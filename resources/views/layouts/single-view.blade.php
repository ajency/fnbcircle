@extends('layouts.app')
@section('content')
<!-- content -->
@section('seo')
	@yield('openGraph')
@endsection

  <div class="single-view-head">
    @yield('single-view-data')
  </div>
 
@endsection
