appRoot.config(function ($stateProvider, $urlRouterProvider, $httpProvider) {
    // enable http caching
//    $httpProvider.defaults.cache = true;

    $urlRouterProvider
            .otherwise('/home');

    $stateProvider
            .state('home', {
                url: '/home',
                templateUrl: 'app/views/home/index.html',
                controller: 'homeCtrl',
            })
            .state('project', {
                url: '/project',
                templateUrl: 'app/views/project/index.html',
                controller: 'projectCtrl'
            })
            .state('addProject', {
                url: '/addProject',
                templateUrl: 'app/views/project/add.html',
                controller: 'addProjectCtrl'
            })
            .state('calendar', {
                url: '/calendar',
                templateUrl: 'app/views/calendar/index.html',
                controller: 'calendarCtrl'
            })          
            //authority
            .state('authority', {
                url: '/authority',
                templateUrl: 'app/views/authority/index.html',
                controller: 'AuthorityCtrl'
            });
});


