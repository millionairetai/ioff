appRoot.factory('employeeService', ['apiService', '$rootScope', 'alertify',
    function (apiService, $rootScope, alertify) {

        return {
            searchEmployee: function (data, success, error) {
                return apiService.post('employee/search', data, success, error);
            },
            searchEmployeeByProjectIdAndKeyword: function (data, success, error) {
                return apiService.post('employee/search-by-project-id-and-keyword', data, success, error);
            },
            searchEmployeeByKeyword: function (data, success, error) {
                return apiService.post('employee/search-by-keyword', data, success, error);
            },
            getEmployeesByStatus: function (data, success, error) {
                return apiService.get('employee/get-employees', data, success, error);
            },
            invite: function (data, success, error) {
                data.emails = data.emails.split(';');
                return apiService.post('employee/invite', data, success, error);
            },
            isValidEmail: function (email) {
                var emailRegExp = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
                if (email.search(emailRegExp) === -1) {
                    return false;
                }
                
                return true;
            },
            validateInvitation: function (object) {
                var message = "";
                try {
                    if (object.message.length == 0) {
                        message += $rootScope.$lang.project_name_error_empty + "<br/>";
                        throw message;
                    }

                    if (object.emails.length == 0) {
                        message += $rootScope.$lang.project_description_error_empty + "<br/>";
                        throw message;
                    }

                    //Check validation each email.
                    var emails = object.emails.split(';');
                    for (var n = 0; n < emails.length; n++) {
                        if (this.isValidEmail(emails[n].trim()) === false) {
                            message += 'Email ' + emails[n].trim() + ' is invalid';
                            throw message;
                        }
                    }
                }
                catch (err) {
                    if (message.length > 0) {
                        alertify.error(message);
                        return false;
                    }
                }

                return true;
            }
        };
    }]);
