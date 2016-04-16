(function (angular) {
    'user strict';

    angular.module('centeroffice').controller('centerofficeCtrl', function ($rootScope) {
        $rootScope.$lang = {
            title_error_dialog : 'Thông báo lỗi',
            title_confirm_dialog : 'Xác nhận thông tin',
            ok : 'Chấp nhận',
            cancel : 'Hủy',
            add_project : 'Thêm dự án',
            save : 'Lưu',
            employee_empty : 'Không nhân viên nào được tìm thấy',
            button_back : 'Quay lại',
            button_next : 'Tiếp',
            button_close : 'Đóng',
            max_size : 'Tổng dung lượng file upload vượt quá 10MB',
            max_length:'Chỉ cho phép tổng số lượng tập tin upload tối đa là 20',
            no_data: 'Không có dữ liệu',
            //project
            project_list_view_more : 'Xem thêm',
            project_add : 'Tạo dự án',
            project_empty : 'Chưa có dự án nào được tạo',
            project_manage : 'Quản lý dự án',
            project_list : 'Danh sách dự án',
            project_infomation : 'Thông tin dự án',
            project_choose_member: 'Chọn thành viên',
            project_final: 'Hoàn thành',
            project_name : "Tên dự án",
            project_time : "Thời gian",
            project_start_date : 'Bắt đầu',
            project_end_date : 'Kết thúc',
            project_estimate_time : 'Thời gian ước lượng',
            project_status : 'Tình trạng',
            project_priority : 'Độ ưu tiên',
            project_completed_percent : 'Hoàn thành',
            project_share : 'Chia sẻ',
            project_description : "Mô tả",
            project_file : 'Tập tin',
            project_view_more : 'Thông tin mở rộng',
            project_view_short : 'Thu nhỏ',
            project_files: 'Tập tin đình kèm',
            project_hour : 'giờ',
            project_real : 'Lý thuyết',
            project_theory: 'Thực tế',
            project_manager:'Quản lý dự án',
            project_department : 'Phòng ban',
            project_choose_all: 'Tất cả',
            project_members: 'Thành viên',
            
            project_estimate_error : 'Thời gian ước lượng phải là con số',
            project_estimate_error_0 : 'Thời gian ước lượng phải lớn hơn -1',
            project_name_error_empty : 'Tên dự án không thể bỏ trống',
            project_description_error_empty : 'Mô tả dự án không thể bỏ trống',
            project_start_date_error_empty : 'Ngày bắt đầu phải có định dạng dd-mm-yyyy',
            project_end_date_error_empty : 'Ngày kết thúc phải có định dạng dd-mm-yyyy',
            project_start_date_error_past : 'Ngày bắt đầu phải lớn hơn hiện tại',
            project_end_date_error_past : 'Ngày kết thúc phải lớn hơn hiện tại',
            project_time_error: 'Ngày kết thúc phải lớn hơn ngày bắt đầu',
            project_manager_error_empty: 'Người quản lý không thể bỏ trống',
            project_members_error_empty: 'Dự án phải có người phụ trách',
            project_created_success:'Dự án đã được tạo thành công.',
            project_notify_success:'Dự án đã được tạo thành công.',
            //end project
            
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
