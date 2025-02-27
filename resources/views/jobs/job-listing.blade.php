@extends('layouts.app')

@section('title')
Job Listing
@endsection

@php
$additionalData = ['urlFilters'=>$urlFilters,'currentUrl'=>$currentUrl ];
@endphp

@section('openGraph')   
{!! getMetaTags('App\Seo\JobListView',$additionalData) !!}
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/jquery-flexdatalist/jquery.flexdatalist.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('js/ion-rangeslider/css/ion.rangeSlider.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('js/ion-rangeslider/css/ion.rangeSlider.skinModern.css') }}">
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('bower_components/jquery-flexdatalist/jquery.flexdatalist.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('js/jobs-listing.js') }}"></script>
@endsection    

@section('content')

<!-- <body class="highlight-color"> -->
    
    <!-- content -->

    <!-- Banner -->
    <div class="fnb-banner">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="pos-fixed fly-out fixed-bg searchBy">
                        <div class="mobile-back desk-hide mobile-flex">
                            <div class="left mobile-flex">
                                <i class="fa fa-arrow-left text-primary back-icon" aria-hidden="true"></i>
                                <p class="element-title heavier m-b-0">Search By</p>
                            </div>
                            <!-- <div class="right">
                                <a href="" class="text-primary heavier element-title">Clear All</a>
                            </div> -->
                        </div>
                        <div class="fly-out__content">
                            <div class="search-section">
                                <h4 class="sub-title search-section__title">Tell us what are you looking for</h4>
                                <div class="search-section__cols flex-row">
                                    <div class="city search-boxes flex-row">
                                        <i class="fa fa-map-marker p-r-5 icons" aria-hidden="true"></i>
                                    
   
                                        <select name="job_city" class="form-control fnb-select search-job p-l-20">
                                        @foreach($cities as $city)
                                        @php
                                            $selectedCity = '';

                    
                                            if(isset($urlFilters['state'])){
                                                
                                                if($urlFilters['state']== $city->slug)
                                                    $selectedCity = 'selected';
                                            } 
                                            elseif($serachCity== $city->name){
                                               $selectedCity = 'selected';
                                            }
                                             
                                                
                                                                              
                                        @endphp
                                        <option {{ $selectedCity }}  value="{{ $city->slug }}" id="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                        </select>
                                    </div>

                                    <ul class="nav nav-tabs desk-hide mobile-flex" role="tablist">
                                        <li role="presentation" class="active"><a href="#category" aria-controls="home" role="ab" data-toggle="tab">Business Type</a></li>
                                        <li role="presentation"><a href="#business" aria-controls="profile" role="tab" data-toggle="tab">Job Title</a></li>
                                    </ul>

                                      <div class="tab-con flex-row">
                                        <div role="tabpanel" class="tab-pane active" id="category">
                                            <div class="category search-boxes flex-row">
                                                <i class="fa fa-search p-r-5 icons" aria-hidden="true"></i>
                                                <input type="text" name="search_category" class="form-control fnb-input search-job-categories " placeholder="Search for a specific business type job" value="@if(isset($urlFilters['category_name'])){{ $urlFilters['category_name'] }}@endif">

                                                <input type="hidden" name="category_id" slug="@if(isset($urlFilters['business_type'])){{ $urlFilters['business_type'] }}@endif" value="@if(isset($urlFilters['category_id'])){{ $urlFilters['category_id'] }}@endif">  
                                                <a href="javascript:void(0)" class="clear-input-text desk-hide">clear</a>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="business">
                                            <div class="business search-boxes flex-row">
                                                <i class="fa fa-search p-r-5 icons" aria-hidden="true"></i>
                                                <input type="text" id="job_name" name="job_name" class="form-control fnb-input search-job-title" placeholder="Search for a specific job" value="@if(isset($urlFilters['job_name'])){{ $urlFilters['job_name'] }}@endif">
                                                <a href="javascript:void(0)" class="clear-input-text desk-hide">clear</a>
                                                <div class="right desk-hide hidden">
                                                     | 
                                                    <a href="javascript:void(0)" class="text-primary heavier element-title title-search-btn ">Search</a>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- banner ends -->

    <!-- Container -->
    <div class="container">
        <div class="row m-t-30 p-t-30 m-b-30 mobile-flex breadcrums-container mobile-hide">
            <div class="col-sm-8 flex-col">
                <!-- Breadcrums -->

                {!! getPageBreadcrum('App\Seo\JobListView',$additionalData) !!}
                <!-- Breadcrums ends -->
            </div>
            <div class="col-sm-4 flex-col">
            </div>
        </div>
        <!-- section headings -->
        <div class="row addShow">
            <div class="col-sm-8 mobile-hide">
                <h5 class="m-t-0"><span class="serach_category_name">@if(isset($urlFilters['category_name'])){{ ucwords($urlFilters['category_name']) }}@endif</span> Jobs <span class="text-lighter">in</span> <span class="serach_state_name">{{ ucwords($urlFilters['state']) }}</span></h5>
            </div>
            <div class="col-sm-4">
                <div class="search-actions mobile-flex ">
                    <p class="sub-title text-color text-right search-actions__title show-count-title mobile-hide">Showing <span id="filtered_count"></span> out of <span class="total_count"></span>  <span class="serach_category_name">@if(isset($urlFilters['category_name'])){{ ucwords($urlFilters['category_name']) }}@endif</span> Jobs in <span class="serach_state_name">{{ ucwords($urlFilters['state']) }}</span></p>

                    <p class="sub-title text-color text-right search-actions__title show-count-title desk-hide">Showing  <span class="total_count"></span>  <span class="serach_category_name">@if(isset($urlFilters['category_name'])){{ ucwords($urlFilters['category_name']) }}@endif</span> Jobs in <span class="serach_state_name">{{ ucwords($urlFilters['state']) }}</span></p>

                    <div class="desk-hide flex-row search-actions__btn">
                        <div class="search-by sub-title trigger-section heavier">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            Search By
                        </div>
                        <div class="filter-by sub-title trigger-section heavier">
                            <i class="fa fa-filter" aria-hidden="true"></i>
                            Filter By
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- section heading ends -->
    
        <!-- Advertisement -->

        <div class="advertisement small flex-row m-t-20">
            <h6 class="element-title">Advertisement</h6>
        </div>

        <!-- Advertisement ends -->


        <div class="row m-t-25 row-margin">
            @include('jobs.job-listing-sidebar')
            <div class="col-sm-9 custom-col-9">
                <div class="job-listings">
                    <div class="site-loader section-loader m-t-30">
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
                <div class="site-loader full-page-loader section-loader hidden">
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
                <div class="job-pagination"></div>
            </div>
            <input type="hidden" name="listing_page" value="{{ $urlFilters['page'] }}">
        </div>
        <div class="site-overlay"></div>
    </div>
@endsection
<!-- </body> -->
