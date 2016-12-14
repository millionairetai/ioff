appRoot.factory('departmentService', ['apiService', '$rootScope', 'alertify', 'validateService', function (apiService, $rootScope, alertify, validateService) {
        return {
            validate: function (department) {
                var message = "";
                if (!validateService.required(department.name)) {
                    message += $rootScope.$lang.error_name_empty;
                }
                
                if (message.length > 0) {
                    alertify.error(message);
                    return false;
                }
                
                return true;
            },
            allDepartment: function (data, success, error) {
                return apiService.get('department/all', data, success, error);
            },
            gets: function (data, success, error) {
                return apiService.get('department/index', data, success, error);
            },
            delete: function (data, success, error) {
                return apiService.post('department/delete', data, success, error);
            },
        };
    }]);
