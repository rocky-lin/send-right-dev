obj = new Object();

if (location.hostname === "localhost" || location.hostname === "127.0.0.1") { 
    obj.siteUrl = 'http://localhost/rocky/send-right-dev'; 
} else { 
    obj.siteUrl = 'http://sendright.net'; 
}

var app = angular.module('myApp', ['ngAnimate', 'ngSanitize', 'mgcrea.ngStrap', 'ui.bootstrap']);

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
    $scope.pageSize = '20';
    $scope.data = [];
    $scope.q = '';
    $scope.deleteCampaign = [];
    $scope.totalCampaign = 0;
    $scope.filteredTodos = []; 
    $scope.numPerPage = 10;
    $scope.maxSize = 10;

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
    // Sort display all the campaings


    //$scope.testingFunc = function (data) {

        //alert("test" + data);

    //};
    $scope.campaignDisplayByKind = function(kind) {

        console.log("kind = " + kind);
        $scope.campaignKindLoader = true;
        $scope.showCampaignInitLoader = true;

        $scope.myStyle={'display':'block'};


        //alert("test");
        var url = obj.siteUrl;

        if(kind == 'all') {
            url = url + '/user/campaign/get/all';
        } else   {
            url = url + '/user/campaign/get/all/by/kind/'+kind;
        }

        $http({
            method: 'GET',
            url: url,
        }).then(function successCallback(response) {

            $scope.data = [];
            $scope.totalCampaign = 0;
            $scope.myStyle={'display':'none'};
            // console.log(response);
            for (var i = 0; i < response.data.length; i++) {
                $scope.data.push(response.data[i]);
                $scope.totalCampaign++;
            }
            $scope.showCampaignInitLoader = false;
            $scope.campaignKindLoader = false; 

        }, function errorCallback(response) {
            $scope.myStyle={'display':'none'};
            //$scope.campaignKindLoader = false;
            $scope.showCampaignInitLoader = false;
            alert("something wrong! please campaign send right support. Thank you!");
        });
    };
 
    // initialized data
    // $scope.campaignDisplayByKind('all');



    // pagination

    $scope.numPages = function () {
        return Math.ceil($scope.data.length / $scope.pageSize)-1;
    };

    var begin = 1;

    console.log( " scope number pages " +  Math.ceil($scope.data.length / $scope.numPerPage));

    // detect where the page selected
    $scope.$watch('currentPage + numPerPage', function() {
        var begin = (($scope.currentPage - 1) * $scope.numPerPage)
            , end = begin + $scope.numPerPage;

        $scope.filteredTodos = $scope.data.slice(begin, end);
    });

    console.log($scope.data);

    $scope.$watch('pageSize', function () {
        $scope.numPages();
        $scope.getData() ;
    });
 
    // add label  
    $scope.saveNewLabel = function ()  { 
        console.log("save new label now name "    + $scope.name  ) ;   
        if($scope.name == null)  {
            $scope.label_popup_message = true; 
        } else {
            $scope.label_popup_message = false; 
            // post request to insert new label    
             $http({
                method: 'POST',
                url: obj.siteUrl + '/user/label',
                data: { type:'campaign', name:$scope.name },
                headers: {
                    'Content-type': 'application/json;charset=utf-8'
                }
            })
            .then(function(response) { 
                $window.location.reload(); 
                // console.log(response);
            }, function(rejection) {
                console.log("Ohps! something wrong, please campaign send right support. Thank you!");
            }); 
        } 
    }

    // delete label 
    
    $scope.deleteNewLabel  = function () { 
        $http({ 
            method: 'DELETE',  
            url: obj.siteUrl + '/user/label/'+$scope.label_id,  
            data: { id:$scope.label_id}, 
            headers: {
                'Content-type': 'application/json;charset=utf-8'
            }  
        })
        .then(function(response) { 
            $window.location.reload();  
        }, function(rejection) {
            console.log("Ohps! something wrong, please campaign send right support. Thank you!");
        });  
    } 



    // load label
    $scope.loadAllByLabel = function(id) {
         $scope.showCampaignLabelLoader[id] = true;
      $http({ 
            method: 'GET',  
            url: obj.siteUrl + '/user/campaign/get/all/label/'+id,  
            data: { id:id}, 
            headers: {
                'Content-type': 'application/json;charset=utf-8'
            }   
         }).then(function successCallback(response) {   
            $scope.data = [];
            for (var i = 0; i<response.data.length; i++) {
                $scope.data.push(response.data[i]); 
            } 
             $scope.showCampaignLabelLoader[id] = false;
        }, function(rejection) {
            console.log("Ohps! something wrong, please campaign send right support. Thank you!");
             $scope.showCampaignLabelLoader[id] = false;
        });    
    }
    
}]);



//contact view
app.controller('myContactsViewCtr', [ '$scope', '$filter', '$http', '$window', function ($scope, $filter, $http, $window) {

    console.log("Contact views loaded angulajs!..");

    $scope.currentPage = 1;
    $scope.pageSize = '20';
    $scope.data = [];
    $scope.q = ''; 
    $scope.deleteContact = []; 
    $scope.totalContact = 0;
    $scope.numPerPage = 10;
    $scope.maxSize = 10;
    $scope.results = [];

    //$scope.contact_search_model = '';

    $scope.editContact = function(contact) {  

        $window.location.href = obj.siteUrl + '/user/contact/'+contact.id+'/edit'; 
    };

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
  	};

    $scope.getData = function () {
        return $filter('filter')($scope.data, $scope.search);
    };

    $scope.numberOfPages=function() {
        return Math.ceil($scope.getData().length/$scope.pageSize);
    };

    $scope.add_entry_for_total_page_size = function(){
        // push data from db
        for (var i = 0; i < $scope.pageSize; i++) {
            $scope.data.push(['']);
        }
    };

    $scope.dataLoaded = function() {
        // When the home page contact loaded


        // load data
        $http({
            method: 'GET',
            url: obj.siteUrl + '/user/contact/get/all'
        }).then(function successCallback(response) {
            $scope.results = response;

            $scope.load_content_data(response, false);
            //for (var i = 0; i < response.data.length; i++) {
            //    $scope.data.push(response.data[i]);
            //    $scope.totalContact++;
            //}
        }, function errorCallback(response) {
            alert("something wrong! please contact send right support. Thank you!");
        });
    };

    $scope.dataLoaded();

    $scope.numPages = function () {
        return Math.ceil($scope.getData().length / $scope.pageSize);
    };

    $scope.selectPage = function() {
        alert("alert");
    };
    // search contact
    $scope.contact_search = function (event) {
        console.log( " event keycode = " + event.keyCode);  //this will show the ASCII value of the key pressed
        if(event.keyCode === 13 || $scope.contact_search_model == '') {
            console.log("start searching now " + $scope.contact_search_model);

            // compose url

            var keyword = $scope.contact_search_model;

            console.log(" keyword "  + keyword);

            if(keyword === '') {
                console.log("empty ");
                keyword = 'all';
            } else {
                console.log(" not empty ");
            }

            var url = obj.siteUrl + '/user/contact/search/' + keyword;

            $scope.contact_query_ajax(url);


        }
    };

    $scope.filterByStatus = function(filterName) {
       var url = obj.siteUrl + '/user/contact/filter/status/' + filterName;
        console.log(" url " + url);

        $scope.contact_query_ajax(url);

    };

    $scope.filterByList = function(filterName) {
        var url = obj.siteUrl + '/user/contact/filter/list/' + filterName;
        //console.log(" url " + url);
        $scope.contact_query_ajax(url);

    };

    $scope.filterByTag = function($filterName) {
        var url = obj.siteUrl + '/user/contact/filter/tag/' + keyword;
        console.log(" url " + url);
    };

    $scope.filterByOrder = function($filterName) {
        var url = obj.siteUrl + '/user/contact/filter/order/' + keyword;
        console.log(" url " + url);
    };


    $scope.makeTodos = function() {

        $scope.data = [];

        for (i=1;i<=Math.floor((Math.random() * 100) + 1);i++) {
            $scope.data.push({
                "email": i + "mrjesuserwins@gmail.com",
                "type": "mrjesuserwins@gmail.com",
                "status": "mrjesuserwins@gmail.com",
                "last_name": "mrjesuserwins@gmail.com",
                "first_name": "mrjesuserwins@gmail.com"
            });
        }
    };

    // query contact from database and add to display
    $scope.contact_query_ajax = function(url) {

        $http({
            method: 'GET',
            url: url
        }).then(function successCallback(response) {

            $scope.results = response;
            $scope.totalContact = 0;
            $scope.data = [];
            $scope.currentPage = 1;

            $scope.load_content_data(response, false);

            //// space for
            //$scope.add_entry_for_total_page_size();
            //
            //// push data from db
            //for (var i = 0; i < response.data.length; i++) {
            //    $scope.data.push(response.data[i]);
            //    $scope.totalContact++;
            //}
            //console.log(response.data);
            //$scope.makeTodos();

        }, function errorCallback(response) {
            alert("something wrong! please contact send right support. Thank you!");
        });
    };


    $scope.$watch('pageSize', function () {
        console.log("test page size changed " + $scope.pageSize);
        $scope.load_content_data($scope.results, false);
    });


    $scope.toogleColumn = function() {
        $scope.data = $scope.data.reverse();
    };


    $scope.load_content_data = function (response, addEmpyRow) {


        if(addEmpyRow == true) {
            $scope.add_entry_for_total_page_size();
        }
        // push data from db
        for (var i = 0; i < response.data.length; i++) {
            $scope.data.push(response.data[i]);
            $scope.totalContact++;
        }
    }

}]);



































// list   
app.controller('myListsViewCtr', ['$scope', '$filter', '$http', '$window', function ($scope, $filter, $http, $window) {




    console.log("lists  views loaded angulajs!..");
    $scope.currentPage = 0;
    $scope.pageSize = '20';
    $scope.data = [];
    $scope.q = ''; 
    $scope.deleteList = []; 
    $scope.totalList = 0;
    $scope.filteredTodos = [];
    $scope.numPerPage = 10;
    $scope.maxSize = 10;


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
        $scope.results = response;
        for (var i = 0; i<response.data.length; i++) {
            $scope.data.push(response.data[i]);
            $scope.totalList++; 
        }   
    }, function errorCallback(response) { 
        alert("something wrong! please contact send right support. Thank you!"); 
    });



    // pagination

    $scope.numPages = function () {
        return Math.ceil($scope.data.length / $scope.pageSize)-1;
    };

    var begin = 1;

    console.log( " scope number pages " +  Math.ceil($scope.data.length / $scope.numPerPage));

    // detect where the page selected
    $scope.$watch('currentPage + numPerPage', function() {
        var begin = (($scope.currentPage - 1) * $scope.numPerPage)
            , end = begin + $scope.numPerPage;

        $scope.filteredTodos = $scope.data.slice(begin, end);
    });

    console.log($scope.data);

    $scope.$watch('pageSize', function () {
        $scope.numPages();
        $scope.getData() ;
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
    $scope.pageSize = '20';
    $scope.data = [];
    $scope.q = ''; 
    $scope.deleteForm = []; 
    $scope.totalForm = 0;
    $scope.filteredTodos = [];
    $scope.numPerPage = 10;
    $scope.maxSize = 10;

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
    $scope.InitForm = function() {   
        $scope.showFormInitLoader = true;  
        $http({
          method: 'GET',
          url:  obj.siteUrl + '/user/form/get/all'
        }).then(function successCallback(response) {   
            $scope.data = []; 
            $scope.totalForm = 0;
            for (var i = 0; i<response.data.length; i++) {
                $scope.data.push(response.data[i]);
                $scope.totalForm++; 
            } 
            $scope.showFormInitLoader = false;
        }, function errorCallback(response) { 
            alert("something wrong! please form send right support. Thank you!"); 
            $scope.showFormInitLoader = false;
        });
    } 
    $scope.InitForm(); 

    // pagination   
    $scope.numPages = function () {
        return Math.ceil($scope.data.length / $scope.pageSize)-1;
    };

    var begin = 1;

    console.log( " scope number pages " +  Math.ceil($scope.data.length / $scope.numPerPage));

    // detect where the page selected
    $scope.$watch('currentPage + numPerPage', function() {
        var begin = (($scope.currentPage - 1) * $scope.numPerPage)
            , end = begin + $scope.numPerPage;

        $scope.filteredTodos = $scope.data.slice(begin, end);
    });

    console.log($scope.data);

    $scope.$watch('pageSize', function () {
        $scope.numPages();
        $scope.getData() ;
    });


    // add new label
    $scope.saveNewLabel = function ()  { 
    console.log("save new label now name "    + $scope.name  ) ;    
    if($scope.name == null)  {
        $scope.label_popup_message = true; 
    } else {
        $scope.label_popup_message = false;  
        // post request to insert new label    
         $http({
                method: 'POST',
                url: obj.siteUrl + '/user/label',
                data: { type:'form', name:$scope.name },
                headers: {
                    'Content-type': 'application/json;charset=utf-8'
                }
            })
            .then(function(response) {  
                $window.location.reload(); 
                // console.log(response);
            }, function(rejection) {
                console.log("Ohps! something wrong, please campaign send right support. Thank you!");
            }); 
        } 
    } 

    // delete new label 
    $scope.deleteNewLabel  = function () { 
        $http({ 
            method: 'DELETE',  
            url: obj.siteUrl + '/user/label/'+$scope.label_id,  
            data: { id:$scope.label_id}, 
            headers: {
                'Content-type': 'application/json;charset=utf-8'
            }  
        })
        .then(function(response) { 
            $window.location.reload();  
        }, function(rejection) {
            console.log("Ohps! something wrong, please campaign send right support. Thank you!");
        });  
    } 

    // load label
    $scope.loadAllByLabel = function(id) {
         $scope.showFormLabelLoader[id] = true;
         $http({ 
            method: 'GET',  
            url: obj.siteUrl + '/user/form/get/all/label/'+id,  
            data: { id:id}, 
            headers: {
                'Content-type': 'application/json;charset=utf-8'
            }   
        }).then(function successCallback(response) {   
            $scope.data = [];
            for (var i = 0; i<response.data.length; i++) {
                $scope.data.push(response.data[i]); 
            } 
             $scope.showFormLabelLoader[id] = false;
        }, function(rejection) {
            console.log("Ohps! something wrong, please campaign send right support. Thank you!");
             $scope.showFormLabelLoader[id] = false;
        });     
    } 
 


    /**  click checkbox show label dropdown, check all and check individual */
    $scope.checked_all = []; 
    $scope.checked_all_model = []; 
    $scope.selected_item = [];  
    $scope.manageCheckStatus = function () {  
        $scope.selected_item = [];   
        $scope.selected_item = [];  
        /**  push data to list of selected item  */
        $scope.data.forEach(function(item) {      
            if ($scope.checked_all_model[item.id] == true) {  
                $scope.selected_item.push(item.id); 
            } else {  
            }
        });     
        /** show hide list dropdown */
        if( $scope.selected_item.length > 0) {
            $scope.assignLabelDropdownShow = true;
        } else {
            $scope.assignLabelDropdownShow = false;
        } 
        console.log($scope.selected_item);    
    }  
    /** Save assignment of label */
    $scope.assignLabel = function(label_id) {  

        $scope.assignListShow = true; 
        

        $http({ 
            method: 'POST',  
            url: obj.siteUrl + '/user/label-detail',  
            data: { table_ids:$scope.selected_item, table_name:'forms', label_id:$scope.labelSelectedId}, 
            headers: {
                'Content-type': 'application/json;charset=utf-8'
            }   
        }).then(function successCallback(response) {   
            alert("successfully added to a list");
            $scope.assignListShow = false; 
        }, function(rejection) {
            console.log("Ohps! something wrong, please campaign send right support. Thank you!"); 
            $scope.assignListShow = false; 
        });     
    



        console.log("save label assignment now"); 



    }




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
    $scope.pageSize = '20';
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
    // 
    // 
    // 
    // 
    // Pagination 
     
   $scope.numPages = function () {
        return Math.ceil($scope.data.length / $scope.pageSize)-1;
    };

    var begin = 1;
 
    // detect where the page selected
    $scope.$watch('currentPage + numPerPage', function() {
        var begin = (($scope.currentPage - 1) * $scope.numPerPage)
            , end = begin + $scope.numPerPage;

        $scope.filteredTodos = $scope.data.slice(begin, end);
    });
  
    $scope.$watch('pageSize', function () {
        $scope.numPages();
        $scope.getData() ;
    });

}]);















// Account Controller 

// list create, edit and suggested contacts
app.controller('myUserAccountCtrl', ['$scope', '$filter', '$http', '$window', function ($scope, $filter, $http, $window) { 
        
        $scope.accountInfoInit = [];    
         
        // Change password
            //Typing in field current password
            $scope.$watch('current_password', function(newValue, oldValue) {  
                $scope.old_password_invalid = false; 
                if($scope.old_password == newValue) {
                    $scope.old_password_class = "alert alert-success";
                    $scope.old_password_invalid = true; 
                    $scope.old_password_text =  "Password matched to old password"; 
                }   else {  
                    $scope.old_password_class = "alert alert-danger";
                    $scope.old_password_invalid = true; 
                    $scope.old_password_text = "Didn't matched to old password"; 
                }   
            });  

            // Typing in field new password and repeat password
            $scope.$watchCollection('[new_password, repeat_new_password]', function(newValue, oldValue) {   
            console.log("typing");
                $scope.new_password_invalid = false; 
                console.log(newValue[0]);
                if(newValue == null) {
                    $scope.new_password_class = "alert alert-danger";
                    $scope.new_password_invalid = true; 
                    $scope.passwordAllowUpdate = false; 
                    $scope.new_password_text = "new password required";  
                } else if (newValue[0].length  < 5 ) {  
                    $scope.new_password_class = "alert alert-danger";
                    $scope.new_password_invalid = true; 
                    $scope.new_password_text =  "Required min password is 5";
                    $scope.passwordAllowUpdate = false; 
                } else if(newValue[0] == newValue[1]) {
                    $scope.new_password_class = "alert alert-success";
                    $scope.new_password_invalid = true; 
                    $scope.new_password_text =  "Password matched to old password";
                    $scope.passwordAllowUpdate = true; 
                }   else if(newValue[0] != newValue[1]) {  
                    $scope.new_password_class = "alert alert-danger";
                    $scope.new_password_invalid = true; 
                    $scope.new_password_text =  "Password didn't matched to repeat password "; 
                    $scope.passwordAllowUpdate = false; 
                }   else {
                    $scope.passwordAllowUpdate = false; 
                    $scope.new_password_invalid = false;  
                }
            }); 
     
            $scope.changePassword = function() { 
                console.log($scope.current_password + " " + $scope.new_password );  
                console.log("changing password now!");  
                // send ajax request via post  
                $http({
                method: 'POST',
                url:  obj.siteUrl + '/user/update-password',
                data: { password:$scope.new_password },
                headers : {  'X-XSRF-TOKEN' : '2sltge4Q2lVTdF8dFVTjyABHm1Mdqk2mBA59k4X8' }, 
                }).then(function successCallback(response) { 
                    $scope.new_password_text = response.data; 
                    console.log(response); 
                }, function errorCallback(response) { 
                    alert("something wrong! please contact send right support. Thank you!");
                }); 
            };
        // Change account information   
            $scope.updateAccount = function() {  
                console.log("update account now");  

               $scope.accountInfoUpdateLoaderStyle = {'display': 'block', 'margin-top': '6px', 'margin-left': '13px'}; 
            $http({
                method: 'POST',
                url:  obj.siteUrl + '/user/update-account',
                data: { name:$scope.user_full_name,email:$scope.user_email, sendright_email:$scope.sendright_email,company:$scope.user_company,time_zome:$scope.user_time_zome,user_name:$scope.user_name },
                headers : { 'X-XSRF-TOKEN' : '2sltge4Q2lVTdF8dFVTjyABHm1Mdqk2mBA59k4X8' }, 
                }).then(function successCallback(response) { 
                    $scope.new_password_text = response.data; 
                    console.log(response);  
                    $scope.accountStatus(true, 'info', response);  
                }, function errorCallback(response) { 
                    // console.log("something wrong! please contact send right support. Thank you!");
                     $scope.accountStatus(true, 'danger', 'something wrong'); 
                }); 
            };
            // add data to fields as initialized
            $scope.$watch('accountInfoInit', function(newValue, oldValue)   { 
               $scope.user_full_name =  newValue.name; 
                $scope.user_email = newValue.email;
                $scope.user_company = newValue.company;
                $scope.user_time_zome = newValue.time_zone;
                $scope.user_name = newValue.user_name;
                $scope.sendright_email = newValue.sendright_email; 
 
                //console.log(" billing address " + newValue.details.billing_address);
                // $scope.accountInfoStatusShow  = false;


                // billing address
                $scope.address = newValue.details.billing_address;
                $scope.streetAddress = newValue.details.billing_address_street;
                $scope.addressLine2 = newValue.details.billing_address_line_2;
                $scope.city = newValue.details.billing_address_city;
                $scope.state = newValue.details.billing_address_state;
                $scope.zipCode = newValue.details.billing_address_zip_code;




                // credit card

                $scope.billing_card_holder_name = newValue.details.billing_card_holder_name;
                $scope.billing_card_number = newValue.details.billing_card_number;
                $scope.billing_card_month_expiry = newValue.details.billing_card_month_expiry;
                $scope.billing_card_year_expiry = newValue.details.billing_card_year_expiry;
                $scope.billing_card_cvv = newValue.details.billing_card_cvv;



            });
            console.log("account controller loaded - angular js");  
 
            $scope.accountStatus = function(show, status, message) { 
                $scope.accountInfoStatusModel = message.data; 
                $scope.accountInfoStatusShow  = true; 
                $scope.accountInfoStatusClass  = 'alert alert-' +status+ ' alert-dismissable';  

               $scope.accountInfoUpdateLoaderStyle = {'display': 'none'}; 
            }

        // Update billing address

            $scope.updateBillingAddress = function() {

                console.log(" address " + $scope.address);
                 console.log($scope.streetAddress +
                 $scope.addressLine2 +
                 $scope.city +
                 $scope.state +

                 $scope.zipCode);

                    $http({
                        method: 'POST',
                        url:  obj.siteUrl + '/user/update-billing-address',
                        data: { billing_address:$scope.address,billing_address_street:$scope.streetAddress,billing_address_line_2:$scope.addressLine2, billing_address_city:$scope.city,
                        billing_address_state:$scope.state, billing_address_zip_code:$scope.zipCode},
                        headers : { 'X-XSRF-TOKEN' : '2sltge4Q2lVTdF8dFVTjyABHm1Mdqk2mBA59k4X8' },
                    }).then(function successCallback(response) {

                        alert('Successfully updated billing address');
                        $scope.new_password_text = response.data;
                        console.log(response);
                        //$scope.accountStatus(true, 'info', response);
                    }, function errorCallback(response) {
                        // console.log("something wron! please contact send right support. Thank you!");
                        $scope.accountStatus(true, 'danger', 'something wrong');
                    });
            };

            // Update credit card info
            $scope.updateCreditCardDetails  = function() {
                $http({
                    method: 'POST',
                    url:  obj.siteUrl + '/user/update-billing-credit-card',
                    data: {
                        billing_card_holder_name:$scope.billing_card_holder_name,
                        billing_card_number:$scope.billing_card_number,
                        billing_card_month_expiry:$scope.billing_card_month_expiry,
                        billing_card_year_expiry:$scope.billing_card_year_expiry,
                        billing_card_cvv:$scope.billing_card_cvv
                    },
                    headers : { 'X-XSRF-TOKEN' : '2sltge4Q2lVTdF8dFVTjyABHm1Mdqk2mBA59k4X8' },
                }).then(function successCallback(response) {

                    alert('Successfully updated credit card info');
                    $scope.new_password_text = response.data;
                    console.log(response);
                    //$scope.accountStatus(true, 'info', response);
                }, function errorCallback(response) {
                    // console.log("something wrong! please contact send right support. Thank you!");
                    $scope.accountStatus(true, 'danger', 'something wrong');
                });
            };


        

}]);



// app.controller('optinSettingsPopup', ['$scope', '$filter', '$http', '$window', function ($scope, $filter, $http, $window) { 

//     console.log("loaded optin popup") 

// }]);

// app.controller('optinSettingsPopup', function($scope) {

//          console.log("loaded optin popup") 
// });  

// app.directive('initModel', function($compile) {
//     return {
//         restrict: 'A',
//         link: function(scope, element, attrs) {
//             scope[attrs.initModel] = element[0].value;
//             element.attr('ng-model', attrs.initModel);
//             element.removeAttr('init-model');
//             $compile(element)(scope);
//         }
//     };
// }

// list create, edit and suggested contacts
app.controller('myTemplateThemeCtr', ['$scope', '$filter', '$http', '$window', function ($scope, $filter, $http, $window) {
    // $scope.document = function() {
    console.log("List create views loaded angulajs!..");
    $scope.isContactSelected = [];
    $scope.currentPage = 0;
    $scope.pageSize = '20';
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
        url:  obj.siteUrl + '/user/campaign/template'
    }).then(function successCallback(response) {
        for (var i = 0; i<response.data.length; i++) {
            $scope.data.push(response.data[i]);
            $scope.totalContact++;
        }
    }, function errorCallback(response) {

        alert("something wrong! please contact send right support. Thank you!");
    });
    // }
    // 
    // 
    // 
    // 
    // Pagination 
     
   $scope.numPages = function () {
        return Math.ceil($scope.data.length / $scope.pageSize)-1;
    };

    var begin = 1;
 
    // detect where the page selected
    $scope.$watch('currentPage + numPerPage', function() {
        var begin = (($scope.currentPage - 1) * $scope.numPerPage)
            , end = begin + $scope.numPerPage;

        $scope.filteredTodos = $scope.data.slice(begin, end);
    });
  
    $scope.$watch('pageSize', function () {
        $scope.numPages();
        $scope.getData() ;
    });


    $scope.buttonThemeSelectedEnabled = [];  

    $scope.selectedTheme = function(campaign) {

        // other settings
        console.log(campaign.id); 
        $scope.selectedThemeModel = campaign.id;
        $scope.templateNextEnable = false;
        $scope.hideAlertMessage = true;  

        // set disabled button clicked
        $scope.buttonThemeSelectedEnabled[campaign.id] = true;  

        // enable all button except clicked button
        $scope.data.forEach(function(item) {  
            console.log(" item id "  + item.id  + " campaign id " + campaign.id);  
            if (item.id !== campaign.id) { 
                $scope.buttonThemeSelectedEnabled[item.id] = false; 
            }  
        });   
    } 
}]);