@extends('add-listing')

@section('form-data')

<div class="business-cats tab-pane fade in active" id="business-cats">
    <h5 class="no-m-t">Business Categories</h5>
    <div class="m-t-30 c-gap">
        <label>List of all the categories for your listing</label>
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
            <a href="#category-select" data-toggle="modal" data-target="#category-select" class="dark-link heavier">+ Add/Edit more categories</a>
        </div>
    </div>
    <div class="m-t-50 c-gap">
        <label class="required">Core categories of your listing</label>
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
        <label>List some brands that you deal with</label>
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

@endsection