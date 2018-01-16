<div class="filter-data m-t-30 send-enquiry-section m-b-30" id="listing_list_view_enquiry">
    <div class="pos-fixed fly-out enquiry-card">
        <div class="mobile-back desk-hide mobile-flex">
            <div class="left mobile-flex">
                <i class="fa fa-arrow-left text-primary back-icon" aria-hidden="true"></i>
                <p class="element-title heavier m-b-0">Back</p>
            </div>
            <div class="right">
                <!-- <a href="" class="text-primary heavier element-title">Clear All</a> -->
            </div>
        </div>
        <div class="fly-out__content">
            <div class="bg-card filter-cards add-card enquiry-add-card flex-row white-space align-top">
                <div class="add-card__content">
                    <p class="element-title heavier title flex-row">
                        <img src="{{ asset('/img/business.png') }}" class="img-responsive p-r-10">
                        Find Suppliers at<br> lowest rate
                    </p>
                    <p class="m-b-0 sub-title p-t-10 text-color">
                        To get best deals, send your enquiry now.
                    </p>
                </div>
                <div class="add-card__form">
                    @include('modals.listing_enquiry_popup.popup_level_one', array("no_title" => true, "is_multi_select_dropdown" => true, "enquiry_send_button" => true, "enquiry_modal_id" => "#multi-quote-enquiry-modal"))
                </div>
            </div>
        </div>    
    </div>
    <div class="sticky-bottom  mobile-flex desk-hide">
        <div class="stick-bottom__text">
            <p class="m-b-0 element-title text-capitalise bolder">Get best deals in "Meat &amp; poultry"</p>
        </div>
        <div class="actions">
            <button class="btn fnb-btn primary-btn full border-btn send-enquiry" type="button">Send an Enquiry</button>
        </div>
    </div>
</div>