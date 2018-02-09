<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use App\Category;
use App\Defaults;
use App\User;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Config;

use App\Http\Controllers\CookieController;
use Symfony\Component\Console\Output\ConsoleOutput;
// use AjComm;

/**
*
*/
function getOperationTime($info=null,$type= "from",$diff=30) {
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
function generateHTML($reference, $values = []) {
	$config_content = config("helper_generate_html_config." . $reference);
	$response_html = [];

	foreach ($config_content as $key => $value) {
		$temp_html = [];
		if($value["type"] == "checkbox") {
			if(!auth()->guest()) {
				$userDetailsObj = auth()->user()->getUserDetails;
			} else {
				$userDetailsObj = null;
			}

			/* Parsley field */
			$parsley = "";
			if(isset($value["parsley"]) && sizeof($value["parsley"]) > 0) {
				foreach ($value["parsley"] as $parsley_key => $parsley_value) {
					$parsley .= $parsley_key . '="' . $parsley_value . '" ';
				}
			}

			if(!auth()->guest() && $userDetailsObj && $userDetailsObj->subtype && in_array($value["value"], unserialize($userDetailsObj->subtype))) { // If logged in & has userDetails & has atleast 1 option in array
				$temp_html["html"] = "<input type=\"checkbox\" class=\"" . $value["css_classes"] . "\" for=\"" . $value["for"] . "\" name=\"" . $value["name"] . "\" value=\"" . $value["value"] . "\" checked=\"true\" " . $parsley . " ". (isset($value["required"]) ? ("required='" . $value["required"] . "'") : '' ) . "/>";
			} else if(in_array($value["value"], $values)) { // If the value is passed in the Array, then ENABLE that Checkbox
				$temp_html["html"] = "<input type=\"checkbox\" class=\"" . $value["css_classes"] . "\" for=\"" . $value["for"] . "\" name=\"" . $value["name"] . "\" value=\"" . $value["value"] . "\" checked=\"true\" " . $parsley . " ". (isset($value["required"]) ? ("required='" . $value["required"] . "'") : '' ) . "/>";
			} else {
				$temp_html["html"] = "<input type=\"checkbox\" class=\"" . $value["css_classes"] . "\" for=\"" . $value["for"] . "\" name=\"" . $value["name"] . "\" value=\"" . $value["value"] . "\" " . $parsley . " ". (isset($value["required"]) ? ("required='" . $value["required"] . "'") : '' ) . "/>";
			}
		} else if($value["type"] == "option") {
			if(!auth()->guest()) {
				$userDetailsObj = auth()->user()->getUserDetails;
			} else {
				$userDetailsObj = null;
			}

			/* Parsley field */
			$parsley = "";
			if(isset($value["parsley"]) && sizeof($value["parsley"]) > 0) {
				foreach ($value["parsley"] as $parsley_key => $parsley_value) {
					$parsley .= $parsley_key . '="' . $parsley_value . '" ';
				}
			}

			if(!auth()->guest() && $userDetailsObj && $userDetailsObj->subtype && in_array($value["value"], unserialize($userDetailsObj->subtype))) { // If logged in & has userDetails & has atleast 1 option in array
				$temp_html["html"] = "<option class=\"" . $value["css_classes"] . "\" for=\"" . $value["for"] . "\" name=\"" . $value["name"] . "\" value=\"" . $value["value"] . "\" selected=\"true\" " . $parsley . " ". (isset($value["required"]) ? ("required='" . $value["required"] . "'") : '' ) . ">" . $value["title"] . "</option>";
			} else if(in_array($value["value"], $values)) { // If the value is passed in the Array, then ENABLE that Checkbox
				$temp_html["html"] = "<option class=\"" . $value["css_classes"] . "\" for=\"" . $value["for"] . "\" name=\"" . $value["name"] . "\" value=\"" . $value["value"] . "\" selected=\"true\" " . $parsley . " ". (isset($value["required"]) ? ("required='" . $value["required"] . "'") : '' ) . ">" . $value["title"] . "</option>";
			} else {
				$temp_html["html"] = "<option class=\"" . $value["css_classes"] . "\" for=\"" . $value["for"] . "\" name=\"" . $value["name"] . "\" value=\"" . $value["value"] . "\" " . $parsley . " ". (isset($value["required"]) ? ("required='" . $value["required"] . "'") : '' ) . ">" . $value["title"] . "</option>";
			}
		} else if($value["type"] == "li_label") {
			if (sizeof($values) > 0) {
				if(in_array($key, $values)) {
					$temp_html["html"] = "<li class=\"" . $value["css_classes"] . "\" for=\"" . $value["for"] . "\" name=\"" . $value["name"] . "\">" . $value["title"] . "</li>";
				}
			} else {
				$temp_html["html"] = "<li class=\"" . $value["css_classes"] . "\" for=\"" . $value["for"] . "\" name=\"" . $value["name"] . "\">" . $value["title"] . "</li>";
			}
		}

		if(isset($value["title"]) && isset($temp_html["html"])) {
			$temp_html["title"] = $value["title"];
		}

		if(isset($value["content"])  && isset($temp_html["html"])) {
			$temp_html["content"] = $value["content"];
		}

		if(isset($temp_html["html"])) { // If html value exist, then push it in array
			array_push($response_html, $temp_html);
		}
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

/**
*
*/
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

/**
*
*/
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

/**
*
*/
function salarayTypeText($type){
   $salaryTpes = ['Annually'=>'per annum' ,'Monthly'=>'per month', 'Daily'=>'per day','Hourly'=>'per hour']  ;

   return $salaryTpes[$type];
}


/**
*
*/ 
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


/**
*
*/ 
function salaryRange() {
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

/**
*
*/
function getUploadFileUrl($id) {
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
	return App\City::where('status', 1)->orderBy('order', 'asc')->get(); //where('is_popular_city', 1)->
}

/**
*
*/
function getSinglePopularCity() {
	return App\City::where('status', 1)->orderBy('order', 'asc')->first(); //where('is_popular_city', 1)->
}
 

function getSinglePopularCitySlug() {
	if(getUserSessionState())
		return getUserSessionState();
	else
		return App\City::where('status', 1)->orderBy('order', 'asc')->first()->slug;
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
*   @param delay  - @var integer
*   @param priority - @var string -> ['low','default','high']
*	@param attach - An Array of arrays each containing the following parameters:
*			@param file - base64 encoded raw file
*			@param as - filename to be given to the attachment
*			@param mime - mime of the attachment
*/
function sendEmail($event='new-user', $data=[]) {
	if(!in_develop() || (in_develop() && config('constants.send_email_dev'))) { // if (in Production Mode) or (in Dev mode & send_email_dev == true)
		$email = new \Ajency\Comm\Models\EmailRecipient();

		/* from */
		$from = (isset($data['from']))? $data['from'] : config('tempconfig.email.defaultID');
		$name = (isset($data['name']))? $data['name'] : config('tempconfig.email.defaultName');
		$from = sendEmailTo($from, 'from');
		$email->setFrom($from, $name);

		/* to */
		if(!isset($data['to']))
			$data['to']= [];
		else
			if(!is_array($data['to'])) // If not in array format
				$data['to'] = [$data['to']];
		$to = sendEmailTo($data['to'], 'to');
		$email->setTo($to);

		/* cc */
		$cc = isset($data['cc']) ? sendEmailTo($data['cc'], 'cc') : sendEmailTo([], 'cc');	
		if(!is_array($cc)) $cc = [$cc];

		$notify = Defaults::where('type','email_notification')->pluck('label')->toArray();
		if(in_array($event, $notify)) {
			$notify_data = json_decode(Defaults::where('type','email_notification')->where('label',$event)->pluck('meta_data')->first())->value;
			$cc = array_merge($cc,$notify_data);
		}
		$email->setCc($cc);

		/* bcc */
		if(isset($data['bcc'])) {
			$bcc = sendEmailTo($data['bcc'], 'bcc');
			$email->setCc($bcc);
		}
		
		$params = (isset($data['template_data']))? $data['template_data']:[];
		if(!is_array($params)) $params = [$params];
		$params['email_subject'] = (isset($data['subject']))? $data['subject']:"";
	 
		$email->setParams($params);

		if(isset($data['attach'])) $email->setAttachments($data['attach']);

		$notify = new \Ajency\Comm\Communication\Notification();
	    $notify->setEvent($event);
	    $notify->setRecipientIds([$email]); 
	    if(isset($data['delay']) && in_develop()) $data['delay'] = config('constants.send_delay_dev');
	    if (isset($data['delay']) and is_integer($data['delay'])) $notify->setDelay($data['delay']);
	    if (isset($data['priority'])) $notify->setPriority($data['priority']);
	    // $notify->setRecipientIds([$email,$email1]);
	    AjComm::sendNotification($notify);
	}
}

/**
* This function is used to send sms for each event
* This function will send an sms to given recipients
* @param data can contain the following extra parameters
*	@param to - array
* 	@param message - string
*   @param delay  - @var integer
* @param override
*/
function sendSms($event='new-user', $data=[], $override = false) {
	if(!in_develop() || (in_develop() && config('constants.send_sms_dev'))) { // If not dev or (if dev && the 'send_sms_dev' flag == true)
		if(in_develop()) { // If develop, then send SMS among dev accounts
			if(config('constants.sms_to_dev_array')) {
				$data['to'] = config('constants.sms_to_dev');
			} else {
				$data['to'] = config('constants.sms_to_dev')[0];
			}
		}

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
	    if(isset($data['delay']) && in_develop()) $data['delay'] = config('constants.send_delay_dev');
	    if (isset($data['delay']) and is_integer($data['delay'])) $notify->setDelay($data['delay']);
	    if (isset($data['priority'])) $notify->setPriority($data['priority']);
	    AjComm::sendNotification($notify);
 	} else {
 		return false;
 	}


}
 
/**
* 
*/
 
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

	if(isset($params['salary_type_text']) && $params['salary_type_text']!=''){
		$url .='&salary_type='.str_slug($params['salary_type_text']);
	}

	if(isset($params['salary_lower']) && $params['salary_lower']!=''){
		$url .='&salary_lower='.$params['salary_lower'];
	}

	if(isset($params['salary_upper']) && $params['salary_upper']!=''){
		$url .='&salary_upper='.$params['salary_upper'];
	}

	if(isset($params['category_slug'])){
		$url .='&business_type='.$params['category_slug'];
	}

	if(isset($params['job_type_text']) && !empty($params['job_type_text'])){
		$url .='&job_type=[';
		foreach ($params['job_type_text'] as $key => $jobType) {
			$url .= '"'.str_slug($jobType).'",';
		}
		$url = rtrim($url, ",");
		$url .= ']';
	}

	if(isset($params['experience']) && !empty($params['experience'])){
		$url .='&experience=[';
		foreach ($params['experience'] as $key => $exp) {
			$url .= '"'.str_slug($exp).'",';
		}
		$url = rtrim($url, ",");
		$url .= ']';
	}


	if(isset($params['keywords_id']) && !empty($params['keywords_id'])){
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

 
/**
*
*/
 
function sendNotifications(){
	$today = date('Y-m-d H:i:s');
	$pendingNotifications = App\NotificationQueue::where('processed', 0)->where('send_at','<=',$today)->orderBy('created_at', 'asc')->get();

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
			$pendingNotification->processed_at = $today;
			$pendingNotification->save();


		}
	}
 }
 
 

function sendUserRegistrationMails($user){
 

    $userDetail = $user->getUserDetails;
    if($userDetail!=null){
	    $userDetail->has_previously_login = 1;
	    $userDetail->save();
	}


    Auth::login($user);
    $userEmail = $user->getPrimaryEmail();
    // $userEmail = 'nutan@ajency.in';

    //send welcome mail
    $data = [];
    $data['from'] = config('constants.email_from');
    $data['name'] = config('constants.email_from_name');
    $data['to'] = [$userEmail];
    $data['cc'] = [];
    $data['subject'] = "Welcome to FnB Circle!";
    $data['template_data'] = ['name' => $user->name,'contactEmail' => config('constants.email_from')];
    sendEmail('welcome-user', $data);


    $data = [];
    $data['from'] = config('constants.email_from');
    $data['name'] = config('constants.email_from_name');
    $data['to'] = [config('constants.email_from')];
    $data['cc'] = [];
    $data['subject'] = "New user registration on FnB Circle.";
    $data['template_data'] = ['user' => $user];
    sendEmail('user-register', $data);

    return true;

}

/**
*
*/
function firstTimeUserLoginUrl(){

	$redirectUrl = '/';

	if(Auth::check()){
		$userType = (!empty(Auth::user()->type)) ? Auth::user()->type :'external';
		if($userType == 'internal')
            $redirectUrl = '/admin-dashboard';
        else
            $redirectUrl = '/customer-dashboard';
    }

	return $redirectUrl;

}

function getUserSessionState(){
	if(session('user_location')!='')
		return session('user_location');
	elseif(\Cookie::get('user_state')!='')
		return \Cookie::get('user_state');
	else
		return false;

}
 


/**
* This function will generate Category's Hierarchy from bottom to top -> Node to Parent
*/
function generateCategoryHierarchy($category_id) {
	$cat_obj = Category::find($category_id);
	$position = ["parent", "branch", "node"];
	$value = [];
	$categ = $cat_obj;
	$level = $cat_obj->level;

	do{
		if($level!=$cat_obj->level) $categ = Category::find($categ->parent_id);
		$value[$position[$categ->level - 1]] = array("id" => $categ->id, "name" => $categ->name, "slug" => $categ->slug, "level" => $categ->level, "icon_url" => $categ->icon_url);
		$level--;
	}while($level > 0);

	return $value;
}


/**
* This function is used to determine whether the Server Hosted is in Development or Production Mode
* 	@return boolean
*/
function in_develop() {
	if(in_array(env('APP_ENV'), config('constants.app_dev_envs'))) {
		return true;
	} else {
		return false;
	}
}

/**
* This function will return Email IDs based on ENV if it is Development or Production mode
*/
function sendEmailTo($emails = [], $type='to') {
	if(in_develop()) {
		$emails = config('constants.email_' . $type . '_dev');
	}

	return $emails;
}


/**
* Note: 
* The Wordpress or other PHP frameworks send data in the format "[\"<val1>\", \"<val2>\"]" & is converted to "["<val1>", "<val2>"]", 
* hence to convert, a 2 step process is done below 
*/
function jsonDecoder($string) {
    if(is_string($string)) {
        if(strpos($string, "\\") !== false) { // If "\" exist in the JSON string, then remove them
            $string = str_replace("\\", "", $string);
            return json_decode($string);
        } else {
            return json_decode($string);
        }
    } else {
        return $string;
    }
}

/**
* This function is used to shorten/lengthen the URL -> using google "goo.gl"
*/
function urlShortner($url,$shorten = true) {
	// Create cURL
	$ch = curl_init();
	$google_api_key = config('services.google.api_key');

	if($google_api_key && is_string($url) && strlen($url) > 0) { // If API key exist, & URL is a string & has value
		$apiUrl = "https://www.googleapis.com/urlshortener/v1/url" .'?key=' . $google_api_key;
		// If we're shortening a URL...
		if($shorten) {
			curl_setopt($ch, CURLOPT_URL, $apiUrl);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("longUrl" => $url)));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		} else {
			curl_setopt($ch, CURLOPT_URL, $apiUrl . '&shortUrl='.$url);
		}

		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		// Execute the post
		$result = curl_exec($ch);
		// Close the connection
		curl_close($ch);

		// Return the result
		return json_decode($result,true);
	} else { // Else return back same value
		return ["id" => $url, "longUrl" => $url];
	}
}

/**
*		this function creates a new activity on status change
*/
function saveListingStatusChange($listing, $from, $to){
	($listing->owner_id != null)?
	activity()
	   ->performedOn($listing)
	   ->causedBy(User::find($listing->owner_id))
	   ->withProperties(['changed_by' => \Auth::user()->id, 'prev_status' => $from, 'new_status' => $to])
	   ->log('listing-status-change')
	: activity()
	   ->performedOn($listing)
	   ->withProperties(['changed_by' => \Auth::user()->id, 'prev_status' => $from, 'new_status' => $to])
	   ->log('listing-status-change');
}
 
function getActivePlan($object){
	$expiryDate = date('Y-m-d H:i:s'); 
	$activePlan = $object->premium()->where('status',1)->where('billing_end', '>', $expiryDate)->first();

	return $activePlan;
            
}

function getrequestedPlan($object){
	$requestedPlan = $object->premium()->where('status',0)->first(); 

	return $requestedPlan;
}

function getjobFreePlan(){
	$plan = App\Plan::where('amount',0)->where('type','job')->first();
	return $plan;
}

function archivePublishedJobs(){
	$currentDate  = date('Y-m-d H:i:s');
	$jobs = App\Job::where('job_expires_on','<=',$currentDate)->get(); 

	foreach ($jobs as $key => $job) {

		$job->premium = 0;
		$job->status = 4;	//mark job as archieve
		$job->job_expires_on = NULL; 
		$job->save();

		//send email
		$jobOwner = $job->createdBy;
        $ownerDetails = $jobOwner->getUserProfileDetails();

		$templateData['job'] = $job;
        $templateData['ownerName'] = $jobOwner->name;
        $ownerDetails['email'] = $jobOwner->getPrimaryEmail();
         
        $subject =  'Your job has expired. Do you want to relist the job?';
 
        $data = [];
        $data['from'] = config('constants.email_from');
        $data['name'] = config('constants.email_from_name');
        $data['to'] = [$ownerDetails['email']];
 
        $data['subject'] = $subject;
        $data['template_data'] = $templateData;
        
        sendEmail('job-expiry', $data);
 	 
	}

	return true;

}

function activateJobPlan($job,$jobRequestedPlan){
	$currentDate  = date('Y-m-d H:i:s');
	$plan =  $jobRequestedPlan->plan;
	$duration = $plan->duration;
	$expiryDate = date('Y-m-d H:i:s', strtotime("+".$duration." days"));

	$jobRequestedPlan->approval_date = $currentDate;
	$jobRequestedPlan->billing_start = $currentDate;
	$jobRequestedPlan->billing_end = $expiryDate;
	$jobRequestedPlan->status = 1;
	$jobRequestedPlan->save();

	$job->premium = 1;
	$job->job_expires_on = $expiryDate;
	$job->save();

	return true;
 
}

function updateJobExpiry($job,$newPlan=[]){
	if(empty($job->job_expires_on)){

		if(!empty($newPlan)){
			$plan = $newPlan;
			$job->premium = 1;
		}
		else{
			$plan = getjobFreePlan();
			$job->premium = 0;
		}
		
		$duration = $plan->duration;
		$expiryDate = date('Y-m-d H:i:s', strtotime("+".$duration." days"));
		$job->job_expires_on = $expiryDate;
		$job->save();

		return true;
	}

	return false;
}
// function createNewPlan($objectType,$objectid,$planId){
// 	//check if any plan is active or requested
// 	$objectplan = App\PlanAssociation::where(['premium_type'=>$objectType,'premium_id'=>$objectid,'plan_id'=>$planId])->whereIn('status',[0,1])->get();

// 	if(!empty($objectplan)){
// 		foreach ($objectplan as $key => $plan) {
// 			$plan->status = 2;
// 			$plan->save();
// 		}
// 	}

// 	// add new  plan
// 	$plan = new App\PlanAssociation;
// 	$plan->premium_type = $objectType;
// 	$plan->premium_id = $objectid;
// 	$plan->plan_id = $planId;
// 	$plan->status = 0;
// 	$plan->save();


// 	return $planId;

// }

/**
* This function updates the Session for display of Enquiry Modal
*/
function generateEnquiryModalSession() {
	// $output = new ConsoleOutput;
	$user_modal_data = Session::get('enquiry_modal_data', []);

	if (sizeof($user_modal_data) <= 0) { // If session doesn't exist, then update the session 
		Session::put('enquiry_modal_data', ['first_time' => ['value' => 30, 'unit' => 'second'], 'display_count' => 3]);
		// Update the Config
		/*$config_value = config('cookie_config.unguarded_cookies', []);
		$config_value = array_merge($config_value, ['enquiry_modal_first_time_value', 'enquiry_modal_first_time_unit', 'enquiry_modal_display_count']); // merge the new key
		config(['cookie_config.unguarded_cookies' => $config_value]); // update the Config value*/
		
		$cookie_class_obj = new CookieController;
		$other_params = ['http_only' => false];
		
		$cookie_class_obj->set('enquiry_modal_first_time_value', 30, $other_params); // Set the modal display value
		$cookie_class_obj->set('enquiry_modal_first_time_unit', 'second', $other_params); // Set the modal display unit
		$cookie_class_obj->set('enquiry_modal_display_count', 3, $other_params); // Set the Modal display count 
	}
	return ;
}