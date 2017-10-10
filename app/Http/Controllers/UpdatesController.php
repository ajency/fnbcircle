<?php

namespace App\Http\Controllers;

use App\Listing;
use App\Update;
use Auth;
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
        	$object = Listing::where($config['id'], $request->id)->firstOrFail();
        }else{
        	return response()->json(['status' => '400', 'message' => 'Invalid type']);
        }

        
        $update =  new Update;
        $update->posted_by = Auth::user()->id;
        $update->last_updated_by = Auth::user()->id;
        $update->title = $request->title;
        $update->contents = $request->description;
        $update->photos = ($request->photos == '')? null:$request->photos;
        $update->status = 1;

        $object->updates()->save($update);

        return response()->json(['status' => '200', 'message' => '']);
    }

}
