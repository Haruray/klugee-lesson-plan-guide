<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Klugee Syllabus</title>
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"> 
        <link rel="stylesheet" href="https://use.typekit.net/lay2hum.css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/script.js')}}"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>

    </head>
    <body>
        <header>
            <nav id="navbar" class="nav navbar-default">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header navbar-right">
                        <a class="navbar-brand" href="/">
                            <img id="klugee-logo" src="{{asset('images/klugee-logo.png')}}" alt="tes" width="85" height="85"> 
                        </a>
                    </div>
                    
                </div>
            </nav>
        </header>
        <div class="container">
            <div class="row">
                <h1 id="yellow" class="text-center">Welcome</h1>
                <h1 id="white" class="text-center">Teachers!</h1>
                    <div id="button" class="text-center center-block">
                        <a href="{{route('login')}}">
                            <p id="button-text">Sign in<p>
                        </a>
                    </div>
               
                
                    <div id="button" class="text-center center-block">
                        <a href="{{route('register')}}">
                            <p id="button-text">Sign up</p>
                        </a>
                    </div>
               
            </div>

        </div>
        <script id="__bs_script__">//<![CDATA[
    document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.26.12'><\/script>".replace("HOST", location.hostname));
//]]></script>
    </body>
</html>
