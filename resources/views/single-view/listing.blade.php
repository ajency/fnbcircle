@extends('layouts.single-view')
@section('title', $data['pagetitle'] )
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="/css/jquery.flexdatalist.min.css">
@endsection
@section('js')
    @parent
    <!-- Dropify -->
      <script type="text/javascript" src="/js/dropify.js"></script>
      <!-- custom script -->
      <script type="text/javascript" src="/js/flex-datalist/jquery.flexdatalist.min.js"></script>
      <script type="text/javascript" src="/js/bootstrap-multiselect.js"></script>
      <!-- <script type="text/javascript" src="/js/maps.js"></script> -->
@endsection

@section('opengraph')
<!-- SEo section here -->
@endsection

@section('single-view-data')
     <div class="container">
        <div class="row m-t-30 m-b-30 mobile-flex breadcrums-container single-breadcrums">
            <div class="col-sm-8  flex-col">
                <!-- Breadcrums -->
                <ul class="fnb-breadcrums flex-row">
                    <li class="fnb-breadcrums__section">
                        <a href="">
                            <i class="fa fa-home home-icon" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="fnb-breadcrums__section">
                        <a href="">
                            <p class="fnb-breadcrums__title">/</p>
                        </a>
                    </li>
                    <li class="fnb-breadcrums__section">
                        <a href="">
                            <p class="fnb-breadcrums__title">{{$data['city']['name']}}</p>
                        </a>
                    </li>
                    <li class="fnb-breadcrums__section">
                        <a href="">
                            <p class="fnb-breadcrums__title">/</p>
                        </a>
                    </li>
                    <li class="fnb-breadcrums__section">
                        <a href="">
                            <p class="fnb-breadcrums__title main-name">{{$data['title']['name']}}</p>
                        </a>
                    </li>
                </ul>
                <!-- Breadcrums ends -->
            </div>
            <div class="col-sm-4 flex-col">
                <!-- Slide navigation -->
                <div class="slide-nav flex-row">
                     <p class="m-b-0 published-title">Published on {{$data['publish_date']}}</p>
                    <button type="button" class="share-btn flex-row"><span class="fnb-icons share"></span> Share</button>
                </div>
                <!-- slide navigation ends -->
            </div>
        </div>
         <!-- premium benefits -->
        <div class="row">
            <div class="col-sm-12">
                <div class="pre-benefits flex-row">
                    <div class="pre-benefits__intro flex-row">
                        
                        <img src="../public/img/power-icon.png" class="img-repsonsive" width="50">
                        <div class="pre-benefits__content">
                            <h5 class="section-title pre-benefits__title">What are the benefits of registering as premium?</h5>
                            <p class="sub-title pre-benefits__caption lighter text-color m-b-0">You are currently using a free version of F&amp;BCircle to upgrade to the premium version</p>
                        </div>
                    </div>
                    <button type="button" class="btn fnb-btn primary-btn full border-btn upgrade">Upgrade Premium</button>
                </div>
            </div>
        </div>
        <!-- premium benefits ends -->
        <!-- edit business listing  is this required?????? -->
        <div class="row">
            <div class="col-sm-8"></div>
            <div class="col-sm-4">
                <div class="edit-listing text-right">
                    <a class="secondary-link flex-row edit-listing__container" href="">
                        <i class="fa fa-pencil-square-o p-r-5 edit-icon" aria-hidden="true"></i>
                        <p class="section-title m-b-0">Edit business listing</p>
                    </a>
                </div>
            </div>
        </div>
        <!-- business listing ends -->
        <div class="row">
            <div class="col-sm-8">
                <div class="spacer">
                    <!-- Card Info starts -->
                    <div class="seller-info card design-2-card">
                        <div class="seller-info__header flex-row"></div>
                        <div class="seller-info__body">
                            <div class="flex-row space-between">
                                <h3 class="seller-info__title main-heading">{{$data['title']['name']}}</h3>
                                <a href="" class="secondary-link"><p class="m-b-0"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</p></a>
                                <img src="/img/power-seller.png" class="img-responsive mobile-hide" width="130">
                                <img src="/img/power-icon.png" class="img-responsive desk-hide" width="30">
                            </div>
                            <div class="location flex-row">
                                <span class="fnb-icons map-icon"></span>
                                <p class="location__title c-title"> {{$data['city']['name']}}<span class="map-link heavier">(Map)</span></h6>
                            </div>
                            <div class="stats flex-row m-t-25">
                                <div class="rating-view flex-row">
                                    <div class="rating">
                                        <div class="bg"></div>
                                        <div class="value" style="width: {{$data['rating']}}%;"></div>
                                    </div>
                                    <div class="views p-l-20 flex-row">
                                        <span class="fnb-icons eye-icon"></span>
                                        <p class="views__title c-title"><span>{{$data['views']}}</span> Views</p>
                                    </div>
                                    @if($data['verified'])
                                    <div class="p-l-20 verified flex-row">
                                        <span class="fnb-icons verified-icon"></span>
                                        <p class="c-title">Verified</p>
                                    </div>
                                    @endif
                                </div>
                                <label class="fnb-label wholesaler flex-row">
                                    <i class="fa fa-user user p-r-5" aria-hidden="true"></i>
                                    {{$data['type']}}
                                </label>
                                
                                <!-- <div class="verified-toggle flex-row">
                                    <p class="m-b-0 text-color mobile-hide">Un-Verified</p>
                                    <div class="toggle m-l-10 m-r-10">
                                      <input type="checkbox" class="toggle__check">
                                      <b class="switch"></b>
                                      <b class="track"></b>
                                    </div>
                                    <p class="m-b-0 text-color toggle-state">Verified</p>
                                </div> -->
                            </div>
                            <div class="operations p-t-5">
                                <h6 class="operations__title">Areas of operation of {{$data['title']['name']}}</h6>
                                @foreach($data['operationAreas'] as $city)
                                <div class="opertaions__container flex-row">
                                    <div class="location flex-row">
                                        <span class="fnb-icons map-icon"></span>
                                        <p class="location__title c-title">{{$city['name']}} <i class="fa fa-caret-right p-l-5" aria-hidden="true"></i></h6>
                                    </div>
                                    <ul class="cities flex-row p-l-10">
                                        @foreach($city['areas'] as $area)
                                        @if($loop->last)
                                        <li>
                                            <p class="cities__title">{{$area['name']}} </p>
                                        </li>
                                        @else
                                        <li>
                                            <p class="cities__title">{{$area['name']}}, </p>
                                        </li>
                                        @endif
                                        @endforeach
                                        @if(count($city['areas']) > 5)
                                        <li class="remain more-show">
                                            <a href="" class="secondary-link remain__number">+{{count($city['areas']) - 5}}</a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="seller-info__footer p-t-20">
                            <div class="contact flex-row">
                                <div class="contact__info flex-row">
                                    <!-- If logged in -->
                                    <button class="btn fnb-btn primary-btn full border-btn show-info" data-toggle="collapse" href="#contact-data">Show contact info</button>

                                    <!-- If not logged in -->
                                    <!-- <button class="btn fnb-btn outline full border-btn" data-toggle="modal" data-target="#contact-modal" href="#contact-modal">Show contact info</button> -->

                                    <!-- <h1 class="m-b-0">20</h1> -->
                                    <p class="contact__title lighter">This lisiting got <b>50+</b> contact requests</p>
                                </div>
                                <!-- <div class="contact__date">
                                    <p class="contact__title"><i>Published on 20 Dec 2016</i></p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <!-- Card info ends -->
                    <!-- contact info -->
                    <div class="card seller-info sell-re collapse" id="contact-data">
                        <div class="contact-info">
                            <div class="close-contact" data-toggle="collapse" href="#contact-data">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </div>
                            <div class="phone collapse-section m-b-20">
                                <h6 class="collapse-section__title">Phone no:</h6>
                                <div class="number flex-row">
                                    <a class="number__real text-secondary" href="callto:+919293939393">+91 9293939393, </a>
                                    <a class="number__real text-secondary" href="callto:+919293939393">+91 9293939393</a>
                                </div>
                            </div>
                            <div class="mail-us collapse-section m-t-20 m-b-20">
                                <h6 class="collapse-section__title">Mail us at:</h6>
                                <div class="number flex-row">
                                    <a class="number__real text-secondary" href="mailto:mysticalinfo@gmail.com">mysticalinfo@gmail.com</a>
                                </div>
                            </div>
                            <div class="message flex-row">
                                <span class="fnb-icons exclamation"></span>
                                <p class="message__title p-l-10">When you contact, don't forget to mention that you found this listing on FnBcircle</p>
                            </div>
                        </div>
                    </div>
                    <!-- contact info ends -->
                    <!-- tabs structure -->
                    <div class="nav-info m-t-20 p-t-20">
                        <div class="sticky-section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <ul class="nav-info__tabs flex-row">
                                            <!-- <li class="nav-section"><a class="active" href="#updates">Recent updates</a></li> -->
                                            <li class="nav-section"><a href="#listed">Listed In</a></li>
                                            <li class="nav-section"><a href="#overview">Overview</a></li>
                                            <li class="nav-section"><a href="#business">Similar Businesses</a></li>
                                            <!-- <li class="nav-section"><a href="#article">Articles</a></li> -->
                                        </ul>
                                    </div>
                                   <!--  <div class="col-sm-4">
                                        <div class="text-center">
                                            <button class="btn fnb-btn primary-btn full border-btn enquiry-btn">Send an Enquiry</button>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <ul class="nav-info__tabs flex-row">
                            <!-- <li class="nav-section"><a class="active" href="#updates">Recent updates</a></li> -->
                            <li class="nav-section"><a href="#listed">Listed In</a></li>
                            <li class="nav-section"><a href="#overview">Overview</a></li>
                            <li class="nav-section"><a href="#business">Similar Businesses</a></li>
                        </ul>
                    </div>
                    <!-- tabs structure ends -->
                    <!-- updates section -->

                    <!-- updates section ends -->
                    <!-- listed -->
                    <div class="listed p-t-20 p-b-10" id="listed">
                        <h6 class="element-title">Also Listed In</h6>
                        @foreach($data['categories'] as $category)
                        <div class="listed__section flex-row">
                            <div class="parent-cat flex-row">
                                <span class="fnb-icons cat-icon meat m-r-15"></span>
                                <p class="parent-cat__title cat-size">{{$category['parent']}}</p>
                            </div>
                            <div class="child-cat">
                                <p class="child-cat__title cat-size">{{$category['branch']}}</p>
                            </div>
                            <ul class="fnb-cat flex-row">
                                @foreach($category['nodes'] as $node)
                                <li><a href="" class="fnb-cat__title">{{$node['name']}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @if(!$loop->last)<hr>@endif
                        @endforeach
                    </div>
                    <hr>
                    <!-- listed ends -->
                    <!-- brands -->
                    <div class="brands p-t-20 p-b-20" id="overview">
                        <h6 class="element-title m-b-20">{{$data['title']['name']}} Brands</h6>
                        <ul class="brands__list flex-row">
                            @foreach($data['brands'] as $brand)
                            <li class="flex-row">
                                <!-- <img src="img/tags.png" alt="" class="tags img-responsive"> -->
                                <span class="fnb-icons tags"></span>
                                <p class="sub-title">{{$brand}}</p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Brands ends -->
                    <!-- Highlights -->
                    <div class="highlights p-t-20 p-b-20">
                        <h6 class="element-title m-b-20">{{$data['title']['name']}} Highlights</h6>
                        <ul class="highlights__points">
                            @foreach($data['highlights'] as $highlight)
                            <li class="flex-row">
                                <!-- <img src="img/check.png" alt="" class="img-responsive check p-r-10"> -->
                                <i class="element-title fa fa-check text-lighter p-r-10" aria-hidden="true"></i>
                                <p class="sub-title">{{$highlight}}</p>
                            </li>
                            @endforeach
                           
                        </ul>
                    </div>
                    <!-- highlights ends -->
                    <!-- Description -->
                    <div class="description p-t-20 p-b-20">
                        <h6 class="element-title m-b-20">{{$data['title']['name']}} Description</h6>
                        <p class="sub-title description__detail">{{$data['description']}}</p>
                    </div>
                    <!-- Description ends -->
                    <!-- more-details -->
                    <div class="more-details p-t-20 p-b-20">
                        <!-- <h3 class="main-heading p-b-15">More details of {{$data['title']['name']}}</h3> -->
                        <div class="detail-1 flex-row m-t-25 m-b-25">
                            <div class="year">
                                <p class="element-title heavier m-b-20">Year of establishment</p>
                                <p class="sub-title lighter">{{$data['established']}} </p>
                            </div>
                            <div class="site">
                                <p class="element-title heavier m-b-10">Website</p>
                                <p class="sub-title lighter "><a href="{{$data['website']}}" target="_blank" class="link-click">{{$data['website']}} <i class="fa fa-external-link new-link p-l-5" aria-hidden="true"></i></a></p>
                            </div>
                        </div>
                        <div class="detail-2 flex-row m-t-25 m-b-25">
                            <div class="operation">
                                <p class="element-title heavier m-b-20">Hours of operation @if($data['today']['open'])<span class="text-success">(Open now)</span>@else <span class="text-danger">(Closed now)</span>@endif</p>
                                <p class="sub-title lighter operation__hours">Today {{$data['today']['timing']}} <span class="dis-block data-show m-t-5">
                                @foreach($data['hours'] as $day)
                               <br> {{$day['day']}} {{$day['timing']}} 
                                @endforeach</span><a href="" class="secondary-link heavier p-l-10 more-show">See more</a></p>
                            </div>
                        </div>
                        <div class="detail-3 flex-row m-t-25 m-b-25">
                            <div class="address">
                                <p class="element-title heavier m-b-20">Address {{$data['title']['name']}}</p>
                                <p class="sub-title lighter">{{$data['address']}}</p>
                            </div>
                        </div>
                        <div class="detail-4 flex-row m-t-25 m-b-25">
                        <div class="m-t-10" id="map"  style="width:600px;height:250px;"></div>
                        <script type="text/javascript">
                            function initMap() {
                                var uluru = {lat: {{$data['location']['lat']}}, lng: {{$data['location']['lng']}} };
                                var map = new google.maps.Map(document.getElementById('map'), {
                                  zoom: 12,
                                  center: uluru
                                });
                                var marker = new google.maps.Marker({
                                  position: uluru,
                                  map: map
                                });
                              }
                            window.onload = function() {
                                $.ajax({
                                  type: 'post',
                                  url: '/get-map-key',
                                  success: function(data) {
                                    var newScript, src;
                                    key = data['key'];
                                    newScript = document.createElement('script');
                                    newScript.type = 'text/javascript';
                                    newScript.src = src = 'https://maps.googleapis.com/maps/api/js?key=' + key + '&callback=initMap';
                                    newScript.async = true;
                                    newScript.defer = true;
                                    document.getElementsByTagName('head')[0].appendChild(newScript);
                                  }
                                });
                              };
                        </script>
                            <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15380.091383021922!2d73.81245283848914!3d15.483203277923609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bbfc0a93361ccd9%3A0xdd98120b24e5be61!2sPanjim%2C+Goa!5e0!3m2!1sen!2sin!4v1498804405360" width="600" height="250" frameborder="0" style="border:0" allowfullscreen></iframe> -->
                        </div>
                        <div class="detail-4 flex-row m-t-25">
                            <div class="payment-mode">
                                <p class="element-title heavier m-b-20 payment-mode__title">Modes of payment</p>
                                <ul class="credit-card flex-row flex-wrap">
                                    @foreach($data['payments'] as $mode)
                                    <li><i class="fa fa-credit-card" aria-hidden="true"></i> {{$mode}}
                                    </li>
                                    @endforeach
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- more details ends -->
                    <!-- Similar businesses -->
                    <div class="similar-business p-t-20 p-b-20" id="business">
                        <div class="section-start-head m-b-15 flex-row">
                            <h6 class="element-title">Similar Businesses</h6>
                            <a href="" class="secondary-link view-more heavier">View More</a>
                        </div>
                        <div class="similar-business__section flex-row">
                            <div class="card business-card article-col">
                                <div class="business-card__header">
                                    <img src="/img/power-seller.png" class="img-responsive powerSeller" width="100">
                                    <ul class="fnb-cat flex-row">
                                        <li><a href="" class="fnb-cat__title">Chicken Retailer</a></li>
                                        <li><a href="" class="fnb-cat__title">Mutton</a></li>
                                        <li><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                        <li><a href="" class="fnb-cat__title">Pork Wholesaler</a></li>
                                        <li><a href="" class="fnb-cat__title">Egg</a></li>
                                        <li><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                    </ul>
                                    <div class="operations m-t-20">
                                        <span class="dis-block lighter">Area of operations</span>
                                        <ul class="areas flex-row">
                                            <li>
                                                <p class="default-size areas__title">Thane, </p>
                                            </li>
                                            <li>
                                                <p class="default-size areas__title">Navi-mumbai, </p>
                                            </li>
                                            <li>
                                                <p class="default-size areas__title">Dadar, </p>
                                            </li>
                                            <li>
                                                <p class="default-size areas__title">Matunga</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="business-card__body">
                                    <div class="flex-row space-between">
                                        <div class="rating">
                                            <div class="bg"></div>
                                            <div class="value" style="width: 80%;"></div>
                                        </div>
                                        <span class="fnb-icons verified-icon"></span>
                                    </div>
                                    <div class="address">
                                        <p class="sub-title heavier">Kasam quershi sons pvt ltd</p>
                                        <p class="m-b-0 lighter address-title"><i class="fa fa-map-marker p-r-5 loc-icon" aria-hidden="true"></i> Andheri Mumbai</p>
                                    </div>
                                </div>
                                <div class="business-card__footer flex-row">
                                    <p class="sub-title heavier footer-text"><a href="">Get Details <i class="fa fa-caret-right p-l-5" aria-hidden="true"></i></a></p>
                                    <span class="x-small date lighter">Updated on 20 Dec</span>
                                </div>
                            </div>
                            <div class="card business-card article-col">
                                <div class="business-card__header">
                                    <img src="/img/power-seller.png" class="img-responsive powerSeller" width="100">
                                    <ul class="fnb-cat flex-row">
                                        <li><a href="" class="fnb-cat__title">Chicken Retailer</a></li>
                                        <li><a href="" class="fnb-cat__title">Mutton</a></li>
                                        <li><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                        <li><a href="" class="fnb-cat__title">Pork Wholesaler</a></li>
                                        <li><a href="" class="fnb-cat__title">Egg</a></li>
                                        <li><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                    </ul>
                                    <div class="operations m-t-20">
                                        <span class="dis-block lighter">Area of operations</span>
                                        <ul class="areas flex-row">
                                            <li>
                                                <p class="default-size areas__title">Thane, </p>
                                            </li>
                                            <li>
                                                <p class="default-size areas__title">Navi-mumbai, </p>
                                            </li>
                                            <li>
                                                <p class="default-size areas__title">Dadar, </p>
                                            </li>
                                            <li>
                                                <p class="default-size areas__title">Matunga</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="business-card__body">
                                    <div class="flex-row space-between">
                                        <div class="rating">
                                            <div class="bg"></div>
                                            <div class="value" style="width: 80%;"></div>
                                        </div>
                                        <span class="fnb-icons verified-icon"></span>
                                    </div>
                                    <div class="address">
                                        <p class="sub-title heavier">Kasam quershi sons pvt ltd</p>
                                        <p class="m-b-0 lighter address-title"><i class="fa fa-map-marker p-r-5 loc-icon" aria-hidden="true"></i> Andheri Mumbai</p>
                                    </div>
                                </div>
                                <div class="business-card__footer flex-row">
                                    <p class="sub-title heavier footer-text"><a href="">Get Details <i class="fa fa-caret-right p-l-5" aria-hidden="true"></i></a></p>
                                    <span class="x-small date lighter">Updated on 20 Dec</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Similar businesses end -->
                    <!-- Related article section -->




                    <!-- Related article section end -->

                </div>
            </div>
            <div class="col-sm-4">
                <div class="detach-col-1">
                    <!-- core categories -->
                    <div class="equal-col">
                       <div class="core-cat">
                            <h6 class="element-title m-t-0 m-b-15">We specialise in</h6>
                            <ul class="fnb-cat flex-row">
                                @foreach($data['cores'] as $core)
                                <li><a href="" class="fnb-cat__title">{{$core['name']}}</a></li>
                                @endforeach
                            </ul>
                        </div> 
                        <div class="contact__enquiry text-center mobile-hide">                                
                            <!-- <p class="contact__title lighter">This listing got <b>10+</b> enquiries</p> -->
                            <!-- <button class="btn fnb-btn primary-btn full border-btn" type="button" data-toggle="modal" data-target="#enquiry-modal"><i class="p-r-5 fa fa-paper-plane-o" aria-hidden="true"></i> Send an Enquiry</button> -->
                            <div class="approval">
                                <p class="contact__title lighter">{{$data['status']['text']}}</p>
                                <div class="heavier sub-title">{{$data['status']['status']}} </div>
                            </div>
                        </div>
                    </div>
                    <!-- core categories end -->
                    <!-- Claim -->
                    <div class="claim-box p-b-10">
                        <!-- <i class="fa fa-commenting claim__icon" aria-hidden="true"></i> -->
                        <!-- <img src="img/exclamation.png" class="img-reponsive"> -->
                        <span class="fnb-icons exclamation"></span>
                        <p class="claim-box__text sub-title">Is this your business? <a href="">Claim it now.</a><br> or <a href="">Report/Delete</a></p>
                    </div>
                    <!-- claim end -->
                    <!-- Photos and documents -->
                    <div class="docs p-t-20 p-b-20">
                        <h6 class="element-title m-b-15">Photos &amp; Documents of {{$data['title']['name']}}</h6>
                        <div class="photo-gallery">
                            @foreach($data['images'] as $images)
                            @if($loop->first)
                            <div class="photo-gallery__banner">
                                <a href="{{$images['full']}}" class="thumb-click">
                                  <img src="{{$images['full']}}" class="img-responsive main-img">
                                </a>
                            </div>
                            <ul class="photo-gallery__thumbnails flex-row m-t-5 m-b-20">
                            @else

                                <li>
                                    <a href="{{$images['full']}}" class="thumb-click">
                                        <img src="{{$images['thumb']}}" alt="" class="img-responsive">
                                    </a>
                                </li>
                                
                            @endif
                            @if($loop->last)
                            </ul>
                            @endif
                            @endforeach
                        </div>
                        @foreach($data['files'] as $file)
                        <div class="catalogue flex-row p-t-20 p-b-20">
                            <p class="sub-title flex-row"><i class="fa fa-file file-icon p-r-10" aria-hidden="true"></i>
                                {{$file['name']}}
                            </p>
                            <a href="{{$file['url']}}">
                                <span class="fnb-icons download"></span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <!-- documents ends -->
                    <!-- enquiry form -->




                    <!-- enquiry form ends-->
                    <!-- browse category -->
                    <div class="browse-cat">
                        <h6 class="element-title">Browse Categories</h6>
                        <ul class="browse-cat__list m-t-20">
                            <li>
                                <a href="">
                                    <p class="m-b-0 flex-row">
                                        <span class="fnb-icons cat-icon veg">
                                            <!-- <img src="img/veg-option.png"> -->
                                        </span>
                                        Vegetables <span class="total p-l-5 bolder">(218)</span>
                                    </p>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <p class="m-b-0 flex-row">
                                        <span class="fnb-icons cat-icon drinks"></span>
                                        Cold Drinks <span class="total p-l-5 bolder">(28)</span>
                                    </p>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <p class="m-b-0 flex-row">
                                        <span class="fnb-icons cat-icon grocery"></span>
                                        Grocery <span class="total p-l-5 bolder">(56)</span>
                                    </p>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <p class="m-b-0 flex-row">
                                        <span class="fnb-icons cat-icon drinks"></span>
                                        Cold Drinks <span class="total p-l-5 bolder">(28)</span>
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Browse category ends-->
                </div>
            </div>
        </div>
        <div class="row m-t-30 m-b-30 why-row">
            <div class="col-sm-12">
                <!-- why fnb -->
                <div class="why-fnb text-center m-b-30 p-b-30">
                    <h3 class="element-title">Why FnB Circle?</h3>
                    <ul class="points m-t-30 flex-row">
                        <li>
                            <!-- <img src="/img/quotes.png" class="img-responsive m-t-20 m-b-20 icons" alt=""> -->
                            <span class="why-icon quote"></span>
                            <p class="sub-title heavier">Hospitality News</p>
                            <p class="default-size m-b-0 text-lighter why-captions">Stay upto date and profit from the latest Hospitality industry News, Trends and Research</p>
                        </li>
                        <li>
                            <span class="why-icon supplier"></span>
                            <!-- <img src="img/suppliers.png" class="img-responsive m-t-20 m-b-20 icons" alt=""> -->
                            <p class="sub-title heavier">Your own Purchase Department</p>
                            <p class="default-size m-b-0 text-lighter why-captions">Find the best vendors for your products &amp; services or let them come to you.</p>
                        </li>
                        <li>
                            <!-- <img src="img/jobs.png" class="img-responsive m-t-20 m-b-20 icons" alt=""> -->
                            <span class="why-icon jobs"></span>
                            <p class="sub-title heavier">Your own H.R. Department</p>
                            <p class="default-size m-b-0 text-lighter why-captions">Hire the best talent to manage your business or find the most suitable job for yourself.</p>
                        </li>
                        <li>
                            <!-- <img src="img/updates.png" class="img-responsive m-t-20 m-b-20 icons" alt=""> -->
                            <span class="why-icon news"></span>
                            <p class="sub-title heavier">Sales for Vendors/Suppliers</p>
                            <p class="default-size m-b-0 text-lighter why-captions">Find new products &amp; opportunities and take your products to news customers.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
     </div>
     <div class="pos-fixed fly-out side-toggle">
        <div class="mobile-back desk-hide mobile-flex">
            <div class="left mobile-flex">
                <i class="fa fa-arrow-left text-primary back-icon" aria-hidden="true"></i>
                <p class="element-title heavier m-b-0">Back</p>
            </div>
            <div class="right">
            </div>
        </div>
        <div class="fly-out__content">
            <div class="sidebar-updates page-sidebar">
                <div class="page-sidebar__header flex-row space-between mobile-hide">
                    <div class="backLink flex-row">
                        <a href="" class="primary-link p-r-10 element-title article-back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                        <div class="element-title bolder">Updates of {{$data['title']['name']}}</div>
                    </div>
                   <div class="sort flex-row">
                       <p class="m-b-0 text-lighter default-size">Sort</p>
                       <select name="" id="" class="fnb-select">
                           <option>Recent</option>
                           <option>Newer</option>
                           <option>Older</option>
                       </select>
                   </div>
                </div>
                <div class="page-sidebar__body">
                    <div class="update-sec sidebar-article">
                        <div class="update-sec__body update-space">
                            <h6 class="element-title update-sec__heading m-t-15 bolder">
                                {{$data['title']['name']}} recent updates
                            </h6>
                            <p class="update-sec__caption text-lighter">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem obcaecati voluptate debitis, quaerat eum expedita quia veritatis repellendus quod aliquid!
                            </p>
                            <ul class="flex-row update-img">
                                <li><img src="../public/img/gallery-1.png" alt="" width="80"></li>
                                <li><img src="../public/img/gallery-1.png" alt="" width="80"></li>
                                <li><img src="../public/img/gallery-1.png" alt="" width="80"></li>
                            </ul>
                            <p class="m-b-0 posted-date text-secondary flex-row"><i class="fa fa-clock-o sub-title p-r-5" aria-hidden="true"></i> Posted 1 day ago</p>
                        </div>
                    </div>
                    <div class="update-sec sidebar-article">
                        <div class="update-sec__body update-space">
                            <h6 class="element-title update-sec__heading m-t-15 bolder">
                                {{$data['title']['name']}} recent updates
                            </h6>
                            <p class="update-sec__caption text-lighter">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem obcaecati voluptate debitis, quaerat eum expedita quia veritatis repellendus quod aliquid!
                            </p>
                            <ul class="flex-row update-img">
                                <li><img src="../public/img/gallery-1.png" alt="" width="80"></li>
                                <li><img src="../public/img/gallery-1.png" alt="" width="80"></li>
                                <li><img src="../public/img/gallery-1.png" alt="" width="80"></li>
                            </ul>
                            <p class="m-b-0 posted-date text-secondary flex-row"><i class="fa fa-clock-o sub-title p-r-5" aria-hidden="true"></i> Posted 1 day ago</p>
                        </div>
                    </div>
                    <div class="update-sec sidebar-article">
                        <div class="update-sec__body update-space">
                            <h6 class="element-title update-sec__heading m-t-15 bolder">
                                {{$data['title']['name']}} recent updates
                            </h6>
                            <p class="update-sec__caption text-lighter">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem obcaecati voluptate debitis, quaerat eum expedita quia veritatis repellendus quod aliquid!
                            </p>
                            <ul class="flex-row update-img">
                                <li><img src="../public/img/gallery-1.png" alt="" width="80"></li>
                                <li><img src="../public/img/gallery-1.png" alt="" width="80"></li>
                                <li><img src="../public/img/gallery-1.png" alt="" width="80"></li>
                            </ul>
                            <p class="m-b-0 posted-date text-secondary flex-row"><i class="fa fa-clock-o sub-title p-r-5" aria-hidden="true"></i> Posted 1 day ago</p>
                        </div>
                    </div>
                    <div class="update-sec sidebar-article">
                        <div class="update-sec__body update-space">
                            <h6 class="element-title update-sec__heading m-t-15 bolder">
                                {{$data['title']['name']}} recent updates
                            </h6>
                            <p class="update-sec__caption text-lighter">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem obcaecati voluptate debitis, quaerat eum expedita quia veritatis repellendus quod aliquid!
                            </p>
                            <ul class="flex-row update-img">
                                <li><img src="../public/img/gallery-1.png" alt="" width="80"></li>
                                <li><img src="../public/img/gallery-1.png" alt="" width="80"></li>
                                <li><img src="../public/img/gallery-1.png" alt="" width="80"></li>
                            </ul>
                            <p class="m-b-0 posted-date text-secondary flex-row"><i class="fa fa-clock-o sub-title p-r-5" aria-hidden="true"></i> Posted 1 day ago</p>
                        </div>
                    </div>
                </div>
                <div class="page-sidebar__footer"></div>
            </div>  
        </div>
    </div>
@endsection
