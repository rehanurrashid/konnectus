<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Konnect Us - @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
  <link rel="icon" href="{{asset('images/favicon.png')}}" type="image/gif" sizes="16x16">
</head>
<body>
    <div id="app">

        <!------------------Header Section---------------------------->
        @include('user.templates.header')

        <main>
            @yield('content')
        </main>

         <!------------------Footer Section---------------------------->
        @include('user.templates.footer')
    </div>
</body>
</html>
