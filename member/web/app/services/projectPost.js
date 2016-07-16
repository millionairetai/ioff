appRoot.factory('projectPostService', ['apiService', '$rootScope', 'alertify', function (apiService, $rootScope, alertify) {
    return {
    	addProjectPost : function (data,success,error){
        	apiService.upload('project-post/add-project-post',data,success,error);
        },
        getProjectPosts : function (data, success, error){
            apiService.post('project-post/get-project-post',data, success, error);
        },
        validateProjectPost : function(object){
        	var message = "";
        	if(object.description.length == 0){
                message += $rootScope.$lang.project_description_error_empty + "<br/>";
            }
        	if(message.length > 0){
        		alertify.error(message);
        		return false;
        	}
        	return true;
        	
        }
    };
}]);
