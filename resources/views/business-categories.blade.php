@extends('add-listing')

@section('form-data')

<!-- Success message -->
@if(isset($_GET['success']) and $_GET['success']=='true') <div class="alert fnb-alert alert-success alert-dismissible fade in " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    Success!!! You're information has been saved.
</div>
@endif

<div class="business-cats tab-pane fade in active" id="business_categories">
    <h5 class="no-m-t main-heading">Business Categories</h5>
    <div class="m-t-30 c-gap">
        <label class="label-size">List of all the categories for your listing</label>
        <div class="single-category gray-border">
            <div class="row flex-row categoryContainer">
                <div class="col-sm-4 flex-row">
                    <span class="fnb-icons cat-icon meat"></span>
                    <div class="branch-row">
                        <div class="cat-label">Meat &amp; Poultry</div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <strong class="branch">Mutton</strong>
                </div>
                <div class="col-sm-6">
                    <ul class="fnb-cat small flex-row">
                        <li><span class="fnb-cat__title">Al Kabeer <span class="fa fa-times remove"></span></span>
                        </li>
                        <li><span class="fnb-cat__title">Pandiyan <span class="fa fa-times remove"></span></span>
                        </li>
                        <li><span class="fnb-cat__title">Ezzy <span class="fa fa-times remove"></span></span>
                        </li>
                        <li><span class="fnb-cat__title">Royco <span class="fa fa-times remove"></span></span>
                        </li>
                        <li><span class="fnb-cat__title">Venkys <span class="fa fa-times remove"></span></span>
                        </li>
                        <li class="more-show desk-hide"><span class="fnb-cat__title text-secondary">+10 more</span></li>
                    </ul>
                </div>
            </div>
            <div class="delete-cat">
                <span class="fa fa-times remove"></span>
            </div>
        </div>
        <div class="m-t-20">
            <a href="#category-select" data-toggle="modal" data-target="#category-select" name="add_categories" class="dark-link heavier">+ Add/Edit more categories</a>
        </div>
    </div>
    <div class="m-t-50 c-gap">
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
                <li><input type="checkbox" class="checkbox core-cat-select" id="cat-label" checked=""><label class="core-selector__label m-b-0" for="cat-label"><span class="fnb-cat__title text-medium">Al Kabeer </span></label></span>
                </li>
                <li><input type="checkbox" class="checkbox core-cat-select" id="cat-label-2"><label class="core-selector__label m-b-0" for="cat-label-2"><span class="fnb-cat__title text-medium">Pandiyan </span></label></span>
                </li>
                <li><input type="checkbox" class="checkbox core-cat-select" id="cat-label-3"><label class="core-selector__label m-b-0" for="cat-label-3"><span class="fnb-cat__title text-medium">Ezzy </span></label></span>
                </li>
                <li><input type="checkbox" class="checkbox core-cat-select" id="cat-label-4"><label class="core-selector__label m-b-0" for="cat-label-4"><span class="fnb-cat__title text-medium">Royco </span></label></span>
                </li>
                <li><input type="checkbox" class="checkbox core-cat-select" id="cat-label-5"><label class="core-selector__label m-b-0" for="cat-label-5"><span class="fnb-cat__title text-medium">Venkys </span></label></span>
                </li>
                <!--
                <li class="more-show desk-hide"><span class="fnb-cat__title text-secondary">+10 more</span></li> -->
            </ul>
        </div>
    </div>
    <div class="m-t-40 c-gap">
        <label class="label-size">List some brands that you deal with</label>
        <!-- <div class="text-lighter m-t-5">
            Ex: Albertsons, America's Choice, Bashas
        </div> -->
        <div class="m-t-5">
            <input type="text" class="form-control fnb-input" placeholder="+ Add brands you deal with">
        </div>
    </div>
    <!-- <div class="m-t-30 add-container c-gap">
        <label>Select categories your listing belongs to <span class="text-primary">*</span></label>
        <div class="text-lighter m-t-5">
            One category at a time
        </div>
    </div>
    <ul class="interested-options cat-select flex-row m-t-30">
        <li>
            <input type="radio" class="radio" name="interests">
            <div class="veg option flex-row">
                <span class="fnb-icons cat-icon veg"></span>
            </div>
            <div class="interested-label">
                Cereals &amp; Food Grains
            </div>
        </li>
        <li>
            <input type="radio" class="radio" name="interests" checked>
            <div class="meat option flex-row">
                <span class="fnb-icons cat-icon meat"></span>
            </div>
            <div class="interested-label">
                Meat &amp; Poultry
            </div>
        </li>
        <li>
            <input type="radio" class="radio" name="interests" checked>
            <div class="drinks option flex-row">
                <span class="fnb-icons cat-icon drinks"></span>
            </div>
            <div class="interested-label">
                Juices, Soups &amp; Soft Drinks
            </div>
        </li>
    </ul> -->

</div>

<!-- Category modal -->

 <div class="modal fnb-modal category-modal multilevel-modal fade" id="category-select" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="level-one mobile-hide ">
                        <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                    </div>
                    <div class="mobile-back flex-row">
                        <div class="back">
                            <button class="btn fnb-btn outline border-btn no-border" data-dismiss="modal"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i> Back</button>
                        </div>
                        <div class="level-two">
                            <button class="btn fnb-btn outline border-btn">save</button>
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
                        <div class="add-container">
                            <h5 class="text-medium">Select categories your listing belongs to <span class="text-primary">*</span></h5>
                            <div class="text-lighter">
                                One category at a time
                            </div>
                        </div>
                        <ul class="interested-options cat-select flex-row m-t-45">
                            <li>
                                <input type="radio" class="radio level-two-toggle" name="categories" data-name="Cereals &amp; Food Grains">
                                <div class="veg option flex-row">
                                    <span class="fnb-icons cat-icon veg"></span>
                                </div>
                                <div class="interested-label">
                                    Cereals &amp; Food Grains
                                </div>
                            </li>
                            <li>
                                <input type="radio" class="radio level-two-toggle" name="categories" data-name="Meat &amp; Poultry">
                                <div class="meat option flex-row">
                                    <span class="fnb-icons cat-icon meat"></span>
                                </div>
                                <div class="interested-label">
                                    Meat &amp; Poultry
                                </div>
                            </li>
                            <li>
                                <input type="radio" class="radio level-two-toggle" name="categories" data-name="Juices, Soups &amp; Soft Drinks">
                                <div class="drinks option flex-row">
                                    <span class="fnb-icons cat-icon drinks"></span>
                                </div>
                                <div class="interested-label">
                                    Juices, Soups &amp; Soft Drinks
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="sub-category level-two">
                        <!-- <div class="mobile-back flex-row m-b-10">
                            <div class="back">
                                 <button class="btn fnb-btn outline border-btn no-border sub-category-back"><i class="fa fa-arrow-left p-r-5" aria-hidden="true"></i> Back</button>
                            </div>
                            <button class="btn fnb-btn outline border-btn">save</button>
                        </div> -->
                        <div class="instructions">
                            <p class="instructions__title bat-color">Please choose the sub categories under "<span class="main-cat-name">Meat &amp; Poultry</span>"</p>
                            <div class="cat-name flex-row">
                                <span class="fnb-icons cat-icon meat m-r-15"></span>
                                <h5 class="cat-title bat-color main-cat-name">Meat &amp; Poultry</h5>
                            </div>
                        </div>
                        <div class="node-select flex-row">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs flex-row mobile-hide" role="tablist">
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
                            <div class="tab-content">
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

@endsection