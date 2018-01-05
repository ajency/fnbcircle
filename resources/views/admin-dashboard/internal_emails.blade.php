 @extends('layouts.admin-dashboard')

@section('js')
  @parent
  <!-- for location select -->
  <script type="text/javascript" src="/js/underscore-min.js" ></script>
  <script type="text/javascript" src="/js/handlebars.js"></script>
  <script type="text/javascript" src="/js/location_select.js"></script>
  <!-- for categories select -->
  <script type="text/javascript" src="{{ asset('js/category_select_modal.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/categories_select_leads.js') }}"></script>
   <!-- bootstrap-daterangepicker -->
    <script src="/bower_components/moment/min/moment.min.js"></script>
    <script src="/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- page js -->
  <script type="text/javascript" src="/js/dashboard-internal-emails.js"></script>
  
@endsection

@section('meta')
  <meta property="mailtype-change-url" content="{{action('AdminModerationController@getInternalMailFilters')}}">
  <meta property="mail-count" content="{{action('AdminModerationController@getMailCount')}}">
  <meta property="mail-send" content="{{action('AdminModerationController@sendSelectedUsersMail')}}">
 @endsection

 @section('page-data')
  <div class="right_col" role="main">
      <div class="">

      
        <div class="page-title">
          <div class="title_left">
            <h5>Internal Emails <!-- <small>Some examples to get you started</small> --></h5>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">

          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content  table-responsive">

              	<select class="form-control" id="internal-email-type">
                 <option value="">Select type</option>
                 @foreach($types as $type)
                    @php
                      $data = json_decode($type->meta_data,true);
                    @endphp
                    <option value="{{$type->label}}">{{$data['name']}}</option>
                 @endforeach 
                </select>
                <div id="filter-area"></div>
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
                                      <h4 class="element-title text-medium text-left text-color">Are you sure you want to send email to <span id="user_number"></span> users?</h4>
                                  </div>  
                                  <div class="confirm-actions text-right">
                                      <a href="#" class="" > <button class="btn fnb-btn text-primary border-btn no-border" id="send-mail-confirm">Send Email</button></a>
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
                                  <h5 class="text-medium m-t-0 bolder">Sending Emails</h5>
                              </div>
                              <div class="modal-body text-center">
                                  <div class="listing-message">
                                      <h4 class="element-title text-medium text-left text-color">Emails will get sent to selected users in background</h4>
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