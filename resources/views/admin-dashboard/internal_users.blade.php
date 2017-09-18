@extends('layouts.admin-dashboard')

@section('css')
    <!-- Datatables -->
    <link href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-multiselect.min.css" rel="stylesheet">
    <!-- Main styles -->
    <link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('js')
  @parent
  <script type="text/javascript" src="/bower_components/bootstrap-confirmation2/bootstrap-confirmation.min.js"></script>
@endsection

@section('page-data')
	<div class="right_col" role="main">
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
	            <h5>Manage Categories <button class="btn btn-link btn-sm" data-toggle="modal" data-target="#add_newuser_modal">+ Add new user</button></h5>
	          </div>
	        </div>

	        <div class="clearfix"></div>

	        <div class="row">

	          <div class="col-md-12 col-sm-12 col-xs-12">
	            <div class="x_panel">
	              <div class="x_content search-enabled">

	                <input type="text" name="" placeholder="Search by Name" id="catNameSearch" class="form-control fnb-input pull-right customDtSrch" >

	                <table id="datatable-users" class="table table-striped  no-wrap" cellspacing="0" width="100%">
	                  <thead>
	                    <tr>
	                      <th class="no-sort"></th>
	                      <th class="">Name </th>
	                      <th class="">Email </th>
	                      <th class="no-sort ">Roles
	                        <select multiple class="form-control multi-dd">
	                          <option value="yes">Yes</option>
	                          <option value="no">No</option>
	                        </select>
	                      </th>
	                      <th class="no-sort">Status
	                        <select multiple class="form-control multi-dd">
	                          <option value="published">Published</option>
	                          <option value="draft">Draft</option>
	                          <option value="archived">Archived</option>
	                        </select>
	                      </th>
	                    </tr>
	                  </thead>
	                  <tbody>
	                    <tr>
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
	                    </tr>
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
	              <form>
	                <div class="modal-header">
	                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                  <h6 class="modal-title">Add New Internal User</h6>
	                </div>
	                <div class="modal-body">
	                  <div class="row">
	                    <div class="col-sm-6">
	                      <div class="form-group">
	                        <label>Name  <span class="text-danger">*</span></label>
	                        <input type="text" class="form-control fnb-input" name="" placeholder="Enter your name">
	                      </div>
	                    </div>
	                    <div class="col-sm-6">
	                      <div class="form-group">
	                        <label>Email  <span class="text-danger">*</span></label>
	                        <input type="text" class="form-control fnb-input" name="" placeholder="Email Address">
	                      </div>
	                    </div>
	                  </div>
	                  
	                  <div class="row">
	                    <div class="col-sm-6">
	                      <div class="form-group">
	                        <label>Roles  <span class="text-danger">*</span></label>
	                        <select class="form-control fnb-select roles-select multiSelect" multiple="multiple">
	                          <option >Published</option>
	                          <option >Draft</option>
	                          <option >Archived</option>
	                        </select>
	                      </div>
	                    </div>
	                    <div class="col-sm-6">
	                      <div class="form-group">
	                          <label>Status  <span class="text-danger">*</span></label>
	                          <select class="form-control fnb-select dashboard-select">
	                            <option value="">Published</option>
	                            <option value="">Draft</option>
	                            <option value="">Archived</option>
	                          </select>
	                        </div>
	                    </div>
	                  </div>
	                  
	                  <div class="row">
	                    <div class="col-sm-6 hidden old-password">
	                      <div class="form-group">
	                        <label>Old Password  <span class="text-danger">*</span></label>
	                        <input type="password" class="form-control fnb-input" name="" placeholder="Old password">
	                      </div>
	                    </div>
	                    <div class="col-sm-6 new-password">
	                      <div class="form-group">
	                        <label>Password  <span class="text-danger">*</span></label>
	                        <input type="password" class="form-control fnb-input" name="" placeholder="Enter a password">
	                      </div>
	                    </div>
	                    <div class="col-sm-6">
	                      <div class="form-group">
	                        <label>Confirm Password <span class="text-danger">*</span></label>
	                        <input type="password" class="form-control fnb-input" name="" placeholder="Confirm your password">
	                      </div>
	                    </div>
	                  </div>

	                </div>
	                <div class="modal-footer">
	                  <button type="button" class="btn fnb-btn outline no-border" data-dismiss="modal">Cancel</button>
	                  <button type="submit" class="btn primary-btn fnb-btn border-btn">Save <i class="fa fa-circle-o-notch fa-spin"></i></button>
	                </div>
	              </form>
	            </div>
	          </div>
	        </div>

      </div>
    </div>
@section