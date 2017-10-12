<!-- Modal -->
  <!-- listing review -->
  @if($job->id)
  <div class="modal fnb-modal listing-review job-review fade modal-center" id="job-review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button class="close" data-dismiss="modal" aria-label="Close">&#10005;</button>
              </div>
              <div class="modal-body text-center">
                  <div class="listing-message">
                      @if($job->status == 2 )
                      <i class="fa fa-check-circle check" aria-hidden="true"></i>
                      <h4 class="element-title heavier">We have sent your job for review</h4>
                      <p class="default-size text-color lighter list-caption">Our team will review your job and you will be notified if your job is published.</p>
                      @elseif($job->status == 3 )
                      <i class="fa fa-check-circle check" aria-hidden="true"></i>
                      <h4 class="element-title heavier">Your job is now published</h4>
                      @elseif($job->status == 4 )
                      <i class="fa fa-check-circle check" aria-hidden="true"></i>
                      <h4 class="element-title heavier">Your job is now archived</h4>
                      @endif
                  </div>
                  <div class="listing-status highlight-color">
                      <p class="m-b-0 text-darker heavier">The current status of your job is</p>
                      <div class="pending text-darker heavier sub-title"><i class="fa fa-clock-o text-primary p-r-5" aria-hidden="true"></i> {{ $job->getJobStatus()}}  <!-- <i class="fa fa-info-circle text-darker p-l-5" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pending review"></i> --></div>
                  </div>
              </div>
              <div class="modal-footer">
                      <button class="btn fnb-btn outline cancel-modal border-btn" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
  @endif
 

 @if($job->getNextActionButton())
      @php
      $nextActionBtn =$job->getNextActionButton();
      @endphp
                                           
  <div class="modal fnb-modal confirm-box fade modal-center" id="confirmBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="text-medium m-t-0 bolder">Confirm</h5>
              </div>
              <div class="modal-body text-center">
                  <div class="listing-message">
                      <h4 class="element-title text-medium text-left text-color">Are you sure you want to {{ $nextActionBtn['status'] }} job?</h4>
                  </div>  
                  <div class="confirm-actions text-right">
                      <a href="{{ url('/jobs/'.$job->reference_id.'/update-status/'.str_slug($nextActionBtn['status'])) }}" > <button class="btn fnb-btn text-primary border-btn no-border" >Ok</button></a>
                        <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal">Cancel</button>
                  </div>
              </div>
              <!-- <div class="modal-footer">
                  <button class="btn fnb-btn outline cancel-modal border-btn" data-dismiss="modal">Close</button>
              </div> -->
          </div>
      </div>
  </div>
  @endif
