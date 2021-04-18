<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Settings;
use App\Util;
use App\Lang;

class CategoriesController extends Controller
{
    public function load(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');
        return view('categories', []);
    }

    public function add(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $id = $request->input('id', "0"); // for edit
        $name = $request->input('name');
        $visible = $request->input('visible');
        $text = $request->input('desc') ?: "";
        $vendor = Auth::id();
        if (Auth::user()->role == 1)
            $vendor = 0;

        $values = array('name' => $name,
            'imageid' => $request->input('image') ?: 0,
            'desc' => $text,
            'visible' => $visible,
            'parent' => $request->input('parent'),
            'vendor' => $vendor,
            'updated_at' => new \DateTime());

        if ($id != "0"){
            DB::table('categories')->where('id', $id)->update($values);
        }else{
            $values['created_at'] = new \DateTime();
            DB::table('categories')->insert($values);
            $id = DB::getPdo()->lastInsertId();
        }

        return CategoriesController::getOne($id);
    }

    public function categoryGetInfo(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1"]);

        $id = $request->input('id', "0");
        if ($id == "0")
            return response()->json(['error' => "4"]);

        return CategoriesController::getOne($id);
    }

    public function getOne($id){
        $category = DB::table('categories')->where("id", $id)->get()->first();
        $categories = DB::table('categories')->get();

        $filename = DB::table('image_uploads')->where("id", $category->imageid)->get()->first();
        if ($filename != null)
            $category->filename = $filename->filename;
        else
            $category->filename = "noimage.png";
        $category->timeago = Util::timeago($category->updated_at);
        $category->parentName = "";
        foreach ($categories as &$value)
            if ($category->parent == $value->id)
                $category->parentName = $value->name;

        $category->itemsCount = 0;
        $cat = DB::table('categories')->
            select('id', 'name')->
            where('visible', '1')->get();

        return response()->json(['error'=>"0",
            'data' => $category,
            'category' => $cat
        ]);
    }

    public function delete(Request $request){
        if (!Auth::check())
            return response()->json(['error' => "1"]);
        if (Settings::isDemoMode())
            return response()->json(['error'=>'2', 'text' => Lang::get(489)]); // This is demo app. You can't change this section

        $id = $request->input('id');
        DB::table('categories')
            ->where('id',$id)
            ->delete();

        return response()->json(['error'=>'0']);
    }

    public function categoryGoPage(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error'=>"1"]);

        $search = $request->input('search') ? : "";
        $cat = $request->input('cat', "0");
        $page = $request->input('page') ? : 1;
        $count = $request->input('count', 10);
        $sortBy = $request->input('sortBy') ? : "id";
        $sortAscDesc = $request->input('sortAscDesc') ? : "asc";
        $sortPublished = $request->input('sortPublished', "1");
        $sortUnPublished = $request->input('sortUnPublished', "1");

        $offset = ($page - 1) * $count;

        $searchVisible = "";
        if ($sortPublished != '1' || $sortUnPublished != '1') {
            if ($sortPublished == '1')
                $searchVisible = "visible = '1' AND ";
            if ($sortUnPublished == '1')
                $searchVisible = "visible = '0' AND ";
        }
        if ($sortPublished == '0' && $sortUnPublished == '0')
            $searchVisible = "visible='3' AND ";

        $searchCat = "";
        if ($cat != "0")
            $searchCat = " parent=" . $cat . " AND ";

        $vendor = Auth::id();
        if (Auth::user()->role == 1)
            $vendor = 0;

        $data = DB::select("SELECT * FROM categories WHERE vendor=" . $vendor . " AND " . $searchVisible . $searchCat . " name LIKE '%" . $search . "%' ORDER BY " . $sortBy . " " . $sortAscDesc . " LIMIT " . $count . " OFFSET " . $offset);
        $total = count(DB::select("SELECT * FROM categories WHERE vendor=" . $vendor . " AND " . $searchVisible . $searchCat . " name LIKE '%" . $search . "%'" ));

        $categoriesAll = DB::table('categories')->get();
        foreach ($data as &$category) {
            $filename = DB::table('image_uploads')->where("id", $category->imageid)->get()->first();
            if ($filename != null)
                $category->filename = $filename->filename;
            else
                $category->filename = "noimage.png";
            $category->timeago = Util::timeago($category->updated_at);
            $category->parentName = "";
            foreach ($categoriesAll as &$value)
                if ($category->parent == $value->id)
                    $category->parentName = $value->name;
            $category->itemsCount = count(DB::table('foods')->where("category", $category->id)->get());
        }

        $t = $total/$count;
        if ($total%$count > 0)
            $t++;

        return response()->json(['error'=>"0", 'idata' => $data, 'page' => $page, 'pages' => $t, 'total' => $total]);
    }
}
