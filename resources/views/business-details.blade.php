@extends('add-listing')
@section('js')
    @parent
    <script type="text/javascript" src="/js/add-listing-details.js"></script>
@endsection
@section('form-data')

@if(isset($_GET['success']) and $_GET['success']=='true') <div class="alert fnb-alert alert-success alert-dismissible fade in " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    Location &amp; Hours of Operation details saved successfully.
</div>
@endif

<div class="business-details tab-pane fade in active" id="business_details">
    <h5 class="no-m-t main-heading white m-t-0 margin-btm">Business Details</h5>
    <div class="m-t-30 c-gap">
        <label class="label-size">Give us some more details about your listing</label>
        <textarea type="text" class="form-control fnb-textarea no-m-t" placeholder="Describe your business here">{{$listing->description}}</textarea>
    </div>
    <div class="m-t-30 c-gap">
        <label class="label-size">What are the highlights of your business?</label>
        <div class="text-lighter">
            Tell your customer about yourself and what makes your business unique
        </div>
        @php $highlights = json_decode($listing->highlights) @endphp
        @if ($highlights != null)
        @foreach($highlights as $highlight)
        <div class="input-group highlight-input-group">
            <input type="text" class="form-control fnb-input highlight-input" placeholder="" value="{{$highlight}}">
            <span class="input-group-btn">
                <button class="btn fnb-btn outline no-border add-highlight hidden" type="button">
                    <i class="fa fa-plus-circle"></i>
                </button>
                <button class="btn fnb-btn outline no-border delete-highlight" type="button">
                    <small><i class="fa fa-times"></i></small>
                </button>
            </span>
        </div>
        @endforeach
        @endif
        <div class="input-group highlight-input-group">
            <input type="text" class="form-control fnb-input highlight-input" placeholder="">
            <span class="input-group-btn">
                <button class="btn fnb-btn outline no-border add-highlight" type="button">
                    <i class="fa fa-plus-circle"></i>
                </button>
                <button class="btn fnb-btn outline no-border delete-highlight hidden" type="button">
                    <small><i class="fa fa-times"></i></small>
                </button>
            </span>
        </div>
    </div>
    <div class="m-t-30 c-gap">
        @php $details = json_decode($listing->other_details); @endphp
        <div class="row">
            <div class="col-sm-6">

                <label class="label-size">When was your business established?</label>
                <input type="text" class="form-control fnb-input" placeholder="Eg: 1988" data-parsley-type="digits" data-parsley-length="[4,4]" id="established-year" data-parsley-type-message="Please enter valid year" data-parsley-length-message="Please enter valid year" data-parsley-max-message="Business established cannot be a future date" value="@isset($details->established){{$details->established}}@endisset">

            </div>
            <div class="col-sm-6 c-gap">
                <label>Do you have a business website?</label>
                <input type="text" class="form-control fnb-input" id="business-website" placeholder="http://" data-parsley-urlstrict value="@isset($details->website){{$details->website}}@endisset">
            </div>
        </div>
    </div>
    <div class="m-t-30 c-gap">
        <label class="label-size">Payment modes accepted by you:</label>
        <div class="text-lighter">
            Select from the list below or add your own mode
        </div>
        <div class="highlight-color p-t-10 p-l-10 p-r-5 p-b-10 m-t-10 select-all">
            <label class="flex-row heavier">
                <input type="checkbox" class="checkbox" id="selectall"> Select All
            </label>
        </div>
        @php $payment = json_decode($listing->payment_modes); @endphp
        
        <ul class="flex-row payment-modes">
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="visa" @if($payment!=null and $payment->visa) checked @endif> Visa cards
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="debit" @if($payment!=null and $payment->debit) checked @endif > Debit Card
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="money_order" @if($payment!=null and $payment->money_order) checked @endif > Money Order
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="cheque" @if($payment!=null and $payment->cheque) checked @endif > Cheque
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="credit" @if($payment!=null and $payment->credit) checked @endif > Credit Card
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="travelers" @if($payment!=null and $payment->travelers) checked @endif > Travelers Cheque
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="cash" @if($payment!=null and $payment->cash) checked @endif > Cash
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="master" @if($payment!=null and $payment->master) checked @endif > Master Card
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="diners" @if($payment!=null and $payment->diners) checked @endif > Diner's Club
                </label>
            </li>
        </ul>
    </div>
    <div class="m-t-20 c-gap">

        <input type="text" class="form-control fnb-input payment-add flexdatalist" multiple="multiple" placeholder="+ Add modes of payment &amp; press enter">

    </div>
</div>

@endsection