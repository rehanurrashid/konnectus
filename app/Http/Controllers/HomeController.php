<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->isMethod('post')){
            $api_token= Str::random(80);
            $user = $request->user();
            $user->api_token = hash('sha256',$api_token);
            $user->save();  
            return redirect('/home')->with('api_token',$api_token);
        }
    
        return view('admin.home');
    }
}
