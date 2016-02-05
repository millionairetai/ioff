(function (angular) {
    'user strict';

    angular.module('centeroffice').controller('ce_controller', function ($scope, userService, $stateParams) {
        $scope.$lang = {
            please_enter_username: 'Xin nhập vào tài khoản',
            please_enter_password: 'Xin nhập vào password',
            remember: 'Ghi nhớ',
            sign_in: 'Đăng nhập',
            forgot_password: 'Quên mật khẩu',
            username: 'Tài khoản',
            password: 'Mật khẩu'
        };
    });
})(window.angular);
