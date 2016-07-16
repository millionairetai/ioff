appRoot.factory('priorityService', ['apiService', function (apiService) {
    return {
    	getProjectPriority : function (data,success,error){
            apiService.get('priority/get-project-priority', data, success, error);
        }
    };
}]);
