<?php $htype = !empty($header_type) ? ($header_type=='home-header' ? 'trans-header home-header' : 'trans-header') : ''; ?>
 <!-- header -->
    <!-- page shifter start-->
    <header class="fnb-header <?php echo $htype ?>">
        <nav class="navbar navbar-default">
            <div class="container-fluid nav-gap">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header mobile-head mobile-flex">
                    <div class="mobile-head__left mobile-flex">
                        <i class="fa fa-bars sideMenu" aria-hidden="true"></i>
                        <a class="navbar-brand nav-color" href="#"><img src="/img/logo-fnb.png" class="img-responsive"></a>
                    </div>
                    <div class="mobile-head__right mobile-flex">
                        <button class="btn fnb-btn outline mini quote-btn half-border">Get Multiple quotes</button>
                         <a href="" class="login">
                            <i class="fa fa-user-circle user-icon" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse m-side-bar" id="bs-example-navbar-collapse-1">
                    <ul class="mobile-top mobile-flex">
                        <?php if(auth()->guest()){ ?>
                            <li><p class="mobile-top__text x-small">Sign in to get a personalised feed!</p></li>
                            <li><button type="button" class="fnb-btn outline bnw close-sidebar" data-toggle="modal" data-target="#login-modal">Login</button></li>
                        <?php } else { ?>
                            <li><p class="mobile-top__text x-small">Find suppliers, jobs and a lot more</p></li>
                            <li>
                                <a href="{{ route('logout') }}" class="fnb-btn outline bnw close-sidebar">Logout</a>
                                <!-- <a href="{{ route('logout') }}" class="fnb-btn outline bnw close-sidebar" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form> -->
                            </li>
                        <?php } ?>
                    </ul>
                    <ul class="nav navbar-nav city-select">
                        <!-- <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> -->
                        <li>
                            
                            <select class="form-control fnb-select nav-color" onchange="location = this.value;">

                                <option>--Change State--</option>
                                <?php foreach(getPopularCities() as $city_index => $city_value) { ?>
                                    <option title="<?php  echo $city_value->slug ?>" value="<?php  echo env('APP_URL').'/'.$city_value->slug ?>/" <?php if(getUserSessionState() && getUserSessionState() == $city_value->slug) { ?> selected="" <?php } ?>><?php echo $city_value->name ?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </li>
                    </ul>
                    <p class="mobile-side-title">Browse</p>
                    <div class="fixed-show">
                        <ul class="nav navbar-nav navbar-right side-section">
                            <li class="fixed-section">
                                <a href="" class="nav-title-size nav-color">
                                    <i class="fa fa-home home-icon" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li>
                                <a href="" class="nav-title-size nav-color">Directory</a>
                            </li>
                            <li>
                                <a href="" class="nav-title-size nav-color">Jobs</a>
                            </li>
                            <li>
                                <a href="" class="nav-title-size nav-color">News</a>
                            </li>
                            <li class="mobile-hide">
                                <button class="btn fnb-btn outline mini quote-btn half-border nav-color">Get Multiple quotes</button>
                            </li>
                           
                            <li class="mobile-hide">
                                <?php if(Auth::guest()){ ?>
                                    <a href="#" class="login" data-toggle="modal" data-target="#login-modal">
                                        <i class="fa fa-user-circle user-icon nav-color" aria-hidden="true"></i>
                                        <p class="login__title nav-title-size p-l-10 nav-color">Login</p>
                                    </a>
                                <?php }
                                else{ ?>
                                    <a href="{{ route('logout') }}" class="login">
                                        <i class="fa fa-user-circle user-icon nav-color" aria-hidden="true"></i>
                                        <p class="login__title nav-title-size p-l-10 nav-color">Logout</p>
                                    </a>
                                    <!-- <a href="{{ route('logout') }}" class="login" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-user-circle user-icon nav-color" aria-hidden="true"></i>
                                        <p class="login__title nav-title-size p-l-10 nav-color">Logout</p>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form> -->
                                <?php } ?>
                            </li>
                            <li class="mobile-hide">
                                <a href="#" class="side-menu">
                                    <i class="fa fa-bars ham nav-color" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right side-section fixed-section">
                            <li>
                                <button class="btn fnb-btn outline full border-btn modify-search"><i class="fa fa-search p-r-5" aria-hidden="true"></i> Modify Search</button>
                            </li>
                            <li>
                                <button class="btn fnb-btn primary-btn full border-btn send-enq">Send Enquiry</button>
                            </li>
                        </ul>
                    </div>
                    <p class="mobile-side-title">Explore</p>
                    <ul class="nav navbar-nav explore side-section">
                        <li>
                            <a href="" class="nav-title-size">About us</a>
                        </li>
                        <li>
                            <a href="" class="nav-title-size">Blogs</a>
                        </li>
                        <li>
                            <a href="" class="nav-title-size">How it works</a>
                        </li>
                        <li>
                           <a href="" class="nav-title-size">Terms of use</a>
                        </li>
                        <li>
                             <a href="" class="nav-title-size">FAQ</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>
    <!-- header ends -->



    <?php if(auth()->guest()){ ?>
        <!-- Login Popup Modal -->
        <div class="modal fnb-modal login-modal modal-center" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                    <div class="email-missing facebook-email-miss-error hidden">
                                        <h6 class="sub-title">Email missing in facebook account</h6>
                                        <span>Looks like you have a facebook account with no email ID. Please update your facebook account with an Email ID or sign up with <b>Google</b> or <b>Email</b></span>
                                    </div>
                                    <div class="email-missing google-email-miss-error hidden">
                                        <h6 class="sub-title">Email missing in google account</h6>
                                        <span>Looks like you have a google account with no email ID. Please update your google account with an Email ID or sign up with <b>Facebook</b> or <b>Email</b></span>
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
                                    <span>We have sent you an email with a link to reset your password. Please click on the link to set a new password.</span>
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
    <?php } ?>
