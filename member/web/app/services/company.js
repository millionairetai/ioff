appRoot.factory('companyService', ['apiService', '$rootScope', 'alertify', 
    function (apiService, $rootScope, alertify) {
        return {
            getOne: function (data, success, error) {
                apiService.get('company/view', data, success, error);
            }
        };
    }]);
