var webPreview = angular.module("webPreview", ['ngResource']);


webPreview.factory('WebEditorRepository', ['$resource', 
  function($resource) { 
    return $resource('longread', null, {
      load: { method: 'GET', url: '/preview/:id/load', isArray: true}
    }); 
  }
 ]);


webPreview.controller("PreviewController", function($scope, $document, WebEditorRepository){
	$scope.templates = [];
	$scope.curTempls = [];
	$scope.mainText = [];
	$scope.images = [];
	$scope.style = [];
	$scope.videos = [];


	$scope.init = function(longreadId){
    WebEditorRepository.load({id: longreadId}, function(response) {
    	$scope.curTempls = response[0];
    	if (Object.keys($scope.curTempls).length > 0) {
        	$scope.statusButtom = true;
      	}
      	setContent();
      	// $scope.templates = response[1];
      	console.log("Данные получены");
  	})};

	function setContent(){
	    for (var i = 0; i < Object.keys($scope.curTempls).length; i++) {
	   		// $scope.curTempls[i]["fileName"] = '../' + $scope.curTempls[i]["fileName"];
	      	data = JSON.parse($scope.curTempls[i]["content"]);
	      	$scope.mainText[i] = {};
	      	for (let key in data["text"]){
	        	$scope.mainText[i][key] = data["text"][key];
	      	}
	      
	      	for (let j = 0; j < data["img"].length; j++){
	        	if (data["img"][j]["src"].includes("../..") == false) {
	          		path = "/storage/" + data["img"][j]["src"].split("/")[2] + "/" + data["img"][j]["src"].split("/")[3];
	          		data["img"][j]["src"] = path;
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




});