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

			<!--<ul class="fnb-breadcrums flex-row m-t-10 m-b-20">
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
	            <h5>Registered Users </h5>
	          </div>
	        </div>

	        <div class="clearfix"></div>

	        <div class="row">

	          <div class="col-md-12 col-sm-12 col-xs-12">
	            <div class="x_panel">
	              <div class="x_content">

	                <div class="row">
	                  <div class="col-sm-4">
	                    <label>Date created</label>
	                    <a href="#" class="btn btn-link btn-sm clearDate">Clear</a>
	                    <div class="form-group">
	                      <input type="text" id="submissionDate" name="" class="form-control fnb-input">
	                      <!-- <button class="btn btn-sm fnb-btn">Apply</button> -->
	                    </div>
	                  </div>

	                  <div class="col-sm-4">
	                    <label>Last Login</label>
	                    <a href="#" class="btn btn-link btn-sm clearDate">Clear</a>
	                    <div class="form-group">
	                      <input type="text" id="loginDate" name="" class="form-control fnb-input">
	                      <!-- <button class="btn btn-sm fnb-btn">Apply</button> -->
	                    </div>
	                  </div>

	                  <div class="col-sm-3">
	                      <div class="m-t-20 filterAction">
	                        <button class="btn fnb-btn outline no-border">Reset all Filters</button>
	                        <button class="btn primary-btn border-btn fnb-btn">Apply Filters</button>
	                      </div>
	                  </div>
	                    
	                </div>


	                <input type="text" name="" placeholder="Search by Name" id="catNameSearch" class="form-control fnb-input pull-right customDtSrch" >

	                <table id="datatable-registered" class="table table-striped  no-wrap registered-table" cellspacing="0" width="100%">
	                  <thead>
	                    <tr>
	                      <th class="text-center" rowspan="2" >Name</th>
	                      <th rowspan="2" class="no-sort text-center" data-col="2">Registration Type
	                        <select multiple class="form-control multi-dd">
	                          <option value="yes">Yes</option>
	                          <option value="no">No</option>
	                        </select>
	                      </th>
	                      <th class="text-center" rowspan="2">Email</th>
	                      <th class="text-center" rowspan="2">Phone</th>
	                      <th rowspan="2" class="no-sort text-center" data-col="3">What describe you the best?
	                        <select multiple class="form-control multi-dd">
	                          <option value="yes">Yes</option>
	                          <option value="no">No</option>
	                        </select>
	                      </th>
	                      <th rowspan="2" class="no-sort text-center" data-col="4" style="min-width: 70px;">City
	                        <select multiple class="form-control multi-dd">
	                          <option value="yes">Yes</option>
	                          <option value="no">No</option>
	                        </select>
	                      </th>
	                      <th class="no-sort text-center" rowspan="2" class="no-sort" data-col="5" style="min-width: 70px;">
	                          Area
	                          <select multiple class="form-control multi-dd">
	                            <option value="meat">Meat</option>
	                            <option value="sea foods">Sea Foods</option>
	                          </select>
	                      </th>
	                      <th class="no-sort text-center" rowspan="2" class="no-sort" data-col="6" style="min-width: 70px;">
	                        Status
	                        <select multiple class="form-control multi-dd">
	                          <option value="Chicken Distributors">Chicken Distributors</option>
	                        </select>
	                      </th>
	                      <th class="text-center" rowspan="2" class="no-sort" style="min-width: 130px;">Date Created</th>
	                      <th class="text-center" rowspan="2" class="" style="min-width: 70px;">Last Login</th>
	                      <th class="text-center" colspan="2" style="min-width: 70px;">Business Listings</th>
	                      <th class="text-center" colspan="2" style="min-width: 70px;">Restaurant Listings</th>
	                      <th class="text-center" colspan="2" style="min-width: 70px;">Jobs Added</th>
	                      <th class="text-center" rowspan="2" style="min-width: 100px;">Jobs Applied to</th>
	                      <th class="text-center" rowspan="2" style="min-width: 100px;">Resume Uploaded (Y/N)</th>
	                    </tr>
	                    <tr>
	                      <th class="text-center" style="min-width: 70px;">Total</th>
	                      <th class="text-center" style="min-width: 70px;">Published</th>
	                      <th class="text-center" style="min-width: 70px;">Total</th>
	                      <th class="text-center" style="min-width: 70px;">Published</th>
	                      <th class="text-center" style="min-width: 70px;">Total</th>
	                      <th class="text-center" style="min-width: 70px;">Published</th>
	                    </tr>
	                  </thead>

	                  <tbody>
	                    <tr>
	                      <td class="text-center">Amit Adav</td>
	                      <td class="text-center">Email</td>
	                      <td class="text-center">amit@ajency.in</td>
	                      <td class="text-center">8087854125</td>
	                      <td class="text-center">Others</td>
	                      <td class="text-center">Goa</td>
	                      <td class="text-center">Panjim</td>
	                      <td class="text-center">Active</td>
	                      <td class="text-center">12/01/2017</td>
	                      <td class="text-center">21/06/2017</td>
	                      <td class="text-center">1</td>
	                      <td class="text-center">1</td>
	                      <td class="text-center">1</td>
	                      <td class="text-center">1</td>
	                      <td class="text-center">1</td>
	                      <td class="text-center">1</td>
	                      <td class="text-center">0</td>
	                      <td class="text-center">N</td>
	                    </tr>
	                    <tr>
	                      <td class="text-center">Valenie Lourenco</td>
	                      <td class="text-center">Email</td>
	                      <td class="text-center">valenie@ajency.in</td>
	                      <td class="text-center">8087854125</td>
	                      <td class="text-center">Others</td>
	                      <td class="text-center">Goa</td>
	                      <td class="text-center">Panjim</td>
	                      <td class="text-center">Active</td>
	                      <td class="text-center">12/01/2017</td>
	                      <td class="text-center">21/06/2017</td>
	                      <td class="text-center">1</td>
	                      <td class="text-center">1</td>
	                      <td class="text-center">1</td>
	                      <td class="text-center">1</td>
	                      <td class="text-center">1</td>
	                      <td class="text-center">1</td>
	                      <td class="text-center">0</td>
	                      <td class="text-center">N</td>
	                    </tr>
	                  </tbody>
	                </table>

	              </div>

	            </div>
	          </div>

	        </div>

	        <!-- Add Category Modal -->
	        <div class="modal fade" id="add_category_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	          <div class="modal-dialog" role="document">
	            <div class="modal-content">
	              <form>
	                <div class="modal-header">
	                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                  <h6 class="modal-title">Add New Category</h6>
	                </div>
	                <div class="modal-body">
	                  <label>Type of Category <span class="text-danger">*</span></label>
	                  <div class="form-group flex flex-space-between">
	                    <label class="radio-inline">
	                      <input type="radio" name="categoryType" id="parent_cat" value="parent_cat" class="fnb-radio" checked> Parent Category
	                    </label>
	                    <label class="radio-inline">
	                      <input type="radio" name="categoryType" id="branch_cat" value="branch_cat" class="fnb-radio"> Branch Category
	                    </label>
	                    <label class="radio-inline">
	                      <input type="radio" name="categoryType" id="node_cat" value="node_cat" class="fnb-radio"> Node Category
	                    </label>
	                  </div>

	                  <div class="row">
	                    <div class="col-sm-6">
	                      <div class="form-group select-parent-cat hidden">
	                        <label>Select Parent Category <span class="text-danger">*</span></label>
	                        <select class="form-control fnb-select w-border">
	                          <option value="">Meat Products</option>
	                          <option value="">Meat Products</option>
	                          <option value="">Meat Products</option>
	                        </select>
	                      </div>
	                    </div>
	                    <div class="col-sm-6">
	                      <div class="form-group select-branch-cat hidden">
	                        <label>Select Branch Category <span class="text-danger">*</span></label>
	                        <select class="form-control fnb-select w-border">
	                          <option value="">Chicken Suppliers</option>
	                          <option value="">Chicken Suppliers</option>
	                          <option value="">Chicken Suppliers</option>
	                        </select>
	                      </div>
	                    </div>
	                  </div>

	                  <div class="form-group">
	                    <label>Category Name  <span class="text-danger">*</span></label>
	                    <input type="text" class="form-control fnb-input" name="" placeholder="Enter a Category name">
	                  </div>

	                  <div class="form-group">
	                    <label>Category Url  <span class="text-danger">*</span></label>
	                    <input type="text" class="form-control fnb-input" name="" placeholder="Enter the Category Url">
	                  </div>

	                  <div class="form-group parent_cat_icon">
	                    <label>Icon  <span class="text-danger">*</span></label>
	                    <input type="file" name="">
	                  </div>

	                  <div class="row">
	                    <div class="col-sm-6">
	                      <div class="form-group">
	                        <label>Sort Order  <span class="text-danger">*</span></label>
	                        <input type="number" class="form-control fnb-input" name="" value="1" min="1" placeholder="Enter a Sort value">
	                      </div>
	                    </div>
	                    <div class="col-sm-6">
	                      <div class="form-group">
	                        <label>Status <span class="text-danger">*</span></label>
	                        <select class="form-control fnb-select w-border">
	                          <option value="">Published</option>
	                          <option value="">Draft</option>
	                          <option value="">Archived</option>
	                        </select>
	                      </div>
	                    </div>
	                  </div>

	                </div>
	                <div class="modal-footer">
	                  <button type="button" class="btn fnb-btn outline no-border" data-dismiss="modal">Cancel</button>
	                  <button type="submit" class="btn primary-btn fnb-btn border-btn">Save</button>
	                </div>
	              </form>
	            </div>
	          </div>
	        </div>

		</div>
    </div>
@section

@section('js')
	<div class="site-overlay"></div>
    <!-- jquery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- BS Script -->
    <script type="text/javascript" src="../public/js/bootstrap.min.js"></script>
    <!-- Smooth Mouse scroll -->
    <script type="text/javascript" src="../public/js/jquery.easeScroll.min.js"></script>
    <!-- BS lightbox -->
    <!-- <script type="text/javascript" src="bower_components/ekko-lightbox/dist/ekko-lightbox.min.js"></script> -->
    <!-- Magnify popup plugin -->
    <script type="text/javascript" src="../public/js/magnify.min.js"></script>
    <!-- Read more -->
    <script type="text/javascript" src="../public/js/readmore.min.js"></script>

    <script src="../public/js/bootstrap-multiselect.js"></script>

    <!-- Datatables -->
    <script src="../public/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../public/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- <script src="../public/js/datatable-button.js"></script> -->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
  
    <!-- Autosize textarea -->
    <script src="../public/bower_components/autosize/dist/autosize.min.js"></script>

    <!-- Date range -->
    <script src="../public/bower_components/moment/min/moment.min.js"></script>
    <script src="../public/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- custom script -->
    <script type="text/javascript" src="../public/js/custom.js"></script>

    <script type="text/javascript" src="../public/js/dashboard.js"></script>
@section