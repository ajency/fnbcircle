@extends('layouts.single-view')
@section('title', $pageName )
@section('js')
    @parent
    <script type="text/javascript" src="/js/jobs.js"></script>
    <script type="text/javascript" src="/js/maps.js"></script>
    <!-- <script type="text/javascript" src="/js/custom.js"></script> -->
@endsection
@section('single-view-data')
<div class="container">
   <div class="row m-t-30 m-b-30 mobile-flex breadcrums-container single-breadcrums">
      <div class="col-sm-8  flex-col">
         <!-- Breadcrums -->
         <ul class="fnb-breadcrums flex-row">
            <li class="fnb-breadcrums__section">
               <a href="">
               <i class="fa fa-home home-icon" aria-hidden="true"></i>
               </a>
            </li>
            <li class="fnb-breadcrums__section">
               <a href="">
                  <p class="fnb-breadcrums__title">/</p>
               </a>
            </li>
               <li class="fnb-breadcrums__section">
               <a href="">
                  <p class="fnb-breadcrums__title main-name">{{ $job->getJobCategoryName() }}</p>
               </a>
            </li>
            

            <li class="fnb-breadcrums__section">
               <a href="">
                  <p class="fnb-breadcrums__title">/</p>
               </a>
            </li>
            <li class="fnb-breadcrums__section">
               <a href="">
                  <p class="fnb-breadcrums__title main-name">{{ $job->title }}</p>
               </a>
            </li>
         </ul>
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
            <p class="m-b-0 published-title job-published-date lighter default-size">Posted on : July 03, 2017</p>
            <button type="button" class="share-btn edit-job flex-row"><i class="fa fa-pencil" aria-hidden="true"></i> Edit your job</button>                        
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
   <div class="row hidden">
      <div class="col-sm-12">
         <div class="pre-benefits pending-review flex-row">
            <div class="pre-benefits__intro flex-row">
               <div class="pre-benefits__content">
                  <h5 class="sub-title pre-benefits__title m-b-0">The current status of your job listing is <b>Pending Review</b> <i class="fa fa-info-circle" aria-hidden="true"></i></h5>
               </div>
            </div>
            <button type="button" class="btn fnb-btn primary-btn full border-btn upgrade">Submit for review</button>
         </div>
      </div>
   </div>
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
                     <h3 class="seller-info__title main-heading">{{ $job->title }}</h3>
                     <!-- <a href="" class="secondary-link"><p class="m-b-0"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</p></a> -->
                     <!-- <img src="../public/img/power-seller.png" class="img-responsive mobile-hide" width="130"> -->
                     <img src="/img/power-icon.png" class="img-responsive" width="30">
                  </div>
                  <div class="location main-loc flex-row">
                     <!-- <span class="fnb-icons map-icon"></span> -->
                     <i class="fa fa-tag p-r-5" aria-hidden="true"></i>
                     <p class="location__title c-title">{{ $job->getJobCategoryName() }}</p>
                  </div>
                  <div class="stats flex-row m-t-15 owner-info">
                    @if(!empty($jobTypes))
                      @foreach($jobTypes as $jobType)
                       <label class="fnb-label wholesaler flex-row">
                          {{ $jobType }}
                       </label>
                      @endforeach
                    @endif
                     <div class="owner-address flex-row">
                        <span class="fnb-icons map-icon"></span>
                        <span class="text-color lighter">Delhi (Dwarka, Ghonda, Mumbai)</span>
                     </div>
          
                  </div>
                  <div class="operations p-t-10 p-b-20 flex-row flex-wrap role-selection">
                    <div class="job-places">
                        <h6 class="operations__title sub-title">Job location</h6>
                        <div class="opertaions__container flex-row job-location">
                           <div class="location flex-row">
                               <span class="fnb-icons map-icon"></span>
                               <p class="default-size location__title c-title">Mumbai <i class="fa fa-caret-right p-l-5" aria-hidden="true"></i></h6>
                           </div>
                           <ul class="cities flex-row p-l-10">
                               <li>
                                   <p class="cities__title">Bandra, </p>
                               </li>
                               <li>
                                   <p class="cities__title">Andheri, </p>
                               </li>
                               <li>
                                   <p class="cities__title">Juhu, </p>
                               </li>
                               <li class="remain more-show">
                                   <a href="" class="secondary-link remain__number">+10</a>
                               </li>
                           </ul>
                        </div>
                        <div class="opertaions__container flex-row job-location">
                           <div class="location flex-row">
                               <span class="fnb-icons map-icon"></span>
                               <p class="default-size location__title c-title">Mumbai <i class="fa fa-caret-right p-l-5" aria-hidden="true"></i></h6>
                           </div>
                           <ul class="cities flex-row p-l-10">
                               <li>
                                   <p class="cities__title">Bandra, </p>
                               </li>
                               <li>
                                   <p class="cities__title">Andheri, </p>
                               </li>
                           </ul>
                        </div>                            
                    </div>
                     <div class="role-gap">
                        <h6 class="operations__title sub-title">Offered Salary</h6>
                        
                        <div class="text-color lighter">2 - 2.5 Lakhs p.a</div>
                     </div>
                     @if(!empty($experience))
                     <div class="role-gap">
                        <h6 class="operations__title sub-title">Years of experience</h6>
                        
                          @foreach($experience as $exp)
                           <div class="text-color lighter">{{ $exp }} years</div>
                          @endforeach
                        
                        
                     </div>
                     @endif

                     @if(!empty($keywords))
                     <div class="job-role">
                        <h6 class="operations__title sub-title">Job role</h6>
                        <ul class="cities flex-row">
                          @foreach($keywords as $keyword)
                           <li>
                              <p class="default-size cities__title">{{ $keyword }}, </p>
                           </li>
                           @endforeach
                           <li class="remain more-show">
                              <a href="" class="secondary-link">+10</a>
                           </li>
                        </ul>
                     </div>
                     @endif
                  </div>
               </div>
            </div>
            <!-- Card info ends -->
            <!-- contact info -->
            <div class="card seller-info sell-re collapse" id="contact-data">
               <div class="contact-info">
                  <div class="close-contact" data-toggle="collapse" href="#contact-data">
                     <i class="fa fa-times" aria-hidden="true"></i>
                  </div>
                  <div class="phone collapse-section m-b-20">
                     <h6 class="collapse-section__title">Phone no:</h6>
                     <div class="number flex-row">
                        <a class="number__real text-secondary" href="callto:+919293939393">+91 9293939393, </a>
                        <a class="number__real text-secondary" href="callto:+919293939393">+91 9293939393</a>
                     </div>
                  </div>
                  <div class="mail-us collapse-section m-t-20 m-b-20">
                     <h6 class="collapse-section__title">Mail us at:</h6>
                     <div class="number flex-row">
                        <a class="number__real text-secondary" href="mailto:mysticalinfo@gmail.com">mysticalinfo@gmail.com</a>
                     </div>
                  </div>
                  <div class="message flex-row">
                     <span class="fnb-icons exclamation"></span>
                     <p class="message__title p-l-10">When you contact, don't forget to mention that you found this listing on FnBcircle</p>
                  </div>
               </div>
            </div>
            <!-- contact info ends -->
            <!-- updates section -->
            <div class="update-sec m-t-30" id="updates">

            </div>
            <!-- update section ends -->
            <!-- listed -->
            <div class="listed p-t-5 p-b-10" id="listed">
               <h5 class="jobDesc">Job Description</h5>
               <hr>
               <div class="job-desc text-color stable-size">
                  {!! $job->description !!}
               </div>
             
               <div class="job-summary job-points">
                  <h6 class="sub-title m-b-15">Address/Map</h6>
                  <div class="text-color stable-size">
                      
                      <div class="m-t-10" id="map" map-title="your interview location" >

                      </div>
                      <input type="hidden" id=latitude name=latitude value="{{ $job->interview_location_lat }}">
                      <input type="hidden" id=longitude name=longitude value="{{ $job->interview_location_long  }}">
                  </div>
               </div>
              <h5 class="jobDesc m-t-15" id="about-company">About Company</h5>
               <hr>
               <div class="job-desc text-color stable-size">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti voluptatum iure aliquid assumenda id quibusdam incidunt reiciendis molestias facilis, minima ut. Quos aut soluta quo sunt neque enim, dolore illum ullam libero rem fugit laborum ut nostrum necessitatibus minima nisi saepe id. Natus possimus eaque tempora debitis quasi deleniti sunt.
               </div>
               <div class="footer-share flex-row">
                  <button class="btn fnb-btn primary-btn full border-btn" type="button">Apply Now</button>
                  <div class="share-job flex-row">
                     <p class="sub-title heavier m-b-0 p-r-10">Share: </p>
                     <ul class="options flex-row flex-wrap">
                        <li><a href="#"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                        <li><i class="fa fa-facebook-official" aria-hidden="true"></i></li>
                        </li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                     </ul>
                  </div>
               </div>
            </div>
            <hr>
            <!-- listed ends -->
            <!-- Related article section -->
            <div class="related-article p-b-20" id="article">
               <div class="section-start-head m-b-15 flex-row">
                  <h6 class="element-title">Featured News Articles</h6>
                  <!-- <a href="" class="secondary-link view-more heavier">View More</a> -->
               </div>
               <div class="related-article__section equalCol flex-row">
                  <div class="related-article__col article-col fnb-article">
                     <a href="" class="article-link">
                        <div class="fnb-article__banner"></div>
                        <div class="fnb-article__content m-t-10">
                           <h6 class="sub-title fnb-article__title">Nestle details ways to make cappuc-cinos creamier.</h6>
                           <!-- <p class="fnb-article__caption default-size text-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam dolores, perferendis possimus nostrum atque ex enim obcaecati harum facilis id.</p> -->
                        </div>
                     </a>
                     <span class="dis-block fnb-article__caption lighter date flex-row space-between">
                     <label class="fnb-label news-label">Supplier innovation</label>
                     June 28, 2017
                     </span>
                  </div>
                  <div class="related-article__col article-col fnb-article">
                     <a href="" class="article-link">
                        <div class="fnb-article__banner banner-2"></div>
                        <div class="fnb-article__content m-t-10">
                           <h6 class="sub-title fnb-article__title">Nestle details ways to make cappuc-cinos creamier.</h6>
                           <!-- <p class="fnb-article__caption default-size text-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam dolores, perferendis possimus nostrum atque ex enim obcaecati harum facilis id.</p> -->
                        </div>
                     </a>
                     <span class="dis-block fnb-article__caption lighter date flex-row space-between">
                     <label class="fnb-label news-label">Supplier innovation</label>
                     June 28, 2017
                     </span>
                  </div>
                  <div class="related-article__col article-col fnb-article">
                     <a href="" class="article-link">
                        <div class="fnb-article__banner"></div>
                        <div class="fnb-article__content m-t-10">
                           <h6 class="sub-title fnb-article__title">Nestle details ways to make cappuc-cinos creamier.</h6>
                           <!-- <p class="fnb-article__caption default-size text-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam dolores, perferendis possimus nostrum atque ex enim obcaecati harum facilis id.</p> -->
                        </div>
                     </a>
                     <span class="dis-block fnb-article__caption lighter date flex-row space-between">
                     <label class="fnb-label news-label">Supplier innovation</label>
                     June 28, 2017
                     </span>
                  </div>
                  <div class="related-article__col article-col fnb-article">
                     <a href="" class="article-link">
                        <div class="fnb-article__banner banner-2"></div>
                        <div class="fnb-article__content m-t-10">
                           <h6 class="sub-title fnb-article__title">Nestle details ways to make cappuc-cinos creamier.</h6>
                           <!-- <p class="fnb-article__caption default-size text-lighter">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam dolores, perferendis possimus nostrum atque ex enim obcaecati harum facilis id.</p> -->
                        </div>
                     </a>
                     <span class="dis-block fnb-article__caption lighter date flex-row space-between">
                     <label class="fnb-label news-label">Supplier innovation</label>
                     June 28, 2017
                     </span>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-sm-4">
         <div class="detach-col-1">
            <div class="equal-col">
               <div class="Company-info">
                  <div class="flex-row name-row">
                     <div class="company-logo">
                        <img src="http://via.placeholder.com/60x60">
                     </div>
                     <div class="company-name heavier">
                        <div>
                           <div class="flex-row heavier"><i class="fa fa-building-o p-r-5" aria-hidden="true"></i> InterContinental Hotels Group</div>
                           <a href="#" class="primary-link x-small ">www.ichotelsgroup.com <i class="fa fa-link p-r-5" aria-hidden="true"></i></a>
                           <a href="#" class="secondary-link dis-block x-small m-t-5 check-detail">View details</a>
                        </div>
                     </div>
                  </div>

               </div>
               <div class="contact__info applyJob">
                  <!-- If logged in -->
                  <!-- If not logged in -->
                  <button class="btn fnb-btn primary-btn full border-btn" type="button"><i class="p-r-5 fa fa-paper-plane-o" aria-hidden="true"></i> Apply now</button>
                  <!-- <h1 class="m-b-0">20</h1> -->
                  <a href="#" class="secondary-link p-l-20 dis-block"><i class="fa fa-envelope p-r-5" aria-hidden="true"></i> Send me jobs like this</a>
               </div>
               <div class="share-job flex-row justify-center">
                  <p class="sub-title heavier m-b-0 p-r-10">Share: </p>
                  <ul class="options flex-row flex-wrap">
                     <li><a href="#"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                     <li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                     <li><i class="fa fa-facebook-official" aria-hidden="true"></i></li>
                     <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                     <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                  </ul>
               </div>
            </div>
            <!-- Advertisement ends -->
            <div class="advertisement flex-row m-t-40">
               <h6 class="element-title">Advertisement</h6>
            </div>
            <!-- advertisement ends -->
            <!-- Featured Jobs -->
            <div class="featured-jobs browse-cat">
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
            <div class="featured-jobs browse-cat">
               <h6 class="element-title m-t-0">Similar Jobs</h6>
               <hr>
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
            <!-- Similar jobs -->
            <!-- Claim -->
            <div class="claim-box p-b-10 job-post">
               <!-- <i class="fa fa-commenting claim__icon" aria-hidden="true"></i> -->
               <!-- <img src="img/exclamation.png" class="img-reponsive"> -->
               <!-- <span class="fnb-icons exclamation"></span> -->
               <p class="claim-box__text sub-title text-center">Post a job on FnB Circle for free!</p>
               <div class="contact__enquiry text-center m-t-15">    
                  <button class="btn fnb-btn primary-btn full border-btn" type="button"><i class="p-r-5 fa fa-paper-plane-o" aria-hidden="true"></i> Post your job</button>
               </div>
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
@endsection
