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
        <nav id="navbar" class="navbar navbar-light navbar-expand-md">
            <div class="container"><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav text-center">
                        <li class="nav-item" role="presentation"><a class="nav-link active" id="logout-button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="glyphicon glyphicon-log-out"></i>&nbsp;Logout</a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form></li>
                    </ul>
                    </div><a class="navbar-brand d-sm-none d-md-block d-none" href="#"><img id="logo-nav" src="{{asset('img/klugee-logo.png')}}"></a></div>
        </nav>
        <div class="container">
                <div id="class-image" class="center-block text-center">
                    <img src="{{asset('images/class.png')}}" width="200" height="200">
                </div>
                <h1 id="white" class="text-center">What class do you want to teach?</h1>
                @foreach ($data as $d)
                    <div id="button" class="text-center center-block">
                        <a href="/class/{{$d->user_id}}/{{$d->id}}">
                            <p id="button-text">{{$d->class_name}}<p>
                        </a>
                    </div>
                @endforeach
                <div id="button" class="text-center center-block">
                    <a data-toggle="modal" data-target="#addclass">
                        <p id="button-text"><i class="glyphicon glyphicon-plus"></i> Add Class<p>
                    </a>
                </div>
            </div>

            <!-- MODAL -->
            <div class="modal fade" id="addclass" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/addclass" method="post" id="form-class">
                    @csrf
                        <div class="form-group">
                            <label for="class">Add New Class</label>
                            <input type="text" name="class" class="form-control" id="class" placeholder="Type the class name you want to add">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="form-class" value="submit" class="btn btn-primary">Submit</button>
                </div>
                </div>
            </div>
            </div>
    </body>
</html>
