@extends('layouts.app')

@section('title')
List View
@endsection

@section('css')
@endsection

@section('js')

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
                                        <select class="form-control fnb-select">
                                            <option>--Change city--</option>
                                            <option>Pune</option>
                                            <option selected="">Delhi</option>
                                            <option>Mumbai</option>
                                            <option>Goa</option>
                                        </select>
                                    </div>

                                  <!--   <div class="category search-boxes flex-row">
                                        <i class="fa fa-search p-r-5 icons" aria-hidden="true"></i>
                                        <input type="text" class="form-control fnb-input" placeholder="Start typing to search category...">
                                    </div>
                                    <div class="business search-boxes flex-row">
                                        <i class="fa fa-search p-r-5 icons" aria-hidden="true"></i>
                                        <input type="text" class="form-control fnb-input" placeholder="Start for a specific business">
                                    </div> -->

                                    <ul class="nav nav-tabs desk-hide mobile-flex" role="tablist">
                                        <li role="presentation" class="active"><a href="#category" aria-controls="home" role="ab" data-toggle="tab">Category</a></li>
                                        <li role="presentation"><a href="#business" aria-controls="profile" role="tab" data-toggle="tab">Business Name</a></li>
                                    </ul>

                                      <div class="tab-con flex-row">
                                        <div role="tabpanel" class="tab-pane active" id="category">
                                            <div class="category search-boxes flex-row">
                                                <i class="fa fa-search p-r-5 icons" aria-hidden="true"></i>
                                                <input type="text" class="form-control fnb-input" placeholder="Start typing to search category...">
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="business">
                                            <div class="business search-boxes flex-row">
                                                <i class="fa fa-search p-r-5 icons" aria-hidden="true"></i>
                                                <input type="text" class="form-control fnb-input" placeholder="Search for a specific business">
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
                    <p class="sub-title text-color text-right search-actions__title">Showing 455 Chicken in Delhi</p>
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
            <div class="col-sm-3 custom-col-3">
                <!-- filter sidebar -->
                <div class="pos-fixed fly-out filterBy">
                    <div class="mobile-back desk-hide mobile-flex">
                        <div class="left mobile-flex">
                            <i class="fa fa-arrow-left text-primary back-icon" aria-hidden="true"></i>
                            <p class="element-title heavier m-b-0">Filter</p>
                        </div>
                        <div class="right">
                            <a href="" class="text-primary heavier element-title">Clear All</a>
                        </div>
                    </div>
                    <div class="fly-out__content">
                        <div class="filter-sidebar bg-card">
                            <!-- Results -->
                            <div class="results filter-sidebar__section">
                                <div class="results__header filter-row">
                                    <h6 class="element-title text-uppercase">Show Results for</h6>
                                </div>
                                <div class="results__body filter-row">
                                    <ul class="contents">
                                        <li class="branch">
                                            <p class="default-size"><i class="fa fa-angle-left p-r-5 arrow" aria-hidden="true"></i> Meat &amp; Poultry</p>
                                            <p class="default-size p-l-20">
                                                <a href="" class="text-inherit bolder">Chicken</a>
                                            </p>
                                            <ul class="node">
                                                <li class="node__child">
                                                    <a href="" class="text-darker">
                                                        <p class="default-size flex-row">Processed Chicken
                                                            <span class="text-lighter">(95)</span>
                                                        </p>
                                                    </a>
                                                </li>
                                                <li class="node__child">
                                                    <a href="" class="text-darker">
                                                        <p class="default-size flex-row">Boneless Chicken
                                                            <span class="text-lighter">(85)</span>
                                                        </p>
                                                    </a>
                                                </li>
                                                <li class="node__child">
                                                    <a href="" class="text-darker">
                                                        <p class="default-size flex-row">Chicken Wings
                                                            <span class="text-lighter">(76)</span>
                                                        </p>
                                                    </a>
                                                </li>
                                                <li class="node__child">
                                                    <a href="" class="text-darker">
                                                        <p class="default-size flex-row">Boiler Chicken
                                                            <span class="text-lighter">(30)</span>
                                                        </p>
                                                    </a>
                                                </li>
                                                <li class="node__child">
                                                    <a href="" class="text-darker">
                                                        <p class="default-size flex-row">Chicken Drumstick
                                                            <span class="text-lighter">(45)</span>
                                                        </p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- results ends -->
                            <div class="filter-group area">
                                <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-area" aria-expanded="false" aria-controls="section-area">
                                    <h6 class="sub-title flex-row">Search by Area <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
                                    </h6>
                                </div>
                                <div class="filter-group__body filter-row collapse in" id="section-area">
                                    <div class="search-area flex-row">
                                        <i class="fa fa-search p-r-10 search-icon" aria-hidden="true"></i>
                                        <input type="text" class="form-control fnb-input search-input text-color" placeholder="Search an area">
                                    </div>
                                    <div class="check-section">
                                        <label class="sub-title flex-row clear hidden">
                                            <a href="" class="text-color">
                                               <i class="fa fa-times" aria-hidden="true"></i>
                                                <span>Clear All</span>
                                            </a>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                            <input type="checkbox" class="checkbox p-r-10">
                                            <span>Adarsh nagar</span>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                            <input type="checkbox" class="checkbox p-r-10">
                                            <span>Babarpur</span>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                            <input type="checkbox" class="checkbox p-r-10">
                                            <span>Badli</span>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                            <input type="checkbox" class="checkbox p-r-10">
                                            <span>Chandichawk</span>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                            <input type="checkbox" class="checkbox p-r-10">
                                            <span>Gandhi nagar</span>
                                        </label>
                                        <div class="more-section collapse" id="moreDown">
                                            <label class="sub-title flex-row text-color">
                                                <input type="checkbox" class="checkbox p-r-10">
                                                <span>Babarpur</span>
                                            </label>
                                            <label class="sub-title flex-row text-color">
                                                <input type="checkbox" class="checkbox p-r-10">
                                                <span>Badli</span>
                                            </label>
                                            <label class="sub-title flex-row text-color">
                                                <input type="checkbox" class="checkbox p-r-10">
                                                <span>Chandichawk</span>
                                            </label>
                                            <label class="sub-title flex-row text-color">
                                                <input type="checkbox" class="checkbox p-r-10">
                                                <span>Gandhi nagar</span>
                                            </label>
                                        </div>
                                        <p data-toggle="collapse" href="#moreDown" aria-expanded="false" aria-controls="moreDown" class="text-primary heavier text-right more-area m-b-0 default-size">+12 more</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Type of business -->
                            <div class="filter-group business-type no-gap">
                                <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-business" aria-expanded="false" aria-controls="section-business">
                                    <h6 class="sub-title flex-row">Type of Business <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
                                    </h6>
                                </div>
                                <div class="filter-group__body filter-row collapse in" id="section-business">
                                    <div class="check-section">
                                        <label class="sub-title flex-row clear hidden">
                                            <a href="" class="text-color">
                                               <i class="fa fa-times" aria-hidden="true"></i>
                                                <span>Clear All</span>
                                            </a>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                            <input type="checkbox" class="checkbox p-r-10">
                                            <span>Wholesaler</span>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                            <input type="checkbox" class="checkbox p-r-10">
                                            <span>Retailer</span>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                            <input type="checkbox" class="checkbox p-r-10">
                                            <span>Manufacturer</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- listing status -->
                            <div class="filter-group list-status no-gap">
                                <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-list-status" aria-expanded="false" aria-controls="section-list-status">
                                    <h6 class="sub-title flex-row">Listing Status <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
                                    </h6>
                                </div>
                                <div class="filter-group__body filter-row collapse in" id="section-list-status">
                                    <div class="check-section">
                                        <label class="sub-title flex-row clear hidden">
                                            <a href="" class="text-color">
                                               <i class="fa fa-times" aria-hidden="true"></i>
                                                <span>Clear All</span>
                                            </a>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                            <input type="checkbox" class="checkbox p-r-10">
                                            <span>Premium</span>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                            <input type="checkbox" class="checkbox p-r-10">
                                            <span>Verified</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- Ratings -->
                            <div class="filter-group rating-section no-gap">
                                <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-rating" aria-expanded="false" aria-controls="section-rating">
                                    <h6 class="sub-title flex-row">Ratings <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
                                    </h6>
                                </div>
                                <div class="filter-group__body filter-row collapse in" id="section-rating">
                                    <div class="check-section">
                                        <label class="sub-title flex-row text-color">
                                           <div class="rating-view p-r-10">
                                                <div class="rating">
                                                    <div class="bg"></div>
                                                    <div class="value" style="width: 100%;"></div>
                                                </div>
                                            </div>
                                            <span>&amp; Up (211)</span>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                           <div class="rating-view p-r-10">
                                                <div class="rating">
                                                    <div class="bg"></div>
                                                    <div class="value" style="width: 68%;"></div>
                                                </div>
                                            </div>
                                            <span>&amp; Up (23)</span>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                           <div class="rating-view p-r-10">
                                                <div class="rating">
                                                    <div class="bg"></div>
                                                    <div class="value" style="width: 50%;"></div>
                                                </div>
                                            </div>
                                            <span>&amp; Up (134)</span>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                           <div class="rating-view p-r-10">
                                                <div class="rating">
                                                    <div class="bg"></div>
                                                    <div class="value" style="width: 28%;"></div>
                                                </div>
                                            </div>
                                            <span>&amp; Up (344)</span>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                           <div class="rating-view p-r-10">
                                                <div class="rating">
                                                    <div class="bg"></div>
                                                    <div class="value" style="width: 16%;"></div>
                                                </div>
                                            </div>
                                            <span>&amp; Up (23)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- ratings ends -->
                            <!-- why fnb -->
                            <div class="filter-group whyFnb no-gap mobile-hide">
                                <div class="filter-group__header filter-row">
                                    <h6 class="element-title flex-row m-b-0 m-t-0">Why F&amp;B Circle?</h6>
                                </div>
                                <div class="filter-group__body filter-row">
                                    <div class="check-section">
                                        <label class="sub-title flex-row text-color">
                                            <i class="fa fa-check check p-r-10" aria-hidden="true"></i>
                                            <span>Get quotes from multiple suppliers</span>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                            <i class="fa fa-check check p-r-10" aria-hidden="true"></i>
                                            <span>Browse and find suppliers</span>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                            <i class="fa fa-check check p-r-10" aria-hidden="true"></i>
                                            <span>Post &amp; apply to the jobs</span>
                                        </label>
                                        <label class="sub-title flex-row text-color">
                                            <i class="fa fa-check check p-r-10" aria-hidden="true"></i>
                                            <span>Get updates in F&amp;B news</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- why fnb ends -->
                            <div class="business-listing businessListing p-t-30 p-b-30 text-center">
                                <!-- <span class="fnb-icons note"></span> -->
                                <div class="bl-top">
                                    <img src="{{ asset('/img/business-graph.png') }}" class="img-responsive center-block">
                                    <div class="business-listing__content m-b-15">
                                        <h6 class="sub-title business-listing__title">Increase your business sales on F&amp;BCircle</h6>
                                        <!-- <p class="default-size">Post your listing on F&amp;BCircle for free</p> -->
                                    </div>
                                </div>
                                <button class="btn fnb-btn outline full border-btn default-size">Learn more</button>
                            </div>
                            <!-- why fnb ends -->
                            <!-- Advertisement -->
                            <div class="adv-row">
                                <div class="advertisement flex-row m-t-20">
                                    <h6 class="element-title">Advertisement</h6>
                                </div>
                                <div class="flex-row boost-row">
                                    <div class="heavier text-color boost-row__title">
                                        Give your marketing a boost!
                                    </div>
                                    <button class="btn fnb-btn s-outline full border-btn default-size"><i class="fa fa-rocket fa-rotate-180" aria-hidden="true"></i> Advertise with us</button>
                                </div>
                            </div>
                            <!-- advertisement ends-->
                            <div class="apply-btn desk-hide">
                                <button class="btn fnb-btn primary-btn full border-btn">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9 custom-col-9">
                <div class="filter-data">
                    <div class="seller-info bg-card filter-cards">
                        <!-- <div class="seller-info__header filter-cards__header flex-row">
                            <div class="flex-row">
                                <div class="rating-view flex-row p-r-10">
                                    <div class="rating">
                                        <div class="bg"></div>
                                        <div class="value" style="width: 80%;"></div>
                                    </div>
                                </div>
                                <p class="m-b-0 text-lighter lighter published-date"><i>Published on 20 Dec 2016</i></p>
                            </div>
                            <p class="featured text-secondary m-b-0">
                                <i class="flex-row">
                                    <i class="fa fa-flag featured__icon p-r-10" aria-hidden="true"></i>
                                    Featured
                                </i>
                            </p>
                        </div> -->
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
                                    <img src="{{ asset('/img/power-seller.png') }}" class="img-responsive power-seller" width="120">
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
                                    <p class="m-b-0 default-size heavier flex-row"><!-- <i class="fa fa-repeat p-r-5" aria-hidden="true"></i> --><img src="{{ asset('/img/list-updates.png') }}" class="img-responsive update-icon"> Recent updates <i class="fa fa-angle-down desk-hide arrowDown" aria-hidden="true"></i></p>
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
                        <!-- <div class="seller-info__header filter-cards__header flex-row">
                            <div class="flex-row">
                                <div class="rating-view flex-row p-r-10">
                                    <div class="rating">
                                        <div class="bg"></div>
                                        <div class="value" style="width: 80%;"></div>
                                    </div>
                                </div>
                                <p class="m-b-0 text-lighter lighter published-date"><i>Published on 20 Dec 2016</i></p>
                            </div>
                            <p class="featured text-secondary m-b-0">
                                <i class="flex-row">
                                    <i class="fa fa-flag featured__icon p-r-10" aria-hidden="true"></i>
                                    Featured
                                </i>
                            </p>
                        </div> -->
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
                                    <img src="{{ asset('/img/power-seller.png') }}" class="img-responsive power-seller" width="120">
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
                                    <p class="m-b-0 default-size heavier flex-row"><!-- <i class="fa fa-repeat p-r-5" aria-hidden="true"></i> --><img src="{{ asset('/img/list-updates.png') }}" class="img-responsive update-icon"> Recent updates <i class="fa fa-angle-down desk-hide arrowDown" aria-hidden="true"></i></p>
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
                <div class="filter-data m-t-30 send-enquiry-section">
                    <div class="bg-card filter-cards add-card flex-row white-space mobile-hide">
                        <div class="add-card__content">
                            <p class="element-title heavier title flex-row">
                                <img src="{{ asset('/img/business.png') }}" class="img-responsive p-r-10">
                                Find Suppliers at<br> lowest rate
                            </p>
                            <p class="m-b-0 sub-title p-t-10 text-color">
                                To get best deals, send your enquiry now.
                            </p>
                        </div>
                        <div class="add-card__form">
                            <form>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group p-t-10 p-b-10">
                                            <input type="text" class="form-control fnb-input" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group p-t-10 p-b-10">
                                            <input type="email" class="form-control fnb-input" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group p-t-10 p-b-10">
                                            <input type="number" class="form-control fnb-input" placeholder="Number">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group p-t-10 p-b-10">
                                            <select class="form-control fnb-select select-variant text-lighter">
                                                <option>What describes you best</option>
                                                <option>Pune</option>
                                                <option>Delhi</option>
                                                <option>Mumbai</option>
                                                <option>Goa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group p-t-10 p-b-10">
                                            <label class="form-label">Message</label>
                                            <textarea class="form-control fnb-textarea" col="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group p-t-10 p-b-0 m-b-0">
                                            <button class="btn fnb-btn primary-btn full border-btn send-enquiry">Send an Enquiry</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="sticky-bottom  mobile-flex desk-hide">
                        <div class="stick-bottom__text">
                            <p class="m-b-0 element-title text-capitalise bolder">Get best deals in "Meat &amp; poultry"</p>
                        </div>
                        <div class="actions">
                            <button class="btn fnb-btn primary-btn full border-btn send-enquiry">Send an Enquiry</button>
                        </div>
                    </div>
                </div>
                 <div class="filter-data m-t-30">
                    <div class="seller-info bg-card filter-cards">
                        <!-- <div class="seller-info__header filter-cards__header flex-row">
                            <div class="flex-row">
                                <div class="rating-view flex-row p-r-10">
                                    <div class="rating">
                                        <div class="bg"></div>
                                        <div class="value" style="width: 80%;"></div>
                                    </div>
                                </div>
                                <p class="m-b-0 text-lighter lighter published-date"><i>Published on 20 Dec 2016</i></p>
                            </div>
                            <p class="featured text-secondary m-b-0">
                                <i class="flex-row">
                                    <i class="fa fa-flag featured__icon p-r-10" aria-hidden="true"></i>
                                    Featured
                                </i>
                            </p>
                        </div> -->
                        <div class="seller-info__body filter-cards__body flex-row white-space">
                            <div class="body-left flex-cols">
                                <div>
                                   <h3 class="seller-info__title ellipsis" title="Mystical the meat and fish store">Mystical the meat and fish store</h3>
                                    <div class="location p-b-5 flex-row">
                                        <span class="fnb-icons map-icon"></span>
                                        <p class="location__title default-size m-b-0 text-lighter">Gandhi Nagar, Delhi</p>
                                    </div>
                                    <div class="flex-row">
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
                                    <img src="{{ asset('/img/power-seller.png') }}" class="img-responsive power-seller" width="120">
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
                                    <p class="m-b-0 default-size heavier"><!-- <i class="fa fa-repeat p-r-5" aria-hidden="true"></i> --><img src="{{ asset('/img/list-updates.png') }}" class="img-responsive update-icon"> Recent updates</p>
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
                <div class="filter-data m-t-30 m-b-30">
                    <div class="seller-info bg-card filter-cards">
                        <!-- <div class="seller-info__header filter-cards__header flex-row">
                            <div class="flex-row">
                                <div class="rating-view flex-row p-r-10">
                                    <div class="rating">
                                        <div class="bg"></div>
                                        <div class="value" style="width: 80%;"></div>
                                    </div>
                                </div>
                                <p class="m-b-0 text-lighter lighter published-date"><i>Published on 20 Dec 2016</i></p>
                            </div>
                            <p class="featured text-secondary m-b-0">
                                <i class="flex-row">
                                    <i class="fa fa-flag featured__icon p-r-10" aria-hidden="true"></i>
                                    Featured
                                </i>
                            </p>
                        </div> -->
                        <div class="seller-info__body filter-cards__body flex-row white-space">
                            <div class="body-left flex-cols">
                                <div>
                                   <h3 class="seller-info__title ellipsis" title="Empire cold storage &amp; chicken products">Empire cold storage &amp; chicken products</h3>
                                    <div class="location p-b-5 flex-row">
                                        <span class="fnb-icons map-icon"></span>
                                        <p class="location__title default-size m-b-0 text-lighter">Gandhi Nagar, Delhi</p>
                                    </div>
                                    <div class="flex-row">
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
                                    <img src="{{ asset('/img/power-seller.png') }}" class="img-responsive power-seller" width="120">
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
                                    <p class="m-b-0 default-size heavier"><!-- <i class="fa fa-repeat p-r-5" aria-hidden="true"></i> --><img src="{{ asset('/img/list-updates.png') }}" class="img-responsive update-icon"> Recent updates</p>
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
        </div>
        <div class="site-overlay"></div>
    </div>
@endsection
<!-- </body> -->
