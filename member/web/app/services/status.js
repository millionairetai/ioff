appRoot.factory('statusService', ['apiService', function (apiService) {
    return {
    	getProjectStatus : function (data,success,error){
            apiService.get('status/get-project-status', data, success, error);
        }
    };
}]);
