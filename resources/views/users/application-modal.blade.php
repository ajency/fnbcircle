    <div class="modal fnb-modal center-modal apply-jobs-modal fade customer-job-modal" id="job-application-{{ $job->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Close">&#10005;</button>
            </div>
            <div class="modal-body">
   
                <div class="apply-job-form">
                  <div class="apply-info text-center">
                    <i class="fa fa-briefcase text-lighter" aria-hidden="true"></i>
                    <h6>You have applied for the following job.</h6>
                  </div>
                    <!-- <p class="text-lighter x-small"> -->
                    <div class="jobDetail">
                      <div class="flex-row jobDetail__row align-top">
                        <div class="joblogo">
                          @if(($job->getJobCompany()->logo))
                            <img src="{{ $job->getJobCompany()->getCompanyLogo('company_logo') }}" width="60">
                          @else
                            <img src="/img/company-placeholder.jpg" width="60">
                          @endif
                        </div>
                        <div class="jobdesc">
                          <p class="default-size bolder m-b-0">{{ $job->title }}</p>
                         <!--  <span class="x-small text-color fnb-label">
                          {{ $job->getJobCategoryName() }}
                          </span> -->
                          <span class="x-small text-color dis-block m-t-5 m-b-5 bolder">
                            {{ $job->getJobCompany()->title }}
                          </span>
                          <!-- interview address -->
                          @if($job->interview_location!="")
                          <div class="owner-address m-b-5">
                            <!-- <h6 class="operations__title sub-title">Interview Address</h6> -->
                            <!-- <span class="fnb-icons map-icon"></span> -->
                            <div class="flex-row align-top">
                              <i class="fa fa-map-marker p-r-5 loc-icon text-color" aria-hidden="true"></i>
                              <div class="text-color lighter mapAddress scroll-to-location">{{ $job->interview_location }}</div>  
                            </div>
                            
                           </div>
                          @endif
                          
                          @if(!empty($job->getJobTypes()))
                          <div class="flex-row jobDetail__row">
                             <!-- <h6 class="m-t-0 company-section__title">Job Type</h6> -->
                             <div class="featured-jobs__row flex-row">
                                  <div class="job-type m-t-5">
                                  @foreach($job->getJobTypes() as $jobType)
                                   <div class="text-color year-exp no-comma fnb-label">{{ $jobType }}</div>
                                  @endforeach
                                  </div>
                             </div>
                          </div>
                          @endif

                        </div>
                      </div>
                    </div>

                      <!-- </p> -->
                    <div class=" ">
                     
                        <div class="  flex-row space-between">
                             <h6 class="m-b-20">Your details as follows:</h6> 
                        </div>
                        <div class="row m-b-10">
                            <div class="col-sm-6 form-group c-gap">
                                <label class="label-size">Name: </label>
                                {{ $job->application->name}}
                            </div>
                            <div class="col-sm-6 form-group c-gap">
                                <label class="label-size">Email: </label>
                                {{ $job->application->email}}
                            </div>
                            <div class="col-sm-6 form-group c-gap">
                                <label class="label-size">Phone number: </label>
                                +({{ $job->application->country_code}}) {{ $job->application->phone}}
                            </div>
                            <div class="col-sm-6 form-group c-gap">
                                <label class="label-size">State: </label>
                                @if($job->application->city_id)
                                {{ $job->application->applicantCity->name}}
                                @endif
                            </div>
                        </div>
                        
                        <div class="text-center">
                          <a href="{{ url('/user/'.$job->application->resume_id.'/download-resume')}}" class="btn fnb-btn full primary-btn border-btn default-size"><i class="fa fa-download" aria-hidden="true"></i> Download Resume</a>  
                        </div>
                        
                              
 
                         
                        </div>
                        <div class="validationError text-left"></div>
                    </div>
                 
                 

             
               
            </div>
            <div class="modal-footer verificationFooter">
                <div class="resend-code sub-title text-color">
                     
                </div>
                
            </div>
        </div>
    </div>
</div>
 
