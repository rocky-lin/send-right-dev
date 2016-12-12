obj = new Object(); 

if (location.hostname === "localhost" || location.hostname === "127.0.0.1") { 
    obj.siteUrl = 'http://localhost/rocky/send-right-dev'; 
} else { 
    obj.siteUrl = 'http://sendright.net'; 
}

var app = angular.module('myApp', ['ngAnimate', 'ngSanitize', 'mgcrea.ngStrap']); 
 
app.controller('MainCtrl', function($scope) {

     $scope.init = function(value) {
        $scope.testInput= value;    
    }
});  

'use strict'; 
 
//add contact
app.controller('myAddContactCtrl', ['$scope', function($scope) { 

    console.log("add countact angulajs loaded");
}]);  

//edit contact
app.controller('myEditContactCtrl',['$scope', '$http', function($scope, $http) {    
    console.log('edit contact angularjs loaded!');
    // When the edit page is loaded      
    $scope.$watch('contactId', function () { 
        $http({
            method: 'GET',
            url: obj.siteUrl + '/user/contact/'+$scope.contactId+'/get', 
            headers: {
                'Content-type': 'application/json;charset=utf-8'
            }
        })
        .then(function(response) {   
            $scope.firstName = response.data.first_name;
            $scope.lastName = response.data.last_name;
            $scope.email = response.data.email; 
            $scope.location = response.data.location;
            $scope.phoneNumber = response.data.phone_number;
            $scope.telephoneNumber = response.data.telephone_number;  
            $scope.contactType = response.data.type;  
        }, function(rejection) {
            alert("Ohps! something wrong, please contact send right support. Thank you!");
        });  

    });
}]);


//campaign view
app.controller( 'myCampaignViewCtr', ['$scope', '$filter', '$http', '$window', function ($scope, $filter, $http, $window) {
    console.log("Campaign views loaded angulajs!..");
    $scope.currentPage = 0;
    $scope.pageSize = '5';
    $scope.data = [];
    $scope.q = '';
    $scope.deleteCampaign = [];
    $scope.totalCampaign = 0;
    $scope.editCampaign = function(campaign) {

        $window.location.href = obj.siteUrl + '/extension/campaign/index.php?id='+campaign.id;
    };
    $scope.deleteCampaign = function(campaign) {
        if(confirm('are you sure you want to delete this campaign?' + campaign.id)){
            $http({
                method: 'DELETE',
                url: obj.siteUrl + '/user/campaign/' + campaign.id,
                data: {
                    id: campaign.id
                },
                headers: {
                    'Content-type': 'application/json;charset=utf-8'
                }
            })
                .then(function(response) {
                    $scope.deleteCampaign[campaign.id] = true;
                }, function(rejection) {
                    alert("Ohps! something wrong, please campaign send right support. Thank you!");
                });

        } else {
            console.log("cancel delete " + campaign.id);
        }
    };
    $scope.getData = function () {

        return $filter('filter')($scope.data, $scope.q)
    };
    $scope.numberOfPages=function() {

        return Math.ceil($scope.getData().length/$scope.pageSize);
    };

    // When the home page campaign loaded
    $http({
        method: 'GET',
        url:  obj.siteUrl + '/user/campaign/get/all'
    }).then(function successCallback(response) { 
        // console.log(response); 
        for (var i = 0; i<response.data.length; i++) { 
            $scope.data.push(response.data[i]);
            $scope.totalCampaign++;
        }
    }, function errorCallback(response) {
        alert("something wrong! please campaign send right support. Thank you!");
    });
}]);



//contact view
app.controller('myContactsViewCtr', ['$scope', '$filter', '$http', '$window', function ($scope, $filter, $http, $window) { 
    console.log("Contact views loaded angulajs!..");
    $scope.currentPage = 0; 
    $scope.pageSize = '5'; 
    $scope.data = [];
    $scope.q = ''; 
    $scope.deleteContact = []; 
     $scope.totalContact = 0;
    $scope.editContact = function(contact) {  

        $window.location.href = obj.siteUrl + '/user/contact/'+contact.id+'/edit'; 
    } 
  	$scope.deleteContact = function(contact) { 
    	if(confirm('are you sure you want to delete this contact?' + contact.id)){ 
            $http({
                method: 'DELETE',
                url: obj.siteUrl + '/user/contact/' + contact.id,
                data: {
                    id: contact.id
                },
                headers: {
                    'Content-type': 'application/json;charset=utf-8'
                }
            })
            .then(function(response) {
                $scope.deleteContact[contact.id] = true; 
            }, function(rejection) {
                alert("Ohps! something wrong, please contact send right support. Thank you!");
            }); 
            
        } else {
            console.log("cancel delete " + contact.id);
        } 
  	}   
    $scope.getData = function () { 

      return $filter('filter')($scope.data, $scope.q) 
    } 
    $scope.numberOfPages=function() {
        
        return Math.ceil($scope.getData().length/$scope.pageSize);                
    }   

    // When the home page contact loaded
	$http({
	  method: 'GET',
	  url:  obj.siteUrl + '/user/contact/get/all'
	}).then(function successCallback(response) {   
	    for (var i = 0; i<response.data.length; i++) {
	    	$scope.data.push(response.data[i]);
            $scope.totalContact++; 
	    } 
    }, function errorCallback(response) { 
        alert("something wrong! please contact send right support. Thank you!"); 
    });    
}]);  

// list   
app.controller('myListsViewCtr', ['$scope', '$filter', '$http', '$window', function ($scope, $filter, $http, $window) { 
  
    console.log("lists  views loaded angulajs!..");
    $scope.currentPage = 0; 
    $scope.pageSize = '5'; 
    $scope.data = [];
    $scope.q = ''; 
    $scope.deleteList = []; 
    $scope.totalList = 0;
    $scope.editList = function(list) {  

        $window.location.href = obj.siteUrl + '/user/list/'+list.id+'/edit'; 
    } 
    $scope.deleteList = function(list) { 

        if(confirm('are you sure you want to delete this list?')){ 
            $http({
                method: 'DELETE',
                url: obj.siteUrl + '/user/list/' + list.id,
                data: {
                    id: list.id
                },
                headers: {
                    'Content-type': 'application/json;charset=utf-8'
                }
            })
            .then(function(response) {
                $scope.deleteList[list.id] = true; 
            }, function(rejection) {
                alert("Ohps! something wrong, please contact send right support. Thank you!");
            }); 
            
        } else {
            console.log("cancel delete " + list.id);
        } 
    }   
    $scope.getData = function () { 

      return $filter('filter')($scope.data, $scope.q) 
    } 
    $scope.numberOfPages=function() {

        return Math.ceil($scope.getData().length/$scope.pageSize);                
    }   

    // When the home page list loaded
    $http({
      method: 'GET',
      url:  obj.siteUrl + '/user/list/get/all'
    }).then(function successCallback(response) {   
     
        for (var i = 0; i<response.data.length; i++) {
            $scope.data.push(response.data[i]);
            $scope.totalList++; 
        }   
    }, function errorCallback(response) { 
        alert("something wrong! please contact send right support. Thank you!"); 
    });    
}]);  
 
 // list create, edit and suggested contacts
app.controller('myListCreateViewCtr', ['$scope', '$filter', '$http', '$window', function ($scope, $filter, $http, $window) {   
    // $scope.document = function() {   
        console.log("List create views loaded angulajs!..");
        $scope.isContactSelected = [];
        $scope.currentPage = 0; 
        $scope.pageSize = '5'; 
        $scope.data = [];
        $scope.q = ''; 
        $scope.deleteContact = []; 
        $scope.totalContact = 0;
        $scope.selectedContactArray = [];

        $scope.editContact = function(contact) {  

            $window.location.href = obj.siteUrl + '/user/contact/'+contact.id+'/edit'; 
        } 

        $scope.deleteContact = function(contact) { 

            if(confirm('are you sure you want to delete this contact?' + contact.id)){ 
                $http({
                    method: 'DELETE',
                    url: obj.siteUrl + '/user/contact/' + contact.id,
                    data: {
                        id: contact.id
                    },
                    headers: {
                        'Content-type': 'application/json;charset=utf-8'
                    }
                })
                .then(function(response) {
                    $scope.deleteContact[contact.id] = true; 
                }, function(rejection) {
                    alert("Ohps! something wrong, please contact send right support. Thank you!");
                }); 
                
            } else {
                console.log("cancel delete " + contact.id);
            } 
        }   

        $scope.getData = function () { 

          return $filter('filter')($scope.data, $scope.q) 
        } 

        $scope.numberOfPages = function() {
            
            return Math.ceil($scope.getData().length/$scope.pageSize);                
        }    
     
        /**
         * [selectContact when user select a contact then it should be stored to an array, this is usfull when hitting next and prev]
         * @param  {[type]} contact [description]
         * @return {[type]}         [description]
         */
        $scope.selectContact = function(contact) {  
            $scope.setCheckBoxUnSelectedContact(); 
            var array = $scope.selectedContactArray;  
            if (array.indexOf(contact.id) === -1) {
                $scope.selectedContactArray.push(contact.id);  
                // console.log("contact added");
            } else { 
                var index = array.indexOf(contact.id);
                if (index > -1) {
                    $scope.selectedContactArray.splice(index, 1);
                }  
                // console.log("contact is removed");
            }  
            // console.log($scope.selectedContactArray);
            $scope.setCheckBoxSelectedContact();     
            // return $scope.selectedContactArray;
        }     

        $scope.setCheckBoxSelectedContact = function() {   
            // console.log($scope.selectedContactArray);  
            for (var i = 0; i <  $scope.selectedContactArray.length; i++) {
                $scope.isContactSelected[$scope.selectedContactArray[i]] = true;  
            }    
        }

        $scope.setCheckBoxUnSelectedContact = function() {   
            // console.log($scope.selectedContactArray);  
            for (var i = 0; i <  $scope.selectedContactArray.length; i++) {
                $scope.isContactSelected[$scope.selectedContactArray[i]] = false;  
            }
        } 
        // when edit page loaded get all default contact list set
        $scope.$watch('listId', function () { 
            $http({
              method: 'GET',
              url:  obj.siteUrl + '/user/list/get/'+$scope.listId+'/contacts'
            }).then(function successCallback(response) {    
                for (var i = 0; i<response.data.length; i++) {
                  $scope.selectedContactArray.push(response.data[i].contact_id); 
                } 
                 $scope.setCheckBoxSelectedContact();
            }, function errorCallback(response) {  
                alert("something wrong! please contact send right support. Thank you!"); 
            });    
        }); 
        // When the home page contact loaded
        $http({
          method: 'GET',
          url:  obj.siteUrl + '/user/contact/get/all'
        }).then(function successCallback(response) {   
            for (var i = 0; i<response.data.length; i++) {
                $scope.data.push(response.data[i]);
                $scope.totalContact++; 
            } 
        }, function errorCallback(response) { 

            alert("something wrong! please contact send right support. Thank you!"); 
        });     
    // } 
}]);      



/**
 *  This is the controller for general in lists
 */
//contact view
app.controller('myListCtr', ['$scope', '$filter', '$http', '$window', function ($scope, $filter, $http, $window) { 
    console.log("Contact views loaded angulajs!..");
    $scope.currentPage = 0; 
    $scope.pageSize = '5'; 
    $scope.data = [];
    $scope.q = ''; 
    $scope.deleteContact = []; 
    $scope.totalContact = 0;
  

   $scope.editContact = function(contact) {  
        
        $window.location.href = obj.siteUrl + '/user/contact/'+contact.id+'/edit'; 
    } 
    $scope.deleteContact = function(contact) { 
        if(confirm('are you sure you want to delete this contact?' + contact.id)){ 
            $http({
                method: 'DELETE',
                url: obj.siteUrl + '/user/contact/' + contact.id,
                data: {
                    id: contact.id
                },
                headers: {
                    'Content-type': 'application/json;charset=utf-8'
                }
            })
            .then(function(response) {
                $scope.deleteContact[contact.id] = true; 
            }, function(rejection) {
                alert("Ohps! something wrong, please contact send right support. Thank you!");
            }); 
            
        } else {
            console.log("cancel delete " + contact.id);
        } 
    }   


    $scope.getData = function () {  
      return $filter('filter')($scope.data, $scope.q) 
    } 

    $scope.numberOfPages=function() { 
        return Math.ceil($scope.getData().length/$scope.pageSize);                
    }   
    // alert("load content");
    // When the home page contact loaded  
    $scope.$watch('listId', function () {  
        // alert("test");
        // alert($scope.listId);
        // alert($scope.listId)
        $http({

          method: 'GET',
          url:  obj.siteUrl + '/user/form/'+$scope.listId+'/contacts/get'

        }).then(function successCallback(response) {   

            // console.log(response);
            // alert('test');
             
            for (var i = 0; i<response.data.length; i++) {

                $scope.data.push(response.data[i]);
                $scope.totalContact++; 

            } 

        }, function errorCallback(response) { 
            alert("something wrong! please contact send right support. Thank you!"); 
        });     
    }); 
}]);  


/**
 *  This is the one controlling the form view page
 */
app.controller('myFormViewCtr', ['$scope', '$filter', '$http', '$window', function ($scope, $filter, $http, $window) { 
    console.log("Form views loaded angulajs!..");
    $scope.currentPage = 0; 
    $scope.pageSize = '5'; 
    $scope.data = [];
    $scope.q = ''; 
    $scope.deleteForm = []; 
     $scope.totalForm = 0;

    $scope.viewFormContacts = function(form) {    
        // alert("redirect to contact views");
        $window.location.href = obj.siteUrl + '/user/form/' + form.id + '/contacts/view';   
    }  

    $scope.viewNowForm = function(form) {    
        $window.location.href = obj.siteUrl + '/extension/form/create/editor/forms/'+form.folder_name+'/index.php';   
    } 
 
    $scope.editForm = function(form) {   
        $window.location.href = obj.siteUrl + '/extension/form/create/editor/?id='+form.folder_name; 
    } 

    $scope.deleteForm = function(form) { 
        if(confirm('are you sure you want to delete this form?')){ 
            $http({
                method: 'DELETE',
                url: obj.siteUrl + '/user/form/' + form.id,
                data: {
                    id: form.id
                },
                headers: {
                    'Content-type': 'application/json;charset=utf-8'
                }
            })
            .then(function(response) {
                $scope.deleteForm[form.id] = true; 
            }, function(rejection) {
                alert("Ohps! something wrong, please form send right support. Thank you!");
            }); 
            
        } else {
            console.log("cancel delete " + form.id);
        } 
    }   
    $scope.getData = function () { 

      return $filter('filter')($scope.data, $scope.q) 
    } 
    $scope.numberOfPages=function() {
        
        return Math.ceil($scope.getData().length/$scope.pageSize);                
    }   

    // When the home page Form loaded
    $http({
      method: 'GET',
      url:  obj.siteUrl + '/user/form/get/all'
    }).then(function successCallback(response) {   
        for (var i = 0; i<response.data.length; i++) {
            $scope.data.push(response.data[i]);
            $scope.totalForm++; 
        } 
    }, function errorCallback(response) { 
        alert("something wrong! please form send right support. Thank you!"); 
    });    
}]);  
 
/**
 *  General use of code for sorting
 */
app.filter('startFrom', function() {
    return function(input, start) {
        start = +start;
        return input.slice(start);
    } 
}); 
 



/**
 * Drop Down in create form
 *  connecting to a lists and should show auto suggest drop down
 */
angular.module('myApp')
.controller('myListConnectCtrl', function($scope, $templateCache, $http) {


    console.log("type head started ");
    console.log("siteUrl" + $scope.siteUrl);
    $scope.icons = [];
    //$scope.selectedAddress = '';
    // $scope.editList = function(list) {  

    //     $window.location.href = obj.siteUrl + '/user/list/'+list.id+'/edit'; 
    // } 


    $scope.getLists = function(viewValue) {
      var str = (viewValue  == '' )? "" : "/" + viewValue;
      return $http.get( obj.siteUrl + '/user/list/search' + str)
      .then(function(res) {
          return res.data;
      });
    };
});





// list create, edit and suggested contacts
app.controller('myListSelectCtr', ['$scope', '$filter', '$http', '$window', function ($scope, $filter, $http, $window) {
    // $scope.document = function() {
    console.log("List create views loaded angulajs!..");
    $scope.isContactSelected = [];
    $scope.currentPage = 0;
    $scope.pageSize = '5';
    $scope.data = [];
    $scope.q = '';
    $scope.deleteContact = [];
    $scope.totalContact = 0;
    $scope.selectedContactArray = [];

    $scope.editContact = function(contact) {

        $window.location.href = obj.siteUrl + '/user/contact/'+contact.id+'/edit';
    }

    $scope.deleteContact = function(contact) {

        if(confirm('are you sure you want to delete this contact?' + contact.id)){
            $http({
                method: 'DELETE',
                url: obj.siteUrl + '/user/contact/' + contact.id,
                data: {
                    id: contact.id
                },
                headers: {
                    'Content-type': 'application/json;charset=utf-8'
                }
            })
                .then(function(response) {
                    $scope.deleteContact[contact.id] = true;
                }, function(rejection) {
                    alert("Ohps! something wrong, please contact send right support. Thank you!");
                });

        } else {
            console.log("cancel delete " + contact.id);
        }
    }

    $scope.getData = function () {

        return $filter('filter')($scope.data, $scope.q)
    }

    $scope.numberOfPages = function() {

        return Math.ceil($scope.getData().length/$scope.pageSize);
    }

    /**
     * [selectContact when user select a contact then it should be stored to an array, this is usfull when hitting next and prev]
     * @param  {[type]} contact [description]
     * @return {[type]}         [description]
     */
    $scope.selectContact = function(contact) {
        $scope.setCheckBoxUnSelectedContact();
        var array = $scope.selectedContactArray;
        if (array.indexOf(contact.id) === -1) {
            $scope.selectedContactArray.push(contact.id);
        } else {
            var index = array.indexOf(contact.id);
            if (index > -1) {
                $scope.selectedContactArray.splice(index, 1);
            }
        }
        $scope.setCheckBoxSelectedContact();
    };

    // set check box as selected and based on the input selected list id or default list id
    $scope.setCheckBoxSelectedContact = function() {
        // console.log($scope.selectedContactArray);
        for (var i = 0; i <  $scope.selectedContactArray.length; i++) {
            $scope.isContactSelected[$scope.selectedContactArray[i]] = true;
        }
    };

    // set check box as un selected and based on the input selected list id or default list id
    $scope.setCheckBoxUnSelectedContact = function() {
        // console.log($scope.selectedContactArray);
        for (var i = 0; i <  $scope.selectedContactArray.length; i++) {
            $scope.isContactSelected[$scope.selectedContactArray[i]] = false;
        }
    };


    // load the default list data selecte before
    // usually this is from the database and when hit edit to to the list or any other that connected to this list
    // then it should show the default selected list and selected checkboxes
    $scope.loadDefaultLists = function(list_id) {
        
       console.log("doc loaded" + list_id);
        var listIdArr = list_id.split(',');

        for (var i = 0; i<listIdArr.length; i++) {
            console.log(" default list id "  +   listIdArr[i]);
            $scope.selectedContactArray.push(parseInt(listIdArr[i]));
        }
        $scope.setCheckBoxSelectedContact();
    };

    // when edit page loaded get all default contact list set
    //$scope.$watch('default_list_ids', function () {
        //$http({
        //    method: 'GET',
        //    url:  obj.siteUrl + '/user/list/get/'+$scope.listId+'/contacts'
        //}).then(function successCallback(response) {
        //for (var i = 0; i<$scope.default_list_ids.length; i++) {
        //
        //    alert($scope.default_list_ids[0]);
            //$scope.selectedContactArray.push($scope.data[i].contact_id);
        //}
        //    $scope.setCheckBoxSelectedContact();
        //}, function errorCallback(response) {
        //    alert("something wrong! please contact send right support. Thank you!");
        //});
    //});
    //
    // When the home page contact loaded
    $http({
        method: 'GET',
        url:  obj.siteUrl + '/user/list/get/all'
    }).then(function successCallback(response) {
        for (var i = 0; i<response.data.length; i++) {
            $scope.data.push(response.data[i]);
            $scope.totalContact++;
        }
    }, function errorCallback(response) {

        alert("something wrong! please contact send right support. Thank you!");
    });
    // }
}]);



