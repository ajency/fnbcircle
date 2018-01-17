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

    <script type="text/javascript" src="/js/categories_select_leads.js"></script>
    <script type="text/javascript" src="/js/dashboard-manage-listings.js"></script>
@endsection


@section('page-data')
<div class="right_col" role="main">
      <div class="">

        <div class="page-title">
          <div class="title_left">
            <h5>Manage Listings
              <button type="button" class="btn btn-link btn-sm" id="resetAll">Reset all Filters</button>
            </h5>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">

          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content">

                <div class="row">
                  <div class="col-sm-3">
                    <label>Date of Submission</label>
                    <a href="#" class="btn btn-link btn-sm" id="clearSubDate">Clear</a>
                    <div class="form-group">
                      <input type="text" id="submissionDate" name="" class="form-control fnb-input">
                    </div>
                     <label>Date of Approval</label>
                    <a href="#" class="btn btn-link btn-sm" id="clearAppDate">Clear</a>
                    <div class="form-group">
                      <input type="text" id="approvalDate" name="" class="form-control fnb-input">
                    </div>
                     <label>Stats</label>
                    <a href="#" class="btn btn-link btn-sm" id="clearStatDate">Clear</a>
                    <div class="form-group">
                      <input type="text" id="statsDate" name="" class="form-control fnb-input">
                    </div>
                  </div>

                  <div class="col-sm-1"></div>

                  <div class="col-sm-8">
                    <div class="m-t-10 m-b-10"><label>Category Filter</label>
                     <a href="#category-select" data-toggle="modal" data-target="#category-select" class="btn btn-link btn-sm heavier" id="select-more-categories">Filter based on Categories</a></div>
                    <input type="hidden" id="modal_categories_chosen" name="modal_categories_chosen" value="[]">
                    <input type="hidden" id="is_parent_category_checkbox" value="1">
                    <input type="hidden" id="is_branch_category_checkbox" value="1">
                    <div id="categories" class="node-list"></div>
                  </div>
                </div>

                <div class="filter-actions m-t-10">
                  <div class="pull-right">
                    <button class="btn primary-btn border-btn fnb-btn" id="applyCategFilter">Apply Category</button>
                  </div>
                  <div class="clearfix"></div>
                </div>



                <input type="text" name="" placeholder="Search by Name" id="listingNameSearch" class="form-control fnb-input pull-right customDtSrch">

                <hr>

                <table id="datatable-manage_listings" class="table table-striped list-approval-tab" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th  class="no-sort">
                        City
                        <select multiple class="form-control multi-dd" id="citySelect">
                        @foreach ($cities as $city)
                          <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                        </select>
                      </th>
                      <th >Listing Name</th>
                      <th class="no-sort">
                        Categories
                      </th>
                      <th class="" >
                        Date of Submission
                      </th>
                      <th class="" >
                        Date of approval
                      </th>
                      <th class="no-sort" >
                        Paid
                        <select multiple class="form-control multi-dd" id="paidFilter">
                          <option value="1">Yes</option>
                          <option value="0">No</option>
                        </select>
                      </th>
                      <th class="no-sort"  >
                        Status
                        <select multiple class="form-control multi-dd" id="status-filter">
                          <option value="3" >Draft</option>
                          <option value="2" >Pending Review</option>
                          <option value="1" >Published</option>
                          <option value="4" >Archived</option>
                          <option value="5" >Rejected</option>
                        </select>
                      </th>
                      <th class="" >
                        Views
                      </th>
                      <th class="no-sort" >
                        Contact Requests
                      </th>
                      <th class="no-sort" >
                        Direct Enquiries
                      </th>
                      <th class="no-sort" >
                        Indirect Enquiries
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




      </div>
    </div>

@endsection
