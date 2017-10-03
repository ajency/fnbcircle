<?php

use Carbon\Carbon;

function getOperationTime($info=null,$type= "from",$diff=30){
	$time = null;
	if($info != null and !empty($info)) {
		if($type == 'from') $time = substr($info->from,0,5);
		if($type == 'to') $time = substr($info->to,0,5);
		if($info->open24 == "1") $time = "open24";
		if($info->closed == '1') $time = "closed";
		// echo $time;
	}
	$day = new Carbon('yesterday');
	$end = new Carbon('today');
	if($time == 'open24') $html='<option selected value="open24">Open 24 hours</option>';
	else $html='<option value="open24">Open 24 hours</option>';
	if($time=='closed') $html.='<option selected value="closed" hidden>Closed</option>';
	else $html.='<option value="closed" hidden>Closed</option>';
	while($day < $end){
		if($time == $day->format('H:i') )$html.='<option selected >'.$day->format('H:i').'</option>';
		else $html.='<option>'.$day->format('H:i').'</option>';
		$day=$day->addMinutes($diff);
	}
	if($type == 'to'){
		if ($time == '24:00') $html.='<option selected>24:00</option>';
		else $html.='<option>24:00</option>';
	} 
		
	echo $html;
}

/***
generates unique slug for the modal
incase if duplicates found appends slug with - count
***/
function getUniqueSlug(\Illuminate\Database\Eloquent\Model $model, $value)
{
    $slug = \Illuminate\Support\Str::slug($value);
    $slugCount = count($model->whereRaw("slug REGEXP '^{$slug}(-[0-9]+)?$' and id != '{$model->id}'")->get());

    return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
}


/***
generates unique refernce id for the modal
***/

function generateRefernceId(\Illuminate\Database\Eloquent\Model $model, $refernceKey, $length=8)
{
   $refernceId = str_random($length);

   $record = $model->where([$refernceKey=> $refernceId])->first();

   if(empty($record)){
      $result = $refernceId;
   }else{
      $result = $this->generateRefernceId($model, $refernceKey,$length);
   }

   return $result;

}


/**
* This function can be called in blade to generate the HTML required.
* This function @return
* [
*	array("html" => "", "title" => "", "content" => ""),
* 	....
* ]
* 
* Note: If a new content is to be generated, please refer config/helper_generate_html_config.php
*/
function generateHTML($reference) {
	$config_content = config("helper_generate_html_config." . $reference);
	$response_html = [];
	
	foreach ($config_content as $key => $value) {
		$temp_html = [];
		if($value["type"] == "checkbox") {
			if(!auth()->guest()) {
				$userDetailsObj = auth()->user()->getUserDetails()->first();
			} else {
				$userDetailsObj = null;
			}

			if(!auth()->guest() && $userDetailsObj && $userDetailsObj->subtype && in_array($value["value"], unserialize($userDetailsObj->subtype))) { // If logged in & has userDetails & has atleast 1 option in array
				$temp_html["html"] = "<input type=\"checkbox\" class=\"" . $value["css_classes"] . "\" for=\"" . $value["for"] . "\" name=\"" . $value["name"] . "\" value=\"" . $value["value"] . "\" checked=\"true\"/>";
			} else {
				$temp_html["html"] = "<input type=\"checkbox\" class=\"" . $value["css_classes"] . "\" for=\"" . $value["for"] . "\" name=\"" . $value["name"] . "\" value=\"" . $value["value"] . "\"/>";
			}
		}

		if(isset($value["title"])) {
			$temp_html["title"] = $value["title"];
		}

		if(isset($value["content"])) {
			$temp_html["content"] = $value["content"];
		}

		array_push($response_html, $temp_html);
	}

	return $response_html;
}


/***
breaks the array data by the given limit
"array"  will contain limited array values 
"moreArray"  will contain remaining array values 
"moreArrayCount" will conatin count of remaing values
eg: $a = [1,2,3,4,5,6]
splitJobArrayData($a,3)
$data['array'] = [1,2,3]
$data['moreArray'] = [4,5,6]
$data['moreArrayCount'] = 3 
***/
function splitJobArrayData($array,$limit){	 
    $arrayCount = count($array);
    $limitedArray = ($arrayCount > $limit) ? array_splice($array,0,$limit) : $array;
    $moreArray = $array;
    $data['array'] = $limitedArray;
    $data['moreArray'] = $moreArray;
    $data['moreArrayCount'] = $arrayCount - count($limitedArray);

    return $data;

}

/**
get refernce id from the slug generated
refernce id will be the last value in slug  diffrenciated by "-"
**/
function getReferenceIdFromSlug($slug){

        $slugArray = explode("-", $slug);
        return  end($slugArray);;
}

/**
replace "-" with " " while displaying breadcrumb
**/
function breadCrumbText($text){
	$text = str_replace("/", " ", $text);
	return ucwords($text);
}

/**
get values from defaults table
pass type of that need to be retrived
arrayType :
1 : return object
2 : key value [id=>value]
3 : data array with key as id
**/
function getDefaultValues($type, $arrayType=1){
	$defaults = App\Defaults::where("type",$type)->get();
	$defaultValues = [];
	if(!empty($defaults))
	{
		if($arrayType == 2){
	    	foreach ($defaults as $key => $default) {
	    		$defaultValues[$default->id] = $default->label;
	    	}
		}
		elseif($arrayType == 3){
	    	foreach ($defaults as $key => $default) {
	    		$defaultValues[$default->id] = ['label' => $default->label,'meta_data' => $default->meta_data];
	    	}
		}
		else{
			$defaultValues = $defaults;
		}
	}

	return $defaultValues;
}


function getCommunicationContactDetail($objectId,$objectType,$type){
    $commObjs = App\UserCommunication::where(['object_type'=>$objectType,'object_id'=>$objectId,'type'=>$type])->get();
    
    $contactInfo = [];
    if(!empty($commObjs)){
        foreach ($commObjs as $key => $commObj) {
            $contactInfo[] = ['id'=>$commObj->id,$type =>$commObj->value,'country_code' =>$commObj->country_code,'visible'=>$commObj->is_visible,'verified'=>$commObj->is_verified];
        }
         
    }

    return $contactInfo;
}

function isAdmin()
{
    $roleId = App\Role::where('name','superadmin')->first()->id;
    if(Auth::check() && Auth::user()->role_id==$roleId)
    {
        return true;
    }
    else
    {
        return false;
    }
}
 

function moneyFormatIndia($amount){
    $num = floatval($amount);
    $splitNum = explode('.', $amount);
    $num = $splitNum[0];
    $decimalValue = (isset($splitNum[1]))? '.'.$splitNum[1] : '';


    $explrestunits = "" ;
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash.$decimalValue; // writes the final format where $currency is the currency symbol.
}

function salarayTypeText($type){
   $salaryTpes = ['Annually'=>'per annum' ,'Monthly'=>'per month', 'Daily'=>'per day','Hourly'=>'per hour']  ;

   return $salaryTpes[$type];
}


