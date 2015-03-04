// app.js

var examApp = angular.module('examApp', ['ngRoute', 'ui.bootstrap.modal','ui.bootstrap.tabs',
	'ui.ace','textAngular','ui.bootstrap.buttons','ui.bootstrap.collapse',
	'mgcrea.ngStrap.datepicker','mgcrea.ngStrap.timepicker']);

examApp.config(['$routeProvider', '$locationProvider', 
	function($routeProvider, $locationProvider) {
		$routeProvider
			.when('/', {
				templateUrl: 'views/login.html',
				controller: 'loginController'
			})
			.when('/home', {
				templateUrl: 'views/dashboard.html',
				controller: 'dashboardController'
			})
			.when('/exam/:examId/edit', {
				templateUrl: 'views/create_exam.html',
				controller: 'newExamController'
			})
			.otherwise({
				templateUrl: 'views/not_found.html'
			});

		$locationProvider.html5Mode(true);




	 //*********test adding tools**********

	  // $provide.decorator('taOptions', ['taRegisterTool', '$delegate', function(taRegisterTool, taOptions){
   //      // $delegate is the taOptions we are decorating
   //      // register the tool with textAngular
   //      taRegisterTool('colourRed', {
   //          iconclass: "fa fa-square red",
   //          action: function(){
   //              this.$editor().wrapSelection('forecolor', 'red');
   //          }
   //      });
   //      // add the button to the default toolbar definition
   //      taOptions.toolbar[1].push('colourRed');
   //      return taOptions;
   //  }]);

	}
]);


examApp.controller('loginController', ['$scope', '$location', '$window', '$http',
	function($scope, $location, $window, $http) {

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

		$scope.createError = null;
		$http.post('/api/create-exam', $scope.exam)
			.success(function(data, status, header, config) {
				console.log("captured exam data:");
				console.log($scope.exam);
				console.log('data received:');
				console.log(data);
				if (data.code === 200) {
					var exam = data.data;
					$modalInstance.close(exam);
				} else {
					$scope.createError = data.data;
				}
			})
			.error(function(data, status, header, config) {

			});	
	};

	$scope.cancel = function () {
		$modalInstance.dismiss('cancel');
	};
});

examApp.controller('dashboardController', ['$scope', '$location', '$modal', '$http',
	function($scope, $location, $modal, $http) {
	
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
			})
			.error(function(data, status, header, config) {

			});	
	};

	$scope.viewExam = function(examid){
		$location.path('/exam/' + examid + '/edit');
	}

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

		modalInstance.result.then(function (exam) {
			$location.path('/exam/' + exam.id + '/edit');
		}, function () {
		});
	};

	$scope.init();
}]);

examApp.controller('newExamController', ['$scope', '$location','$http', '$routeParams',
	function($scope, $location, $http, $routeParams) {

	$scope.examId = $routeParams.examId;

	$scope.getQuestionTypes = function() {
		$http.get('/api/get-qn-types')
			.success(function(data, status, header, config) {
				$scope.questionTypes = data.types;
			})
			.error(function(data, status, header, config) {

			});	
	};

	$scope.saveExam = function(){
		$scope.isExamInfoCollapsed = true;
		$http.put('/api/exam/' + $scope.examId + '/editexam',$scope.exam)
			.success(function(data){
				if (data.code === 200) {
					console.log(data);
					$scope.exam = data.data;
				}
			})
	};

	$scope.finishEditExam = function(){
		$location.path('/home');
	};

	$scope.getExamInfo = function() {

		$http.get('/api/exam/' + $scope.examId + '/examinfo')
		.success(function(data){
			if (data.code === 200) {
				console.log(data.data);
				$scope.exam = data.data;
			}
		})
	};

	$scope.isExamInfoCollapsed = true;
	$scope.ExamName="CS1010 Mid-Term Exam";

	$scope.defaultDate = "2015-02-05T08:00:01.534Z"; // (formatted: 2/5/15 4:00 PM)
	$scope.isMarkingSchemeCollapsed = true;
	$scope.hasMarkingScheme = false;

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

    };

    $scope.textAreaSetup = function($element){
	  $element.attr('ui-codemirror', '');
	};

	$scope.initQuestions = function(){
		$http.get('/api/exam/' + $scope.examId + '/questions')
		.success(function(data){
			if (data.code === 200) {
				console.log(data.data);
				if (data.data.length>0) {
					$scope.exam.questions = data.data;
				} else {	
					$scope.exam.questions = [{
						questiontype: 1,
						content: '',
						options: []
					}];
				}

			}
		});	
	}

	$scope.submitQuestion = function(index){
		
		console.log('options sent:');
		console.log($scope.exam.questions[index]);

		$scope.exam.questions[index].index = index+1;
		
		if ($scope.exam.questions[index].id) {
			// id does exist, update question
			$http.put('/api/exam/' + $scope.examId + '/question', $scope.exam.questions[index])
			.success(function(data){
				if (data.code === 200) {
					console.log(data.data);
					$scope.exam.questions[index] = data.data;
				}
			});
		} else {
			// id does not exist, create question
			$http.post('/api/exam/' + $scope.examId + '/question', $scope.exam.questions[index])
			.success(function(data){
				if (data.code === 200) {
					console.log(data.data);
					$scope.exam.questions[index] = data.data;
				}
			});
		}

		

		// $http.post('/api/exam/' + $scope.examId + '/options', $scope.questions[index].options)
		// .success(function(data){
		// 	if (data.code === 200) {
		// 		console.log('options received:');
		// 		console.log(data.data);
		// 	}
		// })	
	};

	$scope.isMCQ = function(questiontype) {
		return questiontype == 1;
	};

	$scope.addNewQuestion = function() {
		$scope.exam.questions.push({questiontype: 1, content: ''});
	};

	$scope.removeQuestion = function(index) {
		if($scope.exam.hasOwnProperty('id')){
			console.log('deleting qn:');
			console.log($scope.exam.questions[index]);
			$http.post('/api/exam/' + $scope.examId + '/deletequestion', $scope.exam.questions[index])
				.success(function(data){
					if (data.code === 200) {
						$scope.exam = data.data;
					}
				})
		}			
		$scope.exam.questions.splice(index, 1);
	};

	$scope.addOption = function(question) {
		if (question.questiontype === 2) {
			return;
		}
		question.options.push({correctOption: false, content: ''});
	};

	$scope.onQuestionTypeChanged = function(question) {
		if (question.questiontype === 1) {
			if (!question.options) {
				question.options = [];
			}
			// add two options
			question.options.push({
				correct: 1,
				content: ''
			});
			question.options.push({
				correct: 0,
				content: ''
			});
		} else {
			question.options = [];
		}
	};

	// initialization
	$scope.getExamInfo();
	$scope.getQuestionTypes();
}]);