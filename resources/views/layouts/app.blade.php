<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="/img/logo-fnb.png" />
    <title>@yield('title')</title>
    @yield('openGraph')
    @yield('meta') 
    <!-- Google font cdn -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
    <!-- Font awesome cdn -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}">
    <!-- Magnify css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/magnify.css') }}">
    <!-- Internationalization CSS -->
    <link rel="stylesheet" href="{{ asset('/bower_components/intl-tel-input/build/css/intlTelInput.css') }}">
    <!-- Main styles -->
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
    @yield('css')

    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "WebSite",
        "name": "{{env('APP_NAME')}}",
        "url": "{{env('APP_URL')}}"
    }
    </script>
</head>

 
<body class="nav-md overflow-hidden">
 
    <div class="page-shifter animate-row">
 
    <!-- header -->

    @include('includes.header')
    
    <!-- header ends -->


    <!-- content -->
    @yield('content')

 
    <!-- Footer -->
    @include('includes.footer')
    <!-- Footer ends -->

    </div>
    <!-- Modals -->
    <!-- Email / Social Signin Popup -->
    @if(Auth::guest())
        @include('modals.login')
    @endif

    <!-- requirement popup signup -->
    @if(!Auth::guest() && !Auth::user()->has_required_fields_filled)
        @include('modals.user_requirement')
    @endif

    <!-- Email Verification popup -->
    @include('modals.verification.email-modal')

    <!-- Mobile Verification popup -->
    @include('modals.verification.mobile-modal')

    </div>
    <!-- page shifter end-->
    <!-- banner ends -->




    <div class="site-overlay"></div>
    
    <!-- jquery -->
    <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script> -->
    <script type="text/javascript" src="{{ asset('/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- BS Script -->
    <script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>

    
    <!-- Scroll plugin check not required for admin dashboard -->

    @php
    $router = app()->make('router');
    $uriPath = $router->getCurrentRoute()->getPrefix(); 
    $route = explode('/', $uriPath);
    $tableReference = $route[0];
    @endphp

    @if($tableReference != 'admin-dashboard')
        <!-- Smooth Mouse scroll -->
        <script type="text/javascript" src="{{ asset('/js/jquery.easeScroll.min.js') }}"></script>
    @endif

    
    <!-- BS lightbox -->
    <script type="text/javascript" src="{{ asset('bower_components/ekko-lightbox/dist/ekko-lightbox.min.js') }}"></script>
    <!-- Magnify popup plugin -->
    <script type="text/javascript" src="{{ asset('/js/magnify.min.js') }}"></script>
    <!-- Read more -->
    <script type="text/javascript" src="{{ asset('/js/readmore.min.js') }}"></script>
    <!-- Parsley text validation -->
    <script type="text/javascript" src="{{ asset('/js/parsley.min.js') }}" ></script>
    <!-- Internationalization plugin -->
    <script type="text/javascript" src="{{ asset('/bower_components/intl-tel-input/build/js/intlTelInput.min.js') }}"></script>
    <!-- custom script -->
    <script type="text/javascript" src="{{ asset('/js/custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/verification.js') }}"></script>

    @if(!Auth::guest() && !Auth::user()->has_required_fields_filled)
        <!-- This is defined here as the "require" modal is included to this blade -->
        <script type="text/javascript" src="{{ asset('/bower_components/tether/src/js/utils.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/contact_flag_initialization.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#requirement_form input[name='contact']").intlTelInput();
                $("#require-modal").modal('show');
            });
        </script>
    @endif

    @yield('js')
</body>

</html>