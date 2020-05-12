<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PlaceRating;
use App\PlacePhoto;
use App\Place;
use Validator;
use DB;

class PlaceController extends Controller
{
    public function store(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'category_id' => 'required',
            'language_code' => 'required',
            'phone' => 'required|unique:places', 
            'longitude' => 'required',
            'latitude' => 'required',
            'image' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $place = new Place;

        $place->user_id = auth()->user()->id;
        $place->category_id = $request->category_id;
        $place->name = $request->name;
        $place->setAttribute('slug', $request->name);
        $place->tags = $request->tags;
        $place->phone = $request->phone;
        $place->address = $request->address;
        $place->longitude = $request->longitude;
        $place->latitude = $request->latitude;
        $place->from_time = $request->from_time;
        $place->to_time = $request->to_time;
        $place->country_code = $request->country_code;
        $place->language_code = $request->language_code;
        $place->save();

        foreach ($request->image as $file) {
            
            $request['picture'] = $file->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $request['picture'] = asset($request['picture']);

            PlacePhoto::create([
                'place_id' => $place->id,
                'photo' => $request['picture']
            ]);
        }

        if($place){
        	return response()->json(['success'=>'Place Added Successfully!'], 200); 
        }
        else{
        	return response()->json(['success'=>'Place Failed to Add!'], 422); 
        }
        
    }

    public function show($id){

        $place = Place::with(['category','photos','rating'])->withCount(['rating'])->where('id',$id)->first();

        $place->language_code = explode(',',$place->language_code);

        if($place != null){

            $rate = $place->rating()->avg('rate');
            $rate = number_format((float)$rate, 1, '.', '');
            $place->avg_rate = $rate;
            return response()->json(['success'=>$place], 200); 
        }
        else{
            return response()->json(['error'=> ''], 200); 
        }
        
    }

    public function show_all(){

        $places = Place::with(['category','photos'])->withCount(['rating'])->where('status',1)->get();

        foreach ($places as $place) {
            $place->language_code = explode(',',$place->language_code);
            $rate = $place->rating()->avg('rate');
            $rate = number_format((float)$rate, 1, '.', '');
            $place->avg_rate = $rate;

        }

        return response()->json(['success'=>$places], 200); 
    }

    public function store_rating(Request $request){

        $validator = Validator::make($request->all(), [ 
            'place_id' => 'required', 
        ]);
        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
        }

        $place = new PlaceRating;

        $place->user_id = auth()->user()->id;
        $place->place_id = $request->place_id;
        $place->review = $request->review;
        $place->rate = $request->rate;
        $place->save();

        if($place){
            return response()->json(['success'=>'Place Rate/Review Successfully!'], 200); 
        }
        else{
            return response()->json(['success'=>'Place Failed to Rate/Review!'], 422); 
        }

    }

    public function show_rating($id){

        $place_rating = Place::with('rating')->where('id',$id)->where('status',1)->first();

        if(!empty($place_rating->rating[0])){
            return response()->json(['success'=>$place_rating], 200); 
        }
        else{
            return response()->json(['success'=>'No Review/Rating Found!'], 422); 
        }
    }

    public function search(Request $request){

        if($request->keyword == '' && $request->slug == ''){
            return response(['error' => 'Atleast one word(keyword/slug) is required for searching...!'], 200);
        }

        if(!empty($request->slug)){

            $place = Place::with(['category','photos','rating'])->withCount(['rating'])->where('slug', $request->slug)->first();
            

            if(!empty($place)){


                foreach ($places as $place) {
                    $place->language_code = explode(',',$place->language_code);
                }

                $place['latest_places'] = Place::orderBy('id', 'desc')->take(5)->get();

                $place['related_places'] = Place::orderBy('id', 'desc')->take(5)->get();

                $search_terms = explode(",", $place->tags);
    
                $place['related_places'] = Place::where(function ($q) use ($search_terms) {
                  foreach ($search_terms as $value) {
                    $q->orWhere('tags', 'like', '%'.$value.'%');
                  }
                })->with(['rating'])->get();

                if(!empty($place['related_places'])){

                    foreach ($place['related_places'] as $row) {

                        $rate = $row->rating()->avg('rate');
                        $rate = number_format((float)$rate, 1, '.', '');
                        $row->avg_rate = $rate;

                    }
                }
                
                // auth()->user()->places()->attach($place->id);

                $rate = $place->rating()->avg('rate');
                $rate = number_format((float)$rate, 1, '.', '');
                $place->avg_rate = $rate;

                return response(['product' => $place], 200);
            }
            else{
                // $place['product'] = 'No Product Found!';
                // $place['latest_places'] = Product::orderBy('id', 'desc')->take(5)->get();
                return response(['product' => []], 200);
            }
        }
        else if(!empty($request->keyword)){

            $searchValues = preg_split('/\s /', $request->keyword, -1, PREG_SPLIT_NO_EMPTY);
            $search_terms = explode(" ", $searchValues[0]);
            // $places = Searchy::places('title')->query($searchValues[0])->get();
            $places = Place::where(function ($q) use ($search_terms) {
              foreach ($search_terms as $value) {
                $q->orWhere('name', 'like', '%'.$value.'%')
                    ->orWhere('tags', 'like', '%'.$value.'%');
              }
            })->get();

            $props = ['name'];

            $places = $places->sortByDesc(function($i, $k) use ($search_terms, $props) {
                // The bigger the weight, the higher the record
                $weight = 0;
                // Iterate through search terms
                foreach($search_terms as $searchTerm) {
                    // Iterate through places (address1, address2...)
                    foreach($props as $prop) {
                        // Use strpos instead of %value% (cause php)
                        if(strpos($i->{$prop}, $searchTerm) !== false)
                            $weight += 1; // Increase weight if the search term is found
                    }
                }

                return $weight;
                });

                foreach ($places as $row) {

                    $rate = $row->rating()->avg('rate');
                    $rate = number_format((float)$rate, 1, '.', '');
                    $row->avg_rate = $rate;

                }

                $places = $places->values()->all();

                if(!empty($places[0])){

                    return response(['places' => $places], 200);
                }
                else{
                    return response(['places' => []], 200);
                }
            }
    }
}

