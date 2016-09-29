appRoot.factory('employeeService', ['apiService', function (apiService) {

        return {
            searchEmployee : function (data,success,error){
                return apiService.post('employee/search',data,success,error);
            },
            searchEmployeeByProjectIdAndKeyword : function (data,success,error){
                return apiService.post('employee/search-by-project-id-and-keyword',data,success,error);
            },
            searchEmployeeByKeyword : function (data,success,error){
                return apiService.post('employee/search-by-keyword',data,success,error);
            },
            getEmployeesByStatus: function (data, success, error){
                return apiService.get('employee/get-employees',data,success,error);
            }
        };
    }]);
