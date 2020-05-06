<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use App\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {   
        if (Auth::check() && auth()->user()->role == 'admin') {
            return redirect('admin/dashboard');
        }
        else{
            return redirect('admin/login');
        }
    }

    public function home(Request $request)
    {   
        $posts = Post::latest()->limit(3)->get();

        foreach ($posts as $post) {

            $created = new Carbon($post->created_at);
            $now = Carbon::now();
            $posted_on = ($created->diff($now)->days < 1)
            ? 'today'
            : (($created->diff($now)->days > 7) ? $created->format('M d Y') : $created->diffForHumans()) ;
            $post->posted_on = $posted_on;

        }

        return view('user.pages.home', compact('posts'));
    }

    public function single($slug)
    {   
        $post = Post::where('slug','=', $slug)->first();

        $created = new Carbon($post->created_at);
            $now = Carbon::now();
            $posted_on = ($created->diff($now)->days < 1)
            ? 'today'
            : (($created->diff($now)->days > 7) ? $created->format('M d Y') : $created->diffForHumans()) ;
            $post->posted_on = $posted_on;
            
        return view('user.pages.single',compact('post'));
    }
}
