var app = angular.module('myApp', []);
app.controller('myAddContactCtrl', function($scope) { 
    // $scope.firstName = "John"; 
}); 

/**
 * This is the controller of the view contacts page or 
 * http://www.domain.com/user/contact
 */
// alternate - https://github.com/michaelbromley/angularUtils/tree/master/src/directives/pagination
// alternate - http://fdietz.github.io/recipes-with-angular-js/common-user-interface-patterns/paginating-through-client-side-data.html 
app.controller('myContactsViewCtr', ['$scope', '$filter', '$http', function ($scope, $filter, $http) { 
    $siteUrl = 'http://localhost/rocky/send-right-dev';
    //  $scope.userContactGetAllUri = 'default';
    // $scope.loadUserContactGetAllUri = function (userContactGetAllUri) { 
    //     $scope.userContactGetAllUri =  userContactGetAllUri;
    //     console.log("value " +     $scope.userContactGetAllUri); 
    //     // return  $scope.userContactGetAllUri;
    // } 
    console.log("function uri " + $scope.userContactGetAllUri); 
    $scope.currentPage = 0; 
    $scope.pageSize = '20';
   //  console.log("print the hidden value ");
   // console.log($scope.userContactGetAllUri);  
    // set total show of column
    // $scope.items = [{ id: 10,label: 10}, {id: 20,label: 20}, {id: 30,label: 30}, {id: 40,label: 40}];
    // $scope.pageSize = $scope.items[0]; 
    $scope.data = [];
    $scope.q = ''; 
  	$scope.delete = function(item) {
    	confirm('are you sure you want to delete this contact?' + item); 
  	} 
    $scope.getData = function () { 
      return $filter('filter')($scope.data, $scope.q) 
    } 
    $scope.numberOfPages=function() {
        return Math.ceil($scope.getData().length/$scope.pageSize);                
    }  
    // for (var i=0; i<1; i++) {
    //     $scope.data.push("Item "+i);
    // }  
    // Simple GET request example: 
	$http({
	  method: 'GET',
	  url:  $siteUrl + '/user/get/all'
	}).then(function successCallback(response) {   
	    for (var i = 0; i<response.data.length; i++) {
	    	$scope.data.push(response.data[i]);
	    } 
	   }, function errorCallback(response) { 
	  }); 
    // Sort and order by
    // $scope.propertyName = 'first_name';
    // $scope.reverse = true;
    // $scope.data  = orderBy($scope.data, $scope.propertyName, $scope.reverse); 
    // $scope.sortBy = function(propertyName) {
    //     $scope.reverse = (propertyName !== null && $scope.propertyName === propertyName)
    //         ? !$scope.reverse : false;
    //     $scope.propertyName = propertyName;
    //     $scope.friends = orderBy(friends, $scope.propertyName, $scope.reverse);
    // }; 
}]);// end contact view ctr  
//We already have a limitTo filter built-in to angular,
//let's make a startFrom filter
app.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
}); 
