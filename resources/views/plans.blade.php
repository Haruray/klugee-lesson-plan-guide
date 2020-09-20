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
        <header>
            <nav id="navbar" class="nav navbar-default">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header navbar-right">
                        <a class="navbar-brand" href="/">
                            <img id="klugee-logo" src="{{asset('images/klugee-logo.png')}}" alt="tes" width="85" height="85"> 
                        </a>
                    </div>
                    <div class="navbar-nav navbar-left">
                        @guest
                        @else
                        <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <button id="nav-button" type="button" class="btn btn-danger" aria-label="Left Align">
                                            <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout
                                        </button>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                        @endguest
                    </div>
                </div>
            </nav>
        </header>
        <div class="container">
            <div class="row">
                <span id="left-corner">
                </span>
                <div id="custombreadcrumb" class="text-center center-block">
                    <div id="breadcrumb-class">{{$classdata['class_name']}}</div>
                    <div id="breadcrumb-text"></div>
                </div>
                <div id="class-image" class="center-block text-center">
                    <h1 id="white"><strong>What do you want to teach?</strong></h1>
                </div>
                <div id="content">
                @foreach ($data as $d)
                
                    <div id="button" class="text-center center-block">
                        <a onclick="$dc.fetchSelection('topic','{{$d->topic}}','{{$classdata['user_id']}}','{{$classdata['class_id']}}')">
                            <p id="button-text">{{$d->topic}}<p>
                        </a>
                    </div>
                
                @endforeach
                </div>
            </div>
        </div>
    </body>
</html>
