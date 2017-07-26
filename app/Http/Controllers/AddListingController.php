<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\ListingCommunication;
use Validator;
use App\ListingCategory;
use App\ListingBrand;
use App\Common;

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
      //-------- Save contacts details in listing_communication table
      $contacts=json_decode($data->contacts);
      foreach ($contacts as $info) {
        if(Common::verify_id($info->id,'user_communication')) abort(400, 'Contact id is fabricated. Id doesnt exist');
      }
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

      $categ=json_decode($data->categories);
      foreach($categ as $category){
        if(Common::verify_id($category->id,'categories')) abort(400, 'Category id is fabricated. Id doesnt exist');
      }
      $allcores = json_decode($request->core);
      foreach ($allcores as $core) {
        if(Common::verify_id($core->id,'categories')) abort(400, 'Category id is fabricated. Id doesnt exist');
      }
      $brands=json_decode($request->brands);
      foreach ($brands as $brand) {
        if(Common::verify_id($brand->id,'brands')) abort(400, 'Brand id is fabricated. Id doesnt exist');
      }
    }
    function save_business_categories($listing_id,$categories,$brands){
        ListingCategory::where('listing_id',$listing_id)->delete();
        foreach ($categories as $id => $core) {
            $category= new ListingCategory;
            $category->listing_id = $listing_id;
            $category->category_id = $id;
            $category->core=$core;
            $category->save();
        }
        ListingBrand::where('listing_id',$listing_id)->delete();
        foreach ($brands as $brand) {
          $row = new ListingBrand;
          $row->listing_id = $listing_id;
          $row->brand_id = $brand->id;
          $row->save();
        }
    }
    function business_categories($request){
        $this->validate_business_categories($request);

        $categories = array();
        $categ=json_decode($request->categories);
        foreach($categ as $category){
          $categories[$category->id]=0;
        }
        $allcores = json_decode($request->core);
        foreach ($allcores as $core) {
           $categories[$core->id]=1;
        }
        $brands=json_decode($request->brands);


        $this->save_business_categories($request->listing_id,$categories,$brands);
    }

    //------------------------step 3 --------------------

    function validate_loaction_operation_hours($data){
      $this->validate($data, [
          'listing_id'  => 'required|integer|min:1',
          'area_id'     => 'required|integer|min:1',
          'latitude'    => 'numeric',
          'longitude'   => 'numeric',
          'address'     => 'max:255',
          'display_hours'=> 'nullable|boolean',
          'operation_areas'=> 'nullable|json|id_json',
          'operation_time' => 'json|week_time',
      ]);
      if(Common::verify_id($area->id,'areas')) abort(400, 'Area id is fabricated. Id doesnt exist');
    }

    function loaction_operation_hours($request){
        $this->validate_loaction_operation_hours($request);
    }


    //--------------------Common method ------------------------
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
          case 3:
            $this->loaction_operation_hours($request);

          default:
            # code...
            break;
        }
      }
    }
}
