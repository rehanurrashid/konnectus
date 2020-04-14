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

    		return response()->json(['categories'=>$category ,'message' => 'success'], 200);
    	}
    	else{
    		return response()->json(['categories'=>'No Places Found!' ,'message' => 'error'], 200);
    	}
    }

    public function services($id){
        
        $service = Category::with('services')->where('id', $id)->first();

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
            
            return response()->json(['service'=>$service,'message' => 'success'], 200);
        }
        else{
            return response()->json(['service'=>'No Services Found!','message' => 'error'], 200);
        }
    }
}
