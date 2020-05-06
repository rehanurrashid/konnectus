
@extends('user.layouts.app')

@section('title', 'Home')

@section('content')

  <section class="main-section">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-6 p-0 m-0">
          <div class="empty"></div>
          <div class="intro-text">
            <h1 class="text-white mb-4">lorem ipsum<br> is simply dummy text</h1>
            <p class="text-white mb-4">Lorem ipsum has been the industry'sstandard dummy <br>
            text ever since the 1500s, when an unknown printer.</p>
            <div class="row container">
             <img class="app-img-1" src="{{asset('images/app store.png')}}">
             <img class="app-img-2" src="{{asset('images/play store.png')}}">
           </div>
         </div>
       </div>
       <div class="col-lg-6 p-0 m-0  ">
        <div class="top-img">
          <img class="w-100 img-fluid" src="{{asset('images/banner phones.png')}}">
        </div>
      </div>
    </div>
  </div>
</section>
<section class="about-us" id="about">
  <div class="margin-1"></div>
  <div class="container">
    <h3 class=" text-center text-capitalize mt-5 mb-3" style="color: #c2236c"><span style="color: #003470;">about </span>us?</h3>
    <p class=" text-center text-muted mb-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text<br>ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.<br>It has survived not only five centuries, but also the leap intod</p>
    <div class="margin-1"></div>
    <div class="row ">
      <div class="col-md-3">
        <div class="back-im">
          <img class="abt-img" src="{{asset('images/aboutbg.png')}}">
          <img class="con-img" src="{{asset('images/connect people.png')}}">
          <p class="text-white text-center text-capitalize p-4">connect people</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="back-im">
          <img class="abt-img" src="{{asset('images/aboutbg.png')}}">
          <img class="con-img" src="{{asset('images/services.png')}}">
          <p class="text-white text-center text-capitalize p-4">Services</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="back-im">
          <img class="abt-img" src="{{asset('images/aboutbg.png')}}">
          <img class="con-img" src="{{asset('images/connect people.png')}}">
          <p class="text-white text-center text-capitalize p-4">connect people</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="back-im">
          <img class="abt-img" src="{{asset('images/aboutbg.png')}}">
          <img class="con-img" src="{{asset('images/secuirty.png')}}">
          <p class="text-white text-center text-capitalize p-4">security check</p>
        </div>
      </div>
    </div>
    <div class="margin-1"></div>
  </div>
</section>
<section class="blogs-section mb-5" id="blogs">
  <div class="container-fluid">
    <div>
      <img class="fone-image-1" src="{{asset('images/half phone.png')}}">
    </div>
    <div class="our-blogs">
      <h3 class="text-center text-white text-capitalize pt-5">our <span class="font-weight-bold">blogs</span></h3>
      <p class=" text-center text-white mb-5" style="font-weight: 300;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text<br>ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.<br>It has survived not only five centuries, but also the leap intod</p>
    </div>
  </div>
  <div class="container">
    <div class="row justify-content-center" style="margin-top: 5rem;">
    @forelse($posts as $post)
      <div class="col-md-4">
        <a href="{{ route('single', [$post->slug]) }}" target="_blank" class="text-white"><h4 class="text-white"> {{$post->topic}} </h4></a>
        <p class="text-white" style="font-weight: 400;">________ {{$post->posted_on}}</p>
        <div class="background-1">
          <img class="w-100 mt-3 mb-5" src="{{$post->image}}">
          <p class="text-white" style="font-weight: 400;">
          @php
          $first10words = implode(' ', array_slice(str_word_count($post->excerpt,1), 0, 25));
          echo $first10words;
          @endphp
        </p>
          <img class="p-2" src="{{asset('images/fb.png')}}">
          <img class="p-2" src="{{asset('images/gmail.png')}}">
          <img  class="p-2"src="{{asset('images/pinterst.png')}}">
          <img class="p-2" src="{{asset('images/twitter.png')}}">
          <p class="text-white text-capitalize" style="font-weight: 300;">----------------------------------------- <a class="text-white text-capitalize " href="{{ route('single', [$post->slug]) }}" target="_blank">Read more</a> </p>
        </div>
      </div>
    @empty
      <div class="col-md-12">
        <h4>No Blogs Posts Yet!</h4>
      </div>
    @endforelse
    </div>
  </div>
  <img class="fone-image-2" src="{{asset('images/Layer 1358.png')}}" style="">
</section>
<section class="get-app" id="news">
  <div class="container">
    <div class="margin-1"></div>
    <h1 class="text-center font-weight-bold" style="color: #003470">Get the latest app updates</h1>
    <p class="text-center text-muted mb-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's</p>
    <div class="row mb-5 justify-content-center">
      <input placeholder="Email" type="text" />
      <button class="btn btn-primary">subscribe</button>
    </div>
    <div class="margin-1"></div>
  </div>
</section>
<section class="download-app">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="text-white text-capitalize pt-5 pb-3">download <span class="font-weight-bold">app now!</span></h2>
        <p class="text-white pb-3">Lorem ipsum has been the industry'sstandard dummy <br>text ever since the 1500s, when an unknown printer.<br>Lorem ipsum has been the industry'sstandard dummy </p>
        <div class="row ">
          <img class="app-img-3" src="{{asset('images/playstore2.png')}}">
          <img class="app-img-4" src="{{asset('images/playstore2.png')}}">
        </div>
      </div>
      <div class="col-md-6 p-0 m-0">
        <img class="img-dwnldapp-1" src="{{asset('images/app-1.png')}}">
        <img class="img-dwnldapp-2" src="{{asset('images/app-2.png')}}">
      </div>
    </div>
  </div>
</section>
<section class="contact-section" id="contact">
  <div class="container">
    <div class="margin-1"></div>
    <h3 class="text-capitalize mt-5 mb-5"><span style="color: #003470;">contact </span><span style="color: #c2236c;">us</span></h3>
    <div class="row">
      <div class="col-md-7">
        <form>
          <label class="text-muted  pt-5 pr-3">Name</label>
          <input placeholder="" type="text" style="width: 80%;" /><br>
          <label class="text-muted pt-5 pr-3">Email</label>
          <input placeholder="" type="text" style="width: 80%;" /><br>
          <label class="text-muted  pt-5">Subjects</label>
          <input placeholder="" type="text" style="width: 80%;" />
          <button class="btn btn-primary mt-5 mb-5">Send</button>
        </form>
      </div>
      <div class="col-md-5">
        <ul>
          <li><img class="p-3" src="{{asset('images/loc.png')}}" class="info-imgs"><span class="text-muted text-capitalize"> 100 proctor st. usa</span></li>
          <li><img class="p-3" src="{{asset('images/phone.png')}}" class="info-imgs"><span class="text-muted text-capitalize"> +113-804-9098</span> </li>
          <li><img class="p-3" src="{{asset('images/mail.png')}}" class="info-imgs"><span class="text-muted text-capitalize"> contact@konnectus.com</span> </li>
          <div class="row mt-4 pl-3 ">
            <img class="p-3" src="{{asset('images/fb footer.png')}}" class="info-imgs">
            <img class="p-3" src="{{asset('images/google footer.png')}}" class="info-imgs">
            <img class="p-3" src="{{asset('images/pinterst footer.png')}}" class="info-imgs">
          </div>
        </ul>
      </div>
    </div>
  </div>
</section>

@endsection