<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\UserCommunication;
use File;
use Illuminate\Support\Facades\Storage;
// use Aws\Laravel\AwsFacade as AWS;
// use Aws\Laravel\AwsServiceProvider;
use Ajency\User\Ajency\userauth\UserAuth;
use Session;
use App\Job;
use App\City;
use App\Area;
use App\Defaults;
use App\Category;
use App\Listing;
use App\ListingAreasOfOperation;
use App\ListingCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ListViewController;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
    * This fuction is used to send email or sms
    */
    public function sendEmailSms($contact_type, $OTP, $contact_data = []) {
        switch ($contact_type){
            case "email": 
                $email = [
                    'to' => $contact_data['contact_value'],
                    'subject' => 'Verify your email address.',
                    'template_data' => ['name' => Auth::user()->name , 'code' => $OTP , 'email' => $contact_data['contact_value']],
                ];
                sendEmail('verification',$email);
                break;
            case "mobile":
                $sms = [
                    'to' => $contact_data['country_code'].$contact_data['contact_value'],
                    'message' => 'Hi ' . Auth::user()->name . ', ' . $OTP . ' is your OTP for number verification. Do not share OTP for security reasons.'
                ];
                error_log($sms['message']);
                sendSms('verification',$sms);
                break;
        }
    }

    /**
    * This function is used to generate / regenerate OTP for the requested Contact
    */
    public function verifyContactDetails(Request $request) {
        $this->validate($request, [
            'contact_value' => 'required',
            'contact_type'  => 'required',
            // 'object_id'    => 'required|integer',
            'object_type'   => 'required',
        ]);
        
        $user = Auth::user();
        $data = $request->all();
        $data['action'] = 'verify';
        
        if($request->has('resend') && $request->has('id') && $request->resend) { // If 'resend' key exists, then Resend the Same OTP
            $session_otp_data = $request->session()->get('contact#' . $request->id, "[]");

            $array = json_decode($session_otp_data);
            $OTP = $array->OTP;
            $contact = UserCommunication::find($request->id);
            $timestamp = Carbon::now()->timestamp;
        } else { // Else resend new OTP
            $OTP = rand(1000, 9999);
            $contact = $user->saveContactDetails($data, 'job');
            $timestamp = Carbon::now()->timestamp;
        }
        $json = json_encode(array("id" => $contact->id, "OTP" => $OTP, "timestamp" => $timestamp));
        error_log($json); //send sms or email here

        $this->sendEmailSms($request->contact_type, $OTP, $data);
        $request->session()->put('contact#' . $contact->id, $json); // Save / Update OTP data
        
        return response()->json([
                'id' => $contact->id,
                'verify' => $contact->is_verified,
                'value' => $contact->value,
                'OTP' => $OTP
            ]);
    }

    /**
    * This function is used to check if the OTP sent by user is valid or Invalid
    */
    public function verifyContactOtp(Request $request){
        $this->validate($request, [
            'otp' => 'integer|min:1000|max:9999',
            'id'  => 'integer|min:1',
        ]);
        $json = session('contact#' . $request->id);
        if ($json == null) {
            abort(404);
        }

        $array = json_decode($json);
        $old   = Carbon::createFromTimestamp($array->timestamp);
        $now   = Carbon::now();
        if ($now > $old->addMinutes(15)) {
            abort(410);
        }
  
        if ($request->otp == $array->OTP) {
            $contact = UserCommunication::find($request->id);
            $contact->is_verified = 1;
            $contact->save();
            if($contact->object_type == 'App\\User'){
                activity()
                   ->performedOn($contact)
                   ->causedBy(\Auth::user())
                   ->log('contact-verified');
            }
            // dd($request->session);
            $request->session()->forget('contact#' . $request->id);
            return response()->json(array('success' => "1"));

        }
        return response()->json(array('success' => "0"));
    }

    public function deleteContactDetails(Request $request){
        $this->validate($request, [
            'id' => 'required'
        ]);

        $data = $request->all();
        $contactId = $data['id'];

        $userCom = UserCommunication::find($contactId);

        if(!empty($userCom)){
            $userCom->delete();
        }

        return response()->json(
            ['code' => 200, 
             'status' => true]);
    }

    public function downloadResume($resumeId){
        // if(isset($_GET['resume'])){
        //     $file = $_GET['resume'];
        //     $this->getUserResume($file);
        // }
        // else
        //     abort(404);

        $filePath = getUploadFileUrl($resumeId);
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);      
        $mimeType = getFileMimeType($ext);
        $file = Auth::user()->getSingleFile($resumeId);
        $name = 'resume.'.$ext;

        return response($file)
          ->header('Content-Type', $mimeType)
          ->header('Content-Description', 'File Transfer')
          ->header('Content-Disposition', "attachment; filename={$name}")
          ->header('Filename', $name);
        
    }



    // public function getUserResume($doc_url,$download =true){

    //     $source = pathinfo($doc_url); 
    //     $filename = $source['filename'];
    //     $extension = $source['extension'];
    //     $basename = $source['basename'];

    //     $s3 = AWS::createClient('s3');

    //     $getKey = explode('user', $doc_url);

    //     $bucket = env('AWS_BUCKET');
    //     $keyname = 'user'.$getKey[1]; 
    //     $localPath = public_path().'/tmp/'.$basename;
        
    //     if(!File::exists(public_path().'/tmp/')) { 
    //         File::makeDirectory(public_path().'/tmp/', 0777, true);
    //     }
 
    //     // Save object to a file.
    //     $result = $s3->getObject(array(
    //         'Bucket' => $bucket,
    //         'Key'    => $keyname,
    //         'SaveAs' => $localPath
    //     ));

 
    //     if($download){
    //         //NOW comes the action, this statement would say that WHATEVER output given by the script is given in form of an octet-stream, or else to make it easy an application or downloadable
    //         header('Content-type: application/octet-stream');
    //         header('Content-Length: ' . filesize($localPath));
    //         //This would be the one to rename the file
    //         header('Content-Disposition: attachment; filename='.$basename.'');
    //         //clean all levels of output buffering
    //         while (ob_get_level()) {
    //             ob_end_clean();
    //         }
    //         readfile($localPath);


    //         //Remove the local original file once all sizes are generated and uploaded
    //         if (File::exists($localPath)){
    //             File::delete($localPath);
    //         }

    //          exit();
    //     }
    //     else
    //         return $localPath;
 
    // }

    public function getMyListingData($listing_obj){
        try{
            $listing_obj = $listing_obj->orderBy('updated_at', 'desc')->get(['id', 'title', 'status', 'verified', 'type', 'published_on', 'locality_id', 'display_address', 'premium', 'slug', 'updated_at']);
            $listing_obj = $listing_obj->each(function($list){ // Get following data for each list
                    $list["area"] = $list->location()->where('status', 1)->get(["id", "name", "slug", "city_id"])->first(); // Get the Primary area
                    $list["city"] = ($list["area"]) ? $list['area']->city()->get(["id", "name", "slug"])->first() : "";

                    // $list["status"] = Listing::listing_status[$list["status"]]; // Get the string of the Listing Status
                    // $list["business_type"]['name'] = Listing::listing_business_type[$list["type"]]; // Get the string of the Listing Type

                    $list["business_type"] = ['name' => Listing::listing_business_type[$list["type"]], 'slug' => Listing::listing_business_type_slug[$list["type"]]];

                    // Get list of areas under that Listing
                    $areas_operation_id = ListingAreasOfOperation::where("listing_id", $list->id)->pluck('area_id')->toArray();
                    $city_areas = Area::whereIn('id', $areas_operation_id)->get(['id', 'name', 'slug', 'city_id'])->groupBy('city_id');

                    $areas_operation = [];
                    foreach ($city_areas as $city_id => $city_areas) { // Get City & areas that the Listing is under operation
                        array_push($areas_operation, 
                            array("city" => City::where("id", $city_id)->first(['id', 'name', 'slug']),
                            "areas" => $city_areas
                        ));
                    }
                    $list["areas_operation"] = $areas_operation; // Array of cities & areas under that city

                    $recent_update_obj = DB::table('updates')->where([["object_type", "App\Listing"], ['object_id', $list->id], ['deleted_at', null]])->orderBy('updated_at', "desc")->get();
                    $list["recent_updates"] = $recent_update_obj->count() > 0 ? $recent_update_obj->first() : null;

                    // Fetches the list of all the Core categories & it's details
                    $list["cores"] = Category::whereIn('id', ListingCategory::where([['listing_id', $list->id],['core',1]])->pluck('category_id')->toArray())->get(['id', 'name', 'slug', 'level', 'order'])->each(function($cat_obj) {
                            $listViewCont_obj = new ListViewController;

                            $cat_obj["node_categories"] = $listViewCont_obj->getCategoryNodeArray($cat_obj, "slug", false);
                    });

                });
        }catch (Exception $e) {
            return collect([]);
        }
        return $listing_obj;
    }
    public function customerdashboard(){

        $user = Auth::user();
 
        if($user->type != 'external')
            abort(404);

        $jobPosted = $user->jobPosted()->orderBy('created_at','desc')->get();  
        $jobApplication = $user->jobApplications(); 
        $myListingsCount = $user->listing()->count();
        $listings = $this->getMyListingData($user->listing());
        $userResume = $user->getUserJobLastApplication();
        $userDetails = $user->getUserDetails; 
        $jobAlertConfig =  $userDetails->job_alert_config;//dd($jobAlertConfig);
        $setNewAlert = (empty($jobAlertConfig)) ? true :false;
        if(empty($jobAlertConfig) && isset($_GET['job'])){
            $reference_id = $_GET['job'];
            $job = Job::where('reference_id',$reference_id)->first();
            $jobAlertConfig = $user->getJobCriterias($job);
        }
        $sendJobAlerts = $userDetails->send_job_alerts;
        $areas = [];

        if(isset($jobAlertConfig['job_location']) && !empty($jobAlertConfig['job_location'])){
            foreach ($jobAlertConfig['job_location'] as $cityId => $location) {
 
                $areas[$cityId] = Area::where('status', 1)->where('city_id', $cityId)->orderBy('name')->get()->toArray();             
            }
        }

        // dd($jobAlertConfig);

        $salaryRange = salaryRange();
        $cities  = City::where('status', 1)->orderBy('name')->get();

        $job    = new Job;
        $jobTypes  = $job->jobTypes();
        $salaryTypes  = $job->salaryTypes();
        $defaultExperience  = $job->jobExperience();
        $defaultKeywords  = $job->jobKeywords();
        $jobCategories = $job->jobCategories();

        $browserState = (getUserSessionState()) ? getUserSessionState() : getSinglePopularCity()->slug;
        
        return view('users.dashboard') ->with('user', $user)
                                       ->with('salaryRange', $salaryRange)
                                       ->with('cities', $cities)
                                       ->with('areas', $areas)
                                       ->with('userResume', $userResume)
                                       ->with('jobAlertConfig', $jobAlertConfig)
                                       ->with('sendJobAlerts', $sendJobAlerts)
                                       ->with('jobApplication', $jobApplication)
                                       ->with('jobCategories', $jobCategories)
                                        ->with('defaultExperience', $defaultExperience) 
                                        ->with('salaryTypes', $salaryTypes) 
                                        ->with('defaultKeywords', $defaultKeywords) 
                                        ->with('jobTypes', $jobTypes)
                                        ->with('browserState', $browserState)
                                        ->with('myListingsCount', $myListingsCount)
                                        ->with('listing_data', $listings)
                                        ->with('setNewAlert', $setNewAlert)
                                       ->with('jobPosted', $jobPosted);
    }

    public function uploadResume(Request $request){

 
        $user =  Auth::user();
        $data = $request->all(); 
        $resume = (isset($data['resume'])) ? $data['resume'] : [];
 
        if(!empty($resume)){
            $resumeId = $user->uploadUserResume($resume);
             

            $userauth_obj = new UserAuth;
            $request_data['resume_id'] = $resumeId;
            $request_data['resume_updated_on'] =  date('Y-m-d H:i:s');
            $response = $userauth_obj->updateOrCreateUserDetails($user, $request_data, "user_id", $user->id);

        }
  
        Session::flash('success_message','Resume Successfully Updated ');
        
        return redirect()->back();

    }


    public function setJobAlert(Request $request){

        $user =  Auth::user();
        $data = $request->all(); //dd($data);
            
        $criteria=[];
        $criteria['job_type'] =  (isset($data['job_type'])) ? $data['job_type'] :[];
        $criteria['job_type_text']='';
        if(isset($data['job_type']) && !empty($data['job_type']))
            $criteria['job_type_text'] = Defaults::whereIn("id",$data['job_type'])->pluck('label')->toArray();

        $criteria['experience'] = (isset($data['experience'])) ? $data['experience'] :[];
        $criteria['salary_lower'] = $data['salary_lower'];
        $criteria['salary_upper'] = $data['salary_upper'];
        $criteria['salary_type'] =  (isset($data['salary_type'])) ? $data['salary_type'] :0; 

        $criteria['salary_type_text']='';
        if(isset($data['salary_type']) && !empty($data['salary_type']))
            $criteria['salary_type_text'] = Defaults::find($data['salary_type'])->label;

        $criteria['category'] = $data['category'];
        $criteria['category_name']='';
        if(isset($data['category']) && !empty($data['category']))
            $criteria['category_name'] = Category::find($data['category'])->name;

        $criteria['job_keyword'] = $data['job_keyword'];
        $criteria['keywords_id'] = $data['keyword_id'];
        $criteria['keywords'] =  (!empty($data['keyword_id'])) ? array_keys($data['keyword_id']) :[];
        // $criteria['city'] = (!empty($data['job_city'])) ? array_keys($data['job_city']) :[];
        $jobArea  = (!empty($data['job_area'])) ? $data['job_area'] :[];
        $criteria['job_location'] = $jobArea;

        $criteria['area'] = [];
        $criteria['city'] = [];
        $areas = [];
        foreach ($jobArea as $cityId => $areas) { 
            $criteria['city'][] = $cityId;

            foreach ($areas as $key => $area) {
                $criteria['area'][] = $area;
            }
             
        }
        $criteria['city'] = array_unique($criteria['city']);
        $criteria['area'] = array_unique($criteria['area']);

        $sendJobAlerts = (isset($data['send_job_alerts'])) ? true :false;
        $userDetails = $user->getUserDetails;  
        if(!empty($userDetails)){
            $userDetails->job_alert_config = $criteria;
            $userDetails->send_job_alerts = $sendJobAlerts;
            $userDetails->save();
        }
 
  
        Session::flash('success_message','Job Alert Configuaration Successfully Updated');
        
        return redirect(url('customer-dashboard'));
    }
    
    public function removeResume(Request $request){
        $user =  Auth::user();
        $userDetails = $user->getUserDetails; 
        $userDetails->resume_id = null;
        $userDetails->resume_updated_on = null;
        $userDetails->save();

        return response()->json(
            ['code' => 200, 
             'status' => true]);
 

    }

}
