<!-- Level two starts -->

<div class="level-three levels">
    <p class="content-title text-darker m-b-0 text-medium mobile-hide">Verify your phone number to contact the listing.</p>
    <!-- verify email and contact -->
    <div class="verification gap-separator" id="level-two-enquiry">
        <p class="content-title text-darker m-b-0 text-lighter desk-hide m-b-15">Verify your phone number to contact the listing.</p>
        <!-- <p class="content-title text-darker m-b-0 text-lighter desk-hide m-b-15">Verify your email and phone number to contact the listing.</p>
        <div class="verification__row flex-row">
            <div class="verification__detail flex-row">
                <div class="verify-exclamation">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                </div>
                <p class="text-darker verification__text larger">Please enter the code sent to <br clear="desk-hide verify-seperator"><span class="email bolder">valenie@gmail.com</span> <a href="#" class="heavier secondary-link text-decor">Edit</a></p>
            </div>
            <div class="verification__col">
                <div class="verification__code">
                    <input type="text" class="form-control fnb-input" placeholder="Enter the code">
                    <a href="#" class="secondary-link text-decor p-l-10 x-small" id="level-two-form-btn">Submit</a>
                    <p class="x-small text-lighter m-b-0 m-t-10 didnt-receive">Didn't receive the code? <a href="#" class="dark-link x-small heavier"><i class="fa fa-refresh" aria-hidden="true"></i> Resend Email</a></p>
                </div>
            </div>
        </div>
        <hr> -->
        <div class="verification__row flex-row">
            <div class="verification__detail flex-row">
                <div class="verify-exclamation">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                </div>
                <p class="text-darker verification__text larger">Please enter the code sent to <br clear="desk-hide verify-seperator"><span class="mobile bolder">{{ isset($data["contact_code"]) ? $data["contact_code"] : '+91' }} {{ isset($data["contact"]) ? $data["contact"] : '' }} </span> <a href="#" class="heavier secondary-link text-decor">Edit</a></p>
            </div>
            <div class="verification__col">
                <div class="verification__code">
                    <input type="text" id="code_otp" name="code_otp" class="form-control fnb-input" placeholder="Enter the code">
                    <a href="#" class="secondary-link text-decor p-l-10 x-small" id="level-two-form-btn" data-value="{{ isset($data['next_page']) && strlen($data['next_page']) ? $data['next_page'] : ''}}">Submit</a>
                    <p class="x-small text-lighter m-b-0 m-t-10 didnt-receive">Didn't receive the code? <a href="#" class="dark-link x-small heavier" id="level-two-resend-btn" data-value="{{ isset($data['current_page']) && strlen($data['current_page']) ? $data['current_page'] : ''}}"><i class="fa fa-refresh" aria-hidden="true"></i> Resend SMS</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Level two ends -->