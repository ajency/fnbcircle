@extends('layouts.add-job')
@section('js')
    @parent
    <script type="text/javascript" src="/js/jobs.js"></script>
@endsection
@section('form-data')



 

<div class="business-info tab-pane fade in active" id="plan_selection">
 
    <!-- <h5 class="no-m-t fly-out-heading-size main-heading white m-t-0 margin-btm ">Job Information</h5> -->
    <h5 class="nno-m-t main-heading  white m-t-0 margin-btm">Plan Selection</h5>

    <!-- Job title/category -->

    

    <div class="pricing-table plans flex-row">
        <label class="pricing-table__cards free-plan active">
            <div class="plans__header">
               <h6 class="sub-title text-uppercase plans__title text-color">Basic Plan</h6>
                <div class="plans__fee">
                    <h5>Free Membership</h5>
                    <span class="text-lighter lighter sub-title"><i class="fa fa-inr" aria-hidden="true"></i> 0.00/month</span>
                </div> 
            </div>
            <div class="plans__footer">
                <div class="selection">
                    <input type="radio" class="fnb-radio" name="plan-select" checked=""></input>
                    <label class="radio-check"></label>
                    <span class="dis-block lighter text-lighter">Your current plan</span>
                </div>
            </div>
        </label>
        <label class="pricing-table__cards plan-1">
            <div class="plans__header">
                <div class="validity">
                    <span class="validity__text"><h6 class="number">6</h6>Months</span>
                </div>
                <img src="img/power-icon.png" class="img-responsive power-icon" width="50">
                <h6 class="sub-title text-uppercase plans__title text-color">Plan 1</h6>
                <div class="plans__fee">
                    <h5><i class="fa fa-inr" aria-hidden="true"></i> 5,000</h5>
                </div> 
                <ul class="points">
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet.</li>
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit elit.</li>
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet</li>
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                </ul>
            </div>
            <div class="plans__footer">
                <div class="selection">
                    <input type="radio" class="fnb-radio" name="plan-select"></input>
                    <label class="radio-check"></label>
                    <span class="dis-block lighter text-lighter">Your current plan</span>
                </div>
            </div>
        </label>
        <label class="pricing-table__cards plan-2">
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
        </label>
    </div>
    <div class="text-right m-t-30 m-b-30 subscribe-plan">
        <button class="btn fnb-btn outline full border-btn" type="button">Subscribe</button>
    </div>



@endsection
