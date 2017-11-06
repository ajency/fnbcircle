<!-- header -->

<?php $htype = !empty($header_type) ? ($header_type=='home-header' ? 'trans-header home-header' : 'trans-header') : ''; ?>
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
                                <a href="<?php echo route('logout') ?>" class="fnb-btn outline bnw close-sidebar">Logout</a>
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
                                    <option title="<?php  echo $city_value->slug ?>" value="http://localhost:8000/<?php  echo $city_value->slug ?>/" <?php if(isset($city) && $city == $city_value->slug) { ?> selected="" <?php } ?>><?php echo $city_value->name ?></option>
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
                                    <a href="<?php  echo  route('logout') ?> " class="login">
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