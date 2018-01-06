<?php

namespace App\Http\Controllers;

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
use View;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Auth\RegisterController;
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
        return view('admin-dashboard.listing_approval')->with('parents', $parent_categ)->with('cities', $cities);
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
                    $html.='<label>Category Filter</label>
                       <a href="#category-select" data-toggle="modal" data-target="#category-select" class="btn btn-link btn-sm" id="select-more-categories">Filter based on Categories</a>
                      <input type="hidden" id="modal_categories_chosen" name="modal_categories_chosen" value="[]">
                      <input type="hidden" id="is_parent_category_checkbox" value="1">
                      <input type="hidden" id="is_branch_category_checkbox" value="1">
                      <div id="categories" class="node-list"></div>';
                    $html.= View::make('modals.categories_list');
                    break;
                case 'listing_source':
                    $html.='<label>Listing Source Filter</label>
                            <select name="listing_source" class="form-control" multiple>
                                <option value="">Select</option>
                                <option value="import">Import</option>
                                <option value="internal_user">Internal User</option>
                                <option value="external_user">External User</option>
                            </select>';
                    break;
                case 'description_filter':
                    $description = \App\Description::where('active',1)->get();
                    $html.='<label>Description Filter</label>
                            <select name="description" multiple>
                                <option value="">Select</option>';
                    foreach ($description as $des) {
                        $html.='<option value="'.$des->id.'">'.$des->title.'</option>';
                    }
                    $html.='</select>
                            ';
                    break;
                case 'user_created_filter':
                    $html .= '<label>User Created</label>
                    <div class="form-group">
                      <input type="text" id="submissionDate" name="" class="form-control fnb-input">
                    </div>';
                    break;
            }
        }
        $html .= '<br><button class="btn primary-btn border-btn fnb-btn" type="button" id="mail-check">Send Mail</button>';
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
                $sql="select active_users.id as userID,draft_listings.id as listingID from (select * from listings where status = 3";
                if(!empty($areas)) $sql.= " and locality_id in ('".implode("','",$areas)."')";
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
                $sql="select active_users.id as userID,draft_listings.id as listingID from (select * from listings where status = 3";
                if(!empty($areas)) $sql.= " and locality_id in ('".implode("','",$areas)."')";
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
                    $areas = UserDetail::whereIn('area',$request->areas)->pluck('user_id')->toArray();
                    $cities = UserDetail::whereIn('city',$request->cities)->pluck('user_id')->toArray();
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
                        'subject' => "Listing(s) added under your account on FnB Circle",
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
                $errors = [];
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
                            'subject' => "Listing(s) added under your account on FnB Circle",
                            'template_data' => [
                                'confirmationLink' => $reset_password_url,
                                'listings'=> $listing_details,
                                
                            ],
                        ];
                        sendEmail('listing-user-notify',$email);
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
            return response()->json(['errors'=>$errors],200);
        }
    }
}

