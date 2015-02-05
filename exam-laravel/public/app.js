// app.js

var examApp = angular.module('examApp', ['ngRoute', 'ui.bootstrap','ui.ace','textAngular',
	'mgcrea.ngStrap.datepicker','mgcrea.ngStrap.timepicker']);

examApp.config(function($routeProvider,$locationProvider,$provide) {
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

});


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

		var newExamVar = $scope.exam;

		$scope.createError = null;
		$http.post('/api/create-exam', newExamVar)
		.success(function(data, status, header, config) {
			console.log(data);
			if(data['code']==200){
				console.log('success');
				$modalInstance.close();
				$scope.exam = data['data'];
			}
			else
				$scope.createError = data['data'];
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

	$scope.saveExam=function(){
		$scope.isExamInfoCollapsed = true;
		$http.put('/api/exam/1/editexam',$scope.exam)
			.success(function(data){
				if(data['code']==200)
					$scope.exam = data;
			})
	};

	$scope.isExamInfoCollapsed = true;
	$scope.ExamName="CS1010 Mid-Term Exam";

	$scope.exam={
		title:"Mid Term Test",
		course:"CS1010J",
		fullmarks:100,
		duration:90
	};

	$scope.defaultDate = "2015-02-05T08:00:01.534Z"; // (formatted: 2/5/15 4:00 PM)
	$scope.isMarkingSchemeCollapsed = true;
	$scope.hasMarkingScheme = false;

	$scope.toggleMarkingScheme=function(){
		// $scope.hasMarkingScheme = !($scope.hasMarkingScheme);
		$scope.isMarkingSchemeCollapsed = !($scope.isMarkingSchemeCollapsed);
	};

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

    $scope.textAreaSetup = function($element){
	  $element.attr('ui-codemirror', '');
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