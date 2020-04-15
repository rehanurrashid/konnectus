<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Place;
use App\PlaceRating;

class PlaceController extends Controller
{
    public function store(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'category_id' => 'required', 
            'phone' => 'required', 
            'longitude' => 'required',
            'latitude' => 'required',
            'image' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
        ]);
        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
        }

        $filename ='';

        if ($request['image']){
            $originalImage= $request->file('image');
            $request['picture'] = $request->file('image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $request['picture'] = asset($request['picture']);
            $filename = $request->file('image')->hashName();

        }

        $place = new Place;

        $place->user_id = auth()->user()->id;
        $place->category_id = $request->category_id;
        $place->name = $request->name;
        $place->setAttribute('slug', $request->name);
        $place->address = $request->address;
        $place->image = $request['picture'];
        $place->phone = $request->phone;
        $place->longitude = $request->longitude;
        $place->latitude = $request->latitude;
        $place->tags = $request->tags;
        $place->from_time = $request->from_time;
        $place->to_time = $request->to_time;
        $place->save();

        if($place){
        	return response()->json(['success'=>'Place Added Successfully!'], 200); 
        }
        else{
        	return response()->json(['success'=>'Place Failed to Add!'], 422); 
        }
        
    }

    public function show($id){

        $place = Place::with(['category','rating'])->withCount(['rating'])->where('id',$id)->first();
        $rate = $place->rating()->avg('rate');
        $rate = number_format((float)$rate, 1, '.', '');
        $place->avg_rate = $rate;
        return response()->json(['success'=>$place], 200); 
    }

    public function show_all(){

        $places = Place::with(['category'])->withCount(['rating'])->get();

        foreach ($places as $place) {

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

        $place_rating = Place::with('rating')->where('id',$id)->first();

        if(!empty($place_rating->rating[0])){
            return response()->json(['success'=>$place_rating], 200); 
        }
        else{
            return response()->json(['success'=>'No Review/Rating Found!'], 422); 
        }
    }

}

