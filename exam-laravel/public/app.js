// app.js

var examApp = angular.module('examApp', ['ngRoute', 'ui.bootstrap']);


examApp.config(function($routeProvider,$locationProvider) {
	$routeProvider
		// .when('/home', {
		// 	templateUrl: 'views/dashboard.html',
		// 	controller: 'loginController'
		// })
		.when('/home', {
			templateUrl: 'views/dashboard.html',
			controller: 'dashboardController'
		})
		.when('/create-exam', {
			templateUrl: 'views/create_exam.html',
			controller: 'newExamController'
		});

	 // $locationProvider.html5Mode(true);

});


// examApp.controller('loginController', ['$scope', '$location', '$window', '$http',
// 	function($scope, $location, $window, $http) {

// 		$scope.signin = function() {

// 			var loginVar = {
// 				'username': $scope.user.userId,
// 				'password': $scope.user.password
// 			};	

// 			$scope.loginError = null;	

// 			$http.post('/login', loginVar)
// 				.success(function(data, status, header, config) {
// 					if(data.success === true){
// 						$location.path('/dashboard');
// 					}else {
// 						$scope.loginError = 'Your user id or password is incorrect';
// 					}
// 				})
// 				.error(function(data, status, header, config) {

// 				});			
// 		};
// 	}
// ]);

examApp.controller('ModalInstanceCtrl', function ($scope, $modalInstance, $http, courses) {
	$scope.courses = courses;

	$scope.ok = function () {

		var newExamVar = $scope.exam;

		$http.post('/create-exam', newExamVar)
		.success(function(data, status, header, config) {
			console.log = data;
		})
		.error(function(data, status, header, config) {

		});	

		$modalInstance.close();
	};

	$scope.cancel = function () {
		$modalInstance.dismiss('cancel');
	};
});

examApp.controller('dashboardController', ['$scope', '$location', '$modal', '$http',
	function($scope, $location, $modal,$http) {
	
	$scope.selectedTab = 1;

	$scope.isTabSelected = function(tabIndex) {
		return tabIndex === $scope.selectedTab;
	};

	$scope.selectTab = function(tabIndex) {
		$scope.selectedTab = tabIndex;
	};

	$scope.init = function() {
		$http.get('/get-courses')
			.success(function(data, status, header, config) {
				$scope.courses = data;
				console.log('status: ' + status + '\n Data:' + data);
			})
			.error(function(data, status, header, config) {

			});	
	};

	$scope.addExam = function() {
		var modalInstance = $modal.open({
			templateUrl: 'myModalContent.html',
			controller: 'ModalInstanceCtrl',
			resolve: {
				courses: function () {
				  return $scope.courses;
				}
			}
		});

		modalInstance.result.then(function (selectedItem) {
			$location.path('/create-exam');
		}, function () {
		});
	};

	$scope.init();
}]);

examApp.controller('newExamController', ['$scope', function($scope) {

	$scope.questionTypes = [{
		type: 1,
		name: 'Multiple Choise Question'
	}, {
		type: 2,
		name: 'Short Answer Question'
	}];

	$scope.questions = [{
		type: 2,
		content: ''
	}];

	$scope.isMCQ = function(type) {
		return type === 1;
	};

	$scope.addNewQuestion = function() {
		$scope.questions.push({type: 2, content: ''});
	};

	$scope.removeQuestion = function(index) {
		$scope.questions.splice(index, 1);
	};

	$scope.addOption = function(question) {
		if (question.type === 2) {
			return;
		}
		question.options.push({correct: false, content: ''});
	};

	$scope.onQuestionTypeChanged = function(question) {
		if (question.type === 1) {
			if (!question.options) {
				question.options = [];
			}
			// add two options
			question.options.push({
				correct: true,
				content: ''
			});
			question.options.push({
				correct: false,
				content: ''
			});
		} else {
			question.options = [];
		}
	};
}]);