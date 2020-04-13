<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreCategory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){

            $category = Category::select(['id','parent_id', 'name','image','type','created_at', 'updated_at']);
            // dd($category);
            return Datatables::of($category)
                ->addColumn('action', function($category) {
                    return view('admin.actions.actions_category',compact('category'));
                    })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
       return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategory $request)
    {
        $filename ='';

        if ($request['photo']){
            $originalImage= $request->file('photo');
            $request['picture'] = $request->file('photo')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $request['picture'] = asset($request['picture']);
            $filename = $request->file('photo')->hashName();

        }

        $category = new Category;
        $category->parent_id = $request->parent_id;
        $category->name = $request->name;
        $category->type = $request->type;
        $category->image = $request['picture'];
        $category->save();

        if($category){
            Session::flash('message', 'Category Created Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/categories');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $categories = Category::where('parent_id','=',null)->pluck('name', 'id');
        return view('admin.category.edit',compact('category','categories'));
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
        $category = Category::find($id);

        $filename ='';

        if ($request['photo']){
            $originalImage= $request->file('photo');
            $request['picture'] = $request->file('photo')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $request['picture'] = asset($request['picture']);
            $filename = $request->file('photo')->hashName();

        }
        else{
            $filename =$category->image;
        }

        $category->parent_id = $request->parent_id;
        $category->name = $request->name;
        $category->type = $request->type;
        $category->image = $request['picture'];
        $category->save();

        if($category){
            Session::flash('message', 'Category Updated Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/categories');
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
        $category = Category::find($id)->delete();
        if($category){
            return view('admin.category.index');
        }
    }

    public function fetch(Request $request){
        $categories = Category::where('type', '=' ,$request->value)->where('parent_id','=',null)->get();
        $output = '<option value="" selected>Select Parent Category</option>';

        foreach ($categories as $category) {
            $output .= '<option value="'.$category->id.'">'.$category->name.'</option>';
        }

        return $output;
    }
}
