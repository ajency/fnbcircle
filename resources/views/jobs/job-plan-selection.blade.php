@extends('layouts.add-job')
@section('js')
    @parent
    <script type="text/javascript" src="/js/jobs.js"></script>
@endsection
@section('form-data')



@include('jobs.notification')
<input type="hidden" name="_method" value="PUT">
<input type="hidden" name="step" value="step-three">

<div class="business-info tab-pane fade in active" id="plan_selection">
 
    <!-- <h5 class="no-m-t fly-out-heading-size main-heading white m-t-0 margin-btm ">Job Information</h5> -->
    <h5 class="nno-m-t main-heading  white m-t-0 margin-btm">Plan Selection</h5>

    <!-- Job title/category -->

    

    <div class="pricing-table plans flex-row job-plans">
        <div class="pricing-table__cards free-plan active">
            <div class="plans__header">
               <!-- <h6 class="sub-title text-uppercase plans__title text-color">Basic Plan</h6> -->
                <div class="plans__fee">
                    <h5 class="element-title">Free Membership</h5>
                    <span class="text-lighter lighter default-size"><i class="fa fa-inr" aria-hidden="true"></i> 0.00/month</span>
                </div> 
                <ul class="points">
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet.</li>
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit elit.</li>
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet</li>
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                </ul>
            </div>
            <div class="plans__footer">
                <div class="selection sub-row">
                    <!-- <input type="radio" class="fnb-radio" name="plan-select" checked=""></input>
                    <label class="radio-check"></label>
                    <span class="dis-block lighter text-lighter">Your current plan</span> -->
                    <button class="btn fnb-btn outline full border-btn def-btn" type="button">Subscribe </i></button>
                    <button class="btn fnb-btn outline full border-btn green-btn" type="button">Selected <i class="fa fa-check check-icon" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
        <div class="pricing-table__cards plan-1">
            <div class="plans__header">
                <!-- <div class="validity">
                    <span class="validity__text"><h6 class="number">6</h6>Months</span>
                </div> -->
                <img src="/img/power-icon.png" class="img-responsive power-icon" width="50">
                <div class="plans__fee">
                    <h5 class="element-title bolder">Premium Plan</h5>
                    <p class="default-size text-lighter">Choose a duration</p>
                    <select class="fnb-select select-variant form-control text-color">
                        <option>--Select Duration--</option>
                        <option><i class="fa fa-inr" aria-hidden="true"></i> 3000/3 months</option>
                        <option><i class="fa fa-inr" aria-hidden="true"></i> 3000/6 months</option>
                        <option><i class="fa fa-inr" aria-hidden="true"></i> 3000/1 Year</option>
                    </select>
                </div> 
                <ul class="points">
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet.</li>
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit elit.</li>
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet</li>
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                </ul>
            </div>
            <div class="plans__footer">
                <div class="selection sub-row">
                    <!-- <input type="radio" class="fnb-radio" name="plan-select"></input>
                    <label class="radio-check"></label>
                    <span class="dis-block lighter text-lighter">Your current plan</span> -->
                    <button class="btn fnb-btn outline full border-btn def-btn" type="button">Subscribe</button>
                    <button class="btn fnb-btn outline full border-btn green-btn" type="button">Selected <i class="fa fa-check check-icon" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
       <!--  <label class="pricing-table__cards plan-2">
            <div class="plans__header">
                <div class="validity">
                    <span class="validity__text"><h6 class="number">3</h6>Months</span>
                </div>
                <img src="img/power-icon.png" class="img-responsive power-icon" width="50">
               <h6 class="sub-title text-uppercase plans__title text-color">Plan 2</h6>
                <div class="plans__fee">
                    <h5><i class="fa fa-inr" aria-hidden="true"></i> 5,000</h5>
                </div> 
                <ul class="points">
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet.</li>
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit elit.</li>
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet</li>
                </ul>
            </div>
            <div class="plans__footer">
                <div class="selection">
                    <input type="radio" class="fnb-radio" name="plan-select"></input>
                    <label class="radio-check"></label>
                    <span class="dis-block lighter text-lighter">Your current plan</span>
                </div>
            </div>
        </label> -->
    </div>




@endsection
