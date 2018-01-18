
@extends('layouts.add-listing')
@section('css')
    @parent
    <!-- Datatables -->
    <link href="{{ asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection
@section('js')
    @parent
    <script type="text/javascript" src="/js/underscore-min.js" ></script>
    <!-- Datatables -->
    <script src="{{ asset('/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="/js/listing-summary.js"></script>
@endsection

@section('meta')
  <meta property="listing-enquiry" content="{{action('AdminEnquiryController@displaylistingEnquiries')}}">
  <meta property="listing-stats" content="{{action('ListingController@getListingStatsByDate')}}">
  
@endsection


@section('form-data')

<div class="alert fnb-alert alert-success alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <div class="flex-row">
        <i class="fa fa-check-circle" aria-hidden="true"></i>
        <span class="message"></span>
    </div>
</div>

<div class="business-info  post-update tab-pane fade in active business-leads" id="summary">
    <h5 class="no-m-t fly-out-heading-size main-heading white m-t-0 margin-btm flex-row space-between preview-detach post-up-head align-top">
    <div class="flex-row space-between">
        <img src="/img/post-update.png" class="img-responsive mobile-hide m-r-15" width="60">
        <div>Make your business stand out on FnB Circle
            <span class="dis-block xxx-small lighter m-t-10 post-caption">Post special events, promotions and more on your listings.</span>
        </div>
        
    </div>
    </h5>
    

    <!-- updates section -->
     <div class="update-sec m-t-20 nav-starter" id="updates">
        @if(isset($updates) and !empty($updates))
        <div class="update-sec__body update-space">

            <p class="m-t-20 m-b-5 updateTitle heavier">{{$updates->title}}</p>
            <p class="update-sec__caption grey-darker">
                {!! nl2br(e($updates->contents)) !!}
            </p>
            <ul class="flex-row update-img flex-wrap post-gallery align-top">
            @php $photos = $updates->getImages(); @endphp
                @foreach($photos as $photo)
                <li>
                    <a href="{{$photo[config('tempconfig.listing-photo-full')]}}">
                        <img src="{{$photo[config('tempconfig.listing-photo-thumb')]}}" alt="" width="80" class="no-height">
                        <div class="updates-img-col" style="background-image: url('{{$photo[config('tempconfig.listing-photo-thumb')]}}');">
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
            <p class="text-lighter m-b-0 postDate">Posted {{$updates->created_at->diffForHumans()}}</p>
        </div>

        <div class="m-t-30 c-gap">
           <div class="review-note flex-row space-between">
                <div class="review-note__text flex-row">
                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                    <p class="review-note__title">Recently updated listings usually get more leads.<br> Go ahead and post an update</p>
                </div>
               <div class="review-note__submit">
                     <a href="/listing/{{$listing->reference}}/edit/post-an-update?step=true"  class="btn primary-btn sub-title">Post an update</a>
               </div>
           </div>
        </div>
        @else
            <!-- if no posts -->
            
            <div class="update-sec__body update-space">

                <h6 class="sub-title update-sec__heading m-t-15 heavier text-center no-post-title">
                    You have not posted any updates as of now! <br> Recently updated listings usually get more leads, so go ahead and post an update.
                </h6>
                <p class="m-b-0 m-t-20 text-center">
                    <a href="/listing/{{$listing->reference}}/edit/post-an-update?step=true" class="btn fnb-btn primary-btn border-btn posUpdate full ">Post an Update</a>
                </p>
            </div>
            
        @endif
    </div>
    <!-- updates section ends -->

    <div class="row">
        <div class="col-md-6">
            <h4>Listing Stats</h4>
        </div>
        <div class="col-md-3">
            Filter your stats for a particular time period 
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control fnb-input requestDate default-size" placeholder="Request Date" id="submissionDate">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <h5>Views</h5>
            <h3>{{$listing->views_count}}</h3>
            By default displays the number of views in the last 30 days
        </div>
        <div class="col-md-3">
            <h5>Contact Requests</h5>
            <h3 id="contact-count">{{$stats['contact']}}</h3>
            Number of requests sent for the contact details of the listing <a href="/listing/{{$listing->reference}}/edit/manage-leads?step=true&type=contact-request">View</a>
        </div>
        <div class="col-md-3">
            <h5>Direct Enquiries</h5>
            <h3 id="direct-count">{{$stats['direct']}}</h3>
            Number of direct enquiries sent to the listing <a href="/listing/{{$listing->reference}}/edit/manage-leads?step=true&type=direct">View</a>
        </div>
        <div class="col-md-3">
            <h5>Indirect Enquiries</h5>
            <h3 id="shared-count">{{$stats['shared']}}</h3>
            number of indirect enquiries sent to this listing based on category and area the listing belongs to <a href="/listing/{{$listing->reference}}/edit/manage-leads?step=true&type=shared">View</a>
        </div>
    </div>


    <div class="m-t-50 relative leads-tab-section">

    <table id="listing-leads" class="table table-striped listing-lead" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="no-sort" style="min-width: 110px;">Type</th>
                <th class="width-control" style="min-width: 80px;width: 130px !important;">Name</th>
                <th class="width-control" style="min-width: 80px;width: 130px !important;">Email</th>
                <th class="width-control" style="min-width: 80px;width: 130px !important;">Phone</th>
                <th style="min-width: 160px">What describes you the best?</th>
                <th style="min-width: 30px;">Action</th>
            </tr>
            
        </thead>
        <tbody>
           
        </tbody>
    </table> 




    </div>


    

</div>


<!-- archive confirmation modal -->

<div class="modal fnb-modal confirm-box fade modal-center" id="enquiryarchive" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="text-medium m-t-0 bolder">Confirm</h5>
          </div>
          <div class="modal-body text-center">
              <div class="listing-message">
                  <h4 class="element-title text-medium text-left text-color">Are you sure you want to archive this enquiry?</h4>
              </div>  
              <div class="confirm-actions text-right">
                  <a href="#" class="archive-enquiry-confirmed" > <button class="btn fnb-btn text-primary border-btn no-border"  data-dismiss="modal">Archive</button></a>
                    <button class="btn fnb-btn outline cancel-modal border-btn no-border" data-dismiss="modal" id="cancelenquiryarchive">Cancel</button>
              </div>
          </div>
          <!-- <div class="modal-footer">
              <button class="btn fnb-btn outline cancel-modal border-btn" data-dismiss="modal">Close</button>
          </div> -->
      </div>
  </div>
</div>





@endsection