(function (angular) {
    'user strict';

    angular.module('centeroffice').controller('centerofficeCtrl', function ($rootScope) {
        $rootScope.$lang = {
            title_error_dialog : 'Error',
            title_confirm_dialog : 'Confirm',
            ok : 'Ok',
            cancel : 'Cancel',
            add_project : 'Add project',
            save : 'Save',
            remove: 'Delete',
            employee_empty : "Employee does't match",
            button_back : 'Back',
            button_next : 'Next',
            button_close : 'Close',
            max_size : 'Total file size upload is excess 10MB',
            max_length:'Only allow maximum number of file upload is 20',
            no_data: 'No data',
            //project
            project_list_view_more : 'View More',
            project_add : 'Create project',
            project_empty : 'There is not project',
            project_manage : 'Managing project',
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
            project_view_more : 'View More',
            project_view_short : 'View Short',
            project_files: 'Files',
            project_hour : 'Hour(s)',
            project_real : 'Real',
            project_theory: 'Theory',
            project_manager:'Project Manger',
            project_department : 'Department',
            project_choose_all: 'All',
            project_members: 'Members',
            
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
            //end project
            success_add_project : 'You add project successfully',
            please_enter_username: 'Please enter username',
            please_enter_password: 'Please enter password',
            remember: 'Remember',
            sign_in: 'Sign in',
            forgot_password: 'Forgot password',
            username: 'Username',
            password: 'Password',
            you_dont_have_permission_to_access_this_page: 'You don\'t have permission to access this page',
            page_not_found:'Page not found',
            
            authority_manage: 'Authority management',
            authority_list: 'Authority list',
            authority_name: 'Name',
            last_modify: 'Last modified',
            modify_by: 'Modify by',
            authority_add: 'Add authority',
            authority_edit: 'Edit authority',
            functionality_group: 'Functionality group',
            functionalities: 'Functionalities',
            please_enter_authority_name: 'Authority name is required',
            please_enter_this_field: 'Please enter this field',
            authority_name_max_length: 'Authority name must be smaller than 255 charactors',
            please_select_action: 'Please select at least one functionality',
            search: 'Search',
            is_delete: 'Do you want to delete this authority?',
            authority_is_used: 'This authority can not be deleted because in use',
            warning: 'Warning',
            no_data: 'No data',
            authority_added_success:'Authority has been added successfully',
            authority_edited_success:'Authority has been updated successfully',
            authority_deleted_success: 'Deleted authority successfully'
        };
    });
})(window.angular);
