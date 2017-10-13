<?php

namespace App\Http\Controllers;

use App\Listing;
use App\Update;
use Auth;
use Carbon\Carbon;
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
        $update->id = Carbon::now()->timestamp;
        $id     = $update->uploadImage($request->file('file'),false);
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
            'photos'      => 'nullable',
            'postID'      => 'nullable|integer'
        ]);

        if ($request->type == 'listing') {
        	$config = config('tempconfig.table-details.listing');
        	$object = Listing::where($config['id'], $request->id)->firstOrFail();
        }else{
        	return response()->json(['status' => '400', 'message' => 'Invalid type']);
        }
        // dd($request->photos);
        // if (isset($request->photos)) {
        //     $images = explode(',', $request->photos);
        // } else {
        //     $images = [];
        // }
        // dd($images);
        if(isset($request->postID)){
            $update =  Update::find($request->postID);
        }else {
            $update =  new Update;
            $update->posted_by = Auth::user()->id;
        }
        $update->last_updated_by = Auth::user()->id;
        $update->title = $request->title;
        $update->contents = $request->description;
        $update->photos = ($request->photos == '')? '[]':json_encode($request->photos);
        $update->status = 1;
        $update->save();
        // dd($update->id);
        $object->updates()->save($update);
        $object->updated_at = Carbon::now();
        $object->last_updated_by = Auth::user()->id;
        $object->save();
        $update->remapImages(json_decode($update->photos));

        return response()->json(['status' => '200', 'message' => '']);
    }

    public function getUpdates(Request $request){
        $this->validate($request, [
            "type"=>'required',
            "id"=>'required',
            "order"=>'nullable|boolean',
            "offset" => 'required|integer',
        ]);
        if ($request->type == 'listing') {
            $config = config('tempconfig.table-details.listing');
            $object = Listing::where($config['id'], $request->id)->firstOrFail();
        }else{
            return response()->json(['status' => '400', 'message' => 'Invalid type']);
        }
        if($request->order == '1') $order = 'asc';
        else $order = 'desc';
        $updates = $object->updates()->orderBy('updated_at',$order)->skip($request->offset)->take(config('tempconfig.default-updates-number'))->get();
        $update_json = [];
        foreach ($updates as $update) {
            $update_json[] = [
                'id' => $update->id,
                'title' => e($update->title),
                'contents' => nl2br(e($update->contents)),
                'images'=> $update->getImages(),
                'updated'=>$update->updated_at->format('F j, Y'),
            ];           
        }
        return response()->json(['status'=>'200', 'message'=>'OK', 'data'=>['updates' => $update_json]]);
    }

    public function getPost(Request $request){
        $this->validate($request, [
            "type"=>'required',
            "id"=>'required',
            'postID' => 'required|integer',
        ]);
        if ($request->type == 'listing') {
            $config = config('tempconfig.table-details.listing');
            $object = Listing::where($config['id'], $request->id)->firstOrFail();
        }else{
            return response()->json(['status' => '400', 'message' => 'Invalid type']);
        }
        $post = $object->updates()->where('id',$request->postID)->firstOrFail();
        return response()->json(['status'=>'200', 'message'=>'OK', 'data'=>[
            'id'=>$post->id,
            'title' => $post->title,
            'content' => $post->contents,
            'images'=> $post->getImages(),
        ]]);
    }

}
