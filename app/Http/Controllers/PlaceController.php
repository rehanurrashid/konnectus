<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StorePlace;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\PlacePhoto;
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

            $place = $place->newQuery()->with(['user','rating'])->where('status',1)->withCount('rating');

            // dd($place);
            return Datatables::of($place)
                ->addColumn('action', function (Place $place) {
                    return view('admin.actions.actions_place',compact('place'));
                    })
                ->addColumn('name', function ($place) {
                    $token = 1;
                    return view('admin.actions.actions_place',compact('place','token'));
                    })
                ->addColumn('status', function (Place $place) {
                    if($place->status == 1){
                        return 'Approved';
                    }
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

                    $rate = $place->rating->avg('rate');
                    return $rate = number_format((float)$rate, 1, '.', '');

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
        $place->user_id = $request->user_id;
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
        $place->language_code = $request->language_code;
        $place->save();

        if ($request->photo){
            foreach ($request->photo as $file) {
            
                $request['picture'] = $file->store('public/storage');
                $request['picture'] = Storage::url($request['picture']);
                $request['picture'] = asset($request['picture']);

                PlacePhoto::create([
                    'place_id' => $place->id,
                    'photo' => $request['picture']
                ]);
            }
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
        $place = Place::with(['user:id,name','category:id,name','rating','photos'])->withCount(['rating'])->where('id',$id)->first();
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

        if($request->status == 2){
            $request->status = Null;
        }
        
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

    public function add_note(Request $request){

        $place = Place::find($request->place_id);
        
        $place->notes = $request->notes;
        $place->save();

        if($place){
            return response(['status' => true,'data' => $place], 200);
        }
        else{
            return response(['status' => false], 200);
        }
    }
}
