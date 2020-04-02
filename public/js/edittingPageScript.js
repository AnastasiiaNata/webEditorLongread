var webEditor = angular.module("webEditor", ['ngResource', 'ngSanitize']);


webEditor.factory('WebEditorRepository', ['$resource', 
  function($resource) { 
    return $resource('longread', null, {
      load: { method: 'GET', url: '/longread/:id/load', isArray: true},
      save: { method: 'POST', url: '/longread/:id/save', isArray: true}
    }); 
  }
 ]);


webEditor.controller("TemplController", function($scope, $document, WebEditorRepository){
  $scope.templates = [];
  $scope.curTempls = [];
  $scope.mainText = [];
  $scope.style = [];
  $scope.init = function(longreadId){
    WebEditorRepository.load({id: longreadId}, function(response) {
      $scope.curTempls = response[0];
      if (Object.keys($scope.curTempls).length > 0) {
        $scope.statusButtom = true;
      }
      setContent();
      $scope.templates = response[1];
      console.log("Данные получены");
  })};

  function setContent(){
    for (var i = 0; i < Object.keys($scope.curTempls).length; i++) {
      data = JSON.parse($scope.curTempls[i]["content"]);
      $scope.mainText[i] = {};
      for (let key in data["text"]){
        $scope.mainText[i][key] = data["text"][key];
      }
      // dataStyle = JSON.parse($scope.curTempls[i]["styles"]);
      // $scope.style[i] = {};
      // for (let key in dataStyle){
      //   if (typeof(dataStyle[key]) == "Object"){
      //     console.log("t");
      //   }
      // }
    }
  }

  

  $scope.statusLibrary = false;
  $scope.statusButtom = false;
  $scope.statusStyleSection = false;
  $scope.curEdittingBlock = 0;



	$scope.addTemple = function($index){
    if (angular.isNumber($scope.curPosition)){
      
      curTemplsArr = [];
      for (var i = 0; i < Object.keys($scope.curTempls).length; i++){
        curTemplsArr.push($scope.curTempls[i]);
      }
      curTemplsArr.splice($scope.curPosition, 0, $scope.templates[$index]);
      data = JSON.parse($scope.templates[$index]["content"]);

      $scope.mainText.splice($scope.curPosition, 0, {});
      for (let key in data["text"]){
        $scope.mainText[$scope.curPosition][key] = data["text"][key];
      }

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
      data = JSON.parse($scope.templates[$index]["content"]);

      $scope.mainText[length] = {};
      for (let key in data["text"]){ 
        $scope.mainText[length][key] = data["text"][key];
      }    

      dataStyle = JSON.parse($scope.templates[$index]["styles"]);
      $scope.style[length] = {};
      for (let key2 in dataStyle){
        $scope.style[length][key2] = dataStyle[key2];
      }
    }
    console.log($scope.style);
    $scope.statusButtom = true;
    $scope.statusLibrary = false;
	}


  $scope.saveTemples = function(longreadId){
    for (var i = 0; i < Object.keys($scope.curTempls).length; i++){
      $scope.curTempls[i]["content"] = (typeof $scope.curTempls[i]["content"] === "string") ? JSON.parse($scope.curTempls[i]["content"]):$scope.curTempls[i]["content"];
      $scope.curTempls[i]["styles"] = (typeof $scope.curTempls[i]["content"] === "string") ? JSON.parse($scope.curTempls[i]["styles"]):$scope.curTempls[i]["styles"];
      
      for (key in $scope.curTempls[i]["content"]["text"]) {
        $scope.curTempls[i]["content"]["text"][key] = $scope.mainText[i][key];
      }
    }
    WebEditorRepository.save({id: longreadId}, $scope.curTempls, function(response) {
      console.log("saving");
      });
  }

  $scope.delete = function($index){
    console.log($index);
    curTemplsArr = [];
    mainTextArr = [];
    for (var i = 0; i < Object.keys($scope.curTempls).length; i++){
      curTemplsArr.push($scope.curTempls[i]);
    }
    
    curTemplsArr.splice($index, 1);
    console.log(curTemplsArr);
    $scope.mainText.splice($index, 1);
    console.log($scope.mainText);

    data = [];
    for (var i = 0; i < curTemplsArr.length; i++){
      data[i] = [i, curTemplsArr[i]];
    }
      
    $scope.curTempls = Object.fromEntries(data);
  }

  $scope.move = function($index, direction){
    curContext = $scope.mainText[$index];
    curTempl = $scope.curTempls[$index];
    $scope.delete($index);
    
    if (direction == 1){
      $scope.curPosition = $index - 1;
    }
    else{
      $scope.curPosition = $index + 1;
    }
    $scope.mainText.splice($scope.curPosition, 0, curContext);
    curTemplsArr.splice($scope.curPosition, 0, curTempl);
    data = [];
    for (var i = 0; i < curTemplsArr.length; i++){
      data[i] = [i, curTemplsArr[i]];
    }
      
    $scope.curTempls = Object.fromEntries(data);
  }

  

  $scope.openLibrary = function($index){
    $scope.statusLibrary = true;
    $scope.curPosition = $index;
  }

  $scope.closeLibrary = function(){
    $scope.statusLibrary = false;
  }

  $scope.openStyleSection = function($index){
    $scope.statusStyleSection = true;
    $scope.curEdittingBlock = $index;
    clearStyleFormItems();
    setStyleFormItems();
  }

  $scope.closeStyleSection = function(){
    $scope.statusStyleSection = false;
  }

  $scope.block_width = ['50', '60', '70', '80', '90', '100'];
  $scope.alignment = ['По левому краю', 'По центру', 'По правому краю'];
  $scope.font_family = ['Tahoma', 'Comic Sans MS', 'Montserrat', 'Arial', 'Microsoft Sans Serif', 'Palatino Linotype'];
  $scope.vertical_alignment = ['По верху', 'По центру', 'По низу'];

  
  $scope.templatesStyle = {'width': false, 'justify_content': false, 'align_items': false, 'height':false, 'title':false,
                      'uptitle':false, 'subtitle':false, 'main_text':false, 'text_align':false};


  function setStyleFormItems(){
    data = JSON.parse($scope.curTempls[$scope.curEdittingBlock]["styles"]);
    for (key in data){
      for (key2 in $scope.templatesStyle){
        if (key == key2){
          $scope.templatesStyle[key] = true;
        }
      }
    }

    // for (key in $scope.templatesStyle){
    //   if ($scope.templatesStyle[key] == true) {

    //   }
    // }
  }

  function clearStyleFormItems(){
    for (key in $scope.templatesStyle){
      $scope.templatesStyle[key] = false;
    }
  }

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