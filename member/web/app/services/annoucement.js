appRoot.factory('annoucementService', ['apiService', 'validateService', '$rootScope', 'alertify',
    function (apiService, validateService, $rootScope, alertify) {

        return {
            validate: function (annoucement) {
                var message = '';
                if (!validateService.required(annoucement.title)) {
                    message += $rootScope.$lang.i_can_not_be_blank.replace('%i%', $rootScope.$lang.title) + '<br />';
                }

                if (!validateService.required(annoucement.description)) {
                    message += $rootScope.$lang.i_can_not_be_blank.replace('%i%', $rootScope.$lang.content) + '<br />';
                }

                if (!validateService.required(annoucement.date_new_to)) {
                    message += $rootScope.$lang.date_cant_blank_and_format_ddmmYY + '<br />';
                } else {
                    var enddate = moment(annoucement.date_new_to);
                    var now = moment();
                    if (enddate.diff(now) <= 0) {
                        message += $rootScope.$lang.enddate_must_greater_one_day_than_now + "<br/>";
                    }
                }

                if (message.length > 0) {
                    alertify.error(message);
                    return false;
                }

                return true;
            },
            add: function (data, success, error) {
                return apiService.post('annoucement/add', data, success, error);
            },
            getAnnoucements: function (data, success, error) {
                return apiService.get('annoucement/get-annoucements', data, success, error);
            }
        };
    }]);
