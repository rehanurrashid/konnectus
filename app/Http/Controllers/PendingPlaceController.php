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

class PendingPlaceController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){

            $place = Place::with(['user:id,name'])->where('status',0)->withCount('rating')->get();

             foreach ($place as $row) {

                $rate = $row->rating()->avg('rate');
                $rate = number_format((float)$rate, 1, '.', '');
                $row->avg_rate = $rate;

            }

            return Datatables::of($place)
                ->addColumn('action', function ($place) {
                    return view('admin.actions.actions_pending_place',compact('place'));
                    })
                ->addColumn('user_name', function ($place) {
                    return $place->user->name;
                    })
                ->addColumn('rate', function ($place) {
                    return $place->avg_rate;
                    })
                ->addColumn('reviews', function ($place) {
                    return $place->rating_count;
                    })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
       return view('admin.pending_place.index');
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
        return view('admin.pending_place.create',compact('user','category'));
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
            return redirect('admin/pending_places');
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
        return view('admin.pending_place.show',compact('place'));
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
        return view('admin.pending_place.edit',compact('place','user','category'));
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

        $place->status = $request->status;
        $place->save();

        if($place){
            Session::flash('message', 'Place Updated Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/pending_places');
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
            return view('admin.pending_place.index');
        }
    }
}
