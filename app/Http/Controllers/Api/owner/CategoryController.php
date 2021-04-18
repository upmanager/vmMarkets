<?php
namespace App\Http\Controllers\API\owner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class CategoryController extends Controller
{
    public function load(){
        return CategoryController::categoryRet("");
    }

    public function categoryRet($id){
        $categories = DB::table('categories')->where('vendor', Auth::user()->id)->orWhere('vendor', 0)->get();
        $images = DB::table('image_uploads')->select('id', 'filename')->get();

        return response()->json([
            'error' => '0',
            'id' => $id,
            'images' => $images,
            'category' => $categories,
            'vendor' => Auth::user()->id
        ], 200);
    }

    public function categorySave(Request $request){
        $edit = $request->input('edit') ?: "0";
        $editId = $request->input('editId') ?: "0";

        $values = array(
            'name' => $request->input('name'),
            'desc' => $request->input('desc') ?: "",
            'imageid' => $request->input('imageid') ?: 0,
            'visible' => $request->input('visible'),
            'parent' => $request->input('parent'),
            'vendor' => Auth::user()->id,
            'updated_at' => new \DateTime());

        $id = $editId;
        if ($edit == '1')
            DB::table('categories')->where('id', $editId)->where('vendor', Auth::user()->id)->update($values);
        else{
            $values['created_at'] = new \DateTime();
            DB::table('categories')->insert($values);
            $id = DB::getPdo()->lastInsertId();
        }
        return CategoryController::categoryRet($id);
    }

    public function categoryDelete(Request $request){
        $id = $request->input('id');
        DB::table('categories')->where('id',$id)->where('vendor', Auth::user()->id)->delete();
        return CategoryController::categoryRet("");
    }


}
