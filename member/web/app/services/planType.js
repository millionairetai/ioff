appRoot.factory('planTypeService', ['apiService', '$rootScope',
    function (apiService, $rootScope) {

        return {
            gets: function (data, success, error) {
                apiService.get('plan-type/gets', data, success, error);
            }
        };
    }]);