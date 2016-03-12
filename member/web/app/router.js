appRoot.config(function ($routeProvider, $httpProvider) {
    // enable http caching
    $httpProvider.defaults.cache = true;
    
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
            //calendar
            .when('/calendar', {
                templateUrl: 'app/views/calendar/index.html',
                controller: 'calendarCtrl'
            })
            .otherwise({redirectTo: '/home'});

});


