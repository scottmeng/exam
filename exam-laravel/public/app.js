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
	
	$scope.selectedTab = 1;

	$scope.isTabSelected = function(tabIndex) {
		return tabIndex === $scope.selectedTab;
	};

	$scope.selectTab = function(tabIndex) {
		$scope.selectedTab = tabIndex;
	};

	$scope.courses = [{
		name: 'CS1010S',
		description: 'Some module description',
		exams: [{
			title: 'test 1',
			date: 1416329525
		}, {
			title: 'test 2',
			date: 1416322525
		}]
	}, {
		name: 'CS2010',
		description: 'Some other module description',
		exams: [{
			title: 'Mid-term test',
			date: 1416189525
		}, {
			title: 'sit-in test 1',
			date: 1416232525
		}]
	}];
}]);