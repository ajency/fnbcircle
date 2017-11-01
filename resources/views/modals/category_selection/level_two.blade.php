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
                <button id="category-select" class="btn fnb-btn outline border-btn re-save" type="button" data-dismiss="modal">save</button>
            </div>
        </div>
        @if(sizeof($sub_categories["children"]) > 0)
            <div class="node-select flex-row">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs flex-row mobile-hide categ-list" role="tablist" id="branch_categories">
                    @foreach($sub_categories["children"] as $sub_index => $sub_value)
                        @if($sub_index == 0)
                            <li role="presentation" class="active"><a href="#{{ $sub_value['slug'] }}" aria-controls="{{ $sub_value['slug'] }}" role="tab" data-toggle="tab">{{ $sub_value["name"] }}</a></li>
                        @else
                            <li role="presentation"><a href="#{{ $sub_value['slug'] }}" aria-controls="{{ $sub_value['slug'] }}" role="tab" data-toggle="tab">{{ $sub_value["name"] }}</a></li>
                        @endif
                    @endforeach
                </ul>
                <!-- Tab panes -->
                <div class="tab-content cat-dataHolder mobile-categories relative">
                    <!-- mobile collapse -->
                    @foreach($sub_categories["children"] as $sub_index => $sub_value)
                        @if($sub_index == 0)
                            <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#{{ $sub_value['slug'] }}" aria-expanded="false" aria-controls="{{ $sub_value['slug'] }}">{{ $sub_value["name"] }} <i class="fa fa-angle-down" aria-hidden="true"></i></div>
                        @else
                            <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#{{ $sub_value['slug'] }}" aria-expanded="false" aria-controls="{{ $sub_value['slug'] }}">{{ $sub_value["name"] }} <i class="fa fa-angle-down" aria-hidden="true"></i></div>
                        @endif
                    @endforeach
                    @foreach($sub_categories["children"] as $sub_index => $sub_value)
                        @if($sub_index == 0)
                            <div role="tabpanel" class="tab-pane active collapse" id="{{ $sub_value['slug'] }}">
                                @if(isset($sub_value["node_children"]))
                                    <ul class="nodes">
                                        @foreach($sub_value["node_children"] as $node_index => $node_value)
                                            <li>
                                                <label class="flex-row">
                                                    <input type="checkbox" class="checkbox" for="{{ $node_value['slug'] }}">
                                                    <p class="lighter nodes__text" id="{{ $node_value['slug'] }}">{{ $node_value["name"] }}</p>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @else
                            <div role="tabpanel" class="tab-pane collapse" id="{{ $sub_value['slug'] }}">{{ $sub_value['name'] }}</div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
        <div class="footer-actions mobile-hide text-right">
            <button class="btn fnb-btn outline border-btn grey" type="button" data-dismiss="modal">Cancel</button>
            <button id="category-select" class="btn fnb-btn outline border-btn" type="button" data-dismiss="modal">Save</button>
        </div>
    @endif
</div>