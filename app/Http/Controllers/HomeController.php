<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\ContentSetting;
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
        $content = ContentSetting::first();
        foreach ($posts as $post) {

            $created = new Carbon($post->created_at);
            $now = Carbon::now();
            $posted_on = ($created->diff($now)->days < 1)
            ? 'today'
            : (($created->diff($now)->days > 7) ? $created->format('M d Y') : $created->diffForHumans()) ;
            $post->posted_on = $posted_on;

        }

        return view('user.pages.home', compact('posts','content'));
    }

    public function single($slug)
    {   
        $popular_posts = Post::latest()->limit(3)->get();
        $recent_posts = Post::latest()->limit(3)->get();

        $post = Post::where('slug','=', $slug)->first();

        $now = Carbon::now();
        $created = new Carbon($post->created_at);
            
        $posted_on = ($created->diff($now)->days < 1)
        ? 'today' : (($created->diff($now)->days > 7) ? $created->toFormattedDateString() : $created->diffForHumans()) ;
        $post->posted_on = $posted_on;
        
        foreach ($recent_posts as $recent_post) {
            $created = new Carbon($recent_post->created_at);
            $posted_on = ($created->diff($now)->days < 1)
            ? 'today'
            : (($created->diff($now)->days > 7) ? $created->toFormattedDateString() : $created->diffForHumans()) ;
            $recent_post->posted_on = $posted_on;
        }

        foreach ($popular_posts as $popular_post) {
            $created = new Carbon($popular_post->created_at);
            $posted_on = ($created->diff($now)->days < 1)
            ? 'today'
            : (($created->diff($now)->days > 7) ? $created->toFormattedDateString() : $created->diffForHumans()) ;
            $popular_post->posted_on = $posted_on;
        }

        return view('user.pages.single',compact('post','popular_posts','recent_posts'));
    }
}
