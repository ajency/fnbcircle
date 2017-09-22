@extends('layouts.app')
@section('title', 'Create your F&B Circle Account')

@section('css')
<link rel="stylesheet" type="text/css" href="/css/bootstrap-multiselect.min.css">
@endsection

@section('js')
    <!-- Custom file input -->
    <script type="text/javascript" src="/js/jquery.custom-file-input.js"></script>
    <!-- Add listing -->
    <!-- <script type="text/javascript" src="/js/add-listing.js"></script> -->
    <!-- custom script -->
    <script type="text/javascript" src="/js/bootstrap-multiselect.js"></script>

    <script type="text/javascript" src="/js/custom.js"></script>

     <script src="{{ asset('js/AddListing.js') }}"></script>
    <script type="text/javascript" src="/js/handlebars.js"></script>
    <script type="text/javascript" src="/js/require.js"></script>
@endsection

@section('content')
<div class="register-holder">
    <div class="container">
        <ul class="fnb-breadcrums flex-row m-t-20">
            <li class="fnb-breadcrums__section">
                <a href="/">
                    <i class="fa fa-home home-icon" aria-hidden="true"></i>
                </a>
            </li>
            <li class="fnb-breadcrums__section">
                <!-- <a href=""> -->
                    <p class="fnb-breadcrums__title">/</p>
                <!-- </a> -->
            </li>
            <li class="fnb-breadcrums__section">
                <a href="/register">
                    <p class="fnb-breadcrums__title">Sign Up</p>
                </a>
            </li>
        </ul>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="dsk-separator m-t-20 m-b-50 sign-page">
                    <div class="alert alert-danger alert-dismissible fade in hidden" role="alert"> 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>  
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum ad praesentium sunt at! Eligendi, dolor?</p>
                    </div>
                    <div class="text-center m-t-30 log-sign">
                        <h4 class="welcome-text text-medium">Create your FnB Circle Account</h4>
                        <p class="text-medium have-acc">Already have an account? <a href="#" class="primary-link" data-toggle="modal" data-target="#login-modal">Log In</a></p>

                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-4">
                                <div class="social-login flex-row col-direction m-t-10">
                                    <!-- <button class="fnb-btn social-btn fb" type="button"><i class="fa fa-facebook-official" aria-hidden="true"></i>Sign up with Facebook</button> -->
                                    <a href="{{ url('redirect/facebook') }}" class="fnb-btn social-btn fb"><i class="fa fa-facebook-official" aria-hidden="true"></i>Sign up with Facebook</a>
                                    <div class="m-b-10">OR</div>
                                    <!-- <button class="fnb-btn social-btn google" type="button"><i class="fa fa-google-plus" aria-hidden="true"></i>Sign up with Google</button> -->
                                    <a href="{{ url('redirect/google') }}" class="fnb-btn social-btn google"><i class="fa fa-google-plus" aria-hidden="true"></i>Sign up with Google</a>
                                </div>
                            </div>
                        </div>
                        <p class="text-medium m-b-40 m-t-10 no-post-text"><i class="fa fa-lock" aria-hidden="true"></i> We will not post anything without your permission</p>
                        <hr>
                        <h6 class="heavier m-t-40 formTitle">You can also sign up with email. Please enter your details below.</h6>
                    </div>

                    <div class="row">
                        <div class="col-sm-8 col-lg-offset-2 sign-up-row">
                            <form class="" method="POST" action="{{ route('register') }}" id="register_form">
                                {{ csrf_field() }}

                                <div class="row flex-row flex-wrap signup-container">
                                    <div class="col-sm-6">
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} m-b-10 p-b-10">
                                            <label class="m-b-0 text-lighter float-label required" for="name">Name</label>
                                            <input id="name" type="text" class="form-control fnb-input float-input" name="name" value="{{ old('name') }}" required>
                                            <label id="name-error" class="fnb-errors hidden"></label>

                                            @if ($errors->has('name'))
                                                <!-- <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span> -->
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6 email-col">
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} m-b-10 p-b-10">
                                            <label class="m-b-0 text-lighter float-label required" for="email">E-Mail</label>
                                            <input id="email" type="email" class="form-control fnb-input float-input" name="email" value="{{ old('email') }}" required>
                                            <label id="email-error" class="fnb-errors hidden"></label>

                                            @if ($errors->has('email'))
                                               <!--  <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span> -->
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                         <div class="form-group phoneNumber">
                                            <label class="m-b-0 text-lighter float-label filled required" for="phone">Phone Number</label>
                                            <!-- <input id="phone" type="tel" class="form-control fnb-input float-input" name="phone" value="" required> -->
                                            <div class="number-code flex-row">
                                              <input type="text" class="form-control fnb-input number-code__region" value="+91" maxlength="3" name="contact_locality">
                                              <input type="tel" class="form-control fnb-input number-code__value" placeholder="xxxxxxxxxx" id="contact" name="contact">
                                            </div>
                                            <label id="contact-error" class="fnb-errors hidden"></label>
                                            @if ($errors->has('contact'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('contact') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group m-b-0 city">
                                            <!-- <label class=" text-lighter required">City</label> -->
                                            <div class="required select-required">
                                                <select class="form-control fnb-select border-bottom text-lighter" name="city">
                                                    <option value="">State</option>
                                                    @foreach(App\City::all() as $key => $value)
                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                                <label id="city-error" class="fnb-errors hidden"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group m-b-0 area">
                                            <!-- <label class=" text-lighter required">Area</label> -->
                                            <div class="required select-required">
                                                <select class="form-control fnb-select border-bottom text-lighter" name="area">
                                                    <option value="">City</option>
                                                </select>
                                                <label id="area-error" class="fnb-errors hidden"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 describe-section m-b-10 form-group">
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
                                                <div class="flex-row">
                                                    <label class="flex-row points">
                                                    <input type="checkbox" class="checkbox" for="hospitality" name="description[]" value="hospitality">
                                                        <p class="m-b-0 text-medium points__text flex-points__text text-color" id="hospitality">Hospitality Business Owner </p>
                                                    </label>  
                                                    <i class="fa fa-info-circle p-l-5 text-color" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="If you are an Owner/Founder/Director/C.E.O of a Restaurant, Catering business, Hotel, Food or Beverage Manufacturing/Processing unit or any other Hospitality business"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="flex-row">
                                                    <label class="flex-row points">
                                                    <input type="checkbox" class="checkbox" for="pro" name="description[]" value="pro">
                                                        <p class="m-b-0 text-medium points__text flex-points__text text-color" id="pro">Working Professional </p>
                                                    </label>  
                                                    <i class="fa fa-info-circle p-l-5 text-color" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="If you are a chef, senior Manager, mid level Manager, Supervisor, Order Taker, Customer Representative, etc"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="flex-row">
                                                     <label class="flex-row points">
                                                    <input type="checkbox" class="checkbox" for="vendor" name="description[]" value="vendor">
                                                        <p class="m-b-0 text-medium points__text flex-points__text text-color" id="vendor">Vendor/Supplier/Service provider </p>
                                                    </label>
                                                    <i class="fa fa-info-circle p-l-5 text-color" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="If you or your company trades in or supplies/provides anything to the Hospitality Industry. This category includes Food &amp; Beverage Traders, Manufacturers, Importers, Exporters, Service/Solution Providers"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="flex-row">
                                                    <label class="flex-row points">
                                                    <input type="checkbox" class="checkbox" for="student" name="description[]" value="student">
                                                        <p class="m-b-0 text-medium points__text flex-points__text text-color" id="student">Hospitality Student </p>
                                                    </label>
                                                    <i class="fa fa-info-circle p-l-5 text-color" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Consultants, Media, Investors, Foodie, etc"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="flex-row">
                                                    <label class="flex-row points">
                                                    <input type="checkbox" class="checkbox" for="enterpreneur" name="description[]" value="enterpreneur">
                                                        <p class="m-b-0 text-medium points__text flex-points__text text-color" id="enterpreneur">Prospective Entrepreneur  </p>
                                                    </label>
                                                    <i class="fa fa-info-circle p-l-5 text-color" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="If you see yourself becoming a part of the awesome Hospitality Industry in the near or distant future"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="flex-row">
                                                   <label class="flex-row points">
                                                    <input type="checkbox" class="checkbox" for="others" name="description[]" value="others">
                                                        <p class="m-b-0 text-medium points__text flex-points__text text-color" id="others">Others   </p>
                                                    </label>
                                                    <i class="fa fa-info-circle p-l-5 text-color" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Consultants, Media, Investors, etc"></i>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} p-b-10 m-t-10">
                                            <label class="m-b-0 text-lighter float-label required" for="password">Password</label>
                                            <input id="password" type="password" class="form-control fnb-input float-input" name="password" required>
                                            <label id="password_errors" class="fnb-errors hidden"></label>

                                            @if ($errors->has('password'))
                                                <!-- <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span> -->
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                         <div class="form-group m-t-10 p-b-10">
                                            <label class="m-b-0 text-lighter float-label required" for="password-confirm">Confirm Password</label>
                                            <input id="password-confirm" type="password" class="form-control fnb-input float-input" name="password_confirmation" required>
                                            <label id="password_confirm_errors" class="fnb-errors hidden"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group m-t-30 m-b-40">
                                            <label class="flex-row accept-row">
                                                  <input type="checkbox" class="checkbox" for="accept_terms" id="accept_terms_checkbox">
                                                  <div class="text-medium m-b-0 accept_terms" id="accept_terms">I accept the <a href="#" class="secondary-link">Terms of Service</a> &amp; <a href="#" class="secondary-link">Privacy Policy</a> of FnB Circle</div>
                                                  <label id="terms_conditions" class="fnb-errors hidden">Please accept our terms and conditions</label>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                         <div class="form-group text-center m-t-20 m-b-20 signBtn">
                                            <!-- <button type="submit" class="btn btn-lg fnb-btn primary-btn border-btn"> -->
                                            <button type="button" id="register_form_btn" class="btn btn-lg fnb-btn primary-btn border-btn" disabled="disabled">
                                                Sign Up <i class="fa fa-circle-o-notch fa-spin hidden"></i>
                                            </button>
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
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <hr class="desk-hide">
                <!-- why fnb -->
                <div class="why-fnb sign-up-adv text-center m-b-30 p-b-30">
                    <h3 class="element-title">Why FnB Circle?</h3>
                    <ul class="points m-t-20">
                        <li>
                            <!-- <img src="img/quotes.png" class="img-responsive m-t-20 m-b-20 icons" alt=""> -->
                            <span class="why-icon quote"></span>
                            <p class="element-title subTitle">Hospitality News</p>
                            <p class="default-size subCaption text-color">Stay upto date and profit from the latest Hospitality industry News, Trends and Research.</p>
                        </li>
                        <li>
                            <span class="why-icon supplier"></span>
                            <!-- <img src="img/suppliers.png" class="img-responsive m-t-20 m-b-20 icons" alt=""> -->
                            <p class="element-title subTitle">Vendor/Supplier Directory</p>
                            <p class="default-size subCaption text-color">Find the best Vendors/Suppliers for your business or <a href="#" class="primary-link">make them come to you.</a></p>
                        </li>
                        <li>
                            <!-- <img src="img/jobs.png" class="img-responsive m-t-20 m-b-20 icons" alt=""> -->
                            <span class="why-icon jobs"></span>
                            <p class="element-title subTitle">Hospitality Jobs Portal</p>
                            <p class="default-size subCaption text-color">Hire the best talent to manage your business, or find the most suitable Hospitality Job for yourself.</p>
                        </li>
                        <li>
                            <!-- <img src="img/updates.png" class="img-responsive m-t-20 m-b-20 icons" alt=""> -->
                            <span class="why-icon news"></span>
                            <p class="element-title subTitle">Business promotion for Vendors/Suppliers &amp; Service providers</p>
                            <p class="default-size subCaption text-color">Discover new business opportunities and promote your business to find new customers.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- requirement popup signup -->

<div class="modal fnb-modal require-modal modal-center" id="require-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="require-modal__title">
                    Please fill/confirm the required details of your profile on Fnb Circle
                </div>
                <button class="close" data-dismiss="modal" aria-label="Close">&#10005;</button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label class="m-b-0 text-lighter float-label required" for="name">Name</label>
                        <input id="name" type="text" class="form-control fnb-input float-input" name="name" value="" required="">
                    </div>
                    <div class="form-group">
                        <label class="m-b-0 text-lighter float-label required" for="email">Email</label>
                        <input id="email" type="text" class="form-control fnb-input float-input" name="email" value="" required="">
                    </div>
                    <div class="row phone-col">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label class="m-b-0 text-lighter float-label filled required" for="phone">Phone Number</label>
                                <div class="number-code flex-row">
                                  <input type="text" class="form-control fnb-input number-code__region" value="+91" maxlength="3" name="contact_locality">
                                  <input type="tel" class="form-control fnb-input number-code__value" placeholder="xxxxxxxxxx" name="contact">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="verify-container">
                                <a href="#" class="secondary-link text-decor verifyPhone x-small">Verify Now</a>
                                <!-- <div class="verified verifiedMini flex-row">
                                    <span class="fnb-icons verified-icon"></span>
                                    <p class="c-title m-b-0">Verified</p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group p-t-10 p-b-10">
                                <!-- <label class=" text-lighter required">City</label> -->
                                <div class="required select-required">
                                    <select class="form-control fnb-select border-bottom text-lighter">
                                        <option>State</option>
                                        @foreach(App\City::all() as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group p-t-10 p-b-10">
                                <!-- <label class=" text-lighter required">Area</label> -->
                                <div class="required select-required">
                                    <select class="form-control fnb-select border-bottom text-lighter">
                                        <option>City</option>
                                        @foreach(App\Area::all() as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 describe-section m-b-10 form-group m-t-10">
                            <label class="required describe-section__title">What describes you the best?</label>
                            <div class="row">
                                <div class="col-sm-6">
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
                                </div>
                            </div>
                        </div>
                    </div>
     
<!--                     <div class="form-group p-t-10 p-b-10 multipleOptions">
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
                    <button type="submit" class="btn btn-lg fnb-btn primary-btn border-btn">
                        Save <i class="fa fa-circle-o-notch fa-spin"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
