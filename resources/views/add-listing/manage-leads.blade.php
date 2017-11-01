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
    <script type="text/javascript" src="/js/categories.js"></script>
    <!-- Datatables -->
    <script src="{{ asset('/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="/js/listing-lead.js"></script>
@endsection
@section('form-data')

@section('meta')
  <meta property="listing-enquiry" content="{{action('AdminEnquiryController@displaylistingEnquiries')}}">
@endsection

<div class="business-info  post-update tab-pane fade in active business-leads" id="my-leads">
    <h5 class="no-m-t fly-out-heading-size main-heading white m-t-0 margin-btm flex-row space-between preview-detach post-up-head align-top">
    <div class="flex-row space-between">
        <img src="/img/post-update.png" class="img-responsive mobile-hide m-r-15" width="60">
        <div>My Leads
            <span class="dis-block xxx-small lighter m-t-10 post-caption">List of all contact requests and enquiries to {{$listing->title}}.</span>
        </div>
        
    </div>
    </h5>
    



<div class="row">
    <div class="col-sm-2">
        <div class="filter-trigger">
            <button class="btn fnb-btn primary-btn border-btn fullwidth default-size" data-toggle="collapse" href="#collapsefilter" aria-expanded="false" aria-controls="collapsefilter"><i class="fa fa-filter" aria-hidden="true"></i> Filter</button>
        </div>
    </div>
</div>


<div class="row m-t-20 lead-filter collapse" id="collapsefilter">
    <div class="col-sm-6">
        <div class="m-b-20">
            <p class="text-color x-small text-uppercase">Type</p>
            <div class="flex-row flex-wrap m-t-20">
                <label class="flex-row text-lighter m-r-15 text-medium cursor-pointer"><input type="checkbox" class="checkbox"> <div class="">Direct Enquiry</div></label>
                <label class="flex-row text-lighter m-r-15 text-medium cursor-pointer"><input type="checkbox" class="checkbox"> <div class="">Shared Enquiry</div></label>
                <label class="flex-row text-lighter text-medium cursor-pointer"><input type="checkbox" class="checkbox"> <div class="">Contact Request</div></label>
            </div>
        </div>
        
    </div>
    <div class="col-sm-6">
        <div>
            <p class="text-color x-small text-uppercase">Request send date</p>
            <input type="text" class="form-control fnb-input requestDate default-size" placeholder="Request Date">
        </div>
    </div>
    <div class="col-sm-12">
        <div>
            <p class="text-color x-small text-uppercase">Categories</p>
            <div class="category-listing m-b-10">
                <div class="single-category gray-border add-more-cat m-t-15">
                    <div class="row flex-row categoryContainer corecat-container">
                        <div class="col-sm-4 flex-row">
                            <img class="import-icon cat-icon" src="https://fnbcircle.s3.ap-south-1.amazonaws.com/Categories/1/images/1507374184/1-65x65.png">
                            <div class="branch-row">
                                <div class="cat-label">Fish&amp;Meat</div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <strong class="branch">Meat</strong>
                        </div>
                        <div class="col-sm-6">
                            <ul class="fnb-cat small flex-row" id="view-categ-node">
                                <li><span class="fnb-cat__title">Lamb Mutton<input type="hidden" name="categories" value="10" data-item-name="Lamb Mutton"> <span class="fa fa-times remove"></span></span></li>
                                <li><span class="fnb-cat__title">Mutton<input type="hidden" name="categories" value="11" data-item-name="Mutton"> <span class="fa fa-times remove"></span></span></li>
                            </ul>
                        </div> 
                    </div>
                    <div class="delete-cat">
                        <span class="fa fa-times remove"></span>
                    </div>
                </div>
            </div>
            <div class="flex-row flex-wrap add-filter-actions">
                <a href="#" class="secondary-link x-small m-r-5" data-toggle="modal" data-target="#category-select">+ Add Parent</a>    
                <a href="#" class="secondary-link x-small m-r-5">+ AddBranch</a>
                <a href="#" class="secondary-link x-small">+ Add Node</a>    
            </div>
        </div>
    </div>
    <div class="col-sm-12 m-t-20">
        <div>
            <p class="text-color x-small text-uppercase">Location</p>
            <div class="category-listing m-b-10">
                <div class="single-category gray-border add-more-cat m-t-15">
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
                </div>
            </div>
            <div class="flex-row flex-wrap add-filter-actions">
                <a href="#" class="secondary-link x-small m-r-5">+ Add State</a>    
                <a href="#" class="secondary-link x-small m-r-5">+ Add City</a>      
            </div>
        </div>
    </div>
    <div class="col-sm-12 m-t-10">
        <div class="leads-filter-action flex-row">
            <a href="#" class="clear-link dis-block text-decor m-r-15">Clear All</a>
            <button class="btn primary-btn border-btn fnb-btn" type="button" id="">Apply Category</button>
        </div>
    </div>
</div>


    <div class="m-t-50">

    <table id="listing-leads" class="table table-striped listing-lead" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="no-sort" style="min-width: 90px;">Type</th>
                <th class="width-control" style="min-width: 80px;width: 130px !important;">Name</th>
                <th class="width-control" style="min-width: 80px;width: 130px !important;">Email</th>
                <th class="width-control" style="min-width: 80px;width: 130px !important;">Phone</th>
                <th style="min-width: 80px">What describes you the best?</th>
                <th style="min-width: 90px;">Action</th>
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
                <th style="min-width: 80px;"></th>
                <th style="min-width: 90px;">
                    <label class="flex-row show-archive"><input type="checkbox" class="checkbox" id="archivefilter"> Show archive</label>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
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
            </tr>
        </tbody>
    </table> 




    </div>


    

</div>





<!-- Category modal -->

 <div class="modal fnb-modal category-modal multilevel-modal fade" id="category-select" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
        </div>

@endsection