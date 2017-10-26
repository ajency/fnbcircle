@extends('layouts.app')

@section('title')
Job Listing
@endsection

@section('content')

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

    
@endsection
<!-- </body> -->
