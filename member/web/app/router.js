appRoot.config(function ($routeProvider, $httpProvider) {
    // enable http caching
//    $httpProvider.defaults.cache = true;
    
    //Router
    $routeProvider
            //main page
            .when('/home', {
                templateUrl: 'app/views/home/index.html',
                controller: 'homeCtrl'
            })
            //project
            .when('/project', {
                templateUrl: 'app/views/project/index.html',
                controller: 'projectCtrl'
            })
            .when('/addProject', {
                templateUrl: 'app/views/project/add.html',
                controller: 'addProjectCtrl'
            })
            .when('/viewProject/:projectId', {
            	templateUrl: 'app/views/project/view.html',
            	controller: 'viewProjectCtrl'
            })
            .when('/editProject', {
            	templateUrl: 'app/views/project/edit.html',
            	controller: 'editProjectCtrl'
            })
            //calendar
            .when('/calendar', {
                templateUrl: 'app/views/calendar/index.html',
                controller: 'calendarCtrl',
                resolve : {
                    settingSystem : function($q, calendarService){
                        var deferred = $q.defer();
                        calendarService.getLanguage({},function(respone){
                            deferred.resolve(respone.objects);
                        });
                        
                        return deferred.promise;
                    },
                    listCalendar : function($q, calendarService){
                        var deferred = $q.defer();
                        calendarService.listCalendars({},function(respone){
                            deferred.resolve(respone.objects);
                        });
                        
                        return deferred.promise;
                    }
                }
            })
            .when('/viewEvent/:eventId', {
            	templateUrl: 'app/views/calendar/view.html',
            	controller: 'viewEventCtrl'
            })
            //authority
            .when('/authority', {
                templateUrl: 'app/views/authority/index.html',
                controller: 'AuthorityCtrl'
            })
            //task
            .when('/task', {
                templateUrl: 'app/views/task/index.html',
                controller: 'taskCtrl'
            })
            .when('/addTask', {
                templateUrl: 'app/views/task/add.html',
                controller: 'addTaskCtrl'
            })
            .when('/viewTask/:taskId', {
                templateUrl: 'app/views/task/view.html',
                controller: 'viewTaskCtrl'
            })
            //notify
            .when('/notify', {
                templateUrl: 'app/views/notify/index.html',
                controller: 'NotifyCtrl'
            })
            //notify
            .when('/search', {
                templateUrl: 'app/views/search/index.html',
                controller: 'searchCtrl'
            })
            .when('/employee', {
                templateUrl: 'app/views/employee/index.html',
                controller: 'EmployeeCtrl'
            })
             .when('/viewEmployee/:employeeId', {
                templateUrl: 'app/views/employee/profile.html',
                controller: 'profileCtrl'
            })
            .when('/changePassword/:employeeId', {
                templateUrl: 'app/views/employee/changePassword.html',
                controller: 'ChangePasswordCtrl'
            })
            .when('/activity', {
                templateUrl: 'app/views/activity/index.html',
                controller: 'ActivityCtrl'
            })
            .when('/company', {
                templateUrl: 'app/views/company/index.html',
                controller: 'CompanyCtrl'
            })
            .when('/changePackage', {
                templateUrl: 'app/views/company/changePackage.html',
                controller: 'changePackageCtrl'
            })
            .when('/authority/:authorityId', {
                templateUrl: 'app/views/authority/detail.html',
                controller: 'AuthorityDetailCtrl'
            })
            .when('/report', {
                templateUrl: 'app/views/report/index.html',
                controller: 'reportCtrl'
            })
            .otherwise({redirectTo: '/home'});

});


