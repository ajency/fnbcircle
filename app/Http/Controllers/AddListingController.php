<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\ListingCommunication;
class AddListingController extends Controller
{

    public function is_user_authenticated(){
      if (Auth::check()) {
          return True;
      }
      return False;
    }


    //-----------------------------------Step 1-----------------------

    function save_business_information($data){
      //------ save listing details in listing table
      $listing =  new Listing;
      $listing->title = $data->title;
      $listing->type = $data->type;
      $listing->show_primary_phone = $data->primary_phone;
      $listing->show_primary_email = $data->primary_email;
      $listing->status = Listing::DRAFT;
      $listing->slug="";
      $listing->owner_id="1";
      $listing->created_by="1";
      $listing->save();

      //-------- Save contacts details in listing_communication table
      $contacts=json_decode($data->contacts);
      foreach ($contacts as $info) {
        $com= new ListingCommunication;
        $com->listing_id = $listing->id;
        $com->user_communication_id = $info->id;
        $com->verified=$info->verify;
        $com->visible=$info->visible;
        $com->save();
      }
    }
    function validate_business_information($data){
      $this->validate($data, [
          'title' => 'required|max:255',
          'type' => 'required|integer|between:11,13',
          'primary_email' => 'required|boolean',
          'primary_phone' => 'required|boolean',
          'contacts' => 'json|contacts',
      ]);
    }
    function business_information($request){
        $this->validate_business_information($request);
        $this->save_business_information($request);
    }


    //---------------------------step 2 ----------------------------------------

    function validate_business_categories($data){
      $this->validate($data, [
          'listing_id' => 'required|integer|min:1',
          'categories' => 'required|id_json|not_empty_json',
          'core' => 'required|id_json|not_empty_json',
          'brands' => 'id_json',
      ]);
    }

    function business_categories($request){
        $this->validate_business_categories($request);
        // $this->save_business_categories($request);
    }


    public function store(Request $request){
      // if($this->is_user_authenticated()){
      if(True){
        $this->validate($request, [
            'step' => 'required|integer|min:1|max:6',
        ]);
        $data = $request->all();
        switch ($data['step']) {
          case 1:
            $this->business_information($request);
            break;
          case 2:
            $this->business_categories($request);
            break;

          default:
            # code...
            break;
        }
      }
    }
}
