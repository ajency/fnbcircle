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


<div class="business-info  post-update tab-pane fade in active" id="post-update">
    <h5 class="no-m-t fly-out-heading-size main-heading white m-t-0 margin-btm flex-row space-between"><div>Post an update 
    	<span class="dis-block xxx-small lighter m-t-10 post-caption">Post special events, promotions and more on your lsiting.</span>
    	</div>
    	<img src="/img/post-update.png" class="img-responsive mobile-hide" width="60">
    </h5>
	
	<div class="m-t-50 flex-row imp-update">
		<i class="fa fa-info-circle p-r-10" aria-hidden="true"></i>
        <p class="m-b-0 text-color">Your last update was on 10th July 2017. Recently updated listings usually get more leads, so go ahead and post an update.</p>
    </div>

    <div class="m-t-30 card">
    	<div class="row">
    		<div class="col-sm-12 form-group">
	    		<div class="flex-row space-between title-flex-row">
	    			<div class="title-icon">
	    				<label class="required">Title</label>
	                	<input type="text" class="form-control fnb-input" placeholder="Give a title to your post" name="title" data-parsley-required>
	                </div>
	                <img src="/img/post-title-icon.png" class="img-responsive">
	    		</div>
    		</div>
    		<div class="col-sm-12 form-group c-gap">
	    		<label class="required">Give us some more details about your listing</label>
	             <textarea type="text" rows="2" class="form-control fnb-textarea no-m-t allow-newline" placeholder="Describe the post here" data-parsley-required></textarea>
    		</div>
    		<div class="col-sm-12">
    			<div class="image-grid imageUpload fileUpload post-uploads">
					<div class="image-grid__cols post-img-col" >
						 <input type="file" class="list-image" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="jpg png" />
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
		                <input type="file" class="doc-uploadd" data-height="100" data-max-file-size="1M" data-allowed-file-extensions="doc docx pdf jpg jpeg xls xlsx png"  />
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
    			<div class="text-right mobile-center post-action">
    				<button class="btn fnb-btn primary-btn full border-btn enquiry-btn post-btn" id="post-update-button" type="button">Post</button>
    			</div>
    		</div>



    	</div>
    </div>

	<div class="sidebar-updates page-sidebar postUpdates">
        <div class="page-sidebar__header flex-row space-between">
            <div class="backLink flex-row">
                <!-- <a href="" class="primary-link p-r-10 element-title article-back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> -->
                <h5 class="bolder update-title">My Updates</h5>
            </div>
           <div class="sort flex-row">
               <p class="m-b-0 text-lighter default-size">Sort</p>
               <select name="" id="" class="fnb-select">
                   <option>Recent</option>
                   <option>Newer</option>
                   <option>Older</option>
               </select>
           </div>
        </div>
        <div class="page-sidebar__body">
            <div class="update-sec sidebar-article">
                <div class="update-sec__body update-space">
                    <h6 class="element-title update-sec__heading m-t-15 bolder">
                        Mystical the meat and fish store recent updates
                    </h6>
                    <p class="update-sec__caption text-lighter">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem obcaecati voluptate debitis, quaerat eum expedita quia veritatis repellendus quod aliquid!
                    </p>
                    <ul class="flex-row update-img">
                        <li><img src="/img/gallery-1.png" alt="" width="80"></li>
                        <li><img src="/img/gallery-1.png" alt="" width="80"></li>
                        <li><img src="/img/gallery-1.png" alt="" width="80"></li>
                    </ul>
                    <p class="m-b-0 posted-date text-secondary flex-row"><i class="fa fa-clock-o sub-title p-r-5" aria-hidden="true"></i> Posted 1 day ago</p>
                </div>
            </div>
            <div class="update-sec sidebar-article">
                <div class="update-sec__body update-space">
                    <h6 class="element-title update-sec__heading m-t-15 bolder">
                        Mystical the meat and fish store recent updates
                    </h6>
                    <p class="update-sec__caption text-lighter">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem obcaecati voluptate debitis, quaerat eum expedita quia veritatis repellendus quod aliquid!
                    </p>
                    <ul class="flex-row update-img">
                        <li><img src="/img/gallery-1.png" alt="" width="80"></li>
                        <li><img src="/img/gallery-1.png" alt="" width="80"></li>
                        <li><img src="/img/gallery-1.png" alt="" width="80"></li>
                    </ul>
                    <p class="m-b-0 posted-date text-secondary flex-row"><i class="fa fa-clock-o sub-title p-r-5" aria-hidden="true"></i> Posted 1 day ago</p>
                </div>
            </div>
			<div class="update-sec sidebar-article">
                <div class="update-sec__body update-space">
                    <h6 class="element-title update-sec__heading m-t-15 bolder">
                        Mystical the meat and fish store recent updates
                    </h6>
                    <p class="update-sec__caption text-lighter">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem obcaecati voluptate debitis, quaerat eum expedita quia veritatis repellendus quod aliquid!
                    </p>
                    <ul class="flex-row update-img">
                        <li><img src="/img/gallery-1.png" alt="" width="80"></li>
                        <li><img src="/img/gallery-1.png" alt="" width="80"></li>
                        <li><img src="/img/gallery-1.png" alt="" width="80"></li>
                    </ul>
                    <p class="m-b-0 posted-date text-secondary flex-row"><i class="fa fa-clock-o sub-title p-r-5" aria-hidden="true"></i> Posted 1 day ago</p>
                </div>
            </div>
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