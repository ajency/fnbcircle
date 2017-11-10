<div class="sub-category level-two-category" id="level-two-category">
    <!-- <div class="mobile-back flex-row m-b-10">
        <div class="back">
             <button class="btn fnb-btn outline border-btn no-border sub-category-back"><i class="fa fa-arrow-left p-r-5" aria-hidden="true"></i> Back</button>
        </div>
        <button class="btn fnb-btn outline border-btn">save</button>
    </div> -->
    @if(sizeof($sub_categories) > 0)
        <div class="instructions flex-row space-between">
            <div class="cat-name flex-row">
                <span class="fnb-icons cat-icon meat m-r-15"></span>
                <div>
                    <p class="instructions__title bat-color default-size">Please choose the sub categories under "<span class="main-cat-name" id="main-cat-name">{{ $sub_categories['name'] }}</span>"</p>
                    <h5 class="sub-title cat-title bat-color main-cat-name" id="main-cat-title">{{ $sub_categories['name'] }}</h5>
                </div>
            </div>
            <div>
                <button id="category-select-btn" class="btn fnb-btn outline border-btn re-save" type="button">add selected</button>
            </div>
        </div>
        @if(sizeof($sub_categories["children"]) > 0)
            <div class="node-select flex-row custom-node-select">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs flex-row mobile-hide categ-list" role="tablist" id="branch_categories">
                    @foreach($sub_categories["children"] as $sub_index => $sub_value)
                        @if($sub_index == 0)
                            <li role="presentation" class="active">
                                @if(isset($is_branch_select) && $is_branch_select)
                                    <input type="checkbox" name="branch_categories_select" id="" value="{{ $sub_value['id'] }}">
                                @endif
                                <a href="#{{ $sub_value['id'] }}" aria-controls="{{ $sub_value['id'] }}" role="tab" data-toggle="tab">
                                    <p class="lighter nodes__text" id="{{ $sub_value['id'] }}">{{ $sub_value["name"] }}</p>
                                </a>
                                <input type="hidden" name="hierarchy" id="hierarchy" value="{{ json_encode(generateCategoryHierarchy($sub_value['id'])) }}">
                            </li>
                        @else
                            <li role="presentation">
                                @if(isset($is_branch_select) && $is_branch_select)
                                    <input type="checkbox" name="branch_categories_select" id="" value="{{ $sub_value['id'] }}">
                                @endif
                                <a href="#{{ $sub_value['id'] }}" aria-controls="{{ $sub_value['id'] }}" role="tab" data-toggle="tab">
                                    <p class="lighter nodes__text" id="{{ $sub_value['id'] }}">{{ $sub_value["name"] }}</p>
                                </a>
                                <input type="hidden" name="hierarchy" id="hierarchy" value="{{ json_encode(generateCategoryHierarchy($sub_value['id'])) }}">
                            </li>
                        @endif
                    @endforeach
                </ul>
                <!-- Tab panes -->
                <div class="tab-content cat-dataHolder mobile-categories relative" id="cat-dataHolder">
                    <!-- mobile collapse -->
                    @foreach($sub_categories["children"] as $sub_index => $sub_value)
                        @if($sub_index == 0)
                            <div class="flex-row mobile-custom-child desk-hide">
                                <input type="checkbox" name="branch_categories_select" id="" value="{{ $sub_value['id'] }}" class="mobile-child-selection">
                                <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#{{ $sub_value['id'] }}" aria-expanded="false" aria-controls="{{ $sub_value['id'] }}">
                                    {{ $sub_value["name"] }} <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </div>
                            </div>
                        @else
                            <div class="flex-row mobile-custom-child desk-hide">
                                <input type="checkbox" name="branch_categories_select" id="" value="{{ $sub_value['id'] }}" class="mobile-child-selection">
                                <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#{{ $sub_value['id'] }}" aria-expanded="false" aria-controls="{{ $sub_value['id'] }}">
                                    {{ $sub_value["name"] }} <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    @foreach($sub_categories["children"] as $sub_index => $sub_value)
                        @if($sub_index == 0)
                            <div role="tabpanel" class="tab-pane collapse active" id="{{ $sub_value['id'] }}">
                                @if(isset($sub_value["node_children"]))
                                    <ul class="nodes">
                                        @foreach($sub_value["node_children"] as $node_index => $node_value)
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="{{ $node_value['id'] }}" value="{{ $node_value['id'] }}">
                                                    <input type="hidden" name="hierarchy" id="hierarchy" value="{{ json_encode(generateCategoryHierarchy($node_value['id'])) }}">
                                                    <p class="lighter nodes__text" id="{{ $node_value['id'] }}">{{ $node_value["name"] }}</p>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    Sorry! No Categories found under <b>$sub_value["name"]</b>.
                                @endif
                            </div>
                        @else
                            <div role="tabpanel" class="tab-pane collapse" id="{{ $sub_value['id'] }}"></div>
                        @endif
                    @endforeach
                    <!-- <div id="node-skeleton" class="hidden">
                        <ul class="nodes">
                            <li>
                                <input type="checkbox" class="checkbox" for="" value=""/>
                                <p class="lighter nodes__text" id=""></p>
                            </li>
                        </ul>
                    </div> -->
                </div>
            </div>
        @endif
        <div class="footer-actions mobile-hide text-right">
            <button class="btn fnb-btn outline border-btn grey" type="button" data-dismiss="modal">Cancel</button>
            <button id="category-select-btn" class="btn fnb-btn outline border-btn" type="button" data-dismiss="modal">Save</button>
        </div>
    @endif
</div>