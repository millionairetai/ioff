angular.module('centeroffice', [
    'ui.bootstrap',
    'ui.router',
    'ngSanitize',
    'ngCookies',
    'angular-loading-bar',
    'angularFileUpload'
]).constant('SITE_URL', SITE_URL)
  .value('$a', angular.element);

angular.module('centeroffice').config(function ($urlRouterProvider, $httpProvider, $sceDelegateProvider,
        cfpLoadingBarProvider, $compileProvider, $locationProvider) {
//    $sceDelegateProvider.resourceUrlWhitelist(['self', '*://www.youtube.com/**', '*://player.vimeo.com/video/**']);
//    $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|file|skype):/);

    /* Add New States Above */
//    $urlRouterProvider.otherwise('/');
    
    $locationProvider.html5Mode(true);
    $httpProvider.interceptors.push('authInterceptor');
    
    // enable http caching
    $httpProvider.defaults.cache = true;

    //angular loading bar
    cfpLoadingBarProvider.includeSpinner = true;
    cfpLoadingBarProvider.includeBar = true;
}).factory('authInterceptor', function ($q, $cookieStore, $location) {
    return {
        // Add authorization token to headers
        request: function (config) {
            config.headers = config.headers || {};
            if ($cookieStore.get('token')) {
                config.headers.Authorization = $cookieStore.get('token');
            }
            return config;
        },
        // Intercept 401s and redirect you to login
        responseError: function (response) {
            if (response.status === 401) {
                $location.path('/');
                // remove any stale tokens
                $cookieStore.remove('token');
                return $q.reject(response);
            }
            else {
                return $q.reject(response);
            }
        }
    };
}).run(function ($rootScope, $state, cfpLoadingBar, $cookieStore, $anchorScroll, $window,
        $http, $cacheFactory, commonService) {
    cfpLoadingBar.start();

    $rootScope.token = $cookieStore.get('token');
    $rootScope.cache = $cacheFactory('centeroffice');

    $rootScope.currStateName = '';
    $rootScope.stateData = {};
    $rootScope.errors = {};


    //http://stackoverflow.com/questions/14117653/how-to-cache-an-http-get-service-in-angularjs
    $rootScope.isLoading = function () {
        return $http.pendingRequests.length > 0;
    }

    $state.go('project-home');
    var checkLogin = function () {
        if (!$rootScope.token) {
            $state.go('employee');
        }
    }

    checkLogin();

    $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams) {
        checkLogin();
        $rootScope.currStateName = toState.name;

        //authenticate  
        if (toState.auth != false) {
//            event.preventDefault();
//            if ($cookieStore.get('token')) {
                commonService.prepareState(toState.url).success(function (data) {
                    $state.go(toState.name);
                }).error(function (data) {
                    alertify.error($rootScope.$lang.you_dont_have_permission_to_access_this_page);
                    $state.go(fromState.name);
                });
//            } else {
//                alertify.error($rootScope.$lang.you_dont_have_permission_to_access_this_page);
//                $state.go(fromState.name);
//            }
        }
    });

    /*
     *scroll to top when state changed 
     */
    var wrap = function (method) {
        var orig = $window.window.history[method];
        $window.window.history[method] = function () {
            var retval = orig.apply(this, Array.prototype.slice.call(arguments));
            $anchorScroll();
            return retval;
        };
    };

    wrap('pushState');
    wrap('replaceState');
    /*End scroll to top*/
});