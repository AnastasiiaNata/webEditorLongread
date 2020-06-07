var webLongread = angular.module("webLongread", ['ngResource', 'ui.bootstrap', 'ngAnimate', 'ngSanitize']);


webLongread.factory('WebLongreadRepository', ['$resource', 
  function($resource) { 
    return $resource('longread', null, {
      load: { method: 'GET', url: '/longread/load', isArray: true},
      create: { method: 'POST', url: '/longread/create'},
      save: { method: 'POST', url: '/longread/save', isArray: true},
      delete: { method: 'POST', url: '/longread/delete'},
      publish: { method: 'POST', url: '/longread/publish', isArray: true}
    }); 
  }
 ]);


webLongread.controller("LongreadController", function($scope, $document, WebLongreadRepository, $uibModal, $log){
  $scope.longreads = [];
  $scope.settings = [{'en': "main", 'title': "Основные настройки", 'header': true, 'img': true}, {'en': 'action','title': "Действия", 'delete': true}];
  $scope.images = [];
  $scope.oldImg = [];
  $scope.deleteImg = [];
  $scope.settingsLongread = {};
  $scope.favicons = [];

  $scope.init = function(){
    $scope.documentLocation = document.location.protocol + '//' + document.location.host;
    WebLongreadRepository.load(function(response) {
      $scope.longreads = response;
      setContent();
      console.log("Данные получены");
      console.log($scope.longreads);
    });
  }

  function setContent(){
    for (var i = 0; i < Object.keys($scope.longreads).length - 2; i++) {
      $scope.oldImg[i] = [];
      $scope.deleteImg[i] = [];
      $scope.favicons[i] = [];
      if ($scope.longreads[i]["parameters"] != null) {
        if ($scope.longreads[i]["parameters"] !== undefined){
          data = JSON.parse($scope.longreads[i]["parameters"]);
          if (Object.keys(data["img"][0]).length > 0) {
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
            $scope.images[i] = data["img"];
          }

          if (data["favicon"][0]["src"].includes("/icons/") == false) {
            pathOld = "/public/" + data["favicon"][0]["src"].split("/")[2] + "/" + data["favicon"][0]["src"].split("/")[3];
            path = "/storage/" + data["favicon"][0]["src"].split("/")[2] + "/" + data["favicon"][0]["src"].split("/")[3];
            data["favicon"][0]["src"] = path;
            $scope.oldImg[i]['icon'] = pathOld;
          }
          else {
            data["favicon"][0]["src"] = data["favicon"][0]["src"];
          } 
          $scope.favicons[i][0] = data["favicon"][0];
        }
      }
      else {
        $scope.images[i] = [{'src': '../../templates/images/10.jpg', 'title': ''}];
        $scope.favicons[i][0] = {};
        $scope.favicons[i][0]['src'] = '/icons/project.ico';
        $scope.longreads[i]["parameters"] = {};
        $scope.longreads[i]["parameters"]['img'] = $scope.images[i];
        $scope.longreads[i]["parameters"]['favicon'] = $scope.favicons[i];
      }
      
      // $scope.settingsLongread['url'] = $scope.longreads[i]['url'];
    }
  }

  $scope.addLongread = function(){
    WebLongreadRepository.create({}, function(response) {
      console.log("create");
      $scope.init();
    });
  }

  $scope.deleteImage = function(index, type){
    console.log($scope.deleteImg);
    console.log($scope.longreads[$scope.curLong]);
    if (type == 'img') {
      $scope.deleteImg[$scope.curLong].push($scope.images[$scope.curLong][0]);
      $scope.images[$scope.curLong] = {};
      // $scope.longreads[$scope.curLong]["parameters"]["img"] = {};
    }
    else {
      $scope.deleteImg[$scope.curLong].push($scope.favicons[$scope.curLong][0]);
      $scope.favicons[$scope.curLong][0] = {};
      console.log($scope.longreads[$scope.curLong]);
      // $scope.longreads[$scope.curLong]["parameters"]["favicon"] = {};
    }
  }

  $scope.statusSettings = false;


  $scope.openSettings = function($index){
    $scope.statusSettings = true;
    $scope.curLong = $index;
    $scope.settingsLongread['url'] = $scope.longreads[$scope.curLong]['url'];
  }

  $scope.closeSettings = function(){
    $scope.statusSettings = false;
    for (key in $scope.status){
      $scope.status[key] = false;
    }
    $scope.status["main"] = true;

    $scope.settingsLongread['url'] = $scope.longreads[$scope.curLong]['url'];
    $scope.showErrorExist = false;
    $scope.showErrorValue = false;
    $scope.statusChangeURL = false;
    $scope.loadIc = false;
  }
  // console.log($scope.longreads[$scope.curLong]);
  
  $scope.status = {'main': true, 'action': false};
  $scope.curLong = "";
  
  $scope.statusChangeURL = false;

  $scope.changedURL = function() {
    if ($scope.settingsLongread["url"] != $scope.longreads[$scope.curLong]["url"]){
      $scope.statusChangeURL = true;
    }
  }

  $scope.openSet = function($index){
    for (key in $scope.status){
      $scope.status[key] = false;
    }
    $scope.status[$scope.settings[$index]['en']] = true;
  }

  $scope.loadImg = false;
  $scope.loadIc = false;

  $scope.loadImage = function(){
    $scope.loadImg = true;
  }

  $scope.loadIcon = function(){
    $scope.loadIc = true;
  }


  $scope.getTheFiles = function ($files, type) {
    imagesrc = [];
    for (var i = 0; i < $files.length; i++) {
      var reader = new FileReader();
      reader.fileName = $files[i].name; // Наименование загруженного файла

      reader.onload = function (event) {
        var image = {};
        image.title = event.target.fileName;
        image.size = (event.total / 1024).toFixed(2);
        image.src = event.target.result;
        imagesrc.push(image);
        $scope.$apply();
      }
      reader.readAsDataURL($files[i]);  

    }
    
    if (type == 'icon'){
      $scope.favicons[$scope.curLong] = imagesrc;
      $scope.loadIc = false;
    }
    else if (type = 'img'){
      $scope.images[$scope.curLong] = imagesrc;
      $scope.loadImg = false;
    }
  }



  $scope.save = function(id_longread){
    if ($scope.curLong == "" && id_longread != undefined){
      posLong = id_longread;
    }
    else {
      posLong = $scope.curLong;
    }
    console.log(id_longread);
    console.log($scope.longreads[posLong]);
    $scope.longreads[posLong]["parameters"] = (typeof $scope.longreads[posLong]["parameters"] === "string") ? JSON.parse($scope.longreads[posLong]["parameters"]) : $scope.longreads[posLong]["parameters"];
    
    
    for (let i = 0; i < Object.keys($scope.images[posLong]).length; i++){
      if ($scope.images[posLong][i]["src"].includes("/storage/")) {
        $scope.oldImg[posLong][i] = null;
      }
    }
    if ($scope.favicons[posLong][0]["src"].includes("/storage/")) {
      $scope.oldImg[posLong]['icon'] = null;
    }
    if ($scope.longreads[posLong]["parameters"] == null) {
      $scope.longreads[posLong]["parameters"] = {'img': [$scope.images[posLong][0]]};
      $scope.longreads[posLong]["parameters"]['favicon'] = $scope.favicons[posLong];
    }
    else {
      $scope.longreads[posLong]["parameters"]["img"][0] = $scope.images[posLong][0];
      $scope.longreads[posLong]["parameters"]['favicon'] = $scope.favicons[posLong];
    }

    $scope.longreads[posLong]["url"] = $scope.settingsLongread['url'];
    if ($scope.longreads[posLong]["url"] === undefined){
      $scope.longreads[posLong]["url"] = "";
    }
    $scope.postData = [$scope.longreads[posLong], $scope.oldImg, $scope.deleteImg];
    console.log($scope.postData);
    time = new Date().getSeconds();
    console.log(time);
    WebLongreadRepository.save($scope.postData, function(response) {
      
      time2 = new Date().getSeconds();
      console.log(time2);
      console.log(response);
      if (response[0] == 0){
        if ($scope.statusChangeURL) {
          $scope.showErrorExist = true;
          $scope.showErrorValue = false;
        }
      }
      else if (response[0] == -1){
        if ($scope.statusChangeURL) {
          $scope.showErrorValue = true;
          $scope.showErrorExist = false;
        }
      }
      else {
        console.log("saved");
        $scope.showLongread = true;
        $scope.showErrorExist = false;
        $scope.showErrorValue = false;
      }
    });
  }


  $scope.deleteLongread = function(){
    $scope.closeSettings();
    $scope.postData = $scope.longreads[$scope.curLong]['id'];
    WebLongreadRepository.delete($scope.postData, function(response) {
      console.log("deleted");
    });
    $scope.longreads.splice($scope.curLong, 1);
    $scope.images.splice($scope.curLong, 1);
  }


  $scope.statusPublish = false;
  $scope.showLongread = false;
  $scope.showErrorExist = false;
  $scope.showErrorValue = false;
  $scope.published = false;
  $scope.pubLong = 0;



  $scope.openPublish = function($index){
    $scope.statusPublish = true;
    $scope.pubLong = $index;
    if ($scope.longreads[$index]["url"] == null){
        $scope.published = false;
    }
    else {
      $scope.published = true;
      $scope.showLongread = true;
    }
  }


  $scope.closePublish = function(){
    $scope.statusPublish = false;
    // $scope.openBurger();
  }

  $scope.publishLongread = function(){
    $scope.postData = [];
    $scope.postData[0] = $scope.settingsLongread.url;
    $scope.postData[1] = $scope.longreads[$scope.pubLong]['id'];
    WebLongreadRepository.publish($scope.postData, function(response) {
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


});



webLongread.directive('ngFiles', ['$parse', function ($parse) {
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

webLongread.filter("trustUrl", function($sce) {
  return function(Url) {
    return $sce.trustAsResourceUrl(Url);
  };
});





  