appRoot.factory('activityService', ['apiService', function (apiService) {

        return {
            getActivity: function (data, success, error) {
                return apiService.get('activity/get-activity', data, success, error);
            },
            like: function (data, success, error) {
                return apiService.post('activity/like', data, success, error);
            },
            addMessage: function (data, success, error) {
                return apiService.post('activity/add-message', data, success, error);
            }
        };
    }]);
