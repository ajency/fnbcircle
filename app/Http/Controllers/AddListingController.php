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
    function save_business_information($data){
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
          'contacts' => 'contacts|json',
      ]);
      // $contacts=json_decode($data->contacts);
      // foreach ($contacts as $info) {
      //   //info->id = integer
      //   if(!is_numeric($info->id) or strpos($info->id, '.') == true) abort(400,"BAD REQUEST");
      //   //info->verify = boolean
      //   if($info->verify!=="1" and $info->verify!=="0") abort(400,"BAD REQUEST");
      //   //info->visible = boolean
      //   if($info->visible!=="1" and $info->visible!=="0") abort(400,"BAD REQUEST");
      // }
    }
    function business_information($request){
        $this->validate_business_information($request);
        $this->save_business_information($request);
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

          default:
            # code...
            break;
        }
      }
    }
}
