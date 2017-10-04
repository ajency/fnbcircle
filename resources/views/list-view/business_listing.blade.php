@extends('layouts.app')

@section('title')
List View
@endsection

@section('css')
    <!-- FlexDatalist -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.flexdatalist.min.css') }}">
@endsection

@section('js')
    <!-- Handle bars  -->
    <script type="text/javascript" src="{{ asset('/node_modules/handlebars/dist/handlebars.min.js') }}"></script>
    <!-- FlexDatalist -->
    <script type="text/javascript" src="{{ asset('js/flex-datalist/jquery.flexdatalist.min.js') }}"></script>

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
                                        <input type="text" value="" class="form-control fnb-select flexdatalist" name="city" placeholder="State">
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
                                                <input type="text" name="category_search" class="form-control fnb-input flexdatalist" placeholder="Start typing to search category...">
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="business">
                                            <div class="business search-boxes flex-row">
                                                <i class="fa fa-search p-r-5 icons" aria-hidden="true"></i>
                                                <input type="text" name="business_search" class="form-control fnb-input flexdatalist" placeholder="Search for a specific business">
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
                    <p class="sub-title text-color text-right search-actions__title">Showing <label id="listing_filter_count"></label> Chicken in Delhi</p>
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
                            <div id="listing_filter_view">
                                
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

            <!-- <script id="listing_card_template" type="text/x-handlebars-template">
                <?php //include resource_path() . '/views/handlebars_templates/listing_card.html'; ?>
            </script> -->
            <div class="col-sm-9 custom-col-9">
                <div id="listing_card_view">
                    
                    
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
            </div>
        </div>

        <div class="site-overlay"></div>
    </div>
@endsection
<!-- </body> -->
