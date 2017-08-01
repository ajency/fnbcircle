@extends('add-listing')

@section('form-data')

<div class="business-info tab-pane fade in active" id="add_listing">
    <h5 class="no-m-t">Business Information</h5>
    <div class="m-t-30 c-gap">
        <label>Tell us the name of your business <span class="text-primary">*</span></label>
        <input type="text" name="listing_title" class="form-control fnb-input" placeholder="" data-parsley-required>
        <div class="text-lighter m-t-5">
            This will be the display name of your listing.
        </div>
    </div>
    <div class="m-t-50 c-gap">
        <label>Who are you? <span class="text-primary">*</span></label>
        <ul class="business-type flex-row m-t-15">
            <li>
                <input value="11" type="radio" class="radio" name="business_type" data-parsley-multiple="listing_type"  >
                <div class="wholesaler option flex-row">
                    <span class="fnb-icons business-icon wholesaler"></span>
                    <i class="fa fa-check"></i>
                </div>
                <div class="business-label">
                    Wholesaler
                </div>
            </li>
            <li>
                <input value="12" type="radio" class="radio" name="business_type" data-parsley-multiple="listing_type">
                <div class="retailer option flex-row">
                    <span class="fnb-icons business-icon retailer"></span>
                    <i class="fa fa-check"></i>
                </div>
                <div class="business-label">
                    Retailer
                </div>
            </li>
            <li>
                <input value="13" type="radio" class="radio" name="business_type" data-parsley-multiple="listing_type" data-parsley-required>
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
                <input type="number" style="visibility: hidden;" readonly value=1 name="contact_IDs">
                <input type="email" class="form-control fnb-input p-l-5" value="" name="contacts" data-parsley-type="email">
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                    <a href="#" class="dark-link" onclick="contact_submit(event);">Verify now</a>
                    <input type="checkbox" name="verified_contact" style="visibility: hidden;" readonly="">
                </div>
            </div>
            <div class="col-sm-4 col-xs-8">
                <div class="verified-toggle flex-row">
                    <div class="toggle m-l-10 m-r-10">
                        <input type="checkbox" class="toggle__check" name="visible_contact">
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
        <div class="row p-t-10 p-b-10 phone-row">
            <div class="col-sm-5">
            <!-- <input type="number" style="visibility: hidden;" readonly value=5 name="contact_IDs"> -->
                <input type="tel" class="form-control fnb-input p-l-5" value="9344567888" name="contacts" data-parsley-type="digits" data-parsley-length="[10, 11]">
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                    <!-- <span class="fnb-icons verified-icon"></span>
                    <p class="c-title">Verified</p> -->
                    <input type="checkbox" name="verified_contact" style="visibility: hidden;" readonly="">
                    <a href="#" class="dark-link" onclick="contact_submit(event);">Verify now</a>
                </div>
            </div>
            <div class="col-sm-4 col-xs-8">
                <div class="verified-toggle no-m-t flex-row">
                    <div class="toggle m-l-10 m-r-10">
                        <input type="checkbox" class="toggle__check" name="visible_contact">
                        <b class="switch"></b>
                        <b class="track"></b>
                    </div>
                    <p class="m-b-0 text-color toggle-state">Not visible on the listing</p>
                </div>
            </div>
        </div>
        <div class="row p-t-10 p-b-10 no-m-b contact-group hidden">
            <div class="col-sm-5">
                <input type="number" style="visibility: hidden;" readonly value=5 name="contact_IDs">
                <input type="tel" class="form-control fnb-input p-l-5" value="" name="contacts" data-parsley-type="digits" data-parsley-length="[10, 11]">
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                    <input type="checkbox" name="verified_contact" style="visibility: hidden;" readonly="">
                    <a href="#" class="dark-link" onclick="contact_submit(event);">Verify now</a>
                </div>
            </div>
            <div class="col-sm-4 col-xs-8">
                <div class="verified-toggle flex-row">
                    <div class="toggle m-l-10 m-r-10">
                        <input type="checkbox" class="toggle__check" name="visible_contact">
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
@endsection