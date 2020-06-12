<div class="margin-1"></div>
<footer style="background-image: url( '{{ (!empty($content->footer_bg_image)) ? $content->footer_bg_image : '../images/footerbackground.png' }}' )">
  <div class="container">
    <div class="row p-3">
      <div class="col-md-5">
        <img class="img-f foot-marg" src="{{ (!empty($content->footer_logo)) ? $content->footer_logo : asset('images/KonnectUsLogowhite.png') }}">
        <p class="text-white img-f mt-2">
          @php
              echo wordwrap($content->footer_p,40,"<br>\n");
              @endphp
        </p>
      </div>
      <div class="col-md-5 ">
        <h5 class="text-white text-capitalize usefull foot-marg img-f">useful links</h5>
        <ul>
          <li class="p-1 text-white pl-5 foot-link"><a class="text-nav" href="#home">Home</a></li>
          <li class="p-1 text-white pl-5 foot-link"><a class="text-nav" href="#about">About</a></li>
          <li class="p-1 text-white pl-5 foot-link"><a class="text-nav" href="#blogs">Blogs</a></li>
          <li class="p-1 text-white pl-5 foot-link"><a class="text-nav" href="#news">News Letter</a></li>
          <li class="p-1 text-white pl-5 foot-link"><a class="text-nav" href="#contact">Contact</a></li>
        </ul>
      </div>
      <div class="col-md-2 ">
        <h5 class="text-white foot-link foot-marg">Download Links</h5>
        <img class="img-ffoter" src="{{asset('images/google.png')}}">
        <br>
        <img class="img-ffoter" src="{{asset('images/apple.png')}}">
      </div>
    </div>
  </div>
</footer>
<div class="copyright-div pt-3 pb-2" style="background-color: black;">
  <div class="container">
      <p class="text-white text text-capitalize">
        {{ $content->copyright}}
      </p>
</div>