<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use DB;

class ProductController extends Controller
{
    public function show(Request $request){

        if($request->keyword == '' && $request->slug == ''){
            return response(['error' => 'Atleast one word(keyword/slug) is required for searching...!'], 200);
        }

        
        if(!empty($request->slug)){

            $product = Product::where('slug', $request->slug)->first();

            if(!empty($product)){
                    
                return response(['products' => $product], 200);
            }
            else{
                return response(['error' => 'No Products Found!'], 401);
            }
        }
        else if(!empty($request->keyword)){

            $searchValues = preg_split('/\s /', $request->keyword, -1, PREG_SPLIT_NO_EMPTY);
            $search_terms = explode(" ", $searchValues[0]);
            // $products = Searchy::products('title')->query($searchValues[0])->get();
            $products = Product::where(function ($q) use ($search_terms) {
              foreach ($search_terms as $value) {
                $q->orWhere('title', 'like', '%'.$value.'%')
                    ->orWhere('tags', 'like', '%'.$value.'%');
              }
            })->get();

            $props = ['title'];

            $products = $products->sortByDesc(function($i, $k) use ($search_terms, $props) {
                // The bigger the weight, the higher the record
                $weight = 0;
                // Iterate through search terms
                foreach($search_terms as $searchTerm) {
                    // Iterate through products (address1, address2...)
                    foreach($props as $prop) { 
                        // Use strpos instead of %value% (cause php)
                        if(strpos($i->{$prop}, $searchTerm) !== false)
                            $weight += 1; // Increase weight if the search term is found
                    }
                }

                return $weight;
                });

                $products = $products->values()->all();


                if(!empty($products[0])){
                    
                    return response(['products' => $products], 200);
                }
                else{
                    return response(['error' => 'No Products Found!'], 401);
                }
            }
        }
        
}
