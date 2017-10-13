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


<div class="modal fnb-modal edit-updates fade modal-center" id="edit-updates" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<h6 class="modal-title bolder">Edit Post</h6>
                <button class="close" data-dismiss="modal" aria-label="Close">&#10005;</button>
            </div>
            <div class="modal-body post-card">
                <div class="row">
                    <div class="col-sm-12 form-group">
                      <div class="flex-row space-between title-flex-row">
                        <div class="title-icon">
                          <label class="">Title</label>
                           <input type="text" class="form-control fnb-input" placeholder="" name="title" data-parsley-required>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 form-group c-gap">
                      <label class="">Listing description</label>
                        <textarea type="text" rows="2" name="description" class="form-control fnb-textarea no-m-t allow-newline" placeholder="" data-parsley-required></textarea>
                    </div>
                    <div class="col-sm-12">
                      <div class="image-grid imageUpload fileUpload post-uploads modal-uploads">
	                      <div class="image-grid__cols post-img-col" >
	                         <input type="file" class="list-image img-upload" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="jpg png gif jpeg" />
	                         <input type="hidden" name="image-id" value="">
		                         <div class="image-loader hidden">
		                            <div class="site-loader section-loader">
		                                  <div id="floatingBarsG">
		                                      <div class="blockG" id="rotateG_01"></div>
		                                      <div class="blockG" id="rotateG_02"></div>
		                                      <div class="blockG" id="rotateG_03"></div>
		                                      <div class="blockG" id="rotateG_04"></div>
		                                      <div class="blockG" id="rotateG_05"></div>
		                                      <div class="blockG" id="rotateG_06"></div>
		                                      <div class="blockG" id="rotateG_07"></div>
		                                      <div class="blockG" id="rotateG_08"></div>
		                                  </div>
		                              </div>
		                        </div>
	                      	</div>
	                      	<div class="image-grid__cols addCol">
                            	<a href="#" class="add-uploader secondary-link text-decor">+Add more files</a>
                          	</div>
	                        <div class="image-grid__cols uppend-uploader hidden">
	                            <input type="file" class="list-image doc-upload" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="jpg png gif jpeg" />
	                            <input type="hidden" name="image-id" value="">
	                            <div type="button" class="removeCol"><i class="">✕</i></div>
	                            <div class="image-loader hidden">
	                                <div class="site-loader section-loader">
	                                      <div id="floatingBarsG">
	                                          <div class="blockG" id="rotateG_01"></div>
	                                          <div class="blockG" id="rotateG_02"></div>
	                                          <div class="blockG" id="rotateG_03"></div>
	                                          <div class="blockG" id="rotateG_04"></div>
	                                          <div class="blockG" id="rotateG_05"></div>
	                                          <div class="blockG" id="rotateG_06"></div>
	                                          <div class="blockG" id="rotateG_07"></div>
	                                          <div class="blockG" id="rotateG_08"></div>
	                                      </div>
	                                  </div>
	                            </div>
	                        </div>
                    	</div>
                    </div>
                    <div class="col-sm-12">
                      <div class="text-center post-action m-t-20">
                        <button class="btn fnb-btn primary-btn full border-btn post-btn" id="post-update-button" type="button">Update</button>
                      </div>
                    </div>
                  </div>
            </div>
<!--             <div class="modal-footer">
               <button class="btn fnb-btn outline cancel-modal border-btn" data-dismiss="modal">Close</button>
            </div> -->
        </div>
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