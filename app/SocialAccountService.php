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

    public function check_if_user_exists($data, $getObject=false) {
        $comm = '';

        if (isset($data["email"])) {
            $comm = UserCommunication::where('value','=',$data['email'])->first(); // Check if this email ID exist in the User Communication DB
        } else if (isset($data["contact"])) {
            $comm = UserCommunication::where('value','=',$data['contact'])->first(); // Check if this Contact No (Phone No / Landline) exist in the User Communication DB
        } else {
            $comm = User::where('email', '=', $data['username'])->first(); // Check if this Username exist in the User DB
        }

        if($comm) {
            $exist = true;
        } else {
            $exist = false;
        }

        if ($getObject) { // Pass the User object & Boolean Status
            return array("data" => $comm, "status" => $exist);
        } else { // Pass Boolean Status
            return $exist;
        }
    }

    public function getOrCreateUser($data) {

        $output = new ConsoleOutput();
        $object = $this->check_if_user_exists($data, true); // Check if the EMail ID exist
        $status = "exist";

        $status_active_provider = ["google", "facebook"];

        if (!$object["status"]) { // if the email & info is not present in the list, then create new
            $user = new User;
            $user->name = $data["name"];
            $user->email = $data["username"];
            $user->password = $data["password"];
            $user->signup_source = $data['provider'];
            $user->status = in_array($data["provider"], $status_active_provider) ? "active" : "inactive"; // If provider is in the List, then activate, else Inactive
            $user->save();

            if (isset($data['email']) || isset($data['contact'])) { // If contact or Email is defined in the plugin, then mark this fields as 'True' as this is User's 1st contact
                $types = [];

                (isset($data['email']) && $data['email']) ? array_push($types, 'email') : '';// If email field exist & the value is not NULL
                (isset($data['contact']) && $data['contact']) ? array_push($types, 'contact') : '';// If contact field exist & the value is not NULL

                foreach ($types as $key => $type) { // Loop through Communication types
                    $comm = new UserCommunication;
                    $comm->object_id = $user->id;
                    $comm->object_type = 'user';

                    $comm->type = $type;
                    $comm->value = $data[$type];
                    
                    $comm->is_primary = true;
                    $comm->is_communication = true;
                    $comm->is_verified = true;
                    $comm->is_visible = true;
        
                    $comm->save();
                }
            }

            $status = "present";
        } else { // This email exist
            $user = User::find($object["data"]->object_id);

            if ($user->signup_source !== $data['provider']) {
                $status = "different";
            }
        }

        return array($user, $status);
    }
}