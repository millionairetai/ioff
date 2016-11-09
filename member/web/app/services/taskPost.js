appRoot.factory('TaskPostService', ['apiService', '$rootScope', 'alertify', function (apiService, $rootScope, alertify) {
    return {
        addTaskPost: function (data, success, error) {
            apiService.upload('task-post/add-task-post', data, success, error);
        },
        getTaskPosts: function (data, success, error) {
            apiService.get('task-post/get-task-post', data, success, error);
        },
        getLastTaskPost: function (data, success, error) {
            apiService.get('task-post/get-last-task-post', data, success, error);
        },
        removeTaskPost : function (data,success,error){
            apiService.get('task-post/remove-task-post', data, success, error);
        },
        updateTaskPost : function (data,success,error){
            apiService.post('task-post/update-task-post', data, success, error);
        },
        validateTaskPost: function (object) {
            var message = "";
            if (object.description.length == 0) {
                message += $rootScope.$lang.task_description_error_empty + "<br/>";
            }
            if (message.length > 0) {
                alertify.error(message);
                return false;
            }
            return true;
        }
    };
}]);