<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use App\Defaults;
// use AjComm;


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


function getCommunicationContactDetail($objectId,$objectType,$type,$mode='edit'){
	if($mode == 'edit')
    	$commObjs = App\UserCommunication::where(['object_type'=>$objectType,'object_id'=>$objectId,'type'=>$type])->get();
   	else
   		$commObjs = App\UserCommunication::where(['object_type'=>$objectType,'object_id'=>$objectId,'type'=>$type,'is_visible'=>1])->get();
    
    $contactInfo = [];
    if(!empty($commObjs)){
        foreach ($commObjs as $key => $commObj) {
            $contactInfo[] = ['id'=>$commObj->id,$type =>$commObj->value,'country_code' =>$commObj->country_code,'visible'=>$commObj->is_visible,'verified'=>$commObj->is_verified];
        }
         
    }

    return $contactInfo;
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
 
function getCities(){
	$cities  = App\City::where('status', 1)->orderBy('name')->get();

	return $cities;
}
 
/**
* This function will return DOM for the pagination
* This function will @return
* 	$html = < page 1 > | < page 2 > | ....... | < page n >
*
* Note: If the main page is loaded via AJAX, it is advisable to render from ServerSide i.e. from Controller,
*		else you can use in blade via {!! pagination(<param1>, <param2>, <param3>) !!}
*/
 
function pagination($totalRecords,$currentPage,$limit){

	$currentPage = (!$currentPage) ? 1 : $currentPage;
	$totalPages = intVal(ceil($totalRecords/$limit)); 
	$next = false;
	$previous = false;
	$html = '';
	$endCounterValue = ($currentPage >= 5 ) ? 5 : 10 - $currentPage;

	if($totalPages > 1) {

		if($currentPage > 4) {
			$previous = true;
			$startPage = $currentPage - 4;
		} else
			$startPage = 1;
		 
		if(($currentPage + $endCounterValue) < $totalPages){
			$next = true;
			$endPage = $currentPage + $endCounterValue;
		} else
			$endPage = $currentPage + ($totalPages-$currentPage);

		$html = View::make('pagination')->with(compact('previous', 'next', 'currentPage', 'startPage', 'endPage'))->render();
 
		/*if($previous)
			$html .= '<a href="javascript:void(0)" class="paginate previous" page="'.($startPage-1).'">previous</a> | ';

		for ($i=$startPage; $i <= $endPage; $i++) { 
			$active = ($i == $currentPage) ? 'active' : '';
			$html .= '<a href="javascript:void(0)" class="paginate page '.$active.'" page="'.($i).'">'.$i.'</a>';

			if($i !== $endPage) {
				$html .= ' | ';
			}
		}

		if($next)
			$html .= '| <a href="javascript:void(0)" class="paginate next" page="' . ($endPage + 1) . '">next</a>';*/
	}

	return $html;
}

 
function salaryRange(){
	$range = [	'5'=>['min' => 0,
					'max' => 300000000
					],

				'6'=>['min' => 0,
					'max' => 25000000
					],

				'7'=>['min' => 0,
					'max' => 822000
					],

				'8'=>['min' => 0,
					'max' => 34500
					]

			];
	return  $range;
} 

function getUploadFileUrl($id){
	$url = '';
	if(!empty($id)){
		$fileUrl = \DB::select('select url  from  fileupload_files where id ='.$id);
	
		if(!empty($fileUrl)){
			$url = $fileUrl[0]->url;
		}
	}
	
	 return $url;
}
 
/**
* This function is used to get Popular city object that will be used in Every page dropdown -> Header page
* This function will @return
*	Filtered <City_obj> which has "is_popular_city" applied & ordered by "order"
*/
function getPopularCities() {
	return App\City::where('is_popular_city', 1)->orderBy('order', 'asc')->get();
}

function getSinglePopularCity() {
	return App\City::where('is_popular_city', 1)->orderBy('order', 'asc')->first();
}

/**
* This function is used to generate URL from city_name & 1 or more slugs
* This function will @return
*	url => /<city>/<slug1>/<slug2>/.......
*/
function generateUrl($city, $slug, $slug_extra = []) {

	//str_slug('Laravel 5 Framework', '-');

	$url = "/" . $city . "/" . $slug;
	if(sizeof($slug_extra) > 0) {
		foreach ($slug_extra as $slug_key => $slug_value) {
			$url .= "/" . str_slug($slug_value, '-');
		}
	}
 
	return $url;
}

 
/**
* This function is used to send email for each event
* This function will send an email to given recipients
* @param data can contain the following extra parameters
*	@param template_data
*	@param to 
*	@param cc
*	@param bcc
*	@param from
*	@param name
* 	@param subject
*	@param attach - An Array of arrays each containing the following parameters:
*			@param file - base64 encoded raw file
*			@param as - filename to be given to the attachment
*			@param mime - mime of the attachment
*/
function sendEmail($event='new-user', $data=[]) {
	$email = new \Ajency\Comm\Models\EmailRecipient();
	$from = (isset($data['from']))? $data['from']:config('tempconfig.email.defaultID');
	$name = (isset($data['name']))? $data['name']:config('tempconfig.email.defaultName');
	$email->setFrom($from, $name);
	if(!isset($data['to']) ) $data['to']= [];
	// 	return false;
	$email->setTo($data['to']);
	$cc = (isset($data['cc']))? $data['cc']:[];
	if(!is_array($cc)) $cc = [$cc];
	$notify = Defaults::where('type','email_notification')->pluck('label')->toArray();
	if(in_array($event, $notify)){
		$notify_data = json_decode(Defaults::where('type','email_notification')->where('label',$event)->pluck('meta_data')->first())->value; 
		$cc = array_merge($cc,$notify_data);
	}
	$email->setCc($cc);
	if(isset($data['bcc'])) $email->setCc($data['bcc']);
	$params = (isset($data['template_data']))? $data['template_data']:[];
	if(!is_array($params)) $params = [$params];
	$params['email_subject'] = (isset($data['subject']))? $data['subject']:"";
 
	$email->setParams($params);

	if(isset($data['attach'])) $email->setAttachments($data['attach']);

	$notify = new \Ajency\Comm\Communication\Notification();
    $notify->setEvent($event);
    $notify->setRecipientIds([$email]); 
    // $notify->setRecipientIds([$email,$email1]);
    AjComm::sendNotification($notify);

}

/**
* This function is used to send sms for each event
* This function will send an sms to given recipients
* @param data can contain the following extra parameters
*	@param to - array
* 	@param message - string
* @param override
*/
function sendSms($event='new-user', $data=[], $override = false) {
	if(!isset($data['to'])) return false;
	if(!is_array($data['to'])) $data['to'] = [$data['to']];
	if(!isset($data['message'])) return false;
	$sms = new \Ajency\Comm\Models\SmsRecipient();
    $sms->setTo($data['to']);
    $sms->setMessage($data['message']);
    if($override) $sms->setOverride(true);
    $notify = new \Ajency\Comm\Communication\Notification();
    $notify->setEvent($event);
    $notify->setRecipientIds([$sms]);
    AjComm::sendNotification($notify);
 
}


function generateJobListUrl($params,$urlCity,$userObj){

	if($userObj){
		$userDetails = $userObj->getUserDetails;
		$urlCity = App\City::find($userDetails->city)->slug;

	}
	$stateCity = [];
	$url = url($urlCity.'/job-listings?');

	if(isset($params['state'])){
		$state = App\City::find($params['state']);
		$url .='&state='.$state->slug;
		$stateCity['city_name'] = $state->name;

		if(isset($params['job_location'][$params['state']]) ){
			$areaIds = $params['job_location'][$params['state']];
			$areas = App\Area::whereIn('id',$areaIds)->get();
			$url .='&area=[';
			$areaNames = [];
			foreach ($areas as $key => $area) {
				$areaNames[] = $area->name;
				$url .= '"'.str_slug($area->slug).'",';
			}

			$stateCity['areas'] = $areaNames;
			$url = rtrim($url, ",");
			$url .= ']';

		}
	}

	if(isset($params['salary_type_text'])){
		$url .='&salary_type='.str_slug($params['salary_type_text']);
	}

	if(isset($params['salary_lower'])){
		$url .='&salary_lower='.$params['salary_lower'];
	}

	if(isset($params['salary_upper'])){
		$url .='&salary_upper='.$params['salary_upper'];
	}

	if(isset($params['category_slug'])){
		$url .='&business_type='.$params['category_slug'];
	}

	if(isset($params['job_type_text'])){
		$url .='&job_type=[';
		foreach ($params['job_type_text'] as $key => $jobType) {
			$url .= '"'.str_slug($jobType).'",';
		}
		$url = rtrim($url, ",");
		$url .= ']';
	}

	if(isset($params['experience'])){
		$url .='&experience=[';
		foreach ($params['experience'] as $key => $exp) {
			$url .= '"'.str_slug($exp).'",';
		}
		$url = rtrim($url, ",");
		$url .= ']';
	}

	if(isset($params['experience'])){
		$url .='&experience=[';
		foreach ($params['experience'] as $key => $exp) {
			$url .= '"'.str_slug($exp).'",';
		}
		$url = rtrim($url, ",");
		$url .= ']';
	}

	if(isset($params['keywords_id'])){
		$url .='&job_roles=[';
		foreach ($params['keywords_id'] as $keywordId => $keyword) {
			$url .= '"'.$keywordId.'|'.str_slug($keyword).'",';
		}
		$url = rtrim($url, ",");
		$url .= ']';
	}

	return ['url'=>$url,'locationtext'=>$stateCity];

	// http://fnbcircle.dev/pune/job-listings?page=1&state=mumbai&salary_type=annually&salary_lower=0&salary_upper=300000000&business_type=club-banquet-catering-unit&job_type=[%22full-time%22]&area=[%22andheri%22]&experience=[%220-1%22]&job_roles=[%2228|assistant-kitchen-manager%22]
}
 

function getFileMimeType($ext){
	$mimeTypes = ['pdf'=>'application/pdf','docx'=>'application/vnd.openxmlformats-officedocument.wordprocessingml.document','doc'=>'application/msword'];

	$mimeType = $mimeTypes[$ext];

	return $mimeType;
 
}

function sendNotifications(){
	$pendingNotifications = App\NotificationQueue::where('processed', 0)->orderBy('created_at', 'asc')->get();

	if(!empty($pendingNotifications)){
		foreach ($pendingNotifications as $key => $pendingNotification) {

			if($pendingNotification->notification_type == 'email'){
				$data = [];
                $data['from'] = $pendingNotification->from_email;
                $data['name'] = $pendingNotification->from_name;
                $data['to'] = $pendingNotification->to;
                $data['cc'] = $pendingNotification->cc;
                $data['subject'] = $pendingNotification->subject;
                $data['template_data'] = $pendingNotification->template_data;
                $emailResponse = sendEmail($pendingNotification->event_type, $data);

                // $response = ($emailResponse) ? 1 : 2;
			}
	 
			$pendingNotification->processed = 1;
			$pendingNotification->processed_at = date('Y-m-d H:i:s');
			$pendingNotification->save();


		}
	}
 }
