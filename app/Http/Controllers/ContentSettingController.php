<?php

namespace App\Http\Controllers;

use App\ContentSetting;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ContentSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){

            $content = ContentSetting::get();
            // dd($content);
            return Datatables::of($content)
                ->addColumn('action', function($content) {
                    return view('admin.actions.actions_content',compact('content'));
                    })
                ->addColumn('view_content', function ($content) {
                    $token = 1;
                    return view('admin.actions.actions_content',compact('content','token'));
                    })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
       return view('admin.content.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.content.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $content = new ContentSetting;

        if ($request['header_logo']){
            $originalImage= $request->file('header_logo');
            $request['picture'] = $request->file('header_logo')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->header_logo = asset($request['picture']);
        }

        if ($request['header_f_image']){
            $originalImage= $request->file('header_f_image');
            $request['picture'] = $request->file('header_f_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->header_f_image = asset($request['picture']);
        }

        if ($request['header_bg_image']){
            $originalImage= $request->file('header_bg_image');
            $request['picture'] = $request->file('header_bg_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->header_bg_image = asset($request['picture']);
        }

        if ($request['our_blogs_bg_image']){
            $originalImage= $request->file('our_blogs_bg_image');
            $request['picture'] = $request->file('our_blogs_bg_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->our_blogs_bg_image = asset($request['picture']);
        }

        if ($request['our_blogs_rt_image']){
            $originalImage= $request->file('our_blogs_rt_image');
            $request['picture'] = $request->file('our_blogs_rt_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->our_blogs_rt_image = asset($request['picture']);
        }

        if ($request['our_blogs_bl_image']){
            $originalImage= $request->file('our_blogs_bl_image');
            $request['picture'] = $request->file('our_blogs_bl_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->our_blogs_bl_image = asset($request['picture']);
        }

        if ($request['download_app_bg_image']){
            $originalImage= $request->file('download_app_bg_image');
            $request['picture'] = $request->file('download_app_bg_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->download_app_bg_image = asset($request['picture']);
        }

        if ($request['download_app_r1_image']){
            $originalImage= $request->file('download_app_r1_image');
            $request['picture'] = $request->file('download_app_r1_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->download_app_r1_image = asset($request['picture']);
        }

        if ($request['download_app_r2_image']){
            $originalImage= $request->file('download_app_r2_image');
            $request['picture'] = $request->file('download_app_r2_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->download_app_r2_image = asset($request['picture']);
        }
        
        if ($request['location_image']){
            $originalImage= $request->file('location_image');
            $request['picture'] = $request->file('location_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->location_image = asset($request['picture']);
        }

        if ($request['phone_image']){
            $originalImage= $request->file('phone_image');
            $request['picture'] = $request->file('phone_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->phone_image = asset($request['picture']);
        }

        if ($request['email_image']){
            $originalImage= $request->file('email_image');
            $request['picture'] = $request->file('email_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->email_image = asset($request['picture']);
        }

        if ($request['footer_logo']){
            $originalImage= $request->file('footer_logo');
            $request['picture'] = $request->file('footer_logo')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->footer_logo = asset($request['picture']);
        }

        if ($request['footer_bg_image']){
            $originalImage= $request->file('footer_bg_image');
            $request['picture'] = $request->file('footer_bg_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->footer_bg_image = asset($request['picture']);
        }

        $content->header_h = $request->header_h;
        $content->header_p = $request->header_p;
        $content->about_us_h = $request->about_us_h;
        $content->about_us_p = $request->about_us_p;
        $content->our_blogs_h = $request->our_blogs_h;
        $content->our_blogs_p = $request->our_blogs_p;
        $content->updates_h = $request->updates_h;
        $content->updates_p = $request->updates_p;
        $content->download_app_h = $request->download_app_h;
        $content->download_app_p = $request->download_app_p;
        $content->contact_us_h = $request->contact_us_h;
        $content->location = $request->location;
        $content->phone = $request->phone;
        $content->email = $request->email;
        $content->footer_p = $request->footer_p;
        $content->copyright = $request->copyright;
        $content->save();

        if($content){
            Session::flash('message', 'ContentSetting Created Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/content_settings');
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
        $content = ContentSetting::find($id);
        return view('admin.content.show',compact('content'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $content = ContentSetting::find($id);
        return view('admin.content.edit',compact('content'));
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
        $content = ContentSetting::find($id);
        
        if ($request['header_logo']){
            $originalImage= $request->file('header_logo');
            $request['picture'] = $request->file('header_logo')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->header_logo = asset($request['picture']);
        }

        if ($request['header_f_image']){
            $originalImage= $request->file('header_f_image');
            $request['picture'] = $request->file('header_f_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->header_f_image = asset($request['picture']);
        }

        if ($request['header_bg_image']){
            $originalImage= $request->file('header_bg_image');
            $request['picture'] = $request->file('header_bg_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->header_bg_image = asset($request['picture']);
        }

        if ($request['our_blogs_bg_image']){
            $originalImage= $request->file('our_blogs_bg_image');
            $request['picture'] = $request->file('our_blogs_bg_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->our_blogs_bg_image = asset($request['picture']);
        }

        if ($request['our_blogs_rt_image']){
            $originalImage= $request->file('our_blogs_rt_image');
            $request['picture'] = $request->file('our_blogs_rt_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->our_blogs_rt_image = asset($request['picture']);
        }

        if ($request['our_blogs_bl_image']){
            $originalImage= $request->file('our_blogs_bl_image');
            $request['picture'] = $request->file('our_blogs_bl_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->our_blogs_bl_image = asset($request['picture']);
        }

        if ($request['download_app_bg_image']){
            $originalImage= $request->file('download_app_bg_image');
            $request['picture'] = $request->file('download_app_bg_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->download_app_bg_image = asset($request['picture']);
        }

        if ($request['download_app_r1_image']){
            $originalImage= $request->file('download_app_r1_image');
            $request['picture'] = $request->file('download_app_r1_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->download_app_r1_image = asset($request['picture']);
        }

        if ($request['download_app_r2_image']){
            $originalImage= $request->file('download_app_r2_image');
            $request['picture'] = $request->file('download_app_r2_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->download_app_r2_image = asset($request['picture']);
        }
        
        if ($request['location_image']){
            $originalImage= $request->file('location_image');
            $request['picture'] = $request->file('location_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->location_image = asset($request['picture']);
        }

        if ($request['phone_image']){
            $originalImage= $request->file('phone_image');
            $request['picture'] = $request->file('phone_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->phone_image = asset($request['picture']);
        }

        if ($request['email_image']){
            $originalImage= $request->file('email_image');
            $request['picture'] = $request->file('email_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->email_image = asset($request['picture']);
        }

        if ($request['footer_logo']){
            $originalImage= $request->file('footer_logo');
            $request['picture'] = $request->file('footer_logo')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->footer_logo = asset($request['picture']);
        }

        if ($request['footer_bg_image']){
            $originalImage= $request->file('footer_bg_image');
            $request['picture'] = $request->file('footer_bg_image')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $content->footer_bg_image = asset($request['picture']);
        }

        $content->header_h = $request->header_h;
        $content->header_p = $request->header_p;
        $content->about_us_h = $request->about_us_h;
        $content->about_us_p = $request->about_us_p;
        $content->our_blogs_h = $request->our_blogs_h;
        $content->our_blogs_p = $request->our_blogs_p;
        $content->updates_h = $request->updates_h;
        $content->updates_p = $request->updates_p;
        $content->download_app_h = $request->download_app_h;
        $content->download_app_p = $request->download_app_p;
        $content->contact_us_h = $request->contact_us_h;
        $content->location = $request->location;
        $content->phone = $request->phone;
        $content->email = $request->email;
        $content->footer_p = $request->footer_p;
        $content->copyright = $request->copyright;
        $content->save();

        if($content){
            Session::flash('message', 'ContentSetting Updated Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/content_settings');
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
        $content = ContentSetting::find($id)->forceDelete();
        if($content){
            return view('admin.content.index');
        }
    }

}
