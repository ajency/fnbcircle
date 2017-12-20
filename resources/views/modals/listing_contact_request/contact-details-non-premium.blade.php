<!-- Thank you  -->
<div class="thankyou-msg success-stuff">
   <div class="enquiry-success contact-success">
      <div class="flex-row align-top">
         <i class="fa fa-check-circle" aria-hidden="true"></i>
         <div>
            <h6 class="enquiry-success__text m-t-0 thanks-text">Thank you for showing your interest!</h6>
            <p class="enquiry-success__sub-text">
               Email &amp; SMS with the contact details of <span class="text-darker text-decor heavier">{{$listing->title}}</span> have been sent to you. You can now contact the owner directly.
            </p>
            <p class="enquiry-success__sub-text m-b-0 owner-detail">
               @if($listing->owner != null) We have also shared your contact details with the owner <i class="fa fa-user-circle text-color"></i> <span class="bolder text-darker">{{$listing->owner()->first()->name}}</span> @endif
            </p>
         </div>
      </div>
   </div>
   <div class="vendor-contact-details">
      <h6 class="text-color m-b-5 flex-row space-between">{{$listing->title}} Details
         <div class="icon-notation mobile-hide">
            <div class="flex-row">
               <span class="fnb-icons verified-icon scale-down"></span>
               <span class="text-color">Verified</span>
               <span class="fa fa-times-circle text-danger m-l-10 m-r-5"></span>
               <span class="text-color">Unverified</span>
            </div>
         </div>
      </h6>
      <div class="row">
         @php
            $contacts = $listing->getAllContacts();
         @endphp
         @if(count($contacts['email']))
         <div class="col-sm-4">
            <label class="m-t-15 vendor-label">Email</label>
            @foreach($contacts['email'] as $email)
            <div class="flex-row flex-wrap">
               <p class="m-b-0">
                  <a href="email:{{$email['email']}}" class="text-darker m-r-10">{{$email['email']}}</a>
               </p>
               <div class="flex-row">
               @if($email['is_verified'])
                  <span class="fnb-icons verified-icon scale-down"></span>
                  <!-- <span class="text-color">Verified</span> -->
               @else
                  <span class="fa fa-times-circle text-danger m-r-10"></span>
                  <!-- <span class="text-color">Unverified</span> -->
               @endif
               </div>
            </div>
            @endforeach
         </div>
         @endif
         @if(count($contacts['mobile']))
         <div class="col-sm-4">
            <label class="m-t-15 vendor-label">Phone</label>
            @foreach($contacts['mobile'] as $phone)
            <div class="flex-row flex-wrap">
               <p class="m-b-0">
                  <a href="tel:+{{$phone['contact_region']}}-{{$phone['contact']}}" class="text-darker m-r-10">+{{$phone['contact_region']}}-{{$phone['contact']}}</a>
               </p>
               <div class="flex-row">
               @if($phone['is_verified'])
                  <span class="fnb-icons verified-icon scale-down"></span>
                  <span class="text-color">Verified</span>
               @else
                  <span class="fa fa-times-circle text-danger m-r-10"></span>
                  <!-- <span class="text-color">Unverified</span> -->
               @endif
               </div>
            </div>
            @endforeach
         </div>
         @endif
         @if(count($contacts['landline']))
         <div class="col-sm-4">
            <label class="m-t-15 vendor-label">Landline</label>
            @foreach($contacts['landline'] as $phone)
            <div class="flex-row flex-wrap">
               <p class="m-b-0">
                  <a href="tel:+{{$phone['contact_region']}}-{{$phone['contact']}}" class="text-darker m-r-10">+{{$phone['contact_region']}}-{{$phone['contact']}}</a>
               </p>
               <div class="flex-row">
               </div>
            </div>
            @endforeach
         </div>
         @endif
      </div>
      <div class="sub-title m-t-30 m-b-10 flex-row flex-wrap name-mention">
         <span class="fnb-icons exclamation m-r-10"></span>
         <div>When you contact the listing, don't forget to mention that you found it on FnBCircle</div>
      </div>
   </div>

   
   <div class="suppliers-data ">
      <p class="element-title heavier text-darker">Don't miss out on these suppliers <img src="/img/direction-down-2.png" class="img-responsive direction-down"></p>
      @include('list-view.single-card.listing_card', array('exclude_enquiry' => 'true'))
      <p class="small text-lighter m-t-20 m-b-0">
         Disclaimer: FnBCircle is only an intermediary platform between the business owners and seekers and hence shall neither be responsible nor liable to mediate or resolve any disputes or disagreements between the business owners and seekers.
      </p>
   </div>
</div>
<!-- Thank you End