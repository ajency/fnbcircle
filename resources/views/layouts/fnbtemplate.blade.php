<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title> @yield('title')</title>
    <!-- Google font cdn -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
    <!-- Font awesome cdn -->
    <link rel="stylesheet" type="text/css" href="/css/font-awesome/css/font-awesome.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <!-- Main styles -->
    <link rel="stylesheet" href="/css/main.css">
    @yield('css')
</head>

<body class="nav-md">
    <!-- header -->
    <header class="fnb-header">
        <nav class="navbar navbar-default">
            <div class="container-fluid nav-gap">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header mobile-head mobile-flex">
                    <div class="mobile-head__left mobile-flex">
                        <i class="fa fa-bars sideMenu" aria-hidden="true"></i>
                        <a class="navbar-brand" href="/"><img src="/img/logo-fnb.png" class="img-responsive"></a>
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
                        <li>
                            <p class="mobile-top__text">Sign in to get a personalised feed!</p>
                        </li>
                        @if(Auth::guest())
                            <li>
                                    <!-- <button type="button" class="fnb-btn outline bnw">Login</button> -->
                                    <button type="button" class="fnb-btn outline bnw" data-toggle="modal" data-target="#login-modal">Login</button></li>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('logout') }}" class="login" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-user-circle user-icon nav-color" aria-hidden="true"></i>
                                    <p class="login__title nav-title-size p-l-10 nav-color">Logout</p>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @endif
                    </ul>
                    <ul class="nav navbar-nav city-select">
                        <!-- <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> -->
                        <li>
                            <select class="form-control fnb-select">
                                <option>--Change city--</option>
                                <option selected="">Pune</option>
                                <option>Delhi</option>
                                <option>Mumbai</option>
                                <option>Goa</option>
                            </select>
                        </li>
                    </ul>
                    <p class="mobile-side-title">Browse</p>
                    <ul class="nav navbar-nav navbar-right side-section">
                        <li>
                            <a href="" class="nav-title-size">Directory</a>
                        </li>
                        <li>
                            <a href="" class="nav-title-size">Jobs</a>
                        </li>
                        <li>
                            <a href="" class="nav-title-size">News</a>
                        </li>
                        <li class="mobile-hide">
                            <button class="btn fnb-btn outline mini quote-btn half-border">Get Multiple quotes</button>
                        </li>
                        <li class="mobile-hide">
                             @if(Auth::guest())
                                <a href="#" class="login" data-toggle="modal" data-target="#login-modal">
                                    <i class="fa fa-user-circle user-icon" aria-hidden="true"></i>
                                    <p class="login__title nav-title-size p-l-10">Login</p>
                                </a>
                            @else
                                <a href="{{ route('logout') }}" class="login" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-user-circle user-icon nav-color" aria-hidden="true"></i>
                                    <p class="login__title nav-title-size p-l-10 nav-color">Logout</p>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            @endif
                        </li>
                        <li class="mobile-hide">
                            <a href="" class="side-menu">
                                <i class="fa fa-bars ham" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
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
    @yield('content')


    <!-- jquery -->
    <!-- <script type="text/javascript" src="http://code.jquery.com/jquery-3.2.1.min.js"></script> -->
    <script type="text/javascript" src="/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- BS Script -->
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <!-- Smooth Mouse scroll -->
    <script type="text/javascript" src="/js/jquery.easeScroll.min.js"></script>
    <!-- BS lightbox -->
    <!-- <script type="text/javascript" src="bower_components/ekko-lightbox/dist/ekko-lightbox.min.js"></script> -->
 
      <script type="text/javascript" src="/js/parsley.min.js" ></script>
    @yield('js')
</body>

</html>
