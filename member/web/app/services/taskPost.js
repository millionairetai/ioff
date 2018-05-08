appRoot.factory('TaskPostService', ['apiService', '$rootScope', 'alertify', 'validateService',
    function (apiService, $rootScope, alertify, validateService) {

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
            removeTaskPost: function (data, success, error) {
                apiService.get('task-post/remove-task-post', data, success, error);
            },
            updateTaskPost: function (data, success, error) {
                apiService.post('task-post/update-task-post', data, success, error);
            },
            validateTaskPost: function (object) {
                var message = "";
                if (validateService.required(object.worked_hour) && !validateService.integer(object.worked_hour)) {
                    message += $rootScope.$lang.worked_hour_must_be_number + "<br/>";
                }
                
                if (message.length > 0) {
                    alertify.error(message);
                    return false;
                }
                return true;
            }
        };
    }]);