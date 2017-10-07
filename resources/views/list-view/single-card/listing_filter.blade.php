<!-- Results -->
<div class="results filter-sidebar__section">
    <div class="results__header filter-row">
        <h6 class="element-title text-uppercase">Show Results for</h6>
    </div>
    <div class="results__body filter-row">
        <ul class="contents">
            <input type="hidden" id="current_category" name="" value="0|[]">
            <li class="branch">
                @if(strlen($filter_data["category"]["name"]) > 0)
                    <p class="default-size"><a href="" class="text-darker" value="0|[]"><i class="fa fa-angle-left p-r-5 arrow" aria-hidden="true"></i> Reset categories </a></p>
                @endif
                @foreach($filter_data["category"]["parent"] as $cat_parent_index => $cat_parent_value)
                    <p class="default-size"><a href="" class="text-darker" value="{{ $cat_parent_value['node_categories'] }}"><i class="fa fa-angle-left p-r-5 arrow" aria-hidden="true"></i> {{ $cat_parent_value["name"] }} </a></p>
                @endforeach

                <p class="default-size p-l-20">
                    <a href="#" class="text-inherit bolder" value="{{ $filter_data['category']['node_categories'] }}">{{ $filter_data["category"]["name"] }}</a>
                </p>
                <ul class="node">
                    @foreach(array_slice($filter_data["category"]["children"], 0, 10) as $cat_child_index => $cat_child_value)
                        <li class="node__child">
                            <a href="#" class="text-darker" value="{{ $cat_child_value['node_categories'] }}">
                                <p class="default-size flex-row"> {{ $cat_child_value["name"] }}
                                    <!-- <span class="text-lighter">(95)</span> -->
                                </p>
                            </a>
                        </li>
                    @endforeach
                    <div class="more-section collapse" id="moreCategoryDown">
                        @foreach(array_slice($filter_data["category"]["children"], 10) as $cat_child_index => $cat_child_value)
                            <li class="node__child">
                                <a href="#" class="text-darker" value="{{ $cat_child_value['node_categories'] }}">
                                    <p class="default-size flex-row">{{ $cat_child_value["name"] }}
                                        <!-- <span class="text-lighter">(85)</span> -->
                                    </p>
                                </a>
                            </li>
                        @endforeach
                    </div>
                    @if(sizeof(array_slice($filter_data["category"]["children"], 10)) > 10)
                        <p data-toggle="collapse" href="#moreCategoryDown" aria-expanded="false" aria-controls="moreDown" class="text-primary heavier text-right more-area m-b-0 default-size">+{{ sizeof(array_slice($filter_data["category"]["children"], 10)) - 10 }} more</p>
                    @endif
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
            @foreach(array_slice($filter_data["areas"], 0, 5) as $area_index => $area_value)
                @if($area_index < 5)
                    <label class="sub-title flex-row text-color">
                        <input type="checkbox" name="areas[]" class="checkbox p-r-10" value="{{$area_value['slug']}}"  {{ in_array($area_value['slug'], $filter_data["areas_selected"]) ? "checked" : "" }}>
                        <span>{{ $area_value['name'] }}</span>
                    </label>
                @endif
            @endforeach
            @if(sizeof($filter_data["areas"]) > 5)
                <div class="more-section collapse" id="moreDown">
                    @foreach(array_slice($filter_data["areas"], 5) as $area_index => $area_value)
                        <label class="sub-title flex-row text-color">
                            <input type="checkbox" name="areas[]" class="checkbox p-r-10" value="{{$area_value['slug']}}"  {{ in_array($area_value['slug'], $filter_data["areas_selected"]) ? "checked" : "" }}>
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
            @foreach($filter_data["business_type"]["value"] as $type_id => $type_value)
                <label class="sub-title flex-row text-color">
                    <input type="checkbox" class="checkbox p-r-10" name="business_type[]" value="{{ $type_id }}" {{ isset($filter_data["business_type"]["status"][$type_id]) && $filter_data["business_type"]["status"][$type_id] == "checked" ? "checked" : "" }}>
                    <span> {{ $type_value }} </span>
                </label>
            @endforeach
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
            @foreach($filter_data["listing_status"]["value"] as $status_id => $status_value)
                <label class="sub-title flex-row text-color">
                    <input type="checkbox" class="checkbox p-r-10" name="listing_status[]" value="{{ $status_id }}" {{ isset($filter_data["listing_status"]["status"][$status_id]) && $filter_data["listing_status"]["status"][$status_id] == "checked" ? "checked" : "" }}>
                    <span>{{ $status_value }}</span>
                </label>
            @endforeach
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
            @foreach($filter_data["star_ratings"] as $star_id => $star_value)
                <label class="sub-title flex-row text-color">
                    <a href="#" class="text-darker" value="{{ $star_id }}">
                       <div class="rating-view p-r-10">
                            <div class="rating">
                                <div class="bg"><span>&amp; Up</span></div>
                                <div class="value" style="width: {{ $star_value }}%;"></div>
                            </div>
                        </div>
                    </a>
                </label>
            @endforeach
            <!-- <label class="sub-title flex-row text-color">
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
            </label> -->
        </div>
    </div>
</div>
<!-- ratings ends -->