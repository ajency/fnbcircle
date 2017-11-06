<!-- enquiry success -->
    <div class="enquiry-success flex-row" style="padding: 0em">
        <i class="fa fa-check-circle" aria-hidden="true"></i>
        <h6 class="text-color text-medium enquiry-success__text" style="padding-right: 0em">Email &amp; SMS with your details has been sent to the relevant listing owners you will be contacted soon.</h6>
    </div>
<!-- enquiry success ends -->

@if(isset($listing_data))
	<!-- <div class="seller-info bg-card filter-cards">
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
    </div> -->
    @include('list-view.single-card.listing_card')
@endif

<button class="btn fnb-btn" data-dismiss="modal" aria-label="Close">Ok, got it!</button>