var webEditor = angular.module("webEditor", ['ngResource', 'ngRoute', 'ngSanitize', 'color.picker', 'video-background', 'ngAnimate']);


webEditor.factory('WebEditorRepository', ['$resource', 
  function($resource) { 
    return $resource('longread', null, {
      load: { method: 'GET', url: '/longread/:id/load', isArray: true},
      save: { method: 'POST', url: '/longread/:id/save', isArray: true},
      publish: { method: 'POST', url: '/longread/:id/publish', isArray: true}
    }); 
  }
 ]);


webEditor.controller("TemplController", function($window, $scope, $document, WebEditorRepository){
  $scope.templates = [];
  $scope.curTempls = [];
  $scope.mainText = [];
  $scope.images = [];
  $scope.style = [];
  $scope.oldImg = [];
  $scope.deleteImgServer = [];
  $scope.videos = [];
  $scope.editPage = true;
  $scope.settingsLongread = [];

  $scope.init = function(longreadId){
    console.log(window.innerWidth);
    $scope.documentLocation = document.location.protocol + '//' + document.location.host;
    WebEditorRepository.load({id: longreadId}, function(response) {
      $scope.curTempls = response[0];
      // console.log($scope.curTempls);
      if (Object.keys($scope.curTempls).length > 0) {
        $scope.statusButtom = true;
      }
     
      setContent();
      $scope.templates = response[1];
      $scope.long = response[2];
      $scope.long['parameters'] = JSON.parse($scope.long['parameters']);
      console.log($scope.long);
      console.log("Данные получены");
  })};

  function setContent(){
    for (var i = 0; i < Object.keys($scope.curTempls).length; i++) {
      data = JSON.parse($scope.curTempls[i]["content"]);
      $scope.mainText[i] = {};
      for (let key in data["text"]){
        $scope.mainText[i][key] = data["text"][key];
      }
      $scope.oldImg[i] = [];
      for (let j = 0; j < data["img"].length; j++){
        if (data["img"][j]["src"].includes("../..") == false) {
          pathOld = "/public/" + data["img"][j]["src"].split("/")[2] + "/" + data["img"][j]["src"].split("/")[3];
          path = "/storage/" + data["img"][j]["src"].split("/")[2] + "/" + data["img"][j]["src"].split("/")[3];
          data["img"][j]["src"] = path;
          $scope.oldImg[i][j] = pathOld;
        }
        else {
          data["img"][j]["src"] = data["img"][j]["src"];
        }        
      }


      $scope.videos[i] = data["video"];
      $scope.images[i] = data["img"];
      dataStyle = JSON.parse($scope.curTempls[i]["styles"]);
      $scope.style[i] = {};
      for (let key in dataStyle){
        $scope.style[i][key] = dataStyle[key];
      }
      $scope.initSlider(i, $scope.style[i]["slider"]);
    }
  }

  $scope.initSlider = function(id, settings){
    // $(document).ready(function(){
      $('#owl-carousel-' + id).owlCarousel('destroy');
      setTimeout(function(){
        console.log($("div").is('#owl-carousel-' + id));
        console.log(settings);
        if ($("div").is('#owl-carousel-' + id)) {        
          var owl = $('#owl-carousel-' + id).owlCarousel({
            items: Number( settings["items"]),
            stagePadding: Number( settings["stagePadding"]),
            margin: Number(settings["margin"]),
            loop: settings["loop"],
            nav: true,
            navText : ["",""],
            // dotsContainer: '#carousel-custom-dots',
            autoplay: settings["autoplay"],
            autoplayTimeout: Number( settings["autoplayTimeout"]),
            autoplayHoverPause:true,

            responsive:{
              0:{
                stagePadding: 0,
                margin: 0,
                items: 1,
              },
              800:{
                items: (Number( settings["items"]) > 2 ) ? Number( settings["items"]) - 1 : Number( settings["items"]), 
                stagePadding: Number(settings["stagePadding"]),
                margin: Number( settings["margin"]),
              },
              1200:{
                items: Number( settings["items"]), 
                stagePadding: Number( settings["stagePadding"]),
                margin: Number( settings["margin"]),
              }
            }
          });
        }
        // $('.carousel_dot').click(function () {
        //   owl.trigger('to.owl.carousel', [$(this).index(), 300]);
        // });
      }, 50);
      
    // });

  }

  

  $scope.statusLibrary = false;
  $scope.statusButtom = false;
  $scope.statusStyleSection = false;
  $scope.statusContentSection = false;
  $scope.loadImg = false;
  $scope.loadVid = false;
  $scope.statusPublish = false;
  $scope.curEdittingBlock = 0;
  $scope.showErrorExist = false;
  $scope.showErrorValue = false;

  $scope.publish = function(longreadId){
    $scope.statusPublish = true;
    // console.log($scope.long["url"]);
    if ($scope.long["url"] == null){
        $scope.published = false;
    }
    else {
      $scope.published = true;
      $scope.showLongread = true;
    }
  }

  $scope.closePublish = function(){
    $scope.statusPublish = false;
    $scope.openBurger();
  }

  $scope.publishLongread = function(longreadId){
    $scope.postData = [];
    $scope.postData[0] = $scope.settingsLongread.url;
    WebEditorRepository.publish({id: longreadId}, $scope.postData, function(response) {
      if (response[0] == 0){
        $scope.showErrorExist = true;
        $scope.showErrorValue = false;
      }
      else if (response[0] == -1){
        $scope.showErrorValue = true;
        $scope.showErrorExist = false;
      }
      else {
        console.log("published");
        $scope.showLongread = true;
        $scope.showErrorExist = false;
        $scope.showErrorValue = false;
      }
      });
  }



	$scope.addTemple = function($index){

    if (angular.isNumber($scope.curPosition)){
      
      curTemplsArr = [];
      for (var i = 0; i < Object.keys($scope.curTempls).length; i++){
        curTemplsArr.push($scope.curTempls[i]);
      }
      curTemplsArr.splice($scope.curPosition, 0, $scope.templates[$index]);
      $scope.oldImg.splice($scope.curPosition, 0, []);
      data = JSON.parse($scope.templates[$index]["content"]);

      // Добавление текста

      $scope.mainText.splice($scope.curPosition, 0, {});
      for (let key in data["text"]){
        $scope.mainText[$scope.curPosition][key] = data["text"][key];
      }

      // Добавление изображений

      $scope.images.splice($scope.curPosition, 0, []);
      for (let key in data["img"]){
        $scope.images[$scope.curPosition][key] = data["img"][key];
      }
      // console.log($scope.images);

      // Добавление видео
      $scope.videos.splice($scope.curPosition, 0, {});
      for (let key in data["video"]){
        $scope.videos[$scope.curPosition][key] = data["video"][key];
      }

      // Добавление стилей

      dataStyle = JSON.parse($scope.templates[$index]["styles"]);
      $scope.style.splice($scope.curPosition, 0, {});
      for (let key in dataStyle){
        $scope.style[$scope.curPosition][key] = dataStyle[key];
      }

      // Инициализация слайдера
      $('.carousel').owlCarousel('destroy');

      for (var j = 0; j < curTemplsArr.length; j++) {
        if ($scope.images[j].length > 1) {
          console.log($scope.style[j]["slider"]);
          $scope.initSlider(j, $scope.style[j]["slider"]);
        }
      }
      
     
      data = [];
      for (var i = 0; i < curTemplsArr.length; i++){
        data[i] = [i, curTemplsArr[i]];
      }
      
      $scope.curTempls = Object.fromEntries(data);
    }
    else {
      length = Object.keys($scope.curTempls).length;
      $scope.curTempls[length] = $scope.templates[$index];
      $scope.oldImg[length] = [];

      // console.log($scope.templates[$index]["content"]);
      data = JSON.parse($scope.templates[$index]["content"]);


      $scope.mainText[length] = {};
      for (let key in data["text"]){ 
        $scope.mainText[length][key] = data["text"][key];
      }

      // добавление изображений
      $scope.images[length] = [];
      for (let key in data["img"]){ 
        $scope.images[length][key] = data["img"][key];
      }  
      // console.log($scope.images);

      $scope.videos[length] = {};
      if (data["video"] != undefined){
        for (let key in data["video"]){ 
          $scope.videos[length][key] = data["video"][key];
        }
      }
      console.log($scope.templates[$index]["styles"]);
      dataStyle = JSON.parse($scope.templates[$index]["styles"]);
      $scope.style[length] = {};
      for (let key2 in dataStyle){
        $scope.style[length][key2] = dataStyle[key2];
      }

      // Инициализация слайдера
      $('.carousel').owlCarousel('destroy');
      
      for (var j = 0; j < Object.keys($scope.curTempls).length; j++) {
          if ($scope.images[j].length > 1) {
            $scope.initSlider(j, $scope.style[j]["slider"]);
          }
      }
    }
    // console.log($scope.oldImg);
    $scope.statusButtom = true;
    $scope.statusLibrary = false;
	}


  $scope.saveTemples = function(longreadId){
    // console.log($scope.deleteImgServer);
    for (var i = 0; i < Object.keys($scope.curTempls).length; i++){
      $scope.curTempls[i]["content"] = (typeof $scope.curTempls[i]["content"] === "string") ? JSON.parse($scope.curTempls[i]["content"]):$scope.curTempls[i]["content"];
      $scope.curTempls[i]["styles"] = (typeof $scope.curTempls[i]["styles"] === "string") ? JSON.parse($scope.curTempls[i]["styles"]):$scope.curTempls[i]["styles"];
      

      for (key in $scope.curTempls[i]["content"]["text"]) {
        $scope.curTempls[i]["content"]["text"][key] = $scope.mainText[i][key];
      }
      if (Object.keys($scope.images[i]).length != 0) {
        for (let j = 0; j < Object.keys($scope.images[i]).length; j++){
          if ($scope.images[i][j]["src"].includes("/storage/")) {
            $scope.oldImg[i][j] = null;
          }
        }
        $scope.curTempls[i]["content"]["img"] = $scope.images[i];

      }
      else {
        $scope.curTempls[i]["content"]["img"] = {};
      }
      

      if (Object.keys($scope.videos[i]).length != 0) {
        for (let j = 0; j < Object.keys($scope.videos[i]).length; j++){
          $scope.curTempls[i]["content"]["video"][j] = $scope.videos[i][j];
        }
      }
      else {
        $scope.curTempls[i]["content"]["video"] = {};
      }

      for (key in $scope.style[i]){
        $scope.curTempls[i]["styles"][key] = $scope.style[i][key];

      }
    }

    $scope.postData = [$scope.curTempls, $scope.oldImg, $scope.deleteImgServer];
    console.log($scope.postData);
    WebEditorRepository.save({id: longreadId}, $scope.postData, function(response) {
      console.log("saved");
      });
  }

  $scope.delete = function($index){
    curTemplsArr = [];
    mainTextArr = [];
    for (var i = 0; i < Object.keys($scope.curTempls).length; i++){
      curTemplsArr.push($scope.curTempls[i]);
    }
    
    curTemplsArr.splice($index, 1);
    $scope.mainText.splice($index, 1);
    $scope.style.splice($index, 1);
    $scope.images.splice($index, 1);
    $scope.videos.splice($index, 1);
    $scope.deleteImgServer[$index] = $scope.oldImg[$index];
    $scope.oldImg.splice($index, 1);

    
    // Инициализация слайдера
    $('.carousel').owlCarousel('destroy');
    for (var j = 0; j < curTemplsArr.length; j++) {
      if ($scope.images[j].length > 1){
        $scope.initSlider(j, $scope.style[j]["slider"]);
      }
    }

    data = [];
    for (var i = 0; i < curTemplsArr.length; i++){
      data[i] = [i, curTemplsArr[i]];
    }
      
    $scope.curTempls = Object.fromEntries(data);

    $scope.statusContentSection = false;
    $scope.statusStyleSection = false;
    $scope.loadImg = false;
    $scope.loadVid = false;
    $scope.statusLibrary = false;
    $scope.imagesInfo = false;
    $scope.sliderInfo = false;
  }

  $scope.move = function($index, direction){
    curContext = $scope.mainText[$index];
    curTempl = $scope.curTempls[$index];
    curStyle = $scope.style[$index];
    curImg = $scope.images[$index];
    curVideo = $scope.videos[$index];
    curOldImg = $scope.oldImg[$index];

    $scope.delete($index);
    
    if (direction == 1){
      $scope.curPosition = $index - 1;
    }
    else{
      $scope.curPosition = $index + 1;
    }
    $scope.mainText.splice($scope.curPosition, 0, curContext);
    $scope.style.splice($scope.curPosition, 0, curStyle);
    $scope.images.splice($scope.curPosition, 0, curImg);
    $scope.videos.splice($scope.curPosition, 0, curVideo);
    $scope.oldImg.splice($scope.curPosition, 0, curOldImg);


    curTemplsArr.splice($scope.curPosition, 0, curTempl);
    data = [];

    // Инициализация слайдера
    $('.carousel').owlCarousel('destroy');
    for (var j = 0; j < curTemplsArr.length; j++) {
      if ($scope.images[j].length > 1) {
        $scope.initSlider(j, $scope.style[j]["slider"]);
      }
    }

    for (var i = 0; i < curTemplsArr.length; i++){
      data[i] = [i, curTemplsArr[i]];
    }
      
    $scope.curTempls = Object.fromEntries(data);
  }

  

  $scope.openLibrary = function($index){
    $scope.statusLibrary = true;
    $scope.statusContentSection = false;
    $scope.statusStyleSection = false;
    $scope.curPosition = $index;
  }

  $scope.closeLibrary = function(){
    $scope.statusLibrary = false;
    $scope.loadVid = false;
  }

  $scope.openStyleSection = function($index){
    $scope.statusContentSection = false;
    $scope.statusLibrary = false;
    $scope.statusStyleSection = true;
    $scope.curEdittingBlock = $index;

    $scope.oneImg = true;

    curImgs = (typeof $scope.curTempls[$scope.curEdittingBlock]["content"] === "string") ? JSON.parse($scope.curTempls[$scope.curEdittingBlock]["content"]):$scope.curTempls[$scope.curEdittingBlock]["content"];
    
    if (curImgs["img"] != undefined && $scope.images[$scope.curEdittingBlock] != undefined){
      if (Object.keys($scope.images[$scope.curEdittingBlock]).length > 1 || curImgs["img"].length > 1){
        $scope.oneImg = false;
      }
    }
    else {
      $scope.oneImg = false;
    }
    clearStyleFormItems();
    setStyleFormItems();
  }

  $scope.closeStyleSection = function(){
    // $scope.initSlider($scope.curEdittingBlock, $scope.style[$scope.curEdittingBlock]["slider"]);
    $scope.statusStyleSection = false;
    $scope.statusContentSection = false;
    $scope.imagesInfo = false;
    $scope.typographyShow = false;
    $scope.sliderShow = false;
    $scope.sliderInfo = false;
    $scope.typographyInfo = false;
  }

  $scope.openContentSection = function($index){
    $scope.InVideo = Object.keys($scope.videos[$scope.curEdittingBlock]).length;
    $scope.statusContentSection = true;
    $scope.statusLibrary = false;
    $scope.curEdittingBlock = $index;
    $scope.oneImg = true;

    curContent = (typeof $scope.curTempls[$scope.curEdittingBlock]["content"] === "string") ? JSON.parse($scope.curTempls[$scope.curEdittingBlock]["content"]):$scope.curTempls[$scope.curEdittingBlock]["content"];
    
    if (curContent["img"]){
      if (Object.keys($scope.images[$scope.curEdittingBlock]).length > 1 || curContent["img"].length > 1){
        $scope.oneImg = false;
      }
    }
    else if (curContent["video"]){
      $scope.imagesInfo = false;
      $scope.loadImg = false;
    }
    
    $scope.statusStyleSection = false;
    clearContentFormItems();
    setContentFormItems();
  }

  $scope.closeContentSection = function(){
    $scope.statusContentSection = false;
    $scope.statusStyleSection = false;
    $scope.loadImg = false;
    $scope.loadVid = false;
  }

  $scope.deleteVideo = function($index){
    $scope.videos[$scope.curEdittingBlock] = [];
    $scope.InVideo = 0;
  }

  $scope.deleteImg = function($index){
    curImg = [];
    for (var i = 0; i < Object.keys($scope.images[$scope.curEdittingBlock]).length; i++){
      curImg.push($scope.images[$scope.curEdittingBlock][i]);
    }
    
    curImg.splice($index, 1);

    data = [];
    if (curImg.length != 0){
      for (var i = 0; i < curImg.length; i++){
        data[i] = [i, curImg[i]];
      }
      
      $scope.images[$scope.curEdittingBlock] = Object.fromEntries(data);
    }
    else {
      $scope.images[$scope.curEdittingBlock] = {};
    }


    // Инициализация слайдера
    $('.carousel').owlCarousel('destroy');
      
    for (var j = 0; j < Object.keys($scope.curTempls).length; j++) {
      if ($("div").is('#owl-carousel-' + j)) {
        $scope.initSlider(j, $scope.style[j]["slider"]);
      }
    }
    
  }

  $scope.block_width = ['50', '55', '60', '65', '70', '75', '80', '85', '90', '95', '100'];
  $scope.block_height = ['30', '35', '40', '45', '50', '55', '60', '65', '70', '75', '80', '85', '90', '95', '100'];
  $scope.alignment = [{"ru": 'По левому краю', "en": 'flex-start'}, {"ru": 'По центру', "en": 'center'}, {"ru": 'По правому краю', "en": 'flex-end'}];
  $scope.text_alignment = [{"ru": 'По левому краю', "en": 'left'}, {"ru": 'По центру', "en": 'center'}, {"ru": 'По правому краю', "en": 'right'}];
  $scope.font_family = ['Tahoma', 'Comic Sans MS', 'Montserrat', 'Arial', 'Microsoft Sans Serif', 'Palatino Linotype'];
  $scope.vertical_alignment = [{"ru": 'По верху', "en": 'flex-start'}, {"ru": 'По центру', "en": 'center'}, {"ru": 'По низу', "en": 'flex-end'}];
  $scope.direction = [{"ru": 'Картинка справа', "en": 'row'}, {"ru": 'Картинка слева', "en": 'row-reverse'}];
  $scope.font_weight = ['100', '200', '300', '400', '500', '600', '700', '800', '900'];
  $scope.text_decoration = [{"ru": 'Перечеркнутый', "en": 'line-through'}, {"ru": 'Без изменений', "en": 'none'}, {"ru": 'Над текстом', "en": 'overline'}, {"ru": 'Подчеркнутый', "en": 'underline'}];
  $scope.font_style = [{"ru": 'Курсив', "en": 'italic'}, {"ru": 'Обычный', "en": 'normal'}];
  $scope.shadow_blur = ['0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100'];
  $scope.slider_direction = ["На слайдере", "Под слайдером"];
  $scope.slider_loop = [{"ru": 'Зациклить', "en": 'true'}, {"ru": 'Не зацикливать', "en": 'false'}];
  $scope.slider_autoplay = [{"ru": 'Автовоспроизводить', "en": 'true'}, {"ru": 'Не автовоспроизводить', "en": 'false'}];

  
  $scope.templatesStyle = {'width': false, 'justify_content': false, 'align_items': false, 'height':false, 'title':false,
                      'overhead':false, 'subtitle':false, 'main_text':false, 'text_align':false, 'direction':false, 'slider': false, 'gallery': false};

  $scope.templatesContent = {'title': false, 'overhead': false, 'subtitle': false, 'text':false, 'img': false, 'video':false};

  $scope.typographyShow = false;
  $scope.sliderShow = false;

  function setStyleFormItems(){
    data = (typeof $scope.curTempls[$scope.curEdittingBlock]["styles"] === "string") ? JSON.parse($scope.curTempls[$scope.curEdittingBlock]["styles"]):$scope.curTempls[$scope.curEdittingBlock]["styles"];
    for (key in data){
      for (key2 in $scope.templatesStyle){
        if (key == key2){
          $scope.templatesStyle[key] = true;
        }
      }
    }
    if ($scope.templatesStyle["overhead"] == true || $scope.templatesStyle["main_text"] == true){
      $scope.typographyShow = true;
    }
    if ($scope.templatesStyle["slider"] == true){
      $scope.sliderShow = true;
    }

    if ($scope.templatesStyle["subtitle"] == true){
      $scope.oneImg = false;
    }
  }

  function clearStyleFormItems(){
    for (key in $scope.templatesStyle){
      $scope.templatesStyle[key] = false;
    }
  }

  function setContentFormItems(){
    data = (typeof $scope.curTempls[$scope.curEdittingBlock]["content"] === "string") ? JSON.parse($scope.curTempls[$scope.curEdittingBlock]["content"]):$scope.curTempls[$scope.curEdittingBlock]["content"];
    for (key in data["text"]){
      for (key2 in $scope.templatesContent){
        if (key == key2){
          $scope.templatesContent[key] = true;
        }
      }
    }
    if (typeof data['img'] !== "undefined" && data['img'].length > 0 ) {
      $scope.templatesContent['img'] = true;
    }
    
    if (typeof data['video'] !== "undefined" && data['video'].length > 0) {
      $scope.templatesContent['video'] = true;
    }
  }

  function clearContentFormItems(){
    for (key in $scope.templatesContent){
      $scope.templatesContent[key] = false;
    }
  }

  $scope.image = "";

  $scope.loadImage = function(){
    $scope.loadImg = true;
  }

  $scope.loadVideo = function(){
    $scope.loadVid = true;
  }

  $scope.getUrl = function(width, src){
    if (width < 570){
      return src.split('watch?v=')[0] + 'embed/' + src.split('watch?v=')[1].split('&')[0] + '?loop=1&autoplay=1&rel=0';
    }
    else {
      return src.split('watch?v=')[0] + 'embed/' + src.split('watch?v=')[1].split('&')[0] + '?loop=1&autoplay=1&controls=0&rel=0';
    }
  }

  


  $scope.getTheFiles = function($files) {
    let imagesrc = [];

    for (var i = 0; i < $files.length; i++) {
      var reader = new FileReader();
      reader.fileName = $files[i].name; // Наименование загруженного файла

      reader.onload = function(event) {
        let image = {};
        image.name = event.target.fileName;
        image.size = (event.total / 1024).toFixed(2);
        image.src = event.target.result;
        imagesrc.push(image);

        curImgs = (typeof $scope.curTempls[$scope.curEdittingBlock]["content"] === "string") ? JSON.parse($scope.curTempls[$scope.curEdittingBlock]["content"]):$scope.curTempls[$scope.curEdittingBlock]["content"];

        if (Object.keys($scope.images[$scope.curEdittingBlock]).length != 1 || curImgs["img"].length != 1){
          // console.log($scope.images[$scope.curEdittingBlock]);
          let len = Object.keys($scope.images[$scope.curEdittingBlock]).length;
          $scope.images[$scope.curEdittingBlock][len] = imagesrc.shift();
        }
        $scope.$apply();
      }
      reader.readAsDataURL($files[i]);  

    }

    if (Object.keys($scope.images[$scope.curEdittingBlock]).length == 1){
      $scope.images[$scope.curEdittingBlock] = imagesrc;
    }
    $scope.loadImg = false;

    // Инициализация слайдера
    $('.carousel').owlCarousel('destroy');
      
    for (var j = 0; j < Object.keys($scope.curTempls).length; j++) {
      // console.log(j);
      $scope.initSlider(j, $scope.style[j]["slider"]);
    }
  }

  $scope.active_buttons = "";

  $scope.openBurger = function(){
    if ($scope.active_buttons == "") {
      $scope.active_buttons = "active_buttons";
    }
    else {
      $scope.active_buttons = "";
    }
    
  }





  

  // $scope.currentSlide = 0;
  
  // $scope.setCurrentSlideIndex = function(index) {
  //   $scope.currentSlide = index;
  // };
  
  // $scope.isCurrentSlideIndex = function(index) {
  //   return $scope.currentSlide === index;
  // };


  // $scope.prevSlide = function($index) {
  //   // console.log("prev");
  //   // console.log($scope.currentSlide);
  //   $scope.currentSlide = ($scope.currentSlide > 0) ? --$scope.currentSlide : Object.keys($scope.images[$index]).length - 1;
  //   // console.log($scope.currentSlide);
  //   // console.log(Object.keys($scope.images[$index]));
  // };

  // $scope.nextSlide = function($index) {
  //   // console.log("next");
  //   // console.log($scope.currentSlide);
  //   $scope.currentSlide = ($scope.currentSlide < Object.keys($scope.images[$index]).length - 1) ? ++$scope.currentSlide : 0;
  //   // console.log($scope.currentSlide);
  //   // console.log(Object.keys($scope.images[$index]).length);
  // };

  $scope.owlOptionsTestimonials = {
    autoPlay: 4000,
    stopOnHover: true,
    slideSpeed: 300,
    paginationSpeed: 600,
    items: 2
  }

  $scope.mobileInfo = false;
  $scope.typographyInfo = false;
  $scope.shadowMainText = false;
  $scope.bg_color = false;
  $scope.shadowTitle = false;
  $scope.shadowSubtitle = false;
  $scope.shadowOverhead = false;
  $scope.imagesInfo = false;
  $scope.sliderInfo = false;

  $scope.showAdditionalInfo = function(param){
    if (param == 1){
      if ($scope.typographyInfo){
        $scope.typographyInfo = false;
      }
      else{
        $scope.typographyInfo = true;
      }
    }
    else if (param == 2){
      if ($scope.mobileInfo){
        $scope.mobileInfo = false;
      }
      else{
        $scope.mobileInfo = true;
      }
    }
    else if (param == 3.1){
      if ($scope.shadowMainText){
        $scope.shadowMainText = false;
      }
      else{
        $scope.shadowMainText = true;
      }
    }
    else if (param == 3.2){
      if ($scope.shadowSubtitle){
        $scope.shadowSubtitle = false;
      }
      else{
        $scope.shadowSubtitle = true;
      }
    }
    else if (param == 3.3){
      if ($scope.shadowOverhead){
        $scope.shadowOverhead = false;
      }
      else{
        $scope.shadowOverhead = true;
      }
    }
    else if (param == 3.4){
      if ($scope.shadowTitle){
        $scope.shadowTitle = false;
      }
      else{
        $scope.shadowTitle = true;
      }
    }
    else if (param == 4){
      if ($scope.bg_color){
        $scope.bg_color = false;
      }
      else{
        $scope.bg_color = true;
      }
    }
    else if (param == 5){
      if ($scope.imagesInfo){
        $scope.imagesInfo = false;
      }
      else{
        $scope.imagesInfo = true;
      }
    }
    else if (param == 6){
      if ($scope.sliderInfo){
        $scope.sliderInfo = false;
      }
      else{
        $scope.sliderInfo = true;
      }
    }
    
  }

  

});





webEditor.config(function($provide) {
  $provide.decorator('ColorPickerOptions', function($delegate) {
    var options = angular.copy($delegate);
    options.alpha = false;
    options.format = 'hex';
    options.dynamicHue = false;
    return options;
  });
});




webEditor.directive('contenteditable', ['$sce', function($sce) { //$sce: удаляет потенциально опасные элементы и атрибуты из кода html
  return {
    require: '?ngModel', // получить NgModelController
    link: function(scope, element, attrs, ngModel) { // Функция, используемая для задач манипулирования DOM
      if (!ngModel) return; // ничего не делать, если нет ng-model

      // Как пользовательский интерфейс должен быть обновлен
      ngModel.$render = function() {
        element.html($sce.getTrustedHtml(ngModel.$viewValue || ''));
      };

      // Прослушивание события изменения, чтобы включить привязку
      element.on('blur keyup change', function() {
        scope.$evalAsync(read);
      });

      ngModel.$modelValue = scope.$eval(attrs.ngModel);
      ngModel.$setViewValue(ngModel.$modelValue);
      ngModel.$render();

      // Записать данные в модель
      function read() {
        var html = element.html();
        // Когда мы очищаем редактируемый контент, браузер оставляет позади <br> 
        // Если указан атрибут strip-br, то мы удаляем
        if ( attrs.stripBr && html == '<br>' ) {
          html = '';
        }
        ngModel.$setViewValue(html);
      }
    }
  };
}]);



webEditor.directive('ngFiles', ['$parse', function ($parse) {
  function fn_link(scope, element, attrs) {
    var onChange = $parse(attrs.ngFiles);
    element.on('change', function (event) {
      onChange(scope, { $files: event.target.files });
    });
  }
  return {
    link: fn_link
  }
}]);

webEditor.filter("trustUrl", function($sce) {
  return function(Url) {
    return $sce.trustAsResourceUrl(Url);
  };
});


webEditor.directive('resize', function ($window) {
    return function (scope, element) {
        var w = angular.element($window);
        scope.getWindowDimensions = function () {
            return {
                'h': $(window).height(),
                'w': $(window).width()
            };
        };
        scope.$watch(scope.getWindowDimensions, function (newValue, oldValue) {
            scope.windowHeight = newValue.h;
            scope.windowWidth = newValue.w;

            scope.styleWindow = function () {
                return {
                    'height': (newValue.h - 200),
                    'width': (newValue.w - 200)
                };
            };

        }, true);

        w.bind('resize', function () {
            scope.$apply();
        });
    }
});

// $(document).ready(function(){
//   $(".owl-carousel").owlCarousel();
// });