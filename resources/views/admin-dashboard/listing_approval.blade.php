@extends('layouts.admin-dashboard')

@section('js')
  @parent
  <script type="text/javascript" src="/js/dashboard-listing-approval.js"></script>
@endsection

@section('page-data')
<div class="right_col" role="main">
      <div class="">

        <div class="page-title">
          <div class="title_left">
            <h5>Listing Approval <button class="btn btn-link btn-sm">+ Add Listing</button></h5>
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
                    <a href="#" class="btn btn-link btn-sm">Clear</a>
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
                      <div class="single-category gray-border m-b-10">
                          <div class="row flex-row categoryContainer corecat-container">
                              <div class="col-sm-4 flex-row">
                                  <div class="branch-row">
                                      <div class="cat-label">Meat</div>
                                  </div>
                              </div>
                              <div class="col-sm-2">
                                  <strong class="branch">Chicken</strong>
                              </div>
                              <div class="col-sm-6">
                                  <ul class="fnb-cat small flex-row">
                                      <li><span class="fnb-cat__title">Boneless Chicken <span class="fa fa-times remove"></span></span>
                                      </li>
                                      <li><span class="fnb-cat__title">Frozen Chicken <span class="fa fa-times remove"></span></span>
                                      </li>
                                  </ul>
                              </div>
                          </div>
                          <div class="delete-cat">
                              <span class="fa fa-times remove"></span>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="filter-actions m-t-10">
                  <div class="pull-right">
                    <button class="btn fnb-btn outline no-border">Reset all Filters</button>
                    <button class="btn primary-btn border-btn fnb-btn">Apply Filters</button>
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="m-t-10">
                  <label class="flex-row flex-end">
                      <input type="checkbox" class="checkbox" for="draft_status">
                      <div class="text-medium m-b-0" id="draft_status">Display Listings having Draft status</div>
                  </label>
                </div>

                <div class="bulk-status-update m-t-10 hidden">
                  <hr>
                  <label>Bulk Status Update</label>
                  <div class="row">
                    <div class="col-sm-3">
                      <select class="form-control fnb-select w-border status-select">
                        <option value="Published">Published</option>
                        <option value="Draft">Draft</option>
                        <option value="Archived">Archived</option>
                        <option value="Pending Review" selected>Pending Review</option>
                        <option value="Rejected">Rejected</option>
                      </select>
                      <label class="flex-row notify-user-msg hidden m-t-15">
                          <input type="checkbox" class="checkbox" for="bulk_notify_user">
                          <div class="text-medium m-b-0" id="bulk_notify_user">Notify Listing Owner</div>
                      </label>
                    </div>
                    <div class="col-sm-2">
                      <button class="btn primary-btn border-btn fnb-btn">Update</button>
                    </div>
                  </div>
                </div>

                <input type="text" name="" placeholder="Search by Name" id="listingNameSearch" class="form-control fnb-input pull-right customDtSrch">

                <hr>

                <table id="datatable-listing_approval" class="table table-striped" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th></th>
                      <th style="min-width: 12%;">Listing Name</th>
                      <th class="no-sort" data-col="2">
                        City
                        <select multiple class="form-control multi-dd">
                          <option value="Panjim">Panjim</option>
                          <option value="Margao">Margao</option>
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
                        <select multiple class="form-control multi-dd">
                          <option value="External User">External User</option>
                          <option value="Internal User">Internal User</option>
                        </select>
                      </th>
                      <th>Duplicates<br><small>(Number,Email,Name)</small></th>
                      <th class="no-sort" data-col="8" style="min-width: 10%;">
                        Premium Request
                        <select multiple class="form-control multi-dd">
                          <option value="Yes">Yes</option>
                          <option value="No">No</option>
                        </select>
                      </th>
                      <th class="no-sort" data-col="9" style="min-width: 10%;">
                        Status
                        <select multiple class="form-control multi-dd">
                          <option value="Published">Published</option>
                          <option value="Draft">Draft</option>
                          <option value="Archived">Archived</option>
                          <option value="Pending Review">Pending Review</option>
                          <option value="Rejected">Rejected</option>
                        </select>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td></td>
                      <td><a href="#">AVK Suppliers</a></td>
                      <td>Panjim</td>
                      <td>
                        <div class="m-b-5">
                          Meat > Chicken > Boneless Chicken, Frozen Chicken
                          <!-- Boneless Chicken, Frozen Chicken -->
                          <!-- <i class="fa fa-info-circle small text-color" data-toggle="tooltip" data-placement="right" title="Meat > Chicken > Boneless Chicken, Frozen Chicken"></i> -->
                        </div>
                        <div class="m-b-5">
                          Meat > Pork > Pork Ham, Pork Meat, Pork Chops
                          <!-- Pork Ham, Pork Meat, Pork Chops -->
                          <!-- <i class="fa fa-info-circle small text-color" data-toggle="tooltip" data-placement="right" title="Meat > Pork > Pork Ham, Pork Meat, Pork Chops"></i> -->
                        </div>
                      </td>
                      <td>2017/06/05</td>
                      <td>2017/06/05</td>
                      <td>External User</td>
                      <td>1,2,1</td>
                      <td>No</td>
                      <td>Pending Review <a href="#updateStatusModal" data-target="#updateStatusModal" data-toggle="modal"><i class="fa fa-pencil"></i></a></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td><a href="#">Mz Wholesalers</a></td>
                      <td>Margao</td>
                      <td>
                        <div class="m-b-5">
                          Milk & Dairy > Butter > Unsalted Butter, Pasteurized Butter
                          <!-- Unsalted Butter, Pasteurized Butter -->
                          <!-- <i class="fa fa-info-circle small text-color" data-toggle="tooltip" data-placement="right" title="Milk & Dairy > Butter > Unsalted Butter, Pasteurized Butter"></i> -->
                        </div>
                      </td>
                      <td>2017/06/04</td>
                      <td>2017/06/05</td>
                      <td>External User</td>
                      <td>0,0,0</td>
                      <td>Yes</td>
                      <td>Rejected <a href="#updateStatusModal" data-target="#updateStatusModal" data-toggle="modal"><i class="fa fa-pencil"></i></a></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td><a href="#">Kusumkar Dist</a></td>
                      <td>Bandra</td>
                      <td>
                        <div class="m-b-5">
                          Meat > Chicken > Boneless Chicken, Frozen Chicken
                          <!-- Boneless Chicken, Frozen Chicken -->
                          <!-- <i class="fa fa-info-circle small text-color" data-toggle="tooltip" data-placement="right" title="Meat > Chicken > Boneless Chicken, Frozen Chicken"></i> -->
                        </div>
                      </td>
                      <td>2017/06/04</td>
                      <td>2017/06/05</td>
                      <td>Internal User</td>
                      <td>0,0,0</td>
                      <td>No</td>
                      <td>Published <a href="#updateStatusModal" data-target="#updateStatusModal" data-toggle="modal"><i class="fa fa-pencil"></i></a></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td><a href="#">Bhatt Suppliers</a></td>
                      <td>Ahmedabad</td>
                      <td>
                        <div class="m-b-5">
                          Sweets > Milk Sweets > Peda, Burfi, Rabri, Rasgulla, Rasmalai
                          <!-- Peda, Burfi, Rabri, Rasgulla, Rasmalai -->
                          <!-- <i class="fa fa-info-circle small text-color" data-toggle="tooltip" data-placement="right" title="Sweets > Milk Sweets > Peda, Burfi, Rabri, Rasgulla, Rasmalai"></i> -->
                        </div>
                      </td>
                      <td>2017/06/04</td>
                      <td>2017/06/05</td>
                      <td>External User</td>
                      <td>0,0,0</td>
                      <td>No</td>
                      <td>Published <a href="#updateStatusModal" data-target="#updateStatusModal" data-toggle="modal"><i class="fa fa-pencil"></i></a></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td><a href="#">ROC</a></td>
                      <td>Panjim</td>
                      <td>
                        <div class="m-b-5">
                          Meat > Pork > Pork Ham, Pork Meat, Pork Chops
                          <!-- Pork Ham, Pork Meat, Pork Chops -->
                          <!-- <i class="fa fa-info-circle small text-color" data-toggle="tooltip" data-placement="right" title="Meat > Pork > Pork Ham, Pork Meat, Pork Chops"></i> -->
                        </div>
                      </td>
                      <td>2017/06/04</td>
                      <td>2017/06/05</td>
                      <td>External User</td>
                      <td>0,0,0</td>
                      <td>No</td>
                      <td>Published <a href="#updateStatusModal" data-target="#updateStatusModal" data-toggle="modal"><i class="fa fa-pencil"></i></a></td>
                    </tr>

                  </tbody>
                </table>

              </div>

            </div>
          </div>

        </div>

        <!-- Category Filter -->
        <div class="modal fnb-modal category-modal multilevel-modal fade" id="category-select" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="level-one mobile-hide ">
                            <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                        <div class="mobile-back flex-row">
                            <div class="back">
                                <button class="btn fnb-btn outline border-btn no-border" data-dismiss="modal"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i> Back to Category</button>
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
                                    <input type="radio" class="radio level-two-toggle" name="categories" data-name="{{$parent->name}}">
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
                                        <p class="instructions__title bat-color default-size">Please choose the sub categories under "<span class="main-cat-name">Vegetables</span>"</p>
                                        <h5 class="sub-title cat-title bat-color main-cat-name">Vegetables</h5>
                                    </div>
                                </div>
                                <div>
                                    <button id="category-select" class="btn fnb-btn outline border-btn re-save" type="button" data-dismiss="modal">save</button>
                                </div>
                            </div>

                            <div class="node-select flex-row">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs flex-row mobile-hide categ-list" role="tablist">
                                    <li role="presentation" class="active"><a href="#chicken" aria-controls="chicken" role="tab" data-toggle="tab">Chicken</a></li>
                                    <li role="presentation"><a href="#mutton" aria-controls="mutton" role="tab" data-toggle="tab">Mutton</a></li>
                                    <li role="presentation"><a href="#pork" aria-controls="pork" role="tab" data-toggle="tab">Pork</a></li>
                                    <li role="presentation"><a href="#beef" aria-controls="beef" role="tab" data-toggle="tab">Beef</a></li>
                                    <li role="presentation"><a href="#halal" aria-controls="halal" role="tab" data-toggle="tab">Halal meat</a></li>
                                    <li role="presentation"><a href="#rabbit" aria-controls="rabbit" role="tab" data-toggle="tab">Rabbit meat</a></li>
                                    <li role="presentation"><a href="#sheep" aria-controls="sheep" role="tab" data-toggle="tab">Sheep meat</a></li>
                                    <li role="presentation"><a href="#cured" aria-controls="cured" role="tab" data-toggle="tab">Cured meat</a></li>
                                    <li role="presentation"><a href="#knuckle" aria-controls="knuckle" role="tab" data-toggle="tab">Knuckle meat</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content cat-dataHolder mobile-categories relative">
                                    <!-- mobile collapse -->
                                    <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#chicken" aria-expanded="false" aria-controls="chicken">
                                        Chicken <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </div>
                                    <div role="tabpanel" class="tab-pane active collapse" id="chicken">
                                        <ul class="nodes">
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="boneless">
                                                    <p class="lighter nodes__text" id="boneless">Boneless Chicken</p>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#mutton" aria-expanded="false" aria-controls="mutton">
                                        Mutton <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </div>
                                    <div role="tabpanel" class="tab-pane collapse" id="mutton">Mutton</div>
                                    <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#pork" aria-expanded="false" aria-controls="pork">
                                        Pork <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </div>
                                    <div role="tabpanel" class="tab-pane collapse" id="pork">Pork</div>
                                    <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#beef" aria-expanded="false" aria-controls="beef">
                                        Beef <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </div>
                                    <div role="tabpanel" class="tab-pane collapse" id="beef">Beef</div>
                                    <div role="tabpanel" class="tab-pane" id="halal">Halal</div>
                                    <div role="tabpanel" class="tab-pane" id="rabbit">Rabbit</div>
                                    <div role="tabpanel" class="tab-pane" id="sheep">Sheep</div>
                                    <div role="tabpanel" class="tab-pane" id="cured">Cured</div>
                                    <div role="tabpanel" class="tab-pane" id="knuckle">Knuckle</div>
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
              <div class="modal-body">
                <label>Status of AVK Suppliers</label>
                <select class="form-control fnb-select w-border status-select">
                  <option value="Published">Published</option>
                  <option value="Draft">Draft</option>
                  <option value="Archived">Archived</option>
                  <option value="Pending Review">Pending Review</option>
                  <option value="Rejected" selected>Rejected</option>
                </select>
                <label class="flex-row notify-user-msg hidden m-t-15">
                    <input type="checkbox" class="checkbox" for="notify_user">
                    <div class="text-medium m-b-0" id="notify_user">Notify Listing Owner</div>
                </label>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn fnb-btn primary-btn mini">Save changes</button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

@endsection