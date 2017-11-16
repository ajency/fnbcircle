@extends('layouts.app')
@section('title', 'Add Listing')
@section('css')
    <!-- Magnify css -->
    <link rel="stylesheet" type="text/css" href="/css/magnify.css">
    <!-- Dropify css -->
    <link rel="stylesheet" type="text/css" href="/css/dropify.css">
    <!-- tags css -->
    <link rel="stylesheet" type="text/css" href="/css/jquery.flexdatalist.min.css">
@endsection

@section('js')
       <!-- Magnify popup plugin -->
    <script type="text/javascript" src="/js/magnify.min.js"></script>
    <!-- Read more -->
    <script type="text/javascript" src="/js/readmore.min.js"></script>
    <!-- Dropify -->
    <script type="text/javascript" src="/js/dropify.js"></script>
    <!-- jquery tags -->
    <script type="text/javascript" src="/js/flex-datalist/jquery.flexdatalist.min.js"></script>

      <script type="text/javascript" src="/js/underscore-min.js" ></script>
    <!-- Custom file input -->
    <script type="text/javascript" src="/js/jquery.custom-file-input.js"></script>
    <!-- Add listing -->
    <script type="text/javascript" src="/js/add-listing.js"></script>
    <!-- custom script -->
    <script type="text/javascript" src="/js/custom.js"></script>

     <script src="{{ asset('js/AddListing.js') }}"></script>
    <script type="text/javascript" src="/js/handlebars.js"></script>
   @if(Session::has('statusChange'))
    <script> 
       $('#listing-review').modal('show');
    </script>
    @endif
@endsection

@section('content')
<!-- content -->
    @if($listing->reference!=null)
    <div class="preview-header text-color mobile-hide">
        <div class="container">
            <div class="pull-left">
                <span class="text-primary">Note:</span> You can add multiple listings on FnB Circle
            </div>
            <div class="pull-right">
                <a href="{{url('/'.$cityy->slug.'/'.$listing->slug)}}" class="secondary-link preview-header__link"><i class="fa fa-eye" aria-hidden="true"></i> Preview Listing</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    @endif

    <!-- <div class="header-shifter"></div> -->

    <div class="profile-stats breadcrums-row no-shadow">
        <div class="container">
            <div class="row p-t-30 p-b-30 mobile-flex breadcrums-container listing-breadcrum @if($listing->reference!=null) edit-mode @endif @if($step == 'business-updates') post-mode @endif ">
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
                            <a href="/listing/{{$listing->reference}}" class="breadcrum-link">
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
                <div class="col-sm-4 flex-col text-right mobile-hide">

                    <div class="detach-preview mobile-hide">
                        @if($listing->reference!=null)
                            <a href="{{url('/'.$cityy->slug.'/'.$listing->slug)}}" class="preview-header__link white btn fnb-btn white-border mini"><i class="fa fa-eye" aria-hidden="true"></i> Preview Listing</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 content-wrapper @if($listing->reference!=null) edit-mode @endif @if($step == 'business-updates') post-mode-shifter @endif">
                <div class="flex-row note-row top-head m-b-15 m-t-15">
                    <h3 class="main-heading m-b-0 m-t-0 white">@if($listing->reference==null)Let's get started! @endif</h3>
                    <!-- <div class="flex-row">
                        <p class="note-row__text text-medium">
                            <div class="mobile-hide p-r-10">
                                @if($listing->reference==null) <span class="text-primary bolder status-changer">Note:</span> You can add multiple listings on F&amp;BCircle @else The current status of your listing is <span class="text-primary bolder status-changer"> @if($listing->status=="3") Draft @endif @if($listing->status=="2") Under Review @endif @if($listing->status=="1") Published @endif</span> <i class="fa fa-info-circle text-color m-l-5 draft-status" data-toggle="tooltip" data-placement="top" title="Listing will remain in draft status till submitted for review."></i> @endif
                            </div>
                        </p>
                        @if($listing->isReviewable())<button class="btn fnb-btn outline full border-btn mobile-hide review-submit">Submit for review <i class="fa fa-circle-o-notch fa-spin fa-fw"></i></button>@endif
                    </div> -->
                </div>

                @if($listing->reference==null)
                <div class="get-started">
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
                                <!-- <div class="flex-row page-intro">
                                    <div>
                                        <img src="/img/steps.png" class="mobile-hide desk-hide">
                                        <img src="/img/steps-orange.png">
                                    </div>
                                    <div class="page-intro__title">
                                        You are a few steps away from creating a listing on F&amp;BCircle
                                    </div>
                                </div> -->
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
                @endif

                <div class="m-t-20 m-b-10 white-bg-border">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3">
                            @if($listing->reference!=null)
                                <div class="dsk-separator edit-summary-card">

                                    <div class="summary-info">
                                        <h5>{{$listing->title}} <!-- <a href="/listing/{{$listing->reference}}" target="_blank">View</a> --></h5>
                                        <div class="rating">
                                            <div class="bg"></div>
                                            <div class="value" style="width: 50%;"></div>
                                        </div>
                                        <div class="listing-status">
                                            <div class="label">STATUS</div>
                                            <div class="flex-row space-between">
                                                <div class="statusMsg">
                                                @if($listing->status=="3") 
                                                    Draft <i class="fa fa-info-circle text-color m-l-5 draft-status" data-toggle="tooltip" data-placement="top" title="Listing will remain in draft status till submitted for review."></i>  
                                                @elseif($listing->status=="2") 
                                                    Pending Review 
                                                @elseif($listing->status=="1") 
                                                    Published 
                                                @elseif($listing->status=="4")
                                                    Archived 
                                                @elseif($listing->status=="5") 
                                                    Rejected
                                                @endif
                                                </div>
                                                <div>
                                                @if($listing->isReviewable() and ($listing->status == "3" or $listing->status == "5"))
                                                    <a href="#" data-toggle="modal" data-target="#confirmBox">Submit for Review</a>
                                                @endif
                                                @if($listing->isReviewable() and ($listing->status == "1"))
                                                    <a href="#" data-toggle="modal" data-target="#confirmBox">Archive</a>
                                                @endif
                                                @if($listing->isReviewable() and ($listing->status == "4"))
                                                   <a href="#" data-toggle="modal" data-target="#confirmBox">Publish</a>
                                                @endif
                                                @if($listing->status == '1')
                                                    <i class="fa fa-info-circle text-color m-l-5" data-toggle="tooltip" data-placement="top" title="Remove this Listing." ></i>
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($listing->isReviewable() and !$listing->isPremium())
                                    <div class="premium-info">
                                        <p>
                                            Premium listings usually get more leads than non premium.
                                            Subscribe to our paid plans and watch your business grow.
                                        </p>
                                        <a href="@if($listing->reference!=null and $step != 'business-plans') /listing/{{$listing->reference}}/edit/business-premium?step=true @else # @endif" class="">Go Premium</a>
                                    </div>
                                    @endif
                                </div>
                            @endif

                            <div class="dsk-separator">
                                @if($listing->reference!=null)
                                    <ul class="edit-steps">
                                        <li>
                                            @if($listing->status!="1")
                                            <div class="links inactive">
                                            @else
                                            <a href="#" class="links enabled">
                                            @endif
                                                <div>
                                                    Listing Summary
                                                    @if($listing->status!="1") <i class="fa fa-info-circle small text-color m-l-5" data-toggle="tooltip" data-placement="top" title="Business status should be published to access this."></i> @endif
                                                </div>
                                                <i class="fa fa-caret-right"></i>
                                            @if($listing->status!="1")
                                            </div>
                                            @else
                                            </a>
                                            @endif
                                        </li>
                                        <li>
                                            @if($listing->status!="1")
                                            <div class="links inactive">
                                            @else
                                            <a href="@if($listing->reference!=null and $step != 'business-updates') /listing/{{$listing->reference}}/edit/post-an-update?step=true @else # @endif" id="post-update" class="links enabled form-toggle">
                                            @endif
                                                <div>
                                                    Post an Update
                                                    @if($listing->status!="1") <i class="fa fa-info-circle small text-color m-l-5" data-toggle="tooltip" data-placement="top" title="Business status should be published to access this."></i> @endif
                                                </div>
                                                <i class="fa fa-caret-right"></i>
                                            @if($listing->status!="1")
                                            </div>
                                            @else
                                            </a>
                                            @endif
                                        </li>
                                        <li>
                                            @if($listing->status!="1")
                                            <div class="links inactive">
                                            @else
                                            <a href="#" class="links enabled">
                                            @endif
                                                <div>
                                                    My Leads
                                                    @if($listing->status!="1") <i class="fa fa-info-circle small text-color m-l-5" data-toggle="tooltip" data-placement="top" title="Business status should be published to access this."></i> @endif
                                                </div>
                                                <i class="fa fa-caret-right"></i>
                                            @if($listing->status!="1")
                                            </div>
                                            @else
                                            </a>
                                            @endif
                                        </li>
                                        <li>
                                            <a href="#stepsCollapse" class="links enabled" data-toggle="collapse">Edit your Listing <!-- <i class="fa fa-chevron-down small"></i> --></a>
                                        </li>
                                    </ul>
                                @endif
                                <ul class="gs-steps @if($listing->reference!=null) collapse in edit-mode @endif" role="tablist"  @if($listing->reference!=null)id="stepsCollapse"@endif>
                                    <li class="">
                                        <a href="@if($listing->reference!=null and $step != 'business-information') /listing/{{$listing->reference}}/edit/business-information?step=true @else # @endif" class="@if($listing->reference == null or $step == 'business-information') form-toggle @endif" id="add_listing">Business Information <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </li>

                                   <li class="@if($listing->reference!=null)  @else disable @endif busCat">
                                        <a href="@if($listing->reference!=null and $step != 'business-categories') /listing/{{$listing->reference}}/edit/business-categories?step=true @else # @endif" class="@if($listing->reference == null or $step == 'business-categories') form-toggle @endif" id="business_categories">Business Categories <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </li>

                                    <li class="@if($listing->isReviewable())  @else disable @endif">
                                        <a href="@if($listing->reference!=null and $step != 'business-location-hours') /listing/{{$listing->reference}}/edit/business-location-hours?step=true @else # @endif" class="@if($listing->reference == null or $step == 'business-location-hours') form-toggle @endif" id="business_location">Location &amp; Hours of Operation <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </li>
                                    <li class="@if($listing->isReviewable())  @else disable @endif">
                                        <a href="@if($listing->reference!=null and $step != 'business-details') /listing/{{$listing->reference}}/edit/business-details?step=true @else # @endif" class="@if($listing->reference == null or $step == 'business-details') form-toggle @endif" id="business_details">Business Details <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </li>
                                    <li class="@if($listing->isReviewable())  @else disable @endif">
                                        <a href="@if($listing->reference!=null and $step != 'business-photos-documents') /listing/{{$listing->reference}}/edit/business-photos-documents?step=true @else # @endif" class="@if($listing->reference == null or $step == 'business-photos-documents') form-toggle @endif" id="business_photos">Photos &amp; Documents <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </li>
                                    <li class="@if($listing->isReviewable())  @else disable @endif">
                                        <a href="@if($listing->reference!=null and $step != 'business-premium') /listing/{{$listing->reference}}/edit/business-premium?step=true @else # @endif" class="@if($listing->reference == null or $step == 'business-premium') form-toggle @endif" id="business_premium">Go Premium <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                            </div>

                            <div class="view-sample dsk-separator m-t-20 m-b-20">
                                View what a sample business listing would look like once created.
                                <div class="m-t-10">
                                    <a href="/pdf/sample-business-listing.pdf" class="mobile-hide" target="_blank">
                                        <img src="/img/sample_listing.png" class="img-responsive">
                                    </a>
                                    <a href="/pdf/sample-business-listing.pdf" class="desk-hide" target="_blank">View the sample</a>
                                </div>
                            </div>
                            <!-- <div class="why-premium">
                                <div class="text-darker">
                                    <strong>Go PREMIUM!</strong> Read why...
                                </div>
                                <div class="text-lighter m-t-15">
                                    More contacts &amp; enquiries from seekers, indirectly more leads.
                                </div>
                                <div class="text-lighter m-t-15">
                                    Premium listings have priority over non premium as they are displayed first on the list view of listings.
                                </div>
                            </div> -->
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <div class="pos-fixed fly-out no-transition slide-bg listing-form-wrapper listing-sections @if(isset($_GET['step']))active @endif">
                                <div class="mobile-back desk-hide mobile-flex @if($listing->reference!=null) p-v-10 @endif ">
                                    <div class="left mobile-flex">
                                        <i class="fa fa-arrow-left text-primary back-icon" aria-hidden="true"></i>
                                        <p class="element-title heavier m-b-0">Back</p>
                                    </div>
                                    @if($listing->reference!=null)
                                        <div>
                                            <a href="{{url('/'.$cityy->slug.'/'.$listing->slug)}}" class="fnb-btn mini outline btn preview-header__link">Preview</a>
                                        </div>
                                    @endif
                                </div>
                                <div class="fly-out__content">
                                    @if($listing->reference!=null)
                                    <div class="preview-header text-color desk-hide"> Do you want to see a preview of your listing? <a href="{{url('/'.$cityy->slug.'/'.$listing->slug)}}" class="secondary-link preview-header__link">Preview</a>
                                    </div>
                                    @endif
                                    
                                    <p class="note-row__text--status text-medium desk-hide">

                                         @if($listing->reference==null) <span class="text-primary bolder status-changer">Note:</span> You can add multiple listings on FnB Circle @else The current status of your listing is <span class="text-primary bolder status-changer">@if($listing->status=="3") Draft <i class="fa fa-info-circle text-color" data-toggle="tooltip" data-placement="top" title="" data-original-title="Listing will remain in draft status till submitted for review."></i> @endif @if($listing->status=="2") >Pending Review @endif @if($listing->status=="1") Published @endif</span> <!-- <i class="fa fa-info-circle text-color m-l-5" data-toggle="tooltip" data-placement="top" title="Listing will remain in draft status till submitted for review."></i> -->

                                         @endif
                                    </p>
                                    <div class="gs-form tab-content @if($listing->reference!=null) p-t-0 @endif">
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

                                    <!-- failure message-->
                                    <div class="alert fnb-alert @if ($errors->any()) server-error @endif alert-failure alert-dismissible fade in " role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <div class="flex-row">
                                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                             Oh snap! Some error occurred. Please check all the details and proceed.
                                        </div>

                                        <ul>
                                                  @foreach ($errors->all() as $error)
                                                      <li>{{ $error }}</li>
                                                  @endforeach
                                              </ul>
                                    </div>
                                        <form id="info-form">
                                       <input type="hidden" id="step-name" value="{{$step}}" readonly>
                                        @yield('form-data')

                                        <!-- Submit for review section -->
                                        <input type="hidden" id="listing_id" value="{{$listing->reference}}"  readonly>
                                        @if($listing->isReviewable() and $listing->status > "2" and $listing->status != "4")
                                        <div class="m-t-30 c-gap">
                                           <div class="review-note flex-row space-between">
                                                <div class="review-note__text flex-row">
                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                    <p class="review-note__title">If you don't want to further complete/edit the listing, you can submit it for review</p>
                                                </div>
                                               <div class="review-note__submit">
                                                     <a href="#" class="primary-link sub-title" data-toggle="modal" data-target="#confirmBox">Submit for Review</a>
                                               </div>
                                           </div>
                                        </div>
                                        @endif
                                        <!-- content navigation -->
                                        @if($step!= 'business-updates')
                                        <div class="gs-form__footer flex-row m-t-30">
                                            @if($step != 'business-information')<a class="btn fnb-btn outline no-border gs-prev" href="/listing/{{$listing->reference}}/edit/{{$back}}?step=true"><i class="fa fa-arrow-left" aria-hidden="true" ></i> Back</a> @endif

                                            @if($step != 'business-premium' )<button class="btn fnb-btn primary-btn full save-btn gs-next" type=button>Save &amp; Next</button>@endif
                                            <!-- <button class="btn fnb-btn outline no-border ">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button> -->
                                        </div>
                                        @endif
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

@if(Session::has('statusChange'))
                <!-- listing review -->
    <div class="modal fnb-modal listing-review fade modal-center" id="listing-review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aria-label="Close">&#10005;</button>
                </div>
                <div class="modal-body text-center">
                    <div class="listing-message">
                        <i class="fa fa-check-circle check" aria-hidden="true"></i>
                        <h4 class="element-title heavier">
                            @if(session('statusChange')=='review')
                                We have sent your listing for review
                            @endif
                            @if(session('statusChange')=='archive')
                                Your listing has been archived
                            @endif
                            @if(session('statusChange')=='published')
                                Your Listing has been published
                            @endif
                        </h4>
                        <p class="default-size text-color lighter list-caption">@if(session('statusChange')=='review')Our team will review your listing and you will be notified if your listing is published.@endif</p>
                    </div>
                    <div class="listing-status highlight-color">
                        <p class="m-b-0 text-darker heavier">The current status of your listing is</p>
                        <div class="pending text-darker heavier sub-title">
                        @if(session('statusChange')=='review')<i class="fa fa-clock-o text-primary p-r-5" aria-hidden="true"></i> Pending Review @endif
                        @if(session('statusChange')=='archive')
                        Archived
                        @endif
                       @if(session('statusChange')=='published')
                       Published
                        @endif
                         <!-- <i class="fa fa-info-circle text-darker p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pending review"></i> --></div>
                    </div>
                </div>
                <div class="modal-footer">
                        <button class="btn fnb-btn outline cancel-modal border-btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endif

                <!-- listing present -->
                <div class="modal fnb-modal duplicate-listing fade multilevel-modal" id="duplicate-listing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="level-one mobile-hide">
                                    <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="listing-details text-center">
                                    <img src="/img/listing-search.png" class="img-responsive center-block">
                                    <h5 class="listing-details__title sub-title">Looks like the listing is already present on FnB Circle.</h5>
                                    @if(Auth::user()->type == 'external')
                                    <p class="text-lighter lighter listing-details__caption default-size">Please confirm if the following listing(s) belongs to you.
                                        <br> You can either Claim the listing or Delete it.</p>
                                    @endif
                                </div>
                                <div class="list-entries">
                                    <div class="list-row flex-row">
                                        <div class="left">
                                            <h5 class="sub-title text-medium text-capitalise list-title">Mystical the meat and fish store</h5>
                                            <p class="text-color default-size">
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

                                    <div class="list-row flex-row">
                                        <div class="left">
                                            <h5 class="sub-title text-medium text-capitalise list-title">Mystical the meat and fish store</h5>
                                            <p class="text-color default-size">
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
                                <button class="btn fnb-btn outline full border-btn no-border skip text-danger" data-dismiss="modal" aria-label="Close" id="skip-duplicates">Skip to Continue <i class="fa fa-forward p-l-5" aria-hidden="true" ></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                @if($listing->isReviewable() and ($listing->status == "3" or $listing->status == "5"))
                    <div class="modal fnb-modal confirm-box fade modal-center" id="confirmBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="text-medium m-t-0 bolder">Confirm</h5>
                              </div>
                              <div class="modal-body text-center">
                                  <div class="listing-message">
                                      <h4 class="element-title text-medium text-left text-color">Are you sure you want to send your listing for review?</h4>
                                  </div>  
                                  <div class="confirm-actions text-right">
                                      <a href="#" class="review-submit-link" > <button class="btn fnb-btn text-primary border-btn no-border" >Send for Review</button></a>
                                        <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                                  </div>
                              </div>
                              <!-- <div class="modal-footer">
                                  <button class="btn fnb-btn outline cancel-modal border-btn" data-dismiss="modal">Close</button>
                              </div> -->
                          </div>
                      </div>
                  </div>
                @endif
                @if($listing->isReviewable() and ($listing->status == "1"))
                    <div class="modal fnb-modal confirm-box fade modal-center" id="confirmBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="text-medium m-t-0 bolder">Confirm</h5>
                              </div>
                              <div class="modal-body text-center">
                                  <div class="listing-message">
                                      <h4 class="element-title text-medium text-left text-color">Are you sure you want to archive your listing?</h4>
                                  </div>  
                                  <div class="confirm-actions text-right">
                                      <a href="#" class="archive-submit-link" > <button class="btn fnb-btn text-primary border-btn no-border" >Archive</button></a>
                                        <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                                  </div>
                              </div>
                              <!-- <div class="modal-footer">
                                  <button class="btn fnb-btn outline cancel-modal border-btn" data-dismiss="modal">Close</button>
                              </div> -->
                          </div>
                      </div>
                  </div>
                @endif
                @if($listing->isReviewable() and ($listing->status == "4"))
                    <div class="modal fnb-modal confirm-box fade modal-center" id="confirmBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="text-medium m-t-0 bolder">Confirm</h5>
                              </div>
                              <div class="modal-body text-center">
                                  <div class="listing-message">
                                      <h4 class="element-title text-medium text-left text-color">Are you sure you want to publish your listing ?</h4>
                                  </div>  
                                  <div class="confirm-actions text-right">
                                      <a href="#" class="publish-submit-link" > <button class="btn fnb-btn text-primary border-btn no-border" >Publish</button></a>
                                        <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                                  </div>
                              </div>
                              <!-- <div class="modal-footer">
                                  <button class="btn fnb-btn outline cancel-modal border-btn" data-dismiss="modal">Close</button>
                              </div> -->
                          </div>
                      </div>
                  </div>
                @endif
            </div>
        </div>
        <div class="site-loader full-loader hidden">
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
        <div class="site-overlay"></div>
    </div>
    <!-- content ends -->
@endsection
