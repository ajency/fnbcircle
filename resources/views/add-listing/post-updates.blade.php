@extends('layouts.add-listing')

@section('js')
    @parent
    <script type="text/javascript" src="/js/add-listing-updates.js"></script>
@endsection

@section('meta')
  <meta property="photo-upload-url" content="{{action('UpdatesController@uploadPhotos')}}">
  <meta property="post-upload-url" content="{{action('UpdatesController@postUpdate')}}">
  <meta property="max-file-upload" content="{{config('tempconfig.add-listing-updates-max-photos')}}">
  <meta property="get-posts-url" content="{{action('UpdatesController@getUpdates')}}">

@endsection

@section('form-data')


<div class="business-info  post-update tab-pane fade in active" id="post-update">
    <h5 class="no-m-t fly-out-heading-size main-heading white m-t-0 margin-btm flex-row space-between"><div>Post an update 
    	<span class="dis-block xxx-small lighter m-t-10 post-caption">Post special events, promotions and more on your lsiting.</span>
    	</div>
    	<img src="/img/post-update.png" class="img-responsive mobile-hide" width="60">
    </h5>
	
	<div class="m-t-50 flex-row imp-update">
		<i class="fa fa-info-circle p-r-10" aria-hidden="true"></i>
        <p class="m-b-0 text-color"> @if(!empty($post)) Your last update was on {{$post->updated_at->format('F j, Y')}}. @endif Recently updated listings usually get more leads, so go ahead and post an update.</p>
    </div>

    <div class="m-t-30 card post-card update-card">
    	
    </div>

	<div class="sidebar-updates page-sidebar postUpdates">
        <div class="page-sidebar__header flex-row space-between">
            <div class="backLink flex-row">
                <!-- <a href="" class="primary-link p-r-10 element-title article-back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> -->
                <h5 class="bolder update-title">My Updates</h5>
            </div>
           <div class="sort flex-row">
               <p class="m-b-0 text-lighter default-size">Sort</p>
               <select name="update-sort" id="" class="fnb-select">
                   <option value="0">Recent</option>
                   <option value="1">Older</option>
               </select>
           </div>
        </div>
        <div class="page-sidebar__body update-display-section">
            
        </div>
        <div class="page-sidebar__footer"></div>
    </div>

	

</div>






<!-- <div>
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
</pre> -->

@endsection