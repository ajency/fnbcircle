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
                      <a href="#category-select"  class="btn btn-link btn-sm">Filter based on node categories</a>
                      <div id="categories" class="node-list"></div>
                      
                    </div>
                    <div class="cat-filter__wrapper">
                      <label>Location Filter</label>
                      <a href="#area-select" data-target="#area-select" data-toggle="modal" class="secondary-link text-decor heavier addArea" id="area-modal-link">Filter based on Locations</a>
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
                      <th style="min-width: 8%;" class="no-sort">Enquiry Type
                        <select multiple class="form-control multi-dd" id="updateType">
                          <option value="direct" >Direct Enquiry</option>
                          <option value="shared" >Shared Enquiry</option>
                        </select>
                      </th>
                      <th style="min-width: 5%;" class="no-sort">Enquirer Type
                        <select multiple class="form-control multi-dd" id="updateUser">
                          <option value="user" >User</option>
                          <option value="lead" >Lead</option>
                        </select>
                      </th>
                      <th style="min-width: 8%;">
                        Request Date
                      </th>
                      <th class="no-sort">
                        Name
                        <input id="namefilter">
                      </th>
                      <th class="no-sort" style="min-width: 10%;">
                        Email
                        <input id="emailfilter">
                      </th>
                      <th class="no-sort" style="min-width: 10%;">
                        Phone
                        <input id="phonefilter">
                      </th>
                      <th class="no-sort" style="min-width: 10%;">
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
                      <th class="no-sort" style="min-width: 10%;">
                        Message
                      </th>
                      <th class="no-sort">Categories</th>
                      <th class="no-sort" style="min-width: 10%;">Areas</th>
                      <th class="no-sort" style="min-width: 10%;">
                        Enquiry Made to
                        <input id="madetofilter">
                      </th>
                      <th class="no-sort" style="min-width: 10%;">
                        Enquiry Sent to
                        <input id="senttofilter">
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


        




      </div>
    </div>

@endsection