@extends('layouts.admin-dashboard')

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
                      
                      <th>Name</th>
                      <th class="no-sort text-center" data-col="1">
                        isCity
                        <select multiple class="form-control multi-dd">
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </th>
                      <th class="no-sort text-center" data-col="2">
                        isArea
                        <select multiple class="form-control multi-dd">
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </th>
                      <th class="no-sort" data-col="4">
                          City
                          <select multiple class="form-control multi-dd">
                            <option value="goa">Goa</option>
                          </select>
                      </th>
                      
                      <th class="text-center">Sort Order</th>
                      <th>Published on</th>
                      <th>Last Updated on</th>
                      <th class="no-sort" data-col="10">
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
              <form>
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h6 class="modal-title">Add New Location</h6>
                </div>
                <div class="modal-body">
                  <label>Type of Location <span class="text-danger">*</span></label>
                  <div class="form-group ">
                    <label class="radio-inline">
                      <input type="radio" name="locationType" id="city" value="city_type" class="fnb-radio"> City
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="locationType" id="area" value="area_type" class="fnb-radio" checked=""> Area
                    </label>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group select_city">
                        <label>Select the City <span class="text-danger">*</span></label>
                        <select class="form-control fnb-select w-border">
                          <option value="">City Name</option>
                          <option value="">City Name</option>
                          <option value="">City Name</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Area Name  <span class="text-danger">*</span></label>
                    <input type="text" class="form-control fnb-input" name="" placeholder="Enter a Area name">
                  </div>

                  <div class="form-group">
                    <label>Area Url  <span class="text-danger">*</span></label>
                    <input type="text" class="form-control fnb-input" name="" placeholder="Enter the Area Url">
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Sort Order  <span class="text-danger">*</span></label>
                        <input type="number" class="form-control fnb-input" name="" value="1" min="1">
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

@endsection