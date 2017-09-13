@extends('layouts.add-job')
@section('js')
    @parent
    <script type="text/javascript" src="/js/jobs.js"></script>
@endsection
@section('form-data')




<div class="business-info tab-pane fade in active" id="add_listing">
    <!-- <h5 class="no-m-t fly-out-heading-size main-heading white m-t-0 margin-btm ">Job Information</h5> -->
    <h5 class="no-m-t fly-out-heading-size main-heading ">Job Information</h5>
    <div class="m-t-30 c-gap">
        <label class="label-size">What is the job title? <span class="text-primary">*</span></label>
        <input type="text" name="job_title" class="form-control fnb-input" placeholder="" value="" data-parsley-required-message="Please enter the job title." data-parsley-required data-parsley-maxlength=255 data-parsley-maxlength-message="Job name cannot be more than 255 characters." data-parsley-required data-parsley-minlength=2 data-parsley-minlength-message="Job name cannot be less than 2 characters.">
        <div class="text-lighter m-t-5">
            This will be the display name of your job.
        </div>
    </div>
    <div class="m-t-50 c-gap">
        <label class="label-size">Choose a category that the job belongs to: <span class="text-primary">*</span></label>
        <!-- <div class="text-lighter">
            Help text comes here
        </div> -->
        <div class="m-t-5 brands-container">
             
             <select class="fnb-select select-variant form-control text-lighter catSelect" name="category" placeholder="Type and hit enter" list="jobCats" id=jobCatsInput value="" data-parsley-required>
                @foreach($jobCategories as $categoryId =>$category)
                <option value = "{{ $categoryId }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="m-t-40 c-gap">
        <label class="label-size">Where is the job located? <span class="text-primary">*</span></label>
        <div class="location-select flex-row flex-wrap">
            <div class="select-col city">
                <select class="fnb-select select-variant form-control text-lighter" name="job_city[]" data-parsley-required data-parsley-required-message="Select a city where the job is located.">
                    <option value="">Select City</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="select-col area">
                <select class="fnb-select select-variant form-control text-lighter" name="job_area[]" data-parsley-required data-parsley-required-message="Select an area where the job is located.">
                    <option value="">Select Area</option>
                </select>
            </div>
        </div>
        <div id="areaError" ></div>
    </div>

    <div class="m-t-40 c-gap">
        <label class="label-size">Where is the job located? <span class="text-primary">*</span></label>
        <div class="location-select flex-row flex-wrap">
            <div class="select-col city">
                <select class="fnb-select select-variant form-control text-lighter" name="job_city[]" data-parsley-required data-parsley-required-message="Select a city where the job is located.">
                    <option value="">Select City</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="select-col area">
                <select class="fnb-select select-variant form-control text-lighter" name="job_area[]" data-parsley-required data-parsley-required-message="Select an area where the job is located.">
                    <option value="">Select Area</option>
                </select>
            </div>
        </div>
        <div id="areaError" ></div>
    </div>
    <div class="m-t-40 c-gap">
        <label class="label-size">Job Description <span class="text-primary">*</span></label>
        <textarea class="form-control fnb-input" name="description" placeholder="Enter a brief summary of the Job" data-parsley-required></textarea>
    </div>

    <div class="m-t-40 c-gap">
        <label class="label-size">What type of job is it?</label>
        <div class="form-group ">
        @foreach($jobTypes as $jobTypeId => $jobType)
          <label class="radio-inline">
            <input type="radio" name="job_type" id="parttime" value="{{ $jobTypeId }}" class="fnb-radio"> {{ $jobType }}
          </label>
        @endforeach 
        </div>
    </div>

    <div class="m-t-50 c-gap">
        <label class="label-size">Required years of experience:</label>
        <div class="m-t-5 brands-container">
            <!-- <input type="text" class="form-control fnb-input years-experience" name="experience" placeholder="Type and hit enter" list="yrsExp" multiple="multiple" id=yrsExpInput value="1" data-value-property='id'> -->
            <select class="fnb-select select-variant form-control " multiple="" id="yrsExp" name="experience[]">
                @foreach($experiencList as $experienceId =>$experience)
                <option value="{{ $experienceId }}" >{{ $experience }}</option>
                @endforeach

            </select>
        </div>
    </div>

    <div class="m-t-40 c-gap">
        <label class="label-size">Offered salary : (optional)</label>
        <div class="form-group ">
        @foreach($salaryTypes as $salaryTypeId => $salaryType)
          <label class="radio-inline">
            <input type="radio" name="salary_type"   value="{{ $salaryTypeId }}" class="fnb-radio"> {{ $salaryType }}
          </label>
        @endforeach 
        </div>

        <input type="text" name="salary_lower" id="salary_lower" data-parsley-type="number"> - <input type="text" name="salary_upper" id="salary_upper" data-parsley-type="number">
    </div>

</div>


<!-- Phone verification -->

<div class="modal fnb-modal verification-step-modal phone-modal fade" id="phone-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">
                <div class="verify-steps default-state">
                    <img src="/img/number-default.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Phone number verification</h6>
                    <p class="text-lighter x-small">Please enter the 4 digit code sent to your number via sms.</p>
                    <div class="number-code">
                        <div class="show-number flex-row space-between">
                            <div class="number">
                                9344556878
                            </div>
                            <a href="#" class="secondary-link edit-number"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT</a>
                        </div>
                        <div class="code-submit flex-row space-between">
                            <input type="password" class="fnb-input text-color" placeholder="Enter code here..." >
                            <button class="btn fnb-btn primary-btn border-btn code-send" type="button">Submit <i class="fa fa-circle-o-notch fa-spin hidden"></i></button>
                        </div>
                       <div class="validationError text-left"></div>
                    </div>
                </div>
                <div class="verify-steps add-number hidden">
                    <img src="/img/number-add.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Please provide a new number for verification.</h6>
                    <div class="number-code">
                        <div class="code-submit flex-row space-between">
                            <input text="tel" class="fnb-input text-color value-enter" placeholder="Enter new number..." data-parsley-errors-container="#phoneError">
                            <button class="btn fnb-btn primary-btn border-btn verify-stuff" type="button">Verify</button>
                        </div>
                        <div id="phoneError" class="customError"></div>
                    </div>
                </div>
                <div class="verify-steps processing hidden">
                    <img src="/img/processing.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Please wait, we are verifying the code...</h6>
                </div>
                <div class="verify-steps step-success hidden">
                    <img src="/img/number-sent.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Your number has been verified successfully!</h6>
                    <div class="number-code">
                        <button class="btn fnb-btn outline border-btn" type="button" data-dismiss="modal">Continue</button>
                    </div>
                </div>
                <div class="verify-steps step-failure hidden">
                    <i class="fa fa-exclamation-triangle text-danger failIcon"></i>
                    <h6 class="sub-title">Validation Failed. Please Try Again</h6>
                    <div class="number-code">
                        <button class="btn fnb-btn outline border-btn" type="button" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer verificationFooter">
                <div class="resend-code sub-title text-color">
                    Didn't receive the code? <a href="#" class="secondary-link resend-link"><span class="resent-title"><i class="fa fa-repeat" aria-hidden="true"></i> Resend SMS</span>
                    <span class="send-title"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i>Sending...</span></a>
                </div>
                <a href="#" class="step-back primary-link"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
        </div>
    </div>
</div>

<!-- Email verification -->


<div class="modal fnb-modal verification-step-modal email-modal fade" id="email-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">
                <div class="verify-steps default-state">
                    <img src="/img/email-default.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Email verification</h6>
                    <p class="text-lighter x-small">Please enter the 4 digit code sent to your email address.</p>
                    <div class="number-code">
                        <div class="show-number flex-row space-between">
                            <div class="number">
                                Qureshi@gmail.com
                            </div>
                            <a href="#" class="secondary-link edit-number"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT</a>
                        </div>
                        <div class="code-submit flex-row space-between">
                            <input text="text" class="fnb-input text-color" placeholder="Enter code here..."  >
                            <button class="btn fnb-btn primary-btn border-btn code-send" type="button">Submit <i class="fa fa-circle-o-notch fa-spin"></i></button>
                        </div>
                        <div class="validationError text-left"></div>
                    </div>
                </div>
                <div class="verify-steps add-number hidden">
                    <img src="/img/email-add.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Please provide a new email for verification.</h6>
                    <div class="number-code">
                        <div class="code-submit flex-row space-between">
                            <input text="email" class="fnb-input text-color value-enter" placeholder="Enter new email..." data-parsley-errors-container="#customError">
                            <button class="btn fnb-btn primary-btn border-btn verify-stuff" type="button">Verify</button>
                        </div>
                        <div id="customError" class="customError"></div>
                    </div>
                </div>
                <div class="verify-steps processing hidden">
                    <img src="/img/email-processing.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Please wait, we are verifying the code...</h6>
                </div>
                <div class="verify-steps step-success hidden">
                    <img src="/img/email-sent.png" class="img-responsive center-block" width="60">
                    <h6 class="sub-title">Your email has been verified successfully!</h6>
                    <div class="number-code">
                        <button class="btn fnb-btn outline border-btn" type="button" data-dismiss="modal">Continue</button>
                    </div>
                </div>
                <div class="verify-steps step-failure hidden">
                    <i class="fa fa-exclamation-triangle text-danger failIcon"></i>
                    <h6 class="sub-title">Validation Failed. Please try again</h6>
                    <div class="number-code">
                        <button class="btn fnb-btn outline border-btn" type="button">Resend</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer verificationFooter">
                <div class="resend-code sub-title text-color">
                    Didn't receive the code? <a href="#" class="secondary-link resend-link"><span class="resent-title"><i class="fa fa-repeat" aria-hidden="true"></i> Resend email</span>
                    <span class="send-title"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i>Sending...</span></a>
                </div>
                <a href="#" class="step-back primary-link"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
        </div>
    </div>
</div>


@endsection
