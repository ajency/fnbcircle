@extends('add-listing')

@section('form-data')

<div class="premium tab-pane fade active in" id="business_premium">
<h5 class="no-m-t">Go Premium</h5>
<h6 class="m-t-30 m-b-30">Benefits of going premium</h6>
<div class="row">
    <div class="col-sm-6">
        <!-- <div class="plan text-center m-t-10">
            <div class="mobile-flex plan__container">
                <div>
                    <div class="plan__title mobile-flex">
                        Free Membership
                    </div>
                    <div class="plan__price">
                        Rs. 0.00/month
                    </div>
                </div>
                <i class="fa fa-check-circle desk-hide" aria-hidden="true"></i>
            </div>
            <div class="plan__details">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
            </div>
            <i class="fa fa-check-circle mobile-hide" aria-hidden="true"></i>
        </div> -->
        <ul class="premium-points">
            <li class="flex-row text-color align-top"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
            <li class="flex-row text-color align-top"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
            <li class="flex-row text-color align-top"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
            <li class="flex-row text-color align-top"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
        </ul>
    </div>
    <div class="col-sm-6 c-gap">
        <div class="premium-plan">
            <img src="img/premium_listing.png" class="img-responsive">
           <!--  <label>Premium 1</label>
            <div class="row duration-choose">
                <div class="col-sm-6 dur-col col-text">
                    <div class="col-text__title">
                        Choose a duration
                    </div>
                    <select class="form-control fnb-select border-bottom">
                        <option>Rs. 3000.00/month</option>
                        <option>Rs. 5000.00/month</option>
                    </select>
                </div>
                <div class="col-sm-6 dur-col col-btn">
                    <button class="btn fnb-btn outline full">Subscribe</button>
                </div>
            </div> -->
        </div>
    </div>
</div>
<h6 class="m-t-30 m-b-30">Our Plans</h6>
<!-- pricing grids -->
<div class="pricing-table plans flex-row">
    <div class="pricing-table__cards free-plan active">
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
    </div>
    <div class="pricing-table__cards plan-1">
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
    </div>
    <div class="pricing-table__cards plan-2">
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
    </div>
</div>
<div class="text-right m-t-30 m-b-30 subscribe-plan">
    <button class="btn fnb-btn outline full border-btn" type="button">Subscribe</button>
</div>
</div>

@endsection
