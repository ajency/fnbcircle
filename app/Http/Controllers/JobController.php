<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Job;
use App\JobLocation;
use App\Category;
use App\City;
use App\Defaults;
use Auth;


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
        $experiencList = [1=>'1 - 2',2=>'3 - 4',3=>'5 - 8'];
        $cities  = City::where('status', 1)->orderBy('name')->get();

        $job    = new Job;
        $jobTypes  = $job->jobTypes();
        $salaryTypes  = $job->salaryTypes();
        $postUrl = url('jobs');

        return view('jobs.job-info')->with('jobCategories', $jobCategories)
                                    ->with('cities', $cities) 
                                    ->with('experiencList', $experiencList) 
                                    ->with('salaryTypes', $salaryTypes) 
                                    ->with('jobTypes', $jobTypes)
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
        $jobType = $data['job_type'];
        $experience = $data['experience'];
        $salaryType = $data['salary_type'];
        $salaryLower = $data['salary_lower'];
        $salaryUpper = $data['salary_upper'];

        $metaData = [] ;

        if(is_array($jobType) && !empty($jobType)){
            $metaData['job_type'] = $jobType;
            $jobType = $jobType[0];
        }

        $experienceYearsLower = '';
        $experienceYearsUpper  = '';

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
        $job->save();

        $jobId = $job->id;

        $this->addJobLocation($job,$jobArea);

        return redirect(url('/jobs/'.$job->reference_id.'/step-two')); 

    }

    public function addJobLocation($job,$areaIds){
        foreach ($areaIds as $key => $areaId) {
            $jobLocation = $job->hasLocations()->where('area_id',$areaId)->first();

            if(empty($jobLocation)){ 
                $jobLocation    = new JobLocation;
                $jobLocation->job_id = $job->id;
                $jobLocation->area_id = $areaId;
                $jobLocation->save();
            }
        }

        return true;
        
    }

    public function getExperienceLowerAndUpperValue($experience){
        $getExperience = Defaults::whereIn('id',$experience)->get()->toArray();
        $lower = $upper =[];
        
   
        $getExperience =[
          0 => [
            "id" => 1,
            "label" => "1 - 2"
          ],
          1 => [
            "id" => 3,
            "label" => "3 - 4"
          ],
          2 => [
            "id" => 3,
            "label" => "5 - 8"
          ]
        ] ;  
            
        foreach ($getExperience as $key => $experience) {
            $experienceLabel = $experience['label'];
            $experienceValues = explode('-', $experienceLabel);

            if(!empty($experienceValues)){
                $lower[] = trim($experienceValues[0]);
                $upper[] = trim($experienceValues[1]);
            }

        } 

        return ['lower'=> min($lower), 'upper'=>max($upper)];
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
        $data = ['job' => $job->toArray()];
        $postUrl = url('jobs/'.$job->reference_id);
        $data['postUrl'] = $postUrl;

        if($step = 'step-one'){
            $jobCategories = [1=>'cat-1',2=>'cat-2'];
            $experiencList = [1=>'1-2',2=>'3-4',3=>'5-8'];
            $cities  = City::where('status', 1)->orderBy('name')->get();

            $jobTypes  = $job->jobTypes();
            $salaryTypes  = $job->salaryTypes();
            

            $locations = $job->hasLocations()->get()->toArray(); 
            $data['location'] = $locations;
            $data['jobCategories'] = $jobCategories;
            $data['experiencList'] = $experiencList;
            $data['cities'] = $cities;
            $data['jobTypes'] = $jobTypes;
            $data['salaryTypes'] = $salaryTypes;
            $blade = 'jobs.job-edit';

        }
        elseif ($step = 'step-two'){
            # code...
        }
        elseif ($step = 'step-three'){
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
        //
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
