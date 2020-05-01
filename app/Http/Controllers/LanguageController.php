<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreLanguage;
use App\Mail\PasswordSentEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\language;
use Mail;



class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $language = Language::select(['id', 'name', 'code', 'created_at', 'updated_at']);
            // dd($language);
            return Datatables::of($language)
                ->addColumn('action', function ($language) {
                    return view('admin.actions.actions_language',compact('language'));
                    })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
       return view('admin.language.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.language.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storelanguage $request)
    {    
        $language = new Language;
        $language->name = $request->name;
        $language->code = $request->code;
        $language->save();

        if($language){
            Session::flash('message', 'Language Created Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/languages');  
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
        return view('admin.language.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $language = language::where('id',$id)->first();
        // dd($language->profile->image);
        return view('admin.language.edit',compact('language'));
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
        $language = language::find($id);
        $language->name = $request->name;
        $language->code = $request->code;
        $language->save();

        if($language){
            Session::flash('message', 'Language Updated Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/languages');  
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
        $language = Language::find($id)->delete();
        if($language){
            return view('admin.language.index');
        }
    }
}
