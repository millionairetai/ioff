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
                
                if (!parseInt(requestment.requestment_category_id)) {
                    message += $rootScope.$lang.i_can_not_be_blank.replace('%i%', $rootScope.$lang.requestment_category) + '<br />';
                }
                
                if (!requestment.review_employee) {
                    message += $rootScope.$lang.i_can_not_be_blank.replace('%i%', $rootScope.$lang.review_employee) + '<br />';
                }
                
                var from_datetime = moment(requestment.from_datetime);
                var to_datetime = moment(requestment.to_datetime);
                if (to_datetime.diff(from_datetime) <= 0) {
                    message += $rootScope.$lang.todatetime_must_be_greater_fromdatetime + "<br/>";
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
            },
            process: function (data, success, error) {
                return apiService.post('requestment/process', data, success, error);
            }
        };
    }]);
