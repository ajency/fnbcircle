<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*
 *    This class defines the actions required for adding a update to the database and editing it.
 *
 *
 *    @method uploadPhotos  will be invoked to upload any photos for the update
 *        @param file - Image to be uploaded
 *
 *    @method postUpdate will post the update
 *        @param
 *
 */

class UpdatesController extends Controller
{
    public function uploadPhotos(Request $request)
    {
        $this->validate($request, [
            'file' => 'image',
        ]);
        $image  = $request->file('file');
        $update = new Update;
        $id     = $update->uploadImage($request->file('file'));
        if ($id != false) {
            return response()->json(['status' => '200', 'message' => 'Image Uploaded successfully', 'data' => ['id' => $id]]);
        } else {
            return response()->json(['status' => '400', 'message' => 'Image Upload Failed', 'data' => []]);
        }
    }

    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'type'        => 'required|string',
            'id'          => 'required|string',
            'title'       => 'required|string',
            'description' => 'required|string',
            'photos'      => 'nullable|json',
        ]);

        if ($request->type == 'listing') {
        	$config = config('tempconfig.table-details.listing');
        }else{
        	return response()->json(['status' => '400', 'message' => 'Invalid type']);
        }

        
    }

}
