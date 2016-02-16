(function (angular) {
    'user strict';

    angular.module('centeroffice').controller('ce_controller', function ($rootScope) {
        $rootScope.$lang = {
            please_enter_username: 'Xin nhập vào tài khoản',
            please_enter_password: 'Xin nhập vào password',
            remember: 'Ghi nhớ',
            sign_in: 'Đăng nhập',
            forgot_password: 'Quên mật khẩu',
            username: 'Tài khoản',
            password: 'Mật khẩu',
            you_dont_have_permission_to_access_this_page: 'Bạn không có quyền truy cập trang này'
        };
    });
})(window.angular);
