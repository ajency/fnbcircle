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
        $job->interview_location_lat = "28.7040592";
        $job->interview_location_long = "77.10249019999992";


        return view('jobs.job-info')->with('jobCategories', $jobCategories)
                                    ->with('job', $job) 
                                    ->with('cities', $cities) 
                                    ->with('defaultExperience', $defaultExperience) 
                                    ->with('salaryTypes', $salaryTypes) 
                                    ->with('defaultKeywords', $defaultKeywords) 
                                    ->with('jobTypes', $jobTypes)
                                    ->with('back_url', null)
                                    ->with('step', 'step-one')
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
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];

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
            $metaData['job_keyword'] = $jobKeywords;
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
        $slug = getUniqueSlug($job, $title);
        $job->reference_id = generateRefernceId($job,'reference_id');
        $job->title = $title;
        $job->description = $description;
        $job->slug = $slug;
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
        // $this->addJobKeywords($job,$jobKeywords);
        Session::flash('success_message','Job details saved successfully.');
        return redirect(url('/jobs/'.$job->reference_id.'/step-two')); 

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

    public function addJobKeywords($job,$keywords){
        $job->hasKeywords()->delete();
        foreach ($keywords as $key => $keywordId) {
       
            $jobKeyword    = new JobKeyword;
            $jobKeyword->job_id = $job->id;
            $jobKeyword->keyword_id = $keywordId;
            $jobKeyword->save();
        }

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
    public function show($jobSlug,$reference_id)
    {
        $pageName = "show";
        $job = Job::where('reference_id',$reference_id)->first();

        if(empty($job))
            abort(404);

        if(!$job->isJobVisible())
            abort(404);

        $jobCompany  = $job->getJobCompany();
        $jobTypes  = $job->getJobTypes();
        $locations  = $job->getJobLocationNames();
        
        $metaData = $job->meta_data;
      
        $data = ['job' => $job]; 
        $data['jobTypes'] = $jobTypes;
        $jobKeywords = (isset($metaData['job_keyword'])) ? $metaData['job_keyword'] :[]; 
        $splitKeywords =  splitArrayData($jobKeywords,4);
        $data['keywords'] = $splitKeywords['array'];
        $data['moreKeywords'] = $splitKeywords['moreArray'];
        $data['moreKeywordCount'] = $splitKeywords['moreArrayCount'];

        $data['experience'] = (isset($metaData['experience'])) ? $metaData['experience'] :[];
        $data['jobCompany'] = $jobCompany;
        $data['pageName'] = $job->getJobCategoryName() .'-'. $job->title;
        $data['locations'] = $locations;
         

         return view('jobs.job-view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($reference_id,$step='step-one')
    {
        $job = Job::where('reference_id',$reference_id)->first(); 
        $data = [];
        $data = ['job' => $job];
        $postUrl = url('jobs/'.$job->reference_id);
        $data['postUrl'] = $postUrl;
        $data['step'] = $step;

        $jobCompany  = $job->getJobCompany();
        $data['jobCompany'] = $jobCompany;

        if($step == 'step-one'){
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
        elseif ($step == 'step-two'){
            
            $contactEmail = $job->getCompanyContactEmail($job->id);
            $contactMobile = $job->getCompanyContactMobile($job->id);
            $data['contactEmail'] = $contactEmail;
            $data['contactMobile'] = $contactMobile;
            $data['back_url'] = url('jobs/'.$job->reference_id.'/step-one'); 
            $blade = 'jobs.job-company';
            $pageName = $job->title .'- Company Details' ;
            // $breadcrumb = $job->title .'/ Company Details' ;
            $breadcrumb = $job->title .' / Edit Job' ;
        }
        elseif ($step == 'step-three'){
            $data['back_url'] = url('jobs/'.$job->reference_id.'/step-two'); 
            $blade = 'jobs.job-plan-selection';
            $pageName = $job->title .'- Plan-Selection' ;
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

        if($request->step == 'step-one'){
            $response = $this->saveStepOneData($job,$request);
        }
        elseif ($request->step == 'step-two'){
             
            $response = $this->saveCompanyData($job,$request);
        }
        elseif ($request->step == 'step-three'){
            # code...
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
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];

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
            $metaData['job_keyword'] = $jobKeywords;
        }
     
        $experienceYearsLower = 0;
        $experienceYearsUpper  = 0;

        if(!empty($experience)){
            $metaData['experience'] = $experience; 
            $experienceLowerUpperValue = $this->getExperienceLowerAndUpperValue($experience);
            
            $experienceYearsLower = $experienceLowerUpperValue['lower'];
            $experienceYearsUpper  = $experienceLowerUpperValue['upper'];
          
        }

        $slug = getUniqueSlug($job, $title);
        $job->title = $title;
        $job->description = $description;
        $job->slug = $slug;
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
        // $this->addJobKeywords($job,$jobKeywords);
        Session::flash('success_message','Job details saved successfully.');
        $request['next_step'] = 'step-two';

        return $request;
    }


    public function saveCompanyData($job,$request){ 
        $user = Auth::user();
        $userId = $user->id;
        $this->validate($request, [
            'company_name' => 'required|max:255',
        ]);

        $data = $request->all();  

        $companyId = $data['company_id'];
        $title = $data['company_name'];
        $description = $data['company_description'];
        $website = $data['company_website'];
        $contactEmail = $data['contact_email'];
        $contactMobile = $data['contact_mobile'];
        $contactEmailId = $data['contact_email_id'];
        $contactMobileId = $data['contact_mobile_id'];
        $visibleEmailContact = (isset($data['visible_email_contact']))?$data['visible_email_contact']:[];
        $visibleMobileContact = (isset($data['visible_mobile_contact']))?$data['visible_mobile_contact']:[];  
 
        
        if($companyId == ''){
            $company = new Company;
        }
        else{
            $company = Company::find($companyId);
        }
        
        $slug = getUniqueSlug($company, $title);
        $company->user_id = $userId;
        $company->title = $title;
        $company->description = $description;
        $company->slug = $slug;
        $company->website = $website;
        $company->save();


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
            $conactDetails = ['id' => $contactMobileId[$key],'object_type' => 'App\Job','object_id' => $job->id,'contact_value'=>$mobile,'contact_type'=>'mobile','is_visible'=>$isVisible] ;

            $userCom = $user->saveContactDetails($conactDetails,'job');

        }

        
        $job->job_modifier = $userId;
        $job->save(); 

        Session::flash('success_message','Company details saved successfully.');
        $request['next_step'] = 'step-three';

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

    public function submitForReview($reference_id){
        $date = date('Y-m-d H:i:s');    
        $job = Job::where('reference_id',$reference_id)->first();
        $job->status = 2; 
        $job->date_of_submission = $date; 
        $job->save();

        Session::flash('job_review_pending','Job details submitted for review.');
        return redirect(url('/jobs/'.$job->reference_id.'/step-one')); 
    }

    public function getSimilarJobs($job){

    }

    private function getFilteredJobs($jobs, $filters){

            // //Category Subcategory Filter
            // if(isset($filters['category'])){

            //      $projects = $projects->filter(function($project)use($filters){ 
            //         $filters = (isset($_REQUEST['filters'])) ? $_REQUEST['filters'] : $filters;  
            //         $cat_filters = getCatFilterTree($filters);

            //         $status = array();
            //         foreach($cat_filters as $key=>$cat){
            //             //Log::info($cat);
            //             $status[] = $this->isCategoryTrue($cat,$project);
            //         }

            //         if(in_array(true, $status)){
            //             return $project;
            //         }

            //     });
            // }

            
            return $jobs;
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
