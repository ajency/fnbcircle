@extends('layouts.app')

@section('content')
<!-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
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
                                <form class="" method="POST" action="http://stage.fnbcircle.com/register" id="register_form">
                                    <input type="hidden" name="_token" value="nqsuZoHlahPMuKNn0E562uU628DgkN5jWr4B9Whf">

                                    <div class="row flex-row flex-wrap signup-container">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-8">
                                            <div class="form-group m-b-10 p-b-10">
                                                <label class="m-b-0 text-lighter float-label required" for="new-pass">New Password</label>
                                                <input id="new-pass" type="password" class="form-control fnb-input float-input" name="name" value="" required="">
                                                <label id="name-error" class="fnb-errors hidden"></label>
                                            </div>
                                            <div class="form-group m-b-10 p-b-10">
                                                <label class="m-b-0 text-lighter float-label required" for="confirm-password">Confirm Password</label>
                                                <input id="confirm-password" type="password" class="form-control fnb-input float-input" name="name" value="" required="">
                                                <label id="name-error" class="fnb-errors hidden"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-12">
                                             <div class="form-group text-center m-t-20 m-b-20 signBtn">
                                                <button type="button" id="register_form_btn" class="btn btn-lg fnb-btn primary-btn border-btn full">Reset<i class="fa fa-circle-o-notch fa-spin hidden"></i>
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
