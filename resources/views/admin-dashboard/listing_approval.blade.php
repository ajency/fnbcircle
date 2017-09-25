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
   <script type="text/javascript" src="/js/plugins/handlebars.js"></script>
    <!-- <script type="text/javascript" src="/js/require.js"></script> -->

    <!-- bootstrap-daterangepicker -->
    <script src="/bower_components/moment/min/moment.min.js"></script>
    <script src="/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Autosize textarea -->
    <script src="/bower_components/autosize/dist/autosize.min.js"></script>

    <script type="text/javascript" src="/js/dashboard-listing-approval.js"></script>
@endsection
@section('meta')
  <meta property="status-url" content="{{action('AdminModerationController@setStatus')}}">
@endsection

@section('page-data')
<div class="right_col" role="main">
      <div class="">

        <div class="page-title">
          <div class="title_left">
            <h5>Listing Approval <button class="btn btn-link btn-sm">+ Add Listing</button><button type="button" class="btn btn-link btn-sm" id="resetAll">Reset all Filters</button></h5>
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
                      <!-- <button class="btn btn-sm fnb-btn">Apply</button> -->
                    </div>
                  </div>

                  <div class="col-sm-1"></div>

                  <div class="col-sm-8">
                    <div class="cat-filter__wrapper">
                      <label>Category Filter</label>
                      <a href="#category-select" data-toggle="modal" data-target="#category-select" class="btn btn-link btn-sm">Filter based on node categories</a>
                      <div id="categories" class="node-list"></div>
                      
                    </div>
                  </div>
                </div>

                <div class="filter-actions m-t-10">
                  <div class="pull-right">
                    <button class="btn primary-btn border-btn fnb-btn" id="applyCategFilter">Apply Category</button>
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="m-t-10">
                  <label class="flex-row flex-end">
                      <input type="checkbox" class="checkbox" for="draft_status" id="draftstatus">
                      <div class="text-medium m-b-0" id="draft_status">Display Listings having Draft status</div>
                  </label>
                </div>

                <div class="bulk-status-update m-t-10 hidden">
                  <hr>
                  <form id="bulkupdateform">
                  <label>Bulk Status Update</label>
                  <div class="row">
                    <div class="col-sm-3">
                      <select class="form-control fnb-select w-border status-select" required>
                        <option value="">Select</option>
                        <option value="1">Published</option>
                        <option value="3">Draft</option>
                        <option value="4">Archived</option>
                        <option value="2">Pending Review</option>
                        <option value="5">Rejected</option>
                      </select>
                      <label class="flex-row notify-user-msg hidden m-t-15">
                          <input type="checkbox" class="checkbox" for="bulk_notify_user">
                          <div class="text-medium m-b-0" id="bulk_notify_user">Notify Listing Owner</div>
                      </label>
                    </div>
                    <div class="col-sm-2">
                      <button class="btn primary-btn border-btn fnb-btn" id="bulkupdate" type="button">Update</button>
                    </div>
                  </div>
                  </form>
                </div>

                <input type="text" name="" placeholder="Search by Name" id="listingNameSearch" class="form-control fnb-input pull-right customDtSrch">

                <hr>

                <table id="datatable-listing_approval" class="table table-striped" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th class="select-checkbox sorting_disabled" aria-label="" style="width: 10px;"></th>
                      <th style="min-width: 12%;">Listing Name</th>
                      <th class="no-sort" data-col="2">
                        City
                        <select multiple class="form-control multi-dd" id="citySelect">
                        @foreach ($cities as $city)
                          <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                        </select>
                      </th>
                      <th class="no-sort">
                        Node Categories
                      </th>
                      <th class="" style="min-width: 10%;">
                        Date of Submission
                      </th>
                      <th class="" style="min-width: 10%;">
                          Last Updated on
                      </th>
                      <th class="no-sort" data-col="6" style="min-width: 10%;">
                        Last Updated by
                        <select multiple class="form-control multi-dd" id="updateUser">
                          <option value="external" >External User</option>
                          <option value="internal" >Internal User</option>
                        </select>
                      </th>
                      <th class="no-sort">Duplicates<br><small>(Number,Email,Name)</small></th>
                      <th class="no-sort" data-col="8" style="min-width: 10%;">
                        Premium Request
                        <select multiple class="form-control multi-dd">
                          <option value="Yes">Yes</option>
                          <option value="No">No</option>
                        </select>
                      </th>
                      <th class="no-sort" data-col="9" style="min-width: 10%;">
                        Status
                        <select multiple class="form-control multi-dd" id="status-filter">
                          <option value="1" >Published</option>
                           <option value="2" >Pending Review</option>
                        <option value="4" >Archived</option>
                       
                        <option value="5" >Rejected</option>
                        </select>
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

        <!-- Category Filter -->
        <div class="modal fnb-modal category-modal multilevel-modal fade list-app-modal" id="category-select" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="level-one mobile-hide firstStep">
                            <button class="close" data-dismiss="modal" aria-label="Close">&#10005;</button>
                        </div>
                        <div class="mobile-back flex-row">
                            <div class="back">
                                <button class="desk-hide btn fnb-btn outline border-btn no-border mobileCat-back" type="button" data-dismiss="modal"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i> Back</button>
                                <button class="btn fnb-btn outline border-btn no-border category-back mobile-hide" type="button"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i> Back to Category</button>
                            </div>
                            <div class="level-two">
                                <a href="#" data-dismiss="modal" class="mobile-hide btn fnb-btn text-color m-l-5 cat-cancel text-color">✕</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="main-category level-one m-l-30 m-r-30 m-b-30">
                            <!-- <div class="mobile-hide">
                                <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                                <div class="clearfix"></div>
                            </div> -->
                            <!-- <div class="desk-hide mobile-back">
                                <button class="btn fnb-btn outline border-btn no-border" data-dismiss="modal"><i class="fa fa-arrow-left p-r-5" aria-hidden="true"></i> Back</button>
                            </div> -->
                            <div class="add-container text-center">
                                <h5 class="text-medium">Select a Category</h5>
                                <div class="text-lighter">
                                    One category at a time
                                </div>
                            </div>
                            <ul class="interested-options catOptions cat-select flex-row m-t-45">
                                @foreach($parents as $parent)
                                <li>
                                    <input type="radio" class="radio level-two-toggle" name="categories" data-name="{{$parent->name}}" value="{{$parent->id}}">
                                    <div class="option flex-row">
                                        <img class="fnb-icons cat-icon " src="{{$parent->icon_url}}"></span>
                                    </div>
                                    <div class="interested-label">
                                        {{$parent->name}}
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="sub-category level-two">
                            <!-- <div class="mobile-back flex-row m-b-10">
                                <div class="back">
                                     <button class="btn fnb-btn outline border-btn no-border sub-category-back"><i class="fa fa-arrow-left p-r-5" aria-hidden="true"></i> Back</button>
                                </div>
                                <button class="btn fnb-btn outline border-btn">save</button>
                            </div> -->

                            <div class="instructions flex-row space-between">
                                <div class="cat-name flex-row"><img class="import-icon cat-icon m-r-15" src="http://icons.iconarchive.com/icons/xaml-icon-studio/agriculture/256/Fruits-Vegetables-icon.png">
                                    <div>
                                        <p class="instructions__title bat-color default-size">Please choose the sub categories under "<span class="main-cat-name"></span>"</p>
                                        <h5 class="sub-title cat-title bat-color main-cat-name"></h5>
                                    </div>
                                </div>
                                <div>
                                    <button id="category-select" class="btn fnb-btn outline border-btn re-save" type="button" data-dismiss="modal">save</button>
                                </div>
                            </div>

                            <div class="node-select flex-row">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs flex-row mobile-hide categ-list" role="tablist">
                                    
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content cat-dataHolder mobile-categories relative">
                                    <!-- mobile collapse -->
                                    
                                </div>
                            </div>

                            <div class="footer-actions mobile-hide text-right">
                                <button class="btn fnb-btn outline border-btn grey" type="button" data-dismiss="modal">Cancel</button>
                                <button id="category-select" class="btn fnb-btn outline border-btn" type="button" data-dismiss="modal">Save</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mobile-hide">
                        <div class="sub-category hidden">
                            <button class="btn fnb-btn outline full border-btn">save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="updateStatusModal">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h6 class="modal-title">Update Status</h6>
              </div>
              <form id="singlestatus">
              <div class="modal-body">
                <label>Status of <span id="listing-title"></span></label>
                <select class="form-control fnb-select w-border status-select" required>
                  <option value="">Select</option>
                  <option value="1">Published</option>
                  <option value="2">Pending Review</option>
                  <option value="3">Draft</option>
                  <option value="4">Archived</option>
                  <option value="5">Rejected</option>
                </select>
                <label class="flex-row notify-user-msg hidden m-t-15">
                    <input type="checkbox" class="checkbox" for="notify_user">
                    <div class="text-medium m-b-0" id="notify_user">Notify Listing Owner</div>
                </label>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn fnb-btn primary-btn mini" id="change_status">Save changes</button>
              </div>
              </form>
            </div>
          </div>
        </div>


        <div class="modal fnb-modal bulk-failure modal-center" id="bulk-failure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" aria-label="Close">&#10005;</button>
                        <h4 class="element-title modal-title">Status Update Failed!</h4>
                    </div>
                    <div class="modal-body">
                        <div class="listings">
                            <p class="default-size text-center listings__title">The following listings did not get updated.</p>
                            <ul class="listings__links flex-row flex-wrap">
                                <li>
                                    <a href="#" class="primary-link">Lorem ipsum</a>
                                </li>
                                <li>
                                    <a href="#" class="primary-link">Lorem ipsum</a>
                                </li>
                                <li>
                                    <a href="#" class="primary-link">Lorem ipsum</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>




      </div>
    </div>

@endsection