appRoot.factory('requestmentCategoryService', ['apiService', '$rootScope', 'alertify', 'validateService',
    function (apiService, $rootScope, alertify, validateService) {
        return {
            validate: function (requestmentCategory) {
                var message = "";
                if (!validateService.required(requestmentCategory.name)) {
                    message += $rootScope.$lang.error_name_empty;
                }

                if (message.length > 0) {
                    alertify.error(message);
                    return false;
                }

                return true;
            },
            allDepartment: function (data, success, error) {
                return apiService.get('requestment-category/all', data, success, error);
            },
            gets: function (data, success, error) {
                return apiService.get('requestment-category/index', data, success, error);
            },
            delete: function (data, success, error) {
                return apiService.post('requestment-category/delete', data, success, error);
            }
        };
    }]);
