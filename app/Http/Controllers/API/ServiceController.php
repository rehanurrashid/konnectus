<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ServiceRating;
use App\ServicePhoto;
use App\Service;
use Validator;

class ServiceController extends Controller
{
    public function store(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'category_id' => 'required',
            'language_code' => 'required', 
            'phone' => 'required', 
            'longitude' => 'required',
            'latitude' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
        ]);
        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
        }

         $service = new Service;

        $service->user_id = auth()->user()->id;
        $service->category_id = $request->category_id;
        $service->name = $request->name;
        $service->setAttribute('slug', $request->name);
        $service->tags = $request->tags;
        $service->phone = $request->phone;
        $service->address = $request->address;
        $service->longitude = $request->longitude;
        $service->latitude = $request->latitude;
        $service->from_time = $request->from_time;
        $service->to_time = $request->to_time;
        $service->country_code = $request->country_code;
        $service->language_code = $request->language_code;
        $service->save();

        foreach ($request->image as $file) {
            
            $request['picture'] = $file->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $request['picture'] = asset($request['picture']);

            ServicePhoto::create([
                'service_id' => $service->id,
                'photo' => $request['picture']
            ]);
        }

        if($service){
            return response()->json(['success'=>'Service Added Successfully!'], 200); 
        }
        else{
            return response()->json(['success'=>'Service Failed to Add!'], 422); 
        }
        
    }

    public function show($id){

        $service = Service::with(['category','photos','rating'])->withCount(['rating'])->where('id',$id)->first();
        $service->language_code = explode(',',$service->language_code);
        $rate = $service->rating()->avg('rate');
        $rate = number_format((float)$rate, 1, '.', '');
        $service->avg_rate = $rate;
        return response()->json(['success'=>$service], 200); 
    }

    public function show_all(){

        $services = Service::with(['category','photos'])->withCount(['rating'])->where('status',1)->get();

        foreach ($services as $service) {
            $service->language_code = explode(',',$service->language_code);
            $rate = $service->rating()->avg('rate');
            $rate = number_format((float)$rate, 1, '.', '');
            $service->avg_rate = $rate;

        }

        return response()->json(['success'=>$services], 200); 
    }

    public function store_rating(Request $request){

        $validator = Validator::make($request->all(), [ 
            'service_id' => 'required', 
        ]);
        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
        }

        $service = new ServiceRating;

        $service->user_id = auth()->user()->id;
        $service->service_id = $request->service_id;
        $service->review = $request->review;
        $service->rate = $request->rate;
        $service->save();

        if($service){
            return response()->json(['success'=>'Service Rate/Review Successfully!'], 200); 
        }
        else{
            return response()->json(['success'=>'Service Failed to Rate/Review!'], 422); 
        }

    }

    public function show_rating($id){

        $service_rating = Service::with('rating')->where('id',$id)->first();

        if(!empty($service_rating->rating[0])){
            return response()->json(['success'=>$service_rating], 200); 
        }
        else{
            return response()->json(['success'=>'No Review/Rating Found!'], 422); 
        }
    }

}

