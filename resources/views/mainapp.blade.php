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
                    <div class="navbar-header">
                        <a class="navbar-brand" href="/">
                            <img id="klugee-logo" src="{{asset('images/klugee-logo.png')}}" alt="tes" width="85" height="85"> 
                        </a>
                    </div>
                </div>
            </nav>
        </header>
        <div class="container">
            <div class="row">
                <img src="{{asset('images/class'}}">
            </div>
        </div>
    </body>
</html>
