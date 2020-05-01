<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StorePlace;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\PlacesPhoto;
use App\Category;
use App\Place;
use App\User;


class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Place $place)
    {
        if($request->ajax()){

            $place = $place->newQuery()->with(['user','rating'])->withCount('rating');
            // dd($place[0]->rating[0]->rate);

            foreach ($place as $row) {

                $rate = $row->rating()->avg('rate');
                $rate = number_format((float)$rate, 1, '.', '');
                $row->avg_rate = $rate;

            }
            return Datatables::of($place)
                ->addColumn('action', function (Place $place) {
                    return view('admin.actions.actions_place',compact('place'));
                    })
                ->addColumn('user_name', function ($place) {
                        if($place->user != Null){
                            return $place->user->name;
                        }
                        else{
                            return 'No User';
                        }
                    })
                ->addColumn('rate', function ($place) {
                    return $place->avg_rate;
                    })
                ->addColumn('reviews', function ($place) {
                    return $place->rating_count;
                    })
                ->addColumn('direction', function ($place) {
                    return view('admin.actions.actions_get_direction',compact('place'))->render();
                    })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['direction'])
                ->make(true);
        }
       return view('admin.place.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::pluck('name','id');
        $category = Category::pluck('name', 'id');
        return view('admin.place.create',compact('user','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlace $request)
    {   
        $place = new Place;
        $place = Place::create([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'slug' => $place->setAttribute('slug', $request->name),
            'name' => $request->name,
            'tags' => $request->tags,
            'phone' =>$request->phone,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'from_time' => $request->from_time,
            'to_time' => $request->to_time,
        ]);

        foreach ($request->photo as $file) {
            
            $request['picture'] = $file->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $request['picture'] = asset($request['picture']);

            PlacesPhoto::create([
                'place_id' => $place->id,
                'photo' => $request['picture']
            ]);
        }

        if($place){
            Session::flash('message', 'Place Created Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/places');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place = Place::with(['user:id,name','category:id,name','rating'])->withCount(['rating'])->where('id',$id)->first();
        $rate = $place->rating()->avg('rate');
        $rate = number_format((float)$rate, 1, '.', '');
        $place->avg_rate = $rate;
        return view('admin.place.show',compact('place'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $place = Place::find($id);
        $user = User::pluck('name','id');
        $category = Category::pluck('name', 'id');
        return view('admin.place.edit',compact('place','user','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $place = Place::find($id);
        // dd($place, $request->status);

        $place->status = $request->status;
        $place->save();

        if($place){
            Session::flash('message', 'Place Updated Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/places');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place = Place::find($id)->delete();
        if($place){
            return view('admin.place.index');
        }
    }
}
