angular.module('centeroffice').controller('LoginCtrl', function ($rootScope, $scope, $state, authService) {
    $scope.employee = {
        username: '',
        password: '',
        rememberMe: 0
    };

    $scope.login = function (form) {
        if (form.$valid) {
            authService.login($scope.employee).then(function (data) {
                $scope.submited = false;
                $rootScope.token = data;
                $state.go('project.home');
            }, function (data) {
                $rootScope.errors = data.data;
            });
        }
    };
});