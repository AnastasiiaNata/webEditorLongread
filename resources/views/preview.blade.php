<!DOCTYPE html>
<html ng-app="webPreview">
<head>
	<title></title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <script src="{{asset('js/lib/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/lib/jquery-3.4.0.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/lib/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/lib/jasny-bootstrap.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/lib/angular.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/lib/angular-resource.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/lib/angular-sanitize.min.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/jasny-bootstrap.min.css') }}">
        
    <script type="text/javascript" src="{{ asset('js/previewPageScript.js') }}"></script><!-- 
    <link rel="stylesheet" type="text/css" href="{{ asset('css/edittingPageStyle.css') }}" /> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/templates_css/templatesStyle.css') }}" />
</head>
<body ng-controller="PreviewController" ng-init="init({{$longreadId}})">
	<div ng-repeat="curTempl in curTempls track by $index">
		@{{ curTempl }}
		<div ng-include="curTempl.fileName"></div>
		
	</div>
</body>
</html>