appRoot.factory('projectService', ['apiService', function (apiService) {

        return {
            listProject : function (data,success,error){
                apiService.get('project/index',data,success,error);
            },
            addProject : function (data,success,error){
                apiService.post('project/add',data,success,error);
            }
        };
    }]);
