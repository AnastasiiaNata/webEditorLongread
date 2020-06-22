var webPreview = angular.module("webPreview", ['ngResource']);


webPreview.factory('WebEditorRepository', ['$resource', 
  function($resource) { 
    return $resource('longread', null, {
      load: { method: 'GET', url: '/longread/:id/preview/load', isArray: true},
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
  $scope.curlongread = {};


	$scope.init = function(longread, previewStatus){
    $scope.curlongread = longread;
    WebEditorRepository.load({id: $scope.curlongread['id']}, function(response) {
    	$scope.curTempls = response[0];
      // console.log(response);
    	if (Object.keys($scope.curTempls).length > 0) {
        	$scope.statusButtom = true;
      }
      setContent();
      // console.log("Данные получены");
      $scope.curlongread['parameters'] = JSON.parse($scope.curlongread['parameters']);
      if (previewStatus == 1){
        $scope.statusButtom = true;
      }
      else {
        $scope.statusButtom = false;
      }
  	})};

	function setContent(){
    $('.carousel').owlCarousel('destroy');
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
        // console.log($("div").is('#owl-carousel-' + id));
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
      }, 150);
  }

  $scope.owlOptionsTestimonials = {
    autoPlay: 4000,
    stopOnHover: true,
    slideSpeed: 300,
    paginationSpeed: 600,
    items: 2
  }


  $scope.getUrl = function(width, src){
    if (width < 570){
      return src.split('watch?v=')[0] + 'embed/' + src.split('watch?v=')[1].split('&')[0] + '?loop=1&autoplay=1&rel=0';
    }
    else {
      return src.split('watch?v=')[0] + 'embed/' + src.split('watch?v=')[1].split('&')[0] + '?loop=1&autoplay=1&controls=0&rel=0';
    }
  }



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
                'h': $(window).height(),
                'w': $(window).width()
            };
        };
        scope.$watch(scope.getWindowDimensions, function (newValue, oldValue) {
            scope.windowHeight = newValue.h;
            scope.windowWidth = newValue.w;

            scope.styleWidth = function () {
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

// webPreview.animation('.slide-animation', function () {
//   return {
//     addClass: function (element, className, done) {
//       if (className == 'ng-hide') {
//         TweenMax.to(element, 0.5, {left: -element.parent().width(), onComplete: done });
//       }
//       else {
//         done();
//       }
//     },
//     removeClass: function (element, className, done) {
//       if (className == 'ng-hide') {
//         element.removeClass('ng-hide');
//         TweenMax.set(element, { left: element.parent().width() });
//         TweenMax.to(element, 0.5, {left: 0, onComplete: done });
//       }
//       else {
//         done();
//       }
//     }
//   };
// });
