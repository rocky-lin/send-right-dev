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
        templateUrl: 'partialmodal.html',
        transclude: true,
        controller: function ($scope) {
            $scope.handler = 'pop'; 
        },
    };
});