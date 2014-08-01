var amAdmin = angular.module('amAdmin',['mgcrea.ngStrap']);

// amAdmin.config(function($interpolateProvider) {
//   $interpolateProvider.startSymbol('{[');
//   $interpolateProvider.endSymbol(']}');
// });

amAdmin.controller('userCtrl', ['$scope','$modal','$http', function($scope,$modal,$http){
	var newModal = $modal({
		scope : $scope,
		template : 'newAccount.html',
		show : false,

	});

	$scope.showModal = function(user_id){
		$http.get('angular/user/'+user_id)
		.success(function(result){
			
			console.log("Profile received.");
			console.log(result);

			$scope.profile = result;
		})
		newModal.$promise.then(newModal.show);
	}

}])

//===========================================================================================
// amAdmin.controller('userCtrl',['$scope','$templateCache','$modal','$log','$http', function($scope,$templateCache,$modal,$log,$http){
// 	$templateCache.removeAll();
// 	$scope.open = function(user_id){

// 		$scope.profile = $http.get('angular/user/'+user_id)

// 					.success(function(result){
// 						console.log(result);
// 						$scope.profile = result;
// 					});
// console.log('Creating new modal.');
// 		var newModal = $modal.open({
// 			templateUrl : 'newAccount.html',
// 			controller : 	amAdmin.newModalCtrl,
// 			resolve : {
// 				User : function() {
// 					return $scope.profile;
// 				}
// 			}
// 		});

// 		newModal.result.then(
// 			function(result){
// 			console.log('function complete');
// 			console.log(result);
// 			},
// 			function(result){
// 				console.log('last function error');
// 				console.log(result);
// 			}
// 		)
// 	}
// }]);

// amAdmin.controller('newModalCtrl', ['$scope','$modalInstance','User', function($scope,$modalInstance,User){
// 	console.log('ModalInstanceCtrl Invocked.');
// 	$scope.profile = User;

// 	$scope.okDone = function(){
// 		console.log('OK Function called.');
// 		$modalInstance.close($scope.profile);
// 	}
// 	$scope.cancelled = function(){
// 		console.log('Cancel function called.');
// 		$modalInstance.dismiss('cancel');
// 	}
// }]);

//==========================================================//



amAdmin.controller('testCtrl', ['$scope','$http', function($scope,$http){
	$scope.formdata = {};

	$scope.processForm = function(){
		// console.log("Processing invocked.");
		$http.post('angular/test',$scope.user)
		.success(function(data){
			console.log(data);
		})
		.error(function(data){
			console.log(data);
		});
	}

}]);

amAdmin.controller('planCtrl', ['$scope', function($scope){
	$scope.time = "1970-01-01T05:00:00.000Z"; // (formatted: 10:30 AM)
	$scope.selectedTimeAsNumber = 28800000; // (formatted: 1:30 PM)
	$scope.sharedDate = "2014-05-03T06:30:13.945Z"; // (formatted: 5/3/14 12:00 PM)
}])



// amAdmin.controller('accountsCtrl',function($scope, $http){


// 	$http.get("http://localhost/am-laravel/public/api/v1/accounts")
// 	.success(
// 			function(result, status) {
// 				$scope.records = result;
// 			}
// 		)
// 	.error(
// 			function(result, status) {

// 			}
// 		);
// });