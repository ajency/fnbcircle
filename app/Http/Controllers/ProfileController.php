<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Hash;
use App\UserCommunication;

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
            $usercomm = UserCommunication::where('value',$email)->where('object_type','App\\User')->where('is_primary',1)->first();
            if($usercomm!=null and hasAccess('view_profile_element_cls',$usercomm->id,'communication')){
                $user = User::findUsingEmail($email);
                $self = false;    
            }else{
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
                if($data['phone'] == null) $data['phone'] = ['contact' => '', 'contact_region' => '91', 'is_verified'=>0];
                $data['password'] = ($user->signup_source != 'google' and $user->signup_source != 'facebook')? true:false;
                return view('profile.basic-details')->with('data', $template)->with('details', $data)->with('self', $self);
            default:
                abort(404);
        }

    }

    public function changePassword()
    {
        $this->validate(request(), [
            'old_password' => 'required|current_password',
            'new_password'     => 'required|string|min:6|confirmed',
        ]);

        request()->user()->fill([
            'password' => Hash::make(request()->input('new_password')),
        ])->save();
        request()->session()->flash('passwordChange', 'Password changed!');

        return  \Redirect::back();
    }

    public function changePhone()
    {
    	$req = request()->all();

        $user = Auth::user();
        $user->name = $req['username'];
        $user->save();
        $comm_obj = UserCommunication::where('object_type','App\\User')->where('object_id',Auth::user()->id)->where('type','mobile')->where('is_primary',1)->first();
        if($comm_obj==null or $comm_obj->is_verified == 0){
        	UserCommunication::where('id','!=',$req['contact_mobile_id'])->where('object_type','App\\User')->where('object_id',Auth::user()->id)->where('type','mobile')->delete();
        	if($req['contact_mobile_id']==''){
        		$comm = New UserCommunication;
        	}else{
        		$comm = UserCommunication::find($req['contact_mobile_id']);
        	}
        	if($req['contactNumber'] !=""){
        		$comm->type = 'mobile';
        		$comm->object_type = 'App\\User';
        		$comm->object_id = Auth::user()->id;
        		$comm->value = $req['contactNumber'];
        		$comm->country_code = $req['contact_country_code'][0];
        		$comm->is_primary = 1;
        		$comm->is_communication = 1;
        		// $comm->is_verified = 0;
        		// $comm->is_visible = 0;
        		$comm->save();
        	}
        }
    	return  \Redirect::back();
    }
}
