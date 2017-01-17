appRoot.factory('activityService', ['apiService', function (apiService) {

        return {
            getActivity: function (data, success, error) {
                return apiService.get('activity/get-activity', data, success, error);
            }
        };
    }]);
