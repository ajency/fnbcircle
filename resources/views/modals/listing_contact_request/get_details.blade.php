<div class="content-data">
   <!-- Contact Details -->
   <div class="level-one enquiry-details flex-row ">
      <div class="detail-cols extra-padding col-left col-left--full enquiry-details__intro flex-row">
         <div class="send-enquiry">
            <h5 class="intro-text flex-row space-between">
               Please login to view the <br class="mobile-hide"> contact details of...
            </h5>
            <div class="seller-enquiry">
               <p class="sub-title heavier text-darker text-capitalise flex-row seller-enquiry__title"><span class="brand-name">{{$listing->title}}</span> <span class="fnb-icons verified-icon"></span></p>
               <div class="location flex-row mobile-hide">
                  <span class="fnb-icons map-icon"></span>
                  <p class="location__title m-b-0 text-lighter">Mumbai, Andheri</p>
               </div>
               <div class="rat-view flex-row mobile-hide">
                  <div class="rating">
                     <div class="bg"></div>
                     <div class="value" style="width: 80%;"></div>
                  </div>
                  <div class="views flex-row">
                     <span class="fnb-icons eye-icon"></span>
                     <p class="views__title text-lighter m-b-0"><span class="heavier">126</span> Views</p>
                  </div>
               </div>
            </div>
            <div class="m-t-50 log-link sub-title">
               <a href="#" class="primary-link heavier text-decor" data-toggle="modal" data-target="#login-modal">Login if already registered</a>
            </div>
         </div>
      </div>
      <div class="detail-cols extra-padding contact col-right enquiry-details__content">
         <h5 class="intro-text">Give your details below
         </h5>
         <p class="content-title text-darker m-b-0 m-t-10 text-medium">Ensure that you provide the correct details as the business owner will use these details to contact you.</p>
         <div class="formFields row">
            <div class="col-sm-12">
               <div class="form-group m-b-0">
                  <label class="m-b-0 text-lighter float-label required" for="contact_name">Name</label>
                  <input type="text" class="form-control fnb-input float-input" id="contact_name">
               </div>
            </div>
            <div class="col-sm-12">
               <div class="form-group m-b-0">
                  <label class="m-b-0 text-lighter float-label required" for="contact_email">Email</label>
                  <input type="email" class="form-control fnb-input float-input" id="contact_email">
               </div>
            </div>
            <div class="col-sm-12">
               <div class="">
                  <label class="m-b-0 text-lighter float-label required" for="contact_number">Phone</label>
                  <input type="tel" class="form-control fnb-input float-input" id="contact_number">
               </div>
            </div>
            <div class="col-sm-12">
               <div class="describes best-section m-t-5">
                  <label class="m-b-0 text-lighter float-label filled focused required" for="contact_describe">What describes you the best? <span class="xx-small text-lighter">(Please select atleast one)</span></label>
                  <!-- <p class="text-darker describes__title text-medium"></p> -->
                  <div class="row">
                     <div class="col-sm-6">
                        <select class="fnb-select select-variant entry-describe-best" multiple="multiple">
                           <option>I work in the F&amp;B industry</option>
                           <option>I am a resturant owner</option>
                           <option>I am a supplier to F&amp;B industry</option>
                           <option>I provide services to F&amp;B industry</option>
                           <option>I am a manufacturer</option>
                           <option>Others...</option>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="p-t-10">
            <div class="send-action">
               <button class="btn fnb-btn primary-btn full border-btn">Submit <i class="fa fa-circle-o-notch fa-spin fa-fw"></i></button>
            </div>
         </div>
         <div class="or-divider">
            OR
         </div>
      </div>
   </div>
   <!-- Contact Details End -->
</div>