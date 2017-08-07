@extends('layouts.fnbtemplate')
@section('title', 'Add Listing')
@section('css')

@endsection

@section('js')
    <!-- Custom file input -->
    <script type="text/javascript" src="/js/jquery.custom-file-input.js"></script>
    <!-- Add listing -->
    <script type="text/javascript" src="/js/add-listing.js"></script>
    <!-- custom script -->
    <script type="text/javascript" src="/js/custom.js"></script>
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
                    @if($listing->reference==null)
                    <li class="fnb-breadcrums__section">
                        <a href="#">
                            <p class="fnb-breadcrums__title">Add a listing</p>
                        </a>
                    </li>
                    @else
                    <li class="fnb-breadcrums__section">
                        <a href="/listing/{{$listing->reference}}">
                            <p class="fnb-breadcrums__title">{{$listing->title}}</p>
                        </a>
                    </li>
                    <li class="fnb-breadcrums__section">
                        <a href="">
                            <p class="fnb-breadcrums__title">/</p>
                        </a>
                    </li>
                    <li class="fnb-breadcrums__section">
                        <a href="#">
                            <p class="fnb-breadcrums__title">Edit Listing</p>
                        </a>
                    </li>
                    @endif
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
                        <img src="/img/steps.png" class="mobile-hide desk-hide">
                        <img src="/img/steps-orange.png">
                    </div>
                    <div class="page-intro__title">
                        You are a few steps away from creating a listing on F&amp;B Circle
                    </div>
                </div>
                <div class="flex-row note-row top-head m-b-15 m-t-15">
                    <h3 class="main-heading m-b-0 m-t-0">@if($listing->reference==null)Let's get started! @else {{$listing->title}} @endif</h3>
                    <div class="flex-row">
                        <p class="note-row__text text-medium">
                            <!-- <span class="text-primary">Note:</span> You can add multiple listings on F&amp;BCircle. -->
                            <div class="mobile-hide p-r-10">
                                @if($listing->reference==null) <span class="text-primary bolder status-changer">Note:</span> You can add multiple listings on F&amp;BCircle @else The current status of your listing is <span class="text-primary bolder status-changer"> @if($listing->status=="3") Draft @endif @if($listing->status=="2") Under Review @endif @if($listing->status=="1") Published @endif</span> <i class="fa fa-info-circle text-color m-l-5 draft-status" data-toggle="tooltip" data-placement="top" title="Listing will remain in draft status till submitted for review."></i> @endif
                            </div>
                        </p>
                        @if($listing->isReviewable())<button class="btn fnb-btn outline full border-btn mobile-hide review-submit">Submit for review <i class="fa fa-circle-o-notch fa-spin fa-fw"></i></button>@endif
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
                                <img src="/img/bulb.png" class="desk-hide">
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
                                <li class="">
                                    <a href="#" class="form-toggle" id="add_listing">Business Information <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#" class="form-toggle" id="business_categories">Business Categories <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#" class="form-toggle" id="business_location">Location &amp; Hours of Operation <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#" class="form-toggle" id="business_details">Business Details <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#" class="form-toggle" id="business_photos">Photos &amp; Documents <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="#" class="form-toggle" id="business_premium">Go Premium <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                            <div class="view-sample m-t-20 m-b-20">
                                View what a sample business listing would look like once created.
                                <div class="m-t-10">
                                    <img src="/img/sample_listing.png" class="img-responsive mobile-hide sample-img">
                                    <a href="/img/sample_listing.png" class="desk-hide sample-img">View the sample</a>
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
                            <div class="pos-fixed fly-out slide-bg listing-sections">
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
                                         @if($listing->reference==null) <span class="text-primary bolder status-changer">Note:</span> You can add multiple listings on F&amp;BCircle @else The current status of your listing is <span class="text-primary bolder status-changer">@if($listing->status=="3") Draft @endif @if($listing->status=="2") Under Review @endif @if($listing->status=="1") Published @endif</span> <i class="fa fa-info-circle text-color m-l-5" data-toggle="tooltip" data-placement="top" title="Listing will remain in draft status till submitted for review."></i>
                                         @endif
                                    </p>
                                    <div class="gs-form tab-content">
                                        <form id="info-form">
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
                                        <input style="visibility: hidden" id="listing_id" value="{{$listing->reference}}"  readonly>
                                        @if($listing->isReviewable())
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
                                        @endif
                                        <!-- content navigation -->
                                        <div class="gs-form__footer flex-row m-t-40">
                                            @if($step != 'listing_information')<button class="btn fnb-btn outline no-border gs-prev"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button> @endif
                                            <button onclick="validateListing(event)" class="btn fnb-btn primary-btn full save-btn gs-next">Save &amp; Next</button>
                                            <!-- <button class="btn fnb-btn outline no-border ">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button> -->
                                        </div>
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


                <!-- Modal -->
                <!-- listing present -->
                <div class="modal fnb-modal duplicate-listing fade multilevel-modal" id="duplicate-listing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="level-one mobile-hide">
                                    <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="listing-details text-center">
                                    <img src="/img/listing-search.png" class="img-responsive center-block">
                                    <h5 class="listing-details__title element-title">Looks like the listing is already present on F&amp;BCircle.</h5>
                                    <p class="text-lighter lighter listing-details__caption">Please confirm if the following listing(s) belongs to you.
                                        <br> You can either Claim the listing or Delete it.</p>
                                </div>
                                <div class="list-entries">
                                    <div class="list-row flex-row">
                                        <div class="left">
                                            <h5 class="sub-title text-medium text-capitalise list-title">Mystical the meat and fish store</h5>
                                            <p class="text-color">
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
                                            <h5 class="sub-title text-medium text-capitalise list-title">Mystical the meat and fish store</h5>
                                            <p class="text-color">
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
            </div>
        </div>
        <div class="site-loader hidden">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
        </div>
        <div class="site-overlay"></div>
    </div>
    <!-- content ends -->
@endsection
