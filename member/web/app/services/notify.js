appRoot.factory('notifyService', ['apiService', '$rootScope', 'alertify', function (apiService, $rootScope, alertify) {

        return {
            countNotification: function (data, success, error) {
                apiService.post('notification/count', data, success, error, 0);
            },
            getNotifications: function (data, success, error) {
                apiService.post('notification/get-notifications', data, success, error, 0);
            }
        };
    }]);
