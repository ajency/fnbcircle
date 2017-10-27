@extends('layouts.app')

@section('title')
Job Listing
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/dropify.css') }}">
@endsection

@section('js')
    @parent
    <!-- Dropify -->
    <script type="text/javascript" src="{{ asset('js/dropify.js') }}"></script>
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
                         
                            @if(!empty($userResume['resume_id']))
                             
                            <span class="text-lighter">Resume last updated on: {{ $userResume['resume_updated_on'] }}</span>
                            <input type="hidden" name="resume_id" value="{{ $userResume['resume_id'] }}">
                            <a href="{{ url('/user/download-resume')}}?resume={{ $userResume['resume_url'] }}">download</a>
                            @else
                            <p class="default-size heavier m-b-0">You do not have resume uploaded on your profile</p>
                            Please upload your resume
                             
                            @endif

                            <div class="row m-t-15 m-b-15 c-gap">
                            <div class="col-sm-4 fileUpload">
                                <input type="file" name="resume" class="resume-upload" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="doc docx pdf" data-parsley-errors-container="#resume-error"/> 
                                <div id="resume-error"></div>
                            </div>
                          </div>

                             <button class="btn fnb-btn primary-btn border-btn code-send full center-block" type="submit">Upload Resume <i class="fa fa-circle-o-notch fa-spin hidden"></i></button>
 
                        </form>
                        </div>


@endsection
<!-- </body> -->
