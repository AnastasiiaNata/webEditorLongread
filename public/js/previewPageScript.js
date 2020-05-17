var webPreview = angular.module("webPreview", ['ngResource']);


webPreview.factory('WebEditorRepository', ['$resource', 
  function($resource) { 
    return $resource('longread', null, {
      load: { method: 'GET', url: '/longread/:id/preview/load', isArray: true}
    }); 
  }
 ]);


webPreview.controller("PreviewController", function($scope, $document, WebEditorRepository, $window){
	$scope.templates = [];
	$scope.curTempls = [];
	$scope.mainText = [];
	$scope.images = [];
	$scope.style = [];
	$scope.oldImg = [];
	$scope.deleteImgServer = [];
	$scope.videos = [];
	$scope.editPage = false;
  $scope.statusButtom = false;


	$scope.init = function(longreadId, previewStatus){
    WebEditorRepository.load({id: longreadId}, function(response) {
    	$scope.curTempls = response[0];
    	if (Object.keys($scope.curTempls).length > 0) {
        	$scope.statusButtom = true;
      }
      setContent();
      	// $scope.templates = response[1];
      console.log("Данные получены");
      if (previewStatus == 1){
        $scope.statusButtom = true;
      }
      else {
        $scope.statusButtom = false;
      }
      // console.log($scope.curTempls);
      // console.log($scope.mainText);
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

    $scope.currentSlide = 0;
  
  $scope.setCurrentSlideIndex = function(index) {
    $scope.currentSlide = index;
  };
  
  $scope.isCurrentSlideIndex = function(index) {
    return $scope.currentSlide === index;
  };


  $scope.prevSlide = function($index) {
    $scope.currentSlide = ($scope.currentSlide > 0) ? --$scope.currentSlide : Object.keys($scope.images[$index]).length - 1;
  };

  $scope.nextSlide = function($index) {
    $scope.currentSlide = ($scope.currentSlide < Object.keys($scope.images[$index]).length - 1) ? ++$scope.currentSlide : 0;
  };




});


webPreview.filter("trustUrl", function($sce) {
  return function(Url) {
    return $sce.trustAsResourceUrl(Url);
  };
});


webPreview.directive('resize', function ($window) {
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
});

webPreview.animation('.slide-animation', function () {
  return {
    addClass: function (element, className, done) {
      if (className == 'ng-hide') {
        TweenMax.to(element, 0.5, {left: -element.parent().width(), onComplete: done });
      }
      else {
        done();
      }
    },
    removeClass: function (element, className, done) {
      if (className == 'ng-hide') {
        element.removeClass('ng-hide');
        TweenMax.set(element, { left: element.parent().width() });
        TweenMax.to(element, 0.5, {left: 0, onComplete: done });
      }
      else {
        done();
      }
    }
  };
});
