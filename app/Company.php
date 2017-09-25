<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ajency\FileUpload\FileUpload;

class Company extends Model
{
	use FileUpload;
	
    public function getTitleAttribute( $value ) { 
        $value = ucwords( $value );      
        return $value;
    }

    public function companyStatuses(){
    	return ['1'=>'Published','2'=>'Not Published'];
    }

    public Function uploadCompanyLogo($file){
        $id = $this->uploadImage($file);
        $this->remapImages([$id]);

         return $id;
    }


    public Function getCompanyLogo($type){
    	$companyLogoUrl  ='';
        $companyLogo = $this->getImages();
        foreach ($companyLogo as $key => $logo) {
        	$companyLogoUrl = (isset($logo[$type])) ? $logo[$type] : '';
        }
        return $companyLogoUrl;
    }


}
