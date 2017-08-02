<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title> @yield('title')</title>
    <!-- Google font cdn -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
    <!-- Font awesome cdn -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <!-- Magnify css -->
    <link rel="stylesheet" type="text/css" href="/css/magnify.css">
    <!-- Dropify css -->
    <link rel="stylesheet" type="text/css" href="/css/dropify.css">
    <!-- tags css -->
    <link rel="stylesheet" type="text/css" href="/css/jquery.flexdatalist.min.css">
    <!-- Main styles -->
    <link rel="stylesheet" href="/css/main.css">
    @yield('css')
</head>

<body class="highlight-color">
    <!-- header -->
    <header class="fnb-header">
        <nav class="navbar navbar-default">
            <div class="container-fluid nav-gap">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header mobile-head mobile-flex">
                    <div class="mobile-head__left mobile-flex">
                        <i class="fa fa-bars sideMenu" aria-hidden="true"></i>
                        <a class="navbar-brand" href="#">F&amp;BCircle.in</a>
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
                        <li>
                            <button type="button" class="fnb-btn outline bnw">Login</button>
                        </li>
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
                            <a href="" class="login">
                                <i class="fa fa-user-circle user-icon" aria-hidden="true"></i>
                                <p class="login__title nav-title-size p-l-10">Login</p>
                            </a>
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

    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif
    <!-- jquery -->
    <!-- <script type="text/javascript" src="http://code.jquery.com/jquery-3.2.1.min.js"></script> -->
    <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- BS Script -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- Smooth Mouse scroll -->
    <script type="text/javascript" src="js/jquery.easeScroll.min.js"></script>
    <!-- BS lightbox -->
    <!-- <script type="text/javascript" src="bower_components/ekko-lightbox/dist/ekko-lightbox.min.js"></script> -->
    <!-- Magnify popup plugin -->
    <script type="text/javascript" src="js/magnify.min.js"></script>
    <!-- Read more -->
    <script type="text/javascript" src="js/readmore.min.js"></script>
    <!-- Dropify -->
    <script type="text/javascript" src="js/dropify.js"></script>
    <!-- jquery tags -->
    <script type="text/javascript" src="js/flex-datalist/jquery.flexdatalist.min.js"></script>
      <script type="text/javascript" src="js/parsley.min.js" ></script>
    @yield('js')
</body>

</html>
