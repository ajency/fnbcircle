<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\UserCommunication;

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

    public function verifyContactDetails(Request $request){
        $this->validate($request, [
            'contact_value' => 'required',
            'contact_type'  => 'required',
            // 'object_id'    => 'required|integer',
            'object_type'    => 'required',
        ]);
        
        $user = Auth::user();
        $data = $request->all();
        $data['action'] = 'verify';
        $contact = $user->saveContactDetails($data,'job');
        $OTP       = rand(1000, 9999);
        $timestamp = Carbon::now()->timestamp;
        $json      = json_encode(array("id" => $contact->id, "OTP" => $OTP, "timestamp" => $timestamp));
        error_log($json); //send sms or email here
        switch ($request->contact_type){
            case "email": 
                $email = [
                    'to' => $data['contact_value'],
                    'subject' => 'Verify your email address.',
                    'template_data' => ['name' => Auth::user()->name , 'code' => $OTP , 'email' => $request->contact_value ],
                ];
                sendEmail('verification',$email);
        }
        $request->session()->put('contact#' . $contact->id, $json);
        
        return response()->json(
            ['id' => $contact->id,
             'verify' => $contact->is_verified,
             'value' => $contact->value,
             'OTP' => $OTP]);
    }

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

}
