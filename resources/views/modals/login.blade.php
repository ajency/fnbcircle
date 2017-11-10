<!-- Login Popup Modal -->
<div class="modal fnb-modal login-modal modal-center fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="logo-style">
                    <img src='/img/logo-fnb.png' class="img-responsive center-block">
                </div>
                <button class="close close-modal" data-dismiss="modal" aria-label="Close">&#10005;</button>
            </div>
            <div class="modal-body">
                <div class="login-body">
                    <div class="login-container">
                        <div class="alert alert-danger alert-dismissible fade in hidden" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <div class="account-exist google-exist-error hidden">
                                <h6 class="sub-title">Please login with Google</h6>
                                <span>Looks like you have an account associated with Google, please login with Google.</span>
                            </div>
                            <div class="account-exist facebook-exist-error hidden">
                                <h6 class="sub-title">Please login with Facebook</h6>
                                <span>Looks like you have an account associated with Facebook, please login with Facebook.</span>
                            </div>
                            <div class="account-exist email-exist-error hidden">
                                <h6 class="sub-title">Please login with Email</h6>
                                <span>Looks like you have an account associated with Email, please login with Email-ID &amp; Password.</span>
                            </div>
                            <div class="account-exist email-suspend-error hidden">
                                <h6 class="sub-title">Your account has been Suspended</h6>
                                <span>We’ve disabled your account. Please contact us at <b>developer@fnbcircle.com</b> .</span>
                            </div>
                            <div class="no-account no-email-error hidden">
                                <h6>Permission Denied</h6>
                                <span>Seems like the access to social login is <b>denied</b> by you. Please <b>confirm</b> the access permission.</span>
                            </div>
                            <div class="no-account-exist no-email-exist-error hidden">
                                <h6 class="sub-title">No account exist with this Email</h6>
                                <span>Looks like there is no account associated to this Email-ID, please create an account or sign in with <b>Facebook</b> or <b>Google</b>.</span>
                            </div>
                            <div class="account-exist wrong-password-error hidden">
                                <h6 class="sub-title">Incorrect Password</h6>
                                <span>The password you have entered is incorrect. Are you sure this is your account?</span>
                            </div>
                            <div class="user-token-expiry token-expiry-error hidden">
                                <h6>Token Expired</h6>
                                <span>Sorry, this link has expired.
                                <a href="{{ url('/send-confirmation-link')}}" class="primary-link dis-block" id="verif-resend-btn">Resend Verification Email</a></span>
                            </div>
                        </div>
                        <div class="alert alert-warning signin-verification alert-dismissible fade in hidden" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <div class="account-inactive email-exist-error hidden">
                                <h6 class="sub-title">Your account is not Activated</h6>
                                <span>Your email id is not verified. A verification mail was sent. Please check your inbox or click here to resend the email.</span>
                                <!-- <button type="button" class="btn fnb-btn outline border-btn" >Resend Verification Email</button> -->
                                <a href="{{ url('/send-confirmation-link')}}" class="primary-link dis-block" id="verif-resend-btn">Resend Verification Email</a>
                            </div>
                            <div class="resend-verification resend-verification-error hidden">
                                <h6 class="sub-title">Your account is not Activated</h6>
                                <span>A verification mail is sent. Please check your inbox or click here to resend the email.</span>
                                <!-- <button type="button" class="btn fnb-btn outline border-btn" >Resend Verification Email</button> -->
                                <a href="{{ url('/send-confirmation-link')}}" class="primary-link dis-block" id="verif-resend-btn">Resend Verification Email</a>
                            </div>
                            <div class="token-already-verified already-verified-error hidden">
                                <h6 class="sub-title">Invalid Request</h6>
                                <span>The account has already been activated.</span>
                                <!-- <button type="button" class="btn fnb-btn outline border-btn" >Resend Verification Email</button> -->
                            </div>
                        </div>
                        

                        <div class="alert alert-success signin-verification alert-dismissible fade in hidden" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h6 class="sub-title">Email Verification Success</h6>
                            <span>Email ID has been verified successfully.</span>
                        </div>
                        <h3 class="welcome-text text-medium">Let's get you inside the Circle.</h3>
                        <div class="social-login flex-row col-direction">
                            <!-- <button class="fnb-btn social-btn fb" type="button"><i class="fa fa-facebook-official" aria-hidden="true"></i>Log in with Facebook</button> -->
                            <a href="{{ url('redirect/facebook') }}" class="fnb-btn social-btn fb"><i class="fa fa-facebook-official" aria-hidden="true"></i>Log in with Facebook</a>
                            <!-- <button class="fnb-btn social-btn google" type="button"><i class="fa fa-google-plus" aria-hidden="true"></i>Log in with Google</button> -->
                            <a href="{{ url('redirect/google') }}" class="fnb-btn social-btn google"><i class="fa fa-google-plus" aria-hidden="true"></i>Log in with Google</a>
                        </div>
                        <div class="alternate-login">
                            <p class="sub-title text-color text-medium m-b-0 alternate-login__title"><span>Already part of the Circle?</span></p>
                            <form method="POST" action="{{ route('login') }}" id="login_form_modal">
                                {{ csrf_field() }}
                                <div class="form-group text-left m-b-0">
                                    <!-- <input type="text" class="form-control fnb-input float-input required" id="email" placeholder="Email"> -->
                                    <input type="email" class="form-control fnb-input float-input required" id="email" name="email" value="{{ old('email') }}" placeholder="Email">
                                    <label id="email-error" class="fnb-errors hidden"></label>
                                </div>
                                <div class="form-group text-left m-b-0">
                                    <!-- <input type="password" class="form-control fnb-input float-input required" id="password" placeholder="Password"> -->
                                    <input type="password" class="form-control fnb-input float-input required" id="password" name="password" placeholder="Password">
                                    <label id="password-error" class="fnb-errors hidden"></label>
                                </div>
                                <div class="form-group m-b-0 flex-row space-between forgot-actions">
                                    <label class="stay-logged flex-row text-medium m-b-0 text-color">
                                        <!-- <input type="checkbox" class="checkbox"> Stay Logged In -->
                                    </label>
                                    <a href="#" class="primary-link forget-link">Forgot password?</a>
                                </div>
                                <div class="form-group m-b-0">
                                    <!-- <button class="btn fnb-btn primary-btn full border-btn log-action log-in" type="submit">Log In <i class="fa fa-circle-o-notch fa-spin"></i></button> -->
                                    <button class="btn fnb-btn primary-btn full border-btn log-action log-in" type="button" id="login_form_modal_btn">Log In <i class="fa fa-circle-o-notch fa-spin hidden"></i></button>
                                </div>
                            </form>
                        </div>
                        <hr/>
                        <div class="form-group m-b-0 flex-row space-between no-account">
                            <div class="text-color">
                                Don't have an account yet?
                            </div>
                            <!-- <button class="btn fnb-btn outline border-btn" type="button">Sign Up</button> -->
                            <a href="{{ url('register') }}" class="btn fnb-btn outline border-btn" type="button">Sign Up</a>
                        </div>                            
                    </div>
                   <div class="forget-password" id="forget-password-div">
                        <div class="alert alert-success forgot-link-sent alert-dismissible fade in hidden" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h6 class="sub-title">Success</h6>
                            <span>We have sent you an email with a link to reset your password. You should be receiving them shortly.</span>
                        </div>
                        <h3 class="welcome-text text-medium">Forgot Password</h3>
                        <p class="text-color m-t-20 m-b-10 default-size help-text">Enter your email address. You will receive an email with a link to reset your password.</p>
                        <!-- <form method="POST" action="{{ route('password.email') }}" id="forgot-password-form" data-parsley-validate=""> -->
                        <form method="POST" action="#" id="forgot-password-form" data-parsley-validate="">
                            <div class="form-group text-left m-b-0">
                                <input type="email" class="form-control fnb-input float-input required" id="forgot_password_email" name="forgot_password_email" placeholder="Email Address" data-parsley-trigger="focusout" data-parsley-type="email" data-parsley-errors-container="#email-error-container">
                            </div>
                            <div id="email-error-container" class="fnb-errors"></div>
                            <div class="form-group m-b-0 m-t-20">
                                <button class="btn fnb-btn primary-btn full border-btn log-action reset-link" type="button" id="forgot-password-form-btn"><i class="fa fa-unlock p-r-5" aria-hidden="true"></i> Send password reset link <i class="fa fa-circle-o-notch fa-spin hidden"></i></button>
                            </div>
                        </form>
                        <div class="form-group m-b-0">
                            <div class="text-primary back-login heavier m-t-20 dis-inline"><i class="fa fa-angle-left p-r-5" aria-hidden="true"></i> Back to Log In</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>