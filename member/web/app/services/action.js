appRoot.factory('actionService', ['apiService', function (apiService) {

        return {
            findAll: function (success, error) {
                return apiService.get('action/index', {}, success, error);
            }
        };
    }]);
