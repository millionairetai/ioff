(function (angular) {
    'user strict';

    angular.module('centeroffice').controller('centerofficeCtrl', function ($rootScope) {
        $rootScope.$lang = {
            title_error_dialog : 'Thông báo lỗi',
            title_confirm_dialog : 'Xác nhận thông tin',
            ok : 'Chấp nhận',
            cancel : 'Hủy',
            add_project : 'thêm dự án',
            save : 'Lưu',
            //project
            project_title : "Tiêu đề",
            project_description : "Mô tả",
            success_add_project : 'bạn đã tạo dự án thành công',
            please_enter_username: 'Xin nhập vào tài khoản',
            please_enter_password: 'Xin nhập vào password',
            remember: 'Ghi nhớ',
            sign_in: 'Đăng nhập',
            forgot_password: 'Quên mật khẩu',
            username: 'Tài khoản',
            password: 'Mật khẩu',
            you_dont_have_permission_to_access_this_page: 'Bạn không có quyền truy cập trang này',
            page_not_found:'Không tìm thấy trang này'
        };
    });
})(window.angular);
