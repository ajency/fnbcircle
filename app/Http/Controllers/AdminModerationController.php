<?php

namespace App\Http\Controllers;

use App;
use Excel;

use App\Category;
use App\City;
use App\Area;
use App\Common;
use App\Http\Controllers\ListingController;
use App\Listing;
use App\ListingCategory;
use App\ListingCommunication;
use App\Defaults;
use App\PlanAssociation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Spatie\Activitylog\Models\Activity;
use Ajency\Ajfileimport\Helpers\AjCsvFileImport;
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
        return view('admin-dashboard.listing_approval')->with('parents', $parent_categ)->with('cities', $cities)->with('importForm',$form_view);
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
            $listing['status']     = $status[$listing['status']] . '<a href="#updateStatusModal" data-target="#updateStatusModal" data-toggle="modal"><i class="fa fa-pencil"></i></a>';
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

            // if (count($filters['status'])==1) $listing['#'] = '<td class=" select-checkbox" style="display: table-cell;"></td>';
            // dd($listing['categories']);
            $i    = 0;
            $temp = '';
            foreach ($listing['categories'] as $key => $value) {
                if ($i != 0) {
                    $temp .= "<hr>";
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
            $listing['categories'] = $temp;
            // dd($listing['categories']);
        }

        return response()->json($response);
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
        $end = new Carbon($filters['submission_date']['end']);
        if ($filters['submission_date']['start'] != "") {
            $listings->where('submission_date', '>', $filters['submission_date']['start'])->where('submission_date', '<', $end->addDay()->toDateTimeString());
        }
        $listings = $listings->where('title','like','%'.$search.'%');
        if (isset($filters['city'])) {
            $areas = Area::whereIn('city_id', $filters['city'])->pluck('id')->toArray();
            $listings = $listings->whereIn('locality_id',$areas);
        }
        if(isset($filters["updated_by"])){
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
        $filtered = $listings->count();
        $listings = $listings->skip($start)->take($display_limit);
        $listings = ($sort == "") ? $listings : $listings->orderBy($sort, $order);
        // $output   = new ConsoleOutput;
        // $output->writeln($listings->toSql());
        // $output->writeln($filters['submission_date']['start']);
        // $output->writeln($filters['submission_date']['end']);

        $listings = $listings->get();
        // $filtered = count($listings);
        // $output->writeln(json_encode($listings));
        $response = array();

        foreach ($listings as $listing) {
            // $output->writeln($listing->submission);
            // dd($listing);
            $sub                                       = ($listing->submission_date != null) ? $listing->submission_date->toDateTimeString() : '';
            $response[$listing->id]                    = array('id' => $listing->id, 'name' => $listing->title, 'submission_date' => $sub, 'updated_on' => $listing->updated_at->toDateTimeString());
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
        Excel::create('Listing_import', function ($excel){
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
        return response()->download(storage_path().'/app/public/import.xls');
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
            DB::statement($sql);
        }
        $category_ids = \App\ListingCategory::distinct()->whereNull('category_slug')->pluck('category_id')->toArray();
        if(!empty($category_ids)){
            $categories = \App\Category::whereIn('id',$category_ids)->pluck('slug','id')->toArray();
            $sql = 'UPDATE listing_category SET category_slug = (CASE';
            foreach ($categories as $id => $slug) {
                 $sql.= ' WHEN category_id = '.$id.' THEN \''.$slug.'\'';
            }
            $sql.= 'END) WHERE  category_slug IS NULL';
            DB::statement($sql);
        }
        $brand_ids = \Conner\Tagging\Model\Tagged::distinct()->whereNull('tag_name')->pluck('tag_slug')->toArray();
        if(!empty($brand_ids)){
            $brands = \Conner\Tagging\Model\Tag::where('tag_group_id', 1)->whereIn('slug',$brand_ids)->pluck('name','slug')->toArray();
            $sql = 'UPDATE tagging_tagged SET tag_name = (CASE';
            foreach ($brands as $slug => $name) {
                sql.= ' WHEN tag_slug = '.$slug.' THEN \''.$name.'\'';
            }
            $sql.= 'END) WHERE  category_slug IS NULL';
            DB::statement($sql);
        }
    }
}
