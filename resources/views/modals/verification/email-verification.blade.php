<div class="m-t-20 business-email business-contact contact-info contact-info-email" contact-type="email">
    <div class="flex-row space-between mobile-sp-row">
        <label class="label-size">Enter your business email address </label>
        <a href="#" class="dark-link text-medium add-another">+ Add another email</a>
    </div>
    @if($contactEmail)
    @foreach($contactEmail as $email)
    <div class="contact-row m-t-5 contact-container">
        <div class="row no-m-b get-val ">
            <div class="col-sm-5">
                <input type="hidden" class="contact_email_id contact-id" readonly value="{{ $email['id'] }}"  name="contact_email_id[]">

                <input type="email" class="form-control fnb-input p-l-5 contact-input" value="{{ $email['email'] }}" name="contact_email[]" data-parsley-type-message="Please enter a valid email." data-parsley-type="email"  @if($email['verified']) readonly @endif>
                <div class=dupError ></div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                @if($email['verified'])
                    <span class="fnb-icons verified-icon"></span><p class="c-title">Verified</p>
                @else
                    <a href="javascript:void(0)" class="dark-link contact-verify-link">Verify now</a>
                @endif
                    <input type="checkbox" name="verified_contact" class="hidden" readonly="">
                </div>
            </div>
            <div class="col-sm-4 col-xs-8">
                <div class="flex-row close-section">
                    <div class="verified-toggle flex-row">
                        <div class="toggle m-l-10 m-r-10">
                            <input type="checkbox" class="toggle__check"  data-parsley-multiple="contacts" @if($email['visible']) checked @endif data-parsley-errors-container="#toggleError">
                            <b class="switch"></b>
                            <b class="track"></b>

                            <input type="hidden" class="contact-visible" name="visible_email_contact[]" value="{{ $email['visible'] }}">
                        </div>
                        <p class="m-b-0 text-color toggle-state">@if($email['visible']) Visible on the listing @else Not visible on the listing @endif</p>
                    </div>
                     <i class="fa fa-times removeRow delete-contact"></i>
                </div>
                <div id="toggleError"></div>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="contact-row m-t-5 contact-container">
        <div class="row no-m-b get-val ">
            <div class="col-sm-5">
                <input type="hidden" class="contact_email_id contact-id" readonly value=""  name="contact_email_id[]">
                <input type="email" class="form-control fnb-input p-l-5 contact-input" value="" name="contact_email[]" data-parsley-type-message="Please enter a valid email." data-parsley-type="email" >
                <div class=dupError ></div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                    <a href="javascript:void(0)" class="dark-link contact-verify-link">Verify now</a>
                    <input type="checkbox" name="verified_contact" class="hidden" readonly="">
                </div>
            </div>
            <div class="col-sm-4 col-xs-8">
                <div class="flex-row close-section">
                    <div class="verified-toggle flex-row">
                        <div class="toggle m-l-10 m-r-10">
                            <input type="checkbox" class="toggle__check" data-parsley-multiple="contacts"  data-parsley-errors-container="#toggleError">
                            <b class="switch"></b>
                            <b class="track"></b>
                            <input type="hidden" class="contact-visible" name="visible_email_contact[]" value="0">
                        </div>
                        <p class="m-b-0 text-color toggle-state">  Not visible on the listing </p>
                    </div>
                     <i class="fa fa-times removeRow delete-contact"></i>
                </div>
                <div id="toggleError"></div>
            </div>
        </div>
    </div>
    @endif

   
    <div class="contact-row m-t-5 contact-group contact-container hidden">
        <div class="row no-m-b get-val ">
            <div class="col-sm-5">
                <input type="hidden" class="contact_email_id contact-id" readonly value=""  name="contact_email_id[]">
                <input type="email" class="form-control fnb-input p-l-5 contact-input" value="" name="contact_email[]" data-parsley-type-message="Please enter a valid email." data-parsley-type="email" >
                <div class=dupError ></div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                    <a href="javascript:void(0)" class="dark-link contact-verify-link">Verify now</a>
                    <input type="checkbox" name="verified_contact" class="hidden" style="visibility: hidden;" readonly="">
                </div>
            </div>
            <div class="col-sm-4 col-xs-8">
                <div class="flex-row close-section">
                    <div class="verified-toggle flex-row">
                        <div class="toggle m-l-10 m-r-10">
                            <input type="checkbox" class="toggle__check" data-parsley-multiple="contacts" data-parsley-errors-container="#toggleError">
                            <b class="switch"></b>
                            <b class="track"></b>
                            <input type="hidden" class="contact-visible" name="visible_email_contact[]" value="0">
                        </div>
                        <p class="m-b-0 text-color toggle-state">Not visible on the listing</p>
                    </div>
                    <i class="fa fa-times removeRow delete-contact"></i>
                </div>
                <div id="toggleError"></div>
            </div>
        </div>
    </div>
</div>