@extends('layouts.app')

@section('content')
<div class="register-holder forget-holder p-t-30">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-lg-offset-2">
                    <div class="dsk-separator m-t-20 m-b-50 sign-page forget-page">
                        <div class="text-center m-t-10">
                            <i class="fa fa-lock text-primary lock" aria-hidden="true"></i>
                        </div>
                        <div class="text-center m-t-30 log-sign">
                            <h5 class="welcome-text">Reset Password</h5>
                            <p class="text-lighter">Please enter your new password</p>
                        </div>

                        <div class="row">
                            <div class="col-sm-8 col-lg-offset-2 sign-up-row">
                                <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="row flex-row flex-wrap signup-container">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-8">
                                            <div class="form-group m-b-10 p-b-10 hidden">
                                                <!-- <label class="m-b-0 text-lighter float-label required" for="new-pass">Email Address</label> -->
                                                <input id="email" type="hidden" class="form-control fnb-input float-input" name="email" value="{{ $email or old('email') }}" required="">
                                                @if ($errors->has('email'))
                                                    <label id="name-error" class="fnb-errors hidden"><strong>{{ $errors->first('email') }}</strong></label>
                                                @endif
                                            </div>
                                            @include('auth.passwords.password-set', array("old_password" => false, "confirm_password" => true))
                                            
                                        </div>
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-12">
                                             <div class="form-group text-center m-t-20 m-b-20 signBtn">
                                                <button type="submit" id="" class="btn btn-primary btn-lg fnb-btn primary-btn border-btn full">Reset Password<i class="fa fa-circle-o-notch fa-spin hidden"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mobile-hide">
                    <hr class="desk-hide">
                    <!-- why fnb -->
                    <div class="why-fnb sign-up-adv text-center m-b-30 p-b-30 m-t-0">
                        <h3 class="element-title">Why FnB Circle?</h3>
                        <ul class="points m-t-20 flex-row flex-wrap forgot-points">
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


@endsection
