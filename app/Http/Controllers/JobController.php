<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Job;
use App\JobLocation;
use App\Category;
use App\City;
use App\Defaults;
use App\Company;
use App\JobKeyword;
use App\JobCompany;
use Auth;
use Session;
use App\UserCommunication;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
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
        $jobType = (isset($data['job_type']))?$data['job_type']:[];
        $jobKeywords = $data['job_keyword'];
        $experience =  (isset($data['experience']))?$data['experience']:[];
        $salaryType = (isset($data['salary_type']))?$data['salary_type']:0;
        $salaryLower = $data['salary_lower'];
        $salaryUpper = $data['salary_upper'];
        $interviewLocation = $data['interview_location'];
        $latitude = ($interviewLocation)? $data['latitude'] :'';
        $longitude = ($interviewLocation)? $data['longitude'] :'';
        $keywordIds =  (isset($data['keyword_id']))?$data['keyword_id']:[];

        $metaData = [] ;

        if(is_array($jobType) && !empty($jobType)){
            $metaData['job_type'] = $jobType;
            $jobType = $jobType[0];
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
        $job->meta_data = $metaData;
        $job->interview_location_lat = $latitude;
        $job->interview_location_long = $longitude;
        $job->save();

        $jobId = $job->id;
        
        $this->addJobLocation($job,$jobArea);
        $this->addJobKeywords($job,$keywordIds,$jobKeywords);
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

    public function addJobKeywords($job,$keywords,$jobKeywords){
        $job->hasKeywords()->delete();
        $keywordData = [];
        foreach ($keywords as $keywordId => $keyword) {
            
            if(in_array($keyword, $jobKeywords)){
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
            $max = max($upper);
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
        $splitKeywords =  splitJobArrayData($jobKeywords,4);
        $data['keywords'] = $splitKeywords['array'];
        $data['moreKeywords'] = $splitKeywords['moreArray'];
        $data['moreKeywordCount'] = $splitKeywords['moreArrayCount'];

        $data['experience'] = (isset($metaData['experience'])) ? $metaData['experience'] :[];
        $data['jobCompany'] = $jobCompany;
        $data['companyLogo'] = $companyLogo;
        $data['pageName'] = $job->getJobCategoryName() .'-'. $job->title;
        $data['locations'] = $locations;
        $data['similarjobs'] = $similarjobs;

        $shareLink = url('/job/'.$job->getJobSlug());
        $shareTitle = $job->title.' | ' .$job->getJobCategoryName()." | fnbcircle";

        $facebookShare = "https://www.facebook.com/dialog/share?app_id=117054608958714&display=page&href=".$shareLink;

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

        if(!$job->canEditJob())
            abort(403);


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
            $companyLogo = (!empty($jobCompany)) ? $jobCompany->getCompanyLogo('company_logo') : ''; 
            $data['companyLogo'] = $companyLogo;
            $data['contactEmail'] = $contactEmail;
            $data['contactMobile'] = $contactMobile;
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
        $jobType = (isset($data['job_type']))?$data['job_type']:[];
        $jobKeywords = $data['job_keyword'];
        $experience =  (isset($data['experience']))?$data['experience']:[];
        $salaryType = (isset($data['salary_type']))?$data['salary_type']:0;
        $salaryLower = $data['salary_lower'];
        $salaryUpper = $data['salary_upper'];
        $interviewLocation = $data['interview_location'];
        $latitude = ($interviewLocation)? $data['latitude'] :'';
        $longitude = ($interviewLocation)? $data['longitude'] :'';
        $keywordIds =  (isset($data['keyword_id']))?$data['keyword_id']:[];
        $hasChanges =  $data['has_changes'];
 

        $metaData = [] ;

        if(is_array($jobType) && !empty($jobType)){
            $metaData['job_type'] = $jobType;
            $jobType = $jobType[0];
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
        $job->save(); 
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
        $contactEmailId = $data['contact_email_id'];
        $contactMobileId = $data['contact_mobile_id'];
        $contactMobileCode = $data['contact_country_code'];
        $deleteLogo =  $data['delete_logo'];
        $visibleEmailContact = (isset($data['visible_email_contact']))?$data['visible_email_contact']:[];
        $visibleMobileContact = (isset($data['visible_mobile_contact']))?$data['visible_mobile_contact']:[];  
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

        
        $job->job_modifier = $userId;
        $job->save(); 

        if($hasChanges == 1)
            Session::flash('success_message','Company details saved successfully.');

        $request['next_step'] = 'go-premium';

        return $request;
    }

    public function getKeywords(Request $request)
    { 
        $this->validate($request, [
            'keyword' => 'required',
        ]);

        
        // $jobKeywords =  Defaults::where("type","job_keyword")->where('label', 'like', '%'.$request->keyword.'%')->select('id', 'label')
        $jobKeywords = \DB::select('select id,label  from  defaults where label like "%'.$request->keyword.'%" order by label asc');
        
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

    public function submitForReview($reference_id){
        $date = date('Y-m-d H:i:s');    
        $job = Job::where('reference_id',$reference_id)->first();
        $job->status = 2; 
        $job->date_of_submission = $date; 
        $job->save();

        Session::flash('job_review_pending','Job details submitted for review.');
        return redirect(url('/jobs/'.$job->reference_id.'/job-details')); 
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
