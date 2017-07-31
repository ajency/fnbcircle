@extends('layouts.fnbtemplate')
@section('title', 'Add Listing')
@section('css')

@endsection

@section('js')
    <!-- Custom file input -->
    <script type="text/javascript" src="js/jquery.custom-file-input.js"></script>
    <!-- Add listing -->
    <script type="text/javascript" src="js/add-listing.js"></script>
    <!-- custom script -->
    <script type="text/javascript" src="js/custom.js"></script>
     <script src="{{ asset('js/AddListing.js') }}"></script>
@endsection

@section('content')
<!-- content -->
    <div class="preview-header text-color mobile-hide">
        <i class="fa fa-binoculars bino" aria-hidden="true"></i> Do you want to see a preview of your listing? <a href="http://staging.fnbcircle.com/single-view.html" class="secondary-link preview-header__link">Preview</a>
    </div>
    <div class="header-shifter"></div>
    <div class="container">
        <div class="row p-t-30 mobile-flex breadcrums-container mobile-hide">
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
                            <p class="fnb-breadcrums__title">Add a listing</p>
                        </a>
                    </li>
                </ul>
                <!-- Breadcrums ends -->
            </div>
            <div class="col-sm-4 flex-col">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="flex-row page-intro m-t-20">
                    <div>
                        <img src="img/steps.png" class="mobile-hide desk-hide">
                        <img src="img/steps-orange.png">
                    </div>
                    <div class="page-intro__title">
                        You are a few steps away from creating a listing on F&amp;B Circle
                    </div>
                </div>
                <div class="flex-row note-row top-head m-b-15 m-t-15">
                    <h3 class="main-heading m-b-0 m-t-0">Let's get started!</h3>
                    <div class="flex-row">
                        <p class="note-row__text text-medium">
                            <!-- <span class="text-primary">Note:</span> You can add multiple listings on F&amp;BCircle. -->
                            <div class="mobile-hide p-r-10">
                                The current status of your listing is <span class="text-primary bolder status-changer">Draft</span> <i class="fa fa-info-circle text-color m-l-5 draft-status" data-toggle="tooltip" data-placement="top" title="Listing will remain in draft status till submitted for review."></i>
                            </div>
                        </p>
                        <button class="btn fnb-btn outline full border-btn mobile-hide review-submit">Submit for review <i class="fa fa-circle-o-notch fa-spin fa-fw"></i></button>
                    </div>
                </div>
                <div class="white-box gray-border get-started">
                    <!-- <div class="desk-hide mobile-flex ">
                        <select class="form-control fnb-select">
                            <option>
                                6 tips for an effective business listing
                            </option>
                        </select>
                    </div> -->
                    <div class="">
                        <div class="row">
                            <div class="col-sm-3 tips">
                                <img src="img/bulb.png" class="desk-hide">
                                <span class="text-medium">6</span> tips
                                <br class="mobile-hide">for an effective
                                <br class="mobile-hide">business listing
                                <i class="fa fa-chevron-down pull-right desk-hide"></i>
                            </div>
                            <div class="mobile-collapse tips__steps col-sm-9">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <ol>
                                            <li class="flex-row align-top"><span class="p-r-5">1)</span> Fill in all the details and complete your listing</li>
                                            <li class="flex-row align-top"><span class="p-r-5">2)</span> Ensure your contact details are correct</li>
                                            <li class="flex-row align-top"><span class="p-r-5">3)</span> An accurate address is required for local customers</li>
                                        </ol>
                                    </div>
                                    <div class="col-sm-6">
                                        <ol>
                                            <li class="flex-row align-top"><span class="p-r-5">4)</span> Describe your business well, highlight your USPs</li>
                                            <li class="flex-row align-top"><span class="p-r-5">5)</span> Use outlined categories wisely</li>
                                            <li class="flex-row align-top"><span class="p-r-5">6)</span> Photos/brochures drive interest - fact!</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="white-box gray-border m-t-10 m-b-10">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3">
                            <ul class="gs-steps" role="tablist">
                                <li class="active">
                                    <a href="#business-info" class="form-toggle" role="tab" data-toggle="tab">Business Information <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#business-cats" class="form-toggle" role="tab" data-toggle="tab">Business Categories <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#location-hours" class="form-toggle" role="tab" data-toggle="tab">Location &amp; Hours of Operation <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#business-details" class="form-toggle" role="tab" data-toggle="tab">Business Details <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#photos" class="form-toggle" role="tab" data-toggle="tab">Photos &amp; Documents <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#premium" class="form-toggle" role="tab" data-toggle="tab">Go Premium <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                            <div class="view-sample m-t-20 m-b-20">
                                View what a sample business listing would look like once created.
                                <div class="m-t-10">
                                    <img src="img/sample_listing.png" class="img-responsive mobile-hide sample-img">
                                    <a href="img/sample_listing.png" class="desk-hide sample-img">View the sample</a>
                                </div>
                            </div>
                            <div class="why-premium">
                                <div class="text-darker">
                                    <strong>Go PREMIUM!</strong> Read why...
                                </div>
                                <div class="text-lighter m-t-15">
                                    More contacts &amp; enquiries from seekers, indirectly more leads.
                                </div>
                                <div class="text-lighter m-t-15">
                                    Premium listings have priority over non premium as they are displayed first on the list view of listings.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <div class="pos-fixed fly-out slide-bg">
                                <div class="mobile-back desk-hide mobile-flex">
                                    <div class="left mobile-flex">
                                        <i class="fa fa-arrow-left text-primary back-icon" aria-hidden="true"></i>
                                        <p class="element-title heavier m-b-0">Back</p>
                                    </div>
                                </div>
                                <div class="fly-out__content">
                                    <div class="preview-header text-color desk-hide"> Do you want to see a preview of your listing? <a href="http://staging.fnbcircle.com/single-view.html" class="secondary-link preview-header__link">Preview</a>
                                    </div>
                                    <p class="note-row__text--status text-medium desk-hide">
                                        The current status of your listing is <span class="text-primary bolder">Draft</span> <i class="fa fa-info-circle text-color m-l-5" data-toggle="tooltip" data-placement="top" title="Listing will remain in draft status till submitted for review."></i>
                                    </p>
                                    <div class="gs-form tab-content">
                                        <!-- Business Information -->
                                        @yield('form-data')
                                        <!-- Business Information End -->
                                        <!-- Business Categories -->
                                        <!-- @yield('business-categories') -->
                                        <!-- Business Categories End -->
                                        <!-- Business Details -->
                                        <!-- @yield('business-details') -->
                                        <!-- Business Details End-->
                                        <!-- Location & hours -->
                                        <!-- @yield('location') -->
                                        <!-- Location & hours End -->
                                        <!-- Photos -->
                                        <!-- @yield('photos') -->
                                        <!-- Photos End -->
                                        <!-- Go Premium -->
                                        <!-- @yield('premium') -->
                                        <!-- Go Premium End -->
                                        <!-- Submit for review section -->
                                        <div class="m-t-50 c-gap">
                                           <div class="review-note flex-row space-between">
                                                <div class="review-note__text flex-row">
                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                    <p class="review-note__title">If you don't want to further complete/edit the listing, you can submit it for review</p>
                                                </div>
                                               <div class="review-note__submit">
                                                   <a href="#" class="primary-link sub-title">Submit for review</a>
                                               </div>
                                           </div>
                                        </div>
                                        <!-- content navigation -->
                                        <div class="gs-form__footer flex-row m-t-40">
                                            <button class="btn fnb-btn outline no-border gs-prev"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
                                            <button onclick="listingInformation()" class="btn fnb-btn primary-btn full save-btn gs-next">Save &amp; Next</button>
                                            <!-- <button class="btn fnb-btn outline no-border ">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- categories select modal -->
                <!-- Button trigger modal -->
                <!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#category-select">
                  Launch demo modal
                </button> -->
                <!-- Modal -->
                <div class="modal fnb-modal category-modal multilevel-modal fade" id="category-select" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="level-one mobile-hide ">
                                    <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                                <div class="mobile-back flex-row">
                                    <div class="back">
                                        <button class="btn fnb-btn outline border-btn no-border" data-dismiss="modal"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i> Back</button>
                                    </div>
                                    <div class="level-two">
                                        <button class="btn fnb-btn outline border-btn">save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="main-category level-one m-l-30 m-r-30 m-b-30">
                                    <!-- <div class="mobile-hide">
                                        <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                                        <div class="clearfix"></div>
                                    </div> -->
                                    <!-- <div class="desk-hide mobile-back">
                                        <button class="btn fnb-btn outline border-btn no-border" data-dismiss="modal"><i class="fa fa-arrow-left p-r-5" aria-hidden="true"></i> Back</button>
                                    </div> -->
                                    <div class="add-container">
                                        <h5 class="text-medium">Select categories your listing belongs to <span class="text-primary">*</span></h5>
                                        <div class="text-lighter">
                                            One category at a time
                                        </div>
                                    </div>
                                    <ul class="interested-options cat-select flex-row m-t-45">
                                        <li>
                                            <input type="radio" class="radio level-two-toggle" name="categories" data-name="Cereals &amp; Food Grains">
                                            <div class="veg option flex-row">
                                                <span class="fnb-icons cat-icon veg"></span>
                                            </div>
                                            <div class="interested-label">
                                                Cereals &amp; Food Grains
                                            </div>
                                        </li>
                                        <li>
                                            <input type="radio" class="radio level-two-toggle" name="categories" data-name="Meat &amp; Poultry">
                                            <div class="meat option flex-row">
                                                <span class="fnb-icons cat-icon meat"></span>
                                            </div>
                                            <div class="interested-label">
                                                Meat &amp; Poultry
                                            </div>
                                        </li>
                                        <li>
                                            <input type="radio" class="radio level-two-toggle" name="categories" data-name="Juices, Soups &amp; Soft Drinks">
                                            <div class="drinks option flex-row">
                                                <span class="fnb-icons cat-icon drinks"></span>
                                            </div>
                                            <div class="interested-label">
                                                Juices, Soups &amp; Soft Drinks
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="sub-category level-two">
                                    <!-- <div class="mobile-back flex-row m-b-10">
                                        <div class="back">
                                             <button class="btn fnb-btn outline border-btn no-border sub-category-back"><i class="fa fa-arrow-left p-r-5" aria-hidden="true"></i> Back</button>
                                        </div>
                                        <button class="btn fnb-btn outline border-btn">save</button>
                                    </div> -->
                                    <div class="instructions">
                                        <p class="instructions__title bat-color">Please choose the sub categories under "<span class="main-cat-name">Meat &amp; Poultry</span>"</p>
                                        <div class="cat-name flex-row">
                                            <span class="fnb-icons cat-icon meat m-r-15"></span>
                                            <h5 class="cat-title bat-color main-cat-name">Meat &amp; Poultry</h5>
                                        </div>
                                    </div>
                                    <div class="node-select flex-row">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs flex-row mobile-hide" role="tablist">
                                            <li role="presentation" class="active"><a href="#chicken" aria-controls="chicken" role="tab" data-toggle="tab">Chicken</a></li>
                                            <li role="presentation"><a href="#mutton" aria-controls="mutton" role="tab" data-toggle="tab">Mutton</a></li>
                                            <li role="presentation"><a href="#pork" aria-controls="pork" role="tab" data-toggle="tab">Pork</a></li>
                                            <li role="presentation"><a href="#beef" aria-controls="beef" role="tab" data-toggle="tab">Beef</a></li>
                                            <li role="presentation"><a href="#halal" aria-controls="halal" role="tab" data-toggle="tab">Halal meat</a></li>
                                            <li role="presentation"><a href="#rabbit" aria-controls="rabbit" role="tab" data-toggle="tab">Rabbit meat</a></li>
                                            <li role="presentation"><a href="#sheep" aria-controls="sheep" role="tab" data-toggle="tab">Sheep meat</a></li>
                                            <li role="presentation"><a href="#cured" aria-controls="cured" role="tab" data-toggle="tab">Cured meat</a></li>
                                            <li role="presentation"><a href="#knuckle" aria-controls="knuckle" role="tab" data-toggle="tab">Knuckle meat</a></li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <!-- mobile collapse -->
                                            <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#chicken" aria-expanded="false" aria-controls="chicken">
                                                Chicken <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                            <div role="tabpanel" class="tab-pane active collapse" id="chicken">
                                                <ul class="nodes">
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="boneless">
                                                            <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#mutton" aria-expanded="false" aria-controls="mutton">
                                                Mutton <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                            <div role="tabpanel" class="tab-pane collapse" id="mutton">Mutton</div>
                                            <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#pork" aria-expanded="false" aria-controls="pork">
                                                Pork <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                            <div role="tabpanel" class="tab-pane collapse" id="pork">Pork</div>
                                            <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#beef" aria-expanded="false" aria-controls="beef">
                                                Beef <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                            <div role="tabpanel" class="tab-pane collapse" id="beef">Beef</div>
                                            <div role="tabpanel" class="tab-pane" id="halal">Halal</div>
                                            <div role="tabpanel" class="tab-pane" id="rabbit">Rabbit</div>
                                            <div role="tabpanel" class="tab-pane" id="sheep">Sheep</div>
                                            <div role="tabpanel" class="tab-pane" id="cured">Cured</div>
                                            <div role="tabpanel" class="tab-pane" id="knuckle">Knuckle</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer mobile-hide">
                                <div class="sub-category hidden">
                                    <button class="btn fnb-btn outline full border-btn">save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- listing present -->
                <div class="modal fnb-modal duplicate-listing fade" id="duplicate-listing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            </div>
                            <div class="modal-body">
                                <div class="listing-details text-center">
                                    <img src="img/listing-search.png" class="img-responsive center-block">
                                    <h5 class="listing-details__title">Looks like the listing is already present on F&amp;BCircle.</h5>
                                    <p class="sub-title text-lighter lighter listing-details__caption">Please confirm if the following listing(s) belongs to you.
                                        <br> You can either Claim the listing or Delete it.</p>
                                </div>
                                <div class="list-entries">
                                    <div class="list-row flex-row">
                                        <div class="left">
                                            <h5 class="text-medium text-capitalise list-title">Mystical the meat and fish store</h5>
                                            <p class="sub-title text-color">
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
                                    <hr>
                                    <div class="list-row flex-row">
                                        <div class="left">
                                            <h5 class="text-medium text-capitalise list-title">Mystical the meat and fish store</h5>
                                            <p class="sub-title text-color">
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
                <!-- Areas of operation modal -->
                <div class="modal fnb-modal area-modal multilevel-modal fade" id="area-select" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header p-l-0 p-r-0 p-t-0 p-b-0">
                                <!-- <div class="level-one mobile-hide ">
                                    <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                                </div> -->
                                <div class="mobile-back">
                                    <div class="back pull-left">
                                        <button class="btn fnb-btn outline border-btn no-border" data-dismiss="modal"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i> Back</button>
                                    </div>
                                    <div class="pull-right">
                                        <button class="btn fnb-btn outline border-btn">save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="">
                                    <div class="instructions">
                                        <h6 class="instructions__title bat-color">Select your area(s) of operation.</h6>
                                    </div>
                                    <div class="node-select flex-row">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs flex-row mobile-hide" role="tablist">
                                            <li role="presentation" class="active"><a href="#mumbai" aria-controls="mumbai" role="tab" data-toggle="tab">Mumbai</a></li>
                                            <li role="presentation"><a href="#delhi" aria-controls="delhi" role="tab" data-toggle="tab">Delhi</a></li>
                                            <li role="presentation"><a href="#bangalore" aria-controls="bangalore" role="tab" data-toggle="tab">Bangalore</a></li>
                                            <li role="presentation"><a href="#pune" aria-controls="pune" role="tab" data-toggle="tab">Pune</a></li>
                                            <li role="presentation"><a href="#hyderabad" aria-controls="hyderabad" role="tab" data-toggle="tab">Hyderabad</a></li>
                                            <li role="presentation"><a href="#kolkata" aria-controls="kolkata" role="tab" data-toggle="tab">Kolkata</a></li>
                                            <li role="presentation"><a href="#chennai" aria-controls="chennai" role="tab" data-toggle="tab">Chennai</a></li>
                                            <li role="presentation"><a href="#jaipur" aria-controls="jaipur" role="tab" data-toggle="tab">Jaipur</a></li>
                                            <li role="presentation"><a href="#lucknow" aria-controls="lucknow" role="tab" data-toggle="tab">Lucknow</a></li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <!-- mobile collapse -->
                                            <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#mumbai" aria-expanded="false" aria-controls="mumbai">
                                                Mumbai <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                            <div role="tabpanel" class="tab-pane active collapse" id="mumbai">
                                                <div class="highlight-color p-t-10 p-l-10 p-r-5 p-b-10 m-b-20 select-all operate-all">
                                                    <label class="flex-row heavier">
                                                        <input type="checkbox" class="checkbox all-cities" id="throughout_city"> I operate throughout the city
                                                    </label>
                                                </div>
                                                <ul class="nodes">
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row">
                                                            <input type="checkbox" class="checkbox" for="adarsh">
                                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#delhi" aria-expanded="false" aria-controls="delhi">
                                                Delhi <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                            <div role="tabpanel" class="tab-pane collapse" id="delhi">Delhi</div>
                                            <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#bangalore" aria-expanded="false" aria-controls="bangalore">
                                                Bangalore <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                            <div role="tabpanel" class="tab-pane collapse" id="bangalore">Bangalore</div>
                                            <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#pune" aria-expanded="false" aria-controls="pune">
                                                Pune <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </div>
                                            <div role="tabpanel" class="tab-pane collapse" id="pune">Pune</div>
                                            <div role="tabpanel" class="tab-pane" id="hyderabad">Hyderabad</div>
                                            <div role="tabpanel" class="tab-pane" id="kolkata">Kolkata</div>
                                            <div role="tabpanel" class="tab-pane" id="chennai">Chennai</div>
                                            <div role="tabpanel" class="tab-pane" id="jaipur">Jaipur</div>
                                            <div role="tabpanel" class="tab-pane" id="lucknow">Lucknow</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer mobile-hide">
                                <div class="sub-category hidden">
                                    <button class="btn fnb-btn outline full border-btn">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Areas of operation modal -->
            </div>
        </div>
        <div class="site-overlay"></div>
    </div>
    <!-- content ends -->
@endsection
