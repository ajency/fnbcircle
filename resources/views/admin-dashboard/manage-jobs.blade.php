@extends('layouts.admin-dashboard')

@section('css')
  <!-- bootstrap-daterangepicker -->
    <link href="/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="/bower_components/datatables.net-select-dt/css/select.dataTables.css" rel="stylesheet">
  @parent
@endsection

@section('js')
  @parent
  <script type="text/javascript" src="{{ asset('js/underscore-min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/dashboard-jobs.js') }}"></script>
 
   <!-- bootstrap-daterangepicker -->
    <script src="/bower_components/moment/min/moment.min.js"></script>
    <script src="/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

  <script type="text/javascript">
    
      var avail_status = [<?php echo json_encode($jobAvailabeStatus);?>];
    
  </script>
@endsection

@section('page-data')
	<div class="right_col" role="main">
      <div class="">


        <div class="page-title">
          <div class="title_left">
            <h5>Manage Jobs  <button id="resetfilter" class="btn btn-link btn-sm reset-filters">Reset Filters</button></h5>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">

          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content">

                <!-- <div class="bulk-status-update m-t-10 hidden">
                  <hr>
                  <form id="bulkupdateform">
                  <label>Bulk Status Update</label>
                  <div class="row">
                    <div class="col-sm-3">
                      <select class="form-control fnb-select w-border bulk-update-job-status" required>
                      <option value="">Select</option>
                       @foreach($jobStatuses as $jobStatusId => $jobStatus)
                        <option value="{{ $jobStatusId }}">{{ $jobStatus }}</option>
                        @endforeach
                    </select>
                    <span class="fnb-errors bulk-update-error"></span>
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
                <br> -->
                 
 
                <input type="text" name="job_name" placeholder="Search by Job Title" id="job_name" class="form-control fnb-input pull-right customDtSrch jobstrsearchinput manage-search-box">

                <input type="text" name="company_name" placeholder="Search by Company Name" id="company_name" class="form-control fnb-input pull-right customDtSrch jobstrsearchinput manage-search-box">
                
                <table id="datatable-jobs" class="table table-striped  nowrap jobs-table" cellspacing="0" width="100%">
 
                  <thead>
                    <tr>
                      <th class="no-sort update-checkbox " width="2%"> 
                      <!-- <input type='checkbox' class="hidden" name='job_check_all'></th> -->
                      <th class="no-sort" data-col="5" width="10%">
                          City
                          <select multiple class="form-control multi-dd jobsearchinput" id="filtercities" name="job_city">
                            @foreach ($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                          @endforeach
                          </select>
                      </th>
                      <th width="15%">Job Title</th>
                      <th width="5%">
                         Business Type
                         <select multiple class="form-control multi-dd jobsearchinput" id="filtercategory" name="job_category">
                            @foreach ($categories as $categoryId => $category)
                            <option value="{{ $categoryId }}">{{$category}}</option>
                          @endforeach
                          </select>
                      </th>
                      <th width="20%">
                         Keywords
                         <select multiple class="form-control multi-dd jobsearchinput" id="filterkeywords" name="job_keywords">
                            @foreach ($keywords as $keywordId => $keyword)
                            <option value="{{$keywordId}}">{{$keyword}}</option>
                          @endforeach
                          </select>
                      </th>
                      <th class="no-sort text-center" data-col="4" width="10%">
                        Company Name
                         
                      </th>                    
                      <th class="text-center" width="10%">Date of submission</th>
                      <th width="10%">Published Date</th>
                      <th width="10%">Last Updated on</th>
                      <th width="10%">Last Updated By</th>
                      <th class="no-sort" data-col="9" width="10%">
                        Status
                        <select name="job_status" multiple class="form-control multi-dd job-status jobsearchinput">
                          @foreach($jobStatuses as $jobStatusId => $jobStatus)
                          <option value="{{ $jobStatusId }}">{{ $jobStatus }}</option>
                          @endforeach
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

      


 <div class="modal fade" tabindex="-1" role="dialog" id="updateStatusModal">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h6 class="modal-title">Update Status</h6>
              </div>
              <form id="singlestatus">
              <div class="modal-body">
                <label>Status of <span id="job-title"></span></label>
                <select class="form-control fnb-select w-border job-status update-job-status" required>
                  <option value="">Select</option>
                   @foreach($jobStatuses as $jobStatusId => $jobStatus)
                    <option value="{{ $jobStatusId }}">{{ $jobStatus }}</option>
                    @endforeach
                </select>
                <label class="flex-row notify-user-msg hidden m-t-15">
                    <input type="checkbox" class="checkbox" for="notify_user">
                    <div class="text-medium m-b-0" id="notify_user">Notify Listing Owner</div>
                </label>
                <span class="fnb-errors update-error"></span>
              </div>
              <input type="hidden" name="job_id" id="job_id" value="">
              <div class="modal-footer">
                <button type="button" class="btn fnb-btn primary-btn mini" id="change_status">Save changes</button>
              </div>
              </form>
            </div>
          </div>
        </div> 

@endsection