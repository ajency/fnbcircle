@extends('layouts.single-view')
@section('js')
    @parent
    <script type="text/javascript" src="/js/jobs.js"></script>
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
                  <p class="fnb-breadcrums__title">Delhi</p>
               </a>
            </li>
            <li class="fnb-breadcrums__section">
               <a href="">
                  <p class="fnb-breadcrums__title">/</p>
               </a>
            </li>
            <li class="fnb-breadcrums__section">
               <a href="">
                  <p class="fnb-breadcrums__title main-name">Foods Restaurant jobs</p>
               </a>
            </li>
            <li class="fnb-breadcrums__section">
               <a href="">
                  <p class="fnb-breadcrums__title">/</p>
               </a>
            </li>
            <li class="fnb-breadcrums__section">
               <a href="">
                  <p class="fnb-breadcrums__title main-name">Foods &amp; Beverage Manager</p>
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
               <img src="../public/img/power-icon.png" class="img-repsonsive" width="50">
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
                     <h3 class="seller-info__title main-heading">Food &amp; Beverage Manager</h3>
                     <!-- <a href="" class="secondary-link"><p class="m-b-0"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</p></a> -->
                     <!-- <img src="../public/img/power-seller.png" class="img-responsive mobile-hide" width="130"> -->
                     <img src="../public/img/power-icon.png" class="img-responsive" width="30">
                  </div>
                  <div class="location main-loc flex-row">
                     <!-- <span class="fnb-icons map-icon"></span> -->
                     <i class="fa fa-tag p-r-5" aria-hidden="true"></i>
                     <p class="location__title c-title">Restaurant/bar</p>
                  </div>
                  <div class="stats flex-row m-t-15 owner-info">
                     <!-- <div class="rating-view flex-row">
                        <div class="rating">
                            <div class="bg"></div>
                            <div class="value" style="width: 80%;"></div>
                        </div>
                        <div class="views p-l-20 flex-row">
                            <span class="fnb-icons eye-icon"></span>
                            <p class="views__title c-title"><span>126</span> Views</p>
                        </div>
                        <div class="p-l-20 verified flex-row">
                            <span class="fnb-icons verified-icon"></span>
                            <p class="c-title">Verified</p>
                        </div>
                        </div> -->
                     <label class="fnb-label wholesaler flex-row">
                        <!-- <i class="fa fa-user user p-r-5" aria-hidden="true"></i> -->
                        FULL - TIME
                     </label>
                     <div class="owner-address flex-row">
                        <span class="fnb-icons map-icon"></span>
                        <span class="text-color lighter">Delhi (Dwarka, Ghonda, Mumbai)</span>
                     </div>
                     <!--  <div class="verified-toggle flex-row">
                        <p class="m-b-0 text-color mobile-hide">Un-Verified</p>
                        <div class="toggle m-l-10 m-r-10">
                          <input type="checkbox" class="toggle__check">
                          <b class="switch"></b>
                          <b class="track"></b>
                        </div>
                        <p class="m-b-0 text-color toggle-state">Verified</p>
                        </div> -->
                  </div>
                  <div class="operations p-t-10 p-b-20 flex-row flex-wrap role-selection">
                     <div class="role-gap">
                        <h6 class="operations__title sub-title">Offered Salary</h6>
                        <!-- <div class="opertaions__container flex-row">
                           <div class="location flex-row">
                               <span class="fnb-icons map-icon"></span>
                               <p class="location__title c-title">Mumbai <i class="fa fa-caret-right p-l-5" aria-hidden="true"></i></h6>
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
                               <li>
                                   <p class="cities__title">Worli, </p>
                               </li>
                               <li>
                                   <p class="cities__title">Powai, </p>
                               </li>
                                <li>
                                   <p class="cities__title">Bandra, </p>
                               </li>
                               <li>
                                   <p class="cities__title">Andheri, </p>
                               </li>
                               <li>
                                   <p class="cities__title">Juhu, </p>
                               </li>
                               <li>
                                   <p class="cities__title">Worli, </p>
                               </li>
                               <li>
                                   <p class="cities__title">Powai</p>
                               </li>
                               <li class="remain more-show">
                                   <a href="" class="secondary-link remain__number">+10</a>
                               </li>
                           </ul>
                           </div> -->
                        <div class="text-color lighter">2 - 2.5 Lakhs p.a</div>
                     </div>
                     <div class="role-gap">
                        <h6 class="operations__title sub-title">Years of experience</h6>
                        <div class="text-color lighter">1 - 2 years</div>
                     </div>
                     <div class="job-role">
                        <h6 class="operations__title sub-title">Job role</h6>
                        <ul class="cities flex-row">
                           <li>
                              <p class="default-size cities__title">Area director, </p>
                           </li>
                           <li>
                              <p class="default-size cities__title">Baker, </p>
                           </li>
                           <li>
                              <p class="default-size cities__title">Accountant, </p>
                           </li>
                           <li>
                              <p class="default-size cities__title">Bartender, </p>
                           </li>
                           <li>
                              <p class="default-size cities__title">Area director, </p>
                           </li>
                           <li>
                              <p class="default-size cities__title">Baker, </p>
                           </li>
                           <li>
                              <p class="default-size cities__title">Accountant, </p>
                           </li>
                           <li>
                              <p class="default-size cities__title">Bartender, </p>
                           </li>
                           <li>
                              <p class="default-size cities__title">Area director, </p>
                           </li>
                           <li>
                              <p class="default-size cities__title">Baker, </p>
                           </li>
                           <li>
                              <p class="default-size cities__title">Accountant, </p>
                           </li>
                           <li>
                              <p class="default-size cities__title">Bartender, </p>
                           </li>
                           <li>
                              <p class="default-size cities__title">Area director, </p>
                           </li>
                           <li>
                              <p class="default-size cities__title">Baker, </p>
                           </li>
                           <li>
                              <p class="default-size cities__title">Accountant, </p>
                           </li>
                           <li>
                              <p class="default-size cities__title">Bartender, </p>
                           </li>
                           <li class="remain more-show">
                              <a href="" class="secondary-link">+10</a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <!-- <div class="seller-info__footer p-t-20">
                  <div class="contact flex-row">
                      <div class="contact__info flex-row">
                          <button class="btn fnb-btn outline full border-btn" data-toggle="modal" data-target="#contact-modal" href="#contact-modal">Apply Now</button>
                  
                          <a href="#" class="secondary-link p-l-20"><i class="fa fa-envelope p-r-5" aria-hidden="true"></i> Send me jobs like this</a>
                      </div>
                  </div>
                  </div> -->
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
            <!-- tabs structure -->
            <!--  <div class="nav-info m-t-20 p-t-20">
               <div class="sticky-section">
                   <div class="container">
                       <div class="row">
                           <div class="col-sm-8">
                               <ul class="nav-info__tabs flex-row">
                                   <li class="nav-section"><a class="active" href="#updates">Recent updates</a></li>
                                   <li class="nav-section"><a href="#listed">Listed In</a></li>
                                   <li class="nav-section"><a href="#overview">Overview</a></li>
                                   <li class="nav-section"><a href="#business">Similar Businesses</a></li>
                               </ul>
                           </div>
                           <div class="col-sm-4">
                               <div class="text-center">
                                   <button class="btn fnb-btn primary-btn full border-btn enquiry-btn">Send an Enquiry</button>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <ul class="nav-info__tabs flex-row">
                <li class="nav-section"><a class="active" href="#updates">Recent updates</a></li>
                   <li class="nav-section"><a href="#listed">Listed In</a></li>
                   <li class="nav-section"><a href="#overview">Overview</a></li>
                   <li class="nav-section"><a href="#business">Similar Businesses</a></li>
               </ul>
               </div> -->
            <!-- tabs structure ends -->
            <!-- updates section -->
            <div class="update-sec m-t-30" id="updates">
               <!-- <div class="update-sec__header flex-row update-space">
                  <h6 class="element-title m-t-5 m-b-5">Recent Updates</h6>
                  <a href="" class="text-secondary update-sec__link secondary-link open-sidebar">View More</a>
                  </div> -->
               <!--   <div class="update-sec__body update-space">
                  <h6 class="element-title update-sec__heading m-t-15 bolder">
                      Mystical the meat and fish store recent updates
                  </h6>
                  <p class="m-t-20 m-b-5 updateTitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, velit.</p>
                  <p class="update-sec__caption text-lighter">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem obcaecati voluptate debitis, quaerat eum expedita quia veritatis repellendus quod aliquid!
                  </p>
                  <ul class="flex-row update-img">
                      <li><img src="../public/img/gallery-1.png" alt="" width="80"></li>
                      <li><img src="../public/img/gallery-1.png" alt="" width="80"></li>
                      <li><img src="../public/img/gallery-1.png" alt="" width="80"></li>
                  </ul>
                  <p class="m-b-0 text-right"><a href="" class="text-secondary update-sec__link secondary-link open-sidebar">View More</a></p>
                  </div> -->
            </div>
            <!-- update section ends -->
            <!-- listed -->
            <div class="listed p-t-5 p-b-10" id="listed">
               <h5 class="jobDesc">About Company</h5>
               <hr>
               <div class="job-desc text-color stable-size">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti voluptatum iure aliquid assumenda id quibusdam incidunt reiciendis molestias facilis, minima ut. Quos aut soluta quo sunt neque enim, dolore illum ullam libero rem fugit laborum ut nostrum necessitatibus minima nisi saepe id. Natus possimus eaque tempora debitis quasi deleniti sunt.
               </div>
               <h5 class="jobDesc">Job Description</h5>
               <hr>
               <div class="job-desc text-color stable-size">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti voluptatum iure aliquid assumenda id quibusdam incidunt reiciendis molestias facilis, minima ut. Quos aut soluta quo sunt neque enim, dolore illum ullam libero rem fugit laborum ut nostrum necessitatibus minima nisi saepe id. Natus possimus eaque tempora debitis quasi deleniti sunt.
               </div>
               <div class="job-summary job-points">
                  <h6 class="sub-title">Job Summary</h6>
                  <div class="text-color stable-size">
                     Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti voluptatum iure aliquid assumenda id quibusdam incidunt reiciendis molestias facilis, minima ut. Quos aut soluta quo sunt neque enim, dolore illum ullam libero rem fugit laborum ut nostrum necessitatibus minima nisi saepe id. Natus possimus eaque tempora debitis quasi deleniti sunt. minima nisi saepe id. Natus possimus eaque tempora debitis quasi deleniti sunt.
                  </div>
               </div>
               <div class="candidate-profile job-points">
                  <h6 class="sub-title">Candidate Profile</h6>
                  <p class="sub-seperator">Education and Experience</p>
                  <div class="text-color stable-size">
                     Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti voluptatum iure aliquid assumenda id quibusdam incidunt reiciendis molestias facilis, minima ut. Quos aut soluta quo sunt neque enim, dolore illum ullam libero rem fugit laborum ut nostrum necessitatibus minima nisi saepe id. Natus possimus eaque tempora debitis quasi deleniti sunt.
                  </div>
                  <p class="sub-seperator">OR</p>
                  <div class="text-color stable-size">
                     Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti voluptatum iure aliquid assumenda id quibusdam incidunt reiciendis molestias facilis, minima ut. Quos aut soluta quo sunt neque enim, dolore illum ullam libero rem fugit laborum ut nostrum necessitatibus minima nisi saepe id. Natus possimus eaque tempora debitis quasi deleniti sunt.
                  </div>
               </div>
               <div class="core-activities job-points">
                  <h6 class="sub-title">Core Work Activities</h6>
                  <div class="text-color stable-size">
                     <div class="m-t-10">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti voluptatum iure aliquid assumenda id quibusdam incidunt reiciendis molestias facilis,</div>
                     <div class="m-t-10">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti voluptatum iure aliquid assumenda id quibusdam incidunt reiciendis molestias facilis,</div>
                     <div class="m-t-10">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti voluptatum iure aliquid assumenda id quibusdam incidunt reiciendis molestias facilis,</div>
                     <div class="m-t-10">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti voluptatum iure aliquid assumenda id quibusdam incidunt reiciendis molestias facilis,</div>
                     <div class="m-t-10">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti voluptatum iure aliquid assumenda id quibusdam incidunt reiciendis molestias facilis,</div>
                  </div>
               </div>
               <div class="job-summary job-points">
                  <h6 class="sub-title">Address/Map</h6>
                  <div class="text-color stable-size">
                     <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15380.091383021922!2d73.81245283848914!3d15.483203277923609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bbfc0a93361ccd9%3A0xdd98120b24e5be61!2sPanjim%2C+Goa!5e0!3m2!1sen!2sin!4v1498804405360" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
                  </div>
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
            <!--     <div class="featured-news">
               <h5>Featured News Articles</h5>
               <hr>
               <div class="featured-news__container flex-row flex-wrap">
                  <div class="featured-news__row flex-row">
                       <div class="newslogo">
                            <img src="http://via.placeholder.com/90x90">
                       </div>
                       <div class="newsdetail">
                           <div>
                               <p class="m-b-0 default-size">Nestle details ways to make cappuc-cinos creamier.</p>
                               <span class="x-small text-color lighter">June 28, 2017</span>
                           </div>
                           <label class="fnb-label supplier">Supplier innovation</label>
                       </div>
                   </div>
                   <div class="featured-news__row flex-row">
                       <div class="newslogo">
                            <img src="http://via.placeholder.com/90x90">
                       </div>
                       <div class="newsdetail">
                           <div>
                               <p class="m-b-0 default-size">Nestle details ways to make cappuc-cinos creamier.</p>
                               <span class="x-small text-color lighter">June 28, 2017</span>
                           </div>
                           <label class="fnb-label supplier">Supplier innovation</label>
                       </div>
                   </div> 
                   <div class="featured-news__row flex-row">
                       <div class="newslogo">
                            <img src="http://via.placeholder.com/90x90">
                       </div>
                       <div class="newsdetail">
                           <div>
                               <p class="m-b-0 default-size">Nestle details ways to make cappuc-cinos creamier.</p>
                               <span class="x-small text-color lighter">June 28, 2017</span>
                           </div>
                           <label class="fnb-label supplier">Supplier innovation</label>
                       </div>
                   </div>
                   <div class="featured-news__row flex-row">
                       <div class="newslogo">
                            <img src="http://via.placeholder.com/90x90">
                       </div>
                       <div class="newsdetail">
                           <div>
                               <p class="m-b-0 default-size">Nestle details ways to make cappuc-cinos creamier.</p>
                               <span class="x-small text-color lighter">June 28, 2017</span>
                           </div>
                           <label class="fnb-label supplier">Supplier innovation</label>
                       </div>
                   </div>
               </div>
               
               </div> -->
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
            <!-- status change -->
            <!--                <div class="status-listing">
               <div class="form-group">
                   <label for="status" class="title-label">Change the status of listing</label>
                   <select class="fnb-select select-variant text-lighter" id="status">
                       <option>Update status</option>
                       <option>Update status</option>
                       <option>Update status</option>
                       <option>Update statu</option>
                       <option>Update status</option>
                   </select>
               </div>
               <p class="sub-title m-b-15">Your Listing is submitted for Approval</p>
               <p class="sub-title heavier">
                   <i class="fa fa-spinner text-primary p-r-5 spin" aria-hidden="true"></i> Pending Review
               </p>
               </div> -->
            <!-- core categories -->
            <div class="equal-col">
               <!-- <div class="core-cat">
                  <h6 class="element-title m-t-0 m-b-15 text-center">Post a job on FnB Circle for free!</h6>
                  <div class="contact__enquiry text-center mobile-hide">    
                     <button class="btn fnb-btn primary-btn full border-btn" type="button"><i class="p-r-5 fa fa-paper-plane-o" aria-hidden="true"></i> Post your job</button>
                     
                  </div>
                  </div>  -->
               <!--  <div class="share-job">
                  <p class="element-title heavier text-center">Share</p>
                  <ul class="options flex-row flex-wrap">
                      <li><a href="#"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                      <li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                      <li><i class="fa fa-facebook-official" aria-hidden="true"></i></li></li>
                      <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i><</a>/li>
                      <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                  </ul>
                  </div> -->
               <div class="Company-info">
                  <div class="flex-row name-row">
                     <div class="company-logo">
                        <img src="http://via.placeholder.com/60x60">
                     </div>
                     <div class="company-name heavier">
                        <div>
                           <div class="flex-row heavier"><i class="fa fa-building-o p-r-5" aria-hidden="true"></i> InterContinental Hotels Group</div>
                           <a href="#" class="primary-link x-small ">www.ichotelsgroup.com <i class="fa fa-link p-r-5" aria-hidden="true"></i></a>
                           <a href="#" class="secondary-link dis-block x-small m-t-5">View details</a>
                        </div>
                        <!-- <div class="share-job">
                           <ul class="options flex-row flex-wrap">
                               <li><a href="#"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                               <li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                               <li><a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                               <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                               <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                           </ul>
                           </div> -->
                     </div>
                  </div>
                  <!-- <div class="company-detail text-color">
                     Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi debitis consequatur sed ea recusandae ut iure, odit hic inventore dignissimos iste incidunt neque, quasi, fuga aliquid!
                     </div> -->
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
         <!-- enquiry form -->
         <!-- <div class="form-toggle desk-hide">
            <span class="fnb-icons enquiry-white"></span>
            </div> -->
         <!-- 
            <div class="sticky-bottom mobile-flex desk-hide">
                <div class="stick-bottom__text">
                    <p class="m-b-0 element-title text-capitalise bolder">Get best deals in "Meat &amp; poultry"</p>
                </div>
                <div class="actions">
                    <button class="btn fnb-btn primary-btn full border-btn send-enquiry form-toggle">Send Enquiry</button>
                </div>
            </div> -->
         <!--  <div class="pos-fixed fly-out">
            <div class="mobile-back desk-hide mobile-flex">
                <div class="left mobile-flex">
                    <i class="fa fa-arrow-left text-primary back-icon" aria-hidden="true"></i>
                    <p class="element-title heavier m-b-0">Enquiry</p>
                </div>
                <div class="right">
                   
                </div>
            </div>
            <div class="fly-out__content">
            <div class="enquiry-form card m-t-30 m-b-20">
            <form method="">
            <div class="enquiry-form__header flex-row space-between">
            
            <div class="enquiry-title">
            <h6 class="element-title m-t-0 m-b-0">Send Enquiry To</h6>
            <p class="sub-title">Mystical the meat and fish store</p>
            </div>
                            <span class="fnb-icons enquiry"></span>
            </div>
            <div class="enquiry-form__body m-t-10">
            <div class="form-group p-t-10 m-b-0">
            
                                <label class="m-b-0 text-lighter float-label required" for="contact_name">Name</label>
                                <input type="text" class="form-control fnb-input float-input" id="contact_name">
            </div>
            <div class="form-group p-t-10 m-b-0">
            
                                <label class="m-b-0 text-lighter float-label required" for="contact_email">Email</label>
                                <input type="email" class="form-control fnb-input float-input" id="contact_email">
            </div>
            <div class="form-group p-t-10 m-b-0">
                                <label class="m-b-0 text-lighter float-label required" for="contact_phone">Phone no</label>
                                <input type="tel" class="form-control fnb-input float-input" id="contact_phone">
            
            </div>
            <div class="form-group p-t-20 p-b-10 m-b-0">
            <label class="m-b-0 custom-label required" for="describe">What describe you the best?</label>
                                <p class="x-small text-lighter lighter">(Please select atleast one)</p>
            <select class="form-control fnb-select" id="describe">
                                 <option>--Select--</option>
                                 <option>I work in the F&amp;B industry</option>
                                 <option>I work in the F&amp;B industry</option>
                                 <option>I work in the F&amp;B industry</option>
                                 <option>I work in the F&amp;B industry</option>
                             </select>
            </div>
            
            <div class="form-group p-t-10 p-b-20 m-b-0">
            
                                <label class="text-lighter" for="contact_msg">Tell the business owner what you're looking for</label>
                                
                                <input type="text" class="form-control fnb-input" id="contact_msg" placeholder="Eg: The categories that you're interested in">
            </div>
            <div class="form-group p-t-10 m-b-0">
            <button class="btn fnb-btn primary-btn full border-btn">Send an Enquiry</button>
            </div>
            </div>
            </form>
            </div>
            </div>
            </div> -->
         <!-- enquiry form ends -->
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
         <!-- Browse category ends-->
         <!-- <div class="business-listing p-t-20 p-b-20 text-center">
            <span class="fnb-icons note"></span>
            <div class="business-listing__content m-b-15">
            <h6 class="element-title">Create a Business Listing</h6>
            <p class="sub-title">Post your listing on F&amp;BCircle for free</p>
            </div>
            <button class="btn fnb-btn outline full border-btn">Create Listing</button>
            </div> -->
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
   <!-- Enquiry modal -->
   <div class="modal fnb-modal enquiry-modal verification-modal multilevel-modal fade" id="enquiry-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <button class="close mobile-hide" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
               <div class="mobile-back flex-row desk-hide">
                  <div class="back ellipsis">
                     <button class="btn fnb-btn outline border-btn no-border ellipsis" data-dismiss="modal"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i></button>
                     <span class="m-b-0 ellipsis heavier back-text">Back to Mystical the meat and fish store</span>
                  </div>
               </div>
            </div>
            <div class="modal-body">
               <div class="success-stuff hidden">
                  <!-- enquiry success -->
                  <div class="enquiry-success flex-row">
                     <i class="fa fa-check-circle" aria-hidden="true"></i>
                     <h6 class="text-color text-medium enquiry-success__text">Email &amp; SMS with your details has been sent to the relevant listing owners you will be contacted soon.</h6>
                  </div>
                  <!-- enquiry success ends -->
                  <!-- suppliers details -->
                  <div class="suppliers-data">
                     <!-- <h5 class="text-darker lighter m-t-0 deal-text">We can help you get the best deals on F&amp;BCircle <p class="xx-small m-t-5 text-medium m-b-20">Please give us details of the categories that you're interested in and also the areas of operation.</p></h5> -->
                     <p class="element-title heavier text-darker">Don't miss out on these suppliers <img src="img/direction-down-2.png" class="img-responsive direction-down"></p>
                     <!-- Categories start -->
                     <div class="categories-select gap-separator">
                        <p class="text-darker describes__title text-medium">Categories <span class="xx-small text-lighter">(Select from the list below or add other categories.)</span></p>
                        <ul class="categories__points flex-points flex-row flex-wrap">
                           <li>
                              <label class="flex-row">
                                 <input type="checkbox" class="checkbox" for="chicken">
                                 <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                              </label>
                           </li>
                           <li>
                              <label class="flex-row">
                                 <input type="checkbox" class="checkbox" for="egg">
                                 <p class="text-medium describes__text flex-points__text text-color" id="egg">Egg</p>
                              </label>
                           </li>
                           <li>
                              <label class="flex-row">
                                 <input type="checkbox" class="checkbox" for="chicken">
                                 <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                              </label>
                           </li>
                           <li>
                              <label class="flex-row">
                                 <input type="checkbox" class="checkbox" for="egg">
                                 <p class="text-medium describes__text flex-points__text text-color" id="egg">Egg</p>
                              </label>
                           </li>
                           <li>
                              <label class="flex-row">
                                 <input type="checkbox" class="checkbox" for="chicken">
                                 <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                              </label>
                           </li>
                           <li>
                              <label class="flex-row">
                                 <input type="checkbox" class="checkbox" for="egg">
                                 <p class="text-medium describes__text flex-points__text text-color" id="egg">Egg</p>
                              </label>
                           </li>
                           <li>
                              <label class="flex-row">
                                 <input type="checkbox" class="checkbox" for="chicken">
                                 <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                              </label>
                           </li>
                           <li>
                              <label class="flex-row">
                                 <input type="checkbox" class="checkbox" for="egg">
                                 <p class="text-medium describes__text flex-points__text text-color" id="egg">Egg</p>
                              </label>
                           </li>
                           <li>
                              <label class="flex-row">
                                 <input type="checkbox" class="checkbox" for="chicken">
                                 <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                              </label>
                           </li>
                        </ul>
                        <div class="add-more-cat m-t-5">
                           <a href="#" class="more-show secondary-link text-decor">+ Add more</a>
                           <div class="form-group m-t-5 m-b-0 add-more-cat__input">
                              <input type="text" class="form-control fnb-input flexdatalist cat-add-data" placeholder="Type to select categories" multiple='multiple' data-min-length='1'>
                           </div>
                        </div>
                     </div>
                     <!-- Categories ends -->
                     <!-- Areas start -->
                     <div class="areas-select gap-separator">
                        <p class="text-darker describes__title heavier">Areas <span class="xx-small text-lighter">(Select your areas of interest)</span></p>
                        <ul class="areas-select__selection flex-row flex-wrap">
                           <li>
                              <div class="required left-star flex-row">
                                 <select class="form-control fnb-select select-variant">
                                    <option>Select City</option>
                                    <option>Delhi</option>
                                    <option>Goa</option>
                                    <option>Mumbai</option>
                                    <option>Goa</option>
                                 </select>
                              </div>
                           </li>
                           <li>
                              <div class="required left-star flex-row">
                                 <select class="fnb-select select-variant default-area-select" multiple="multiple">
                                    <option>Bandra</option>
                                    <option>Andheri</option>
                                    <option>Dadar</option>
                                    <option>Borivali</option>
                                    <option>Church gate</option>
                                 </select>
                              </div>
                           </li>
                        </ul>
                        <ul class="areas-select__selection flex-row flex-wrap area-append hidden">
                           <li>
                              <div class="required left-star flex-row">
                                 <select class="form-control fnb-select select-variant">
                                    <option>Select City</option>
                                    <option>Delhi</option>
                                    <option>Goa</option>
                                    <option>Mumbai</option>
                                    <option>Goa</option>
                                 </select>
                              </div>
                           </li>
                           <li>
                              <div class="required left-star flex-row">
                                 <select class="fnb-select select-variant areas-appended" multiple="multiple">
                                    <option>Bandra</option>
                                    <option>Andheri</option>
                                    <option>Dadar</option>
                                    <option>Borivali</option>
                                    <option>Church gate</option>
                                 </select>
                              </div>
                           </li>
                        </ul>
                        <div class="m-t-10 adder">
                           <a href="#" class="secondary-link text-decor heavier add-areas">+ Add more</a>
                        </div>
                     </div>
                     <!-- Areas ends -->
                     <div class="seller-info bg-card filter-cards">
                        <div class="seller-info__body filter-cards__body white-space">
                           <div class="flex-row suppliers-title-head">
                              <div class="suppliers-title">
                                 <h3 class="seller-info__title main-heading ellipsis" title="Mystical the meat and fish store">Mystical the meat and fish store</h3>
                                 <div class="location flex-row">
                                    <span class="fnb-icons map-icon"></span>
                                    <p class="location__title m-b-0 text-lighter">Gandhi Nagar, Delhi</p>
                                 </div>
                              </div>
                              <div class="suppliers-stat">
                                 <div class="rating-view flex-row">
                                    <div class="rating">
                                       <div class="bg"></div>
                                       <div class="value" style="width: 80%;"></div>
                                    </div>
                                 </div>
                                 <p class="featured text-secondary m-b-0">
                                    <i class="flex-row featured__title">
                                    <i class="fa fa-flag featured__icon p-r-10" aria-hidden="true"></i>
                                    Featured
                                    </i>
                                 </p>
                              </div>
                           </div>
                           <div class="m-t-15 cat-holder flex-row">
                              <div class="core-cat">
                                 <p class="text-lighter m-t-0 m-b-0">Core Categories</p>
                                 <ul class="fnb-cat flex-row">
                                    <li><a href="" class="fnb-cat__title">Chicken Retailer</a></li>
                                    <li><a href="" class="fnb-cat__title">Mutton</a></li>
                                    <li><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                    <li><a href="" class="fnb-cat__title">Pork Wholesaler</a></li>
                                    <li class="desk-hide"><a href="" class="fnb-cat__title">Egg</a></li>
                                    <li class="desk-hide"><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                    <li class="cat-more more-show"><a href="" class="text-darker">+5 more</a></li>
                                 </ul>
                              </div>
                              <div class="get-details">
                                 <button class="btn fnb-btn outline full border-btn fullwidth">Get Details <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="seller-info bg-card filter-cards">
                        <div class="seller-info__body filter-cards__body white-space">
                           <div class="flex-row suppliers-title-head">
                              <div class="suppliers-title">
                                 <h3 class="seller-info__title main-heading ellipsis" title="CH Exports and imports private limited">CH Exports and imports private limited</h3>
                                 <div class="location flex-row">
                                    <span class="fnb-icons map-icon"></span>
                                    <p class="location__title m-b-0 text-lighter">Chennai, Tamil Nadu</p>
                                 </div>
                              </div>
                              <div class="suppliers-stat">
                                 <div class="rating-view flex-row">
                                    <div class="rating">
                                       <div class="bg"></div>
                                       <div class="value" style="width: 100%;"></div>
                                    </div>
                                 </div>
                                 <p class="featured text-secondary m-b-0">
                                    <i class="flex-row featured__title">
                                    <i class="fa fa-flag featured__icon p-r-10" aria-hidden="true"></i>
                                    Featured
                                    </i>
                                 </p>
                              </div>
                           </div>
                           <div class="m-t-15 cat-holder flex-row">
                              <div class="core-cat">
                                 <p class="text-lighter m-t-0 m-b-0">Core Categories</p>
                                 <ul class="fnb-cat flex-row">
                                    <li><a href="" class="fnb-cat__title">Chicken Retailer</a></li>
                                    <li><a href="" class="fnb-cat__title">Mutton</a></li>
                                    <li><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                    <li><a href="" class="fnb-cat__title">Pork Wholesaler</a></li>
                                    <li class="desk-hide"><a href="" class="fnb-cat__title">Egg</a></li>
                                    <li class="desk-hide"><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                    <li class="cat-more more-show"><a href="" class="text-darker">+5 more</a></li>
                                 </ul>
                              </div>
                              <div class="get-details">
                                 <button class="btn fnb-btn outline full border-btn fullwidth">Get Details <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- suppliers details ends -->
               </div>
               <div class="enquiry-details flex-row content-data">
                  <!-- col left -->
                  <div class="detail-cols col-left enquiry-details__intro flex-row">
                     <!-- <h5 class="bolder intro-text">To send your enquiry, please fill the details.
                        <img src="img/direction-down.png" class="img-responsive direction-down">
                        </h5> -->
                     <!-- premium details -->
                     <div class="send-enquiry">
                        <h5 class="bolder intro-text flex-row space-between">
                           Send a<br class="mobile-hide"> direct enquiry to...
                           <div class="rotator mobile-hide">
                              <img src="img/direction-down.png" class="img-responsive direction-down">
                           </div>
                        </h5>
                        <div class="seller-enquiry">
                           <p class="sub-title heavier text-darker text-capitalise flex-row seller-enquiry__title"><span class="brand-name">Mystical the meat and fish store</span> <span class="fnb-icons verified-icon"></span></p>
                           <div class="location flex-row mobile-hide">
                              <span class="fnb-icons map-icon"></span>
                              <p class="location__title m-b-0 text-lighter">Mumbai, Andheri</p>
                           </div>
                           <div class="rat-view flex-row mobile-hide">
                              <div class="rating">
                                 <div class="bg"></div>
                                 <div class="value" style="width: 80%;"></div>
                              </div>
                              <div class="views flex-row">
                                 <span class="fnb-icons eye-icon"></span>
                                 <p class="views__title text-lighter m-b-0"><span class="heavier">126</span> Views</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- premium details ends -->
                     <div class="h-i-w mobile-hide">
                        <p class="sub-title bolder text-darker m-b-20">How it works</p>
                        <ul class="points">
                           <li>
                              <p class="m-b-0 points__container flex-row"><span class="points__number">1</span> <span class="points__text text-color">Submit your details.</span></p>
                           </li>
                           <li>
                              <p class="m-b-0 points__container flex-row"><span class="points__number">2</span> <span class="points__text text-color">Your details are sent to the business owner.</span></p>
                           </li>
                           <li>
                              <p class="m-b-0 points__container flex-row"><span class="points__number">3</span> <span class="points__text text-color">They will get back to you with their offers.</span></p>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <!-- col left ends -->
                  <!-- col right -->
                  <div class="detail-cols col-right enquiry-details__content">
                     <!-- level one starts -->
                     <div class="level-one">
                        <p class="content-title text-darker m-b-0 text-medium">Ensure that you provide the correct details as the business owner will use these details to contact you.</p>
                        <!-- form -->
                        <div class="formFields p-b-15 row">
                           <div class="col-sm-6">
                              <div class="form-group m-b-0">
                                 <!-- <label class="m-b-0 lighter text-color xx-small required">Name</label> -->
                                 <label class="m-b-0 text-lighter float-label required" for="name">Name</label>
                                 <input type="text" class="form-control fnb-input float-input" id="name">
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-group m-b-0">
                                 <label class="m-b-0 text-lighter float-label required" for="number">Phone</label>
                                 <input type="tel" class="form-control fnb-input float-input" id="number">
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-group m-b-0">
                                 <label class="m-b-0 text-lighter float-label required" for="email">Email</label>
                                 <input type="text" class="form-control fnb-input float-input" id="email">
                              </div>
                           </div>
                           <div class="col-sm-6"></div>
                        </div>
                        <!-- form ends -->
                        <!-- describes best -->
                        <div class="describes gap-separator">
                           <p class="text-darker describes__title text-medium">What describes you the best? <span class="xx-small text-lighter">(Please select atleast one)</span></p>
                           <div class="row">
                              <div class="col-sm-6">
                                 <select class="fnb-select select-variant multi-select" multiple="multiple">
                                    <option>I work in the F&amp;B industry</option>
                                    <option>I am a resturant owner</option>
                                    <option>I am a supplier to F&amp;B industry</option>
                                    <option>I provide services to F&amp;B industry</option>
                                    <option>I am a manufacturer</option>
                                    <option>Others...</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <!-- describes best ends -->
                        <!-- looking for -->
                        <div class="looking-for gap-separator">
                           <a class="secondary-link text-decor desk-hide looking-for__toggle" data-toggle="collapse" href="#lookingfor" aria-expanded="false" aria-controls="lookingfor">Add a note</a>
                           <div class="collapse in" id="lookingfor">
                              <p class="text-darker describes__title text-medium">Tell the business owner what you're looking for</p>
                              <div class="form-group">
                                 <input type="text" class="form-control fnb-input" placeholder="">
                              </div>
                           </div>
                        </div>
                        <!-- looking for ends -->
                        <!-- action -->
                        <div class="send-action">
                           <button class="btn fnb-btn primary-btn full border-btn level-two-toggle">Send</button>
                        </div>
                        <!-- action ends -->
                     </div>
                     <!-- Level one ends -->
                     <!-- Level two starts -->
                     <div class="level-two levels">
                        <p class="content-title text-darker m-b-0 text-medium mobile-hide">Verify your email and phone number to contact the listing.</p>
                        <!-- verify email and contact -->
                        <div class="verification gap-separator">
                           <p class="content-title text-darker m-b-0 text-lighter desk-hide m-b-15">Verify your email and phone number to contact the listing.</p>
                           <div class="verification__row flex-row">
                              <div class="verification__detail flex-row">
                                 <div class="verify-exclamation">
                                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                                 </div>
                                 <p class="text-darker verification__text larger">Please enter the code sent to <br clear="desk-hide verify-seperator"><span class="email bolder">valenie@gmail.com</span> <a href="#" class="heavier secondary-link text-decor">Edit</a></p>
                              </div>
                              <div class="verification__col">
                                 <div class="verification__code">
                                    <input type="text" class="form-control fnb-input" placeholder="Enter the code">
                                    <a href="#" class="secondary-link text-decor p-l-10 x-small">Submit</a>
                                    <p class="x-small text-lighter m-b-0 m-t-10 didnt-receive">Didn't receive the code? <a href="#" class="dark-link x-small heavier"><i class="fa fa-refresh" aria-hidden="true"></i> Resend Email</a></p>
                                 </div>
                              </div>
                           </div>
                           <hr>
                           <div class="verification__row flex-row">
                              <div class="verification__detail flex-row">
                                 <div class="verify-exclamation">
                                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                                 </div>
                                 <p class="text-darker verification__text larger">Please enter the code sent to <br clear="desk-hide verify-seperator"><span class="email bolder">+91 9876543200</span> <a href="#" class="heavier secondary-link text-decor">Edit</a></p>
                              </div>
                              <div class="verification__col">
                                 <div class="verification__code">
                                    <input type="text" class="form-control fnb-input" placeholder="Enter the code">
                                    <a href="#" class="secondary-link text-decor p-l-10 x-small">Submit</a>
                                    <p class="x-small text-lighter m-b-0 m-t-10 didnt-receive">Didn't receive the code? <a href="#" class="dark-link x-small heavier"><i class="fa fa-refresh" aria-hidden="true"></i> Resend SMS</a></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="mobile-hide">
                           <!-- verify email and contact ends -->
                           <p class="content-title text-darker m-b-0 text-medium">Ensure that you provide the correct details as the business owner will use these details to contact you.</p>
                           <!-- form -->
                           <div class="formFields gap-separator row">
                              <div class="col-sm-6">
                                 <div class="form-group m-b-0">
                                    <!-- <label class="m-b-0 lighter text-color xx-small required">Name</label> -->
                                    <label class="m-b-0 text-lighter float-label required" for="name">Name</label>
                                    <input type="text" class="form-control fnb-input float-input" id="name" value="Suresh Sharma">
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-group m-b-0">
                                    <label class="m-b-0 text-lighter float-label required" for="number">Phone</label>
                                    <input type="tel" class="form-control fnb-input float-input" id="number" value="9876543200">
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-group m-b-0">
                                    <label class="m-b-0 text-lighter float-label required" for="email">Email</label>
                                    <input type="text" class="form-control fnb-input float-input" id="email" value="sunil773@gmail.com">
                                 </div>
                              </div>
                              <div class="col-sm-6"></div>
                           </div>
                           <!-- form ends -->
                           <!-- categories -->
                           <div class="categories-select gap-separator">
                              <p class="text-darker describes__title text-medium">Categories <span class="xx-small text-lighter">(Select from the list below or add other categories.)</span></p>
                              <ul class="categories__points flex-points flex-row flex-wrap">
                                 <li>
                                    <label class="flex-row">
                                       <input type="checkbox" class="checkbox" for="chicken">
                                       <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                                    </label>
                                 </li>
                                 <li>
                                    <label class="flex-row">
                                       <input type="checkbox" class="checkbox" for="egg">
                                       <p class="text-medium describes__text flex-points__text text-color" id="egg">Egg</p>
                                    </label>
                                 </li>
                                 <li>
                                    <label class="flex-row">
                                       <input type="checkbox" class="checkbox" for="chicken">
                                       <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                                    </label>
                                 </li>
                                 <li>
                                    <label class="flex-row">
                                       <input type="checkbox" class="checkbox" for="egg">
                                       <p class="text-medium describes__text flex-points__text text-color" id="egg">Egg</p>
                                    </label>
                                 </li>
                                 <li>
                                    <label class="flex-row">
                                       <input type="checkbox" class="checkbox" for="chicken">
                                       <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                                    </label>
                                 </li>
                                 <li>
                                    <label class="flex-row">
                                       <input type="checkbox" class="checkbox" for="egg">
                                       <p class="text-medium describes__text flex-points__text text-color" id="egg">Egg</p>
                                    </label>
                                 </li>
                                 <li>
                                    <label class="flex-row">
                                       <input type="checkbox" class="checkbox" for="chicken">
                                       <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                                    </label>
                                 </li>
                                 <li>
                                    <label class="flex-row">
                                       <input type="checkbox" class="checkbox" for="egg">
                                       <p class="text-medium describes__text flex-points__text text-color" id="egg">Egg</p>
                                    </label>
                                 </li>
                                 <li>
                                    <label class="flex-row">
                                       <input type="checkbox" class="checkbox" for="chicken">
                                       <p class="text-medium categories__text flex-points__text text-color" id="chicken">Chicken</p>
                                    </label>
                                 </li>
                              </ul>
                              <div class="add-more-cat text-right m-t-5">
                                 <a href="#" class="more-show secondary-link text-decor">+ Add more</a>
                                 <div class="form-group m-t-5 m-b-0 add-more-cat__input">
                                    <input type="text" class="form-control fnb-input flexdatalist cat-add-data" placeholder="Type to select categories" multiple='multiple' data-min-length='1'>
                                 </div>
                              </div>
                           </div>
                           <!-- categories ends -->
                           <!-- Add categories -->
                           <!-- <div class="add-categories gap-separator">
                              <p class="text-darker describes__title text-medium">Add Categories</p>
                              <div class="form-group m-b-0">
                                  <input type="text" class="form-control fnb-input flexdatalist" placeholder="Type to select categories" multiple='multiple' data-min-length='1'>
                              </div>
                              </div> -->
                           <!-- add categories ends -->
                           <!-- areas select -->
                           <div class="areas-select gap-separator">
                              <p class="text-darker describes__title heavier">Areas <span class="xx-small text-lighter">(Select your areas of interest)</span></p>
                              <ul class="areas-select__selection flex-row flex-wrap">
                                 <li>
                                    <div class="required left-star flex-row">
                                       <select class="form-control fnb-select select-variant">
                                          <option>Select City</option>
                                          <option>Delhi</option>
                                          <option>Goa</option>
                                          <option>Mumbai</option>
                                          <option>Goa</option>
                                       </select>
                                    </div>
                                 </li>
                                 <li>
                                    <div class="required left-star flex-row">
                                       <select class="fnb-select select-variant default-area-select" multiple="multiple">
                                          <option>Bandra</option>
                                          <option>Andheri</option>
                                          <option>Dadar</option>
                                          <option>Borivali</option>
                                          <option>Church gate</option>
                                       </select>
                                    </div>
                                 </li>
                              </ul>
                              <ul class="areas-select__selection flex-row flex-wrap area-append hidden">
                                 <li>
                                    <div class="required left-star flex-row">
                                       <select class="form-control fnb-select select-variant">
                                          <option>Select City</option>
                                          <option>Delhi</option>
                                          <option>Goa</option>
                                          <option>Mumbai</option>
                                          <option>Goa</option>
                                       </select>
                                    </div>
                                 </li>
                                 <li>
                                    <div class="required left-star flex-row">
                                       <select class="fnb-select select-variant areas-appended" multiple="multiple">
                                          <option>Bandra</option>
                                          <option>Andheri</option>
                                          <option>Dadar</option>
                                          <option>Borivali</option>
                                          <option>Church gate</option>
                                       </select>
                                    </div>
                                 </li>
                              </ul>
                              <div class="text-right m-t-10 adder">
                                 <a href="#" class="secondary-link text-decor heavier add-areas">+ Add more</a>
                              </div>
                           </div>
                        </div>
                        <!-- areas select -->
                        <!-- action -->
                        <div class="send-action">
                           <button class="btn fnb-btn primary-btn full border-btn success-toggle">Send</button>
                        </div>
                        <!-- action ends -->
                     </div>
                     <!-- level two ends -->
                  </div>
                  <!-- col right ends -->
               </div>
            </div>
            <div class="modal-footer mobile-hide">
               <div class="sub-category hidden">
                  <button class="btn fnb-btn outline full border-btn">save</button>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Enquiry ends -->
   <!-- Contact Modal -->
   <div class="modal fnb-modal contact-modal verification-modal multilevel-modal fade" id="contact-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <button class="close mobile-hide" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
               <div class="mobile-back flex-row desk-hide">
                  <div class="back ellipsis">
                     <button class="btn fnb-btn outline border-btn no-border" data-dismiss="modal"><i class="fa fa-arrow-left p-r-10" aria-hidden="true"></i></button>
                     <span class="m-b-0 ellipsis heavier back-text">Back to Mystical the meat and fish store</span>
                  </div>
               </div>
            </div>
            <div class="modal-body">
               <div class="content-data">
                  <!-- Contact Details -->
                  <div class="level-one enquiry-details flex-row ">
                     <div class="detail-cols extra-padding col-left col-left--full enquiry-details__intro flex-row">
                        <div class="send-enquiry">
                           <h5 class="intro-text flex-row space-between">
                              Please login to view the <br class="mobile-hide"> contact details of...
                           </h5>
                           <div class="seller-enquiry">
                              <p class="sub-title heavier text-darker text-capitalise flex-row seller-enquiry__title"><span class="brand-name">Mystical the meat and fish store</span> <span class="fnb-icons verified-icon"></span></p>
                              <div class="location flex-row mobile-hide">
                                 <span class="fnb-icons map-icon"></span>
                                 <p class="location__title m-b-0 text-lighter">Mumbai, Andheri</p>
                              </div>
                              <div class="rat-view flex-row mobile-hide">
                                 <div class="rating">
                                    <div class="bg"></div>
                                    <div class="value" style="width: 80%;"></div>
                                 </div>
                                 <div class="views flex-row">
                                    <span class="fnb-icons eye-icon"></span>
                                    <p class="views__title text-lighter m-b-0"><span class="heavier">126</span> Views</p>
                                 </div>
                              </div>
                           </div>
                           <div class="m-t-50 log-link sub-title">
                              <a href="#" class="primary-link heavier text-decor">Login if already registered</a>
                           </div>
                        </div>
                     </div>
                     <div class="detail-cols extra-padding contact col-right enquiry-details__content">
                        <h5 class="intro-text">Give your details below
                        </h5>
                        <p class="content-title text-darker m-b-0 m-t-10 text-medium">Ensure that you provide the correct details as the business owner will use these details to contact you.</p>
                        <div class="formFields row">
                           <div class="col-sm-12">
                              <div class="form-group m-b-0">
                                 <label class="m-b-0 text-lighter float-label required" for="contact_name">Name</label>
                                 <input type="text" class="form-control fnb-input float-input" id="contact_name">
                              </div>
                           </div>
                           <div class="col-sm-12">
                              <div class="form-group m-b-0">
                                 <label class="m-b-0 text-lighter float-label required" for="contact_email">Email</label>
                                 <input type="email" class="form-control fnb-input float-input" id="contact_email">
                              </div>
                           </div>
                           <div class="col-sm-12">
                              <div class="form-group">
                                 <label class="m-b-0 text-lighter float-label required" for="contact_number">Phone</label>
                                 <input type="tel" class="form-control fnb-input float-input" id="contact_number">
                              </div>
                           </div>
                        </div>
                        <div class="p-t-10">
                           <div class="send-action">
                              <button class="btn fnb-btn primary-btn full border-btn level-two-toggle">Submit <i class="fa fa-circle-o-notch fa-spin fa-fw"></i></button>
                           </div>
                        </div>
                        <div class="or-divider">
                           OR
                        </div>
                     </div>
                  </div>
                  <!-- Contact Details End -->
                  <!-- Verify Details -->
                  <div class="level-two levels verify-details detail-cols ">
                     <h6 class="intro-text">Verify your email &amp; number to contact Mystical the meat &amp; fish store
                     </h6>
                     <div class="verification vertical-margin gap-separator">
                        <p class="content-title text-darker m-b-0 text-lighter desk-hide m-b-15">Verify your email and phone number to contact the listing.</p>
                        <div class="verification__row flex-row">
                           <div class="verification__detail flex-row">
                              <div class="verify-exclamation">
                                 <i class="fa fa-exclamation" aria-hidden="true"></i>
                              </div>
                              <p class="text-darker verification__text larger">Please enter the code sent to <br clear="desk-hide verify-seperator"><span class="email bolder">valenie@gmail.com</span> <a href="#" class="heavier secondary-link text-decor">Edit</a></p>
                           </div>
                           <div class="flex-row flex-end verification__col">
                              <div class="verification__code text-right">
                                 <input type="text" class="form-control fnb-input" placeholder="Enter the code">
                                 <a href="#" class="secondary-link text-decor p-l-10 x-small">Submit</a>
                                 <p class="x-small text-lighter m-b-0 m-t-5 didnt-receive">Didn't receive the code? <a href="#" class="dark-link x-small heavier"><i class="fa fa-refresh" aria-hidden="true"></i> Resend Email</a></p>
                              </div>
                           </div>
                        </div>
                        <hr>
                        <div class="verification__row flex-row">
                           <div class="verification__detail flex-row">
                              <div class="verify-exclamation">
                                 <i class="fa fa-exclamation" aria-hidden="true"></i>
                              </div>
                              <p class="text-darker verification__text larger">Please enter the code sent to <br clear="desk-hide verify-seperator"><span class="email bolder">+919876543200</span> <a href="#" class="heavier secondary-link text-decor">Edit</a></p>
                           </div>
                           <div class="flex-row flex-end verification__col">
                              <div class="verification__code text-right">
                                 <input type="text" class="form-control fnb-input" placeholder="Enter the code">
                                 <a href="#" class="secondary-link text-decor p-l-10 x-small">Submit</a>
                                 <p class="x-small text-lighter m-b-0 m-t-5 didnt-receive">Didn't receive the code? <a href="#" class="dark-link x-small heavier"><i class="fa fa-refresh" aria-hidden="true"></i> Resend SMS</a></p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="details-confirm mobile-hide">
                        <h6 class="m-t-40 m-b-0 text-medium">Give your details below
                        </h6>
                        <div class="formFields gap-separator row">
                           <div class="col-sm-4">
                              <div class="form-group m-b-0">
                                 <label class="m-b-0 text-lighter float-label required" for="contact_name_verify">Name</label>
                                 <input type="text" class="form-control fnb-input float-input" id="contact_name_verify">
                              </div>
                           </div>
                           <div class="col-sm-4">
                              <div class="form-group">
                                 <label class="m-b-0 text-lighter float-label required" for="contact_email_verify">Email</label>
                                 <input type="email" class="form-control fnb-input float-input" id="contact_email_verify">
                              </div>
                           </div>
                           <div class="col-sm-4">
                              <div class="form-group m-b-0">
                                 <label class="m-b-0 text-lighter float-label required" for="contact_number_verify">Phone</label>
                                 <input type="tel" class="form-control fnb-input float-input" id="contact_number_verify">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="text-center">
                        <button class="btn fnb-btn primary-btn full border-btn success-toggle">Submit</button>
                     </div>
                  </div>
                  <!-- Verify Details End -->
               </div>
               <!-- Thank you -->
               <div class="thankyou-msg success-stuff hidden">
                  <div class="enquiry-success contact-success">
                     <div class="flex-row align-top">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                        <div>
                           <h6 class="enquiry-success__text m-t-0 thanks-text">Thank you for showing your interest!</h6>
                           <p class="enquiry-success__sub-text">
                              Email &amp; SMS with the contact details of <a href="#" class="text-darker text-decor heavier">Mystical The Meat and Fish Store</a> have been sent to you. You can now contact the owner directly.
                           </p>
                           <p class="enquiry-success__sub-text m-b-0 owner-detail">
                              We have also shared your contact details with the owner <i class="fa fa-user-circle text-color"></i> <span class="bolder text-darker">Sameer Rawool</span>
                           </p>
                        </div>
                     </div>
                  </div>
                  <div class="vendor-contact-details">
                     <h6 class="text-color m-b-5">Mystical The Meat and Fish Store Details</h6>
                     <div class="row">
                        <div class="col-sm-6">
                           <label class="m-t-15 vendor-label">Email</label>
                           <div class="flex-row flex-wrap">
                              <p class="m-b-0">
                                 <a href="#" class="text-darker m-r-15">contactus@mystical.com</a>
                              </p>
                              <div class="flex-row">
                                 <span class="fnb-icons verified-icon scale-down"></span>
                                 <span class="text-color">Verified</span>
                              </div>
                           </div>
                           <div class="flex-row flex-wrap">
                              <p class="m-b-0">
                                 <a href="#" class="text-darker m-r-15">contactus@mystical.com</a>
                              </p>
                              <div class="flex-row">
                                 <span class="fnb-icons verified-icon scale-down"></span>
                                 <span class="text-color">Verified</span>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <label class="m-t-15 vendor-label">Phone</label>
                           <div class="flex-row flex-wrap">
                              <p class="m-b-0">
                                 <a href="#" class="text-darker m-r-20">+91 9876543200</a>
                              </p>
                              <div class="flex-row">
                                 <span class="fnb-icons verified-icon scale-down"></span>
                                 <span class="text-color">Verified</span>
                              </div>
                           </div>
                           <div class="flex-row flex-wrap">
                              <p class="m-b-0">
                                 <a href="#" class="text-darker m-r-20">+91 9876543200</a>
                              </p>
                              <div class="flex-row">
                                 <span class="fa fa-times-circle text-danger m-l-10 m-r-10"></span>
                                 <span class="text-color">Unverified</span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="sub-title m-t-30 m-b-10 flex-row flex-wrap">
                        <span class="fnb-icons exclamation m-r-10"></span>
                        When you contact the listing, don't forget to mention that you found it on F&amp;BCircle
                     </div>
                  </div>
                  <div class="suppliers-data">
                     <p class="element-title heavier text-darker">Don't miss out on these suppliers <img src="img/direction-down-2.png" class="img-responsive direction-down"></p>
                     <div class="seller-info bg-card filter-cards">
                        <div class="seller-info__body filter-cards__body white-space">
                           <div class="flex-row suppliers-title-head">
                              <div class="suppliers-title">
                                 <h3 class="seller-info__title main-heading ellipsis" title="Mystical the meat and fish store">Mystical the meat and fish store</h3>
                                 <div class="location flex-row">
                                    <span class="fnb-icons map-icon"></span>
                                    <p class="location__title m-b-0 text-lighter">Gandhi Nagar, Delhi</p>
                                 </div>
                              </div>
                              <div class="suppliers-stat">
                                 <div class="rating-view flex-row">
                                    <div class="rating">
                                       <div class="bg"></div>
                                       <div class="value" style="width: 80%;"></div>
                                    </div>
                                 </div>
                                 <p class="featured text-secondary m-b-0">
                                    <i class="flex-row featured__title">
                                    <i class="fa fa-flag featured__icon p-r-10" aria-hidden="true"></i>
                                    Featured
                                    </i>
                                 </p>
                              </div>
                           </div>
                           <div class="m-t-15 cat-holder flex-row">
                              <div class="core-cat">
                                 <p class="text-lighter m-t-0 m-b-0">Core Categories</p>
                                 <ul class="fnb-cat flex-row">
                                    <li><a href="" class="fnb-cat__title">Chicken Retailer</a></li>
                                    <li><a href="" class="fnb-cat__title">Mutton</a></li>
                                    <li><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                    <li><a href="" class="fnb-cat__title">Pork Wholesaler</a></li>
                                    <li class="desk-hide"><a href="" class="fnb-cat__title">Egg</a></li>
                                    <li class="desk-hide"><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                    <li class="cat-more more-show"><a href="" class="text-darker">+5 more</a></li>
                                 </ul>
                              </div>
                              <div class="get-details">
                                 <button class="btn fnb-btn outline full border-btn fullwidth">Get Details <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="seller-info bg-card filter-cards">
                        <div class="seller-info__body filter-cards__body white-space">
                           <div class="flex-row suppliers-title-head">
                              <div class="suppliers-title">
                                 <h3 class="seller-info__title main-heading ellipsis" title="CH Exports and imports private limited">CH Exports and imports private limited</h3>
                                 <div class="location flex-row">
                                    <span class="fnb-icons map-icon"></span>
                                    <p class="location__title m-b-0 text-lighter">Chennai, Tamil Nadu</p>
                                 </div>
                              </div>
                              <div class="suppliers-stat">
                                 <div class="rating-view flex-row">
                                    <div class="rating">
                                       <div class="bg"></div>
                                       <div class="value" style="width: 100%;"></div>
                                    </div>
                                 </div>
                                 <p class="featured text-secondary m-b-0">
                                    <i class="flex-row featured__title">
                                    <i class="fa fa-flag featured__icon p-r-10" aria-hidden="true"></i>
                                    Featured
                                    </i>
                                 </p>
                              </div>
                           </div>
                           <div class="m-t-15 cat-holder flex-row">
                              <div class="core-cat">
                                 <p class="text-lighter m-t-0 m-b-0">Core Categories</p>
                                 <ul class="fnb-cat flex-row">
                                    <li><a href="" class="fnb-cat__title">Chicken Retailer</a></li>
                                    <li><a href="" class="fnb-cat__title">Mutton</a></li>
                                    <li><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                    <li><a href="" class="fnb-cat__title">Pork Wholesaler</a></li>
                                    <li class="desk-hide"><a href="" class="fnb-cat__title">Egg</a></li>
                                    <li class="desk-hide"><a href="" class="fnb-cat__title">Meat Retailer</a></li>
                                    <li class="cat-more more-show"><a href="" class="text-darker">+5 more</a></li>
                                 </ul>
                              </div>
                              <div class="get-details">
                                 <button class="btn fnb-btn outline full border-btn fullwidth">Get Details <i class="fa fa-arrow-right p-l-5" aria-hidden="true"></i></button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <p class="small text-lighter m-t-20 m-b-0">
                        Disclaimer: F&amp;BCircle is only an intermediary platform between the business owners and seekers and hence shall neither be responsible nor liable to mediate or resolve any disputes or disagreements between the business owners and seekers.
                     </p>
                  </div>
               </div>
               <!-- Thank you End -->
            </div>
         </div>
      </div>
   </div>
   <!-- Contact Modal End -->
</div>
@endsection
