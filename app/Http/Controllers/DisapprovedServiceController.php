<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\ServicePhoto;
use App\Category;
use App\Service;
use App\User;


class DisapprovedServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Service $service)
    {
        if($request->ajax()){

            $service = $service->newQuery()->with(['user','rating'])->where('status',0)->withCount('rating');

            return Datatables::of($service)
                ->addColumn('action', function ($service) {
                    return view('admin.actions.actions_disapproved_service',compact('service'));
                    })
                ->addColumn('name', function ($service) {
                    $token = 1;
                    return view('admin.actions.actions_disapproved_service',compact('service','token'));
                    })
                ->addColumn('user_name', function ($service) {
                     if($service->user != Null){
                            return $service->user->name;
                        }
                        else{
                            return 'No User';
                        }
                    })
                ->addColumn('status', function ($service) {
                    if($service->status == 0){
                        return 'Denied';
                    }
                    })
                ->addColumn('rate', function ($service) {
                    $rate = $service->rating->avg('rate');
                    return $rate = number_format((float)$rate, 1, '.', '');
                    })
                ->addColumn('reviews', function ($service) {
                    return $service->rating_count;
                    })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
       return view('admin.disapproved_service.index');
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
        return view('disapproved_service.create',compact('user','category'));
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
        $service->user_id = $request->user_id;
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
        $service->language_code = $request->language_code;
        $service->save();

        foreach ($request->photo as $file) {
            
            $request['picture'] = $file->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $request['picture'] = asset($request['picture']);

            ServicePhoto::create([
                'service_id' => $service->id,
                'photo' => $request['picture']
            ]);
        }
        if($service){
            Session::flash('message', 'Service Created Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/disapproved_services');
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
        $service = Service::with(['user:id,name','category:id,name','rating','photos'])->withCount(['rating'])->where('id',$id)->first();
        $rate = $service->rating()->avg('rate');
        $rate = number_format((float)$rate, 1, '.', '');
        $service->avg_rate = $rate;
        return view('admin.disapproved_service.show',compact('service'));
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
        return view('admin.disapproved_service.edit',compact('service','user','category'));
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

        if($request->status == 2){
            $request->status = Null;
        }

        
        $service->status = $request->status;
        $service->save();

        if($service){
            Session::flash('message', 'Service Updated Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/disapproved_services');
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
        $service = Service::find($id)->forceDelete();
        if($service){
            return view('disapproved_service.index');
        }
    }
}
