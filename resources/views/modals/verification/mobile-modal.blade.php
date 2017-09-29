<div class="modal fnb-modal verification-step-modal mobile-modal contact-verification-modal fade" id="mobile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" modal-type="mobile">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">
                <div class="contact-verify-steps default-state">
                    <img src="/img/number-default.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Phone number verification</h6>
                    <p class="text-lighter x-small">Please enter the 4 digit code sent to your number via sms.</p>
                    <div class="number-code">
                        <div class="show-number flex-row space-between">
                            <div class="number contact-input-value">
                                9344556878
                            </div>
                            <a href="#" class="secondary-link edit-number"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT</a>
                        </div>
                        <div class="code-submit flex-row space-between">
                            <input type="password" class="fnb-input text-color otp-input" placeholder="Enter code here..." >
                            <button class="btn fnb-btn primary-btn border-btn code-send" type="button">Submit <i class="fa fa-circle-o-notch fa-spin hidden"></i></button>
                        </div>
                       <div class="validationError text-left"></div>
                    </div>
                </div>
                <div class="contact-verify-steps add-number hidden">
                    <img src="/img/number-add.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Please provide a new number for verification.</h6>
                    <div class="number-code">
                        <div class="code-submit flex-row space-between">
                            <input text="tel" class="fnb-input text-color value-enter change-contact-input contact-mpbile contact-mobile-input contact-mobile-number" data-parsley-length-message="Mobile number should be 10 digits." data-parsley-type="digits" data-parsley-length="[10, 10]"  placeholder="Enter new number..." data-parsley-errors-container="#phoneError">
                            <button class="btn fnb-btn primary-btn border-btn contact-verify-stuff" type="button">Verify</button>
                        </div>
                        <div id="phoneError" class="customError fnb-errors text-left"></div>
                    </div>
                </div>
                <div class="contact-verify-steps processing hidden">
                    <img src="/img/processing.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Please wait, we are verifying the code...</h6>
                </div>
                <div class="contact-verify-steps step-success hidden">
                    <img src="/img/number-sent.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Your number has been verified successfully!</h6>
                    <div class="number-code">
                        <button class="btn fnb-btn outline border-btn" type="button" data-dismiss="modal">Continue</button>
                    </div>
                </div>
                <div class="contact-verify-steps step-failure hidden">
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