@if($jobs->count())
@foreach($jobs as $key =>$job)
<div class="filter-data @if($key==0 && $append == 'false') @else m-t-30 m-b-30 @endif">
  <div class="seller-info bg-card filter-cards">
 
      <div class="seller-info__body filter-cards__body flex-row white-space">
          <div class="body-left flex-cols">
              <div>
                 <h3 class="seller-info__title ellipsis" title="Empire cold storage &amp; chicken products">{{ $job->title }}</h3>
                  <div class="location p-b-5 flex-row">
                      <span class="fnb-icons map-icon"></span>
                      @if(!empty($job->getJobCompany()))
                      <p class="location__title default-size m-b-0 text-lighter">{{ $job->getJobCompany()->title }}</p>
                      @endif
 
                  </div>
                  <div class="flex-row">
                      <div class="rating-view flex-row p-r-10"> 
                          <a href="?city={{ $flteredCitySlug }}&category={{ $job->category->slug }}">{{ $job->getJobCategoryName() }}</a>
                      </div>
                      @if($job->jobPostedOn()!="")
                      <p class="m-b-0 text-lighter default-size lighter published-date"><i>Posted on {{ $job->jobPostedOn() }}</i></p>
                       @endif
                  </div>
                  <div class="stats flex-row m-t-10 p-t-10">

                      @if(!empty($job->getJobTypes()))
                       
                      @foreach($job->getJobTypes() as $jobType)
                       <label class="fnb-label wholesaler flex-row">
                          <i class="fa fa-user user p-r-5" aria-hidden="true"></i>
                          {{ $jobType }}
                       </label>
                      @endforeach
                      
                    @endif

                     
                  </div>
              </div>
              @if(!empty($job->getJobSavedKeywords(2)))
              @php
              $splitKeywords =  splitJobArrayData($job->getJobSavedKeywords(2),5);
              $keywords = $splitKeywords['array'];
              $moreKeywords = $splitKeywords['moreArray'];
              $moreKeywordCount = $splitKeywords['moreArrayCount'];
              @endphp 
              <div class="m-t-15 p-t-15 cat-holder">
                  <div class="core-cat">
                      <p class="default-size text-lighter m-t-0 m-b-0">Job Roles</p>
                      <ul class="fnb-cat flex-row">
                        @foreach($keywords as $keyword)
                          <li><a href='?city={{ $flteredCitySlug }}&keywords=["{{ $keyword['id'] }}|{{ str_slug($keyword['label']) }}"]' class="fnb-cat__title">{{ $keyword['label'] }}</a></li>

                        @endforeach

                        @if($moreKeywordCount) 
                          <li class="cat-more more-show"><a href="" class="text-darker">+{{ $moreKeywordCount }} more</a></li>
                        @endif
                      </ul>
                  </div>
              </div>
              @endif
          </div>
          <div class="body-right flex-cols">
              <div class="operations">
                  <img src="{{ asset('/img/power-seller.png') }}" class="img-responsive power-seller" width="120">
                  <p class="operations__title default-size text-lighter m-t-5">Job Location:</p>
                  @foreach($job->getJobLocationNames() as $city => $locAreas)
                  <div class="operations__container">
                      <div class="location flex-row">
                          <p class="m-b-0 text-color heavier default-size">{{ $city }} <i class="fa fa-caret-right p-l-5" aria-hidden="true"></i>
                          </p>
                      </div>
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
                              <a href="" class="cities__title remain__number default-size text-medium">more...</a>
                          </li>
                        @endif
                      </ul>
                  </div>
                  @endforeach  

              </div>
              <div>
            
                  <div class="get-details detail-move">
                      <a href="{{ url('/job/'.$job->getJobSlug()) }}" target="_blank"><button class="btn fnb-btn outline full border-btn fullwidth default-size">Get Details <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></button></a>
                  </div>
              </div>
          </div>
      </div>
      <div class="seller-info__body filter-cards__body flex-row white-space">
      <div class="recent-updates flex-row">
      Description : {{ $job->getShortDescription() }}
      </div>
      </div>
      <div class="seller-info__footer filter-cards__footer white-space">
          <div class="recent-updates flex-row">
             <div class="off-salary">
                <h6 class="operations__title sub-title">Offered Salary</h6>

                @if($job->salary_lower >="0" && $job->salary_upper > "0" )

                <div class="text-color lighter">
                  @if($job->salary_lower == $job->salary_upper )
                  <i class="fa fa-inr text-color" aria-hidden="true"></i> {{ moneyFormatIndia($job->salary_lower) }}
                  @else
                  <i class="fa fa-inr text-color" aria-hidden="true"></i> {{ moneyFormatIndia($job->salary_lower) }} - <i class="fa fa-inr text-color" aria-hidden="true"></i>{{ moneyFormatIndia($job->salary_upper) }} 
                  @endif
                {{ $job->getSalaryTypeShortForm()}}</div>

                @else
                <div class="text-color lighter">Not disclosed</div>
                @endif
             </div>  

             @if(!empty($job->meta_data['experience']))
                     <div class="year-exp">
                        <h6 class="operations__title sub-title">Years Of Experience</h6>
                        <div class="flex-row flex-wrap">
                          @foreach($job->meta_data['experience'] as $exp)
                           <div class="text-color lighter year-exp">{{ $exp }} years</div>
                          @endforeach
                        </div>
                        
                     </div>
                     @endif
              
          </div>
          <div class="updates-dropDown">

          </div>
      </div>
  </div>
</div>
@endforeach
@else
<div class="filter-data ">
  <div class="seller-info bg-card filter-cards">
 
      <div class="seller-info__body filter-cards__body flex-row white-space">
          <div class="body-left flex-cols">
              <div>
                 <h3 class="seller-info__title ellipsis" title="">No Jobs Found :(</h3>
              </div>
          </div>
      </div>
  </div>
</div>  
@endif