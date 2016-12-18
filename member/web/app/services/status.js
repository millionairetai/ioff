appRoot.factory('statusService', ['apiService', function (apiService) {
    return {
    	getProjectStatus : function (data,success,error){
            apiService.get('status/get-status?type=project', data, success, error);
        },
        getTaskStatus : function (data,success,error){
            apiService.get('status/get-status?type=task', data, success, error);
        },
        getEmployeesStatus : function (employeeStatus, success, error){
            apiService.get('status/get-employee-statuses', {currentStatus: employeeStatus},success, error);
        }
    };
}]);
