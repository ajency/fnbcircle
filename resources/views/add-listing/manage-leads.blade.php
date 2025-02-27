
@extends('layouts.add-listing')
@section('css')
    @parent
    <!-- Datatables -->
    <link href="{{ asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection
@section('js')
    @parent
    <script type="text/javascript" src="/js/underscore-min.js" ></script>
    <!-- Datatables -->
    <script src="{{ asset('/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/category_select_modal.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/categories_select_leads.js') }}"></script>
    <script type="text/javascript" src="/js/listing-lead.js"></script>
@endsection

@section('meta')
  <meta property="listing-enquiry" content="{{action('AdminEnquiryController@displaylistingEnquiries')}}">
  <meta property="listing-enquiry-archive" content="{{action('AdminEnquiryController@archiveEnquiry')}}">
  <meta property="listing-enquiry-unarchive" content="{{action('AdminEnquiryController@unarchiveEnquiry')}}">
@endsection


@section('form-data')

<div class="alert fnb-alert alert-success alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <div class="flex-row">
        <i class="fa fa-check-circle" aria-hidden="true"></i>
        <span class="message"></span>
    </div>
</div>

<div class="business-info  post-update tab-pane fade in active business-leads" id="manage-leads">
    <h5 class="no-m-t fly-out-heading-size main-heading white m-t-0 margin-btm flex-row space-between preview-detach post-up-head align-top">
    <div class="flex-row space-between">
        <img src="/img/post-update.png" class="img-responsive mobile-hide m-r-15" width="60">
        <div>My Leads
            <span class="dis-block xxx-small lighter m-t-10 post-caption">List of all contact requests and enquiries to {{$listing->title}}.</span>
        </div>
        
    </div>
    </h5>
    


<!-- listing summary section -->

<!-- <div class="row">
    <div class="col-sm-12">
        <div class="update-sec sidebar-article listing-summary-row"> 
            <div class="update-sec__body update-space"> 
                <div class="flex-row space-between"> 
                    <p class="element-title update-sec__heading m-t-15 bolder">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta explicabo esse dolorum officia molestiae est provident quidem itaque possimus asperiores!</p>
                </div>
                 <p class="update-sec__caption text-lighter">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn'</p>
                 <p class="m-b-0 posted-date text-secondary flex-row"><i class="fa fa-clock-o sub-title p-r-5" aria-hidden="true"></i> Your last update was 12 hours ago</p> 
            </div>
         </div>
         <div class="post-update-row flex-row space-between">
             <p class="m-b-0 grey-darker">Recently updated listings usually get more Leads. <br> Go ahead and post an update.</p>
             <button class="btn fnb-btn primary-btn full post-btn" id="" type="button">Post</button>
         </div>
    </div>
</div>


<div class="row m-t-20">
    <div class="col-sm-12">
        <div class="listing-stats">
            <div class="listing-stats__header">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="m-t-0 list-stat-title">Listing Stats</h4>
                    </div>
                    <div class="col-sm-7">
                        <div class="flex-row period-filter space-between flex-wrap align-top">
                            <p class="m-b-0 default-size text-color title p-r-10">Filter your stats for a particular time period</p>   
                            <div class="relative date-icon">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <input type="text" class="form-control fnb-input requestDate stat-filter default-size" placeholder="Request Date" id="submissionDate">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="listing-stats__body flex-row flex-wrap m-t-40 align-full">
                <div class="list-cols views">
                    <p class="default-size text-uppercase text-color heavier">Views</p>
                    <h3 class="m-t-15 heavier">50</h3>
                    <p class="text-lighter default-size">By default displays the number of views in the last 30 days.</p>
                </div>
                <div class="list-cols views">
                    <p class="default-size text-uppercase text-color heavier">Contact requests</p>
                    <h3 class="m-t-15 heavier">4</h3>
                    <p class="text-lighter default-size">Number of requests sent for the contact details of the listing.</p>
                </div>
                <div class="list-cols views">
                    <p class="default-size text-uppercase text-color heavier">Direct enquiries</p>
                    <h3 class="m-t-15 heavier">0</h3>
                    <p class="text-lighter default-size">Number of direct enquiries sent to this listing. <a href="#" class="x-small primary-link">View</a></p>
                </div>
                <div class="list-cols views">
                    <p class="default-size text-uppercase text-color heavier">Indirect enquiries</p>
                    <h3 class="m-t-15 heavier">4</h3>
                    <p class="text-lighter default-size">Number of indirect enquiries sent to this listing based on the category and area the listing belongs to. <a href="#" class="x-small primary-link">View</a></p>
                </div>
            </div>
        </div>
    </div>
</div> -->


<!-- listing summary section ends -->







<div class="row">
    <div class="col-sm-2 p-l-0">
        <div class="filter-trigger">
            <button class="btn fnb-btn outline border-btn fullwidth default-size" data-toggle="collapse" href="#collapsefilter" aria-expanded="false" aria-controls="collapsefilter"><i class="fa fa-filter" aria-hidden="true"></i> Filter</button>
        </div>
    </div>
</div>


<div class="row m-t-20 lead-filter collapse" id="collapsefilter">
    <div class="col-sm-6">
        <div class="m-b-20">
            <p class="text-color x-small text-uppercase">Type</p>
            <div class="flex-row flex-wrap m-t-20">
                <label class="flex-row text-lighter m-r-15 text-medium cursor-pointer"><input type="checkbox" class="checkbox type-filter" value="direct"> <div class="">Direct Enquiry</div></label>
                <label class="flex-row text-lighter m-r-15 text-medium cursor-pointer"><input type="checkbox" class="checkbox type-filter" value="shared"> <div class="">Shared Enquiry</div></label>
                <label class="flex-row text-lighter text-medium cursor-pointer"><input type="checkbox" class="checkbox type-filter" value="contact-request"> <div class="">Contact Request</div></label>
            </div>
        </div>
        
    </div>
    <div class="col-sm-6 c-gap">
        <div>
            <p class="text-color x-small text-uppercase flex-row space-between">Request send date  <a id="clearSubDate" href="#" class="primary-link">Clear</a> </p>
            <input type="text" class="form-control fnb-input requestDate default-size" placeholder="Request Date" id="submissionDate">
        </div>
    </div>
    <div class="col-sm-12 c-gap">
        <div>
            <p class="text-color x-small text-uppercase">Categories</p>
            <div class="category-listing m-b-10">
                 <input type="hidden" id="modal_categories_chosen" name="modal_categories_chosen" value="[]">
                 <input type="hidden" id="modal_categories_hierarchy_chosen" value="[]">
                      <div id="categories" class="node-list"></div>
            </div>
            <div class="flex-row flex-wrap add-filter-actions">
                 <a href="#category-select" data-toggle="modal" data-target="#category-select" class="primary-link x-small" id="select-more-categories">+ Filter based on Categories</a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 c-gap m-t-20">
        <div>
            <p class="text-color x-small text-uppercase">Location</p>
            <div class="category-listing m-b-10">
                <!-- <div class="single-category gray-border add-more-cat m-t-15">
                    <div class="row flex-row categoryContainer corecat-container">
                        <div class="col-sm-2 flex-row">
                            <div class="branch-row">
                                <div class="cat-label">Goa</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <ul class="fnb-cat small flex-row" id="view-categ-node">
                                <li><span class="fnb-cat__title">Panjim<input type="hidden" name="categories" value="10" data-item-name="Lamb Mutton"> <span class="fa fa-times remove"></span></span></li>
                                <li><span class="fnb-cat__title">Mapusa<input type="hidden" name="categories" value="11" data-item-name="Mutton"> <span class="fa fa-times remove"></span></span></li>
                            </ul>
                        </div> 
                    </div>
                    <div class="delete-cat">
                        <span class="fa fa-times remove"></span>
                    </div>
                </div> -->
                @include('modals.location_select.display')
            </div>
            <div class="flex-row flex-wrap add-filter-actions">
                <a href="#area-select" data-target="#area-select" data-toggle="modal" class="primary-link x-small m-r-5" id="area-modal-link">+ Add Location</a>    
            </div>
        </div>
    </div>
    <div class="col-sm-12 c-gap m-t-10">
        <div class="leads-filter-action flex-row">
            <a href="#" class="dark-link dis-block text-decor m-r-15" id="clearAllFilters">Clear All</a>
            <button class="btn primary-btn border-btn fnb-btn" type="button" id="applyLocFilter">Apply Location</button>
            <button class="btn primary-btn border-btn fnb-btn" type="button" id="applyCategFilter">Apply Category</button>
        </div>
    </div>
</div>


    <div class="m-t-50 relative leads-tab-section">

    <table id="listing-leads" class="table table-striped listing-lead" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="no-sort" style="min-width: 110px;">Type</th>
                <th class="width-control" style="min-width: 80px;width: 130px !important;">Name</th>
                <th class="width-control" style="min-width: 80px;width: 130px !important;">Email</th>
                <th class="width-control" style="min-width: 80px;width: 130px !important;">Phone</th>
                <th style="min-width: 160px">What describes you the best?</th>
                <th style="min-width: 5px;"></th>
                <th style="min-width: 30px;">Action</th>
            </tr>
            <tr class="search-row">
                <th style="min-width: 90px;"></th>
                <th class="width-control" style="min-width: 80px;width: 80px !important;">
                    <div class="tableSearch">
                        <i class="fa fa-search text-lighter" aria-hidden="true"></i>
                        <input type="text" class="form-control fnb-input" placeholder="Search" id="namefilter">
                    </div>
                </th>
                <th class="width-control" style="min-width: 80px;">
                    <div class="tableSearch">
                        <i class="fa fa-search text-lighter" aria-hidden="true"></i>
                        <input type="text" class="form-control fnb-input" placeholder="Search" id="emailfilter">
                    </div>
                </th>
                <th class="width-control" style="min-width: 80px;">
                    <div class="tableSearch">
                        <i class="fa fa-search text-lighter" aria-hidden="true"></i>
                        <input type="text" class="form-control fnb-input" placeholder="Search" id="phonefilter">
                    </div>
                </th>
                <th style="min-width: 40px;"></th>
                <th style="">
                    
                </th>
                <th style="min-width: 120px;">
                    <label class="flex-row show-archive"><input type="checkbox" class="checkbox" id="archivefilter"> Show archive</label>
                </th>
            </tr>
        </thead>
        <tbody>
            <!-- <tr>
                <td>
                    <label class="fnb-label text-secondary m-b-5">Direct Enquiry</label><br>
                    Request sent on 10 oct 2017
                </td>
                <td>Namrata Desai</td>
                <td>namdes@gmail.com</td>
                <td>9878738444 <img src="/img/verified.png" class="lead-verify" width="12"></td>
                <td>Working Professional<br> Business Owner</td>
                <td class="details-control text-secondary cursor-pointer"><div class="rating"><div class="bg"></div><div class="value" style="width: 0;"></div></div><span class="more-less-text">More details</span> <i class="fa fa-angle-down text-color" aria-hidden="true"></i></td>
            </tr>
            <tr>
                <td>
                    <label class="fnb-label text-primary m-b-5">Shared Enquiry</label><br>
                    Request sent on 10 oct 2017
                </td>
                <td>Namrata Desai</td>
                <td>test@gmail.com <img src="/img/verified.png" class="lead-verify" width="12"></td>
                <td>9878738444 <img src="/img/verified.png" class="lead-verify" width="12"></td>
                <td>Working Professional<br> Business Owner</td>
                <td class="details-control text-secondary cursor-pointer"><div class="rating"><div class="bg"></div><div class="value" style=""></div></div><span class="more-less-text">More details</span> <i class="fa fa-angle-down text-color" aria-hidden="true"></i></td>
            </tr>
            <tr>
                <td>
                    <label class="fnb-label fnb-info-text m-b-5">Contact Enquiry</label><br>
                    Request sent on 10 oct 2017
                </td>
                <td>Namrata Desai</td>
                <td>lorem@gmail.com <img src="/img/verified.png" class="lead-verify" width="12"></td>
                <td>9878738444 <img src="/img/verified.png" class="lead-verify" width="12"></td>
                <td>Working Professional<br> Business Owner</td>
                <td class="details-control text-secondary cursor-pointer"><div class="rating"><div class="bg"></div><div class="value" style="width: 0;"></div></div><span class="more-less-text">More details</span> <i class="fa fa-angle-down text-color" aria-hidden="true"></i></td>
            </tr> -->
        </tbody>
    </table> 




    </div>


    

</div>


<!-- archive confirmation modal -->

<div class="modal fnb-modal confirm-box fade modal-center" id="enquiryarchive" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="text-medium m-t-0 bolder">Confirm</h5>
          </div>
          <div class="modal-body text-center">
              <div class="listing-message">
                  <h4 class="element-title text-medium text-left text-color">Are you sure you want to archive this enquiry?</h4>
              </div>  
              <div class="confirm-actions text-right">
                  <a href="#" class="archive-enquiry-confirmed" > <button class="btn fnb-btn text-primary border-btn no-border"  data-dismiss="modal">Archive</button></a>
                    <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal" id="cancelenquiryarchive">Cancel</button>
              </div>
          </div>
          <!-- <div class="modal-footer">
              <button class="btn fnb-btn outline cancel-modal border-btn" data-dismiss="modal">Close</button>
          </div> -->
      </div>
  </div>
</div>


@include('modals.location_select.popup')


<!-- Category modal -->

 <!-- <div class="modal fnb-modal category-modal multilevel-modal fade" id="category-select" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="level-one mobile-hide firstStep">
                        <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                    </div>
                    <div class="mobile-back flex-row">
                        <div class="back">
                            <button class="desk-hide btn fnb-btn outline border-btn no-border mobileCat-back" type="button" data-dismiss="modal"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i> Back</button>
                            <button class="btn fnb-btn outline border-btn no-border category-back mobile-hide" type="button"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i> Back to Category</button>
                        </div>
                        <div class="level-two">
                            <a href="#" data-dismiss="modal" class="mobile-hide btn fnb-btn text-color m-l-5 cat-cancel text-color">&#10005;</a>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="main-category level-one m-l-30 m-r-30 m-b-30">

                        <div class="add-container text-center">
                            <h5 class="text-medium element-title">Select categories your listing belongs to <span class="text-primary">*</span></h5>
                            <div class="text-lighter">
                                One category at a time
                            </div>
                        </div>
                        <ul class="interested-options catOptions cat-select flex-row m-t-45">
      
                           @foreach($parents as $category)
                            <li class="catSelect-click">
                                <input type="radio" class="radio level-two-toggle" name="categories" data-name="{{$category->name}}" value="{{$category->id}}">
                                <div class="option flex-row">
                                    <img class="import-icon cat-icon" src="{{$category->icon_url}}" />
                                </div>
                                <div class="interested-label">
                                    {{$category->name}}
                                </div>
                            </li>
                           @endforeach
                        </ul>
                    </div>
                    <div class="sub-category level-two">
          
                        <div class="instructions flex-row space-between">
                            <div class="cat-name flex-row">
                                <span class="fnb-icons cat-icon meat m-r-15"></span>
                                <div>
                                    <p class="instructions__title bat-color default-size">Please choose the sub categories under "<span class="main-cat-name">Meat &amp; Poultry</span>"</p>
                                    <h5 class="sub-title cat-title bat-color main-cat-name">Meat &amp; Poultry</h5>
                                </div>
                            </div>
                            <div>
                                <button id="category-select" class="btn fnb-btn outline border-btn re-save" type="button" data-dismiss="modal">save</button>
                            </div>
                        </div>
                        <div class="node-select flex-row">
                            
                            <ul class="nav nav-tabs flex-row mobile-hide categ-list" role="tablist">
                         
                            </ul>
                            
                            <div class="tab-content cat-dataHolder mobile-categories relative">
                               
                                <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#chicken" aria-expanded="false" aria-controls="chicken">Chicken <i class="fa fa-angle-down" aria-hidden="true"></i></div>
                                <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#mutton" aria-expanded="false" aria-controls="mutton">
                                    Mutton <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </div>
                                <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#pork" aria-expanded="false" aria-controls="pork">
                                    Pork <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </div>
                                <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#beef" aria-expanded="false" aria-controls="beef">
                                    Beef <i class="fa fa-angle-down" aria-hidden="true"></i>
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
                                    </ul>
                                </div>

                                <div role="tabpanel" class="tab-pane collapse" id="mutton">Mutton</div>

                                <div role="tabpanel" class="tab-pane collapse" id="pork">Pork</div>

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
                </div>
                <div class="modal-footer mobile-hide">
                    <div class="sub-category hidden">
                        <button class="btn fnb-btn outline full border-btn" type="button">save</button>
                    </div>
                </div>
                <div class="site-loader full-modal hidden">
                    <div id="floatingBarsG">
                        <div class="blockG" id="rotateG_01"></div>
                        <div class="blockG" id="rotateG_02"></div>
                        <div class="blockG" id="rotateG_03"></div>
                        <div class="blockG" id="rotateG_04"></div>
                        <div class="blockG" id="rotateG_05"></div>
                        <div class="blockG" id="rotateG_06"></div>
                        <div class="blockG" id="rotateG_07"></div>
                        <div class="blockG" id="rotateG_08"></div>
                    </div>
                    
                </div>
            </div>
        </div> -->

@endsection