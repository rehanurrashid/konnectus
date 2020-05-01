<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\ServicesPhoto;
use App\Category;
use App\Service;
use App\User;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Service $service)
    {
        if($request->ajax()){

            $service = $service->newQuery()->with(['user','rating'])->withCount('rating');

            foreach ($service as $row) {

                $rate = $row->rating()->avg('rate');
                $rate = number_format((float)$rate, 1, '.', '');
                $row->avg_rate = $rate;

            }

            return Datatables::of($service)
                ->addColumn('action', function ($service) {
                    return view('admin.actions.actions_service',compact('service'));
                    })
                ->addColumn('user_name', function ($service) {
                     if($service->user != Null){
                            return $service->user->name;
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
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
       return view('admin.service.index');
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
        return view('admin.service.create',compact('user','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreService $request)
    {    
        $service = new Service;
        $service = Service::create([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'slug' => $service->setAttribute('slug', $request->name),
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

            ServicesPhoto::create([
                'service_id' => $place->id,
                'photo' => $request['picture']
            ]);
        }
        if($service){
            Session::flash('message', 'Service Created Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/ervices');
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
        $service = Service::with(['user:id,name','category:id,name','rating'])->withCount(['rating'])->where('id',$id)->first();
        $rate = $service->rating()->avg('rate');
        $rate = number_format((float)$rate, 1, '.', '');
        $service->avg_rate = $rate;
        return view('admin.service.show',compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $service = Service::find($id);
        $user = User::pluck('name','id');
        $category = Category::pluck('name', 'id');
        return view('admin.service.edit',compact('service','user','category'));
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
        $service = Service::find($id);

        $service->status = $request->status;
        $service->save();

        if($service){
            Session::flash('message', 'Service Updated Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/services');
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
        $service = Service::find($id)->delete();
        if($service){
            return view('admin.service.index');
        }
    }
}
