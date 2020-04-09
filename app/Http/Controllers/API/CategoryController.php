<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::pluck('name', 'id');
        return response()->json(['Categories'=>$category], 200);
    }

    public function places($id){
    	$category = Category::with('places')->where('id', $id)->first();

    	if(!empty($category->places)){
    		return response()->json(['Categories'=>$category], 200);
    	}
    	else{
    		return response()->json(['Categories'=>'No Places Found!'], 200);
    	}
    }
}
