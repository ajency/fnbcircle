@extends('layouts.add-job')
@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/maps.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jobs.js') }}"></script>
    @if($job->id)
     <script type="text/javascript">
    // $(document).ready(function() {
    //     getAddress();
    // });
    </script> 
    @endif 
@endsection
@section('form-data')

@include('jobs.notification')
 
@if($job->id)
<input type="hidden" name="_method" value="PUT">
@endif
<input type="hidden" name="step" value="job-details">
 

<div class="business-info tab-pane fade in active" id="job_details">
 
    <!-- <h5 class="no-m-t fly-out-heading-size main-heading white m-t-0 margin-btm ">Job Information</h5> -->
    <div class="flex-row space-between preview-detach">
        <h5 class="nno-m-t main-heading  white m-t-0">Job Details</h5>
    </div>

    <!-- Job title/category -->
    <div class="m-t-40 c-gap">

        <div class="m-t-5 brands-container">
            
        <div class="row">
            <div class="col-sm-6">
                <label class="label-size required">What is the job title?</label>
                <input type="text" name="job_title" class="form-control fnb-input" placeholder=""  data-parsley-required-message="Please enter the job title." data-parsley-required data-parsley-maxlength=255 data-parsley-maxlength-message="Job name cannot be more than 255 characters." data-parsley-required data-parsley-minlength=2 data-parsley-minlength-message="Job name cannot be less than 2 characters." value="{{ $job['title'] }}">
                <div class="text-lighter m-t-5 x-small">
                    This will be the display name of your job.
                </div>
            </div>
            <div class="col-sm-6 c-gap">
                <label class="label-size required">Choose a business type:</label>
                <!-- <div class="text-lighter">
                    Help text comes here
                </div> -->
                <div class="brands-container businessType">
                     <select class="fnb-select select-variant form-control text-color" name="category" placeholder="Type and hit enter" list="jobCats" id=jobCatsInput value="" data-parsley-required data-parsley-required-message="Please select a business type">
                        <option value="">Select Category</option>
                            @foreach($jobCategories as $categoryId =>$category)
                            <option value="{{ $categoryId }}" @if($job['category_id'] == $categoryId) selected @endif>{{ ucwords($category) }}</option>
                            @endforeach
                    </select>
                </div>
            </div>
 
        </div>
        
    </div>
</div>

    <!-- Job keywords -->

    <div class="m-t-40 c-gap">
        <label class="label-size required">Select job roles:</label>
        <div class="text-lighter m-b-15 x-small">(Add as many Keywords, Functions &amp; skills to get maximum response).</div>
        <div class="m-t-5 flex-data-row">
            <input type="text" class="form-control fnb-input job-keywords" data-parsley-required-message="At least one job role should be added" name="job_keyword" placeholder="Search and select from the list below" list="jobKeyword" multiple="multiple" id=jobKeywordInput @if(isset($job['meta_data']['job_keyword']) && !empty($job['meta_data']['job_keyword'])) value='{{ implode(",",$job['meta_data']['job_keyword']) }}' @endif  >

            <datalist id="jobKeyword">
              
            </datalist>
            <div id="keyword-ids">
                @if(isset($job['meta_data']['job_keyword']) && !empty($job['meta_data']['job_keyword']))
                @foreach($job['meta_data']['job_keyword'] as $keywordId => $keyword)
                <input type="hidden" name="keyword_id[{{ $keywordId }}]" value="{{ $keyword }}" label="">
                @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Job located -->

    <div class="m-t-40 c-gap areas-select job-areas">

        <label class="label-size required">Where is the job located?  </label>
         <?php $i = 1?>
        @if($job->id)
       
        @foreach($savedjobLocation as $cityId => $jobLocation)
 
        <div class="location-select cityArea flex-row flex-wrap clone-row">
            <div class="select-col city">
                <select class="fnb-select select-variant form-control text-lighter" name="job_city[]" data-parsley-required data-parsley-required-message="Select a state where the job is located." data-parsley-errors-container="#state-errors{{ $i }}">
                    <option value="">Select State</option>
                    @foreach($cities as $city)
                        <option @if($cityId == $city->id) selected @endif  value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
                <div id="state-errors{{ $i }}" class="state-errors fnb-errors"></div>
            </div> 
            <div class="select-col area">
 
                <select class="fnb-select select-variant form-control text-lighter default-area-select job-areas" name="job_area[{{ $cityId }}][]" data-parsley-required data-parsley-required-message="Select city where the job is located." multiple="multiple" data-parsley-errors-container="#city-errors{{ $i }}">
                    @foreach($savedAreas[$cityId] as $area)
                        <option @if(!empty($jobLocation) && in_array($area['id'],$jobLocation)) selected @endif value="{{ $area['id'] }}">{{ $area['name'] }}</option>
                    @endforeach
 
                </select>
                <div id="city-errors{{ $i }}" class="city-errors fnb-errors"></div>
            </div>
            
            <div class=" remove-select-col flex-row removelocRow ">
                <i class="fa fa-times text-primary" aria-hidden="true"></i>
            </div>
            
        </div>
        <?php $i ++?>
        @endforeach
        @else
        <div class="location-select flex-row flex-wrap clone-row">
            <div class="select-col city">
                <select class="fnb-select select-variant form-control text-lighter" name="job_city[]" data-parsley-required data-parsley-required-message="Select a state where the job is located." data-parsley-errors-container="#state-errors{{ $i }}">
                    <option value="">Select State</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
                <div id="#state-errors{{ $i }}" class="state-errors fnb-errors"></div>
            </div> 
            <div class="select-col area">
 
                <select class="fnb-select select-variant form-control text-lighter default-area-select job-areas" name="job_area[][]" data-parsley-required data-parsley-required-message="Select city where the job is located." multiple="multiple" data-parsley-errors-container="#city-errors{{ $i }}">
                    
                </select>
                <div id="city-errors{{ $i }}" class="city-errors fnb-errors"></div>
            </div>
        </div>

        @endif
        
         <div class="location-select cityArea flex-row flex-wrap area-append hidden" >

            <div class="select-col city">
 
                <select class="fnb-select select-variant form-control text-lighter selectCity" name="job_city[]" >
 
                    <option value="">Select State</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
                <div id="state-errors" class="state-errors fnb-errors"></div>
            </div>
            <div class="select-col area">

                <select class="fnb-select select-variant form-control text-lighter areas-appended job-areas" name="job_area[]" multiple="multiple" data-parsley-errors-container="#site-errors">
 
                </select>
               <div id="city-errors" class="city-errors fnb-errors"></div>
            </div>
            <div class=" remove-select-col removelocRow flex-row">
                <i class="fa fa-times text-primary" aria-hidden="true"></i>
            </div>
        </div>
        <div class="adder">
            <a href="#" class="secondary-link text-decor heavier add-job-areas">+ Add more</a>
        </div>
        <div id="areaError" ></div>
    </div>

    <!-- map -->
    <div class="m-t-30 c-gap">
        <label class="label-size">Please provide the google map address for the interview location <span class="text-lighter">(optional)</span></label>

        <div class="text-lighter">
            Note: You can drag the pin on the map to point to the desired address
        </div>
    </div>
    <div class="m-t-20 c-gap">
        <input id="mapadd" type="text" class="form-control fnb-input location-val" name="interview_location" placeholder="Ex: Shop no 4, Aarey Milk Colony, Mumbai" value="{{ $job->interview_location }}">
        <div class="m-t-10" id="map" map-title="your interview location" >

        </div>
        <input type="hidden" id=latitude name=latitude value="{{ $job->getInterviewLocationLat() }}">
        <input type="hidden" id=longitude name=longitude value="{{ $job->getInterviewLocationLong() }}">

    </div>

    <!-- Job description -->

    <div class="m-t-40 c-gap">
 
        <label class="label-size required">Enter the job description:</label>
        <textarea class="form-control fnb-input" name="description" id="editor" placeholder="Enter a brief summary of the Job" data-parsley-required data-parsley-required-message="Please enter the job description">{{ $job['description'] }}</textarea>
         
 
    </div>

    <!-- Job type -->
    
    <div class="m-t-40 c-gap J-type">
        <label class="label-size">What type of a job is it? <span class="text-lighter">(optional)</span></label>
        <div class="form-group m-t-5 job-type mobile-flex flex-row flex-wrap">
        @foreach($jobTypes as $jobTypeId => $jobType)
          <label class="checkbox-inline">
            <input type="checkbox" name="job_type[]" id="job_type" value="{{ $jobTypeId }}" class="fnb-checkbox custom-checkbox" @if(isset($job['meta_data']['job_type']) && in_array($jobTypeId,$job['meta_data']['job_type'])) checked @endif> {{ $jobType }}
          </label>
        @endforeach 
        </div>
    </div>

    <!-- Experience -->

    <div class="m-t-40 c-gap flex-data-row">
        <label class="label-size">Mention the required years of experience: <span class="text-lighter">(optional)</span></label>
 
        <div class="m-t-5 brands-container auto-exp-select catSelect">

              <select class="fnb-select select-variant form-control text-lighter expSelect" name="experience[]" id="yrsExpInput"  multiple="multiple">
                @foreach($defaultExperience as $experienceId =>$experience)
                    <option @if(isset($job['meta_data']['experience']) && in_array($experience,$job['meta_data']['experience'])) selected @endif value="{{ $experience }}">{{ $experience }}</option>
                @endforeach

            </select>

            <!-- <input type="text" class="form-control fnb-input years-experience" name="experience" placeholder="Type and hit enter" list="yrsExp" multiple="multiple" id="yrsExpInput" @if(isset($job['meta_data']['experience']) && !empty($job['meta_data']['experience'])) value='{{ implode(",",$job['meta_data']['experience']) }}' @endif>
 

            <datalist id="yrsExp">
               @foreach($defaultExperience as $experienceId =>$experience)
                <option value="{{ $experienceId }}" >{{ $experience }}</option>
                @endforeach
            </datalist> -->
            <!--  <div class="m-t-10">
                <a href="#" class="secondary-link text-decor heavier add-custom">+ Add custom</a>
            </div> -->
        </div>
        <!-- <div class="m-t-5 custom-exp hidden">
            <div class="row custom-row">
                <div class="col-sm-3">
                    <label class="x-small exp-label">Min experience</label>
                    <select class="fnb-select select-variant form-control text-lighter min-exp p-l-0">
                        <option>--Please select--</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class="x-small exp-label">Max experience</label>
                     <select class="fnb-select select-variant form-control text-lighter max-exp p-l-0">
                        <option>--Please select--</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <a href="#" class="add-exp"><i class="fa fa-plus-circle text-primary sub-title" aria-hidden="true"></i></a>
                    <a href="#" class="delete-exp hidden"><i class="fa fa-times text-primary sub-title" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="m-t-10">
                <a href="#" class="secondary-link text-decor heavier auto-select">Auto Select</a>
            </div>
        </div> -->
    </div>

    <!-- Offered salary -->

    <div class="m-t-40 c-gap salary-row mobile-flex flex-wrap">
        <label class="label-size">What is the salary for this job? <span class="text-lighter">(optional)</span> </label>
        <div class="form-group m-t-5">
        @foreach($salaryTypes as $salaryTypeId => $salaryType)
          <label class="radio-inline">
            <input type="radio" name="salary_type" class="fnb-radio"  @if($job['salary_type'] == $salaryTypeId) checked @endif value="{{ $salaryTypeId }}"   data-parsley-errors-container="#salary-type-errors" data-parsley-required-message="Please select salary type."> {{ $salaryType }}
          </label>
        @endforeach 
        <div id="salary-type-errors" class="fnb-errors"></div>
        </div>
        
        <div class="salary-range flex-row">
            <div class="flex-row">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-inr" aria-hidden="true"></i></span>
 
     
                  <input type="number" min="0" class="form-control salary-amt " name="salary_lower" id="salary_lower"  data-parsley-type="number" aria-describedby="inputGroupSuccess3Status"  @if($job['salary_type']) data-parsley-required salary-type-checked="true" @else salary-type-checked="false" @endif   value="{{ $job['salary_lower'] }}" data-parsley-errors-container="#errors" data-parsley-required-message="Please enter minimum salary." salary_type_checked max="300000000">
               
                   <div id="errors" class="ctm-error fnb-errors"></div>
                </div>
                <p class="m-b-0 sal-divider">to</p>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-inr" aria-hidden="true"></i></span>
 
                  <input type="number" class="form-control salary-amt" name="salary_upper" id="salary_upper" data-parsley-type="number" aria-describedby="inputGroupSuccess3Status" @if($job['salary_lower']!='') data-parsley-required @endif @if($job['salary_type']) data-parsley-required @endif value="{{ $job['salary_upper'] }}" data-parsley-errors-container="#error" data-parsley-required-message="Please enter maximum salary." max="300000000">
 
                   <div id="error" class="ctm-error fnb-errors"></div>
                </div>
                
            </div>
            <a href="javascript:void(0)" class="p-l-20 clear-salary secondary-link text-decor dis-block">Clear</a>

        </div>

    </div>

    </div>



@endsection
