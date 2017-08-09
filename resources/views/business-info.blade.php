@extends('add-listing')

@section('form-data')

<!-- failure message-->

<div class="alert fnb-alert alert-failure alert-dismissible fade in hidden" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    Oh snap! You got an error! Please check all the required fields.
</div>


<div class="business-info tab-pane fade in active" id="add_listing">
    <h5 class="no-m-t fly-out-heading-size">Business Information</h5>
    <div class="m-t-30 c-gap">
        <label>Tell us the name of your business <span class="text-primary">*</span></label>
        <input type="text" name="listing_title" class="form-control fnb-input" placeholder="" value="{{ old('title', $listing->title)}}" data-parsley-required-message="Business title is mandatory." data-parsley-required data-parsley-maxlength=255 data-parsley-maxlength-message="Business title cannot be more than 255 characters.">
        <div class="text-lighter m-t-5">
            This will be the display name of your listing.
        </div>
    </div>
    <div class="m-t-50 c-gap">
        <label>Who are you? <span class="text-primary">*</span></label>
        <ul class="business-type flex-row m-t-15">
            <li>
                <input value="11" type="radio" class="radio" name="business_type" data-parsley-multiple="listing_type" data-parsley-required-message="Business type is mandatory." data-parsley-errors-container="#errorfield" @if($listing->type=='11') checked=checked @endif>
                <div class="wholesaler option flex-row">
                    <span class="fnb-icons business-icon wholesaler"></span>
                    <i class="fa fa-check"></i>
                </div>
                <div class="business-label">
                    Wholesaler
                </div>
            </li>
            <li>
                <input value="12" type="radio" class="radio" name="business_type" data-parsley-multiple="listing_type" data-parsley-required-message="Business type is mandatory." data-parsley-errors-container="#errorfield" @if($listing->type=='12') checked=checked @endif>
                <div class="retailer option flex-row">
                    <span class="fnb-icons business-icon retailer"></span>
                    <i class="fa fa-check"></i>
                </div>
                <div class="business-label">
                    Retailer
                </div>
            </li>
            <li>
                <input value="13" type="radio" class="radio" name="business_type" data-parsley-multiple="listing_type" data-parsley-required-message="Business type is mandatory." data-parsley-required data-parsley-errors-container="#errorfield" @if($listing->type=='13') checked=checked @endif>
                <div class="manufacturer option flex-row">
                    <span class="fnb-icons business-icon manufacturer"></span>
                    <i class="fa fa-check"></i>
                </div>
                <div class="business-label">
                    Manufacturer
                </div>
            </li>
        </ul>
        <div id="errorfield"></div>
        <div class="text-lighter">
            The right business type will get you the right enquiries. A listing can be only of one type.
        </div>
    </div>
    <div class="m-t-40 c-gap">
        <label>Where is the business located?</label>
        <div class="location-select flex-row flex-wrap">
            <div class="select-col city">
                <select class="fnb-select select-variant form-control text-lighter">
                    <option>Select city</option>
                    <option>Mumbai</option>
                    <option>Delhi</option>
                    <option>Goa</option>
                </select>
            </div>
            <div class="select-col area">
                <select class="fnb-select select-variant form-control text-lighter">
                    <option>Select area</option>
                    <option>Dadar</option>
                    <option>Bandra</option>
                    <option>Borivili</option>
                </select>
            </div>
        </div>
    </div>
    <div class="m-t-20 flex-row c-gap">
        <span class="fnb-icons contact mobile-hide"></span>
        <!-- <img src="img/enquiry.png" class="mobile-hide"> -->
        <div class="m-l-10 no-m-l">
            <label>Contact Details</label>
            <div class="text-lighter">
                Seekers would like to contact you or send enquiries. Please share your contact details below. We have pre-populated your email and phone number from your profile details.
            </div>
        </div>
    </div>

    <!-- email -->
    
    <div class="m-t-20 business-email business-contact">
        <label>Enter your business email address <span class="text-primary">*</span></label>
        <div class="row p-t-10 p-b-10 no-m-b">
            <div class="col-sm-5">
                <input type="email" class="form-control fnb-input p-l-5" value="quershi@gmail.com" readonly=""  data-parsley-required>
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
                        <input name="primary_email" type="checkbox" class="toggle__check" data-parsley-errors-container="#toggleError" data-parsley-multiple="contacts" data-parsley-required-message="At least one contact detail either email or phone number should be visible on the listing." data-parsley-mincheck="1" required  @if($listing->show_primary_email === null or $listing->show_primary_email == "1") checked="true" @endif>
                        <b class="switch"></b>
                        <b class="track"></b>
                    </div>
                    <p class="m-b-0 text-color toggle-state"> @if($listing->show_primary_email === null or $listing->show_primary_email == "1")  Visible on the listing @else Not Visible on the listing @endif</p>
                </div>
                <div id="toggleError"></div>
            </div>
        </div>
        @foreach($emails as $email)
        <div class="row p-t-10 p-b-10 no-m-b get-val ">
            <div class="col-sm-5">
                <input type="hidden" class="comm-id" readonly  name="contact_IDs" value="{{$email->id}}">
                <input type="email" class="form-control fnb-input p-l-5" value="{{$email->value}}" name="contacts" data-parsley-required-message="Please enter a valid email." data-parsley-type-message="Please enter a valid email." data-parsley-type="email" @if($email->is_verified==1) readonly @endif>
                <div class=dupError ></div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                    @if($email->is_verified==1)
                    <span class="fnb-icons verified-icon"></span>
                    <p class="c-title">Verified</p>
                    <input type="checkbox" name="verified_contact" class="hidden" style="visibility: hidden;" readonly="" checked>
                    @else
                    <a href="#" class="dark-link verify-link">Verify now</a>
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
                        </div>
                        <p class="m-b-0 text-color toggle-state">@if($email->is_visible==1) Visible on the listing @else Not visible on the listing @endif </p>
                    </div>
                    <i class="fa fa-times removeRow"></i>
                </div>
                <div id="toggleError"></div>
            </div>
        </div>
        @endforeach
        <div class="row p-t-10 p-b-10 no-m-b get-val contact-group hidden">
            <div class="col-sm-5">
                <input type="hidden" class="comm-id" readonly  name="contact_IDs">
                <input type="email" class="form-control fnb-input p-l-5" value="" name="contacts" data-parsley-type-message="Please enter a valid email." data-parsley-type="email" data-parsley-required-message="Please enter a valid email.">
                <div class=dupError ></div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                    <a href="#" class="dark-link verify-link">Verify now</a>
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
                        </div>
                        <p class="m-b-0 text-color toggle-state">Not visible on the listing</p>
                    </div>
                    <i class="fa fa-times removeRow"></i>
                </div>
                <div id="toggleError"></div>
            </div>
        </div>
        <a href="#" class="dark-link text-medium add-another">+ Add another email</a>
    </div>

    <!-- phone number -->

    <div class="m-t-40 business-phone business-contact">
        <label>Enter your business phone number <span class="text-primary">*</span></label>
        @if($listing->reference===null)
        <div class="row p-t-10 p-b-10 phone-row get-val ">
            <div class="col-sm-5">
                <div class="input-row">
                    <input type="hidden" class="comm-id" readonly  name="contact_IDs">
                    <input type="tel" class="form-control fnb-input p-l-5" value="9344567888" name="contacts" data-parsley-type="digits" data-parsley-length="[10, 10]" data-parsley-required>
                    <div class=dupError ></div>
                    <i class="fa fa-mobile" aria-hidden="true"></i>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                    
                    <a href="#" class="dark-link verify-link">Verify now</a>
                    <input type="checkbox" name="verified_contact" class="hidden" style="visibility: hidden;" readonly="">
                   
                </div>
            </div>
            <div class="col-sm-4 col-xs-8">
                <div class="verified-toggle no-m-t flex-row">
                    <div class="toggle m-l-10 m-r-10">
                        <input type="checkbox" class="toggle__check" name="visible_contact" data-parsley-multiple="contacts" data-parsley-errors-container="#toggleError">
                        <b class="switch"></b>
                        <b class="track"></b>
                    </div>
                    <p class="m-b-0 text-color toggle-state">Not visible on the listing</p>
                </div>
                <div id="toggleError"></div>
            </div>
        </div>
        @endif
        @foreach ($mobiles as $mobile)
        <div class="row p-t-10 p-b-10 no-m-b get-val phone-row">
            <div class="col-sm-5">

                <input type="hidden" class="comm-id" readonly  name="contact_IDs" value="{{$mobile->id}}">

                <div class="input-row">
                    <input type="tel" class="form-control fnb-input p-l-5" value="{{$mobile->value}}" name="contacts" data-parsley-length-message="Mobile number should be 10 digits." data-parsley-required-message="Mobile number should be 10 digits." data-parsley-type="digits" data-parsley-length="[10, 10]" @if($mobile->is_verified==1) readonly @endif>
                    <div class=dupError ></div>
                     <i class="fa fa-mobile" aria-hidden="true"></i>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                    @if($mobile->is_verified==1)
                    <span class="fnb-icons verified-icon"></span>
                    <p class="c-title">Verified</p>
                    <input type="checkbox" name="verified_contact" class="hidden" style="visibility: hidden;" readonly="" checked>
                    @else
                    <a href="#" class="dark-link verify-link">Verify now</a>
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
                        </div>
                        <p class="m-b-0 text-color toggle-state">@if($mobile->is_visible==1) Visible on the listing @else Not visible on the listing @endif </p>
                    </div>
                    @if (!$loop->first)<i class="fa fa-times removeRow"></i>@endif
                </div>
                <div id="toggleError"></div>
            </div>
        </div>
        @endforeach
        <div class="row p-t-10 p-b-10 no-m-b contact-group get-val phone-row hidden">
            <div class="col-sm-5">

                <input type="hidden" class="comm-id" readonly  name="contact_IDs">

                <div class="input-row">
                    <input type="tel" class="form-control fnb-input p-l-5" value="" name="contacts" data-parsley-length-message="Mobile number should be 10 digits." data-parsley-type="digits" data-parsley-length="[10, 10]" data-parsley-required-message="Mobile number should be 10 digits.">
                    <div class=dupError ></div>
                     <i class="fa fa-mobile" aria-hidden="true"></i>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                    <input type="checkbox" class="hidden" name="verified_contact" style="visibility: hidden;" readonly="">
                    <a href="#" class="dark-link verify-link">Verify now</a>
                </div>
            </div>
            <div class="col-sm-4 col-xs-8">
                <div class="flex-row close-section">
                    <div class="verified-toggle flex-row">
                        <div class="toggle m-l-10 m-r-10">
                            <input type="checkbox" class="toggle__check" name="visible_contact" data-parsley-multiple="contacts" data-parsley-errors-container="#toggleError">
                            <b class="switch"></b>
                            <b class="track"></b>
                        </div>
                        <p class="m-b-0 text-color toggle-state">Not visible on the listing</p>
                    </div>
                    <i class="fa fa-times removeRow"></i>
                </div>
                <div id="toggleError"></div>
            </div>
        </div>
        <a href="#" class="dark-link text-medium add-another">+ Add another phone number</a>
    </div>

    <!-- landline -->

    <div class="m-t-10 business-phone landline business-contact">
        @foreach($phones as $phone)
        <div class="row p-t-10 p-b-10 no-m-b phone-row get-val ">
            <div class="col-sm-5">
                <input type="hidden" readonly class="comm-id"  name="contact_IDs" value="{{$phone->id}}">
                <div class="input-row">
                    <input type="tel" class="form-control fnb-input p-l-5" value="{{$phone->value}}" name="contacts" data-parsley-length-message="Landline number should be 10 - 12 digits." data-parsley-type="digits" data-parsley-length="[10, 12]" @if($phone->is_verified==1) readonly @endif>
                    <div class=dupError ></div>
                    <i class="fa fa-phone" aria-hidden="true"></i>
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
                    @if (!$loop->first)<i class="fa fa-times removeRow"></i>@endif
                </div>
                <div id="toggleError"></div>
            </div>
        </div>
        @endforeach
        <div class="row p-t-10 p-b-10 no-m-b phone-row contact-group get-val  hidden">
            <div class="col-sm-5">
                <input type="hidden" readonly class="comm-id"  name="contact_IDs">
                <div class="input-row">
                    <input type="tel" class="form-control fnb-input p-l-5" value="" name="contacts" data-parsley-length-message="Mobile number should be 10 digits." data-parsley-length-message="Landline number should be 10-12 digits." data-parsley-type="digits" data-parsley-length="[10, 12]" >
                    <div class=dupError ></div>
                    <i class="fa fa-phone" aria-hidden="true"></i>
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
        <a href="#" class="dark-link text-medium add-another">+ Add another landline number</a>
    </div>
</div>


<!-- Phone verification -->

<div class="modal fnb-modal verification-step-modal phone-modal fade" id="phone-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">
                <div class="verify-steps default-state">
                    <img src="../../img/number-default.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Phone number verification</h6>
                    <p class="text-lighter x-small">Please enter the 6 digit code sent to your number via sms.</p>
                    <div class="number-code">
                        <div class="show-number flex-row space-between">
                            <div class="number">
                                9344556878
                            </div>
                            <a href="#" class="secondary-link edit-number"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT</a>
                        </div>
                        <div class="code-submit flex-row space-between">
                            <input text="text" class="fnb-input text-color" placeholder="Enter code here...">
                            <button class="btn fnb-btn primary-btn border-btn code-send" type="button">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="verify-steps add-number hidden">
                    <img src="../../img/number-add.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Please provide a new number for verification.</h6>
                    <div class="number-code">
                        <div class="code-submit flex-row space-between">
                            <input text="tel" class="fnb-input text-color value-enter" placeholder="Enter new number...">
                            <button class="btn fnb-btn primary-btn border-btn verify-stuff" type="button">Verify</button>
                        </div>
                    </div>
                </div>
                <div class="verify-steps processing hidden">
                    <img src="../../img/processing.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Please wait, we are verifying the code...</h6>
                </div>
                <div class="verify-steps step-success hidden">
                    <img src="../../img/number-sent.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Your number has been verified successfully!</h6>
                    <div class="number-code">
                        <button class="btn fnb-btn outline border-btn" type="button" data-dismiss="modal">Continue</button>
                    </div>
                </div>
                <div class="verify-steps step-failure hidden">
                    <img src="../../img/number-sent.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Some problem occurred!!!</h6>
                    <div class="number-code">
                        <button class="btn fnb-btn outline border-btn" type="button" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer verificationFooter">
                <div class="resend-code sub-title text-color">
                    Didn't receive the code? <a href="#" class="secondary-link resend-link"><span class="resent-title"><i class="fa fa-repeat" aria-hidden="true"></i> Resend SMS</span>
                    <span class="send-title"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i>Sending...</span></a>
                </div>
                <a href="#" class="step-back primary-link"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
        </div>
    </div>
</div>

<!-- Email verification -->


<div class="modal fnb-modal verification-step-modal email-modal fade" id="email-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">
                <div class="verify-steps default-state">
                    <img src="../../img/email-default.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Email verification</h6>
                    <p class="text-lighter x-small">Please enter the 6 digit code sent to your email address.</p>
                    <div class="number-code">
                        <div class="show-number flex-row space-between">
                            <div class="number">
                                Qureshi@gmail.com
                            </div>
                            <a href="#" class="secondary-link edit-number"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT</a>
                        </div>
                        <div class="code-submit flex-row space-between">
                            <input text="text" class="fnb-input text-color" placeholder="Enter code here...">
                            <button class="btn fnb-btn primary-btn border-btn code-send" type="button">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="verify-steps add-number hidden">
                    <img src="../../img/email-add.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Please provide a new email for verification.</h6>
                    <div class="number-code">
                        <div class="code-submit flex-row space-between">
                            <input text="email" class="fnb-input text-color value-enter" placeholder="Enter new email...">
                            <button class="btn fnb-btn primary-btn border-btn verify-stuff" type="button">Verify</button>
                        </div>
                    </div>
                </div>
                <div class="verify-steps processing hidden">
                    <img src="../../img/processing.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Please wait, we are verifying the code...</h6>
                </div>
                <div class="verify-steps step-success hidden">
                    <img src="../../img/number-sent.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Your email has been verified successfully!</h6>
                    <div class="number-code">
                        <button class="btn fnb-btn outline border-btn" type="button" data-dismiss="modal">Continue</button>
                    </div>
                </div>
                <div class="verify-steps step-failure hidden">
                    <img src="../../img/number-sent.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Some problem occurred!!!</h6>
                    <div class="number-code">
                        <button class="btn fnb-btn outline border-btn" type="button">Resend</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer verificationFooter">
                <div class="resend-code sub-title text-color">
                    Didn't receive the code? <a href="#" class="secondary-link resend-link"><span class="resent-title"><i class="fa fa-repeat" aria-hidden="true"></i> Resend email</span>
                    <span class="send-title"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i>Sending...</span></a>
                </div>
                <a href="#" class="step-back primary-link"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
        </div>
    </div>
</div>


@endsection