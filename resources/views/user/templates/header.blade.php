<section class="nav-b-section">
    <nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
      <div class="container">
        <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('images/LogoMap.png')}}"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item {{ (request()->is('/')) ? 'active' : '' }}">
              <a class="nav-link text-nav mr-5" href="{{route('home')}}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item {{Request::is('about') ? 'active' : ''}}">
              <a class="nav-link text-nav mr-5" href="#about">About</a>
            </li>
            <li class="nav-item {{ (request()->is('blog')) ? 'active' : '' }}">
              <a class="nav-link text-nav mr-5" href="#blogs">Blogs</a>
            </li>
            <li class="nav-item {{Request::is('news') ? 'active' : ''}}">
              <a class="nav-link text-nav mr-5" href="#news">News Letter</a>
            </li>
            <li class="nav-item {{Request::is('contact') ? 'active' : ''}}">
              <a class="nav-link text-nav mr-5" href="#contact">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </section>