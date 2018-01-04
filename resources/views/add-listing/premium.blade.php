@extends('layouts.add-listing')

@section('js')
    @parent
    <script type="text/javascript" src="/js/add-listing-premium.js"></script>
@endsection

@section('meta')
  @parent
  <meta property="premium-url" content="{{action('CommonController@premium')}}">
@endsection

@section('form-data')

@if(Session::has('success_message'))
 <div class="alert fnb-alert alert-success alert-dismissible fade in active" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <span class="success-message">{{session('success_message')}}</span>
</div>
<script>
    setTimeout(function(){ $('.alert-success').removeClass('active'); }, 4000);
</script>
@else
 <div class="alert fnb-alert alert-success alert-dismissible fade in " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <span class="success-message">Photos/Documents saved successfully.</span>
</div>
@endif

<div class="premium tab-pane fade active in" id="business_premium">
<div class="flex-row space-between preview-detach">
    <h5 class="no-m-t main-heading white m-t-0">Go Premium</h5>
</div>
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
            <li class="flex-row text-color align-top"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Premium businesses will show up first when users browse through various businesses.</li>
            <li class="flex-row text-color align-top"><i class="fa fa-check p-r-5" aria-hidden="true"></i>On the single view of business page they will not have competitors displayed as similar businesses. For free listings users will be encouraged to visit other businesses.</li>
            <li class="flex-row text-color align-top"><i class="fa fa-check p-r-5" aria-hidden="true"></i>More Leads - Premium businesses will receive more contacts and enquiries and hence a higher rating.</li>
            <li class="flex-row text-color align-top"><i class="fa fa-check p-r-5" aria-hidden="true"></i>Premium businesses will be indicated by a Power Seller badge.</li>
        </ul>
    </div>
    <div class="col-sm-6 c-gap">
        <div class="premium-plan">
            <img src="/img/premium_listing.png" class="img-responsive">
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
<h6 class="m-t-30 m-b-30">Our Plans <span id="pending-request">@if($pending != null) (Request pending) @endif</span></h6>
<!-- pricing grids -->
<div class="pricing-table plans flex-row flex-wrap job-plans listing-plans">
    @foreach($plans as $plan)
    <div class="pricing-table__cards plan-1 premium-plans @if($current['id'] == $plan->id) active @endif @if($plan->slug == 'free-listing') free-plan @if($current['id'] == null) active @endif @endif">
        <label class="plan-label">
            <div class="plans__header">
                @if($plan->slug != 'free-listing')
                <div class="validity">
                    <span class="validity__text"><h6 class="number">{{(int)$plan->duration/30}}</h6>Months</span>
                </div>
                <img src="/img/power-icon.png" class="img-responsive power-icon" width="50">
                @endif
                <h6 class="sub-title text-uppercase plans__title text-color">{{$plan->title}}</h6>
                @if($plan->slug != 'free-listing')
                <div class="plans__fee">
                    <h5><i class="fa fa-inr" aria-hidden="true"></i> {{$plan->amount}}</h5>
                </div>
                @else
                <div class="plans__fee">
                    <h5 class="element-title">Free Membership</h5>
                    <span class="text-lighter lighter default-size"><i class="fa fa-inr" aria-hidden="true"></i> 0.00/month</span>
                </div>
                @endif
                <ul class="points">
                @php $highlights = json_decode($plan->meta_data); @endphp
                    @foreach($highlights as $highlight)
                    <li class="flex-row text-color align-top lighter x-small"><i class="fa fa-check p-r-5" aria-hidden="true"></i>{{$highlight}}</li>
                    @endforeach
                    
                </ul>
            </div>
            <div class="plans__footer">
                <div class="selection">
                    <input type="radio" class="fnb-radio" name="plan-select" value="{{$plan->id}}" @if(($current['id'] == $plan->id) or ($current['id'] == null and $plan->slug == 'free-listing')) checked="" @endif  ></input>
                    <label class="radio-check"></label>
                    <span class="dis-block lighter text-lighter planCaption">
                    @if($current['id'] == $plan->id or ($current['id']==null and $plan->slug=='free-listing')) 
                        Your current plan<br>
                    @elseif($pending != null and $pending->plan_id == $plan->id) 
                        Your request for this plan is under process 
                        <input type="hidden" id="pending-plan" value="{{$pending->plan_id}}">
                    @elseif($current['next'] == $plan->id)
                        Your payment is processed. You will shift to this plan after current cycle
                        <input type="hidden" id="next-plan-selected" value="1">
                    @elseif($current['id'] != $plan->id) Click here to choose this plan 
                    @endif</span>
                </div>
            </div>
        </label>
    </div>
    @endforeach
    
</div>
<div class="text-right m-t-30 m-b-30 subscribe-plan">
    @if($listing->status == 3 or $listing->status == 5)<input type="checkbox" id="submit-terms-check" checked> I agree to the Terms of Service &amp; Privacy Policy of FnB Circle.
    <button id="submit-btn" data-toggle="modal" data-target="#confirmBox" class="btn fnb-btn outline full border-btn" type="button">Submit Listing</button>
    @else
    <button id="submit-btn" data-toggle="modal" data-target="#confirmBox" class="btn fnb-btn outline full border-btn" type="button">Subscribe</button>
    @endif
</div>
</div>

@endsection
