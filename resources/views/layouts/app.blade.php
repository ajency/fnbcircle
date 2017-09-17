<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <link rel="shortcut icon" href="/img/logo-fnb.png" />
    <title>Homepage</title>
    <!-- Google font cdn -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
    <!-- Font awesome cdn -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <!-- Magnify css -->
    <link rel="stylesheet" type="text/css" href="/css/magnify.css">
    <!-- Main styles -->
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
    <!-- header -->
    <header class="fnb-header trans-header home-header">
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
                        @if(Auth::guest())
                            <li><p class="mobile-top__text">Sign in to get a personalised feed!</p></li>
                            <li><button type="button" class="fnb-btn outline bnw close-sidebar" data-toggle="modal" data-target="#login-modal">Login</button></li>
                        @else
                            <li><p class="mobile-top__text">Find suppliers, jobs and a lot more</p></li>
                            <li><a href="{{ route('logout') }}" class="fnb-btn outline bnw close-sidebar" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                        @endif
                    </ul>
                    <ul class="nav navbar-nav city-select">
                        <!-- <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> -->
                        <li>
                            <select class="form-control fnb-select nav-color">
                                <option>--Change city--</option>
                                <option selected="">Pune</option>
                                <option>Delhi</option>
                                <option>Mumbai</option>
                                <option>Goa</option>
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
                            <!-- @if(!isset($user))
                            @else
                            @endif -->
                            @if(Auth::guest())
                                <li class="mobile-hide">
                                    <a href="#" class="login" data-toggle="modal" data-target="#login-modal">
                                        <i class="fa fa-user-circle user-icon nav-color" aria-hidden="true"></i>
                                        <p class="login__title nav-title-size p-l-10 nav-color">Login</p>
                                    </a>
                                </li>
                            @else
                                <li class="mobile-hide">
                                    <a href="{{ route('logout') }}" class="login" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-user-circle user-icon nav-color" aria-hidden="true"></i>
                                        <p class="login__title nav-title-size p-l-10 nav-color">Logout</p>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            @endif
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
    <!-- content -->

        @yield('content')

    <!-- Email / Social Signin Popup -->
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
                                    <h6 class="sub-title">No account exist with this email</h6>
                                    <span>Looks like there is no account associated this Email-ID, please create an account or sign in with <b>Facebook</b> or <b>Google</b>.</span>
                                </div>
                                <div class="account-exist wrong-password-error hidden">
                                    <h6 class="sub-title">Incorrect Password</h6>
                                    <span>The password you have enter is incorrect. Are you sure this is your account?</span>
                                </div>
                            </div>
                            <div class="alert alert-warning signin-verification alert-dismissible fade in hidden" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <div class="account-inactive email-exist-error hidden">
                                    <h6 class="sub-title">Your account is not Activated</h6>
                                    <span>Your email id is not verified. A verification mail was sent. Please check your inbox or click here to resend the email.</span>
                                    <!-- <button type="button" class="btn fnb-btn outline border-btn" >Resend Verification Email</button> -->
                                    <a href="#" class="primary-link dis-block" id="verif-resend-btn">Resend Verification Email</a>
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
                                <form method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group text-left m-b-0">
                                        <!-- <input type="text" class="form-control fnb-input float-input required" id="email" placeholder="Email"> -->
                                        <input type="email" class="form-control fnb-input float-input required" id="email" name="email" value="{{ old('email') }}" placeholder="Email">
                                    </div>
                                    <div class="form-group text-left m-b-0">
                                        <!-- <input type="password" class="form-control fnb-input float-input required" id="password" placeholder="Password"> -->
                                        <input type="password" class="form-control fnb-input float-input required" id="password" name="password" placeholder="Password">
                                    </div>
                                    <div class="form-group m-b-0 flex-row space-between forgot-actions">
                                        <label class="stay-logged flex-row text-medium m-b-0 text-color">
                                            <input type="checkbox" class="checkbox"> Stay Logged In
                                        </label>
                                        <a href="#" class="primary-link forget-link">Forgot password?</a>
                                    </div>
                                    <div class="form-group m-b-0">
                                        <button class="btn fnb-btn primary-btn full border-btn log-action log-in" type="submit">Log In <i class="fa fa-circle-o-notch fa-spin"></i></button>
                                    </div>
                                </form>
                            </div>
                            <hr>
                            <div class="form-group m-b-0 flex-row space-between no-account">
                                <div class="text-color">
                                    Don't have an account yet?
                                </div>
                                <!-- <button class="btn fnb-btn outline border-btn" type="button">Sign Up</button> -->
                                <a href="{{ url('register') }}" class="btn fnb-btn outline border-btn" type="button">Sign Up</a>
                            </div>                            
                        </div>
                       <div class="forget-password">
                            <h3 class="welcome-text text-medium">Forgot Password</h3>
                            <p class="text-color m-t-20 m-b-10 default-size help-text">Enter your email address. You will receive an email with a link to reset your password.</p>
                            <div class="form-group text-left m-b-0">
                                <input type="email" class="form-control fnb-input float-input required" id="password" placeholder="Email Address">
                            </div>
                            <div class="form-group m-b-0 m-t-20">
                                <button class="btn fnb-btn primary-btn full border-btn log-action reset-link" type="button"><i class="fa fa-unlock p-r-5" aria-hidden="true"></i> Send password reset link <i class="fa fa-circle-o-notch fa-spin"></i></button>
                            </div>
                            <div class="form-group m-b-0">
                                <div class="text-primary back-login heavier m-t-20"><i class="fa fa-angle-left p-r-5" aria-hidden="true"></i> Back to Log In</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>

    <!-- requirement popup signup -->
    @if(!Auth::guest())
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
                            </div>
                            <div class="form-group">
                                <label class="m-b-0 text-lighter float-label required" for="email">Email</label>
                                <input id="email" type="text" class="form-control fnb-input float-input" name="name" value="{{ Auth::user()->getPrimaryEmail() }}" required="">
                            </div>
                            <div class="row phone-col">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label class="m-b-0 text-lighter float-label filled required" for="phone">Phone Number</label>
                                        <div class="number-code flex-row">
                                          <input type="text" class="form-control fnb-input number-code__region" value="+91" maxlength="3" name="contact_locality">
                                          <input type="tel" class="form-control fnb-input number-code__value" placeholder="xxxxxxxxxx" name="contact" value="{{ Auth::user()->getPrimaryContact()['contact'] }}">
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
                                            <select class="form-control fnb-select border-bottom text-lighter" name="city">
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
                                            <select class="form-control fnb-select border-bottom text-lighter" name="area">
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
                                Save <i class="fa fa-circle-o-notch fa-spin"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif




    <!-- banner ends -->
    <div class="site-overlay"></div>
    <!-- jquery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- BS Script -->
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <!-- Smooth Mouse scroll -->
    <script type="text/javascript" src="/js/jquery.easeScroll.min.js"></script>
    <!-- BS lightbox -->
    <!-- <script type="text/javascript" src="bower_components/ekko-lightbox/dist/ekko-lightbox.min.js"></script> -->
    <!-- Magnify popup plugin -->
    <script type="text/javascript" src="/js/magnify.min.js"></script>
    <!-- Read more -->
    <script type="text/javascript" src="/js/readmore.min.js"></script>
    <!-- custom script -->
    <script type="text/javascript" src="/js/custom.js"></script>
</body>

</html>