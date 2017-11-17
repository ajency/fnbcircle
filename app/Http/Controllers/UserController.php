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

    public function customerdashboard(){
        $user = Auth::user();
        $jobPosted = $user->jobPosted()->get();  
        $jobApplication = $user->jobApplications(); 
        $userResume = $user->getUserJobLastApplication();
 
        return view('users.dashboard') ->with('user', $user)
                                       ->with('userResume', $userResume)
                                       ->with('jobApplication', $jobApplication)
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
