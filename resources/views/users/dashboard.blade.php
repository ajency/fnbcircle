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
 


        <div class="single-view-head">

            <div class="container">

<!--                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-4">
                        <div class="featured-jobs browse-cat card text-center">
                            <h6 class="sub-title m-t-0">Do you own a Business?</h6>
                            <hr>
                            <button class="btn fnb-btn outline  border-btn" type="button" >
                                Create a Listing
                            </button>

                            <h6 class="bolder p-b-20 p-t-20 text-muted">OR</h6>

                            <h6 class="sub-title m-t-0">Browse other Businesses</h6>
                            <hr>
                            <button class="btn fnb-btn outline  border-btn" type="button" >
                                Browse Listings
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="featured-jobs browse-cat card text-center">
                            <h6 class="sub-title m-t-0">Looking for talent?</h6>
                            <hr>
                            <button class="btn fnb-btn outline  border-btn" type="button" >
                                Post a Job
                            </button>

                            <h6 class="bolder p-b-20 p-t-20 text-muted">OR</h6>

                            <h6 class="sub-title m-t-0">View jobs on FnB Circle</h6>
                            <hr>
                            <button class="btn fnb-btn outline  border-btn" type="button" >
                                Browse Jobs
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-2"></div>
                </div> -->

                    
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
                    <button class="btn fnb-btn outline  border-btn" type="button" >
                        Create a Listing
                    </button>
                </div>
                <div class="card__section or flex-row">
                    <div class="or__text flex-row">OR</div>
                </div>
                <div class="card__section browse-business">
                    <h5>View jobs on<br> FnB Circle</h5>
                    <button class="btn fnb-btn outline  border-btn" type="button" >
                        Browse Listings
                    </button>
                </div>
            </div>
        </div>






                <!-- No activity -->

                <!-- <div class="row m-b-30 m-t-30">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <div class="featured-jobs browse-cat card text-center no-data-card">
                            <i class="fa fa-frown-o text-primary element-title" aria-hidden="true"></i>
                            <div class="m-t-20">
                                <h6 class="element-title m-b-20 no-data-card__title">You don't have any Business Listing or Job Posts Yet !</h6>
                                <h6 class="text-lighter text-medium m-b-20">You Business Listing and Job Post will appear here</h6>
                                <h6 class="eleent-title m-b-20">Get Started Now</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3"></div>
                </div> -->

                <!-- No activity div ends -->



                <div class="row m-t-20">
                    <div class="col-sm-8">

                        <!-- No data -->
                    <!--    <div class="card">

                            <div class="row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-6">
                                                    <div class="featured-jobs browse-cat card text-center">
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

                            <hr>

                            <div class="row">
                                                <div class="col-sm-3"></div>
                                                
                                                <div class="col-sm-6">
                                                    <div class="featured-jobs browse-cat card text-center">
                                                        <h6 class="sub-title m-t-0">Looking for talent?</h6>
                                                        <hr>
                                                        <button class="btn fnb-btn outline  border-btn" type="button">
                                                            Post a Job
                                                        </button>

                                                        <h6 class="bolder p-b-20 p-t-20 text-muted">OR</h6>

                                                        <h6 class="sub-title m-t-0">View jobs on FnB Circle</h6>
                                                        <hr>
                                                        <button class="btn fnb-btn outline  border-btn" type="button">
                                                            Browse Jobs
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3"></div>
                            </div>

                        </div> -->
                        
                        <!-- no data -->

                        <!-- Nav tabs -->
                        <div class="nav-info scroll-tabs">
                            <ul class="nav-info__tab flex-row" role="tablist">
                                <li role="presentation" class="nav-section active"><a href="#mylistings" aria-controls="mylistings" role="tab" data-toggle="tab">My Listings (5)</a></li>
                                <li role="presentation" class="nav-section"><a href="#myjobs" aria-controls="myjobs" role="tab" data-toggle="tab">My Jobs (3)</a></li>
                                <li role="presentation" class="nav-section"><a href="#appliedjobs" aria-controls="appliedjobs" role="tab" data-toggle="tab">Jobs I Applied To (3)</a></li>
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
                                                    <img src="../public/img/power-seller.png" class="img-responsive power-seller" width="120">
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
                                                    <p class="m-b-0 default-size heavier flex-row"><!-- <i class="fa fa-repeat p-r-5" aria-hidden="true"></i> --><img src="../public/img/list-updates.png" class="img-responsive update-icon"> Recent updates <i class="fa fa-angle-down desk-hide arrowDown" aria-hidden="true"></i></p>
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

                                <div class="filter-data m-t-30 adv-after">
                                    <div class="seller-info bg-card filter-cards">
                                        <div class="seller-info__body filter-cards__body flex-row white-space">
                                            <div class="body-left flex-cols">
                                                <div>
                                                    <div class="list-title-container">
                                                        <h3 class="seller-info__title ellipsis" title="Empire cold storage &amp; chicken products">Empire cold storage &amp; chicken products</h3>
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
                                                    <img src="../public/img/power-seller.png" class="img-responsive power-seller" width="120">
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
                                                    <p class="m-b-0 default-size heavier flex-row"><!-- <i class="fa fa-repeat p-r-5" aria-hidden="true"></i> --><img src="../public/img/list-updates.png" class="img-responsive update-icon"> Recent updates <i class="fa fa-angle-down desk-hide arrowDown" aria-hidden="true"></i></p>
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
                                        echo View::make('jobs.job-listing-card', compact('jobs'))->with(['isListing'=>false,'append'=>false])->render();  
                                    @endphp
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="appliedjobs">
                                <div class="job-listings">
                                    <div class="filter-data m-b-30 ">
                                      <div class="seller-info bg-card filter-cards">
                                          <div class="seller-info__body filter-cards__body white-space">
                                              <div class="body-left flex-cols">
                                                  <div>
                                                      <div class="flex-row space-between">
                                                        <h3 class="seller-info__title ellipsis-2" title="Kitchen Stewarding Executive"><a href="http://staging.fnbcircle.com/job/kitchen-stewarding-executive-healthcare-hospital-fortune-select-exotica-member-of-itc-group-gKCd71jA" class=" text-darker" target="_blank">Kitchen Stewarding Executive</a></h3>
                                                      </div>
                                                      <div class="location flex-row companyName space-between flex-wrap">
                                                        <p class="location__title default-size m-b-0 text-lighter">Fortune Select Exotica, Member Of ITC Group</p>
                                  
                                                        <p class="m-b-0 text-lighter default-size lighter published-date"><i>Posted on: November 1, 2017</i></p>
                                                            
                                                      </div>
                                                      <div class="flex-row space-between flex-wrap cat-posted">
                                                          <div class="rating-view flex-row p-r-10"> 
                                                          <i class="fa fa-tag p-r-5 text-lighter" aria-hidden="true"></i>
                                                            <a href="?state=goa&amp;business_type=healthcare-hospital" class="primary-link" title="Find all Healthcare-hospital jobs in goa">Healthcare-hospital</a>
                                                          </div>
                                                      </div>

                                                      <div class="stats flex-row m-t-10 flex-wrap">
                                                           
                                                           <label class="fnb-label wholesaler flex-row m-r-5" title="Find all Full Time jobs in goa">
                                                              <!-- <i class="fa fa-user user p-r-5" aria-hidden="true"></i> -->    
                                                               <a href="?state=goa&amp;job_type=[&quot;full-time&quot;]" class="secondary-link">Full Time</a>
                                     
                                                            </label>

                                                                               
                                                           <label class="fnb-label wholesaler flex-row m-r-5" title="Find all Internship jobs in goa">
                                                              <!-- <i class="fa fa-user user p-r-5" aria-hidden="true"></i> -->
                                                               <a href="?state=goa&amp;job_type=[&quot;internship&quot;]" class="secondary-link">Internship</a>
                                     
                                                           </label>

                                                                               
                                                           <label class="fnb-label wholesaler flex-row m-r-5" title="Find all Work From Home jobs in goa">
                                                              <!-- <i class="fa fa-user user p-r-5" aria-hidden="true"></i> -->
                                                               <a href="?state=goa&amp;job_type=[&quot;work-from-home&quot;]" class="secondary-link">Work From Home</a>
                                     
                                                           </label>

                                                                               
                                                           <label class="fnb-label wholesaler flex-row m-r-5" title="Find all International Jobs-Work Abroad jobs in goa">
                                                              <!-- <i class="fa fa-user user p-r-5" aria-hidden="true"></i> -->
                                                               <a href="?state=goa&amp;job_type=[&quot;international-jobs-work-abroad&quot;]" class="secondary-link">International Jobs-Work Abroad</a>
                                     
                                                           </label>
                                                                                
                                                      </div>

                                                    </div>
                                     
                                                  <div class="flex-row space-between roles-location open-border align-top">
                                                                     
                                                    <div class="cat-holder">
                                                        <div class="core-cat m-r-5">
                                                            <p class="default-size grey-darker heavier m-t-0 m-b-5">Job Roles</p>
                                                            <ul class="fnb-cat flex-row">
                                      
                                                                  <li><a href="?state=goa&amp;job_roles=[&quot;28|assistant-kitchen-manager&quot;]" class="fnb-cat__title" title="Find all jobs matching Assistant kitchen manager in goa">Assistant kitchen manager</a></li>
                                                                
                                                                  <li><a href="?state=goa&amp;job_roles=[&quot;29|associate-creative-director&quot;]" class="fnb-cat__title" title="Find all jobs matching Associate creative director in goa">Associate creative director</a></li>
                                                                
                                                                  <li><a href="?state=goa&amp;job_roles=[&quot;202|accounts-payable-jobs&quot;]" class="fnb-cat__title" title="Find all jobs matching Accounts Payable Jobs in goa">Accounts Payable Jobs</a></li>
                                                                
                                                                  <li><a href="?state=goa&amp;job_roles=[&quot;283|administration-general-jobs&quot;]" class="fnb-cat__title" title="Find all jobs matching Administration &amp; General Jobs in goa">Administration &amp; General Jobs</a></li>

                                                                    <li class="cat-more more-show"><a href="http://staging.fnbcircle.com/job/kitchen-stewarding-executive-healthcare-hospital-fortune-select-exotica-member-of-itc-group-gKCd71jA" class="secondary-link" target="_blank">+1 more</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="operations">
                                                        <p class="operations__title default-size grey-darker heavier m-t-0">Job Location:</p>
                                                         <div class="operations__container">
                                                            <div class="location flex-row">
                                                                <p class="m-b-0 text-color heavier default-size">Goa <i class="fa fa-caret-right p-l-5 p-r-5" aria-hidden="true"></i>
                                                                </p>
                                                                <ul class="cities flex-row">
                                                                  <li>
                                                                      <p class="cities__title default-size">Vasco
                                                                                                               , 
                                                                      </p>
                                                                  </li>
                                                                                                   
                                                                  <li>
                                                                      <p class="cities__title default-size">Margao
                                                                       </p>
                                                                  </li>
                                                                   
                                                                  <li class="line">
                                                                      <p class="cities__title default-size">|</p>
                                                                  </li>
                                                                  <li class="remain more-show">
                                                                      <a href="http://staging.fnbcircle.com/job/kitchen-stewarding-executive-healthcare-hospital-fortune-select-exotica-member-of-itc-group-gKCd71jA" target="_blank" class="cities__title remain__number default-size text-medium secondary-link">more...</a>
                                                                  </li>
                                                             </ul>
                                                            </div>
                                                 
                                                        </div>
                                                       <div class="operations__container">
                                                            <div class="location flex-row">
                                                                <p class="m-b-0 text-color heavier default-size">Delhi <i class="fa fa-caret-right p-l-5 p-r-5" aria-hidden="true"></i>
                                                                </p>
                                                                <ul class="cities flex-row">
                                                                  <li>
                                                                    <p class="cities__title default-size">Chanakyapuri
                                                                         </p>
                                                                  </li>
                                                                    
                                                                   </ul>
                                                            </div>
                                                 
                                                        </div>
                                                         <div class="location flex-row m-t-5">
                                                            <p class="m-b-0 text-color heavier default-size"> <a href="http://staging.fnbcircle.com/job/kitchen-stewarding-executive-healthcare-hospital-fortune-select-exotica-member-of-itc-group-gKCd71jA" class="remain__number x-small secondary-link moreLink" target="_blank">+ 1  more...</a>
                                                            </p>
                                                        </div> 
                                                         
                                                    </div>
                                                  </div>
                                              </div>

                                               <div class="recent-updates flex-row flex-wrap open-border space-between align-top">
                                                 <div class="off-salary">
                                                    <p class="operations__title default-size grey-darker heavier m-t-0">Offered Salary</p>

                                                    
                                                    <div class="text-lighter text-medium">
                                                       <i class="fa fa-inr text-color" aria-hidden="true"></i> 45,678 - <i class="fa fa-inr text-color" aria-hidden="true"></i> 78,901 
                                                         per month</div>

                                                       </div>  

                                                      <div class="year-exp no-comma">
                                                      <p class="operations__title default-size grey-darker heavier m-t-0">Years Of Experience</p>
                                                      <div class="flex-row flex-wrap">
                                                        <div class="text-lighter text-medium year-exp">7-10 years</div>
                                                      </div>
                                                      
                                                   </div>
                                                   
                                                  <div class="get-details detail-move mobile-hide">
                                                    <!-- <img src="http://staging.fnbcircle.com/img/power-seller.png" class="img-responsive power-seller" width="120"> -->
                                                    <a href="http://staging.fnbcircle.com/job/kitchen-stewarding-executive-healthcare-hospital-fortune-select-exotica-member-of-itc-group-gKCd71jA" target="_blank" class="btn fnb-btn full primary-btn border-btn fullwidth default-size">View Job <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></a>
                                                    <p></p>
                                                    <a href="#" target="_blank" class="secondary-link default-size">View Applicant Details</a>
                                                  </div>
                                              </div>
                                              <div class="get-details detail-move desk-hide">
                                                <!-- <img src="http://staging.fnbcircle.com/img/power-seller.png" class="img-responsive power-seller" width="120"> -->
                                                <a href="http://staging.fnbcircle.com/job/kitchen-stewarding-executive-healthcare-hospital-fortune-select-exotica-member-of-itc-group-gKCd71jA" target="_blank" class="btn fnb-btn full primary-btn border-btn fullwidth default-size">View Job <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></a>
                                                <p></p>
                                                <a href="#" target="_blank" class="secondary-link default-size">View Applicant Details</a>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="filter-data m-b-30 ">
                                      <div class="seller-info bg-card filter-cards">
                                          <div class="seller-info__body filter-cards__body white-space">
                                              <div class="body-left flex-cols">
                                                  <div>
                                                      <div class="flex-row space-between">
                                                        <h3 class="seller-info__title ellipsis-2" title="Kitchen Stewarding Executive"><a href="http://staging.fnbcircle.com/job/kitchen-stewarding-executive-healthcare-hospital-fortune-select-exotica-member-of-itc-group-gKCd71jA" class=" text-darker" target="_blank">Kitchen Stewarding Executive</a></h3>
                                                      </div>
                                                      <div class="location flex-row companyName space-between flex-wrap">
                                                        <p class="location__title default-size m-b-0 text-lighter">Fortune Select Exotica, Member Of ITC Group</p>
                                  
                                                        <p class="m-b-0 text-lighter default-size lighter published-date"><i>Posted on: November 1, 2017</i></p>
                                                            
                                                      </div>
                                                      <div class="flex-row space-between flex-wrap cat-posted">
                                                          <div class="rating-view flex-row p-r-10"> 
                                                          <i class="fa fa-tag p-r-5 text-lighter" aria-hidden="true"></i>
                                                            <a href="?state=goa&amp;business_type=healthcare-hospital" class="primary-link" title="Find all Healthcare-hospital jobs in goa">Healthcare-hospital</a>
                                                          </div>
                                                      </div>

                                                      <div class="stats flex-row m-t-10 flex-wrap">
                                                           
                                                           <label class="fnb-label wholesaler flex-row m-r-5" title="Find all Full Time jobs in goa">
                                                              <!-- <i class="fa fa-user user p-r-5" aria-hidden="true"></i> -->    
                                                               <a href="?state=goa&amp;job_type=[&quot;full-time&quot;]" class="secondary-link">Full Time</a>
                                     
                                                            </label>

                                                                               
                                                           <label class="fnb-label wholesaler flex-row m-r-5" title="Find all Internship jobs in goa">
                                                              <!-- <i class="fa fa-user user p-r-5" aria-hidden="true"></i> -->
                                                               <a href="?state=goa&amp;job_type=[&quot;internship&quot;]" class="secondary-link">Internship</a>
                                     
                                                           </label>

                                                                               
                                                           <label class="fnb-label wholesaler flex-row m-r-5" title="Find all Work From Home jobs in goa">
                                                              <!-- <i class="fa fa-user user p-r-5" aria-hidden="true"></i> -->
                                                               <a href="?state=goa&amp;job_type=[&quot;work-from-home&quot;]" class="secondary-link">Work From Home</a>
                                     
                                                           </label>

                                                                               
                                                           <label class="fnb-label wholesaler flex-row m-r-5" title="Find all International Jobs-Work Abroad jobs in goa">
                                                              <!-- <i class="fa fa-user user p-r-5" aria-hidden="true"></i> -->
                                                               <a href="?state=goa&amp;job_type=[&quot;international-jobs-work-abroad&quot;]" class="secondary-link">International Jobs-Work Abroad</a>
                                     
                                                           </label>
                                                                                
                                                      </div>

                                                    </div>
                                     
                                                  <div class="flex-row space-between roles-location open-border align-top">
                                                                     
                                                    <div class="cat-holder">
                                                        <div class="core-cat m-r-5">
                                                            <p class="default-size grey-darker heavier m-t-0 m-b-5">Job Roles</p>
                                                            <ul class="fnb-cat flex-row">
                                      
                                                                  <li><a href="?state=goa&amp;job_roles=[&quot;28|assistant-kitchen-manager&quot;]" class="fnb-cat__title" title="Find all jobs matching Assistant kitchen manager in goa">Assistant kitchen manager</a></li>
                                                                
                                                                  <li><a href="?state=goa&amp;job_roles=[&quot;29|associate-creative-director&quot;]" class="fnb-cat__title" title="Find all jobs matching Associate creative director in goa">Associate creative director</a></li>
                                                                
                                                                  <li><a href="?state=goa&amp;job_roles=[&quot;202|accounts-payable-jobs&quot;]" class="fnb-cat__title" title="Find all jobs matching Accounts Payable Jobs in goa">Accounts Payable Jobs</a></li>
                                                                
                                                                  <li><a href="?state=goa&amp;job_roles=[&quot;283|administration-general-jobs&quot;]" class="fnb-cat__title" title="Find all jobs matching Administration &amp; General Jobs in goa">Administration &amp; General Jobs</a></li>

                                                                    <li class="cat-more more-show"><a href="http://staging.fnbcircle.com/job/kitchen-stewarding-executive-healthcare-hospital-fortune-select-exotica-member-of-itc-group-gKCd71jA" class="secondary-link" target="_blank">+1 more</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="operations">
                                                        <p class="operations__title default-size grey-darker heavier m-t-0">Job Location:</p>
                                                         <div class="operations__container">
                                                            <div class="location flex-row">
                                                                <p class="m-b-0 text-color heavier default-size">Goa <i class="fa fa-caret-right p-l-5 p-r-5" aria-hidden="true"></i>
                                                                </p>
                                                                <ul class="cities flex-row">
                                                                  <li>
                                                                      <p class="cities__title default-size">Vasco
                                                                                                               , 
                                                                      </p>
                                                                  </li>
                                                                                                   
                                                                  <li>
                                                                      <p class="cities__title default-size">Margao
                                                                       </p>
                                                                  </li>
                                                                   
                                                                  <li class="line">
                                                                      <p class="cities__title default-size">|</p>
                                                                  </li>
                                                                  <li class="remain more-show">
                                                                      <a href="http://staging.fnbcircle.com/job/kitchen-stewarding-executive-healthcare-hospital-fortune-select-exotica-member-of-itc-group-gKCd71jA" target="_blank" class="cities__title remain__number default-size text-medium secondary-link">more...</a>
                                                                  </li>
                                                             </ul>
                                                            </div>
                                                 
                                                        </div>
                                                       <div class="operations__container">
                                                            <div class="location flex-row">
                                                                <p class="m-b-0 text-color heavier default-size">Delhi <i class="fa fa-caret-right p-l-5 p-r-5" aria-hidden="true"></i>
                                                                </p>
                                                                <ul class="cities flex-row">
                                                                  <li>
                                                                    <p class="cities__title default-size">Chanakyapuri
                                                                         </p>
                                                                  </li>
                                                                    
                                                                   </ul>
                                                            </div>
                                                 
                                                        </div>
                                                         <div class="location flex-row m-t-5">
                                                            <p class="m-b-0 text-color heavier default-size"> <a href="http://staging.fnbcircle.com/job/kitchen-stewarding-executive-healthcare-hospital-fortune-select-exotica-member-of-itc-group-gKCd71jA" class="remain__number x-small secondary-link moreLink" target="_blank">+ 1  more...</a>
                                                            </p>
                                                        </div> 
                                                         
                                                    </div>
                                                  </div>
                                              </div>

                                               <div class="recent-updates flex-row flex-wrap open-border space-between align-top">
                                                 <div class="off-salary">
                                                    <p class="operations__title default-size grey-darker heavier m-t-0">Offered Salary</p>

                                                    
                                                    <div class="text-lighter text-medium">
                                                       <i class="fa fa-inr text-color" aria-hidden="true"></i> 45,678 - <i class="fa fa-inr text-color" aria-hidden="true"></i> 78,901 
                                                         per month</div>

                                                       </div>  

                                                      <div class="year-exp no-comma">
                                                      <p class="operations__title default-size grey-darker heavier m-t-0">Years Of Experience</p>
                                                      <div class="flex-row flex-wrap">
                                                        <div class="text-lighter text-medium year-exp">7-10 years</div>
                                                      </div>
                                                      
                                                   </div>
                                                   
                                                  <div class="get-details detail-move mobile-hide">
                                                    <!-- <img src="http://staging.fnbcircle.com/img/power-seller.png" class="img-responsive power-seller" width="120"> -->
                                                    <a href="http://staging.fnbcircle.com/job/kitchen-stewarding-executive-healthcare-hospital-fortune-select-exotica-member-of-itc-group-gKCd71jA" target="_blank" class="btn fnb-btn full primary-btn border-btn fullwidth default-size">View Job <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></a>
                                                    <p></p>
                                                    <a href="#" target="_blank" class="secondary-link default-size">View Applicant Details</a>
                                                  </div>
                                              </div>
                                              <div class="get-details detail-move desk-hide">
                                                <!-- <img src="http://staging.fnbcircle.com/img/power-seller.png" class="img-responsive power-seller" width="120"> -->
                                                <a href="http://staging.fnbcircle.com/job/kitchen-stewarding-executive-healthcare-hospital-fortune-select-exotica-member-of-itc-group-gKCd71jA" target="_blank" class="btn fnb-btn full primary-btn border-btn fullwidth default-size">View Job <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></a>
                                                <p></p>
                                                <a href="#" target="_blank" class="secondary-link default-size">View Applicant Details</a>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>


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
                                <div class="card resume-card m-b-20">
                                    <div class="flex-row align-top">
                                        <img src="../public/img/resume.png" class="m-r-15">
                                        <div class="flex-1">
                                            <div class="enquiry-form__header flex-row space-between align-top m-b-10">
                                                <!-- <img src="img/enquiry.png" class="img-responsive p-r-10"> -->
                                                <div class="enquiry-title">
                                                    <p class="m-t-0 m-b-0 heavier">My Resume</p>
                                                </div>
                                            </div>
                                            <div class="catalogue flex-row">
                                                <p class="default-size flex-row m-b-0 text-color word-break align-top">
                                                    Amit_Adav_Resume.pdf
                                                </p>
                                                <div class="flex-row">
                                                    <a href="">
                                                        <!-- <i class="fa fa-download catalogue-download" aria-hidden="true"></i> -->
                                                        <span class="fnb-icons download"></span>
                                                    </a>
                                                    <i class="fa fa-times p-l-10 remove-resume cursor-pointer" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="form-group p-t-15 m-b-0">
                                                <a href="#" class="primary-link text-decor">Upload Resume</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="enquiry-form card m-b-20 dash-enquiry-form">
                                    <form method="">
                                        <div class="enquiry-form__header flex-row space-between align-top">
                                            <!-- <img src="img/enquiry.png" class="img-responsive p-r-10"> -->
                                            <div class="enquiry-title">
                                                <h6 class="element-title m-t-0 m-b-0">Job Alerts</h6>
                                                <p class="default-size text-lighter">You will receive job recommendation based on following</p>
                                            </div>
                                            <span class="fnb-icons enquiry"></span>
                                        </div>
                                        <div class="enquiry-form__body m-t-10">
                                            <div class="form-group">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="job_type[]" id="" value="" class="fnb-checkbox custom-checkbox" checked=""> <span class="default-size p-l-5">Send Alerts</span>
                                                </label>
                                            </div>
                                            
                                            <div class="form-group p-t-10">
                                                <label class="label-size required">Choose a business type:</label>
                                                <div class="brands-container businessType">
                                                     <select class="fnb-select select-variant form-control text-color" name="category" placeholder="Type and hit enter" list="jobCats" id="jobCatsInput" value="" data-parsley-required="" data-parsley-required-message="Please select a business type">
                                                            <option value="">Select Category</option>
                                                            <option value="236">Club, Banquet &amp; Catering Unit</option>
                                                            <option value="235" selected="">Entertainment-Cinemas, Casino, Etc</option>
                                                            <option value="244">Food Processing</option>
                                                            <option value="243">Food Tech</option>
                                                            <option value="238">Guest House, Bnb &amp; Villa Rentals</option>
                                                            <option value="239">Healthcare-hospital</option>
                                                            <option value="234">Hotel/Resort</option>
                                                            <option value="233">Restaurant/Bar</option>
                                                            <option value="240">Retail</option>
                                                            <option value="241">Spa</option>
                                                            <option value="237">Travel &amp; Tourism- Airline Cruise, Etc</option>
                                                            <option value="242">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group p-t-10 flex-data-row">
                                                 <label class="label-size required">Job Roles</label>
                                                 <input type="text" class="form-control fnb-input job-keywords" data-parsley-required-message="At least one job role should be added" name="job_keyword" placeholder="Search and select from the list below" list="jobKeyword" multiple="multiple" id=jobKeywordInput>
                                            </div>
                                            <div class="form-group p-t-10">
                                                <label class="label-size required">Where is the job located?  </label>
                                                <div class="location-select cityArea flex-row flex-wrap">
                                                    <div class="select-col city">
                                                        <select class="fnb-select select-variant form-control text-lighter">
                                                            <option value="">Select State</option>
                                                                <option value="3">Delhi</option>
                                                                <option value="1">Goa</option>
                                                                <option value="4">Mumbai</option>
                                                                <option value="2">Pune</option>
                                                                <option value="6">Shimala</option>
                                                        </select>
                                                    </div> 
                                                    <div class="select-col area">
                                                        <select class="fnb-select select-variant form-control text-lighter">
                                                            <option value="">Select City</option>
                                                                <option value="3">Delhi</option>
                                                                <option value="1">Panjim</option>
                                                                <option value="4">Mumbai</option>
                                                                <option value="2">Pune</option>
                                                                <option value="6">Shimala</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group p-t-10">
                                                <label class="label-size required">Job Type</label>
                                                <div class="form-group m-t-5 job-type mobile-flex flex-row flex-wrap align-top">
                                                  <label class="checkbox-inline">
                                                    <input type="checkbox" name="job_type[]" id="job_type" value="194" class="fnb-checkbox custom-checkbox" data-parsley-multiple="job_type"> Full Time
                                                  </label>
                                                     <label class="checkbox-inline">
                                                        <input type="checkbox" name="job_type[]" id="job_type" value="195" class="fnb-checkbox custom-checkbox" data-parsley-multiple="job_type"> Part Time
                                                      </label>
                                                  <label class="checkbox-inline">
                                                    <input type="checkbox" name="job_type[]" id="job_type" value="196" class="fnb-checkbox custom-checkbox" data-parsley-multiple="job_type"> Contract/Temp
                                                  </label>
                                                          <label class="checkbox-inline">
                                                    <input type="checkbox" name="job_type[]" id="job_type" value="197" class="fnb-checkbox custom-checkbox" data-parsley-multiple="job_type"> Internship
                                                  </label>
                                                          <label class="checkbox-inline">
                                                    <input type="checkbox" name="job_type[]" id="job_type" value="198" class="fnb-checkbox custom-checkbox" data-parsley-multiple="job_type"> Work From Home
                                                  </label>
                                                          <label class="checkbox-inline">
                                                    <input type="checkbox" name="job_type[]" id="job_type" value="199" class="fnb-checkbox custom-checkbox" data-parsley-multiple="job_type"> International Jobs-Work Abroad
                                                  </label>
                                                </div>
                                            </div>
                                            <div class="form-group p-t-10">
                                                <label class="label-size required">Years of experience</label>
                                                <div class="brands-container businessType auto-exp-select">
                                                    <select class="fnb-select select-variant form-control text-lighter expSelect" id="yrsExpInput" multiple="multiple">
                                                        <option selected="" value="0-1">0-1</option>
                                                        <option value="1-3">1-3</option>
                                                        <option value="3-5">3-5</option>
                                                        <option value="5-7">5-7</option>
                                                        <option value="7-10">7-10</option>
                                                        <option value="10+">10+</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group p-t-10">
                                                <label class="label-size">Salary</label>
                                                <div class="form-group m-t-5">
                                                    <div class="flex-row flex-wrap align-top">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="salary_type" class="fnb-radio" value="5" data-parsley-errors-container="#salary-type-errors" data-parsley-required-message="Please select salary type." data-parsley-multiple="salary_type"> Annually
                                                          </label>
                                                          <label class="radio-inline">
                                                            <input type="radio" name="salary_type" class="fnb-radio" value="6" data-parsley-errors-container="#salary-type-errors" data-parsley-required-message="Please select salary type." data-parsley-multiple="salary_type"> Monthly
                                                          </label>
                                                          <label class="radio-inline">
                                                            <input type="radio" name="salary_type" class="fnb-radio" value="7" data-parsley-errors-container="#salary-type-errors" data-parsley-required-message="Please select salary type." data-parsley-multiple="salary_type"> Daily
                                                          </label>
                                                          <label class="radio-inline">
                                                            <input type="radio" name="salary_type" class="fnb-radio" value="8" data-parsley-errors-container="#salary-type-errors" data-parsley-required-message="Please select salary type." data-parsley-multiple="salary_type"> Hourly
                                                          </label>
                                                    </div>

                                                    <a href="javascript:void(0)" class="text-right clear-salary secondary-link text-decor dis-block">Clear</a>

                                                    <div class="salary-range flex-row">
                                                        <div class="flex-row">
                                                            <div class="input-group">
                                                              <span class="input-group-addon"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                                 
                                                              <input type="number" min="0" class="form-control salary-amt " name="salary_lower" id="salary_lower" data-parsley-type="number" aria-describedby="inputGroupSuccess3Status" salary-type-checked="false" value="" data-parsley-errors-container="#errors" data-parsley-required-message="Please enter minimum salary." salary_type_checked="" max="300000000">
                                                           
                                                               <div id="errors" class="ctm-error fnb-errors"></div>
                                                            </div>
                                                            <p class="m-b-0 sal-divider">to</p>
                                                            <div class="input-group">
                                                              <span class="input-group-addon"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                             
                                                              <input type="number" class="form-control salary-amt" name="salary_upper" id="salary_upper" data-parsley-type="number" aria-describedby="inputGroupSuccess3Status" value="" data-parsley-errors-container="#error" data-parsley-required-message="Please enter maximum salary." max="300000000">
                                             
                                                               <div id="error" class="ctm-error fnb-errors"></div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group p-t-20 m-b-0 text-center">
                                                <button class="btn fnb-btn primary-btn border-btn full">Modify</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sticky-bottom mobile-flex desk-hide active">
                    <div class="actions">
                       <button class="btn fnb-btn primary-btn full border-btn send-enquiry form-toggle">Modify Details</button>
                    </div>
                 </div>
            </div>
        </div>

















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
