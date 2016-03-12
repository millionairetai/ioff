(function (angular) {
    'user strict';

    angular.module('centeroffice').controller('centerofficeCtrl', function ($rootScope) {
        $rootScope.$lang = {
            title_error_dialog : 'Error',
            title_confirm_dialog : 'Confirm',
            ok : 'Ok',
            cancel : 'Cancel',
            add_project : 'add project',
            save : 'Save',
            //project
            project_title : "Title",
            project_description : "Description",
            success_add_project : 'You add project successfully',
            please_enter_username: 'Please enter username',
            please_enter_password: 'Please enter password',
            remember: 'Remember',
            sign_in: 'Sign in',
            forgot_password: 'Forgot password',
            username: 'Username',
            password: 'Password',
            you_dont_have_permission_to_access_this_page: 'You don\'t have permission to access this page',
            page_not_found:'Page not found'
        };
    });
})(window.angular);
