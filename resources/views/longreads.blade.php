<!DOCTYPE html>
<html ng-app="webLongread">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <div class="main" >
            <div class="titleSection">
                <h5>Ваши лонгриды</h5>
                <div><button class="addBTN" ng-click="addLongread()"><img src="{{ asset('icons/add.svg') }}">НОВЫЙ ЛОНГРИД</button></div>
            </div>
            
            <div class="list" ng-init="init()">
           
                <div ng-repeat="curLongread in longreads track by $index" class="longread-wrapper">     
                    <div class="longread longread-hover">
                        <div class="img_block"><img src="@{{images[$index][0].src}}"></div>
                        <div class="title"><a href="longread/@{{ curLongread.id }}" ng-click="save()">@{{curLongread.title}}</a></div>
                        <div class="editBTN">
                                <div class="edit"><a href = 'longread/@{{ curLongread.id }}' ng-click="save()">РЕДАКТИРОВАТЬ</a></div>
                                <div class="img_btn">
                                    <div ng-click="openPublish($index)"><img src="{{ asset('icons/publish.svg') }}"></div>
                                    <div ng-click="openSettings($index)"><img src="{{ asset('icons/settings.svg') }}"></div>
                                </div>
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
                <div class="popup ng-cloak">
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
                            <div class="form-group" id = "7">
                                <label>URL адрес</label></br>
                                <div class="form-group2">
                                    <label for="n" ng-style="{'font-weight': 500}">@{{documentLocation}}/</label>
                                    <input id="n" name="title_longread" placeholder="titleLongread" ng-model="settingsLongread.url" ng-blur="changedURL()">
                                </div>
                                <p class="error" ng-if="showErrorExist">Введенный адрес уже существует. Введите, пожалуйста, другой</p>
                                <p class="error" ng-if="showErrorValue">Вы не ввели адрес. Введите, пожалуйста, еще раз</p>
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
                                                <div class="curImg_btn" ng-click="deleteImage($index)"><img src="{{ asset('icons/garbage.svg') }}"></div>
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

            <div class="overlay" ng-if="statusPublish">
                <div class="popup ng-cloak">
                    <div class="close" ng-click="closePublish()" ng-style="{ 'width': '2.5%'}"><img src="{{ asset('icons/close.svg') }}"></div>
                    <div class="form_style" ng-if="!published"> 
                        <h3>Публикация лонгрида</h3>
                        <p>Введите адрес страницы для вашего лонгрида</p>
                        <p class="error" ng-if="showErrorExist">Введенный адрес уже существует. Введите, пожалуйста, другой</p>
                        <p class="error" ng-if="showErrorValue">Вы не ввели адрес. Введите, пожалуйста, еще раз</p>
                        <div class="form-group2">
                            <label for="n">@{{documentLocation}}/</label>
                            <input id="n" name="title_longread" placeholder="titleLongread" ng-model="settingsLongread.url">
                        </div>
                        <button ng-if="!showLongread" class="publishBTN" ng-click="publishLongread()">Опуликовать</button>
                        <a href="/view/@{{settingsLongread.url}}" target="_blank" class="publishBTN" ng-if="showLongread">Показать лонгрид</a>
                    </div>
                    <!-- @{{published}} -->
                    <div class="form_style" ng-if="published"> 
                        <h3>Публикация лонгрида</h3>
                        <p>Адрес вашего опубликованного лонгрида</p>
                        <div class="form-group2">
                            <label for="n">@{{documentLocation}}/@{{longreads[pubLong]['url']}}</label>
                        </div>
                        <a href="/view/@{{longreads[pubLong]['url']}}" target="_blank" class="publishBTN" ng-if="showLongread">Показать лонгрид</a>
                    </div>
                </div>
            </div>


            
        </div>
    </body>
</html>