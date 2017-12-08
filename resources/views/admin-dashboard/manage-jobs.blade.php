@extends('layouts.admin-dashboard')

@section('css')
  <!-- bootstrap-daterangepicker -->
    <link href="/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="/bower_components/datatables.net-select-dt/css/select.dataTables.css" rel="stylesheet">
  @parent
@endsection

@section('js')
  @parent
   <!-- bootstrap-daterangepicker -->
    <script src="/bower_components/moment/min/moment.min.js"></script>
    <script src="/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

  <script type="text/javascript" src="{{ asset('js/underscore-min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/dashboard-jobs.js') }}"></script>
 
  

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
              <div class="row">  
               <div class="col-sm-3">
                    <label>Date of Submission</label>
                    <a href="#" class="btn btn-link btn-sm clear-date"  >Clear</a>
                    <div class="form-group date-range-picker">
                      <input type="text" id="submission_date" name="" class="form-control fnb-input date-range">
                      <!-- <button class="btn btn-sm fnb-btn">Apply</button> -->
                      <input type="hidden" name="submission_from" class="date-from">
                      <input type="hidden" name="submission_to" class="date-to">
                    </div>
                  </div>  

                <div class="col-sm-3">
                    <label>Publish Date</label>
                    <a href="#" class="btn btn-link btn-sm clear-date"  >Clear</a>
                    <div class="form-group date-range-picker">
                      <input type="text" id="publish_date" name="" class="form-control fnb-input date-range">
                      <!-- <button class="btn btn-sm fnb-btn">Apply</button> -->
                      <input type="hidden" name="published_from" class="date-from">
                      <input type="hidden" name="published_to" class="date-to">
                    </div>
                  </div>  
              </div>

                <input type="text" name="job_name" placeholder="Search by Job Title" id="job_name" class="form-control fnb-input pull-right customDtSrch jobstrsearchinput manage-search-box">

                <input type="text" name="company_name" placeholder="Search by Company Name" id="company_name" class="form-control fnb-input pull-right customDtSrch jobstrsearchinput manage-search-box">
                

                <table id="datatable-jobs" class="table table-striped jobs-table" cellspacing="0" width="100%">

                  <thead>
                    <tr>
                      <!--<th class="no-sort update-checkbox " width="2%"> 
                       <input type='checkbox' class="hidden" name='job_check_all'></th> -->
                      <th class="no-sort update-checkbox " width="2%">Job Id</th>
                      <th class="no-sort city-select" data-col="5" width="10%">
                          State
                          <select multiple class="form-control multi-dd jobsearchinput" id="filtercities" name="job_city">
                            @foreach ($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                          @endforeach
                          </select>
                      </th>
                      <th>Job Title</th>
                      <th>
                         Business Type
                         <select multiple class="form-control multi-dd jobsearchinput" id="filtercategory" name="job_category">
                            @foreach ($categories as $categoryId => $category)
                            <option value="{{ $categoryId }}">{{$category}}</option>
                          @endforeach
                          </select>
                      </th>
                      <th width="10%">
                         Job Role(s)
                         <select multiple class="form-control jobsearchinput admin-job-role-search" id="filterkeywords" name="job_keywords">
                            @foreach ($keywords as $keywordId => $keyword)
                            <option value="{{$keywordId}}"  >{{$keyword}}</option>
                          @endforeach
                          </select>
                      </th>
                      <th class="no-sort" data-col="4" style="min-width: 10%;">
                        Company Name
                         
                      </th>                    
                      <th class="" style="min-width: 10%;">Date of submission</th>
                      <th>Published Date</th>
                      <th>Last Updated on</th>
                      <th>Last Updated By</th>
                      <th class="no-sort man-status-col" data-col="9">
                        Premium Request
                        <select multiple name="premium_request" class="form-control multi-dd jobsearchinput">
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </th>
                      <th class="no-sort man-status-col" data-col="9">
                        Status
                        <select name="job_status" multiple class="form-control multi-dd  jobsearchinput">
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

<div class="modal fnb-modal bulk-failure modal-center" id="status-failure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" aria-label="Close">&#10005;</button>
                        <h4 class="element-title modal-title">Status Update Failed!</h4>
                    </div>
                    <div class="modal-body">
                        <div class="listings">
                            <p class="default-size text-center listings__title">The following Job Listing(s) did not get updated.</p>
                            <ul class="listings__links flex-row flex-wrap">
                                <li>
                                    <a href="#" class="primary-link job-title" target="_blank">Lorem ipsum</a>
                                </li>
                                 
                            </ul>
                            Job listing doesn't meet reviewable criteria.
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>

@endsection