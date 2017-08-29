@extends('layouts.admin-dashboard')

@section('js')
  @parent
  <script type="text/javascript" src="/js/dashboard-location.js"></script>
@endsection

@section('page-data')
	<div class="right_col" role="main">
      <div class="">


        <div class="page-title">
          <div class="title_left">
            <h5>Manage Locations <button class="btn btn-link btn-sm" data-toggle="modal" data-target="#add_location_modal">+ Add new</button></h5>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">

          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content">

                <input type="text" name="" placeholder="Search by Name" id="locationNameSearch" class="form-control fnb-input pull-right customDtSrch">

                <table id="datatable-locations" class="table table-striped  nowrap" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      
                      <th>#</th>
                      <th>Name</th>
                      <th>slug</th>
                      <th class="no-sort text-center" data-col="3">
                        isCity
                        <select multiple class="form-control multi-dd">
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </th>
                      <th class="no-sort text-center" data-col="4">
                        isArea
                        <select multiple class="form-control multi-dd">
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </th>
                      <th class="no-sort" data-col="5">
                          City
                          <select multiple class="form-control multi-dd" id="filtercities">
                            @foreach ($cities as $city)
                            <option value="{{$city->name}}">{{$city->name}}</option>
                          @endforeach
                          </select>
                      </th>
                      
                      <th class="text-center">Sort Order</th>
                      <th>Published on</th>
                      <th>Last Updated on</th>
                      <th class="no-sort" data-col="9">
                        Status
                        <select multiple class="form-control multi-dd">
                          <option value="Published">Published</option>
                          <option value="Draft">Draft</option>
                          <option value="Archived">Archived</option>
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

        <!-- Add Location Modal -->
        <div class="modal fade" id="add_location_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form id="locationForm">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h6 class="modal-title">Add New Location</h6>
                </div>
                <div class="modal-body">
                  <label>Type of Location <span class="text-danger">*</span></label>
                  <div class="form-group ">
                    <label class="radio-inline">
                      <input type="radio" name="locationType" id="city" value="0" class="fnb-radio"> City
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="locationType" id="area" value="1" class="fnb-radio" checked=""> Area
                    </label>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group select_city">
                        <label>Select the City <span class="text-danger">*</span></label>
                        <select class="form-control fnb-select w-border" id="allcities" required>
                          <option value="">Select City</option>
                          @foreach ($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Location Name  <span class="text-danger" >*</span></label>
                    <input type="text" class="form-control fnb-input" name="name" placeholder="Enter a Area name" required>
                  </div>

                  <div class="form-group">
                    <label>Location Slug  <span class="text-danger">*</span></label>
                    <input type="text" class="form-control fnb-input" name="slug" placeholder="Enter the Area Slug" required>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Sort Order  <span class="text-danger">*</span></label>
                        <input type="number" class="form-control fnb-input" name="order" value="1" min="1">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select class="form-control fnb-select w-border" name="status" required>
                          <option value="0">Draft</option>
                        </select>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn fnb-btn outline no-border" data-dismiss="modal">Cancel</button>
                  <button type="button" class="btn primary-btn fnb-btn border-btn save-btn">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>

@endsection