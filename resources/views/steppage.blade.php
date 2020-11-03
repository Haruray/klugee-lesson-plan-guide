<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Getting Started</title>
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/styles_steppage.css')}}">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/script.js')}}"></script>
</head>
@if ($classdata['isstepdone'])
<body id="step-page-done">
    <nav id="navbar-done" class="navbar navbar-light navbar-expand-md">
@else
<body id="step-page">
    <nav id="navbar" class="navbar navbar-light navbar-expand-md">
@endif
            <div class="container"><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav text-center">
                        <li class="nav-item" role="presentation"><a class="nav-link active" id="logout-button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="glyphicon glyphicon-log-out"></i>&nbsp;Logout</a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="material-selection" href="/class/{{$classdata['user_id']}}/{{$classdata['class_id']}}"><i class="glyphicon glyphicon-home"></i>&nbsp;Material Selection</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="class-info" href="/class/{{$classdata['user_id']}}/{{$classdata['class_id']}}/info"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Class Info</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="class-selection" href="/home"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Class Selection</a></li>
                    </ul>
                </div></div>
        </nav>
    <div class="container">
        <div>
            <div id="buttons-step"><a href="/class/{{$classdata['user_id']}}/{{$classdata['class_id']}}/steps/{{$data->id}}/prev"><span id="arrow" class="glyphicon glyphicon-arrow-left"></span></a></i>
            <h2 class="pulse animated" id="custom-breadcrumb-text">{{$backupdata->unit}}</h2>
            <h3 class="pulse animated" id="custom-breadcrumb-text">{{$backupdata->lesson}}</h3>
            <p class="flash animated" id="custom-breadcrumbs-steps">{{strtoupper($data->phase)}}</p>
        </div>
        <div id="main-content">
            <h4 id="step-title">Step {{$classdata['stepnumber']}}</h4>
            <div id="step-text">{!!$data->step!!}</div>
            <a
                href="/class/{{$classdata['user_id']}}/{{$classdata['class_id']}}/steps/{{$data->id}}/next"><span class=" glyphicon glyphicon-ok " data-bs-hover-animate="tada" id="check"></span></a>
        </div>
    </div>
    
    <script src="{{asset('js/bs-init.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
</body>

</html>