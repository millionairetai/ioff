(function (angular) {
    'user strict';
    
    var app = angular.module('centeroffice', []);    
    app.constant('JOB_TYPE', 1);
    app.constant('NUM_ROW', 50);
    
    app.config(function ($httpProvider) {
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
    });
    
    app.controller('ce_controller', function ($scope) {
        $scope.nameText = '1111';
        
        $scope.test = function() {
            console.log($scope.LoginForm.rememberMe);
            alert($scope.LoginForm.rememberMe);
        }
    });

})(window.angular);
