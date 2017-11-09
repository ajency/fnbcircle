@extends('layouts.profile')

@section('js')
    @parent
    <script type="text/javascript" src="/js/basic-details.js"></script>
    @if(Session::has('passwordChange')) 
    <script type="text/javascript">
    $('.alert-success').addClass('active');
    setTimeout((function() {
      $('.alert-success').removeClass('active');
    }), 5000);
    </script>
    @endif
@endsection

@section('main-content')
	<div class="activity tab-pane fade active in" id="activity">
                                    <!-- <div class="activity-panel"> -->
                                        <!--    <div class="activity-panel__header flex-row space-between">
                                            <div class="activity-name">
                                                <i class="fa fa-bell" aria-hidden="true"></i>
                                                Abhay Rajput activity
                                            </div>
                                            <div class="activity-action">
                                                <label class="verified-toggle flex-row" for="tog">
                                                    <p class="toggle-text recent-activity m-b-0">Recent activity</p>
                                                    <div class="toggle m-l-10 m-r-10">
                                                        <input type="checkbox" class="toggle__check" id="tog">
                                                        <b class="switch"></b>
                                                        <b class="track"></b>
                                                    </div>
                                                    <p class="toggle-text all-activity m-b-0 checked">All time activity</p>
                                                </label>
                                            </div>
                                        </div> -->
                                      <!--   <h6 class="enquiries-made title">
                                            <i aria-hidden="true" class="fa fa-bell">
                                            </i>
                                            Abhay Rajput activity
                                            <div class="activity-action">
                                                <label class="verified-toggle flex-row" for="tog">
                                                    <p class="toggle-text recent-activity m-b-0">
                                                        Recent activity
                                                    </p>
                                                    <div class="toggle m-l-10 m-r-10">
                                                        <input class="toggle__check" id="tog" type="checkbox">
                                                            <b class="switch">
                                                            </b>
                                                            <b class="track">
                                                            </b>
                                                        </input>
                                                    </div>
                                                    <p class="toggle-text all-activity m-b-0 checked">
                                                        All time activity
                                                    </p>
                                                </label>
                                            </div>
                                        </h6>
                                        <br>
                                            <div class="activity-panel__body">
                                                <div class="activity-col flex-row space-between">
                                                    <div class="flex-col activity-col__content">
                                                        <h6 class="sub-title heavier ellipsis contentTitle">
                                                            Abhay Rajput posted a
                                                            <a class="secondary-link" href="#">
                                                                Business Listing
                                                            </a>
                                                            Colaba Chicken Center
                                                        </h6>
                                                        <div class="center-details">
                                                            <div class="center-details__name text-color text-medium">
                                                                Colaba Chicken Center
                                                            </div>
                                                            <div class="area flex-row">
                                                                <i aria-hidden="true" class="fa fa-map-marker p-r-10">
                                                                </i>
                                                                <span class="text-lighter lighter">
                                                                    Gandhi Nagar, Delhi
                                                                </span>
                                                                <div class="rating rating-small p-l-10">
                                                                    <div class="bg">
                                                                    </div>
                                                                    <div class="value" style="width: 80%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex-col activity-col__actions">
                                                        <div class="lighter text-lighter date">
                                                            11 July
                                                        </div>
                                                        <a class="primary-link" href="#">
                                                            View Details
                                                            <i aria-hidden="true" class="fa fa-arrow-right p-l-5">
                                                            </i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <hr>
                                                    <div class="activity-col flex-row space-between">
                                                        <div class="flex-col activity-col__content">
                                                            <h6 class="sub-title heavier ellipsis contentTitle">
                                                                Abhay Rajput posted a
                                                                <a class="secondary-link" href="#">
                                                                    Job
                                                                </a>
                                                                Food & Beverage Manager
                                                            </h6>
                                                            <div class="center-details">
                                                                <div class="center-details__name text-color text-medium">
                                                                    Food & Beverage Manager
                                                                </div>
                                                                <div class="area flex-row">
                                                                    <i aria-hidden="true" class="fa fa-map-marker p-r-10">
                                                                    </i>
                                                                    <span class="text-lighter lighter">
                                                                        Delhi (Dwarka, Ghonda, Mundka)
                                                                    </span>
                                                                </div>
                                                                <div class="time-cat">
                                                                    <label class="fnb-label">
                                                                        Full-time
                                                                    </label>
                                                                    @InterContinental Hotels Group
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="flex-col activity-col__actions">
                                                            <div class="lighter text-lighter date">
                                                                11 July
                                                            </div>
                                                            <a class="primary-link" href="#">
                                                                View Details
                                                                <i aria-hidden="true" class="fa fa-arrow-right p-l-5">
                                                                </i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                        <div class="activity-col flex-row space-between">
                                                            <div class="flex-col activity-col__content">
                                                                <h6 class="sub-title heavier ellipsis contentTitle">
                                                                    Abhay Rajput posted a
                                                                    <a class="secondary-link" href="#">
                                                                        Business Listing
                                                                    </a>
                                                                    Colaba Chicken Center
                                                                </h6>
                                                                <div class="center-details">
                                                                    <div class="center-details__name text-color text-medium">
                                                                        Colaba Chicken Center
                                                                    </div>
                                                                    <div class="area flex-row">
                                                                        <i aria-hidden="true" class="fa fa-map-marker p-r-10">
                                                                        </i>
                                                                        <span class="text-lighter lighter">
                                                                            Gandhi Nagar, Delhi
                                                                        </span>
                                                                        <div class="rating rating-small p-l-10">
                                                                            <div class="bg">
                                                                            </div>
                                                                            <div class="value" style="width: 80%;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="flex-col activity-col__actions">
                                                                <div class="lighter text-lighter date">
                                                                    11 July
                                                                </div>
                                                                <a class="primary-link" href="#">
                                                                    View Details
                                                                    <i aria-hidden="true" class="fa fa-arrow-right p-l-5">
                                                                    </i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </hr>
                                                </hr>
                                            </div>
                                        </br>
                                    </div> -->

                                    <h3 class="profile-stats__title text-medium sectionTitle mobile-hide">
                                        My Basic Details
                                    </h3>
                                    
                                    <div class="basic-detail">
                                        <div class="contactCard">
                                            <h3 class="sub-title basic-detail__title">Basic Details</h3>
                                              <div class="verification-content">
                                    <input type="hidden" name="object_type" value="App\User"/>
                                    <input type="hidden" name="object_id" value="{{ auth()->user()->id }}"/>

                                            <form method="POST" action="{{action('ProfileController@changePhone')}}" >
                                            <div class="basic-detail__col flex-row flex-wrap">
                                                <div class="form-group m-b-0">
                                                    <label class="m-b-0 text-lighter float-label required" for="contact_name">Name</label>
                                                    <input type="text" class="form-control fnb-input float-input" id="contact_name" value="{{$details['name']}}" name="username">
                                                </div>
                                                <div class="form-group m-b-0 flex-row space-between">
                                                    <div class="flex-full flex-1">
                                                        <label class="m-b-0 text-lighter float-label required" for="contact_email">Email</label>
                                                        <input type="email" class="form-control fnb-input float-input" id="contact_email" value="{{$details['email']['email']}}" disabled>
                                                    </div>
                                                    <div class="verified flex-row m-t-20 p-l-5">
                                                        @if($details['email']['is_verified'] == 1) <span class="fnb-icons verified-icon">
                                                        </span> @else <i class="fa fa-times not-verified" aria-hidden="true"></i> @endif
                                                        <div class="text-color">
                                                           @if($details['email']['is_verified'] == 0) Not @endif Verified
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group p-t-10 m-b-0 flex-row space-between contact-info contact-info-mobile" contact-type="mobile">
                                                    <div class="contact-container flex-row space-between full-width">
                                                        <div class="flex-1">
                                                            <label class="m-b-0 text-lighter float-label filled required" for="contact_phone">Phone No</label>
                                                            <div class="flex-full">
                                                                <input type="hidden" class="contact_mobile_id contact-id" readonly value=""  name="contact_mobile_id" id="requirement_contact_mobile_id">
                                                                <input type="tel" class="form-control fnb-input float-input contact-input contact-mobile-input contact-mobile-number" id="contact_phone" value="{{$details['phone']['contact']}}" name="contactNumber" @if($details['phone']['is_verified'] == 1) disabled @endif>
                                                                <input type="hidden" class="contact-country-code" name="contact_country_code[]" value="{{ $details['phone']['contact_region'] }}">
                                                            </div>
                                                        </div>    
                                                        <div class="verified m-t-15 flex-row">
                                                            @if($details['phone']['is_verified'] == 1)
                                                              <span class="fnb-icons verified-icon"></span> 
                                                            @else 
                                                              <!-- <i class="fa fa-times not-verified" aria-hidden="true"></i>  -->
                                                            @endif
                                                            <div class="text-color">
                                                            @if($details['phone']['is_verified'] == 0) @if($self) 
                                                              <a href="javascript:void(0)" class="secondary-link contact-verify-link secondary-link text-decor verifyPhone">Verify now</a>
                                                              <div name="" class="under-review hidden">
                                                                <input type="hidden" class="contact-visible" value="0"/>
                                                              </div> @else <i class="fa fa-times not-verified" aria-hidden="true"></i>  Not Verified  @endif @else Verified @endif 
                                                            </div>
                                                        </div>
                                                    </div>   
                                                </div>
                                                <div class="form-group p-t-10 m-b-0">
                                                    <label class="m-b-0 text-lighter float-label required filled lab-color" for="member">Member Since</label>
                                                    <input type="text" class="form-control fnb-input float-input" id="member" value="{{$details['joined']}}" disabled>
                                                </div>
                                                <div class="form-group p-t-20 m-b-0 save-btn">
                                                   <button class="btn fnb-btn primary-btn full border-btn" >Save</button>
                                                </div> 
                                            </div>
                                            </form>
                                            </div>
                                        </div>
                                        @if($self and $details['password'])
                                        <div class="contactCard">
                                            <h3 class="sub-title basic-detail__title">Change Password</h3>
                                        <form id="password_form" method="POST" action="{{action('ProfileController@changePassword')}}">
                                            <div class="basic-detail__col flex-row flex-wrap align-top">
                                                <div class="form-group m-b-0">
                                                    <label class="m-b-0 text-lighter float-label required full-label" for="password">Old Password</label>
                                                    <input type="password" class="form-control fnb-input float-input" name="old_password" id="old">
                                                    @if ($errors->has('old_password'))
                                                        <span class="fnb-errors">
                                                            {{ $errors->first('old_password') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group m-b-0">
                                                    <label class="m-b-0 text-lighter float-label required full-label" for="new">New Password</label>
                                                    <input type="password" class="form-control fnb-input float-input" name="new_password" id="password" value="">
                                                    <label id="password_errors" class="fnb-errors hidden"></label>

                                                </div>
                                                <div class="form-group p-t-10 m-b-0">
                                                    <label class="m-b-0 text-lighter float-label required full-label" for="confirm">Confirm Password</label>
                                                    <input type="password" class="form-control fnb-input float-input" name="new_password_confirmation" id="password-confirm">
                                                    <label id="password_confirm_errors" class="fnb-errors hidden"></label>
                                                </div>
                                                <div class="form-group p-t-20 m-b-0 save-btn">
                                                   <button class="btn fnb-btn primary-btn full border-btn" type="submit" disabled id="password_save">Save</button>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                        @endif
                                        <br><br>
                                    </div>
                                </div>

@if(Session::has('passwordChange')) 
<div class="alert fnb-alert alert-success alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <div class="flex-row">
        <i class="fa fa-check-circle" aria-hidden="true"></i>
        Password changed successfully.
    </div>
</div>

@endif
@endsection