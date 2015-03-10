// app.js

var examApp = angular
	.module('examApp', ['ngRoute', 'checklist-model','ui.bootstrap.modal','ui.bootstrap.tabs',
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
			.when('/exam/:examId/preview',{
				templateUrl: 'views/preview_exam.html',
				controller: 'previewExamController'
			})
			.otherwise({
				templateUrl: 'views/not_found.html'
			});

		$locationProvider.html5Mode(true);
	}
]);

examApp.service('sessionService', function() {
	this.create = function(userId, userName) {
		this.userId = userId;
		this.userName = userName;
	};

	this.clear = function() {
		this.userId = null;
		this.userName = null;
	};
});

examApp.controller('previewExamController', ['$scope', '$http', '$routeParams', '$location',
	'QN_TYPES', 'EXAM_STATUS', function($scope, $http, $routeParams, $location, QN_TYPES, EXAM_STATUS){
	
	$scope.examId = $routeParams.examId;

	$scope.getExamInfo = function() {
		console.log($scope.examId);
		$http.get('/api/exam/' + $scope.examId + '/examinfo')
			.success(function(data){
				if (data.code === 200) {
					$scope.exam = data.data;
					$scope.publish = $scope.exam.status === EXAM_STATUS.DRAFT? 'Publish':'Unpublish';
				} else {
					$scope.error = data.data;
				}
		});
	};

	$scope.isMCQ = function(question) {
		return question.questiontype_id === QN_TYPES.QN_MCQ;
	};
	$scope.isMRQ = function(question){
		return question.questiontype_id === QN_TYPES.QN_MRQ;
	}

	$scope.isCodingQuestion = function(question) {
		return question.questiontype_id === QN_TYPES.QN_CODING;
	};

	$scope.isShortQuestion = function(question) {
		return question.questiontype_id === QN_TYPES.QN_SHORT;
	};

	$scope.publishUnpublish = function(){
		if($scope.exam.status === EXAM_STATUS.DRAFT){
			$http.get('/api/exam/' + $scope.examId + '/publish')
				.success(function(data){
			});
		}else 
		{
			$http.get('/api/exam/' + $scope.examId + '/unpublish')
				.success(function(data){
			});
		}
		$location.path('/home');
	};

	$scope.cancel = function(){
		if($scope.exam.status === EXAM_STATUS.DRAFT){
			$location.path('/exam/' + $scope.examId + '/edit');
		}else{
			$location.path('/home');
		}

	}


	$scope.getExamInfo();

}]);

examApp.controller('headerController', ['$scope', 'sessionService', '$location',
	function($scope, sessionService, $location) {

		$scope.isLogin = false;
		$scope.userName = '';

		$scope.$on('auth_event', function() {
			$scope.updateLoginStatus();
		});
		
		$scope.updateLoginStatus = function() {
			if (sessionService.userName) {
				$scope.isLogin = true;
				$scope.userName = sessionService.userName;
			} else {
				$scope.isLogin = false;
				$scope.userName = '';
			}
			$scope.option = ($scope.isLogin === true) ? 'logout' : 'login';
		};

		$scope.onAuthClicked = function() {
			if ($scope.isLogin) {
				// logout
				// todo: send logout request
				sessionService.clear();
				$scope.updateLoginStatus();
				$location.path('/');
			} else {
				// login
				$location.path('/');
			}
		};

		$scope.updateLoginStatus();
}]);

examApp.controller('loginController', ['$scope', '$rootScope','$location', '$window', '$http', 'sessionService',
	function($scope, $rootScope, $location, $window, $http, sessionService) {

		$scope.signin = function() {

			var loginVar = {
				'username': $scope.user.userId,
				'password': $scope.user.password
			};	

			$scope.loginError = null;	
			$http.post('/login', loginVar)
				.success(function(data, status, header, config) {
					console.log(data);
					if(data.code === 200){
						sessionService.create('user_id', data.data);
						$rootScope.$broadcast('auth_event');
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
	$scope.exam = {
		'course_id':$scope.courses[0].id,
		'title':""
	};
// console.log($scope.exam);
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

examApp.controller('dashboardController', ['$scope', '$location', '$modal', '$http', 'EXAM_STATUS',
	function($scope, $location, $modal, $http, EXAM_STATUS) {
	
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
				console.log(data.data);
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

	$scope.redirectExam = function(exam){
		if(exam.status === EXAM_STATUS.DRAFT){
			$location.path('/exam/' + exam.id + '/edit');
		}else if (exam.status === EXAM_STATUS.NOT_STARTED){
			$location.path('/exam/' + exam.id + '/preview');
		}else if (exam.status === EXAM_STATUS.IN_EXAM){
			$location.path('/exam/' + exam.id);
		}else{
			$location.path('/exam/' + exam.id + '/preview');
		}
	}

	$scope.getExamLabel = function(exam){
		if(exam.status === EXAM_STATUS.DRAFT){
			$scope.examActionText = "Edit";
			return "label-primary";
		}else if (exam.status === EXAM_STATUS.NOT_STARTED){
			$scope.examActionText = "View";
			return "label-success";
		}else if (exam.status === EXAM_STATUS.IN_EXAM){
			$scope.examActionText = "Start";
			return "label-warning";
		}else{
			$scope.examActionText = "View";
			return "label-info";
		}	
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
	$scope.showTimer=true;
	$scope.langs=['C/C++','Java']
	// code editor setting
    $scope.aceOptions = {
	  useWrapMode : true,
	  theme:'clouds',
	  mode: 'javascript',
	  firstLineNumber: 1,
	  require:['ace/ext/language_tools'],
	  onload: "aceLoaded",
	  advanced:{
	  	enableSnippets: true,
	  	enableLiveAutocompletion: true
	  }
    };

   //   $scope.aceLoaded = function(_editor) {
	  //   // Options
	  //   _editor.$blockScrolling = 0;
	  // };

	$scope.getExamInfo = function() {

		$http.get('/api/exam/' + $scope.examId + '/examinfo')
			.success(function(data){
				if (data.code === 200) {
					console.log(data.data);
					$scope.exam = data.data;
					$scope.startExamSubmission();
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
					$scope.goToQuestion(0);

					// start timer 
					// todo calculate based on server returned current time
					$scope.$broadcast('timer-add-cd-seconds', 60 * $scope.exam.duration - 1);
			     	$timeout(function(){
				     	$scope.$broadcast('timer-start');
				  	},0);
				}
			});
	};

	$scope.submitCurrentQuestion = function(){
		console.log($scope.curQnSubmission);

		if (!$scope.curQnSubmission) {
			return;
		}
		if ($scope.curQnSubmission.id) {
			// id does exist, update submission
			$http.put('/api/submission/' + $scope.submission.id + '/questionsubmission', $scope.curQnSubmission)
			.success(function(data){
				if (data.code === 200){
					console.log(data.data)
					$scope.updateQuestionSubmission(data.data);
				}
			});
		} else {
			// id does not exist, create submission
			$http.post('/api/submission/' + $scope.submission.id + '/questionsubmission', $scope.curQnSubmission)
			.success(function(data){
				if (data.code === 200) {
					$scope.updateQuestionSubmission(data.data);
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
		return question.questiontype_id === QN_TYPES.QN_MCQ;
	};
	$scope.isMRQ = function(question){
		return question.questiontype_id === QN_TYPES.QN_MRQ;
	}

	$scope.isCodingQuestion = function(question) {
		return question.questiontype_id === QN_TYPES.QN_CODING;
	};

	$scope.isShortQuestion = function(question) {
		return question.questiontype_id === QN_TYPES.QN_SHORT;
	};

	$scope.isChecked = function(option_id) {
		if($scope.exam.questions[$scope.curQnIndex].questiontype_id === QN_TYPES.QN_MCQ){
			if($scope.curQnSubmission.choice == option_id){
				return true;
			}
		}else if($scope.exam.questions[$scope.curQnIndex].questiontype_id === QN_TYPES.QN_MRQ){
			for (var i in $scope.curQnSubmission.choices) {
				if($scope.curQnSubmission.choices[i] == option_id){
					return true;
				}
			}
		}
		return false;
	}

	$scope.goToQuestion = function(newIndex) {
		$scope.submitCurrentQuestion();
		// get question submission by question id
		console.log($scope.exam.questions);
		$scope.curQnSubmission = $scope.getQuestionSubmission($scope.exam.questions[newIndex].id);
		$scope.curQnIndex = newIndex;	
	};

	$scope.getQuestionSubmission = function(questionId) {
		for (var i in $scope.submission.questions) {
			if ($scope.submission.questions[i].question_id === questionId) {
				return $scope.submission.questions[i];
			}
		}

		var newQnSubmission = {
			'question_id' : questionId,
			'examsubmission_id' : $scope.submission.id,
			'answer' : ''
		};
		$scope.submission.questions.push(newQnSubmission);
		return newQnSubmission;
	}

	$scope.updateQuestionSubmission = function(qnSubmission) {
		for (var i in $scope.submission.questions) {
			if ($scope.submission.questions[i].question_id === qnSubmission.question_id) {
				$scope.submission.questions[i] = qnSubmission;
			}
		}
	}

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
		$scope.isExamInfoCollapsed = true;
		$http.put('/api/exam/' + $scope.examId + '/editexam',$scope.exam)
			.success(function(data){
				if (data.code === 200) {
					for (var key in data.data) {
						$scope.exam[key] = data.data[key];
					}
				}
			})
	};

	$scope.saveNPreview = function(){
		$http.put('/api/exam/' + $scope.examId + '/editexam',$scope.exam)
		.success(function(data){
			if (data.code === 200) {
				$scope.exam = data.data;
			}
		})
		$location.path('/exam/'+ $scope.examId + '/preview');
	};

	$scope.getExamInfo = function() {

		$http.get('/api/exam/' + $scope.examId + '/examinfo')
		.success(function(data){
			if (data.code === 200) {
				$scope.exam = data.data;				
				if ($scope.exam.status === EXAM_STATUS.UNAVAILABLE) {
					$scope.error = 'You are not allowed to view this page';
				}else if ($scope.exam.status != EXAM_STATUS.DRAFT){
					$scope.error = 'You are not allowed to edit an active/archived exam!'
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
		console.log($scope.exam.questions[index]);
		
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
			console.log($scope.exam.questions[index]);
			// id does not exist, create question
			$http.post('/api/exam/' + $scope.examId + '/question', $scope.exam.questions[index])
			.success(function(data){
				if (data.code === 200) {
					$scope.exam.questions[index] = data.data;
					$scope.exam.totalqn += 1;
				}
			});			
		}	
	};

	$scope.onRadioSelection = function (qn_index, option_index){
		//set all other options false
		for (var i in $scope.exam.questions[qn_index].options) {
			if(i!=option_index){
				$scope.exam.questions[qn_index].options[i].correctOption = false;
			}
		}
	}

	$scope.isMCQ = function(questiontype) {
		return questiontype === QN_TYPES.QN_MCQ;
	};
	$scope.isMRQ = function(questiontype){
		return questiontype === QN_TYPES.QN_MRQ;
	}
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
			options:[],
			index:$scope.exam.questions.length+1	
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

	$scope.removeOption = function(qn_index,option_index){
		console.log('removing options:');
		console.log(qn_index);
		console.log(option_index);
		$scope.exam.questions[qn_index].options.splice([option_index],1);
	}

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