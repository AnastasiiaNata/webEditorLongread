<!DOCTYPE html>
<html ng-app="webEditor">
    <head>
        <meta charset="utf-8">

        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
        <script src="{{asset('js/lib/popper.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/lib/jquery-3.4.0.min.js')}}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('js/lib/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/jasny-bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('../node_modules/angular/angular.min.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/jasny-bootstrap.min.css') }}">

        <script type="text/javascript" src="{{ asset('js/edittingPageScript.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/edittingPageStyle.css') }}" />

    </head>
    <body>
        <h5>Ваши лонгриды</h5>
        @foreach ($data as $longread)
            <a href="longread/{{ $longread->id }}">{{ $longread->title }}</a>
        @endforeach 
    </body>
</html>