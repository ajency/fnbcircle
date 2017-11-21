@extends('layouts.admin-dashboard')

@section('title')
Internal Users
@endsection

@section('css')
    <!-- Datatables -->
    <link href="{{ asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap-multiselect.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/bower_components/datatables.net-select-dt/css/select.dataTables.css') }}" rel="stylesheet">
    <!-- Main styles -->
    <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
@endsection

@section('js')
  @parent
  <script type="text/javascript" src="{{ asset('/js/parsley.min.js') }}" ></script>
  <script type="text/javascript" src="{{ asset('/bower_components/bootstrap-confirmation2/bootstrap-confirmation.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/bower_components/datatables.net-select/js/dataTables.select.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/admin_dashboard_internal.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/bootstrap-multiselect.js') }}"></script>

    <!-- Datatables -->
    <!-- <script src="../public/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../public/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> -->

    <!-- Autosize textarea -->
    <!-- <script src="../public/bower_components/autosize/dist/autosize.min.js"></script> -->

    <!-- custom script -->
    <!-- <script type="text/javascript" src="../public/js/dashboard.js"></script> -->
@endsection

@section('page-data')
	<div class="admin_internal_users right_col" role="main">
    	<div class="">

	    <!-- <ul class="fnb-breadcrums flex-row m-t-10 m-b-20">
	            <li class="fnb-breadcrums__section">
	                <a href="">
	                    <i class="fa fa-home home-icon" aria-hidden="true"></i>
	                </a>
	            </li>
	            <li class="fnb-breadcrums__section">
	                <a href="">
	                    <p class="fnb-breadcrums__title main-name">Admin Control Panel</p>
	                </a>
	            </li>
	            <li class="fnb-breadcrums__section">
	                <a href="">
	                    <p class="fnb-breadcrums__title">/</p>
	                </a>
	            </li>
	            <li class="fnb-breadcrums__section">
	                <a href="">
	                    <p class="fnb-breadcrums__title main-name">Business</p>
	                </a>
	            </li>
	            <li class="fnb-breadcrums__section">
	                <a href="">
	                    <p class="fnb-breadcrums__title">/</p>
	                </a>
	            </li>
	            <li class="fnb-breadcrums__section">
	                <a href="">
	                    <p class="fnb-breadcrums__title main-name">Configuration</p>
	                </a>
	            </li>
	            <li class="fnb-breadcrums__section">
	                <a href="">
	                    <p class="fnb-breadcrums__title">/</p>
	                </a>
	            </li>
	            <li class="fnb-breadcrums__section">
	                <a href="">
	                    <p class="fnb-breadcrums__title main-name">Categories</p>
	                </a>
	            </li>
	        </ul> -->

	        <div class="page-title">
	          <div class="title_left">
	            <h5>Internal Users <button class="btn btn-link btn-sm" data-toggle="modal" data-target="#add_newuser_modal">+ Add new user</button></h5>
	          </div>
	        </div>

	        <div class="clearfix"></div>

	        <div class="row">

	          <div class="col-md-12 col-sm-12 col-xs-12">
	            <div class="x_panel">
	              <div class="x_content search-enabled">
	                <!-- <div id="datatable-internal-users_filter" class="dataTables_filter">
	                	<input type="search" name="" placeholder="Search by Name" id="internal_name_search" class="form-control fnb-input pull-right customDtSrch" aria-controls="datatable-internal-users"/>
	                </div> -->

	                <table id="datatable-internal-users" class="display table table-striped  no-wrap internal-users" cellspacing="0" width="100%">
	                  <thead>
	                    <tr>
	                      <th class="no-sort"></th>
	                      <th class="">Name <span class="sort-icon"/></th>
	                      <th class="">Email <span class="sort-icon"/></th>
	                      <th class="no-sort" data-col="3">Roles
	                        <select multiple class="form-control multi-ddd" id="status_filters">
	                          @foreach(Role::all() as $key_role => $value_role)
	                          	<option value="{{$value_role->name}}">{{ ucfirst(implode(" ", explode("_", $value_role->name))) }}</option>
	                          @endforeach
	                        </select>
	                      </th>
	                      <th class="no-sort" data-col="4">Status
	                        <select multiple class="form-control multi-ddd" id="status_filters">
	                          @foreach($status as $status_slug => $status_name)
	                          	<option value="{{ $status_slug }}">{{ $status_name }}</option>
	                          @endforeach
	                        </select>
	                      </th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                    <!-- <tr>
	                      <td><a href="#" class="editUser" data-toggle="modal" data-target="#add_newuser_modal"><i class="fa fa-pencil"></i></a></td>
	                      <td>Valenie Lourenco</td>
	                      <td>valenie@ajency.in</td>
	                      <td>Listing Manger, User Manager</td>
	                      <td>Active</td>
	                    </tr>
	                    <tr>
	                      <td><a href="#" class="editUser" data-toggle="modal" data-target="#add_newuser_modal"><i class="fa fa-pencil"></i></a></td>
	                      <td>Amit Adav</td>
	                      <td>amit@ajency.in</td>
	                      <td>Listing Manger</td>
	                      <td>Active</td>
	                    </tr>
	                    <tr>
	                      <td><a href="#" class="editUser" data-toggle="modal" data-target="#add_newuser_modal"><i class="fa fa-pencil"></i></a></td>
	                      <td>Nutan kamat</td>
	                      <td>nutan@ajency.in</td>
	                      <td>Listing Manger, User Manager</td>
	                      <td>Active</td>
	                    </tr>
	                    <tr>
	                      <td><a href="#" class="editUser" data-toggle="modal" data-target="#add_newuser_modal"><i class="fa fa-pencil"></i></a></td>
	                      <td>Harshita Gauns</td>
	                      <td>harshita@ajency.in</td>
	                      <td>Jobs Manager</td>
	                      <td>Active</td>
	                    </tr>
	                    <tr>
	                      <td><a href="#" class="editUser" data-toggle="modal" data-target="#add_newuser_modal"><i class="fa fa-pencil"></i></a></td>
	                      <td>Ajaj Rajguru</td>
	                      <td>ajaj@ajency.in</td>
	                      <td>News Manager</td>
	                      <td>inactive</td>
	                    </tr> -->
	                  </tbody>
	                </table>

	              </div>

	            </div>
	          </div>

	        </div>

	        <!-- Add Category Modal -->
	        <div class="modal fade" id="add_newuser_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	          <div class="modal-dialog" role="document">
	            <div class="modal-content">
	              <form method="post" id="add_newuser_modal_form" data-parsley-validate="">
	              	<input type="hidden" name="form_type" value=""/>
	              	<input type="hidden" name="user_id" value=""/>
	                <div class="modal-header">
	                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                  <h6 class="modal-title">Add New Internal User</h6>
	                </div>
	                <div class="modal-body">
	                  <div class="row">
	                    <div class="col-sm-6">
	                      <div class="form-group">
	                        <label>Name  <span class="text-danger">*</span></label>
	                        <input type="text" class="form-control fnb-input" name="name" placeholder="Enter your name" data-required="true" required>
	                      </div>
	                    </div>
	                    <div class="col-sm-6">
	                      <div class="form-group">
	                        <label>Email  <span class="text-danger">*</span></label>
	                        <input type="email" class="form-control fnb-input" name="email" placeholder="Email Address" data-parsley-trigger="change" data-required="true" required>
	                    	<p id="email-error" class="fnb-errors hidden"></p>
	                      </div>
	                    </div>
	                  </div>
	                  
	                  <div class="row">
	                    <div class="col-sm-6">
	                      <div class="form-group">
	                        <label>Roles  <span class="text-danger">*</span></label>
	                        <select class="form-control fnb-select roles-select multiSelect" multiple="role_option[]" name="role" data-parsley-mincheck="1" data-required="true" data-parsley-required="true" data-parsley-errors-container="#role-error">
	                          @foreach(Role::all() as $key_role => $value_role)
	                          	<option value="{{$value_role->name}}" name="role_option[]">{{ ucfirst(implode(" ", explode("_", $value_role->name))) }}</option>
	                          @endforeach
	                        </select>
	                        <div id="role-error" class="fnb-error"></div>
	                      </div>
	                    </div>
	                    <div class="col-sm-6">
	                      <div class="form-group">
	                          <label>Status  <span class="text-danger">*</span></label>
	                          <select class="form-control fnb-select dashboard-select status-select" name="status">
	                            <option value="active">Active</option>
	                            <!-- <option value="inactive">Inactive</option> -->
	                            <option value="suspended">Suspended</option>
	                            <!-- <option value="">Published</option>
	                            <option value="">Draft</option>
	                            <option value="">Archived</option> -->
	                          </select>
	                        </div>
	                    </div>
	                  </div>
	                  
	                  <div class="row">
	                    <div class="col-sm-6 hidden old-password">
	                      <div class="form-group">
	                        <label>Old Password  <span class="text-danger">*</span></label>
	                        <input type="password" class="form-control fnb-input" name="old_password" placeholder="Old password">
	                      </div>
	                    </div>
	                    <div class="col-sm-6 new-password">
	                      <div class="form-group">
	                        <label>Password  <span class="text-danger">*</span></label>
	                        <input type="password" class="form-control fnb-input" name="password" id="password" placeholder="Enter a password" parsley-type="password" data-parsley-trigger="keyup" data-required="true" required>
	                        <p id="password-error" class="fnb-errors hidden"></p>
	                      </div>
	                    </div>
	                    <div class="col-sm-6">
	                      <div class="form-group">
	                        <label>Confirm Password <span class="text-danger">*</span></label>
	                        <input type="password" class="form-control fnb-input" name="confirm_password" data-parsley-equalto="#password" placeholder="Confirm your password" data-parsley-trigger="keyup" data-required="true" required>
	                      </div>
	                    </div>
	                  </div>

	                </div>
	                <div class="modal-footer">
	                  <button type="button" class="btn fnb-btn outline no-border" data-dismiss="modal">Cancel</button>
	                  <!-- <button type="submit" class="btn primary-btn fnb-btn border-btn">Save <i class="fa fa-circle-o-notch fa-spin"></i></button> -->
	                  <button type="button" class="btn primary-btn fnb-btn border-btn createSave" id="add_newuser_modal_btn">Create <i class="fa fa-circle-o-notch fa-spin hidden"></i></button>
	                  <button type="button" class="btn primary-btn fnb-btn border-btn hidden editSave" id="add_newuser_modal_btn">Save <i class="fa fa-circle-o-notch fa-spin hidden"></i></button>
	                </div>
	              </form>
	            </div>
	          </div>
	        </div>

      </div>
    </div>
@endsection