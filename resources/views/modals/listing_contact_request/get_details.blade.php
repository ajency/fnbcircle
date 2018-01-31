<div class="content-data">
   <input type="hidden" name="contact-request-step" value="get-details">
   <input type="hidden" id="cr-details-form-submit-link" value="{{action('ContactRequestController@getDetails')}}">
   <!-- Contact Details -->
   <div class="level-one enquiry-details flex-row ">
      <div class="detail-cols extra-padding col-left col-left--full enquiry-details__intro flex-row">
         <div class="send-enquiry contactEnquiry">
            <h5 class="intro-text flex-row space-between">
               Please login to view the <br class="mobile-hide"> contact details of...
            </h5>
            <div class="seller-enquiry">
               <p class="sub-title heavier text-darker text-capitalise flex-row seller-enquiry__title m-t-10"><span class="brand-name">{{$listing->title}}</span> @if($listing->verified == 1)<span class="fnb-icons verified-icon"></span>@endif</p>
               <div class="location flex-row mobile-hide">
                  <span class="fnb-icons map-icon"></span>
                  <p class="location__title m-b-0 text-lighter">{{$area->city['name']}}, {{$area->name}}</p>
               </div>
               <div class="rat-view flex-row mobile-hide">
                  <div class="rating">
                     <div class="bg"></div>
                     <div class="value" style="width: 80%;"></div>
                  </div>
                  <div class="views flex-row">
                     <span class="fnb-icons eye-icon"></span>
                     <p class="views__title text-lighter m-b-0"><span class="heavier">{{displayCount($listing->views_count)}}</span> Views</p>
                  </div>
               </div>

            </div>
            <div class="m-t-50 log-link sub-title">
               <a href="#" class="primary-link heavier text-decor" data-dismiss="modal" data-toggle="modal" data-target="#login-modal">Login if already registered</a>
            </div>
            @isset($error)
             <p class="fnb-errors m-t-20 sub-title">{{$error}}</p>
            @endisset
         </div>
      </div>
      <div class="detail-cols extra-padding contact col-right enquiry-details__content relative">
         <form id="get-crdetails-form"> 
         <h5 class="intro-text">Give your details below
         </h5>
         <p class="content-title text-darker m-b-0 m-t-10 heavier">Ensure that you provide the correct details as the business owner will use these details to contact you.</p>
         <div class="formFields row">
            <div class="col-sm-12">
               <div class="form-group m-b-10">
                  <label class="m-b-0 text-lighter float-label required" for="contact_name">Name</label>
                  <input type="text" class="form-control fnb-input float-input" id="contact_name" data-parsley-required data-parsley-required-message="Please enter your name">
               </div>
            </div>
            <div class="col-sm-12">
               <div class="form-group m-b-10">
                  <label class="m-b-0 text-lighter float-label required" for="contact_email">Email</label>
                  <input type="email" class="form-control fnb-input float-input" id="contact_email" data-parsley-type-message="Please enter a valid email." data-parsley-type="email" required="" data-parsley-required-message="Please enter your email">
               </div>
            </div>
            <div class="col-sm-12">
               <div class="contact-phone-intl form-group m-b-10">
                  <label class="m-b-0 text-lighter float-label filled dis-block required" for="contact_number">Phone</label>
                  <input type="tel" class="form-control fnb-input float-input dis-block" id="contact_number" data-parsley-length-message="Mobile number should be 10 digits." data-parsley-type="digits" data-parsley-length="[10, 10]" required="" data-parsley-required-message="Please enter your contact number" data-parsley-errors-container="#intl-error">
                  <div id="intl-error" class="fnb-errors"></div>
               </div>
            </div>
            <div class="col-sm-12">
               <div class="describes best-section m-t-5">
                  <label class="m-b-0 text-lighter float-label filled focused required" for="contact_describe">What describes you the best? <span class="xx-small text-lighter">(Please select atleast one)</span></label>
                  <!-- <p class="text-darker describes__title text-medium"></p> -->
                  <div class="row">
                     <div class="col-sm-12">
                        <select class="fnb-select select-variant entry-describe-best" multiple="multiple" required="" data-parsley-required-message="Please select atleast one description" id="contact_description">
                           <option value="hospitality">Hospitality Business Owner</option>
                           <option value="vendor">Vendor/Supplier/Service provider</option>
                           <option value="enterpreneur">Prospective Entrepreneur</option>
                           <option value="professional">Working Professional</option>
                           <option value="student">Hospitality Student</option>
                           <option value="others">Others</option>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="p-t-10">
            <div class="send-action">
               <button type="button" class="btn fnb-btn primary-btn full border-btn" id="cr-get-details-form-submit">Submit <i class="fa fa-circle-o-notch fa-spin fa-fw contact-sub-spin hidden"></i></button>
            </div>
         </div>
         </form>
         <div class="or-divider">
            OR
         </div>
      </div>
   </div>
   <!-- Contact Details End -->
</div>