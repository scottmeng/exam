// app.js

var examApp = angular
	.module('examApp', ['ngRoute', 'ui.bootstrap.modal','ui.bootstrap.tabs',
		'ui.ace','textAngular','ui.bootstrap.buttons','ui.bootstrap.collapse',
		'mgcrea.ngStrap.datepicker','mgcrea.ngStrap.timepicker', 'timer'])
	.constant('QN_TYPES', {
		'QN_MCQ_SINGLE'	: 1,
		'QN_CODING'		: 2,
		'QN_SHORT'		: 3,
		'QN_MCQ_MULTI'	: 4
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
				console.log('courses received:');
				console.log(data);
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

examApp.controller('viewExamController', ['$scope', '$http', '$routeParams', 'QN_TYPES', 
	function($scope, $http, $routeParams, QN_TYPES) {

	$scope.curQnIndex = 0;
	$scope.examId = $routeParams.examId;

	$scope.getExamInfo = function() {

		$http.get('/api/exam/' + $scope.examId + '/examinfo')
			.success(function(data){
				if (data.code === 200) {
					console.log(data.data);
					$scope.exam = data.data;
				}
		})
	};

	// $scope.exam = {
	// 	course_id: 1,
	// 	created_at: "2015-03-04 23:29:27",
	// 	description: null,
	// 	duration: 60,
	// 	examstate_id: 1,
	// 	fullmarks: 100,
	// 	id: 1,
	// 	questions: [{
	// 		coding_qn: 0,
	// 		compiler_enable: 0,
	// 		content: "this is the content of question",
	// 		created_at: "2015-03-04 23:32:35",
	// 		exam_id: 1,
	// 		full_marks: 0,
	// 		id: 1,
	// 		index: 1,
	// 		marking_scheme: null,
	// 		options: [{
	// 			content: "option 1",
	// 			correctOption: 1,
	// 			created_at: "2015-03-05 00:12:18",
	// 			id: 17,
	// 			index: null,
	// 			question_id: 1,
	// 			updated_at: "2015-03-05 00:12:18"
	// 		}, {
	// 			content: "option 2",
	// 			correctOption: 0,
	// 			created_at: "2015-03-05 00:12:18",
	// 			id: 18,
	// 			index: null,
	// 			question_id: 1,
	// 			updated_at: "2015-03-05 00:12:18"
	// 		}],
	// 		questiontype_id: 1,
	// 		randomizeOptions: 0,
	// 		subindex: 0,
	// 		title: "test",
	// 		updated_at: "2015-03-04 23:32:35"
	// 	}, {
	// 		coding_qn: 0,
	// 		compiler_enable: 0,
	// 		content: "this is the content of question",
	// 		created_at: "2015-03-04 23:32:35",
	// 		exam_id: 1,
	// 		full_marks: 0,
	// 		id: 1,
	// 		index: 1,
	// 		marking_scheme: null,
	// 		options: [{
	// 			content: "option 1",
	// 			correctOption: 1,
	// 			created_at: "2015-03-05 00:12:18",
	// 			id: 17,
	// 			index: null,
	// 			question_id: 1,
	// 			updated_at: "2015-03-05 00:12:18"
	// 		}, {
	// 			content: "option 2",
	// 			correctOption: 0,
	// 			created_at: "2015-03-05 00:12:18",
	// 			id: 18,
	// 			index: null,
	// 			question_id: 1,
	// 			updated_at: "2015-03-05 00:12:18"
	// 		}],
	// 		questiontype_id: 2,
	// 		randomizeOptions: 0,
	// 		subindex: 0,
	// 		title: "test",
	// 		updated_at: "2015-03-04 23:32:35"
	// 	}, {
	// 		coding_qn: 0,
	// 		compiler_enable: 0,
	// 		content: "this is the content of question",
	// 		created_at: "2015-03-04 23:32:35",
	// 		exam_id: 1,
	// 		full_marks: 0,
	// 		id: 1,
	// 		index: 1,
	// 		marking_scheme: null,
	// 		options: [{
	// 			content: "option 1",
	// 			correctOption: 1,
	// 			created_at: "2015-03-05 00:12:18",
	// 			id: 17,
	// 			index: null,
	// 			question_id: 1,
	// 			updated_at: "2015-03-05 00:12:18"
	// 		}, {
	// 			content: "option 2",
	// 			correctOption: 0,
	// 			created_at: "2015-03-05 00:12:18",
	// 			id: 18,
	// 			index: null,
	// 			question_id: 1,
	// 			updated_at: "2015-03-05 00:12:18"
	// 		}],
	// 		questiontype_id: 3,
	// 		randomizeOptions: 0,
	// 		subindex: 0,
	// 		title: "test",
	// 		updated_at: "2015-03-04 23:32:35"
	// 	}, {
	// 		coding_qn: 0,
	// 		compiler_enable: 0,
	// 		content: "this is the content of question",
	// 		created_at: "2015-03-04 23:32:35",
	// 		exam_id: 1,
	// 		full_marks: 0,
	// 		id: 1,
	// 		index: 1,
	// 		marking_scheme: null,
	// 		options: [{
	// 			content: "option 1",
	// 			correctOption: 1,
	// 			created_at: "2015-03-05 00:12:18",
	// 			id: 17,
	// 			index: null,
	// 			question_id: 1,
	// 			updated_at: "2015-03-05 00:12:18"
	// 		}, {
	// 			content: "option 2",
	// 			correctOption: 0,
	// 			created_at: "2015-03-05 00:12:18",
	// 			id: 18,
	// 			index: null,
	// 			question_id: 1,
	// 			updated_at: "2015-03-05 00:12:18"
	// 		}],
	// 		questiontype_id: 4,
	// 		randomizeOptions: 0,
	// 		subindex: 0,
	// 		title: "test",
	// 		updated_at: "2015-03-04 23:32:35"
	// 	}],
	// 	randomizeQuestions: 0,
	// 	starttime: null,
	// 	title: "CS1234 Mid-term Test",
	// 	totalqn: 0,
	// 	updated_at: "2015-03-04 23:29:27"
	// };

	$scope.isMCQ = function(question) {
		console.log(question);
		return question.questiontype_id === QN_TYPES.QN_MCQ_SINGLE ||
			   question.questiontype_id === QN_TYPES.QN_MCQ_MULTI;
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
}]);

examApp.controller('newExamController', ['$scope', '$location','$http', '$routeParams',
	function($scope, $location, $http, $routeParams) {

	$scope.examId = $routeParams.examId;

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
		$scope.exam.questions.push({
			questiontype_id: 1, 
			content: '',
			options:[
				{
					correctOption: false,
					content: ''
				},
				{
					correctOption: false,
					content: ''
				}
			]				
		});
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
		if (!question.options) {
				question.options = [];
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