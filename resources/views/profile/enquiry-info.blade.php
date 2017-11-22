@extends('layouts.profile')

@section('js')
    @parent
    <script type="text/javascript" src="/js/my-activities.js"></script>
@endsection

@section('meta')
    @parent
    <meta property="get-activities-url" content="{{action('ProfileController@getUserActivity')}}">
@endsection

@section('main-content')
 <div class="enquiry-info tab-pane fade in active" id="enquiry-info">
                                    <h3 class="profile-stats__title text-medium sectionTitle mobile-hide">
                                        @if($self) My @else {{$data['name']}}'s @endif Activity
                                    </h3>
                                    @if(!$self and !$admin)
                                    <h6 class="public-enquiry-title text-color">Enquiries made to you by {{$data['name']}}</h6>
                                    @endif
                                    {!!$details!!}
                                    <ul class="nav activityTab" role="tablist">
                                        <!-- <li class="active" role="presentation">
                                            <a aria-controls="recent-activity" data-toggle="tab" href="#recent-activity" role="tab">
                                                Recent Activity <span class="xx-small text-medium text-lighter">(<i class="fa fa-clock-o" aria-hidden="true"></i> Last 7 days)</span>
                                            </a>
                                        </li> -->
                                        <li role="presentation" class="active">
                                            <a aria-controls="all-activity" data-toggle="tab" href="#all-activity" role="tab">
                                                All time activity
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="recent-activity" role="tabpanel">
                                            <div id="load-more-container" class="text-center"><button type="button" id="load-more-action" class="btn fnb-btn primary-btn border-btn posUpdate full">View More</button></div>
                                            <!-- <h6 class="enquiries-made title">
                                                <i aria-hidden="true" class="fa fa-comments">
                                                </i>
                                                Enquiries made to you by Amit Adav
                                            </h6> -->
                                            <!-- <p class="text-color default-size m-b-0 text-right lastUpdated heavier"></p> -->

                                            <!-- <p class="default-size mainDate"><span><i class="fa fa-calendar p-r-5" aria-hidden="true"></i> 03 July 2017</span></p>

                                            <div class="enquire-container">
                                                <h6 class="enquiry-made-by text-medium">
                                                    You made a
                                                    <label class="fnb-label">
                                                        Direct Enquiry
                                                    </label>
                                                    to
                                                    <a class=" text-decor" href="#">
                                                        Mystical the meat and fish store
                                                    </a>
                                                </h6>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <dl class="flex-row flex-wrap enquiriesRow">
                                                            <div class="enquiriesRow__cols">
                                                                <dt>
                                                                    Name
                                                                </dt>
                                                                <dd>
                                                                    valenie Lourenco
                                                                </dd>
                                                            </div>
                                                            <div class="enquiriesRow__cols">
                                                                <dt>
                                                                    Email address
                                                                </dt>
                                                                <dd>
                                                                    valenie@gmail.com
                                                                    <span class="fnb-icons verified-icon mini">
                                                                    </span>
                                                                </dd>
                                                            </div>

                                                            <div class="enquiriesRow__cols">
                                                                <dt>
                                                                    Phone number
                                                                </dt>
                                                                <dd>
                                                                    9800789877
                                                                    <span class="fnb-icons verified-icon mini">
                                                                    </span>
                                                                </dd>
                                                            </div>
                                                            <div class="enquiriesRow__cols">
                                                                <dt>
                                                                    What describe you best?
                                                                </dt>
                                                                <dd>
                                                                    <p class="describe-points"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Hospitality Business Owner</p>
                                                                    <p class="describe-points"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Others</p>

                                                                </dd>
                                                            </div>
                                                            <div class="enquiriesRow__cols last-col">
                                                                 <dt>
                                                                    Give the supplier/service provider some details of your requirement
                                                                </dt>
                                                                <dd>
                                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius quis commodi aliquid reprehenderit beatae ad magni in incidunt, recusandae obcaecati dolore illum assumenda consequuntur, nobis, rerum voluptatum tempora maiores blanditiis!
                                                                </dd>
                                                            </div>
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="enquire-container">
                                                <h6 class="enquiry-made-by text-medium">
                                                    You made a
                                                    <label class="fnb-label">
                                                        Shared Enquiry
                                                    </label>
                                                    to
                                                    <a class=" text-decor" href="#">
                                                        XYZ Enterprises
                                                    </a>
                                                </h6>
                                                <div class="row">
                                                    <div class="col-sm-5 b-r">
                                                        <dl class="flex-row flex-wrap enquiriesRow withCat">
                                                            <div class="enquiriesRow__cols">
                                                                <dt>
                                                                    Name
                                                                </dt>
                                                                <dd>
                                                                    valenie Lourenco
                                                                </dd>
                                                            </div>
                                                            <div class="enquiriesRow__cols">
                                                                <dt>
                                                                    Email address
                                                                </dt>
                                                                <dd>
                                                                    valenie@gmail.com
                                                                    <span class="fnb-icons verified-icon mini">
                                                                    </span>
                                                                </dd>
                                                            </div>

                                                            <div class="enquiriesRow__cols">
                                                                <dt>
                                                                    Phone number
                                                                </dt>
                                                                <dd>
                                                                    9800789877
                                                                    <span class="fnb-icons verified-icon mini">
                                                                    </span>
                                                                </dd>
                                                            </div>
                                                            <div class="enquiriesRow__cols">
                                                                <dt>
                                                                    What describe you best?
                                                                </dt>
                                                                <dd>
                                                                    <p class="describe-points"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Hospitality Business Owner</p>
                                                                    <p class="describe-points"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Others</p>

                                                                </dd>
                                                            </div>

                                                        </dl>
                                                    </div>
                                                    <div class="col-sm-7">
                                                        <dl class="enquiriesRow">
                                                            <div class="enquiriesRow__cols">
                                                                <dt>
                                                                    Categories
                                                                </dt>
                                                                <dd>
                                                                    <ul class="fnb-cat flex-row">
                                                                        <li>
                                                                            <a class="fnb-cat__title" href="">
                                                                                Chicken
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="fnb-cat__title" href="">
                                                                                Mutton
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="fnb-cat__title" href="">
                                                                                Beef
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="fnb-cat__title" href="">
                                                                                Fish
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="fnb-cat__title" href="">
                                                                                Egg
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </dd>
                                                            </div>

                                                            <div class="enquiriesRow__cols">
                                                                <dt>
                                                                    Areas
                                                                </dt>
                                                                <dd>
                                                                    <p class="default-size">
                                                                        Delhi -
                                                                        <span class="text-medium">
                                                                            Dwarka, Chandni chawk, Mundka
                                                                        </span>
                                                                    </p>
                                                                </dd>
                                                            </div>

                                                        </dl>
                                                    </div>
                                                    <div class="col-sm-12 m-t-10">
                                                        <div class="enquiriesRow__cols last-col">
                                                             <dt>
                                                                Give the supplier/service provider some details of your requirement
                                                            </dt>
                                                            <dd>
                                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius quis commodi aliquid reprehenderit beatae ad magni in incidunt, recusandae obcaecati dolore illum assumenda consequuntur, nobis, rerum voluptatum tempora maiores blanditiis!
                                                            </dd>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="enquire-container">
                                                <h6 class="enquiry-made-by text-medium">
                                                    You viewed the
                                                    <label class="fnb-label">
                                                        Contact Details
                                                    </label>
                                                    of
                                                    <a class=" text-decor" href="#">
                                                        Kasam Querishi &amp; sons
                                                    </a>
                                                </h6>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <dl class="flex-row flex-wrap enquiriesRow">
                                                            <div class="enquiriesRow__cols">
                                                                <dt>
                                                                    Name
                                                                </dt>
                                                                <dd>
                                                                    valenie Lourenco
                                                                </dd>
                                                            </div>
                                                            <div class="enquiriesRow__cols">
                                                                <dt>
                                                                    Email address
                                                                </dt>
                                                                <dd>
                                                                    valenie@gmail.com
                                                                    <span class="fnb-icons verified-icon mini">
                                                                    </span>
                                                                </dd>
                                                            </div>

                                                            <div class="enquiriesRow__cols">
                                                                <dt>
                                                                    Phone number
                                                                </dt>
                                                                <dd>
                                                                    9800789877
                                                                    <span class="fnb-icons verified-icon mini">
                                                                    </span>
                                                                </dd>
                                                            </div>
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>

                                            <p class="default-size mainDate"><span><i class="fa fa-calendar p-r-5" aria-hidden="true"></i> 02 July 2017</span></p>

                                            <div class="enquire-container">
                                                <h6 class="enquiry-made-by text-medium flex-row space-between">
                                                    <div>
                                                        You posted a
                                                        <label class="fnb-label">
                                                            Business Listing
                                                        </label>
                                                        <a class=" text-decor" href="#">
                                                            VML Suppliers
                                                        </a>
                                                    </div>
                                                    <a class="text-decor primary-link" href="#">
                                                        View Listing
                                                    </a>
                                                </h6>
                                            </div>


                                             <div class="enquire-container">
                                                <h6 class="enquiry-made-by text-medium flex-row space-between">
                                                    <div>
                                                        You posted a
                                                        <label class="fnb-label">
                                                            Job
                                                        </label>
                                                        <a class=" text-decor" href="#">
                                                            Assistant Manager for a Restaurant
                                                        </a>
                                                    </div>
                                                    <a class="text-decor primary-link" href="#">
                                                        View Job
                                                    </a>
                                                </h6>
                                            </div> -->

                                        </div>


                                    </div>
                                    
                                        
                                    
                                </div>
@endsection                                
