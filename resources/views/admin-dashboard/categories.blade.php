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
                        <select multiple class="form-control multi-dd" >
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
                          <select multiple class="form-control multi-dd" id="filterparents">
                            @foreach($parents as $parent)
                            <option>{{$parent->name}}</option>
                            @endforeach
                          </select>
                      </th>
                      <th class="no-sort" data-col="7">
                        Branch
                        <select multiple class="form-control multi-dd" id="filterbranches">
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
              <form id="categoryForm">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h6 class="modal-title">Add New Category</h6>
                </div>
                <div class="modal-body">
                  <label>Type of Category <span class="text-danger">*</span></label>
                  <div class="form-group flex flex-space-between">
                    <label class="radio-inline">
                      <input type="radio" name="categoryType" id="parent_cat" value="1" class="fnb-radio" checked required=""> Parent Category
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="categoryType" id="branch_cat" value="2" class="fnb-radio"> Branch Category
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="categoryType" id="node_cat" value="3" class="fnb-radio"> Node Category
                    </label>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group select-parent-cat hidden">
                        <label>Select Parent Category <span class="text-danger">*</span></label>
                        <select class="form-control fnb-select w-border" id="allparents">
                            <option value="">Select Parent</option>
                          @foreach($parents as $parent)
                            <option value="{{$parent->id}}">{{$parent->name}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group select-branch-cat hidden">
                        <label>Select Branch Category <span class="text-danger">*</span></label>
                        <select class="form-control fnb-select w-border">
                          <option value="">Select Branch</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label><div class="dis-inline namelabel"></div> Category Name  <span class="text-danger">*</span></label>
                    <input type="text" class="form-control fnb-input" name="name" placeholder="Enter a Category name" required="">
                  </div>

                  <div class="form-group">
                    <label><div class="dis-inline namelabel"></div> Category Slug  <span class="text-danger">*</span></label>
                    <input type="text" class="form-control fnb-input" name="slug" placeholder="Enter the Category Slug" required="" data-parsley-slug>
                  </div>

                  <div class="form-group parent_cat_icon">
                    <label>Icon  <span class="text-danger">*</span></label>
                    <input type="file" name="">
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Sort Order  <span class="text-danger">*</span></label>
                        <input type="number" class="form-control fnb-input" name="order" value="1" min="1" placeholder="Enter a Sort value" required="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control fnb-select w-border" required>
                          <option value="">Select</option>
                          <option value="0">Draft</option>
                          <option value="1">Published</option>
                          <option value="2">Archived</option>
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

<!-- edit Category Modal -->
        <div class="modal fade" id="edit_category_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form id="categoryForm">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h6 class="modal-title">Edit Category</h6>
                </div>
                <input type="hidden" name="id">
                <div class="modal-body">
                  <label>Type of Category <span class="text-danger">*</span></label>
                  <div class="form-group flex flex-space-between">
                    <label class="radio-inline">
                      <input type="radio" name="categoryType" id="parent_cat" value="1" class="fnb-radio" checked required=""> Parent Category
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="categoryType" id="branch_cat" value="2" class="fnb-radio"> Branch Category
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="categoryType" id="node_cat" value="3" class="fnb-radio"> Node Category
                    </label>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group select-parent-cat hidden">
                        <label>Select Parent Category <span class="text-danger">*</span></label>
                        <select class="form-control fnb-select w-border" id="allparents">
                            <option value="">Select Parent</option>
                          @foreach($parents as $parent)
                            <option value="{{$parent->id}}">{{$parent->name}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group select-branch-cat hidden">
                        <label>Select Branch Category <span class="text-danger">*</span></label>
                        <select class="form-control fnb-select w-border">
                          <option value="">Select Branch</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label><span class="namelabel"></span> Category Name  <span class="text-danger">*</span></label>
                    <input type="text" class="form-control fnb-input" name="name" placeholder="Enter a Category name" required="">
                  </div>

                  <div class="form-group">
                    <label><span class="namelabel"></span> Category Slug  <span class="text-danger">*</span></label>
                    <input type="text" class="form-control fnb-input" name="slug" placeholder="Enter the Category Url" required="" data-parsley-slug>
                  </div>

                  <div class="form-group parent_cat_icon">
                    <label>Icon  <span class="text-danger">*</span></label>
                    <input type="file" name="">
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Sort Order  <span class="text-danger">*</span></label>
                        <input type="number" class="form-control fnb-input" name="order" value="1" min="1" placeholder="Enter a Sort value" required="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control fnb-select w-border" required>
                          <option value="">Select</option>
                          <option value="0">Draft</option>
                          <option value="1">Published</option>
                          <option value="2">Archived</option>
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