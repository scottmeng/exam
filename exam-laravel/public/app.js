// app.js

var examApp = angular.module('examApp', ['ngRoute', 'ui.bootstrap','ui.ace','textAngular']);


examApp.config(function($routeProvider,$locationProvider) {
	$routeProvider
		.when('/', {
			templateUrl: 'views/login.html',
			controller: 'loginController'
		})
		.when('/home', {
			templateUrl: 'views/dashboard.html',
			controller: 'dashboardController'
		})
		.when('/create-exam', {
			templateUrl: 'views/create_exam.html',
			controller: 'newExamController'
		})
		.otherwise({
			templateUrl: 'views/not_found.html'
		});

	 $locationProvider.html5Mode(true);
});


examApp.controller('loginController', ['$scope', '$location', '$window', '$http',
	function($scope, $location, $window, $http) {

		// $scope.init = function(){
		// 	$window.location.href ='https://ivle.nus.edu.sg/api/login/?apikey=6TfFzkSWBlHOT4ExcqFpY&url=http://localhost:8000/validate';

		// };

		// $scope.init();

		$scope.signin = function() {

			var loginVar = {
				'username': $scope.user.userId,
				'password': $scope.user.password
			};	

			$scope.loginError = null;	
			$http.post('/login', loginVar)
				.success(function(data, status, header, config) {
					if(data.success === true){
						$location.path('/home');
					}else {
						$scope.loginError = 'Incorrect user id or password. Login failed!';
					}
				})
				.error(function(data, status, header, config) {
				});			
		};

	}
]);

examApp.controller('ModalInstanceCtrl', function ($scope, $modalInstance, $http, courses) {
	$scope.courses = courses;

	$scope.ok = function () {

		var newExamVar = $scope.exam;

		$scope.createError = null;
		$http.post('/api/create-exam', newExamVar)
		.success(function(data, status, header, config) {
			console.log(data);
			if(data==='success')
				$modalInstance.close();
			else
				$scope.createError = 'Exam already exists for the selected module!';
		})
		.error(function(data, status, header, config) {

		});	
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
		$http.get('/api/get-courses')
			.success(function(data, status, header, config) {
				$scope.courses = data.courses;
				console.log(data);
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

examApp.controller('newExamController', ['$scope', '$http',function($scope,$http) {

	$http.get('/api/get-qn-types')
		.success(function(data, status, header, config) {
			$scope.questionTypes = data.types;
			console.log(data);
		})
		.error(function(data, status, header, config) {

		});	

	// $scope.questionTypes = [{
	// 	type: 1,
	// 	name: 'Multiple Choise Question'
	// }, {
	// 	type: 2,
	// 	name: 'Short Answer Question'
	// }];

	// The ui-ace option
    $scope.aceOptions = {
	  useWrapMode : true,
	  theme:'monokai',
	  mode: 'javascript',
	  firstLineNumber: 5,
	  require:['ace/ext/language_tools'],
	  advanced:{
	  	enableSnippets: true,
	  	enableLiveAutocompletion: true
	  }
	  // onLoad: aceLoaded,
	  // onChange: aceChanged
	
      // onLoad: function (_ace) {
 
      // // HACK to have the ace instance in the scope...
      //   $scope.modeChanged = function () {
      //     _ace.getSession().setMode("ace/mode/" + $scope.mode.toLowerCase());
      //   };
 
      //  } 
    };

	$scope.questions = [{
		type: 1,
		content: ''
	}];

	$scope.moreOptionsCollapsed = true;

	$scope.isMCQ = function(type) {
		return type == 1;
	};

	$scope.addNewQuestion = function() {
		$scope.questions.push({type: 1, content: ''});
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