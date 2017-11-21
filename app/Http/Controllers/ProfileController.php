<?php

namespace App\Http\Controllers;

use App\Area;
use App\EnquiryCategory;
use App\User;
use App\Listing;
use App\Enquiry;
use App\UserCommunication;
use App\EnquirySent;
use Carbon\Carbon;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ProfileController extends Controller
{
    public function displayProfile($step, $email = null)
    {

        if ($email == null) {
            $user = Auth::user();
            $self = true;
        } elseif ($email == Auth::user()->getPrimaryEmail()) {
            return redirect('profile/' . $step);
        } else {
            $usercomm = UserCommunication::where('value', $email)->where('object_type', 'App\\User')->where('is_primary', 1)->first();
            $user     = User::findUsingEmail($email);
            if ($usercomm != null and $user != null) {
                if (hasAccess('view_profile_element_cls', $usercomm->id, 'communication')) {
                    $self = true;
                } else {
                    if ($step == 'basic-details') {
                        abort(403);
                    }

                    $self = false;
                }
            } else {
                abort(403);
            }

        }

        $template           = [];
        $template['name']   = $user->name;
        $template['joined'] = $user->created_at->toFormattedDateString();
        $template['email']  = $user->getPrimaryEmail(true);
        $template['phone']  = $user->getPrimaryContact();
        $template['step']   = $step;

        switch ($step) {
            case 'basic-details':
                $data           = [];
                $data['name']   = $user->name;
                $data['joined'] = $user->created_at->format('F Y');
                $data['email']  = $user->getPrimaryEmail(true);
                $data['phone']  = $user->getPrimaryContact();
                if ($data['phone'] == null) {
                    $data['phone'] = ['contact' => '', 'contact_region' => '91', 'is_verified' => 0];
                }

                $data['password'] = ($user->signup_source != 'google' and $user->signup_source != 'facebook') ? true : false;
                return view('profile.basic-details')->with('data', $template)->with('details', $data)->with('self', $self);
            case 'description':

                $data = [];
                return view('profile.describes-best')->with('data', $template)->with('details', $data)->with('self', $self);
            case 'activity':
                if(!$self){
                    $data = $this->getUserEnquiryActivity($user);
                    if($data == "") abort(403);    
                }
                
                return view('profile.enquiry-info')->with('data', $template)->with('details', $data)->with('self', $self);
            default:
                abort(404);
        }

    }

    public function getUserEnquiryActivity($user){
        $listings_id = Listing::where('owner_id',Auth::user()->id)->pluck('id')->toArray();
        $enquiry_sent = EnquirySent::whereIn('enquiry_to_id',$listings_id)->where('enquiry_to_type','App\\Listing')->pluck('enquiry_id')->toArray();
        $enquiries = Enquiry::whereIn('id', $enquiry_sent)->where('user_object_id',$user->id)->where('user_object_type','App\\User')->orderBy('created_at','desc')->get();
        $data="";
        foreach ($enquiries as $enquiry) {
            $details = [];
            $details['date'] = $enquiry->created_at->format('j F Y');
            $details['type'] = $enquiry->sentTo()->whereIn('enquiry_to_id',$listings_id)->where('enquiry_to_type','App\\Listing')->first()->enquiry_type;
            if($details['type']=='direct') {
                $details['enquiree']      = $enquiry->enquiry_to()->first();
                $details['enquiree_name'] = $details['enquiree']->title;
                $against_city          = Area::with('city')->find($details['enquiree']->locality_id);
                $details['enquiree_link'] = url('/' . $against_city->city['slug'] . '/' . $details['enquiree']->slug);
                unset($details['enquiree']);
            }
            $details['made-by-name']        = $user->name;
            $details['made-by-email']       = $user->getPrimaryEmail(true);
            $details['made-by-phone']       = $user->getPrimaryContact();
            $details['made-by-description'] = unserialize($user->getUserDetails()->first()->subtype);
            $config                      = config('helper_generate_html_config.enquiry_popup_display');
            foreach ($details['made-by-description'] as &$detail) {
                $detail = $config[$detail]['title'];
            }
            $details['categories'] = EnquiryCategory::getCategories($enquiry->id);
            $details['areas'] = $enquiry->areas()->with('city')->get()->groupBy('city_id');
            $areas         = [];
            foreach ($details['areas'] as $city_id => $cities) {
                $city = $cities[0]->city()->first()->name . ' - <span class="text-medium"> ';
                $area = [];
                foreach ($cities as $city_area_ref) {
                    $city_area = $city_area_ref->area()->first();
                    $area[]    = $city_area->name;
                }
                $city .= implode(', ', $area);
                $city .= '</span>';
                $areas[] = $city;
            }
            $details['areas'] = implode('<br/>', $areas);
            if (count($details['areas']) == 0) {
                unset($details['areas']);
            }
            $details['message'] = $enquiry->enquiry_message;
            if ($details['message'] == null) {
                $details['message'] = "No description given";
            }
            switch ($details['type']) {
                            case 'direct':
                                $details['html'] = '
                                <div class="enquire-container">
                                    <h6 class="enquiry-made-by text-medium">
                                        '.$details['made-by-name'].' made a
                                        <label class="fnb-label">
                                            Direct Enquiry
                                        </label>
                                        to
                                        <a class=" text-decor" target="_blank" href="' . $details['enquiree_link'] . '">
                                            ' . $details['enquiree_name'] . '
                                        </a>
                                        on '.$details['date'].'
                                    </h6>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <dl class="flex-row flex-wrap enquiriesRow">
                                                <div class="enquiriesRow__cols">
                                                    <dt>
                                                        Name
                                                    </dt>
                                                    <dd>
                                                        ' . $details['made-by-name'] . '
                                                    </dd>
                                                </div>
                                                <div class="enquiriesRow__cols">
                                                    <dt>
                                                        Email address
                                                    </dt>
                                                    <dd>
                                                           ' . $details['made-by-email']['email'] . '
                                                            <span class="fnb-icons verified-icon mini">
                                                            </span>
                                                        </dd>
                                                </div>

                                                <div class="enquiriesRow__cols">
                                                    <dt>
                                                        Phone number
                                                    </dt>
                                                    <dd>+' . $details['made-by-phone']['contact_region'] . ' ' . $details['made-by-phone']['contact'];

                                if ($details['made-by-phone']['is_verified'] == 1) {
                                    $details['html'] .= '<span class="fnb-icons verified-icon mini"></span>';
                                } else {
                                    $details['html'] .= '<i class="fa fa-times not-verified" aria-hidden="true"></i> ';
                                }

                                $details['html'] .= '</dd>
                                                </div>
                                                <div class="enquiriesRow__cols">
                                                    <dt>
                                                        What describe you best?
                                                    </dt>
                                                    <dd>';
                                foreach ($details['made-by-description'] as $value) {
                                    $details['html'] .= '<p class="describe-points"><i class="fa fa-hand-o-right" aria-hidden="true"></i> ' . $value . '</p>';
                                }
                                $details['html'] .= '</dd>
                                                </div>
                                                <div class="enquiriesRow__cols last-col">
                                                     <dt>
                                                        Give the supplier/service provider some details of your requirement
                                                    </dt>
                                                    <dd>
                                                        ' . $details['message'] . '
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            ';
                                break;

                            case 'shared':
                                $details['html'] = '
                                    <div class="enquire-container">
                                        <h6 class="enquiry-made-by text-medium">
                                            '.$details['made-by-name'].' made a
                                            <label class="fnb-label">
                                                Shared Enquiry
                                            </label>on '.$details['date'].'';

                                $details['html'] .= '</h6>
                                        <div class="row">
                                            <div class="col-sm-5 b-r">
                                                <dl class="flex-row flex-wrap enquiriesRow withCat">
                                                    <div class="enquiriesRow__cols">
                                                        <dt>
                                                            Name
                                                        </dt>
                                                        <dd>
                                                            ' . $details['made-by-name'] . '
                                                        </dd>
                                                    </div>
                                                    <div class="enquiriesRow__cols">
                                                        <dt>
                                                            Email address
                                                        </dt>
                                                        <dd>
                                                           ' . $details['made-by-email']['email'] . '
                                                            <span class="fnb-icons verified-icon mini">
                                                            </span>
                                                        </dd>
                                                    </div>

                                                    <div class="enquiriesRow__cols">
                                                        <dt>
                                                            Phone number
                                                        </dt>
                                                         <dd>+' . $details['made-by-phone']['contact_region'] . ' ' . $details['made-by-phone']['contact'];

                                if ($details['made-by-phone']['is_verified'] == 1) {
                                    $details['html'] .= '<span class="fnb-icons verified-icon mini"></span>';
                                } else {
                                    $details['html'] .= '<i class="fa fa-times not-verified" aria-hidden="true"></i> ';
                                }

                                $details['html'] .= '</dd>
                                                    </div>
                                                    <div class="enquiriesRow__cols">
                                                        <dt>
                                                            What describe you best?
                                                        </dt>
                                                        <dd>';
                                foreach ($details['made-by-description'] as $value) {
                                    $details['html'] .= '<p class="describe-points"><i class="fa fa-hand-o-right" aria-hidden="true"></i> ' . $value . '</p>';
                                }
                                $details['html'] .= '</dd>
                                                    </div>

                                                </dl>
                                            </div>
                                            <div class="col-sm-7">
                                                <dl class="enquiriesRow">
                                                    <div class="enquiriesRow__cols">
                                                        <dt>
                                                            Categories
                                                        </dt>
                                                        <dd>
                                                            <ul class="fnb-cat flex-row">';
                                foreach ($details['categories'] as $category) {
                                    foreach ($category['nodes'] as $node) {
                                        $details['html'] .= '
                                                         <li>
                                                            <a class="fnb-cat__title" href="">
                                                                ' . $node['name'] . '
                                                            </a>
                                                        </li>
                                                    ';
                                    }
                                }
                                $details['html'] .= '</ul>
                                                        </dd>
                                                    </div>

                                                    <div class="enquiriesRow__cols">
                                                        <dt>
                                                            Areas
                                                        </dt>
                                                        <dd>
                                                            <p class="default-size">
                                                                ' . $details['areas'] . '
                                                            </p>
                                                        </dd>
                                                    </div>

                                                </dl>
                                            </div>
                                            <div class="col-sm-12 m-t-10">
                                                <div class="enquiriesRow__cols last-col">
                                                     <dt>
                                                        Give the supplier/service provider some details of your requirement
                                                    </dt>
                                                    <dd>
                                                        ' . $details['message'] . '
                                                    </dd>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                ';
                                break;
                        }
            $data .=$details['html'];
        }
        return $data;
    }

    public function getUserActivity(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'date'  => 'nullable',
        ]);
        $usercomm = UserCommunication::where('value', $request->email)->where('object_type', 'App\\User')->where('is_primary', 1)->first();
        if (!hasAccess('view_profile_element_cls', $usercomm->id, 'communication')) {
            return response()->json(['data'=>[],'more'=>0]);
        }
        $user          = User::findUsingEmail($request->email);
        $day          = (isset($request->day)) ? Carbon::createFromFormat('j F Y', $request->day)->startOfDay() : Carbon::now();
        $activity_type = config('tempconfig.activity-types');
        $activities    = $user->activities(config('tempconfig.activity-display-classes'))->where('created_at','<',$day)->orderBy('created_at', 'desc')->take(config('tempconfig.activity-display-number'))->get();
        if(count($activities)>0){
            $activities1   =  $user->activities(config('tempconfig.activity-display-classes'))->orderBy('created_at', 'desc')->where('created_at', 'like', $activities->last()->created_at->toDateString() . '%')->get();
            $last_date = $activities->last()->created_at;
            $more = $user->activities(config('tempconfig.activity-display-classes'))->where('created_at','<', $last_date->startOfDay())->count();
        }else{
            $activities1 = collect([]);
            $more = 0;
        }
        $response      = [];
        $prev = [];
        $objects       = [$activities, $activities1];
        foreach ($objects as $object) {
            foreach ($object as $activity) {
                if(in_array($activity->id, $prev)){
                    continue;
                }
                $prev[] = $activity->id;
                $activity_date = $activity->created_at->format('j F Y');
                if (!isset($response[$activity_date])) {
                    $response[$activity_date] = [];
                }

                $temp         = [];
                // die(get_class($activity->subject));
                $temp['type'] = $activity_type[get_class($activity->subject)];
                switch ($temp['type']) {
                    case 'enquiry':
                        $enquiry = $activity->subject;
                        // Enquiry Type
                        if ($enquiry->sentTo()->count() > 1 or $enquiry->enquiry_to_id == 0) {
                            $temp['enquiry-type'] = 'shared';
                        } else {
                            $temp['enquiry-type'] = 'direct';
                        }

                        //Enquiry Made To
                        if ($enquiry->enquiry_to_id != 0) {
                            $temp['enquiree']      = $enquiry->enquiry_to()->first();
                            $temp['enquiree_name'] = $temp['enquiree']->title;
                            $against_city          = Area::with('city')->find($temp['enquiree']->locality_id);
                            $temp['enquiree_link'] = url('/' . $against_city->city['slug'] . '/' . $temp['enquiree']->slug);
                            unset($temp['enquiree']);
                        }

                        //Enquiry Made By
                        $temp['made-by-name']        = $user->name;
                        $temp['made-by-email']       = $user->getPrimaryEmail(true);
                        $temp['made-by-phone']       = $user->getPrimaryContact();
                        $temp['made-by-description'] = unserialize($user->getUserDetails()->first()->subtype);
                        $config                      = config('helper_generate_html_config.enquiry_popup_display');
                        foreach ($temp['made-by-description'] as &$detail) {
                            $detail = $config[$detail]['title'];
                        }

                        //categories
                        $temp['categories'] = EnquiryCategory::getCategories($enquiry->id);
                        // if(empty($temp['categories'])) unset($temp['categories']);

                        //areas
                        $temp['areas'] = $enquiry->areas()->with('city')->get()->groupBy('city_id');
                        $areas         = [];
                        foreach ($temp['areas'] as $city_id => $cities) {
                            $city = $cities[0]->city()->first()->name . ' - <span class="text-medium"> ';
                            $area = [];
                            foreach ($cities as $city_area_ref) {
                                $city_area = $city_area_ref->area()->first();
                                $area[]    = $city_area->name;
                            }
                            $city .= implode(', ', $area);
                            $city .= '</span>';
                            $areas[] = $city;
                        }
                        $temp['areas'] = implode('<br/>', $areas);
                        if (count($temp['areas']) == 0) {
                            unset($temp['areas']);
                        }

                        //Message
                        $temp['message'] = $enquiry->enquiry_message;
                        if ($temp['message'] == null) {
                            $temp['message'] = "No description given";
                        }

                        //HTML
                        switch ($temp['enquiry-type']) {
                            case 'direct':
                                $temp['html'] = '
                                <div class="enquire-container">
                                    <h6 class="enquiry-made-by text-medium">
                                        You made a
                                        <label class="fnb-label">
                                            Direct Enquiry
                                        </label>
                                        to
                                        <a class=" text-decor" target="_blank" href="' . $temp['enquiree_link'] . '">
                                            ' . $temp['enquiree_name'] . '
                                        </a>
                                    </h6>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <dl class="flex-row flex-wrap enquiriesRow">
                                                <div class="enquiriesRow__cols">
                                                    <dt>
                                                        Name
                                                    </dt>
                                                    <dd>
                                                        ' . $temp['made-by-name'] . '
                                                    </dd>
                                                </div>
                                                <div class="enquiriesRow__cols">
                                                    <dt>
                                                        Email address
                                                    </dt>
                                                    <dd>
                                                           ' . $temp['made-by-email']['email'] . '
                                                            <span class="fnb-icons verified-icon mini">
                                                            </span>
                                                        </dd>
                                                </div>

                                                <div class="enquiriesRow__cols">
                                                    <dt>
                                                        Phone number
                                                    </dt>
                                                    <dd>+' . $temp['made-by-phone']['contact_region'] . ' ' . $temp['made-by-phone']['contact'];

                                if ($temp['made-by-phone']['is_verified'] == 1) {
                                    $temp['html'] .= '<span class="fnb-icons verified-icon mini"></span>';
                                } else {
                                    $temp['html'] .= '<i class="fa fa-times not-verified" aria-hidden="true"></i> ';
                                }

                                $temp['html'] .= '</dd>
                                                </div>
                                                <div class="enquiriesRow__cols">
                                                    <dt>
                                                        What describe you best?
                                                    </dt>
                                                    <dd>';
                                foreach ($temp['made-by-description'] as $value) {
                                    $temp['html'] .= '<p class="describe-points"><i class="fa fa-hand-o-right" aria-hidden="true"></i> ' . $value . '</p>';
                                }
                                $temp['html'] .= '</dd>
                                                </div>
                                                <div class="enquiriesRow__cols last-col">
                                                     <dt>
                                                        Give the supplier/service provider some details of your requirement
                                                    </dt>
                                                    <dd>
                                                        ' . $temp['message'] . '
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            ';
                                break;

                            case 'shared':
                                $temp['html'] = '
                                    <div class="enquire-container">
                                        <h6 class="enquiry-made-by text-medium">
                                            You made a
                                            <label class="fnb-label">
                                                Shared Enquiry
                                            </label>';
                                if (isset($temp['enquiree_name'])) {
                                    $temp['html'] .= 'to <a class=" text-decor" target="_blank" href="' . $temp['enquiree_link'] . '">' . $temp['enquiree_name'] . '</a>';
                                }

                                $temp['html'] .= '</h6>
                                        <div class="row">
                                            <div class="col-sm-5 b-r">
                                                <dl class="flex-row flex-wrap enquiriesRow withCat">
                                                    <div class="enquiriesRow__cols">
                                                        <dt>
                                                            Name
                                                        </dt>
                                                        <dd>
                                                            ' . $temp['made-by-name'] . '
                                                        </dd>
                                                    </div>
                                                    <div class="enquiriesRow__cols">
                                                        <dt>
                                                            Email address
                                                        </dt>
                                                        <dd>
                                                           ' . $temp['made-by-email']['email'] . '
                                                            <span class="fnb-icons verified-icon mini">
                                                            </span>
                                                        </dd>
                                                    </div>

                                                    <div class="enquiriesRow__cols">
                                                        <dt>
                                                            Phone number
                                                        </dt>
                                                         <dd>+' . $temp['made-by-phone']['contact_region'] . ' ' . $temp['made-by-phone']['contact'];

                                if ($temp['made-by-phone']['is_verified'] == 1) {
                                    $temp['html'] .= '<span class="fnb-icons verified-icon mini"></span>';
                                } else {
                                    $temp['html'] .= '<i class="fa fa-times not-verified" aria-hidden="true"></i> ';
                                }

                                $temp['html'] .= '</dd>
                                                    </div>
                                                    <div class="enquiriesRow__cols">
                                                        <dt>
                                                            What describe you best?
                                                        </dt>
                                                        <dd>';
                                foreach ($temp['made-by-description'] as $value) {
                                    $temp['html'] .= '<p class="describe-points"><i class="fa fa-hand-o-right" aria-hidden="true"></i> ' . $value . '</p>';
                                }
                                $temp['html'] .= '</dd>
                                                    </div>

                                                </dl>
                                            </div>
                                            <div class="col-sm-7">
                                                <dl class="enquiriesRow">
                                                    <div class="enquiriesRow__cols">
                                                        <dt>
                                                            Categories
                                                        </dt>
                                                        <dd>
                                                            <ul class="fnb-cat flex-row">';
                                foreach ($temp['categories'] as $category) {
                                    foreach ($category['nodes'] as $node) {
                                        $temp['html'] .= '
                                                         <li>
                                                            <a class="fnb-cat__title" href="">
                                                                ' . $node['name'] . '
                                                            </a>
                                                        </li>
                                                    ';
                                    }
                                }
                                $temp['html'] .= '</ul>
                                                        </dd>
                                                    </div>

                                                    <div class="enquiriesRow__cols">
                                                        <dt>
                                                            Areas
                                                        </dt>
                                                        <dd>
                                                            <p class="default-size">
                                                                ' . $temp['areas'] . '
                                                            </p>
                                                        </dd>
                                                    </div>

                                                </dl>
                                            </div>
                                            <div class="col-sm-12 m-t-10">
                                                <div class="enquiriesRow__cols last-col">
                                                     <dt>
                                                        Give the supplier/service provider some details of your requirement
                                                    </dt>
                                                    <dd>
                                                        ' . $temp['message'] . '
                                                    </dd>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                ';
                                break;
                        }

                        //break
                        break;
                }
                $response[$activity_date][] = $temp;
            }
        }
        return response()->json(['data'=>$response, 'more'=>$more]);

    }

    public function changePassword()
    {
        $this->validate(request(), [
            'old_password' => 'required|current_password',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        request()->user()->fill([
            'password' => Hash::make(request()->input('new_password')),
        ])->save();
        request()->session()->flash('passwordChange', 'Password changed!');

        return \Redirect::back();
    }

    public function changePhone()
    {
        $req      = request()->all();
        $usercomm = UserCommunication::where('value', $req['email_id'])->where('object_type', 'App\\User')->where('is_primary', 1)->first();
        if (($usercomm != null and hasAccess('view_profile_element_cls', $usercomm->id, 'communication')) or $req['email_id'] == Auth::user()->getPrimaryEmail()) {
            $user = User::findUsingEmail($req['email_id']);
            if ($user->name != $req['username']) {
                $user->name = $req['username'];
                $user->save();
                activity()
                    ->performedOn($user)
                    ->causedBy($user)
                    ->log('user-details-updated');
            }

            $comm_obj = UserCommunication::where('object_type', 'App\\User')->where('object_id', $user->id)->where('type', 'mobile')->where('is_primary', 1)->first();
            if ($comm_obj == null or $comm_obj->is_verified == 0) {
                UserCommunication::where('id', '!=', $req['contact_mobile_id'])->where('object_type', 'App\\User')->where('object_id', $user->id)->where('type', 'mobile')->delete();
                if ($req['contact_mobile_id'] == '') {
                    $comm = new UserCommunication;
                } else {
                    $comm = UserCommunication::find($req['contact_mobile_id']);
                }
                if ($req['contactNumber'] != "") {
                    $comm->type             = 'mobile';
                    $comm->object_type      = 'App\\User';
                    $comm->object_id        = $user->id;
                    $comm->value            = $req['contactNumber'];
                    $comm->country_code     = $req['contact_country_code'][0];
                    $comm->is_primary       = 1;
                    $comm->is_communication = 1;
                    // $comm->is_verified = 0;
                    // $comm->is_visible = 0;
                    $comm->save();
                }
            }
        }
        return \Redirect::back();
    }
}
