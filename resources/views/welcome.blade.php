@extends('layouts.app')

@section('js')
@parent
    <!-- <script type="text/javascript" src="/js/verification.js"></script> -->
    <!-- <script type="text/javascript">
        $(document).ready(function() {
            verifyContactDetail(true);
        });
    </script> -->
@endsection

@section('content')
    <!-- Banner -->
    <div class="fnb-banner home-banner">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home-text text-center">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- @if(Auth::guest())@else
                        <h1 class="home-text__title text-medium">Welcome {{Auth::user()->name}}</h1>@endif -->
                        <h1 class="home-text__title text-medium">What is F&amp;BCircle?</h1>
                        <p class="home-text__caption element-title lighter">We provide information related to businesses, jobs, news in the F&amp;B industry.<br> Find suppliers, jobs, read news and a lot more.</p>
                    </div>
                     <div class="search-section home-search">
                        <div class="search-boxes type-search flex-row mobile-fake-search desk-hide">
                            <i class="fa fa-search p-r-5 icons" aria-hidden="true"></i>
                            <input type="text" class="form-control fnb-input" placeholder="Start typing to search..." readonly>
                        </div>
                         <div class="pos-fixed fly-out fixed-bg searchArea">
                            <div class="mobile-back desk-hide mobile-flex">
                                <div class="left mobile-flex">
                                    <i class="fa fa-arrow-left text-primary back-icon" aria-hidden="true"></i>
                                    <p class="element-title heavier m-b-0">Search By</p>
                                </div>
                                <div class="right">
                                    <a href="#" class="heavier sub-title primary-link">Clear All</a>
                                </div>
                            </div>
                            <div class="fly-out__content">
                                <div class="search-section__cols flex-row">
                                    <div class="city search-boxes flex-row">
                                        <i class="fa fa-map-marker p-r-5 icons" aria-hidden="true"></i>
                                        <select class="form-control fnb-select p-l-20">
                                            <option>All</option>
                                            <option>Pune</option>
                                            <option selected="">Delhi</option>
                                            <option>Mumbai</option>
                                            <option>Goa</option>
                                        </select>
                                    </div>
                                    <div class="search-boxes type-search flex-row">
                                        <i class="fa fa-search p-r-5 icons" aria-hidden="true"></i>
                                        <input type="text" class="form-control fnb-input" placeholder="Start typing to search...">
                                    </div>
                                    <div class="search-btn flex-row hidden">
                                        <button class="btn fnb-btn primary-btn full search">search</button>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="search-results text-center m-l-5">
                            <p class="sub-title text-lighter lighter">You have more than <b>7,203</b> listing's to choose from!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
            <!-- category listing -->
                <div class="listed-cat">
                    <h3 class="lighter text-center listed-cat__title">Categories Listed on F&amp;B Circle</h3>
                    <ul class="flex-row cat-types">
                        <li>
                            <a href="">
                                <span class="icon-theme cereals"></span>
                                <p class="cat-types__text sub-title text-medium">Cereals &amp; Food Grains</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span class="icon-theme meat"></span>
                                <p class="cat-types__text sub-title text-medium">Meat &amp; Poultry</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span class="icon-theme milk"></span>
                                <p class="cat-types__text sub-title text-medium">Milk &amp; dairy products</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span class="icon-theme marine"></span>
                                <p class="cat-types__text sub-title text-medium">Marine Food Supplies</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span class="icon-theme juices"></span>
                                <p class="cat-types__text sub-title text-medium">Juices, Soups &amp; Soft drinks</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span class="icon-theme spices"></span>
                                <p class="cat-types__text sub-title text-medium">Cooking spices &amp; masalas</p>
                            </a>
                        </li>
                    </ul>
                    <p class="elment-title text-center m-t-40"><a href="" class="view-all-cat">View All Categories</a></p>
                </div>
                <!-- Categories listing ends -->
            </div>
        </div>
    </div>

    <!-- create listing -->
    <div class="create-listing">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row create-list-group">
                        <div class="col-xs-12 col-sm-8">
                            <p class="create-listing__title text-darker lighter">
                                Join <b>over 800+</b> people already using F&amp;B Circle.<br>
                                Post your listing on F&amp;BCircle <b>Free!</b>
                            </p>
                        </div>
                        <div class="col-xs-12 col-sm-4 createlist-col">
                            <button class="btn fnb-btn alternate full createList">Create Listing</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection