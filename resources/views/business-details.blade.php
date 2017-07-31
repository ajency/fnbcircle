@extends('add-listing')

@section('business-details')

<div class="business-details tab-pane fade in active" id="business-details">
    <h5 class="no-m-t">Business Details</h5>
    <div class="m-t-30 c-gap">
        <label>Give us some more details about your listing</label>
        <textarea type="text" class="form-control fnb-textarea no-m-t" placeholder="Describe your business here"></textarea>
    </div>
    <div class="m-t-30 c-gap">
        <label>What are the highlights of your business?</label>
        <div class="text-lighter">
            Tell your customer about yourself and what makes your business unique
        </div>
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
        <div class="row">
            <div class="col-sm-6">
                <label>When was your business established?</label>
                <input type="text" class="form-control fnb-input" placeholder="Eg: 1988">
            </div>
            <div class="col-sm-6 c-gap">
                <label>Do you have a business website?</label>
                <input type="text" class="form-control fnb-input" placeholder="http://">
            </div>
        </div>
    </div>
    <div class="m-t-30 c-gap">
        <label>Payment modes accepted by you:</label>
        <div class="text-lighter">
            Select from the list below or add your own mode
        </div>
        <div class="highlight-color p-t-10 p-l-10 p-r-5 p-b-10 m-t-10 select-all">
            <label class="flex-row heavier">
                <input type="checkbox" class="checkbox" id="selectall"> Select All
            </label>
        </div>
        <ul class="flex-row payment-modes">
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="visa"> Visa cards
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="debit"> Debit Card
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="money_order"> Money Order
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="cheque"> Cheque
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="credit"> Credit Card
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="travelers"> Travelers Cheque
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="cash"> Cash
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="master"> Master Card
                </label>
            </li>
            <li>
                <label class="flex-row text-medium">
                    <input type="checkbox" class="checkbox" id="diners"> Diner's Club
                </label>
            </li>
        </ul>
    </div>
    <div class="m-t-20 c-gap">
        <input type="text" class="form-control fnb-input" placeholder="+ Add modes of payment &amp; press enter">
    </div>
</div>

@endsection