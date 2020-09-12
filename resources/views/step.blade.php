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
        <link rel="stylesheet" type="text/css" href="{{ asset('css/styles_admin.css') }}">
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{asset('js/script.js')}}"></script>

    </head>
    <body>
    <div id="app">
        <header>
            <nav id="navbar" class="nav navbar-default">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                </div>
            </nav>
        </header>
        <div class="container">
            <div class="row">
            <h1 id="white" class="text-center"></h1>
                <div id="welcome-card" class="jumbotron text-center">
                    <p id="welcome-card-text">Write Your Lesson Plan!</p>
                    <img id="welcome-card-image" class="visible-lg visible-md" src="{{asset('images/icon_grade_6.png')}}" height='400' width='400'>
                </div>
                <div id="form" class="col-md-push-8">
                    <h1 id="white" class="text-center text-bold">{{$backup[0]}} : {{$backup[1]}}</h1>
                    <h3 id="white" class="text-center">{{$backup[2]}} : {{$backup[3]}}</h3><br/>
                    @foreach ($data as $d)
                    <div id="syllabus-item">
                        @if (!(is_null($d->step)))
                        <p id="syllabus-item-text"><strong>Step {{$loop->iteration}}</strong></p>
                        <a href="/admin/syllabus/deleteLesson/{{$d->id}}">
                            <span id="delete-button" class="glyphicon glyphicon-trash"></span>
                        </a>
                    </div>
                    <div id="unit-item" class="syllabus-unit">
                        <p id="syllabus-item-step-text">{{$d->step}}</p>
                    </div>
                        @endif
                    @endforeach
                    <button id="button-add" type="button" class="btn" aria-label="Left Align" data-toggle="modal" data-target="#exampleModalCenter">
                        <span style="color:white"class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span><span style="color:white" id="button-add-text">Add new step</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/admin/syllabus/addstep" method="post" id="form-step">
                    @csrf
                        <div class="form-group">
                            <label for="topic">Add New Step</label>
                            <textarea form="form-step" name="step" class="form-control" id="step" placeholder="Type the step you want to add"></textarea>
                            <input type="hidden" name="topic" value="{{$backup[0]}}">
                            <input type="hidden" name="unit" value="{{$backup[1]}}">
                            <input type="hidden" name="lesson" value="{{$backup[2]}}">
                            <input type="hidden" name="phase" value="{{$backup[3]}}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="form-step" value="submit" class="btn btn-primary">Submit</button>
                </div>
                </div>
            </div>
            </div>
    </div>
    </body>
    </html>