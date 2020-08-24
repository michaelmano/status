<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-title" content="Reception Status">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Status</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,600" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="Body">
    <div id="app" class="Admin">
        @if (session('status'))
            {{ session('status') }}
        @endif
        <div class="Admin__header">
            <img src="{{ asset('images/logo.svg') }}" alt="" class="Admin__logo">
            @guest
                <a class="Button" href="{{ route('login') }}">Login</a>
            @else
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    <button class="Button Button--medium" type="submit">Logout</a>
                    {{ csrf_field() }}
                </form>
            @endguest
        </div>
        @yield('content')
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js" integrity="sha256-eVNjHw5UeU0jUqPPpZHAkU1z4U+QFBBY488WvueTm88=" crossorigin="anonymous"></script>
    <script src="{{ mix('js/app.js') }}" charset="utf-8"></script>
</body>
</html>
