appRoot.factory('companyService', ['apiService', '$rootScope', 'alertify', 'validateService',
    function (apiService, $rootScope, alertify, validateService) {
        return {
            validate: function (company) {
                var message = '';
                if (!validateService.required(company.numberMonth)) {
                    message += $rootScope.$lang.i_can_not_be_blank.replace('%i%', $rootScope.$lang.time) + '<br />';
                }
                
                if (message.length > 0) {
                    alertify.error(message);
                    return false;
                }

                return true;
            },
            getOne: function (data, success, error) {
                return apiService.get('company/view', data, success, error);
            },
            changePackage: function (data, success, error) {
                return apiService.post('company/change-package', data, success, error);
            }
        };
    }]);
