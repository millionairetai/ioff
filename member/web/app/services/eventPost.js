appRoot.factory('EventPostService', ['apiService', '$rootScope', 'alertify', function (apiService, $rootScope, alertify) {
    return {
        addEventPost: function (data, success, error) {
            apiService.upload('event-post/add-event-post', data, success, error);
        },
        getEventPosts: function (data, success, error) {
            apiService.get('event-post/get-event-post', data, success, error);
        },
        getLastEventPost: function (data, success, error) {
            apiService.get('event-post/get-last-event-post', data, success, error);
        },
        removeEventPost : function (data,success,error){
            apiService.get('event-post/remove-event-post', data, success, error);
        },
        updateEventPost : function (data,success,error){
            apiService.post('event-post/update-event-post', data, success, error);
        },
        validateEventPost: function (object) {
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