<!-- Level three starts -->

<div class="level-three levels" id="level-three-enquiry">
    <div class="mobile-hide">
        <!-- verify email and contact ends -->
        <p class="content-title text-darker m-b-0 text-medium">Ensure that you provide the correct details as the business owner will use these details to contact you.</p>
        <a class="" data-toggle="collapse" href="#personalDetailsCollapse" aria-expanded="false" aria-controls="personalDetailsCollapse">View Personal Details</a>
          <!-- form -->
        <div class="collapse formFields gap-separator row" id="personalDetailsCollapse" style="box-shadow: 0px 5px 10px #f0f0f0 inset, 0px -5px 10px #f0f0f0 inset;">
            <div class="col-sm-6">
                <div class="form-group m-b-0">
                    <!-- <label class="m-b-0 lighter text-color xx-small required">Name</label> -->
                    <!-- <label class="m-b-0 text-lighter float-label required" for="name">Name</label>
                    <input type="text" class="form-control fnb-input float-input" id="name" value=""> -->
                    <p><label>Name:</label> <span id="enquiry_name">{{ !Auth::guest() ? Auth::user()->name : (isset($enquiry_data) && isset($enquiry_data['name']) ? $enquiry_data['name'] : '') }}</span></p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group m-b-0">
                    <!-- <label class="m-b-0 text-lighter float-label required" for="number">Phone</label>
                    <input type="tel" class="form-control fnb-input float-input" id="number" value="9876543200"> -->
                    <p><label>Phone:</label> <span id="enquiry_contact">{{ !Auth::guest() ? (Auth::user()->getPrimaryContact()['contact_region'] . Auth::user()->getPrimaryContact()['contact']) : (isset($enquiry_data) && isset($enquiry_data['contact']) ? $enquiry_data['contact'] : '') }}</span></p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group m-b-0">
                    <!-- <label class="m-b-0 text-lighter float-label required" for="email">Email</label>
                    <input type="text" class="form-control fnb-input float-input" id="email" value="sunil773@gmail.com"> -->
                    <p><label>Email: </label> <span id="enquiry_email">{{ !Auth::guest() ? Auth::user()->email : (isset($enquiry_data) && isset($enquiry_data['email']) ? $enquiry_data['email'] : '') }}</span></p>
                </div>
            </div>
            <div class="col-sm-6"></div>
            <div class="col-sm-12">
                <label>What descr: </label>
                @if(isset($enquiry_data['describes_best']) && sizeof($enquiry_data['describes_best']) > 0)
                    <ul>
                        @php
                            if(isset($enquiry_data) && isset($enquiry_data['describes_best'])) {
                                $describes_best_html = generateHTML("enquiry_popup_display", $enquiry_data['describes_best']);
                            } else {
                                $describes_best_html = generateHTML("enquiry_popup_display", []);
                            }
                        @endphp
                        @foreach($describes_best_html as $index_best => $value_best)
                            {!! $value_best["html"] !!}
                        @endforeach
                    </ul>
                @else
                    None
                @endif
            </div>
        </div>
        <!-- form ends -->

        <!-- categories -->
        <div class="categories-select gap-separator">
            <p class="text-darker describes__title text-medium">Categories <span class="xx-small text-lighter">(Select from the list below or add other categories.)</span></p>
            <ul class="categories__points flex-points flex-row flex-wrap">
                <!-- <li>
                    <label class="flex-row">
                        <input type="checkbox" class="checkbox" for="chicken">
                        <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                    </label>
                </li> -->
                @foreach($data["cores"] as $core_key => $core_value)
                    <li>
                        <label class="flex-row">
                            <input type="checkbox" class="checkbox" for="" name="categories_interested" value="{{ $core_value['slug'] }}">
                            <p class="text-medium categories__text flex-points__text text-color" id="">{{ $core_value['name'] }}</p>
                        </label>
                    </li>
                @endforeach
            </ul>
            <div class="add-more-cat text-right m-t-5">
                <a href="#" class="more-show secondary-link text-decor">+ Add more</a>
                <div class="form-group m-t-5 m-b-0 add-more-cat__input">
                    <input type="text" class="form-control fnb-input flexdatalist cat-add-data" placeholder="Type to select categories" multiple='multiple' data-min-length='1'>
                </div>
            </div>

        </div>
        <!-- categories ends -->
        <!-- Add categories -->
        <!-- <div class="add-categories gap-separator">
            <p class="text-darker describes__title text-medium">Add Categories</p>
            <div class="form-group m-b-0">
                <input type="text" class="form-control fnb-input flexdatalist" placeholder="Type to select categories" multiple='multiple' data-min-length='1'>
            </div>
        </div> -->
        <!-- add categories ends -->
        <!-- areas select -->
        <div class="areas-select gap-separator" id="area_section">
            <p class="text-darker describes__title heavier">Areas <span class="xx-small text-lighter">(Select your areas of interest)</span></p>
            <ul class="areas-select__selection flex-row flex-wrap">
                <li>
                    <div class="required left-star flex-row">
                        <select class="form-control fnb-select select-variant" name="city">
                            <option>Select State</option>
                            @foreach(App\City::where('status', 1)->get() as $key => $value)
                                @if($data["city"]["slug"] == $value->slug)
                                    <option value="{{ $value->slug }}" selected="selected">{{ $value->name }}</option>
                                @else
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </li>
                <li>
                    <div class="required left-star flex-row">
                        <select class="fnb-select select-variant default-area-select" multiple="multiple" name="area">
                            @if(isset($data["city"]) && isset($data["city"]["id"]))
                                @foreach(App\Area::where([['status', 1], ['city_id', $data['city']['id']]])->get() as $key_area => $key_value)
                                    <option value="{{ $key_value->id }}">{{ $key_value->name }}</option>
                                @endforeach
                            @endif
                            <!-- <option>Bandra</option>
                            <option>Andheri</option>
                            <option>Dadar</option>
                            <option>Borivali</option>
                            <option>Church gate</option> -->
                        </select>
                    </div>
                </li>
            </ul>
            <ul class="areas-select__selection flex-row flex-wrap area-append hidden">
                <li>
                    <div class="required left-star flex-row">
                        <select class="form-control fnb-select select-variant" name="city">
                            <option>Select State</option>
                            @foreach(App\City::where('status', 1)->get() as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
                <li>
                    <div class="required left-star flex-row">
                        <select class="fnb-select select-variant areas-appended" multiple="multiple" name="area">
                            <!-- <option>Bandra</option>
                            <option>Andheri</option>
                            <option>Dadar</option>
                            <option>Borivali</option>
                            <option>Church gate</option> -->
                        </select>
                    </div>
                </li>
            </ul>
            <div class="text-right m-t-10 adder">
                <a href="#" class="secondary-link text-decor heavier add-areas">+ Add more</a>
            </div>
        </div>
    </div>
    <!-- areas select -->
     <!-- action -->
    <div class="send-action">
        <button class="btn fnb-btn primary-btn full border-btn success-toggle" id="level-three-form-btn" data-value="{{ isset($data['current_page']) && strlen($data['current_page']) ? $data['current_page'] : ''}}">Send</button>
    </div>
    <!-- action ends -->
</div>
<!-- level three ends