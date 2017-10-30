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
   <script type="text/javascript" src="/js/handlebars.js"></script>
    <!-- <script type="text/javascript" src="/js/require.js"></script> -->

    <!-- bootstrap-daterangepicker -->
    <script src="/bower_components/moment/min/moment.min.js"></script>
    <script src="/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Autosize textarea -->
    <script src="/bower_components/autosize/dist/autosize.min.js"></script>

    <script type="text/javascript" src="/js/dashboard-manage-enquiries.js"></script>
@endsection
@section('meta')
  <meta property="status-url" content="{{action('AdminModerationController@setStatus')}}">
@endsection

@section('page-data')
<div class="right_col" role="main">
      <div class="">

        <div class="page-title">
          <div class="title_left">
            <h5>Manage Enquiries<button type="button" class="btn btn-link btn-sm" id="resetAll">Reset all Filters</button></h5>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">

          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content">

                <div class="row">
                  <div class="col-sm-3">
                    <label>Date of Enquiry</label>
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


                <hr>

                <table id="datatable-manage_enquiries" class="table table-striped" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="min-width: 8%;" class="no-sort">Enquiry Type
                        <select multiple class="form-control multi-dd" id="updateType">
                          <option value="direct" >Direct Enquiry</option>
                          <option value="shared" >Shared Enquiry</option>
                        </select>
                      </th>
                      <th style="min-width: 5%;" class="no-sort">Enquirer Type
                        <select multiple class="form-control multi-dd" id="updateUser">
                          <option value="user" >User</option>
                          <option value="lead" >Lead</option>
                        </select>
                      </th>
                      <th style="min-width: 8%;">
                        Request Date
                      </th>
                      <th class="no-sort">
                        Name
                      </th>
                      <th class="no-sort" style="min-width: 10%;">
                        Email
                      </th>
                      <th class="no-sort" style="min-width: 10%;">
                        Phone
                      </th>
                      <th class="no-sort" style="min-width: 10%;">
                        What describes you Best
                        <select multiple class="form-control multi-dd" id="updateUser">
                          <option value="hospitality" >Hospitality</option>
                          <option value="professional" >Professional</option>
                          <option value="vendor" >Vendor</option>
                          <option value="student" >Student</option>
                          <option value="enterpreneur" >Enterpreneur</option>
                          <option value="others" >Others</option>
                        </select>
                      </th>
                      <th class="no-sort" style="min-width: 10%;">
                        Message
                      </th>
                      <th class="no-sort">Categories</th>
                      <th class="no-sort" style="min-width: 10%;">Areas</th>
                      <th class="no-sort" style="min-width: 10%;">
                        Enquiry Made to
                      </th>
                      <th class="no-sort" style="min-width: 10%;">
                        Enquiry Sent to
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

       


        




      </div>
    </div>

@endsection