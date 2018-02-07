<!-- level one starts -->
<div class="level-one">
    @if(!isset($no_title) || !$no_title)
        @if(isset($mobile_view) && $mobile_view)
            <div class="enquiry-form__header flex-row space-between">
                <div class="enquiry-title">
                    <h6 class="element-title m-t-0 m-b-0">Send Enquiry To</h6>
                    <p class="sub-title">{{ $data['title']['name'] }}</p>
                </div>
                <span class="fnb-icons enquiry"></span>
            </div>
        @else
            @if(!Auth::guest())
                <h5 class="content-title text-darker heavier enquiry-log-title flex-row m-t-0"><img src="{{ asset('img/enquiry-msg.png') }}" class="img-responsive m-r-10" width="60"> <div>To send your enquiry, as <b class="text-primary">{{ Auth::user()->name }}</b> please fill your details below.</div></h5>
            @else
                <p class="content-title text-darker heavier">Ensure that you provide the correct details as the business owner will use these details to contact you.</p>
            @endif
        @endif
    @endif
      <!-- form -->
    <form method="post" action="" id="level-one-enquiry" data-parsley-validate="">
        <div class="formFields flex-row flex-wrap p-b-15 row {{ !Auth::guest() ? 'hidden' : '' }}">
            <div class="@if(isset($mobile_view) && $mobile_view) col-sm-11 @else col-sm-6 @endif col-xs-12">
                <div class="form-group m-b-0">
                    <!-- <label class="m-b-0 lighter text-color xx-small required">Name</label> -->
                    <label class="m-b-0 text-lighter float-label required" for="name">Name</label>
                    <input type="text" class="form-control fnb-input float-input" id="name" name="name" data-required="true" value="{{ !Auth::guest() ? Auth::user()->name : (isset($enquiry_data) && isset($enquiry_data['name']) ? $enquiry_data['name'] : '') }}" required {{ !Auth::guest() ? 'disabled="true"' : '' }} />
                </div>
            </div>
            <div class="@if(isset($mobile_view) && $mobile_view) col-sm-11 @else col-sm-6 @endif">
                <div class="form-group @if(isset($mobile_view) && $mobile_view) p-t-10 @endif m-b-0">
                    <label class="m-b-0 text-lighter float-label required filled lab-color dis-block phone-label" for="number">Phone</label>
                    @if(!Auth::guest())
                        <!-- <input type="tel" class="form-control fnb-input number-code__value" id="contact" name="contact" data-parsley-trigger="change" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-type="digits" data-required="true" data-parsley-errors-container="#errorfield" value="{{ !Auth::guest() ? ( '+' . Auth::user()->getPrimaryContact()['contact_region'] . Auth::user()->getPrimaryContact()['contact']) : (isset($enquiry_data) && isset($enquiry_data['contact']) ? $enquiry_data['contact'] : '') }}" required {{ !Auth::guest() ? 'disabled="true"' : '' }}/> -->
                        <input type="tel" class="form-control fnb-input number-code__value" id="contact" name="contact" data-parsley-trigger="change" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-type="digits" data-required="true" data-parsley-errors-container="#errorfield" value="{{ !Auth::guest() ? ( '+' . Auth::user()->getPrimaryContact()['contact_region']) : (isset($enquiry_data) && isset($enquiry_data['contact_code']) ? '+' . $enquiry_data['contact_code'] : '') }}{{!Auth::guest() ? (Auth::user()->getPrimaryContact()['contact']) : (isset($enquiry_data) && isset($enquiry_data['contact']) ? $enquiry_data['contact'] : '') }}" required {{ !Auth::guest() ? '' : '' }} @if(isset($is_multi_select_dropdown) && $is_multi_select_dropdown) data-parsley-errors-container="#errorfield" @else data-parsley-errors-container="#contactfield" @endif />
                        <input type="hidden" name="contact_locality" value="{{ !Auth::guest() ? (Auth::user()->getPrimaryContact()['contact_region']) : '' }}"/>
                    @elseif(isset($enquiry_data) && isset($enquiry_data['contact']))
                        <!-- <input type="tel" class="form-control fnb-input number-code__value" id="contact" name="contact" data-parsley-trigger="change" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-type="digits" data-required="true" data-parsley-errors-container="#errorfield" value="{{ (isset($enquiry_data) && isset($enquiry_data['contact_code']) ? '+' . $enquiry_data['contact_code'] : '') }}{{(isset($enquiry_data) && isset($enquiry_data['contact']) ? $enquiry_data['contact'] : '') }}" required> -->
                        <input type="tel" class="form-control fnb-input number-code__value" id="contact" name="contact" data-parsley-trigger="change" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-type="digits" data-required="true" data-parsley-errors-container="#errorfield" value="{{ (isset($enquiry_data) && isset($enquiry_data['contact_code']) ? '+' . $enquiry_data['contact_code'] : '') }}{{(isset($enquiry_data) && isset($enquiry_data['contact']) ? $enquiry_data['contact'] : '') }}" required @if(isset($is_multi_select_dropdown) && $is_multi_select_dropdown) data-parsley-errors-container="#errorfield" @else data-parsley-errors-container="#contactfield" @endif />
                        <input type="hidden" name="contact_locality" value="{{ (isset($enquiry_data) && isset($enquiry_data['contact_code']) ? $enquiry_data['contact_code'] : '') }}">
                    @else
                        <!-- <input type="tel" class="form-control fnb-input number-code__value" id="contact" name="contact" data-parsley-trigger="change" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-type="digits" data-required="true" data-parsley-errors-container="#errorfield" value="" required=""> -->
                        <input type="tel" class="form-control fnb-input number-code__value" id="contact" name="contact" data-parsley-trigger="change" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-type="digits" data-required="true" value="" required="" @if(isset($is_multi_select_dropdown) && $is_multi_select_dropdown) data-parsley-errors-container="#errorfield" @else data-parsley-errors-container="#contactfield" @endif />
                        <input type="hidden" name="contact_locality" value="">
                    @endif
                </div>

                @if(isset($is_multi_select_dropdown) && $is_multi_select_dropdown)
                    <div id="errorfield" class="fnb-errors"></div>
                @else
                    <div id="contactfield" class="fnb-errors"></div>
                @endif
            </div>
            <div class="@if(isset($mobile_view) && $mobile_view) col-sm-11 @else col-sm-6 @endif">
                <div class="form-group @if(isset($mobile_view) && $mobile_view) p-t-10 @endif m-b-0">
                    <label class="m-b-0 text-lighter float-label required" for="email">Email</label>
                    <input type="email" class="form-control fnb-input float-input" id="email" name="email" data-parsley-trigger="change" data-parsley-type="email" data-required="true" value="{{ !Auth::guest() ? Auth::user()->getPrimaryEmail() : (isset($enquiry_data) && isset($enquiry_data['email']) ? $enquiry_data['email'] : '') }}" required {{ !Auth::guest() ? 'disabled="true"' : '' }}/>
                </div>
            </div>
            <div class="@if(isset($mobile_view) && $mobile_view) hidden @else col-sm-6 @endif">
                <div class="form-group m-b-0">
                </div>
            </div>
        </div>
        <!-- form ends -->
        <!-- describes best -->
        <div class="describes gap-separator {{ !Auth::guest() ? 'hidden' : '' }}">
            <p class="text-darker describes__title"><span class="dis-inline required default-size heavier" style="font-size: 1em;">What describes you the best?</span> <span class="xx-small text-lighter">(Please select atleast one)</span></p>
            <div class="row">
                <!-- <div class="col-sm-6">
                    <select class="fnb-select select-variant multi-select" multiple="multiple">
                        <option>I work in the F&amp;B industry</option>
                        <option>I am a resturant owner</option>
                        <option>I am a supplier to F&amp;B industry</option>
                        <option>I provide services to F&amp;B industry</option>
                        <option>I am a manufacturer</option>
                        <option>Others...</option>
                    </select>
                </div> -->
                @if(isset($is_multi_select_dropdown) && $is_multi_select_dropdown)
                    @php
                        if(isset($enquiry_data) && isset($enquiry_data['describes_best']) && $enquiry_data['describes_best']) {
                            $describes_best_html = generateHTML("list_view_enquiry_description", $enquiry_data['describes_best']);
                        } else {
                            $describes_best_html = generateHTML("list_view_enquiry_description");
                        }
                    @endphp
                    <div class="col-sm-12 flex-row flex-wrap describe-section">
                        <label class="flex-row points">
                            <select class="fnb-select select-variant" multiple="multiple" name="description" data-parsley-trigger="change" data-parsley-mincheck="1" data-parsley-errors-container="#describes-best-dropdown-error" required>
                                @foreach($describes_best_html as $keyContent => $valueContent)
                                    {!! $valueContent["html"] !!}
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <div class="col-sm-12">
                        <div id="describes-best-dropdown-error" class="fnb-error"></div>
                    </div>
                @else
                    @php
                        if(isset($enquiry_data) && isset($enquiry_data['describes_best']) && $enquiry_data['describes_best']) {
                            $describes_best_html = generateHTML("listing_enquiry_description", $enquiry_data['describes_best']);
                        } else {
                            $describes_best_html = generateHTML("listing_enquiry_description");
                        }
                    @endphp
                    <div class="col-sm-12 flex-row flex-wrap describe-section">
                        @foreach($describes_best_html as $keyContent => $valueContent)
                            <label class="flex-row points">
                                {!! $valueContent["html"] !!}
                                <p class="m-b-0 text-medium points__text flex-points__text text-color" id="hospitality">{{ $valueContent["title"] }} </p>
                                <i class="fa fa-info-circle p-l-5 text-color" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ $valueContent['content'] }}"></i>
                            </label>
                        @endforeach
                    </div>
                    <div class="col-sm-12">
                        <div id="describes-best-error" class="fnb-error"></div>
                    </div>
                @endif
            </div>
        </div>
        <!-- describes best ends -->
        <!-- looking for -->
        <div class="looking-for gap-separator">
            @if(Auth::guest())
                <a class="secondary-link text-decor desk-hide looking-for__toggle" data-toggle="collapse" href="#lookingfor" aria-expanded="false" aria-controls="lookingfor">Add a note</a>
            @endif    
            <!-- <div class="@if(Auth::guest()) collapse @endif  @if(!Auth::guest()) in @endif" id="lookingfor"> -->
            <div class="collapse in" id="lookingfor">
                <p class="text-darker describes__title heavier m-b-5">Give the supplier/service provider some details of your requirements</p>
                <div class="text-lighter x-small heavier">You may specify product/services, quantities, specifications, your company/brand name, etc.</div>
                <div class="form-group">
                    <input type="text" class="form-control fnb-input" name="enquiry_message" placeholder="">
                </div>
            </div>
        </div><br/>
        <!-- looking for ends -->
        <div class="flex-row points">
            <input type="checkbox" class="checkbox" for="" name="news-letter-subscribe" id="news-letter-subscribe" value="" checked="true"/> Subscribe to news letter.
        </div>
        <!-- action -->
        <div class="send-action">
            @if(isset($enquiry_send_button) && $enquiry_send_button)
                <!-- <button class="btn fnb-btn primary-btn full border-btn enquiry-modal-btn" type="button" id="level-one-form-btn" data-value="step_1" data-toggle="modal" data-target="{{ isset($enquiry_modal_id) && $enquiry_modal_id ? $enquiry_modal_id  : '#multi-quote-enquiry-modal' }}">Send an Enquiry <i class="fa fa-circle-o-notch fa-spin fa-fw hidden"></i></button> -->
                <button class="btn fnb-btn primary-btn full border-btn enquiry-modal-btn" type="button" id="level-one-form-btn" data-value="step_1" data-target="{{ isset($enquiry_modal_id) && $enquiry_modal_id ? $enquiry_modal_id  : '#multi-quote-enquiry-modal' }}">Send an Enquiry <i class="fa fa-circle-o-notch fa-spin fa-fw hidden"></i></button>
            @else
                <button class="btn fnb-btn primary-btn full border-btn" type="button" id="level-one-form-btn" data-value="step_1">Send <i class="fa fa-circle-o-notch fa-spin fa-fw hidden"></i></button>
            @endif
        </div>
        <!-- action ends -->
    </form>
</div>

<!-- <script type="text/javascript">
    $(document).ready(function(){
        $(document).find("#level-one-enquiry input[name='contact']").intlTelInput({
          initialCountry: 'auto',
          separateDialCode: true,
          geoIpLookup: function(callback) {
            $.get('https://ipinfo.io', (function() {}), 'jsonp').always(function(resp) {
              var countryCode;
              countryCode = resp && resp.country ? resp.country : '';
              callback(countryCode);
            });
          },
          preferredCountries: ['IN'],
          americaMode: false,
          formatOnDisplay: false
        });

        $(document).on("countrychange", "#level-one-enquiry input[name='contact']", function(){
            $(this).val($(this).intlTelInput("getNumber"));
        });
    });
</script> -->

<!-- Level one ends -->