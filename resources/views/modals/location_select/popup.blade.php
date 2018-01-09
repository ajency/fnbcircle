<!-- Areas of operation modal -->
<div class="modal fnb-modal area-modal multilevel-modal fade" id="area-select" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header p-l-0 p-r-0 p-t-0 p-b-0">
                <div class="level-one mobile-hide text-right">
                    <a href="#" data-dismiss="modal" class="mobile-hide btn fnb-btn text-color m-l-5 cat-cancel text-color">&#10005;</a>
                </div>
                <div class="mobile-back flex-row desk-level-two">
                    <div class="back">
                        <button class="desk-hide btn fnb-btn outline border-btn no-border mobileCat-back" type="button" data-dismiss="modal"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i> Back</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="instructions flex-row space-between">
                        <h6 class="instructions__title bat-color sub-title">Select Location(s)</h6>
                        <button id="" class="btn fnb-btn outline border-btn operation-save re-save" type="button" data-dismiss="modal">save</button>
                    </div>
                    <div class="node-select flex-row custom-node-select">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs flex-row mobile-hide city-list" role="tablist">
                            @foreach($cities as $city)
                            <li role="presentation" class="@if($loop->first) active @endif">
                                <input type="checkbox" id="checkbox-{{$city->id}}" class="city-checkbox">
                                <a href="#{{$city->slug}}" aria-controls="{{$city->slug}}" role="tab" data-toggle="tab" name="{{$city->id}}">{{$city->name}}</a>
                            </li>
                            @endforeach
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content relative">
                            <div class="site-loader section-loader half-modal hidden">
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
                            <!-- mobile collapse -->
                            @foreach($cities as $city)
                            <div class="flex-row mobile-custom-child desk-hide">
                                <input type="checkbox" name="branch_categories_select" id="" value="" class="mobile-child-selection">
                                <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#{{$city->slug}}" aria-expanded="false" aria-controls="{{$city->slug}}" name="{{$city->id}}">
                                    {{$city->name}} <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane @if($loop->first) active @endif collapse" id="{{$city->slug}}" name={{$city->id}} >
                                <input type=hidden name="city" value="{{$city->name}}" id="city-{{$city->slug}}" data-city-id="{{$city->id}}">
                                <!-- <div class="highlight-color p-t-10 p-l-10 p-r-5 p-b-10 m-b-20 select-all operate-all">
                                </div> -->
                                <ul class="nodes">
                                    <!-- <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh" value="67">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li> -->

                                </ul>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-actions mobile-hide text-right">
                <button class="btn fnb-btn outline border-btn grey" type="button" data-dismiss="modal">Cancel</button>
                <button id="location-select" class="btn fnb-btn outline border-btn operation-save re-save" type="button" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Areas of operation modal -->
@section('js')
@parent
<script type="text/javascript" src="/js/location_select.js"></script>
@endsection