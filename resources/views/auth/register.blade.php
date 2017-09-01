@extends('layouts.fnbtemplate')
@section('title', 'Create your F&B Circle Account')

@section('css')
@endsection

@section('js')
    <!-- Custom file input -->
    <script type="text/javascript" src="/js/jquery.custom-file-input.js"></script>
    <!-- Add listing -->
    <script type="text/javascript" src="/js/add-listing.js"></script>
    <!-- custom script -->
    <script type="text/javascript" src="/js/custom.js"></script>

     <script src="{{ asset('js/AddListing.js') }}"></script>
    <script type="text/javascript" src="/js/handlebars.js"></script>
    <script type="text/javascript" src="/js/require.js"></script>
@endsection

@section('content')
<div class="container">
    <ul class="fnb-breadcrums flex-row m-t-20">
        <li class="fnb-breadcrums__section">
            <a href="">
                <i class="fa fa-home home-icon" aria-hidden="true"></i>
            </a>
        </li>
        <li class="fnb-breadcrums__section">
            <a href="">
                <p class="fnb-breadcrums__title">/</p>
            </a>
        </li>
        <li class="fnb-breadcrums__section">
            <a href="">
                <p class="fnb-breadcrums__title">Sign Up</p>
            </a>
        </li>
    </ul>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-9">
            <div class="dsk-separator m-t-20 m-b-50">
                <div class="text-center m-t-50">
                    <h4 class="welcome-text text-medium">Create your FnB Circle Account</h4>
                    <p class="text-medium">Already have and account? <a href="#" class="primary-link" data-toggle="modal" data-target="#login-modal">Log In</a></p>

                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-4">
                            <div class="social-login flex-row col-direction m-t-10">
                                <button class="fnb-btn social-btn fb" type="button"><i class="fa fa-facebook-official" aria-hidden="true"></i>Sign up with Facebook</button>
                                <div class="m-b-10">OR</div>
                                <button class="fnb-btn social-btn google" type="button"><i class="fa fa-google-plus" aria-hidden="true"></i>Sign up with Google</button>
                            </div>
                        </div>
                    </div>
                    <p class="text-medium m-b-40"><i class="fa fa-lock" aria-hidden="true"></i> We will not post anything without your permission</p>
                    <hr>
                    <h6 class="text-medium m-t-40">You can also sign up with email. Please enter your details below.</h6>
                </div>

                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
                        <form class="" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="m-b-0 text-lighter float-label required" for="name">Name</label>
                                <input id="name" type="text" class="form-control fnb-input float-input" name="name" value="{{ old('name') }}" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="m-b-0 text-lighter float-label required" for="email">E-Mail</label>
                                <input id="email" type="email" class="form-control fnb-input float-input" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="m-b-0 text-lighter float-label required" for="phone">Phone Number</label>
                                <input id="phone" type="tel" class="form-control fnb-input float-input" name="phone" value="" required>
                            </div>

                            <div class="form-group p-t-10 p-b-10">
                                <!-- <label class=" text-lighter required">What describes you the best?</label> -->
                                <select class="form-control fnb-select border-bottom text-lighter">
                                    <option>Please select at least one</option>
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group p-t-10 p-b-10">
                                        <!-- <label class=" text-lighter required">City</label> -->
                                        <select class="form-control fnb-select border-bottom text-lighter">
                                            <option>City</option>
                                            <option>1</option>
                                            <option>2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group p-t-10 p-b-10">
                                        <!-- <label class=" text-lighter required">Area</label> -->
                                        <select class="form-control fnb-select border-bottom text-lighter">
                                            <option>Area</option>
                                            <option>1</option>
                                            <option>2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="m-b-0 text-lighter float-label required" for="password">Password</label>
                                <input id="password" type="password" class="form-control fnb-input float-input" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="m-b-0 text-lighter float-label required" for="password-confirm">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control fnb-input float-input" name="password_confirmation" required>
                            </div>

                            <div class="form-group m-t-30 m-b-40">
                                <label class="flex-row">
                                      <input type="checkbox" class="checkbox" for="accept_terms">
                                      <div class="text-medium m-b-0" id="accept_terms">I accept the <a href="#" class="secondary-link">Terms of Service</a> &amp; <a href="#" class="secondary-link">Privacy Policy</a> of F&amp;B Circle</div>
                                </label>
                            </div>

                            <div class="form-group text-center m-t-20 m-b-20">
                                <button type="submit" class="btn btn-lg fnb-btn primary-btn border-btn">
                                    Register
                                </button>
                            </div>
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
                        <p class="default-size subCaption text-lighter">Stay upto date and profit from the latest Hospitality industry News, Trends and Research.</p>
                    </li>
                    <li>
                        <span class="why-icon supplier"></span>
                        <!-- <img src="img/suppliers.png" class="img-responsive m-t-20 m-b-20 icons" alt=""> -->
                        <p class="element-title subTitle">Your own Purchase Department</p>
                        <p class="default-size subCaption text-lighter">Find the best vendors for your products & services or let them come to you.</p>
                    </li>
                    <li>
                        <!-- <img src="img/jobs.png" class="img-responsive m-t-20 m-b-20 icons" alt=""> -->
                        <span class="why-icon jobs"></span>
                        <p class="element-title subTitle">Your own H.R. Department</p>
                        <p class="default-size subCaption text-lighter">Hire the best talent to manage your business or find the most suitable job for yourself.</p>
                    </li>
                    <li>
                        <!-- <img src="img/updates.png" class="img-responsive m-t-20 m-b-20 icons" alt=""> -->
                        <span class="why-icon news"></span>
                        <p class="element-title subTitle">Sales for Vendors/Suppliers</p>
                        <p class="default-size subCaption text-lighter">Find new products &amp; opportunities and take your products to news customers.</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
