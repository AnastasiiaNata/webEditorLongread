<!DOCTYPE html>
<html ng-app="webLongread">
    <head>
        <meta charset="utf-8">

        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
        <script src="{{asset('js/lib/popper.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('js/lib/jquery-3.4.0.min.js')}}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('js/lib/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/jasny-bootstrap.min.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/jasny-bootstrap.min.css') }}">      

        <script type="text/javascript" src="{{ asset('js/lib/angular.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/angular-resource.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/angular-sanitize.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/angular-animate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/ui-bootstrap-tpls-2.5.0.js') }}"></script>

        <script type="text/javascript" src="{{ asset('js/longreadsPageScript.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/longreadsPageStyle.css') }}" />

    </head>
    <body ng-controller="LongreadController">
        <div class="header">
            <div><a href="/"><h2>ВЫЙТИ</h2></a></div>
        </div>
        <div class="main">
            <div class="titleSection">
                <h5>Ваши лонгриды</h5>
                <div><button class="addBTN" ng-click="addLongread()"><img src="{{ asset('icons/add.svg') }}">НОВЫЙ ЛОНГРИД</button></div>
            </div>
            
            <div class="list" ng-init="init({{$data}})">
           
                <div ng-repeat="curLongread in longreads track by $index" class="longread-wrapper">     
                    <div class="longread">
                        <div class="img_block"><img src="@{{images[$index][0].src}}"></div>
                        <div class="title"><a href="longread/@{{ curLongread.id }}">@{{curLongread.title}}</a></div>
                        <div class="editBTN">
                                <div><a href = 'longread/@{{ curLongread.id }}'>РЕДАКТИРОВАТЬ</a></div>
                                <div ng-click="openSettings($index)"><img src="{{ asset('icons/settings.svg') }}"></div>
                        </div>
                    </div>
                        
                </div>
                <div class="longread-wrapper" ng-click="addLongread()">
                    <div class="longread">
                        <div class="new" ><img src="{{ asset('icons/new.svg') }}"></div>
                    </div>
                </div>
            </div>


            <div class="overlay" ng-if="statusSettings">
                <div class="popup">
                    <div class="tabs">
                        <button ng-repeat="curSet in settings track by $index" ng-click="openSet($index)">@{{ curSet.title }}</button>
                    </div>
                    <div class="close" ng-click="closeSettings()" ng-style="{ 'width': '2.5%'}"><img src="{{ asset('icons/close.svg') }}"></div>
                    <div class="content">  
                        <div class="form_style" ng-if="status['main']">
                            <h5>Основные настройки</h5>
                            <div class="form-group" id = "7">
                                <label>Наименование лонгрида</label></br>
                                
                                    <input class="inputContent" type="text" name="title" ng-model="longreads[curLong].title">
                            </div>
                            <div class="form-group" id = "23" >
                                <label>Изображение</label></br>
                                <div>
                                    <div>
                                        <button class="loadBTN" ng-click="loadImage()">Загрузить изображение</button>
                                        <div ng-if="loadImg" class="loadImg">
                                            <form enctype="multipart/form-data" method="post" class="inputfile">
                                                {{ csrf_field() }}
                                                <input type="file" id="file"  ng-files="getTheFiles($files)" accept=".jpg, .jpeg, .png"/>
                                                <label for="file" class="btn-1"><span>Выбрать файл</span></label>
                                            </form> 
                                        </div>
                                        <div ng-repeat="curImg in images[curLong] track by $index" class="curImgs">
                                            <div class="curImg">
                                                <div class="curImg_img"><img ng-src="@{{ curImg.src }}"></div>
                                                <div class="curImg_text"><p>@{{ curImg.title }}</p></div>
                                                <div class="curImg_btn" ng-click="deleteImg($index)"><img src="{{ asset('icons/garbage.svg') }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="saveBTN" ng-click="save()">Сохранить настройки</button>
                        </div>

                        <div class="form_style"  ng-if="status['action']">
                          <h5>Действия</h5>
                          <button class="deleteBTN" ng-click="deleteLongread()">Удалить лонгрид</button>
                        </div>
                    </div>
                </div>
            </div>




            
        </div>
    </body>
</html>