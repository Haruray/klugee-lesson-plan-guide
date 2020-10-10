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
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
        
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/script.js')}}"></script>
        
    </head>
    <body>
        <div class="container">
        <div id="header"><img id="logo" src="{{asset('img/klugee-logo.png')}}">
            <h1 id="head">You're done with this lesson!</h1>
        </div>
        <div>
            @if ($data['prevlesson']!=99969)
            <a id="prev" href="/class/{{$data['user_id']}}/{{$data['class_id']}}/steps/{{$data['prevlesson']}}"><i class="glyphicon glyphicon-chevron-left"></i>&nbsp;Previous</a>
            @endif
            @if ($data['nextlesson']!=99969)
            <a id="next" href="/class/{{$data['user_id']}}/{{$data['class_id']}}/steps/{{$data['nextlesson']}}">Next<i class="glyphicon glyphicon-chevron-right"></i></a></div>
            @endif
            <a id="home" href="/class/{{$data['user_id']}}/{{$data['class_id']}}"><i class="glyphicon glyphicon-home" id="home-icon"></i><p id="home-text">Home</p></a>
        </div>
    </body>
    </html>