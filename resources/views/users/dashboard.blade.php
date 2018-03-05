@extends('layouts.app')

@section('title')
Dashboard
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/dropify.css') }}">
<!-- Multiselect -->
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-multiselect.min.css') }}">

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
<script type="text/javascript" src="{{ asset('js/customer-dashboard.js') }}"></script>

@endsection

@section('content')
@include('jobs.notification')
<!-- <body class="highlight-color"> -->
    
    <!-- content -->
 


        <div class="single-view-head">

            <div class="container">
   

                    <!-- No activity -->

            <!--     <div class="row m-b-30 m-t-30">
                    <div class="col-sm-12 p-l-0 no-p-l">
                        <div class="pre-benefits flex-row no-listing-job">
                            <div class="pre-benefits__intro flex-row">
                                <i class="fa fa-frown-o text-primary sad-icon" aria-hidden="true"></i><div class="pre-benefits__content">
                                    <h5 class="section-title pre-benefits__title">You don't have any Business Listings or Job Posts yet !</h5>
                                    <p class="sub-title pre-benefits__caption lighter text-color m-b-0">Your Business Listings and Job Posts will appear here.</p>
                                </div>
                            </div>
                            <a href="#" class="btn fnb-btn primary-btn full border-btn get-dash-started">Get Started Now</a>
                        </div>
                    </div>
                </div>
 -->
                <!-- No activity div ends -->


<!--         <div class="selection-card flex-row space-between">
            <div class="card business-card flex-row space-between">
                <div class="card__section own-business">
                    <h5>Do you own a<br> Business?</h5>
                    <button class="btn fnb-btn outline  border-btn" type="button" >
                        Create a Listing
                    </button>
                </div>
                <div class="card__section or flex-row">
                    <div class="or__text flex-row">OR</div>
                </div>
                <div class="card__section browse-business">
                    <h5>Browse other<br> Businesses</h5>
                    <button class="btn fnb-btn outline  border-btn" type="button" >
                        Browse Listings
                    </button>
                </div>
            </div>
            <div class="card card-jobs-card flex-row space-between">
                <div class="card__section own-business">
                    <h5>Looking for<br> talent?</h5>
                    <a href="{{ url('/jobs/create') }}" target="_blank"><button class="btn fnb-btn outline  border-btn" type="button" >
                        Post A Job
                    </button></a>
                </div>
                <div class="card__section or flex-row">
                    <div class="or__text flex-row">OR</div>
                </div>
                <div class="card__section browse-business">
                    <h5>View jobs on<br> FnB Circle</h5>
                    <a href="{{ url($browserState.'/job-listings') }}" target="_blank"><button class="btn fnb-btn outline  border-btn" type="button" >
                        Browse Jobs
                    </button></a>
                </div>
            </div>
        </div> -->

            <div class="row m-t-30">
                <div class="col-sm-8 m-t-15 m-b-10">
                    <div class="cust-dashboard__title">
                        <h4 class="cloud-color dashboardTitle">My Dashboard</h4>
                        <!-- <p class="element-title cloud-color m-b-0 lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br> Nemo, quidem. Magni autem ipsum est, quos numquam unde voluptatibus nobis quae.</p> -->
                    </div>
                </div>
            </div>

 
                <div class="row m-t-20 row-btm-space">

                    <div class="col-sm-8">

                    
                        <!-- No data -->
                       <div class="card no-listing-card flex-row">
                            <div class="featured-jobs browse-cat text-center customer-card flex-row space-between col-direction align-baseline">
                                <div class="customer-card__col flex-row">
                                    <div class="flex-row justify-center customer-card__logo">
                                        <img src="/img/create-list.png" class="img-responsive center-block">
                                    </div>
                                    <div class="text-left p-l-20">
                                        <h6 class="sub-title m-t-0 text-medium">Do you own a Business?</h6>
                                        <a href="{{url('/listing/create')}}" target="_blank" class="primary-link m-t-10 dis-block sub-title">Create a Listing</a>
                                    </div>
                                </div>
                                
                                <div class="customer-card__divider p-t-20 p-b-20">
                                    <p class="bolder x-small m-b-0">OR</p>    
                                </div>
                                
                                    
                                <div class="customer-card__col flex-row">
                                    <div class="flex-row justify-center customer-card__logo">
                                        <img src="/img/browse-business.png" class="img-responsive center-block" width="35">
                                    </div>
                                    <div class="text-left p-l-20">
                                        <h6 class="sub-title m-t-0 text-medium">Browse other Businesses</h6>
                                        <a href="{{ url($browserState.'/business-listings') }}" target="_blank" class="primary-link m-t-10 dis-block sub-title">Browse Listings</a>
                                    </div>
                                </div>   
                                
                            </div>
                            
                  

                            <div class="featured-jobs browse-cat text-center customer-card flex-row space-between col-direction align-baseline">
                                <div class="customer-card__col flex-row">
                                    <div class="flex-row justify-center customer-card__logo">
                                        <img src="/img/talent.png" class="img-responsive center-block" width="35">
                                    </div>
                                    <div class="text-left p-l-20">
                                        <h6 class="sub-title m-t-0 text-medium">Looking for talent?</h6>
                                        <a href="{{ url('/jobs/create') }}" target="_blank" class="primary-link m-t-10 dis-block sub-title">Post a Job</a>
                                    </div>
                                </div>
                                
                                <div class="customer-card__divider p-t-20 p-b-20">
                                    <p class="bolder x-small m-b-0">OR</p>    
                                </div>
                                
                                    
                                <div class="customer-card__col flex-row">
                                    <div class="flex-row justify-center customer-card__logo">
                                        <img src="/img/handshake.png" class="img-responsive center-block" width="35">
                                    </div>
                                    <div class="text-left p-l-20">
                                        <h6 class="sub-title m-t-0 text-medium">View jobs on FnB Circle</h6>
                                        <a href="{{ url($browserState.'/job-listings') }}" target="_blank" class="primary-link m-t-10 dis-block sub-title">Browse Jobs</a>
                                    </div>
                                </div>   
                                
                            </div>


                            <!-- <hr class="separator"> -->

                          <!--   <div class="row">
                                <div class="col-sm-3"></div>
                                
                                <div class="col-sm-6">
                                    
                                </div>
                                <div class="col-sm-3"></div>
                            </div> -->

                        </div>
                        
                        <!-- no data -->
                        
                        <!-- Nav tabs -->
                        @if($jobPosted->count() || $jobApplication->count() || $myListingsCount)
                       

                        <div class="your-activity tabs-listing">
                            
                            <div class="nav-info scroll-tabs">
                                <ul class="nav-info__tab flex-row" role="tablist">
                                    @if($myListingsCount)
                                        @php
                                        $activeJobPostedTab = '';
                                        $activeJobApplicationTab = '';
                                        @endphp
                                    @else
                                        @if($jobPosted->count())
                                            @php
                                            $activeJobPostedTab = 'active';
                                            $activeJobApplicationTab = '';
                                            @endphp
                                        @else
                                            @php
                                            $activeJobApplicationTab = 'active';
                                            @endphp
                                        @endif
                                    @endif

                                    @if($myListingsCount)
                                    <li role="presentation" class="nav-section active"><a href="#mylistings" aria-controls="mylistings" role="tab" data-toggle="tab">My Listings ({{$myListingsCount}})</a></li>
                                    @endif

                                    @if($jobPosted->count())
                                    <li role="presentation" class="nav-section {{ $activeJobPostedTab }}"><a href="#myjobs" aria-controls="myjobs" role="tab" data-toggle="tab">My Jobs ({{ count($jobPosted)}})</a></li>
                                    @endif

                                    @if($jobApplication->count())
                                    <li role="presentation" class="nav-section {{ $activeJobApplicationTab }}"><a href="#appliedjobs" aria-controls="appliedjobs" role="tab" data-toggle="tab">Jobs I Applied To ({{ count($jobApplication)}})</a></li>
                                    @endif
                                </ul>
                            </div>


                            <div class="tab-content">
                                @if($myListingsCount)
                                <div role="tabpanel" class="tab-pane active" id="mylistings">
                                    @php
                                            if ($myListingsCount){
                                                @endphp
                                                @include('list-view.single-card.listing_card', array('exclude_enquiry' => 'true'))
                                                @php
                                            }
                                            else{
                                                echo '<div class="no-results m-b-40">
                                                    <h4 class="seller-info__title ellipsis text-primary">No Listings Found <i class="fa fa-frown-o" aria-hidden="true"></i></h4>
                                                </div>';
                                            }
                                            
                                        @endphp
                                </div>
                                @endif

                                @if($jobPosted->count())
                                <div role="tabpanel" class="tab-pane {{ $activeJobPostedTab }}" id="myjobs">
                                    <div class="job-listings customer-jobs">
                                        @php
                                            $jobs = $jobPosted;
                                            if (count($jobs)){
                                                echo View::make('jobs.job-listing-card', compact('jobs'))->with(['isListing'=>false,'append'=>false])->render();  
                                            }
                                            else{
                                                echo '<div class="no-results m-b-40">
                                                    <h4 class="seller-info__title ellipsis text-primary">No Jobs Found <i class="fa fa-frown-o" aria-hidden="true"></i></h4>
                                                </div>';
                                            }
                                            
                                        @endphp
                                    </div>
                                </div>
                                @endif

                                @if($jobApplication->count())
                                <div role="tabpanel" class="tab-pane {{ $activeJobApplicationTab }}" id="appliedjobs">
                                    <div class="job-listings customer-jobs">
                                        @php
                                            $jobs = $jobApplication;
                                            if (count($jobs)){
                                                echo View::make('jobs.job-listing-card', compact('jobs'))->with(['isListing'=>false,'append'=>false,'showApplication'=>true])->render();  
                                            }
                                            else{
                                                echo '<div class="no-results m-b-40">
                                                    <h4 class="seller-info__title ellipsis text-primary">No Jobs Found <i class="fa fa-frown-o" aria-hidden="true"></i></h4>
                                                </div>';
                                            }
                                        @endphp 
                                    </div>
                                </div>
                                @endif

                            </div>

                        </div>
                        
                        @else


                        <div class="no-customer-activity text-center"> 
                            
                            <img src="/img/no-data.png" class="img-responsive center-block" width="100">

                            <p class="m-b-30 m-t-30 text-darker text-medium">You don't have any business listings or Job posts yet!
                            <br>
                            Your business listings and jobs will appear here and also the jobs that you apply to.</p>
                        </div>


                        @endif
                        
                    </div>


                    <div class="col-sm-4">
                        <div class="pos-fixed fly-out">
                            <div class="mobile-back desk-hide mobile-flex">
                               <div class="left mobile-flex">
                                  <i class="fa fa-arrow-left text-primary back-icon" aria-hidden="true"></i>
                                  <p class="element-title heavier m-b-0">Enquiry</p>
                               </div>
                               <div class="right">
                                  <!-- <a href="" class="text-primary heavier element-title">Clear All</a> -->
                               </div>
                            </div>
                            <div class="fly-out__content">
                                <form id="job-form" method="post" data-parsley-validate action="{{url('customer-dashboard/users/update-resume')}}"   enctype="multipart/form-data">
                                    <div class="card resume-card m-b-30">
                                        <div class="flex-row align-top">
                                            <img src="/img/resume.png" class="m-r-15">
                                            <div class="flex-1">
                                                <div class="enquiry-form__header flex-row space-between align-top m-b-10">
                                                    <div class="enquiry-title">
                                                        <p class="m-t-0 m-b-0 heavier">My Resume</p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="no_resume @if(!empty($userResume['resume_id'])) hidden @endif"> 
                                                        <p class="default-size text-lighter m-b-0">You do not have resume uploaded on your profile</p>
                                                        
                                                    </div>
                                                    <div class="m-t-10 fileUpload">
                                                            <input type="file" name="resume" class="@if(empty($userResume['resume_id'])) resume-upload @else resume-already-upload @endif" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="doc docx pdf" data-parsley-required data-parsley-errors-container="#resume-error"/> 
                                                            <div id="resume-error"></div>
                                                    </div>
                                                </div>
                                                <div class="catalogue flex-row has_resume @if(empty($userResume['resume_id'])) hidden @endif">
                                                    <p class="x-small flex-row m-b-0 text-color word-break align-top bolder">Resume last updated on: {{ $userResume['resume_updated_on'] }}</p>
                                                    <input type="hidden" name="resume_id" value="{{ $userResume['resume_id'] }}">
                                                    <div class="flex-row">
                                                        <a href="{{ url('/user/'.$userResume['resume_id'].'/download-resume')}}" class="customer-resume-download">
                                                            <span class="fnb-icons download"></span>
                                                        </a>
                                                        <a href="javascript:void(0)" class="remove_resume no-decor"><i class="fa fa-times p-l-10 remove-resume cursor-pointer" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                                <div class="form-group p-t-5 m-b-0">
                                                    <button class="btn fnb-btn btn-link code-send primary-link p-l-0 no-outline" type="submit">Upload Your Resume <i class="fa fa-circle-o-notch fa-spin fa-fw label-size hidden resume-loader"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                
                                <div class="enquiry-form card m-b-20 dash-enquiry-form">
                                    
                                    <form id="job-form" method="post" data-parsley-validate action="{{url('customer-dashboard/users/set-job-alert')}}" enctype="multipart/form-data" class="job-form @if($setNewAlert) hidden @endif">
                                        <div class="enquiry-form__header flex-row space-between align-top">
                                            <!-- <img src="img/enquiry.png" class="img-responsive p-r-10"> -->
                                            <div class="enquiry-title">
                                                <h6 class="element-title m-t-0 m-b-5">Job Alerts</h6>
                                                <p class="default-size text-lighter">You will receive job recommendation based on following</p>
                                            </div>
                                            <span class="fnb-icons enquiry"></span>
                                        </div>
                                        <div class="enquiry-form__body m-t-10">
                                            <div class="form-group">
                                                <label class="checkbox-inline send-alert">

                                                    <input type="checkbox" @if($sendJobAlerts == null)checked @endif {{ ($sendJobAlerts) ? 'checked' : '' }}  name="send_job_alerts" class="fnb-checkbox custom-checkbox" value="1"><span class="default-size">Send Alerts</span></span>
                                                </label>
                                            </div>
                                            
                                            <div class="form-group p-t-10">
                                                <label class="label-size required">Choose a business type:</label>
                                                <div class="brands-container businessType">
                                                     <select class="fnb-select select-variant form-control text-color" name="category" placeholder="Type and hit enter" list="jobCats" id=jobCatsInput data-parsley-required data-parsley-required-message="Select a business type." data-parsley-errors-container="#category-error" >
                                                        <option value="">Select Category</option>
                                                            @foreach($jobCategories as $categoryId =>$category)
                                                            <option value="{{ $categoryId }}"  @if($jobAlertConfig['category'] == $categoryId) selected @endif >{{ ucwords($category) }}</option>
                                                            @endforeach
                                                    </select>
                                                    <div id="category-error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group p-t-10 flex-data-row">
                                                 <label class="label-size required">Job Roles</label>
                                                 <div class="flex-data-row">
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
                                            <div class="form-group p-t-10 job-alert-location areas-select job-areas">
                                                <label class="label-size">Where is the job located?  </label>
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
                                                            <div class="adder m-t-10">
                                                                <a href="#" class="secondary-link text-decor heavier add-job-areas">+ Add more</a>
                                                            </div>
                                                        <div id="areaError" ></div>
                                            </div>
    

                                             <div class="collapse form-collapse-hide" id="more-field">

                                                <div class="form-group p-t-10">
                                                    <label class="label-size">Job Type</label>
                                                    <div class="form-group m-t-5 job-type mobile-flex flex-row flex-wrap align-top">
                                                        @foreach($jobTypes as $jobTypeId => $jobType)
                                                          <label class="checkbox-inline">
                                                            <input type="checkbox" name="job_type[]" id="job_type" value="{{ $jobTypeId }}" class="fnb-checkbox custom-checkbox" @if(isset($jobAlertConfig['job_type']) && in_array($jobTypeId,$jobAlertConfig['job_type'])) checked @endif> {{ $jobType }}
                                                          </label>
                                                        @endforeach 
                                                    </div>
                                                </div>
                                                <div class="form-group p-t-10">
                                                    <label class="label-size">Years of experience</label>
                                                        <div class="brands-container businessType auto-exp-select">
                                                          <select class="fnb-select select-variant form-control text-lighter expSelect" name="experience[]" id="yrsExpInput"  multiple="multiple">
                                                            @foreach($defaultExperience as $experienceId =>$experience)
                                                                <option @if(isset($jobAlertConfig['experience']) && in_array($experience,$jobAlertConfig['experience'])) selected @endif  value="{{ $experience }}">{{ $experience }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group p-t-10">
                                                    <label class="label-size">Salary</label>
                                                    <div class="form-group m-t-5">
                                                        <div class="flex-row flex-wrap align-top">
                                                            @foreach($salaryTypes as $salaryTypeId => $salaryType)
                                                              <label class="radio-inline">
                                                                <input type="radio" name="salary_type" class="fnb-radio"   value="{{ $salaryTypeId }}"   data-parsley-errors-container="#salary-type-errors" data-parsley-required-message="Please select salary type."  @if($jobAlertConfig['salary_type'] == $salaryTypeId) checked @endif> {{ $salaryType }}
                                                              </label>
                                                            @endforeach
                                                        </div>
                                                        <div id="salary-type-errors" class="fnb-errors"></div>
                                                        <a href="javascript:void(0)" class="text-right clear-salary secondary-link text-decor dis-block">Clear</a>

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
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <a class="primary-link form-collapse dis-block m-t-25 m-b-5" href="javascript:void(0);" type="button" data-toggle="collapse" data-target="#more-field" aria-expanded="false" aria-controls="more-field" data-class="more">
                                              More data <i class="fa fa-angle-down sub-title" aria-hidden="true"></i>
                                            </a>
                                            <a class="primary-link form-collapse dis-block m-t-25 m-b-5" href="javascript:void(0);" type="button" data-toggle="collapse" data-target="#more-field" aria-expanded="false" aria-controls="more-field" data-class="less">
                                              Less data <i class="fa fa-angle-up sub-title" aria-hidden="true"></i>
                                            </a>

                                            <div class="form-group p-t-20 m-b-0 text-center">
                                                <button  type="submit" class="btn fnb-btn primary-btn border-btn full code-send job-save-btn">
                                                @if($setNewAlert)
                                                Set Job Alert
                                                @else
                                                Modify
                                                @endif

                                                 <i class="fa fa-circle-o-notch fa-spin job-form-spinner hidden"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- new config -->
                                    <div class="alert-config @if(!$setNewAlert) hidden @endif">
                                         <div class="enquiry-form__header flex-row space-between align-top">
                                            <!-- <img src="img/enquiry.png" class="img-responsive p-r-10"> -->
                                            <div class="enquiry-title">
                                                <h6 class="element-title m-t-0 m-b-5">Job Alerts</h6>
                                                <p class="default-size text-lighter">Set your criteria to receive job recommendation</p>
                                            </div>
                                            <span class="fnb-icons enquiry"></span>
                                        </div>
                                        <div class="m-b-20 m-t-20 text-center no-alert-set">
                                            <button type="submit" class="btn fnb-btn primary-btn border-btn full code-send show-alert-form">  
                                                Set Job Alert
                                                <i class="fa fa-circle-o-notch fa-spin hidden"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sticky-bottom alert-bottom mobile-flex desk-hide active">
                    <div class="actions flex-row space-between">
                        <p class="m-b-0 bolder default-size m-r-10 text-center flex-1">Receive job recommendation</p>
                        <div class="flex-1 text-center">
                            <button class="btn fnb-btn primary-btn full border-btn send-enquiry form-toggle">Job Alert</button>     
                        </div>
                    </div>
                 </div>
            </div>
        </div>



<!-- Applicant sidebar -->


      <div class="pos-fixed fly-out side-toggle">
        <div class="mobile-back desk-hide mobile-flex">
           <div class="left mobile-flex">
              <i class="fa fa-arrow-left text-primary back-icon" aria-hidden="true"></i>
              <p class="element-title heavier m-b-0">Back</p>
           </div>
           <div class="right">
           </div>
        </div>
        <div class="fly-out__content">
           <div class="sidebar-updates page-sidebar">
              <div class="page-sidebar__header flex-row space-between mobile-hide">
                 <div class="backLink flex-row">
                    <a href="" class="primary-link p-r-10 element-title article-back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                    <div class="element-title bolder">Job Applications</div>
                 </div>
                 <!-- <div class="sort flex-row">
                    <p class="m-b-0 text-lighter default-size">Sort</p>
                    <select name="" id="" class="fnb-select">
                       <option>Recent</option>
                       <option>Newer</option>
                       <option>Older</option>
                    </select>
                 </div> -->
              </div>
              <div class="page-sidebar__body JA-sidebar">
                <table class="table table-striped table-responsive application-table m-t-20">
                    <thead>
                        <tr>
                            <th>Date of application</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>State</th>
                            <th>Resume</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="">November 23, 2017 </td>
                            <td>Bruce Wayne</td>
                            <td>bruce@gmail.com</td>
                            <td> +(91) 7854785478</td>
                            <td> Pune </td>
                            <td class="download-col"> - </td>
                        </tr>
                    </tbody>
                </table> 
              </div>
              <div class="page-sidebar__footer"></div>
              <div class="site-loader application-loader">
                    <div id="floatingBarsG">
                        <div class="blockG" id="rotateG_01"></div>
                        <div class="blockG" id="rotateG_02"></div>
                        <div class="blockG" id="rotateG_03"></div>
                        <div class="blockG" id="rotateG_04"></div>
                        <div class="blockG" id="rotateG_05"></div>
                        <div class="blockG" id="rotateG_06"></div>
                        <div class="blockG" id="rotateG_07"></div>
                        <div class="blockG" id="rotateG_08"></div>
                    </div>
                </div>
           </div>
        </div>
     </div>






@endsection
<!-- </body> -->
