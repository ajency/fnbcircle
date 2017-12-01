@extends('layouts.add-job')
@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/jobs.js') }}"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        if($('input[name="plan_id"]').length == $('.not-for-selection').length){
            $('.job-save-btn').attr('disabled',true);
        }
        // console.log($('input[name="plan_id"]').length);
        // console.log($('.not-for-selection').length);
    });
    </script> 
@endsection
@section('form-data')



@include('jobs.notification')
<!-- <input type="hidden" name="_method" value="PUT"> -->
<input type="hidden" name="step" value="go-premium">
<input type="hidden" name="type" value="job">
<input type="hidden" name="id" value="{{$job->id}}">

<div class="business-info tab-pane fade in active" id="plan_selection">
 
    <!-- <h5 class="no-m-t fly-out-heading-size main-heading white m-t-0 margin-btm ">Job Information</h5> -->
    <div class="flex-row space-between preview-detach">
        <h5 class="nno-m-t main-heading  white m-t-0">Plan Selection</h5>
    </div>

    <!-- Job title/category -->

    

    <div class="pricing-table plans flex-row job-plans">
        @foreach($plans as $plan)
            @php

                if(!empty($activePlan) && $plan->id == $activePlan->plan_id)
                    $active = true;
                elseif(empty($activePlan) && $plan->amount == 0)
                    $active = true;
                else
                    $active = false;

                
                    
                if(!empty($requestedPlan) && $requestedPlan->plan_id == $plan->id) 
                    $disabled = 'disabled';
                elseif(!empty($activePlan) && $plan->amount < $activePlan->plan->amount)
                    $disabled = 'disabled';
                else
                    $disabled = '';

                $selectionclass = ($active || $disabled == 'disabled') ? 'not-for-selection' : '';
                
                 
            @endphp
       
       <input type="hidden" name="is_premium[{{$plan->id}}]" value="@if($plan->amount == 0) 0 @else 1 @endif">    
        <div class="pricing-table__cards  @if($active) active @endif">
            <div class="plans__header">
               <!-- <h6 class="sub-title text-uppercase plans__title text-color">Basic Plan</h6> -->
               @if($plan->amount > 0)
               <img src="/img/power-icon.png" class="img-responsive power-icon" width="50">
               @endif
                <div class="plans__fee">
                    <h5 class="element-title">{{ $plan->title }}</h5>
                    <span class="text-lighter lighter default-size"><i class="fa fa-inr" aria-hidden="true"></i> {{ $plan->amount }}/month</span>
                </div> 
                <ul class="points">
                    @foreach(unserialize($plan->meta_data) as $meta)
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>{{  $meta }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="plans__footer">
                <div class="selection sub-row">
                     <input type="radio" {{ $disabled }} class="fnb-radio {{ $selectionclass }}" name="plan_id" @if($active) checked="" @endif value="{{ $plan->id }}"></input>
                    <label class="radio-check"></label>
                    @if($active)
                    <span class="dis-block lighter text-lighter">Your current plan</span>
                    @elseif(!empty($requestedPlan) && $requestedPlan->plan_id == $plan->id)
                    <span class="dis-block lighter text-lighter">Your request for this plan is under process.<br>
                    click <a href="{{ url('premium/job/'.$job->reference_id.'/cancle-request') }}" class="primary-link">Here</a> to cancel request.
                    </span>  

                    @else
                    <span class="dis-block lighter text-lighter">Change plan</span> 
                     @endif
                    <!-- <button class="btn fnb-btn outline full border-btn def-btn" type="button">Subscribe </i></button>
                    <button class="btn fnb-btn outline full border-btn green-btn" type="button">Selected <i class="fa fa-check check-icon" aria-hidden="true"></i></button> -->
                </div>
            </div>
        </div>
        @endforeach
        
        <!-- <div class="pricing-table__cards plan-1">
            <div class="plans__header">
                  <div class="validity">
                    <span class="validity__text"><h6 class="number">6</h6>Months</span>
                </div> 
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
                      <input type="radio" class="fnb-radio" name="plan-select"></input>
                    <label class="radio-check"></label>
                    <span class="dis-block lighter text-lighter">Your current plan</span>  
                    <button class="btn fnb-btn outline full border-btn def-btn" type="button">Subscribe</button>
                    <button class="btn fnb-btn outline full border-btn green-btn" type="button">Selected <i class="fa fa-check check-icon" aria-hidden="true"></i></button>
                </div>
            </div>
        </div> -->
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
