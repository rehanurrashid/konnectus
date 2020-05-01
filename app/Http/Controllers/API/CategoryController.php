<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use DB;

class CategoryController extends Controller
{
    public $category = '';

    public function index(Request $request)
    {
        $category['place'] = Category::where('type','place')->get();
        $category['service'] = Category::where('type','service')->get();

        if(empty($category['place'][0])){
            $category['place'] = [];
        }

        if(empty($category['service'][0])){
            $category['service'] = [];
        }

        if($category){
            return response()->json($category, 200);
        }
        else{
            return response()->json(['error'=> 'No Categories Found!'], 404);
        }  
    }

    public function places($id){

    	$category = Category::with(['places'=>function($r){
    	    return $r->where('status',1);
    	}])->where('id', $id)->first();

    	if(!empty($category->places)){

            foreach ($category->places as $row) {
                
                if(!empty($row->rating)){
                    $rate = $row->rating->avg('rate');
                    $rate = number_format((float)$rate, 1, '.', '');
                    $row->avg_rate = $rate;
                }
                else {
                    $row->avg_rate = 'No Rating!';
                }    

            }

            DB::table('category_users')->updateOrInsert([

                    'user_id' => auth()->user()->id,
                    'category_id' => $id,
                    'image' => $category->mega_image,
                    'type' => 'place',
                ]);


    		return response()->json(['categories'=>$category ,'message' => 'success'], 200);
    	}
    	else{
    		return response()->json(['categories'=>'No Places Found!' ,'message' => 'error'], 404);
    	}
    }

    public function services($id){
        
        $service = Category::with(['services'=>function($r){
    	    return $r->where('status',1);
    	}])->where('id', $id)->first();

        if(!empty($service->services)){

            foreach ($service->services as $row) {
                
                if(!empty($row->rating)){
                    $rate = $row->rating->avg('rate');
                    $rate = number_format((float)$rate, 1, '.', '');
                    $row->avg_rate = $rate;
                }
                else {
                    $row->avg_rate = 'No Rating!';
            } 
        }

        DB::table('category_users')->updateOrInsert([

                    'user_id' => auth()->user()->id,
                    'category_id' => $id,
                    'image' => $service->mega_image,
                    'type' => 'service',
                ]);
            
            return response()->json(['service'=>$service,'message' => 'success'], 200);
        }
        else{
            return response()->json(['service'=>'No Services Found!','message' => 'error'], 404);
        }
    }

    public function most_visited_place_category(){

        $category = Category::withCount('popular')->orderBy('popular_count','DESC')->where('type','=','place')->get();

        if(!empty($category)){
            return response()->json(['place'=>$category,'message' => 'success'], 200);
        }
        else{
            return response()->json(['place'=>$category,'message' => 'success'], 200);
        }
    }

    public function most_visited_service_category(){

        $category = Category::withCount('popular')->orderBy('popular_count','DESC')->where('type','=','service')->get();

        if(!empty($category)){
            return response()->json(['place'=>$category,'message' => 'success'], 200);
        }
        else{
            return response()->json(['place'=>$category,'message' => 'success'], 200);
        }
    }
}
