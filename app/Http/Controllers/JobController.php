<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Job;
use App\JobLocation;
use App\JobTypes;
use App\Area;
use App\Category;
use App\City;
use App\Defaults;
use App\Company;
use App\JobKeyword;
use App\JobCompany;
use Auth;
use Session;
use App\UserCommunication;
use View;
use \Input;
use App\JobApplicant;
use Ajency\User\Ajency\userauth\UserAuth;
 

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['show']]);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        

        
        $cities  = City::where('status', 1)->orderBy('name')->get();

        $job    = new Job;
        $jobTypes  = $job->jobTypes();
        $salaryTypes  = $job->salaryTypes();
        $defaultExperience  = $job->jobExperience();
        $defaultKeywords  = $job->jobKeywords();
        $jobCategories = $job->jobCategories();
        $postUrl = url('jobs');
        $pageName = "Add Job" ;
        $breadcrumb = "Add a Job" ;
 
        return view('jobs.job-info')->with('jobCategories', $jobCategories)
                                    ->with('job', $job) 
                                    ->with('cities', $cities) 
                                    ->with('defaultExperience', $defaultExperience) 
                                    ->with('salaryTypes', $salaryTypes) 
                                    ->with('defaultKeywords', $defaultKeywords) 
                                    ->with('jobTypes', $jobTypes)
                                    ->with('back_url', null)
                                    ->with('step', 'job-details')
                                    ->with('pageName', $pageName)
                                    ->with('breadcrumb', $breadcrumb)
                                    ->with('postUrl', $postUrl);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $userId = Auth::user()->id;

        $this->validate($request, [
            'job_title' => 'required|max:255',
            'description' => 'required',
            'job_city' => 'required|min:1',
            'job_area' => 'required|min:1',
            'category' => 'required|integer',
        ]);

        $data = $request->all();  

        $title = $data['job_title'];
        $description = $data['description'];
        $category = $data['category'];
        $jobCity = $data['job_city'];
        $jobArea = $data['job_area'];
        $jobTypeIds = (isset($data['job_type']))?$data['job_type']:[];
        $jobKeywords = $data['job_keyword'];
        $experience =  (isset($data['experience']))?$data['experience']:[];
        $salaryType = (isset($data['salary_type']))?$data['salary_type']:0;
        $salaryLower = $data['salary_lower'];
        $salaryUpper = $data['salary_upper'];
        $interviewLocation = $data['interview_location'];
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $keywordIds =  (isset($data['keyword_id']))?$data['keyword_id']:[];

        $metaData = [] ;

        if(is_array($jobTypeIds) && !empty($jobTypeIds)){
            $metaData['job_type'] = $jobTypeIds;
            $jobType = $jobTypeIds[0];
        }
        else{
            $jobType = 0;
        }

        if(!empty($jobKeywords)){
            $jobKeywords = explode(',', $jobKeywords);
            // $metaData['job_keyword'] = $jobKeywords;
        }

        $experienceYearsLower = 0;
        $experienceYearsUpper  = 0;

        if(!empty($experience)){
            $metaData['experience'] = $experience; 
            $experienceLowerUpperValue = $this->getExperienceLowerAndUpperValue($experience); 
             
            $experienceYearsLower = $experienceLowerUpperValue['lower'];
            $experienceYearsUpper  = $experienceLowerUpperValue['upper'];
          
        }

        $job    = new Job;
        // $slug = getUniqueSlug($job, $title);
        $job->reference_id = generateRefernceId($job,'reference_id');
        $job->title = $title;
        $job->description = $description;
        $job->slug = '';
        $job->category_id = $category;
        $job->job_type = $jobType;
        $job->experience_years_lower = $experienceYearsLower;
        $job->experience_years_upper = $experienceYearsUpper;
        $job->salary_type = $salaryType;
        $job->salary_lower = $salaryLower;
        $job->salary_upper = $salaryUpper;
        $job->status = 1;
        $job->job_creator = $userId;
        $job->job_modifier = $userId;
        $job->meta_data = $metaData;
        $job->interview_location = $interviewLocation;
        $job->interview_location_lat = $latitude;
        $job->interview_location_long = $longitude;
        $job->save();

        $jobId = $job->id;
        
        $this->addJobLocation($job,$jobArea);
        $this->addJobKeywords($job,$keywordIds,$jobKeywords);
        $this->addJobTypes($job,$jobTypeIds);
        Session::flash('success_message','Job details saved successfully.');
        return redirect(url('/jobs/'.$job->reference_id.'/company-details')); 

    }

    public function addJobLocation($job,$locations){
        $job->hasLocations()->delete();
        foreach ($locations as $cityId => $areaIds) {
            foreach ($areaIds as $areaId) {
                $jobLocation    = new JobLocation;
                $jobLocation->job_id = $job->id;
                $jobLocation->area_id = $areaId;
                $jobLocation->city_id = $cityId;
                $jobLocation->save();
            }
            
        }

        return true;
        
    }

    public function addJobTypes($job,$types){
        $job->hasJobTypes()->delete();
        foreach ($types as  $typeid) {
                $jobType    = new JobTypes;
                $jobType->job_id = $job->id;
                $jobType->type_id = $typeid;
                $jobType->save();
    
        }

        return true;
        
    }

    public function addJobKeywords($job,$keywords,$jobKeywords){
        $job->hasKeywords()->delete();
        $keywordData = [];

        foreach ($keywords as $keywordId => $keyword) {
             
            if(!empty($jobKeywords) && in_array($keyword, $jobKeywords)){
                $keywordData[$keywordId] = $keyword;
                $jobKeyword    = new JobKeyword;
                $jobKeyword->job_id = $job->id;
                $jobKeyword->keyword_id = $keywordId;
                $jobKeyword->save();
            }
            
        }
        $metaData = $job->meta_data;
        $metaData['job_keyword'] = $keywordData;
        $job->meta_data = $metaData;
        $job->save();

        return true;
        
    }

    public function getExperienceLowerAndUpperValue($jobExperience){
 
        $lower = $upper =[];
        $min = $max = 0; 
        if(!empty($jobExperience)){


            foreach ($jobExperience as $key => $experience) {
                if($experience != '10+')
                    $experienceValues = explode('-', $experience);
                else
                    $experienceValues = explode('+', $experience);


                if(!empty($experienceValues)){
                    $lower[] = trim($experienceValues[0]);
                    $upper[] = trim($experienceValues[1]);
                }

            } 

            $min = min($lower);
            $max = (max($upper) == '') ? 10 :max($upper);
        }
        
        return ['lower'=> $min, 'upper'=>$max];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($jobSlug)
    {
        
        $referenceId = getReferenceIdFromSlug($jobSlug);
        $job = Job::where('reference_id',$referenceId)->first();
        
        if(!empty($job) && $job->slug!="" && $job->slug!=$jobSlug)
            abort(404);

        if(empty($job))
            abort(404);

        if(!$job->isJobVisible())
            abort(404);

        $jobCompany  = $job->getJobCompany();
        $companyLogo = $jobCompany->getCompanyLogo('company_logo'); 
        $jobTypes  = $job->getJobTypes();
        $locations  = $job->getJobLocationNames();
        $similarjobs  = $job->getSimilarJobs(); 
        
        $metaData = $job->meta_data;
      
        $data = ['job' => $job]; 
        $data['jobTypes'] = $jobTypes;
        $jobKeywords = (isset($metaData['job_keyword'])) ? $metaData['job_keyword'] :[];
        $data['keywords'] = $jobKeywords; 
        $splitKeywords =  splitJobArrayData($jobKeywords,4);
        // $data['keywords'] = $splitKeywords['array'];
        $data['moreKeywords'] = $splitKeywords['moreArray'];
        $data['moreKeywordCount'] = $splitKeywords['moreArrayCount'];

        $data['experience'] = (isset($metaData['experience'])) ? $metaData['experience'] :[];
        $data['jobCompany'] = $jobCompany;
        $data['companyLogo'] = $companyLogo;
        $data['pageName'] = $job->getPageTitle();
        $data['locations'] = $locations;
        $data['similarjobs'] = $similarjobs;

        $shareLink = url('/job/'.$job->getJobSlug());
        $shareTitle = $job->title.' | ' .$job->getJobCategoryName()." | fnbcircle";

        $facebookShare = "https://www.facebook.com/dialog/share?app_id=".env('FACEBOOK_ID')."&display=page&href=".$shareLink;

        $twitterShare = "http://www.twitter.com/share?url=".$shareLink;
        
        $googleShare = "https://plus.google.com/share?url=".$shareLink;

        $linkedInShare = "https://www.linkedin.com/shareArticle?mini=true&url=".$shareLink;

        $watsappShare = "whatsapp://send?text=".$shareLink;
        //https://api.whatsapp.com/send?phone=whatsappphonenumber&text=urlencodedtext
 
        $data['shareLink'] = $shareLink;
        $data['shareTitle'] = $shareTitle;
        $data['facebookShare'] = $facebookShare;
        $data['twitterShare'] = $twitterShare;
        $data['googleShare'] = $googleShare;
        $data['linkedInShare'] = $linkedInShare;
        $data['watsappShare'] = $watsappShare;

        $contactEmail = getCommunicationContactDetail($job->id,'App\Job','email','view');
        $contactMobile = getCommunicationContactDetail($job->id,'App\Job','mobile','view');  
        $contactLandline = getCommunicationContactDetail($job->id,'App\Job','landline','view');  
        $data['contactEmail'] = $contactEmail;
        $data['contactMobile'] = $contactMobile;
        $data['contactLandline'] = $contactLandline;

        //if logged in user
        $userApplication = false;
        $userProfile = false;
        $userResume = false;
        $hasAppliedForJob = false;
 
        if(Auth::check()){
            $user = Auth::user();

            $hasAppliedForJob = $user->applications()->where('job_id',$job->id)->first(); 
            $userResume = $user->getUserJobLastApplication();
            $userProfile = $user->getUserProfileDetails();
 
        }

        $jobApplications = false;
        if($job->jobOwnerOrAdmin()){
            $jobApplications = $job->jobApplicants()->orderBy('date_of_application','desc')->get();
            
        }
       
        $data['hasAppliedForJob'] = $hasAppliedForJob;
        $data['userResume'] = $userResume;
        $data['userProfile'] = $userProfile;
        $data['jobApplications'] = $jobApplications; 
         
         return view('jobs.job-view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($reference_id,$step='job-details')
    {
        $job = Job::where('reference_id',$reference_id)->first(); 

        // if(!$job->jobOwnerOrAdmin())
        //     abort(403);


        $data = [];
        $data = ['job' => $job];
        $postUrl = url('jobs/'.$job->reference_id);
        $data['postUrl'] = $postUrl;
        $data['step'] = $step;

        $jobCompany  = $job->getJobCompany();
        $data['jobCompany'] = $jobCompany;

        if($step == 'job-details'){
            $jobCategories = $job->jobCategories();
            $defaultExperience  = $job->jobExperience();
            $defaultKeywords  = $job->jobKeywords();
            $cities  = City::where('status', 1)->orderBy('name')->get();

            $jobTypes  = $job->jobTypes();
            $salaryTypes  = $job->salaryTypes();
            

            $savedLocation = $job->getJobLocation(); 
            $data['savedjobLocation'] = $savedLocation['savedLocation'];
            $data['savedAreas'] = $savedLocation['areas']; 
            $data['jobCategories'] = $jobCategories;
            $data['defaultExperience'] = $defaultExperience;
            $data['defaultKeywords'] = $defaultKeywords;
            $data['cities'] = $cities;
            $data['jobTypes'] = $jobTypes;
            $data['salaryTypes'] = $salaryTypes;
            $data['back_url'] = null;
            
            $blade = 'jobs.job-info';
            $pageName = $job->title .'- Job Details' ;
            // $breadcrumb = $job->title .'/ Job Details' ;
            $breadcrumb = $job->title .' / Edit Job' ;

        }
        elseif ($step == 'company-details'){
            
            $contactEmail = getCommunicationContactDetail($job->id,'App\Job','email');
            $contactMobile = getCommunicationContactDetail($job->id,'App\Job','mobile');  
            $contactLandline = getCommunicationContactDetail($job->id,'App\Job','landline');  
            $companyLogo = (!empty($jobCompany)) ? $jobCompany->getCompanyLogo('company_logo') : ''; 
            $data['companyLogo'] = $companyLogo;
            $data['contactEmail'] = $contactEmail;
            $data['contactMobile'] = $contactMobile;
            $data['contactLandline'] = $contactLandline;
            $data['back_url'] = url('jobs/'.$job->reference_id.'/job-details'); 
            $blade = 'jobs.job-company';
            $pageName = $job->title .'- Company Details' ;
            // $breadcrumb = $job->title .'/ Company Details' ;
            $breadcrumb = $job->title .' / Edit Job' ;
        }
        elseif ($step == 'go-premium'){
            $data['back_url'] = url('jobs/'.$job->reference_id.'/company-details'); 
            $blade = 'jobs.job-plan-selection';
            $pageName = $job->title .'- Go Premium' ;
            // $breadcrumb = $job->title .'/ Plan-Selection' ;
            $breadcrumb = $job->title .' / Edit Job' ;
        }
        else{

            abort(404);
        }
        $data['pageName'] = $pageName;
        $data['breadcrumb'] = $breadcrumb;
        return view($blade)->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $reference_id)
    {
         
        $job = Job::where('reference_id',$reference_id)->first(); 

        if($request->step == 'job-details'){
            $response = $this->saveStepOneData($job,$request);
        }
        elseif ($request->step == 'company-details'){
             
            $response = $this->saveCompanyData($job,$request);
        }
        elseif ($request->step == 'go-premium'){
            $response['next_step']='go-premium';
        }
        else{
            abort(404);
        }
        $nextStep = $response['next_step'];

        return redirect(url('/jobs/'.$job->reference_id.'/'.$nextStep)); 
    }

    //save basic info
    public function saveStepOneData($job,$request){
        $userId = Auth::user()->id;  
        $this->validate($request, [
            'job_title' => 'required|max:255',
            'description' => 'required',
            'job_city' => 'required',
            'job_area' => 'required',
            'category' => 'required|integer',
        ]);

        $data = $request->all();  

        $title = $data['job_title'];
        $description = $data['description'];
        $category = $data['category'];
        $jobCity = $data['job_city'];
        $jobArea = $data['job_area'];
        $jobTypeIds = (isset($data['job_type']))?$data['job_type']:[];
        $jobKeywords = $data['job_keyword'];
        $experience =  (isset($data['experience']))?$data['experience']:[];
        $salaryType = (isset($data['salary_type']))?$data['salary_type']:0;
        $salaryLower = $data['salary_lower'];
        $salaryUpper = $data['salary_upper'];
        $interviewLocation = $data['interview_location'];
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $keywordIds =  (isset($data['keyword_id']))?$data['keyword_id']:[];
        $hasChanges =  $data['has_changes'];
 

        $metaData = [] ;

        if(is_array($jobTypeIds) && !empty($jobTypeIds)){
            $metaData['job_type'] = $jobTypeIds;
            $jobType = $jobTypeIds[0];
        }
        else{
            $jobType = 0;
        }
        // dd()
        if(!empty($jobKeywords)){
            $jobKeywords = explode(',', $jobKeywords);
            // $metaData['job_keyword'] = $jobKeywords;
        }
     
        $experienceYearsLower = 0;
        $experienceYearsUpper  = 0;

        if(!empty($experience)){
            $metaData['experience'] = $experience; 
            $experienceLowerUpperValue = $this->getExperienceLowerAndUpperValue($experience);
            
            $experienceYearsLower = $experienceLowerUpperValue['lower'];
            $experienceYearsUpper  = $experienceLowerUpperValue['upper'];
          
        }

        // $slug = getUniqueSlug($job, $title);
        $job->title = $title;
        $job->description = $description;
        // $job->slug = $slug;
        $job->category_id = $category;
        $job->job_type = $jobType;
        $job->experience_years_lower = $experienceYearsLower;
        $job->experience_years_upper = $experienceYearsUpper;
        $job->salary_type = $salaryType;
        $job->salary_lower = $salaryLower;
        $job->salary_upper = $salaryUpper;
        $job->job_modifier = $userId;
        $job->meta_data = $metaData;
        $job->interview_location_lat = $latitude;
        $job->interview_location_long = $longitude;
        $job->interview_location = $interviewLocation;
        $job->save(); 

        $this->addJobTypes($job,$jobTypeIds);
        $this->addJobLocation($job,$jobArea);
        $this->addJobKeywords($job,$keywordIds,$jobKeywords);

        if($hasChanges == 1)
            Session::flash('success_message','Job details saved successfully.');
        $request['next_step'] = 'company-details';

        return $request;
    }


    public function saveCompanyData($job,$request){ 
       
        $user = Auth::user();
        $userId = $user->id;
        $this->validate($request, [
            'flexdatalist-company_name' => 'required|max:255',
        ]);

        $data = $request->all(); 

        $companyId = $data['company_id'];
        $title = $data['flexdatalist-company_name'];
        $description = $data['company_description'];
        $website = $data['company_website'];
        $contactEmail = $data['contact_email'];
        $contactMobile = $data['contact_mobile'];
        $contactLandline = $data['contact_landline'];
        $contactEmailId = $data['contact_email_id'];
        $contactMobileId = $data['contact_mobile_id'];
        $contactLandlineId = $data['contact_landline_id'];
        $contactMobileCode = $data['contact_country_code'];
        $contactLandlineCode = $data['contact_ll_country_code'];
        $deleteLogo =  $data['delete_logo'];
        $visibleEmailContact = (isset($data['visible_email_contact']))?$data['visible_email_contact']:[];
        $visibleMobileContact = (isset($data['visible_mobile_contact']))?$data['visible_mobile_contact']:[];  
        $visibleLandlineContact = (isset($data['visible_landline_contact']))?$data['visible_landline_contact']:[];  
        $hasChanges =  $data['has_changes'];

        if(isset($data['company_logo'])){
            $companyLogo = $data['company_logo'];
            $deleteLogo = '1';
        }else{
            $companyLogo = '';
        }
                
        if($companyId == ''){
            $company = new Company;
            $status = 1 ;
        }
        else{
            $company = Company::find($companyId);
            $status = $company->status ;
        }
        
        $slug = getUniqueSlug($company, $title);
        $company->user_id = $userId;
        $company->title = $title;
        $company->description = $description;
        $company->slug = $slug;
        $company->website = $website;
        $company->status = $status;
        $company->save();

        if($deleteLogo==1){
            $company->unmapImage($company->logo);
            $company->logo = '';
            $company->save();
        }

        if(!empty($companyLogo)){
            $logoId = $company->uploadCompanyLogo($companyLogo);
            $company->logo = $logoId;
            $company->save();
        }

        
         


        $jobCompany = JobCompany::where('job_id',$job->id)->first();
        if(!empty($jobCompany) && $jobCompany->company_id !=$company->id){
            $jobCompany->company_id = $company->id;
            $jobCompany->save();
        }
        elseif(empty($jobCompany)){
            $jobCompany = new JobCompany;
            $jobCompany->job_id = $job->id;
            $jobCompany->company_id = $company->id;
            $jobCompany->save();
        }  



        ///save conatct detailts
        foreach ($contactEmail as $key => $email) {
            $isVisible = $visibleEmailContact[$key];
            $conactDetails = ['id' => $contactEmailId[$key],'object_type' => 'App\Job','object_id' => $job->id,'contact_value'=>$email,'contact_type'=>'email','is_visible'=>$isVisible] ;

            $userCom = $user->saveContactDetails($conactDetails,'job');

 
        }

        foreach ($contactMobile as $key => $mobile) {
            $isVisible = $visibleMobileContact[$key];
            $conactDetails = ['id' => $contactMobileId[$key],'object_type' => 'App\Job','object_id' => $job->id,'contact_value'=>$mobile,'country_code'=>$contactMobileCode[$key],'contact_type'=>'mobile','is_visible'=>$isVisible] ;


            $userCom = $user->saveContactDetails($conactDetails,'job');

        }

        foreach ($contactLandline as $key => $landline) {
            $isVisible = $visibleLandlineContact[$key];
            $conactDetails = ['id' => $contactLandlineId[$key],'object_type' => 'App\Job','object_id' => $job->id,'contact_value'=>$landline,'country_code'=>$contactLandlineCode[$key],'contact_type'=>'landline','is_visible'=>$isVisible] ;

          
            $userCom = $user->saveContactDetails($conactDetails,'job');
        

        }
   
        $job->job_modifier = $userId;
        $job->updated_at = date('Y-m-d H:i:s');
        $job->save(); 

        if($hasChanges == 1)
            Session::flash('success_message','Company details saved successfully.');

        $request['next_step'] = 'go-premium';

        return $request;
    }


    public function getKeywords(Request $request){ 

        // $this->validate($request, [
        //     'keyword' => 'required',
        // ]);

        
        // $jobKeywords =  Defaults::where("type","job_keyword")->where('label', 'like', '%'.$request->keyword.'%')->select('id', 'label')
        $jobKeywords = \DB::select('select id,label  from  defaults where type="job_keyword" and label like "%'.$request->keyword.'%" order by label asc');
        
        return response()->json(['results' => $jobKeywords, 'options' => []]);
    }

    public function getCompanies(Request $request)
    { 
        $this->validate($request, [
            'keyword' => 'required',
        ]);

        $companies =  Company::where('title', 'like', '%'.$request->keyword.'%')->orderBy('title','asc')->select('id','title','description','website','logo')->get();
        // $companies = \DB::select('select id,title,description,website,logo  from  companies where title like "%'.$request->keyword.'%" order by title asc');

        $companyData = [];
        foreach ($companies as $key => $company) {

            $companies[$key]['logo'] = Company::find($company->id)->getCompanyLogo('company_logo');
        }
 
        return response()->json(['results' => $companies]);
    }

    public function submitForReview($referenceId){
        $date = date('Y-m-d H:i:s');    
        $job = Job::where('reference_id',$referenceId)->first();
        // $job->status = 2; 
        // $job->date_of_submission = $date; 
        // $job->save();


        //email data 

        $jobOwner = $job->createdBy;
        $ownerDetails = $jobOwner->getUserProfileDetails();

        $templateData = [];
        $jobCompany  = $job->getJobCompany();
        $locations  = $job->getJobLocationNames();
        $metaData = $job->meta_data;
         $jobKeywords = (isset($metaData['job_keyword'])) ? $metaData['job_keyword'] :[];
        
        $contactEmail = getCommunicationContactDetail($job->id,'App\Job','email');
        $contactMobile = getCommunicationContactDetail($job->id,'App\Job','mobile');  
        $contactLandline = getCommunicationContactDetail($job->id,'App\Job','landline');  

        $templateData['keywords'] = $jobKeywords;
        $templateData['jobCompany'] = $jobCompany;
        $templateData['contactEmail'] = $contactEmail;
        $templateData['contactMobile'] = $contactMobile;
        $templateData['contactLandline'] = $contactLandline;
        $templateData['locations'] = $locations;
        $templateData['job'] = $job;
        

        $data = [];
        $data['from'] = $ownerDetails['email'];
        $data['name'] = $jobOwner->name;
        $data['to'] = [ 'nutan@ajency.in'];
        $data['cc'] = 'prajay@ajency.in';
        $data['subject'] = "A job has been submitted for review.";
        $data['template_data'] = $templateData;
        
        sendEmail('job-submit-for-review', $data);

        Session::flash('job_review_pending','Job details submitted for review.');
        return redirect()->back();
    }

 
    public function filterJobs($filters,$skip,$length,$orderDataBy){

        $jobQuery = Job::select('jobs.*')->join('categories', 'categories.id', '=', 'jobs.category_id'); 


        if($filters['job_name']!="")
        {
            $jobQuery->where('jobs.title','like','%'.$filters['job_name'].'%');
        }

        if($filters['company_name']!="")
        {
            $jobIds = Company:: where('title','like','%'.$filters['company_name'].'%')
                      ->join('job_companies', 'companies.id', '=', 'job_companies.company_id')
                      ->pluck('job_companies.job_id')->toArray(); 

            $jobQuery->whereIn('jobs.id',$jobIds);
        }

        if(isset($filters['job_status']) && !empty($filters['job_status']))
        {
            $jobQuery->whereIn('jobs.status',$filters['job_status']);
        }

        if(isset($filters['city']) && !empty($filters['city']))
        {   
            $jobQuery->join('job_locations', 'jobs.id', '=', 'job_locations.job_id');
            $jobQuery->whereIn('job_locations.city_id',$filters['city']);

            $jobQuery->distinct('jobs.id'); 
        }

        if(isset($filters['area']) && !empty($filters['area']))
        {   
            $jobQuery->whereIn('job_locations.area_id',$filters['area']);

            $jobQuery->distinct('jobs.id');
        }

        if(isset($filters['keywords']) && !empty($filters['keywords']))
        {
            $jobQuery->join('job_keywords', 'jobs.id', '=', 'job_keywords.job_id'); 

            $jobQuery->whereIn('job_keywords.keyword_id',$filters['keywords']);

            $jobQuery->distinct('jobs.id');
        }

        if(isset($filters['category']) && !empty($filters['category']))
        {
            $jobQuery->whereIn('jobs.category_id',$filters['category']); 
        }

        if(isset($filters['job_type']) && !empty($filters['job_type']))
        {
            $jobQuery->join('job_types', 'jobs.id', '=', 'job_types.job_id'); 

            $jobQuery->whereIn('job_types.type_id',$filters['job_type']);

            $jobQuery->distinct('jobs.id');
        }

        if(isset($filters['published_date_from']) && !empty($filters['published_date_from']) && !empty($filters['published_date_to']))
        { 

            $jobQuery->where('jobs.published_on','>=',$filters['published_date_from'].' 00:00:00'); 
            $jobQuery->where('jobs.published_on','<=',$filters['published_date_to'].' 23:59:59');
        }

        if(isset($filters['submission_date_from']) && !empty($filters['submission_date_from']) &&  !empty($filters['submission_date_to']))
        {
            $jobQuery->where('jobs.date_of_submission','>=',$filters['submission_date_from'].' 00:00:00'); 
            $jobQuery->where('jobs.date_of_submission','<=',$filters['submission_date_to'].' 23:59:59');
        }


        if(isset($filters['experience']) && !empty($filters['experience']))
        {
            $minMaxExperience = $this->getExperienceLowerAndUpperValue($filters['experience']);

            $jobQuery->where(function($expQuery)use($minMaxExperience)
            {
                $expQuery->where(function($expQuery)use($minMaxExperience)
                {
                    $expQuery->where(function($query)use($minMaxExperience)
                    {
                        $minExp = $minMaxExperience['lower'];
                        $maxExp = $minMaxExperience['upper'];
                        $query->where('jobs.experience_years_lower','>=',$minExp); 
                        $query->where('jobs.experience_years_lower','<=',$maxExp); 
                    });

                
                    $expQuery->orWhere(function($query)use($minMaxExperience)
                    {
                        $minExp = $minMaxExperience['lower'];
                        $maxExp = $minMaxExperience['upper'];
                        $query->where('jobs.experience_years_upper','>=',$minExp); 
                        $query->where('jobs.experience_years_upper','<=',$maxExp); 
                    });
                });

                //for not disclosed exp
                $expQuery->orWhere(function($query)use($minMaxExperience)
                {
                    $query->where('jobs.experience_years_lower',0); 
                    $query->where('jobs.experience_years_upper',0); 
                });
            });
            
        }

        if(isset($filters['salary_type']) && !empty($filters['salary_type']))
        {
            $salaryLower = $filters['salary_lower'];
            $salaryUpper = $filters['salary_upper'];
            $salaryType = $filters['salary_type'];


            $jobQuery->where(function($salaryQry)use($salaryLower,$salaryUpper,$salaryType)
            {
                $salaryQry->where('jobs.salary_type',$salaryType); 
                // $salaryQry->where(function($salaryQuery)use($salaryLower,$salaryUpper,$salaryType)
                // {
                    
                //     $salaryQuery->where(function($query)use($salaryLower,$salaryUpper)
                //     {
                //         $query->where('jobs.salary_lower','>=',$salaryLower); 
                //         $query->where('jobs.salary_lower','<=',$salaryUpper); 
                //     });

                
                //     $salaryQuery->orWhere(function($query)use($salaryLower,$salaryUpper)
                //     {
     
                //         $query->where('jobs.salary_upper','>=',$salaryLower); 
                //         $query->where('jobs.salary_upper','<=',$salaryUpper); 
                //     });
                // });

                if($salaryLower == $salaryUpper){
                    $salaryQry->where(function($salaryQuery)use($salaryLower,$salaryUpper,$salaryType)
                    {
                        $salaryQuery->where('jobs.salary_lower','<=',$salaryLower); 
                        $salaryQuery->where('jobs.salary_upper','>=',$salaryLower); 
                    });
                }
                else{

                    $salaryQry->where(function($salaryQuery)use($salaryLower,$salaryUpper,$salaryType)
                    {
                        
                        $salaryQuery->where(function($query)use($salaryLower,$salaryUpper)
                        {
                            $query->where('jobs.salary_lower','>=',$salaryLower); 
                            $query->where('jobs.salary_lower','<=',$salaryUpper); 
                        });

                    
                        $salaryQuery->orWhere(function($query)use($salaryLower,$salaryUpper)
                        {
         
                            $query->where('jobs.salary_upper','>=',$salaryLower); 
                            $query->where('jobs.salary_upper','<=',$salaryUpper); 
                        });

                        $salaryQuery->orWhere(function($query)use($salaryLower,$salaryUpper)
                        {
                            $query->where('jobs.salary_lower','<=',$salaryLower); 
                            $query->where('jobs.salary_upper','>=',$salaryUpper); 
                        });
                    });

                }
                


                //for not disclosed salary
                $salaryQry->orWhere(function($salaryQuery)use($salaryLower,$salaryUpper)
                {
                    $salaryQuery->whereNull('jobs.salary_lower'); 
                    $salaryQuery->whereNull('jobs.salary_upper'); 
                    $salaryQuery->where('jobs.salary_type',0); 
                });
            });
            
        }


        if(isset($orderDataBy['companies.title'])){ 
            $jobQuery->join('job_companies', 'jobs.id', '=', 'job_companies.job_id');
            $jobQuery->join('companies', 'job_companies.company_id', '=', 'companies.id');

        }

        
        

        foreach ($orderDataBy as $columnName => $orderBy) {
            $jobQuery->orderBy($columnName,$orderBy);
        }

        if($length>1)
        {  

            $totalJobs = $jobQuery->get()->count(); 
            $jobs    = $jobQuery->skip($skip)->take($length)->get();   
        }
        else
        {
            $jobs    = $jobQuery->get();  
            $totalJobs = $jobs->count();  
        }

        return ['totalJobs' =>$totalJobs,'jobs'=>$jobs ];

    }



    public function jobListing(Request $request,$serachCity){ 

        $cities  = City::where('status', 1)->orderBy('name')->get();
        $requestData = $request->all();  
        $job    = new Job;
        $jobTypes  = $job->jobTypes();
        $salaryTypes  = $job->salaryTypes();
        $defaultExperience  = $job->jobExperience();
        $salaryRange = salaryRange();
         
        if(!isset($requestData['state'])){
            $requestData['state'] = $serachCity;
        }
        //get filter values
        if(isset($requestData['business_type']) && $requestData['business_type']!=""){
            // $categoryName = Category::find($requestData['category']);
            $categoryName = Category::where('slug',$requestData['business_type'])->first();
            $requestData['category_name'] = (!empty($categoryName)) ? $categoryName->name : '';
            $requestData['category_id'] = (!empty($categoryName)) ? $categoryName->id : '';

        }

        if(isset($requestData['job_type']) && $requestData['job_type']!=""){
            $requestData['job_type'] = json_decode($requestData['job_type']);
        }

        if(isset($requestData['experience']) && $requestData['experience']!=""){
            $requestData['experience'] = json_decode($requestData['experience']);
        }

        if(isset($requestData['city']) && $requestData['city']!=""){
            $cityId  = City::where('slug', $request->state)->first()->id;
            $city_areas = Area::where('city_id', $cityId)->where('status', '1')->orderBy('order')->orderBy('name')->get();
            
            $requestData['area'] = json_decode($requestData['city']);
            $requestData['city_areas'] = $city_areas;
        }

        if(isset($requestData['job_roles']) && $requestData['job_roles']!=""){

            $keywordIdStr = json_decode($requestData['job_roles']); 
            $keywordIds = [];
            foreach ($keywordIdStr as $key => $keywordstr) {
                $keyword = explode('|', $keywordstr);
                $keywordIds[] = $keyword[0];
            }

            $keywordData = Defaults::whereIn("id",$keywordIds)->get();
            $searchKeywords = [];
            foreach ($keywordData as $key => $keyword) {
                $searchKeywords[$keyword->id] = $keyword->label;
            }
            $requestData['job_roles'] = $searchKeywords;
        }

        if(!isset($requestData['page'])){
            $requestData['page'] = 1;
        }
        

        $currentUrl = $request->fullUrl();
        $header_type = "trans-header";
        return view('jobs.job-listing',compact('header_type'))->with('cities', $cities)
                                       ->with('jobTypes', $jobTypes)
                                       ->with('salaryTypes', $salaryTypes)
                                       ->with('defaultExperience', $defaultExperience)
                                       ->with('urlFilters', $requestData)
                                       ->with('salaryRange', $salaryRange)
                                       ->with('currentUrl', $currentUrl)
                                       ->with('serachCity', $serachCity);
    }

    public function getListingJobs(Request $request){
       
        $length = 10;
        $orderDataBy = ['premium'=>'asc','published_on'=>'desc'];
        $filters = $request->all(); 
        $append = $filters['append']; 
        $page = $filters['page'];
        $startPage = ($page - 1); 
        $skip = $startPage * $length;

        //convert to array 
        $flteredCity =  $filters['city']; 
        $flteredCitySlug =  City::find($flteredCity)->slug;   
        // $flteredCityName =  City::where('slug', $flteredCity)->first()->name;   
        $city[] =  $flteredCity; 
        $filters['city'] = $city;

        if(!empty($filters['category'])){
            $category[] =  $filters['category']; 
            $filters['category'] = $category;
        }
        
        $filters['job_status'] = [3];

        $filterJobs = $this->filterJobs($filters,$skip,$length,$orderDataBy);

        $jobs = $filterJobs['jobs'];
        $totalJobs = $filterJobs['totalJobs'];
        $filteredJobs = count($jobs);


        $jobListingCard = View::make('jobs.job-listing-card', compact('jobs'))->with(['append'=>$append,'flteredCitySlug'=>$flteredCitySlug,'isListing'=>true])->render();


        $pagination = pagination($totalJobs,$page,$length);

        $recordEnd = $page * $length;
        if($recordEnd > $totalJobs)
            $recordEnd = $recordEnd - ($recordEnd - $totalJobs);
        $response = array(
            'data' => $jobListingCard,
            'total_items' => $totalJobs,
            'filtered_items' => $filteredJobs,
            'recordStarts' => ($startPage * $length) + 1 ,
            'recordEnd' => $recordEnd ,
            'filters' => '',
            'page'=> $page,
            'perpage'=> $length,
            'jobs' => $jobs,
            'pagination' => $pagination,

            );

        return response()->json($response);
    }
 
    public function changeJobStatus($referenceId,$status){

        $date = date('Y-m-d H:i:s');    
        $job = Job::where('reference_id',$referenceId)->first();

        $configStatuses = $job->jobStatusesToChange();

        foreach ($configStatuses as $statusId => $configStatus) {
            if(str_slug($configStatus) == $status){
               break;
            }
        }

  
        $job->status = $statusId; 
        $job->save();


        $successMessage = [2 => 'Job details submitted for review.',4=> 'Job details archived.',3=>'Job details published.'];
 
        Session::flash('job_review_pending',$successMessage[$statusId]);
        return redirect()->back();
    }
 
    public function applyJob(Request $request,$referenceId){

        $this->validate($request, [
            'applicant_name' => 'required',
            'applicant_email' => 'required',
            // 'applicant_phone' => 'required',
            // 'applicant_city' => 'required',
        ]);

        $job = Job::where('reference_id',$referenceId)->first();
        $user =  Auth::user();
        $data = $request->all(); 
        $applicantName = $data['applicant_name'];
        $applicantEmail = $data['applicant_email'];
        $applicantPhone = $data['applicant_phone'];
        $applicantCity = $data['applicant_city'];
        $applicantCountryCode = $data['country_code'];
        $resume = (isset($data['resume'])) ? $data['resume'] : [];
        $resumeId =(isset($data['resume_id'])) ? $data['resume_id'] : 0;

        $jobApplicant = new JobApplicant;
        $jobApplicant->job_id = $job->id;
        $jobApplicant->user_id = $user->id;
        $jobApplicant->name = $applicantName;
        $jobApplicant->email = $applicantEmail;
        $jobApplicant->phone = $applicantPhone;
        $jobApplicant->city_id = $applicantCity;
        $jobApplicant->country_code = $applicantCountryCode;
        
        $jobApplicant->date_of_application  = date('Y-m-d H:i:s');

        if(!empty($resume)){
            $resumeId = $user->uploadUserResume($resume);
            $jobApplicant->resume_updated_on  = date('Y-m-d H:i:s');

            $userauth_obj = new UserAuth;
            $request_data['resume_id'] = $resumeId;
            $request_data['resume_updated_on'] =  date('Y-m-d H:i:s');
            $response = $userauth_obj->updateOrCreateUserDetails($user, $request_data, "user_id", $user->id);

        }
         
        $jobApplicant->resume_id = $resumeId; 

        $jobApplicant->save();

        $jobOwner = $job->createdBy;
        $ownerDetails = $jobOwner->getUserProfileDetails();
        //for testing
        $ownerDetails['email'] = 'nutan@ajency.in';
         
        $filePath = getUploadFileUrl($resumeId);
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);

        $data = [];
        $data['from'] = $applicantEmail;
        $data['name'] = $applicantName;
        $data['to'] = [ $ownerDetails['email']];
        $data['cc'] = 'prajay@ajency.in';
        $data['subject'] = "New application for job ".$job->title;
        
        $mimeTypes = ['pdf'=>'application/pdf','docx'=>'application/vnd.openxmlformats-officedocument.wordprocessingml.document','doc'=>'application/msword'];

        $mimeType = $mimeTypes[$ext];
        

        $file = $user->getSingleFile($resumeId);
        $data['attach'] = [['file' => base64_encode($file), 'as'=>'photo.'.$ext, 'mime'=>$mimeType]];

        $data['template_data'] = ['job_name' => $job->title,'applicant_name' => $applicantName,'applicant_email' => $applicantEmail,'applicant_phone' => $applicantPhone,'applicant_city' => $applicantCity,'ownername' => $jobOwner->name];
        sendEmail('job-application', $data);

            
    
        // Session::flash('success_message','Successfully applied for job');
        Session::flash('success_apply_job','Job apply');
        return redirect()->back();

    }

    public function getJobTitles(Request $request){ 
        $data = $request->all();
      
        // $jobTitles = \DB::select('select id,title  from  jobs where  title like "%'.$request->keyword.'%" order by title asc');

        $query = "select distinct(`jobs`.`id`),`jobs`.`title`  from  jobs";
        if(isset($data['state']) && $data['state']!='' ){
            $query .= " inner join `job_locations` on `jobs`.`id` = `job_locations`.`job_id`";
        }
        $query .= " where `jobs`.`status`=3";
        $query .= " and `jobs`.`title` like '".$request->keyword."%'";
        
        if(isset($data['state']) && $data['state']!='' ){
            $query .= " and `job_locations`.`city_id` = '".$request->state."'";
        }

        if(isset($data['category']) && $data['category']!=''){ 
            $query .= " and `jobs`.`category_id` = '".$request->category."'";
        }

        $query .= " order by `jobs`.`title` asc";
                 
        
    
        $jobTitles = \DB::select($query);
        
        
        
        
        return response()->json(['results' => $jobTitles, 'options' => []]);
    }

 


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
