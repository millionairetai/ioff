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
//            .when('/viewCalendar/:calendarId', {
            .when('/viewCalendar', {
            	templateUrl: 'app/views/calendar/view.html',
            	controller: 'viewCalendarCtrl'
            })
            //authority
            .when('/authority', {
                templateUrl: 'app/views/authority/index.html',
                controller: 'AuthorityCtrl'
            })
            .when('/employee', {
                templateUrl: 'app/views/employee/index.html',
                controller: 'EmployeeCtrl'
            })
            .when('/viewEmployee/:employeeId', {
                templateUrl: 'app/views/employee/profile.html',
                controller: 'ProfileCtrl'
            })
            .when('/changePassword/:employeeId', {
                templateUrl: 'app/views/employee/change_password.html',
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
                controller: 'ChangePackageCtrl'
            })
            .otherwise({redirectTo: '/home'});

});


