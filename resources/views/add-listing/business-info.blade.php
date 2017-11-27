@extends('layouts.add-listing')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('/bower_components/intl-tel-input/build/css/intlTelInput.css') }}">
@endsection
@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('/bower_components/intl-tel-input/build/js/intlTelInput.min.js') }}"></script>
    <script type="text/javascript" src="/js/add-listing-info.js"></script>
@endsection
@section('form-data')




<div class="business-info tab-pane fade in active" id="add_listing">
    <div class="flex-row space-between preview-detach">
        <h5 class="no-m-t fly-out-heading-size main-heading @if($listing->reference!=null) white m-t-0 @endif ">Business Information</h5>
    </div>
    <div class="m-t-30 c-gap">
        <label class="label-size">Tell us the name of your business <span class="text-primary">*</span></label>
        <input type="text" name="listing_title" class="form-control fnb-input" placeholder="" value="{{ old('title', $listing->title)}}" data-parsley-required-message="Please enter the name of your business." data-parsley-required data-parsley-maxlength=255 data-parsley-maxlength-message="Business name cannot be more than 255 characters." data-parsley-required data-parsley-minlength=2 data-parsley-minlength-message="Business name cannot be less than 2 characters.">
        <div class="text-lighter m-t-5">
            This will be the display name of your listing.
        </div>
    </div>
    <div class="m-t-50 c-gap">
        <label class="label-size">Who are you? <span class="text-primary">*</span></label>
        <div class="text-lighter">
            The right business type will get you the right enquiries. A listing can be only of one type.
        </div>
        <ul class="business-type flex-row m-t-25">
            <li>
                <input value="11" type="radio" class="radio" name="business_type" data-parsley-multiple="listing_type" data-parsley-required-message="Please select a business type." data-parsley-errors-container="#errorfield" @if($listing->type=='11') checked=checked @endif>
                <div class="wholesaler option flex-row col-direction">
                    <div>
                        <span class="fnb-icons business-icon wholesaler"></span>
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="business-label">
                        Wholesaler/ Distributor
                    </div>
                </div>
            </li>
            <li>
                <input value="12" type="radio" class="radio" name="business_type" data-parsley-multiple="listing_type" data-parsley-required-message="Please select a business type." data-parsley-errors-container="#errorfield" @if($listing->type=='12') checked=checked @endif>
                <div class="retailer option flex-row col-direction">
                    <div>
                        <span class="fnb-icons business-icon retailer"></span>
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="business-label">
                        Retailer
                    </div>
                </div>
            </li>
            <li>
                <input value="13" type="radio" class="radio" name="business_type" data-parsley-multiple="listing_type" data-parsley-required-message="Please select a business type." data-parsley-required data-parsley-errors-container="#errorfield" @if($listing->type=='13') checked=checked @endif>
                <div class="manufacturer option flex-row col-direction">
                    <div>
                        <span class="fnb-icons business-icon manufacturer"></span>
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="business-label">
                        Manufacturer
                    </div>
                </div>
            </li>
            <li>
                <input value="14" type="radio" class="radio" name="business_type" data-parsley-multiple="listing_type" data-parsley-required-message="Please select a business type." data-parsley-errors-container="#errorfield" @if($listing->type=='14') checked=checked @endif>
                <div class="wholesaler option flex-row col-direction">
                    <div>
                        <span class="fnb-icons business-icon wholesaler importer"></span>
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="business-label">
                        Importer
                    </div>
                </div>
            </li>
            <li>
                <input value="15" type="radio" class="radio" name="business_type" data-parsley-multiple="listing_type" data-parsley-required-message="Please select a business type." data-parsley-errors-container="#errorfield" @if($listing->type=='15') checked=checked @endif>
                <div class="retailer option flex-row col-direction">
                    <div>
                        <span class="fnb-icons business-icon retailer exporter"></span>
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="business-label">
                        Exporter
                    </div>
                </div>
            </li>
            <li>
                <input value="16" type="radio" class="radio" name="business_type" data-parsley-multiple="listing_type" data-parsley-required-message="Please select a business type." data-parsley-required data-parsley-errors-container="#errorfield" @if($listing->type=='16') checked=checked @endif>
                <div class="manufacturer option flex-row col-direction">
                    <div>
                        <span class="fnb-icons business-icon manufacturer service-provider"></span>
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="business-label">
                        Service Provider
                    </div>
                </div>
            </li>
        </ul>
        <div id="errorfield"></div>

    </div>
    <div class="m-t-40 c-gap">

        <label class="label-size">Where is the business located? <span class="text-primary">*</span></label>
        <div class="location-select flex-row flex-wrap">
            <div class="select-col city">
                <select class="fnb-select select-variant form-control text-lighter" name="city" required data-parsley-required-message="Select a state where the business is located.">
                    <option value="">Select State</option>
                    @foreach($cities as $city)
                        <option value="{{$city->id}}"@if(isset($areas) and count($areas) != 0 and $areas[0]->city_id == $city->id) selected @endif>{{$city->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="select-col area">
                <select class="fnb-select select-variant form-control text-lighter" required data-parsley-required-message="Select a city where the business is located.">

                    <option value="">Select City</option>
                    @if(isset($areas))
                    @foreach($areas as $area)
                        <option value="{{$area->id}}"@if($area->id == $listing->locality_id) selected @endif>{{$area->name}}</option>
                    @endforeach
                    @endif
                    <!-- @if(isset($area))<option value="{{$area->id}}" selected>{{$area->name}}</option>@endif -->
                </select>
            </div>
        </div>
        <div id="areaError" ></div>
    </div>
    <div class="m-t-20 flex-row c-gap">
        <div class="m-r-10 no-m-l">
            <label class="element-title">User Details</label>
        </div>
    </div>
    <div class="business-contact">
        <div class="contact-row m-t-5">
            <div class="row no-m-b">
                <div class="col-sm-5">
                    <input name="primary_email_txt"  placeholder="User Email" type="email" class="form-control fnb-input p-l-5" value="@if($listing->owner_id != null) {{$owner->getPrimaryEmail()}} @endif"   @if($owner->type == 'external') readonly="" data-parsley-required @endif >
                </div>
                <div class="col-sm-3 col-xs-4">
                    <div class="verified flex-row">
                    @if($owner->getPrimaryEmail(true)['is_verified'] == true and $owner->type == 'external' )
                        <span class="fnb-icons verified-icon"></span>
                        <p class="c-title">Verified</p>
                    @endif
                    </div>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <div class="verified-toggle flex-row">
                        <div class="toggle m-l-10 m-r-10">
                            <input name="primary_email" type="checkbox" class="toggle__check" data-parsley-errors-container="#toggleError" data-parsley-multiple="contacts" data-parsley-required-message="At least one contact detail either email or phone number should be visible on the listing." data-parsley-mincheck="1" @if($owner->type == 'external')data-parsley-required @endif  @if(($listing->show_primary_email === null and $owner->type == 'external')  or $listing->show_primary_email == "1") checked="true" @endif>
                            <b class="switch"></b>
                            <b class="track"></b>
                        </div>
                        <p class="m-b-0 text-color toggle-state"> @if(($listing->show_primary_email === null and $owner->type == 'external') or $listing->show_primary_email == "1")  Visible  @else Not Visible  @endif</p>
                    </div>
                    <div id="toggleError" class="visible-error"></div>
                </div>
            </div>
            <div class="row no-m-b contact-container">
                <div class="col-sm-5">
                    <input name="primary_phone_txt" class="contact-mobile-number" type="tel" placeholder="User Contact" class="form-control fnb-input p-l-5" value="@if($listing->owner_id != null) {{$owner->getPrimaryContact()['contact']}} @endif"   @if($owner->type == 'external') readonly="" data-parsley-required @endif data-intl-country="{{$owner->getPrimaryContact()['contact_region']}}" >
                    <input type="hidden" class="contact-country-code" name="contact_country_code[]" @if($owner->type == 'external')  value="{{$owner->getPrimaryContact()['contact_region']}}" @endif>
                </div>
                <div class="col-sm-3 col-xs-4">
                    <div class="verified flex-row">
                    @if($owner->getPrimaryContact()['is_verified'] == true and $owner->type == 'external' )
                        <span class="fnb-icons verified-icon"></span>
                        <p class="c-title">Verified</p>
                    @endif
                    </div>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <div class="verified-toggle flex-row @if($owner->type != 'external')hidden @endif">
                        <div class="toggle m-l-10 m-r-10">
                            <input name="primary_phone" type="checkbox" class="toggle__check" data-parsley-errors-container="#toggleError" data-parsley-multiple="contacts" data-parsley-required-message="At least one contact detail either email or phone number should be visible on the listing." data-parsley-mincheck="1" @if($owner->type == 'external')data-parsley-required @endif  @if(($listing->show_primary_email === null and $owner->type == 'external')  or $listing->show_primary_email == "1") checked="true" @endif>
                            <b class="switch"></b>
                            <b class="track"></b>
                        </div>
                        <p class="m-b-0 text-color toggle-state"> @if(($listing->show_primary_email === null and $owner->type == 'external') or $listing->show_primary_email == "1")  Visible  @else Not Visible @endif</p>
                    </div>
                    <div id="toggleError" class="visible-error"></div>
                </div>
            </div>
        </div>
    </div>


    <div class="m-t-20 flex-row c-gap">
        <div class="m-r-10 no-m-l">
            <label class="element-title">Contact Details</label>
            <div class="text-lighter">
                Seekers would like to contact you or send enquiries. Please share your contact details below. We have pre-populated your email and phone number from your profile details.
            </div>
        </div>
        <span class="fnb-icons contact mobile-hide"></span>
        <!-- <img src="img/enquiry.png" class="mobile-hide"> -->
    </div>

<!-- contact verification HTML -->
    <div class="verification-content">
        <input type="hidden" name="object_type" value="App\Listing">
        @php
            $contactEmail = $emails;
        @endphp
        @include('modals.verification.email-verification')
        @php
            $contactMobile = $mobiles;
        @endphp
        @include('modals.verification.mobile-verification')
        @php
            $contactLandline = $phones;
        @endphp
        @include('modals.verification.landline-verification')

        
    </div>
</div>


@endsection
