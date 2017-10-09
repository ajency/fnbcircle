<div class="m-t-40 m-b-40 business-phone business-contact contact-info contact-info-landline" contact-type="landline">
        <div class="flex-row space-between landline-sp-row">
            <label class="label-size">Enter your business landline number</label>
            <a href="#" class="dark-link text-medium add-another">+ Add another landline number</a>
        </div>
        @if(!empty($contactLandline))
        @foreach($contactLandline as $landline)
        <div class="contact-row m-t-5 contact-container">
            <div class="row phone-row get-val ">
                <div class="col-sm-5">
                    <div class="input-row">
                        <input type="hidden" class="contact_landline_id contact-id" readonly value="{{ $landline['id'] }}"  name="contact_landline_id[]">
                        
                        <input type="text" class="form-control fnb-input p-l-5 contact-input contact-landline-input contact-landline-number contact-landline-number" name="contact_landline[]" value="{{ $landline['landline']}}"  data-parsley-length-message="Landline number should be 10 digits." data-parsley-type="digits" data-parsley-length="[10, 10]"   >

                        <input type="hidden" class="contact-country-code" name="contact_country_code[]" value="{{ $landline['country_code']}}">
                        <div class="dupError" ></div>
                        <!-- <i class="fa fa-landline" aria-hidden="true"></i>  -->
                    </div>
                </div>
                <div class="col-sm-3 col-xs-4">
                   <!--  <div class="verified flex-row">
                    @if($landline['verified'])
                        <span class="fnb-icons verified-icon"></span><p class="c-title">Verified</p>
                    @else
                        <a href="javascript:void(0)" class="dark-link contact-verify-link">Verify now</a>
                    @endif
                        <input type="checkbox" name="verified_contact" class="hidden" style="visibility: hidden;" readonly="">

                    </div> -->
                </div>
                <div class="col-sm-4 col-xs-8">
                    <div class="flex-row close-section">
                        <div class="verified-toggle flex-row">
                            <div class="toggle m-l-10 m-r-10">
                                <input type="checkbox" class="toggle__check"  @if($landline['visible']) checked @endif   data-parsley-multiple="contacts" data-parsley-errors-container="#toggleError">
                                <b class="switch"></b>
                                <b class="track"></b>
                                <input type="hidden" class="contact-visible" name="visible_landline_contact[]" value="{{ $landline['visible'] }}">
                            </div>
                            <p class="m-b-0 text-color toggle-state">@if($landline['visible']) Visible on the listing @else Not visible on the listing @endif  </p>
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
                        <input type="hidden" class="contact_landline_id contact-id" readonly value=""  name="contact_landline_id[]">
                        <input type="text" class="form-control fnb-input p-l-5 contact-input contact-landline-input contact-landline-number "  name="contact_landline[]" data-parsley-length-message="Landline number should be 10 digits." data-parsley-type="digits" data-parsley-length="[10, 10]" data-parsley-length-message="landline number should be 10 digits."  >
                        <input type="hidden" class="contact-country-code" name="contact_country_code[]" value="">
                        <div class="dupError" id="landlineerror"></div>
                        <!-- <i class="fa fa-landline" aria-hidden="true"></i> -->
                    </div>
                </div>
                <div class="col-sm-3 col-xs-4">
                    <div class="verified flex-row hidden ">

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
                                <input type="hidden" class="contact-visible" name="visible_landline_contact[]" value="0">
                            </div>
                            <p class="m-b-0 text-color toggle-state">Not visible on the listing</p>
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

                    <input type="hidden" class="contact-id" readonly  name="contact_landline_id[]">
                    <input type="hidden" class="id-generator"></input>
                    <div class="input-row">
                        <input type="tel" class="form-control fnb-input p-l-5 contact-input contact-landline-input" value="" name="contact_landline[]" data-parsley-length-message="Landline number should be 10 digits." data-parsley-type="digits" data-parsley-length="[10, 10]"   >
                        <input type="hidden" class="contact-country-code" name="contact_country_code[]" value="">
                        <div class="dupError" id="landlineerror-re"></div>
                         <!-- <i class="fa fa-landline" aria-hidden="true"></i> -->
                    </div>
                </div>
                <div class="col-sm-3 col-xs-4">
                   <!--  <div class="verified flex-row">
                        <input type="checkbox" class="hidden" name="verified_contact" style="visibility: hidden;" readonly="">
                        <a href="javascript:void(0)" class="dark-link contact-verify-link">Verify now</a>
                    </div> -->
                </div>
                <div class="col-sm-4 col-xs-8">
                    <div class="flex-row close-section">
                        <div class="verified-toggle flex-row">
                            <div class="toggle m-l-10 m-r-10">
                                <input type="checkbox" class="toggle__check"  data-parsley-multiple="contacts" data-parsley-errors-container="#toggleError">
                                <b class="switch"></b>
                                <b class="track"></b>
                                <input type="hidden" class="contact-visible" name="visible_landline_contact[]" value="0">
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