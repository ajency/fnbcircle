@extends('add-listing')

@section('form-data')

<!-- Success message -->
@if(isset($_GET['success']) and $_GET['success']=='true') <div class="alert fnb-alert alert-success alert-dismissible fade in " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    The details have been saved successfully.
</div>
@endif

<div class="business-cats tab-pane fade in active" id="business_categories">
    <h5 class="no-m-t main-heading">Business Categories</h5>

    <div class="m-t-30 add-container c-gap @if($listing->isReviewable()) hidden @endif" id="no-categ-select">
        <label class="label-size">Select categories your listing belongs to <span class="text-primary">*</span></label>
        <div class="text-lighter m-t-5">
            One category at a time
        </div>
        <ul class="interested-options cat-select flex-wrap flex-row m-t-30">
           @foreach($parents as $category)
            <li class="topSelect" data-toggle="modal" data-target="#category-select">
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
        <div id="no-categ-error" class="hidden">At least one category should be added for a business.</div>   
    </div>


    <div class="m-t-30 c-gap addedCat @if(!$listing->isReviewable()) hidden @endif" id="categ-selected">

        <label class="label-size">List of all the categories for your listing</label>
        <div id="categories" class="node-list">
        @foreach ($categories as $branchID => $branch)
            <div class="single-category gray-border add-more-cat m-t-15"><div class="row flex-row categoryContainer"><div class="col-sm-4 flex-row"><img class="import-icon cat-icon" src="{{$branch['image-url']}}"></img><div class="branch-row"><div class="cat-label">{{$branch['parent']}}</div></div></div><div class="col-sm-2"><strong class="branch">{{$branch['branch']}}</strong></div><div class="col-sm-6"> <ul class="fnb-cat small flex-row" id="view-categ-node">
            @foreach ($categories[$branchID]['nodes'] as $nodeID => $node)
            <li><span class="fnb-cat__title">{{$node['name']}}<input type=hidden name="categories" value="{{$nodeID}}" data-item-name="{{$node['name']}}"> <span class="fa fa-times remove"></span></span></li>
            @endforeach
            </ul></div> </div><div class="delete-cat"><span class="fa fa-times remove"></span></div></div>
        @endforeach
        </div>
        
        <!-- <div class="test">test</div> -->


        <div class="m-t-20">
            <a href="#category-select" data-toggle="modal" data-target="#category-select" name="add_categories" class="dark-link heavier">+ Add/Edit more categories</a>
        </div>
    </div>
    <div class="m-t-50 c-gap core-cat-cont @if(!$listing->isReviewable()) hidden @endif">
        <label class="required label-size">Core categories of your listing</label>
        <div class="text-lighter m-t-5">
            Note: Core categories will be displayed prominently on the listing. Maximum 10 core categories allowed
            <br> Please select your core categories from the following categories.
        </div>
        <div class="m-t-20">
            <!-- <input type="text" class="form-control fnb-input flexdatalist" placeholder="+ Add more core categories" multiple="multiple" data-min-length="0" value="Al Kabeer, Pandiyan, Ezzy, Royco, Venkys" data-selection-required="1" list="core_categories">
            <datalist id="core_categories">
                <option value="Al Kabeer">Al Kabeer</option>
                <option value="Pandiyan">Pandiyan</option>
                <option value="Ezzy">Ezzy</option>
                <option value="Royco">Royco</option>
            </datalist> -->
            <ul class="fnb-cat small core-selector flex-row">
            @foreach ($categories as $branchID => $category)
                @foreach ($category['nodes'] as $node)
                     <li><input type="checkbox" data-parsley-required data-parsley-multiple="core_categ" data-parsley-mincheck=1 data-parsley-maxcheck=10 data-parsley-maxcheck-message="Core categories cannot be more than 10." data-parsley-required-message="At least one core category should be selected for a business." class="checkbox core-cat-select" id="cat-label-{{$node['id']}}" value="{{$node['id']}}" @if ($node['core'] == '1') checked="checked" @endif ><label class="core-selector__label m-b-0" for="cat-label-{{$node['id']}}"><span class="fnb-cat__title text-medium">{{$node['name']}}</span></label></span></li>
                @endforeach
            @endforeach
                
                <!-- <li><input type="checkbox" class="checkbox core-cat-select" id="cat-label" checked=""><label class="core-selector__label m-b-0" for="cat-label"><span class="fnb-cat__title text-medium">Al Kabeer </span></label></span>
                </li>
                <li><input type="checkbox" class="checkbox core-cat-select" id="cat-label-2"><label class="core-selector__label m-b-0" for="cat-label-2"><span class="fnb-cat__title text-medium">Pandiyan </span></label></span>
                </li>
                <li><input type="checkbox" class="checkbox core-cat-select" id="cat-label-3"><label class="core-selector__label m-b-0" for="cat-label-3"><span class="fnb-cat__title text-medium">Ezzy </span></label></span>
                </li>
                <li><input type="checkbox" class="checkbox core-cat-select" id="cat-label-4"><label class="core-selector__label m-b-0" for="cat-label-4"><span class="fnb-cat__title text-medium">Royco </span></label></span>
                </li>
                <li><input type="checkbox" class="checkbox core-cat-select" id="cat-label-5"><label class="core-selector__label m-b-0" for="cat-label-5"><span class="fnb-cat__title text-medium">Venkys </span></label></span>
                </li>
 -->                <!--
                <li class="more-show desk-hide"><span class="fnb-cat__title text-secondary">+10 more</span></li> -->
            </ul>
        </div>
    </div>
    <div class="m-t-40 c-gap">
        <label class="label-size">List some brands that you deal with</label>
        <!-- <div class="text-lighter m-t-5">
            Ex: Albertsons, America's Choice, Bashas
        </div> -->

        <div class="m-t-5 brands-container">
            <input type="text" class="form-control fnb-input brand-list" placeholder="Type and hit enter" list="brands" multiple="multiple" id=brandsinput value="{{$listing->tagNames}}">
            <datalist id="brands">
            @foreach ($brands as $brand)
            <option value = "{{$brand->slug}}">{{$brand->name}}</option>
            @endforeach
            </datalist>
        </div>
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
                            <button class="hidden btn fnb-btn outline border-btn no-border mobileCat-back" type="button" data-dismiss="modal"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i> Back</button>
                            <button class="btn fnb-btn outline border-btn no-border category-back" type="button"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i> Back</button>
                        </div>
                        <div class="level-two">
                            <a href="#" data-dismiss="modal" class="btn fnb-btn text-color m-l-5 cat-cancel text-color">&#10005;</a>
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
                            <h5 class="text-medium element-title">Select categories your listing belongs to <span class="text-primary">*</span></h5>
                            <div class="text-lighter">
                                One category at a time
                            </div>
                        </div>
                        <ul class="interested-options catOptions cat-select flex-row m-t-45">
                            <!-- <li>
                                <input type="radio" class="radio level-two-toggle" name="categories" data-name="Cereals &amp; Food Grains">
                                <div class="veg option flex-row">
                                    <img src="https://freeiconshop.com/wp-content/uploads/edd/cheese-solid.png" />
                                </div>
                                <div class="interested-label">
                                    Cereals &amp; Food Grains
                                </div>
                            </li> -->
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
                        <!-- <div class="mobile-back flex-row m-b-10">
                            <div class="back">
                                 <button class="btn fnb-btn outline border-btn no-border sub-category-back"><i class="fa fa-arrow-left p-r-5" aria-hidden="true"></i> Back</button>
                            </div>
                            <button class="btn fnb-btn outline border-btn">save</button>
                        </div> -->
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
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs flex-row mobile-hide categ-list" role="tablist">
                               <!--  <li role="presentation" class="active"><a href="#chicken" aria-controls="chicken" role="tab" data-toggle="tab">Chicken</a></li>
                                <li role="presentation"><a href="#mutton" aria-controls="mutton" role="tab" data-toggle="tab">Mutton</a></li>
                                <li role="presentation"><a href="#pork" aria-controls="pork" role="tab" data-toggle="tab">Pork</a></li>
                                <li role="presentation"><a href="#beef" aria-controls="beef" role="tab" data-toggle="tab">Beef</a></li>
                                <li role="presentation"><a href="#halal" aria-controls="halal" role="tab" data-toggle="tab">Halal meat</a></li>
                                <li role="presentation"><a href="#rabbit" aria-controls="rabbit" role="tab" data-toggle="tab">Rabbit meat</a></li>
                                <li role="presentation"><a href="#sheep" aria-controls="sheep" role="tab" data-toggle="tab">Sheep meat</a></li>
                                <li role="presentation"><a href="#cured" aria-controls="cured" role="tab" data-toggle="tab">Cured meat</a></li>
                                <li role="presentation"><a href="#knuckle" aria-controls="knuckle" role="tab" data-toggle="tab">Knuckle meat</a></li> -->
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content cat-dataHolder mobile-categories relative">
                                <!-- mobile collapse -->
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
                    <!-- <div class="ball"></div> -->
                </div>
            </div>
        </div>
    
    <script type="text/javascript">
        var categories = {'categories': []};
        @foreach ($categories as $branchID => $category)
            categories['categories'][{{$branchID}}]={
                "branch" : "{{$category['branch']}}", 
                "image-url" : "{{$category['image-url']}}", 
                "parent" : "{{$category['parent']}}" ,
                "nodes" : []
            };
            @foreach ($category['nodes'] as $node)
                categories['categories'][{{$branchID}}]['nodes'].push({"id": "{{$node['id']}}", "name":"{{$node['name']}}"});
            @endforeach
        @endforeach
    </script>
@endsection