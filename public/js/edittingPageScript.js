var webEditor = angular.module("webEditor", ['ngResource', 'ngRoute', 'ngSanitize', 'color.picker', 'video-background']);


webEditor.factory('WebEditorRepository', ['$resource', 
  function($resource) { 
    return $resource('longread', null, {
      load: { method: 'GET', url: '/longread/:id/load', isArray: true},
      save: { method: 'POST', url: '/longread/:id/save', isArray: true}
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

  $scope.init = function(longreadId){
    WebEditorRepository.load({id: longreadId}, function(response) {
      $scope.curTempls = response[0];
      if (Object.keys($scope.curTempls).length > 0) {
        $scope.statusButtom = true;
      }
      setContent();
      $scope.templates = response[1];
      console.log("Данные получены");
      console.log($scope.oldImg);
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
    }
  }

  

  $scope.statusLibrary = false;
  $scope.statusButtom = false;
  $scope.statusStyleSection = false;
  $scope.statusContentSection = false;
  $scope.loadImg = false;
  $scope.loadVid = false;
  $scope.curEdittingBlock = 0;



	$scope.addTemple = function($index){
    if (angular.isNumber($scope.curPosition)){
      
      curTemplsArr = [];
      for (var i = 0; i < Object.keys($scope.curTempls).length; i++){
        curTemplsArr.push($scope.curTempls[i]);
      }
      curTemplsArr.splice($scope.curPosition, 0, $scope.templates[$index]);
      $scope.oldImg.splice($scope.curPosition, 0, []);

      data = JSON.parse($scope.templates[$index]["content"]);
      // console.log(data);

      // Добавление текста

      $scope.mainText.splice($scope.curPosition, 0, {});
      for (let key in data["text"]){
        $scope.mainText[$scope.curPosition][key] = data["text"][key];
      }

      // Добавление изображений

      $scope.images.splice($scope.curPosition, 0, {});
      for (let key in data["img"]){
        $scope.images[$scope.curPosition][key] = data["img"][key];
      }

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

      data = JSON.parse($scope.templates[$index]["content"]);

      $scope.mainText[length] = {};
      for (let key in data["text"]){ 
        $scope.mainText[length][key] = data["text"][key];
      }
      $scope.images[length] = {};
      for (let key in data["img"]){ 
        $scope.images[length][key] = data["img"][key];
      }  

      $scope.videos[length] = {};
      if (data["video"] != undefined){
        for (let key in data["video"]){ 
          $scope.videos[length][key] = data["video"][key];
        }
      }

      dataStyle = JSON.parse($scope.templates[$index]["styles"]);
      $scope.style[length] = {};
      for (let key2 in dataStyle){
        $scope.style[length][key2] = dataStyle[key2];
      }
    }
    // console.log($scope.oldImg);
    $scope.statusButtom = true;
    $scope.statusLibrary = false;
	}


  $scope.saveTemples = function(longreadId){
    console.log($scope.deleteImgServer);
    for (var i = 0; i < Object.keys($scope.curTempls).length; i++){
      $scope.curTempls[i]["content"] = (typeof $scope.curTempls[i]["content"] === "string") ? JSON.parse($scope.curTempls[i]["content"]):$scope.curTempls[i]["content"];
      $scope.curTempls[i]["styles"] = (typeof $scope.curTempls[i]["styles"] === "string") ? JSON.parse($scope.curTempls[i]["styles"]):$scope.curTempls[i]["styles"];
      
      for (key in $scope.curTempls[i]["content"]["text"]) {
        $scope.curTempls[i]["content"]["text"][key] = $scope.mainText[i][key];
      }
      if (Object.keys($scope.images[i]).length != 0) {
        for (let j = 0; j < Object.keys($scope.images[i]).length; j++){
          $scope.curTempls[i]["content"]["img"][j] = $scope.images[i][j];
          console.log($scope.images[i][j]);
          if ($scope.images[i][j].src.includes("/storage/")) {
            console.log($scope.oldImg[i]);
            $scope.oldImg[i].splice(j, 1);
          }
        }
      }
      else {
        $scope.curTempls[i]["content"]["img"] = {};
      }
      
      // console.log($scope.videos[i]);
      if (Object.keys($scope.videos[i]).length != 0) {
        for (let j = 0; j < Object.keys($scope.videos[i]).length; j++){
          $scope.curTempls[i]["content"]["video"][j] = $scope.videos[i][j];
        }
      }
      else {
        $scope.curTempls[i]["content"]["video"] = {};
      }

      for (key in $scope.curTempls[i]["styles"]){
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

    data = [];
    for (var i = 0; i < curTemplsArr.length; i++){
      data[i] = [i, curTemplsArr[i]];
    }
      
    $scope.curTempls = Object.fromEntries(data);
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
    clearStyleFormItems();
    setStyleFormItems();
  }

  $scope.closeStyleSection = function(){
    $scope.statusStyleSection = false;
  }

  $scope.openContentSection = function($index){
    $scope.InVideo = Object.keys($scope.videos[$scope.curEdittingBlock]).length;
    $scope.statusContentSection = true;
    $scope.statusLibrary = false;
    $scope.curEdittingBlock = $index;
    $scope.statusStyleSection = false;
    clearContentFormItems();
    setContentFormItems();
  }

  $scope.closeContentSection = function(){
    $scope.statusContentSection = false;
    $scope.loadVid = false;
  }

  $scope.deleteVideo = function($index){
    $scope.videos[$scope.curEdittingBlock] = [];
    $scope.InVideo = 0;
  }

  $scope.deleteImg = function($index){
    curTemplsArr = [];
    for (var i = 0; i < Object.keys(JSON.parse($scope.curTempls[$scope.curEdittingBlock]["content"])["img"]).length; i++){
      curTemplsArr.push($scope.curTempls[i]);
    }
    
    curTemplsArr.splice($index, 1);

    data = [];
    if (curTemplsArr.length != 0){
      for (var i = 0; i < curTemplsArr.length; i++){
        data[i] = [i, curTemplsArr[i]];
      }
        
      $scope.curTempls = Object.fromEntries(data);
    }
    else {
      JSON.parse($scope.curTempls[$scope.curEdittingBlock]["content"])["img"] = {};
    }


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
    
  }

  $scope.block_width = ['50', '55', '60', '65', '70', '75', '80', '85', '90', '95', '100'];
  $scope.alignment = [{"ru": 'По левому краю', "en": 'flex-start'}, {"ru": 'По центру', "en": 'center'}, {"ru": 'По правому краю', "en": 'flex-end'}];
  $scope.text_alignment = [{"ru": 'По левому краю', "en": 'left'}, {"ru": 'По центру', "en": 'center'}, {"ru": 'По правому краю', "en": 'right'}];
  $scope.font_family = ['Tahoma', 'Comic Sans MS', 'Montserrat', 'Arial', 'Microsoft Sans Serif', 'Palatino Linotype'];
  $scope.vertical_alignment = [{"ru": 'По верху', "en": 'flex-start'}, {"ru": 'По центру', "en": 'center'}, {"ru": 'По низу', "en": 'flex-end'}];
  $scope.direction = [{"ru": 'Картинка справа', "en": 'row'}, {"ru": 'Картинка слева', "en": 'row-reverse'}];

  
  $scope.templatesStyle = {'width': false, 'justify_content': false, 'align_items': false, 'height':false, 'title':false,
                      'overhead':false, 'subtitle':false, 'main_text':false, 'text_align':false, 'direction':false};

  $scope.templatesContent = {'title': false, 'overhead': false, 'subtitle': false, 'text':false, 'img': false, 'video':false};


  function setStyleFormItems(){
    data = (typeof $scope.curTempls[$scope.curEdittingBlock]["styles"] === "string") ? JSON.parse($scope.curTempls[$scope.curEdittingBlock]["styles"]):$scope.curTempls[$scope.curEdittingBlock]["styles"];
    for (key in data){
      for (key2 in $scope.templatesStyle){
        if (key == key2){
          $scope.templatesStyle[key] = true;
        }
      }
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
      console.log(data['img'].length);
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


  $scope.getTheFiles = function ($files) {
    imagesrc = [];
    
    for (var i = 0; i < $files.length; i++) {
      var reader = new FileReader();
      reader.fileName = $files[i].name; // Наименование загруженного файла

      reader.onload = function (event) {
        var image = {};
        image.name = event.target.fileName;
        image.size = (event.total / 1024).toFixed(2);
        image.src = event.target.result;
        imagesrc.push(image);
        $scope.$apply();
      }
      reader.readAsDataURL($files[i]);  

    }
    
    // for (let i = 0; i < $scope.images[$scope.curEdittingBlock].length; i++){
    //   pathOld = "/public/" + $scope.images[$scope.curEdittingBlock][i]["src"].split("/")[2] + "/" + $scope.images[$scope.curEdittingBlock][i]["src"].split("/")[3];
    //   $scope.oldImg[$scope.curEdittingBlock][i] = pathOld;
    // }
    $scope.images[$scope.curEdittingBlock] = imagesrc;
    
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




webEditor.directive('contenteditable', ['$sce', function($sce) {
  return {
    restrict: 'A', // only activate on element attribute
    require: '?ngModel', // get a hold of NgModelController
    link: function(scope, element, attrs, ngModel) {
      if (!ngModel) return; // do nothing if no ng-model

      // Specify how UI should be updated
      ngModel.$render = function() {
        element.html($sce.getTrustedHtml(ngModel.$viewValue || ''));
      };

      // Listen for change events to enable binding
      element.on('blur keyup change', function() {
        scope.$evalAsync(read);
      });
      // read(); // initialize


      ngModel.$modelValue = scope.$eval(attrs.ngModel);
      ngModel.$setViewValue(ngModel.$modelValue);
      ngModel.$render();



      // Write data to the model
      function read() {
        var html = element.html();
        // When we clear the content editable the browser leaves a <br> behind
        // If strip-br attribute is provided then we strip this out
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
                'h': w.height(),
                'w': w.width()
            };
        };
        scope.$watch(scope.getWindowDimensions, function (newValue, oldValue) {
            scope.windowHeight = newValue.h;
            scope.windowWidth = newValue.w;

            scope.style = function () {
                return {
                    'height': (newValue.h - 100) + 'px',
                        'width': (newValue.w - 100) + 'px'
                };
            };

        }, true);

        w.bind('resize', function () {
            scope.$apply();
        });
    }
})