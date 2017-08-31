@extends('layouts.fnbtemplate')
@section('title', 'Admin-Dashboard')
@section('css')
    <!-- Datatables -->
    <link href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-multiselect.min.css" rel="stylesheet">
    <!-- Main styles -->
    <link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('js')
<!-- Magnify popup plugin -->
    <script type="text/javascript" src="/js/magnify.min.js"></script>
    <!-- Read more -->
    <script type="text/javascript" src="/js/readmore.min.js"></script>

    <script src="/js/bootstrap-multiselect.js"></script>

    <!-- Datatables -->
    <script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <!-- Autosize textarea -->
    <script src="/bower_components/autosize/dist/autosize.min.js"></script>

    <!-- custom script -->
    <script type="text/javascript" src="/js/custom.js"></script>

    <script type="text/javascript" src="/js/dashboard.js"></script>
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
                      <ul class="nav child_menu" >
                        <li class="sub_menu"><a href="listing_approval.html">Listing Approval</a>
                        </li>
                        <li class=""><a href="#">Manage Listings</a>
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
                <!-- <ul class="nav child_menu">
                  <li><a href="form.html">General Form</a></li>
                  <li><a href="form_advanced.html">Advanced Components</a></li>
                </ul> -->
              </li>
              <li><a><i class="fa fa-user"></i> Users </a>
              </li>
              <li><a><i class="fa fa-envelope"></i> Emails <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <li class=""><a href="email_notifications.html">Notifications</a></li>
                </ul>
              </li>
            </ul>
          </div>

        </div>
        <!-- /sidebar menu -->
      </div>
    </div>

    @yield('page-data')

    <div class="site-overlay"></div>
@endsection