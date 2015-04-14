// app.js

var examApp = angular
	.module('examApp', ['ngRoute', 'angularMoment', 'checklist-model','ui.bootstrap.modal','ui.bootstrap.tabs',
		'ui.ace','textAngular','ui.bootstrap.buttons','ui.bootstrap.collapse', 'ui.bootstrap.progressbar', 'ui.bootstrap.carousel','ui.bootstrap.dropdown',
		'mgcrea.ngStrap.datepicker','mgcrea.ngStrap.timepicker','mgcrea.ngStrap.scrollspy','mgcrea.ngStrap.affix',
		'timer','hljs','ui.grid','ui.grid.selection','ui.grid.exporter','chart.js'])
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
	})
	.constant('SUBMISSION_STATUS',{
		'NOT_GRADED'	:	1,
		'GRADING'		: 	2, 
		'GRADED'		: 	3
	})
	.constant('GRAPH_LEVEL',6);

examApp.config(function ($httpProvider) {
	$httpProvider.interceptors.push([
		'$injector',
		function ($injector) {
			return $injector.get('AuthInterceptor');
		}
	]);
});

examApp.factory('AuthInterceptor', function ($rootScope, $q, $location, sessionService) {
	return {
		responseError: function (response) { 
			if (response.status === 401) {
				var current = $location.path();
				sessionService.clear();
				if (current === '/') {
					return $q.reject(response);
				}
				$location.search().redirect = current;
				$location.path('/');
				return $q.reject(response);
			}else if(response.status === 403){
				$location.path('/unauthorized');
				return $q.reject(response);
			}
		}
	};
})

examApp.config(['$routeProvider', '$locationProvider', 
	function($routeProvider, $locationProvider) {
		$routeProvider
			.when('/', {
				templateUrl: 'views/login.html',
				controller: 'loginController',
				resolve: {
					auth: function resolveAuthentication(AuthResolver) {
						return AuthResolver.resolve(false);
					}
				}
			})
			.when('/home', {
				templateUrl: 'views/dashboard.html',
				controller: 'dashboardController',
				resolve: {
					auth: function resolveAuthentication(AuthResolver) {
						return AuthResolver.resolve(true);
					}
				}
			})
			.when('/exam/:examId/view_paper', {
				templateUrl: 'views/view_graded_paper.html',
				controller: 'viewPaperController',
				resolve: {
					auth: function resolveAuthentication(AuthResolver) {
						return AuthResolver.resolve(true);
					}
				}
			})
			.when('/exam/:examId/edit', {
				templateUrl: 'views/create_exam.html',
				controller: 'newExamController',
				resolve: {
					auth: function resolveAuthentication(AuthResolver) {
						return AuthResolver.resolve(true);
					}
				}
			})
			.when('/exam/:examId', {
				templateUrl: 'views/view_exam.html',
				controller: 'viewExamController',
				resolve: {
					auth: function resolveAuthentication(AuthResolver) {
						return AuthResolver.resolve(true);
					}
				}
			})
			.when('/course/:courseId', {
				templateUrl: 'views/view_course.html',
				controller: 'viewCourseController',
				resolve: {
					auth: function resolveAuthentication(AuthResolver) {
						return AuthResolver.resolve(true);
					}
				}
			})
			.when('/exam/:examId/preview',{
				templateUrl: 'views/preview_exam.html',
				controller: 'previewExamController',
				resolve: {
					auth: function resolveAuthentication(AuthResolver) {
						return AuthResolver.resolve(true);
					}
				}
			})
			.when('/exam/:examId/submission/:submissionId', {
				templateUrl: 'views/mark_exam.html',
				controller: 'markExamController',
				resolve: {
					auth: function resolveAuthentication(AuthResolver) {
						return AuthResolver.resolve(true);
					}
				}
			})
			.when('/exam/:examId/submissions',{
				templateUrl: 'views/exam_details.html',
				controller: 'examDetailsController',
				resolve: {
					auth: function resolveAuthentication(AuthResolver) {
						return AuthResolver.resolve(true);
					}
				}
			})
			.when('/unauthorized',{
				templateUrl: 'views/unauthorized.html',
				resolve: {
					auth: function resolveAuthentication(AuthResolver) {
						return AuthResolver.resolve(false);
					}
				}
			})
			.otherwise({
				templateUrl: 'views/not_found.html',
				resolve: {
					auth: function resolveAuthentication(AuthResolver) {
						return AuthResolver.resolve(false);
					}
				}
			});

		$locationProvider.html5Mode(true);
	}
]);

// simple decorator
examApp.config(function($provide){
    $provide.decorator('taOptions', ['taRegisterTool', '$delegate', '$modal', 
    	function(taRegisterTool, taOptions, $modal){
        // $delegate is the taOptions we are decorating
        // register the tool with textAngular
        taRegisterTool('code', {
            iconclass: "fa fa-terminal",
            action: function(promise, restoreSelection){
            	var field = this;
	            var modalInstance = $modal.open({
	                templateUrl: 'views/editorModal.html',
	                controller: 'insertCodeModalController'
	            });
	            //define result modal , when user complete result information 
				modalInstance.result.then(function(content){
					restoreSelection();
                    var formatted = '<pre><code>' + content + '</code></pre><br>';
                    field.$editor().wrapSelection('inserthtml', formatted, true);
                    promise.resolve();
	            });
	            return false;
            }
        });
        // add the button to the default toolbar definition
        taOptions.toolbar[1].push('code');
        return taOptions;
    }]);
});

examApp.factory('AuthResolver', function($q, $rootScope, $location, AuthService, $timeout) {
	return {
		resolve: function(needLogin) {
			var deferred = $q.defer();
			$timeout(function() {
				if (needLogin === false) {
					deferred.resolve();
					return;
				}
				if (AuthService.isAuthenticated()) {
					deferred.resolve();
				} else {
					AuthService.checkLogin().then(function(res) {
						$rootScope.$broadcast('auth_event');
						deferred.resolve();
					}, function() {
						deferred.reject();
					});	
				}
			}, 10);
			
			return deferred.promise;
		}
	};
});

examApp.factory('AuthService', function($http, sessionService) {
	var authService = {};

	authService.checkLogin = function() {
		return $http.get('/api/profile')
			.then(function(res) {
				sessionService.create('user_id', res.data.data.name);
				return res.data.data;
			});
	};

	authService.login = function(credentials) {
		return $http.post('/login', credentials)
			.then(function(res) {
				sessionService.create('user_id', res.data.data);
				return res.data.data;
			});
	};

	authService.logout = function() {
		return $http.get('/logout')
			.then(function(res) {
				sessionService.clear();
				return res.data.data;
			});
	};

	authService.isAuthenticated = function() {
		return !!sessionService.userId;
	};

	return authService;
});

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

// examApp.controller('CarouselDemoCtrl', function ($scope) {
//   $scope.myInterval = 0;
//   var slides = $scope.slides = [];
//   $scope.addSlide = function() {
//     var newWidth = 600 + slides.length + 1;
//     slides.push({
//       image: 'http://placekitten.com/' + newWidth + '/300',
//       text: ['More','Extra','Lots of','Surplus'][slides.length % 4] + ' ' +
//         ['Cats', 'Kittys', 'Felines', 'Cutes'][slides.length % 4]
//     });
//   };
//   for (var i=0; i<4; i++) {
//     $scope.addSlide();
//   }
// });

'use strict';

examApp.directive('printDiv', function () {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {

            var iframe;
            var elementToPrint = document.querySelector(attrs.printDiv);

            if (!window.frames["print-frame"]) {
                var elm = document.createElement('iframe');
                elm.setAttribute('id', 'print-frame');
                elm.setAttribute('name', 'print-frame');
                elm.setAttribute('style', 'display: none;');
                document.body.appendChild(elm);
            }

            element.bind('click', function(event) {
                iframe = document.getElementById('print-frame');
                // write(elementToPrint.innerHTML);

                 iframe.contentWindow.document.write('<html><head><title></title>'+
                     '<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />'
                          + '</head><body><div>'
                          + elementToPrint.innerHTML
                          + '</div></body></html>');


                if (window.navigator.userAgent.indexOf ("MSIE") > 0) {
                    iframe.contentWindow.document.execCommand('print', false, null);
                } else {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                }
            });
        }
    };
});

examApp.directive('codearea', ['$interval', '$compile', function($interval, $compile) {
  return {
  	restrict: 'AE',
  	scope: {
  		raw: '='
  	},
    link: function(scope, elem, attrs) {
    	scope.$watch('raw', function(newValue, oldValue) {
    		generate();
    	}, true);

    	var regex = /<pre><code>.*?<\/code><\/pre>/g;
    	scope.code = [];

    	function generate() {
    		var html = scope.raw;
    		if (!html) {
    			return;
    		}
    		var matches = html.match(regex);
    		for (var i in matches) {
    			var code = matches[i].replace(/<pre><code>/g, '')
    								 .replace(/<\/code><\/pre>/g, '');
    			scope.code.push(escape(code));
    			html = html.replace(matches[i], '<div hljs source="code[' + i + ']"></div>');
    		}
    		elem.html(html);
	    	$compile(elem)(scope);
    	}

    	function escape(data) {
    		var div = document.createElement('div');
			div.innerHTML = data;
			return div.firstChild.nodeValue;
    	}
    	
    	generate();
    }
  };
}]);

examApp.controller('insertCodeModalController', function($scope, $modalInstance) {
	$scope.content = '';

	$scope.ok = function() {
		$modalInstance.close($scope.content);
	};

	$scope.cancel = function() {
		$modalInstance.dismiss('cancel');
	};
});

examApp.controller('viewPaperController', ['$scope', '$routeParams', '$http', 'QN_TYPES', 
	function($scope, $routeParams, $http, QN_TYPES) {
		$scope.examId = $routeParams.examId;

		$scope.getExamInfo = function() {
			$http.get('/api/exam/' + $scope.examId + '/examinfo')
				.success(function(data){
					if (data.code === 200) {
						$scope.getSubmissionInfo(data.data);
					} else {
						$scope.error = data.data;
					}
			});
		};

		$scope.getSubmissionInfo = function(exam){
			console.log('get submission info');
			$http.get('/api/exam/' + $scope.examId + '/submission')
				.success(function(data) {
					if (data.code === 200) {
						$scope.submission = data.data;
						$scope.mergeSubmissionToExam(exam, data.data);
					}
				});
		};

		$scope.getQuestionSubmission = function(questionId) {
			for (var i in $scope.submission.questions) {
				if ($scope.submission.questions[i].question_id === questionId) {
					return $scope.submission.questions[i];
				}
			}

			return null;
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

		$scope.mergeSubmissionToExam = function(exam, submission) {
			for (var i in exam.questions) {
				exam.questions[i].submission = 
					$scope.getQuestionSubmission(exam.questions[i].id);
				exam.questions[i].submission.answer_copy = '<pre><code>'+exam.questions[i].submission.answer+'</code></pre>';
			}
			$scope.exam = exam;
		};

		// $scope.generatePDF = function () {
		// 	console.log('I was here!');
		//     $scope.printElement(document.getElementById("printsection"));
		//     window.print();
		// }


		$scope.getExamInfo();
}]);

examApp.controller('previewExamController', ['$scope', '$http', '$routeParams', '$location',
	'QN_TYPES', 'EXAM_STATUS', 'moment',
	function($scope, $http, $routeParams, $location, QN_TYPES, EXAM_STATUS, moment){
	
	$scope.examId = $routeParams.examId;

	$scope.getExamInfo = function() {
		console.log($scope.examId);
		$http.get('/api/exam/' + $scope.examId + '/examinfo')
			.success(function(data){
				if (data.code === 200) {
					console.log(data.data);
					$scope.exam = data.data;
					var time = moment.tz($scope.exam.starttime, 'GMT').toDate();
					$scope.exam.starttime = time;
					$scope.publish = $scope.exam.status === EXAM_STATUS.DRAFT? 'Publish':'Unpublish';
					$scope.isAdmin = $scope.exam.user_role === 'admin';
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
				console.log(data.data);

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

examApp.controller('headerController', ['$scope', 'sessionService', '$location', 'AuthService',
	function($scope, sessionService, $location, AuthService) {

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
			$scope.option = ($scope.isLogin === true) ? 'Logout' : 'Login';
		};

		$scope.onAuthClicked = function() {
			if ($scope.isLogin) {
				// logout
				// todo: send logout request
				AuthService.logout().then(function(res) {
					$scope.updateLoginStatus();
					$location.path('/');
				});
			} else {
				// login
				$location.path('/');
			}
		};

		$scope.updateLoginStatus();
}]);

examApp.controller('appController', ['$scope', '$rootScope', 'AuthService', 
	function($scope, $rootScope, AuthService) {
		$rootScope.currentUser = null;
	  	$rootScope.isAuthorized = AuthService.isAuthorized;

	  	$scope.setCurrentUser = function (user) {
		    $rootScope.currentUser = user;
		};
}]);

examApp.controller('loginController', ['$scope', '$rootScope','$location', '$window', '$http', 'AuthService',
	function($scope, $rootScope, $location, $window, $http, AuthService) {
		
		var init = function() {
			var redirect = $location.search().redirect;

			if (redirect) {
				$scope.loginError = 'You are not logged in yet. Please log in to continue...';
			}
			if (AuthService.isAuthenticated()) {
				if (redirect) {
					$location.url(redirect);
				} else {
					$location.path('/home');
				}
			}
		}

		$scope.signin = function() {
			var loginVar = {
				'username': $scope.user.userId,
				'password': $scope.user.password
			};	

			$scope.loginError = null;	
			AuthService.login(loginVar).then(function(user) {
				$rootScope.$broadcast('auth_event');
				$scope.setCurrentUser(user);

				var redirect = $location.search().redirect;
				if (redirect) {
					$location.url(redirect);
				} else {
					$location.path('/home');
				}
			}, function() {
				$scope.loginError = 'Incorrect user id or password. Login failed';
			});		
		};

		init();
	}
]);

examApp.controller('addQnModalController',function($scope,$modalInstance,questions){
	$scope.questions = questions;
	console.log(questions);
	console.log($scope.questions);
	$scope.cancel = function(){
		$modalInstance.dismiss('cancel');
	};	

	$scope.select = function(question){
		$modalInstance.close(question);
	}

});

examApp.controller('DeleteModalController',function($scope,$modalInstance,$http,exam){
	$scope.exam = exam;

	$scope.cancel = function(){
		$modalInstance.dismiss('cancel');
	};

	$scope.deleteExamWithQuestions = function(){

		var exam_id={'id':exam.id};

		$http.post('/api/delete-exam-n-qns', exam_id)
			.success(function(data, status, header, config) {
				if (data.code === 200) {
					$modalInstance.close();
				} 
			});	
	};

	$scope.deleteExam = function(){
		var exam_id={'id':exam.id};

		$http.post('/api/delete-exam', exam_id)
			.success(function(data, status, header, config) {
				if (data.code === 200) {
					$modalInstance.close();
				} 
			});	
	};
});

examApp.controller('ConfirmModalController',function($scope,$modalInstance,data){
	$scope.modalData = data;

	$scope.goToHome = function(){
		$modalInstance.close();
	};

	$scope.OK = function(){
		$modalInstance.close();
	}
});

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

examApp.controller('dashboardController', ['$scope', '$location', '$modal', '$http', 'EXAM_STATUS','$route',
	function($scope, $location, $modal, $http, EXAM_STATUS,$route) {
	
	$scope.selectedTab = 1;

	$scope.isTabSelected = function(tabIndex) {
		return tabIndex === $scope.selectedTab;
	};

	$scope.selectTab = function(tabIndex) {
		$scope.selectedTab = tabIndex;
	};

	$scope.viewSubmissions = function(exam_id){
		$location.path('/exam/' + exam_id + '/submissions');
	}

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
					console.log(data.data);
					$scope.courses = data.data;
				}
				else if (data.code === 401){
					$location.path('/');
				}
			})
			.error(function(data, status, header, config) {

			});
	};


	$scope.editExam = function (exam_id){
		$location.path('/exam/' + exam_id + '/edit');
	}

	$scope.previewExam = function(exam_id){
		$location.path('/exam/' + exam_id + '/preview');
	}

	$scope.startExam = function(exam_id){
		$location.path('/exam/' + exam_id);
	}

	$scope.removeExam = function(exam){
		var modalInstance = $modal.open({
			templateUrl: 'deleteModal.html',
			controller: 'DeleteModalController',
			resolve: {
				exam: function () {
				  return exam;
				}
			}
		});

		modalInstance.result.then(function () {
			$route.reload();
		}, function () {
		});	
	};

	$scope.viewCourse = function(course_id){
		$location.path('/course/' + course_id);
	}

	$scope.viewGradedPaper = function(exam_id){
		$location.path('/exam/' + exam_id + '/view_paper');
	}

	$scope.getExamLabel = function(exam){
		if(exam.status === EXAM_STATUS.DRAFT){
			exam.statusText = "draft";
			return "label-warning";
		}else if(exam.status === EXAM_STATUS.FINISHED){
			exam.statusText = "grading";
			return "label-primary";
		}else if (exam.status === EXAM_STATUS.PUBLISHED){
			exam.statusText = "published!";
			return "label-success";
		}else if (exam.status === EXAM_STATUS.IN_EXAM){
			exam.statusText = "in exam";
			return "label-danger";
		}else {
			exam.statusText = "coming soon";
			return "label-danger";
		}	
	}

	$scope.getExamTime = function(starttime){
		var time = moment.tz(starttime, 'GMT').toDate();
		return time;
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

examApp.controller('viewCourseController', ['$scope', '$http', '$routeParams', 
	'EXAM_STATUS','SUBMISSION_STATUS', '$location','$modal', '$route',
	function($scope, $http, $routeParams, EXAM_STATUS,SUBMISSION_STATUS,$location,$modal,$route) {

	$scope.courseId = $routeParams.courseId;
	$scope.isDescriptionCollapsed = true;
	$scope.areSubmissionsCollapsed = true;

	$scope.gradePaper = function(exam_id,submission_id){
		$location.path('/exam/' + exam_id + '/submission/' + submission_id);
	};

	$scope.saveAndToggle = function(){
		$scope.isDescriptionCollapsed=!$scope.isDescriptionCollapsed;
		$scope.saveDescription();
	};


	$scope.markAllMCQs = function(exam_id){
		$http.get('/api/exam/' + exam_id + '/markmcq')
			.success(function(data){
				if(data.code===200){
					var modalData = {
										"message":"All MCQs has been graded!",
										"header": "Automatic Grading"
									};
					var modalInstance = $modal.open({
						templateUrl: 'confirmModal.html',
						controller: 'ConfirmModalController',
						resolve:{
							data:function(){
								return modalData;
							}
						}
					});

					modalInstance.result.then(function () {
						$route.reload();
					}, function () {
					});	
				}
			});
	};

	$scope.getCourseInfo = function() {
		// get course information
		$http.get('/api/course/' + $scope.courseId + '/course')
			.success(function(data) {
				if (data.code === 200) {
					$scope.prepareExams(data.data.exams);
					$scope.course = data.data;
					$scope.isAdmin = $scope.course.user_role === 'admin';
					console.log($scope.course);
				}else {
					$scope.error = data.data;
				}
			});
	};

	$scope.showExamStats = function(exam_id){
		$location.path('/exam/'+exam_id+'/submissions');
	};

	$scope.randomStart = function(exam_id){
		$http.get('/api/exam/' + exam_id + '/randomsubmission')
			.success(function(data){
				if(data.code===200){
					
					var submissionId = data.data.id;
					$location.path('/exam/' + exam_id + '/submission/' + submissionId);
				}
			});
	};

	$scope.editExam = function (exam_id){
		$location.path('/exam/' + exam_id + '/edit');
	}

	$scope.previewExam = function(exam_id){
		$location.path('/exam/' + exam_id + '/preview');
	}


	$scope.removeExam = function(exam){
		var modalInstance = $modal.open({
			templateUrl: 'deleteModal.html',
			controller: 'DeleteModalController',
			resolve: {
				exam: function () {
				  return exam;
				}
			}
		});

		modalInstance.result.then(function (exam) {
			$location.path('/exam/' + exam.id + '/edit');
		}, function () {
		});	
	};

	$scope.addExam = function() {
		var courses = [];
		courses.push($scope.course);
		var modalInstance = $modal.open({
			templateUrl: 'myModalContent.html',
			controller: 'ModalInstanceCtrl',
			resolve: {
				courses: function () {
				  return courses;
				}
			}
		});

		modalInstance.result.then(function (exam) {
			$location.path('/exam/' + exam.id + '/edit');
		}, function () {
		});
	};

	$scope.getStatusClass = function (submission){
		if(submission.submissionstate_id == SUBMISSION_STATUS.NOT_GRADED){
			submission.statusText = 'Submitted';
			return 'label-danger';
		}else if(submission.submissionstate_id == SUBMISSION_STATUS.GRADING){
			submission.statusText = 'Grading';
			return 'label-warning';
		}else{
			submission.statusText = 'Graded';
			return 'label-success';
		}
	};

	$scope.saveDescription = function(){
		// put course information
		$http.put('/api/course/' + $scope.courseId + '/course',$scope.course)
			.success(function(data) {
		});
	};

	$scope.prepareExams = function(exams){
		$scope.updateStartTime(exams);
		$scope.updateGradingStatus(exams);
	};

	$scope.updateGradingStatus = function(exams){
		for(var i in exams){
			var exam = exams[i];
			if(exam.submission_status){
				exam.status_data = [];
			  	exam.status_data.push({
		          value: (exam.submission_status.graded*100)/exam.submission_status.total,
		          count:exam.submission_status.graded,
		          text:'Finished:',
		          type: 'success'
		        });
		        exam.status_data.push({
		          value: (exam.submission_status.grading*100)/exam.submission_status.total,
			          count:exam.submission_status.grading,
		          text:'Grading:',
		          type: 'warning'
		        });
		        exam.status_data.push({
		          value: (exam.submission_status.not_graded*100)/exam.submission_status.total,
		          count:exam.submission_status.not_graded,
		          text:'Left:',
		          type: 'danger'
		        });
		        if(exam.submission_status.graded == exam.submission_status.total){
		        	exam.grading_finished = true;
		        }else{
		        	exam.grading_finished = false;
		        }
			}
		}
	};

	$scope.updateStartTime = function(exams){
		for(var i in exams){
			exams[i].starttime = moment.tz(exams[i].starttime, 'GMT').toDate();
		}
	};

	//delete the question from database
	$scope.deleteQuestion = function(question_id) {
		var question={'id':question_id};
		$http.post('/api/exam/' + $scope.examId + '/deletequestion', question)
			.success(function(data){
				if (data.code === 200) {
					$scope.exam.totleqn-=1;
				}
			})
		
		$scope.exam.questions.splice(index, 1);
	};

	$scope.getExamLabel = function(exam){
		if(exam.status === EXAM_STATUS.FINISHED){
			exam.statusText = "grading";
			return "label-primary";
		}else if (exam.status === EXAM_STATUS.PUBLISHED){
			exam.statusText = "published!";
			return "label-success";
		}else if(exam.status === EXAM_STATUS.DRAFT){
			exam.statusText = "draft";
			return "label-default";
		}else {
			exam.statusText = "coming soon";
			return "label-danger";
		}	
	}

	$scope.isExamFinished = function(exam_status){
		return exam_status === EXAM_STATUS.FINISHED || exam_status === EXAM_STATUS.PUBLISHED;
	}

	$scope.getCourseInfo();
}]);


examApp.controller('examDetailsController', ['$scope', '$http', '$routeParams', 'EXAM_STATUS',
	'SUBMISSION_STATUS', '$location','$modal','uiGridConstants','$route', 'GRAPH_LEVEL',
	function($scope, $http, $routeParams, EXAM_STATUS,SUBMISSION_STATUS,$location,$modal,uiGridConstants,$route,GRAPH_LEVEL) {

	$scope.examId = $routeParams.examId;
	$scope.isDescriptionCollapsed = true;
	$scope.areSubmissionsCollapsed = false;
	$scope.allSubmissionData = [];
	$scope.gradedSubmissionData = [];
	$scope.notGradedSubmissionData = [];
	$scope.gradingSubmissionData = [];
	$scope.graph = {};

	$scope.AllSubmissionsGrid = {
	    enableFiltering: true,
    	enableRowSelection: true,
    	showGridFooter: true,
    	showColumnFooter: true,
	    // data: $scope.allSubmissionData,
	     onRegisterApi: function(gridApi){ 
		     $scope.allApi = gridApi;
		   }
	};

	$scope.gradedSubmissionsGrid = {
	    enableFiltering: true,
    	enableRowSelection: true,
    	showGridFooter: true,
    	showColumnFooter: true,
	    data: $scope.gradedSubmissionData,
	     onRegisterApi: function(gridApi){ 
		     $scope.gradedApi = gridApi;
		   }
	};

	$scope.notGradedSubmissionsGrid = {
	    enableFiltering: true,
    	enableRowSelection: true,
    	showGridFooter: true,
    	showColumnFooter: true,
	    data: $scope.notGradedSubmissionData,
	     onRegisterApi: function(gridApi){ 
		     $scope.notGradedApi = gridApi;
		   }
	};

	$scope.gradingSubmissionsGrid = {
	    enableFiltering: true,
    	enableRowSelection: true,
    	showGridFooter: true,
    	showColumnFooter: true,
	    data: $scope.gradingSubmissionData,
	     onRegisterApi: function(gridApi){ 
		     $scope.gradingApi = gridApi;
		   }
	};

	$scope.export = function(index){
	    switch(index){
	    	case 1:
	      		$scope.allApi.exporter.csvExport('all', 'all');
	      		break;
	      	case 2:
	      		$scope.gradedApi.exporter.csvExport('all','all');
	      		break;
	      	case 3:
	      		$scope.notGradedApi.exporter.csvExport('all','all');
	      		break;
	      	default:
	      		$scope.gradingApi.exporter.csvExport('all','all');
	      		break;
	  	}

    } 

	$scope.gradePaper = function(row) {
      	$location.path('/exam/' + $scope.examId + '/submission/' + row.entity.submission_id);
     };

	$scope.getExamInfo = function() {
		$http.get('/api/exam/' + $scope.examId + '/examsubmissions')
			.success(function(data) {
				if (data.code === 200) {
					if(data.data.submissions.length>0){
						$scope.prepareExams(data.data);
						data.data.isPublished = data.data.status === EXAM_STATUS.PUBLISHED;
						data.data.publishText = data.data.isPublished? "Published!":"Publish";
						console.log(data.data);
						$scope.exam = data.data;
					}else{
						$scope.error = "Oops! No available submissions/statistics have been found for this exam."
					}
				}else {
					$scope.error = data.data;
				}
			});
	};

	$scope.randomStart = function(){
		$http.get('/api/exam/' + $scope.examId + '/randomsubmission')
			.success(function(data){
				if(data.code===200){
					var submissionId = data.data.id;
					$location.path('/exam/' + $scope.examId + '/submission/' + submissionId);
				}
			});
	};

	$scope.markAllMCQs = function(){
		$http.get('/api/exam/' + $scope.examId + '/markmcq')
			.success(function(data){
				if(data.code===200){
					var modalData = {
										message:"All MCQs has been graded!",
										header: "Automatic Grading"
									};
					var modalInstance = $modal.open({
						templateUrl: 'confirmModal.html',
						controller: 'ConfirmModalController',
						resolve:{
							data:function(){
								return modalData;	
							}
						}
					});

					modalInstance.result.then(function () {
						$route.reload();
					}, function () {
					});	
				}
			});
	};

	$scope.publishResult = function(){
		//TODO: popup window to collect feedback
		$http.get('/api/exam/' + $scope.examId + '/publish')
			.success(function(data){
				if(data.code===200){
					var modalData = {
										message:"Result has been published!",
										header:"Publish Result"
									};
					var modalInstance = $modal.open({
						templateUrl: 'confirmModal.html',
						controller: 'ConfirmModalController',										
						backdrop: 'static',
						resolve:{
							data:function(){
								return modalData;		
							}
						}
					});

					modalInstance.result.then(function () {
						$route.reload();
					}, function () {
					});	
				}
			});
	}

	$scope.getStatusClass = function (submission){
		if(submission.submissionstate_id == SUBMISSION_STATUS.NOT_GRADED){
			submission.statusText = 'Submitted';
			return 'label-important';
		}else if(submission.submissionstate_id == SUBMISSION_STATUS.GRADING){
			submission.statusText = 'Grading';
			return 'label-warning';
		}else{
			submission.statusText = 'Graded';
			return 'label-success';
		}
	}

	$scope.prepareExams = function(exam){
		$scope.updateStartTime(exam);
		$scope.updateGradingStatus(exam);
		$scope.prepareData(exam);
		$scope.initializeColumns(exam.totalqn);
	};


	$scope.initializeColumns = function(qn_count){

		var grid_columnDefs = [{
			field: "student" ,
			 cellTemplate:'<div>' +
                   '<a ng-click="grid.appScope.gradePaper(row)">{{row.entity.student}}</a>' +
                   '</div>' ,
              cellClass: 'grid-center-align'
		}];
		var index=1;
		while(index < qn_count+1){
			grid_columnDefs.push({
				field: index.toString(),
				name:"Qn " + index,
				cellClass: 'grid-center-align',
				aggregationType: uiGridConstants.aggregationTypes.avg,
				footerCellTemplate: '<div class="grid-center-align">Avg: {{col.getAggregationValue()| number:2}}</div>' 
			});
			index +=1;
		}
		grid_columnDefs.push({
			field:"total_marks",
			name:"Total",
			cellClass:"grid-center-align",
			aggregationType: uiGridConstants.aggregationTypes.avg,
			footerCellTemplate: '<div class="grid-center-align">Avg: {{col.getAggregationValue()| number:2}}</div>' 
		});
		grid_columnDefs.push({
			field:"status",
			name:'Status',
			cellClass:'grid-center-align'
		});

		$scope.AllSubmissionsGrid.columnDefs = grid_columnDefs;
		$scope.gradedSubmissionsGrid.columnDefs = grid_columnDefs;		
		$scope.gradingSubmissionsGrid.columnDefs = grid_columnDefs;
		$scope.notGradedSubmissionsGrid.columnDefs = grid_columnDefs;

		console.log($scope.AllSubmissionsGrid);

	};

	$scope.prepareData = function(exam){

		$http.get('/api/exam/' + $scope.examId + '/griddata')
			.success(function(data) {
				if (data.code === 200) {
					$scope.AllSubmissionsGrid.data = data.data.all;
					$scope.gradedSubmissionsGrid.data = data.data.graded;
					$scope.gradingSubmissionsGrid.data = data.data.grading;
					$scope.notGradedSubmissionsGrid.data = data.data.notGraded;
				}else {
					$scope.error = data.data;
				}
			});

		$http.get('/api/exam/' + $scope.examId + '/graphdata')
			.success(function(data) {
				if (data.code === 200) {
					console.log(data.data);
					$scope.graph = data.data;
				}else {
					$scope.error = data.data;
				}
			});

	};

	$scope.updateGradingStatus = function(exam){

		$scope.progress={};
		$scope.progress.data=[exam.submission_status.graded,exam.submission_status.grading,exam.submission_status.not_graded];
		$scope.progress.labels=['Graded','Grading','Submitted'];
		
		exam.status_data = [];
	  	exam.status_data.push({
          value: (exam.submission_status.graded*100)/exam.submission_status.total,
          count:exam.submission_status.graded,
          text:'Finished:',
          type: 'success'
        });
        exam.status_data.push({
          value: (exam.submission_status.grading*100)/exam.submission_status.total,
	          count:exam.submission_status.grading,
          text:'Grading:',
          type: 'warning'
        });
        exam.status_data.push({
          value: (exam.submission_status.not_graded*100)/exam.submission_status.total,
          count:exam.submission_status.not_graded,
          text:'Left:',
          type: 'danger'
        });
        if(exam.submission_status.graded == exam.submission_status.total){
        	exam.grading_finished = true;
        }else{
        	exam.grading_finished = false;
        }
	};

	$scope.updateStartTime = function(exam){
		exam.starttime = moment.tz(exam.starttime, 'GMT').toDate();
	};

	$scope.getExamLabel = function(exam){
		if(exam){
			if(exam.status === EXAM_STATUS.FINISHED){
				exam.statusText = "grading";
				return "label-primary";
			}else if (exam.status === EXAM_STATUS.PUBLISHED){
				exam.statusText = "published";
				return "label-success";
			}else if(exam.status === EXAM_STATUS.DRAFT){
				exam.statusText = "draft";
				return "label-default";
			}else {
				exam.statusText = "coming soon";
				return "label-inverse";
			}	
		}
	};

	$scope.getExamInfo();
}]);

examApp.controller('viewExamController', ['$scope', '$http', '$routeParams', 
	'QN_TYPES', 'EXAM_STATUS', 'moment','$timeout', '$route','$location', '$modal',
	function($scope, $http, $routeParams, QN_TYPES, EXAM_STATUS,moment,$timeout,$route,$location,$modal) {

	$scope.curQnIndex = 0;
	$scope.examId = $routeParams.examId;
	$scope.error = null;
	$scope.showTimer=true;
	$scope.startDisabled = true;

	$scope.langs=['C/C++','Java']
	// code editor setting
    $scope.aceOptions = {
	  useWrapMode : true,
	  theme:'clouds',
	  mode: 'c_cpp',
	  firstLineNumber: 1,
	  require:['ace/ext/language_tools'],
	  // onload: "aceLoaded",
	  // advanced:{
	  // 	enableSnippets: true,
	  // 	enableLiveAutocompletion: true
	  // }
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
					var endtime = moment.tz($scope.exam.starttime, 'GMT').add($scope.exam.duration,'minutes');
					$scope.exam.starttime = moment.tz($scope.exam.starttime, 'GMT').toDate();

					if (moment().isAfter(moment.tz($scope.exam.starttime, 'GMT').add($scope.exam.duration,'minutes'))){
						$scope.examAction="Exam Has Finished!"
					}else {
						$scope.examAction="Start Exam"
						var canStartExam = moment().isAfter($scope.exam.starttime);
						if(canStartExam){
							$scope.startDisabled = false;
							console.log('exam already started');
						}else{
							console.log('counting down for exam start');
							$scope.startCountdown();
						}
					}

				} else {
					$scope.error = data.data;
				}
		});
	};

	$scope.startExam = function(){

		// start timer 
		// todo calculate based on server returned current time
		$scope.startExamSubmission();
		$scope.timerEndTime = parseInt(moment.tz($scope.exam.starttime, 'GMT').add($scope.exam.duration,'minutes').format('x'),10);
		
		//start countdown timer
		$timeout(function(){
	        $scope.$broadcast('timer-start');
	    },0);	   
	   	$scope.canAnswerQuestion = true;
     };

    $scope.startCountdown = function(){
	    $scope.timerRunning = false;
		$scope.timerEndTime = parseInt(moment.tz($scope.exam.starttime, 'GMT').format('x'),10);
		//start countdown timer
	    $timeout(function(){
	        $scope.$broadcast('timer-start');
	    },0);	
	    console.log($scope.timerEndTime);

	    $scope.timerRunning = true;
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
				}else {
					$scope.error = data.data;
				}
			});
	};

	$scope.submitCurrentQuestion = function(){

		if (!$scope.curQnSubmission) {
			return;
		}
		console.log($scope.curQnSubmission);
		if ($scope.curQnSubmission.id) {
			// id does exist, update submission
			$http.put('/api/submission/' + $scope.submission.id + '/questionsubmission', $scope.curQnSubmission)
			.success(function(data){
				if (data.code === 200){
					console.log(data.data);
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

	$scope.onTimeUp = function() {

		if($scope.canAnswerQuestion){
			$scope.submitCurrentQuestion();
			var modalData = {
								message:"All changes has been saved. Good luck!",
								header: "Exam Finished"
							};
	  		var modalInstance = $modal.open({
				templateUrl: 'confirmModal.html',
				controller: 'ConfirmModalController',
				backdrop: 'static',
				resolve:{
					data:function(){
						return modalData;
					}
				}
			});

			modalInstance.result.then(function () {
				$location.path('/home');
			}, function () {
			});
			// console.log('time is up');
		}else{
			$route.reload();
		}

	};

	$scope.getExamInfo();
}]);

examApp.controller('markExamController', ['$scope', '$routeParams', '$http', 'QN_TYPES', 'EXAM_STATUS', 
	'SUBMISSION_STATUS','$timeout','$location','$modal',
	function($scope, $routeParams, $http, QN_TYPES, EXAM_STATUS,SUBMISSION_STATUS,$timeout,$location,$modal) {

		$scope.examId = $routeParams.examId;
		$scope.submissionId = $routeParams.submissionId;
		$scope.isQuestionCollapsed = [];
		$scope.isQuestionActive = [];
		$scope.currentQuestion = null;

		// code editor setting
	    $scope.aceOptions = {
		  useWrapMode : true,
		  theme:'clouds',
		  mode: 'c_cpp',
		  firstLineNumber: 1,
		  require:['ace/ext/language_tools'],
		  onload: "aceLoaded",
		  advanced:{
		  	enableSnippets: true,
		  	enableLiveAutocompletion: true
		  }
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
		
		$scope.previousSubmission = function(){
			//check if all questions have been graded
		};

		$scope.isExamSubmissionGraded = function(){
			var graded = true;
			console.log('checking status');
			for (var i in $scope.exam.questions) {
				console.log($scope.exam.questions[i].submission.submissionstate_id);
				if($scope.exam.questions[i].submission &&
					$scope.exam.questions[i].submission.submissionstate_id != SUBMISSION_STATUS.GRADED){
					graded = false;
					break;
				}
			}
			return graded;
		}

		$scope.showOriginal = function(submission){
			submission.answer_copy = submission.answer;
		}

		$scope.nextSubmission = function(){
			//check if all questions have been graded
			// if($scope.isExamSubmissionGraded){
			// 	$http.get('/api/submission/' + $scope.submissionId + '/finish')
			// 	.success(function(data){});
			// }
			$http.get('/api/submission/' + $scope.submissionId + '/nextsubmission')
				.success(function(data){
					if(data.code===200){
						var submissionId = data.data.id;
						$location.path('/exam/' + $scope.examId + '/submission/' + submissionId);
					}
					else{
						var modalData = {
											message:"There are no more unmarked papers!",
											header:"No More Paper Found"
										};
						var modalInstance = $modal.open({
							templateUrl: 'confirmModal.html',
							controller: 'ConfirmModalController',
							resolve:{
								data:function(){
								return modalData;
								}
							}
						});

						modalInstance.result.then(function () {
							$location.path('/exam/'+ $scope.examId + '/submissions');
						}, function () {
						});	
					}
				});
		};

		$scope.markQuestion = function(index) {
			$http.put('/api/submission/' + $scope.submissionId + '/qnmarking', 
				$scope.exam.questions[index].submission).success(function(data){
					if(data.code===200){
						$scope.exam.questions[index].submission.submissionstate_id = SUBMISSION_STATUS.GRADED;
					}
				});
			$scope.updateTotalMarks();
		};

		$scope.goToQuestion = function(newIndex) {
			if($scope.currentQuestion!=null){
				// $scope.markQuestion($scope.currentQuestion);
				$scope.isQuestionActive[$scope.currentQuestion] = false;
			}
			$scope.isQuestionActive[newIndex] = true;

			if($scope.exam.questions[newIndex].submission && 
				$scope.exam.questions[newIndex].submission.submissionstate_id === SUBMISSION_STATUS.NOT_GRADED){
				$scope.exam.questions[newIndex].submission.submissionstate_id = SUBMISSION_STATUS.GRADING;
				$http.post('/api/submission/' + $scope.submissionId + '/startqnmarking', 
					$scope.exam.questions[newIndex].submission)
					.success(function(data){
				});
			}
			$scope.currentQuestion = newIndex;
		};

		$scope.getExamInfo = function() {
			$http.get('/api/exam/' + $scope.examId + '/examinfo')
			.success(function(data){
				if (data.code === 200) {
					for (var i in data.data.questions) {
						$scope.isQuestionCollapsed.push(true);
						$scope.isQuestionActive.push(false);
					}					
					$scope.exam = data.data;
					if ($scope.exam.status === EXAM_STATUS.UNAVAILABLE) {
						$scope.error = 'You are not allowed to view this page';
					}
					else{
						$scope.getSubmission();
					}	
				}else{
					$scope.error = data.data;
				}
			});
		};

		$scope.getSubmission = function() {
			// todo
			// get exam submission data from server
			$http.get('/api/submission/' + $scope.submissionId + '/examsubmission')
			.success(function(data){
				if (data.code === 200) {
					console.log('here here here');
					console.log(data.data);
					$scope.submission = data.data;
					$scope.mergeSubmissionToExam();
					$scope.goToQuestion(0);
					console.log($scope.submission.submissionstate_id);
					if($scope.submission.submissionstate_id === SUBMISSION_STATUS.NOT_GRADED){
						$http.get('/api/submission/' + $scope.submissionId + '/startgrading')
							.success(function(data){
								console.log(data.data);
						});
					}
				}
			});
		};

		$scope.mergeSubmissionToExam = function() {
			if (!$scope.submission) {
				return;
			}
			if (!$scope.exam) {
				return;
			}

			for (var i in $scope.exam.questions) {
				$scope.exam.questions[i].submission = $scope.getQuestionSubmission($scope.exam.questions[i].id);
				// $scope.exam.questions[i].submission.invalidmark=false;
				if($scope.isCodingQuestion($scope.exam.questions[i])){
					$scope.exam.questions[i].submission.answer_copy = $scope.exam.questions[i].submission.answer;
				}
				//$scope.exam.questions[i].answers = [];
			}
		};

		$scope.getQuestionSubmission = function(questionId) {
			for (var i in $scope.submission.questions) {
				if ($scope.submission.questions[i].question_id === questionId) {
					return $scope.submission.questions[i];
				}
			}

			return null;
		};

		$scope.getQuestionStatus = function(question){
			if(question.submission){
				if(question.submission.submissionstate_id === SUBMISSION_STATUS.GRADED){
					return 'label-success';
				}else if(question.submission.submissionstate_id === SUBMISSION_STATUS.GRADING){
					return 'label-warning';
				}else{
					return 'label-danger';
				}
			}
			return 'label-default';
		}

		// helper function to calculate the total mark
		$scope.updateTotalMarks = function() {
			if (!$scope.submission) {
				return;
			}

			$total=0;
			for (var i in $scope.exam.questions) {
				if($scope.exam.questions[i].submission && $scope.exam.questions[i].submission.marks_obtained){
					$total += $scope.exam.questions[i].submission.marks_obtained;
				}
			}
			$scope.submission.total_marks = $total;

			console.log($scope.submission.total_marks);
		};

		$scope.CompileRun = function(submission){
			var student_answer={
				'code':submission.answer_copy,
				'lang':'c++'
			};

			$http.post('/api/test-code',student_answer)
			.success(function(data){
				if (data.code === 200) {
					console.log(data);
					submission.resultReady = true;
					if(data.data.compilation.length>0){
						submission.compilation_fail = true;
						submission.compilation_error = data.data.compilation;
					}else{
						submission.compilation_fail = false;
						submission.output = data.data.execution;	
					}
				}
			});
		}

		$scope.isCorrectMCQ = function(question,option){
			// console.log(question);
			// if(option.correctOption == 1){
			// 	return 'green';
			// }else if(question.submission.choice == option.id){
			// 	if(option.correctOption != 1){
			// 		return 'red';
			// 	}
			// }
			// return 'black';		
		}

		$scope.isCorrectMRQ = function(submission, option){
			// console.log(submission);
			// console.log(option);
			// if(option.correctOption === 1){
			// 	for (var i in submission.choices){
			// 		//if choosen
			// 		if (submission.choices[i] === option.id){
			// 			return 'green';
			// 		}
			// 	}
			// 	return 'orange';
			// }
			// //wrong option
			// else{
			// 		for (var i in submission.choices){
			// 			//if choosen
			// 			if (submission.choices[i] === option.id){
			// 				return 'red';
			// 			}
			// 	}
			// }
			// return 'black';	
		}

		$scope.getExamInfo();
}]);

examApp.controller('newExamController', ['$scope', '$location','$http', '$routeParams', 
	'QN_TYPES', 'EXAM_STATUS', 'moment', 'taSelection','$modal',
	function($scope, $location, $http, $routeParams, QN_TYPES, EXAM_STATUS, moment, taSelection,$modal) {

	$scope.examId = $routeParams.examId;
	$scope.isExamInfoCollapsed = true;
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
		console.log($scope.exam);
		$http.put('/api/exam/' + $scope.examId + '/editexam', $scope.exam)
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
				console.log($scope.exam);

				var time = moment.tz($scope.exam.starttime, 'GMT').toDate();
				$scope.exam.starttime = time;

				if ($scope.exam.status === EXAM_STATUS.UNAVAILABLE) {
					$scope.error = 'You are not allowed to view this page';
				}else if ($scope.exam.status != EXAM_STATUS.DRAFT){
					$scope.error = 'You are not allowed to edit an active/archived exam!'
				}
			}
		});

		$http.get('/api/exam/' + $scope.examId + '/availableqns')
			.success(function(data){
				if (data.code === 200) {
					$scope.available_questions = data.data;
				}
		});	
	};

	$scope.isExamInfoCollapsed = false;
	// $scope.ExamName="CS1010 Mid-Term Exam";

	// $scope.defaultDate = "2015-02-05T08:00:01.534Z"; // (formatted: 2/5/15 4:00 PM)
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

	$scope.addQuestion = function(){
				
		var modalInstance = $modal.open({
			templateUrl: 'addQnModal.html',
			controller: 'addQnModalController',
			resolve: {
				questions: function () {
				  return $scope.available_questions;
				}
			}
		});

		modalInstance.result.then(function (question) {
			$scope.exam.questions.push(question);
			$http.post('/api/exam/' + $scope.examId + '/addqn', question)
			.success(function(data){
				if (data.code === 200) {
					$scope.exam.totalqn += 1;
				}
			});			
		}, function () {
		});
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
	//delete the question from database
	$scope.deleteQuestion = function(index) {
		if(index<$scope.exam.totalqn){
			if($scope.exam.questions[index].hasOwnProperty('id')){
				var question={'id':$scope.exam.questions[index].id};
				$http.post('/api/exam/' + $scope.examId + '/deletequestion', question)
					.success(function(data){
						if (data.code === 200) {
							$scope.exam.totleqn-=1;
						}
					})
			}
		}			
		$scope.exam.questions.splice(index, 1);
	};
	//un-relate question with exam
	$scope.removeQuestion = function(index){
		if(index<$scope.exam.totalqn){
			if($scope.exam.hasOwnProperty('id')){
				$http.post('/api/exam/' + $scope.examId + '/removequestion', $scope.exam.questions[index])
					.success(function(data){
						if (data.code === 200) {
							$scope.exam.totleqn-=1;
						}
					})
			}
		}			
		$scope.exam.questions.splice(index, 1);
	}

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