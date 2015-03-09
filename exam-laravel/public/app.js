// app.js

var examApp = angular
	.module('examApp', ['ngRoute', 'ui.bootstrap.modal','ui.bootstrap.tabs',
		'ui.ace','textAngular','ui.bootstrap.buttons','ui.bootstrap.collapse',
		'mgcrea.ngStrap.datepicker','mgcrea.ngStrap.timepicker', 'timer'])
	.constant('QN_TYPES', {
		'QN_MCQ'	: 1,
		'QN_MRQ'	: 2,
		'QN_SHORT'	: 3,
		'QN_CODING'	: 4
	})
	.constant('EXAM_STATUS', {
		'UNAVAILABLE'	: 'unavailable',
		'DRAFT'			: 'draft',
		'NOT_STARTED'	: 'not_started',
		'FINISHED'		: 'finished',
		'IN_EXAM'		: 'in_exam',
		'PUBLISHED'		: 'published' 
	});

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
			.when('/exam/:examId', {
				templateUrl: 'views/view_exam.html',
				controller: 'viewExamController'
			})
			.when('/courses/:courseId', {
				templateUrl: 'views/view_course.html',
				controller: 'viewCourseController'
			})
			.otherwise({
				templateUrl: 'views/not_found.html'
			});

		$locationProvider.html5Mode(true);
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

		$http.get('/api/get-admin-courses')
		.success(function(data,status,header,config){
			if(data.code === 200){
				if(data.data.length==0){
					$scope.adminCourse = [];
					$scope.isAdmin = false;
				}
				else{
					$scope.adminCourses = data.data;
					$scope.isAdmin = true;
				}
			}
		});

		$http.get('/api/get-courses')
			.success(function(data, status, header, config) {
				if (data.code === 200) {
					$scope.courses = data.data;
				}
				else if (data.code === 401){
					$location.path('/');
				}
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
				  return $scope.adminCourses;
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

examApp.controller('viewCourseController', ['$scope', '$http', '$routeParams', 'EXAM_STATUS',
	function($scope, $http, $routeParams, EXAM_STATUS) {

	$scope.courseId = $routeParams.courseId;

	$scope.getCourseInfo = function() {
		// get course information
	};
}]);

examApp.controller('viewExamController', ['$scope', '$http', '$routeParams', 
	'QN_TYPES', 'EXAM_STATUS', '$timeout',
	function($scope, $http, $routeParams, QN_TYPES, EXAM_STATUS, $timeout) {

	$scope.curQnIndex = 0;
	$scope.examId = $routeParams.examId;
	$scope.error = null;
	// code editor setting
    $scope.aceOptions = {
	  useWrapMode : true,
	  theme:'clouds',
	  mode: 'javascript',
	  firstLineNumber: 1,
	  require:['ace/ext/language_tools'],
	  advanced:{
	  	enableSnippets: true,
	  	enableLiveAutocompletion: true
	  }

    };

	$scope.getExamInfo = function() {

		$http.get('/api/exam/' + $scope.examId + '/examinfo')
			.success(function(data){
				if (data.code === 200) {
					console.log(data.data);
					$scope.exam = data.data;
					$scope.endTime = new Date(new Date($scope.exam.starttime).getTime() + $scope.exam.duration*60000);
				} else {
					$scope.error = data.data;
				}
		});
	};

	$scope.startExamSubmission = function() {
		// retrieve last exam submission
		// or get a new one
		$http.get('/api/exam/' + $scope.examId + '/submission')
			.success(function(data) {
				if (data.code === 200) {
					console.log(data.data);
					$scope.submission = data.data;
					$scope.$broadcast('timer-add-cd-seconds', 60 * $scope.exam.duration - 1);
			     	$timeout(function(){
				     	$scope.$broadcast('timer-start');
				  	},0);
				}
			});
	};

	$scope.submitCurrentQuestion = function(){
		$index = $scope.curQnIndex;
		$scope.submission.questions[$index].question_id = $scope.exam.questions[$index].id;

		if ($scope.submission.questions[$index].id) {
			// id does exist, update submission
			$http.put('/api/submission/' + $scope.submission.id + '/questionsubmission', $scope.submission.questions[$index])
			.success(function(data){
				if (data.code === 200) {
					$scope.submission.questions[$index] = data.data;
				}
			});
		} else {
			// id does not exist, create submission
			$http.post('/api/submission/' + $scope.submission.id + '/questionsubmission', $scope.submission.questions[$index])
			.success(function(data){
				if (data.code === 200) {
					$scope.submission.questions[$index] = data.data;
				}
			});
		}
	}

	$scope.canAnswerQuestion = function() {
		// todo 
		// depends on user relation with course
		// only 'student' accessing an 'active' exam can answer question
		return true;
	};

	$scope.getCountDown = function() {
		if ($scope.exam) {
			return $scope.exam * 60;
		}
		return 10;
	};


	$scope.isMCQ = function(question) {
		return question.questiontype_id === QN_TYPES.QN_MCQ ||
			   question.questiontype_id === QN_TYPES.QN_MRQ;
	};

	$scope.isCodingQuestion = function(question) {
		return question.questiontype_id === QN_TYPES.QN_CODING;
	};

	$scope.isShortQuestion = function(question) {
		return question.questiontype_id === QN_TYPES.QN_SHORT;
	};

	$scope.goToQuestion = function(newIndex) {
		// todo
		// save question submission of curQnIndex
		// update curQnIndex with the new index
		$scope.submitCurrentQuestion();
		$scope.curQnIndex = newIndex;	
	};

	$scope.timer = {};
	$scope.timer.status = 1;
	$scope.timer.onTimeUp = function() {
		console.log('test');
	};
	$scope.onTimeUp = function() {
		// todo
		// prompt user
		// submit question
		// disable input and etc.
		console.log('time is up');
	};

	$scope.getExamInfo();
	$scope.startExamSubmission();
}]);

examApp.controller('newExamController', ['$scope', '$location','$http', '$routeParams', 'QN_TYPES', 'EXAM_STATUS',
	function($scope, $location, $http, $routeParams, QN_TYPES, EXAM_STATUS) {

	$scope.examId = $routeParams.examId;
	$scope.error = null;

	$scope.getQuestionTypes = function() {
		$http.get('/api/get-qn-types')
			.success(function(data, status, header, config) {
				if (data.code === 200) {
					$scope.questionTypes = data.data;
				}
			})
			.error(function(data, status, header, config) {

			});	
	};

	$scope.saveExam = function(){
		console.log('exam sent:');
		console.log($scope.exam);
		
		$scope.isExamInfoCollapsed = true;
		$http.put('/api/exam/' + $scope.examId + '/editexam',$scope.exam)
			.success(function(data){
				console.log('exam received:');
				console.log(data.data);
				if (data.code === 200) {
					$scope.exam = data.data;
				}
			})
	};

	$scope.finishEditExam = function(){
		$http.put('/api/exam/' + $scope.examId + '/editexam',$scope.exam)
		.success(function(data){
			console.log('exam received:');
			console.log(data.data);
			if (data.code === 200) {
				$scope.exam = data.data;
			}
		})
		$location.path('/home');
	};

	$scope.getExamInfo = function() {

		$http.get('/api/exam/' + $scope.examId + '/examinfo')
		.success(function(data){
			if (data.code === 200) {
				console.log(data.data);
				$scope.exam = data.data;
				if ($scope.exam.status === EXAM_STATUS.UNAVAILABLE) {
					$scope.error = 'You are not allowed to view this page';
				}
			}
		})
	};

	$scope.isExamInfoCollapsed = false;
	$scope.ExamName="CS1010 Mid-Term Exam";

	$scope.defaultDate = "2015-02-05T08:00:01.534Z"; // (formatted: 2/5/15 4:00 PM)
	$scope.isMarkingSchemeCollapsed = true;
	$scope.hasMarkingScheme = false;

    $scope.textAreaSetup = function($element){
	  $element.attr('ui-codemirror', '');
	};

	$scope.initQuestions = function(){
		$http.get('/api/exam/' + $scope.examId + '/questions')
		.success(function(data){
			if (data.code === 200) {
				if (data.data.length>0) {
					$scope.exam.questions = data.data;
				} else {	
					$scope.exam.questions = [];
				}
			}
		});	
	}

	$scope.submitQuestion = function(index){

		$scope.exam.questions[index].index = index+1;
		
		if ($scope.exam.questions[index].id) {
			// id does exist, update question
			$http.put('/api/exam/' + $scope.examId + '/question', $scope.exam.questions[index])
			.success(function(data){
				if (data.code === 200) {
					$scope.exam.questions[index] = data.data;
				}
			});
		} else {
			// id does not exist, create question
			$http.post('/api/exam/' + $scope.examId + '/question', $scope.exam.questions[index])
			.success(function(data){
				if (data.code === 200) {
					$scope.exam.questions[index] = data.data;
				}
			});
			
			$scope.exam.totalqn += 1;
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
		return questiontype === QN_TYPES.QN_MCQ || 
			   questiontype === QN_TYPES.QN_MRQ;
	};
	$scope.isCodingQn = function(questiontype){
		return questiontype == QN_TYPES.QN_CODING;
	}

	$scope.addNewQuestion = function() {
		if ($scope.exam.questions==null) {
			$scope.exam.questions = [];
		}
		$scope.exam.questions.push({
			questiontype_id: QN_TYPES.QN_SHORT, 
			content: '',
			options:[]				
		});
	};

	$scope.removeQuestion = function(index) {
		if(index<$scope.exam.totalqn){
			if($scope.exam.hasOwnProperty('id')){
				$http.post('/api/exam/' + $scope.examId + '/deletequestion', $scope.exam.questions[index])
					.success(function(data){
						if (data.code === 200) {
							$scope.exam.totleqn-=1;
						}
					})
			}
		}			
		$scope.exam.questions.splice(index, 1);
	};

	$scope.addOption = function(question) {
		if (question.questiontype_id != QN_TYPES.QN_MCQ && question.questiontype_id != QN_TYPES.QN_MRQ) {
			return;
		}
		if (!question.options) {
				question.options = [];
		}
		console.log('type varified');
		question.options.push({correctOption: false, content: ''});
	};

	$scope.onQuestionTypeChanged = function(question) {
		if (question.questiontype_id === QN_TYPES.QN_MCQ) {
			if (!question.options) {
				question.options = [];
			}
			// add two options
			question.options.push({
				correctOption: 1,
				content: ''
			});
			question.options.push({
				correctOption: 0,
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