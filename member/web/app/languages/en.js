(function (angular) {
    'user strict';

    angular.module('iofficez').controller('iofficezCtrl', function ($rootScope) {
        $rootScope.$lang = {
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
            name_must_less_than_255_characters: 'Name must be less than 255 characters',
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
            is_delete: 'Do you want to delete this authority?',
            authority_is_used: 'This authority can not be deleted because in use',
            authority_added_success:'Authority has been added successfully',
            authority_edited_success:'Authority has been updated successfully',
            authority_deleted_success: 'Deleted authority successfully',
            
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
            task_update_success:'Project has updated successfully.',
            task_created_success: 'Task has created successfully',
            task_group:'Task group',
            task_group_type:'task group type:',
            parent_task:'Parent task',
            task_project_empty:'Please choose project first',
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
            remove_calendar_success : 'Remove calendar success'
        };
    });
})(window.angular);
