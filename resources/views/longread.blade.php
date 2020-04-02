<!DOCTYPE html>
<html ng-app="webEditor">
    <head>
        <meta charset="utf-8">

        <title>LongreadDev</title>
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

        <script type="text/javascript" src="{{ asset('js/edittingPageScript.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/edittingPageStyle.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/templates_css/templatesStyle.css') }}" />

    </head>
    <body ng-controller="TemplController">
        <div class="header">
            <nav class="navbar navbar-expand">
                <div class="collapse-right navbar-collapse">
                    <ul class="navbar-nav mr-4">
                        <li class="nav-item"><button class="btn button mr-5" ng-click="saveTemples({{$longreadId}})">Сохранить</button></li>
                        <li class="nav-item"><button id="butView" class="btn button mr-5">Предпросмотр</button></li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="wrapper">
            <div class="menu" ng-class = "{menu_active: statusLibrary}">
                <div class="menu-header">
                    <div class="menu-header-title"><h5>Библиотека шаблонов</h5></div>
                    <div class="menu-btn" ng-click="closeLibrary()"><img src="{{ asset('icons/close.svg') }}"></div>
                </div>
                <div class="menu-list" ng-repeat="template in templates">
                    <div ng-click="addTemple($index)" templId=$index><h6>@{{template.title}}</h6></div>
                </div>
            </div>



            <div class="menu" ng-class = "{menu_active: statusStyleSection}">
                <div class="styleSection">
                    <div class="block1" id = "1">
                        <div class="menu-header">
                            <div class="menu-header-title"><h5>Оформление</h5></div>
                            <div class="menu-btn" ng-click="closeStyleSection()"><img src="{{ asset('icons/close.svg') }}"></div>
                        </div>
                        <form class="form_style">
                            <div class="form-group" id = "1" ng-if="templatesStyle['width']">
                                <label>Ширина блока</label></br>
                                <select ng-model="style[curEdittingBlock].width">
                                  <option ng-repeat="x in block_width" value="@{{x}}" >@{{x}}</option>
                                </select>
                            </div>
                            <div class="form-group" id = "2" ng-if="templatesStyle['align_items']">
                                <label>Выравнивание</label></br>
                                <select ng-model="style[curEdittingBlock].align_items">
                                  <option ng-repeat="x in alignment" value="@{{x}}" >@{{x}}</option>
                                </select>
                            </div>
                            <div class="form-group" id = "3" ng-if="templatesStyle['text_align']">
                                <label>Выравнивание</label></br>
                                <select ng-model="style[curEdittingBlock].text_align">
                                  <option ng-repeat="x in alignment" value="@{{x}}" >@{{x}}</option>
                                </select>
                            </div>
                            <div class="form-group" id = "4" ng-if="templatesStyle['justify_content']">
                                <label>Вертикальное выравнивание</label></br>
                                <select ng-model="style[curEdittingBlock].justify_content">
                                  <option ng-repeat="x in vertical_alignment" value="@{{x}}" >@{{x}}</option>
                                </select>
                            </div>
                            <div class="form-group" id = "5" ng-if="templatesStyle['height']">
                                <label>Высота блока</label></br>
                                <input type="text" name="height_block" ng-model="style[curEdittingBlock].height" size="7" placeholder="100vh" value="100vh">
                            </div>
                            <div>
                                <label class="subtitle_styleSection">Типографика</label>
                                <div>
                                    <div ng-if="templatesStyle['title']">
                                        <div class="form-group" id = "6">
                                            <label>Заголовок: Цвет</label></br>
                                            <input type="text" name="title_color" size="7" placeholder="#000000" ng-model="style[curEdittingBlock].title.color">
                                        </div>
                                        <div class="form-group" id = "7">
                                            <label>Заголовок: Размер шрифта</label></br>
                                            <input type="text" name="title_fontsize" size="7" placeholder="14pt" ng-model="style[curEdittingBlock].title.font_size">
                                        </div>
                                        <div class="form-group" id = "8">
                                            <label>Заголовок: Шрифт</label></br>
                                            <select ng-model="style[curEdittingBlock].title.font_family">
                                              <option ng-repeat="x in font_family" value="@{{x}}" >@{{x}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div ng-if="templatesStyle['uptitle']">
                                        <div class="form-group" id = "9">
                                            <label>Надзаголовок: Цвет</label></br>
                                            <input type="text" name="uptitle_color" size="7" placeholder="#000000" ng-model="style[curEdittingBlock].uptitle.color">
                                        </div>
                                        <div class="form-group" id = "10">
                                            <label>Надзаголовок: Размер шрифта</label></br>
                                            <input type="text" name="uptitle_fontsize" size="7" placeholder="14pt" ng-model="style[curEdittingBlock].uptitle.font_size">
                                        </div>
                                        <div class="form-group" id = "11">
                                            <label>Надзаголовок: Шрифт</label></br>
                                            <select ng-model="style[curEdittingBlock].uptitle.font_family">
                                              <option ng-repeat="x in font_family" value="@{{x}}" >@{{x}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div ng-if="templatesStyle['subtitle']">
                                        <div class="form-group" id = "12">
                                            <label>Подзаголовок: Цвет</label></br>
                                            <input type="text" name="subtitle_color" size="7" placeholder="#000000" ng-model="style[curEdittingBlock].subtitle.color">
                                        </div>
                                        <div class="form-group" id = "13">
                                            <label>Подзаголовок: Размер шрифта</label></br>
                                            <input type="text" name="subtitle_fontsize" size="7" placeholder="14pt" ng-model="style[curEdittingBlock].subtitle.fontsize">
                                        </div>
                                        <div class="form-group" id = "14">
                                            <label>Подзаголовок: Шрифт</label></br>
                                            <select ng-model="style[curEdittingBlock].subtitle.font_family">
                                              <option ng-repeat="x in font_family" value="@{{x}}" >@{{x}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div ng-if="templatesStyle['main_text']">
                                        <div class="form-group" id = "15">
                                            <label>Основной текст: Цвет</label></br>
                                            <input type="text" name="main_text_color" size="7" placeholder="#000000" ng-model="style[curEdittingBlock].main_text.color">
                                        </div>
                                        <div class="form-group" id = "16">
                                            <label>Основной текст: Размер шрифта</label></br>
                                            <input type="text" name="main_text_fontsize" size="7" placeholder="14pt" ng-model="style[curEdittingBlock].main_text.font_size">
                                        </div>
                                        <div class="form-group" id = "17">
                                            <label>Основной текст: Шрифт</label></br>
                                            <select ng-model="style[curEdittingBlock].main_text.font_family">
                                              <option ng-repeat="x in font_family" value="@{{x}}" >@{{x}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div><button>Сохранить</button></div>
                            <!-- @{{ style | json }} -->
                        </form>
                    </div>
                </div>
                <div class="contentSection"></div>
            </div>

            




            <div class="editSection" ng-init="init({{$longreadId}})" >
                <div ng-repeat="curTempl in curTempls track by $index">
                    <div class="library" ng-if="statusButtom"><button ng-click="openLibrary($index)">Добавить блок</button></div>
                    <div class="block">
                        <div class="editButtom">
                            <div class="editStyle" ng-click="openStyleSection($index)">Оформление</div>
                            <div class="editContent">Контент</div>
                            <div class="moreOption"><img src="{{ asset('icons/dot.svg') }}">
                                <div class="option">
                                    <div class="option-list">
                                        <div class="option-item" ng-click="delete($index)">
                                            <img src="{{ asset('icons/garbage.svg') }}">
                                            <h6>Удалить блок</h6>
                                        </div>
                                        <div class="option-item" ng-click="move($index, 1)">
                                            <img src="{{ asset('icons/up.svg') }}">
                                            <h6>Переместить наверх</h6>
                                        </div>
                                        <div class="option-item" ng-click="move($index, 0)">
                                            <img src="{{ asset('icons/down.svg') }}">
                                            <h6>Переместить вниз</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div ng-include="curTempl.fileName"></div>
                    </div>
                </div>
                <div class="library"><button ng-click="openLibrary()">Добавить блок</button></div>
            </div>
        </div>
    </body>
</html>