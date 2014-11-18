// app.js

var examApp = angular.module('examApp', ['ngRoute']);


examApp.config(function($routeProvider) {
	$routeProvider
		.when('/', {
			templateUrl: 'views/login.html',
			controller: 'loginController'
		})
		.when('/dashboard', {
			templateUrl: 'views/dashboard.html',
			controller: 'dashboardController'
		})
		.when('/create-exam', {
			templateUrl: 'views/new_exam.html',
			controller: 'newExamController'
		});
});

examApp.controller('loginController', ['$scope', '$location', function($scope, $location) {

	$scope.signin = function() {
		$scope.loginError = null;
		if ($scope.user.userId === 'test' && $scope.user.password === 'test') {
			$location.path('/dashboard');
		} else {
			$scope.loginError = 'Your user id or password is incorrect';
		}
	};
}]);

examApp.controller('dashboardController', ['$scope', '$location', function($scope, $location) {
	
}]);