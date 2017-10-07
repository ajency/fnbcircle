@extends('layouts.app')

@section('title')
Job Listing
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/jquery-flexdatalist/jquery.flexdatalist.min.css') }}">
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('bower_components/jquery-flexdatalist/jquery.flexdatalist.min.js') }}"></script>
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
                            <div class="right">
                                <a href="" class="text-primary heavier element-title">Clear All</a>
                            </div>
                        </div>
                        <div class="fly-out__content">
                            <div class="search-section">
                                <h4 class="sub-title search-section__title">Tell us what are you looking for</h4>
                                <div class="search-section__cols flex-row">
                                    <div class="city search-boxes flex-row">
                                        <i class="fa fa-map-marker p-r-5 icons" aria-hidden="true"></i>
                                    
   
                                        <select name="job_city" class="form-control fnb-select search-job">
                                        @foreach($cities as $city)
                                        @php
                                            $selectedCity = '';

                    
                                            if(isset($urlFilters['city'])){
                                                
                                                if($urlFilters['city']== $city->id)
                                                    $selectedCity = 'selected';
                                            } 
                                            elseif($serachCity== $city->name){
                                               $selectedCity = 'selected';
                                            }
                                             
                                                
                                                                              
                                        @endphp
                                        <option {{ $selectedCity }}  value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                        </select>
                                    </div>

                                    <ul class="nav nav-tabs desk-hide mobile-flex" role="tablist">
                                        <li role="presentation" class="active"><a href="#category" aria-controls="home" role="ab" data-toggle="tab">Category</a></li>
                                        <li role="presentation"><a href="#business" aria-controls="profile" role="tab" data-toggle="tab">Business Name</a></li>
                                    </ul>

                                      <div class="tab-con flex-row">
                                        <div role="tabpanel" class="tab-pane active" id="category">
                                            <div class="category search-boxes flex-row">
                                                <i class="fa fa-search p-r-5 icons" aria-hidden="true"></i>
                                                <input type="text" name="search_category" class="form-control fnb-input job-categories flexdatalist" placeholder="Start typing to search category..." value="@if(isset($urlFilters['category_name'])){{ $urlFilters['category_name'] }}@endif">
                                                <input type="hidden" name="category_id" value="@if(isset($urlFilters['category'])){{ $urlFilters['category'] }}@endif">  
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="business">
                                            <div class="business search-boxes flex-row">
                                                <i class="fa fa-search p-r-5 icons" aria-hidden="true"></i>
                                                <input type="text" id="job_name" name="job_name" class="form-control fnb-input search-job" placeholder="Search for a specific job" value="@if(isset($urlFilters['job_name'])){{ $urlFilters['job_name'] }}@endif">
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
                        <a href="">
                            <p class="fnb-breadcrums__title">Delhi</p>
                        </a>
                    </li>
                    <li class="fnb-breadcrums__section">
                        <a href="">
                            <p class="fnb-breadcrums__title">/</p>
                        </a>
                    </li>
                    <li class="fnb-breadcrums__section">
                        <a href="">
                            <p class="fnb-breadcrums__title main-name">Meat &amp; Poultry</p>
                        </a>
                    </li>
                    <li class="fnb-breadcrums__section">
                        <a href="">
                            <p class="fnb-breadcrums__title">/</p>
                        </a>
                    </li>
                    <li class="fnb-breadcrums__section">
                        <a href="">
                            <p class="fnb-breadcrums__title main-name">Chicken</p>
                        </a>
                    </li>
                </ul>
                <!-- Breadcrums ends -->
            </div>
            <div class="col-sm-4 flex-col">
            </div>
        </div>
        <!-- section headings -->
        <div class="row addShow">
            <div class="col-sm-8 mobile-hide">
                <h5 class="m-t-0">Meat &amp; Poultry <span class="text-lighter">in</span> Delhi</h5>
            </div>
            <div class="col-sm-4">
                <div class="search-actions mobile-flex">
                    <p class="sub-title text-color text-right search-actions__title">Showing <span id="filtered_count"></span> out of <span id="total_count"></span> Jobs in <span id="state_name">Delhi</span></p>
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
            <div class="col-sm-9 custom-col-9 job-listings">
   
                
                
            </div>
            <div class="job-pagination"></div>
            <input type="hidden" name="listing_page" value="{{ $urlFilters['page'] }}">
        </div>
        <div class="site-overlay"></div>
    </div>
@endsection
<!-- </body> -->
