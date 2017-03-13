 
  <!DOCTYPE html>
  <html ng-app="myModal" >  
   
  
  <head >
    <title>Modal</title>
    <script data-require="jquery@1.9.0" data-semver="1.9.0" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.js"></script>
    <link data-require="bootstrap@3.0.0" data-semver="3.0.0" rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" />
    <script data-require="bootstrap@3.0.0" data-semver="3.0.0" src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script data-require="angular.js@1.2.14" data-semver="1.2.14" src="http://code.angularjs.org/1.2.14/angular.js"></script>
    <script >
      var myModal = angular.module('myModal', []);
myModal.controller('mymodalcontroller', function ($scope) { 
    $scope.data = []; 
    for (var i = 0; i < 10; i++) {
        $scope.data.push(i); 
    } 
    $scope.loadUrl = function (url) {
        console.log(url);  
        $scope.body = url;  
    } 
    $scope.header = 'This is the header..';
    $scope.body = '';
    $scope.footer = 'This is the footer';  
    $scope.myRightButton = function (bool) {
            alert('!!! first function call!');
    };
});
  
// trigger modal popup directive 
myModal.directive('modal', function () {
    return {
        restrict: 'EA',
        scope: { 
            title: '=modalTitle',
            header: '=modalHeader',
            body: '=modalBody',
            footer: '=modalFooter',
            callbackbuttonleft: '&ngClickLeftButton',
            callbackbuttonright: '&ngClickRightButton',
            handler: '=lolo'
        },
        templateUrl: 'http://localhost/rocky/send-right-dev/resources/views/pages/popup/partialmodal.html',
        transclude: true,
        controller: function ($scope) {
            $scope.handler = 'pop'; 
        },
    };
});


    </script>
  </head>

  <body data-ng-app="myModal">
    <div ng-controller="mymodalcontroller">  

    <ul data-ng-repeat="i in data">
      <li >  
        <!-- directive -->
        <modal lolo="modal1" modal-body="body" modal-footer="footer" modal-header="header"  data-ng-click-right-button="myRightButton()"> 
        </modal>  
        <!-- clickable button to trigger popup -->
        <a href="#@{{modal1}}" role="button" class="btn btn-success"  data-toggle="modal" data-ng-click="loadUrl( 'google.com' + i )">Launch Demo Modal</a>
        
      </li> 
    </ul> 
    </div> 