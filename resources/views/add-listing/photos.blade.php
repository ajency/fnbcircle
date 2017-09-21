@extends('layouts.add-listing')

@section('js')
    @parent
    <script type="text/javascript" src="/js/add-listing-photos.js"></script>
@endsection

@section('form-data')


@if(isset($_GET['success']) and $_GET['success']=='true') <div class="alert fnb-alert alert-success alert-dismissible fade in " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    Business Details saved successfully.
</div>
@endif

@section('meta')
  <meta property="photo-upload-url" content="{{action('ListingController@uploadListingPhotos')}}">
  <meta property="file-upload-url" content="{{action('ListingController@uploadListingFiles')}}">
  <meta property="max-file-upload" content="{{config('tempconfig.add-listing-files-maxnumber')}}">
@endsection
<div class="photos tab-pane fade active in" id="business_photos">
    <h5 class="no-m-t main-heading white m-t-0 margin-btm">Photos &amp; Documents</h5>
    <div class="m-t-30 add-container c-gap">
        <label class="label-size">Add some images for your listing (optional)</label>
        <div class="text-lighter">
            Tip: Photos are the most important feature of your listing. Listing with images in general get 5x more responses.
        </div>
        <img src="/img/main-pic-down.png" class="m-t-15 desk-hide">
        <div class="image-grid imageUpload">
        @php
            $images = $listing->getImages();
            $list_photos = json_decode($listing->photos);
            $order = explode(',',$list_photos->order);
            $i=0;
        @endphp
        @foreach($order as $img)
            <div class="image-grid__cols @if($i == 0) main-image @endif">
            <input type="hidden" name="image-id" value="{{$images[$img]['id']}}">
            <input type="file" class="list-image" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="jpg png"  data-default-file="{{$images[$img]['200x150']}}"/>
            <div class="image-loader hidden">This is a Loader</div>
            @if($i == 0) <img src="/img/main_photo.png" class="m-t-10 m-l-10 mobile-hide"> @endif
        </div>
            @php $i++; @endphp
        @endforeach
        @while($i< config('tempconfig.add-listing-photos-number'))
            <div class="image-grid__cols @if($i == 0) main-image @endif">
                <input type="hidden" name="image-id" value="">
                <input type="file" class="list-image" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="jpg png"/>
                <div class="image-loader hidden">This is a Loader</div>
                @if($i == 0) <img src="/img/main_photo.png" class="m-t-10 m-l-10 mobile-hide"> @endif
            </div>
            @php $i++; @endphp
        @endwhile
        </div>
    </div>
    <div class="m-t-10 upload-container c-gap">
        <label class="label-size">Do you have some files which you would like to upload for the listing?</label>
        <div class="text-lighter">
            Only .jpg, .jpeg &amp; .pdf with a maximum size of 1mb is allowed
        </div>
        <!-- <div class="m-t-20">
            <input type="file" name="file-2[]" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple />
            <label for="file-2" class="btn fnb-btn outline full border-btn"><i class="fa fa-upload" aria-hidden="true"></i> <span>Upload File</span></label>
        </div> -->
        <div class="image-grid fileUpload">
        @if($listing==null)
            <div class="image-grid__cols">
                <input type="hidden" name="file-id" value="">
                <input type="file" class="doc-upload" data-height="100" data-max-file-size="1M" data-allowed-file-extensions="doc docx pdf"   title="You cannot upload a file till you write a name"/>
                <input type="text" class="fnb-input title-input doc-name" placeholder="Enter file name">
                <div class="image-loader hidden">This is a Loader</div>
            </div>
        @else
            @php $files = $listing->getFiles(); @endphp
            @foreach($files as $file)
                <div class="image-grid__cols">
                    <input type="hidden" name="file-id" value="{{$file['id']}}">
                    <input type="file" class="doc-upload" data-height="100" data-max-file-size="1M" data-allowed-file-extensions="doc docx pdf"  data-default-file="{{$file['url']}}" />
                    <input type="text" class="fnb-input title-input doc-name" placeholder="Enter file name" disabled value="{{$file['name']}}">
                    <div class="image-loader hidden">This is a Loader</div>
                </div>
            @endforeach
            @if(count($files)==0)
            <div class="image-grid__cols">
                <input type="hidden" name="file-id" value="">
                <input type="file" class="doc-upload" data-height="100" data-max-file-size="1M" data-allowed-file-extensions="doc docx pdf"   title="You cannot upload a file till you write a name"/>
                <input type="text" class="fnb-input title-input doc-name" placeholder="Enter file name">
                <div class="image-loader hidden">This is a Loader</div>
            </div>
            @endif
        @endif
            <div class="image-grid__cols addCol">
                <a href="#" class="add-uploader secondary-link">Add more files</a>
            </div>
            <div class="image-grid__cols uppend-uploader hidden">
                <input type="hidden" name="file-id" value="">
                <input type="file" class="doc-uploadd" data-height="100" data-max-file-size="1M" data-allowed-file-extensions="jpg jpeg pdf"  title="You cannot upload a file till you write a name"/>
                <div type="button" class="removeCol"><i class="">✕</i></div>
                <input type="text" class="fnb-input title-input doc-name" placeholder="Enter file name">
                <div class="image-loader hidden">This is a Loader</div>
            </div>
        </div>
    </div>
</div>

@endsection
