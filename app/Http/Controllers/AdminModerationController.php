<?php

namespace App\Http\Controllers;

use App;
use Excel;
use Auth;
use DB;
use App\Category;
use App\City;
use App\Area;
use App\Common;
use App\Http\Controllers\ListingController;
use App\Listing;
use App\ListingAreasOfOperation;
use App\ListingCategory;
use App\ListingCommunication;
use App\Defaults;
use App\Description;
use App\PlanAssociation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Spatie\Activitylog\Models\Activity;
use View;
use Illuminate\Support\Facades\Password;
use Ajency\Ajfileimport\Helpers\AjCsvFileImport;
use App\Http\Controllers\Auth\RegisterController;
use App\PepoImport;
use App\PepoBackup;
use App\UserDetail;
// use Symfony\Component\Console\Output\ConsoleOutput;

class AdminModerationController extends Controller
{
    public function __construct()
    {
        Common::authenticate('dashboard', $this);
    }
    public function listingApproval(Request $request)
    {
        $parent_categ = Category::whereNull('parent_id')->orderBy('order')->orderBy('name')->where('status','1')->where('type','listing')->get();
        $cities       = City::where('status', '1')->get();
        $aj_file_import = new AjCsvFileImport();
        $form_view = $aj_file_import->fileuploadform();
        $start_id = (isset($request->start_id))?  $request->start_id : 0;
        $end_id = (isset($request->end_id))?  $request->end_id : 0;
        return view('admin-dashboard.listing_approval')->with('parents', $parent_categ)->with('cities', $cities)->with('importForm',$form_view)->with('start_id',$start_id)->with('end_id',$end_id);
    }

    public function displayListingsDum(Request $request)
    {
        // print_r($request->all());
        // dd($request->all());
        $filters = $request->filters;
        switch ($request->order['0']['column']) {
            case '1':
                $sort_by = 'title';
                $order   = $request->order['0']['dir'];
                break;
            case '2':
                $sort_by = 'id';
                $order   = $request->order['0']['dir'];
                break;
            case '5':
                $sort_by = "submission_date";
                $order   = $request->order['0']['dir'];
                break;
            case '6':
                $sort_by = "updated_at";
                $order   = $request->order['0']['dir'];
                break;
            default:
                $sort_by = "";
                $order   = "";

        }
        // $filters  = array();
        $response = $this->displayListings($request->length, $request->start, $sort_by, $order, $filters,$request->search['value']);

        $status = ['3' => 'Draft', '2' => 'Pending Review', '1' => 'Published', '4' => 'Archived', '5' => 'Rejected'];

        foreach ($response['data'] as &$listing) {
            $listing['status_ref'] = $listing['status'];
            $listing['status']     = $status[$listing['status']] . '<a href="#updateStatusModal" data-target="#updateStatusModal" data-toggle="modal"><i class="fa fa-pencil p-l-10"></i></a>';
            $listing['name']       = '<a target="_blank" href="/listing/' . $listing['reference'] . '/edit?show_duplicates=true">' . $listing['name'] . '</a>';
            $listing['#']          = "";
            switch ($listing['source']){
                case 'internal_user' :
                    $listing['source'] = 'Added by internal user';
                    break;
                case 'external_user' :
                    $listing['source'] = 'Added by external user';
                    break;
                case 'import' :
                    $listing['source'] = 'Added by import';
                    break;
            }
            if($listing['owner'] != null){
                $listing['owner-status'] = $listing['owner']->name.' ('.ucfirst($listing['owner']->status).')';
            }else{
                $listing['owner-status'] = 'N/A';
            }
            unset($listing['owner']);
            unset($listing['listing_obj']);
            $nodes = "";
            $i    = 0;
            foreach ($listing['categories'] as $key => $value) {
                $temp = $value['parent'] . ' >> ' . $value['branch'] . ' >> ';
                foreach ($value['nodes'] as $node) {
                    if ($i != 0) {
                        $nodes .= ', ';
                    }

                    $nodes .= '<span title="'.$temp.$node['name'].'">'.$node['name'].'</span>';
                    $i++;
                }
            }
            $listing['categories'] = $nodes;
            // $i    = 0;
            // $temp = '';
            // foreach ($listing['categories'] as $key => $value) {
            //     if ($i != 0) {
            //         $temp .= "<hr>";
            //     } else {
            //         $temp .= "";
            //     }

            //     $temp .= $value['parent'] . ' > ' . $value['branch'] . ' > ';
            //     $j = 0;
            //     foreach ($value['nodes'] as $node) {
            //         if ($j != 0) {
            //             $temp .= ', ';
            //         }

            //         $temp .= $node['name'];
            //         $j++;
            //     }
            //     $i++;
            // }
            // $listing['categories'] = $temp;
        }

        return response()->json($response);
    }

    public function manageListingData(Request $request){
       $filters = $request->filters;
        switch ($request->order['0']['column']) {
            case '0':
                $sort_by = 'created_at';
                $order   = 'desc';
                break;
            case '2':
                $sort_by = 'title';
                $order   = $request->order['0']['dir'];
                break;
            case '4':
                $sort_by = 'submission_date';
                $order   = $request->order['0']['dir'];
                break;
            case '5':
                $sort_by = "published_on";
                $order   = $request->order['0']['dir'];
                break;
            case '8':
                $sort_by = "views_count";
                $order   = $request->order['0']['dir'];
                break;
            default:
                $sort_by = "";
                $order   = "";

        }
        // $filters  = array();
        $response = $this->displayListings($request->length, $request->start, $sort_by, $order, $filters,$request->search['value']);

        $status = ['3' => 'Draft', '2' => 'Pending Review', '1' => 'Published', '4' => 'Archived', '5' => 'Rejected'];

        foreach ($response['data'] as &$listing) {
            $listing['status']     = $status[$listing['status']];
            $listing['name']       = '<a target="_blank" href="/listing/' . $listing['reference'] . '/edit">' . $listing['name'] . '</a>';
            $listing['views'] = $listing['listing_obj']->views_count;
            $listing['paid'] = ($listing['listing_obj']->premium)? "Yes":"No";
            $lc=new ListingController;
            if(!isset($filters['stats_date']) or !isset($filters['stats_date']['start']) or !isset($filters['stats_date']['end'])){
                $stats = $lc->getListingStats($listing['listing_obj']);
            }else{
                $end = new Carbon($filters['stats_date']['end']);
                $stats = $lc->getListingStats($listing['listing_obj'],$filters['stats_date']['start'], $end->endOfDay()->toDateTimeString());
            }
            $listing['approval'] = ($listing['listing_obj']->published_on != null)? $listing['listing_obj']->published_on->toDateTimeString():'';
            $listing['contact-count'] = $stats['contact'];
            $listing['direct-count'] = $stats['direct'];
            $listing['shared-count'] = $stats['shared'];
            unset($listing['duplicates']);
            unset($listing['last_updated_by']);
            unset($listing['premium']);
            unset($listing['source']);
            unset($listing['type']);
            unset($listing['updated_on']);
            unset($listing['owner']);
            unset($listing['listing_obj']);
            // $i    = 0;
            // $temp = '';
            // foreach ($listing['categories'] as $key => $value) {
            //     if ($i != 0) {
            //         $temp .= "<hr>";
            //     } else {
            //         $temp .= "";
            //     }

            //     $temp .= $value['parent'] . ' > ' . $value['branch'] . ' > ';
            //     $j = 0;
            //     foreach ($value['nodes'] as $node) {
            //         if ($j != 0) {
            //             $temp .= ', ';
            //         }

            //         $temp .= $node['name'];
            //         $j++;
            //     }
            //     $i++;
            // }
            // $listing['categories'] = $temp;
            $nodes = "";
            $i    = 0;
            foreach ($listing['categories'] as $key => $value) {
                $temp = $value['parent'] . ' >> ' . $value['branch'] . ' >> ';
                foreach ($value['nodes'] as $node) {
                    if ($i != 0) {
                        $nodes .= ', ';
                    }

                    $nodes .= '<span title="'.$temp.$node['name'].'">'.$node['name'].'</span>';
                    $i++;
                }
            }
            $listing['categories'] = $nodes;
        }

        return response()->json($response);
        

    }

    private function IDFilter($filters){
        $result = (isset($filters['id_filter']) and isset($filters['id_filter']['start']) and isset($filters['id_filter']['end']) and ($filters['id_filter']['start'] != 0 or $filters['id_filter']['start'] != '0') and ($filters['id_filter']['end'] != 0 or $filters['id_filter']['end'] != '0'));
        return $result;
    }

    public function displayListings($display_limit, $start, $sort, $order, $filters,$search='')
    {
        $listings = Listing::where(function ($sql) use ($filters) {
            $i = 0;
            // dd($filters);
            if (isset($filters['status'])) {
                foreach ($filters['status'] as $status) {
                    if ($i == 0) {
                        $sql->where('status', $status);
                    } else { $sql->orWhere('status', $status);}
                    $i++;
                }
            }
        });
        if($this->IDFilter($filters)){
            
            $idstart = $filters['id_filter']['start'];
            $idend = $filters['id_filter']['end'];
            $listings->where('id','>=',$idstart)->where('id','<=',$idend);
        }
        if(isset($filters['submission_date'])){
            $end = new Carbon($filters['submission_date']['end']);
            if ($filters['submission_date']['start'] != "") {
                $listings->where('submission_date', '>', $filters['submission_date']['start'])->where('submission_date', '<', $end->endOfDay()->toDateTimeString());
            }
        }
        if(isset($filters['approval_date'])){
            $end = new Carbon($filters['approval_date']['end']);
            if ($filters['approval_date']['start'] != "") {
                $listings->where('published_on', '>', $filters['approval_date']['start'])->where('published_on', '<', $end->endOfDay()->toDateTimeString());
            }
        }
        if($search!="") $listings = $listings->where('title','like','%'.$search.'%');
        if (isset($filters['city'])) {
            $areas = Area::whereIn('city_id', $filters['city'])->pluck('id')->toArray();
            $listings = $listings->whereIn('locality_id',$areas);
        }
        if(isset($filters["updated_by"]) and count($filters["updated_by"]['user_type']) ==1){
            $users  = User::whereIn('type',$filters["updated_by"]['user_type'])->pluck('id')->toArray();
            $listings = $listings->whereIn('last_updated_by',$users);
        }
        if(isset($filters["premium"])){
            $request_senders = array_unique(PlanAssociation::where('premium_type','App\\Listing')->pluck('premium_id')->toArray());
           $prem = [];
           if(count($filters["premium"]) == 1){
            if($filters["premium"][0] == 1) $listings->whereIn('id',$request_senders);
            if($filters["premium"][0] == 0) $listings->whereNotIn('id',$request_senders);
           }
        }
        if(isset($filters["paid"]) and count($filters["paid"]) == 1){
            if($filters["paid"][0] == 1) $listings->where('premium',1);
            if($filters["paid"][0] == 0) $listings->where('premium',0);  
        }
        if(isset($filters['source'])){
            $listings = $listings->whereIn('source', $filters['source']);
        }
        if(isset($filters['user-status'])){
            $users = User::whereIn('status',$filters['user-status'])->pluck('id')->toArray();
            $listings = $listings->whereIn('owner_id',$users);
        }
        if(isset($filters['type'])){
            $listings = $listings->where(function ($listings) use ($filters){
                foreach($filters['type'] as $type ){
                    $listings->whereNull('id');
                    if($type == 'orphan') $listings->orWhereNull('verified')->orWhere('verified',0);
                    if($type == 'verified') $listings->orWhere('verified',1);
                }
            });
        }
        if (isset($filters['category_nodes'])) {
            $category = ListingCategory::whereIn('category_id',$filters['category_nodes'])->select('listing_id')->distinct()->pluck('listing_id')->toArray();
            $listings = $listings->whereIn('id',$category);
        }
        if(isset($filters['categories'])){
            $filter_nodes = [];
            $filters['categories'] = json_decode($filters['categories']);
            if(count($filters['categories'])!=0){
                foreach($filters['categories'] as $category_id){
                    $category = Category::find($category_id);
                    if($category->level == 3){
                        $filter_nodes[] = $category->id;
                    }else{
                        $nodes = Category::where('path','like',$category->path.str_pad($category->id, 5, '0', STR_PAD_LEFT)."%")->where('level',3)->pluck('id')->toArray();
                        $filter_nodes = array_merge($filter_nodes,$nodes);
                    }
                }
                $filter_listings = array_unique(ListingCategory::whereIn('category_id',$filter_nodes)->pluck('listing_id')->toArray());
                $listings = $listings->whereIn('id',$filter_listings);

            }
        }
        $filtered = $listings->count();
        $listings = $listings->skip($start)->take($display_limit);
        $listings = ($sort == "") ? $listings : $listings->orderBy($sort, $order);
        // $output   = new ConsoleOutput;
        // $output->writeln($listings->toSql());
        // $output->writeln($filters['submission_date']['start']);
        // $output->writeln($filters['submission_date']['end']);

        // print_r($listings->toSql());
        // print_r($listings->getBindings());
        // die();

        $listings = $listings->get();
        // $filtered = count($listings);
        // $output->writeln(json_encode($listings));
        $response = array();

        foreach ($listings as $listing) {
            // $output->writeln($listing->submission);
            // dd($listing);
            if($listing->owner and $listing->owner->status == 'active' and $listing->verified == 0){
                $listing->verified = 1;
                $listing->save();
            }
            $sub                                       = ($listing->submission_date != null) ? $listing->submission_date->toDateTimeString() : '';
            $response[$listing->id]                    = array(
                'id' => $listing->id, 
                'name' => $listing->title, 
                'submission_date' => $sub, 
                'updated_on' => ($listing->updated_at != null)? $listing->updated_at->toDateTimeString():""
            );
            $response[$listing->id]['status']          = $listing->status;
            $response[$listing->id]['reference']       = $listing->reference;
            $response[$listing->id]['last_updated_by'] = $listing->lastUpdatedBy['type'];
            // if (isset($filters['city']) and !in_array($listing->location['city_id'], $filters['city'])) {
            //     unset($response[$listing->id]);
            //     $filtered--;
            //     continue;
            // }
            $city = City::find($listing->location['city_id']);
            //write the logic to filter the city and remove them from response. count the number of removed entries and subtract them from
            $response[$listing->id]['city'] = $city['name'];
            // $output->writeln(json_encode($listing->lastUpdatedBy));
            // if (isset($filters['category_nodes'])) {
            //     $categories = ListingCategory::where('listing_id', $listing->id)->get();
            //     $check      = false;
            //     foreach ($categories as $category) {
            //         if (in_array($category->category_id, $filters['category_nodes'])) {
            //             $check = true;
            //         }
            //     }
            //     if (!$check) {
            //         unset($response[$listing->id]);
            //         $filtered--;
            //         continue;
            //     }
            // }
            $dup                                  = $this->getDuplicateCount($listing->id, $listing->title);
            $response[$listing->id]['duplicates'] = $dup['phone'] . ',' . $dup['email'] . ',' . $dup['title'];
            $response[$listing->id]['premium']    = (count($listing->premium()->get())>0)? "Yes":"No";
            $response[$listing->id]['categories'] = ListingCategory::getCategories($listing->id);
            if($listing->verified == 1) $response[$listing->id]['type'] = 'Verified';
            else $response[$listing->id]['type'] = 'Orphan';
            $response[$listing->id]['source'] =  $listing->source;
            $response[$listing->id]['owner'] = $listing->owner()->first();
            $response[$listing->id]['listing_obj'] = $listing;
        }
        $response1 = array();
        foreach ($response as $resp) {
            $response1[] = $resp;
        }
        $all = Listing::count();

        return array('draw' => "1", 'sEcho' => 0, "recordsTotal" => $all, "recordsFiltered" => $filtered, 'data' => $response1);

    }

    private function getDuplicateCount($id, $name)
    {
        // $contacts = ListingCommunication::where('listing_id', $id)->get();
        $request  = new Request;
        // $title    = $name;
        // $req      = array();
        // $req[]    = array('value' => Listing::find($id)->owner->email);
        // foreach ($contacts as $contact) {
        //     $req[] = array('value' => $contact->value);
        // }
        // $contacts = json_encode($req);
        // if ($id=='27') dd($contacts);
        $request->merge(array('id' => $id));
        $lc   = new ListingController;
        $dup  = $lc->findDuplicates($request);
        $data = json_decode(json_encode($dup), true)['original']['matches'];

        return array('title' => count($data['title']), 'email' => count($data['email']), 'phone' => count($data['phones']));
    }

    public function setStatus(Request $request)
    {
        $this->validate($request, [
            'change_request' => 'required|json',
            'sendmail'       => 'nullable|boolean',
        ]);
        $response       = array('status' => "", 'message' => '', 'data' => array('success' => array(), 'error' => array()));
        $change_request = json_decode($request->change_request);
        foreach ($change_request as $change) {
            $listing = Listing::find($change->id);
            $link = '/listing/'.$listing->reference.'/edit';
            if ($listing->status == Listing::DRAFT) {
                if ($change->status == (string) Listing::REVIEW) {
                    if ($listing->isReviewable()) {
                        $listing->status = Listing::REVIEW;
                        $listing->submission_date = Carbon::now();
                        $listing->save();
                        saveListingStatusChange($listing, Listing::DRAFT, Listing::REVIEW );
                        $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.', 'url' => $link);
                    } else {
                        $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing doesn\'t meet Reviewable criteria.', 'url' => $link);
                        $response['status']          = 'Error';
                    }
                } else {
                    $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Draft listing can only be changed to pending review', 'url' => $link);
                    $response['status']          = 'Error';
                }
            } else if ($listing->status == Listing::REVIEW) {
                if ($change->status == (string) Listing::PUBLISHED) {
                    $listing->status = Listing::PUBLISHED;
                    $listing->published_on = Carbon::now();
                    $listing->save();
                    logActivity('listing_publish',$listing,Auth::user());
                    if($listing->owner_id != null){
                        $common = new CommonController;
                        $common->updateUserDetails($listing->owner);
                    }
                    ($listing->owner_id == null)?
                    activity()
                       ->performedOn($listing)
                       ->withProperties(['published-by' => \Auth::user()->id])
                       ->log('listing-publish')
                  	:activity()
                       ->performedOn($listing)
                       ->causedBy(User::find($listing->owner_id))
                       ->withProperties(['published-by' => \Auth::user()->id])
                       ->log('listing-publish');
                    saveListingStatusChange($listing, Listing::REVIEW, Listing::PUBLISHED );
                    $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.', 'url' => $link);
                    if ($request->sendmail == "1") {
                        if($listing->owner_id !=null){
                            $owner = User::find($listing->owner_id);
                            $area = Area::with('city')->find($listing->locality_id);
                            $email = [
                                'to' => $owner->getPrimaryEmail(),
                                'subject' => 'Congratulations! Your business is now live on FnB Circle',
                                'template_data' => [
                                    'owner_name' => $owner->name,
                                    'listing_name' => $listing->title,
                                    'public_link' => url('/'.$area->city['slug'].'/'.$listing->slug),
                                ],
                            ];
                            sendEmail('listing-published',$email);
                            //sendmail('published',$listing);
                        }
                    }
                } else if ($change->status == (string) Listing::REJECTED) {
                    $listing->status = Listing::REJECTED;
                    $listing->save();
                    saveListingStatusChange($listing, Listing::REVIEW, Listing::REJECTED );
                    $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.', 'url' => $link);
                    if($listing->owner_id !=null){
                            $owner = User::find($listing->owner_id);
                            $email = [
                                'to' => $owner->getPrimaryEmail(),
                                'subject' => 'Your business is not approved and hence rejected on FnB Circle',
                                'template_data' => [
                                    'owner_name' => $owner->name,
                                    'listing_name' => $listing->title,
                                    'listing_link' => url('/listing/'.$listing->reference.'/edit'),
                                ],
                            ];
                            sendEmail('listing-rejected',$email);
                            //sendmail('published',$listing);
                        }
                } else {
                    $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Pending review listing can only be changed to published or rejected', 'url' => $link);
                    $response['status']          = 'Error';
                }
            } else if ($listing->status == Listing::PUBLISHED) {
                if ($change->status == (string) Listing::ARCHIVED) {
                    $listing->status = Listing::ARCHIVED;
                    $listing->save();
                    if($listing->owner_id != null){
                        $common = new CommonController;
                        $common->updateUserDetails($listing->owner);
                    }
                    saveListingStatusChange($listing, Listing::PUBLISHED, Listing::ARCHIVED );
                    $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.', 'url' => $link);
                } else {
                    $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Published listing can only be changed to Archived', 'url' => $link);
                    $response['status']          = 'Error';
                }

            } else if ($listing->status == Listing::REJECTED) {
                // if ($change->status == (string) Listing::ARCHIVED) {
                //     $listing->status = Listing::ARCHIVED;
                //     $listing->save();
                //     $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.', 'url' => $link);
                // } else
                if ($change->status == (string) Listing::REVIEW) {
                    if ($listing->isReviewable()) {
                        $listing->status = Listing::REVIEW;
                        $listing->save();
                        saveListingStatusChange($listing, Listing::REJECTED, Listing::REVIEW );
                        $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.', 'url' => $link);
                    } else {
                        $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing doesn\'t meet Reviewable criteria.', 'url' => $link);
                        $response['status']          = 'Error';
                    }
                } else {
                    $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Rejected listing can only be changed to Archived/Pending Review', 'url' => $link);
                    $response['status']          = 'Error';
                }

            } else if ($listing->status == Listing::ARCHIVED) {
                // if ($change->status == (string) Listing::REVIEW) {
                //     if ($listing->isReviewable()) {
                //         $listing->status = Listing::REVIEW;
                //         $listing->save();
                //         saveListingStatusChange($listing, Listing::REJECTED, Listing::REVIEW );
                //         $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.', 'url' => $link);
                //     } else {
                //         $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing doesn\'t meet Reviewable criteria.', 'url' => $link);
                //         $response['status']          = 'Error';
                //     }
                // } else
                if ($change->status == (string) Listing::PUBLISHED) {
                    $listing->status = Listing::PUBLISHED;
                    $listing->save();
                    saveListingStatusChange($listing, Listing::ARCHIVED, Listing::PUBLISHED );
                    $response['data']['success'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Listing status updated successfully.', 'url' => $link);
                } else {
                    $response['data']['error'][] = array('id' => $listing->id, 'name' => $listing->title, 'message' => 'Archieved listing can only be changed to Published/Pending Review', 'url' => $link);
                    $response['status']          = 'Error';
                }
            }

        }

        return response()->json($response);

    }


    public function emailNotification(Request $request){
        $email_notification = Defaults::where('type','email_notification')->get();
        return view('admin-dashboard.email_notifications')->with('rows', $email_notification);
    }

    public function setNotificationDefault(Request $request){
        $this->validate($request,[
            'type' =>'required',
        ]);

        $default = Defaults::where('type','email_notification')->where('label',str_replace('notification-', '', $request->type))->firstOrFail();
        $data = json_decode($default->meta_data,true);
        $data['value'] = (isset($request->value))? explode(',', $request->value):[];
        $default->meta_data = json_encode($data);
        $default->save();
        return response()->json(['status'=>'200', 'message'=>'OK']);
    }

    public function generateFile(){
        $excel = App::make('excel');
        Excel::create('DataSheet', function ($excel){
            $excel->sheet('Categories', function ($sheet) {
                $category_model = \App\Category::where('level', 3)->where('status', 1)->orderBy('order')->orderBy('name')->get();
                $categories     = [];
                foreach ($category_model as $category) {
                    $categories[] = array($category->hirarchy, $category->id);
                }
                $sheet->fromArray($categories, null, 'B3', true, false);
                $sheet->row(2, array(
                    '', 'Node Category', 'Cat Id',
                ));
            });
            $excel->sheet('Brand', function ($sheet) {
                $brandModel = \Conner\Tagging\Model\Tag::where('tag_group_id', 1)->orderBy('name')->get();
                $brands     = [];
                foreach ($brandModel as $brand) {
                    $brands[] = array($brand->name, $brand->slug);
                }
                $sheet->fromArray($brands, null, 'B3', true, false);
                $sheet->row(2, array(
                    '', 'Brand Name', 'Brand Slug',
                ));
            });
            $excel->sheet('Cities', function ($sheet) {
                $citiesModel = \App\Area::where('status', 1)->orderBy('order')->orderBy('name')->get();
                $cities      = [];
                foreach ($citiesModel as $city) {
                    $cities[] = array($city->hirarchy, $city->id);
                }
                $sheet->fromArray($cities, null, 'B3', true, false);
                $sheet->row(2, array(
                    '', 'City Name', 'City ID',
                ));
                $sheet->cell('I3', function ($cell) {$cell->setValue('Yes');});
                $sheet->cell('I4', function ($cell) {$cell->setValue('No');});
                $sheet->cell('J3', function ($cell) {$cell->setValue('1');});
                $sheet->cell('J4', function ($cell) {$cell->setValue('0');});
            });
        })->export('xls');
    }

    public function getFile(){
        return response()->download(storage_path().'/app/public/import-sample-file.xlsx');
    }

    public function uploadToPepo($listings){
        foreach ($listings as $listing_id) {
            $listing = Listing::find($listing_id);
            $email = $listing->owner->getPrimaryEmail();
            $import = new PepoImport;
            $backup =  PepoBackup::where('email',$email)->first();
            try{
                if($backup == null){
                    $backup = new PepoBackup;
                    //$import->email = $email;
                    $backup->email = $email;
                    $backup->state = $listing->owner->getUserDetails->userCity->id;
                    //$import->name = 'imported user';
                    $backup->name = 'imported user';
                    $backup->state = $listing->owner->getUserDetails->userCity->name;
                    // $backup->state = $import->state;
                    // $import->active = "False";
                    $backup->active = "False";
                    // $import->subscribed = "True";
                    $backup->subscribed = "True";
                    // $import->signUpType = 'Import';
                    $backup->signUpType = 'Import';
                    // $import->userType = json_encode(["Listing"]);
                    $backup->userType = json_encode(["Listing"]);
                    $backup->listingStatus =json_encode([]);
                    $backup->listingType =json_encode([]);
                    $backup->listingCategories =json_encode([]);
                    $backup->area = json_encode([]);
                    $backup->save();
                }
                if ($backup != null){
                    $import->email = $email;
                    $import->name = $backup->name;
                    $import->state = $backup->state;
                    $import->active = $backup->active;
                    $import->subscribed = $backup->subscribed;
                    if($backup->signUpType == 'Guest' or $backup->signUpType == null){
                        $import->signUpType = 'Import';
                    }else{
                        $import->signUpType = $backup->signUpType;
                    }
                    $import->userSubType = mergeFields($backup->userSubType,[],true);
                    $import->userType = mergeFields($backup->userType,['Listing'],true);
                    $import->listingStatus = mergeFields($backup->listingStatus,[$listing->reference => 'Draft'],true);
                    $import->listingType = mergeFields($backup->listingType,[Listing::listing_business_type[$listing->type]],true);
                    $import->listingCategories = mergeFields($backup->listingCategories,ListingCategory::getCategoryJsonTag($listing->id),true);
                    $import->area = mergeFields($backup->area,ListingAreasOfOperation::listingAreasJsonTag($listing->id),true);
                    $import->listingPremium = mergeFields($backup->listingPremium,[$listing->reference =>"false"],true);
                    $import->jobPremium = mergeFields($backup->jobPremium,[],true);
                    $import->enquiryArea = mergeFields($backup->enquiryArea,[],true);
                    $import->enquiryCategories = mergeFields($backup->enquiryCategories,[],true);
                    $import->jobStatus = mergeFields($backup->jobStatus,[],true);
                    $import->jobRole = mergeFields($backup->jobRole,[],true);
                    $import->jobCategory = mergeFields($backup->jobCategory,[],true);
                    $import->jobArea = mergeFields($backup->jobArea,[],true);
                    $import->save();

                    $backup->signUpType = $import->signUpType;
                    $backup->userType = $import->userType;
                    $backup->listingStatus = mergeFields($backup->listingStatus,[$listing->reference=>'Draft']);
                    $backup->listingPremium = mergeFields($backup->listingPremium,[$listing->reference=>'false']);
                    $backup->listingType = mergeFields($backup->listingType,[Listing::listing_business_type[$listing->type]]);
                    $backup->listingCategories = mergeFields($backup->listingCategories,ListingCategory::getCategoryJsonTag($listing->id));
                    $backup->area = mergeFields($backup->area,ListingAreasOfOperation::listingAreasJsonTag($listing->id));
                    $backup->response = "Sent via CSV to admin";
                    $backup->save();

                }
            } catch (\Exception $ex) {
                $error_msg = $ex->getMessage();
                \Log::error($error_msg);
                \Log::error(json_encode($backup->toArray()));
            }
        }
    }
    public function importFinalCallback(){
        $filepath = dumpTableintoFile('pepo_imports',[],[],true);
        // return $filepath;
        if($filepath['status']){
            \DB::table('pepo_imports')->truncate();
            $file = \Storage::disk('root')->get($filepath['path']);
             $email = [
                'to' => 'admin@fnbcircle.com',
                'subject' => "Upload contacts to PepoCampaigns",
                'attach' => [['file' => base64_encode($file), 'as'=>'pepo-import.csv', 'mime'=>'text/csv']]
                
            ];
            sendEmail('pepo-import',$email);
        }else{
            \Log::error($filepath['msg']);
        }
        
    }
    public function importCallback(){
        $listing_ids = \App\Listing::whereNull('reference')->pluck('id')->toArray();
        if(!empty($listing_ids)){
            $references = [];
            $sql = 'UPDATE listings SET reference = (CASE ';
            foreach ($listing_ids as $listing) {
                $references[$listing] = str_random(8);
                $sql.= 'WHEN id = '.$listing.' THEN \''.$references[$listing].'\'';
            }
            $sql.= 'END) WHERE id in ('.implode(',', array_keys($references)).')';
            \DB::statement($sql);
        }
        
        $category_ids = \App\ListingCategory::distinct()->whereNull('category_slug')->pluck('category_id')->toArray();
        if(!empty($category_ids)){
            $categories = \App\Category::whereIn('id',$category_ids)->pluck('slug','id')->toArray();
            $sql = 'UPDATE listing_category SET category_slug = (CASE';
            foreach ($categories as $id => $slug) {
                 $sql.= ' WHEN category_id = '.$id.' THEN \''.$slug.'\'';
            }
            $sql.= 'END) WHERE  category_slug IS NULL';
            \DB::statement($sql);
        }
        $brand_ids = \Conner\Tagging\Model\Tagged::distinct()->whereNull('tag_name')->pluck('tag_slug')->toArray();
        if(!empty($brand_ids)){
            $brands = \Conner\Tagging\Model\Tag::where('tag_group_id', 1)->whereIn('slug',$brand_ids)->pluck('name','slug')->toArray();
            $sql = 'UPDATE tagging_tagged SET tag_name = (CASE';
            foreach ($brands as $slug => $name) {
                $sql.= ' WHEN tag_slug = \''.$slug.'\' THEN \''.$name.'\'';
            }
            $sql.= 'END) WHERE  tag_name IS NULL';
            \DB::statement($sql);
        }
        $user_comms = \App\UserCommunication::whereNull('value')->orWhere('value','')->delete();
        $listings = \App\Listing::whereNull('slug')->get();
        foreach ($listings as $listing) {
            $slug  = str_slug($listing->title);
            $count = \App\Listing::where('slug', $slug)->where('id','!=',$listing->id)->count();
            $i     = 1;
            $slug1 = $slug;
            if ($count > 0) {
                do {
                    $slug1 = $slug . '-' . $i;
                    $count = \App\Listing::where('slug', $slug1)->count();
                    $i++;
                } while ($count > 0);
            }
            $listing->slug = $slug1;
            $listing->save();
        }
        $areaCity = Area::where('status',1)->pluck('city_id','id')->toArray();
        $userDetailSql = 'UPDATE user_details SET city = (CASE ';
        foreach ($areaCity as $area => $city) {
            $userDetailSql.= 'WHEN area = '.$area.' THEN \''.$city.'\'';
        }
        $userDetailSql .= ' END) WHERE area IS NOT NULL AND city IS NULL';
        \Log::info('UserDetailQuery: '.$userDetailSql);
        \DB::statement($userDetailSql);
        $this->uploadToPepo($listing_ids);
        $common = new CommonController;
        $common->updateUserDetails();
    }

    public function generateDummyCsv($records = 10){
        Excel::create('Listing_import', function ($excel)use ($records){
            $excel->sheet('Listings', function ($sheet) use ($records){
                $filecontents = array(config('ajimportdata.fileheader'));
                $type = ['Wholesaler/Distributor','Retailer','Manufacturer','Importer','Exporter', 'Service Provider'];
                $cities = \App\Area::where('status', 1)->orderBy('order')->orderBy('name')->select('name','id')->get()->toArray();
                $email_primary = ['intizar_08@yahoo.co.in','manu29809@gmail.com','pankajdhaka.dav@hotmail.com','pranav165@yahoo.com','arya.anit3@gmail.com','meetshrotriya@gmail.com','manugarg1592@yahoo.in','praveen_solanki29@yahoo.com','tanmaysharma07@gmail.com','kartikkumar781@gmail.com','arun.singh2205@gmail.com','rohitneema065@gmail.com','shashikant.1975@rediffmail.com','vikas221965@yahoo.com','dharmendershrm09@gmail.com','publicdial@gmail.com','kumarmrinal27@gmail.com','saikumar6448@gmail.com','saini.sourabh2013@gmail.com','sunyruc718@gmail.com','prasadchinnaa@gmail.com','m_aizaz786@yahoo.com','sundevs@gmail.com','rish.parashar@hotmail.com','kumar4612@gmail.com','vijaysingh361@gmail.com','ankitsingh33@gmail.com','kuldeepetah@yahoo.com','bansi.pathak@gmail.com','aktiwari.94@hotmail.co.uk','kataria1100@yahoo.com','jogendra5336@gmail.com','aniketparoha1@gmail.com','pranavbembi09@gmail.com','chandank973@gmail.com','ki04298@gmail.com','smartyvinod.143@gmail.com','way4dilip@gmail.com','deepakaspact@yahoo.co.in','akhil002.m@gmail.com','sanjeevheikham@gmail.com','princejnv@gmail.com','rahul_singh1990@rediff.com','suneeshjacob@gmail.com','praveenhuded3@gmail.com','vishnaram@gmail.com','omveer2012@yahoo.in','bhupalmehra17@gmail.com','satyam2708@gmail.com','shrihari333@gmail.com','nishug0786@gmail.com','ravikr.singh89@gmail.com','lucky_singh99989@rediffmail.com','jijil.tk@gmail.com','ramnathreddy.pathi@gmail.com','masoodvali.k@gmail.com','himansu1234himanshu@gmail.com','rshthakur80@gmail.com','vt1469@gmail.com','gautamkumarsingh.1993@gmail.com','vipinrajput919@gmail.com','manish.khusrupur@gmail.com','rahulmishra5790@gmail.com','munnakumar_1991@rediffmail.com','kundankumargupta1@gmail.com','diptiranjan076@gmail.com','anujchoubey4@gmail.com','avbaragi@gmail.com','ramakantsingh29@gmail.com','manmohan_1989.23@rediffmail.com','shradanan_thulay@yahoo.co.in','pushpendrasngh09@gmail.com','prasad.reddy008@gmail.com','vijuthakur02@gmail.com','jsrcyberpoint@gmail.com','dineshsundlia@gmail.com','rajeshkumaar786@gmail.com','ut_raghav@yahoo.co.in','sumit_kumar1173@yahoo.com','bskrishna17@gmail.com','vineetkumar039@gmail.com','kumar1niket@gmail.com','pandeyraviraj715@gmail.com','shivvirnh27@gmail.com','vinay9634344545@gmail.com','n.shiva245@gmail.com','laksh_stude@rediffmail.com','bhalaje89@gmail.com','chkadityabaghel@gmail.com','remosroy2011@live.com','amanit3004@gmail.com','shagun13489@gmail.com','sumallya4all@gmail.com','jalajpathak11@yahoo.in','singh16ashok@yahoo.com','jhashashank02@gmail.com','rakesh.pal.indu@gmail.com','mayankgoel9999@gmail.com','singhvishal104@gmail.com','ashishverma261190@gmail.com'];
                $emails = array_merge($email_primary,array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',));
                $cores = \App\Category::where('level', 3)->where('status', 1)->orderBy('order')->orderBy('name')->select('name','id')->get()->toArray();
                $categories = array_merge($cores,array(["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""]));
                $brands = \Conner\Tagging\Model\Tag::where('tag_group_id', 1)->orderBy('name')->select('name','slug')->get()->toArray();
                $brands = array_merge($brands,array(["name" => "", "slug" => ""],["name" => "", "slug" => ""],["name" => "", "slug" => ""],["name" => "", "slug" => ""],["name" => "", "slug" => ""],["name" => "", "slug" => ""],["name" => "", "slug" => ""],["name" => "", "slug" => ""],["name" => "", "slug" => ""],["name" => "", "slug" => ""],["name" => "", "slug" => ""],["name" => "", "slug" => ""],["name" => "", "slug" => ""],["name" => "", "slug" => ""],["name" => "", "slug" => ""]));
                $areas = array_merge($cities,array(["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""],["name" => "", "id" => ""]));
                for($i=0;$i<$records;$i++){
                    $listing = [];

                    for($j=0;$j< count($filecontents[0]);$j++){
                        switch ($filecontents[0][$j]) {
                            case 'BusinessName':
                                $listing[] = str_random();
                                break;
                            case 'BusinessType':
                                $listing[] = array_random($type);
                                break;
                            case 'City':
                                $city = array_random($cities);
                                $listing[] = $city['name'];
                                $listing[] = $city['id'];
                                $j++;
                                break;
                            case 'Email1':
                                $listing[] = array_random($email_primary);
                                break;
                            case 'Email2':
                                $listing[] = array_random($emails);
                                break;
                            case 'Mobile1':
                                $listing[] = rand(7000000000,9999999999);
                                break;
                            case 'Mobile2':
                            case 'Landline1':
                            case 'Landline2':
                                $listing[] = (rand(0,1))? rand(7000000000,9999999999):"";
                                break;
                            case 'CoreCategory1':
                                $core = array_random($cores);
                                $listing[] = $core['name'];
                                $listing[] = $core['id'];
                                $j++;
                                break; 
                            case 'CoreCategory2':
                            case 'CoreCategory3':
                            case 'CoreCategory4':
                            case 'CoreCategory5':
                            case 'CoreCategory6':
                            case 'CoreCategory7':
                            case 'CoreCategory8':
                            case 'CoreCategory9':
                            case 'CoreCategory10':
                                $core = array_random($categories);
                                $listing[] = $core['name'];
                                $listing[] = $core['id'];
                                $j++;
                                break;
                            case 'Brand1':
                            case 'Brand2':
                            case 'Brand3':
                            case 'Brand4':
                            case 'Brand5':
                            case 'Brand6':
                            case 'Brand7':
                            case 'Brand8':
                            case 'Brand9':
                            case 'Brand10':
                                $brand = array_random($brands);
                                $listing[] = $brand['name'];
                                $listing[] = $brand['slug'];
                                $j++;
                                break;
                            case 'DisplayAddress':
                                $listing[] = (rand(0,1))? str_random():"";
                                break;
                            case 'AreaOfOperation1':
                            case 'AreaOfOperation2':
                            case 'AreaOfOperation3':
                            case 'AreaOfOperation4':
                            case 'AreaOfOperation5':
                            case 'AreaOfOperation6':
                            case 'AreaOfOperation7':
                            case 'AreaOfOperation8':
                            case 'AreaOfOperation9':
                            case 'AreaOfOperation10':
                                $area = array_random($areas);
                                $listing[] = $area['name'];
                                $listing[] = $area['id'];
                                $j++;
                                break;
                            case 'BusinessDescription':
                            case 'BusinessHighlight1':
                            case 'BusinessHighlight2':
                            case 'BusinessHighlight3':
                            case 'BusinessHighlight4':
                                $listing[] = (rand(0,1))? str_random():"";
                                break;
                            case 'YearOfEstablishment':
                                $listing[] = (rand(0,1))? rand(1950,2017):"";
                                break;
                            case 'BusinessWebsite':
                                $listing[] = (rand(0,1))? 'http://'.str_random().'.com':"";
                                break;
                            case 'OnlineBanking':
                            case 'OnCredit':
                            case 'CreditDebitCards':
                            case 'CashOnDelivery':
                            case 'eMobileWallets':
                            case 'USSD_AEPS_UPI':
                            case 'Cheque':
                            case 'Draft':
                                if(rand(0,1)){
                                    $listing[] = "Yes"; $listing[] = 1;
                                }else{
                                    $listing[] = "No"; $listing[] = 0;
                                }
                                $j++;
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                    $filecontents[]=$listing;
                }
                $sheet->fromArray($filecontents, null, 'A1', true, false);
            });
        })->export('csv');
    }

    public function internalEmails(Request $request){
        $internal = Defaults::where('type','internal_email')->get();
        return view('admin-dashboard.internal_emails')->with('types',$internal);
    }

    public function getInternalMailFilters(Request $request){
        $this->validate($request,[
            'type'=>'required'
        ]);
        $email_type = Defaults::where('type','internal_email')->where('label',$request->type)->first();
        if($email_type == null) abort(404);
        $email_data = json_decode($email_type->meta_data,true);
        $html = '<input type="hidden" name="mail-type" value="'.$email_type->label.'"';
        foreach ($email_data['user_filters'] as $filter) {
            switch($filter){
                case 'location_filter':
                    $cities = City::where('status', '1')->get();
                    $html.= View::make('modals.location_select.display');
                    $html.= View::make('modals.location_select.popup')->with('cities',$cities);
                    break;
                case 'category_filter':
                    $html.='<div class="m-t-10 m-b-10"><label>Category Filter</label>
                       <a href="#category-select" data-toggle="modal" data-target="#category-select" class="btn btn-link btn-sm heavier" id="select-more-categories">Filter based on Categories</a></div>
                      <input type="hidden" id="modal_categories_chosen" name="modal_categories_chosen" value="[]">
                      <input type="hidden" id="modal_categories_hierarchy_chosen" value="[]">
                      <input type="hidden" id="is_parent_category_checkbox" value="1">
                      <input type="hidden" id="is_branch_category_checkbox" value="1">
                      <div id="categories" class="node-list"></div>';
                    // $html.= View::make('modals.categories_list');
                    break;
                case 'listing_source':
                    $html.='<div class="m-t-10 m-b-10 flex-row listing-source">
                            <label class="m-b-0 m-r-10">Listing Source Filter</label>
                            <select name="listing_source" class="form-control" multiple>
                                <option value="">Select</option>
                                <option value="import">Import</option>
                                <option value="internal_user">Internal User</option>
                                <option value="external_user">External User</option>
                            </select></div>';
                    break;
                case 'description_filter':
                    $description = \App\Description::where('active',1)->get();
                    $html.='<div class="m-t-10 m-b-10 flex-row">
                            <label class="bolder m-b-0 m-r-10 desc-filter">Description Filter</label>
                            <select name="description" multiple>';
                    foreach ($description as $des) {
                        $html.='<option value="'.$des->id.'">'.$des->title.'</option>';
                    }
                    $html.='</select>
                            </div>';
                    break;
                case 'user_created_filter':
                    $html .= '<div class="flex-row"><label class="m-b-0 m-r-20">User Created Date</label> <a href="#" class="clear-user-date m-r-10">Clear</a> 
                    <div class="form-group" style="width:220px;margin-bottom: 5px;">
                      <input type="text" id="submissionDate" name="" class="form-control fnb-input" style="padding-bottom: 0;font-size: 1em;">
                    </div></div>';
                    break;
            }
        }
        $html .= '<br><button class="btn primary-btn border-btn fnb-btn m-r-15" type="button" id="mail-check">Send Mail</button>';
        switch($request->type){
            case 'draft-listing-active':
                $owner_name = "OWNER NAME";
                $listings = [[
                    'listing_reference' => "dummy-ref",
                    'listing_name' => "Dummy Name 1",
                    'listing_type' => "Dummy type",
                    'listing_state' => "Dummy State",
                    'listing_city' => "Dummy City"
                ],[
                   'listing_reference' => "dummy-ref",
                    'listing_name' => "Dummy Name 2",
                    'listing_type' => "Dummy type",
                    'listing_state' => "Dummy State 2",
                    'listing_city' => "Dummy City 2" 
                ]];
                $template = View::make('email.listing-user-notify1')->with(compact('owner_name','listings'));
                $html.= '<button class="btn fnb-btn outline" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Show Email Template</button><div class="collapse m-t-15" id="collapseExample">'.$template.'</div>';
                break;
            case 'draft-listing-inactive':
                $confirmationLink = url('/dummy-confirmation-link');
                $listings = [[
                    'listing_reference' => "dummy-ref",
                    'listing_name' => "Dummy Name 1",
                    'listing_type' => "Dummy type",
                    'listing_state' => "Dummy State",
                    'listing_city' => "Dummy City"
                ],[
                   'listing_reference' => "dummy-ref",
                    'listing_name' => "Dummy Name 2",
                    'listing_type' => "Dummy type",
                    'listing_state' => "Dummy State 2",
                    'listing_city' => "Dummy City 2" 
                ]];
                $template = View::make('email.listing-user-verify1')->with(compact('confirmationLink','listings'));
                $html.= '<button class="btn fnb-btn outline" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Show Email Template</button><div class="collapse m-t-15" id="collapseExample">'.$template.'</div>';
                break;
            case 'user-activate':
                $name = "User Name"; 
                $confirmationLink = url('/dummy-confirmation-link');
                $contactEmail =  config('constants.email_from');
                $template = View::make('email.user-verify')->with(compact('confirmationLink','name','contactEmail'));
                $html.= '<button class="btn fnb-btn outline" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Show Email Template</button><div class="collapse m-t-15" id="collapseExample">'.$template.'</div>';
                break;
        }
        print_r($html);
        die(); 
    }

    public function getMailGroups($request){
         $this->validate($request,[
            'type'=>'required'
        ]);
        $type = $request->type;
        switch ($type) {
            case 'draft-listing-active':
                //select active_users.id as userID,draft_listings.id as listingID from (select * from listings where status = 3 and locality_id in ("23", "24", "15", "16")) as draft_listings join (select * from users where status = 'active') as active_users on draft_listings.owner_id = active_users.id;
                $areas =[]; 
                if(!empty($request->cities) and $request->cities!=[""]){
                    $locations = Area::whereIn('city_id',$request->cities)->pluck('id')->toArray();
                    $areas = array_merge($areas,$locations);
                }
                if(!empty($request->areas) and $request->areas!=[""]){
                    $areas = array_unique(array_merge($areas,$request->areas));
                }
                $filter_categories =[];
                if(!empty($request->categories) and $request->categories!=[""]){
                    $filter_nodes = [];
                    $categories = json_decode($request->categories);
                    if(count($categories)!=0){
                        foreach($categories as $category_id){
                            $category = Category::find($category_id);
                            if($category->level == 3){
                                $filter_nodes[] = $category->id;
                            }else{
                                $nodes = Category::where('path','like',$category->path.str_pad($category->id, 5, '0', STR_PAD_LEFT)."%")->where('level',3)->pluck('id')->toArray();
                                $filter_nodes = array_merge($filter_nodes,$nodes);
                            }
                        }
                        $filter_categories = array_unique(ListingCategory::whereIn('category_id',$filter_nodes)->pluck('listing_id')->toArray());
                    }
                }

                $sql="select active_users.id as userID,draft_listings.id as listingID from (select * from listings where status = 3";
                if(!empty($areas)) $sql.= " and locality_id in ('".implode("','",$areas)."')";
                if(!empty($filter_categories)) $sql.= " and id in ('".implode("','",$filter_categories)."')";
                if(!empty($request->source) and $request->source != [""]) $sql.= " and source in ('".implode("','",$request->source)."')";
                $sql.=") as draft_listings join (select * from users where status = 'active') as active_users on draft_listings.owner_id = active_users.id;";
                return collect(\DB::Select($sql))->groupBy('userID');
                break;
            case 'draft-listing-inactive':
                $areas =[]; 
                if(!empty($request->cities) and $request->cities!=[""]){
                    $locations = Area::whereIn('city_id',$request->cities)->pluck('id')->toArray();
                    $areas = array_merge($areas,$locations);
                }
                if(!empty($request->areas) and $request->areas!=[""]){
                    $areas = array_unique(array_merge($areas,$request->areas));
                }
                $filter_categories =[];
                if(!empty($request->categories) and $request->categories!=[""]){
                    $filter_nodes = [];
                    $categories = json_decode($request->categories);
                    if(count($categories)!=0){
                        foreach($categories as $category_id){
                            $category = Category::find($category_id);
                            if($category->level == 3){
                                $filter_nodes[] = $category->id;
                            }else{
                                $nodes = Category::where('path','like',$category->path.str_pad($category->id, 5, '0', STR_PAD_LEFT)."%")->where('level',3)->pluck('id')->toArray();
                                $filter_nodes = array_merge($filter_nodes,$nodes);
                            }
                        }
                        $filter_categories = array_unique(ListingCategory::whereIn('category_id',$filter_nodes)->pluck('listing_id')->toArray());
                    }
                }
                $sql="select active_users.id as userID,draft_listings.id as listingID from (select * from listings where status = 3";
                if(!empty($areas)) $sql.= " and locality_id in ('".implode("','",$areas)."')";
                if(!empty($filter_categories)) $sql.= " and id in ('".implode("','",$filter_categories)."')";
                if(!empty($request->source) and $request->source != [""]) $sql.= " and source in ('".implode("','",$request->source)."')";
                $sql.=") as draft_listings join (select * from users where status = 'inactive') as active_users on draft_listings.owner_id = active_users.id;";
                return collect(\DB::Select($sql))->groupBy('userID');
                break;

            case 'user-activate':
                $users = User::where('status','inactive');
                if(!empty($request->description) and $request->description != [""]){
                    $description_users = \App\UserDescription::whereIn('description_id',$request->description)->select('user_id')->distinct()->pluck('user_id')->toArray();
                    $users=$users->whereIn('id',$description_users);
                }
                if(!empty($request->cities) or !empty($request->areas)){
                    $areas = ($request->has('areas'))? UserDetail::whereIn('area',$request->areas)->pluck('user_id')->toArray() : [];
                    $cities = ($request->has('cities'))? UserDetail::whereIn('city',$request->cities)->pluck('user_id')->toArray() : [];
                    $location_filter = array_unique(array_merge($cities,$areas));
                    $users = $users->whereIn('id',$location_filter);
                }
                if(isset($request->start) and $request->start != ""){
                    $users->where('created_at','>',\Carbon\Carbon::createFromFormat('Y-m-d',$request->start)->startOfDay());
                }
                if(isset($request->end) and $request->end != ""){
                    $users->where('created_at','<',\Carbon\Carbon::createFromFormat('Y-m-d',$request->end)->endOfDay());
                }
                return $users;
            default:
                abort(404);
        }
    }

    public function getMailCount(Request $request){
        $this->validate($request,[
            'type'=>'required'
        ]);
        if($request->type == 'draft-listing-active'or $request->type == 'draft-listing-inactive'){
            $users = $this->getMailGroups($request);
            if(in_develop()){
                return response()->json(['email_count'=>count($users),'users'=>$users]);
            }
            return response()->json(['email_count'=>count($users)]);
            //die();
        }
        if($request->type == 'user-activate'){
            $users = $this->getMailGroups($request);

            
            if(in_develop()){
                return response()->json(['email_count'=>$users->count(),'users'=>$users->get()]);
            }
            return response()->json(['email_count'=>$users->count()]);
        }
    }

    public function sendSelectedUsersMail(Request $request){
        $this->validate($request,[
            'type'=>'required'
        ]);
        $errors = [];
        switch($request->type){
            case 'draft-listing-active':
                $users = $this->getMailGroups($request);
                foreach ($users as $uid => $listings) {
                    $user = User::find($uid);
                    $listing_details = [];
                    foreach ($listings as  $user_listing) {
                        $listing = Listing::find($user_listing->listingID);
                        $area = Area::with('city')->find($listing->locality_id);
                        $detail = [
                            'listing_name' => $listing->title,
                            'listing_type' => Listing::listing_business_type[$listing->type],
                            'listing_state' => $area->city['name'],
                            'listing_city' => $area->name,
                            'listing_reference' => $listing->reference,
                        ];
                        $listing_details[] = $detail;
                    }
                    $email = [
                        'to' => $user->getPrimaryEmail(),
                        'subject' => "Your Listing(s) are in draft",
                        'template_data' => [
                            'owner_name' => $user->name,
                            'listings'=> $listing_details,
                            
                        ],
                    ];
                    sendEmail('listing-user-notify',$email);
                }
                break;
            case 'draft-listing-inactive':
                $users = $this->getMailGroups($request);
                
                foreach ($users as $uid => $listings) {
                    try{
                        $user = User::find($uid);
                        $listing_details = [];
                        $user1 = Password::broker()->getUser(['email'=>$user->getPrimaryEmail()]);
                        $token =Password::broker()->createToken($user1);
                        $reset_password_url = url(config('app.url').route('password.reset', $token, false)) . "?email=" . $user->getPrimaryEmail().'&new_user=true';
                        foreach ($listings as  $user_listing) {
                            $listing = Listing::find($user_listing->listingID);
                            $area = Area::with('city')->find($listing->locality_id);
                            $detail = [
                                'listing_name' => $listing->title,
                                'listing_type' => Listing::listing_business_type[$listing->type],
                                'listing_state' => $area->city['name'],
                                'listing_city' => $area->name,
                                'listing_reference' => $listing->reference,
                            ];
                            $listing_details[] = $detail;
                        }
                        $email = [
                            'to' => $user->getPrimaryEmail(),
                            'subject' => "Reminder - Your Listing(s) are in draft",
                            'template_data' => [
                                'confirmationLink' => $reset_password_url,
                                'listings'=> $listing_details,
                                
                            ],
                        ];
                        sendEmail('listing-user-verify',$email);
                        // break;
                    }catch (\Exception $e){
                        $errors[] = $user;
                    }
                }
                break;
            case 'user-activate':
                $users = $this->getMailGroups($request)->get();
                $RC = new RegisterController;

                foreach ($users as $user) {
                    $RC->confirmEmail('register',["id"=>$user->id,'email'=>$user->getPrimaryEmail(),'name'=>$user->name]);
                }
                break;
            default:
                abort(404);
                break;
            
        }
        return response()->json(['errors'=>$errors, 'email_count'=>$users->count()],200);
    }

    public function manageListings(Request $request){
        $parent_categ = Category::whereNull('parent_id')->orderBy('order')->orderBy('name')->where('status','1')->where('type','listing')->get();
        $cities       = City::where('status', '1')->get();
        $start_id = (isset($request->start_id))?  $request->start_id : 0;
        $end_id = (isset($request->end_id))?  $request->end_id : 0;
        return view('admin-dashboard.manage_listings')->with('parents', $parent_categ)->with('cities', $cities)->with('start_id',$start_id)->with('end_id',$end_id);
    }

    public function exportManageListings(Request $request){
        $filters = json_decode($request->filters,true);
        switch ($request->order['0']['0']) {
            case '0':
                $sort_by = 'created_at';
                $order   = 'desc';
                break;
            case '2':
                $sort_by = 'title';
                $order   = $request->order['0']['1'];
                break;
            case '4':
                $sort_by = 'submission_date';
                $order   = $request->order['0']['1'];
                break;
            case '5':
                $sort_by = "published_on";
                $order   = $request->order['0']['1'];
                break;
            case '8':
                $sort_by = "views_count";
                $order   = $request->order['0']['1'];
                break;
            default:
                $sort_by = "";
                $order   = "";
        }        
        $sort = $sort_by;
        $search=$request->search['value'];
        $listings = Listing::where(function ($sql) use ($filters) {
            $i = 0;
            if (isset($filters['status'])) {
                foreach ($filters['status'] as $status) {
                    if ($i == 0) {
                        $sql->where('status', $status);
                    } else { $sql->orWhere('status', $status);}
                    $i++;
                }
            }
        });
        if(isset($filters['submission_date'])){
            $end = new Carbon($filters['submission_date']['end']);
            if ($filters['submission_date']['start'] != "") {
                $listings->where('submission_date', '>', $filters['submission_date']['start'])->where('submission_date', '<', $end->endOfDay()->toDateTimeString());
            }
        }
        if(isset($filters['approval_date'])){
            $end = new Carbon($filters['approval_date']['end']);
            if ($filters['approval_date']['start'] != "") {
                $listings->where('published_on', '>', $filters['approval_date']['start'])->where('published_on', '<', $end->endOfDay()->toDateTimeString());
            }
        }
        if($search!="") $listings = $listings->where('title','like','%'.$search.'%');
        if (isset($filters['city'])) {
            $areas = Area::whereIn('city_id', $filters['city'])->pluck('id')->toArray();
            $listings = $listings->whereIn('locality_id',$areas);
        }
        if(isset($filters["updated_by"]) and count($filters["updated_by"]['user_type']) ==1){
            $users  = User::whereIn('type',$filters["updated_by"]['user_type'])->pluck('id')->toArray();
            $listings = $listings->whereIn('last_updated_by',$users);
        }
        if(isset($filters["premium"])){
            $request_senders = array_unique(PlanAssociation::where('premium_type','App\\Listing')->pluck('premium_id')->toArray());
           $prem = [];
           if(count($filters["premium"]) == 1){
            if($filters["premium"][0] == 1) $listings->whereIn('id',$request_senders);
            if($filters["premium"][0] == 0) $listings->whereNotIn('id',$request_senders);
           }
        }
        if(isset($filters["paid"]) and count($filters["paid"]) == 1){
            if($filters["paid"][0] == 1) $listings->where('premium',1);
            if($filters["paid"][0] == 0) $listings->where('premium',0);  
        }
        if(isset($filters['source'])){
            $listings = $listings->whereIn('source', $filters['source']);
        }
        if(isset($filters['user-status'])){
            $users = User::whereIn('status',$filters['user-status'])->pluck('id')->toArray();
            $listings = $listings->whereIn('owner_id',$users);
        }
        if(isset($filters['type'])){
            $listings = $listings->where(function ($listings) use ($filters){
                foreach($filters['type'] as $type ){
                    $listings->whereNull('id');
                    if($type == 'orphan') $listings->orWhereNull('verified')->orWhere('verified',0);
                    if($type == 'verified') $listings->orWhere('verified',1);
                }
            });
        }
        if (isset($filters['category_nodes'])) {
            $category = ListingCategory::whereIn('category_id',$filters['category_nodes'])->select('listing_id')->distinct()->pluck('listing_id')->toArray();
            $listings = $listings->whereIn('id',$category);
        }
        if(isset($filters['categories'])){
            $filter_nodes = [];
            $filters['categories'] = json_decode($filters['categories']);
            if(count($filters['categories'])!=0){
                foreach($filters['categories'] as $category_id){
                    $category = Category::find($category_id);
                    if($category->level == 3){
                        $filter_nodes[] = $category->id;
                    }else{
                        $nodes = Category::where('path','like',$category->path.str_pad($category->id, 5, '0', STR_PAD_LEFT)."%")->where('level',3)->pluck('id')->toArray();
                        $filter_nodes = array_merge($filter_nodes,$nodes);
                    }
                }
                $filter_listings = array_unique(ListingCategory::whereIn('category_id',$filter_nodes)->pluck('listing_id')->toArray());
                $listings = $listings->whereIn('id',$filter_listings);

            }
        }
        $listings = ($sort == "") ? $listings : $listings->orderBy($sort, $order);
        \Log::info('listings exported = '.$listings->count());
        $listings = $listings->get();
        $response = array();
        $cities = City::pluck('name','id')->toArray();
        foreach ($listings as $listing) {
            if($listing->owner and $listing->owner->status == 'active' and $listing->verified == 0){
                $listing->verified = 1;
                $listing->save();
            }
            
            $response[$listing->id]                    = array();
            //col 1 = city
            $response[$listing->id][] = $cities[$listing->location['city_id']];
            //col2 = name
            $response[$listing->id][] = $listing->title;
            //col3 = categories
            /*$categories = ListingCategory::getCategories($listing->id);
            $i    = 0;
            $temp = '';
            foreach ($categories as $key => $value) {
                if ($i != 0) {
                    $temp .= "|";
                } else {
                    $temp .= "";
                }

                $temp .= $value['parent'] . ' > ' . $value['branch'] . ' > ';
                $j = 0;
                foreach ($value['nodes'] as $node) {
                    if ($j != 0) {
                        $temp .= ', ';
                    }

                    $temp .= $node['name'];
                    $j++;
                }
                $i++;
            }
            $response[$listing->id][] = $temp;
            */
            //col4 = submission date
            $sub = ($listing->submission_date != null) ? $listing->submission_date->toDateTimeString() : '';
            $response[$listing->id][] = $sub;
            //col5 = approval date
            $response[$listing->id][] = ($listing->published_on != null)? $listing->published_on->toDateTimeString():'';
            //col6 = paid
            $response[$listing->id][] = ($listing->premium)? "Yes":"No";
            //col7 = status
            $status = ['3' => 'Draft', '2' => 'Pending Review', '1' => 'Published', '4' => 'Archived', '5' => 'Rejected'];
            $response[$listing->id][]          = $status[$listing->status];
            //col8 = views
            $response[$listing->id][] = $listing->views_count;
            //col9,10,11 = stats
            $lc = new ListingController;
            if(!isset($filters['stats_date']) or !isset($filters['stats_date']['start']) or !isset($filters['stats_date']['end'])){
                $stats = $lc->getListingStats($listing);
            }else{
                $end = new Carbon($filters['stats_date']['end']);
                $stats = $lc->getListingStats($listing,$filters['stats_date']['start'], $end->endOfDay()->toDateTimeString());
            }
            $response[$listing->id][] = $stats['contact'];
            $response[$listing->id][] = $stats['direct'];
            $response[$listing->id][] = $stats['shared'];
        }
        // dd($response);
        $excel = App::make('excel');
        Excel::create('Manage_Listing', function ($excel) use ($response){
            $excel->sheet('Listings', function ($sheet) use ($response){
                $sheet->fromArray($response, null, 'A2', true, false);
                $sheet->row(1, array(
                    'State', 'Listing Name','Date of Submission','Date of Approval','Paid','Status','Views','Contact Requests', 'Direct Enquiries', 'Shared Enquiries'
                ));
            });
        })->export('xls');
    }

    public function userExport(Request $request){
        $export = Defaults::where('type','export_filter')->get();
        return view('admin-dashboard.user_export')->with('types',$export);
    }

    public function getExportFilters(Request $request){
        $this->validate($request,[
            'type'=>'required'
        ]);
        // return $this->getFilterHtmlData();
        $email_type = Defaults::where('type','export_filter')->where('label',$request->type)->first();
        if($email_type == null) abort(404);
        $email_data = json_decode($email_type->meta_data,true);
        $html = '<input type="hidden" name="export-type" value="'.$email_type->label.'"> '.$this->getFilterHtmlData($email_data['user_filters']);
        return $html;
        
    }

    public function getFilterHtmlData($userFilters=[]){
        $html = '<h3>Please add values to the following filtering criteria as necessary:</h3><a href="#" id="clear-filters">clear all filters</a>';

        foreach ($userFilters as $column => $filter) {
            switch($filter){
                case 'state':
                    $html .= $this->getExportStateFilter();
                    break;
                case 'status':
                    $html .= $this->getExportStatusFilter();
                    break;
                case 'premium':
                    $html .= $this->getExportPremiumFilter();
                    break;
                case 'categories':
                    $html .= $this->getExportCategoryFilter();
                    break;
                case 'jobBusinessType':
                    $html .= $this->getExportJobBusinessTypeFilter();
                    break;
                case 'jobRole':
                    $html .= $this->getExportJobRoleFilter();
                    break;
                case 'signupType':
                    $html .= $this->getExportSignupTypeFilter();
                    break;
                case 'active':
                    $html .= $this->getExportActiveFilter();
                    break;
                case 'userSubType':
                    $html .= $this->getExportUsersubtypeFilter();
                    break;
                case 'userType':
                    $html .= $this->getExportUsertypeFilter();
                    break;
            }
        }

        $html .= '<div class="m-t-15"><button class="btn primary-btn border-btn fnb-btn" id="getExportCount">Export</button></div>';
        return $html;
        die(); 
    }

    public function getExportStateFilter(){
        $cities = City::where('status', '1')->get();
        $html = '<h5>Locations <a href="#" data-toggle="modal" data-target="#export-state-modal">Filter based on Locations</a></h5>
        <div id="display-export-state"><input type="hidden" id="selected-export-states" name="selected-export-states" value=""></div>
        <div class="modal fnb-modal confirm-box fade modal-center" id="export-state-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="text-medium m-t-0 bolder">Choose Locations</h5>
                              </div>
                              <div class="modal-body">
                                  ';
        $html.= '<div id="export-state-filter">';
        foreach ($cities as $city) {
            $html .= '<div class="">';
            $html .= '<input type="checkbox" id="'.$city->slug.'" value="'.$city->name.'" name="exportState[]">';
            $html .= '<label id="'.$city->slug.'-label" for="'.$city->slug.'" >'.$city->name.'</label>';
            $html .= '</div>';
        }
        $html.='</div>
        <div class="confirm-actions text-right">
                                      <a href="#" class="" > <button class="btn fnb-btn text-primary border-btn no-border" id="select-export-states" data-dismiss="modal">Add</button></a>
                                        <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';
        return $html;
    }

    public function displayExportStateFilter(Request $request){
        $states = ($request->has('states'))? $request->states : [];

        $html = '<input type="hidden" id="selected-export-states" name="selected-export-states" value="'.implode(',', $states).'">';
        if(!empty($states)){
            $html.='<div class="single-category gray-border add-more-cat m-t-15">
                        <ul class="fnb-cat small flex-row" id="view-export-states">';
                    foreach ($states as $node) {
                        $html .= '
                <li class="node-container">
                  <span class="fnb-cat__title">
                    '.$node.'
                  </span>
                </li>
                ';
                    }
                 
              $html .= '</ul>
                    </div>';
        }

        return response()->json(["html"=>$html]);
    }

    public function getExportStatusFilter(){
        $statuses = ["Draft", "Review", "Published", "Archived","Rejected"];
        $html = '<h5>Status <a href="#" data-toggle="modal" data-target="#export-status-modal">Filter based on Status</a></h5> <div id="display-export-status"><input type="hidden" id="selected-export-status" name="selected-export-status" value=""></div>
        <div class="modal fnb-modal confirm-box fade modal-center" id="export-status-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="text-medium m-t-0 bolder">Choose Statuses</h5>
                              </div>
                              <div class="modal-body ">
                                  ';
        $html.= '<div id="export-status-filter">';
        foreach ($statuses as $status) {
            $html .= '<div class="">';
            $html .= '<input type="checkbox" id="status-'.$status.'" value="'.$status.'" name="exportStatus[]">';
            $html .= '<label id="status-'.$status.'-label" for="status-'.$status.'" >'.$status.'</label>';
            $html .= '</div>';
        }
        $html.='</div>
        <div class="confirm-actions text-right">
                                      <a href="#" class="" > <button class="btn fnb-btn text-primary border-btn no-border" id="select-export-statuses" data-dismiss="modal">Add</button></a>
                                        <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';
        return $html;
    }

    public function displayExportStatusFilter(Request $request){
        $statuses = ($request->has('statuses'))? $request->statuses : [];

        $html = '<input type="hidden" id="selected-export-status" name="selected-export-status" value="'.implode(',', $statuses).'">';
        if(!empty($statuses)){
            $html.='<div class="single-category gray-border add-more-cat m-t-15">
                        <ul class="fnb-cat small flex-row" id="view-export-statuses">';
                    foreach ($statuses as $node) {
                        $html .= '
                <li class="node-container">
                  <span class="fnb-cat__title">
                    '.$node.'
                  </span>
                </li>
                ';
                    }
                 
              $html .= '</ul>
                    </div>';
        }

        return response()->json(["html"=>$html]);
    }

    public function getExportPremiumFilter(){
        // $html = '   <div class="row">
        //                 <div class="col-md-4">
        //                     <h5>Premium </h5>
        //                 </div> 
        //                 <div class="col-md-8">
        //                     <input type="checkbox" id="exportPremium" name="exportPremium">
        //                     <label for="exportPremium" >Filter only Premium</label>
        //                 </div> 
                        
        //             </div>';
        $html = '<h5>Premium  <a href="#" data-toggle="modal" data-target="#export-premium-modal">Filter based on premium</a></h5>
                <div id="display-export-premium"><input type="hidden" id="selected-export-premium" name="selected-export-premium" value=""></div>
        <div class="modal fnb-modal confirm-box fade modal-center" id="export-premium-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="text-medium m-t-0 bolder">Choose Premium</h5>
                              </div>
                              <div class="modal-body">
                                  <div id="export-premium">
                                     <div>
                                         <input type="checkbox" id="exportActive" name="exportPremium[]" value="true">
                                         <label for="exportActive" >true</label>
                                     </div>
                                     <div>
                                         <input type="checkbox" id="exportinactive" name="exportPremium[]" value="false">
                                         <label for="exportinactive" >false</label>
                                     </div>
                                  </div>  
                                  <div class="confirm-actions text-right">
                                      <a href="#" class="" > <button class="btn fnb-btn text-primary border-btn no-border" id="select-export-premium" data-dismiss="modal">Add</button></a>
                                        <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';
        return $html;
    }

    public function displayExportPremiumFilter(Request $request){
        $premium = ($request->has('premium'))? $request->premium : [];

        $html = '<input type="hidden" id="selected-export-premium" name="selected-export-premium" value="'.implode(',', $premium).'">';
        if($premium){
            $html.='<div class="single-category gray-border add-more-cat m-t-15">
                        <ul class="fnb-cat small flex-row" id="view-export-statuses">';
                    foreach ($premium as $node) {
                        $html .= '
                <li class="node-container">
                  <span class="fnb-cat__title">
                    '.$node.'
                  </span>
                </li>
                ';
                    }
                 
              $html .= '</ul>
                    </div>';
        }

        return response()->json(["html"=>$html]);
    }

    public function getExportCategoryFilter(){
        $html = '<h5>Categories <a href="#" data-toggle="modal" data-target="#export-category-modal">Filter based on categories</a></h5>
                <div id="display-export-categories"><input type="hidden" id="selected-export-categories"  name="selected-categories" value=""> </div>
        <div class="modal fnb-modal confirm-box fade modal-center" id="export-category-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="text-medium m-t-0 bolder">Choose Categories</h5>
                              </div>
                              <div class="modal-body">
                                  <div id="export-categories"></div>  
                                  <div class="confirm-actions text-right">
                                      <a href="#" class="" > <button class="btn fnb-btn text-primary border-btn no-border" id="select-export-categories" data-dismiss="modal">Add</button></a>
                                        <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';
        return $html;
    }

    public function getAllTreeCategoriesFromIds($categ_ids){
        $query = Category::whereIn('id',$categ_ids);
        // foreach ($categ_ids as &$id) {
        //     $query->orWhere('path','LIKE', '%'.str_pad($id, 5, '0', STR_PAD_LEFT).'%');
        // }
        $categories = $query->get();
        $paths = $categories->pluck('path')->toArray();
        $ids = [];
        foreach ($paths as $path) {
            $ids=array_merge(str_split($path,5),$ids);
        }
        $ids = array_unique($ids);
        $categories2 = Category::whereIn('id',$ids)->get();
        $categories = $categories->merge($categories2);
        return $categories;
    }

    public function generateTreeFromCategories($categories){
        $tree = ['parents' => [], 'leaf' =>[]];
        $categories = $categories->groupBy('level');
        if(isset($categories['1'])){
            foreach ($categories['1'] as $category) {
                $tree['parents'][str_pad($category->id, 5, '0', STR_PAD_LEFT)] =[
                    'id' => $category->id,
                    'image-url' => $category->icon_url,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'branches' => []
                ];
                array_push($tree['leaf'], $category->id);
                \Log::info('category_tree (push parent):'.$category->name.'('.$category->id.')');
            }
        }
        if(isset($categories['2'])){
            foreach ($categories['2'] as $category) {
                $tree['parents'][$category->path]['branches'][str_pad($category->id, 5, '0', STR_PAD_LEFT)] =[
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'nodes' => []
                ];
                unset($tree['leaf'][array_search($category->parent_id, $tree['leaf'])]);
                \Log::info('category_tree (pop parent):'.$category->parent_id);
                array_push($tree['leaf'], $category->id);
                \Log::info('category_tree (push branch):'.$category->name.'('.$category->id.')');
            }
        }
        if(isset($categories['3'])){
        try{
            foreach ($categories['3'] as $category) {
                    $path = str_split($category->path,5);
                    $tree['parents'][$path[0]]['branches'][$path[1]]['nodes'][str_pad($category->id, 5, '0', STR_PAD_LEFT)] =[
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                    ];
                    unset($tree['leaf'][array_search($category->parent_id, $tree['leaf'])]);
                    \Log::info('category_tree (pop branch):'.$category->parent_id);
                    array_push($tree['leaf'], $category->id);
                    \Log::info('category_tree (push node):'.$category->name.'('.$category->id.')');
                }
            }catch(\Exception $e){
                return false;
            }
        }
        $tree['leaf']=array_values($tree['leaf']);
        return $tree;
    }

    public function getCategoryHtmlFromTree($tree){
        $html = '<input type="hidden" id="selected-export-categories"  name="selected-categories" value="'.implode(',', $tree['leaf']).'"> ';
        foreach ($tree['parents'] as $parent) {
            $html.='
            
<div class="single-category gray-border add-more-cat m-t-15" data-categ-id="'.$parent['id'].'">
  <div class="row flex-row categoryContainer corecat-container align-top">
    <div class="col-sm-4 flex-row">
      <img class="import-icon cat-icon" src="'.$parent['image-url'].'">
      <div class="branch-row">
        <div class="cat-label">
          '.$parent['name'].'
          <input type=hidden name="categories" value="'.$parent['id'].'" data-item-name="'.$parent['slug'].'"> 
        </div>
      </div>
    </div>
    <div class="col-sm-8">';
      
            foreach ($parent['branches'] as $branch) {
                $html .= '
      <div class="m-b-10 row branch-container" data-categ-id="'.$branch['id'].'">
        <div class="col-sm-4">
          <ul class="fnb-cat flex-row small">
            <li>
              <span class="fnb-cat__title">
                <strong class="branch">'.$branch['name'].'</strong>
                <input type=hidden name="categories" value="'.$branch['id'].'" data-item-name="'.$branch['name'].'"> 
              </span>
            </li>
          </ul>
        </div>
        <div class="col-sm-8">
          <ul class="fnb-cat small flex-row" id="view-categ-node">';
                foreach ($branch['nodes'] as $node) {
                    $html .= '
            <li class="node-container">
              <span class="fnb-cat__title">
                '.$node['name'].'
                <input data-item-name="'.$node['name'].'" name="categories" type="hidden" value="'.$node['id'].'"> 
              </span>
            </li>
            ';
                }
             
          $html .= '</ul>
        </div>
      </div>
      ';
            }
    $html .= '</div>
  </div>
</div>';
        }
        return $html;
    }

    public function generateCategoryHirarchyFromID(Request $request){
        $category_ids = ($request->has('categories'))? $request->categories : [];

        $categories=$this->getAllTreeCategoriesFromIds($category_ids);
        $tree = $this->generateTreeFromCategories($categories);
        $html = $this->getCategoryHtmlFromTree($tree);
        return response()->json(["html"=>$html]);
    }

    public function getCategoriesData(Request $request){
        $response = [];
        if($request->has('id') and $request->id != "#"){
            $parent = Category::find($request->id);
            $children = ($parent->level == 1)? true:false;
            $categories = Category::where('status',1)->where('type','listing')->where('parent_id',$parent->id)->get();
            foreach ($categories  as $category) {
                $temp = [];
                $count = $category->getChildrenCount();
                $text = ($count>0)? " (".$count.")":"";
                $temp['children'] = $children;
                $temp['icon'] = false;
                $temp['text'] = $category->name.$text;
                $temp['id'] = $category->id;
                array_push($response, $temp);
            }
        }else{
            $categories = Category::where('status',1)->where('type','listing')->where('level','1')->get();
            foreach ($categories  as $category) {
                $temp = [];
                $temp['children'] = true;
                $temp['icon'] = false;//$category->icon_url;
                $temp['text'] = $category->name.' ('.$category->getChildrenCount().')';
                $temp['id'] = $category->id;
                array_push($response, $temp);
            }
        }
        return response()->json($response);
    }

    public function getExportUsertypeFilter(){
        $html = '<h5>User Type <a href="#" data-toggle="modal" data-target="#export-usertype-modal">Filter based on user types</a></h5>
                <div id="display-export-usertypes"><input type="hidden" id="selected-export-usertypes" name="selected-export-status" value=""></div>
        <div class="modal fnb-modal confirm-box fade modal-center" id="export-usertype-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="text-medium m-t-0 bolder">Choose User Types</h5>
                              </div>
                              <div class="modal-body">
                                  <div id="export-usertypes">
                                    <div>
                                        <input type="checkbox" name="usertypes[]" value="User" id="usertype-user-select">
                                        <label for="usertype-user-select">User</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="usertypes[]" value="Lead" id="usertype-lead-select">
                                        <label for="usertype-lead-select">Lead</label>
                                    </div>
                                </div>  
                                  <div class="confirm-actions text-right">
                                      <a href="#" class="" > <button class="btn fnb-btn text-primary border-btn no-border" id="select-export-usertypes" data-dismiss="modal">Add</button></a>
                                        <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';
        return $html;
    }  

    public function displayExportUserTypeFilter(Request $request){
        $userTypes = ($request->has('userTypes'))? $request->userTypes : [];

        $html = '<input type="hidden" id="selected-export-usertypes" name="selected-export-usertypes" value="'.implode(',', $userTypes).'">';
        if(!empty($userTypes)){
            $html.='<div class="single-category gray-border add-more-cat m-t-15">
                        <ul class="fnb-cat small flex-row" id="view-export-usertypes">';
                    foreach ($userTypes as $node) {
                        $html .= '
                <li class="node-container">
                  <span class="fnb-cat__title">
                    '.$node.'
                  </span>
                </li>
                ';
                    }
                 
              $html .= '</ul>
                    </div>';
        }

        return response()->json(["html"=>$html]);
    } 
    
    public function getExportUsersubtypeFilter(){
        $usersubtypes = Description::all();
        $html = '<h5>User Sub Type <a href="#" data-toggle="modal" data-target="#export-usersubtype-modal">Filter based on user sub type</a></h5>
                <div id="display-export-usersubtypes"><input type="hidden" id="selected-export-usersubtypes" name="selected-export-usersubtypes" value=""></div>
        <div class="modal fnb-modal confirm-box fade modal-center" id="export-usersubtype-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="text-medium m-t-0 bolder">Choose User SubTypes</h5>
                              </div>
                              <div class="modal-body">
                                  <div id="export-usersubtypes">';
                                foreach ($usersubtypes as $description) {
                                        $html.= '<div>
                                        <input type="checkbox" name="usersubtypes[]" value="'.$description->title.'" id="usersubtype-'.$description->id.'-select">
                                        <label for="usertype-'.$description->id.'-select">'.$description->title.'</label>
                                    </div>';
                                    }    
                                    
                                    
                         $html .= '</div>  
                                  <div class="confirm-actions text-right">
                                      <a href="#" class="" > <button class="btn fnb-btn text-primary border-btn no-border" id="select-export-usersubtypes" data-dismiss="modal">Add</button></a>
                                        <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';
        return $html;
    }

    public function displayExportUserSubTypeFilter(Request $request){
        $userSubTypes = ($request->has('userSubTypes'))? $request->userSubTypes : [];
        $html = '<input type="hidden" id="selected-export-usersubtypes" name="selected-export-usersubtypes" value="'.implode(',', $userSubTypes).'">';
        if(!empty($userSubTypes)){
            $html.='<div class="single-category gray-border add-more-cat m-t-15">
                        <ul class="fnb-cat small flex-row" id="view-export-usersubtypes">';
                    foreach ($userSubTypes as $node) {
                        $html .= '
                <li class="node-container">
                  <span class="fnb-cat__title">
                    '.$node.'
                  </span>
                </li>
                ';
                    }
                 
              $html .= '</ul>
                    </div>';
        }

        return response()->json(["html"=>$html]);
    } 

    public function getExportJobBusinessTypeFilter(){
            $jobbusinesstypes = Category::where('type','job')->get();
            $html = '<h5>Job Business Type <a href="#" data-toggle="modal" data-target="#export-jobbusinestype-modal">Filter based on job business types</a></h5>
                    <div id="display-export-jobtypes"><input type="hidden" id="selected-export-jobtypes" name="selected-export-jobtypes" value=""></div>
            <div class="modal fnb-modal confirm-box fade modal-center" id="export-jobbusinestype-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog modal-sm" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="text-medium m-t-0 bolder">Choose Job Business Types</h5>
                                  </div>
                                  <div class="modal-body">
                                        <input type="text" id="jobtypesearch">
                                      <div id="export-jobbusinesstypes">';
                                    foreach ($jobbusinesstypes as $jobtype) {
                                            $html.= '<div class="jobbusinesstype">
                                            <input type="checkbox" name="jobbusinesstypes[]" value="'.$jobtype->name.'" id="jobtype-'.$jobtype->id.'-select">
                                            <label for="jobtype-'.$jobtype->id.'-select">'.$jobtype->name.'</label>
                                        </div>';
                                        }    
                                        
                                        
                             $html .= '</div>  
                                      <div class="confirm-actions text-right">
                                          <a href="#" class="" > <button class="btn fnb-btn text-primary border-btn no-border" id="select-export-jobbusinesstypes" data-dismiss="modal">Add</button></a>
                                            <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>';
            return $html;
        }

    public function displayExportJobTypeFilter(Request $request){
        $jobTypes = ($request->has('jobTypes'))? $request->jobTypes : [];
        $html = '<input type="hidden" id="selected-export-jobtypes" name="selected-export-jobtypes" value="'.implode(',', $jobTypes).'">';
        if(!empty($jobTypes)){
            $html.='<div class="single-category gray-border add-more-cat m-t-15">
                        <ul class="fnb-cat small flex-row" id="view-export-jobtypes">';
                    foreach ($jobTypes as $node) {
                        $html .= '
                <li class="node-container">
                  <span class="fnb-cat__title">
                    '.$node.'
                  </span>
                </li>
                ';
                    }
                 
              $html .= '</ul>
                    </div>';
        }

        return response()->json(["html"=>$html]);
    }

    public function getExportJobRoleFilter(){
        $jobroles = Defaults::where('type','job_keyword')->get();
        $html = '<h5>Job Roles <a href="#" data-toggle="modal" data-target="#export-jobrole-modal">Filter based on job roles</a></h5>
                <div id="display-export-jobroles"><input type="hidden" id="selected-export-jobRoles" name="selected-export-jobRoles" value=""></div>
        <div class="modal fnb-modal confirm-box fade modal-center" id="export-jobrole-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="text-medium m-t-0 bolder">Choose Job Roles</h5>
                              </div>
                              <div class="modal-body">
                                    <input type="text" id="jobrolesearch">
                                  <div id="export-jobroles" class="modal-lists">';
                                foreach ($jobroles as $jobrole) {
                                        $html.= '<div class="jobrole">
                                        <input type="checkbox" name="jobroles[]" value="'.$jobrole->label.'" id="jobrole-'.str_slug($jobrole->label,'-').'-select">
                                        <label for="jobrole-'.str_slug($jobrole->label,'-').'-select">'.$jobrole->label.'</label>
                                    </div>';
                                    }    
                                    
                                    
                         $html .= '</div>  
                                  <div class="confirm-actions text-right">
                                      <a href="#" class="" > <button class="btn fnb-btn text-primary border-btn no-border" id="select-export-jobroles" data-dismiss="modal">Add</button></a>
                                        <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';
        return $html;
    } 

    public function displayExportJobRoleFilter(Request $request){
        $jobRoles = ($request->has('jobRoles'))? $request->jobRoles : [];
        $html = '<input type="hidden" id="selected-export-jobRoles" name="selected-export-jobRoles" value="'.implode(',', $jobRoles).'">';
        if(!empty($jobRoles)){
            $html.='<div class="single-category gray-border add-more-cat m-t-15">
                        <ul class="fnb-cat small flex-row" id="view-export-jobrole">';
                    foreach ($jobRoles as $node) {
                        $html .= '
                <li class="node-container">
                  <span class="fnb-cat__title">
                    '.$node.'
                  </span>
                </li>
                ';
                    }
                 
              $html .= '</ul>
                    </div>';
        }

        return response()->json(["html"=>$html]);
    }

    public function getExportSignupTypeFilter(){
        $types = ["google",'facebook','email','import','guest','listing'];
        $html = '<h5>Registration Type(s) <a href="#" data-toggle="modal" data-target="#export-signuptype-modal">Filter based on Registration Type</a></h5>
            <div id="display-export-signup"><input type="hidden" id="selected-export-signup" name="selected-export-signup" value=""></div>
        <div class="modal fnb-modal confirm-box fade modal-center" id="export-signuptype-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="text-medium m-t-0 bolder">Choose Registration Types</h5>
                              </div>
                              <div class="modal-body ">
                                  ';
        $html.= '<div id="export-signuptype-filter">';
        foreach ($types as $status) {
            $html .= '<div class="">';
            $html .= '<input type="checkbox" id="signuptype-'.$status.'" value="'.$status.'" name="exportsignuptype[]">';
            $html .= '<label id="signuptype-'.$status.'-label" for="signuptype-'.$status.'" >'.ucfirst($status).'</label>';
            $html .= '</div>';
        }
        $html.='</div>
        <div class="confirm-actions text-right">
                                      <a href="#" class="" > <button class="btn fnb-btn text-primary border-btn no-border" id="select-export-signuptypes" data-dismiss="modal">Add</button></a>
                                        <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';
        return $html;
    }  

    public function displayExportSignupFilter(Request $request){
        $signup = ($request->has('signup'))? $request->signup : [];
        $html = '<input type="hidden" id="selected-export-signup" name="selected-export-signup" value="'.implode(',', $signup).'">';
        if(!empty($signup)){
            $html.='<div class="single-category gray-border add-more-cat m-t-15">
                        <ul class="fnb-cat small flex-row" id="view-export-signup">';
                    foreach ($signup as $node) {
                        $html .= '
                <li class="node-container">
                  <span class="fnb-cat__title">
                    '.$node.'
                  </span>
                </li>
                ';
                    }
                 
              $html .= '</ul>
                    </div>';
        }

        return response()->json(["html"=>$html]);
    }

    public function getExportActiveFilter(){
        $html = '<h5>Active  <a href="#" data-toggle="modal" data-target="#export-active-modal">Filter based on active users</a></h5>
                <div id="display-export-active"><input type="hidden" id="selected-export-active" name="selected-export-active" value=""></div>
        <div class="modal fnb-modal confirm-box fade modal-center" id="export-active-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="text-medium m-t-0 bolder">Choose Active</h5>
                              </div>
                              <div class="modal-body">
                                  <div id="export-active">
                                     <div>
                                         <input type="checkbox" id="exportActive" name="exportActive[]" value="true">
                                         <label for="exportActive" >true (Active)</label>
                                     </div>
                                     <div>
                                         <input type="checkbox" id="exportinactive" name="exportActive[]" value="false">
                                         <label for="exportinactive" >false (Inactive)</label>
                                     </div>
                                  </div>  
                                  <div class="confirm-actions text-right">
                                      <a href="#" class="" > <button class="btn fnb-btn text-primary border-btn no-border" id="select-export-active" data-dismiss="modal">Add</button></a>
                                        <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';
        return $html;
    }

    public function displayExportActiveFilter(Request $request){
        $active = ($request->has('active'))? $request->active : [];
        $html = '<input type="hidden" id="selected-export-active" name="selected-export-active" value="'.implode(',', $active).'">';
        if(!empty($active)){
            $html.='<div class="single-category gray-border add-more-cat m-t-15">
                        <ul class="fnb-cat small flex-row" id="view-export-active">';
                    foreach ($active as $node) {
                        $html .= '
                <li class="node-container">
                  <span class="fnb-cat__title">
                    '.$node.'
                  </span>
                </li>
                ';
                    }
                 
              $html .= '</ul>
                    </div>';
        }

        return response()->json(["html"=>$html]);
    }

    public function getCountQuery($filters){
        $qry_test = "SELECT  count(*) as count FROM `pepo_backups` ";
        if(!empty($filters)){
            foreach ($filters as $column => &$data) {
                if(!empty($data)){
                    $stringdata = [];
                    foreach ($data as &$value) {
                        if(in_array($column, ['userType','listingType','area','jobRole','jobCategory','listingCategories','listingStatus','enquiryCategories','jobStatus','jobArea','listingPremium','jobPremium','enquiryArea'])){
                            $stringdata[] = '`'.$column.'` like  "%\"'.$value.'\"%" ';
                        }else{
                            $stringdata[] = '`'.$column.'` like  "%'.$value.'%" ';
                        }       
                    }
                    $data = '('. implode(" OR ",$stringdata) . ")";
                }else{
                    unset($filters[$column]);
                }
            }
            if(!empty($filters)){
                $string = " where ".implode(' AND ', $filters);
                $qry_test .= $string;
            }
        }
        \Log::info('Dump Query: '.$qry_test);
        return $qry_test;
    }

    public function getExportFiltersFromRequest($request){
        $export_type = Defaults::where('type','export_filter')->where('label',$request->exportType)->first();
        if($export_type == null) abort(404);
        $export = json_decode($export_type->meta_data,true);
        $filters = [];
        $userData = $request->all();
        // \Log::info(json_encode($userData));
        foreach ($export['applied_filters'] as $column => $value) {
            $filters[$column] = $value;
        }
        // \Log::info(json_encode($filters));
        foreach ($export['user_filters'] as $column => $userfilter) {
            $value = ($request->has($userfilter) and $userData[$userfilter] != 'undefined' and $userData[$userfilter] != ''  and !empty($userData[$userfilter]))? explode(',', $userData[$userfilter]): [];
            // \Log::info($userfilter.' => 1)'.$request->has($userfilter).' 2)'.$userData[$userfilter].json_encode($value));
            if($userfilter == 'userType'){
                if(array_search('User', $value) > -1){
                    unset($value[array_search('User', $value)]); 
                    $value = array_merge(['email','google','facebook','import','listing'],$value);
                }
                if(array_search('Lead', $value) > -1){
                    unset($value[array_search('Lead', $value)]); 
                    $value = array_merge(['guest'],$value);
                }
            }
            if($userfilter == 'categories'){
                $value = Category::whereIn('id',$value)->pluck('name')->toArray();
            }

            if(!isset($filters[$column]) or !empty($value))
            $filters[$column] = $value;
            // \Log::info(json_encode($filters));
        }
        \Log::info(json_encode($filters));
        return $filters;
    }

    public function getExportCount(Request $request){
        $this->validate($request,[
            'exportType' => 'required'
        ]);
        $filters = $this->getExportFiltersFromRequest($request);
        $qry_test = $this->getCountQuery($filters);
        try {
            $count = collect(DB::select($qry_test));
        }catch (\Illuminate\Database\QueryException $ex) {
            $error_msg = $ex->getMessage();
            return array('status' => false, 'msg' => $error_msg);
        }
        return array('status'=> true, 'count' => $count->first()->count);
    }

    public function getExportData(Request $request){
        $this->validate($request,[
            'exportType' => 'required'
        ]);
        $filters = $this->getExportFiltersFromRequest($request);
        $file = dumpTableintoFile('pepo_backups',$filters,[],true,true);

        // \Log::info(json_encode($file));
        if($file['status']) return response()->download($file['path']);
        abort(200,$file['msg']);
    }

    
}

