<!-- Level three starts -->

<!-- <div class="level-three levels" id="level-three-enquiry"> -->
<div class="level-three" id="level-three-enquiry">
    @if(isset($data["premium"]) && $data["premium"])
        <div class="enquiry-success flex-row" style="padding: 1em">
            <i class="fa fa-check-circle" aria-hidden="true"></i>
            <h6 class="text-color text-medium enquiry-success__text" style="padding-right: 0em">Email &amp; SMS with your details has been sent to the owner of {{ $data["title"]["name"] }}.</h6>
        </div>
    @endif
    <div class="suppliers-data in-popup">
        <div class="">
            <h6 class="text-darker m-t-0">We can help you get the best deals on FnB Circle.</h6>
            @if(Auth::guest())
                <!-- <p class="content-title text-darker m-b-0 text-medium">Ensure that you provide the correct details as the business owner will use these details to contact you.</p> -->
                <div class="text-right m-b-10">
                    <a class="secondary-link x-small collapsed" data-toggle="collapse" href="#personalDetailsCollapse" aria-expanded="false" aria-controls="personalDetailsCollapse"><i class="fa fa-user" aria-hidden="true"></i> View Personal Details</a>
                </div>    
                  <!-- form -->
                <div class="collapse formFields gap-separator row card" id="personalDetailsCollapse">
                    <div class="fornDetails flex-row flex-wrap">
                        <div class="formDetails__cols">
                            <div class="form-group m-b-0">
                                <!-- <label class="m-b-0 lighter text-color xx-small required">Name</label> -->
                                <!-- <label class="m-b-0 text-lighter float-label required" for="name">Name</label>
                                <input type="text" class="form-control fnb-input float-input" id="name" value=""> -->
                                <label>Name:</label>
                                <p class="x-small" id="enquiry_name">{{ !Auth::guest() ? Auth::user()->name : (isset($enquiry_data) && isset($enquiry_data['name']) ? $enquiry_data['name'] : '') }}</p>
                            </div>
                        </div>
                        <div class="formDetails__cols">
                            <div class="form-group m-b-0">
                                <!-- <label class="m-b-0 text-lighter float-label required" for="email">Email</label>
                                <input type="text" class="form-control fnb-input float-input" id="email" value="sunil773@gmail.com"> -->
                                <label>Email: </label> 
                                <p class="x-small" id="enquiry_email">{{ !Auth::guest() ? Auth::user()->email : (isset($enquiry_data) && isset($enquiry_data['email']) ? $enquiry_data['email'] : '') }}</p>
                            </div>
                        </div>
                        <div class="formDetails__cols">
                            <div class="form-group m-b-0">
                                <!-- <label class="m-b-0 text-lighter float-label required" for="number">Phone</label>
                                <input type="tel" class="form-control fnb-input float-input" id="number" value="9876543200"> -->
                                <label>Phone:</label>
                                <p class="x-small" id="enquiry_contact">{{ !Auth::guest() ? (Auth::user()->getPrimaryContact()['contact_region'] . Auth::user()->getPrimaryContact()['contact']) : (isset($enquiry_data) && isset($enquiry_data['contact']) ? '+' . $enquiry_data['contact_code'] . $enquiry_data['contact'] : '') }}</p>
                            </div>
                        </div>
                        <div class="formDetails__cols">
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

                </div>
                <!-- form ends -->
            @endif

            <p class="text-darker text-medium m-t-20">Please give us details of the categories that you are interested in and also the areas of operation.</p>
            <form id="other_details_container" data-parsley-validate="">
                <!-- categories -->
                <div class="categories-select gap-separator">
                    <!-- <p class="text-darker describes__title heavier">Categories <span class="xx-small text-lighter">(Select from the list below or add other categories.)</span></p> -->
                    <p class="text-darker describes__title heavier">Categories <span class="xx-small text-lighter">(Add categories and select.)</span></p>
                        <ul class="categories__points flex-points flex-row flex-wrap" id="enquiry_core_categories">
                            @if(isset($data["cores"]) && sizeof($data["cores"]) > 0)
                            <!-- <li>
                                <label class="flex-row">
                                    <input type="checkbox" class="checkbox" for="chicken">
                                    <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                                </label>
                            </li> -->
                            @foreach($data["cores"] as $core_key => $core_value)
                                <li>
                                    <label class="flex-row">
                                        @if($core_key == 0)
                                            <input type="checkbox" class="checkbox" for="{{ $core_value['id'] }}" name="categories_interested[]" value="{{ $core_value['id'] }}" data-parsley-trigger="change" data-parsley-mincheck="1" data-parsley-errors-container="#category-checkbox-error" required="">
                                        @else
                                            <input type="checkbox" class="checkbox" for="{{ $core_value['id'] }}" name="categories_interested[]" value="{{ $core_value['id'] }}">
                                        @endif
                                        <p class="text-medium categories__text flex-points__text text-color" id="">{{ $core_value['name'] }}</p>
                                    </label>
                                </li>
                            @endforeach
                            @endif
                        </ul>
                    <ul class="categories__points flex-points flex-row flex-wrap" id="more_added_core_categories">
                    </ul>
                    <div id="category-checkbox-error"></div>
                    <div class="add-more-cat text-right">
                        <a href="#category-select" data-toggle="modal" data-target="#category-select" class="more-show secondary-link text-decor x-small" id="select-more-categories">+ Add categories</a>
                        <input type="hidden" id="modal_categories_chosen" name="modal_categories_chosen" value="[]"/>
                        <input type="hidden" id="modal_categories_hierarchy_chosen" name="modal_categories_hierarchy_chosen" value="[]"/>
                        <input type="hidden" name="" id="is_branch_category_checkbox" value="true"/>
                        <input type="hidden" name="" id="branch_category_selected_ids" value="[]"/>

                        
                        <!-- <div class="form-group m-t-5 m-b-0 add-more-cat__input"> -->
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
                    <p class="text-darker describes__title heavier required m-b-5">Areas <span class="xx-small text-lighter">(Select your areas of interest)</span></p>
                    <div id="area_operations">
                        <ul class="areas-select__selection flex-row flex-wrap">
                            <li class="city-select">
                                <div class="flex-row">
                                    <select class="form-control fnb-select select-variant" name="city" data-parsley-trigger="change" data-parsley-errors-container="#city-select-error" required="">
                                        <option value="">Select State</option>
                                        @foreach(App\City::where('status', 1)->get() as $key => $value)
                                            @if(isset($data["city"]) && $data["city"]["slug"] == $value->slug)
                                                <!-- <option value="{{ $value->slug }}" selected="selected">{{ $value->name }}</option> -->
                                                <option value="{{ $value->id }}" selected="selected">{{ $value->name }}</option>
                                            @else
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div id="city-select-error" class="fnb-error"></div>
                                </div>
                            </li>
                            <li class="area-select">
                                <div class="flex-row">
                                    <select class="fnb-select select-variant default-area-select" multiple="multiple" name="area" data-parsley-mincheck="1" data-parsley-errors-container="#area-select-error" required="">
                                        @if(isset($data["city"]) && isset($data["city"]["id"]))
                                            @foreach(App\Area::where([['status', 1], ['city_id', $data['city']['id']]])->get() as $key_area => $key_value)
                                                @if(isset($data['area_ids']) && in_array($key_value->id, $data['area_ids']))
                                                    <option value="{{ $key_value->id }}" selected="selected">{{ $key_value->name }}</option>
                                                @else
                                                    <option value="{{ $key_value->id }}">{{ $key_value->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <div id="area-select-error" class="fnb-error"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <ul class="areas-select__selection flex-row flex-wrap area-append hidden" id="area_dom_skeleton">
                        <li class="city-select">
                            <div class="flex-row">
                                <select class="form-control fnb-select select-variant" name="city" data-parsley-mincheck="1">
                                    <option value="">Select State</option>
                                    @foreach(App\City::where('status', 1)->get() as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                        <li class="area-select">
                            <div class="flex-row">
                                <select class="fnb-select select-variant areas-appended default-area-select" multiple="multiple" name="area" data-parsley-mincheck="1">
                                    <!-- <option>Bandra</option>
                                    <option>Andheri</option>
                                    <option>Dadar</option>
                                    <option>Borivali</option>
                                    <option>Church gate</option> -->
                                </select>
                            </div>
                        </li>
                        <li><a href="#" class="primary-link m-l-20" aria-label="Close" id="close_areas"><i class="fa fa-times" aria-hidden="true"></i></a></li>
                    </ul>
                    <div class="text-right adder">
                        <a href="#" id="add-city-areas" class="secondary-link text-decor heavier add-areas x-small">+ Add more</a>
                    </div>
                </div>
                <!-- areas select -->
                
                <!-- action -->
                <div class="send-action m-t-10">
                    <button class="btn fnb-btn primary-btn full border-btn success-toggle" id="level-three-form-btn" data-value="{{ isset($data['current_page']) && strlen($data['current_page']) ? $data['current_page'] : ''}}">Send <i class="fa fa-circle-o-notch fa-spin fa-fw hidden"></i></button>
                </div>
                <!-- action ends -->
            </form>
        </div>
    </div>
</div>
<!-- level three ends