<!-- enquiry success -->
    <div class="enquiry-success flex-row" style="padding: 0em">
        <i class="fa fa-check-circle" aria-hidden="true"></i>
        <h6 class="text-color text-medium enquiry-success__text" style="padding-right: 0em">Email &amp; SMS with your details has been sent to the relevant listing owners. You will be contacted soon.</h6>
    </div>
    <div class="suppliers-data success-cards">
        <p class="element-title heavier text-darker success-cards__title">Don't miss out on these suppliers <img src="/img/direction-down-2.png" class="img-responsive direction-down"></p>
        <!-- enquiry success ends -->
		@if(isset($listing_data) && (!isset($is_premium) || !$is_premium))
		    @include('list-view.single-card.listing_card', array('exclude_enquiry' => 'true'))
		@endif
    </div>


<!-- <button class="btn fnb-btn outline full border-btn default-size" data-dismiss="modal" aria-label="Close">Ok, got it!</button> -->