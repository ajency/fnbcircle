@extends('layouts.app')
@section('title', 'Admin-Dashboard')
@section('css')
    <!-- Datatables -->
    <link href="{{ asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap-multiselect.min.css') }}" rel="stylesheet">
    <!-- Main styles -->
    <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
@endsection

@section('js')
<!-- Magnify popup plugin -->
    <!-- <script type="text/javascript" src="/js/magnify.min.js"></script> -->
    <!-- Read more -->
    <!-- <script type="text/javascript" src="/js/readmore.min.js"></script> -->

    <script src="{{ asset('/js/bootstrap-multiselect.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

    <!-- Autosize textarea -->
    <script src="{{ asset('/bower_components/autosize/dist/autosize.min.js') }}"></script>

    <!-- custom script -->
    <!-- <script type="text/javascript" src="/js/custom.js"></script> -->

    <script type="text/javascript" src="{{ asset('/js/dashboard.js') }}"></script>
@endsection

@section('content')
<!-- content -->
<div class="col-md-3 left_col">
      <div class="left_col scroll-view">

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
          <div class="menu_section">
            <ul class="nav side-menu">
              <li class="active"><a><i class="fa fa-building"></i> Business <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: block">
                    <li><a>Moderation <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu" style="display: block">
                        <li class="@if(Request::path() == 'admin-dashboard/moderation/listing-approval')current-page @endif"><a href="@if(Request::path() == 'admin-dashboard/moderation/listing-approval')#@else {{action('AdminModerationController@listingApproval')}} @endif"">Listing Approval</a>
                        </li>
                        <li class=""><a href="#">Manage Listings</a>
                        </li>
                        <li class="@if(Request::path() == 'admin-dashboard/moderation/manage-enquiries')current-page @endif"><a href="@if(Request::path() == 'admin-dashboard/moderation/manage-enquiries')#@else {{action('AdminEnquiryController@manageEnquiries')}} @endif"">Manage Enquiries</a>
                        </li>
                      </ul>
                    </li>
                    <li><a>Configuration <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu" style="display: block">
                        <li class="@if(Request::path() == 'admin-dashboard/config/categories')current-page @endif"><a href="@if(Request::path() == 'admin-dashboard/config/categories')#@else {{action('AdminConfigurationController@categoriesView')}} @endif"">Categories</a>
                        </li>
                        <li class="sub_menu @if(Request::path() == 'admin-dashboard/config/locations')current-page @endif"><a href="@if(Request::path() == 'admin-dashboard/config/locations')#@else {{action('AdminConfigurationController@locationView')}} @endif">Locations</a>
                        </li>
                      </ul>
                    </li>
                </ul>
              </li>
              <li><a><i class="fa fa-briefcase"></i> Jobs </a>
                <ul class="nav child_menu" style="display: block">
                  <li><a href="{{ url ('admin-dashboard/jobs/manage-jobs') }}">Manage Jobs</a></li>
                  <!-- <li><a href="form_advanced.html">Advanced Components</a></li> -->
                </ul>
              </li>
              <li><a><i class="fa fa-user"></i> Users </a>
                <ul class="nav child_menu" style="display: block">
                    <li class="sub_menu @if(Request::path() == 'admin-dashboard/users/internal-users')current-page @endif"><a href="@if(Request::path() == 'admin-dashboard/users/internal-users')#@else {{action('AdminConfigurationController@internalUserView')}} @endif">Internal Users</a>
                    </li>
                    <li class="@if(Request::path() == 'admin-dashboard/users/registered-users')current-page @endif"><a href="@if(Request::path() == 'admin-dashboard/users/registered-users')#@else {{action('AdminConfigurationController@registeredUserView')}} @endif">Registered users</a>
                    </li>
                  </ul>
              </li>
              <li><a><i class="fa fa-envelope"></i> Emails <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" style="display: block">
                
                  <li class="sub_menu @if(Request::path() == 'admin-dashboard/email-notification' )current-page @endif"><a href="@if(Request::path() == 'admin-dashboard/email-notification')#@else {{action('AdminModerationController@emailNotification')}} @endif">Notifications</a></li>
                  <li class="sub_menu @if(Request::path() == 'admin-dashboard/internal-email' )current-page @endif"><a href="@if(Request::path() == 'admin-dashboard/internal-email')#@else {{action('AdminModerationController@internalEmails')}} @endif">Internal Emails</a></li>
                
                </ul>
              </li>
            </ul>
          </div>

        </div>
        <!-- /sidebar menu -->
      </div>
    </div>

    @yield('page-data')
    <!-- Failure Message-->
      <div class="alert fnb-alert  alert-failure alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <div class="flex-row">
              <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
               <span id="message"></span>
          </div>
      </div>

    <!-- Success Message-->
      <div class="alert fnb-alert alert-success alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <span id="message"></span>
      </div>
    <div class="site-overlay"></div>
@endsection