<!-- Edit current Number i.e. add new number -->
<div class="modal fnb-modal new-mobile-modal modal-center fade" id="new-mobile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" modal-type="mobile">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button> -->
                <button class="close" data-dismiss="" aria-label="Close" id="close-new-mobile-modal"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">
                <div class="contact-verify-steps add-number">
                    <img src="/img/number-add.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Please provide a new number for verification.</h6>
                    <div class="number-code verifySection">
                        <div class="code-submit flex-row space-between new-verify-number">
                            <input type="tel" class="fnb-input text-color value-enter change-contact-input contact-mpbile contact-mobile-input contact-mobile-number" data-parsley-length-message="Mobile number should be 10 digits." data-parsley-type="digits" data-parsley-length="[10, 10]"  placeholder="Enter new number..." data-parsley-errors-container="#phoneError" name="contact">
                            <button class="btn fnb-btn primary-btn border-btn contact-verify-stuff" type="button" id="new-mobile-verify-btn">Verify</button>
                        </div>
                        <div id="phoneError" class="customError fnb-errors text-left"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>