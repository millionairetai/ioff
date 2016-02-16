(function (angular) {
    'user strict';

    angular.module('centeroffice').controller('ce_controller', function ($rootScope) {
        $rootScope.$lang = {
            please_enter_username: 'Please enter username',
            please_enter_password: 'Please enter password',
            remember: 'Remember',
            sign_in: 'Sign in',
            forgot_password: 'Forgot password',
            username: 'Username',
            password: 'Password',
            you_dont_have_permission_to_access_this_page: 'You don\'t have permission to access this page'
        };
    });
})(window.angular);
