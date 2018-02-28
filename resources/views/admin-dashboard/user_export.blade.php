@extends('layouts.admin-dashboard')

@section('css')
  <!-- bootstrap-daterangepicker -->
    <link href="/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- jstree -->
    <link href="/bower_components/jstree/dist/themes/default/style.min.css" rel="stylesheet">
    <!-- Main styles -->
    <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
@endsection

@section('js')
  @parent
  <!-- for location select -->
  <script type="text/javascript" src="/js/underscore-min.js" ></script>
  <script type="text/javascript" src="/js/handlebars.js"></script>
  <script type="text/javascript" src="/js/location_select.js"></script>
  <!-- for categories select -->
  <script src="/bower_components/jstree/dist/jstree.min.js"></script>
  
   <!-- bootstrap-daterangepicker -->
    <script src="/bower_components/moment/min/moment.min.js"></script>
    <script src="/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- page js -->
  <script type="text/javascript" src="/js/dashboard-user-export.js"></script>
  
@endsection

@section('meta')
  <meta property="export-type-change-url" content="{{action('AdminModerationController@getExportFilters')}}">
  <meta property="category-hierarchy" content="{{action('AdminModerationController@generateCategoryHirarchyFromID')}}">
  <meta property="export-state-display" content="{{action('AdminModerationController@displayExportStateFilter')}}">
  <meta property="export-status-display" content="{{action('AdminModerationController@displayExportStatusFilter')}}">
  <meta property="export-premium-display" content="{{action('AdminModerationController@displayExportPremiumFilter')}}">
  <meta property="export-usertype-display" content="{{action('AdminModerationController@displayExportUserTypeFilter')}}">
  <meta property="export-usersubtype-display" content="{{action('AdminModerationController@displayExportUserSubTypeFilter')}}">
  <meta property="export-jobtype-display" content="{{action('AdminModerationController@displayExportJobTypeFilter')}}">
  <meta property="export-jobrole-display" content="{{action('AdminModerationController@displayExportJobRoleFilter')}}">
  <meta property="export-signup-display" content="{{action('AdminModerationController@displayExportSignupFilter')}}">
  <meta property="export-active-display" content="{{action('AdminModerationController@displayExportActiveFilter')}}">
  <meta property="export-count" content="{{action('AdminModerationController@getExportCount')}}">
  <meta property="export-download" content="{{action('AdminModerationController@getExportData')}}">
 @endsection

 @section('page-data')
  <div class="right_col" role="main">
      <div class="">

      
        <div class="page-title">
          <div class="title_left">
            <h5>Export CSV <!-- <small>Some examples to get you started</small> --></h5>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">

          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content">
              <div class="row">
                <div class="col-sm-8">
                  <p class="default-size bolder">Please select the module that you wish to export users for:</p>
                  <select class="fnb-select select-variant" id="export-type" style="font-size: 1em;">
                   <option value="">Select module type</option>
                   @foreach($types as $type)
                      @php
                        $data = json_decode($type->meta_data,true);
                      @endphp
                      <option value="{{$type->label}}">{{$data['name']}}</option>
                   @endforeach 
                  </select>  
                </div>
              </div>
                <div id="filter-area" class="filter-area">
                </div>
              </div>
            </div>
          </div>

        </div>


      </div>
    </div>

    <div class="modal fnb-modal confirm-box fade modal-center" id="confirmBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="text-medium m-t-0 bolder">Confirm</h5>
                              </div>
                              <div class="modal-body text-center">
                                  <div class="listing-message">
                                      <h4 class="element-title text-medium text-left text-color" id="confirm-mail-message"></h4>
                                  </div>  
                                  <div class="confirm-actions text-right">
                                      <a href="#" class="" > <button class="btn fnb-btn text-primary border-btn no-border" id="export-confirm">Export</button></a>
                                        <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                                  </div>
                              </div>
                              <!-- <div class="modal-footer">
                                  <button class="btn fnb-btn outline cancel-modal border-btn" data-dismiss="modal">Close</button>
                              </div> -->
                          </div>
                      </div>
                  </div>

    <div class="modal fnb-modal confirm-box fade modal-center" id="messageBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-sm" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="text-medium m-t-0 bolder">Exporting users</h5>
                              </div>
                              <div class="modal-body text-center">
                                  <div class="listing-message">
                                      <h4 class="element-title text-medium text-left text-color" id="email-sent-message"></h4>
                                  </div>  
                                  <div class="confirm-actions text-right">
                                        <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">OK</button>
                                  </div>
                              </div>
                              <!-- <div class="modal-footer">
                                  <button class="btn fnb-btn outline cancel-modal border-btn" data-dismiss="modal">Close</button>
                              </div> -->
                          </div>
                      </div>
                  </div>
@endsection