<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\ListingCommunication;
use Validator;
use App\ListingCategory;
use App\ListingHighlight;
use App\ListingBrand;
use App\ListingAreasOfOperation;
use App\ListingOperationTime;
use App\Common;

class AddListingController extends Controller
{

    public function is_user_authenticated($listing_id=0){
      if (Auth::check()) {
          return True;
      }
      return False;
    }


    //-----------------------------------Step 1-----------------------

    function save_business_information($data){
      //------ save listing details in listing table
      $listing =  new Listing;
      $listing->title = title_case($data->title);
      $listing->type = $data->type;
      $listing->show_primary_phone = $data->primary_phone;
      $listing->show_primary_email = $data->primary_email;
      $listing->status = Listing::DRAFT;
      // $listing->slug=str_slug($data->title.' '.str_random(7),'-');
      $listing->owner_id="1";
      $listing->created_by="1";
      $listing->save();

      //-------- Save contacts details in listing_communication table
      $contacts_json=json_decode($data->contacts);
      $contacts=array();
      foreach ($contacts_json as $contact) {
        $contacts[$contact->id]=array('verified'=>$contact->verify,'visible'=>$contact->visible);
      }
      ListingCommunication::where('listing_id',$listing->id)->delete();
      foreach ($contacts as $contact=>$info) {
        $com= new ListingCommunication;
        $com->listing_id = $listing->id;
        $com->user_communication_id = $contact;
        $com->verified=$info['verified'];
        $com->visible=$info['visible'];
        $com->save();
      }
    }
    function validate_business_information($data){
      $this->validate($data, [
          'title' => 'required|max:255',
          'type' => 'required|integer|between:11,13',
          'primary_email' => 'required|boolean',
          'primary_phone' => 'required|boolean',
          'contacts' => 'required|json|contacts',
      ]);
      //-------- Save contacts details in listing_communication table
      $contacts=json_decode($data->contacts);
      foreach ($contacts as $info) {
        if(!Common::verify_id($info->id,'user_communication')) return \Redirect::back()->withErrors(array('wrong_step'=>'Contact id is fabricated. Id doesnt exist'));//abort(400, 'Contact id is fabricated. Id doesnt exist');
      }
      return true;
    }
    function business_information($request){
        $check=$this->validate_business_information($request);
        if($check!==true) return $check;
        $this->save_business_information($request);
    }


    //---------------------------step 2 ----------------------------------------

    function validate_business_categories($data){
      $this->validate($data, [
          'listing_id' => 'required|integer|min:1',
          'categories' => 'required|id_json|not_empty_json',
          'core' => 'required|id_json|not_empty_json',
          'brands' => 'required|id_json',
      ]);
      if(!Common::verify_id($data->listing_id,'listings')) return \Redirect::back()->withErrors(array('wrong_step'=>'Listing id is fabricated. Id doesnt exist'));//abort(400, 'Listing id is fabricated. Id doesnt exist');
      $categ=json_decode($data->categories);
      foreach($categ as $category){
        if(!Common::verify_id($category->id,'categories')) return \Redirect::back()->withErrors(array('wrong_step'=>'Category id is fabricated. Id doesnt exist'));//abort(400, 'Category id is fabricated. Id doesnt exist');
      }
      $allcores = json_decode($data->core);
      foreach ($allcores as $core) {
        if(!Common::verify_id($core->id,'categories')) return \Redirect::back()->withErrors(array('wrong_step'=>'Category id is fabricated. Id doesnt exist'));//abort(400, 'Category id is fabricated. Id doesnt exist');
      }
      $brands=json_decode($data->brands);
      foreach ($brands as $brand) {
        if(!Common::verify_id($brand->id,'brands')) return \Redirect::back()->withErrors(array('wrong_step'=>'Brand id is fabricated. Id doesnt exist'));//abort(400, 'Brand id is fabricated. Id doesnt exist');
      }
      return true;
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
        $check = $this->validate_business_categories($request);
        if($check!==true) return $check;

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
          'latitude'    => 'required|numeric|min:0|max:90',
          'longitude'   => 'required|numeric|min:0|max:180',
          'address'     => 'required|max:255',
          'display_hours'=> 'required|nullable|boolean',
          'operation_areas'=> 'required|json|id_json',
          'operation_time' => 'required|json|week_time',
      ]);
      if(!Common::verify_id($data->listing_id,'listings')) return \Redirect::back()->withErrors(array('wrong_step'=>'Listing id is fabricated. Id doesnt exist'));//abort(400, 'Listing id is fabricated. Id doesnt exist');
      if(!Common::verify_id($data->area_id,'areas')) return \Redirect::back()->withErrors(array('wrong_step'=>'Area id is fabricated. Id doesnt exist'));//abort(400, 'Area id is fabricated. Id doesnt exist');
      $areas=json_decode($data->operation_areas);
      foreach ($areas as $area) {
        if(!Common::verify_id($area->id,'areas')) return \Redirect::back()->withErrors(array('wrong_step'=>'Area id is fabricated. Id doesnt exist'));//abort(400, 'Area id is fabricated. Id doesnt exist');
      }
      return true;
    }
    function save_loaction_operation_hours($data){
        $listing=Listing::find($data->listing_id);
        $listing->locality_id=$data->area_id;
        $listing->latitude=$data->latitude;
        $listing->longitude=$data->longitude;
        $listing->display_address=$data->address;
        $listing->show_hours_of_operation=$data->display_hours;
        $areas_json=json_decode($data->operation_areas);
        ListingAreasOfOperation::where('listing_id',$data->listing_id)->delete();
        $areas=array();
        foreach ($areas_json as $area) {
          $areas[$area->id]=1;
        }
        foreach ($areas as  $area => $nil) {
            $operation= new ListingAreasOfOperation;
            $operation->listing_id = $data->listing_id;
            $operation->area_id = $area;
            $operation->save();
        }
        $hours=json_decode($data->operation_time);
        ListingOperationTime::where('listing_id',$data->listing_id)->delete();
        foreach ($hours as $day => $time) {
            $operation= new ListingOperationTime;
            $operation->listing_id = $data->listing_id;
            $operation->day_of_week = $day;
            $operation->from=$time->from;
            $operation->to=$time->to;
            $operation->closed=$time->closed;
            $operation->open24=$time->open24;
            $operation->save();
        }
        $listing->save();
    }
    function loaction_operation_hours($request){
        $check=$this->validate_loaction_operation_hours($request);
        if($check!==true) return $check;
        $this->save_loaction_operation_hours($request);
    }
    //--------------------------step 4 ----------------------------------------
    function validate_business_details($data){
      $this->validate($data, [
          'listing_id' => 'required|integer|min:1',
          'description'=> 'required|max:65535 ',
          'highlights' => 'required',
          'established' => 'nullable|numeric',
          'website' => 'nullable|active_url',
          'payment.*'=>'required|boolean',
      ]);
      if(!Common::verify_id($data->listing_id,'listings'))  return \Redirect::back()->withErrors(array('wrong_step'=>'Listing id is fabricated. Id doesnt exist'));
      return true;
    }
    function save_business_details($data){
        $listing=Listing::find($data->listing_id);
        $listing->description = $data->description;
        ListingHighlight::where('listing_id',$data->listing_id)->delete();
        foreach ($data->highlights as $key => $highlight) {
          if(!empty($highlight)){
            $entry = new ListingHighlight;
            $entry->listing_id = $data->listing_id;
            $entry->highlight_id = $key;
            $entry->highlight = $highlight;
            $entry->save();
          }
        }
        $other=array();
        if(isset($data->established) and !empty($data->established)) $other['established']=$data->established;
        if(isset($data->website) and !empty($data->website)) $other['website']=$data->website;
        $other=json_encode($other);
        $listing->other_details=$other;
        foreach ($data->payment as $key => $value) {
          if(!isset($payment)){
            if($value==1) $payment=$key;
          }else{
            if($value==1) $payment.=', '.$key;
          }
        }
        if(isset($payment))$listing->payment_modes = $payment;
        $listing->save();
    }

    function business_details($request){
      $check = $this->validate_business_details($request);
      if($check!==true) return $check;
      $this->save_business_details($request);
    }
    //----------------------------step 5------------------------------
    function validate_photos_documents($data){
      $this->validate($data, [
          'listing_id' => 'required|integer|min:1',
          'photos'  => 'required|photo_json',
          'documents'=>'required|doc_json',
      ]);
      if(!Common::verify_id($data->listing_id,'listings'))  return \Redirect::back()->withErrors(array('wrong_step'=>'Listing id is fabricated. Id doesnt exist'));
      return true;
    }
    function save_photos_documents($data){
      $listing=Listing::find($data->listing_id);
      $listing->photos=$data->photos;
      $listing->documents=$data->documents;
      $listing->save();
    }
    function photos_documents($request){
      $check = $this->validate_photos_documents($request);
      if($check!==true) return $check;
      $this->save_photos_documents($request);
    }

    //--------------------Common method ------------------------
    public function store(Request $request){
      // if($this->is_user_authenticated()){
      if(True){
        $this->validate($request, [
            'step' => 'required',
        ]);
        $data = $request->all();
        switch ($data['step']) {
          case 'business_information':
            return $this->business_information($request);
            break;
          case 'business_categories':
            return $this->business_categories($request);
            break;
          case 'location_operation_hours':
            return $this->loaction_operation_hours($request);
            break;
          case 'business_details':
            return $this->business_details($request);
            break;
          case 'photos_documents':
            return $this->photos_documents($request);
            break;
          default:
            return \Redirect::back()->withErrors(array('wrong_step'=>'Something went wrong. Please try again'));
            break;
        }
      }
    }
}
