@extends('layouts.app')
@section('title', $data['pagetitle'] )
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="/css/jquery.flexdatalist.min.css">
    <link rel="stylesheet" type="text/css" href="/bower_components/jssocials/dist/jssocials.css" />
    <link rel="stylesheet" type="text/css" href="/bower_components/jssocials/dist/jssocials-theme-minima.css" />
@endsection
@section('js')
    @parent
    <!-- Dropify -->
      <script type="text/javascript" src="/js/dropify.js"></script>
      <!-- custom script -->
      <script type="text/javascript" src="/js/flex-datalist/jquery.flexdatalist.min.js"></script>
      <script type="text/javascript" src="/js/bootstrap-multiselect.js"></script>
      <script type="text/javascript" src="/bower_components/jssocials/dist/jssocials.min.js"></script>
      <script type="text/javascript" src="/js/single-list-view.js"></script>
      <!-- <script type="text/javascript" src="/js/maps.js"></script> -->
       @if(Session::has('statusChange'))
    <script> 
       $('#listing-review').modal('show');
    </script>
    @endif
@endsection

@section('meta')
     <meta property="get-posts-url" content="{{action('UpdatesController@getUpdates')}}">
@endsection

@section('openGraph')
<!-- SEo section here -->
    @php
        $ogtag = singleListingOgTags($data['reference']);
        $twitterTag = singleListingTwitterTags($data['reference']);
        $tag = singleListingTags($data['reference']);
    @endphp
    @include('single-view.metatags')
@endsection

@section('content')
    @include('single-view.listing_SEO')
    <!-- <div class="page-shifter animate-row"> -->
        <div class="single-view-head">
         <div class="container">
            <div class="row m-t-30 m-b-20 mobile-flex breadcrums-container single-breadcrums">
                <div class="col-sm-8  flex-col">
                    <!-- Breadcrums -->
                    @php
                        $breadcrumbs = [];
                        $breadcrumbs[] = ['url'=>env('APP_URL').'/', 'name'=>"Home", 'image'=>'/img/logo-fnb.png'];
                        $breadcrumbs[] = ['url'=>$data['city']['url'], 'name'=>$data['city']['name']];
                        $breadcrumbs[] = ['url'=>$data['title']['url'], 'name'=>$data['title']['name']];
                    @endphp
                    @include('single-view.breadcrumbs')
                    <!-- Breadcrums ends -->
                </div>
                <div class="col-sm-4 flex-col listingActions">
                    @if(isset($data['publish_date']) and $data['status']['id'] == '1')
                    <!-- Slide navigation -->
                    <div class="slide-nav flex-row m-b-10 pub-row">
                        <p class="m-b-0 published-title default-size">Published on {{$data['publish_date']}}</p>
                        <div class="dropdown social-drop">
                            <button type="button" class="share-btn flex-row" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-share-alt p-r-5" aria-hidden="true"></i> Share <i class="fa fa-caret-down p-l-5" aria-hidden="true"></i></button>
                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                <div id="shareRoundIcons"></div>
                            </ul>
                        </div>
                    </div>
                    <!-- slide navigation ends -->
                    @endif

                    @if(hasAccess('edit_permission_element_cls',$data['reference'],'listing'))
                    <!-- edit business listing  is this required?????? -->
                    <div class="slide-nav flex-row editList">
                        <a class="no-decor share-btn edit-job edit-listing flex-row" href="/listing/{{$data['reference']}}/edit">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            Edit business listing
                        </a>
                    </div>
                    <!-- business listing ends -->
                    @endif
                </div>
            </div>

             <!-- premium benefits -->
             @if(hasAccess('edit_permission_element_cls',$data['reference'],'listing') and !$data['premium'])
            <div class="row">
                <div class="col-sm-12">
                    <div class="pre-benefits flex-row">
                        <div class="pre-benefits__intro flex-row">
                            
                            <img src="/img/power-icon.png" class="img-repsonsive" width="50">
                            <div class="pre-benefits__content">
                                <h5 class="section-title pre-benefits__title">What are the benefits of registering as premium?</h5>
                                <p class="sub-title pre-benefits__caption lighter text-color m-b-0">You are currently using a free version of FnB Circle to upgrade to the premium version</p>
                            </div>

                        </div>
                        <a href="/listing/{{$data['reference']}}/edit/business-premium" class="btn fnb-btn primary-btn full border-btn upgrade">Upgrade Premium</a>
                    </div>
                </div>
            </div>
            @endif
          
     <!--        @if(hasAccess('edit_permission_element_cls',$data['reference'],'listing'))
            
            <div class="row">
                <div class="col-sm-8"></div>
                <div class="col-sm-4">
                    <div class="edit-listing text-right">
                        <a class="secondary-link flex-row edit-listing__container" href="/listing/{{$data['reference']}}/edit">
                            <i class="fa fa-pencil-square-o p-r-5 edit-icon" aria-hidden="true"></i>
                            <p class="section-title m-b-0">Edit business listing</p>
                        </a>
                    </div>
                </div>
            </div>
      
            @endif -->

            <div class="row">
                <div class="col-sm-8">
                    <div class="spacer">
                        <!-- Card Info starts -->
                        <div class="seller-info card design-2-card new-changes">
                            <div class="seller-info__header flex-row"></div>
                            <div class="seller-info__body">
                                <div class="flex-row space-between">
                                    <h1 class="seller-info__title main-heading">{{$data['title']['name']}}</h1>
                                    <input readonly id='listing_id' value="{{$data['reference']}}" type="hidden">
                                    @if(hasAccess('edit_permission_element_cls',$data['reference'],'listing'))
                                    <!-- <a href="/listing/{{$data['reference']}}/edit" class="secondary-link"><p class="m-b-0"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</p></a> -->
                                    @endif
                                    @if($data['premium'] and $data['status']['id']==1)
                                    <img src="/img/power-seller.png" class="img-responsive mobile-hide" width="130">
                                    <img src="/img/power-icon.png" class="img-responsive desk-hide" width="30">
                                    @endif
                                </div>
                                <div class="location flex-row">
                                    <span class="fnb-icons map-icon"></span>
                                    <p class="location__title c-title"> {{$data['city']['name']}}@isset($data['location'])<span class="map-link heavier"> (Map)</span>@endisset</p>
                                </div>
                                <div class="stats flex-row m-t-25 stat-section">
                                    <div class="rating-view flex-row">
                                        @isset($data['rating'])
                                        <div class="rating">
                                            <div class="bg"></div>
                                            <div class="value" style="width: {{$data['rating']}}%;"></div>
                                        </div>
                                        @endisset
                                        @isset($data['views'])
                                        <div class="views p-l-20 flex-row">
                                            <span class="fnb-icons eye-icon"></span>
                                            <p class="views__title c-title"><span>{{$data['views']}}</span> Views</p>
                                        </div>
                                        @endisset
                                        @isset($data['verified'])
                                        @if($data['verified'])
                                        <div class="p-l-20 verified flex-row">
                                            <span class="fnb-icons verified-icon"></span>
                                            <p class="c-title">Verified</p>
                                        </div>
                                        @endif
                                        @endisset
                                     </div>
                                    <label class="fnb-label wholesaler flex-row text-uppercase">
                                        <a href="#" class="secondary-link">
                                        <i class="fa fa-user user p-r-5" aria-hidden="true"></i>
                                        {{$data['type']}}</a>
                                    </label>
                                </div>
                                @isset($data['operationAreas'])
                                <div class="operations p-t-5 operate-section">
                                    <h2 class="operations__title sub-title m-t-20">Areas of operation of {{$data['title']['name']}}</h2>
                                    @foreach($data['operationAreas'] as $city)
                                    <div class="opertaions__container flex-row">
                                        <div class="location set-width flex-row">
                                            <span class="fnb-icons map-icon"></span>
                                            <p class="location__title c-title default-size">{{$city['name']}} <i class="fa fa-caret-right p-l-5" aria-hidden="true"></i></h6>
                                        </div>
                                        <ul class="cities flex-row p-l-10">
                                            @foreach($city['areas'] as $area)
                                            @if($loop->last)
                                            <li>
                                                <p class="cities__title default-size">{{$area['name']}} </p>
                                            </li>
                                            @else
                                            <li>
                                                <p class="cities__title default-size">{{$area['name']}}, </p>
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
                                @endisset
                            </div>
                            <div class="seller-info__footer p-t-20">
                                <div class="contact flex-row">
                                    <div class="contact__info flex-row">
                                        <!-- If logged in -->
                                        <!-- <button class="btn fnb-btn primary-btn full border-btn show-info" data-toggle="collapse" href="#contact-data">Show contact info</button> -->

                                        <!-- If not logged in -->
                                        <!-- <button class="btn fnb-btn outline full border-btn" data-toggle="modal" data-target="#contact-modal" href="#contact-modal">Show contact info</button> -->

                                        <!-- <p class="m-b-0">20</p> -->
                                        <!-- <p class="contact__title lighter">This lisiting got <b>50+</b> contact requests</p> -->
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
                                    <p class="collapse-section__title">Phone no:</p>
                                    <div class="number flex-row">
                                        <a class="number__real text-secondary" href="callto:+919293939393">+91 9293939393, </a>
                                        <a class="number__real text-secondary" href="callto:+919293939393">+91 9293939393</a>
                                    </div>
                                </div>
                                <div class="mail-us collapse-section m-t-20 m-b-20">
                                    <p class="collapse-section__title">Mail us at:</p>
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
                                                @if(isset($data['updates']) and !empty($data['updates']))<li class="nav-section"><a class="active" href="#updates">Recent updates</a></li> @endif
                                                @isset($data['categories'])<li class="nav-section"><a href="#listed">Listed In</a></li>@endisset
                                                @isset($data['overview'])<li class="nav-section"><a href="#overview">Overview</a></li>@endisset
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
                               @if(isset($data['updates']) and !empty($data['updates'])) <li class="nav-section"><a class="active" href="#updates">Recent updates</a></li>@endif
                                @isset($data['categories'])<li class="nav-section"><a href="#listed">Listed In</a></li>@endisset
                                @isset($data['overview'])<li class="nav-section"><a href="#overview">Overview</a></li>@endisset
                                <li class="nav-section"><a href="#business">Similar Businesses</a></li>
                            </ul>
                        </div>

                    <!-- tabs structure ends -->
                    @if(isset($data['updates']) and !empty($data['updates']))
                    <!-- updates section -->
                     <div class="update-sec m-t-30" id="updates">
                        <!-- <div class="update-sec__header flex-row update-space">
                            <h6 class="element-title m-t-5 m-b-5">Recent Updates</h6>
                            <a href="" class="text-secondary update-sec__link secondary-link open-sidebar">View More</a>
                        </div> -->
                        <div class="update-sec__body update-space">
    
                            <h6 class="element-title update-sec__heading m-t-15 bolder">
                                {{$data['title']['name']}} recent updates
                            </h6>
                            <p class="m-t-20 m-b-5 updateTitle">{{$data['updates']->title}}</p>
                            <p class="update-sec__caption text-lighter">
                                {!! nl2br(e($data['updates']->contents)) !!}
                            </p>
                            <ul class="flex-row update-img">
                            @php $photos = $data['updates']->getImages(); @endphp
                                @foreach($photos as $photo)
                                <li><img src="{{$photo[config('tempconfig.listing-photo-thumb')]}}" alt="" width="80"></li>
                                @endforeach
                            </ul>
                            <p class="m-b-0 text-right"><a href="" class="text-secondary update-sec__link secondary-link open-sidebar view-updates">View More</a></p>
                        </div>
                    </div>
                    <!-- updates section ends -->
                    @endif
                    @isset($data['categories'])
                    <!-- listed -->
                    <div class="listed p-t-20 p-b-10" id="listed">
                        <h3 class="element-title">Also Listed In</h3>
                        @foreach($data['categories'] as $category)
                        <div class="listed__section flex-row">
                            <div class="parent-cat flex-row">
                                <span class="m-r-10">
                                    <img src="{{$category['image-url']}}" width="40">
                                </span>
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
                        @endisset
                        @isset($data['brands'])
                        <!-- brands -->
                        <div class="brands p-t-20 p-b-20" >
                            <p class="element-title m-b-20">{{$data['title']['name']}} Brands</p>
                            <ul class="brands__list flex-row">
                                @foreach($data['brands'] as $brand)<li class="flex-row">
                                    <!-- <img src="img/tags.png" alt="" class="tags img-responsive"> -->
                                    <span class="fnb-icons tags"></span>
                                    <p class="sub-title">{{$brand}}</p>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Brands ends -->
                    @endisset
                    @isset($data['overview'])
                    <div id="overview">
                        @isset($data['highlights'])
                        <!-- Highlights -->
                        <div class="highlights p-t-20 p-b-20">
                            <h3 class="element-title m-b-20">{{$data['title']['name']}} Highlights</h3>
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
                            @endisset
                           
                        @isset($data['description'])
                        <!-- Description -->
                        <div class="description p-t-20 p-b-20">
                            <h3 class="element-title m-b-20">{{$data['title']['name']}} Description</h3>
                            <p class="sub-title description__detail">{!!nl2br(e($data['description']))!!}</p>
                        </div>
                        <!-- Description ends -->
                        @endisset
                        <!-- more-details -->
                        <div class="more-details p-t-20 p-b-20">
                            <!-- <p class="main-heading p-b-15">More details of {{$data['title']['name']}}</p> -->
                            <div class="detail-1 flex-row m-t-25 m-b-25">

                                @isset($data['established'])
                                <div class="year">
                                    <p class="element-title heavier m-b-20">Year of establishment</p>
                                    <p class="sub-title lighter">{{$data['established']}} </p>
                                </div>
                                @endisset
                                @isset($data['website'])
                                <div class="site">
                                    <p class="element-title heavier m-b-10">Website</p>
                                    <p class="sub-title lighter "><a href="{{$data['website']}}" target="_blank" class="link-click">{{$data['website']}} <i class="fa fa-external-link new-link p-l-5" aria-hidden="true"></i></a></p>
                                </div>
                                @endisset
                            </div>
                            @if(isset($data['showHours']) and $data['showHours'] == 1)
                            <div class="detail-2 flex-row m-t-25 m-b-25">
                                <div class="operation">
                                    <p class="element-title heavier m-b-20">Hours of operation @if($data['today']['open'])<span class="text-success">(Open now)</span>@else <span class="text-danger">(Closed now)</span>@endif</p>
                                    <p class="sub-title lighter operation__hours">Today {{$data['today']['timing']}} <span class="dis-block data-show m-t-5">
                                    @foreach($data['hours'] as $day)
                                   {{$day['day']}} {{$day['timing']}} <br> 
                                    @endforeach</span><!-- <a href="" class="secondary-link heavier p-l-10 more-show">See more</a> --></p>
                                </div>
                            </div>
                            @endif
                            @if(isset($data['address']) or isset($data['location']))
                            <div class="detail-3 flex-row m-t-25 m-b-25">
                                <div class="address">
                                    <h3 class="element-title heavier m-b-20">Address {{$data['title']['name']}}</h3>
                                    @isset($data['address'])<p class="sub-title lighter">{{$data['address']}}</p>@endisset
                                </div>
                            </div>
                            @endif
                            @isset($data['location'])
                            <div class="detail-4 flex-row m-t-25 m-b-25">
                                <div class="m-t-10" id="map"  style="width:600px;height:250px;"></div>
                                <script type="text/javascript">
                                    function initMap() {
                                        var uluru = {lat: {{$data['location']['lat']}}, lng: {{$data['location']['lng']}} };
                                        var map = new google.maps.Map(document.getElementById('map'), {
                                          zoom: 17,
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

                                </div>
                                @endisset
                                @isset($data['payments'])
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
                                @endisset
                            </div>
                            <!-- more details ends -->
                        </div>
                        @endisset
                        @if(!$data['premium'] and isset($similar[0]))
                        <!-- Similar businesses -->
                        <div class="similar-business p-t-20 p-b-20" id="business">
                            <div class="section-start-head m-b-15 flex-row">
                                <p class="element-title">Similar Businesses</p>
                                @isset($similar[1])<a href="{{$similar['url']}}" class="secondary-link view-more heavier">View More</a>@endisset
                            </div>
                            <div class="similar-business__section flex-row">
                                <div class="card business-card article-col">
                                    <div class="business-card__header">
                                        @if($similar[0]['premium'])<img src="/img/power-seller.png" class="img-responsive powerSeller" width="100">@endif
                                        <ul class="fnb-cat flex-row">
                                            @foreach($similar[0]['cores'] as $core)
                                            <li><a href="/{{$core['slug']}}" class="fnb-cat__title">{{$core['name']}}</a></li>
                                            @endforeach
                                        </ul>
                                        @isset($similar[0]['operationAreas'])
                                        <div class="operations m-t-20">
                                            <span class="dis-block lighter">Area of operations</span>
                                            @foreach($similar[0]['operationAreas'] as $city)
                                            {{$city['name']}}
                                            <ul class="areas flex-row">
                                                @foreach($city['areas'] as $area)
                                                <li>
                                                    <p class="default-size areas__title">{{$area['name']}}</p>
                                                </li>
                                                @endforeach
                                                
                                            </ul>
                                            @endforeach
                                        </div>
                                        @endisset
                                    </div>
                                    <div class="business-card__body">
                                        <div class="flex-row space-between">
                                            <div class="rating">
                                                <div class="bg"></div>
                                                <div class="value" style="width: {{$similar[0]['rating']}}%;"></div>
                                            </div>
                                            <span class="fnb-icons verified-icon"></span>
                                        </div>
                                        <div class="address">
                                            <p class="sub-title heavier">{{$similar[0]['title']['name']}}</p>
                                            <p class="m-b-0 lighter address-title"><i class="fa fa-map-marker p-r-5 loc-icon" aria-hidden="true"></i>{{$similar[0]['city']['area']}} {{$similar[0]['city']['name']}}</p>
                                        </div>
                                    </div>
                                    <div class="business-card__footer flex-row">
                                        <p class="sub-title heavier footer-text"><a href="{{$similar[0]['title']['url']}}">Get Details <i class="fa fa-caret-right p-l-5" aria-hidden="true"></i></a></p>
                                        <span class="x-small date lighter">Updated on {{$similar[0]['update']}}</span>
                                    </div>
                                </div>
                                @if(isset($similar[1]))
                                <div class="card business-card article-col">
                                    <div class="business-card__header">
                                        @if($similar[1]['premium'])<img src="/img/power-seller.png" class="img-responsive powerSeller" width="100">@endif
                                        <ul class="fnb-cat flex-row">
                                            @foreach($similar[1]['cores'] as $core)
                                            <li><a href="/{{$core['slug']}}" class="fnb-cat__title">{{$core['name']}}</a></li>
                                            @endforeach
                                        </ul>
                                        @isset($similar[1]['operationAreas'])
                                        <div class="operations m-t-20">
                                            <span class="dis-block lighter">Area of operations</span>
                                            @foreach($similar[1]['operationAreas'] as $city)
                                            {{$city['name']}}
                                            <ul class="areas flex-row">
                                                @foreach($city['areas'] as $area)
                                                <li>
                                                    <p class="default-size areas__title">{{$area['name']}}</p>
                                                </li>
                                                @endforeach
                                                
                                            </ul>
                                            @endforeach
                                        </div>
                                        @endisset
                                    </div>
                                    <div class="business-card__body">
                                        <div class="flex-row space-between">
                                            <div class="rating">
                                                <div class="bg"></div>
                                                <div class="value" style="width: {{$similar[1]['rating']}}%;"></div>
                                            </div>
                                            <span class="fnb-icons verified-icon"></span>
                                        </div>
                                        <div class="address">
                                            <p class="sub-title heavier">{{$similar[1]['title']['name']}}</p>
                                            <p class="m-b-0 lighter address-title"><i class="fa fa-map-marker p-r-5 loc-icon" aria-hidden="true"></i>{{$similar[1]['city']['area']}} {{$similar[1]['city']['name']}}</p>
                                        </div>
                                    </div>
                                    <div class="business-card__footer flex-row">
                                        <p class="sub-title heavier footer-text"><a href="{{$similar[0]['title']['url']}}">Get Details <i class="fa fa-caret-right p-l-5" aria-hidden="true"></i></a></p>
                                        <span class="x-small date lighter">Updated on {{$similar[1]['update']}}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- Similar businesses end -->
                        @endif
                        <!-- Related article section -->




                        <!-- Related article section end -->

                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="detach-col-1">

                        <!-- core categories -->
                        <div class="equal-col">
                           <div class="core-cat">
                                @isset($data['cores'])
                                <h2 class="element-title m-t-0 m-b-15">We specialise in</h2>
                                <ul class="fnb-cat flex-row">
                                    @foreach($data['cores'] as $core)
                                    <li><a href="" class="fnb-cat__title">{{$core['name']}}</a></li>
                                    @endforeach
                                </ul>
                                @endisset
                            </div> 
                            
                            <div class="contact__enquiry text-center mobile-hide">                                
                                <!-- <p class="contact__title lighter">This listing got <b>10+</b> enquiries</p> -->
                                <!-- <button class="btn fnb-btn primary-btn full border-btn" type="button" data-toggle="modal" data-target="#enquiry-modal"><i class="p-r-5 fa fa-paper-plane-o" aria-hidden="true"></i> Send an Enquiry</button> -->
                                @if(hasAccess('edit_permission_element_cls',$data['reference'],'listing'))
                                <div class="approval">
                                    <p class="contact__title lighter">{{$data['status']['text']}}</p>
                                    <div class="heavier sub-title m-b-10">{!! $data['status']['status'] !!} <i class="fa fa-check-circle text-success" aria-hidden="true"></i></div>
                                    @if($data['status']['change']!= '') <a href ="#" class="btn fnb-btn primary-btn full border-btn" data-toggle="modal" data-target="#confirmBox"><i class="fa fa-archive" aria-hidden="true"></i> {{$data['status']['next']}} </a> @endif
                                </div>
                                @endif
                            </div>
                            @isset($data['status']['next'])
                            <div class="modal fnb-modal confirm-box fade modal-center" id="confirmBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog modal-sm" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="text-medium m-t-0 bolder m-b-5">Confirm</h5>
                                      </div>
                                      <div class="modal-body text-center">
                                          <div class="listing-message p-l-10 p-r-10">
                                              <h4 class="element-title text-medium text-left text-color m-t-0">Are you sure you want to {{$data['status']['next']}} ?</h4>
                                          </div>  
                                          <div class="confirm-actions text-right flex-row flex-end">
                                            {!!$data['status']['change']!!}
                                                <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                                          </div>
                                      </div>
                                      <!-- <div class="modal-footer">
                                          <button class="btn fnb-btn outline cancel-modal border-btn" data-dismiss="modal">Close</button>
                                      </div> -->
                                  </div>
                              </div>
                          </div>
                            @endisset
                        </div>
                        <!-- core categories end -->
                        <!-- Claim -->
                        @if(!hasAccess('edit_permission_element_cls',$data['reference'],'listing'))
                        <div class="claim-box p-b-10">
                            <!-- <i class="fa fa-commenting claim__icon" aria-hidden="true"></i> -->
                            <!-- <img src="img/exclamation.png" class="img-reponsive"> -->
                            <span class="fnb-icons exclamation"></span>
                            <p class="claim-box__text sub-title">Is this your business? <a href="">Claim it now.</a><br> or <a href="">Report/Delete</a></p>
                        </div>
                        @endif
                        <!-- claim end -->
                        @if(isset($data['images']) or isset($data['files']))
                        <!-- Photos and documents -->
                        <div class="docs p-t-20 p-b-20">
                            <p class="element-title m-b-15">Photos &amp; Documents of {{$data['title']['name']}}</p>
                            @isset($data['images'])
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
                            @endisset
                            @isset($data['files'])
                            @foreach($data['files'] as $file)
                            <div class="catalogue flex-row p-t-20 p-b-20">
                                <p class="sub-title flex-row"><i class="fa fa-file file-icon p-r-10" aria-hidden="true"></i>
                                    {{$file['name']}}.{{pathinfo($file['url'])['extension']}}
                                </p>
                                <a href="{{$file['url']}}" target="_blank" download>
                                    <span class="fnb-icons download"></span>
                                </a>
                            </div>
                            @endforeach
                            @endisset
                        </div>
                        <!-- documents ends -->
                        <!-- enquiry form -->
                        @endif



                        <!-- enquiry form ends-->
                        <!-- browse category -->
                        <div class="browse-cat">
                            <p class="element-title">Browse Categories</p>
                            <ul class="browse-cat__list m-t-20">
                                @foreach($data['browse_categories'] as $category)
                                <li>
                                    <a href="">
                                        <p class="m-b-0 flex-row">
                                            <span class="fnb-icons cat-icon">
                                                <img src="{{$category['image']}}">
                                            </span>
                                            {{$category['name']}} <span class="total p-l-5 bolder">({{$category['count']}})</span>
                                        </p>
                                    </a>
                                </li>
                                @endforeach
                                
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
                        <p class="element-title">Why FnB Circle?</p>
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
                           <select name="update-sort" id="" class="fnb-select">
                               <option value="0">Recent</option>
                               <option value="1">Older</option>
                           </select>
                       </div>
                    </div>
                    <div class="page-sidebar__body update-display-section">

                    </div>
                    <div class="page-sidebar__footer"></div>
                </div>  
            </div>
        </div>
    <!-- </div> -->

@if(Session::has('statusChange'))
                <!-- listing review -->
    <div class="modal fnb-modal listing-review fade modal-center" id="listing-review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aria-label="Close">&#10005;</button>
                </div>
                <div class="modal-body text-center">
                    <div class="listing-message">
                        <i class="fa fa-check-circle check" aria-hidden="true"></i>
                        <h4 class="element-title heavier">
                            @if(session('statusChange')=='review') We have sent your listing for review @endif
                            @if(session('statusChange')=='archive') Your listing is now archived @endif
                            @if(session('statusChange')=='published') Your listing is now published @endif
                        </h4>
                        @if(session('statusChange')=='review') <p class="default-size text-color lighter list-caption"> Our team will review your listing and you will be notified if your listing is published.</p> @endif
                    </div>
                    <div class="listing-status highlight-color">
                        <p class="m-b-0 text-darker heavier">The current status of your listing is</p>
                        <div class="pending text-darker heavier sub-title">
                        @if(session('statusChange')=='review')<i class="fa fa-clock-o text-primary p-r-5" aria-hidden="true"></i> Pending Review @endif
                        @if(session('statusChange')=='archive')
                        Archived
                        @endif
                       @if(session('statusChange')=='published')
                       Published
                        @endif
                         <!-- <i class="fa fa-info-circle text-darker p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pending review"></i> --></div>
                    </div>
                </div>
                <div class="modal-footer">
                        <button class="btn fnb-btn outline cancel-modal border-btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endif

@endsection
