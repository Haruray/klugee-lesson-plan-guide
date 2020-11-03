<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

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
                        <li class="nav-item" role="presentation"><a class="nav-link" id="class-selection" href="/home"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Class Selection</a></li>
                    </ul>
                </div><a class="navbar-brand d-sm-none d-md-block d-none" href="#"><img id="logo-nav" src="{{asset('img/klugee-logo.png')}}"></a></div>
        </nav>
        <div>
            <p id="breadcrumb-class">{{$data1->class_name}}</p>
        </div>
        <div class="text-center" id="class-info-block">
            <div class="container">
                <h1 class="text-center" id="class-info-block-heading">Class Members</h1>
                @foreach($data2 as $d)
                <p class="text-uppercase text-center" id="class-info-block-text"><strong>{{$d->name}}</strong></p><a href="/class/{{$data1->user_id}}/{{$data1->id}}/{{$d->id}}/delete"><i id="trash-icon" class="glyphicon glyphicon-trash"></i></a><br/>
                @endforeach
                <div id="button-grouping-in-class-info" class="text-left">
                    <div id="class-info-block-add"> <a class="text-left"  data-toggle="modal" data-target="#addclassmember"><i class="glyphicon glyphicon-plus-sign"></i> Add Student</a><br/></div>
                    <div id="class-info-block-delete"> <a class="text-left" href="/class/{{$data1->user_id}}/{{$data1->id}}/delete" ><i class="glyphicon glyphicon-trash"></i> Delete This Class</a> </div>
                </div>
            </div>
        <!-- MODAL -->
        <div class="modal fade" id="addclassmember" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/addmember" method="post" id="form-classmember">
                    @csrf
                        <div class="form-group">
                            <label for="class">Add New Member On This Class</label>
                            <input type="text" name="classmember" class="form-control" id="classmember" placeholder="Type the name you want to add">
                            <input type="hidden" name="class_id" id="class_id" value="{{$data1->id}}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="form-classmember" value="submit" class="btn btn-primary">Submit</button>
                </div>
                </div>
            </div>
            </div>

        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
    </body>
</html>
