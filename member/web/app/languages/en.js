(function (angular) {
    'user strict';

    angular.module('iofficez').controller('iofficezCtrl', function ($rootScope) {
        $rootScope.$lang = {
            //-----------------------------------------Error languages here-----------------------------------
            error_name_empty: 'Tên không được để trống', 
            i_can_not_be_blank: '%i% can not be blank',
            todatetime_must_be_greater_fromdatetime: 'To datetime must be greater than from datetime',
            //-----------------------------------------End of error languages.--------------------------------            
            //-----------------------------------------Common languages here----------------------------------
            data_not_display : 'not found',
            post_add_success : 'Post add successfully',
            title_error_dialog : 'Error',
            title_confirm_dialog : 'Confirm',
            ok : 'Ok',
            at : 'at',
            more : 'View more',
            less : 'View less',
            add : 'Add',
            cancel : 'Cancel',
            add_project : 'Add project',
            edit_project : 'Edit project',
            delete_project : 'Delete project',
            edit_project_post : 'Edit project Post',
            save : 'Save',
            update: 'Update',
            remove: 'Delete',
            post : 'Post',
            employee_empty : "Employee does't match",
            button_back : 'Back',
            button_next : 'Next',
            button_update : 'Update',
            button_close : 'Close',
            max_size : 'Total file size upload is excess 10MB',
            max_length:'Only allow maximum number of file upload is 20',
            view_more_upper_case: 'VIEW MORE',
            //Lang for expand and remove contaner in each page.
            expand: 'Expand',
            remove: 'Remove',
            no_authoirty_function: 'You do not have authority to access this functionality',
            name_less_than_255_character: 'Name must less than 255 characters',
            address: 'Address',
            change: 'Change',
            
            //date picker
            datepicker_close : "Close",
            datepicker_clear : "Clear",
            datepicker_today : "Today",
            //System
            please_enter_username: 'Please enter username',
            please_enter_password: 'Please enter password',
            remember: 'Remember',
            sign_in: 'Sign in',
            forgot_password: 'Forgot password',
            username: 'Username',
            password: 'Password',
            you_dont_have_permission_to_access_this_page: 'You don\'t have permission to access this page',
            page_not_found:'Page not found',
            no_data: 'No data',
            warning: 'Warning',
            confirm_delete_file:'Are you sure delete?',
            remove_file_success:'Delete File success.',
            remove_project_post_success:'Delete Project Post success.',
            remove_event_post_success:'Delete Event Post success.',
            confirm_success: 'Confirm successfully',
            update_attend_error:'Attend error.',
            remove_file_error:'Delete File Error.',
            last_modify: 'Last modified',
            modify_by: 'Modify by',
            search: 'Search',
            functionality_group: 'Functionality group',
            functionalities: 'Functionalities',
            
            /////Re
            time : "Time",
            status : 'Status',
            priority : 'Priority',
            completed_percent : 'Completed Percent',
            share : 'Share',
            description : "Description",
            file : 'File',
            view_more : 'View more',
            view_less : 'View less',
            hour : 'Hour(s)',
            department : 'Department',
            choose_all: 'All',
            members: 'Members',
            name : "Name",
            redmind : "Redmind me",
            see_all: "See all",
            update_post_success:'Update post successfully',
            update_success: 'Update successfully',
            add_success: 'Add successfully',
            all: 'All',
            edit: 'Edit', 
            message: 'Message',
            activity: 'Activity',
            delete_success: 'Delete successfully',
            have_at_least_one_employee_belong_this_department_please_remove_employee_with_this_department_first:'Have at least one employee belong to this department. Please remove employee with this department first',
            detail: 'Detail',
            package: 'Package',
            storage: 'Storage',
            user: 'User',
            hide: 'Hide',
            show: 'Show',
            annoucement: 'Annoucement',
            requestment: 'Requestment',
            name_must_less_than_255_characters: 'Name must be less than 255 characters',          
            start: 'Start', 
            end: 'End',
            content: 'Content',
            end_date:'End date',
            completed: 'Completed',
            in_progress: 'In progress',
            public: 'Public',
            open: 'Open',
            phone: 'Điện thoại',            
            //-----------------------------------------End of common language.----------------------------------
            
            //project
            project: 'Project',
            project_list_view_more : 'View more',//
            project_add : 'Create project',
            project_empty : 'There is not project',
            project_manage : 'Manage project',
            project_list : 'List project',
            project_infomation : 'Project information',
            project_choose_member: 'Choose Members',
            project_final: 'Final',
            project_name : "Project Name",
            project_time : "Time",
            project_start_date : 'Start date',
            project_end_date : 'End date',
            project_estimate_time : 'Estimate Time',
            project_status : 'Status',
            project_priority : 'Priority',
            project_completed_percent : 'Completed Percent',
            project_share : 'Share',
            project_description : "Description",
            project_file : 'Files',
            project_view_more : 'View more',
            project_view_short : 'View less',
            project_files: 'Files',
            project_hour : 'Hour(s)',
            project_real : 'Real',
            project_theory: 'Theory',
            project_manager:'Project Manger',
            project_department : 'Department',
            project_choose_all: 'All',
            project_members: 'Members',
            project_parent: 'Project parent',
            project_progress: 'Project progress',
            work_time: 'Work time',
            file_name :'Name',
            day_ago : 'day ago',
            time_update :'Time Add',
            
            project_estimate_error : 'Estimate time is must numberic',
            project_estimate_error_0 : 'Estimate time is greater than -1',
            project_name_error_empty : 'Project name is not empty',
            project_description_error_empty : 'Description is not empty',
            project_start_date_error_empty : 'Start date is must format dd-mm-yyyy',
            project_end_date_error_empty : 'End date is must format dd-mm-yyyy',
            project_start_date_error_past : 'Start date is not in past',
            project_end_date_error_past : 'End date is not in past',
            project_time_error: 'End date is greater than Start date',
            project_manager_error_empty: 'Manager is not empty',
            project_members_error_empty: 'Department and Employee is not empty',
            project_created_success:'Create project is successful',
            project_notify_success:'Project has created successfully.',
            project_update_success:'Project has update successfully.',
            project_post_update_success:'Project Post has update successfully.',
            success_add_project : 'You add project successfully',
            //end project
            
            //authority    
            authority_manage: 'Authority management',
            authority_list: 'Authority list',
            authority_name: 'Name',
            authority_add: 'Add authority',
            authority_edit: 'Edit authority',
            please_enter_authority_name: 'Authority name is required',
            please_enter_this_field: 'Please enter this field',
            authority_name_max_length: 'Authority name must be smaller than 255 charactors',
            please_select_action: 'Please select at least one functionality',
            is_delete: 'Do you want to delete this item?',
            authority_is_used: 'This authority can not be deleted because in use',
            authority_added_success:'Authority has been added successfully',
            authority_edited_success:'Authority has been updated successfully',
            authority_deleted_success: 'Deleted authority successfully',
            authority: 'Authority',
            
            //calendar
            calendar_title : "Calendar",
            calendar_update_event : "Update event",
            calendar_add_event : "Add event",
            calendar_event_name : "Name",
            calendar_event_all_date : "All day",
            calendar_calendar_id : "Calendar",
            calendar_infomation : 'Calendar information',
            create_by : "create by",
            calendar_event_address : "Address",
            calendar_event_share : "Public",
            calendar_event_description : "Description",
            calendar_event_color : "Event color",
            calendar_event_redmind : "Redmind me",
            calendar_view_more : 'View more',
            calendar_view_short : 'View less',
            calendar_event_redmine_0 : 'No redmind',
            calendar_event_redmine_30 : '30 minutes',
            calendar_event_redmine_60 : '1 hour',
            calendar_event_redmine_120 : '2 hours',
            calendar_event_redmine_240 : '4 hours',
            calendar_event_redmine_1440 : '1 day',
            calendar_event_redmine_2880 : '2 days',
            calendar_event_name_error_empty : 'Name is required',
            calendar_event_start_date_error_empty : 'Start date is must format DD-MM-YYYY HH:mm',
            calendar_event_end_date_error_empty : 'End date is must format DD-MM-YYYY  HH:mm',
            calendar_event_time_error : "Enddate is must greater than startdate",
            calendar_event_calendar_id_error_empty : "Calendar is required",
            calendar_notify_event_created_success : "Event has created successfully",
            calendar_notify_event_edit_success : "Event has edit successfully",
            calendar_event_check_redmind : "Startdate time with current time must be greater than remind time",
                        
            //Event
            event: 'Event',
            event_description_error_empty : 'Event description is not empty',
            event_post_add_success : 'Event post add successfully',
            attend : 'Attend',
            maybe : 'Maybe',
            no_attent : 'Not Attent',
            no_confirm : 'No confirm',
            recent_post : 'Recent post',
            show_attend : "Information of event's participation",
            update_event_post: "Update event post",
            all_day : 'All day',
            
            //task
            task: 'Task',
            task_list_view_more : 'View More',
            task_add : 'Add task',
            task_empty : 'There is not task',
            task_manage : 'Managing task',
            task_list : 'List task',
            task_infomation : 'Task information',
            task_choose_member: 'Choose Members',
            task_final: 'Final',
            task_name : "Project Name",
            task_time : "Time",
            task_start_date : 'Start date',
            task_end_date : 'End date',
            task_estimate_time : 'Estimate Time',
            task_status : 'Status',
            task_priority : 'Priority',
            task_completed_percent : 'Completed Percent',
            task_share : 'Share',
            task_description : "Description",
            task_file : 'Files',
            task_view_more : 'View More',
            task_view_short : 'View Short',
            task_files: 'Files',
            task_hour : 'Hour(s)',
            task_real : 'Real',
            task_theory: 'Theory',
            task_manager:'Project Manger',
            task_department : 'Department',
            task_choose_all: 'All',
            task_employee_assigners: 'Assignees',
            task_employee_followers: 'Followers',
            task_members: 'Members',
            parent_task:'Parent task',
            task_check_valid_redmind: 'Startdatetime with current time must be greater than remind time 30 minutes',
            
            task_estimate_error : 'Estimate time is must numberic',
            task_estimate_error_0 : 'Estimate time is greater than -1',
            task_name_error_empty : 'Project name is not empty',
            task_duedatetime_error_empty: 'Duedatetime is empty',
            task_project_name_error_empty : 'Project is required',
            task_description_error_empty : 'Description is not empty',
            task_start_date_error_empty : 'Start date is must format dd-mm-yyyy',
            task_end_date_error_empty : 'End date is must format dd-mm-yyyy',
            task_start_date_error_past : 'Start date is not in past',
            task_end_date_error_past : 'End date is not in past',
            task_time_error: 'End date is greater than Start date',
            task_manager_error_empty: 'Manager is not empty',
            task_members_error_empty: 'Department and Employee is not empty',
            task_created_success:'Create task is successful',
            task_notify_success:'Project has created successfully.',
            task_created_success: 'Task has created successfully',
            task_group:'Task group',
            task_group_type:'task group type:',
            parent_task:'Parent task',
            task_project_empty:'Please choose project first',
            from:'from',
            to:'to',            
            task_my_task: 'My task',
            task_my_followed_task: 'My followed task',
            task_all_task: 'All task',
            task_employee_assigners: 'Employee assigners',
            task_employee_followers: 'Employee followers',
            task_post_add_success : 'Add task post success.',
            //end task        
            //notify
            notfication_manage: 'Notfication manage',
            notfication_list: 'Notfication list',   
            //search
            search: 'Search',
            search_result: 'Search result',
            search_result_for: 'Search result for',
            my_task : 'My task',
            my_follow_task : 'My following task',

          //task
            task_created : 'Task created',
            parent_child : 'Parent child',
            task_assigner : 'Task assigner',
            edit_task : 'Edit task',
            delete_task : 'Delete task',
            update_post_success : 'Update post success',
            remove_task_post_success : 'Delete post success',
            task_group : 'Task group',
            no_authoirty_item: 'You do not have authority to access this item',
            
          //function add calendar
            button_add : 'Add',
            add_calendar_title : 'Add calendar',
            update_calendar_title : 'Update calendar',
            calendar_name_error_empty : 'Calendar name is not empty',
            calendar_description_error_empty : 'Description is not empty',
            error_calendar_unique : 'Calendar name is exist',
            add_calendar_success : 'Add calendar success',
            update_calendar_success : 'Update calendar success',
            remove_calendar_success : 'Remove calendar success',
            //Employee
            employee: 'Employee',
            invited: 'Invited',
            inactive: 'Inactive',
            invite: 'Invite',
            emails: 'Emails', 
            separate_multiple_emails: 'Separate multiple e-mails with a comma or space',
            message_invitation: 'Please join me in our new intranet. This is a place where everyone can collaborate on projects, coordinate tasks and schedules, and build our knowledge base.',
            invite_successfully: 'Invite new employees successfully',
            update_employee: 'Update employee',
            add_employee: 'Add employee',
            firstname_cannot_blank: 'First name can not blank',
            lastname_cannot_blank: 'Last name can not blank',
            firstname: 'First name',
            lastname: 'Last name',
            mobile_phone: 'Mobile phone',
            work_phone: 'Work phone',
            birthdate: 'Birth date',
            is_invalid: 'is invalid',
            emails_required: 'Emails can not blank',
            message_required: 'Message can not blank',
            employee_manage: 'Employee manage',
            employee_list: 'Employee list',
            make_password_auto: 'Make password auto',
            password_greater_6: 'Password must be greater than 6 characters',
            about_me: 'About Me',
            address: 'Address',
            change_password: 'Change password',
            current_password: 'Current password',
            new_password: 'New password',
            renew_password: 'Re-New password',
            please_choose_png_gif_jpg_file: 'Please choose png, gif, jpg file', 
            change_profile_avatar: 'Change avatar profile',
            //company
            company: 'Company',
            //Report
            report: 'Report',
            //Invoice
            invoice: 'Invoice',
            //Header.
            you_have_i_task: 'You have %i task(s)',
            //Department
            department_manage: 'Department manage',
            department_list: 'Department list',
            //company
            used_storage: 'Use storage',
            register_account: 'Register account',
            company_information: 'Company information',
            start_datetime: 'Started date',
            expire_time: 'Expired date',
            //report
            total_task: 'Total task',
            total_hour: 'Total hour',          
            about: 'about',
            input_comment:' input comment',
            worked_hour_must_be_number: 'Worked hour must be number',
            total_worked_hour: 'Total of worked hour',
            number_worked_hour:'Number of work hour',
            you_have_i_notfication: 'You have %i notification(s)',
            //activity
            a_new_employee_has_been_added: 'A new employee has been added',
            press_enter_to_post_comment: 'Press enter to post comment',
            like_success: 'Like successfully',
            posted_in_project : 'Posted in project',
            posted_in_task: 'Posted in task',
            comments: 'comment(s)',
            like: 'Like',
            likes: 'like(s)',
            display_option: 'Display option',
            what_do_you_think: 'What do you think',
            title: 'Title',
            enddate_must_greater_one_day_than_now: 'Enddate must be greater one day than now',
            date_cant_blank_and_format_ddmmYY: 'Date can not blank and must be format of dd-mm-YY',
            importance: 'Importance',
            requestment_category: 'Requestment category',
            from_datetime: 'From datetime',
            to_datetime: 'to datetime',
            accept: 'Accept',
            refuse: 'Refuse',
            type: 'Type',
            send_to: 'Send to',
            review_employee: 'Review employee',
            requestment_category_manage: 'Requestment category manage',
            requestment_category_list: 'Requestment category list',
            my_request: 'My request',
            sent: 'Sent',
            received: 'Received',
            more_option: 'More option',
            upcoming_event: 'Upcoming Event',
            //Company
            package_detail: 'Plan type detail',
            package: 'Package',
            duedate_package: 'Duedate package',
            current_plan_type:'Current plan type',
            change_edit_your_package: 'Change/ edit your package',
            maximum_users: 'Maximum users',
            maximum_storage: 'Maximum storage',
            this_message_contains: 'This package contains',
            phrase_info_standard_plan_type:'The standard plan contains minimum 10 users and 2 GB. You can scale it up anytime in 5 users or 5 GB steps. If the maximum user count of 150 is reached orand you need more user, please select premium plan type. In some cases it could be more favorable then the Standard Plan, depends on your needs.',
            change_plan_type: 'Change plan type',
            //Invoice.
            payment: 'Payment',            
            method_payment: 'Method payment',
            company_name: 'Company name',
            tax_code:'Tax',
            register_plan: 'REGISTERED PLAN',
            redundant_money_old_package: 'REDUNDANT OLD PACKAGE MONEY',
            total_money_new_package: 'NEW PLAN MONEY',
            total_payment: 'FINAL MONEY TOTAL',
            ignore_free_plan_section: 'If register Free plan type, you can skip this information',
            register_account_successfully: 'Register account successfully',
            info_bank_transfer : "Please transfer money to account number 1039390902 IPL Company Limited ACB Bank Hồ Chí Minh branch - Account number: 1039390902. Content of transfer: [person's name tranfer][Company name] [phone no] pay for iOfficez.*Notice: After transfer, please contact us via email: support@iofficez.com hoặc hotline: 1900283 to us support the best for you.",
            month: 'Month',
            info_standard_plan_type: 'The standard plan contains minimum 10 users and 2 GB. You can scale it up anytime in 5 users or 5 GB steps. If the maximum user count of 150 is reached orand you need more user, please select premium plan type. In some cases it could be more favorable then the Standard Plan, depends on your needs.',
            info_premium_plan_type: 'The premium plan contains unlimited users and 2 GB. You can scale it up anytime 5 GB steps.',
            company_manage: 'Company manage',
            your_package: 'Your package',
            unlimited: 'Unlimited',
            choose_maximum_user: 'Choose maximum user',
            choose_maximum_storage: 'Choose maximum storage',
            not_completed: 'not completed',
            //ordeer
            account: 'Account',
            no: 'No',
            product: 'Product',
            subtotal: 'Subtotal',
            total: 'Total',
            date_created_order: 'Date created order',
            payment_method: 'Payment method',
            order_no: 'Order no',
            order: 'Order'
        };
    });
})(window.angular);
