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

<body id="step-page">
    <nav class="navbar navbar-light navbar-expand-md">
        <div class="container"><button class="navbar-toggler" data-toggle="collapse"></button></div>
    </nav>
    <div class="container">
        <div>
            <div id="buttons-step"><a href="/class/{{$classdata['user_id']}}/{{$classdata['class_id']}}/steps/{{$data->id}}/prev"><span id="arrow" class="glyphicon glyphicon-arrow-left"></span></a></i>
            <a href="#"><i class="fa fa-sign-out" id="logout-button"></i></a></div>
            <h2 class="pulse animated" id="custom-breadcrumb-text">{{$backupdata->unit}}</h2>
            <h3 class="pulse animated" id="custom-breadcrumb-text">{{$backupdata->lesson}}</h3>
            <p class="flash animated" id="custom-breadcrumbs-steps">{{strtoupper($data->phase)}}</p>
        </div>
        <div id="main-content">
            <h4 data-aos="fade-right" data-aos-once="true" id="step-title">Step {{$classdata['stepnumber']}}</h4>
            <p data-aos="fade-right" data-aos-once="true" id="step-text">{{$data->step}}</p>
            <a
                href="/class/{{$classdata['user_id']}}/{{$classdata['class_id']}}/steps/{{$data->id}}/next"><span class=" glyphicon glyphicon-ok " data-bs-hover-animate="tada" id="check"></span></a>
        </div>
    </div>
    
    <script src="{{asset('js/bs-init.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
</body>

</html>