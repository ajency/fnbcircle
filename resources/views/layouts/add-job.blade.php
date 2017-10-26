@extends('layouts.app')
@section('title', $pageName )
@section('css')
    <!-- Magnify css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/magnify.css') }}">
    <!-- Dropify css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dropify.css') }}">
    <!-- tags css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/jquery-flexdatalist/jquery.flexdatalist.min.css') }}">
    <!-- multiselect -->
    <link href="{{ asset('css/bootstrap-multiselect.min.css') }}" rel="stylesheet">
    <!-- Ckeditor -->
    <!-- <link href="/js/ckeditor/toolbarconfigurator/lib/codemirror/neo.css" rel="stylesheet"> -->
@endsection

@section('js')
       <!-- Magnify popup plugin -->
    <script type="text/javascript" src="{{ asset('js/magnify.min.js') }}"></script>
    <!-- Read more -->
    <script type="text/javascript" src="{{ asset('js/readmore.min.js') }}"></script>
    <!-- Dropify -->
    <script type="text/javascript" src="{{ asset('js/dropify.js') }}"></script>
    <!-- jquery tags -->
    <script type="text/javascript" src="{{ asset('bower_components/jquery-flexdatalist/jquery.flexdatalist.min.js') }}"></script>

      <script type="text/javascript" src="{{ asset('js/underscore-min.js') }}" ></script>
    <!-- Custom file input -->

    <!-- multiselect -->
    <script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>

    <!-- Ckeditor -->
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/jquery.custom-file-input.js') }}"></script>

    <!-- Read More -->
    <script type="text/javascript" src="{{ asset('js/readmore.min.js') }}"></script>


    <!-- Add listing -->
    <!-- <script type="text/javascript" src="{{ asset('js/add-listing.js') }}"></script> -->
    <!-- custom script -->
    <script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>

     <!-- <script src="{{ asset('js/AddListing.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('js/handlebars.js') }}"></script>
    <!-- <script type="text/javascript" src="/js/require.js"></script> -->

    @if(Session::has('job_review_pending')) 
     <script type="text/javascript">
    $(document).ready(function() {
        $('#job-review').modal('show');
    });
    </script> 
    @endif 
@endsection

@section('content')
<!-- content -->
    <div class="preview-header text-color mobile-hide">
        <div class="container">
            <div class="pull-left">
                <span class="text-primary">Note:</span> You can add multiple jobs on FnB Circle
            </div> 
            @if($job->isJobVisible())
            <div class="pull-right">
                <a href="{{ url('/job/'.$job->getJobSlug()) }}" class="secondary-link preview-header__link"><i class="fa fa-eye" aria-hidden="true"></i> Preview Job</a>
            </div>
            @endif
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
                                <p class="fnb-breadcrums__title">{{ $breadcrumb }}</p>
                            </a>
                        </li>
                    </ul>
                    <!-- Breadcrums ends -->
                </div>
                @if($job->isJobVisible())
                <div class="col-sm-4 flex-col text-right mobile-hide">
                    <div class="detach-preview mobile-hide">
                        <a href="{{ url('/job/'.$job->getJobSlug()) }}" class="preview-header__link white btn fnb-btn white-border mini"><i class="fa fa-eye" aria-hidden="true"></i> Preview Job</a>
                    </div>
                </div> 
                @endif
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
                                    <h5 class="word-break">{{ $job->title }}</h5>
                                    <div class="listing-status">
                                        <div class="label">STATUS</div>
                                        <div class="flex-row space-between">
                                            <div class="statusMsg">{{ $job->getJobStatus()}} 
                                            @if($job->status == 1)
                                            <i class="fa fa-info-circle text-color m-l-5 draft-status" data-toggle="tooltip" data-placement="top" title="Job will remain in draft status till submitted for review."></i>
                                            @endif



                                            </div>
                                            @if($job->submitForReview()) 
                                            <a href="{{ url('/jobs/'.$job->reference_id.'/submit-for-review') }}" >Submit for Review</a>
                                            @endif

                                            @if($job->getNextActionButton())
                                                @php
                                                $nextActionBtn =$job->getNextActionButton();
                                                @endphp
                                                
                                             <a @if($job->status != 5) data-toggle="modal" data-target="#confirmBox" href="#" @else href="{{ url('/jobs/'.$job->reference_id.'/update-status/'.str_slug($nextActionBtn['status'])) }}"  @endif >{{ $nextActionBtn['status'] }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="dsk-separator">

                                <ul class="gs-steps" role="tablist" >
                                    <li class=""> 
                                        <a href="@if(!$job->id || $step == 'job-details') # @else {{ url('/jobs/'.$job->reference_id.'/job-details') }} @endif" class="@if(!$job->id || $step == 'job-details') form-toggle @endif" id="job_details">Job Details <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </li>

                                   <li class="busCat @if(!$job->id) disable @endif">
                                        <a href="@if($step == 'company-details') # @else {{ url('/jobs/'.$job->reference_id.'/company-details') }} @endif" class="@if(!$job->id || $step == 'company-details') form-toggle @endif" id="company_details">Company Details <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </li>

                                    <li class="@if(!$job->isJobDataComplete()) disable @endif">
                                        <a href="@if($step == 'go-premium') # @else {{ url('/jobs/'.$job->reference_id.'/go-premium') }} @endif" class="@if(!$job->id || $step == 'go-premium') form-toggle @endif" id="plan_selection">Go Premium<i class="fa fa-arrow-right" aria-hidden="true"></i></a>
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
                                    <a href="/pdf/sample-job.pdf" class="mobile-hide" target="_blank">
                                        <img src="/img/sample_listing.png" class="img-responsive">
                                    </a>
                                    <a href="/pdf/sample-job.pdf" class="desk-hide">View the sample</a>
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
                                        Get 10 X times more response.
                                    </div>
                                    <div class="first tips-row__col flex-row align-top">
                                        <span class="number">
                                            2
                                        </span>
                                        Get premium tag which makes your requirement stand out from rest.
                                    </div>
                                    <div class="first tips-row__col flex-row align-top">
                                        <span class="number">
                                            3
                                        </span>
                                        Your job gets displayed on top of other non premium jobs and gets top priority.
                                    </div>
                                    <div class="first tips-row__col flex-row">
                                        <span class="number">
                                            4
                                        </span>
                                        20 extra days of visibility.
                                    </div>
                                    <div class="first tips-row__col flex-row align-top">
                                        <span class="number">
                                            5
                                        </span>
                                        Your job is displayed to candidates while searching for similar other jobs of other employers.
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
                                        
                                        @if($job->isJobVisible())
                                        <div>
                                            <a href="{{ url('/job/'.$job->getJobSlug()) }}" class="fnb-btn mini outline btn preview-header__link">Preview</a>
                                        </div>
                                        @endif
                                   
                                </div>
                                <div class="fly-out__content">
                                    @if($job->isJobVisible())
                                    <!-- <div class="preview-header text-color desk-hide"> Do you want to see a preview of your job? <a href="{{ url('/job/'.$job->getJobSlug()) }}" class="secondary-link preview-header__link">Preview</a>
                                    </div> -->
                                    @endif
                                    <p class="note-row__text--status text-medium desk-hide">

                                           <span class="text-primary bolder status-changer">Note:</span> You can add multiple jobs on FnB Circle 
                                           
                                           <!-- <span class="text-primary bolder status-changer">Published  </span>  --><!-- <i class="fa fa-info-circle text-color m-l-5" data-toggle="tooltip" data-placement="top" title="Listing will remain in draft status till submitted for review."></i> -->

                                         
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
                                    <div class="alert fnb-alert @if ($errors->any()) server-error @else hidden @endif alert-failure alert-dismissible fade in " role="alert">
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
                                        <form id="job-form" method="post" action="{{ $postUrl }}" data-parsley-validate enctype="multipart/form-data">
                                            
                                            @yield('form-data')

                                        <!-- Submit for review section -->
                                 
                                        @if($job->submitForReview() && hasAccess('submit_review_element',$job->reference_id,'jobs')) 
                                        <div class="m-t-0 c-gap">
                                           <div class="review-note flex-row space-between">
                                                <div class="review-note__text flex-row">
                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                    <p class="review-note__title">If you don't want to further complete/edit the job, you can submit it for review</p>
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
                                        <input type="hidden" name="has_changes" value="0">
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


            @include('jobs.job-status-modal')



              
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
