<div class="col-sm-3 custom-col-3 serach-sidebar">
  <!-- filter sidebar -->
  <div class="pos-fixed fly-out filterBy">
      <div class="mobile-back desk-hide mobile-flex">
          <div class="left mobile-flex">
              <i class="fa fa-arrow-left text-primary back-icon" aria-hidden="true"></i>
              <p class="element-title heavier m-b-0">Filter</p>
          </div>
          <div class="right">
              <a href="javascript:void(0)" class="text-primary heavier element-title clear-all-filters">Clear All</a>
          </div>
      </div>
      <div class="fly-out__content">
          <div class="filter-sidebar bg-card">
              <!-- Results -->
              <div class="results filter-sidebar__section">
                  <div class="results__header filter-row">
                      <h6 class="element-title text-uppercase">Show Results for</h6>

                    <!--   <a href="javascript:void(0)" class="primary-link heavier clear-all-filters top-clear-all">
                         <i class="fa fa-times p-r-5" aria-hidden="true"></i>
                          <span>Clear All</span>
                      </a> -->
                  </div>
      
              </div>
              <div class="filter-group keywords">
                  <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-keywords" aria-expanded="false" aria-controls="section-keywords">
                      <h6 class="sub-title flex-row">Search by Job Roles <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
                      </h6>
                  </div>
                  <div class="filter-group__body filter-row collapse in" id="section-keywords">
                      <label class="default-size flex-row clear text-medium m-b-10 clear @if(!isset($urlFilters['keywords'])) hidden @endif ">
                              <a href="javascript:void(0)" class="secondary-link clear-keywords">
                                 <i class="fa fa-times" aria-hidden="true"></i>
                                  <span>Clear All</span>
                              </a>
                      </label>

                      <div class="search-area searchKeyword flex-row align-top">
                          <i class="fa fa-search p-r-10 search-icon" aria-hidden="true"></i>
                           <input type="text" class="form-control fnb-input search-input text-color search-job-keywords"   name="job_keyword" placeholder="Search an role" list="jobKeyword" multiple="multiple" id=jobKeywordInput  @if(isset($urlFilters['keywords']) && !empty($urlFilters['keywords'])) value='{{ implode(",",$urlFilters['keywords']) }}' @endif>
                          
                      </div>
                      <div class="check-section ">
                           <datalist id="jobKeyword">
              
                            </datalist>
                            <div id="keyword-ids">
                              @if(isset($urlFilters['keywords']) && !empty($urlFilters['keywords']))
                              @foreach($urlFilters['keywords'] as $keywordId => $keyword)
                              <input type="hidden" name="keyword_id[]" class="job-input-keywords" value="{{ $keywordId }}" label="{{ $keyword }}">
                              @endforeach
                              @endif
 
                            </div>
                      </div>
                  </div>
              </div>

              <!-- results ends -->
              <div class="filter-group area">
                  <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-area" aria-expanded="false" aria-controls="section-area">
                      <h6 class="sub-title flex-row">Search by City <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
                      </h6>
                  </div>
                  <div class="filter-group__body filter-row collapse in" id="section-area" >
                      <div class="search-area flex-row">
                          <i class="fa fa-search p-r-10 search-icon" aria-hidden="true"></i>
                          <input type="text" class="form-control fnb-input search-input text-color" name="area_search" placeholder="Search city">
                      </div>
                      <div class="check-section filter-check">
                          <label class="default-size flex-row clear text-medium m-b-10 clear @if(!isset($urlFilters['area'])) hidden @endif">
                              <a href="javascript:void(0)" class="secondary-link clear-checkbox clear-area">
                                 <i class="fa fa-times" aria-hidden="true"></i>
                                  <span>Clear All</span>
                              </a>
                          </label>
                        <span class="area-list" has-filter="@if(isset($urlFilters['area']) && !empty($urlFilters['area'])) yes @else no @endif">
                        @php
                        $cityareaCount = 0;
                        @endphp
                        @if(isset($urlFilters['city_areas']) && !empty($urlFilters['city_areas']))
                          @php
                          $cityareaCount = count($urlFilters['city_areas']);
                          @endphp
                          @foreach($urlFilters['city_areas'] as $key=> $area)
                            @php
                              if((!empty($urlFilters['area'])) && in_array($area->slug,$urlFilters['area']) && $key > 6){
                                $showAll = 'show-all-list';
                              } 
                              else{
                                $showAll = '';
                              } 
                            @endphp
                             <label class="sub-title flex-row text-color"> 
                             <input type="checkbox" class="checkbox p-r-10 search-job search-checkbox {{ $showAll }}" name="areas[]" slug="{{ $area->slug }}" value="{{ $area->id }}"   @if( (!empty($urlFilters['area'])) && in_array($area->slug,$urlFilters['area'])) checked @endif> 
                              <span>{{ $area->name }}</span> 
                            </label> 

                            @if($key == 6)
                            <div class="more-section collapse" id="moreDown">
                            @endif

                          @endforeach

                          @if($cityareaCount > 6)

                            </div>
                          @endif
                        @endif
                        </span>   
                          
                          <p id="moreAreaShow" data-toggle="collapse" href="#moreDown" aria-expanded="false" aria-controls="moreDown" class="text-primary toggle-areas heavier text-right more-area m-b-0 default-size  @if($cityareaCount < 6) hidden @endif">+ {{ ($cityareaCount - 6) }} more</p>
                      </div>
                  </div>
              </div>
              <!-- Type of business -->
              <div class="filter-group business-type no-gap">
                  <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-business" aria-expanded="false" aria-controls="section-business">
                      <h6 class="sub-title flex-row">Type of Job <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
                      </h6>
                  </div>
                  <div class="filter-group__body filter-row collapse in" id="section-business">
                      <div class="check-section filter-check jobType">
                          <label class="default-size flex-row text-medium m-b-10 clear @if(!isset($urlFilters['job_type'])) hidden @endif">
                              <a href="javascript:void(0)" class="secondary-link clear-checkbox">
                                 <i class="fa fa-times" aria-hidden="true"></i>
                                  <span>Clear All</span>
                              </a>
                          </label>
                          @foreach($jobTypes as $jobTypeId => $jobType)
                            @php
                              $jobTypeSlug = str_slug($jobType,'-');
                            @endphp
                          <label class="sub-title align-top  flex-row text-color">
                              <input type="checkbox" name="job_type[]" @if((isset($urlFilters['job_type'])) && (!empty($urlFilters['job_type'])) && in_array( $jobTypeSlug,$urlFilters['job_type'])) checked @endif class="checkbox p-r-10 search-job search-checkbox" value="{{ $jobTypeId }}" slug="{{ $jobTypeSlug }}">
                              <span>{{ $jobType }}</span>
                          </label>
                          @endforeach
                      </div>
                  </div>
              </div>
              <!-- listing status -->
              <div class="filter-group list-status no-gap">
                  <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-list-status" aria-expanded="false" aria-controls="section-list-status">
                      <h6 class="sub-title flex-row">Experience <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
                      </h6>
                  </div>
                  <div class="filter-group__body filter-row collapse in" id="section-list-status">
                      <div class="check-section filter-check">
                          <label class="default-size flex-row clear text-medium m-b-10 clear @if(!isset($urlFilters['experience'])) hidden @endif">
                              <a href="javascript:void(0)" class="secondary-link clear-checkbox">
                                 <i class="fa fa-times" aria-hidden="true"></i>
                                  <span>Clear All</span>
                              </a>
                          </label>
                          @foreach($defaultExperience as $jobTypeId => $experience)
                          <label class="sub-title flex-row text-color">
                              <input type="checkbox"  name="experience[]" class="checkbox p-r-10 search-job search-checkbox" @if((isset($urlFilters['experience'])) && (!empty($urlFilters['experience'])) && in_array($experience,$urlFilters['experience'])) checked @endif value="{{ $experience }}">
                              <span>{{ $experience }} Years</span>
                          </label>
                          @endforeach 
                      </div>
                  </div>
              </div>
              <!-- Ratings -->
              <div class="filter-group rating-section no-gap">
                  <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-rating" aria-expanded="false" aria-controls="section-rating">
                      <h6 class="sub-title flex-row">Salary <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
                      </h6>
                  </div>
                  <div class="filter-group__body filter-row collapse in" id="section-rating">
                      <div class="check-section">
                          <label class="default-size flex-row clear text-medium m-b-10 clear @if(!isset($urlFilters['salary_type'])) hidden @endif">
                              <a href="javascript:void(0)" class="secondary-link clear-salary">
                                 <i class="fa fa-times" aria-hidden="true"></i>
                                  <span>Clear All</span>
                              </a>
                          </label>
                           <select name="salary_type" class="search-job form-control select-variant fnb-select p-l-0">
                            <option value=""> -select salary- </option>
                             @foreach($salaryTypes as $salaryTypeId => $salaryType)
                             @php
                              $minSal = (isset($salaryRange[$salaryTypeId]['min'])) ? $salaryRange[$salaryTypeId]['min'] : 0;
                              $maxSal = (isset($salaryRange[$salaryTypeId]['max'])) ? $salaryRange[$salaryTypeId]['max'] : 0;
                              $salaryTypeSlug =  str_slug($salaryType);
                             @endphp
                             <option @if(isset($urlFilters['salary_type']) && $salaryTypeSlug == $urlFilters['salary_type']) selected @endif value="{{ $salaryTypeId }}" min="{{ $minSal }}" max="{{ $maxSal }}" slug="{{ $salaryTypeSlug }}"  > {{ $salaryType }}</option>
                             @endforeach
                             
                           </select>
                           <div class="salary-range @if(isset($urlFilters['salary_type']) && $urlFilters['salary_type']!='') @else hidden @endif">
                           <input type="text" name="salary_lower" value="@if(isset($urlFilters['salary_lower'])){{ $urlFilters['salary_lower'] }}@endif" class="search-job"> - <input type="text" name="salary_upper" value="@if(isset($urlFilters['salary_upper'])){{ $urlFilters['salary_upper'] }}@endif" class="search-job">
                           <input type="text" id="sal-input">
                           </div>
                      </div>
                  </div>
                  
              </div>
              <!-- ratings ends -->
              <!-- why fnb -->
              <div class="filter-group whyFnb no-gap mobile-hide">
                  <div class="filter-group__header filter-row">
                      <h6 class="element-title flex-row m-b-0 m-t-0">Why F&amp;B Circle?</h6>
                  </div>
                  <div class="filter-group__body filter-row">
                      <div class="check-section">
                          <label class="sub-title flex-row text-color">
                              <i class="fa fa-check check p-r-10" aria-hidden="true"></i>
                              <span>Get quotes from multiple suppliers</span>
                          </label>
                          <label class="sub-title flex-row text-color">
                              <i class="fa fa-check check p-r-10" aria-hidden="true"></i>
                              <span>Browse and find suppliers</span>
                          </label>
                          <label class="sub-title flex-row text-color">
                              <i class="fa fa-check check p-r-10" aria-hidden="true"></i>
                              <span>Post &amp; apply to the jobs</span>
                          </label>
                          <label class="sub-title flex-row text-color">
                              <i class="fa fa-check check p-r-10" aria-hidden="true"></i>
                              <span>Get updates in F&amp;B news</span>
                          </label>
                      </div>
                  </div>
              </div>
              <!-- why fnb ends -->
              <div class="business-listing businessListing p-t-30 p-b-30 text-center">
                  <!-- <span class="fnb-icons note"></span> -->
                  <div class="bl-top">
                      <img src="{{ asset('/img/business-graph.png') }}" class="img-responsive center-block">
                      <div class="business-listing__content m-b-15">
                          <h6 class="sub-title business-listing__title">Increase your business sales on F&amp;BCircle</h6>
                          <!-- <p class="default-size">Post your listing on F&amp;BCircle for free</p> -->
                      </div>
                  </div>
                  <button class="btn fnb-btn outline full border-btn default-size">Learn more</button>
              </div>
              <!-- why fnb ends -->
              <!-- Advertisement -->
              <div class="adv-row">
                  <div class="advertisement flex-row m-t-20">
                      <h6 class="element-title">Advertisement</h6>
                  </div>
                  <div class="boost-row text-center">
                      <div class="heavier text-color boost-row__title m-b-5">
                          Give your marketing a boost!
                      </div>
                      <button class="btn fnb-btn s-outline full border-btn default-size"><i class="fa fa-rocket fa-rotate-180" aria-hidden="true"></i> Advertise with us</button>
                  </div>
              </div>
              <!-- advertisement ends-->
              <div class="apply-btn desk-hide apply-filters">
                  <button class="btn fnb-btn primary-btn full border-btn">Apply</button>
              </div>
          </div>
      </div>
  </div>
</div>