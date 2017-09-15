@extends('layouts.add-job')
@section('js')
    @parent
    <script type="text/javascript" src="/js/jobs.js"></script>
@endsection
@section('form-data')


@if(Session::has('success_message')) 
<div class="alert fnb-alert alert-success alert-dismissible fade in " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
   {{ Session::get('success_message')}}
</div>
 @endif 
 
<input type="hidden" name="_method" value="PUT">
<input type="hidden" name="step" value="step-two">
 
 

<div class="business-info tab-pane fade in active" id="company_details">
 
    <!-- <h5 class="no-m-t fly-out-heading-size main-heading white m-t-0 margin-btm ">Job Information</h5> -->
    <h5 class="no-m-t main-heading  white m-t-0 margin-btm">Company Details</h5>

    <!-- Job title/category -->

    
    <!-- Company logo -->

    <div class="m-t-40 c-gap">
        <div class="J-company flex-row">
            <div class="J-company__logo">
                <input type="file" class="comp-logo" data-height="100" />
            </div>
            <div class="J-company__name">
                <label class="label-size required">Name of your company?</label>
                <input type="text" name="company_name" class="form-control fnb-input" placeholder="" value="{{ $jobCompany['title'] }}" data-parsley-required-message="Please enter the company name." data-parsley-required data-parsley-maxlength=255 data-parsley-maxlength-message="company name cannot be more than 255 characters." data-parsley-required data-parsley-minlength=2 data-parsley-minlength-message="company name cannot be less than 2 characters."> 
                <input type="hidden" name="company_id" value="{{ $jobCompany['id'] }}">  
            </div>
        </div>
    </div>
    
    <!-- Company desc -->

    <div class="m-t-40 c-gap">
        <label class="label-size">Describe your company in brief <span class="text-lighter">(optional)</span>:</label>
 
         <textarea class="form-control fnb-input" name="company_description" id="editor" placeholder="Enter a brief summary of the Job" >{{ $jobCompany['description'] }} </textarea>
    </div>

    <!-- Company website -->

    <div class="m-t-40 c-gap">
        <label class="label-size">Does your company have a website? <span class="text-lighter">(optional)</span>:</label>
        <input type="text" name="company_website" data-parsley-type="url" class="form-control fnb-input" placeholder="http://" value="{{ $jobCompany['website'] }}">  
    </div>


    <div class="m-t-40 flex-row c-gap">
        <div class="m-r-10 no-m-l">
            <label class="element-title">Contact Details</label>
            <div class="text-lighter">
                Seekers would like to contact you or send enquiries. Please share your contact details below. We have pre-populated your email and phone number from your profile details.
            </div>
        </div>
        <span class="fnb-icons contact mobile-hide"></span>
        <!-- <img src="img/enquiry.png" class="mobile-hide"> -->
        <input type="hidden" name="object_type" value="job">
        <input type="hidden" name="object_id" value="{{ $job->id}}">
    </div>

    <!-- email -->

    <div class="m-t-20 business-email business-contact contact-info" contact-type="email">
        <div class="flex-row space-between mobile-sp-row">
            <label class="label-size">Enter your business email address <span class="text-primary">*</span></label>
            <a href="#" class="dark-link text-medium add-another">+ Add another email</a>
        </div>
        <div class="contact-row m-t-5 contact-container">
            <div class="row no-m-b">
                <div class="col-sm-5">
                    <input type="email" class="form-control fnb-input p-l-5 contact-input" value="">
                </div>
                <div class="col-sm-3 col-xs-4">
                    <div class="verified flex-row">
                        <a href="#" class="dark-link verify-link">Verify now</a>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <div class="verified-toggle flex-row">
                        <div class="toggle m-l-10 m-r-10">
                            <input name="primary_email" type="checkbox" class="toggle__check" data-parsley-type-message="Please enter a valid email." data-parsley-type="email" data-parsley-required-message="Please enter a valid email.">
                            <b class="switch"></b>
                            <b class="track"></b>
                        </div>
                        <p class="m-b-0 text-color toggle-state">Visible on the listing</p>
                    </div>
                    <div id="toggleError" class="visible-error"></div>
                </div>
            </div>
        </div>
        
 
       
        <div class="contact-row m-t-5 contact-group hidden">
            <div class="row no-m-b get-val ">
                <div class="col-sm-5">
                    <input type="hidden" class="comm-id" readonly  name="contact_IDs">
                    <input type="email" class="form-control fnb-input p-l-5 contact-input" value="" name="primary_email" data-parsley-type-message="Please enter a valid email." data-parsley-type="email" data-parsley-required-message="Please enter a valid email.">
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
        </div>
    </div>

    <!-- phone number -->

    <div class="m-t-40 m-b-40 business-phone business-contact">
        <div class="flex-row space-between mobile-sp-row">
            <label class="label-size">Enter your business mobile number <span class="text-primary">*</span></label>
            <a href="#" class="dark-link text-medium add-another">+ Add another mobile number</a>
        </div>
        <div class="contact-row m-t-5">
            <div class="row phone-row get-val ">
                <div class="col-sm-5">
                    <div class="input-row">
                        <input type="hidden" class="comm-id" readonly  name="contact_IDs">
                        <input type="tel" class="form-control fnb-input p-l-5" value="9344567888">
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
        </div>
      
     
        <div class="contact-row m-t-5 contact-group hidden">
            <div class="row no-m-b get-val phone-row ">
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
        </div>

    </div>

    <!-- landline -->
<!-- 
    <div class="m-t-40 m-b-40 business-phone landline business-contact">
        <div class="flex-row space-between mobile-sp-row">
            <label class="label-size">Enter your business landline number <span class="text-primary">*</span></label>
            <a href="#" class="dark-link text-medium add-another">+ Add landline number</a>
        </div>
        
        
        <div class="contact-row m-t-5 contact-group hidden">
            <div class="row no-m-b phone-row get-val">
                <div class="col-sm-5">
                    <input type="hidden" readonly class="comm-id"  name="contact_IDs">
                    <div class="input-row">
                        <input type="tel" class="form-control fnb-input p-l-5" value="" name="contacts" data-parsley-length-message="Landline number should be 10 - 12 digits." data-parsley-required-message="Landline number should be 10-12 digits." data-parsley-type="digits" data-parsley-length="[10, 12]" >
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
        </div>
    </div> -->






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
                    <img src="/img/number-default.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Phone number verification</h6>
                    <p class="text-lighter x-small">Please enter the 4 digit code sent to your number via sms.</p>
                    <div class="number-code">
                        <div class="show-number flex-row space-between">
                            <div class="number">
                                9344556878
                            </div>
                            <a href="#" class="secondary-link edit-number"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT</a>
                        </div>
                        <div class="code-submit flex-row space-between">
                            <input type="password" class="fnb-input text-color" placeholder="Enter code here..." >
                            <button class="btn fnb-btn primary-btn border-btn code-send" type="button">Submit <i class="fa fa-circle-o-notch fa-spin hidden"></i></button>
                        </div>
                       <div class="validationError text-left"></div>
                    </div>
                </div>
                <div class="verify-steps add-number hidden">
                    <img src="/img/number-add.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Please provide a new number for verification.</h6>
                    <div class="number-code">
                        <div class="code-submit flex-row space-between">
                            <input text="tel" class="fnb-input text-color value-enter" placeholder="Enter new number..." data-parsley-errors-container="#phoneError">
                            <button class="btn fnb-btn primary-btn border-btn verify-stuff" type="button">Verify</button>
                        </div>
                        <div id="phoneError" class="customError"></div>
                    </div>
                </div>
                <div class="verify-steps processing hidden">
                    <img src="/img/processing.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Please wait, we are verifying the code...</h6>
                </div>
                <div class="verify-steps step-success hidden">
                    <img src="/img/number-sent.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Your number has been verified successfully!</h6>
                    <div class="number-code">
                        <button class="btn fnb-btn outline border-btn" type="button" data-dismiss="modal">Continue</button>
                    </div>
                </div>
                <div class="verify-steps step-failure hidden">
                    <i class="fa fa-exclamation-triangle text-danger failIcon"></i>
                    <h6 class="sub-title">Validation Failed. Please Try Again</h6>
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
                    <img src="/img/email-default.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Email verification</h6>
                    <p class="text-lighter x-small">Please enter the 4 digit code sent to your email address.</p>
                    <div class="number-code">
                        <div class="show-number flex-row space-between">
                            <div class="number">
                                Qureshi@gmail.com
                            </div>
                            <a href="#" class="secondary-link edit-number"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT</a>
                        </div>
                        <div class="code-submit flex-row space-between">
                            <input text="text" class="fnb-input text-color" placeholder="Enter code here..."  >
                            <button class="btn fnb-btn primary-btn border-btn code-send" type="button">Submit <i class="fa fa-circle-o-notch fa-spin"></i></button>
                        </div>
                        <div class="validationError text-left"></div>
                    </div>
                </div>
                <div class="verify-steps add-number hidden">
                    <img src="/img/email-add.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Please provide a new email for verification.</h6>
                    <div class="number-code">
                        <div class="code-submit flex-row space-between">
                            <input text="email" class="fnb-input text-color value-enter" placeholder="Enter new email..." data-parsley-errors-container="#customError">
                            <button class="btn fnb-btn primary-btn border-btn verify-stuff" type="button">Verify</button>
                        </div>
                        <div id="customError" class="customError"></div>
                    </div>
                </div>
                <div class="verify-steps processing hidden">
                    <img src="/img/email-processing.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Please wait, we are verifying the code...</h6>
                </div>
                <div class="verify-steps step-success hidden">
                    <img src="/img/email-sent.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Your email has been verified successfully!</h6>
                    <div class="number-code">
                        <button class="btn fnb-btn outline border-btn" type="button" data-dismiss="modal">Continue</button>
                    </div>
                </div>
                <div class="verify-steps step-failure hidden">
                    <i class="fa fa-exclamation-triangle text-danger failIcon"></i>
                    <h6 class="sub-title">Validation Failed. Please try again</h6>
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
