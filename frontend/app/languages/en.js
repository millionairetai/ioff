(function (angular) {
    'user strict';

    angular.module('centeroffice').controller('ce_controller', function ($scope, userService, $stateParams) {
        $scope.$lang = {
            please_enter_username: 'Please enter username',
            please_enter_password: 'Please enter password',
            remember: 'Remember',
            sign_in: 'Sign in',
            forgot_password: 'Forgot password',
            username: 'Username',
            password: 'Password'
        };
    });
})(window.angular);
