@extends('layouts.add-listing')
@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('/bower_components/intl-tel-input/build/css/intlTelInput.css') }}">
@endsection
@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('/bower_components/intl-tel-input/build/js/intlTelInput.min.js') }}"></script>
    <script type="text/javascript" src="/js/add-listing-info.js"></script>
    @if($show_duplicates and count($duplicates) > 0)
        <script type="text/javascript">
            $('#duplicate-listing').modal('show');
        </script>
    @endif
@endsection
@section('meta')
<meta property="check-user-exist" content="{{action('CommonController@checkIfEmailExist')}}">
@endsection
@section('form-data')


<input type="hidden" id="user-type" value="{{$owner->type}}" readonly>

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
    @if(Auth::user()->type == 'internal')
    <div class="m-t-20 flex-row c-gap">
        <div class="m-r-10 no-m-l">
            <label class="element-title">User Details</label>
        </div>
    </div>
    <div class="business-contact user-details-container">
        <div class="contact-row m-t-5">
            <div class="row no-m-b">
                <div class="col-sm-5">
                    <input name="user-email"  placeholder="Enter listing owner's email address" type="email" class="form-control fnb-input p-l-5 default-size user-fields" value="@if($listing->owner_id != null){{$owner->getPrimaryEmail()}}@endif"   @if($owner->type == 'external') readonly="" data-parsley-required @endif >
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
                </div>
            </div>
        </div>
        <div class="contact-row m-t-5">
            <div class="row contact-container internal-contact-row">
                <div class="col-sm-5">
                    <input name="user-phone" class="form-control fnb-input p-l-5 p-t-0 contact-mobile-input contact-mobile-number default-size user-fields" type="tel" placeholder="Enter listing owner's mobile number" value="@if($listing->owner_id != null){{$owner->getPrimaryContact()['contact']}}@endif"   @if($owner->type == 'external') readonly=""  @endif data-intl-country="{{$owner->getPrimaryContact()['contact_region']}}" >
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
                </div>
            </div>
        </div>

    </div>
    @endif

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
            $is_listing = true;
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


<div class="modal fnb-modal confirm-box fade modal-center" id="user-exist-confirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="text-medium m-t-0 bolder">Confirm</h5>
          </div>
          <div class="modal-body text-center">
              <div class="listing-message">
                  <h4 class="element-title text-medium text-left text-color" id="user-exist-text"></h4>
                  <div class="status-checkbox" id="status-c">
                      <input type="checkbox" class="checkbox" id="send-email-checkbox"> 
                      Send email to <div id="status-address"></div>
                  </div>
              </div>  
              <div class="confirm-actions text-right">
                  <button class="btn fnb-btn text-primary border-btn no-border" id="save-listing" >Save Listing</button></a>
                  <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
              </div>
          </div>
          <!-- <div class="modal-footer">
              <button class="btn fnb-btn outline cancel-modal border-btn" data-dismiss="modal">Close</button>
          </div> -->
      </div>
  </div>
</div>

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
                    @if($show_duplicates)
                    @foreach($duplicates as $reference => $duplicate)
                    <div class="list-row flex-row">
                        <div class="left">
                            <h5 class="sub-title text-medium text-capitalise list-title">{{$duplicate['name']}}</h5>
                            @foreach($duplicate['messages'] as $message)
                            <p class="text-color default-size">
                                <i class="fa fa-exclamation-circle p-r-5 text-primary" aria-hidden="true"></i> <span class="lighter">{!!$message!!}</span>
                            </p>
                            @endforeach
                        </div>
                        <div class="right">
                            <div class="capsule-btn flex-row">
                                <button class="btn fnb-btn outline full border-btn no-border claim text-danger">Claim</button>
                                <button class="btn fnb-btn outline full border-btn no-border delete">Delete</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn fnb-btn outline full border-btn no-border skip text-danger" data-dismiss="modal" aria-label="Close" id="skip-duplicates">Skip to Continue <i class="fa fa-forward p-l-5" aria-hidden="true" ></i></button>
            </div>
        </div>
    </div>
</div>

@endsection
