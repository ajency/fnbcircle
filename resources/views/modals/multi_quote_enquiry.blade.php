<div class="modal fnb-modal enquiry-modal verification-modal multilevel-modal fade" id="multi-quote-enquiry-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<button class="close mobile-hide" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
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
                    </div>
                </div>
                <div class="enquiry-details flex-row content-data">
                    <div class="detail-cols col-right enquiry-details__content" id="listing_popup_fill">
                       <!-- level one starts -->
                       @include('modals.listing_enquiry_popup.popup_level_one')
                       <!-- Level one ends -->

                        
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
</div>
@section('js')
    <script type="text/javascript" src="{{ asset('js/category_select_modal.js') }}"></script>
@endsection