@if(!Auth::guest())
    <!-- Requirement Modal Popup -->
    <!-- <div class="modal fnb-modal require-modal modal-center in" id="require-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: block; padding-right: 15px;"> -->
    <input type="hidden" name="object_type" value="App\User">
    <input type="hidden" name="object_id" value="{{ auth()->user()->id }}">
    
    <div class="modal fnb-modal require-modal modal-center" id="require-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                            <label id="name-error" class="fnb-errors hidden"></label>
                        </div>
                        <div class="form-group">
                            <label class="m-b-0 text-lighter float-label required" for="email">Email</label>
                            <input id="email" type="text" class="form-control fnb-input float-input" name="email" value="{{ Auth::user()->getPrimaryEmail() }}" required="">
                            <label id="email-error" class="fnb-errors hidden"></label>
                        </div>
                        <div class="contact-info contact-info-mobile" contact-type="mobile">
                            <div class="row phone-col contact-container">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label class="m-b-0 text-lighter float-label filled required" for="phone">Phone Number</label>
                                        <div class="number-code flex-row">
                                            <input type="hidden" class="contact_mobile_id contact-id" readonly value=""  name="contact_mobile_id[]">
                                            <input type="text" class="form-control fnb-input number-code__region" value="+91" maxlength="3" name="contact_locality">
                                            <input type="tel" class="form-control fnb-input number-code__value contact-input" placeholder="xxxxxxxxxx" name="contact" value="{{ Auth::user()->getPrimaryContact()['contact'] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="verify-container">
                                        <a href="javascript:void(0)" class="dark-link contact-verify-link secondary-link text-decor verifyPhone x-small">Verify now</a>
                                        <!-- <a href="#" class="secondary-link text-decor verifyPhone x-small" data-toggle="modal" data-target="#mobile-modal">Verify Now</a> -->
                                        <!-- <div class="verified verifiedMini flex-row">
                                            <span class="fnb-icons verified-icon"></span>
                                            <p class="c-title m-b-0">Verified</p>
                                        </div> -->
                                    </div>
                                </div>
                                <label id="contact-error" class="fnb-errors hidden"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group p-t-10 p-b-10">
                                    <!-- <label class=" text-lighter required">City</label> -->
                                    <div class="required select-required">
                                        <select class="form-control fnb-select border-bottom text-lighter" name="city">
                                            <option value="">State</option>
                                            @foreach(App\City::all() as $key => $value)
                                                @if(Auth::user()->getUserDetails()->first() && Auth::user()->getUserDetails()->first()->city == $value->id)
                                                    <option value="{{ $value->id }}" selected="selected">{{ $value->name }}</option>
                                                @else
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <label id="city-error" class="fnb-errors hidden"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group p-t-10 p-b-10">
                                    <!-- <label class=" text-lighter required">Area</label> -->
                                    <div class="required select-required">
                                        <select class="form-control fnb-select border-bottom text-lighter" name="area">
                                            <option value="">City</option>
                                            @foreach(App\Area::all() as $key => $value)
                                                @if(Auth::user()->getUserDetails()->first() && Auth::user()->getUserDetails()->first()->area == $value->id)
                                                    <option value="{{ $value->id }}" selected="selected">{{ $value->name }}</option>
                                                @else
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <label id="area-error" class="fnb-errors hidden"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 describe-section m-b-10 form-group m-t-10">
                                <label class="required describe-section__title">What describes you the best?</label>
                                <br/><label id="description-error" class="fnb-errors hidden"></label>
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