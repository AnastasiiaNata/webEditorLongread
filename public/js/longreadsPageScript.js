var webLongread = angular.module("webLongread", ['ngResource', 'ui.bootstrap', 'ngAnimate', 'ngSanitize']);


webLongread.factory('WebLongreadRepository', ['$resource', 
  function($resource) { 
    return $resource('longread', null, {
      load: { method: 'GET', url: '/longread/load', isArray: true},
      create: { method: 'POST', url: '/longread/create'},
      save: { method: 'POST', url: '/longread/save', isArray: true},
      delete: { method: 'POST', url: '/longread/delete'}
    }); 
  }
 ]);


webLongread.controller("LongreadController", function($scope, $document, WebLongreadRepository, $uibModal, $log){
  $scope.longreads = [];
  $scope.settings = [{'en': "main", 'title': "Основные настройки", 'header': true, 'img': true}, {'en': 'action','title': "Действия", 'delete': true}];
  $scope.images = [];
  $scope.oldImg = [];
  $scope.deleteImg = [];

  $scope.init = function(){
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
        }
      }
      else {
        $scope.images[i] = [{'src': '../../templates/images/10.jpg', 'title': ''}];
      }
    }
  }

  $scope.addLongread = function(){
    WebLongreadRepository.create({}, function(response) {
      console.log("create");
      $scope.init();
    });
  }

  $scope.deleteImage = function(index){
    console.log($scope.deleteImg);
    $scope.deleteImg[$scope.curLong].push($scope.images[$scope.curLong][0]);
    $scope.images[$scope.curLong] = {};
    $scope.longreads[$scope.curLong]["parameters"]["img"] = {};
  }

  $scope.statusSettings = false;


  $scope.openSettings = function($index){
    $scope.statusSettings = true;
    $scope.curLong = $index;
  }

  $scope.closeSettings = function(){
    $scope.statusSettings = false;
    for (key in $scope.status){
      $scope.status[key] = false;
    }
    $scope.status["main"] = true;
  }

  $scope.status = {'main': true, 'action': false};
  $scope.curLong = "";

  $scope.openSet = function($index){
    for (key in $scope.status){
      $scope.status[key] = false;
    }
    $scope.status[$scope.settings[$index]['en']] = true;
  }

  $scope.loadImg = false;

  $scope.loadImage = function(){
    $scope.loadImg = true;
  }


  $scope.getTheFiles = function ($files) {
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
    
    // for (let i = 0; i < $scope.images[$scope.curEdittingBlock].length; i++){
    //   pathOld = "/public/" + $scope.images[$scope.curEdittingBlock][i]["src"].split("/")[2] + "/" + $scope.images[$scope.curEdittingBlock][i]["src"].split("/")[3];
    //   $scope.oldImg[$scope.curEdittingBlock][i] = pathOld;
    // }
    $scope.images[$scope.curLong] = imagesrc;
    $scope.loadImg = false;
  }



  $scope.save = function(){
    $scope.longreads[$scope.curLong]["parameters"] = JSON.parse($scope.longreads[$scope.curLong]["parameters"]);

    if ($scope.longreads[$scope.curLong]["parameters"] == null) {
      $scope.longreads[$scope.curLong]["parameters"] = {'img': [$scope.images[$scope.curLong][0]]};
    }
    else {
      $scope.longreads[$scope.curLong]["parameters"]["img"][0] = $scope.images[$scope.curLong][0];
    }
    $scope.postData = [$scope.longreads[$scope.curLong], $scope.oldImg, $scope.deleteImg];
    console.log($scope.postData);
    WebLongreadRepository.save($scope.postData, function(response) {
      console.log("saved");
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





  