<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="/img/logo-fnb.png" />
    <title>@yield('title')</title>
    @yield('openGraph')
    @yield('meta') 
    <!-- Google font cdn -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
    <!-- Font awesome cdn -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}">
    <!-- Magnify css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/magnify.css') }}">
    <!-- Internationalization CSS -->
    <link rel="stylesheet" href="{{ asset('/bower_components/intl-tel-input/build/css/intlTelInput.css') }}">
    <!-- Main styles -->
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
    @yield('css')

    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "WebSite",
        "name": "{{env('APP_NAME')}}",
        "url": "{{env('APP_URL')}}"
    }
    </script>
</head>

 
<body class="nav-md overflow-hidden">
 
    <div class="page-shifter animate-row">
 
    <!-- header -->
    <!-- page shifter start-->
    <header class="fnb-header {{ !empty($header_type) ? ($header_type=='home-header' ? 'trans-header home-header' : 'trans-header') : '' }}">
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
                    <ul class="mobile-top mobile-flex align-top">
                        @if(Auth::guest())
                            <li><p class="mobile-top__text x-small">Sign in to get a personalised feed!</p></li>
                            <li><button type="button" class="fnb-btn outline bnw close-sidebar" data-toggle="modal" data-target="#login-modal">Login</button></li>
                        @else
                            <!-- <li><p class="mobile-top__text x-small">Find suppliers, jobs and a lot more</p></li> -->
                            
                            <li class="full-width text-center">
                                <div class="dropdown user-logged">
                                    <i class="fa fa-user-circle user-icon nav-color p-r-5" aria-hidden="true"></i>
                                    <p class="userName text-medium m-b-0 x-small p-r-5 ellipsis">{{ Auth::user()->name }}</p>
                                  <!-- <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-trigger flex-row">
                                     
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                  </button> -->
                                  <!-- <ul class="dropdown-menu card arrowBox" aria-labelledby="dLabel">
                                        <li><a href="{{url('customer-dashboard')}}"><i class="fa fa-tachometer text-color p-r-5" aria-hidden="true"></i> My Dashboard</a></li>
                                        <li><a href="{{url('profile/basic-details')}}"><i class="fa fa-user text-color p-r-5" aria-hidden="true"></i> My Profile</a></li>
                                        <li><a href="{{ route('logout') }}"><i class="fa fa-power-off text-color p-r-5" aria-hidden="true"></i> Logout</a></li>
                                    </ul> -->
                                </div>
                            </li>
                        @endif
                    </ul>
                    <ul class="nav navbar-nav city-select">
                        <!-- <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> -->
                        <li>
                            
                            <select class="form-control fnb-select nav-color" onchange="location = this.value;">
                                <option>--Change State--</option>
                                @foreach(getPopularCities() as $city_index => $city_value)
                                    <option title="{{ $city_value->slug }}" value="{{ url($city_value->slug) }}" @if(getUserSessionState() && getUserSessionState() == $city_value->slug) selected="" @endif>{{ $city_value->name }}</option>
                                @endforeach
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
                                @if(Auth::guest())
                                    <a href="#" class="login" data-toggle="modal" data-target="#login-modal">
                                        <i class="fa fa-user-circle user-icon nav-color" aria-hidden="true"></i>
                                        <p class="login__title nav-title-size p-l-10 nav-color">Login</p>
                                    </a>
                                @else
                                    <!-- <a href="{{ route('logout') }}" class="login">
                                        <i class="fa fa-user-circle user-icon nav-color" aria-hidden="true"></i>
                                        <p class="login__title nav-title-size p-l-10 nav-color">Logout</p>
                                    </a> -->
                                    <!-- <p class="login__title nav-title-size p-l-10 nav-color">Welcome User!

                                    </p> -->
                                    <div class="dropdown user-logged">
                                      <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-trigger">
                                         <p class="userName text-medium m-b-0 default-size p-r-5 ellipsis">Welcome, <b>{{ Auth::user()->name }}</b></p>
                                         <!-- <i class="fa fa-user-circle user-icon nav-color" aria-hidden="true"></i> -->
                                        <!-- <span class="caret"></span> -->
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                      </button>
                                      <ul class="dropdown-menu card arrowBox" aria-labelledby="dLabel">
                                        @if(Auth::user()->type == 'internal')
                                        <li><a href="{{url('customer-dashboard')}}"><i class="fa fa-tachometer text-color p-r-5" aria-hidden="true"></i> My Dashboard</a></li>
                                        @endif
                                        <li><a href="{{url('profile/basic-details')}}"><i class="fa fa-user text-color p-r-5" aria-hidden="true"></i> My Profile</a></li>
                                        <li><a href="{{ route('logout') }}"><i class="fa fa-power-off text-color p-r-5" aria-hidden="true"></i> Logout</a></li>
                                      </ul>
                                    </div>
                                    <!-- <a href="{{ route('logout') }}" class="login" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-user-circle user-icon nav-color" aria-hidden="true"></i>
                                        <p class="login__title nav-title-size p-l-10 nav-color">Logout</p>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form> -->
                                @endif
                            </li>
                            <li class="mobile-hide hidden">
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
                        @if(!Auth::guest())
                        @if(Auth::user()->type == 'internal')
                        <li class="desk-hide">
                            <a href="{{url('customer-dashboard')}}" class="nav-title-size">My Dashboard</a>
                        </li>
                        @endif
                        <li class="desk-hide">
                            <a href="{{url('profile/basic-details')}}" class="nav-title-size">My Profile</a>
                        </li>
                        @endif  
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
                        @if(!Auth::guest())
                        <li>
                            <a href="{{ route('logout') }}" class="nav-title-size">Logout</a>
                        </li>
                        @endif
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

    </div>
    <!-- Modals -->
    <!-- Email / Social Signin Popup -->
    @if(Auth::guest())
        @include('modals.login')
    @endif

    <!-- requirement popup signup -->
    @if(!Auth::guest() && !Auth::user()->has_required_fields_filled)
        @include('modals.user_requirement')
    @endif

    <!-- Email Verification popup -->
    @include('modals.verification.email-modal')

    <!-- Mobile Verification popup -->
    @include('modals.verification.mobile-modal')

    </div>
    <!-- page shifter end-->
    <!-- banner ends -->
    <div class="site-overlay"></div>
    
    <!-- jquery -->
    <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script> -->
    <script type="text/javascript" src="{{ asset('/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- BS Script -->
    <script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <!-- Smooth Mouse scroll -->
    <script type="text/javascript" src="{{ asset('/js/jquery.easeScroll.min.js') }}"></script>
    <!-- BS lightbox -->
    <script type="text/javascript" src="{{ asset('bower_components/ekko-lightbox/dist/ekko-lightbox.min.js') }}"></script>
    <!-- Magnify popup plugin -->
    <script type="text/javascript" src="{{ asset('/js/magnify.min.js') }}"></script>
    <!-- Read more -->
    <script type="text/javascript" src="{{ asset('/js/readmore.min.js') }}"></script>
    <!-- Parsley text validation -->
    <script type="text/javascript" src="{{ asset('/js/parsley.min.js') }}" ></script>
    <!-- Internationalization plugin -->
    <script type="text/javascript" src="{{ asset('/bower_components/intl-tel-input/build/js/intlTelInput.min.js') }}"></script>
    <!-- custom script -->
    <script type="text/javascript" src="{{ asset('/js/custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/verification.js') }}"></script>

    @if(!Auth::guest() && !Auth::user()->has_required_fields_filled)
        <!-- This is defined here as the "require" modal is included to this blade -->
        <script type="text/javascript" src="{{ asset('/bower_components/tether/src/js/utils.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/contact_flag_initialization.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#requirement_form input[name='contact']").intlTelInput();
                $("#require-modal").modal('show');
            });
        </script>
    @endif

    @yield('js')
</body>

</html>