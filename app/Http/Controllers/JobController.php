<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\JobLocation;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $userId = Auth::user()->id;

        $this->validate($data, [
            'title' => 'required|max:255',
            'description' => 'required',
            'job_city' => 'required|integer',
            'job_area' => 'required|integer',
            'category' => 'required|integer'

        ]);

        $title = $data['title'];
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
        $job->reference_id = '';
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

        $this->addJobLocation($job,$job_area);

        return redirect(url('/jobs/'.$job->reference_id.'/edit/set-two')); 

    }

    public function addJobLocation($job,$areaIds){
        foreach ($areaIds as $key => $areaId) {
            $jobLocation = $job->hasLocations()->where('area_id',$areaId)->first();

            if(!empty($jobLocation)){ 
                $jobLocation    = new JobLocation;
                $jobLocation->job_id = $job->id;
                $jobLocation->area_id = $areaId;
                $jobLocation->save();
            }
        }

        return true;
        
    }

    public function getExperienceLowerAndUpperValue($experience){
        $getExperience = Defaults:: where('id IN',$experience)->get()->toArray();
        $lower = $upper =[];

        foreach ($getExperience as $key => $experience) {
            $experienceLabel = $experience->label;
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
