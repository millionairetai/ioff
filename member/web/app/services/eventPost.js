appRoot.factory('EventPostService', ['apiService', '$rootScope', 'alertify', function (apiService, $rootScope, alertify) {
    return {
        addEventPost: function (data, success, error) {
            apiService.upload('event-post/add-event-post', data, success, error);
        },
//        getProjectPosts: function (data, success, error) {
//            apiService.post('project-post/get-project-post', data, success, error);
//        },
//        removeProjectPost : function (data,success,error){
//            apiService.get('project-post/remove-project-post', data, success, error);
//        },
//        updateProjectPost : function (data,success,error){
//            apiService.post('project-post/update-project-post', data, success, error);
//        },
        validateEventPost: function (object) {
            console.log(object);
            var message = "";
            if (object.description.length == 0) {
                message += $rootScope.$lang.event_description_error_empty + "<br/>";
            }
            if (message.length > 0) {
                alertify.error(message);
                return false;
            }
            return true;
        }
    };
}]);