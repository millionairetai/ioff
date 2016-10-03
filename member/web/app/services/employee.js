appRoot.factory('employeeService', ['apiService', '$rootScope', 'alertify', function (apiService, $rootScope, alertify) {

        return {
            searchEmployee : function (data,success,error){
                return apiService.post('employee/search',data,success,error);
            },
            searchEmployeeByProjectIdAndKeyword : function (data,success,error){
                return apiService.post('employee/search-by-project-id-and-keyword',data,success,error);
            },
            searchEmployeeByKeyword : function (data,success,error){
                return apiService.post('employee/search-by-keyword',data,success,error);
            },
            getEmployeesByStatus: function (data, success, error){
                return apiService.get('employee/get-employees',data,success,error);
            },
            invite: function (data, success, error){
                return apiService.post('employee/invite', data,success,error);
            }, 
            validateInvitation : function(object) {
               var message = "";
                if(object.message.length == 0){
                    message += $rootScope.$lang.project_name_error_empty + "<br/>";
                }
                
                if(object.emails.length == 0){
                    message += $rootScope.$lang.project_description_error_empty + "<br/>";
                }
                
                //Check validation each email.
                
                var email = object.emails.split('')
                
                if(message.length > 0){
                    alertify.error(message);
                    return false;
                }
                return true; 
            }
        };
    }]);
