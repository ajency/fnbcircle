@extends('layouts.add-job')


@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('bower_components/intl-tel-input/build/css/intlTelInput.css') }}">
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/jobs.js') }}"></script>
    <!-- <script type="text/javascript" src="{{ asset('js/verification.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('bower_components/intl-tel-input/build/js/intlTelInput.min.js') }}"></script>  
  >
@endsection
@section('form-data')


@include('jobs.notification')
 
<input type="hidden" name="_method" value="PUT">
<input type="hidden" name="step" value="company-details">
 
 

<div class="business-info tab-pane fade in active" id="company_details">
 
    <!-- <h5 class="no-m-t fly-out-heading-size main-heading white m-t-0 margin-btm ">Job Information</h5> -->
    <h5 class="no-m-t main-heading  white m-t-0 margin-btm">Company Details</h5>

    <!-- Job title/category -->

    
    <!-- Company logo -->

    <div class="m-t-40 c-gap">
        <div class="J-company flex-row">
            <div class="J-company__logo">
                <input type="file" name="company_logo" class="comp-logo" data-height="100" @if($companyLogo!="") data-default-file="{{ $companyLogo }}" @endif data-allowed-file-extensions="png jpg jpeg gif" @if($companyLogo!="") title="{{ basename ($companyLogo) }}" @endif />

                <input type="hidden" name="delete_logo" value="0">
            </div>
            <div class="J-company__name">
                <label class="label-size required">Name of your company?</label>
                <input type="text" name="company_name" class="form-control fnb-input auto-company flexdatalist"  data-min-length='1' placeholder="" value="{{ $jobCompany['title'] }}" data-parsley-required-message="Please enter the company name." data-parsley-required data-parsley-maxlength=255 data-parsley-maxlength-message="company name cannot be more than 255 characters." data-parsley-required data-parsley-minlength=2 data-parsley-minlength-message="company name cannot be less than 2 characters."> 
                <input type="hidden" name="company_id" value="{{ $jobCompany['id'] }}">  
            </div>
        </div>
    </div>
    
    <!-- Company desc -->

    <div class="m-t-40 c-gap">
        <label class="label-size">Describe your company in brief <span class="text-lighter">(optional)</span>:</label>
 
         <textarea class="form-control fnb-input" name="company_description" id="editor" placeholder="Enter a brief summary of the Job" >{{ $jobCompany['description'] }} </textarea>
    </div>

    <!-- Company website -->

    <div class="m-t-40 c-gap">
        <label class="label-size">Does your company have a website? <span class="text-lighter">(optional)</span>:</label>
        <input type="text" name="company_website" data-parsley-pattern="/(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/" data-parsley-pattern-message="Please enter valid url"  class="form-control fnb-input" placeholder="http://" value="{{ $jobCompany['website'] }}">  
    </div>


    <div class="m-t-40 flex-row c-gap">
        <div class="m-r-10 no-m-l">
            <label class="element-title">Contact Details</label>
            <!-- <div class="text-lighter">
                Seekers would like to contact you or send enquiries. Please share your contact details below. We have pre-populated your email and phone number from your profile details.
            </div> -->
        </div>
        <!-- <span class="fnb-icons contact mobile-hide"></span> -->
        <!-- <img src="img/enquiry.png" class="mobile-hide"> -->
        
    </div>

    <!-- contact verification HTML -->
    <input type="hidden" name="object_type" value="App\Job">
    <input type="hidden" name="object_id" value="{{ $job->id}}">
    <!-- email -->
    @include('modals.verification.email-verification')
    
    <!-- phone number -->
    @include('modals.verification.mobile-verification')

    <!-- phone number -->
    @include('modals.verification.landline-verification')
    <!-- /contact verification HTML -->

    </div>

<!-- contact verification MODAL -->
<!-- Phone verification -->
@include('modals.verification.mobile-modal')

<!-- Email verification -->
@include('modals.verification.email-modal')
<!-- contact verification MODAL -->


@endsection
