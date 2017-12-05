<div id="emailError"></div>
<div class="m-t-20 business-email business-contact contact-info contact-info-email" contact-type="email">
    <div class="flex-row space-between mobile-sp-row">
        <label class="label-size">Enter your email address </label>
        <a href="#" class="dark-link text-medium add-another">+ Add another email</a>
    </div>
    @if(isset($is_listing) and $is_listing == true)
    @php
    $listing_owner = $listing->owner()->first();
    if($listing_owner!=null){
        $email = $listing_owner->getPrimaryEmail(true);    
    }else{
        $email = ['email' => "", 'is_verified' => 0];
    }
    @endphp
    <div class="contact-row m-t-5 contact-container">
        <div class="row no-m-b get-val ">
            <div class="col-sm-5">
                <input type="email" class="form-control fnb-input p-l-5" value="{{ $email['email'] }}" name="primary_email_txt" data-parsley-type-message="Please enter a valid email." data-parsley-type="email" readonly data-parsley-errors-container="#emailError0">
                <div class=dupError id="emailError0" ></div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                @if($email['is_verified'])
                    <span class="fnb-icons verified-icon"></span><p class="c-title">Verified</p>
                @endif
                </div>
            </div>
            <div class="col-sm-4 col-xs-8">
                <div class="verified-toggle flex-row">
                        <div class="toggle m-l-10 m-r-10">
                            <input name="primary_email" type="checkbox" class="toggle__check" data-parsley-errors-container="#emailError" data-parsley-multiple="contacts" data-parsley-required-message="At least one contact detail either email or phone number should be visible on the listing." data-parsley-mincheck="1" data-parsley-required @if(($listing->show_primary_email === null and $owner->type == 'external')  or $listing->show_primary_email == "1") checked="true" @endif>
                            <b class="switch"></b>
                            <b class="track"></b>
                        </div>
                        <p class="m-b-0 text-color toggle-state"> @if(($listing->show_primary_email === null and $owner->type == 'external') or $listing->show_primary_email == "1")  Visible  @else Not Visible  @endif</p>
                    </div>
                
            </div>
        </div>
    </div>
    @endif
    @php
    $key = 1;
    @endphp
    @if($contactEmail)
    @foreach($contactEmail as $email)
    <div class="contact-row m-t-5 contact-container">
        <div class="row no-m-b get-val ">
            <div class="col-sm-5">
                <input type="hidden" class="contact_email_id contact-id" readonly value="{{ $email['id'] }}"  name="contact_email_id[]">

                <input type="email" class="form-control fnb-input p-l-5 contact-input" value="{{ $email['email'] }}" name="contact_email[]" data-parsley-type-message="Please enter a valid email." data-parsley-type="email"  @if($email['verified']) readonly @endif data-parsley-errors-container="#emailError{{ $key }}">
                <div class=dupError id="emailError{{ $key }}" ></div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                @if($email['verified'])
                    <span class="fnb-icons verified-icon"></span><p class="c-title">Verified</p>
                @else
                    @if(Auth::user()->type == 'external') <a href="javascript:void(0)" class="dark-link contact-verify-link">Verify now</a> @endif
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
                        <p class="m-b-0 text-color toggle-state">@if($email['visible']) Visible  @else Not visible  @endif</p>
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
                <input type="email" class="form-control fnb-input p-l-5 contact-input" value="" name="contact_email[]" data-parsley-type-message="Please enter a valid email." data-parsley-type="email" data-parsley-errors-container="#emailError{{ $key }}">
                <div class=dupError id="emailError{{ $key }}" ></div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                    @if(Auth::user()->type == 'external') <a href="javascript:void(0)" class="dark-link contact-verify-link">Verify now</a> @endif
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
                        <p class="m-b-0 text-color toggle-state">  Not visible </p>
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
                <input type="email" class="form-control fnb-input p-l-5 contact-input" value="" name="contact_email[]" data-parsley-type-message="Please enter a valid email." data-parsley-type="email" data-parsley-errors-container="#emailError{{ ($key+1) }}" >
                <div class=dupError id="emailError{{ ($key+1) }}"></div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="verified flex-row">
                    @if(Auth::user()->type == 'external') <a href="javascript:void(0)" class="dark-link contact-verify-link">Verify now</a> @endif
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
                        <p class="m-b-0 text-color toggle-state">Not visible</p>
                    </div>
                    <i class="fa fa-times removeRow delete-contact"></i>
                </div>
                <div id="toggleError"></div>
            </div>
        </div>
    </div>
</div>