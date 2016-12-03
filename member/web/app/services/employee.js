appRoot.factory('employeeService', ['apiService', '$rootScope', 'alertify', 'validateService',
    function (apiService, $rootScope, alertify, validateService) {
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
                return apiService.post('employee/invite', data, success, error);
            },
            getProfile: function (data, success, error) {
                return apiService.get('employee/get-profile', data, success, error);
            },
            updateProfile: function (data, success, error) {
                return apiService.post('employee/update-profile', data, success, error);
            },
            changePassword: function (data, success, error) {
                return apiService.post('employee/change-password', data, success, error);
            },
            isValidEmail: function (email) {
                var emailRegExp = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
                if (email.search(emailRegExp) === -1) {
                    return false;
                }

                return true;
            },
            validate: function (employee) {
                var message = '';
                if (employee.firstname.length == 0) {
                    message += $rootScope.$lang.firstname_cannot_blank + "<br/>";
                }
                
                if (employee.lastname.length == 0) {
                    message += $rootScope.$lang.lastname_cannot_blank + "<br/>";
                }
                
                if (message.length > 0) {
                    alertify.error(message);
                    return false;
                }
                
                return true;
            },            
            validateAdd: function (employee) {
                var message = '';
                if (validateService.email(employee.email) === false) {
                    message += 'Email ' + $rootScope.$lang.is_invalid + "<br/>";
                }
                
                if (employee.firstname.length == 0) {
                    message += $rootScope.$lang.firstname_cannot_blank + "<br/>";
                }
                
                if (employee.lastname.length == 0) {
                    message += $rootScope.$lang.lastname_cannot_blank + "<br/>";
                }
                
                if (angular.isDefined(employee.password) && employee.password.length > 0 && employee.password.length < 6) {
                    message += $rootScope.$lang.password_greater_6 + "<br/>";
                }

                if (message.length > 0) {
                    alertify.error(message);
                    return false;
                }
                
                return true;
            },
            validateInvitation: function (emails, message) {
                var errorMessage = "";
                try {
                    if (emails.length == 0) {
                        errorMessage += $rootScope.$lang.emails_required + "<br/>";
                        throw errorMessage;
                    }
                    
                    if (message.length == 0) {
                        errorMessage += $rootScope.$lang.message_required + "<br/>";
                        throw errorMessage;
                    }
                    //Check validation each email.
                    for (var n = 0; n < emails.length; n++) {
                        if (this.isValidEmail(emails[n].trim()) === false) {
                            errorMessage += 'Email ' + emails[n].trim() + ' ' + $rootScope.$lang.is_invalid;
                            throw errorMessage;
                        }
                    }
                }
                catch (err) {
                    if (errorMessage.length > 0) {
                        alertify.error(errorMessage);
                        return false;
                    }
                }

                return true;
            }
        };
    }]);
