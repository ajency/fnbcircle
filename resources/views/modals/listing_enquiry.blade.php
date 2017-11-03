<!-- Enquiry modal -->

<div class="modal fnb-modal enquiry-modal verification-modal multilevel-modal fade" id="enquiry-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close mobile-hide" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                <div class="mobile-back flex-row desk-hide">
                    <div class="back ellipsis">
                        <button class="btn fnb-btn outline border-btn no-border ellipsis" data-dismiss="modal"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i></button>
                        <span class="m-b-0 ellipsis heavier back-text">Back to Mystical the meat and fish store</span>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="success-stuff hidden">
                <!-- enquiry success -->
                    <div class="enquiry-success flex-row">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                        <h6 class="text-color text-medium enquiry-success__text">Email &amp; SMS with your details has been sent to the relevant listing owners you will be contacted soon.</h6>
                    </div>
                <!-- enquiry success ends -->
                <!-- suppliers details -->
                    <div class="suppliers-data">
                        <!-- <h5 class="text-darker lighter m-t-0 deal-text">We can help you get the best deals on F&amp;BCircle <p class="xx-small m-t-5 text-medium m-b-20">Please give us details of the categories that you're interested in and also the areas of operation.</p></h5> -->

                        <p class="element-title heavier text-darker">Don't miss out on these suppliers <img src="{{ asset('img/direction-down-2.png') }}" class="img-responsive direction-down"></p>

                        <!-- Categories start -->
                        <div class="categories-select gap-separator">
                            <p class="text-darker describes__title text-medium">Categories <span class="xx-small text-lighter">(Select from the list below or add other categories.)</span></p>
                            <ul class="categories__points flex-points flex-row flex-wrap">
                                <li>
                                    <label class="flex-row">
                                        <input type="checkbox" class="checkbox" for="chicken">
                                        <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                                    </label>
                                </li>
                                <li>
                                    <label class="flex-row">
                                        <input type="checkbox" class="checkbox" for="egg">
                                        <p class="text-medium describes__text flex-points__text text-color" id="egg">Egg</p>
                                    </label>
                                </li>
                                <li>
                                    <label class="flex-row">
                                        <input type="checkbox" class="checkbox" for="chicken">
                                        <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                                    </label>
                                </li>
                                <li>
                                    <label class="flex-row">
                                        <input type="checkbox" class="checkbox" for="egg">
                                        <p class="text-medium describes__text flex-points__text text-color" id="egg">Egg</p>
                                    </label>
                                </li>
                                <li>
                                    <label class="flex-row">
                                        <input type="checkbox" class="checkbox" for="chicken">
                                        <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                                    </label>
                                </li>
                                <li>
                                    <label class="flex-row">
                                        <input type="checkbox" class="checkbox" for="egg">
                                        <p class="text-medium describes__text flex-points__text text-color" id="egg">Egg</p>
                                    </label>
                                </li>
                                <li>
                                    <label class="flex-row">
                                        <input type="checkbox" class="checkbox" for="chicken">
                                        <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                                    </label>
                                </li>
                                <li>
                                    <label class="flex-row">
                                        <input type="checkbox" class="checkbox" for="egg">
                                        <p class="text-medium describes__text flex-points__text text-color" id="egg">Egg</p>
                                    </label>
                                </li>
                                <li>
                                    <label class="flex-row">
                                        <input type="checkbox" class="checkbox" for="chicken">
                                        <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                                    </label>
                                </li>
                            </ul>
                            <div class="add-more-cat m-t-5">
                                <a href="#" class="more-show secondary-link text-decor">+ Add more</a>
                                <div class="form-group m-t-5 m-b-0 add-more-cat__input">
                                    <input type="text" class="form-control fnb-input flexdatalist cat-add-data" placeholder="Type to select categories" multiple='multiple' data-min-length='1'>
                                </div>
                            </div>
                        </div>
                        <!-- Categories ends -->

                        <!-- Areas start -->
                       <div class="areas-select gap-separator">
                            <p class="text-darker describes__title heavier">Areas <span class="xx-small text-lighter">(Select your areas of interest)</span></p>
                            <ul class="areas-select__selection flex-row flex-wrap">
                                <li>
                                    <div class="required left-star flex-row">
                                        <select class="form-control fnb-select select-variant">
                                            <option>Select City</option>
                                            <option>Delhi</option>
                                            <option>Goa</option>
                                            <option>Mumbai</option>
                                            <option>Goa</option>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="required left-star flex-row">
                                        <select class="fnb-select select-variant default-area-select" multiple="multiple">
                                            <option>Bandra</option>
                                            <option>Andheri</option>
                                            <option>Dadar</option>
                                            <option>Borivali</option>
                                            <option>Church gate</option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                            <ul class="areas-select__selection flex-row flex-wrap area-append hidden">
                                <li>
                                    <div class="required left-star flex-row">
                                        <select class="form-control fnb-select select-variant">
                                            <option>Select City</option>
                                            <option>Delhi</option>
                                            <option>Goa</option>
                                            <option>Mumbai</option>
                                            <option>Goa</option>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="required left-star flex-row">
                                        <select class="fnb-select select-variant areas-appended" multiple="multiple">
                                            <option>Bandra</option>
                                            <option>Andheri</option>
                                            <option>Dadar</option>
                                            <option>Borivali</option>
                                            <option>Church gate</option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                            <div class="m-t-10 adder">
                                <a href="#" class="secondary-link text-decor heavier add-areas">+ Add more</a>
                            </div>
                        </div>
                        <!-- Areas ends -->


                        <div class="seller-info bg-card filter-cards">
                            <div class="seller-info__body filter-cards__body white-space">
                                <div class="flex-row suppliers-title-head">
                                    <div class="suppliers-title">
                                        <h3 class="seller-info__title main-heading ellipsis" title="Mystical the meat and fish store">Mystical the meat and fish store</h3>
                                        <div class="location flex-row">
                                            <span class="fnb-icons map-icon"></span>
                                            <p class="location__title m-b-0 text-lighter">Gandhi Nagar, Delhi</p>
                                        </div>
                                    </div>
                                    <div class="suppliers-stat">
                                        <div class="rating-view flex-row">
                                            <div class="rating">
                                                <div class="bg"></div>
                                                <div class="value" style="width: 80%;"></div>
                                            </div>
                                        </div>
                                        <p class="featured text-secondary m-b-0">
                                            <i class="flex-row featured__title">
                                                <i class="fa fa-flag featured__icon p-r-10" aria-hidden="true"></i>
                                                Featured
                                            </i>
                                        </p>
                                    </div>
                                </div>
                                <div class="m-t-15 cat-holder flex-row">
                                    <div class="core-cat">
                                        <p class="text-lighter m-t-0 m-b-0">Core Categories</p>
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
                                    <div class="get-details">
                                        <button class="btn fnb-btn outline full border-btn fullwidth">Get Details <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="seller-info bg-card filter-cards">
                            <div class="seller-info__body filter-cards__body white-space">
                                <div class="flex-row suppliers-title-head">
                                    <div class="suppliers-title">
                                        <h3 class="seller-info__title main-heading ellipsis" title="CH Exports and imports private limited">CH Exports and imports private limited</h3>
                                        <div class="location flex-row">
                                            <span class="fnb-icons map-icon"></span>
                                            <p class="location__title m-b-0 text-lighter">Chennai, Tamil Nadu</p>
                                        </div>
                                    </div>
                                    <div class="suppliers-stat">
                                        <div class="rating-view flex-row">
                                            <div class="rating">
                                                <div class="bg"></div>
                                                <div class="value" style="width: 100%;"></div>
                                            </div>
                                        </div>
                                        <p class="featured text-secondary m-b-0">
                                            <i class="flex-row featured__title">
                                                <i class="fa fa-flag featured__icon p-r-10" aria-hidden="true"></i>
                                                Featured
                                            </i>
                                        </p>
                                    </div>
                                </div>
                                <div class="m-t-15 cat-holder flex-row">
                                    <div class="core-cat">
                                        <p class="text-lighter m-t-0 m-b-0">Core Categories</p>
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
                                    <div class="get-details">
                                        <button class="btn fnb-btn outline full border-btn fullwidth">Get Details <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- suppliers details ends -->
                </div>
                <div class="enquiry-details flex-row content-data">
                    <!-- col left -->
                    <div class="detail-cols col-left enquiry-details__intro flex-row">
                        <!-- <h5 class="bolder intro-text">To send your enquiry, please fill the details.
                            <img src="img/direction-down.png" class="img-responsive direction-down">
                        </h5> -->
                        <!-- premium details -->
                        <div class="send-enquiry">
                            <h5 class="bolder intro-text flex-row space-between">Send a<br class="mobile-hide"> direct enquiry to...
                                <div class="rotator mobile-hide">
                                    <img src="{{ asset('img/direction-down.png') }}" class="img-responsive direction-down">
                                </div>
                            </h5>
                            <div class="seller-enquiry">
                                <p class="sub-title heavier text-darker text-capitalise flex-row seller-enquiry__title">
                                    <span class="brand-name"> {{ $data['title']['name'] }} </span>
                                    @if(isset($data['verified']) && $data['verified'])
                                        <span class="fnb-icons verified-icon"></span>
                                    @endif
                                </p>
                                <div class="location flex-row mobile-hide">
                                    <span class="fnb-icons map-icon"></span>
                                    <p class="location__title m-b-0 text-lighter">{{$data['city']['name']}}</p>
                                </div>
                                <div class="rat-view flex-row mobile-hide">
                                    <div class="rating">
                                        <div class="bg"></div>
                                        <div class="value" style="width: 80%;"></div>
                                    </div>
                                    <div class="views flex-row">
                                        <span class="fnb-icons eye-icon"></span>
                                        <p class="views__title text-lighter m-b-0"><span class="heavier"> {{ $data['views'] }} </span> Views</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- premium details ends -->
                        <div class="h-i-w mobile-hide m-t-35">
                            <p class="sub-title bolder text-darker m-b-20">How it works</p>
                            <ul class="points">
                                <li><p class="m-b-0 points__container flex-row"><span class="points__number">1</span> <span class="points__text text-color">Submit your details.</span></p></li>
                                <li><p class="m-b-0 points__container flex-row"><span class="points__number">2</span> <span class="points__text text-color">Your details are sent to the business owner.</span></p></li>
                                <li><p class="m-b-0 points__container flex-row"><span class="points__number">3</span> <span class="points__text text-color">They will get back to you with their offers.</span></p></li>
                            </ul>
                        </div>
                    </div>
                    <!-- col left ends -->
                    <!-- col right -->
                    <div class="detail-cols col-right enquiry-details__content" id="listing_popup_fill">
                       <!-- level one starts -->
                       @include('modals.listing_enquiry_popup.popup_level_one')
                       <!-- Level one ends -->

                        
                    </div>
                    <!-- col right ends -->
                </div>
            </div>
            <div class="modal-footer mobile-hide">
                <div class="sub-category hidden">
                    <button class="btn fnb-btn outline full border-btn">save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enquiry ends -->

@section('js')
    <script type="text/javascript" src="{{ asset('js/category_select_modal.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/listing_enquiry.js') }}"></script>
@endsection