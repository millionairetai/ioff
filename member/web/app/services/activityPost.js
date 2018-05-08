appRoot.factory('activityPostService', ['apiService', function (apiService) {

        return {
            addMessage: function (data, success, error) {
                return apiService.post('activity-post/add', data, success, error);
            }
        };
    }]);
