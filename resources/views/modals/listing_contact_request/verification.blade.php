<div class="content-data">
   <input type="hidden" id="cr-otp-submit-link" value="{{action('ContactRequestController@verifyOtp')}}">
   <input type="hidden" id="cr-otp-resend-link" value="{{action('ContactRequestController@resendOtp')}}">
   <!-- Verify Details -->
   <div class="level-two levels verify-details detail-cols shown">
      <h6 class="intro-text">Verify your number to contact {{$listing->title}}
      </h6>
      <div class="verification vertical-margin gap-separator">
         <p class="content-title text-darker m-b-0 text-lighter desk-hide m-b-15">Verify your phone number to contact the listing.</p>
         <div class="verification__row flex-row">
            <div class="verification__detail flex-row">
               <div class="verify-exclamation">
                  <i class="fa fa-exclamation" aria-hidden="true"></i>
               </div>
               <p class="text-darker verification__text larger">Please enter the code sent to <br clear="desk-hide verify-seperator"><span class="email bolder">+{{$number}}</span> <a href="#" id="edit-cr-number"class="heavier secondary-link text-decor">Edit</a></p>
            </div>
            <div class="flex-row flex-end verification__col">
               <div class="verification__code text-right">
                  <input type="password" class="form-control fnb-input" placeholder="Enter the code" id="input-cr-otp" data-parsley-required data-parsley-error-message="Please enter valid OTP" data-parsley-length="[4, 4]"  data-parsley-type="digits">
                  <div class="error">@isset($error){{$error}}@endisset</div>
                  <a href="#" class="secondary-link text-decor p-l-10 x-small" id="submit-cr-otp">Submit</a>
                  <p class="x-small text-lighter m-b-0 m-t-5 didnt-receive">Didn't receive the code? <a href="#" class="dark-link x-small heavier"><i class="fa fa-refresh" aria-hidden="true"></i> Resend SMS</a></p>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Verify Details End -->
</div>
