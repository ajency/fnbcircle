@extends('add-listing')

@section('form-data')

<div class="location-hours tab-pane fade active in" id="business_location">
    <h5 class="no-m-t">Location &amp; Hours of Operation</h5>
    <div class="m-t-30 c-gap">
        <label>Please provide the google map address for your business</label>
        <div class="location-select flex-row flex-wrap">
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
        </div>
        <div class="text-lighter">
            Note: You can drag the pin on the map to point the address
        </div>
    </div>
    <div class="m-t-20 c-gap">
        <input type="text" class="form-control fnb-input" placeholder="Ex: Shop no 4, Aarey Milk Colony, Mumbai">
        <div class="m-t-10">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15380.091383021922!2d73.81245283848914!3d15.483203277923609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bbfc0a93361ccd9%3A0xdd98120b24e5be61!2sPanjim%2C+Goa!5e0!3m2!1sen!2sin!4v1498804405360" width="600" height="250" frameborder="0" style="border:0;width:100%;" allowfullscreen></iframe>
        </div>
    </div>
    <div class="m-t-40 c-gap">
        <label>What is the address that you want to be displayed to the users?</label>
        <label class="dis-block text-medium baseline">
            <input type="checkbox" class="checkbox remove-addr" id=""> Is the display address same as the map address?
            <input type="text" class="another-address form-control fnb-input m-t-10" placeholder="Ex: Shop no 4, Aarey Milk Colony, Mumbai">
        </label>
    </div>
    <!-- <hr class="m-t-50 m-b-50 separate"> -->
    <div class="m-t-40 c-gap">
        <label>Mention the area(s) where you provide your products/services.</label>
        <div class="single-area gray-border m-t-10 m-b-20">
            <div class="row flex-row areaContainer">
                <div class="col-sm-3">
                    <strong class="branch">Delhi</strong>
                </div>
                <div class="col-sm-9">
                    <ul class="fnb-cat small flex-row">
                        <li><span class="fnb-cat__title">Adarsh nagar <span class="fa fa-times remove"></span></span>
                        </li>
                        <li><span class="fnb-cat__title">Babarpur <span class="fa fa-times remove"></span></span>
                        </li>
                        <li><span class="fnb-cat__title">Badli <span class="fa fa-times remove"></span></span>
                        </li>
                        <li><span class="fnb-cat__title">Dwarka <span class="fa fa-times remove"></span></span>
                        </li>
                        <li><span class="fnb-cat__title">Chandni Chowk <span class="fa fa-times remove"></span></span>
                        </li>
                        <li class="more-show desk-hide"><span class="fnb-cat__title text-secondary">+10 more</span></li>
                    </ul>
                </div>
            </div>
            <div class="delete-cat">
                <span class="fa fa-times remove"></span>
            </div>
        </div>
        <div>
            <a href="#area-select" data-target="#area-select" data-toggle="modal" class="text-secondary text-decor heavier">+ Add / Edit area(s)</a>
        </div>
    </div>
    <div class="m-t-40 c-gap operation-hours">
        <label>Enter the hours of operation for your business</label>
        <div class="row">
            <div class="col-sm-3">
                <label class="flex-row text-medium m-t-5">
                    <input type="radio" class="fnb-radio" name="hours" id="display_hours"> Display hours of operation
                </label>
            </div>
            <div class="col-sm-4">
                <label class="flex-row text-medium m-t-5">
                    <input type="radio" class="fnb-radio" name="hours" id="dont_display_hours"> Don't display hours of operation
                </label>
            </div>
        </div>
    </div>
    <div class="m-t-40 c-gap">
        <div class="flex-row c-gap m-t-10">
            <div class="flex-row hours-section open-1">
                <span class="hours_day heavier">Monday</span>
                <select class="fnb-select border-bottom form-control text-lighter">
                    <option>Open 24 hours</option>
                    <option>12 AM</option>
                    <option>12.30 AM</option>
                    <option>1 AM</option>
                    <option>1.30 AM</option>
                </select>
            </div>
            <span class="p-r-30 no-padding">To</span>
            <div class="flex-row hours-section open-2">
                <select class="fnb-select border-bottom form-control text-lighter">
                    <option>Open 24 hours</option>
                    <option>12 AM</option>
                    <option>12.30 AM</option>
                    <option>1 AM</option>
                    <option>1.30 AM</option>
                </select>
                <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                    <input type="checkbox" class="checkbox" id="closed"> Closed
                </label>
            </div>
        </div>
        <div class="flex-row c-gap m-t-10">
            <div class="flex-row hours-section open-1">
                <span class="hours_day heavier">Tuesday</span>
                <select class="fnb-select border-bottom form-control text-lighter">
                    <option>Open 24 hours</option>
                    <option>12 AM</option>
                    <option>12.30 AM</option>
                    <option>1 AM</option>
                    <option>1.30 AM</option>
                </select>
            </div>
            <span class="p-r-30 no-padding">To</span>
            <div class="flex-row hours-section open-2">
                <select class="fnb-select border-bottom form-control text-lighter">
                    <option>Open 24 hours</option>
                    <option>12 AM</option>
                    <option>12.30 AM</option>
                    <option>1 AM</option>
                    <option>1.30 AM</option>
                </select>
                <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                    <input type="checkbox" class="checkbox" id="closed"> Closed
                </label>
            </div>
        </div>
        <div class="flex-row c-gap m-t-10">
            <div class="flex-row hours-section open-1">
                <span class="hours_day heavier">Wednesday</span>
                <select class="fnb-select border-bottom form-control text-lighter">
                    <option>Open 24 hours</option>
                    <option>12 AM</option>
                    <option>12.30 AM</option>
                    <option>1 AM</option>
                    <option>1.30 AM</option>
                </select>
            </div>
            <span class="p-r-30 no-padding">To</span>
            <div class="flex-row hours-section open-2">
                <select class="fnb-select border-bottom form-control text-lighter">
                    <option>Open 24 hours</option>
                    <option>12 AM</option>
                    <option>12.30 AM</option>
                    <option>1 AM</option>
                    <option>1.30 AM</option>
                </select>
                <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                    <input type="checkbox" class="checkbox" id="closed"> Closed
                </label>
            </div>
        </div>
        <div class="flex-row c-gap m-t-10">
            <div class="flex-row hours-section open-1">
                <span class="hours_day heavier">Thursday</span>
                <select class="fnb-select border-bottom form-control text-lighter">
                    <option>Open 24 hours</option>
                    <option>12 AM</option>
                    <option>12.30 AM</option>
                    <option>1 AM</option>
                    <option>1.30 AM</option>
                </select>
            </div>
            <span class="p-r-30 no-padding">To</span>
            <div class="flex-row hours-section open-2">
                <select class="fnb-select border-bottom form-control text-lighter">
                    <option>Open 24 hours</option>
                    <option>12 AM</option>
                    <option>12.30 AM</option>
                    <option>1 AM</option>
                    <option>1.30 AM</option>
                </select>
                <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                    <input type="checkbox" class="checkbox" id="closed"> Closed
                </label>
            </div>
        </div>
        <div class="flex-row c-gap m-t-10">
            <div class="flex-row hours-section open-1">
                <span class="hours_day heavier">Friday</span>
                <select class="fnb-select border-bottom form-control text-lighter">
                    <option>Open 24 hours</option>
                    <option>12 AM</option>
                    <option>12.30 AM</option>
                    <option>1 AM</option>
                    <option>1.30 AM</option>
                </select>
            </div>
            <span class="p-r-30 no-padding">To</span>
            <div class="flex-row hours-section open-2">
                <select class="fnb-select border-bottom form-control text-lighter">
                    <option>Open 24 hours</option>
                    <option>12 AM</option>
                    <option>12.30 AM</option>
                    <option>1 AM</option>
                    <option>1.30 AM</option>
                </select>
                <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                    <input type="checkbox" class="checkbox" id="closed"> Closed
                </label>
            </div>
        </div>
        <div class="flex-row c-gap m-t-10">
            <div class="flex-row hours-section open-1">
                <span class="hours_day heavier">Saturday</span>
                <select class="fnb-select border-bottom form-control text-lighter">
                    <option>Open 24 hours</option>
                    <option>12 AM</option>
                    <option>12.30 AM</option>
                    <option>1 AM</option>
                    <option>1.30 AM</option>
                </select>
            </div>
            <span class="p-r-30 no-padding">To</span>
            <div class="flex-row hours-section open-2">
                <select class="fnb-select border-bottom form-control text-lighter">
                    <option>Open 24 hours</option>
                    <option>12 AM</option>
                    <option>12.30 AM</option>
                    <option>1 AM</option>
                    <option>1.30 AM</option>
                </select>
                <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                    <input type="checkbox" class="checkbox" id="closed"> Closed
                </label>
            </div>
        </div>
        <div class="flex-row c-gap m-t-10">
            <div class="flex-row hours-section open-1">
                <span class="hours_day heavier">Sunday</span>
                <select class="fnb-select border-bottom form-control text-lighter">
                    <option>Open 24 hours</option>
                    <option>12 AM</option>
                    <option>12.30 AM</option>
                    <option>1 AM</option>
                    <option>1.30 AM</option>
                </select>
            </div>
            <span class="p-r-30 no-padding">To</span>
            <div class="flex-row hours-section open-2">
                <select class="fnb-select border-bottom form-control text-lighter">
                    <option>Open 24 hours</option>
                    <option>12 AM</option>
                    <option>12.30 AM</option>
                    <option>1 AM</option>
                    <option>1.30 AM</option>
                </select>
                <label class="flex-row text-medium p-r-15 closed-label m-b-0">
                    <input type="checkbox" class="checkbox" id="closed"> Closed
                </label>
            </div>
        </div>
    </div>
    <div class="m-t-40 c-gap">
        <div>
            <a href="#" class="text-secondary text-decor heavier link-center">Copy timings from Monday to Saturday</a>
        </div>
    </div>
</div>


<!-- Areas of operation modal -->
<div class="modal fnb-modal area-modal multilevel-modal fade" id="area-select" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header p-l-0 p-r-0 p-t-0 p-b-0">
                <div class="level-one mobile-hide ">
                    <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
                </div>
                <div class="mobile-back">
                    <div class="back pull-left">
                        <button class="btn fnb-btn outline border-btn no-border" data-dismiss="modal"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i> Back</button>
                    </div>
                    <div class="pull-right">
                        <button class="btn fnb-btn outline border-btn">save</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="instructions">
                        <h6 class="instructions__title bat-color">Select your area(s) of operation.</h6>
                    </div>
                    <div class="node-select flex-row">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs flex-row mobile-hide" role="tablist">
                            <li role="presentation" class="active"><a href="#mumbai" aria-controls="mumbai" role="tab" data-toggle="tab">Mumbai</a></li>
                            <li role="presentation"><a href="#delhi" aria-controls="delhi" role="tab" data-toggle="tab">Delhi</a></li>
                            <li role="presentation"><a href="#bangalore" aria-controls="bangalore" role="tab" data-toggle="tab">Bangalore</a></li>
                            <li role="presentation"><a href="#pune" aria-controls="pune" role="tab" data-toggle="tab">Pune</a></li>
                            <li role="presentation"><a href="#hyderabad" aria-controls="hyderabad" role="tab" data-toggle="tab">Hyderabad</a></li>
                            <li role="presentation"><a href="#kolkata" aria-controls="kolkata" role="tab" data-toggle="tab">Kolkata</a></li>
                            <li role="presentation"><a href="#chennai" aria-controls="chennai" role="tab" data-toggle="tab">Chennai</a></li>
                            <li role="presentation"><a href="#jaipur" aria-controls="jaipur" role="tab" data-toggle="tab">Jaipur</a></li>
                            <li role="presentation"><a href="#lucknow" aria-controls="lucknow" role="tab" data-toggle="tab">Lucknow</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <!-- mobile collapse -->
                            <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#mumbai" aria-expanded="false" aria-controls="mumbai">
                                Mumbai <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </div>
                            <div role="tabpanel" class="tab-pane active collapse" id="mumbai">
                                <div class="highlight-color p-t-10 p-l-10 p-r-5 p-b-10 m-b-20 select-all operate-all">
                                    <label class="flex-row heavier">
                                        <input type="checkbox" class="checkbox all-cities" id="throughout_city"> I operate throughout the city
                                    </label>
                                </div>
                                <ul class="nodes">
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="flex-row">
                                            <input type="checkbox" class="checkbox" for="adarsh">
                                            <p class="lighter nodes__text" id="adarsh">Adarsh nagar</p>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#delhi" aria-expanded="false" aria-controls="delhi">
                                Delhi <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </div>
                            <div role="tabpanel" class="tab-pane collapse" id="delhi">Delhi</div>
                            <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#bangalore" aria-expanded="false" aria-controls="bangalore">
                                Bangalore <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </div>
                            <div role="tabpanel" class="tab-pane collapse" id="bangalore">Bangalore</div>
                            <div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#pune" aria-expanded="false" aria-controls="pune">
                                Pune <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </div>
                            <div role="tabpanel" class="tab-pane collapse" id="pune">Pune</div>
                            <div role="tabpanel" class="tab-pane" id="hyderabad">Hyderabad</div>
                            <div role="tabpanel" class="tab-pane" id="kolkata">Kolkata</div>
                            <div role="tabpanel" class="tab-pane" id="chennai">Chennai</div>
                            <div role="tabpanel" class="tab-pane" id="jaipur">Jaipur</div>
                            <div role="tabpanel" class="tab-pane" id="lucknow">Lucknow</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mobile-hide">
                <div class="sub-category hidden">
                    <button class="btn fnb-btn outline full border-btn">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Areas of operation modal -->

@endsection