@extends('user.layouts.app')

@section('title', 'Blogs')

@section('content')

  <section class="banner-sec mb-5">
    <div class="container">
      <h2 class="text-center text-white blogs-b">Our Blogs</h2>
      <h5 class="text-center text-white hy-link">Home > Blogs</h5>
    </div>
  </section>
  <section class="content-sec">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <h3>{{ $post->topic }}</h3>
          <p>________ {{$post->posted_on}}</p>
          <img class="w-100 pb-5" src="{{$post->image}}">
          <div class="row">

            @php  $tags = explode(",", $post->tags) @endphp
              @foreach( $tags as $tag)
                  <div href="#" class="hashtag text-center {{ ($loop->iteration == 1) ? 'ml-3' : '' }} ">
                      #{{$tag}}
                 </div>
              @endforeach

          </div>
          <div class="mt-4">
            {!!$post->description!!}
          </div>
        </div>
        <div class="col-md-4 p-3">
          <h4 class="text-capitalize mb-4">Popular posts</h4>
        @forelse($popular_posts as $post)
          <div class="row pb-4">
            <div class="col-md-2 p-0 m-0">
              <img class="blg-img rounded-circle" src="{{$post->image}}" width="72px" height="72px">
            </div>
            <div class="col-md-10 ">
              <a href="{{ route('single', [$post->slug]) }}" target="_blank" style="color: #212529;"><h6> {{$post->topic}}</h6></a>
              <span class="text-teal">{{$post->posted_on}} __________</span>
            </div>
          </div>
        @empty
          <div class="row pb-4">
            <div class="col text-center">
              <h5 >No Popular Posts!</h5>
            </div>
          </div>
        @endforelse

          <h4 class="text-capitalize pb-4 ">Recent post</h4>
        @forelse($recent_posts as $post)
          <div class="row pb-4">
            <div class="col-md-2 p-0 m-0">
              <img class="blg-img rounded-circle" src="{{$post->image}}" width="72px" height="72px">
            </div>
            <div class="col-md-10 ">
              <a href="{{ route('single', [$post->slug]) }}" target="_blank" style="color: #212529;"><h6> {{$post->topic}}</h6></a>
              <span class="text-teal">{{$post->posted_on}} __________</span>
            </div>
          </div>
        @empty
          <div class="row pb-4">
            <div class="col text-center">
              <h5 >No Recent Posts!</h5>
            </div>
          </div>
        @endforelse
          <div class="fancy-div-2" style="background-color: #F5F5F5; width: 100%; height: 17rem; margin-top: 2rem;">
            <h6 class="text-capitalize text-muted text-center pt-3">Follows us</h6>
            <h6 class="text-capitalize text-muted text-center pt-3">News letter</h6>
            <h6 class="text-muted text-center mb-4  ">Fill your email below to subscribe<br> to my newsletter</h6>
            <form>
              <center>
                <input type="text" name="email" placeholder="Email" class="form-control" style="width: 85%;">
                <button class="btn btn-default" style="width: 85%; background-color:  #003470; color: white; margin-top: 10px; border: none; border-radius: 0;">Subscribe</button>
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection