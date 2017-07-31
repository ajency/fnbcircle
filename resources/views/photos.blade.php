@extends('photos')

@section('photos')

<div class="photos tab-pane fade" id="photos">
    <h5 class="no-m-t">Photos &amp; Documents</h5>
    <div class="m-t-30 add-container c-gap">
        <label>Add some images for your listing (optional)</label>
        <div class="text-lighter">
            Tip: Photos are the most important feature of your listing. Listing with images in general get 5x more responses.
        </div>
        <img src="img/main-pic-down.png" class="m-t-15 desk-hide">
        <div class="image-grid">
            <div class="image-grid__cols main-image">
                <input type="file" class="dropify" data-height="100" />
                <img src="img/main_photo.png" class="m-t-10 m-l-10 mobile-hide">
            </div>
            <div class="image-grid__cols">
                <input type="file" class="dropify" data-height="100" />
            </div>
            <div class="image-grid__cols">
                <input type="file" class="dropify" data-height="100" />
            </div>
            <div class="image-grid__cols">
                <input type="file" class="dropify" data-height="100" />
            </div>
            <div class="image-grid__cols">
                <input type="file" class="dropify" data-height="100" />
            </div>
        </div>
    </div>
    <div class="m-t-50 upload-container c-gap">
        <label>Do you have some files which you would like to upload for the listing?</label>
        <div class="m-t-20">
            <input type="file" name="file-2[]" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple />
            <label for="file-2" class="btn fnb-btn outline full border-btn"><i class="fa fa-upload" aria-hidden="true"></i> <span>Upload File</span></label>
        </div>
        <div class="m-t-10 text-lighter">
            Only .jpg, .jpeg &amp; .pdf with a maximum size of 1mb is allowed
        </div>
    </div>
</div>

@endsection