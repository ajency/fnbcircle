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

@endsection