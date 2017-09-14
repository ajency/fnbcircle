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

        

        $jobCategories = [1=>'cat-1',2=>'cat-2'];
        $cities  = City::where('status', 1)->orderBy('name')->get();

        $job    = new Job;
        $jobTypes  = $job->jobTypes();
        $salaryTypes  = $job->salaryTypes();
        $defaultExperience  = $job->jobExperience();
        $defaultKeywords  = $job->jobKeywords();
        $postUrl = url('jobs');

        return view('jobs.job-info')->with('jobCategories', $jobCategories)
                                    ->with('job', $job) 
                                    ->with('cities', $cities) 
                                    ->with('defaultExperience', $defaultExperience) 
                                    ->with('salaryTypes', $salaryTypes) 
                                    ->with('defaultKeywords', $defaultKeywords) 
                                    ->with('jobTypes', $jobTypes)
                                    ->with('back_url', null)
                                    ->with('step', 'step-one')
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
        $experience = $data['experience'];
        $salaryType = (isset($data['salary_type']))?$data['salary_type']:0;
        $salaryLower = $data['salary_lower'];
        $salaryUpper = $data['salary_upper'];

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
            $postExperience = explode(',', $experience);
            $metaData['experience'] = $postExperience; 
            $experienceLowerUpperValue = $this->getExperienceLowerAndUpperValue($postExperience); 
            
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
        $job->save();

        $jobId = $job->id;

        $this->addJobLocation($job,$jobArea);
        // $this->addJobKeywords($job,$jobKeywords);
        Session::flash('success_message','Job details successfully saved.');
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
                $experienceValues = explode('-', $experience);
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
    public function show($id)
    {
        //
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

        if($step == 'step-one'){
            $jobCategories = [1=>'cat-1',2=>'cat-2'];
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

        }
        elseif ($step == 'step-two'){
            $jobCompany  = $job->getJobCompany();
            $data['jobCompany'] = $jobCompany;
            $data['back_url'] = url('jobs/'.$job->reference_id.'/step-one'); 
            $blade = 'jobs.job-company';
        }
        elseif ($step == 'step-three'){
            # code...
        }
        else{

            abort(404);
        }
 
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
        $experience = $data['experience'];
        $salaryType = (isset($data['salary_type']))?$data['salary_type']:0;
        $salaryLower = $data['salary_lower'];
        $salaryUpper = $data['salary_upper'];

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
            $savedExperience = explode(',', $experience);
            $metaData['experience'] = $savedExperience; 
            $experienceLowerUpperValue = $this->getExperienceLowerAndUpperValue($savedExperience);
            
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
        $job->save();
        $this->addJobLocation($job,$jobArea);
        // $this->addJobKeywords($job,$jobKeywords);
        Session::flash('success_message','Job details successfully saved.');
        $request['next_step'] = 'step-two';

        return $request;
    }


    public function saveCompanyData($job,$request){ 
        $userId = Auth::user()->id;
        $this->validate($request, [
            'company_name' => 'required|max:255',
        ]);

        $data = $request->all();    

        $companyId = $data['company_id'];
        $title = $data['company_name'];
        $description = $data['company_description'];
        $website = $data['company_website'];
 
        
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
            
        Session::flash('success_message','Job details successfully saved.');
        $request['next_step'] = 'step-two';

        return $request;
    }

    public function getKeywords(Request $request)
    { 
        $this->validate($request, [
            'keyword' => 'required',
        ]);

    
        $jobKeywords =  Defaults::where("type","job_keyword")->where('label', 'like', '%'.$request->keyword.'%')->select('id', 'label')->get()->toArray();
        
        return response()->json(['results' => $jobKeywords, 'options' => []]);
    }

    public function submitForReview($reference_id){
 
        $job = Job::where('reference_id',$reference_id)->first();
        $job->status = 2; 
        $job->save();

        Session::flash('success_message','Job details submitted for review.');
        return redirect(url('/jobs/'.$job->reference_id.'/step-one')); 
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
