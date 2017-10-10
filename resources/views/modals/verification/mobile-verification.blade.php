<div class="m-t-40 m-b-40 business-phone business-contact contact-info contact-info-mobile" contact-type="mobile">
        <div class="flex-row space-between mobile-sp-row">
            <label class="label-size">Enter your mobile number</label>
            <a href="#" class="dark-link text-medium add-another">+ Add another mobile number</a>
        </div>
        @if(!empty($contactMobile))
        @foreach($contactMobile as $mobile)
        <div class="contact-row m-t-5 contact-container">
            <div class="row phone-row get-val ">
                <div class="col-sm-5">
                    <div class="input-row">
                        <input type="hidden" class="contact_mobile_id contact-id" readonly value="{{ $mobile['id'] }}"  name="contact_mobile_id[]">
                        
                        <input type="text" class="form-control fnb-input p-l-5 contact-input contact-mobile-input contact-mobile-number" name="contact_mobile[]" value="{{ $mobile['mobile']}}"  data-parsley-length-message="Mobile number should be 10 digits." data-parsley-type="digits" data-parsley-length="[10, 10]" @if($mobile['verified']) readonly @endif >

                        <input type="hidden" class="contact-country-code" name="contact_country_code[]" value="{{ $mobile['country_code']}}">
                        <div class="dupError" ></div>
                        <!-- <i class="fa fa-mobile" aria-hidden="true"></i>  -->
                    </div>
                </div>
                <div class="col-sm-3 col-xs-4">
                    <div class="verified flex-row">
                    @if($mobile['verified'])
                        <span class="fnb-icons verified-icon"></span><p class="c-title">Verified</p>
                    @else
                        <a href="javascript:void(0)" class="dark-link contact-verify-link">Verify now</a>
                    @endif
                        <input type="checkbox" name="verified_contact" class="hidden" style="visibility: hidden;" readonly="">

                    </div>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <div class="flex-row close-section">
                        <div class="verified-toggle flex-row">
                            <div class="toggle m-l-10 m-r-10">
                                <input type="checkbox" class="toggle__check"  @if($mobile['visible']) checked @endif   data-parsley-multiple="contacts" data-parsley-errors-container="#toggleError">
                                <b class="switch"></b>
                                <b class="track"></b>
                                <input type="hidden" class="contact-visible" name="visible_mobile_contact[]" value="{{ $mobile['visible'] }}">
                            </div>
                            <p class="m-b-0 text-color toggle-state">@if($mobile['visible']) Visible on the applicant @else Not visible on the applicant @endif  </p>
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
            <div class="row phone-row get-val ">
                <div class="col-sm-5">
                    <div class="input-row test">
                        <input type="hidden" class="contact_mobile_id contact-id" readonly value=""  name="contact_mobile_id[]">
                        <input type="text" class="form-control fnb-input p-l-5 contact-input contact-mobile-input contact-mobile-number"  name="contact_mobile[]" data-parsley-length-message="Mobile number should be 10 digits." data-parsley-type="digits" data-parsley-length="[10, 10]" data-parsley-length-message="Mobile number should be 10 digits." data-parsley-errors-container="#phoneerror">
                        <input type="hidden" class="contact-country-code" name="contact_country_code[]" value="">
                        <div class="dupError" id="phoneerror"></div>
                        <!-- <i class="fa fa-mobile" aria-hidden="true"></i> -->
                    </div>
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
                                <input type="checkbox" class="toggle__check"  data-parsley-multiple="contacts" data-parsley-errors-container="#toggleError"   >
                                <b class="switch"></b>
                                <b class="track"></b>
                                <input type="hidden" class="contact-visible" name="visible_mobile_contact[]" value="0">
                            </div>
                            <p class="m-b-0 text-color toggle-state">Not visible on the applicant</p>
                        </div>
                        <i class="fa fa-times removeRow delete-contact"></i>
                    </div>
                    <div id="toggleError"></div>
                </div>
      
            </div>
        </div>
        @endif
     
        <div class="contact-row m-t-5 contact-group hidden contact-container">
            <div class="row no-m-b get-val phone-row">
                <div class="col-sm-5">

                    <input type="hidden" class="contact-id" readonly  name="contact_mobile_id[]">
                    <input type="hidden" class="id-generator"></input>
                    <div class="input-row">
                        <input type="tel" class="form-control fnb-input p-l-5 contact-input contact-mobile-input" value="" name="contact_mobile[]" data-parsley-length-message="Mobile number should be 10 digits." data-parsley-type="digits" data-parsley-length="[10, 10]"  data-parsley-errors-container="#phoneerror-re">
                        <input type="hidden" class="contact-country-code" name="contact_country_code[]" value="">
                        <div class="dupError" id="phoneerror-re"></div>
                         <!-- <i class="fa fa-mobile" aria-hidden="true"></i> -->
                    </div>
                </div>
                <div class="col-sm-3 col-xs-4">
                    <div class="verified flex-row">
                        <input type="checkbox" class="hidden" name="verified_contact" style="visibility: hidden;" readonly="">
                        <a href="javascript:void(0)" class="dark-link contact-verify-link">Verify now</a>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <div class="flex-row close-section">
                        <div class="verified-toggle flex-row">
                            <div class="toggle m-l-10 m-r-10">
                                <input type="checkbox" class="toggle__check"  data-parsley-multiple="contacts" data-parsley-errors-container="#toggleError">
                                <b class="switch"></b>
                                <b class="track"></b>
                                <input type="hidden" class="contact-visible" name="visible_mobile_contact[]" value="0">
                            </div>
                            <p class="m-b-0 text-color toggle-state">Not visible on the applicant</p>
                        </div>
                        <i class="fa fa-times removeRow delete-contact"></i>
                    </div>
                    <div id="toggleError"></div>
                </div>
            </div>
        </div>

    </div>