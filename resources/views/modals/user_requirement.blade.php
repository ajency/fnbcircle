@if(!Auth::guest())
    <!-- Requirement Modal Popup -->
    <!-- <div class="modal fnb-modal require-modal modal-center in" id="require-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: block; padding-right: 15px;"> -->
    <div class="modal fnb-modal require-modal modal-center" id="require-modal" data-backdrop="static" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="require-modal__title">
                        Please fill/confirm the required details of your profile on Fnb Circle
                    </div>
                    <!-- <button class="close" data-dismiss="modal" aria-label="Close">&#10005;</button> -->
                </div>
                <div class="modal-body">
                    <form method="post" id="requirement_form">
                        <div class="form-group">
                            <label class="m-b-0 text-lighter float-label required" for="name">Name</label>
                            <input id="name" type="text" class="form-control fnb-input float-input" name="name" value="{{ Auth::user()->name }}" required="">
                            <p id="name-error" class="fnb-errors hidden"></p>
                        </div>
                        <div class="form-group">
                            <label class="m-b-0 text-lighter float-label required" for="email">Email</label>
                            <input id="email" type="text" class="form-control fnb-input float-input" name="email" value="{{ Auth::user()->getPrimaryEmail() }}" required="">
                            <p id="email-error" class="fnb-errors hidden"></p>
                        </div>
                        <div class="contact-info contact-info-mobile" contact-type="mobile">
                            <div class="row phone-col contact-container">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label class="m-b-0 text-lighter float-label filled required" for="phone">Phone Number</label>
                                        <div class="number-code flex-row">
                                            <input type="hidden" class="contact_mobile_id contact-id" readonly value=""  name="contact_mobile_id" id="requirement_contact_mobile_id">
                                            <!-- <input type="text" class="form-control fnb-input number-code__region" value="+91" maxlength="3" name="contact_locality"> -->
                                            <input type="tel" class="form-control fnb-input number-code__value contact-input contact-mobile-input contact-mobile-number" placeholder="xxxxxxxxxx" name="contact" value="{{ Auth::user()->getPrimaryContact()['contact_region'] }}{{ Auth::user()->getPrimaryContact()['contact'] }}">
                                            <input type="hidden" class="contact-country-code" name="contact_country_code[]" value="{{ Auth::user()->getPrimaryContact()['contact_region'] }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="verification-content hidden">
                                    <input type="hidden" name="object_type" value="App\User"/>
                                    <input type="hidden" name="object_id" value="{{ auth()->user()->id }}"/>

                                    <div class="col-sm-3">
                                        <div class="verify-container verified flex-row al-verify">
                                            @if(!Auth::user()->getPrimaryContact()['is_verified'])
                                                <a href="javascript:void(0)" class="dark-link contact-verify-link secondary-link text-decor verifyPhone x-small">Verify now</a>
                                                <div name="" class="under-review">
                                                    <input type="hidden" class="contact-visible" value="0"/>
                                                </div>
                                            @else
                                                <div class="verified verifiedMini flex-row">
                                                    <span class="fnb-icons verified-icon load-verify"></span>
                                                    <p class="c-title m-b-0">Verified</p>
                                                </div>
                                            @endif
                                            <!-- <a href="#" class="secondary-link text-decor verifyPhone x-small" data-toggle="modal" data-target="#mobile-modal">Verify Now</a> -->
                                            <!-- <div class="verified verifiedMini flex-row">
                                                <span class="fnb-icons verified-icon"></span>
                                                <p class="c-title m-b-0">Verified</p>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p id="contact-error" class="fnb-errors hidden"></p>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group p-t-10 p-b-10">
                                    <!-- <label class=" text-lighter required">City</label> -->
                                    <div class="required select-required">
                                        <select class="form-control fnb-select border-bottom text-lighter" name="city">
                                            <option value="">State</option>
                                            @foreach(App\City::where('status', 1)->get() as $key => $value)
                                                @if(Auth::user()->getUserDetails()->first() && Auth::user()->getUserDetails()->first()->city == $value->id)
                                                    <option value="{{ $value->id }}" selected="selected">{{ $value->name }}</option>
                                                @else
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <p id="city-error" class="fnb-errors hidden"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group p-t-10 p-b-10">
                                    <!-- <label class=" text-lighter required">Area</label> -->
                                    <div class="required select-required">
                                        <input type="hidden" name="user_area" value="{{ Auth::user()->getUserDetails()->first() ? Auth::user()->getUserDetails()->first()->area : '' }}"/>
                                        <select class="form-control fnb-select border-bottom text-lighter" name="area">
                                            <option value="">City</option>
                                        </select>
                                        <p id="area-error" class="fnb-errors hidden"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 describe-section m-b-10 form-group m-t-10">
                                <label class="required describe-section__title">What describes you the best?</label>
                                <div class="row">
                                    @foreach(generateHTML("register_description") as $keyContent => $valueContent)
                                        <div class="col-sm-6">
                                            <div class="flex-row">
                                                <label class="flex-row points">
                                                <!-- <input type="checkbox" class="checkbox" for="hospitality" name="description[]" value="hospitality"> -->
                                                    {!! $valueContent["html"] !!}
                                                    <p class="m-b-0 text-medium points__text flex-points__text text-color" id="hospitality">{{ $valueContent["title"] }} </p>
                                                </label>  
                                                <i class="fa fa-info-circle p-l-5 text-color" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ $valueContent['content'] }}"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                    <!-- <div class="col-sm-6">
                                        <label class="flex-row points">
                                            <input type="checkbox" class="checkbox" for="hospitality" name="description[]" value="hospitality">
                                            <p class="m-b-0 text-medium points__text flex-points__text text-color" id="hospitality">Hospitality Business Owner <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="If you are an Owner/Founder/Director/C.E.O of a Restaurant, Catering business, Hotel, Food or Beverage Manufacturing/Processing unit or any other Hospitality business"></i></p>
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="flex-row points">
                                            <input type="checkbox" class="checkbox" for="pro" name="description[]" value="professional">
                                            <p class="m-b-0 text-medium points__text flex-points__text text-color" id="pro">Working Professional <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="If you are a chef, senior Manager, mid level Manager, Supervisor, Order Taker, Customer Representative, etc"></i></p>
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="flex-row points">
                                            <input type="checkbox" class="checkbox" for="vendor" name="description[]" value="vendor">
                                            <p class="m-b-0 text-medium points__text flex-points__text text-color" id="vendor">Vendor/Supplier/Service provider <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="If you or your company trades in or supplies/provides anything to the Hospitality Industry. This category includes Food &amp; Beverage Traders, Manufacturers, Importers, Exporters, Service/Solution Providers"></i></p>
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="flex-row points">
                                            <input type="checkbox" class="checkbox" for="student" name="description[]" value="student">
                                            <p class="m-b-0 text-medium points__text flex-points__text text-color" id="student">Student <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="If you are pursuing your education in hospitality sector currently"></i></p>
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="flex-row points">
                                            <input type="checkbox" class="checkbox" for="enterpreneur" name="description[]" value="entrepreneur">
                                            <p class="m-b-0 text-medium points__text flex-points__text text-color" id="enterpreneur">Prospective Entrepreneur  <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="If you see yourself becoming a part of the awesome Hospitality Industry in the near or distant future"></i></p>
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="flex-row points">
                                            <input type="checkbox" class="checkbox" for="others" name="description[]" value="others">
                                            <p class="m-b-0 text-medium points__text flex-points__text text-color" id="others">Others   <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Consultants, Media, Investors, etc"></i></p>
                                        </label>
                                    </div> -->
                                </div>
                                <p id="description-error" class="fnb-errors hidden"></p>
                            </div>
                        </div>
         
                    <!--<div class="form-group p-t-10 p-b-10 multipleOptions">
                            <div class="required select-required">
                                <select class="form-control fnb-select border-bottom text-lighter describe-best" id="describe-best" multiple="multiple">
                                    <option value="hospital">Hospitality Business Owner</option>
                                    <option value="pro">Working Professional</option>
                                    <option value="vendor">Vendor/Supplier/Service provider</option>
                                    <option value="student">Student</option>
                                    <option value="enterpreneur">Prospective Entrepreneur</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>
                        </div> -->
                    </form>
                </div>
                <div class="modal-footer">

                    <div class="text-center m-t-10 m-b-10">
                        <div class="text-medium text-lighter accept_terms x-small">By clicking Save, you agree to our <a href="#" class="secondary-link">Terms of Service</a> and <a href="#" class="secondary-link">Privacy Policy</a></div>
                    </div>

                    <div class="form-group text-center m-b-0 m-t-10">
                        <button type="button" class="btn btn-lg fnb-btn primary-btn border-btn" id="requirement_form_btn">
                            Save <i class="fa fa-circle-o-notch fa-spin hidden"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif