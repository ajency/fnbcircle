<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;

use Illuminate\Support\Facades\Hash;
use App\Organization;
use App\UserCommunication;
use Symfony\Component\Console\Output\ConsoleOutput;

class SocialAccountService {
    public function getSocialData(ProviderUser $providerUser, $provider) {
        $response_data = array("username" => ((string)$providerUser->id).'@fnb'.strtolower($provider).".in", "name" => $providerUser->name, "email" => $providerUser->email, "password" => Hash::make(str_random(10)), "provider" => $provider);

        if (property_exists($providerUser, "contact")) {//(isset($providerUser["contact"]))
            $response_data["contact"] = $providerUser->contact;
        }

        return $response_data;
    }

    public function check_if_user_exists($data, $getObject) {
        $comm = UserCommunication::where('value','=',$data['email'])->first();

        if($comm) {
            $exist = true;
        } else {
            $exist = false;
        }

        if ($getObject) {
            return array($comm, $exist);
        } else {
            return $exist;
        }
    }

    public function getOrCreateUser($data) {

        $output = new ConsoleOutput();
        $object = $this->check_if_user_exists($data, true); // Check if the EMail ID exist
        $status = "exist";

        if (!$object[1]) { // if the email & info is not present in the list, then create new
            $user = new User;
            $user->name = $data["name"];
            $user->email = $data["username"];
            $user->password = $data["password"];
            $user->signup_source = $data['provider'];
            $user->save();

            if (isset($data['email'])) {
                $comm = new UserCommunication;
                $comm->object_id = $user->id;
                $comm->object_type = '';
                $comm->type = "email";
                $comm->value = $data['email'];
            } else if (isset($data['contact'])) {
                $comm = new UserCommunication;
                $comm->object_id = $user->id;
                $comm->object_type = '';
                $comm->type = "mobile";
                $comm->value = $data['contact'];
            }
            
            if (isset($data['email']) || isset($data['contact'])) { // If contact or Email is defined in the plugin, then mark this fields as 'True' as this is User's 1st contact
                $comm->is_primary = true;
                $comm->is_communication = true;
                $comm->is_verified = true;
                $comm->is_visible = true;
    
                $comm->save();
            }

            $status = "present";
        } else { // This email exist
            $user = User::find($object[0]->object_id);

            if ($user->signup_source !== $data['provider']) {
                $status = "different";
            }
        }

        return array($user, $status);
    }
}