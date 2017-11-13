@extends('layouts.app')

@section('title')
Job Listing
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/dropify.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/jquery-flexdatalist/jquery.flexdatalist.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('js/ion-rangeslider/css/ion.rangeSlider.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('js/ion-rangeslider/css/ion.rangeSlider.skinModern.css') }}">
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/dropify.js') }}"></script>
<script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jobs.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/jquery-flexdatalist/jquery.flexdatalist.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

 
    <script type="text/javascript">
    $(document).ready(function() {
      
         setTimeout((function() {
            $('.alert-success').addClass('active');
          }), 1000);

          setTimeout((function() {
            $('.alert-success').removeClass('active');
          }), 6000);    });
    </script> 
 
@endsection

@section('content')
@include('jobs.notification')
<!-- <body class="highlight-color"> -->
    
    <!-- content -->
 

    <!-- Container -->
    <div class="container">
        <div class="row m-t-30 p-t-30 m-b-30 mobile-flex breadcrums-container mobile-hide">
            <div class="col-sm-8 flex-col">
                <!-- Breadcrums -->

                 
                <!-- Breadcrums ends -->
            </div>
            <div class="col-sm-4 flex-col">
            </div>
        </div>
        <!-- section headings -->
        <div class="row addShow">
            <div class="col-sm-8 mobile-hide">
                <h5 class="m-t-0">Jobs   <span class="serach_state_name">Posted</span></h5>
            </div>
        </div>
        <!-- section heading ends -->

        <div class="row m-t-25 row-margin">
            
            <div class="col-sm-9 custom-col-9 job-listings">
            @php
                $jobs = $jobPosted;
                echo View::make('jobs.job-listing-card', compact('jobs'))->with(['isListing'=>false,'append'=>false])->render();  
            @endphp    
            </div>
 
        </div>


        <div class="row addShow">
            <div class="col-sm-8 mobile-hide">
                <h5 class="m-t-0">Jobs   <span class="serach_state_name">Applied</span></h5>
            </div>
        </div>
        <!-- section heading ends -->

        <div class="row m-t-25 row-margin">
            
            <div class="col-sm-9 custom-col-9 job-listings">
            @php
                $jobs = $jobApplication;
                echo View::make('jobs.job-listing-card', compact('jobs'))->with(['isListing'=>false,'append'=>false,'showApplication'=>true])->render();  
            @endphp    
            </div>
 
        </div>
        <div class="site-overlay"></div>
    </div>


 <div class="row addShow">
            <div class="col-sm-8 mobile-hide">
                <h5 class="m-t-0">My   <span class="serach_state_name">Resume</span></h5>
            </div>
        </div>
    <div class=" ">
                    <form id="job-form" method="post" action="{{url('customer-dashboard/users/update-resume')}}"   enctype="multipart/form-data">
                         
                            
                            <div class="has_resume @if(empty($userResume['resume_id'])) hidden @endif">
                                <span class="text-lighter">Resume last updated on: {{ $userResume['resume_updated_on'] }}</span>
                                <input type="hidden" name="resume_id" value="{{ $userResume['resume_id'] }}">
                                <a href="{{ url('/user/download-resume')}}?resume={{ $userResume['resume_url'] }}">download</a> <a href="javascript:void(0)" class="remove_resume">Remove</a>
                            </div>
                            
                            <div class="no_resume @if(!empty($userResume['resume_id'])) hidden @endif"> 
                                <p class="default-size heavier m-b-0">You do not have resume uploaded on your profile</p>
                                Please upload your resume
                            </div>
                            

                            <div class="row m-t-15 m-b-15 c-gap">
                            <div class="col-sm-4 fileUpload">
                                <input type="file" name="resume" class="resume-upload" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="doc docx pdf" data-parsley-errors-container="#resume-error"/> 
                                <div id="resume-error"></div>
                            </div>
                          </div>

                             <button class="btn fnb-btn primary-btn border-btn code-send full center-block" type="submit">Upload Resume <i class="fa fa-circle-o-notch fa-spin hidden"></i></button>
 
                        </form>
                        </div>


 <div class="row addShow">
            <div class="col-sm-8 mobile-hide">
                <h5 class="m-t-0">Configure   <span class="serach_state_name">Job Alerts</span></h5>
            </div>
        </div>
    <div class=" ">
                    <form id="job-form" method="post" data-parsley-validate action="{{url('customer-dashboard/users/set-job-alert')}}"   enctype="multipart/form-data">
                         
                        
                         
                        <div class="col-sm-6 c-gap">
                        <label class="label-size  ">Choose a business type:</label>
                 
                        <div class="brands-container businessType">
                             <select class="fnb-select select-variant form-control text-color" name="category" placeholder="Type and hit enter" list="jobCats" id=jobCatsInput  >
                                <option value="">Select Category</option>
                                    @foreach($jobCategories as $categoryId =>$category)
                                    <option value="{{ $categoryId }}"  @if($jobAlertConfig['category'] == $categoryId) selected @endif >{{ ucwords($category) }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="m-t-40 c-gap areas-select job-areas">

        <label class="label-size  ">Where is the job located?  </label>
         <?php $i = 1?>
         @if(isset($jobAlertConfig['job_location']) && !empty($jobAlertConfig['job_location']))
         @foreach($jobAlertConfig['job_location'] as $cityId => $jobLocation)
 
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
                    @foreach($areas[$cityId] as $area)
                        <option @if(!empty($jobLocation) && in_array($area['id'],$jobLocation)) selected @endif value="{{ $area['id'] }}">{{ $area['name'] }}</option>
                    @endforeach
 
                </select>
                <div id="city-errors{{ $i }}" class="city-errors fnb-errors"></div>
            </div>
            
            <div class=" remove-select-col removelocRow flex-row ">
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
            <a href="javascript:void(0)" class="secondary-link text-decor heavier add-job-areas">+ Add more</a>
        </div>
        <div id="areaError" ></div>
    </div>


                    <div class="m-t-40 c-gap J-type">
                        <label class="label-size">What type of a job is it? <span class="text-lighter">(optional)</span></label>
                        <div class="form-group m-t-5 job-type mobile-flex flex-row flex-wrap">
                        @foreach($jobTypes as $jobTypeId => $jobType)
                          <label class="checkbox-inline">
                            <input type="checkbox" name="job_type[]" id="job_type" value="{{ $jobTypeId }}" class="fnb-checkbox custom-checkbox" @if(isset($jobAlertConfig['job_type']) && in_array($jobTypeId,$jobAlertConfig['job_type'])) checked @endif> {{ $jobType }}
                          </label>
                        @endforeach 
                        </div>
                    </div>

                    <div class="m-t-40 c-gap">
                        <label class="label-size  ">Select job roles:</label>
                  
                        <div class="m-t-5 flex-data-row">
                            <input type="text" class="form-control fnb-input job-keywords" data-parsley-required-message="At least one job role should be added" name="job_keyword" placeholder="Search and select from the list below" list="jobKeyword" multiple="multiple" id=jobKeywordInput   @if(isset($jobAlertConfig['job_keyword']) && !empty($jobAlertConfig['job_keyword'])) value='{{ $jobAlertConfig['job_keyword'] }}' @endif>

                            <datalist id="jobKeyword">
                              
                            </datalist>
                            <div id="keyword-ids">
                              @if(isset($jobAlertConfig['keywords_id']) && !empty($jobAlertConfig['keywords_id']))
                                @foreach($jobAlertConfig['keywords_id'] as $keywordId => $keyword )
                                <input type="hidden" name="keyword_id[{{ $keywordId }}]" value="{{ $keyword }}" label="">
                                @endforeach
                                @endif      
                            </div>
                        </div>
                    </div>

                    <div class="m-t-40 c-gap flex-data-row">
        <label class="label-size">Experience: </label>
 
        <div class="m-t-5 brands-container auto-exp-select catSelect">

              <select class="fnb-select select-variant form-control text-lighter expSelect" name="experience[]" id="yrsExpInput"  multiple="multiple">
                @foreach($defaultExperience as $experienceId =>$experience)
                    <option @if(isset($jobAlertConfig['experience']) && in_array($experience,$jobAlertConfig['experience'])) selected @endif  value="{{ $experience }}">{{ $experience }}</option>
                @endforeach

            </select>
 
        </div>
        </div>

        <div class="m-t-40 c-gap salary-row mobile-flex flex-wrap">
        <label class="label-size">What is the salary for this job?  </label>
        <div class="form-group m-t-5">
        @foreach($salaryTypes as $salaryTypeId => $salaryType)
          <label class="radio-inline">
            <input type="radio" name="salary_type" class="fnb-radio"   value="{{ $salaryTypeId }}"   data-parsley-errors-container="#salary-type-errors" data-parsley-required-message="Please select salary type."  @if($jobAlertConfig['salary_type'] == $salaryTypeId) checked @endif> {{ $salaryType }}
          </label>
        @endforeach 
        <div id="salary-type-errors" class="fnb-errors"></div>
        </div>
        
        <div class="salary-range flex-row">
            <div class="flex-row">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-inr" aria-hidden="true"></i></span>
 
     
                  <input type="number" min="0" class="form-control salary-amt " name="salary_lower" id="salary_lower"  data-parsley-type="number" aria-describedby="inputGroupSuccess3Status"  @if($jobAlertConfig['salary_type']) data-parsley-required salary-type-checked="true" @else salary-type-checked="false" @endif    data-parsley-errors-container="#errors" data-parsley-required-message="Please enter minimum salary." salary_type_checked max="300000000" value="{{ $jobAlertConfig['salary_lower'] }}">
               
                   <div id="errors" class="ctm-error fnb-errors"></div>
                </div>
                <p class="m-b-0 sal-divider">to</p>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-inr" aria-hidden="true"></i></span>
 
                  <input type="number" class="form-control salary-amt" name="salary_upper" id="salary_upper" data-parsley-type="number" aria-describedby="inputGroupSuccess3Status"    data-parsley-errors-container="#error" data-parsley-required-message="Please enter maximum salary." max="300000000" value="{{ $jobAlertConfig['salary_upper'] }}">
 
                   <div id="error" class="ctm-error fnb-errors"></div>
                </div>
                
            </div>
            <a href="javascript:void(0)" class="p-l-20 clear-salary secondary-link text-decor dis-block">Clear</a>

        </div>

    </div>
    Send job alerts : <input type="checkbox" {{ ($sendJobAlerts) ? 'checked' : '' }}  name="send_job_alerts" value="1">                   
                      

          
                         <button class="btn fnb-btn primary-btn border-btn code-send full center-block" type="submit">Save Configuration <i class="fa fa-circle-o-notch fa-spin hidden"></i></button>
 
                        </form>
                        </div>

@endsection
<!-- </body> -->
