@extends('layouts.add-listing')
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
        <textarea type="text" rows="4" class="form-control fnb-textarea no-m-t allow-newline" placeholder="Describe your business here">{{$listing->description}}</textarea>
    </div>
    <div class="m-t-30 c-gap">
        <label class="label-size">What are the highlights of your business?</label>
        <div class="text-lighter">
            Mention your business strengths, advantages over competition, top customers/clients, etc to get more leads.
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
        
        <ul class="flex-row payment-modes m-t-10">
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="visa" @if($payment!=null and $payment->visa) checked @endif> <span class="text-color">Visa card</span>
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="debit" @if($payment!=null and $payment->debit) checked @endif > <span class="text-color">Debit Card</span>
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="money_order" @if($payment!=null and $payment->money_order) checked @endif > <span class="text-color">Money Order</span>
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="cheque" @if($payment!=null and $payment->cheque) checked @endif > <span class="text-color">Cheque</span>
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="credit" @if($payment!=null and $payment->credit) checked @endif > <span class="text-color">Credit Card</span>
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="travelers" @if($payment!=null and $payment->travelers) checked @endif > <span class="text-color">Travelers Cheque</span>
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="cash" @if($payment!=null and $payment->cash) checked @endif > <span class="text-color">Cash</span>
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="master" @if($payment!=null and $payment->master) checked @endif > <span class="text-color">Master Card</span>
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="diners" @if($payment!=null and $payment->diners) checked @endif > <span class="text-color">Diners Club Card</span>
                </label>
            </li>
        </ul>
    </div>
    <div class="m-t-20 c-gap">

        <input type="text" class="form-control fnb-input payment-add flexdatalist" multiple="multiple" placeholder="+ Add modes of payment &amp; press enter" list="payment-modes" value="{{ implode(',',$listing->tagNames('payment-modes')) }}">
        <datalist id="payment-modes">
            @php
                $payment_modes = $listing->existingTagsLike('payment-modes','');
                foreach($payment_modes as $mode){
                echo '<option value="'.$mode->slug.'">'.$mode->name.'</option>';
                }
            @endphp
            <option value="visa">Visa cards</option><option value="debit">Debit Card</option><option value="money_order">Money Order</option><option value="cheque">Cheque</option><option value="credit">Credit Card</option><option value="travelers">Travelers Cheque</option><option value="cash">Cash</option><option value="masters">Master Card</option><option value="diners">Diner's Club</option>
        </datalist>
    </div>
</div>

@endsection