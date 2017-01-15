(function (angular) {
    'user strict';

    angular.module('iofficez').controller('iofficezCtrl', function ($rootScope) {
        $rootScope.$lang = {
            //-----------------------------------------Error languages here-----------------------------------
            error_name_empty: 'Tên không được để trống', 
            //-----------------------------------------End of error languages.--------------------------------
            //-----------------------------------------Common languages here----------------------------------
            data_not_display : 'Không tìm thấy',
            post_add_success : 'Bài đăng thêm thành công',
            title_error_dialog : 'Thông báo lỗi',
            title_confirm_dialog : 'Xác nhận',
            ok : 'Chấp nhận',
            at : 'đến',
            more : 'Xem thêm',
            less : 'Đóng',
            add : 'Thêm',
            cancel : 'Hủy',
            add_project : 'Thêm dự án',
            edit_project : 'Cập Nhật',
            delete_project : 'Xóa dự án',
            edit_project_post : 'Cập nhật bài đăng',
            save : 'Lưu',
            update: 'Cập nhật',
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
            no_authoirty_function: 'Bạn không có quyền để truy cập chứng năng này',
            name_less_than_255_character: 'Tên phải nhỏ hơn 255 kí tự', 
            address: 'Địa chỉ',
            change: 'Thay đổi',
            
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
            remove_event_post_success:'Xóa sự kiện thành công.',
            confirm_success: 'Xác nhận thành công',
            update_attend_error:'Attend Error.',
            last_modify: 'Ngày sửa',
            modify_by: 'Người tạo',
            search: 'Tìm kiếm',
            functionality_group: 'Nhóm chức năng',
            functionalities: 'Các chức năng',
            
            time : "Thời gian",
            status : 'Tình trạng',
            priority : 'Độ ưu tiên',
            completed_percent : 'Phần trăm hoàn thành',
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
            see_all: "Xem tất cả",
            update_post_success:'Bài đăng cập nhật thành công',
            update_success: 'Cập nhật thành công',
            add_success: 'Thêm thành công',
            all: 'Tất cả',
            edit: 'Cập nhật', 
            message: 'Tin nhắn',
            activity: 'Hoạt động',
            delete_success: 'Xóa thành công',
            have_at_least_one_employee_belong_this_department_please_remove_employee_with_this_department_first:'Có ít nhất một nhân viên thuộc về phòng ban này. Xin hãy tháo bỏ phòng ban này với nhân viên đó trước',
            detail: 'Chi tiết',
            package: 'Gói',
            storage: 'Dung lượng lưu trữ',
            user: 'Người dùng',
            hide: 'Ẩn',
            show: 'Hiện',
            annoucement: 'Thông báo',
            requestment: 'Yêu cầu',
            name_must_less_than_255_characters: 'Tên phải nhỏ hơn 255 kí tự',            
            //-----------------------------------------End of common language.----------------------------------
            
            //project
            project: 'Dự án',
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
            day_ago : 'ngày',
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
            is_delete: 'Bạn có muốn xóa mục này không?',
            authority_is_used: 'Quyền không thể xóa vì đang được sử dụng',
            authority_added_success: 'Đã thêm quyền thành công',
            authority_edited_success:'Đã cập nhật quyền thành công',
            authority_deleted_success: 'Xóa quyền thành công',
            authority: 'Quyền',
            
            //calendar
            calendar_title : "Lịch",
            calendar_infomation : 'Thông tin sự kiện',
            calendar_add_event : "Thêm sự kiện",
            calendar_update_event : "Cập nhật sự kiện",
            calendar_event_name : "Tên sự kiện",
            calendar_event_all_date : "All day",
            create_by : "tạo bởi",
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
            calendar_notify_event_edit_success : "Sự kiện của bạn đã được cập nhật thành công",
            calendar_event_check_redmind : "Thời gian bắt đầu sự kiện so với thời gian hiện tại phải lớn hơn thời gian nhắc nhở",
            
            //Event
            event: 'Sự kiện',
            event_description_error_empty : 'Sự kiện mô tả không thể bỏ trống',
            event_post_add_success : 'Bài đăng thêm thành công',
            attend : 'Tham dự',
            maybe : 'Có thể',
            no_attent : 'Không tham dự',
            no_confirm : 'Chưa xác nhận',
            recent_post : 'Bài gần đây',
            show_attend : 'Thông tin tham dự sự kiện',
            update_event_post: "Cập nhật bài đăng",
            all_day : 'Sự kiện nguyên ngày',
            
            //task
            task: 'Công việc',
            task_list_view_more : 'Xem thêm',
            task_add : 'Thêm công việc',
            task_empty : 'Chưa có công việc nào được tạo',
            task_manage : 'Quản lý công việc',
            task_list : 'Danh sách công việc',
            task_infomation : 'Thông tin công việc',
            task_choose_emplyees: 'Chọn thành viên',
            task_final: 'Hoàn thành',
            task_name : "Tên công việc",
            task_project : "Dự án",
            task_project_choose:'Chọn project',
            task_time : "Thời gian",
            task_start_date : 'Bắt đầu',
            task_end_date : 'Hạn chót',
            task_estimate_time : 'Thời gian ước lượng',
            task_status : 'Tình trạng',
            task_priority : 'Độ ưu tiên',
            task_completed_percent : 'Hoàn thành',
            task_share : 'Chia sẻ',
            task_description : "Mô tả",
            task_file : 'Tập tin',
            task_view_more : 'Thông tin mở rộng',
            task_view_short : 'Thu nhỏ',
            task_files: 'Tập tin đình kèm',
            task_hour : 'giờ',
            task_real : 'Lý thuyết',
            task_theory: 'Thực tế',
            task_manager:'Quản lý công việc',
            task_department : 'Phòng ban',
            task_choose_all: 'Tất cả',
            task_employee_assigners: 'Người làm',
            task_employee_followers: 'Người theo dõi',
            task_check_valid_redmind: 'Thời gian hết hạn của công việc so với thời gian hiện tại phải lớn hơn thời gian nhắc nhở 30 phút', 
            
            task_estimate_error : 'Thời gian ước lượng phải là con số',
            task_estimate_error_0 : 'Thời gian ước lượng phải lớn hơn -1',
            task_name_error_empty : 'Tên công việc không thể bỏ trống',
             task_duedatetime_error_empty: 'Ngày hết hạn bị rỗng',
            task_project_name_error_empty : 'Bắt buộc chọn dự án cho công việc',
            task_project_name_error_empty : 'Công việc thuộc dự án nào, không thể bỏ trống',
            task_description_error_empty : 'Mô tả công việc không thể bỏ trống',
            task_start_date_error_empty : 'Ngày bắt đầu phải có định dạng dd-mm-yyyy',
            task_end_date_error_empty : 'Ngày kết thúc phải có định dạng dd-mm-yyyy',
            task_start_date_error_past : 'Ngày bắt đầu phải lớn hơn hiện tại',
            task_end_date_error_past : 'Ngày kết thúc phải lớn hơn hiện tại',
            task_time_error: 'Ngày kết thúc phải lớn hơn ngày bắt đầu',
            task_manager_error_empty: 'Người quản lý không thể bỏ trống',
            task_assigners_error_empty: 'Công việc chưa được giao cho ai',
            task_group_error_empty: 'Phải biết công việc thuộc loại nào',
            task_created_success:'Công việc đã được tạo thành công.',
            task_notify_success:'Công việc đã được tạo thành công.',
            task_group:'Loại công việc',
            task_group_type:'thuộc dạng:',
            task_remind:'Nhắc nhở',
            task_remind_datetime:'Ngày giờ báo',
            task_remind_before:'Báo trước',
            task_remind_repeat:'Lặp lại sau',
            minute:'phút',
            task_group_choose:'Chọn loại công việc',
            parent_task_choose:'Chọn Công việc cha',            
            parent_task:'Công việc cha',
            task_project_empty:'Vui lòng chọn dự án của công việc này trước',
            from:'từ',
            to:'đến',
            task_worked_hour:'thời gian đã làm',
            project:'Dự án',
            assigned_to:'giao cho',
            follow_to:'theo dõi',
            task_creator:'bởi',
            task_search:'tìm công việc',
            time_create:'thời gian tạo',
            task_created_success: 'Công việc được tạo thành công',
            task_my_task: 'Công việc của tôi',
            task_my_followed_task: 'Công việc tôi theo dõi',
            task_all_task: 'Tất cả công việc',
            task_post_add_success : 'Thêm bài đăng thành công.',
            //end task
            //notify
            notfication_manage: 'Quản lý thông báo',
            notfication_list: 'Danh sách thông báo',   
            //search
            search: 'Tìm kiếm',
            search_result: 'Kết quả tìm kiếm',
            search_result_for: 'Kết quả tìm kiếm cho',
            
          //task
            task_created : 'Người tạo',
            parent_child : '  Công việc con',
            task_assigner : 'Người giao việc',
            edit_task : 'Cập Nhật',
            delete_task : 'Xóa công việc',
            update_post_success : 'Cập Nhật bài đăng thêm thành công',
            remove_task_post_success : 'Xóa bài đăng thêm thành công',
            no_authoirty_item: 'Bạn không có quyền để truy cập vào mục vừa chọn',
            
            //function add calendar
            button_add : 'Thêm',
            add_calendar_title : 'Thêm lịch',
            update_calendar_title : 'Cập nhật lịch',
            calendar_name_error_empty : 'Tên lịch không thể bỏ trống',
            calendar_description_error_empty : 'Mô tả lịch không thể bỏ trống',
            add_calendar_success : 'Thêm lịch thành công',
            update_calendar_success : 'Cập nhật thành công',
            remove_calendar_success : 'Xóa lịch thành công',
            my_task : 'Việc của tôi',
            my_follow_task : 'Việc tôi theo dõi',
            //Employee
            employee: 'Nhân viên',
            invited: 'Được mời',
            inactive: 'Bị vô hiệu hóa',
            invite: 'Mời',
            emails: 'Danh sách email', 
            separate_multiple_emails: 'Tách các email với nhau bởi dấu phẩy hoặc khoảng trắng',
            message_invitation: 'Xin hãy gia nhập mạng nội bộ của chúng ta. Đây là nơi mọi người có thể cộng tác dựa trên các dự án, công việc, lập kế hoạch và xây dựng học hỏi kiến thức với nhau.',
            invite_successfully: 'Mời nhân viên mới thành công',
            update_employee: 'Cập nhật nhân viên',
            add_employee: 'Thêm nhân viên',
            firstname_cannot_blank: 'Họ không thể để trống',
            lastname_cannot_blank: 'Tên không thể để trống',
            firstname: 'Họ',
            lastname: 'Tên',
            mobile_phone: 'Điện thoại di động',
            work_phone: 'Điện thoại công sở',
            birthdate: 'Ngày sinh',
            is_invalid: 'không hợp lệ',
            emails_required: 'Danh sách email không thể bỏ trống',
            message_required: 'Tin nhắn không thể bỏ trống',
            employee_manage: 'Quản lý nhân viên',
            employee_list: 'Danh sách nhân viên',
            make_password_auto: 'Tự động tạo mật khẩu',
            password_greater_6: 'Mật khẩu phải lớn hơn 6 kí tự',
            about_me: 'Về tôi',
            change_password: 'Thay đổi mật khẩu',
            current_password: 'Mật khẩu hiện tại',
            new_password: 'Mật khẩu mới',
            renew_password: 'Nhập lại mật khẩu mới',
            please_choose_png_gif_jpg_file: 'Xin chọn file png, gif, jpg', 
            change_profile_avatar: 'Thay đổi ảnh đại diện',
            //company
            company: 'Công ty',
            //Report
            report: 'Báo cáo',
            //Invoice
            invoice: 'Hóa đơn',
            //Header.
            you_have_i_task: 'Bạn có %i công việc',
            //Department
            department_manage: 'Quản lý phòng ban',
            department_list: 'Danh sách phòng ban',
            //company
            used_storage: 'Dung lượng đã dùng',
            register_account: 'Tài khoản đăng ký',
            company_information: 'Thông tin công ty',
            start_datetime: 'Ngày bắt đầu',
            expire_time: 'Ngày kết thúc',
            //report
            total_task: 'Tổng số công việc',
            total_hour: 'Tổng số giờ',
            number_worked_hour: 'Số giờ làm',
            about: 'khoảng',
            input_comment:' nhập bình luận',
            worked_hour_must_be_number: 'Số giờ làm phải là số',
            total_worked_hour: 'Tổng giờ làm',
            you_have_i_notfication: 'Bạn có %i thông báo',
            //activity
            a_new_employee_has_been_added: 'Một nhân viên mới vừa mới được thêm',
            press_enter_to_post_comment: 'Nhấn enter để đăng bình luận'
        };
    });
})(window.angular);
