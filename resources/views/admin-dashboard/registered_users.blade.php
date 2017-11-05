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
  <script type="text/javascript" src="{{ asset('js/dashboard-registered-user.js') }}"></script>
 
  
@endsection

@section('page-data')
	<div class="right_col" role="main">
      <div class="">


        <div class="page-title">
          <div class="title_left">
            <h5>Registered Users  <button id="resetfilter" class="btn btn-link btn-sm reset-filters">Reset Filters</button></h5>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">

          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content">

 
              <div class="row">  
               <div class="col-sm-3">
                    <label>Date Created</label>
                    <a href="#" class="btn btn-link btn-sm clear-date"  >Clear</a>
                    <div class="form-group date-range-picker">
                      <input type="text" id="user_created_date" name="" class="form-control fnb-input date-range">
                      <!-- <button class="btn btn-sm fnb-btn">Apply</button> -->
                      <input type="hidden" name="user_created_from" class="date-from">
                      <input type="hidden" name="user_created_to" class="date-to">
                    </div>
                  </div>  

                <div class="col-sm-3">
                    <label>Last Logged In</label>
                    <a href="#" class="btn btn-link btn-sm clear-date"  >Clear</a>
                    <div class="form-group date-range-picker">
                      <input type="text" id="last_login_date" name="" class="form-control fnb-input date-range">
                      <!-- <button class="btn btn-sm fnb-btn">Apply</button> -->
                      <input type="hidden" name="last_login_from" class="date-from">
                      <input type="hidden" name="last_login_to" class="date-to">
                    </div>
                  </div>  
              </div>

                <input type="text" name="user_name" placeholder="Search by Name" id="user_name" class="form-control fnb-input pull-right customDtSrch userstrsearchinput manage-search-box">

                <input type="text" name="user_email" placeholder="Search by Email" id="user_email" class="form-control fnb-input pull-right customDtSrch userstrsearchinput manage-search-box">

                <input type="text" name="user_phone" placeholder="Search by Phone" id="user_phone" class="form-control fnb-input pull-right customDtSrch userstrsearchinput manage-search-box">
                

                <table id="datatable-registration" class="table table-striped  no-wrap registered-table" cellspacing="0" width="100%">
	                  <thead>
	                    <tr>
	                      <th class="text-center" rowspan="2" >Name</th>
	                      <th rowspan="2" class="no-sort text-center" data-col="2">Registration Type
	                        <select multiple class="form-control multi-dd usersearchinput" name="registration_type">
	                          <option value="email_signup">Email signup</option>
	                          <option value="google">Google</option>
	                          <option value="facebook">Facebook</option>
	                        </select>
	                      </th>
	                      <th class="text-center" rowspan="2">Email</th>
	                      <th class="text-center" rowspan="2">Phone</th>
	                      <th rowspan="2" class="no-sort text-center" data-col="3">What describe you the best?
	                        <select multiple class="form-control multi-dd">
	                          
	                        </select>
	                      </th>
	                      <th rowspan="2" class="no-sort text-center" data-col="4" style="min-width: 70px;">State
		                        <select multiple class="form-control multi-dd usersearchinput" id="filterStates" name="user_state">
	                            @foreach ($cities as $city)
	                            <option value="{{$city->id}}">{{$city->name}}</option>
	                          @endforeach
	                          </select>
	                      </th>
	                      <th class="no-sort text-center" rowspan="2" class="no-sort" data-col="5" style="min-width: 70px;">
	                          City
	                          <select multiple class="form-control multi-dd usersearchinput" id="filterCity" name="user_city">
	                             @foreach ($areas as $area)
	                            <option value="{{$area->id}}">{{$area->name}}</option>
	                          @endforeach
	                          </select>
	                      </th>
	                      
	                      <th class="text-center" rowspan="2" class="no-sort" style="min-width: 130px;">Date Created</th>
	                      <th class="text-center" rowspan="2" class="" style="min-width: 70px;">Last Login</th>
	                      <th class="text-center" colspan="2" style="min-width: 70px;">Business Listings</th>
	              
	                      <th class="text-center" colspan="2" style="min-width: 70px;">Jobs Added</th>
	                      <th class="text-center" rowspan="2" style="min-width: 100px;">Jobs Applied to</th>
	                      <th class="text-center" rowspan="2" style="min-width: 100px;">Resume Uploaded (Y/N)</th>
	                      <th class="no-sort text-center" rowspan="2" class="no-sort" data-col="6" style="min-width: 70px;">
	                        Status
	                        <select multiple class="form-control multi-dd usersearchinput" id="user_status" name="user_status">
	                          <option value="active">Active</option>
	                          <option value="inactive">Inactive</option>
	                          <option value="suspended">Suspended</option>
	                        </select>
	                      </th>
	                    </tr>
	                    <tr>
	                      <th class="text-center" style="min-width: 70px;">Total</th>
	                      <th class="text-center" style="min-width: 70px;">Published</th>
	                      <th class="text-center" style="min-width: 70px;">Total</th>
	                      <th class="text-center" style="min-width: 70px;">Published</th>
	                    </tr>
	                    
	                  </thead>

	                  <tbody>
	                     	 
	                  </tbody>
	                </table>

              </div>

            </div>
          </div>

        </div>

      

 

@endsection