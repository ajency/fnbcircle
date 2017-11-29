@extends('layouts.app')

@section('title')
Job Listing
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
 


        <div class="single-view-head">

            <div class="container">

        @if(!$jobPosted->count() && !$jobApplication->count())

                    <!-- No activity -->

                <div class="row m-b-30 m-t-30">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <div class="featured-jobs browse-cat card text-center no-data-card">
                            <i class="fa fa-frown-o text-primary element-title" aria-hidden="true"></i>
                            <div class="m-t-20">
                                <h6 class="element-title m-b-15 no-data-card__title">You don't have any Business Listings or Job Posts yet !</h6>
                                <h6 class="text-lighter text-medium m-b-15 label-size">Your Business Listings and Job Posts will appear here.</h6>
                                <h6 class="sub-title m-b-20">Get Started Now</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2"></div>
                </div>

                <!-- No activity div ends -->

        @else

        <div class="selection-card flex-row space-between">
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
        </div>
        @endif
 
                <div class="row m-t-20 row-btm-space">
                    <div class="col-sm-8">

                        
                    @if(!$jobPosted->count() && !$jobApplication->count())
                        <!-- No data -->
                       <div class="card no-listing-card">

                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <div class="featured-jobs browse-cat text-center">
                                        <h6 class="sub-title m-t-0">Do you own a Business?</h6>
                                        <hr>
                                        <button class="btn fnb-btn outline  border-btn" type="button">
                                            Create a Listing
                                        </button>

                                        <h6 class="bolder p-b-20 p-t-20 text-muted">OR</h6>

                                        <h6 class="sub-title m-t-0">Browse other Businesses</h6>
                                        <hr>
                                        <button class="btn fnb-btn outline  border-btn" type="button">
                                            Browse Listings
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="col-sm-3"></div>
                            </div>

                            <hr class="separator">

                            <div class="row">
                                <div class="col-sm-3"></div>
                                
                                <div class="col-sm-6">
                                    <div class="featured-jobs browse-cat text-center">
                                        <h6 class="sub-title m-t-0">Looking for talent?</h6>
                                        <hr>
                                        <a href="{{ url('/jobs/create') }}" target="_blank"><button class="btn fnb-btn outline  border-btn" type="button">
                                            Post a Job
                                        </button>
                                        </a>

                                        <h6 class="bolder p-b-20 p-t-20 text-muted">OR</h6>

                                        <h6 class="sub-title m-t-0">View jobs on FnB Circle</h6>
                                        <hr>
                                        <a href="{{ url($browserState.'/job-listings') }}" target="_blank"><button class="btn fnb-btn outline  border-btn" type="button">
                                            Browse Jobs
                                        </button></a>
                                    </div>
                                </div>
                                <div class="col-sm-3"></div>
                            </div>

                        </div>
                        
                        <!-- no data -->
                        @else
                        <!-- Nav tabs -->
                        <div class="nav-info scroll-tabs">
                            <ul class="nav-info__tab flex-row" role="tablist">
                                <li role="presentation" class="nav-section active"><a href="#mylistings" aria-controls="mylistings" role="tab" data-toggle="tab">My Listings (5)</a></li>
                                <li role="presentation" class="nav-section"><a href="#myjobs" aria-controls="myjobs" role="tab" data-toggle="tab">My Jobs ({{ count($jobPosted)}})</a></li>
                                <li role="presentation" class="nav-section"><a href="#appliedjobs" aria-controls="appliedjobs" role="tab" data-toggle="tab">Jobs I Applied To ({{ count($jobApplication)}})</a></li>
                            </ul>
                        </div>

                        <div class="tab-content p-t-20">
                            <div role="tabpanel" class="tab-pane active" id="mylistings">
                                <div class="filter-data">
                                    <div class="seller-info bg-card filter-cards">
                                        <div class="seller-info__body filter-cards__body flex-row white-space">
                                            <div class="body-left flex-cols">
                                                <div>
                                                    <div class="list-title-container">
                                                        <h3 class="seller-info__title ellipsis" title="Mystical the meat and fish store">Mystical the meat and fish store</h3>
                                                        <div class="power-seller-container"></div>
                                                    </div>
                                                    <div class="location p-b-5 flex-row">
                                                        <span class="fnb-icons map-icon"></span>
                                                        <p class="location__title default-size m-b-0 text-lighter">Gandhi Nagar, Delhi</p>
                                                    </div>
                                                    <div class="flex-row rat-pub">
                                                        <div class="rating-view flex-row p-r-10">
                                                            <div class="rating rating-small">
                                                                <div class="bg"></div>
                                                                <div class="value" style="width: 80%;"></div>
                                                            </div>
                                                        </div>
                                                        <p class="m-b-0 text-lighter default-size lighter published-date"><i>Published on 20 Dec 2016</i></p>
                                                    </div>
                                                    <div class="stats flex-row m-t-10 p-t-10">
                                                        <label class="fnb-label wholesaler flex-row">
                                                            <i class="fa fa-user user p-r-5" aria-hidden="true"></i>
                                                            Wholesaler
                                                        </label>
                                                        <div class="verified flex-row p-l-10">
                                                            <span class="fnb-icons verified-icon verified-mini"></span>
                                                            <p class="c-title">Verified</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-t-15 p-t-15 cat-holder">
                                                    <div class="core-cat">
                                                        <p class="default-size text-lighter m-t-0 m-b-0">Core Categories</p>
                                                        <ul class="fnb-cat flex-row">
                                                            <li><a href="" class="fnb-cat__title">Chicken Retailer</a></li>
                                                            <li><a href="" class="fnb-cat__title">Mutton</a></li>
                                                            <li><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                                            <li><a href="" class="fnb-cat__title">Pork Wholesaler</a></li>
                                                            <li class="desk-hide"><a href="" class="fnb-cat__title">Egg</a></li>
                                                            <li class="desk-hide"><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                                            <li class="cat-more more-show"><a href="" class="text-darker">+5 more</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="body-right flex-cols">
                                                <div class="operations">
                                                    <img src="/img/power-seller.png" class="img-responsive power-seller" width="120">
                                                    <p class="operations__title default-size text-lighter m-t-5">Areas of operation:</p>
                                                    <div class="operations__container">
                                                        <div class="location flex-row">
                                                            <p class="m-b-0 text-color heavier default-size">Mumbai <i class="fa fa-caret-right p-l-5" aria-hidden="true"></i>
                                                            </p>
                                                        </div>
                                                        <ul class="cities flex-row">
                                                            <li>
                                                                <p class="cities__title default-size">Bandra, </p>
                                                            </li>
                                                            <li>
                                                                <p class="cities__title default-size">Andheri, </p>
                                                            </li>
                                                            <li>
                                                                <p class="cities__title default-size">Juhu, </p>
                                                            </li>
                                                            <li class="mobile-hide">
                                                                <p class="cities__title default-size">Worli, </p>
                                                            </li>
                                                            <li class="mobile-hide">
                                                                <p class="cities__title default-size">Powai</p>
                                                            </li>
                                                            <li class="line">
                                                                <p class="cities__title default-size">|</p>
                                                            </li>
                                                            <li class="remain more-show">
                                                                <a href="" class="cities__title remain__number default-size text-medium">more...</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="enquiries flex-row">
                                                        <div class="enquiries__count">
                                                            <p class="default-size heavier text-color m-b-0">50+</p>
                                                            <p class="default-size text-lighter">Enquiries</p>
                                                        </div>
                                                        <div class="enquiries__request">
                                                            <p class="default-size heavier text-color m-b-0">100+</p>
                                                            <p class="default-size text-lighter">Contact Requests</p>
                                                        </div>
                                                        <i class="fa fa-bar-chart bars text-darker" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="get-details detail-move">
                                                        <button class="btn fnb-btn outline full border-btn fullwidth default-size">Get Details <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="seller-info__footer filter-cards__footer white-space">
                                            <div class="recent-updates flex-row">
                                                <div class="recent-updates__text">
                                                    <p class="m-b-0 default-size heavier flex-row"><!-- <i class="fa fa-repeat p-r-5" aria-hidden="true"></i> --><img src="/img/list-updates.png" class="img-responsive update-icon"> Recent updates <i class="fa fa-angle-down desk-hide arrowDown" aria-hidden="true"></i></p>
                                                </div>
                                                <div class="recent-updates__content">
                                                    <p class="m-b-0 default-size text-color recent-data">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur recusandae quasi facere voluptates error, ab, iusto similique?,
                                                    <span class="text-lighter p-l-10">Updated few hours ago</span></p>
                                                </div>
                                            </div>
                                            <div class="updates-dropDown">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="myjobs">
                                <div class="job-listings customer-jobs">
                                    @php
                                        $jobs = $jobPosted;
                                        if (count($jobs)){
                                            echo View::make('jobs.job-listing-card', compact('jobs'))->with(['isListing'=>false,'append'=>false])->render();  
                                        }
                                        else{
                                            echo '<div class="no-results">
                                                <h3 class="seller-info__title ellipsis text-primary">No Jobs Found <i class="fa fa-frown-o" aria-hidden="true"></i></h3>
                                            </div>';
                                        }
                                        
                                    @endphp
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="appliedjobs">
                                <div class="job-listings customer-jobs">
                                    @php
                                        $jobs = $jobApplication;
                                        if (count($jobs)){
                                            echo View::make('jobs.job-listing-card', compact('jobs'))->with(['isListing'=>false,'append'=>false,'showApplication'=>true])->render();  
                                        }
                                        else{
                                            echo '<div class="no-results">
                                                <h3 class="seller-info__title ellipsis text-primary">No Jobs Found <i class="fa fa-frown-o" aria-hidden="true"></i></h3>
                                            </div>';
                                        }
                                    @endphp 
                                </div>
                            </div>
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
                                                            <input type="file" name="resume" class="resume-upload" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="doc docx pdf" data-parsley-required data-parsley-errors-container="#resume-error"/> 
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
                                                    <button class="btn fnb-btn btn-link code-send primary-link p-l-0" type="submit">Upload Resume </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="enquiry-form card m-b-20 dash-enquiry-form">
                                    <form id="job-form" method="post" data-parsley-validate action="{{url('customer-dashboard/users/set-job-alert')}}"   enctype="multipart/form-data">
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
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" {{ ($sendJobAlerts) ? 'checked' : '' }}  name="send_job_alerts" class="fnb-checkbox custom-checkbox" value="1"><span class="default-size">Send Alerts</span></span>
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
                                            <div class="form-group p-t-20 m-b-0 text-center">
                                                <button  type="submit" class="btn fnb-btn primary-btn border-btn full code-send job-save-btn">Modify <i class="fa fa-circle-o-notch fa-spin hidden"></i></button>
                                            </div>
                                        </div>
                                    </form>
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


@endsection
<!-- </body> -->
