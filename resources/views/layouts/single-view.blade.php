@extends('layouts.app')
@section('content')
<!-- content -->
  <div class="single-view-head">
    @yield('single-view-data')
  </div>
<!-- failure message-->
<div class="alert fnb-alert @if ($errors->any()) server-error @else hidden @endif alert-failure alert-dismissible fade in " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <div class="flex-row">
        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
         Oh snap! Some error occurred. Please check all the details and proceed.
    </div>

    <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
</div>
@endsection
