<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    @yield('meta') 
    @yield('openGraph')
    <link rel="shortcut icon" href="/img/logo-fnb.png" />
    <!-- <title>Homepage</title> -->
    <title> @yield('title')</title>

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

<body class="nav-md">
    <!-- header -->
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
                    <ul class="mobile-top mobile-flex">
                        @if(Auth::guest())
                            <li><p class="mobile-top__text x-small">Sign in to get a personalised feed!</p></li>
                            <li><button type="button" class="fnb-btn outline bnw close-sidebar" data-toggle="modal" data-target="#login-modal">Login</button></li>
                        @else
                            <li><p class="mobile-top__text x-small">Find suppliers, jobs and a lot more</p></li>
                            <li>
                                <a href="{{ route('logout') }}" class="fnb-btn outline bnw close-sidebar">Logout</a>
                                <!-- <a href="{{ route('logout') }}" class="fnb-btn outline bnw close-sidebar" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form> -->
                            </li>
                        @endif
                    </ul>
                    <ul class="nav navbar-nav city-select">
                        <!-- <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> -->
                        <li>
                            <select class="form-control fnb-select nav-color" onchange="location = this.value;">
                                <option>--Change city--</option>
                                @foreach(getPopularCities() as $city_index => $city_value)
                                    <option value="http://localhost:8000/{{ $city_value->slug }}/" @if(isset($city) && $city == $city_value->slug) selected="" @endif>{{ $city_value->name }}</option>
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
                                @endif
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

    <!-- content -->
    @yield('content')

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