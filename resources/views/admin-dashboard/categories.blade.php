@extends('layouts.admin-dashboard')

@section('js')
  @parent
  <script type="text/javascript" src="/js/dashboard-categories.js"></script>
@endsection

@section('page-data')
  <div class="right_col" role="main">
      <div class="">

        <div class="page-title">
          <div class="title_left">
            <h5>Manage Categories <button class="btn btn-link btn-sm" data-toggle="modal" data-target="#add_category_modal">+ Add new</button><button id="resetfilter" class="btn btn-link btn-sm">Reset Filters</button></h5>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">

          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content">

                <input type="text" name="" placeholder="Search by Name" id="catNameSearch" class="form-control fnb-input pull-right customDtSrch" >

                <table id="datatable-categories" class="table table-striped  no-wrap" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th class="no-sort"></th>
                      <th>Name</th>
                      <th>Slug</th>
                      <th class="no-sort text-center" data-col="3">isParent
                        <select multiple class="form-control multi-dd">
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </th>
                      <th class="no-sort text-center" data-col="4">isBranch
                        <select multiple class="form-control multi-dd">
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </th>
                      <th class="no-sort text-center" data-col="5">isNode
                        <select multiple class="form-control multi-dd">
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </th>
                      <th class="no-sort" data-col="6">
                          Parent
                          <select multiple class="form-control multi-dd">
                            @foreach($parents as $parent)
                            <option>{{$parent->name}}</option>
                            @endforeach
                          </select>
                      </th>
                      <th class="no-sort" data-col="7">
                        Branch
                        <select multiple class="form-control multi-dd">
                          @foreach($branches as $branch)
                            <option>{{$branch->name}}</option>
                            @endforeach
                        </select>
                      </th>
                      <th class="">Sort Order</th>
                      <th>Published on</th>
                      <th>Last Updated on</th>
                      <th class="no-sort" data-col="11">Status
                        <select multiple class="form-control multi-dd">
                          <option value="published">Published</option>
                          <option value="draft">Draft</option>
                          <option value="archived">Archived</option>
                        </select>
                      </th>
                      <th>id</th>
                      <th>level</th>
                      <th>parent id</th>
                      <th>branch id</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                      <td><a href="#" class="dt-link">Meat</a> <img src="../public/img/meat.png" width="20" alt="" class="img-circle"></td>
                      <td class="text-center"><i class="fa fa-check text-success"></i></td>
                      <td class="text-center">-</td>
                      <td class="text-center">-</td>
                      <td>Sea Foods</td>
                      <td>-</td>
                      <td>-</td>
                      <td>1</td>
                      <td>2017/06/05</td>
                      <td>2017/06/05</td>
                      <td>Published</td>
                    </tr>
                    <tr>
                      <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                      <td><a href="#" class="dt-link">Chicken Distributors</a></td>
                      <td class="text-center">-</td>
                      <td class="text-center"><i class="fa fa-check text-success"></i></td>
                      <td class="text-center">-</td>
                      <td>Meat</td>
                      <td>-</td>
                      <td>-</td>
                      <td>2</td>
                      <td>-</td>
                      <td>2017/06/12</td>
                      <td>Draft</td>
                    </tr>
                    <tr>
                      <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                      <td><a href="#" class="dt-link">Venky's</a></td>
                      <td class="text-center">-</td>
                      <td class="text-center">-</td>
                      <td class="text-center"><i class="fa fa-check text-success"></i></td>
                      <td>Meat</td>
                      <td>Chicken Distributors</td>
                      <td>-</td>
                      <td>2</td>
                      <td>2017/06/05</td>
                      <td>2017/07/31</td>
                      <td>Archived</td>
                    </tr>
                    <tr>
                      <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                      <td><a href="#" class="dt-link">Milk Products</a></td>
                      <td class="text-center"><i class="fa fa-check text-success"></i></td>
                      <td class="text-center">-</td>
                      <td class="text-center">-</td>
                      <td>-</td>
                      <td>-</td>
                      <td>-</td>
                      <td>3</td>
                      <td>2017/06/05</td>
                      <td>2017/06/20</td>
                      <td>Published</td>
                    </tr>
                    <tr>
                      <td><a href="#"><i class="fa fa-pencil"></i></a></td>
                      <td><a href="#" class="dt-link">Sea Foods</a></td>
                      <td class="text-center"><i class="fa fa-check text-success"></i></td>
                      <td class="text-center">-</td>
                      <td class="text-center">-</td>
                      <td>-</td>
                      <td>-</td>
                      <td>-</td>
                      <td>4</td>
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


@endsection