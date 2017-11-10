@extends('layouts.app')
@section('title')
@if($self) My @else User @endif Profile
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
                                       @if($self) My @else {{$data['name']}}'s @endif profile
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
                <div class="col-sm-4 profile-stats customer-profile">
                <div class="infoCard">
                                <div class="person-info">
                                    <div class="Profile">
                                        <div class="Profile__header flex-row">
                                            <i aria-hidden="true" class="fa fa-user-circle">
                                            </i>
                                            <div class="name">
                                                <h3 class="element-title text-medium name-text">
                                                    {{$data['name']}}
                                                </h3>
                                                <div class="text-color">
                                                    Joined: {{$data['joined']}}
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                            <div class="Profile__body">
                                                @isset($data['email'])
                                                <div class="email-row contact flex-row space-between">
                                                    <div>
                                                        <h6 class="heavier sub-title">
                                                            Email
                                                        </h6>
                                                        <a class="sub-title dark-link lighter word-break" href="mailto:{{$data['email']['email']}}">
                                                            {{$data['email']['email']}}
                                                        </a>
                                                    </div>
                                                    <div class="verified flex-row self-end">
                                                        @if($data['email']['is_verified'] == 1) <span class="fnb-icons verified-icon">
                                                        </span> @else <i class="fa fa-times not-verified" aria-hidden="true"></i> @endif
                                                        <div class="text-color">
                                                           @if($data['email']['is_verified'] == 0) Not @endif Verified
                                                        </div>
                                                    </div>
                                                </div>
                                                @endisset
                                                @isset($data['phone'])
                                                <div class="phone-row contact flex-row space-between">
                                                    <div>
                                                        <h6 class="heavier sub-title">
                                                            Phone Number
                                                        </h6>
                                                        <a class="sub-title dark-link lighter" href="tel:+{{$data['phone']['contact_region']}}{{$data['phone']['contact']}}">
                                                            +{{$data['phone']['contact_region']}} {{$data['phone']['contact']}}
                                                        </a>
                                                    </div>
                                                    <div class="verified flex-row self-end">
                                                        @if($data['phone']['is_verified'] == 1) <span class="fnb-icons verified-icon">
                                                        </span> @else <i class="fa fa-times not-verified" aria-hidden="true"></i> @endif
                                                        <div class="text-color">
                                                           @if($data['phone']['is_verified'] == 0) Not @endif Verified
                                                        </div>
                                                    </div>
                                                </div>
                                                @endisset
                                            </div>
                                        </hr>
                                    </div>
                                </div>
                                <div class="nav nav-tabs">
                                    <ul class="gs-steps" role="tablist">
                                        <li>
                                            <!-- <a class="form-toggle" data-toggle="tab" href="#enquiry-info" role="tab"> -->
                                            <a href="#">
                                                My Activity
                                                <i aria-hidden="true" class="fa fa-arrow-right">
                                                </i>
                                            </a>
                                        </li>
                                        <li class="active">
                                            <a class="form-toggle" data-toggle="tab" href="#activity" role="tab">
                                                Basic Details
                                                <i aria-hidden="true" class="fa fa-arrow-right">
                                                </i>
                                            </a>
                                        </li>
                                        <li>
                                            <!-- <a class="form-toggle" data-toggle="tab" href="#describe-best" role="tab"> -->
                                            <a href="#">
                                                What describe you the best?
                                                <i aria-hidden="true" class="fa fa-arrow-right">
                                                </i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                </div>
                <div class="col-sm-8">
                    <div class="pos-fixed fly-out profile-info active">
                        <div class="mobile-back desk-hide mobile-flex">
                            <div class="left mobile-flex">
                                <i aria-hidden="true" class="fa fa-arrow-left text-primary back-icon">
                                </i>
                                <p class="element-title heavier m-b-0">
                                    Back
                                </p>
                            </div>
                        </div>
                        <div class="fly-out__content edit-mode profile-info-card">
                            <div class=" tab-content">
                            @yield('main-content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection