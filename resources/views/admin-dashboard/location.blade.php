@extends('layouts.admin-dashboard')

@section('page-data')
	<div class="right_col" role="main">
      <div class="">

        <ul class="fnb-breadcrums flex-row m-t-10 m-b-20">
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
                    <p class="fnb-breadcrums__title main-name">Locations</p>
                </a>
            </li>
        </ul>

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
                      <th class="no-sort"></th>
                      <th>Name</th>
                      <th class="no-sort text-center" data-col="2">
                        isCity
                        <select multiple class="form-control multi-dd">
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </th>
                      <th class="no-sort text-center" data-col="3">
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
                      <th>Area</th>
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
                    <tr>
                      <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                      <td><a href="#" class="dt-link">Goa</a></td>
                      <td class="text-center"><i class="fa fa-check text-success"></i></td>
                      <td class="text-center">-</td>
                      <td>-</td>
                      <td>-</td>
                      <td class="text-center">1</td>
                      <td>2017/06/05</td>
                      <td>2017/06/05</td>
                      <td>Published</td>
                    </tr>
                    <tr>
                      <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                      <td><a href="#" class="dt-link">Panjim</a></td>
                      <td class="text-center">-</td>
                      <td class="text-center"><i class="fa fa-check text-success"></i></td>
                      <td>Goa</td>
                      <td>-</td>
                      <td class="text-center">4</td>
                      <td>-</td>
                      <td>2017/06/12</td>
                      <td>Draft</td>
                    </tr>
                    <tr>
                      <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                      <td><a href="#" class="dt-link">Mumbai</a></td>
                      <td class="text-center"><i class="fa fa-check text-success"></i></td>
                      <td class="text-center">-</td>
                      <td>-</td>
                      <td>-</td>
                      <td class="text-center">2</td>
                      <td>2017/06/05</td>
                      <td>2017/07/31</td>
                      <td>Archived</td>
                    </tr>
                    <tr>
                      <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                      <td><a href="#" class="dt-link">Margao</a></td>
                      <td class="text-center">-</td>
                      <td class="text-center"><i class="fa fa-check text-success"></i></td>
                      <td>Goa</td>
                      <td>-</td>
                      <td class="text-center">3</td>
                      <td>2017/06/05</td>
                      <td>2017/06/20</td>
                      <td>Published</td>
                    </tr>
                    <tr>
                      <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                      <td><a href="#" class="dt-link">Delhi</a></td>
                      <td class="text-center"><i class="fa fa-check text-success"></i></td>
                      <td class="text-center">-</td>
                      <td>-</td>
                      <td>-</td>
                      <td class="text-center">1</td>
                      <td>2017/06/05</td>
                      <td>2017/05/05</td>
                      <td>Published</td>
                    </tr>
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