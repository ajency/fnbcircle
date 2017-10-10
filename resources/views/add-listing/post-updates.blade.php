@extends('layouts.add-listing')

@section('js')
    @parent
    <script type="text/javascript" src="/js/listing-updates.js"></script>
@endsection

@section('meta')
  <meta property="photo-upload-url" content="{{action('UpdatesController@uploadPhotos')}}">
  <meta property="max-file-upload" content="{{config('tempconfig.add-listing-updates-max-photos')}}">
@endsection

@section('form-data')
<div>
	<label>TITLE</label>
	<input type="text" name="title">
</div>

<div>
	<label>description</label>
	<textarea name="title"></textarea>
</div>
<div>
	<input type="file" name="photo">
</div>

@endsection