angular.module('centeroffice', []).constant('SITE_URL', '');
var a = angular.element;

angular.module('centeroffice')
  .config(function ($urlRouterProvider, $httpProvider, $sceDelegateProvider, $compileProvider, $locationProvider) {
      
  })
  .factory('authenticate', function ($q, $cookieStore, $location) {
    return {
    };
  })
  .run(function ($rootScope, $state, $cookieStore, SITE_URL, $anchorScroll, $window) {                                  
    $rootScope.DAY = '24-4-1988'; 
  })
  .value('DEFAULT_URL', '1111111111111');