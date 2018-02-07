<!-- enquiry success -->
<div class="enquiry-success flex-row" style="padding: 1em">
    <i class="fa fa-check-circle" aria-hidden="true"></i>
    <h6 class="text-color text-medium enquiry-success__text" style="padding-right: 0em">Email &amp; SMS with your details has been sent to the relevant listing owners. You will be contacted soon.</h6>
</div>

<div class="no-results hidden">
    <h5 class="seller-info__title ellipsis text-primary">Sorry, No Business Listings Matching Your Requirements! <i class="fa fa-frown-o" aria-hidden="true"></i></h3>
    <img src="/img/404.png" class="img-reponsive center-block img-nf m-t-40" width="350">
</div>
<!-- enquiry success ends -->

<div class="suppliers-data success-cards">
   @if(isset($listing_data) && (!isset($is_premium) || !$is_premium))
        <p class="element-title heavier text-darker success-cards__title">Don't miss out on these suppliers <img src="/img/direction-down-2.png" class="img-responsive direction-down"></p>
	    @include('list-view.single-card.listing_card', array('exclude_enquiry' => 'true'))
	   
        <!-- Show Listings found count -->
        @if(isset($listing_count) && ($listing_count - sizeof($listing_data)) > 0)
    		<p> and {{ ($listing_count - sizeof($listing_data)) }} more ... </p>
    	@endif
    @endif

    <div class="text-center">
        <button class="btn fnb-btn outline border-btn default-size" data-dismiss="modal" aria-label="Close">Ok, got it!</button>
    </div>
</div>