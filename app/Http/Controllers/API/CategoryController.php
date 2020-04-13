<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public $category = '';

    public function index(Request $request)
    {
        $category['place'] = Category::where('type','place')->get();
        $category['service'] = Category::where('type','service')->get();

        if(empty($category['place'][0])){
            $category['place'] = 'No Categories Found!';
        }

        if(empty($category['service'][0])){
            $category['service'] = 'No Categories Found!';
        }

        if($category){
            return response()->json($category, 200);
        }
        else{
            return response()->json(['error'=> 'No Categories Found!'], 200);
        }  
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

    public function services($id){
        
        $category = Category::with('services')->where('id', $id)->first();
        if(!empty($category->places)){
            return response()->json(['Categories'=>$category], 200);
        }
        else{
            return response()->json(['Categories'=>'No Products Found!'], 200);
        }
    }
}
