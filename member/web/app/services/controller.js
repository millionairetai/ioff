appRoot.factory('controllerService', ['apiService', function (apiService) {

        return {
            findAll: function (success, error) {
                return apiService.get('controller/index', {}, success, error);
            }
        };
    }]);
