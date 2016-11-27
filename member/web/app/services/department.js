appRoot.factory('departmentService', ['apiService', function (apiService) {
        return {
            allDepartment: function (data, success, error) {
                return apiService.get('department/all', data, success, error);
            }
        };
    }]);
