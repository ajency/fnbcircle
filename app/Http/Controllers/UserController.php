<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

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
            'object_id'    => 'required|integer',
            'object_type'    => 'required',
        ]);
        
        $user = Auth::user();
        $data = $request->all();
        $contact = $user->saveContactDetails($data,'job');
        $OTP       = rand(1000, 9999);
        $timestamp = Carbon::now()->timestamp;
        $json      = json_encode(array("id" => $contact->id, "OTP" => $OTP, "timestamp" => $timestamp));
        error_log($json); //send sms or email here
        $request->session()->put('contact#' . $contact->id, $json);
        return response()->json(array('id' => $contact->id, 'verify' => $contact->is_verified, 'value' => $contact->value, 'OTP' => $OTP));
    }
}
