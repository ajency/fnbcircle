<!-- level one starts -->
<div class="level-one">
    <p class="content-title text-darker m-b-0 text-medium">Ensure that you provide the correct details as the business owner will use these details to contact you.</p>
      <!-- form -->
    <form method="post" action="" id="level-one-enquiry" data-parsley-validate="">
        <div class="formFields p-b-15 row {{ !Auth::guest() ? 'hidden' : '' }}">
            <div class="col-sm-6">
                <div class="form-group m-b-0">
                    <!-- <label class="m-b-0 lighter text-color xx-small required">Name</label> -->
                    <label class="m-b-0 text-lighter float-label required" for="name">Name</label>
                    <input type="text" class="form-control fnb-input float-input" id="name" name="name" data-required="true" value="{{ !Auth::guest() ? Auth::user()->name : (isset($enquiry_data) && isset($enquiry_data['name']) ? $enquiry_data['name'] : '') }}" required {{ !Auth::guest() ? 'disabled="true"' : '' }} />
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group m-b-0">
                    <label class="m-b-0 text-lighter float-label required" for="number">Phone</label>
                    @if(!Auth::guest())
                        <input type="tel" class="form-control fnb-input number-code__value" id="contact" name="contact" data-parsley-trigger="change" data-parsley-minlength="10" data-parsley-maxlength="10" data-required="true" value="+{{ !Auth::guest() ? (Auth::user()->getPrimaryContact()['contact_region'] . Auth::user()->getPrimaryContact()['contact']) : (isset($enquiry_data) && isset($enquiry_data['contact']) ? $enquiry_data['contact'] : '') }}" required {{ !Auth::guest() ? 'disabled="true"' : '' }}/>
                        <input type="hidden" name="contact_locality" value="{{ !Auth::guest() ? (Auth::user()->getPrimaryContact()['contact_region']) : '' }}"/>
                    @else
                        <input type="tel" class="form-control fnb-input number-code__value" id="contact" name="contact" data-parsley-trigger="change" data-parsley-minlength="10" data-parsley-maxlength="10" data-required="true" value="+{{ (isset($enquiry_data) && isset($enquiry_data['contact_code']) ? $enquiry_data['contact_code'] : '') }}{{(isset($enquiry_data) && isset($enquiry_data['contact']) ? $enquiry_data['contact'] : '') }}" required>
                        <input type="hidden" name="contact_locality" value="{{ (isset($enquiry_data) && isset($enquiry_data['contact_code']) ? $enquiry_data['contact_code'] : '') }}">
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group m-b-0">
                    <label class="m-b-0 text-lighter float-label required" for="email">Email</label>
                    <input type="text" class="form-control fnb-input float-input" id="email" name="email" name="email" data-parsley-trigger="change" data-required="true" value="{{ !Auth::guest() ? Auth::user()->email : (isset($enquiry_data) && isset($enquiry_data['email']) ? $enquiry_data['email'] : '') }}" required {{ !Auth::guest() ? 'disabled="true"' : '' }}/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group m-b-0">
                </div>
            </div>
        </div>
        <!-- form ends -->
        <!-- describes best -->
        <div class="describes gap-separator {{ !Auth::guest() ? 'hidden' : '' }}">
            <p class="text-darker describes__title text-medium">What describes you the best? <span class="xx-small text-lighter">(Please select atleast one)</span></p>
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
                @php
                    if(isset($enquiry_data) && isset($enquiry_data['describes_best'])) {
                        $describes_best_html = generateHTML("listing_enquiry_description", $enquiry_data['describes_best']);
                    } else {
                        $describes_best_html = generateHTML("listing_enquiry_description");
                    }
                @endphp

                @foreach($describes_best_html as $keyContent => $valueContent)
                    <div class="col-sm-12">
                        <label class="flex-row points">
                            {!! $valueContent["html"] !!}
                            <p class="m-b-0 text-medium points__text flex-points__text text-color" id="hospitality">{{ $valueContent["title"] }} </p>
                        </label>
                    </div>
                @endforeach
                <div id="describes-best-error" class="fnb-error"></div>
            </div>
        </div>
        <!-- describes best ends -->
        <!-- looking for -->
        <div class="looking-for gap-separator">
            <a class="secondary-link text-decor desk-hide looking-for__toggle" data-toggle="collapse" href="#lookingfor" aria-expanded="false" aria-controls="lookingfor">Add a note</a>
            <div class="collapse in" id="lookingfor">
                <p class="text-darker describes__title text-medium">Tell the business owner what you're looking for</p>
                <div class="form-group">
                    <input type="text" class="form-control fnb-input" name="enquiry_message" placeholder="Type here....">
                </div>
            </div>
        </div>
        <!-- looking for ends -->
        <!-- action -->
        <div class="send-action">
            <button class="btn fnb-btn primary-btn full border-btn" type="button" id="level-one-form-btn" data-value="step_1">Send</button>
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