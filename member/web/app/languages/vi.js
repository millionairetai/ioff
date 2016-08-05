(function (angular) {
    'user strict';

    angular.module('centeroffice').controller('centerofficeCtrl', function ($rootScope) {
        $rootScope.$lang = {
            //-----------------------------------------Common languages here----------------------------------
            title_error_dialog : 'Thông báo lỗi',
            title_confirm_dialog : 'Xác nhận',
            ok : 'Chấp nhận',
            more : 'Xem thêm',
            less : 'Đóng',
            cancel : 'Hủy',
            add_project : 'Thêm dự án',
            edit_project : 'Cập Nhật',
            delete_project : 'Xóa dự án',
            edit_project_post : 'Cập nhật bài đăng',
            save : 'Lưu',
            remove: 'Xóa',
            post : 'Đăng',
            employee_empty : 'Không nhân viên nào được tìm thấy',
            button_back : 'Quay lại',
            button_next : 'Tiếp',
            button_update : 'Cập nhật',
            button_close : 'Đóng',
            max_size : 'Tổng dung lượng file upload vượt quá 10MB',
            max_length:'Chỉ cho phép tổng số lượng tập tin upload tối đa là 20',
            view_more_upper_case: 'XEM THÊM',
            //Lang for expand and remove contaner in each page.
            expand: 'Đóng',
            remove: 'Xóa',
            
            //date picker
            datepicker_close : "Đóng",
            datepicker_clear : "Xóa",
            datepicker_today : "Hôm nay",
            //system
            please_enter_username: 'Xin nhập vào tài khoản',
            please_enter_password: 'Xin nhập vào password',
            remember: 'Ghi nhớ',
            sign_in: 'Đăng nhập',
            forgot_password: 'Quên mật khẩu',
            username: 'Tài khoản',
            password: 'Mật khẩu',
            you_dont_have_permission_to_access_this_page: 'Bạn không có quyền truy cập trang này',
            page_not_found:'Không tìm thấy trang này',
            no_data: 'Không có dữ liệu',
            warning: 'Cảnh báo',
            confirm_delete_file:'Bạn có chắc chắn xóa?.',
            remove_file_success:'File đã được xóa thành công.',
            remove_file_error:'File bạn cần xóa không thành công.',
            remove_project_post_success:'Xóa dự án bài thành công.',
            last_modify: 'Ngày sửa',
            modify_by: 'Người tạo',
            search: 'Tìm kiếm',
            functionality_group: 'Nhóm chức năng',
            functionalities: 'Các chức năng',
            
            time : "Thời gian",
            status : 'Tình trạng',
            priority : 'Độ ưu tiên',
            completed_percent : 'Hoàn thành',
            share : 'Chia sẻ',
            description : "Mô tả",
            file : 'Tập tin',
            view_more : 'Thông tin mở rộng',
            view_less : 'Thu nhỏ',
            hour : 'giờ',
            department : 'Phòng ban',
            choose_all: 'Tất cả',
            members: 'Thành viên',
            name : "Tên",
            redmind : "Nhắc nhở",
            //-----------------------------------------End of common language.----------------------------------
            
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
            project_parent: 'Dự án cha',
            project_progress: 'Tiến độ dự án',
            work_time: 'Thời gian làm việc',
            file_name :'Tên',
            time_update :'Ngày thêm vào',
            
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
            project_update_success:'Dự án đã được cập nhật thành công.',
            project_post_update_success:'Bài đăng dự án được cập nhật thành công.',
            success_add_project : 'Bạn đã tạo dự án thành công',
            //end project
            
            //authority
            authority_manage: 'Quản lý quyền',
            authority_list: 'Danh sách quyền',
            authority_name: 'Tên',
            authority_add: 'Thêm quyền',
            authority_edit: 'Sửa quyền',
            please_enter_this_field: 'Xin nhập mục này',
            please_enter_authority_name: 'Tên quyền không được bỏ trống',
            authority_name_max_length: 'Tên quyền phải nhỏ hơn 255 ký tự',
            please_select_action: 'Bạn phải chọn tối thiểu một chức năng',
            is_delete: 'Bạn có muốn xóa quyền này không?',
            authority_is_used: 'Quyền không thể xóa vì đang được sử dụng',
            authority_added_success: 'Đã thêm quyền thành công',
            authority_edited_success:'Đã cập nhật quyền thành công',
            authority_deleted_success: 'Xóa quyền thành công',
            
            //calendar
            calendar_title : "Lịch",
            calendar_add_event : "Thêm sự kiện",
            calendar_event_name : "Tên sự kiện",
            calendar_calendar_id : "Lịch",
            calendar_event_address : "Địa chỉ",
            calendar_event_share : "Công khai",
            calendar_event_description : "Mô tả",
            calendar_event_color : "Màu sắc của sự kiện",
            calendar_event_redmind : "Nhắc nhở tôi",
            calendar_view_more : 'Thông tin mở rộng',
            calendar_view_short : 'Thu nhỏ',
            calendar_event_redmine_0 : 'Không nhắc nhở',
            calendar_event_redmine_30 : '30 phút',
            calendar_event_redmine_60 : '1 giờ',
            calendar_event_redmine_120 : '2 giờ',
            calendar_event_redmine_240 : '4 giờ',
            calendar_event_redmine_1440 : '1 ngày',
            calendar_event_redmine_2880 : '2 ngày',
            calendar_event_name_error_empty : 'Tên sự kiện không được bỏ trống',
            calendar_event_start_date_error_empty : 'Ngày bắt đầu phải có định dạng DD-MM-YYYY  HH:mm',
            calendar_event_end_date_error_empty : 'Ngày kết thúc phải có định dạng DD-MM-YYYY  HH:mm',
            calendar_event_time_error : "Ngày kết thúc phải lớn hơn ngày bắt đầu",
            calendar_event_calendar_id_error_empty : "Lịch không được bỏ trống",
            calendar_notify_event_created_success : "Sự kiện của bạn đã được tạo thành công",
            calendar_event_check_redmind : "Thời gian bắt đầu sự kiện so với thời gian hiện tại phải lớn hơn thời gian nhắc nhở"
        };
    });
})(window.angular);
