@extends('layouts.add-listing')

@section('js')
    @parent
    <script type="text/javascript" src="/js/add-listing-updates.js"></script>
@endsection

@section('meta')
  <meta property="photo-upload-url" content="{{action('UpdatesController@uploadPhotos')}}">
  <meta property="post-upload-url" content="{{action('UpdatesController@postUpdate')}}">
  <meta property="max-file-upload" content="{{config('tempconfig.add-listing-updates-max-photos')}}">

@endsection

@section('form-data')
<div>
	<label>TITLE</label>
	<input type="text" name="title" data-parsley-required>
</div>

<div>
	<label>description</label>
	<textarea name="description" class="allow-newline" data-parsley-required></textarea>
</div>
<div class="imageUpload">
<div class="image-grid__cols" >
	 <input type="file" class="list-image" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="jpg png" />
	 <input type="hidden" name="image-id" value="">
</div>
</div>
<button type="button" id="post-update-button">Post Update</button>

<pre>
@php $updates = $listing->updates()->orderBy('updated_at',"desc")->get();
echo json_encode($updates);
 @endphp
</pre>

@endsection