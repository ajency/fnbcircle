@if($jobs->count())
@foreach($jobs as $key =>$job)
<div class="filter-data @if($key==0 && $append == 'false') @else m-t-30 m-b-30 @endif">
  <div class="seller-info bg-card filter-cards">
 
      <div class="seller-info__body filter-cards__body white-space">
          <div class="body-left flex-cols">
              <div>
                  <div class="flex-row space-between">
                    <h3 class="seller-info__title ellipsis-2" title="{{ $job->title }}"><a href="{{ url('/job/'.$job->getJobSlug()) }}" class="  default-size text-medium secondary-link" target="_blank">{{ $job->title }}</a></h3>

                    @if(isset($showApplication) && $showApplication)
                    <div class="get-details detail-move">
                        <a href="#" class="apply-jobs" data-toggle="modal" data-target="#job-application-{{ $job->id}}"><button class="btn fnb-btn outline full border-btn fullwidth default-size">View Application <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></button></a>
                    </div>
                    @endif
                  
                  </div>
                  <div class="location flex-row companyName space-between flex-wrap">
                      <!-- <span class="fnb-icons map-icon"></span> -->
                      @if(!empty($job->getJobCompany()))
                      <p class="location__title default-size m-b-0 text-lighter">{{ $job->getJobCompany()->title }}</p>
                      @endif

                      @if($job->jobPostedOn()!="")
                      <p class="m-b-0 text-lighter default-size lighter published-date"><i>Posted on: {{ $job->jobPostedOn() }}</i></p>
                       @endif
 
                  </div>
                  <div class="flex-row space-between flex-wrap cat-posted">
                      <div class="rating-view flex-row p-r-10"> 
                      <i class="fa fa-tag p-r-5 text-lighter" aria-hidden="true"></i>
 
                        @if($isListing)
                          <a href="?city={{ $flteredCitySlug }}&category={{ $job->category->slug }}" class="primary-link" title="Find all {{ $job->getJobCategoryName() }} jobs in {{ $flteredCitySlug }}">{{ $job->getJobCategoryName() }}</a>
                        @else
                           {{ $job->getJobCategoryName() }} 
                        @endif
 
                      </div>
                  </div>

                  @if(!empty($job->getJobTypes()))
                  <div class="stats flex-row m-t-10 flex-wrap">
                       
                      @foreach($job->getJobTypes() as $jobType)
                     
                       <label class="fnb-label wholesaler flex-row m-r-5" title="Find all {{ $jobType }} jobs in {{ $flteredCitySlug }}" >
                          <!-- <i class="fa fa-user user p-r-5" aria-hidden="true"></i> -->
                          @if($isListing)
                           <a href='?city={{ $flteredCitySlug }}&job_type=["{{ str_slug($jobType) }}"]' class="primary-link" >{{ $jobType }}</a>
                          @else
                          {{ $jobType }} 
                          @endif
                       </label>

                      @endforeach
                      
                  </div>
                  @endif
              </div>
 
              <div class="flex-row space-between roles-location open-border align-top">
                @if(!empty($job->getJobSavedKeywords(2)))
                @php
                $splitKeywords =  splitJobArrayData($job->getJobSavedKeywords(2),5);
                $keywords = $splitKeywords['array'];
                $moreKeywords = $splitKeywords['moreArray'];
                $moreKeywordCount = $splitKeywords['moreArrayCount'];
                @endphp 
                <div class="cat-holder">
                    <div class="core-cat m-r-5">
                        <p class="default-size grey-darker heavier m-t-0 m-b-5">Job Roles</p>
                        <ul class="fnb-cat flex-row">
                          @foreach($keywords as $keyword)

                          @if($isListing)
                            <li><a href='?city={{ $flteredCitySlug }}&keywords=["{{ $keyword['id'] }}|{{ str_slug($keyword['label']) }}"]' class="fnb-cat__title" title="Find all jobs matching {{ $keyword['label'] }} in {{ $flteredCitySlug }}">{{ $keyword['label'] }}</a></li>
                          @else
                          <li> {{ $keyword['label'] }} </li>
                          @endif
                          @endforeach
 

                          @if($moreKeywordCount) 
                            <li class="cat-more more-show"><a href="{{ url('/job/'.$job->getJobSlug()) }}" class="secondary-link">+{{ $moreKeywordCount }} more</a></li>
                          @endif
                        </ul>
                    </div>
                </div>
                @endif
                <div class="operations">
                    <p class="operations__title default-size grey-darker heavier m-t-0">Job Location:</p>
                    @php
                      $locCounter = 0;
                    @endphp
                    @foreach($job->getJobLocationNames() as $city => $locAreas)
                      @php
                      $locCounter++;
                      if($locCounter > 2)
                        continue;
                      @endphp
                    <div class="operations__container">
                        <div class="location flex-row">
                            <p class="m-b-0 text-color heavier default-size">{{ $city }} <i class="fa fa-caret-right p-l-5 p-r-5" aria-hidden="true"></i>
                            </p>
                            <ul class="cities flex-row">
                            @php
                                  $splitAreas =  splitJobArrayData($locAreas,2);
                                  $areas = $splitAreas['array'];
                                  $moreAreas = $splitAreas['moreArray'];
                                  $moreAreaCount = $splitAreas['moreArrayCount'];
                                  $areaCount = count($areas);
                                  $areaInc = 0;
                            @endphp 
                              @foreach($areas as $area)
                                @php
                                     $areaInc++;
                                @endphp 
                              <li>
                                  <p class="cities__title default-size">{{ $area }}
                                    @if($areaInc != $areaCount)
                                       , 
                                      @endif
                                   </p>
                              </li>
                              @endforeach  
                              
                              @if($moreAreaCount) 
                              <li class="line">
                                  <p class="cities__title default-size">|</p>
                              </li>
                              <li class="remain more-show">
                                  <a href="{{ url('/job/'.$job->getJobSlug()) }}" class="cities__title remain__number default-size text-medium secondary-link">more...</a>
                              </li>
                            @endif
                          </ul>
                        </div>
             
                    </div>
                    @endforeach
                    @if(count($job->getJobLocationNames()) >2)
                     <div class="location flex-row m-t-5">
                        <p class="m-b-0 text-color heavier default-size"> <a href="{{ url('/job/'.$job->getJobSlug()) }}" class="remain__number x-small secondary-link moreLink">+ {{(count($job->getJobLocationNames()) - 2)}}  more...</a>
                        </p>
                    </div> 
                    @endif 
                </div>
              </div>
          </div>
 
         <!--  <div class="recent-updates open-border">
            <p class="operations__title default-size grey-darker heavier m-t-0">Job Description</p>
            <p class="m-t-0 heavier text-lighter text-medium default-size job-list-desc">{{ $job->getShortDescription() }}</p>
          </div> -->

           <div class="recent-updates flex-row flex-wrap open-border space-between align-top">
             <div class="off-salary">
                <p class="operations__title default-size grey-darker heavier m-t-0">Offered Salary</p>

                @if($job->salary_lower >="0" && $job->salary_upper > "0" )

                <div class="text-lighter text-medium">
                  @if($job->salary_lower == $job->salary_upper )
                  <i class="fa fa-inr text-color" aria-hidden="true"></i> {{ moneyFormatIndia($job->salary_lower) }}
                  @else
                  <i class="fa fa-inr text-color" aria-hidden="true"></i> {{ moneyFormatIndia($job->salary_lower) }} - <i class="fa fa-inr text-color" aria-hidden="true"></i> {{ moneyFormatIndia($job->salary_upper) }} 
                  @endif
                {{ $job->getSalaryTypeShortForm()}}</div>

                @else
                <div class="text-lighter text-medium">Not disclosed</div>
                @endif
             </div>  

             @if(!empty($job->meta_data['experience']))
               <div class="year-exp no-comma">
                  <p class="operations__title default-size grey-darker heavier m-t-0">Years Of Experience</p>
                  <div class="flex-row flex-wrap">
                    @foreach($job->meta_data['experience'] as $exp)
                     <div class="text-lighter text-medium year-exp">{{ $exp }} years</div>
                    @endforeach
                  </div>
                  
               </div>
               @endif

              <div class="get-details detail-move mobile-hide">
                <!-- <img src="{{ asset('/img/power-seller.png') }}" class="img-responsive power-seller" width="120"> -->
                <a href="{{ url('/job/'.$job->getJobSlug()) }}" target="_blank" class="btn fnb-btn full primary-btn border-btn fullwidth default-size">View Job <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></a>
              </div>
          </div>
          <div class="get-details detail-move desk-hide">
            <!-- <img src="{{ asset('/img/power-seller.png') }}" class="img-responsive power-seller" width="120"> -->
            <a href="{{ url('/job/'.$job->getJobSlug()) }}" target="_blank" class="btn fnb-btn full primary-btn border-btn fullwidth default-size">View Job <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></a>
          </div>
      </div>
  </div>
</div>

@if($isListing)
{!! getPageLdJson('App\Seo\JobSingleView',['job'=>$job]) !!}
@endif


@php
  if(isset($showApplication) && $showApplication){
    echo View::make('users.application-modal', compact('job'))->render();  
  } 
@endphp 



@endforeach
@else
<div class="filter-data m-b-30">
    <div class="no-results">
        <h3 class="seller-info__title ellipsis text-primary">No Jobs Found <i class="fa fa-frown-o" aria-hidden="true"></i></h3>
        <!-- <p class="nf-text heavier text-color">Please check the spelling or try searching for something else</p> -->
        <p class="nf-text heavier text-color">Please try searching for something else</p>
        <img src="/img/404.png" class="img-reponsive center-block img-nf" width="100">
    </div>
</div>  
@endif