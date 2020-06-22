<!DOCTYPE html>
<html ng-app="webPreview" ng-controller="PreviewController" ng-init="init({{$longread}}, {{$previewStatus}})">
<head>
	
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
        <script src="{{asset('js/lib/popper.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/lib/jquery-3.4.0.min.js')}}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('js/lib/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/jasny-bootstrap.min.js') }}"></script>

        <script type="text/javascript" src="{{ asset('js/lib/angular.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/angular-resource.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/angular-sanitize.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/angular-route.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/angular-animate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/TweenMax.min.js') }}"></script>
        
        <link rel="stylesheet" type="text/css" href="{{ asset('css/templates_css/templatesStyle.css') }}" />
        <script type="text/javascript" src="{{ asset('js/previewPageScript.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/previewPageStyle.css') }}" />

        <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/owlcarousel/owl-carousel.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/owlcarousel/owl-theme.css') }}">
        <script src="{{asset('js/lib/jquery-3.4.0.min.js')}}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('js/lib/owlcarousel/owl-carousel.min.js') }}"></script>

        <title>@{{ curlongread['title'] }}</title>
        <link rel="shortcut icon" type="image/x-icon" href="@{{ curlongread['parameters']['favicon'][0]['src'] }}">
        
</head>
<body>
	<div ng-repeat="curTempl in curTempls track by $index">
                <div ng-include="curTempl.fileName"></div>	
	</div>
        <div ng-if="statusButtom" class="overlay">
                <div><a href="../@{{curlongread['id']}}" class="returnBTN" ng-click="returnEdit()"><img src="{{ asset('icons/return.svg') }}">К РЕДАКТИРОВАНИЮ</a></div>
        </div>

</body>
</html>