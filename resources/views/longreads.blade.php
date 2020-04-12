<!DOCTYPE html>
<html>
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

        <script type="text/javascript" src="{{ asset('js/longreadsPageScript.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/longreadsPageStyle.css') }}" />

    </head>
    <body>
        <div class="header">
            
        </div>
        <div class="main">
            <h5>Ваши лонгриды</h5>
            <div class="list">
                <!-- <div ng-repeat="curLongread in longreads track by $index"> -->
                    <!-- <a href="longread/@{{ curLongread.id }}">@{{ curLongread.title }}</a> -->
                    @foreach ($data as $longread)
                        <div class="longread">
                            <div class="title"><a href="longread/{{ $longread->id }}">{{ $longread->title }}</a></div>
                            <div class="editBTN">
                                <div><a href = 'longread/{{ $longread->id }}'><img src="{{ asset('icons/edit.svg') }}">Редактировать</a></div>
                                <!-- <div><a href = 'delete/{{ $longread->id }}'><img src="{{ asset('icons/garbage.svg') }}"></a></div> -->
                                <div><a href = 'settings/{{ $longread->id }}'><img src="{{ asset('icons/settings.svg') }}"></a></div>
                            </div>
                        </div>
                    @endforeach 
                <!-- </div> -->
            </div>
        </div>
    </body>
</html>