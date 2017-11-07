<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Hash;

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
            $user = User::findUsingEmail($email);
            $self = false;
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
        request()->session()->flash('success', 'Password changed!');

        return  \Redirect::back();
    }
}
