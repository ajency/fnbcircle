@extends('layouts.admin-dashboard')
@section('css')
  <!-- bootstrap-daterangepicker -->
    <link href="/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="/bower_components/datatables.net-select-dt/css/select.dataTables.css" rel="stylesheet">
  @parent
@endsection

@section('js')
  @parent
  <script type="text/javascript" src="/bower_components/datatables.net-select/js/dataTables.select.min.js"></script>
  <script type="text/javascript" src="/js/underscore-min.js" ></script>
   <script type="text/javascript" src="/js/handlebars.js"></script>
    <!-- <script type="text/javascript" src="/js/require.js"></script> -->

    <!-- bootstrap-daterangepicker -->
    <script src="/bower_components/moment/min/moment.min.js"></script>
    <script src="/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Autosize textarea -->
    <script src="/bower_components/autosize/dist/autosize.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/category_select_modal.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/categories_select_leads.js') }}"></script>
    <script type="text/javascript" src="/js/dashboard-manage-enquiries.js"></script>
@endsection
@section('meta')
  <meta property="status-url" content="{{action('AdminModerationController@setStatus')}}">
@endsection

@section('page-data')
<div class="right_col" role="main">
      <div class="">

        <div class="page-title">
          <div class="title_left">
            <h5>Manage Enquiries<button type="button" class="btn btn-link btn-sm" id="resetAll">Reset all Filters</button></h5>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">

          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content">

                <div class="row">
                  <div class="col-sm-3">
                    <label>Date of Enquiry</label>
                    <a href="#" class="btn btn-link btn-sm" id="clearSubDate">Clear</a>
                    <div class="form-group">
                      <input type="text" id="submissionDate" name="" class="form-control fnb-input">
                      <!-- <button class="btn btn-sm fnb-btn">Apply</button> -->
                    </div>
                  </div>

                  <div class="col-sm-1"></div>

                  <div class="col-sm-8">
                    <div class="cat-filter__wrapper">
                      <label>Category Filter</label>
                       <a href="#category-select" data-toggle="modal" data-target="#category-select" class="btn btn-link btn-sm" id="select-more-categories">Filter based on Categories</a>
                      <input type="hidden" id="modal_categories_chosen" name="modal_categories_chosen" value="[]">
                      <div id="categories" class="node-list"></div>
                      
                    </div>
                    <div class="cat-filter__wrapper">
                      <label>Location Filter</label>
                      <a href="#area-select" data-target="#area-select" data-toggle="modal" class="btn btn-link btn-sm heavier addArea" id="area-modal-link">Filter based on Locations</a>
                      @include('modals.location_select.display')
                    </div>
                  </div>
                </div>

                <div class="filter-actions m-t-10">
                  <div class="pull-right">
                    <button class="btn primary-btn border-btn fnb-btn" id="applyCategFilter">Apply Category</button>
                    <button class="btn primary-btn border-btn fnb-btn" id="applyLocFilter">Apply Location</button>
                  </div>
                  <div class="clearfix"></div>
                </div>


                <hr>

                <table id="datatable-manage_enquiries" class="table table-striped" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="min-width: 120px;" class="no-sort">Enquiry Type
                        <select multiple class="form-control multi-dd" id="updateType">
                          <option value="direct" >Direct Enquiry</option>
                          <option value="shared" >Shared Enquiry</option>
                        </select>
                      </th>
                      <th style="min-width: 100px;" class="no-sort">User Type
                        <select multiple class="form-control multi-dd" id="updateUser">
                          <option value="user" >User</option>
                          <option value="lead" >Lead</option>
                        </select>
                      </th>
                      <th style="min-width: 120px;">
                        Request Date
                      </th>
                      <th class="no-sort no-sort-icon" style="max-width: 150px;">
                        Name
                        <input type="text" class="form-control fnb-input x-small text-medium" id="namefilter" placeholder="Search" style="max-width: 150px;">
                      </th>
                      <th class="no-sort no-sort-icon" style="max-width: 150px;">
                        Email
                        <input type="text" class="form-control fnb-input x-small text-medium" id="emailfilter" placeholder="Search" style="max-width: 150px;">
                      </th>
                      <th class="no-sort no-sort-icon" style="max-width: 150px;">
                        Phone
                        <input type="text" class="form-control fnb-input x-small text-medium" id="phonefilter" placeholder="Search" style="max-width: 150px;">
                      </th>
                      <th class="no-sort" style="max-width: 100px;">
                        What describes you Best
                        <select multiple class="form-control multi-dd" id="updateUser">
                          <option value="hospitality" >Hospitality</option>
                          <option value="professional" >Professional</option>
                          <option value="vendor" >Vendor</option>
                          <option value="student" >Student</option>
                          <option value="enterpreneur" >Enterpreneur</option>
                          <option value="others" >Others</option>
                        </select>
                      </th>
                      <th class="no-sort" style="min-width: 80px;">
                        Message
                      </th>
                      <th class="no-sort" style="min-width: 80px;">Categories</th>
                      <th class="no-sort" style="min-width: 60px;">Areas</th>
                      <th class="no-sort no-sort-icon" style="max-width: 130px;">
                        Enquiry Made to
                        <input type="text" class="form-control fnb-input x-small text-medium" id="madetofilter" placeholder="Search" style="max-width: 130px;">
                      </th>
                      <th class="no-sort no-sort-icon" style="max-width: 130px;">
                        Enquiry Sent to
                        <input type="text" class="form-control fnb-input x-small text-medium" id="senttofilter" placeholder="Search" style="max-width: 130px;">
                      </th>
                    </tr>
                  </thead>

                  <tbody>

                  </tbody>
                </table>

              </div>

            </div>
          </div>

        </div>


        @include('modals.location_select.popup')

        @include('modals.categories_list')




      </div>
    </div>

@endsection