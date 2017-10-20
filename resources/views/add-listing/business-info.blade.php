@extends('layouts.add-listing')
@section('css')
    @parent
    <link rel="stylesheet" href="/node_modules/intl-tel-input/build/css/intlTelInput.css">
@endsection
@section('js')
    @parent
    <script type="text/javascript" src="/node_modules/intl-tel-input/build/js/intlTelInput.min.js"></script>
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
                        <option value="{{$city->id}}"@if(isset($areas) and !empty($areas) and $areas[0]->city_id == $city->id) selected @endif>{{$city->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="select-col area">
                <select class="fnb-select select-variant form-control text-lighter" required data-parsley-required-message="Select an city where the business is located.">
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
            <label class="element-title">Contact Details</label>
            <div class="text-lighter">
                Seekers would like to contact you or send enquiries. Please share your contact details below. We have pre-populated your email and phone number from your profile details.
            </div>
        </div>
        <span class="fnb-icons contact mobile-hide"></span>
        <!-- <img src="img/enquiry.png" class="mobile-hide"> -->
    </div>

<!-- contact verification HTML -->
    <input type="hidden" name="object_type" value="App\Listing">

    <!-- email -->

    <div class="m-t-20 business-email business-contact contact-info contact-info-email" contact-type="email">
        <div class="flex-row space-between mobile-sp-row">
            <label class="label-size">Enter your business email address @if($owner->type == 'external') <span class="text-primary">*</span> @endif </label>
            <a href="#" class="dark-link text-medium add-another">+ Add another email</a>
        </div>
            <div class="contact-row m-t-5">
                <div class="row no-m-b">
                    <div class="col-sm-5">
                        <input type="email" class="form-control fnb-input p-l-5 contact-input" value="@if($listing->owner_id != null) {{$owner->getPrimaryEmail()}} @endif" readonly=""  @if($owner->type == 'external')data-parsley-required @endif >
                    </div>
                    <div class="col-sm-3 col-xs-4">
                        <div class="verified flex-row">
                        @if($listing->owner_id != null )
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
                            <p class="m-b-0 text-color toggle-state"> @if(($listing->show_primary_email === null and $owner->type == 'external') or $listing->show_primary_email == "1")  Visible on the listing @else Not Visible on the listing @endif</p>
                        </div>
                        <div id="toggleError" class="visible-error"></div>
                    </div>
                </div>
            </div>
            @foreach($emails as $email)
            <div class="contact-row m-t-5 contact-container">
                <div class="row p-t-10 p-b-10 no-m-b get-val ">
                    <div class="col-sm-5">
                        <input type="hidden" class="comm-id contact_email_id contact-id" readonly  name="contact_IDs" value="{{$email->id}}">
                        <input type="email" class="form-control fnb-input p-l-5 contact-input" value="{{$email->value}}" name="contacts" data-parsley-required-message="Please enter a valid email." data-parsley-type-message="Please enter a valid email." data-parsley-type="email"  @if($email->is_verified==1) readonly @endif required>
                        <div class=dupError ></div>
                    </div>
                    <div class="col-sm-3 col-xs-4">
                        <div class="verified flex-row">
                            @if($email->is_verified==1)
                            <span class="fnb-icons verified-icon"></span>
                            <p class="c-title">Verified</p>
                            <input type="checkbox" name="verified_contact" class="hidden" style="visibility: hidden;" readonly="" checked>
                            @else
                            <!-- <a href="#" class="dark-link contact-verify-link verify-link">Verify now</a> -->
                            @if(Auth::user()->type == 'external') <a href="javascript:void(0)" class="dark-link contact-verify-link">Verify now</a> @endif
                            <input type="checkbox" name="verified_contact" class="hidden" style="visibility: hidden;" readonly="">
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <div class="flex-row close-section">
                            <div class="verified-toggle flex-row">
                                <div class="toggle m-l-10 m-r-10">
                                    <input type="checkbox" class="toggle__check" data-parsley-errors-container="#toggleError" name="visible_contact" data-parsley-multiple="contacts" @if($email->is_visible==1) checked @endif>
                                    <b class="switch"></b>
                                    <b class="track"></b>
                                    <input type="hidden" class="contact-visible" name="visible_email_contact[]" value="{{ $email->is_visible }}">
                                </div>
                                <p class="m-b-0 text-color toggle-state">@if($email->is_visible==1) Visible on the listing @else Not visible on the listing @endif </p>
                            </div>
                            <i class="fa fa-times removeRow"></i>
                        </div>
                        <div id="toggleError"></div>
                    </div>
                </div>
            </div>
            @endforeach

        <div class="contact-row m-t-5 contact-container contact-group hidden">
            <div class="row no-m-b get-val ">
                <div class="col-sm-5">
                    <input type="hidden" class="comm-id contact_email_id contact-id" readonly  name="contact_IDs">
                    <input type="email" class="form-control fnb-input p-l-5 contact-input" value="" name="contacts" data-parsley-type-message="Please enter a valid email." data-parsley-type="email" data-parsley-required-message="Please enter a valid email.">
                    <div class=dupError ></div>
                </div>
                <div class="col-sm-3 col-xs-4">
                    <div class="verified flex-row">
                        @if(Auth::user()->type == 'external')<a href="javascript:void(0)" class="dark-link contact-verify-link">Verify now</a>@endif
                        <input type="checkbox" name="verified_contact" class="hidden" style="visibility: hidden;" readonly="">
                    </div>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <div class="flex-row close-section">
                        <div class="verified-toggle flex-row">
                            <div class="toggle m-l-10 m-r-10">
                                <input type="checkbox" class="toggle__check" name="visible_contact" data-parsley-multiple="contacts" data-parsley-errors-container="#toggleError">
                                <b class="switch"></b>
                                <b class="track"></b>
                                <input type="hidden" class="contact-visible" name="visible_email_contact[]" value="0">
                            </div>
                            <p class="m-b-0 text-color toggle-state">Not visible on the listing</p>
                        </div>
                        <i class="fa fa-times removeRow"></i>
                    </div>
                    <div id="toggleError"></div>
                </div>
            </div>
        </div>
        </div>
   

    <!-- phone number -->

    <div class="m-t-40 business-phone business-contact contact-info contact-info-phone"  contact-type="mobile">
        <div class="flex-row space-between mobile-sp-row">
            <label class="label-size">Enter your business mobile number @if($owner->type == 'external') <span class="text-primary">*</span> @endif </label>
            <a href="#" class="dark-link text-medium add-another">+ Add another mobile number</a>
        </div>
        @if($listing->reference===null and $owner->type == 'external')
        <div class="contact-row m-t-5  contact-container">
            <div class="row phone-row get-val ">
                <div class="col-sm-5">
                    <div class="input-row">
                        <input type="hidden" class="comm-id contact_mobile_id contact-id " readonly  name="contact_IDs">
                        <input type="tel" class="form-control fnb-input p-l-5 contact-input contact-mobile-input contact-mobile-number" value="@if($listing->owner_id != null){{$owner->getPrimaryContact()['contact']}}@endif" name="contacts" data-parsley-length-message="Mobile number should be 10 digits." data-parsley-required-message="Mobile number should be 10 digits." data-parsley-type="digits" data-parsley-length="[10, 10]" @if($owner->type == 'external')data-parsley-required @endif >
                        <input type="hidden" class="contact-country-code" name="contact_country_code[]" value="{{$owner->getPrimaryContact()['contact_region']}}">
                        
                        <!-- <i class="fa fa-mobile" aria-hidden="true"></i> -->
                    </div>
                    <div class="dupError" id="phone-error"></div>
                </div>
                <div class="col-sm-3 col-xs-4">
                    <div class="verified flex-row">

                        @if(Auth::user()->type == 'external')<a href="#" class="dark-link contact-verify-link">Verify now</a>@endif
                        <input type="checkbox" name="verified_contact" class="hidden" style="visibility: hidden;" readonly="">

                    </div>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <div class="verified-toggle no-m-t flex-row">
                        <div class="toggle m-l-10 m-r-10">
                            <input type="checkbox" class="toggle__check" name="visible_contact" data-parsley-multiple="contacts" data-parsley-errors-container="#toggleError">
                            <b class="switch"></b>
                            <b class="track"></b>
                             <input type="hidden" class="contact-visible" name="visible_mobile_contact[]" value="0">
                        </div>
                        <p class="m-b-0 text-color toggle-state">Not visible on the listing</p>
                    </div>
                    <div id="toggleError"></div>
                </div>
            </div>
        </div>
        @endif

        @foreach ($mobiles as $mobile)
        
        <div class="contact-row m-t-5  contact-container">
            <div class="row no-m-b get-val phone-row">
                <div class="col-sm-5">

                    <input type="hidden" class="comm-id contact_mobile_id contact-id" readonly  name="contact_IDs" value="{{$mobile->id}}">

                    <div class="input-row">
                        <input type="tel" class="form-control fnb-input p-l-5 contact-input contact-mobile-input contact-mobile-number" value="{{$mobile->value}}" name="contacts" data-parsley-length-message="Mobile number should be 10 digits." data-parsley-required-message="Mobile number should be 10 digits." data-parsley-type="digits" data-parsley-length="[10, 10]" @if($mobile->is_verified==1) readonly @endif required>
                        <input type="hidden" class="contact-country-code" name="contact_country_code[]" value="{{$mobile->country_code}}">
                        <div class="dupError" ></div>
                         <!-- <i class="fa fa-mobile" aria-hidden="true"></i> -->
                    </div>
                </div>
                <div class="col-sm-3 col-xs-4">
                    <div class="verified flex-row">
                        @if($mobile->is_verified==1)
                        <span class="fnb-icons verified-icon"></span>
                        <p class="c-title">Verified</p>
                        <input type="checkbox" name="verified_contact" class="hidden" style="visibility: hidden;" readonly="" checked>
                        @else
                        @if(Auth::user()->type == 'external')<a href="#" class="dark-link contact-verify-link">Verify now</a>@endif
                        <input type="checkbox" name="verified_contact" class="hidden" style="visibility: hidden;" readonly="">
                        @endif
                    </div>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <div class="flex-row close-section">
                        <div class="verified-toggle flex-row">
                            <div class="toggle m-l-10 m-r-10">
                                <input type="checkbox" class="toggle__check" name="visible_contact" data-parsley-errors-container="#toggleError" data-parsley-multiple="contacts" @if($mobile->is_visible==1) checked @endif >
                                <b class="switch"></b>
                                <b class="track"></b>
                                   <input type="hidden" class="contact-visible" name="visible_mobile_contact[]" value="{{ $mobile->is_visible }}">
                            </div>
                            <p class="m-b-0 text-color toggle-state">@if($mobile->is_visible==1) Visible on the listing @else Not visible on the listing @endif </p>
                        </div>
                        @if (!$loop->first)<i class="fa fa-times removeRow"></i>@endif
                    </div>
                    <div id="toggleError"></div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="contact-row m-t-5 contact-container contact-group hidden">
            <div class="row no-m-b get-val phone-row ">
                <div class="col-sm-5">

                    <input type="hidden" class="comm-id contact_mobile_id contact-id" readonly  name="contact_IDs">

                    <div class="input-row">
                        <input type="tel" class="form-control fnb-input p-l-5 contact-input contact-mobile-input " value="" name="contacts" data-parsley-length-message="Mobile number should be 10 digits." data-parsley-type="digits" data-parsley-length="[10, 10]" data-parsley-required-message="Mobile number should be 10 digits.">
                        <input type="hidden" class="contact-country-code" name="contact_country_code[]" value="">
                        <div class="dupError" ></div>
                         <!-- <i class="fa fa-mobile" aria-hidden="true"></i> -->
                    </div>
                </div>
                <div class="col-sm-3 col-xs-4">
                    <div class="verified flex-row">
                        <input type="checkbox" class="hidden" name="verified_contact" style="visibility: hidden;" readonly="">
                        @if(Auth::user()->type == 'external')<a href="#" class="dark-link contact-verify-link">Verify now</a>@endif
                    </div>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <div class="flex-row close-section">
                        <div class="verified-toggle flex-row">
                            <div class="toggle m-l-10 m-r-10">
                                <input type="checkbox" class="toggle__check" name="visible_contact" data-parsley-multiple="contacts" data-parsley-errors-container="#toggleError">
                                <b class="switch"></b>
                                <b class="track"></b>
                                <input type="hidden" class="contact-visible" name="visible_mobile_contact[]" value="0">
                            </div>
                            <p class="m-b-0 text-color toggle-state">Not visible on the listing</p>
                        </div>
                        <i class="fa fa-times removeRow"></i>
                    </div>
                    <div id="toggleError"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- landline -->

    <div class="m-t-40 business-phone landline business-contact contact-info contact-info-landline">
        <div class="flex-row space-between mobile-sp-row">
            <label class="label-size">Enter your business landline number</label>
            <a href="#" class="dark-link text-medium add-another">+ Add landline number</a>
        </div>
        @foreach($phones as $phone)
        <div class="contact-row m-t-5 contact-container">
            <div class="row no-m-b phone-row get-val ">
                <div class="col-sm-5">
                    <input type="hidden" readonly class="comm-id"  name="contact_IDs" value="{{$phone->id}}">
                    <div class="input-row">
                        <input type="tel" class="form-control fnb-input p-l-5  contact-mobile-input contact-mobile-number" value="{{$phone->value}}" name="contacts" data-parsley-length-message="Landline number should be 10 - 12 digits." data-parsley-required-message="Landline number should be 10 - 12 digits." data-parsley-type="digits" data-parsley-length="[10, 12]" @if($phone->is_verified==1) readonly @endif required>
                        <input type="hidden" class="contact-country-code" name="contact_country_code[]" value="{{$phone->country_code}}">
                        <div class=dupError ></div>
                        <!-- <i class="fa fa-phone" aria-hidden="true"></i> -->
                    </div>
                </div>
                <div class="col-sm-3 col-xs-4 mobile-hide">
                </div>
                <div class="col-sm-4 col-xs-12">
                    <div class="flex-row close-section">
                        <div class="verified-toggle flex-row">
                            <div class="toggle m-l-10 m-r-10">
                                <input type="checkbox" class="toggle__check" name="visible_contact" data-parsley-errors-container="#toggleError" data-parsley-multiple="contacts" @if($phone->is_visible==1) checked @endif>
                                <b class="switch"></b>
                                <b class="track"></b>
                            </div>
                            <p class="m-b-0 text-color toggle-state">@if($phone->is_visible==1) Visible on the listing @else Not visible on the listing @endif </p>
                        </div>
                        <i class="fa fa-times removeRow"></i>
                    </div>
                    <div id="toggleError"></div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="contact-row m-t-5 contact-group contact-container hidden">
            <div class="row no-m-b phone-row get-val">
                <div class="col-sm-5">
                    <input type="hidden" readonly class="comm-id"  name="contact_IDs">
                    <div class="input-row">
                        <input type="tel" class="form-control fnb-input p-l-5  contact-mobile-input" value="" name="contacts" data-parsley-length-message="Landline number should be 10 - 12 digits." data-parsley-required-message="Landline number should be 10-12 digits." data-parsley-type="digits" data-parsley-length="[10, 12]" >
                        <div class=dupError ></div>
                        <!-- <i class="fa fa-phone" aria-hidden="true"></i> -->
                    </div>
                </div>
                <div class="col-sm-3 col-xs-4 mobile-hide">
                </div>
                <div class="col-sm-4 col-xs-12">
                    <div class="flex-row close-section">
                        <div class="verified-toggle flex-row">
                            <div class="toggle m-l-10 m-r-10">
                                <input type="checkbox" class="toggle__check" name="visible_contact" data-parsley-multiple="contacts">
                                <b class="switch"></b>
                                <b class="track"></b>
                            </div>
                            <p class="m-b-0 text-color toggle-state">Not visible on the listing</p>
                        </div>
                        <i class="fa fa-times removeRow"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
