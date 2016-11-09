appRoot.factory('statusService', ['apiService', function (apiService) {
    return {
    	getProjectStatus : function (data,success,error){
            apiService.get('status/get-status?type=project', data, success, error);
        }
    };
}]);
