<!DOCTYPE html >
<html >
<head>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.10.0/ui-bootstrap-tpls.js"></script>
 <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css"/>


	<title>This is to test bootsrap compatibility to angular + laravel </title>
</head>
<body >
	 <div ng-app="app"> 
       <div ng-controller="CustomerController">  
        <div ng-repeat="customer in customers">
            <button class="btn btn-default" ng-click="open(customer)">@{{ customer.name }}</button> <br />

                <!--MODAL WINDOW--> 
                <script type="text/ng-template" id="myModalContent.html">
                    <div class="modal-header">
                        <h3>The Customer Name is: @{{ customer.name }}</h3>
                    </div>
                    <div class="modal-body">
                            This is where the Customer Details Goes<br />
                            @{{ customer.details }}
                    </div>
                    <div class="modal-footer"> 
                    </div>
                </script> 
        </div>  
        </div>


</div>
</body>

<script type="text/javascript">
	
	var app = angular.module('app', ['ui.bootstrap']);

app.controller('ModalInstanceCtrl', function ($scope, $modalInstance, customer)
{
$scope.customer = customer;

});

app.controller('CustomerController', function($scope, $timeout, $modal, $log) {
    
    $scope.customers = [
        {
        name: 'Ricky',
        details: 'Some Details for Ricky',
        },
        {
        name: 'Dicky',
        details: 'Some Dicky Details',
        },
        {
        name: 'Nicky',
        details: 'Some Nicky Details',
        }
    ];

    // MODAL WINDOW
    $scope.open = function (_customer) { 
        var modalInstance = $modal.open({
          controller: "ModalInstanceCtrl",
          templateUrl: 'myModalContent.html',
            resolve: {
                customer: function()
                {
                    return _customer;
                }
            }
      	}); 
    };

});


</script>

</html>