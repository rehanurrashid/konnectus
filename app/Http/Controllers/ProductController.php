<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\Storeproduct;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Category;
use App\Product;
use App\User;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){

            $product = Product::with(['user:id,name'])->get();
            return Datatables::of($product)
                ->addColumn('action', function ($product) {
                    return view('admin.actions.actions_product',compact('product'));
                    })
                ->addColumn('user_name', function ($product) {
                    return $product->user->name;
                    })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
       return view('admin.product.index');
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
        return view('admin.product.create',compact('user','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {     
        if ($request['photo']){
            
            $request['picture'] = $request->file('photo')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $request['picture'] = asset($request['picture']);
            $filename = $request->file('photo')->hashName();
        }

        $product = new Product;
        $product->user_id = $request->user_id;
        $product->category_id = $request->category_id;
        $product->setAttribute('slug', $request->title);
        $product->title = $request->title;
        $product->tags = $request->tags;
        $product->description = $request->description;
        $product->image = $filename;
        $product->save();

        if($product){
            Session::flash('message', 'Product Created Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/products');
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
        $product = Product::find($id);
        $user = User::pluck('name','id');
        $category = Category::pluck('name', 'id');
        return view('admin.product.edit',compact('product','user','category'));
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
        $product = product::find($id);
         if($request->hasFile('photo')){
            //storing image
            
            $request['picture'] = $request->file('photo')->store('public/storage');
            $request['picture'] = Storage::url($request['picture']);
            $request['picture'] = asset($request['picture']);
            $filename = $request->file('photo')->hashName();
         }
         else{
            $filename = $product->image;
         }

        $product->user_id = $request->user_id;
        $product->category_id = $request->category_id;
        $product->setAttribute('slug', $request->title);
        $product->title = $request->title;
        $product->tags = $request->tags;
        $product->description = $request->description;
        $product->image = $filename;
        $product->save();

        if($product){
            Session::flash('message', 'Product Updated Successfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/products');
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
        $product = Product::find($id)->delete();
        if($product){
            return view('admin.product.index');
        }
    }
}
