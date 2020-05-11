<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StorePlace;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Category;
use App\Place;
use App\User;

class DisapprovedPlaceController extends Controller
{
   public function index(Request $request, Place $place)
    {
        if($request->ajax()){

            $place = $place->newQuery()->with(['user','rating'])->where('status',0)->withCount('rating');

            // dd($place);
            return Datatables::of($place)
                ->addColumn('action', function (Place $place) {
                    return view('admin.actions.actions_disapproved_place',compact('place'));
                    })
                ->addColumn('status', function (Place $place) {
                    if($place->status == 0){
                        return 'Denied';
                    }
                    })
                ->addColumn('name', function ($place) {
                    $token = 1;
                    return view('admin.actions.actions_disapproved_place',compact('place','token'));
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
       return view('admin.disapproved_place.index');
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
        return view('admin.disapproved_place.create',compact('user','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlace $request)
    {     
        if ($request['photo']){
            
            $request['picture'] = $request->file('photo')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $request['picture'] = asset($request['picture']);
            $filename = $request->file('photo')->hashName();
        }

        $place = new place;
        $place->user_id = $request->user_id;
        $place->category_id = $request->category_id;
        $place->setAttribute('slug', $request->title);
        $place->title = $request->title;
        $place->tags = $request->tags;
        $place->description = $request->description;
        $place->image = $filename;
        $place->save();

        if($place){
            Session::flash('message', 'Place Created Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/disapproved_places');
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
        return view('admin.disapproved_place.show',compact('place'));
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
        return view('admin.disapproved_place.edit',compact('place','user','category'));
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

        if($request->status == 1 || $request->status == 0){
            $request->why_deny = Null;
        }

        $place->status = $request->status;
        $place->why_deny = $request->why_deny;
        $place->save();

        if($place){
            Session::flash('message', 'Place Updated Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/disapproved_places');
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
            return view('admin.disapproved_place.index');
        }
    }
}
