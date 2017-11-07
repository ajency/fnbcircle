@extends('layouts.app')
@section('title', 'My Profile')
@section('css')
    
@endsection

@section('js')
    
@endsection

@section('content')
    <div class="profile-stats edit-mode">
            <div class="container">
                <div class="row p-t-30 mobile-flex breadcrums-container">
                    <div class="col-sm-8 flex-col">
                        <!-- Breadcrums -->
                        <ul class="fnb-breadcrums flex-row">
                            <li class="fnb-breadcrums__section">
                                <a href="">
                                    <i aria-hidden="true" class="fa fa-home home-icon">
                                    </i>
                                </a>
                            </li>
                            <li class="fnb-breadcrums__section">
                                <a href="">
                                    <p class="fnb-breadcrums__title">
                                        /
                                    </p>
                                </a>
                            </li>
                            <li class="fnb-breadcrums__section">
                                <a href="">
                                    <p class="fnb-breadcrums__title">
                                        Valenie Lourenco's profile
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <!-- Breadcrums ends -->
                    </div>
                    <div class="col-sm-4 flex-col">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 fixed-profile-info">
                        <!-- <div class="pos-fixed fly-out slide-bg"> -->
                           <!--  <div class="mobile-back desk-hide mobile-flex">
                                <div class="left mobile-flex">
                                    <i aria-hidden="true" class="fa fa-arrow-left text-primary back-icon">
                                    </i>
                                    <p class="element-title heavier m-b-0">
                                        Back
                                    </p>
                                </div>
                            </div> -->
                            <div class="infoCard">
                                <div class="person-info">
                                    <div class="Profile">
                                        <div class="Profile__header flex-row">
                                            <i aria-hidden="true" class="fa fa-user-circle">
                                            </i>
                                            <div class="name">
                                                <h3 class="element-title text-medium name-text">
                                                    Valenie Lourenco
                                                </h3>
                                                <div class="text-color">
                                                    Joined: June,12, 2017
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                            <div class="Profile__body">
                                                <div class="email-row contact flex-row space-between">
                                                    <div>
                                                        <h6 class="heavier sub-title">
                                                            Email
                                                        </h6>
                                                        <a class="sub-title dark-link lighter" href="mailto:contactus@mystical.com">
                                                            valenie@ajency.in
                                                        </a>
                                                    </div>
                                                    <div class="verified flex-row">
                                                        <span class="fnb-icons verified-icon">
                                                        </span>
                                                        <div class="text-color">
                                                            Verified
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="phone-row contact flex-row space-between">
                                                    <div>
                                                        <h6 class="heavier sub-title">
                                                            Phone number
                                                        </h6>
                                                        <a class="sub-title dark-link lighter" href="tel:+919879870099">
                                                            +91 9881234567
                                                        </a>
                                                    </div>
                                                    <div class="verified flex-row">
                                                        <i class="fa fa-times not-verified" aria-hidden="true"></i>
                                                        <div class="text-color">
                                                            Not Verified
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </hr>
                                    </div>
                                </div>
                                <div class="nav nav-tabs">
                                    <ul class="gs-steps" role="tablist">
                                        <li class="active">
                                            <a class="form-toggle" data-toggle="tab" href="#enquiry-info" role="tab">
                                                My Activity
                                                <i aria-hidden="true" class="fa fa-arrow-right">
                                                </i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="form-toggle" data-toggle="tab" href="#activity" role="tab">
                                                Basic Details
                                                <i aria-hidden="true" class="fa fa-arrow-right">
                                                </i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="form-toggle" data-toggle="tab" href="#describe-best" role="tab">
                                                What describe you the best?
                                                <i aria-hidden="true" class="fa fa-arrow-right">
                                                </i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <!-- </div> -->
                    </div>
                    <div class="col-sm-8">
                        <h3 class="profile-stats__title text-medium topLabel">
                            My Activity
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Profile stats ends -->
        <!-- profile info starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-8">
                    <div class="pos-fixed fly-out profile-info">
                        <div class="mobile-back desk-hide mobile-flex">
                            <div class="left mobile-flex">
                                <i aria-hidden="true" class="fa fa-arrow-left text-primary back-icon">
                                </i>
                                <p class="element-title heavier m-b-0">
                                    Back
                                </p>
                            </div>
                        </div>
                        <div class="fly-out__content edit-mode">
                            <div class=" tab-content">
                                <div class="enquiry-info tab-pane fade in active" id="enquiry-info">
                                <h3 class="profile-stats__title text-medium sectionTitle mobile-hide">
                                    My Activity
                                </h3>
                                <ul class="nav activityTab" role="tablist">
                                    <li class="active" role="presentation">
                                        <a aria-controls="recent-activity" data-toggle="tab" href="#recent-activity" role="tab">
                                            Recent Activity <span class="xx-small text-medium text-lighter">(<i class="fa fa-clock-o" aria-hidden="true"></i> Last 7 days)</span>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a aria-controls="all-activity" data-toggle="tab" href="#all-activity" role="tab">
                                            All time activity
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="recent-activity" role="tabpanel">
                                        <!-- <h6 class="enquiries-made title">
                                            <i aria-hidden="true" class="fa fa-comments">
                                            </i>
                                            Enquiries made to you by Amit Adav
                                        </h6> -->
                                        <!-- <p class="text-color default-size m-b-0 text-right lastUpdated heavier"></p> -->

                                        <p class="default-size mainDate"><span><i class="fa fa-calendar p-r-5" aria-hidden="true"></i> 03 July 2017</span></p>

                                        <div class="enquire-container">
                                            <h6 class="enquiry-made-by text-medium">
                                                You made a
                                                <label class="fnb-label">
                                                    Direct Enquiry
                                                </label>
                                                to
                                                <a class=" text-decor" href="#">
                                                    Mystical the meat and fish store
                                                </a>
                                            </h6>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <dl class="flex-row flex-wrap enquiriesRow">
                                                        <div class="enquiriesRow__cols">
                                                            <dt>
                                                                Name
                                                            </dt>
                                                            <dd>
                                                                valenie Lourenco
                                                            </dd>
                                                        </div>
                                                        <div class="enquiriesRow__cols">
                                                            <dt>
                                                                Email address
                                                            </dt>
                                                            <dd>
                                                                valenie@gmail.com
                                                                <span class="fnb-icons verified-icon mini">
                                                                </span>
                                                            </dd>
                                                        </div>

                                                        <div class="enquiriesRow__cols">
                                                            <dt>
                                                                Phone number
                                                            </dt>
                                                            <dd>
                                                                9800789877
                                                                <span class="fnb-icons verified-icon mini">
                                                                </span>
                                                            </dd>
                                                        </div>
                                                        <div class="enquiriesRow__cols">
                                                            <dt>
                                                                What describe you best?
                                                            </dt>
                                                            <dd>
                                                                <p class="describe-points"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Hospitality Business Owner</p>
                                                                <p class="describe-points"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Others</p>
                                                                
                                                            </dd>
                                                        </div>
                                                        <div class="enquiriesRow__cols last-col">
                                                             <dt>
                                                                Give the supplier/service provider some details of your requirement
                                                            </dt>
                                                            <dd>
                                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius quis commodi aliquid reprehenderit beatae ad magni in incidunt, recusandae obcaecati dolore illum assumenda consequuntur, nobis, rerum voluptatum tempora maiores blanditiis!
                                                            </dd>
                                                        </div>
                                                    </dl>
                                                </div>
                                            </div>                                                
                                        </div>

                                        <div class="enquire-container">
                                            <h6 class="enquiry-made-by text-medium">
                                                You made a
                                                <label class="fnb-label">
                                                    Shared Enquiry
                                                </label>
                                                to
                                                <a class=" text-decor" href="#">
                                                    XYZ Enterprises
                                                </a>
                                            </h6>
                                            <div class="row">
                                                <div class="col-sm-5 b-r">
                                                    <dl class="flex-row flex-wrap enquiriesRow withCat">
                                                        <div class="enquiriesRow__cols">
                                                            <dt>
                                                                Name
                                                            </dt>
                                                            <dd>
                                                                valenie Lourenco
                                                            </dd>
                                                        </div>
                                                        <div class="enquiriesRow__cols">
                                                            <dt>
                                                                Email address
                                                            </dt>
                                                            <dd>
                                                                valenie@gmail.com
                                                                <span class="fnb-icons verified-icon mini">
                                                                </span>
                                                            </dd>
                                                        </div>

                                                        <div class="enquiriesRow__cols">
                                                            <dt>
                                                                Phone number
                                                            </dt>
                                                            <dd>
                                                                9800789877
                                                                <span class="fnb-icons verified-icon mini">
                                                                </span>
                                                            </dd>
                                                        </div>
                                                        <div class="enquiriesRow__cols">
                                                            <dt>
                                                                What describe you best?
                                                            </dt>
                                                            <dd>
                                                                <p class="describe-points"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Hospitality Business Owner</p>
                                                                <p class="describe-points"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Others</p>
                                                                
                                                            </dd>
                                                        </div>
                                                        
                                                    </dl>
                                                </div>
                                                <div class="col-sm-7">
                                                    <dl class="enquiriesRow">
                                                        <div class="enquiriesRow__cols">
                                                            <dt>
                                                                Categories
                                                            </dt>
                                                            <dd>
                                                                <ul class="fnb-cat flex-row">
                                                                    <li>
                                                                        <a class="fnb-cat__title" href="">
                                                                            Chicken
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="fnb-cat__title" href="">
                                                                            Mutton
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="fnb-cat__title" href="">
                                                                            Beef
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="fnb-cat__title" href="">
                                                                            Fish
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="fnb-cat__title" href="">
                                                                            Egg
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </dd>   
                                                        </div>
                                                        
                                                        <div class="enquiriesRow__cols">
                                                            <dt>
                                                                Areas
                                                            </dt>
                                                            <dd>
                                                                <p class="default-size">
                                                                    Delhi -
                                                                    <span class="text-medium">
                                                                        Dwarka, Chandni chawk, Mundka
                                                                    </span>
                                                                </p>
                                                            </dd>
                                                        </div> 
                                                        
                                                    </dl>
                                                </div>
                                                <div class="col-sm-12 m-t-10">
                                                    <div class="enquiriesRow__cols last-col">
                                                         <dt>
                                                            Give the supplier/service provider some details of your requirement
                                                        </dt>
                                                        <dd>
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius quis commodi aliquid reprehenderit beatae ad magni in incidunt, recusandae obcaecati dolore illum assumenda consequuntur, nobis, rerum voluptatum tempora maiores blanditiis!
                                                        </dd>
                                                    </div>
                                                </div>                                                    
                                            </div>                                                
                                        </div>

                                        <div class="enquire-container">
                                            <h6 class="enquiry-made-by text-medium">
                                                You viewed the
                                                <label class="fnb-label">
                                                    Contact Details
                                                </label>
                                                of
                                                <a class=" text-decor" href="#">
                                                    Kasam Querishi &amp; sons
                                                </a>
                                            </h6>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <dl class="flex-row flex-wrap enquiriesRow">
                                                        <div class="enquiriesRow__cols">
                                                            <dt>
                                                                Name
                                                            </dt>
                                                            <dd>
                                                                valenie Lourenco
                                                            </dd>
                                                        </div>
                                                        <div class="enquiriesRow__cols">
                                                            <dt>
                                                                Email address
                                                            </dt>
                                                            <dd>
                                                                valenie@gmail.com
                                                                <span class="fnb-icons verified-icon mini">
                                                                </span>
                                                            </dd>
                                                        </div>

                                                        <div class="enquiriesRow__cols">
                                                            <dt>
                                                                Phone number
                                                            </dt>
                                                            <dd>
                                                                9800789877
                                                                <span class="fnb-icons verified-icon mini">
                                                                </span>
                                                            </dd>
                                                        </div>
                                                    </dl>
                                                </div>
                                            </div>                                                
                                        </div>

                                        <p class="default-size mainDate"><span><i class="fa fa-calendar p-r-5" aria-hidden="true"></i> 02 July 2017</span></p>

                                        <div class="enquire-container">
                                            <h6 class="enquiry-made-by text-medium flex-row space-between">
                                                <div>
                                                    You posted a
                                                    <label class="fnb-label">
                                                        Business Listing
                                                    </label>
                                                    <a class=" text-decor" href="#">
                                                        VML Suppliers
                                                    </a>
                                                </div>
                                                <a class="text-decor primary-link" href="#">
                                                    View Listing
                                                </a>
                                            </h6>                                               
                                        </div> 


                                         <div class="enquire-container">
                                            <h6 class="enquiry-made-by text-medium flex-row space-between">
                                                <div>
                                                    You posted a
                                                    <label class="fnb-label">
                                                        Job
                                                    </label>
                                                    <a class=" text-decor" href="#">
                                                        Assistant Manager for a Restaurant
                                                    </a>
                                                </div>
                                                <a class="text-decor primary-link" href="#">
                                                    View Job
                                                </a>
                                            </h6>                                               
                                        </div> 

                                    </div>
                                    
                                    <div class="tab-pane" id="all-activity" role="tabpanel">
                                        asdfsdfasdf                                   
                                    </div>
                                </div>
                                </div>
                                <div class="activity tab-pane fade" id="activity">
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
                                            <div class="basic-detail__col flex-row flex-wrap">
                                                <div class="form-group m-b-0">
                                                    <label class="m-b-0 text-lighter float-label required" for="contact_name">Name</label>
                                                    <input type="text" class="form-control fnb-input float-input" id="contact_name">
                                                </div>
                                                <div class="form-group m-b-0 flex-row space-between">
                                                    <div class="flex-full">
                                                        <label class="m-b-0 text-lighter float-label required" for="contact_email">Email</label>
                                                        <input type="email" class="form-control fnb-input float-input" id="contact_email" value="valenie@gmail.com">
                                                    </div>
                                                    <div class="verified flex-row">
                                                        <span class="fnb-icons verified-icon">
                                                        </span>
                                                        <div class="text-color">
                                                            Verified
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group p-t-10 m-b-0 flex-row space-between">
                                                    <div class="flex-full">
                                                        <label class="m-b-0 text-lighter float-label required" for="contact_phone">Phone no</label>
                                                        <input type="tel" class="form-control fnb-input float-input" id="contact_phone">
                                                    </div>
                                                    <a href="#" class="secondary-link verifyLink x-small">Verify</a>
                                                </div>
                                                <div class="form-group p-t-10 m-b-0">
                                                    <label class="m-b-0 text-lighter float-label required full-label" for="member">Member Since</label>
                                                    <input type="text" class="form-control fnb-input float-input" id="member" value="June 2017">
                                                </div>
                                                <div class="form-group p-t-20 m-b-0 save-btn">
                                                   <button class="btn fnb-btn primary-btn full border-btn">Save</button>
                                                </div> 
                                            </div>
                                        </div>

                                        <div class="contactCard">
                                            <h3 class="sub-title basic-detail__title">Change Password</h3>
                                            <div class="basic-detail__col flex-row flex-wrap">
                                                <div class="form-group m-b-0">
                                                    <label class="m-b-0 text-lighter float-label required full-label" for="password">Old Password</label>
                                                    <input type="text" class="form-control fnb-input float-input" id="old">
                                                </div>
                                                <div class="form-group m-b-0">
                                                    <label class="m-b-0 text-lighter float-label required full-label" for="new">New Password</label>
                                                    <input type="password" class="form-control fnb-input float-input" id="new" value="">
                                                </div>
                                                <div class="form-group p-t-10 m-b-0">
                                                    <label class="m-b-0 text-lighter float-label required full-label" for="confirm">Confirm Password</label>
                                                    <input type="password" class="form-control fnb-input float-input" id="confirm">
                                                </div>
                                                <div class="form-group p-t-20 m-b-0 save-btn">
                                                   <button class="btn fnb-btn primary-btn full border-btn">Save</button>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>
                                </div>


                                <div class="describe-best tab-pane fade" id="describe-best">
                                    <!-- <h6 class="enquiries-made title">
                                        <i aria-hidden="true" class="fa fa-thumbs-up">
                                        </i>
                                        What describe Abhay the best?
                                    </h6> -->
                                    <h3 class="profile-stats__title text-medium sectionTitle mobile-hide">
                                        What describes you the best?
                                    </h3>
                                    <!-- <div class="panel-group" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-parent="#accordion" data-toggle="collapse" href="#collapseOne">
                                                        <i aria-hidden="true" class="fa fa-briefcase">
                                                        </i>
                                                        Working Professional
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse collapse in" id="collapseOne">
                                                adasdas
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-parent="#accordion" data-toggle="collapse" href="#collapseFour">
                                                        <i aria-hidden="true" class="fa fa-graduation-cap">
                                                        </i>
                                                        Student
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse collapse" id="collapseFour">
                                                qwqw
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-parent="#accordion" data-toggle="collapse" href="#collapseFive">
                                                        <i aria-hidden="true" class="fa fa-users">
                                                        </i>
                                                        Prospective Entreprenuer
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse collapse" id="collapseFive">
                                                adsd
                                            </div>
                                        </div>
                                    </div> -->
                                    
                                    <div class="save-best-data text-right">
                                        <button class="btn fnb-btn outline full border-btn">Save</button>
                                    </div>

                                    <div class="describe-best" id="accordion" role="tablist" aria-multiselectable="true">
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox"></div>
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <div>
                                                    Hospitality Business Owner <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Some data"></i>
                                                </div>
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                          </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                          <div class="panel-body">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut deleniti, odit iusto sunt impedit quam et, reprehenderit illum laborum fuga atque rem a, adipisci rerum libero alias maxime delectus praesentium laboriosam? Explicabo dolor, consequatur iste. Mollitia recusandae vero sapiente repellendus fugit quasi aliquid, rem nisi modi facilis accusantium, commodi animi.
                                          </div>
                                        </div>
                                      </div>
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingTwo">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox"></div>
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <div>
                                                    Working Professional <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Some data"></i>
                                                </div>
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                          </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                          <div class="panel-body">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta veritatis porro odit, ipsum qui illum asperiores accusamus dolorum suscipit placeat deserunt laborum ipsam sequi. Molestiae veritatis ex reiciendis beatae minus.
                                          </div>
                                        </div>
                                      </div>
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingThree">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox"></div>
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                <div>
                                                    Vendor/Suppliers/Service Provider <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Some data"></i>
                                                </div>
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                          </h4>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                          <div class="panel-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                          </div>
                                        </div>
                                      </div>
                                       <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingFour">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox"></div>
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                                                <div>
                                                    Student <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Some data"></i>
                                                </div>
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                          </h4>
                                        </div>
                                        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                          <div class="panel-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                          </div>
                                        </div>
                                      </div>
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingFive">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox"></div>
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseThree">
                                                <div>
                                                    Prospective Entrepreneur <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Some data"></i>
                                                </div>
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                          </h4>
                                        </div>
                                        <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                                          <div class="panel-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                          </div>
                                        </div>
                                      </div>
                                      <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingSix">
                                          <h4 class="panel-title flex-row">
                                            <div><input type="checkbox" class="checkbox"></div>
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseThree">
                                                <div>
                                                    Others <i class="fa fa-info-circle p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Some data"></i>
                                                </div>
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                          </h4>
                                        </div>
                                        <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                                          <div class="panel-body option-col flex-row flex-wrap">
                                            <div class="form-group m-b-0">
                                                <label class="m-b-0 text-lighter float-label required" for="test">Label</label>
                                                <input type="text" class="form-control fnb-input float-input" id="test">
                                            </div>
                                            <div class="form-group m-b-0">
                                                <label class="m-b-0 text-lighter float-label required" for="new">Label</label>
                                                <input type="email" class="form-control fnb-input float-input" id="new" value="">
                                            </div>
                                            <div class="form-group m-b-0">
                                                <label class="m-b-0 text-lighter float-label required" for="confirm">Label</label>
                                                <input type="tel" class="form-control fnb-input float-input" id="confirm">
                                            </div>
                                            <div class="form-group m-b-0">
                                                <label class="m-b-0 text-lighter float-label required" for="confirm">Label</label>
                                                <input type="tel" class="form-control fnb-input float-input" id="confirm">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="save-best-data text-right mobile-hide">
                                        <button class="btn fnb-btn outline full border-btn">Save</button>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection