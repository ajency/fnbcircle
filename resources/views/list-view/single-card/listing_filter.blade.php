<!-- Results -->
<div class="results filter-sidebar__section">
    <div class="results__header filter-row">
        <h6 class="element-title text-uppercase">Show Results for</h6>
    </div>
    <div class="results__body filter-row">
        <ul class="contents">
            <li class="branch">
                <p class="default-size"><i class="fa fa-angle-left p-r-5 arrow" aria-hidden="true"></i> Meat &amp; Poultry</p>
                <p class="default-size p-l-20">
                    <a href="" class="text-inherit bolder">Chicken</a>
                </p>
                <ul class="node">
                    <li class="node__child">
                        <a href="" class="text-darker">
                            <p class="default-size flex-row">Processed Chicken
                                <span class="text-lighter">(95)</span>
                            </p>
                        </a>
                    </li>
                    <li class="node__child">
                        <a href="" class="text-darker">
                            <p class="default-size flex-row">Boneless Chicken
                                <span class="text-lighter">(85)</span>
                            </p>
                        </a>
                    </li>
                    <li class="node__child">
                        <a href="" class="text-darker">
                            <p class="default-size flex-row">Chicken Wings
                                <span class="text-lighter">(76)</span>
                            </p>
                        </a>
                    </li>
                    <li class="node__child">
                        <a href="" class="text-darker">
                            <p class="default-size flex-row">Boiler Chicken
                                <span class="text-lighter">(30)</span>
                            </p>
                        </a>
                    </li>
                    <li class="node__child">
                        <a href="" class="text-darker">
                            <p class="default-size flex-row">Chicken Drumstick
                                <span class="text-lighter">(45)</span>
                            </p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- results ends -->
<div class="filter-group area">
    <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-area" aria-expanded="false" aria-controls="section-area">
        <h6 class="sub-title flex-row">Search by Area <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
        </h6>
    </div>
    <div class="filter-group__body filter-row collapse in" id="section-area">
        <div class="search-area flex-row">
            <i class="fa fa-search p-r-10 search-icon" aria-hidden="true"></i>
            <input type="text" class="form-control fnb-input search-input text-color" placeholder="Search an area">
        </div>
        <div class="check-section">
            <label class="sub-title flex-row clear hidden">
                <a href="" class="text-color">
                   <i class="fa fa-times" aria-hidden="true"></i>
                    <span>Clear All</span>
                </a>
            </label>
            @foreach($filter_data["areas"] as $area_index => $area_value)
                @if($area_index < 5)
                    <label class="sub-title flex-row text-color">
                        <input type="checkbox" class="checkbox p-r-10" value="{{$area_value['slug']}}">
                        <span>{{ $area_value['name'] }}</span>
                    </label>
                @endif
            @endforeach
            @if(sizeof($filter_data["areas"]) > 5)
                <div class="more-section collapse" id="moreDown">
                    @foreach(array_slice($filter_data["areas"], 5) as $area_index => $area_value)
                        <label class="sub-title flex-row text-color">
                            <input type="checkbox" class="checkbox p-r-10" value="{{$area_value['slug']}}">
                            <span>{{ $area_value['name'] }}</span>
                        </label>
                    @endforeach
                </div>

                <p data-toggle="collapse" href="#moreDown" aria-expanded="false" aria-controls="moreDown" class="text-primary heavier text-right more-area m-b-0 default-size">+{{ sizeof($filter_data["areas"]) - 5 }} more</p>
            @endif
        </div>
    </div>
</div>
<!-- Type of business -->
<div class="filter-group business-type no-gap">
    <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-business" aria-expanded="false" aria-controls="section-business">
        <h6 class="sub-title flex-row">Type of Business <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
        </h6>
    </div>
    <div class="filter-group__body filter-row collapse in" id="section-business">
        <div class="check-section">
            <label class="sub-title flex-row clear hidden">
                <a href="" class="text-color">
                   <i class="fa fa-times" aria-hidden="true"></i>
                    <span>Clear All</span>
                </a>
            </label>
            <label class="sub-title flex-row text-color">
                <input type="checkbox" class="checkbox p-r-10">
                <span>Wholesaler</span>
            </label>
            <label class="sub-title flex-row text-color">
                <input type="checkbox" class="checkbox p-r-10">
                <span>Retailer</span>
            </label>
            <label class="sub-title flex-row text-color">
                <input type="checkbox" class="checkbox p-r-10">
                <span>Manufacturer</span>
            </label>
        </div>
    </div>
</div>
<!-- listing status -->
<div class="filter-group list-status no-gap">
    <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-list-status" aria-expanded="false" aria-controls="section-list-status">
        <h6 class="sub-title flex-row">Listing Status <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
        </h6>
    </div>
    <div class="filter-group__body filter-row collapse in" id="section-list-status">
        <div class="check-section">
            <label class="sub-title flex-row clear hidden">
                <a href="" class="text-color">
                   <i class="fa fa-times" aria-hidden="true"></i>
                    <span>Clear All</span>
                </a>
            </label>
            <label class="sub-title flex-row text-color">
                <input type="checkbox" class="checkbox p-r-10">
                <span>Premium</span>
            </label>
            <label class="sub-title flex-row text-color">
                <input type="checkbox" class="checkbox p-r-10">
                <span>Verified</span>
            </label>
        </div>
    </div>
</div>
<!-- Ratings -->
<div class="filter-group rating-section no-gap">
    <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-rating" aria-expanded="false" aria-controls="section-rating">
        <h6 class="sub-title flex-row">Ratings <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
        </h6>
    </div>
    <div class="filter-group__body filter-row collapse in" id="section-rating">
        <div class="check-section">
            <label class="sub-title flex-row text-color">
               <div class="rating-view p-r-10">
                    <div class="rating">
                        <div class="bg"></div>
                        <div class="value" style="width: 100%;"></div>
                    </div>
                </div>
                <span>&amp; Up (211)</span>
            </label>
            <label class="sub-title flex-row text-color">
               <div class="rating-view p-r-10">
                    <div class="rating">
                        <div class="bg"></div>
                        <div class="value" style="width: 68%;"></div>
                    </div>
                </div>
                <span>&amp; Up (23)</span>
            </label>
            <label class="sub-title flex-row text-color">
               <div class="rating-view p-r-10">
                    <div class="rating">
                        <div class="bg"></div>
                        <div class="value" style="width: 50%;"></div>
                    </div>
                </div>
                <span>&amp; Up (134)</span>
            </label>
            <label class="sub-title flex-row text-color">
               <div class="rating-view p-r-10">
                    <div class="rating">
                        <div class="bg"></div>
                        <div class="value" style="width: 28%;"></div>
                    </div>
                </div>
                <span>&amp; Up (344)</span>
            </label>
            <label class="sub-title flex-row text-color">
               <div class="rating-view p-r-10">
                    <div class="rating">
                        <div class="bg"></div>
                        <div class="value" style="width: 16%;"></div>
                    </div>
                </div>
                <span>&amp; Up (23)</span>
            </label>
        </div>
    </div>
</div>
<!-- ratings ends -->