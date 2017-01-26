appRoot.factory('requestmentService', ['apiService', 'validateService', '$rootScope', 'alertify',
    function (apiService, validateService, $rootScope, alertify) {

        return {
            validate: function (requestment) {
                var message = '';
                if (!validateService.required(requestment.title)) {
                    message += $rootScope.$lang.i_can_not_be_blank.replace('%i%', $rootScope.$lang.title) + '<br />';
                }

                if (!validateService.required(requestment.description)) {
                    message += $rootScope.$lang.i_can_not_be_blank.replace('%i%', $rootScope.$lang.content) + '<br />';
                }

                if (message.length > 0) {
                    alertify.error(message);
                    return false;
                }

                return true;
            },
            add: function (data, success, error) {
                return apiService.post('requestment/add', data, success, error);
            },
            getRequestments: function (data, success, error) {
                return apiService.get('requestment/get-requestments', data, success, error);
            }
        };
    }]);
