</script>
<script id="listing_card_template" type="text/x-handlebars-template">                    
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
            <div class="seller-info__body filter-cards__body flex-row white-space">
                <div class="body-left flex-cols">
                    <div>
                        <div class="list-title-container">
                            <h3 class="seller-info__title ellipsis" title="{{ title }}">{{ title }}</h3>
                            <div class="power-seller-container"></div>
                        </div>
                        <div class="location p-b-5 flex-row">
                            <span class="fnb-icons map-icon"></span>
                            <p class="location__title default-size m-b-0 text-lighter">Gandhi Nagar, Delhi</p>
                        </div>
                        <div class="flex-row rat-pub">
                            <div class="rating-view flex-row p-r-10">
                                <div class="rating rating-small">
                                    <div class="bg"></div>
                                    <div class="value" style="width: 80%;"></div>
                                </div>
                            </div>
                            <p class="m-b-0 text-lighter default-size lighter published-date"><i>Published on 20 Dec 2016</i></p>
                        </div>
                        <div class="stats flex-row m-t-10 p-t-10">
                            <label class="fnb-label wholesaler flex-row">
                                <i class="fa fa-user user p-r-5" aria-hidden="true"></i>
                                {{#ifCond business_type == 11 }}
                                    Wholesaler
                                {{else}} 
                                    {{#ifCond business_type == 12 }}
                                        Retailer
                                    {{else}}
                                        Manufacturer
                                    {{/if}}
                                {{/if}}

                            </label>
                            <div class="verified flex-row p-l-10">
                                {{#if verified}}
                                    <span class="fnb-icons verified-icon verified-mini"></span>
                                    <p class="c-title">Verified</p>
                                {{/if}}
                            </div>
                        </div>
                    </div>
                    <div class="m-t-15 p-t-15 cat-holder">
                        <div class="core-cat">
                            <p class="default-size text-lighter m-t-0 m-b-0">Core Categories</p>
                            <ul class="fnb-cat flex-row">
                                <li><a href="" class="fnb-cat__title">Chicken Retailer</a></li>
                                <li><a href="" class="fnb-cat__title">Mutton</a></li>
                                <li><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                <li><a href="" class="fnb-cat__title">Pork Wholesaler</a></li>
                                <li class="desk-hide"><a href="" class="fnb-cat__title">Egg</a></li>
                                <li class="desk-hide"><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                <li class="cat-more more-show"><a href="" class="text-darker">+5 more</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="body-right flex-cols">
                    <div class="operations">
                        <img src="{{ asset('/img/power-seller.png') }}" class="img-responsive power-seller" width="120">
                        <p class="operations__title default-size text-lighter m-t-5">Areas of operation:</p>
                        <div class="operations__container">
                            <div class="location flex-row">
                                <p class="m-b-0 text-color heavier default-size">Mumbai <i class="fa fa-caret-right p-l-5" aria-hidden="true"></i>
                                </p>
                            </div>
                            <ul class="cities flex-row">
                                <li>
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
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <div class="enquiries flex-row">
                            <div class="enquiries__count">
                                <p class="default-size heavier text-color m-b-0">50+</p>
                                <p class="default-size text-lighter">Enquiries</p>
                            </div>
                            <div class="enquiries__request">
                                <p class="default-size heavier text-color m-b-0">100+</p>
                                <p class="default-size text-lighter">Contact Requests</p>
                            </div>
                            <i class="fa fa-bar-chart bars text-darker" aria-hidden="true"></i>
                        </div>
                        <div class="get-details detail-move">
                            <button class="btn fnb-btn outline full border-btn fullwidth default-size">Get Details <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="seller-info__footer filter-cards__footer white-space">
                <div class="recent-updates flex-row">
                    <div class="recent-updates__text">
                        <p class="m-b-0 default-size heavier flex-row"><!-- <i class="fa fa-repeat p-r-5" aria-hidden="true"></i> --><img src="{{ asset('/img/list-updates.png') }}" class="img-responsive update-icon"> Recent updates <i class="fa fa-angle-down desk-hide arrowDown" aria-hidden="true"></i></p>
                    </div>
                    <div class="recent-updates__content">
                        <p class="m-b-0 default-size text-color recent-data">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur recusandae quasi facere voluptates error, ab, iusto similique?,
                        <span class="text-lighter p-l-10">Updated few hours ago</span></p>
                    </div>
                </div>
                <div class="updates-dropDown">

                </div>
            </div>
        </div>
    </div>