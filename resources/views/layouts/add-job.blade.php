@extends('layouts.fnbtemplate')
@section('title', 'Add Job')
@section('css')
    <!-- Magnify css -->
    <link rel="stylesheet" type="text/css" href="/css/magnify.css">
    <!-- Dropify css -->
    <link rel="stylesheet" type="text/css" href="/css/dropify.css">
    <!-- tags css -->
    <link rel="stylesheet" type="text/css" href="/css/jquery.flexdatalist.min.css">
    <!-- multiselect -->
    <link href="/css/bootstrap-multiselect.min.css" rel="stylesheet">
    <!-- Ckeditor -->
    <!-- <link href="/js/ckeditor/toolbarconfigurator/lib/codemirror/neo.css" rel="stylesheet"> -->
@endsection

@section('js')
       <!-- Magnify popup plugin -->
    <script type="text/javascript" src="/js/magnify.min.js"></script>
    <!-- Read more -->
    <script type="text/javascript" src="/js/readmore.min.js"></script>
    <!-- Dropify -->
    <script type="text/javascript" src="/js/dropify.js"></script>
    <!-- jquery tags -->
    <script type="text/javascript" src="/js/flex-datalist/jquery.flexdatalist.min.js"></script>

      <script type="text/javascript" src="/js/underscore-min.js" ></script>
    <!-- Custom file input -->

    <!-- multiselect -->
    <script src="/js/bootstrap-multiselect.js"></script>

    <!-- Ckeditor -->
    <script src="/js/ckeditor/ckeditor.js"></script>

    <script type="text/javascript" src="/js/jquery.custom-file-input.js"></script>
    <!-- Add listing -->
    <script type="text/javascript" src="/js/add-listing.js"></script>
    <!-- custom script -->
    <script type="text/javascript" src="/js/custom.js"></script>

     <script src="{{ asset('js/AddListing.js') }}"></script>
    <script type="text/javascript" src="/js/handlebars.js"></script>
    <script type="text/javascript" src="/js/require.js"></script>
@endsection

@section('content')
<!-- content -->
    <div class="preview-header text-color mobile-hide">
        <div class="container">
            <div class="pull-left">
                <span class="text-primary">Note:</span> You can add multiple jobs on FnB Circle
            </div>
            <div class="pull-right">
                <a href="" class="secondary-link preview-header__link"><i class="fa fa-eye" aria-hidden="true"></i> Preview Job</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <!-- <div class="header-shifter"></div> -->

    <div class="profile-stats breadcrums-row no-shadow">
        <div class="container">
            <div class="row p-t-30 p-b-30 mobile-flex breadcrums-container jobs-listing edit-mode  ">
                <div class="col-sm-8 flex-col">
                    <!-- Breadcrums -->
                    <ul class="fnb-breadcrums flex-row">
                        <li class="fnb-breadcrums__section">
                            <a href="">
                                <i class="fa fa-home home-icon" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="fnb-breadcrums__section">
                            <a href="">
                                <p class="fnb-breadcrums__title">/</p>
                            </a>
                        </li>
                        <li class="fnb-breadcrums__section">
                            <a href="#">
                                <p class="fnb-breadcrums__title">Add a Job</p>
                            </a>
                        </li>
                    </ul>
                    <!-- Breadcrums ends -->
                </div>
                <div class="col-sm-4 flex-col text-right mobile-hide">
                    <a href="http://staging.fnbcircle.com/single-view.html" class="preview-header__link white btn fnb-btn white-border mini"><i class="fa fa-eye" aria-hidden="true"></i> Preview Job</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container jobs-container">
        <div class="row">
            <div class="col-xs-12 content-wrapper edit-mode ">
                <div class="flex-row note-row top-head m-b-15 m-t-15">
                    <h3 class="main-heading m-b-0 m-t-0 white">Let's get started! <span class="dis-block xxx-small lighter m-t-10">You are few steps away from posting a job on FnB Circle</span></h3>
                </div>

                <div class="m-t-20 m-b-10 white-bg-border">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3">
                            @if($job->id)
                            <div class="dsk-separator edit-summary-card">

                                <div class="summary-info">
                                    <h5>{{ $job->title }}</h5>
                                    <div class="listing-status">
                                        <div class="label">STATUS</div>
                                        <div class="flex-row space-between">
                                            <div class="statusMsg">{{ $job->getJobStatus()}} <i class="fa fa-info-circle text-color m-l-5 draft-status" data-toggle="tooltip" data-placement="top" title="Job will remain in draft status till submitted for review."></i></div>
                                            <!-- <a href="#" class="review-submit-link">Submit for Review</a> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="dsk-separator">

                                <ul class="gs-steps" role="tablist" >
                                    <li class=""> 
                                        <a href="@if(!$job->id || $step == 'step-one') # @else {{ url('/jobs/'.$job->reference_id.'/step-one') }} @endif" class="@if(!$job->id || $step == 'step-one') form-toggle @endif" id="job_details">Job Details <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </li>

                                   <li class="busCat @if(!$job->id) disable @endif">
                                        <a href="@if($step == 'step-two') # @else {{ url('/jobs/'.$job->reference_id.'/step-two') }} @endif" class="@if(!$job->id || $step == 'step-two') form-toggle @endif" id="company_details">Company Details <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </li>

                                    <li class="@if(!$job->id) disable @endif">
                                        <a href="@if($step == 'step-three') # @else {{ url('/jobs/'.$job->reference_id.'/step-three') }} @endif" class="@if(!$job->id || $step == 'step-three') form-toggle @endif" id="plan_selection">Plan Selection <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                            </div>

                            <div class="view-sample dsk-separator m-t-20 m-b-20">
                                <div class="tips-header flex-row">
                                    <img src="/img/bulb.png" class="img-responsive p-r-10">
                                    <!-- <i class="fa fa-lightbulb-o  sub-title text-primary" aria-hidden="true"></i> --> Tips to create a good job post
                                </div>
                                <div class="tips-row">
                                    <div class="first tips-row__col flex-row">
                                        <span class="number">
                                            1
                                        </span>
                                        Fill in the details of the job properly.
                                    </div>
                                    <div class="first tips-row__col flex-row">
                                        <span class="number">
                                            2
                                        </span>
                                        Ensure that you provide correct contact details.
                                    </div>
                                    <div class="first tips-row__col flex-row">
                                        <span class="number">
                                            3
                                        </span>
                                        Job description should be clear.
                                    </div>
                                    <div class="first tips-row__col flex-row">
                                        <span class="number">
                                            4
                                        </span>
                                        Highlight the important details related to the job.
                                    </div>
                                </div>
                            </div>

                            <div class="view-sample dsk-separator m-t-20 m-b-20">
                                This is what your job will look like once created.
                                <div class="m-t-10">
                                    <a href="/pdf/sample-project.pdf" class="mobile-hide" target="_blank">
                                        <img src="/img/sample_listing.png" class="img-responsive">
                                    </a>
                                    <a href="/pdf/sample-project.pdf" class="desk-hide">View the sample</a>
                                </div>
                            </div>


                            <div class="view-sample dsk-separator m-t-20 m-b-20">
                                <div class="tips-header text-medium flex-row">
                                    <img src="/img/power-icon.png" class="img-responsive p-r-10" width="40">
                                    <!-- <i class="fa fa-lightbulb-o  sub-title text-primary" aria-hidden="true"></i> --> <span class="bolder p-r-5">GO PREMIUM!!</span> Read why..
                                </div>
                                <div class="tips-row">
                                    <div class="first tips-row__col flex-row">
                                        <span class="number">
                                            1
                                        </span>
                                        Premium jobs get more applicants as compared to non premium.
                                    </div>
                                    <div class="first tips-row__col flex-row">
                                        <span class="number">
                                            2
                                        </span>
                                        Premium jobs are displayed on top in the search results.
                                    </div>
                                    <div class="first tips-row__col flex-row">
                                        <span class="number">
                                            3
                                        </span>
                                        Premium jobs will be indicated with a premium label!
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <div class="pos-fixed fly-out no-transition slide-bg @if($job->id) active @endif">
                                <div class="mobile-back desk-hide mobile-flex  p-v-10   ">
                                    <div class="left mobile-flex">
                                        <i class="fa fa-arrow-left text-primary back-icon" aria-hidden="true"></i>
                                        <p class="element-title heavier m-b-0">Back</p>
                                    </div>
                                    
                                        <div>
                                            <a href="http://staging.fnbcircle.com/single-view.html" class="fnb-btn mini outline btn preview-header__link">Preview</a>
                                        </div>
                                   
                                </div>
                                <div class="fly-out__content">
                                    <div class="preview-header text-color desk-hide"> Do you want to see a preview of your job? <a href="http://staging.fnbcircle.com/single-view.html" class="secondary-link preview-header__link">Preview</a>
                                    </div>
                                    <p class="note-row__text--status text-medium desk-hide">

                                           <span class="text-primary bolder status-changer">Note:</span> You can add multiple jobs on FnB Circle <span class="text-primary bolder status-changer">Published  </span> <!-- <i class="fa fa-info-circle text-color m-l-5" data-toggle="tooltip" data-placement="top" title="Listing will remain in draft status till submitted for review."></i> -->

                                         
                                    </p>
                                    <div class="gs-form tab-content   p-t-0  ">
                                        <div class="site-loader section-loader hidden">
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

                                    <!-- failure message-->
                                    <div class="alert fnb-alert @if ($errors->any()) server-error @endif alert-failure alert-dismissible fade in " role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <div class="flex-row">
                                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                             Oh snap! Some error occurred. Please check all the details and proceed.
                                        </div>

                                        <ul>
                                                  @foreach ($errors->all() as $error)
                                                      <li>{{ $error }}</li>
                                                  @endforeach
                                              </ul>
                                    </div>
                                        <form id="job-form" method="post" action="{{ $postUrl }}" data-parsley-validate>
                                            
                                            @yield('form-data')

                                        <!-- Submit for review section -->
                                 
                                        @if($job->id && $job->status == 1) 
                                        <div class="m-t-0 c-gap">
                                           <div class="review-note flex-row space-between">
                                                <div class="review-note__text flex-row">
                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                    <p class="review-note__title">If you don't want to further complete/edit the listing, you can submit it for review</p>
                                                </div>
                                               <div class="review-note__submit">
                                                   <a href="{{ url('/jobs/'.$job->reference_id.'/submit-for-review') }}" class="primary-link sub-title ">Submit for Review</a>
                                               </div>
                                           </div>
                                        </div>
                                        @endif
                                       
                                        <!-- content navigation -->
                                        <div class="gs-form__footer flex-row m-t-30">
                                        @if($back_url)
                                            <a class="btn fnb-btn outline no-border gs-prev" href="{{ $back_url }}"><i class="fa fa-arrow-left" aria-hidden="true" ></i> Back</a>  
                                        @endif
                                            <button class="btn fnb-btn primary-btn full  info-save gs-next job-save-btn" type="submit">Save &amp; Next</button>
                                            <!-- <button class="btn fnb-btn outline no-border ">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button> -->
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- categories select modal -->
                <!-- Button trigger modal -->
                <!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#verification-step-modal">
                  Launch demo modal
                </button> -->


                <!-- Modal -->
                <!-- listing review -->
                <div class="modal fnb-modal listing-review fade modal-center" id="job-review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close" data-dismiss="modal" aria-label="Close">&#10005;</button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="listing-message">
                                    <i class="fa fa-check-circle check" aria-hidden="true"></i>
                                    <h4 class="element-title heavier">We have sent your job for review</h4>
                                    <p class="default-size text-color lighter list-caption">Our team will review your job and you will be notified if your job is published.</p>
                                </div>
                                <div class="listing-status highlight-color">
                                    <p class="m-b-0 text-darker heavier">The current status of your job is</p>
                                    <div class="pending text-darker heavier sub-title"><i class="fa fa-clock-o text-primary p-r-5" aria-hidden="true"></i> Pending Review <!-- <i class="fa fa-info-circle text-darker p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pending review"></i> --></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                    <button class="btn fnb-btn outline cancel-modal border-btn" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- listing present -->
                <div class="modal fnb-modal duplicate-listing fade multilevel-modal" id="duplicate-listing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="level-one mobile-hide">
                                    <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="listing-details text-center">
                                    <img src="/img/listing-search.png" class="img-responsive center-block">
                                    <h5 class="listing-details__title sub-title">Looks like the listing is already present on F&amp;BCircle.</h5>
                                    <p class="text-lighter lighter listing-details__caption default-size">Please confirm if the following listing(s) belongs to you.
                                        <br> You can either Claim the listing or Delete it.</p>
                                </div>
                                <div class="list-entries">
                                    <div class="list-row flex-row">
                                        <div class="left">
                                            <h5 class="sub-title text-medium text-capitalise list-title">Mystical the meat and fish store</h5>
                                            <p class="text-color default-size">
                                                <i class="fa fa-exclamation-circle p-r-5 text-primary" aria-hidden="true"></i> <span class="lighter">Matches found Phone Number (<span class="heavier">+91 9876543200</span>)</span>
                                            </p>
                                        </div>
                                        <div class="right">
                                            <div class="capsule-btn flex-row">
                                                <button class="btn fnb-btn outline full border-btn no-border claim text-danger">Claim</button>
                                                <button class="btn fnb-btn outline full border-btn no-border delete">Delete</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="list-row flex-row">
                                        <div class="left">
                                            <h5 class="sub-title text-medium text-capitalise list-title">Mystical the meat and fish store</h5>
                                            <p class="text-color default-size">
                                                <i class="fa fa-exclamation-circle p-r-5 text-primary" aria-hidden="true"></i> <span class="lighter">Matches found Phone Number (<span class="heavier">+91 9876543200</span>)</span>
                                            </p>
                                        </div>
                                        <div class="right">
                                            <div class="capsule-btn flex-row">
                                                <button class="btn fnb-btn outline full border-btn no-border claim text-danger">Claim</button>
                                                <button class="btn fnb-btn outline full border-btn no-border delete">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn fnb-btn outline full border-btn no-border skip text-danger" data-dismiss="modal" aria-label="Close">Skip <i class="fa fa-forward p-l-5" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-loader full-loader hidden">
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
        <div class="site-overlay"></div>
    </div>
    <!-- content ends -->
@endsection
