appRoot.factory('activityService', ['apiService', function (apiService) {

        return {
            searchEmployee: function (data, success, error) {
                return apiService.post('employee/search', data, success, error);
            },
            getActivity: function (data, success, error) {
                return apiService.get('activity/get-activity', data, success, error);
            },
        };
    }]);
