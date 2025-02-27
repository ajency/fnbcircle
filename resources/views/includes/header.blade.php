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
                        @if(Auth::guest() || Auth::user()->type == "external")
                            <button class="btn fnb-btn outline mini quote-btn half-border enquiry-modal-btn" type="button" data-toggle="modal" data-target="#multi-quote-enquiry-modal">Get Multiple quotes</button>
                        @endif
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
                            
                            <select class="form-control fnb-select {{ !empty($header_type) ? ($header_type=='home-header' ? 'nav-color' : 'nav-color') : '' }}" onchange="location = this.value;">
                                <option title="all" value="{{ url('/all') }}">All</option>
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
                            @php
                                $city_slug_url =(getUserSessionState())?getUserSessionState():'goa';
                            @endphp
                            <li>
                                <a href="{{url('/'.$city_slug_url.'/business-listings')}}" class="nav-title-size nav-color">Directory</a>
                            </li>
                            <li>
                                <a href="{{url('/'.$city_slug_url.'/job-listings')}}" class="nav-title-size nav-color">Jobs</a>
                            </li>
                            <li>
                                <a href="{{url('/news')}}" class="nav-title-size nav-color">News</a>
                            </li>
                            @if(Auth::guest() || Auth::user()->type == "external")
                                <li class="mobile-hide">
                                    <button class="btn fnb-btn outline mini quote-btn enquiry-modal-btn half-border nav-color enquiry-modal-btn" type="button" data-toggle="modal" data-target="#multi-quote-enquiry-modal">Get Multiple quotes</button>
                                </li>
                            @endif
                           
                            <li class="mobile-hide">
                                @if(Auth::guest())
                                    <a href="#" class="login" data-toggle="modal" data-target="#login-modal">
                                        <i class="fa fa-user-circle user-icon nav-color" aria-hidden="true"></i>
                                        <p class="login__title nav-title-size p-l-10 nav-color">Login</p>
                                    </a>
                                @else
                                    <div class="dropdown user-logged">
                                      <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-trigger">
                                         <p class="userName text-medium m-b-0 default-size p-r-5 ellipsis">Welcome, <b>{{ Auth::user()->name }}</b></p>
                                         <!-- <i class="fa fa-user-circle user-icon nav-color" aria-hidden="true"></i> -->
                                        <!-- <span class="caret"></span> -->
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                      </button>
                                      <ul class="dropdown-menu card arrowBox" aria-labelledby="dLabel">
                                        @if(Auth::user()->type == 'external')
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
                        @if(!Auth::guest())
                            @if(Auth::user()->type == 'external')
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
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>
    <!-- header ends -->