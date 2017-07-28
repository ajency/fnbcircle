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
                                        <div class="business-info tab-pane fade in active" id="business-info">
                                            <h5 class="no-m-t">Business Information</h5>
                                            <div class="m-t-30 c-gap">
                                                <label>Tell us the name of your business <span class="text-primary">*</span></label>
                                                <input type="text" name="listing_title" class="form-control fnb-input" placeholder="">
                                                <div class="text-lighter m-t-5">
                                                    This will be the display name of your listing.
                                                </div>
                                            </div>
                                            <div class="m-t-50 c-gap">
                                                <label>Who are you? <span class="text-primary">*</span></label>
                                                <ul class="business-type flex-row m-t-15">
                                                    <li>
                                                        <input value="11" type="radio" class="radio" name="business_type">
                                                        <div class="wholesaler option flex-row">
                                                            <span class="fnb-icons business-icon wholesaler"></span>
                                                            <i class="fa fa-check"></i>
                                                        </div>
                                                        <div class="business-label">
                                                            Wholesaler
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <input value="12" type="radio" class="radio" name="business_type">
                                                        <div class="retailer option flex-row">
                                                            <span class="fnb-icons business-icon retailer"></span>
                                                            <i class="fa fa-check"></i>
                                                        </div>
                                                        <div class="business-label">
                                                            Retailer
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <input value="13" type="radio" class="radio" name="business_type">
                                                        <div class="manufacturer option flex-row">
                                                            <span class="fnb-icons business-icon manufacturer"></span>
                                                            <i class="fa fa-check"></i>
                                                        </div>
                                                        <div class="business-label">
                                                            Manufacturer
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="text-lighter">
                                                    The right business type will get you the right enquiries. A listing can be only of one type.
                                                </div>
                                            </div>
                                            <div class="m-t-50 flex-row c-gap">
                                                <span class="fnb-icons contact mobile-hide"></span>
                                                <!-- <img src="img/enquiry.png" class="mobile-hide"> -->
                                                <div class="m-l-10 no-m-l">
                                                    <label>Contact Details</label>
                                                    <div class="text-lighter">
                                                        Seekers would like to contact you or send enquiries. Please share your contact details below. We have pre-populated your email and phone number from your profile details.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-t-20 business-email business-contact">
                                                <label>Enter your business email address <span class="text-primary">*</span></label>
                                                <div class="row p-t-10 p-b-10 no-m-b">
                                                    <div class="col-sm-5">
                                                        <input type="email" class="form-control fnb-input p-l-5" value="quershi@gmail.com" readonly="">
                                                    </div>
                                                    <div class="col-sm-3 col-xs-4">
                                                        <div class="verified flex-row">
                                                            <span class="fnb-icons verified-icon"></span>
                                                            <p class="c-title">Verified</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-xs-8">
                                                        <div class="verified-toggle flex-row">
                                                            <div class="toggle m-l-10 m-r-10">
                                                                <input name="primary_email" type="checkbox" class="toggle__check" checked="true">
                                                                <b class="switch"></b>
                                                                <b class="track"></b>
                                                            </div>
                                                            <p class="m-b-0 text-color toggle-state">Visible on the listing</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row p-t-10 p-b-10 no-m-b contact-group hidden">
                                                    <div class="col-sm-5">
                                                        <input name="email_IDs" class="hidden" >
                                                        <input name=emails type="email" class="form-control fnb-input p-l-5" value="">
                                                    </div>
                                                    <div class="col-sm-3 col-xs-4">
                                                        <div class="verified flex-row">
                                                            <a href="#" class="dark-link">Verify now</a>
                                                            <input type=checkbox name=verified_emails class=hidden>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-xs-8">
                                                        <div class="verified-toggle flex-row">
                                                            <div class="toggle m-l-10 m-r-10">
                                                                <input name=visible_emails type="checkbox" class="toggle__check">
                                                                <b class="switch"></b>
                                                                <b class="track"></b>
                                                            </div>
                                                            <p class="m-b-0 text-color toggle-state">Not visible on the listing</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="#" class="dark-link text-medium add-another">+ Add another email</a>
                                            </div>
                                            <div class="m-t-40 business-phone business-contact">
                                                <label>Enter your business phone number <span class="text-primary">*</span></label>
                                                <div class="row p-t-10 p-b-10">
                                                    <div class="col-sm-5">
                                                        <input type="tel" class="form-control fnb-input p-l-5" value="+91 9344567888">
                                                    </div>
                                                    <div class="col-sm-3 col-xs-4">
                                                        <div class="verified flex-row">
                                                            <!-- <span class="fnb-icons verified-icon"></span>
                                                            <p class="c-title">Verified</p> -->
                                                            <a href="#" class="dark-link">Verify now</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-xs-8">
                                                        <div class="verified-toggle no-m-t flex-row">
                                                            <div class="toggle m-l-10 m-r-10">
                                                                <input type="checkbox" class="toggle__check">
                                                                <b class="switch"></b>
                                                                <b class="track"></b>
                                                            </div>
                                                            <p class="m-b-0 text-color toggle-state">Not visible on the listing</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row p-t-10 p-b-10 no-m-b contact-group hidden">
                                                    <div class="col-sm-5">
                                                        <input type="tel" class="form-control fnb-input p-l-5" value="">
                                                    </div>
                                                    <div class="col-sm-3 col-xs-4">
                                                        <div class="verified flex-row">
                                                            <a href="#" class="dark-link">Verify now</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-xs-8">
                                                        <div class="verified-toggle flex-row">
                                                            <div class="toggle m-l-10 m-r-10">
                                                                <input type="checkbox" class="toggle__check">
                                                                <b class="switch"></b>
                                                                <b class="track"></b>
                                                            </div>
                                                            <p class="m-b-0 text-color toggle-state">Not visible on the listing</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="#" class="dark-link text-medium add-another">+ Add another phone number</a>
                                            </div>
                                        </div>
                                        <!-- Business Information End -->
                                        <!-- Business Categories -->
                                        <div class="business-cats tab-pane fade" id="business-cats">
                                            <h5 class="no-m-t">Business Categories</h5>
                                            <div class="m-t-30 c-gap">
                                                <label>List of all the categories for your listing</label>
                                                <div class="single-category gray-border">
                                                    <div class="row flex-row categoryContainer">
                                                        <div class="col-sm-4 flex-row">
                                                            <span class="fnb-icons cat-icon meat"></span>
                                                            <div class="branch-row">
                                                                <div class="cat-label">Meat &amp; Poultry</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <strong class="branch">Mutton</strong>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <ul class="fnb-cat small flex-row">
                                                                <li><span class="fnb-cat__title">Al Kabeer <span class="fa fa-times remove"></span></span>
                                                                </li>
                                                                <li><span class="fnb-cat__title">Pandiyan <span class="fa fa-times remove"></span></span>
                                                                </li>
                                                                <li><span class="fnb-cat__title">Ezzy <span class="fa fa-times remove"></span></span>
                                                                </li>
                                                                <li><span class="fnb-cat__title">Royco <span class="fa fa-times remove"></span></span>
                                                                </li>
                                                                <li><span class="fnb-cat__title">Venkys <span class="fa fa-times remove"></span></span>
                                                                </li>
                                                                <li class="more-show desk-hide"><span class="fnb-cat__title text-secondary">+10 more</span></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="delete-cat">
                                                        <span class="fa fa-times remove"></span>
                                                    </div>
                                                </div>
                                                <div class="m-t-20">
                                                    <a href="#category-select" data-toggle="modal" data-target="#category-select" class="dark-link heavier">+ Add/Edit more categories</a>
                                                </div>
                                            </div>
                                            <div class="m-t-50 c-gap">
                                                <label class="required">Core categories of your listing</label>
                                                <div class="text-lighter m-t-5">
                                                    Note: Core categories will be displayed prominently on the listing. Maximum 10 core categories allowed
                                                    <br> Please select your core categories from the following categories.
                                                </div>
                                                <div class="m-t-20">
                                                    <!-- <input type="text" class="form-control fnb-input flexdatalist" placeholder="+ Add more core categories" multiple="multiple" data-min-length="0" value="Al Kabeer, Pandiyan, Ezzy, Royco, Venkys" data-selection-required="1" list="core_categories">
                                                    <datalist id="core_categories">
                                                        <option value="Al Kabeer">Al Kabeer</option>
                                                        <option value="Pandiyan">Pandiyan</option>
                                                        <option value="Ezzy">Ezzy</option>
                                                        <option value="Royco">Royco</option>
                                                    </datalist> -->
                                                    <ul class="fnb-cat small core-selector flex-row">
                                                        <li><input type="checkbox" class="checkbox core-cat-select" id="cat-label" checked=""><label class="core-selector__label m-b-0" for="cat-label"><span class="fnb-cat__title text-medium">Al Kabeer </span></label></span>
                                                        </li>
                                                        <li><input type="checkbox" class="checkbox core-cat-select" id="cat-label-2"><label class="core-selector__label m-b-0" for="cat-label-2"><span class="fnb-cat__title text-medium">Pandiyan </span></label></span>
                                                        </li>
                                                        <li><input type="checkbox" class="checkbox core-cat-select" id="cat-label-3"><label class="core-selector__label m-b-0" for="cat-label-3"><span class="fnb-cat__title text-medium">Ezzy </span></label></span>
                                                        </li>
                                                        <li><input type="checkbox" class="checkbox core-cat-select" id="cat-label-4"><label class="core-selector__label m-b-0" for="cat-label-4"><span class="fnb-cat__title text-medium">Royco </span></label></span>
                                                        </li>
                                                        <li><input type="checkbox" class="checkbox core-cat-select" id="cat-label-5"><label class="core-selector__label m-b-0" for="cat-label-5"><span class="fnb-cat__title text-medium">Venkys </span></label></span>
                                                        </li>
                                                        <!--
                                                        <li class="more-show desk-hide"><span class="fnb-cat__title text-secondary">+10 more</span></li> -->
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="m-t-40 c-gap">
                                                <label>List some brands that you deal with</label>
                                                <!-- <div class="text-lighter m-t-5">
                                                    Ex: Albertsons, America's Choice, Bashas
                                                </div> -->
                                                <div class="m-t-5">
                                                    <input type="text" class="form-control fnb-input" placeholder="+ Add brands you deal with">
                                                </div>
                                            </div>
                                            <!-- <div class="m-t-30 add-container c-gap">
                                                <label>Select categories your listing belongs to <span class="text-primary">*</span></label>
                                                <div class="text-lighter m-t-5">
                                                    One category at a time
                                                </div>
                                            </div>
                                            <ul class="interested-options cat-select flex-row m-t-30">
                                                <li>
                                                    <input type="radio" class="radio" name="interests">
                                                    <div class="veg option flex-row">
                                                        <span class="fnb-icons cat-icon veg"></span>
                                                    </div>
                                                    <div class="interested-label">
                                                        Cereals &amp; Food Grains
                                                    </div>
                                                </li>
                                                <li>
                                                    <input type="radio" class="radio" name="interests" checked>
                                                    <div class="meat option flex-row">
                                                        <span class="fnb-icons cat-icon meat"></span>
                                                    </div>
                                                    <div class="interested-label">
                                                        Meat &amp; Poultry
                                                    </div>
                                                </li>
                                                <li>
                                                    <input type="radio" class="radio" name="interests" checked>
                                                    <div class="drinks option flex-row">
                                                        <span class="fnb-icons cat-icon drinks"></span>
                                                    </div>
                                                    <div class="interested-label">
                                                        Juices, Soups &amp; Soft Drinks
                                                    </div>
                                                </li>
                                            </ul> -->

                                        </div>
                                        <!-- Business Categories End -->
                                        <!-- Business Details -->
                                        <div class="business-details tab-pane fade" id="business-details">
                                            <h5 class="no-m-t">Business Details</h5>
                                            <div class="m-t-30 c-gap">
                                                <label>Give us some more details about your listing</label>
                                                <textarea type="text" class="form-control fnb-textarea no-m-t" placeholder="Describe your business here"></textarea>
                                            </div>
                                            <div class="m-t-30 c-gap">
                                                <label>What are the highlights of your business?</label>
                                                <div class="text-lighter">
                                                    Tell your customer about yourself and what makes your business unique
                                                </div>
                                                <div class="input-group highlight-input-group">
                                                    <input type="text" class="form-control fnb-input highlight-input" placeholder="">
                                                    <span class="input-group-btn">
                                                        <button class="btn fnb-btn outline no-border add-highlight" type="button">
                                                            <i class="fa fa-plus-circle"></i>
                                                        </button>
                                                        <button class="btn fnb-btn outline no-border delete-highlight hidden" type="button">
                                                            <small><i class="fa fa-times"></i></small>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="m-t-30 c-gap">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>When was your business established?</label>
                                                        <input type="text" class="form-control fnb-input" placeholder="Eg: 1988">
                                                    </div>
                                                    <div class="col-sm-6 c-gap">
                                                        <label>Do you have a business website?</label>
                                                        <input type="text" class="form-control fnb-input" placeholder="http://">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-t-30 c-gap">
                                                <label>Payment modes accepted by you:</label>
                                                <div class="text-lighter">
                                                    Select from the list below or add your own mode
                                                </div>
                                                <div class="highlight-color p-t-10 p-l-10 p-r-5 p-b-10 m-t-10 select-all">
                                                    <label class="flex-row heavier">
                                                        <input type="checkbox" class="checkbox" id="selectall"> Select All
                                                    </label>
                                                </div>
                                                <ul class="flex-row payment-modes">
                                                    <li>
                                                        <label class="flex-row text-medium">
                                                            <input type="checkbox" class="checkbox" id="visa"> Visa cards
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row text-medium">
                                                            <input type="checkbox" class="checkbox" id="debit"> Debit Card
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row text-medium">
                                                            <input type="checkbox" class="checkbox" id="money_order"> Money Order
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row text-medium">
                                                            <input type="checkbox" class="checkbox" id="cheque"> Cheque
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row text-medium">
                                                            <input type="checkbox" class="checkbox" id="credit"> Credit Card
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row text-medium">
                                                            <input type="checkbox" class="checkbox" id="travelers"> Travelers Cheque
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row text-medium">
                                                            <input type="checkbox" class="checkbox" id="cash"> Cash
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row text-medium">
                                                            <input type="checkbox" class="checkbox" id="master"> Master Card
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="flex-row text-medium">
                                                            <input type="checkbox" class="checkbox" id="diners"> Diner's Club
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="m-t-20 c-gap">
                                                <input type="text" class="form-control fnb-input" placeholder="+ Add modes of payment &amp; press enter">
                                            </div>
                                        </div>
                                        <!-- Business Details End-->
                                        <!-- Location & hours -->
                                        <div class="location-hours tab-pane fade" id="location-hours">
                                            <h5 class="no-m-t">Location &amp; Hours of Operation</h5>
                                            <div class="m-t-30 c-gap">
                                                <label>Please provide the google map address for your business</label>
                                                <div class="text-lighter">
                                                    Note: You can drag the pin on the map to point the address
                                                </div>
                                            </div>
                                            <div class="m-t-20 c-gap">
                                                <input type="text" class="form-control fnb-input" placeholder="Ex: Shop no 4, Aarey Milk Colony, Mumbai">
                                                <div class="m-t-10">
                                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15380.091383021922!2d73.81245283848914!3d15.483203277923609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bbfc0a93361ccd9%3A0xdd98120b24e5be61!2sPanjim%2C+Goa!5e0!3m2!1sen!2sin!4v1498804405360" width="600" height="250" frameborder="0" style="border:0;width:100%;" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                            <div class="m-t-30 c-gap">
                                                <label>What is the address that you want to be displayed to the users?</label>
                                                <label class="dis-block text-medium baseline">
                                                    <input type="checkbox" class="checkbox remove-addr" id=""> Is the display address same as the map address?
                                                    <input type="text" class="another-address form-control fnb-input m-t-10" placeholder="Ex: Shop no 4, Aarey Milk Colony, Mumbai">
                                                </label>
                                            </div>
                                            <hr class="m-t-50 m-b-50 separate">
                                            <div class="m-t-20 c-gap">
                                                <label>Mention the area(s) where you provide your products/services.</label>
                                                <div class="single-area gray-border m-t-10 m-b-20">
                                                    <div class="row flex-row areaContainer">
                                                        <div class="col-sm-3">
                                                            <strong class="branch">Delhi</strong>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <ul class="fnb-cat small flex-row">
                                                                <li><span class="fnb-cat__title">Adarsh nagar <span class="fa fa-times remove"></span></span>
                                                                </li>
                                                                <li><span class="fnb-cat__title">Babarpur <span class="fa fa-times remove"></span></span>
                                                                </li>
                                                                <li><span class="fnb-cat__title">Badli <span class="fa fa-times remove"></span></span>
                                                                </li>
                                                                <li><span class="fnb-cat__title">Dwarka <span class="fa fa-times remove"></span></span>
                                                                </li>
                                                                <li><span class="fnb-cat__title">Chandni Chowk <span class="fa fa-times remove"></span></span>
                                                                </li>
                                                                <li class="more-show desk-hide"><span class="fnb-cat__title text-secondary">+10 more</span></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="delete-cat">
                                                        <span class="fa fa-times remove"></span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a href="#area-select" data-target="#area-select" data-toggle="modal" class="text-secondary text-decor heavier">+ Add / Edit area(s)</a>
                                                </div>
                                            </div>
                                            <div class="m-t-40 c-gap operation-hours">
                                                <label>Enter the hours of operation for your business</label>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="flex-row text-medium m-t-5">
                                                            <input type="radio" class="fnb-radio" name="hours" id="display_hours"> Display hours of operation
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="flex-row text-medium m-t-5">
                                                            <input type="radio" class="fnb-radio" name="hours" id="dont_display_hours"> Don't display hours of operation
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-t-40 c-gap">
                                                <div class="flex-row c-gap m-t-10">
                                                    <div class="flex-row hours-section open-1">
                                                        <span class="hours_day heavier">Monday</span>
                                                        <select class="fnb-select border-bottom form-control text-lighter">
                                                            <option>Open 24 hours</option>
                                                            <option>12 AM</option>
                                                            <option>12.30 AM</option>
                                                            <option>1 AM</option>
                                                            <option>1.30 AM</option>
                                                        </select>
                                                    </div>
                                                    <span class="p-r-30 no-padding">To</span>
                                                    <div class="flex-row hours-section open-2">
                                                        <select class="fnb-select border-bottom form-control text-lighter">
                                                            <option>Open 24 hours</option>
                                                            <option>12 AM</option>
                                                            <option>12.30 AM</option>
                                                            <option>1 AM</option>
                                                            <option>1.30 AM</option>
                                                        </select>
                                                        <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                                                            <input type="checkbox" class="checkbox" id="closed"> Closed
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="flex-row c-gap m-t-10">
                                                    <div class="flex-row hours-section open-1">
                                                        <span class="hours_day heavier">Tuesday</span>
                                                        <select class="fnb-select border-bottom form-control text-lighter">
                                                            <option>Open 24 hours</option>
                                                            <option>12 AM</option>
                                                            <option>12.30 AM</option>
                                                            <option>1 AM</option>
                                                            <option>1.30 AM</option>
                                                        </select>
                                                    </div>
                                                    <span class="p-r-30 no-padding">To</span>
                                                    <div class="flex-row hours-section open-2">
                                                        <select class="fnb-select border-bottom form-control text-lighter">
                                                            <option>Open 24 hours</option>
                                                            <option>12 AM</option>
                                                            <option>12.30 AM</option>
                                                            <option>1 AM</option>
                                                            <option>1.30 AM</option>
                                                        </select>
                                                        <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                                                            <input type="checkbox" class="checkbox" id="closed"> Closed
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="flex-row c-gap m-t-10">
                                                    <div class="flex-row hours-section open-1">
                                                        <span class="hours_day heavier">Wednesday</span>
                                                        <select class="fnb-select border-bottom form-control text-lighter">
                                                            <option>Open 24 hours</option>
                                                            <option>12 AM</option>
                                                            <option>12.30 AM</option>
                                                            <option>1 AM</option>
                                                            <option>1.30 AM</option>
                                                        </select>
                                                    </div>
                                                    <span class="p-r-30 no-padding">To</span>
                                                    <div class="flex-row hours-section open-2">
                                                        <select class="fnb-select border-bottom form-control text-lighter">
                                                            <option>Open 24 hours</option>
                                                            <option>12 AM</option>
                                                            <option>12.30 AM</option>
                                                            <option>1 AM</option>
                                                            <option>1.30 AM</option>
                                                        </select>
                                                        <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                                                            <input type="checkbox" class="checkbox" id="closed"> Closed
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="flex-row c-gap m-t-10">
                                                    <div class="flex-row hours-section open-1">
                                                        <span class="hours_day heavier">Thursday</span>
                                                        <select class="fnb-select border-bottom form-control text-lighter">
                                                            <option>Open 24 hours</option>
                                                            <option>12 AM</option>
                                                            <option>12.30 AM</option>
                                                            <option>1 AM</option>
                                                            <option>1.30 AM</option>
                                                        </select>
                                                    </div>
                                                    <span class="p-r-30 no-padding">To</span>
                                                    <div class="flex-row hours-section open-2">
                                                        <select class="fnb-select border-bottom form-control text-lighter">
                                                            <option>Open 24 hours</option>
                                                            <option>12 AM</option>
                                                            <option>12.30 AM</option>
                                                            <option>1 AM</option>
                                                            <option>1.30 AM</option>
                                                        </select>
                                                        <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                                                            <input type="checkbox" class="checkbox" id="closed"> Closed
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="flex-row c-gap m-t-10">
                                                    <div class="flex-row hours-section open-1">
                                                        <span class="hours_day heavier">Friday</span>
                                                        <select class="fnb-select border-bottom form-control text-lighter">
                                                            <option>Open 24 hours</option>
                                                            <option>12 AM</option>
                                                            <option>12.30 AM</option>
                                                            <option>1 AM</option>
                                                            <option>1.30 AM</option>
                                                        </select>
                                                    </div>
                                                    <span class="p-r-30 no-padding">To</span>
                                                    <div class="flex-row hours-section open-2">
                                                        <select class="fnb-select border-bottom form-control text-lighter">
                                                            <option>Open 24 hours</option>
                                                            <option>12 AM</option>
                                                            <option>12.30 AM</option>
                                                            <option>1 AM</option>
                                                            <option>1.30 AM</option>
                                                        </select>
                                                        <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                                                            <input type="checkbox" class="checkbox" id="closed"> Closed
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="flex-row c-gap m-t-10">
                                                    <div class="flex-row hours-section open-1">
                                                        <span class="hours_day heavier">Saturday</span>
                                                        <select class="fnb-select border-bottom form-control text-lighter">
                                                            <option>Open 24 hours</option>
                                                            <option>12 AM</option>
                                                            <option>12.30 AM</option>
                                                            <option>1 AM</option>
                                                            <option>1.30 AM</option>
                                                        </select>
                                                    </div>
                                                    <span class="p-r-30 no-padding">To</span>
                                                    <div class="flex-row hours-section open-2">
                                                        <select class="fnb-select border-bottom form-control text-lighter">
                                                            <option>Open 24 hours</option>
                                                            <option>12 AM</option>
                                                            <option>12.30 AM</option>
                                                            <option>1 AM</option>
                                                            <option>1.30 AM</option>
                                                        </select>
                                                        <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                                                            <input type="checkbox" class="checkbox" id="closed"> Closed
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="flex-row c-gap m-t-10">
                                                    <div class="flex-row hours-section open-1">
                                                        <span class="hours_day heavier">Sunday</span>
                                                        <select class="fnb-select border-bottom form-control text-lighter">
                                                            <option>Open 24 hours</option>
                                                            <option>12 AM</option>
                                                            <option>12.30 AM</option>
                                                            <option>1 AM</option>
                                                            <option>1.30 AM</option>
                                                        </select>
                                                    </div>
                                                    <span class="p-r-30 no-padding">To</span>
                                                    <div class="flex-row hours-section open-2">
                                                        <select class="fnb-select border-bottom form-control text-lighter">
                                                            <option>Open 24 hours</option>
                                                            <option>12 AM</option>
                                                            <option>12.30 AM</option>
                                                            <option>1 AM</option>
                                                            <option>1.30 AM</option>
                                                        </select>
                                                        <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                                                            <input type="checkbox" class="checkbox" id="closed"> Closed
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-t-40 c-gap">
                                                <div>
                                                    <a href="#" class="text-secondary text-decor heavier link-center">Copy timings from Monday to Saturday</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Location & hours End -->
                                        <!-- Photos -->
                                        <div class="photos tab-pane fade" id="photos">
                                            <h5 class="no-m-t">Photos &amp; Documents</h5>
                                            <div class="m-t-30 add-container c-gap">
                                                <label>Add some images for your listing (optional)</label>
                                                <div class="text-lighter">
                                                    Tip: Photos are the most important feature of your listing. Listing with images in general get 5x more responses.
                                                </div>
                                                <img src="img/main-pic-down.png" class="m-t-15 desk-hide">
                                                <div class="image-grid">
                                                    <div class="image-grid__cols main-image">
                                                        <input type="file" class="dropify" data-height="100" />
                                                        <img src="img/main_photo.png" class="m-t-10 m-l-10 mobile-hide">
                                                    </div>
                                                    <div class="image-grid__cols">
                                                        <input type="file" class="dropify" data-height="100" />
                                                    </div>
                                                    <div class="image-grid__cols">
                                                        <input type="file" class="dropify" data-height="100" />
                                                    </div>
                                                    <div class="image-grid__cols">
                                                        <input type="file" class="dropify" data-height="100" />
                                                    </div>
                                                    <div class="image-grid__cols">
                                                        <input type="file" class="dropify" data-height="100" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-t-50 upload-container c-gap">
                                                <label>Do you have some files which you would like to upload for the listing?</label>
                                                <div class="m-t-20">
                                                    <input type="file" name="file-2[]" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple />
                                                    <label for="file-2" class="btn fnb-btn outline full border-btn"><i class="fa fa-upload" aria-hidden="true"></i> <span>Upload File</span></label>
                                                </div>
                                                <div class="m-t-10 text-lighter">
                                                    Only .jpg, .jpeg &amp; .pdf with a maximum size of 1mb is allowed
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Photos End -->
                                        <!-- Go Premium -->
                                        <div class="premium tab-pane fade" id="premium">
                                            <h5 class="no-m-t">Go Premium</h5>
                                            <h6 class="m-t-30 m-b-30">Benefits of going premium</h6>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <!-- <div class="plan text-center m-t-10">
                                                        <div class="mobile-flex plan__container">
                                                            <div>
                                                                <div class="plan__title mobile-flex">
                                                                    Free Membership
                                                                </div>
                                                                <div class="plan__price">
                                                                    Rs. 0.00/month
                                                                </div>
                                                            </div>
                                                            <i class="fa fa-check-circle desk-hide" aria-hidden="true"></i>
                                                        </div>
                                                        <div class="plan__details">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                                                        </div>
                                                        <i class="fa fa-check-circle mobile-hide" aria-hidden="true"></i>
                                                    </div> -->
                                                    <ul class="premium-points">
                                                        <li class="flex-row text-color align-top"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                                                        <li class="flex-row text-color align-top"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                                                        <li class="flex-row text-color align-top"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                                                        <li class="flex-row text-color align-top"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                                                    </ul>
                                                </div>
                                                <div class="col-sm-6 c-gap">
                                                    <div class="premium-plan">
                                                        <img src="img/premium_listing.png" class="img-responsive">
                                                       <!--  <label>Premium 1</label>
                                                        <div class="row duration-choose">
                                                            <div class="col-sm-6 dur-col col-text">
                                                                <div class="col-text__title">
                                                                    Choose a duration
                                                                </div>
                                                                <select class="form-control fnb-select border-bottom">
                                                                    <option>Rs. 3000.00/month</option>
                                                                    <option>Rs. 5000.00/month</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-6 dur-col col-btn">
                                                                <button class="btn fnb-btn outline full">Subscribe</button>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <h6 class="m-t-30 m-b-30">Our Plans</h6>
                                            <!-- pricing grids -->
                                            <div class="pricing-table plans flex-row">
                                                <div class="pricing-table__cards free-plan active">
                                                    <div class="plans__header">
                                                       <h6 class="sub-title text-uppercase plans__title text-color">Basic Plan</h6>
                                                        <div class="plans__fee">
                                                            <h5>Free Membership</h5>
                                                            <span class="text-lighter lighter sub-title"><i class="fa fa-inr" aria-hidden="true"></i> 0.00/month</span>
                                                        </div>
                                                    </div>
                                                    <div class="plans__footer">
                                                        <div class="selection">
                                                            <input type="radio" class="fnb-radio" name="plan-select" checked=""></input>
                                                            <label class="radio-check"></label>
                                                            <span class="dis-block lighter text-lighter">Your current plan</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pricing-table__cards plan-1">
                                                    <div class="plans__header">
                                                        <div class="validity">
                                                            <span class="validity__text"><h6 class="number">6</h6>Months</span>
                                                        </div>
                                                        <img src="img/power-icon.png" class="img-responsive power-icon" width="50">
                                                        <h6 class="sub-title text-uppercase plans__title text-color">Plan 1</h6>
                                                        <div class="plans__fee">
                                                            <h5><i class="fa fa-inr" aria-hidden="true"></i> 5,000</h5>
                                                        </div>
                                                        <ul class="points">
                                                            <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet.</li>
                                                            <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit elit.</li>
                                                            <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet</li>
                                                            <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                                                        </ul>
                                                    </div>
                                                    <div class="plans__footer">
                                                        <div class="selection">
                                                            <input type="radio" class="fnb-radio" name="plan-select"></input>
                                                            <label class="radio-check"></label>
                                                            <span class="dis-block lighter text-lighter">Your current plan</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pricing-table__cards plan-2">
                                                    <div class="plans__header">
                                                        <div class="validity">
                                                            <span class="validity__text"><h6 class="number">3</h6>Months</span>
                                                        </div>
                                                        <img src="img/power-icon.png" class="img-responsive power-icon" width="50">
                                                       <h6 class="sub-title text-uppercase plans__title text-color">Plan 2</h6>
                                                        <div class="plans__fee">
                                                            <h5><i class="fa fa-inr" aria-hidden="true"></i> 5,000</h5>
                                                        </div>
                                                        <ul class="points">
                                                            <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet.</li>
                                                            <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit elit.</li>
                                                            <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet</li>
                                                        </ul>
                                                    </div>
                                                    <div class="plans__footer">
                                                        <div class="selection">
                                                            <input type="radio" class="fnb-radio" name="plan-select"></input>
                                                            <label class="radio-check"></label>
                                                            <span class="dis-block lighter text-lighter">Your current plan</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right m-t-30 m-b-30 subscribe-plan">
                                                <button class="btn fnb-btn outline full border-btn" type="button">Subscribe</button>
                                            </div>
                                        </div>
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
