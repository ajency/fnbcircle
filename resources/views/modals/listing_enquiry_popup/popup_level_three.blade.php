<!-- Level three starts -->

<div class="level-three levels" id="level-three-enquiry" data-parsley-validate="">
    <div class="mobile-hide">
        <h6 class="text-darker m-t-0">We can help you get the best deals on F&amp;B Circle.</h6>
        @if(Auth::guest())
            <!-- <p class="content-title text-darker m-b-0 text-medium">Ensure that you provide the correct details as the business owner will use these details to contact you.</p> -->
            <div class="text-right m-b-10">
                <a class="secondary-link x-small collapsed" data-toggle="collapse" href="#personalDetailsCollapse" aria-expanded="false" aria-controls="personalDetailsCollapse"><i class="fa fa-user" aria-hidden="true"></i> View Personal Details</a>
            </div>    
              <!-- form -->
            <div class="collapse formFields gap-separator row" id="personalDetailsCollapse" style="box-shadow: 0px 5px 10px #f0f0f0 inset, 0px -5px 10px #f0f0f0 inset;">
                <div class="col-sm-4">
                    <div class="form-group m-b-0">
                        <!-- <label class="m-b-0 lighter text-color xx-small required">Name</label> -->
                        <!-- <label class="m-b-0 text-lighter float-label required" for="name">Name</label>
                        <input type="text" class="form-control fnb-input float-input" id="name" value=""> -->
                        <p class="flex-row align-top"><label>Name:</label> <span class="p-l-5" id="enquiry_name">{{ !Auth::guest() ? Auth::user()->name : (isset($enquiry_data) && isset($enquiry_data['name']) ? $enquiry_data['name'] : '') }}</span></p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group m-b-0">
                        <!-- <label class="m-b-0 text-lighter float-label required" for="email">Email</label>
                        <input type="text" class="form-control fnb-input float-input" id="email" value="sunil773@gmail.com"> -->
                        <p class="flex-row align-top"><label>Email: </label> <span class="p-l-5" id="enquiry_email">{{ !Auth::guest() ? Auth::user()->email : (isset($enquiry_data) && isset($enquiry_data['email']) ? $enquiry_data['email'] : '') }}</span></p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group m-b-0">
                        <!-- <label class="m-b-0 text-lighter float-label required" for="number">Phone</label>
                        <input type="tel" class="form-control fnb-input float-input" id="number" value="9876543200"> -->
                        <p class="flex-row align-top"><label>Phone:</label> <span class="p-l-5" id="enquiry_contact">{{ !Auth::guest() ? (Auth::user()->getPrimaryContact()['contact_region'] . Auth::user()->getPrimaryContact()['contact']) : (isset($enquiry_data) && isset($enquiry_data['contact']) ? $enquiry_data['contact'] : '') }}</span></p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <label>What describes you the best: </label>
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
        @endif

        <p class="text-darker heavier m-t-10">Please give us details of the categories that you are interested in and also the areas of operation.</p>
        <!-- categories -->
        <div class="categories-select gap-separator">
            <p class="text-darker describes__title heavier">Categories <span class="xx-small text-lighter">(Select from the list below or add other categories.)</span></p>
            @if(sizeof($data["cores"]) > 0)
                <ul class="categories__points flex-points flex-row flex-wrap" id="enquiry_core_categories">
                    <!-- <li>
                        <label class="flex-row">
                            <input type="checkbox" class="checkbox" for="chicken">
                            <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                        </label>
                    </li> -->
                    @foreach($data["cores"] as $core_key => $core_value)
                        <li>
                            <label class="flex-row">
                                <input type="checkbox" class="checkbox" for="{{ $core_value['slug'] }}" name="categories_interested[]" value="{{ $core_value['slug'] }}" data-parsley-trigger="change" data-parsley-mincheck="1" data-required="true" required="true">
                                <p class="text-medium categories__text flex-points__text text-color" id="">{{ $core_value['name'] }}</p>
                            </label>
                        </li>
                    @endforeach
                </ul>
            @endif
            <ul class="categories__points flex-points flex-row flex-wrap" id="more_added_core_categories">
            </ul>
            <div class="add-more-cat text-right m-t-5">
                <a href="#category-select" data-toggle="modal" data-target="#category-select" class="more-show secondary-link text-decor x-small" id="select-more-categories">+ Add more</a>
                <!-- <div class="form-group m-t-5 m-b-0 add-more-cat__input"> -->
                @include('modals.categories_list')
                <!-- <div class="form-group m-t-5 m-b-0">
                    <input type="text" class="form-control fnb-input flexdatalist cat-add-data" name="get_categories" placeholder="Type to select more categories">
                </div> -->
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
            <div id="area_operations">
                <ul class="areas-select__selection flex-row flex-wrap">
                    <li>
                        <div class="required left-star flex-row">
                            <select class="form-control fnb-select select-variant" name="city" data-parsley-trigger="change" data-parsley-required>
                                <option option="0">Select State</option>
                                @foreach(App\City::where('status', 1)->get() as $key => $value)
                                    @if($data["city"]["slug"] == $value->slug)
                                        <!-- <option value="{{ $value->slug }}" selected="selected">{{ $value->name }}</option> -->
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @else
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </li>
                    <li>
                        <div class="required left-star flex-row">
                            <select class="fnb-select select-variant default-area-select" multiple="multiple" name="area" data-parsley-trigger="change" data-parsley-required data-parsley-mincheck="1">
                                @if(isset($data["city"]) && isset($data["city"]["id"]))
                                    <!-- @foreach(App\Area::where([['status', 1], ['city_id', $data['city']['id']]])->get() as $key_area => $key_value)
                                        <option value="{{ $key_value->id }}">{{ $key_value->name }}</option>
                                    @endforeach -->
                                @endif
                            </select>
                        </div>
                    </li>
                </ul>
            </div>
            <ul class="areas-select__selection flex-row flex-wrap area-append hidden" id="area_dom_skeleton">
                <li>
                    <div class="required left-star flex-row">
                        <select class="form-control fnb-select select-variant" name="city">
                            <option option="0">Select State</option>
                            @foreach(App\City::where('status', 1)->get() as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
                <li>
                    <div class="required left-star flex-row">
                        <select class="fnb-select select-variant areas-appended" multiple="multiple" name="area" data-parsley-trigger="change" data-parsley-required data-parsley-mincheck="1">
                            <!-- <option>Bandra</option>
                            <option>Andheri</option>
                            <option>Dadar</option>
                            <option>Borivali</option>
                            <option>Church gate</option> -->
                        </select>
                    </div>
                </li>
                <li><button class="btn btn-danger" aria-label="Close" id="close_areas">&#10005;</button></li>
            </ul>
            <div class="text-right m-t-10 adder">
                <a href="#" id="add-city-areas" class="secondary-link text-decor heavier add-areas x-small">+ Add more</a>
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