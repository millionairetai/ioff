appRoot.factory('priorityService', ['apiService', function (apiService) {
    return {
    	getTaskPriority : function (data,success,error){
            apiService.get('priority/get-priority?type=task', data, success, error);
        },
        getProjectPriority : function (data,success,error){
            apiService.get('priority/get-priority?type=project', data, success, error);
        }
    };
}]);
