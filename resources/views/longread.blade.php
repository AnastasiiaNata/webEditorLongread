<!DOCTYPE html>
<html ng-app="webEditor" ng-controller="TemplController">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@{{ long['title'] }}</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
        <!-- <script src="{{asset('js/lib/popper.min.js')}}" type="text/javascript"></script> -->
        <!-- <script type="text/javascript" src="{{ asset('js/lib/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/jasny-bootstrap.min.js') }}"></script> -->

        
        <link rel="shortcut icon" type="image/x-icon" href="@{{ long['parameters']['favicon'] }}">

        <script type="text/javascript" src="{{ asset('js/lib/angular.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/angular-resource.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/angular-sanitize.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/angular-route.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/angular-animate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/TweenMax.min.js') }}"></script>


        
        

        <!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/jasny-bootstrap.min.css') }}"> -->
        
        <script type="text/javascript" src="{{ asset('js/edittingPageScript.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/edittingPageStyle.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/templates_css/templatesStyle.css') }}" />

        <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/owlcarousel/owl-carousel.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/owlcarousel/owl-theme.css') }}">
        <script src="{{asset('js/lib/jquery-3.4.0.min.js')}}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('js/lib/owlcarousel/owl-carousel.min.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('js/angularjs-color-picker/dist/angularjs-color-picker.min.css') }}" />
        <script src="{{ asset('js/tinycolor2/dist/tinycolor-min.js') }}"></script>
        <script src="{{ asset('js/angularjs-color-picker/dist/angularjs-color-picker.min.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('js/angular-video-background/dist/angular-video-background.min.css') }}" />
        <script src="{{ asset('js/angular-video-background/dist/angular-video-background.min.js') }}"></script>

        <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/animate.css/animate.css') }}">


    </head>
    <body >
        <div class="header">
            <div class="leftBTN">
                <div><a href="/longread">Мои лонгриды</a></div>
            </div>
            <div class="burger" ng-click="openBurger()"><img src="{{ asset('icons/menu.svg') }}"></div>
            <div class="buttons" ng-class="active_buttons">
                <div class="previewBTN"><a href="#" ng-click="publish({{$longreadId}})" id="butView" >Опубликовать</a></div>
                <div class="previewBTN"><a href="/longread/{{$longreadId}}/preview" ng-click="saveTemples({{$longreadId}})" id="butView" >Предпросмотр</a></div>
                <div class="saveBTN"><a href="#" ng-click="saveTemples({{$longreadId}})">Сохранить</a></div>  
            </div>
            
        </div>

        <div class="wrapper">
            <div class="menu menu-library" ng-class = "{menu_active: statusLibrary}">
                <div class="menu-header menu-header-library">
                    <div class="menu-header-title"><h5>Библиотека шаблонов</h5></div>
                    <div class="menu-btn" ng-click="closeLibrary()"><img src="{{ asset('icons/close.svg') }}"></div>
                </div>
                <div class="menu-list" ng-repeat="template in templates">
                    <div ng-click="addTemple($index)" templId=$index><h6>@{{template.title}}</h6></div>
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
                        <button ng-if="!showLongread" class="publishBTN" ng-click="publishLongread({{$longreadId}})">Опуликовать</button>
                        <a href="/view/@{{settingsLongread.url}}" target="_blank" class="publishBTN" ng-if="showLongread">Показать лонгрид</a>
                    </div>

                    <div class="form_style" ng-if="published"> 
                        <h3>Публикация лонгрида</h3>
                        <p>Адрес вашего опубликованного лонгрида</p>
                        <div class="form-group2">
                            <label for="n">@{{documentLocation}}/@{{long["url"]}}</label>
                        </div>
                        <a href="/view/@{{long['url']}}" target="_blank" class="publishBTN" ng-if="showLongread">Показать лонгрид</a>
                    </div>
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
                            <div class="form-group" id = "5" ng-if="templatesStyle['height']">
                                <label>Высота блока</label></br>
                                <select ng-model="style[curEdittingBlock].height">
                                  <option ng-repeat="x in block_height" value="@{{x}}" >@{{x}}</option>
                                </select>
                            </div>
                            <div class="form-group" id = "2" ng-if="templatesStyle['align_items']">
                                <label>Выравнивание блоков</label></br>
                                <select ng-model="style[curEdittingBlock].align_items">
                                  <option ng-repeat="x in alignment" value="@{{x.en}}" >@{{x.ru}}</option>
                                </select>
                            </div>
                            <div class="form-group" id = "3" ng-if="templatesStyle['text_align']">
                                <label>Выравнивание текста</label></br>
                                <select ng-model="style[curEdittingBlock].text_align">
                                  <option ng-repeat="x in text_alignment" value="@{{x.en}}" >@{{x.ru}}</option>
                                </select>
                            </div>
                            <div class="form-group" id = "4" ng-if="templatesStyle['justify_content']">
                                <label>Вертикальное выравнивание</label></br>
                                <select ng-model="style[curEdittingBlock].justify_content">
                                  <option ng-repeat="x in vertical_alignment" value="@{{x.en}}" >@{{x.ru}}</option>
                                </select>
                            </div>
                            
                            <div class="form-group" id = "18" ng-if="templatesStyle['direction']">
                                <label>Расположение</label></br>
                                <select ng-model="style[curEdittingBlock].direction">
                                  <option ng-repeat="x in direction" value="@{{x.en}}" >@{{x.ru}}</option>
                                </select>
                            </div>
                            
                            <div class="form-group" id = "16" ng-if="templatesStyle['gallery']">
                                <label>Расстояние между изображениями</label></br>
                                <input type="text" name="distance_between_imgs"  ng-model="style[curEdittingBlock].gallery.distance_between_imgs">
                            </div>
                            <div class="form-group showAdditionalInfo" ng-click="showAdditionalInfo(5)" ng-if="oneImg">
                                <div>Изображение</div>
                                <div class="imgAdditionalInfo"><img src="{{ asset('icons/arrow.svg') }}"></div>
                            </div>
                            <div ng-if="imagesInfo">
                                <div class="form-group" id = "7" >
                                    <label>Тень для изображения</label>
                                    <div class="row">
                                        <div ng-style="{'margin-right': 24 + 'px', 'width': 100 + '%'}">
                                            <label>Смещение по X</label>
                                            <input type="text" name="text_shadow_x" ng-model="style[curEdittingBlock].img.text_shadow_x">
                                        </div>
                                        <div ng-style="{'margin-left': 24 + 'px', 'width': 100 + '%'}">
                                            <label>Смещение по Y</label>
                                            <input type="text" name="text_shadow_y" ng-model="style[curEdittingBlock].img.text_shadow_y">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div ng-style="{'margin-right': 24 + 'px', 'width': 100 + '%'}">
                                            <label>Цвет тени</label>
                                            <color-picker ng-model="style[curEdittingBlock].img.text_shadow_color"></color-picker>
                                        </div>
                                        <div ng-style="{'margin-left': 24 + 'px', 'width': 100 + '%'}">
                                            <label>Размытость тени</label>
                                            <input type="text" name="shadow_blur" ng-model="style[curEdittingBlock].img.text_shadow_blur">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group showAdditionalInfo" ng-click="showAdditionalInfo(6)" ng-if="sliderShow">
                                <div>Слайдер</div>
                                <div class="imgAdditionalInfo"><img src="{{ asset('icons/arrow.svg') }}"></div>
                            </div>
                            <div ng-if="sliderInfo">
                                <div class="form-group" id = "7">
                                    <label>Количество картинок на слайде</label>
                                    <input type="text" name="items"  ng-model="style[curEdittingBlock].slider.items" ng-blur="initSlider(curEdittingBlock, style[curEdittingBlock].slider)">
                                </div>
                                <div class="form-group" id = "7">
                                    <label>Видимость картинок</label>
                                    <input type="text" name="stagePadding"  ng-model="style[curEdittingBlock].slider.stagePadding" ng-blur="initSlider(curEdittingBlock, style[curEdittingBlock].slider)">
                                </div>
                                <div class="form-group" id = "7">
                                    <label>Расстояние между картинками</label>
                                    <input type="text" name="margin"  ng-model="style[curEdittingBlock].slider.margin" ng-blur="initSlider(curEdittingBlock, style[curEdittingBlock].slider)">
                                </div>
                                <div class="form-group" id = "18" ng-if="templatesStyle['slider']">
                                    <label>Зацикливание</label>
                                    <select ng-model="style[curEdittingBlock].slider.loop" ng-change="initSlider(curEdittingBlock, style[curEdittingBlock].slider)">
                                      <option ng-repeat="x in slider_loop" value="@{{x.en}}" >@{{x.ru}}</option>
                                    </select>
                                </div>
                                <div class="form-group" id = "18" ng-if="templatesStyle['slider']">
                                    <label>Автовоспроизведение</label>
                                    <select ng-model="style[curEdittingBlock].slider.autoplay" ng-change="initSlider(curEdittingBlock, style[curEdittingBlock].slider)">
                                      <option ng-repeat="x in slider_autoplay" value="@{{x.en}}" >@{{x.ru}}</option>
                                    </select>
                                </div>
                                <div class="form-group" id = "7" ng-if="style[curEdittingBlock].slider.autoplay">
                                    <label>Время на один слайд</label>
                                    <input type="text" name="autoplayTimeout"  ng-model="style[curEdittingBlock].slider.autoplayTimeout" ng-blur="initSlider(curEdittingBlock, style[curEdittingBlock].slider)">
                                </div>
                                
                            </div>



                            <div class="form-group showAdditionalInfo" ng-click="showAdditionalInfo(1)" ng-if="typographyShow">
                                <div>Типографика</div>
                                <div class="imgAdditionalInfo"><img src="{{ asset('icons/arrow.svg') }}"></div>
                            </div>
                            <div ng-if="typographyInfo">
                                <div>
                                    <div ng-if="templatesStyle['title']">
                                        <div class="form-group" id = "6">
                                            <label>Заголовок: Цвет</label></br>
                                            <div class="color-picker-style"><color-picker ng-model="style[curEdittingBlock].title.color"></color-picker></div>
                                        </div>
                                        <div class="form-group" id = "8">
                                            <label>Заголовок: Шрифт</label></br>
                                            <select ng-model="style[curEdittingBlock].title.font_family">
                                              <option ng-repeat="x in font_family" value="@{{x}}" >@{{x}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id = "7">
                                            <label>Заголовок: Размер шрифта</label></br>
                                            <input type="text" name="title_fontsize"  ng-model="style[curEdittingBlock].title.font_size">
                                        </div>
                                        <div class="form-group" id = "17">
                                            <label>Заголовок: Насыщенность</label></br>
                                            <select ng-model="style[curEdittingBlock].title.font_weight">
                                              <option ng-repeat="x in font_weight" value="@{{x}}" >@{{x}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id = "17">
                                            <label>Заголовок: Начертание</label></br>
                                            <select ng-model="style[curEdittingBlock].title.font_style">
                                              <option ng-repeat="x in font_style" value="@{{x.en}}" >@{{x.ru}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id = "17">
                                            <label>Заголовок: Подчеркивание</label></br>
                                            <select ng-model="style[curEdittingBlock].title.text_decoration">
                                              <option ng-repeat="x in text_decoration" value="@{{x.en}}" >@{{x.ru}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group showAdditionalInfo" ng-click="showAdditionalInfo(3.4)">
                                            <div>Заголовок: Тень</div>
                                            <div class="imgAdditionalInfo"><img src="{{ asset('icons/arrow.svg') }}"></div>
                                        </div>
                                        <div class="form-group" id = "7" ng-if="shadowTitle">
                                            <div class="row">
                                                <div ng-style="{'margin-right': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Смещение по X</label>
                                                    <input type="text" name="text_shadow_x" ng-model="style[curEdittingBlock].title.text_shadow_x">
                                                </div>
                                                <div ng-style="{'margin-left': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Смещение по Y</label>
                                                    <input type="text" name="text_shadow_y" ng-model="style[curEdittingBlock].title.text_shadow_y">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div ng-style="{'margin-right': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Цвет тени</label>
                                                    <color-picker ng-model="style[curEdittingBlock].title.text_shadow_color"></color-picker>
                                                </div>
                                                <div ng-style="{'margin-left': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Размытость тени</label>
                                                    <input type="text" name="shadow_blur" ng-model="style[curEdittingBlock].title.text_shadow_blur">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        

                                    <div ng-if="templatesStyle['overhead']">
                                        <div class="form-group" id = "9">
                                            <label>Надзаголовок: Цвет</label></br>
                                            <color-picker ng-model="style[curEdittingBlock].overhead.color"></color-picker>
                                        </div>
                                        <div class="form-group" id = "11">
                                            <label>Надзаголовок: Шрифт</label></br>
                                            <select ng-model="style[curEdittingBlock].overhead.font_family">
                                              <option ng-repeat="x in font_family" value="@{{x}}" >@{{x}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id = "10">
                                            <label>Надзаголовок: Размер шрифта</label></br>
                                            <input type="text" name="overhead_fontsize" ng-model="style[curEdittingBlock].overhead.font_size">
                                        </div>
                                        <div class="form-group" id = "17">
                                            <label>Надзаголовок: Насыщенность</label></br>
                                            <select ng-model="style[curEdittingBlock].overhead.font_weight">
                                              <option ng-repeat="x in font_weight" value="@{{x}}" >@{{x}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id = "17">
                                            <label>Надзаголовок: Начертание</label></br>
                                            <select ng-model="style[curEdittingBlock].overhead.font_style">
                                              <option ng-repeat="x in font_style" value="@{{x.en}}" >@{{x.ru}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id = "17">
                                            <label>Надзаголовок: Подчеркивание</label></br>
                                            <select ng-model="style[curEdittingBlock].overhead.text_decoration">
                                              <option ng-repeat="x in text_decoration" value="@{{x.en}}" >@{{x.ru}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group showAdditionalInfo" ng-click="showAdditionalInfo(3.3)">
                                            <div>Надзаголовок: Тень</div>
                                            <div class="imgAdditionalInfo"><img src="{{ asset('icons/arrow.svg') }}"></div>
                                        </div>
                                        <div class="form-group" id = "7" ng-if="shadowOverhead">
                                            <div class="row">
                                                <div ng-style="{'margin-right': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Смещение по X</label>
                                                    <input type="text" name="text_shadow_x" ng-model="style[curEdittingBlock].overhead.text_shadow_x">
                                                </div>
                                                <div ng-style="{'margin-left': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Смещение по Y</label>
                                                    <input type="text" name="text_shadow_y" ng-model="style[curEdittingBlock].overhead.text_shadow_y">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div ng-style="{'margin-right': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Цвет тени</label>
                                                    <color-picker ng-model="style[curEdittingBlock].overhead.text_shadow_color"></color-picker>
                                                </div>
                                                <div ng-style="{'margin-left': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Размытость тени</label>
                                                    <input type="text" name="shadow_blur" ng-model="style[curEdittingBlock].overhead.text_shadow_blur">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id = "10">
                                            <label>Надзаголовок: Отступ снизу</label></br>
                                            <input type="text" name="overhead_margin_bottom"  ng-model="style[curEdittingBlock].overhead.margin_bottom">
                                        </div>
                                    </div>

                                    <div ng-if="templatesStyle['subtitle']">
                                        <div class="form-group" id = "12">
                                            <label>Подзаголовок: Цвет</label></br>
                                            <color-picker ng-model="style[curEdittingBlock].subtitle.color"></color-picker>
                                        </div>
                                        <div class="form-group" id = "14">
                                            <label>Подзаголовок: Шрифт</label></br>
                                            <select ng-model="style[curEdittingBlock].subtitle.font_family">
                                              <option ng-repeat="x in font_family" value="@{{x}}" >@{{x}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id = "13">
                                            <label>Подзаголовок: Размер шрифта</label></br>
                                            <input type="text" name="subtitle_font_size"  ng-model="style[curEdittingBlock].subtitle.font_size">
                                        </div>
                                        <div class="form-group" id = "17">
                                            <label>Подзаголовок: Насыщенность</label></br>
                                            <select ng-model="style[curEdittingBlock].subtitle.font_weight">
                                              <option ng-repeat="x in font_weight" value="@{{x}}" >@{{x}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id = "17">
                                            <label>Подзаголовок: Начертание</label></br>
                                            <select ng-model="style[curEdittingBlock].subtitle.font_style">
                                              <option ng-repeat="x in font_style" value="@{{x.en}}" >@{{x.ru}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id = "17">
                                            <label>Подзаголовок: Подчеркивание</label></br>
                                            <select ng-model="style[curEdittingBlock].subtitle.text_decoration">
                                              <option ng-repeat="x in text_decoration" value="@{{x.en}}" >@{{x.ru}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group showAdditionalInfo" ng-click="showAdditionalInfo(3.2)">
                                            <div>Подзаголовок: Тень</div>
                                            <div class="imgAdditionalInfo"><img src="{{ asset('icons/arrow.svg') }}"></div>
                                        </div>
                                        <div class="form-group" id = "7" ng-if="shadowSubtitle">
                                            <div class="row">
                                                <div ng-style="{'margin-right': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Смещение по X</label>
                                                    <input type="text" name="text_shadow_x" ng-model="style[curEdittingBlock].subtitle.text_shadow_x">
                                                </div>
                                                <div ng-style="{'margin-left': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Смещение по Y</label>
                                                    <input type="text" name="text_shadow_y" ng-model="style[curEdittingBlock].subtitle.text_shadow_y">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div ng-style="{'margin-right': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Цвет тени</label>
                                                    <color-picker ng-model="style[curEdittingBlock].subtitle.text_shadow_color"></color-picker>
                                                </div>
                                                <div ng-style="{'margin-left': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Размытость тени</label>
                                                    <input type="text" name="shadow_blur" ng-model="style[curEdittingBlock].subtitle.text_shadow_blur">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id = "10">
                                            <label>Подзаголовок: Отступ сверху</label></br>
                                            <input type="text" name="subtitle_margin_top"  ng-model="style[curEdittingBlock].subtitle.margin_top">
                                        </div>
                                    </div>

                                    <div ng-if="templatesStyle['main_text']">
                                        <div class="form-group" id = "15">
                                            <label>Основной текст: Цвет</label></br>
                                            <color-picker ng-model="style[curEdittingBlock].main_text.color"></color-picker>
                                        </div>
                                        <div class="form-group" id = "17">
                                            <label>Основной текст: Шрифт</label></br>
                                            <select ng-model="style[curEdittingBlock].main_text.font_family">
                                              <option ng-repeat="x in font_family" value="@{{x}}" >@{{x}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id = "16">
                                            <label>Основной текст: Размер шрифта</label></br>
                                            <input type="text" name="main_text_fontsize" size="7" placeholder="1.7vw" ng-model="style[curEdittingBlock].main_text.font_size">
                                        </div>
                                        <div class="form-group" id = "17">
                                            <label>Основной текст: Насыщенность</label></br>
                                            <select ng-model="style[curEdittingBlock].main_text.font_weight">
                                              <option ng-repeat="x in font_weight" value="@{{x}}" >@{{x}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id = "17">
                                            <label>Основной текст: Начертание</label></br>
                                            <select ng-model="style[curEdittingBlock].main_text.font_style">
                                              <option ng-repeat="x in font_style" value="@{{x.en}}" >@{{x.ru}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id = "17">
                                            <label>Основной текст: Подчеркивание</label></br>
                                            <select ng-model="style[curEdittingBlock].main_text.text_decoration">
                                              <option ng-repeat="x in text_decoration" value="@{{x.en}}" >@{{x.ru}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group showAdditionalInfo" ng-click="showAdditionalInfo(3.1)">
                                            <div>Основной текст: Тень</div>
                                            <div class="imgAdditionalInfo"><img src="{{ asset('icons/arrow.svg') }}"></div>
                                        </div>
                                        <div class="form-group" id = "7" ng-if="shadowMainText">
                                            <div class="row">
                                                <div ng-style="{'margin-right': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Смещение по X</label>
                                                    <input type="text" name="text_shadow_x" ng-model="style[curEdittingBlock].main_text.text_shadow_x">
                                                </div>
                                                <div ng-style="{'margin-left': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Смещение по Y</label>
                                                    <input type="text" name="text_shadow_y" ng-model="style[curEdittingBlock].main_text.text_shadow_y">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div ng-style="{'margin-right': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Цвет тени</label>
                                                    <color-picker ng-model="style[curEdittingBlock].main_text.text_shadow_color"></color-picker>
                                                </div>
                                                <div ng-style="{'margin-left': 24 + 'px', 'width': 100 + '%'}">
                                                    <label>Размытость тени</label>
                                                    <input type="text" name="shadow_blur" ng-model="style[curEdittingBlock].main_text.text_shadow_blur">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group showAdditionalInfo" ng-click="showAdditionalInfo(4)">
                                <div>Фон блока</div>
                                <div class="imgAdditionalInfo"><img src="{{ asset('icons/arrow.svg') }}"></div>
                            </div> -->
                            <div class="form-group">
                                <div ng-style="{'margin-right': 24 + 'px', 'width': 100 + '%'}">
                                    <label>Фон блока</label>
                                    <color-picker ng-model="style[curEdittingBlock].bg_color"></color-picker>
                                </div>
                            </div>
                            <!-- <div class="form-group" ng-if="bg_color">
                                <div class="row">
                                    <div ng-style="{'margin-right': 24 + 'px', 'width': 100 + '%'}">
                                        <label>Цвет в начале</label>
                                        <color-picker ng-model="style[curEdittingBlock].bg_color_start"></color-picker>
                                    </div>
                                    <div ng-style="{'margin-left': 24 + 'px', 'width': 100 + '%'}">
                                        <label>Прозрачность</label>
                                        <select ng-model="style[curEdittingBlock].bg_blur_start">
                                            <option ng-repeat="x in shadow_blur" value="@{{x}}" >@{{x}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div ng-style="{'margin-right': 24 + 'px', 'width': 100 + '%'}">
                                        <label>Цвет в конце</label>
                                        <color-picker ng-model="style[curEdittingBlock].bg_color_end"></color-picker>
                                    </div>
                                    <div ng-style="{'margin-left': 24 + 'px', 'width': 100 + '%'}">
                                        <label>Прозрачность</label>
                                        <select ng-model="style[curEdittingBlock].bg_blur_end">
                                            <option ng-repeat="x in shadow_blur" value="@{{x}}" >@{{x}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <div class="form-group" id = "7">
                                <label>Отступы для desktop</label>
                                <div class="row">
                                    <div ng-style="{'margin-right': 24 + 'px'}">
                                        <label>Отступ сверху</label>
                                        <input type="text" name="margin_top" ng-model="style[curEdittingBlock].padding_top_desktop">
                                    </div>
                                    <div ng-style="{'margin-left': 24 + 'px'}">
                                        <label>Отступ снизу</label>
                                        <input type="text" name="margin_bottom" ng-model="style[curEdittingBlock].padding_bottom_desktop">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group showAdditionalInfo" ng-click="showAdditionalInfo(2)">
                                <div>Отступы для мобильной версии</div>
                                <div class="imgAdditionalInfo"><img src="{{ asset('icons/arrow.svg') }}"></div>
                            </div>
                            <div class="form-group" id = "7" ng-if="mobileInfo">
                                <label>Отступы для mobile</label>
                                <div class="row">
                                    <div ng-style="{'margin-right': 24 + 'px'}">
                                        <label>Отступ сверху</label>
                                        <input type="text" name="margin_top" ng-model="style[curEdittingBlock].padding_top_mobile">
                                    </div>
                                    <div ng-style="{'margin-left': 24 + 'px'}">
                                        <label>Отступ снизу</label>
                                        <input type="text" name="margin_bottom" ng-model="style[curEdittingBlock].padding_bottom_mobile">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>

            <div class="menu menu_content" ng-class = "{menu_active: statusContentSection}" >
                <div class="contentSection">
                    <div class="block1" id = "1">
                        <div class="menu-header">
                            <div class="menu-header-title"><h5>Контент</h5></div>
                            <div class="menu-btn" ng-click="closeContentSection()"><img src="{{ asset('icons/close.svg') }}"></div>
                        </div>
                        <div class="form_style">
                            <div class="form-group" id = "23" ng-if="templatesContent['img']">
                                <label>Изображение</label></br>
                                <div>
                                    <div>
                                        <!-- <div ng-if="isOneImage"> -->
                                            <button class="loadBTN" ng-click="loadImage()">Загрузить изображение</button>
                                            <div ng-if="loadImg" class="loadImg">
                                                <form enctype="multipart/form-data" method="post" class="inputfile">
                                                    {{ csrf_field() }}
                                                    <input ng-if="oneImg" type="file" id="file" ng-files="getTheFiles($files)" accept=".jpg, .jpeg, .png"/>
                                                    <input ng-if="!oneImg" type="file" id="file" multiple ng-files="getTheFiles($files)" accept=".jpg, .jpeg, .png"/>
                                                    <label for="file" class="btn-1"><span>Выбрать файл</span></label>
                                                </form> 
                                            </div>
                                        <!-- </div> -->
                                        <div ng-repeat="curImg in images[curEdittingBlock] track by $index" class="curImgs">
                                            <div class="curImg">
                                                <div class="curImg_img"><img ng-src="@{{ curImg.src  }}"></div>
                                                <div class="curImg_text"><p>@{{ curImg.name }}</p></div>
                                                <div class="curImg_btn" ng-click="deleteImg($index)"><img src="{{ asset('icons/garbage.svg') }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id = "23" ng-if="templatesContent['video']">
                                <label>Видео</label></br>
                                <div>
                                    <div>
                                        <div class="URLvideo">
                                            <label>Ссылка на YouTube ролик</label></br>
                                            <input type="text" name="" ng-model="videos[curEdittingBlock][0].src" ng-style="{'width': '90%'}">
                                        </div>
                                            <div class="curImgs">
                                                <div class="curImg">
                                                    <div class="curImg_img">
                                                        <iframe frameborder="0" ng-src="@{{ videos[curEdittingBlock][0].src.split('watch?v=')[0] + 'embed/' + videos[curEdittingBlock][0].src.split('watch?v=')[1].split('&')[0] + '?autoplay=0&controls=0&showinfo=0&modestbranding=1$rel=0'| trustUrl }}" ></iframe>
                                                    </div>
                                                    <div class="curImg_text"><p>@{{ videos[curEdittingBlock][0].name }}</p></div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id = "19" ng-if="templatesContent['title']">
                                <label>Заголовок</label></br>
                                <input class="inputContent" type="text" name="title" ng-model="mainText[curEdittingBlock].title">
                            </div>
                            <div class="form-group" id = "20" ng-if="templatesContent['overhead']">
                                <label>Надзаголовок</label></br>
                                <input class="inputContent" type="text" name="overhead" ng-model="mainText[curEdittingBlock].overhead">
                            </div>
                            <div class="form-group" id = "21" ng-if="templatesContent['subtitle']">
                                <label>Подзаголовок</label></br>
                                <input class="inputContent" type="text" name="subtitle" ng-model="mainText[curEdittingBlock].subtitle">
                            </div>
                            
                            <div class="form-group" id = "22" ng-if="templatesContent['text']">
                                <label>Основной текст</label></br>
                                <textarea class="inputContent" ng-model="mainText[curEdittingBlock].text"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            




            <div class="editSection" ng-init="init({{$longreadId}})" >
                <div ng-repeat="(templNum, curTempl) in curTempls track by $index">
                    <div class="library" ng-if="statusButtom"><button ng-click="openLibrary($index)">Добавить блок</button></div>
                    <div class="block">
                        <div class="editButtom">
                            <div class="editStyle" ng-click="openStyleSection($index)">Оформление</div>
                            <div class="editContent" ng-click="openContentSection($index)">Контент</div>
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
                                        <div class="option-item" ng-click="move($index, 0)" ng-style="{'border': 'none'}">
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
            </div><!-- 
            @{{ $first }} -->
        </div>
    </body>

    
</html>