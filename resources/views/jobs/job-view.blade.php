@extends('layouts.single-view')
@section('title', $pageName )

@php
$additionalData = ['job'=>$job];
@endphp

@section('openGraph')
{!! getMetaTags('App\Seo\JobSingleView',$additionalData) !!}
@endsection
@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/jobs.js') }}"></script>
    @if($job->interview_location!="")
    <script type="text/javascript" src="{{ asset('js/maps.js') }}"></script>
    @endif
    <script type="text/javascript" src="{{ asset('js/whatsapp-button.js') }}"></script>
    <!-- <script type="text/javascript" src="/js/custom.js"></script> -->
    @if(Session::has('job_review_pending')) 
     <script type="text/javascript">
    $(document).ready(function() {
        $('#job-review').modal('show');
    });
    </script> 
    @endif 

    {!! getPageLdJson('App\Seo\JobSingleView',$additionalData) !!}
@endsection



@section('single-view-data')
<div class="container">
   <div class="row m-t-30 m-b-30 mobile-flex breadcrums-container single-breadcrums">
      <div class="col-sm-8  flex-col">
         <!-- Breadcrums -->
          
         {!! getPageBreadcrum('App\Seo\JobSingleView',$additionalData) !!}

         <!-- Breadcrums ends -->
      </div>
      <div class="col-sm-4 flex-col">
         <!-- Slide navigation -->
         <div class="slide-nav flex-row">
            <!-- <div class="slide-nav__prev">
               <a href="" class="slide-nav__link flex-row hvr-backward">
                   <i class="fa fa-arrow-left arrow-icon p-r-10" aria-hidden="true"></i>
                   <span class="slide-nav__title">Prev list</span>
               </a>
               </div>
               <div class="slide-nav__next">
               <a href="" class="slide-nav__link flex-row hvr-forward">
                   <span class="slide-nav__title">Next list</span>
                   <i class="fa fa-arrow-right arrow-icon p-l-10" aria-hidden="true"></i>
               </a>
               </div> -->
            @if($job->jobPublishedOn()!="")
            <p class="m-b-0 published-title job-published-date lighter default-size">Published On: {{ $job->jobPublishedOn() }}</p>
            @endif

            @if($job->canEditJob())
            <a href="{{ url('/jobs/'.$job->reference_id.'/job-details') }}" class="no-decor"><button type="button" class="share-btn edit-job flex-row"><i class="fa fa-pencil" aria-hidden="true"></i> Edit your job</button></a>
            @endif                        
         </div>
         <!-- slide navigation ends -->
      </div>
   </div>
   <!-- premium benefits -->
   <div class="row hidden">
      <div class="col-sm-12">
         <div class="pre-benefits flex-row">
            <div class="pre-benefits__intro flex-row">
               <img src="/img/power-icon.png" class="img-repsonsive" width="50">
               <div class="pre-benefits__content">
                  <h5 class="section-title pre-benefits__title">What are the benefits of registering as premium?</h5>
                  <p class="pre-benefits__caption lighter text-color m-b-0">You are currently using a free version of F&amp;BCircle to upgrade to the premium version click upgrade premium</p>
               </div>
            </div>
            <button type="button" class="btn fnb-btn primary-btn full border-btn upgrade">Upgrade Premium</button>
         </div>
      </div>
   </div>
   <!-- pending review -->
   @if($job->canEditJob())
   <div class="row">
      <div class="col-sm-12">
         <div class="pre-benefits pending-review flex-row  @if(!$job->submitForReview() && !$job->getNextActionButton()) pending-no-action  alert alert-dismissible fade in @endif">
            <div class="pre-benefits__intro flex-row">
               <div class="pre-benefits__content">
                  <h5 class="sub-title pre-benefits__title m-b-0">The current status of your job listing is <b>{{ $job->getJobStatus()}} </b> 
                  @if($job->status == 1)
                  <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Job will remain in draft status till submitted for review."></i>
                  @endif
                  </h5>
               </div>
            </div>
            @if(!$job->submitForReview() && !$job->getNextActionButton())
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&#10005;</span></button>
            @endif

            @if($job->submitForReview()) 
             <a href="{{ url('/jobs/'.$job->reference_id.'/submit-for-review') }}"><button type="button" class="btn fnb-btn primary-btn full border-btn upgrade">Submit for review</button></a>
            @endif

            @if($job->getNextActionButton())
                @php
                $nextActionBtn =$job->getNextActionButton();
                @endphp
          <a @if($job->status != 5) data-toggle="modal" data-target="#confirmBox" href="#" @else href="{{ url('/jobs/'.$job->reference_id.'/update-status/'.str_slug($nextActionBtn['status'])) }}"  @endif >
          <button type="button" class="btn fnb-btn primary-btn full border-btn upgrade">{{ $nextActionBtn['status'] }}</button></a>
            
             
            @endif
         </div>
      </div>
   </div>
  @endif

<!--    @if($job->status != 3 && $job->status != 4)
   <div class="row">
      <div class="col-sm-12">
         <div class="pre-benefits pending-review flex-row publish-warning alert alert-dismissible fade in" role="alert">
            <div class="pre-benefits__intro flex-row">
               <div class="pre-benefits__content">
                  <h5 class="sub-title pre-benefits__title m-b-0">You're viewing the job which is not yet published.</h5>
               </div>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&#10005;</span></button>
         </div>
      </div>
   </div>
   @endif -->
   <!-- premium benefits ends -->
   <!-- edit business listing -->
   <!--                 <div class="row">
      <div class="col-sm-8"></div>
      <div class="col-sm-4">
          <div class="edit-listing text-right">
              <a class="secondary-link flex-row edit-listing__container" href="">
                  <i class="fa fa-pencil-square-o p-r-5 edit-icon" aria-hidden="true"></i>
                  <p class="section-title m-b-0">Edit business listing</p>
              </a>
          </div>
      </div>
      </div> -->
   <!-- business listing ends -->
   <div class="row">
      <div class="col-sm-8">
         <div class="spacer">
            <!-- Card Info starts -->
            <div class="seller-info card design-2-card job-info">
               <div class="seller-info__header flex-row">
               </div>
               <div class="seller-info__body">
                  <div class="flex-row space-between">
                    <div class="location main-loc flex-row text-primary m-b-5">
                       <!-- <span class="fnb-icons map-icon"></span> -->
                       <!-- <i class="fa fa-tag p-r-5 x-small" aria-hidden="true"></i> -->
                       <a href="#" class="location__title default-size fnb-label wholesaler lighter no-decor" title="Find all jobs matching {{ $job->getJobCategoryName() }}">{{ $job->getJobCategoryName() }}</a>
                    </div>
                    <!-- publish date -->
                    <!-- @if($job->jobPublishedOn()!='')
                    <div class="pusblished-date text-color lighter text-right x-small hidden ">Published on : <b>{{ $job->jobPublishedOn()}}</b></div>
                    @endif -->
                  </div>
                  <div class="flex-row space-between jobs-head-title">
                     <h1 class="seller-info__title main-heading">{{ $job->title }}</h1>
                     <!-- <a href="" class="secondary-link"><p class="m-b-0"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</p></a> -->
                     <!-- <img src="../public/img/power-seller.png" class="img-responsive mobile-hide" width="130"> -->
                     <!-- <img src="/img/power-icon.png" class="img-responsive" width="30"> -->
                  </div>

                  <div class="operations p-t-10 flex-row flex-wrap role-selection new-roles">
                     @if(!empty($keywords))
                       <div class="job-role">
                          <h2 class="operations__title sub-title m-t-5">Job Role</h2>
                          <ul class="j-role flex-row">

                            @foreach($keywords as $keyword)
                             <li>
                                <p class="default-size cities__title"> <a href="#" class="primary-link" title="Find all jobs matching {{ $keyword }}"> {{ $keyword }}</a> </p>

                             </li>
                             @endforeach

                             <!-- @if($moreKeywordCount) -->
                             <!-- <li class="remain more-show">
                                <a href="" class="secondary-link">+{{ $moreKeywordCount }}</a>
                             </li> -->
                            <!--  <i class="fa fa-ellipsis-h text-color" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></i>
                             @endif -->
                            
                          </ul>
                       </div>
                    @endif
                    
                </div>

                <div class="operations p-t-10 flex-row flex-wrap role-selection detachsection">

                      <div class="job-places">
                        <h2 class="operations__title sub-title">Job Location</h2>
                        @foreach($locations as $city => $locAreas)
                          
                        <div class="opertaions__container flex-row job-location">
                           <div class="location flex-row">
                               <!-- <span class="fnb-icons map-icon"></span> -->
                               <i class="fa fa-map-marker p-r-5 text-color" aria-hidden="true"></i>
                               <p class="default-size location__title c-title flex-row space-between">{{ $city }} <i class="fa fa-caret-right p-l-5 p-r-5" aria-hidden="true"></i></h6>
                           </div>

                           <ul class="cities flex-row">

                              <?php
                              $splitAreas =  splitJobArrayData($locAreas,2);
                              $areas = $splitAreas['array'];
                              $moreAreas = $splitAreas['moreArray'];
                              $moreAreaCount = $splitAreas['moreArrayCount'];
                              $areaCount = count($areas);
                              $areaInc = 0;
                              ?>
                              @foreach($areas as $area)
                                <?php
                                 $areaInc++;
                                ?>
                               <li>
                                  <p class="cities__title">{{ $area }} 
                   
                                  @if($areaInc != $areaCount)
                                   , 
                                  @endif

                                  </p>
                               </li>
                              @endforeach  

                               @if($moreAreaCount) 
                               <!-- <li class="remain more-show">
                                   <a href="" class="secondary-link remain__number">+10</a>
                               </li> -->
 
                            <!--    <i class="fa fa-ellipsis-h text-color" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ implode (',',$moreAreas)}}"></i> -->
                               <span class="x-small text-secondary cursor-pointer" data-toggle="tooltip" data-placement="top" title="{{ implode (',',$moreAreas)}}">+{{ $moreAreaCount}} more</span>
 
                              @endif
                           </ul>
                        </div>
                          @endforeach  

                      </div>


                      <!-- map address -->
                    @if($job->interview_location!="")
                    <div class="owner-address">
                      <h6 class="operations__title sub-title">Interview Address</h6>
                      <!-- <span class="fnb-icons map-icon"></span> -->
                      <div class="flex-row align-top">
                        <i class="fa fa-map-marker p-r-5 loc-icon text-color" aria-hidden="true"></i>
                        <div class="text-color lighter mapAddress scroll-to-location" title="See the map view for interview address">{{ $job->interview_location }}</div>  
                      </div>
                      
                     </div>
                    @endif


                    
                </div>
                @if(!empty($contactEmail) || !empty($contactMobile) || !empty($contactLandline))
                <div class="operations p-t-10 flex-row flex-wrap role-selection contact-stuff">
                    <button class="btn fnb-btn primary-btn full border-btn" data-toggle="collapse" data-target="#contact-data">Show contact info</button>
                    <!-- contact info -->
                    <div class="card seller-info sell-re collapse" id="contact-data">
                       <div class="contact-info flex-row flex-wrap">
                          <div class="close-contact" data-toggle="collapse" href="#contact-data">
                             &#10005;
                          </div>
                          @if(!empty($contactEmail))
                          <div class="mail-us collapse-section m-r-15 m-b-15">
                             <h6 class="sub-title m-t-0">Email:</h6>
                               <div class="number flex-row flex-wrap">
                                @foreach($contactEmail as $email)
                                  @if($email['visible'])
                                  <a class="number__real secondary-link" href="mailto:{{ $email['email'] }}" title="{{ $email['email'] }}">{{ $email['email'] }}</a>
                                  @endif
                                @endforeach
                                    
                               </div>
                             
                          </div>
                          @endif

                           @if(!empty($contactMobile))
                          <div class="phone collapse-section m-r-15 m-b-15">
                             <h6 class="sub-title m-t-0">Mobile No:</h6>
                             <div class="number flex-row flex-wrap">
                             @foreach($contactMobile as $mobile)
                              @if($mobile['visible'])
                                <a class="number__real secondary-link" href="tel:+{{ $mobile['country_code']}}{{ $mobile['mobile']}}" title="+{{ $mobile['country_code']}} {{ $mobile['mobile']}}">+{{ $mobile['country_code']}} {{ $mobile['mobile']}}</a>
                              @endif
                            @endforeach  
                             </div>
                             
                          </div>
                          @endif

                          @if(!empty($contactLandline))
                          <div class="mail-us collapse-section">
                             <h6 class="sub-title m-t-0">Landline No:</h6>
                            <div class="number flex-row flex-wrap">
                                @foreach($contactLandline as $landline)
                                @if($landline['visible'])
                                  <a class="number__real secondary-link" href="tel:+{{ $landline['country_code']}}{{ $landline['landline']}}" title="+{{ $landline['country_code']}} {{ $landline['landline']}}">+{{ $landline['country_code']}} {{ $landline['landline']}}</a>
                                @endif
                              @endforeach  
                             </div>
                          </div>
                          @endif
                          
                       </div>
                    </div>
                </div>
                @endif


             </div> 


            </div>
            
            <!-- Card info ends -->

            <!-- contact info ends -->
            <!-- updates section -->
            <div class="update-sec m-t-30" id="updates">

            </div>
            <!-- update section ends -->
            <!-- listed -->
            <div class="listed p-t-5 p-b-10" id="listed">
               <h3 class="jobDesc">Job Description</h3>
               <hr>
               <div class="job-desc text-color stable-size">
                  {!! $job->description !!}
               </div>
              
               @if($job->interview_location!="")
               <div class="job-summary job-points">
                  <h6 class="sub-title m-b-15">Map address of Interview Location</h6>
                  <div class="text-color stable-size">
                      
                      <div class="m-t-10" id="map" map-title="your interview location" show-address="yes">

                      </div>
                      <input type="hidden" id=latitude name=latitude value="{{ $job->interview_location_lat }}">
                      <input type="hidden" id=longitude name=longitude value="{{ $job->interview_location_long  }}">
                  </div>
               </div>
              @endif
               <!-- @if(!empty($jobCompany->description))
              <h5 class="jobDesc m-t-15" id="about-company">About Company</h5>
               <hr>
               <div class="job-desc text-color stable-size">
                  {!! $jobCompany->description !!}
               </div>
              @endif -->
               <div class="footer-share flex-row">
                  @if($job->canEditJob())
                    <p class="sub-title m-b-0 text-color bolder">Number of job applicants : 0</p>
                  @else
                  <button class="btn fnb-btn primary-btn full border-btn" type="button">Apply Now</button>
                  @endif






                  @if($job->isPublished())
                  <div class="share-job flex-row">
                     <p class="sub-title heavier m-b-0 p-r-10">Share: </p>
                     <ul class="options flex-row flex-wrap">
                        <li class="desk-hide whats-app-row" ><a href="{{ $watsappShare }}" target="_blank" title="Share Job on Whatsapp"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                        <li><a href="{{ $linkedInShare }}" target="_blank" title="Share Job on Linkedin"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                        
                        <li><a href="{{ $facebookShare }}" target="_blank" title="Share Job on Facebook"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                        
                        </li>
                        <li><a href="{{ $twitterShare }}" target="_blank" title="Share Job on Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="{{ $googleShare }}" target="_blank" title="Share Job on Google+"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                     </ul>
                  </div>
                  @endif
               </div>
            </div>
            <hr>
            <!-- listed ends -->


        @if($similarjobs->count())
            <div class="similar-business p-t-20 p-b-20" id="business">
              <div class="section-start-head m-b-15 flex-row">
                <h6 class="element-title">Similar Jobs</h6>
                <a href="#" class="secondary-link view-more heavier">View More</a>
              </div>
              <div class="similar-business__section flex-row">
              @foreach($similarjobs as $similarjob)
                <div class="card business-card article-col">
                  <div class="business-card__body">
                    <div class="flex-row space-between">
                      <div class="location main-loc flex-row text-primary m-b-5 similar-cat">
                         <a href="#" class="location__title x-small fnb-label wholesaler lighter no-decor">{{ $similarjob->getJobCategoryName() }}</a>
                      </div>
                    </div>
                    <div class="address">
                        <p class="sub-title heavier">{{ $similarjob->title }}</p>
                        <p class="m-b-0 lighter address-title m-t-5"><i class="fa fa-map-marker p-r-5" aria-hidden="true"></i> {{ implode(', ',$similarjob->getJobLocationNames('city'))}}</p>

                        @if(!empty($similarjob->getJobExperience()))
                        <p class="m-b-0 lighter address-title m-t-5"><i class="fa fa-briefcase p-r-5" aria-hidden="true"></i> <span class="default-size">{{ implode(',',$similarjob->getJobExperience()) }} years</span></p>
                        @endif
                    </div>
                  </div>
                  <div class="business-card__footer flex-row">
                    <p class="sub-title heavier footer-text"><a href="{{ url('/job/'.$similarjob->getJobSlug()) }}">Get Details <i class="fa fa-caret-right p-l-5" aria-hidden="true"></i></a></p>
                    <span class="x-small date lighter">Published on {{ $similarjob->jobPublishedOn(3) }}</span>
                  </div>
                </div>
              @endforeach
              </div>
            </div>
            <!-- similar business ends -->
          @endif


        <!-- Related article section -->
       
          <div class="related-article p-b-20" id="article">
              <div class="section-start-head m-b-15 flex-row">
                <h6 class="element-title">Related News Articles</h6>
                <a href="" class="secondary-link view-more heavier">View More</a>
              </div>
              <div class="related-article__section flex-row align-top">
                <div class="related-article__col article-col fnb-article">
                  <a href="" class="article-link">
                    <div class="fnb-article__banner"></div>
                    <div class="fnb-article__content m-t-15">
                      <h6 class="sub-title fnb-article__title">Preparing for a Career as a Chef</h6>
                      <p class="fnb-article__caption default-size text-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam dolores, perferendis possimus nostrum atque ex enim obcaecati harum facilis id.</p>
                      <span class="dis-block fnb-article__caption lighter date">Posted on 20 Dec</span>
                    </div>
                  </a>
                </div>
                <div class="related-article__col article-col fnb-article">
                  <a href="" class="article-link">
                    <div class="fnb-article__banner banner-2"></div>
                    <div class="fnb-article__content m-t-15">
                      <h6 class="sub-title fnb-article__title">19 pieces of advice all line cooks should read</h6>
                      <p class="fnb-article__caption default-size text-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam dolores, perferendis possimus nostrum atque ex enim obcaecati harum facilis id.</p>
                      <span class="dis-block fnb-article__caption lighter date">Posted on 20 Dec</span>
                    </div>
                  </a>
                </div>
              </div>
            </div>
         </div>
      </div>
      <div class="col-sm-4 tes">
         <div class="detach-col-1">
            <div class="equal-col job-equal-col">
               <div class="contact__info applyJob">
                  <!-- If logged in -->
                  <!-- If not logged in -->
                  @if($job->status != 3 && $job->status != 4)
                   
                  <h5 class="sub-title pre-benefits__title m-b-0 no-published">You're viewing the job which is not yet published.</h5>
                               
                   @endif

                  @if($job->canEditJob())
                     <p class="sub-title m-b-0 text-color bolder">Number of job applicants : 0</p>
                  @else
                  <button class="btn fnb-btn primary-btn full border-btn" type="button"><i class="p-r-5 fa fa-paper-plane-o" aria-hidden="true"></i> Apply now</button>
                  
                  <!-- <h1 class="m-b-0">20</h1> -->
                  <a href="#" class="secondary-link p-l-20 dis-block" title="Get Email Alert"><i class="fa fa-envelope p-r-5" aria-hidden="true"></i> Send me jobs like this</a>
                  @endif
               </div>
              @if($job->isPublished()) 
               <div class="share-job flex-row justify-center">
                  <p class="sub-title heavier m-b-0 p-r-10">Share: </p>
                  <ul class="options flex-row flex-wrap">
                     <li class="desk-hide whats-app-row" >
                     <a href="whatsapp://send" data-text="{{ $shareTitle }}" data-href="{{ $shareLink }}" class="wa_btn wa_btn_s hidden " style="display:none"><i class="fa fa-whatsapp" aria-hidden="true"></i></a> 
                     <a href="{{ $watsappShare }}" target="_blank" title="Share Job on Whatsapp"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                     <li><a href="{{ $linkedInShare }}" target="_blank" title="Share Job on Linkedin"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                     <li>
                     <a href="{{ $facebookShare }}" target="_blank" title="Share Job on Facebook"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                     <li><a href="{{ $twitterShare }}" target="_blank" title="Share Job on Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                     <li><a href="{{ $googleShare }}" target="_blank" title="Share Job on Google+"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                  </ul>
               </div>
               
              @endif
            </div>
            <!-- Advertisement ends -->
            <div class="featured-jobs browse-cat company-section">
              @if(!empty($jobTypes))
               <h6 class="m-t-0 company-section__title">Job Type</h6>
               <div class="featured-jobs__row flex-row">
                    <div class="job-type">
                    @foreach($jobTypes as $jobType)
                     <div class="text-color year-exp">{{ $jobType }}</div>
                    @endforeach
                    </div>
               </div>
               @endif
               <h6 class="m-t-0 company-section__title">Offered Salary</h6>
               <div class="featured-jobs__row flex-row">
                   @if($job->salary_lower >="0" && $job->salary_upper > "0" )
                    <div class="text-color">
                      @if($job->salary_lower == $job->salary_upper )
                      <i class="fa fa-inr text-color" aria-hidden="true"></i> {{ moneyFormatIndia($job->salary_lower) }}
                      @else
                      <i class="fa fa-inr text-color" aria-hidden="true"></i> {{ moneyFormatIndia($job->salary_lower) }} - <i class="fa fa-inr text-color" aria-hidden="true"></i> {{ moneyFormatIndia($job->salary_upper) }} 
                      @endif
                    {{ $job->getSalaryTypeShortForm()}}
                    </div>

                    @else
                    <div class="text-color lighter">Not disclosed</div>
                    @endif
               </div>
               @if(!empty($experience))
               <h6 class="m-t-0 company-section__title">Years Of Experience</h6>
               <div class="featured-jobs__row flex-row">
                   <div class="year-exp">
                      <div class="flex-row flex-wrap">
                        @foreach($experience as $exp)
                         <div class="text-color year-exp">{{ $exp }} years</div>
                        @endforeach
                      </div>
                   </div>
               </div>
               @endif
               <h3 class="m-t-0 company-section__title">Company Info</h3>
               <div class="featured-jobs__row job-data">
                  <div class="flex-row align-top">
                    <div class="joblogo">
                      @if(($jobCompany->logo))
                       <img src="{{ $companyLogo }}" width="60">
                      @else
                      <img src="/img/company-placeholder.jpg" width="60">
                      @endif
                    </div>
                    <div class="jobdesc">
                        <p class="default-size heavier m-b-0">{{ $jobCompany->title }}</p>
                        <span class="x-small text-color">
                        @if(!empty($jobCompany->website))
                           <a href="{{ $jobCompany->website }}" class="primary-link default-size ellipsis-2" title="{{ $jobCompany->website }}" target="_blank" title="{{ $jobCompany->title }}">{{ $jobCompany->website }}</a>
                           @endif
                        </span>
                     </div>
                  </div>
               </div>
                @if(!empty($jobCompany->description))
                  <h6 class="m-t-0 company-section__title">About Company</h6>
                  <div class="featured-jobs__row">
                     <div class="readMore">
                        <span class="x-small text-color">
                          <!-- {!! $jobCompany->description !!} -->
                          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas libero pariatur consequatur quibusdam doloribus aliquid commodi laudantium quaerat, dicta perferendis enim, ea quis debitis consequuntur quisquam magni nam quia fugiat.
                        </span>
                     </div>
                  </div>
                  @endif
            </div>
            <div class="advertisement flex-row m-t-40">
               <h6 class="element-title">Advertisement</h6>
            </div>
            <!-- advertisement ends -->
         </div>
                  <!-- Featured Jobs -->
        <div class="featured-jobs browse-cat hidden ">
           <h6 class="element-title m-t-0">Featured Jobs</h6>
           <hr>
           <div class="featured-jobs__row flex-row">
              <div class="joblogo">
                 <img src="http://via.placeholder.com/60x60">
              </div>
              <div class="jobdesc ellipsis">
                 <div>
                    <p class="default-size heavier m-b-0 ellipsis">Regional Manager food Service</p>
                    <span class="x-small text-color">Contactx Resource Management</span>
                 </div>
                 <div class="location flex-row">
                    <span class="fnb-icons map-icon"></span>
                    <span class="x-small">Delhi</span>
                 </div>
              </div>
           </div>
           <div class="featured-jobs__row flex-row">
              <div class="joblogo">
                 <img src="http://via.placeholder.com/60x60">
              </div>
              <div class="jobdesc">
                 <div>
                    <p class="default-size heavier m-b-0">Regional Manager food Service</p>
                    <span class="x-small text-color">Contactx Resource Management</span>
                 </div>
                 <div class="location flex-row">
                    <span class="fnb-icons map-icon"></span>
                    <span class="x-small">Delhi</span>
                 </div>
              </div>
           </div>
           <div class="featured-jobs__row flex-row">
              <div class="joblogo">
                 <img src="http://via.placeholder.com/60x60">
              </div>
              <div class="jobdesc">
                 <div>
                    <p class="default-size heavier m-b-0">Regional Manager food Service</p>
                    <span class="x-small text-color">Contactx Resource Management</span>
                 </div>
                 <div class="location flex-row">
                    <span class="fnb-icons map-icon"></span>
                    <span class="x-small">Delhi</span>
                 </div>
              </div>
           </div>
           <div class="featured-jobs__row flex-row">
              <div class="joblogo">
                 <img src="http://via.placeholder.com/60x60">
              </div>
              <div class="jobdesc">
                 <div>
                    <p class="default-size heavier m-b-0">Regional Manager food Service</p>
                    <span class="x-small text-color">Contactx Resource Management</span>
                 </div>
                 <div class="location flex-row">
                    <span class="fnb-icons map-icon"></span>
                    <span class="x-small">Delhi</span>
                 </div>
              </div>
           </div>
        </div>
        <!-- End featured jobs -->
        <!-- Similar Jobs -->
      
        <!-- Similar jobs -->
        <!-- Claim -->
        <div class="claim-box p-b-10 job-post">
           <!-- <i class="fa fa-commenting claim__icon" aria-hidden="true"></i> -->
           <!-- <img src="img/exclamation.png" class="img-reponsive"> -->
           <!-- <span class="fnb-icons exclamation"></span> -->
           <p class="claim-box__text sub-title text-center">Post a job on FnB Circle for free!</p>
           <div class="contact__enquiry text-center m-t-15">    
              <a href="{{ url('jobs/create') }}"><button class="btn fnb-btn primary-btn full border-btn" type="button"><i class="p-r-5 fa fa-paper-plane-o" aria-hidden="true"></i> Post your job</button></a>
           </div>
        </div>

         <!-- browse category -->
         <div class="browse-cat list-of-business">
            <h6 class="element-title">FnB Circle also has business listings</h6>
            <span class="text-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit, doloribus.</span>
            <ul class="browse-cat__list m-t-20">
               <li>
                  <a href="">
                     <p class="m-b-0 flex-row">
                        <span class="fnb-icons cat-icon veg">
                           <!-- <img src="img/veg-option.png"> -->
                        </span>
                        Vegetables <span class="total p-l-5 bolder">(218)</span>
                     </p>
                  </a>
               </li>
               <li>
                  <a href="">
                     <p class="m-b-0 flex-row">
                        <span class="fnb-icons cat-icon drinks"></span>
                        Cold Drinks <span class="total p-l-5 bolder">(28)</span>
                     </p>
                  </a>
               </li>
               <li>
                  <a href="">
                     <p class="m-b-0 flex-row">
                        <span class="fnb-icons cat-icon grocery"></span>
                        Grocery <span class="total p-l-5 bolder">(56)</span>
                     </p>
                  </a>
               </li>
               <li>
                  <a href="">
                     <p class="m-b-0 flex-row">
                        <span class="fnb-icons cat-icon drinks"></span>
                        Cold Drinks <span class="total p-l-5 bolder">(28)</span>
                     </p>
                  </a>
               </li>
            </ul>
         </div>
    

      </div>
   </div>
   <div class="row m-t-30 m-b-30 why-row">
      <div class="col-sm-12">
         <!-- why fnb -->
         <div class="why-fnb text-center m-b-30 p-b-30">
            <h3 class="element-title">Why FnB Circle?</h3>
            <ul class="points m-t-30 flex-row">
               <li>
                  <!-- <img src="img/quotes.png" class="img-responsive m-t-20 m-b-20 icons" alt=""> -->
                  <span class="why-icon quote"></span>
                  <p class="sub-title heavier">Hospitality News</p>
                  <p class="default-size m-b-0 text-lighter why-captions">Stay upto date and profit from the latest Hospitality industry News, Trends and Research</p>
               </li>
               <li>
                  <span class="why-icon supplier"></span>
                  <!-- <img src="img/suppliers.png" class="img-responsive m-t-20 m-b-20 icons" alt=""> -->
                  <p class="sub-title heavier">Your own Purchase Department</p>
                  <p class="default-size m-b-0 text-lighter why-captions">Find the best vendors for your products &amp; services or let them come to you.</p>
               </li>
               <li>
                  <!-- <img src="img/jobs.png" class="img-responsive m-t-20 m-b-20 icons" alt=""> -->
                  <span class="why-icon jobs"></span>
                  <p class="sub-title heavier">Your own H.R. Department</p>
                  <p class="default-size m-b-0 text-lighter why-captions">Hire the best talent to manage your business or find the most suitable job for yourself.</p>
               </li>
               <li>
                  <!-- <img src="img/updates.png" class="img-responsive m-t-20 m-b-20 icons" alt=""> -->
                  <span class="why-icon news"></span>
                  <p class="sub-title heavier">Sales for Vendors/Suppliers</p>
                  <p class="default-size m-b-0 text-lighter why-captions">Find new products &amp; opportunities and take your products to news customers.</p>
               </li>
            </ul>
         </div>
      </div>
   </div>

</div>

@include('jobs.job-status-modal')
@endsection
