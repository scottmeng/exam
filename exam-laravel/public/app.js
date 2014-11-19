// app.js

var examApp = angular.module('examApp', ['ngRoute', 'ui.bootstrap']);


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
			templateUrl: 'views/create_exam.html',
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

examApp.controller('ModalInstanceCtrl', function ($scope, $modalInstance, courses) {
	$scope.courses = courses;

	$scope.ok = function () {
		$modalInstance.close();
	};

	$scope.cancel = function () {
		$modalInstance.dismiss('cancel');
	};
});

examApp.controller('dashboardController', ['$scope', '$location', '$modal',
	function($scope, $location, $modal) {
	
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
		backdrop: true,
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