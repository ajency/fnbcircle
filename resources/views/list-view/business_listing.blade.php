@extends('layouts.app')

@section('title')
List View
@endsection

@section('css')
    <!-- FlexDatalist -->
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/jquery-flexdatalist/jquery.flexdatalist.min.css') }}">
@endsection

@section('js')
    <!-- Handle bars  -->
    <script type="text/javascript" src="{{ asset('/bower_components/handlebars/handlebars.min.js') }}"></script>
    <!-- FlexDatalist -->
    <script type="text/javascript" src="{{ asset('bower_components/jquery-flexdatalist/jquery.flexdatalist.min.js') }}"></script>

    <!-- Custom js codes -->
    <script type="text/javascript" src="{{ asset('/js/listing_list_view.js') }}"></script>
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
                                        <input type="hidden" value="" class="form-control fnb-select hidden" name="area_hidden" id="area"/>
                                        <input type="text" value="{{ $city }}" class="form-control fnb-input" name="city" placeholder="State">
                                        <!-- <input type="text" value="" class="form-control fnb-select flexdatalist" name="city" placeholder="State" data-min-length='0' list='states'> 

                                        <datalist id="states">
                                        </datalist> -->
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
                                                <input type="text" name="category_search" id="category_search" class="form-control fnb-input" placeholder="Start typing to search category...">
                                                <a href="#" class="desk-hide" id="clear_search">Clear</a>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="business">
                                            <div class="business search-boxes flex-row">
                                                <i class="fa fa-search p-r-5 icons" aria-hidden="true"></i>
                                                <input type="text" name="business_search" class="form-control fnb-input" placeholder="Search for a specific business">
                                                <a href="#" id="clear_search" class="desk-hide">Clear</a>
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
    <div class="container listings-page">
        <div class="row m-t-30 p-t-30 m-b-30 mobile-flex breadcrums-container mobile-hide">
            <div class="col-sm-8 flex-col">
                <!-- Breadcrums -->
                <ul class="fnb-breadcrums flex-row">
                    <li class="fnb-breadcrums__section">
                        <a href="{{url('/')}}" title="Home">
                            <i class="fa fa-home home-icon" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="fnb-breadcrums__section">
                        <a href="#">
                            <p class="fnb-breadcrums__title">/</p>
                        </a>
                    </li>
                    <li class="fnb-breadcrums__section">
                        <a href="" title="{{ucfirst($city)}}">
                            <p class="fnb-breadcrums__title state_label"> {{ ucfirst($city) }}</p>
                        </a>
                    </li>
                    <li class="fnb-breadcrums__section">
                        <a href="#">
                            <p class="fnb-breadcrums__title">/</p>
                        </a>
                    </li>
                    <li class="fnb-breadcrums__section">
                        <p class="fnb-breadcrums__title main-name category_label">All categories</p>
                        <!-- <a href="">
                            <p class="fnb-breadcrums__title main-name category_label">Meat &amp; Poultry</p>
                        </a> -->
                    </li>
                    <!-- <li class="fnb-breadcrums__section">
                        <a href="">
                            <p class="fnb-breadcrums__title">/</p>
                        </a>
                    </li>
                    <li class="fnb-breadcrums__section">
                        <a href="">
                            <p class="fnb-breadcrums__title main-name">Chicken</p>
                        </a>
                    </li> -->
                </ul>
                <!-- Breadcrums ends -->
            </div>
            <div class="col-sm-4 flex-col">
            </div>
        </div>
        <!-- section headings -->
        <div class="row addShow">
            <div class="col-sm-6 mobile-hide">
                <h5 class="m-t-0"><span class="category_label"> Meat &amp; Poultry </span> Business Listings <span class="text-lighter">in</span> <span class="state_label">{{ ucfirst($city) }}</span></h5>
            </div>
            <div class="col-sm-6">
                <div class="search-actions mobile-flex">
                    <p class="sub-title text-color text-right search-actions__title mobile-hide">Showing <label id="listing_filter_count"></label> <span class="category_label">Chicken</span> Business Listings in <span class="state_label">{{ ucfirst($city) }}</span></p>
                    <p class="sub-title text-color text-right search-actions__title desk-hide"><label id="listing_filter_count"></label> <span class="category_label">Chicken</span> Business Listings in <span class="state_label">{{ ucfirst($city) }}</span></p>
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
                            <a href="#" class="text-primary heavier element-title" id="clear_all_filters">Clear All</a>
                        </div>
                    </div>
                    <div class="fly-out__content">
                        <div class="filter-sidebar bg-card">
                            <div id="listing_filter_view" class="listing_filter_view">
                                {!! $filter_view_html !!}
                            </div>
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
                                <div class="boost-row text-center">
                                    <div class="heavier text-color boost-row__title m-b-5">
                                        Give your marketing a boost!
                                    </div>
                                    <button class="btn fnb-btn s-outline full border-btn default-size"><i class="fa fa-rocket fa-rotate-180" aria-hidden="true"></i> Advertise with us</button>
                                </div>
                            </div>
                            <!-- advertisement ends-->
                            <div class="apply-btn desk-hide">
                                <button class="btn fnb-btn primary-btn full border-btn" id="apply_listing_filter">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <script id="listing_card_template" type="text/x-handlebars-template">
                <?php //include resource_path() . '/views/handlebars_templates/listing_card.html'; ?>
            </script> -->
            <div class="col-sm-9 custom-col-9">
                <div id="listing_card_view">
                   <div class="loader-section">
                        <div class="site-loader section-loader">
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
                <div id="pagination">
                    {!! $paginate !!}
                </div>
            </div>
        </div>
        <br><br>
       <!--  <button type="button" id="backToTop" title="Go to top" class="btn fnb-btn primary-btn full border-btn" style="display: none; position: fixed; bottom: 10px; right: 10px;"><i class="fa fa-angle-up p-r-5 arrow" aria-hidden="true"></i> Back to Top</button> -->

        <div class="site-overlay"></div>
    </div>

@endsection
<!-- </body> -->
