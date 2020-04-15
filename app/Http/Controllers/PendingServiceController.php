<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Category;
use App\Service;
use App\User;


class PendingServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){

            $service = Service::with(['user:id,name'])->withCount('rating')->where('status',0)->get();

            foreach ($service as $row) {

                $rate = $row->rating()->avg('rate');
                $rate = number_format((float)$rate, 1, '.', '');
                $row->avg_rate = $rate;

            }

            return Datatables::of($service)
                ->addColumn('action', function ($service) {
                    return view('admin.actions.actions_pending_service',compact('service'));
                    })
                ->addColumn('user_name', function ($service) {
                    return $service->user->name;
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
       return view('admin.pending_service.index');
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
        return view('admin.pending_service.create',compact('user','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storeservice $request)
    {     
        if ($request['photo']){
            
            $request['picture'] = $request->file('photo')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $request['picture'] = asset($request['picture']);
            $filename = $request->file('photo')->hashName();
        }

        $service = new Service;
        $service->user_id = $request->user_id;
        $service->category_id = $request->category_id;
        $service->setAttribute('slug', $request->title);
        $service->title = $request->title;
        $service->tags = $request->tags;
        $service->description = $request->description;
        $service->image = $filename;
        $service->save();

        if($service){
            Session::flash('message', 'Service Created Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/pending_services');
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
        $service = service::with(['user:id,name','category:id,name','rating'])->withCount(['rating'])->where('id',$id)->first();
        $rate = $service->rating()->avg('rate');
        $rate = number_format((float)$rate, 1, '.', '');
        $service->avg_rate = $rate;
        return view('admin.pending_service.show',compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $service = service::find($id);
        $user = User::pluck('name','id');
        $category = Category::pluck('name', 'id');
        return view('admin.pending_service.edit',compact('service','user','category'));
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
        $service = service::find($id);

        $service->status = $request->status;
        $service->save();

        if($service){
            Session::flash('message', 'Service Updated Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/pending_services');
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
            return view('admin.pending_service.index');
        }
    }
}
