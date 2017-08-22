@extends('add-listing')

@section('js')
    @parent
    <script type="text/javascript" src="/js/maps.js"></script>
    <script type="text/javascript" src="/js/add-listing-location.js"></script>
@endsection

@section('form-data')

@if(isset($_GET['success']) and $_GET['success']=='true') <div class="alert fnb-alert alert-success alert-dismissible fade in " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    Business Categories details saved successfully.
</div>
@endif

<div class="location-hours tab-pane fade active in" id="business_location">
    <h5 class="no-m-t main-heading white m-t-0 margin-btm">Location &amp; Hours of Operation</h5>
    <div class="m-t-30 c-gap">
        <label class="label-size">Please provide the google map address for your business</label>
<!--         <div class="location-select flex-row flex-wrap">
            <div class="select-col city">
                <select class="fnb-select select-variant form-control text-lighter">
                    <option>Select city</option>
                    <option>Mumbai</option>
                    <option>Delhi</option>
                    <option>Goa</option>
                </select>
            </div>
            <div class="select-col area">
                <select class="fnb-select select-variant form-control text-lighter">
                    <option>Select area</option>
                    <option>Dadar</option>
                    <option>Bandra</option>
                    <option>Borivili</option>
                </select>
            </div>
        </div> -->
        <div class="text-lighter">
            Note: You can drag the pin on the map to point the address
        </div>
    </div>
    <div class="m-t-20 c-gap">
        <input id="mapadd" type="text" class="form-control fnb-input location-val" placeholder="Ex: Shop no 4, Aarey Milk Colony, Mumbai" value="{{$listing->location['name']}}">
        <div class="m-t-10" id="map">
            
        </div>
        
    </div>
    <div class="m-t-40 c-gap">
        <label class="label-size">What is the address that you want to be displayed to the users?</label>
        <label class="dis-block text-medium baseline m-t-5">
            <input type="checkbox" class="checkbox remove-addr save-addr" id=""> Is the display address same as the map address?
            <input type="text" class="another-address form-control fnb-input m-t-10" placeholder="Ex: Shop no 4, Aarey Milk Colony, Mumbai">
        </label>
    </div>
    <!-- <hr class="m-t-50 m-b-50 separate"> -->
    <div class="m-t-40 c-gap">
        <label class="label-size">Mention the area(s) where you provide your products/services.</label>
        <div id="disp-operation-areas" class="node-list"></div>
        <div>
            <a href="#area-select" data-target="#area-select" data-toggle="modal" class="text-secondary text-decor heavier">+ Add / Edit area(s)</a>
        </div>
    </div>
    <div class="m-t-40 c-gap operation-hours">
        <label class="label-size">Enter the hours of operation for your business</label>
        <div class="flex-row flex-wrap">
            <div class="m-t-5 m-r-20">
                <label class="flex-row text-medium m-t-5">
                    <input type="radio" class="fnb-radio hours-display" name="hours" id="display_hours" checked=""> Display hours of operation
                </label>
            </div>
            <div class="m-t-5">
                <label class="flex-row text-medium m-t-5">
                    <input type="radio" class="fnb-radio hours-display dont-display" name="hours" id="dont_display_hours"> Don't display hours of operation
                </label>
            </div>
        </div>
    </div>
    <div class="m-t-20 c-gap hours-list">
        <div class="flex-row c-gap m-t-10 day-hours">
            <div class="flex-row hours-section open-1">
                <span class="hours_day heavier">Monday</span>
                <select class="fnb-select border-bottom form-control text-lighter monday">
                    {{getTime()}}
                </select>
            </div>
            <span class="p-r-30 no-padding">To</span>
            <div class="flex-row hours-section open-2">
                <select class="fnb-select border-bottom form-control text-lighter monday" disabled="disabled">
                    {{getTime()}}
                </select>
                <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                    <input type="checkbox" class="checkbox monday" id="closed"> Closed
                </label>
            </div>
        </div>
        <div class="flex-row c-gap m-t-10 day-hours">
            <div class="flex-row hours-section open-1">
                <span class="hours_day heavier">Tuesday</span>
                <select class="fnb-select border-bottom form-control text-lighter">
                    {{getTime()}}
                </select>
            </div>
            <span class="p-r-30 no-padding">To</span>
            <div class="flex-row hours-section open-2">
                <select class="fnb-select border-bottom form-control text-lighter" disabled="disabled">
                    {{getTime()}}
                </select>
                <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                    <input type="checkbox" class="checkbox" id="closed"> Closed
                </label>
            </div>
        </div>
        <div class="flex-row c-gap m-t-10 day-hours">
            <div class="flex-row hours-section open-1">
                <span class="hours_day heavier">Wednesday</span>
                <select class="fnb-select border-bottom form-control text-lighter">
                  {{getTime()}}
                </select>
            </div>
            <span class="p-r-30 no-padding">To</span>
            <div class="flex-row hours-section open-2">
                <select class="fnb-select border-bottom form-control text-lighter" disabled="disabled">
                    {{getTime()}}
                </select>
                <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                    <input type="checkbox" class="checkbox" id="closed"> Closed
                </label>
            </div>
        </div>
        <div class="flex-row c-gap m-t-10 day-hours">
            <div class="flex-row hours-section open-1">
                <span class="hours_day heavier">Thursday</span>
                <select class="fnb-select border-bottom form-control text-lighter">
                    {{getTime()}}
                </select>
            </div>
            <span class="p-r-30 no-padding">To</span>
            <div class="flex-row hours-section open-2">
                <select class="fnb-select border-bottom form-control text-lighter" disabled="disabled">
                    {{getTime()}}
                </select>
                <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                    <input type="checkbox" class="checkbox" id="closed"> Closed
                </label>
            </div>
        </div>
        <div class="flex-row c-gap m-t-10 day-hours">
            <div class="flex-row hours-section open-1">
                <span class="hours_day heavier">Friday</span>
                <select class="fnb-select border-bottom form-control text-lighter" >
                    {{getTime()}}
                </select>
            </div>
            <span class="p-r-30 no-padding">To</span>
            <div class="flex-row hours-section open-2">
                <select class="fnb-select border-bottom form-control text-lighter" disabled="disabled">
                    {{getTime()}}
                </select>
                <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                    <input type="checkbox" class="checkbox" id="closed"> Closed
                </label>
            </div>
        </div>
        <div class="flex-row c-gap m-t-10 day-hours">
            <div class="flex-row hours-section open-1">
                <span class="hours_day heavier">Saturday</span>
                <select class="fnb-select border-bottom form-control text-lighter">
                    {{getTime()}}
                </select>
            </div>
            <span class="p-r-30 no-padding">To</span>
            <div class="flex-row hours-section open-2">
                <select class="fnb-select border-bottom form-control text-lighter" disabled="disabled">
                    {{getTime()}}
                </select>
                <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                    <input type="checkbox" class="checkbox" id="closed"> Closed
                </label>
            </div>
        </div>
        <div class="flex-row c-gap m-t-10 day-hours">
            <div class="flex-row hours-section open-1">
                <span class="hours_day heavier">Sunday</span>
                <select class="fnb-select border-bottom form-control text-lighter">
                    {{getTime()}}
                </select>
            </div>
            <span class="p-r-30 no-padding">To</span>
            <div class="flex-row hours-section open-2">
                <select class="fnb-select border-bottom form-control text-lighter" disabled="disabled">
                   {{getTime()}}
                </select>
                <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                    <input type="checkbox" class="checkbox" id="closed"> Closed
                </label>
            </div>
        </div>
    </div>
    <div class="m-t-20 m-b-20 c-gap">
        <div>
            <a href="#" class="text-secondary text-decor heavier link-center copy-timing">Copy timings from Monday to Saturday</a>
        </div>
    </div>
</div>


<!-- Areas of operation modal -->
<div class="modal fnb-modal area-modal multilevel-modal fade" id="area-select" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header p-l-0 p-r-0 p-t-0 p-b-0">
                <div class="level-one mobile-hide text-right">
                    <a href="#" data-dismiss="modal" class="mobile-hide btn fnb-btn text-color m-l-5 cat-cancel text-color">&#10005;</a>
                </div>
                <!-- <div class="mobile-back flex-row desk-level-two">
                    <div class="back">
                        <button class="desk-hide btn fnb-btn outline border-btn no-border mobileCat-back" type="button" data-dismiss="modal"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i> Back</button>
                        <button class="btn fnb-btn outline border-btn no-border category-back mobile-hide" type="button"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i> Back to Category</button>
                    </div>
                    <div class="level-two">
                        <a href="#" data-dismiss="modal" class="mobile-hide btn fnb-btn text-color m-l-5 cat-cancel text-color">&#10005;</a>
                    </div>
                </div> -->
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="instructions flex-row space-between">
                        <h6 class="instructions__title bat-color sub-title">Select your area(s) of operation.</h6>
                        <button id="" class="btn fnb-btn outline border-btn operation-save re-save" type="button" data-dismiss="modal">save</button>
                    </div>
                    <div class="node-select flex-row">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs flex-row mobile-hide city-list" role="tablist">
                            @foreach($cities as $city)
                            <li role="presentation" class="@if($loop->first) active @endif"><a href="#{{$city->slug}}" aria-controls="{{$city->slug}}" role="tab" data-toggle="tab" name="{{$city->id}}">{{$city->name}}</a></li>                            
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
                            <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#{{$city->slug}}" aria-expanded="false" aria-controls="{{$city->slug}}" name="{{$city->id}}">{{$city->name}} <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </div>
                            <div role="tabpanel" class="tab-pane @if($loop->first) active @endif collapse" id="{{$city->slug}}" name={{$city->id}}>
                                <input type=hidden name="city" value="{{$city->name}}" id="{{$city->id}}">
                                <div class="highlight-color p-t-10 p-l-10 p-r-5 p-b-10 m-b-20 select-all operate-all">
                                    <label class="flex-row heavier">
                                        <input type="checkbox" class="checkbox all-cities" id="throughout_city"> I operate throughout the city
                                    </label>
                                </div>
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
                <button id="category-select" class="btn fnb-btn outline border-btn operation-save re-save" type="button" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Areas of operation modal -->

@endsection