<div class="col-sm-3 custom-col-3">
  <!-- filter sidebar -->
  <div class="pos-fixed fly-out filterBy">
      <div class="mobile-back desk-hide mobile-flex">
          <div class="left mobile-flex">
              <i class="fa fa-arrow-left text-primary back-icon" aria-hidden="true"></i>
              <p class="element-title heavier m-b-0">Filter</p>
          </div>
          <div class="right">
              <a href="" class="text-primary heavier element-title">Clear All</a>
          </div>
      </div>
      <div class="fly-out__content">
          <div class="filter-sidebar bg-card">
              <!-- Results -->
              <div class="results filter-sidebar__section">
                  <div class="results__header filter-row">
                      <h6 class="element-title text-uppercase">Show Results for</h6>
                  </div>
      
              </div>
              <div class="filter-group keywords">
                  <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-area" aria-expanded="false" aria-controls="section-area">
                      <h6 class="sub-title flex-row">Search by Keywords <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
                      </h6>
                  </div>
                  <div class="filter-group__body filter-row collapse in" id="section-area">
                      <div class="search-area flex-row">
                          <i class="fa fa-search p-r-10 search-icon" aria-hidden="true"></i>
                           <input type="text" class="form-control fnb-input search-input text-color job-keywords"   name="job_keyword" placeholder="Search an keyword" list="jobKeyword" multiple="multiple" id=jobKeywordInput  >
                          
                      </div>
                      <div class="check-section ">
                           <datalist id="jobKeyword">
              
                            </datalist>
                            <div id="keyword-ids"></div>
                      </div>
                  </div>
              </div>

              <!-- results ends -->
              <div class="filter-group area">
                  <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-area" aria-expanded="false" aria-controls="section-area">
                      <h6 class="sub-title flex-row">Search by Area <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
                      </h6>
                  </div>
                  <div class="filter-group__body filter-row collapse in" id="section-area">
                      <div class="search-area flex-row">
                          <i class="fa fa-search p-r-10 search-icon" aria-hidden="true"></i>
                          <input type="text" class="form-control fnb-input search-input text-color" placeholder="Search an area">
                      </div>
                      <div class="check-section area-list">
                          <label class="sub-title flex-row clear hidden">
                              <a href="" class="text-color">
                                 <i class="fa fa-times" aria-hidden="true"></i>
                                  <span>Clear All</span>
                              </a>
                          </label>
                           
                          
                          <p data-toggle="collapse" href="#moreDown" aria-expanded="false" aria-controls="moreDown" class="text-primary heavier text-right more-area m-b-0 default-size">+12 more</p>
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
                      <div class="check-section">
                          <label class="sub-title flex-row clear hidden">
                              <a href="" class="text-color">
                                 <i class="fa fa-times" aria-hidden="true"></i>
                                  <span>Clear All</span>
                              </a>
                          </label>
                          @foreach($jobTypes as $jobTypeId => $jobType)
                          <label class="sub-title flex-row text-color">
                              <input type="checkbox" name="job_type[]" class="checkbox p-r-10 search-job" value="{{ $jobTypeId }}">
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
                      <div class="check-section">
                          <label class="sub-title flex-row clear hidden">
                              <a href="" class="text-color">
                                 <i class="fa fa-times" aria-hidden="true"></i>
                                  <span>Clear All</span>
                              </a>
                          </label>
                          @foreach($defaultExperience as $jobTypeId => $experience)
                          <label class="sub-title flex-row text-color">
                              <input type="checkbox"  name="experience[]" class="checkbox p-r-10 search-job" value="{{ $experience }}">
                              <span>{{ $experience }}</span>
                          </label>
                          @endforeach 
                      </div>
                  </div>
              </div>
              <!-- Ratings -->
              <div class="filter-group rating-section no-gap">
                  <div class="filter-group__header filter-row" data-toggle="collapse" href="#section-rating" aria-expanded="false" aria-controls="section-rating">
                      <h6 class="sub-title flex-row">Ratings <i class="fa fa-angle-down arrow" aria-hidden="true"></i>
                      </h6>
                  </div>
                  <div class="filter-group__body filter-row collapse in" id="section-rating">
                      <div class="check-section">
                          <label class="sub-title flex-row text-color">
                             <div class="rating-view p-r-10">
                                  <div class="rating">
                                      <div class="bg"></div>
                                      <div class="value" style="width: 100%;"></div>
                                  </div>
                              </div>
                              <span>&amp; Up (211)</span>
                          </label>
                          <label class="sub-title flex-row text-color">
                             <div class="rating-view p-r-10">
                                  <div class="rating">
                                      <div class="bg"></div>
                                      <div class="value" style="width: 68%;"></div>
                                  </div>
                              </div>
                              <span>&amp; Up (23)</span>
                          </label>
                          <label class="sub-title flex-row text-color">
                             <div class="rating-view p-r-10">
                                  <div class="rating">
                                      <div class="bg"></div>
                                      <div class="value" style="width: 50%;"></div>
                                  </div>
                              </div>
                              <span>&amp; Up (134)</span>
                          </label>
                          <label class="sub-title flex-row text-color">
                             <div class="rating-view p-r-10">
                                  <div class="rating">
                                      <div class="bg"></div>
                                      <div class="value" style="width: 28%;"></div>
                                  </div>
                              </div>
                              <span>&amp; Up (344)</span>
                          </label>
                          <label class="sub-title flex-row text-color">
                             <div class="rating-view p-r-10">
                                  <div class="rating">
                                      <div class="bg"></div>
                                      <div class="value" style="width: 16%;"></div>
                                  </div>
                              </div>
                              <span>&amp; Up (23)</span>
                          </label>
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
                  <div class="flex-row boost-row">
                      <div class="heavier text-color boost-row__title">
                          Give your marketing a boost!
                      </div>
                      <button class="btn fnb-btn s-outline full border-btn default-size"><i class="fa fa-rocket fa-rotate-180" aria-hidden="true"></i> Advertise with us</button>
                  </div>
              </div>
              <!-- advertisement ends-->
              <div class="apply-btn desk-hide">
                  <button class="btn fnb-btn primary-btn full border-btn">Apply</button>
              </div>
          </div>
      </div>
  </div>
</div>