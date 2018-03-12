@foreach($listing_data as $list_index => $list_value)
    <div class="filter-data m-b-30">
        <div class="seller-info bg-card filter-cards">
            <!-- <div class="seller-info__header filter-cards__header flex-row">
                <div class="flex-row">
                    <div class="rating-view flex-row p-r-10">
                        <div class="rating">
                            <div class="bg"></div>
                            <div class="value" style="width: 80%;"></div>
                        </div>
                    </div>
                    <p class="m-b-0 text-lighter lighter published-date"><i>Published on 20 Dec 2016</i></p>
                </div>
                <p class="featured text-secondary m-b-0">
                    <i class="flex-row">
                        <i class="fa fa-flag featured__icon p-r-10" aria-hidden="true"></i>
                        Featured
                    </i>
                </p>
            </div> -->
            <div class="seller-info__body filter-cards__body flex-row white-space list-new-changes" style="@isset($is_email) border: 1px solid #ddd;padding: 15px;margin-top: 20px; @endisset">
                <div class="body-left flex-cols">
                    <div>
                        <div class="list-title-container" style="@isset($is_email) clear: both; display: table;width: 100%; @endisset">
                            <h3 class="seller-info__title ellipsis-2" title="{{ $list_value->title }}" style="@isset($is_email) margin-bottom: 0;margin-top: 0;float:left; @endisset"><a class="text-darker" href="{{ url(generateUrl($list_value->city['slug'], $list_value->slug)) }}" target="_blank" style="@isset($is_email) color: #ec6d4b; @endisset">{{ $list_value->title }}</a></h3>
                            <div class="power-seller-container" style="@isset($is_email) float: right; padding-left: 15px; @endisset">
                                @isset($is_email)
                                    @if($list_value->premium)
                                        <img src="{{ asset('/img/power-seller.png') }}" class="img-responsive power-seller" width="120">
                                    @endif
                                @endisset    
                            </div>
                        </div>
                        <div class="location p-b-10 flex-row">
                            <!-- <span class="fnb-icons map-icon"></span> -->
                                <i class="fa fa-map-marker sub-title text-lighter p-r-5" aria-hidden="true"></i>
                                <p class="location__title default-size m-b-0 text-lighter" style="@isset($is_email)     margin-top: 5px;margin-bottom: 0px; @endisset">{{ $list_value->area["name"] }}, {{ $list_value->city["name"] }}</p>
                            <!-- @if($list_value->display_address)
                                <p class="location__title default-size m-b-0 text-lighter">{{ $list_value->display_address }}</p>
                            @else
                                <p class="location__title default-size m-b-0 text-lighter">{{ $list_value->area["name"] }}, {{ $list_value->city["name"] }}</p>
                            @endif -->
                        </div>
                        <div class="flex-row rat-pub" style="@isset($is_email) float: left; @endisset">
                            <div class="rating-view flex-row p-r-10">
                                <div class="rating rating-small">
                                    <div class="bg"></div>
                                    <div class="value" style="width: 80%;"></div>
                                </div>
                            </div>
                            @if($list_value->status ==1)<p class="m-b-0 text-lighter default-size lighter published-date" style="@isset($is_email)  margin-top: 0;margin-bottom: 5px; @endisset"><i>Published on {{ date('F d, Y', strtotime($list_value->published_on)) }}</i></p>@endif
                        </div>
                        <div class="stats flex-row m-t-10" style="@isset($is_email) float: right;position: relative;top: -8px; @endisset">
                            <a class="fnb-label wholesaler flex-row list-label m-r-10" @if(isset($new_tab) and $new_tab == true) target="_blank" @endif href='{{ generateUrl($list_value->city["slug"], "business-listings") }}?business_types=["{{ $list_value->business_type["slug"] }}"]' title="{{ $list_value->business_type["name"] }}(s) in {{$list_value->city["name"]}}" style="@isset($is_email)  padding: 5px;color: #27b7b0;border: 1px solid;border-radius: 4px;text-decoration: none;font-size: 12px;width: auto;float: left;margin-right: 15px; @endisset">
                                <i class="fa fa-user user p-r-5" aria-hidden="true"></i>
                                {{ $list_value->business_type["name"] }}
                            </a>
                            @if ($list_value->verified)
                            <div class="verified flex-row p-r-10" style="@isset($is_email) color: #1eb51e;position: relative;top: 5px;float: left;margin-top: 5px; @endisset">
                                <span class="fnb-icons verified-icon verified-mini"></span>
                                <p class="c-title" style="@isset($is_email) margin: 0; @endisset">Verified</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if($list_value->cores->count() > 0)
                        <div class="m-t-15 p-t-15 cat-holder" style="@isset($is_email) margin-top: 40px;border-top: 1px solid #eee;display:table;width: 100%; @endisset">
                            <div class="core-cat">
                                <p class="default-size text-lighter m-t-0 m-b-0" style="@isset($is_email) margin-bottom: 5px; @endisset">Core Categories</p>
                                <ul class="fnb-cat flex-row" style="@isset($is_email) width: 100%;list-style: none;margin: 0;clear: both;padding-left: 0; @endisset">
                                    @foreach($list_value->cores->take(4) as $core_index => $core_value)
                                        @if($core_index < 4)
                                            <li style="@isset($is_email) float: left;padding-right: 8px; @endisset"><a @if(isset($new_tab) and $new_tab == true) target="_blank" @endif href="{{ generateUrl($list_value->city['slug'], 'business-listings') }}?categories={{ $core_value->node_categories }}" class="fnb-cat__title" title="{{ $core_value->name }} vendors in {{$list_value->city['name']}}" style="@isset($is_email) color: #757575; @endisset">{{ $core_value->name }}</a></li>
                                        @else
                                            <!-- <li class="desk-hide"><a href="{{ generateUrl($list_value->city['slug'], 'business-listings') }}?categories={{ $core_value->node_categories }}" class="fnb-cat__title">{{ $core_value->name }}</a></li> -->
                                        @endif
                                    @endforeach
                                    @if (sizeof($list_value->cores) > 4)
                                        <li class="cat-more more-show" style="@isset($is_email) float: left;padding-right: 8px;display:none; @endisset">
                                            <a href="{{ generateUrl($list_value->city['slug'], $list_value->slug) }}" class="x-small secondary-link" target="_blank" style="@isset($is_email) color: #757575; @endisset">+ {{ sizeof($list_value->cores) - 4}} more...</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="body-right flex-cols" style="@isset($is_email) clear: both;display:table;width: 100%;margin-top: 15px; @endisset">
                    @if($list_value->premium || sizeof($list_value->areas_operation) > 0)
                        <div class="operations">
                            @if($list_value->premium)
                                <img src="{{ asset('/img/power-seller.png') }}" class="img-responsive power-seller" width="120" style="@isset($is_email) display: none; @endisset">
                            @endif
                            @if(sizeof($list_value->areas_operation) > 0)
                                <p class="operations__title default-size text-lighter m-t-5" style="@isset($is_email) margin-top: 0;margin-bottom: 0; @endisset">Areas of Operation:</p>
                                <div class="operations__container">
                                    @foreach(array_slice($list_value->areas_operation, 0, 1) as $locations_index => $locations_value)
                                        <div class="location flex-row">
                                            <p class="m-b-0 text-color heavier default-size" style="@isset($is_email) margin-top: 0px;font-weight: 600; margin-bottom: 0; @endisset"> {{ $locations_value["city"]["name"] }} <i class="fa fa-caret-right p-l-5" aria-hidden="true"></i>
                                            </p>
                                        </div>
                                        <ul class="cities flex-row" style="@isset($is_email) width: 100%;list-style: none;margin: 0;clear: both;padding-left: 0;display:table; @endisset">
                                            @foreach($locations_value["areas"]->take(5) as $areas_index => $areas_value)
                                                @if ($areas_index < 5)
                                                    <li style="@isset($is_email) float: left;padding-right: 8px; @endisset">
                                                        <p class="cities__title default-size" style="@isset($is_email) margin-top: 5px; @endisset">{{ $areas_value->name }}{{($areas_index < $locations_value["areas"]->take(5)->count() - 1) ? ', ' : ''}}</p>
                                                    </li>
                                                @else
                                                    <!-- <li class="mobile-hide">
                                                        <p class="cities__title default-size">{{ $areas_value->name }}{{($areas_index < $locations_value["areas"]->take(5)->count() - 1) ? ', ' : ''}}</p>
                                                    </li> -->
                                                @endif
                                            @endforeach
                                            
                                            <li class="remain more-show" style="@isset($is_email) display:none; @endisset">
                                                @if ($locations_value["areas"]->count() > 5)
                                                    <a href="{{ generateUrl($list_value->city['slug'], $list_value->slug) }}" class="cities__title remain__number default-size text-medium" target="_blank" style="@isset($is_email) color: #9a9a9a; @endisset"> and more...</a>
                                                @endif
                                            </li>
                                            <!-- <li>
                                                <p class="cities__title default-size">Bandra, </p>
                                            </li>
                                            <li>
                                                <p class="cities__title default-size">Andheri, </p>
                                            </li>
                                            <li>
                                                <p class="cities__title default-size">Juhu, </p>
                                            </li>
                                            <li class="mobile-hide">
                                                <p class="cities__title default-size">Worli, </p>
                                            </li>
                                            <li class="mobile-hide">
                                                <p class="cities__title default-size">Powai</p>
                                            </li>
                                            <li class="line">
                                                <p class="cities__title default-size">|</p>
                                            </li>
                                            <li class="remain more-show">
                                                <a href="" class="cities__title remain__number default-size text-medium">more...</a>
                                            </li> -->
                                        </ul>
                                    @endforeach
                                </div>
                                @if(sizeof($list_value->areas_operation) > 1)
                                    <div class="location flex-row m-t-5" style="@isset($is_email) display: none; @endisset">
                                        <p class="m-b-0 text-color heavier default-size" style="@isset($is_email) margin-top: 0;margin-bottom: 0; @endisset"> <a href="{{ generateUrl($list_value->city['slug'], $list_value->slug) }}" class="remain__number x-small secondary-link moreLink" target="_blank" style="@isset($is_email) color: #9a9a9a; @endisset">+ {{ sizeof($list_value->areas_operation) - 1 }} more...</a>
                                        </p>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endif
                    <div>
                        <div class="enquiries flex-row m-t-15" style="@isset($is_email) clear: both;display: table;width: 100%;display:none; @endisset">
                            <div class="enquiries__count" style="@isset($is_email) float: left;width: 30%; @endisset">
                                <p class="default-size heavier text-color m-b-0" style="@isset($is_email) margin-bottom:0;margin-top:0; @endisset">{{$list_value->counts['enquiries']}}</p>
                                <p class="default-size text-lighter" style="@isset($is_email) margin-top:5px; @endisset">Enquiries</p>
                            </div>
                            <div class="enquiries__request" style="@isset($is_email) float: left; @endisset">
                                <p class="default-size heavier text-color m-b-0" style="@isset($is_email) margin-bottom:0;margin-top:0; @endisset">{{$list_value->counts['contact']}}</p>
                                <p class="default-size text-lighter" style="@isset($is_email) margin-top:5px; @endisset">Contact Requests</p>
                            </div>
                            <i class="fa fa-bar-chart bars text-darker" aria-hidden="true"></i>
                        </div>
                        <div class="get-details detail-move" style="@isset($is_email)  margin-top: 15px;text-align: center;margin-bottom: 18px; @endisset">
                            <a class="btn fnb-btn outline full border-btn fullwidth default-size" href="{{ url(generateUrl($list_value->city['slug'], $list_value->slug)) }}" target="_blank" style="@isset($is_email) background-color: #fff;color: #ec6d4b;border: 2px solid;padding: 1em 1.8em;font-weight: 500;text-transform: capitalize;border-radius: 4px; @endisset">Get Details <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="seller-info__footer filter-cards__footer white-space {{ $list_value->recent_updates ? '' : 'desk-hide' }}" style="@isset($is_email) background-color: #fff0d4;display:none; @endisset">
                    <div class="recent-updates flex-row">
                        <div class="recent-updates__text {{ $list_value->recent_updates ? '' : 'mobile-hide' }}">
                            <p class="m-b-0 default-size heavier flex-row" style="@isset($is_email) margin-top: 0; @endisset"><!-- <i class="fa fa-repeat p-r-5" aria-hidden="true"></i> --><img src="{{ asset('/img/list-updates.png') }}" class="img-responsive update-icon"> Recent Updates <i class="fa fa-angle-down desk-hide arrowDown" aria-hidden="true"></i></p>
                        </div>
                        <div class="recent-updates__content {{ $list_value->recent_updates ? '' : 'no-updates' }}">
                            @if($list_value->recent_updates)
                                <p class="m-b-0 default-size text-color recent-data"> {{ $list_value->recent_updates->title }}
                                <span class="text-lighter p-l-10">Updated on {{ date('F d, Y', strtotime($list_value->recent_updates->updated_at)) }}</span></p>
                            @else
                                <p class="m-b-0 default-size text-color recent-data"> No updates </p>
                            @endif
                        </div>
                    </div>
                <div class="updates-dropDown">

                </div>
            </div>
        </div>
    </div>
    @if(!isset($exclude_enquiry) || (!$exclude_enquiry))
        @if((($list_index + 1) === 5) || (sizeof($listing_data) < 5 && ($list_index + 1) === sizeof($listing_data)))
            @include("enquiries.listings_enquiry")
        @endif
    @endif
@endforeach
@if(isset($listing_data) && $listing_data && $listing_data->count() <= 0)
    <div class="filter-data m-b-30">
        <div class="no-results">
            <!-- <h3 class="seller-info__title ellipsis text-primary">Sorry, no results found!</h3>
            <p class="nf-text heavier text-color">Please try searching for something else</p>
            <img src="/img/404.png" class="img-reponsive center-block img-nf" width="100"> -->
            <h5 class="seller-info__title ellipsis text-primary">Sorry, No Business Listings Matching Your Requirements! <i class="fa fa-frown-o" aria-hidden="true"></i></h3>
            <img src="/img/404.png" class="img-reponsive center-block img-nf m-t-40" width="350">
        </div>
    </div>
@endif