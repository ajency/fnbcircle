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
                <input value="11" type="radio" class="radio" name="business_type" data-parsley-multiple="listing_type" data-parsley-errors-container="#errorfield">
                <div class="wholesaler option flex-row">
                    <span class="fnb-icons business-icon wholesaler"></span>
                    <i class="fa fa-check"></i>
                </div>
                <div class="business-label">
                    Wholesaler
                </div>
            </li>
            <li>
                <input value="12" type="radio" class="radio" name="business_type" data-parsley-multiple="listing_type" data-parsley-errors-container="#errorfield">
                <div class="retailer option flex-row">
                    <span class="fnb-icons business-icon retailer"></span>
                    <i class="fa fa-check"></i>
                </div>
                <div class="business-label">
                    Retailer
                </div>
            </li>
            <li>
                <input value="13" type="radio" class="radio" name="business_type" data-parsley-multiple="listing_type" data-parsley-required data-parsley-errors-container="#errorfield">
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
                        <input name="primary_email" type="checkbox" class="toggle__check" checked="true" data-parsley-multiple="contacts" data-parsley-mincheck="1" required>
                        <b class="switch"></b>
                        <b class="track"></b>
                    </div>
                    <p class="m-b-0 text-color toggle-state">Visible on the listing</p>
                </div>
            </div>
        </div>
        <div class="row p-t-10 p-b-10 no-m-b get-val contact-group hidden">
            <div class="col-sm-5">
                <input type="hidden" class="comm-id" readonly  name="contact_IDs">
                <input type="email" class="form-control fnb-input p-l-5" value="" name="contacts" data-parsley-type="email">
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
        <a href="#" class="dark-link text-medium add-another">+ Add another email</a>
    </div>

    <!-- phone number -->

    <div class="m-t-40 business-phone business-contact">
        <label>Enter your business phone number <span class="text-primary">*</span></label>
        <div class="row p-t-10 p-b-10 phone-row get-val ">
            <div class="col-sm-5">
                <div class="input-row">
                    <input type="hidden" class="comm-id" readonly  name="contact_IDs">
                    <input type="tel" class="form-control fnb-input p-l-5" value="9344567888" name="contacts" data-parsley-type="digits" data-parsley-length="[10, 10]" data-parsley-required>
                    <i class="fa fa-mobile" aria-hidden="true"></i>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                    <!-- <span class="fnb-icons verified-icon"></span>
                    <p class="c-title">Verified</p> -->
                    <input type="checkbox" class="hidden" name="verified_contact" style="visibility: hidden;" readonly="">
                    <a href="#" class="dark-link verify-link">Verify now</a>
                </div>
            </div>
            <div class="col-sm-4 col-xs-8">
                <div class="verified-toggle no-m-t flex-row">
                    <div class="toggle m-l-10 m-r-10">
                        <input type="checkbox" class="toggle__check" name="visible_contact" data-parsley-multiple="contacts">
                        <b class="switch"></b>
                        <b class="track"></b>
                    </div>
                    <p class="m-b-0 text-color toggle-state">Not visible on the listing</p>
                </div>
            </div>
        </div>
        <div class="row p-t-10 p-b-10 no-m-b contact-group get-val  hidden">
            <div class="col-sm-5">

                <input type="hidden" class="comm-id" readonly  name="contact_IDs">

                <div class="input-row">
                    <input type="tel" class="form-control fnb-input p-l-5" value="" name="contacts" data-parsley-type="digits" data-parsley-length="[10, 11]">
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
        <a href="#" class="dark-link text-medium add-another">+ Add another phone number</a>
    </div>

    <!-- landline -->

    <div class="m-t-10 business-phone landline business-contact">
        <div class="row p-t-10 p-b-10 phone-row get-val ">
            <div class="col-sm-5">
            <input type="hidden" readonly class="comm-id" name="contact_IDs">
                <div class="input-row">
                    <input type="tel" class="form-control fnb-input p-l-5" value="0832234234" name="contacts" data-parsley-type="digits" data-parsley-length="[10, 12]" data-parsley-required>
                    <i class="fa fa-phone" aria-hidden="true"></i>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 mobile-hide">
                
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="verified-toggle no-m-t flex-row">
                    <div class="toggle m-l-10 m-r-10">
                        <input type="checkbox" class="toggle__check" name="visible_contact" data-parsley-multiple="contacts">
                        <b class="switch"></b>
                        <b class="track"></b>
                    </div>
                    <p class="m-b-0 text-color toggle-state">Not visible on the listing</p>
                </div>
            </div>
        </div>
        <div class="row p-t-10 p-b-10 no-m-b contact-group get-val  hidden">
            <div class="col-sm-5">
                <input type="hidden" readonly class="comm-id"  name="contact_IDs">
                <div class="input-row">
                    <input type="tel" class="form-control fnb-input p-l-5" value="" name="contacts" data-parsley-type="digits" data-parsley-length="[10, 12]" >
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