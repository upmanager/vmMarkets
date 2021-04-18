<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ImageUpload;
use Auth;
use App\Util;

class ImageUploadController extends Controller
{
    public function fileCreate(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        //
        if (count(DB::table('settings')->where("param", 'medialib_type')->
                where("vendor", Auth::id())->get()) == 0)
            DB::table('settings')->insert(['param' => 'medialib_type',
                'value' => 'medium', "vendor" => Auth::id(), 'created_at' => new \DateTime(), 'updated_at' => new \DateTime(),]);
        $medialib_type = DB::table('settings')->where('param',"medialib_type")->
                where('vendor', Auth::id())->get()->first()->value;
        //
        if (Auth::user()->role == '1')
            $petani = DB::table('image_uploads')->where('vendor', '0')->get();
        else
            $petani = DB::table('image_uploads')->where('vendor', Auth::id())->get();
        //
        foreach ($petani as &$data) {
            $data->count = count(DB::select("(SELECT foods.id, foods.name FROM foods WHERE foods.imageid=". $data->id . ")
                         UNION
                     (SELECT restaurants.id, restaurants.name FROM restaurants WHERE restaurants.imageid=". $data->id . ")
                         UNION
                     (SELECT users.id, users.name FROM users WHERE users.imageid=". $data->id . ")
                        UNION
                     (SELECT banners.id, banners.name FROM banners WHERE banners.imageid=". $data->id . ")
                         UNION
                    (SELECT categories.id, categories.name FROM categories WHERE categories.imageid=". $data->id . ")"));
            if ($data->count == 0) {
                $filename = DB::table('image_uploads')->where("id", $data->id)->select("filename")->get()->first();
                if ($filename != null)
                    $data->count = count(DB::table('ordersdetails')->where("image", $filename->filename)->get());
            }

            if (strlen($data->filename) > 14)
                $data->shortName = substr($data->filename, 13, strlen($data->filename)-13);
            else
                $data->shortName = $data->filename;
        }

        return view('media', ['petani' => $petani, 'medialib_type' => $medialib_type]);
    }

    public function mediaSetType(Request $request)
    {
        $type =  $request->get('medialib_type');
        DB::table('settings')->where('param', '=', "medialib_type")->
                where('vendor', Auth::id())->update(['value' => "$type", 'updated_at' => new \DateTime(),]);
        return ImageUploadController::fileCreate($request);
    }

    public function fileStore(Request $request)
    {
        if (!Auth::check())
            return redirect()->route('/');

        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);

        $imageUpload = new ImageUpload();
        $imageUpload->filename = $imageName;
        $imageUpload->vendor = Auth::id();
        $imageUpload->save();
        return response()->json(['filename'=>$imageUpload->filename, 'id'=>$imageUpload->id, 'date'=> $imageUpload->updated_at->format('Y-m-d H:i:s')]);
    }

    public function fileDestroy(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $filename =  $request->get('filename');
        ImageUpload::where('filename',$filename)->delete();
        $path=public_path().'/images/'.$filename;
        if (file_exists($path)) {
            unlink($path);
        }

        return response()->json(['filename'=>$filename]);
    }

    public function imageInfo(Request $request){
        $id = $request->get('id');
        $filename = DB::table('image_uploads')->where("id", $id)->select("filename")->get()->first();
        $ordersdetails = null;
        if ($filename != null) {
            $filename = $filename->filename;
            $ordersdetails = DB::table('ordersdetails')->where("image", $filename)->select("id", "updated_at")->orderBy('updated_at', 'desc')->get();
        }
        return response()->json([
            'foods' => DB::table('foods')->where("imageid", $id)->select("id", "name")->get(),
            'categories' => DB::table('categories')->where("imageid", $id)->select("id", "name")->get(),
            'restaurants' => DB::table('restaurants')->where("imageid", $id)->select("id", "name")->get(),
            'users' => DB::table('users')->where("imageid", $id)->select("id", "name")->get(),
            'orders' => $ordersdetails,
            'banners' => DB::table('banners')->where("imageid", $id)->select("id", "name")->get(),
        ]);
    }

    public function getImagesList(Request $request){
        return response()->json(['error'=>'0',
            'data'=>Util::getImages()]);
    }

}
