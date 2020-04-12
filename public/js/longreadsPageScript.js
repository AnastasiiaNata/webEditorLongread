var webLongread = angular.module("webLongread", ['ngResource']);


webLongread.factory('WebEditorRepository', ['$resource', 
  function($resource) { 
    return $resource('longread', null, {
      load: { method: 'GET', url: '/longread/:id/load', isArray: true},
      save: { method: 'POST', url: '/longread/:id/save', isArray: true}
    }); 
  }
 ]);


webLongread.controller("LongreadController", function($scope, $document, WebEditorRepository){
  $scope.longreads = [];

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
