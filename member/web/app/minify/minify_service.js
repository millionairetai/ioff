appRoot.factory('apiService', ['$rootScope', '$http', '$location', 'alertify', function ($rootScope, $http, $location, alertify) {

        return {
            //post
            post: function (url, data, successHandler, errorHandler) {
                $rootScope.progressing = true;
                return $http.post(url, data).success(function (response, status, headers, config) {
                    //chi xu ly khi status bằng 200
                    if (status == 200) {
                        if (response.error) {
                            alertify.error(response.message);
                            if (typeof errorHandler == "function") {
                                errorHandler(response);
                            }
                        } else {
                            successHandler(response);
                        }
                    } else {
                        $location.path('/login');
                    }
                    
                    $rootScope.progressing = false;
                }).error(function (data, status, headers, config) {
                    $rootScope.progressing = false;
                    console.log('error', status);
                });
            },
            //get
            get: function (url, data, successHandler, errorHandler) {
                $rootScope.progressing = true;
                return $http.get(url, {params: data}).success(function (response, status, headers, config) {
                    //chi xu ly khi status bằng 200
                    if (status == 200) {
                        if (response.error) {
                            alertify.error(response.message);
                            if (typeof errorHandler == "function") {
                                errorHandler(response);
                            }
                        } else {
                            successHandler(response);
                        }
                    } else {
                        $location.path('/login');
                    }
                    $rootScope.progressing = false;
                }).error(function (response, status, headers, config) {
                    $rootScope.progressing = false;
                    console.log(response);
                });
            },
            //put
            put: function (url, data, successHandler, errorHandler) {
                $rootScope.progressing = true;
                return $http.put(url, data).success(function (response, status, headers, config) {
                    //chi xu ly khi status bằng 200
                    if (status == 200) {
                        if (response.error) {
                            alertify.error(response.message);
                            if (typeof errorHandler == "function") {
                                errorHandler(response);
                            }
                        } else {
                            successHandler(response);
                        }
                    } else {
                        $location.path('/login');
                    }
                    $rootScope.progressing = false;
                }).error(function (data, status, headers, config) {
                    $rootScope.progressing = false;
                    console.log('error', status);
                });
            },
            //delete
            delete: function (url, data, successHandler, errorHandler) {
                $rootScope.progressing = true;
                return $http.delete(url, {params: data}).success(function (response, status, headers, config) {
                    //chi xu ly khi status bằng 200
                    if (status == 200) {
                        if (response.error) {
                            alertify.error(response.message);
                            if (typeof errorHandler == "function") {
                                errorHandler(response);
                            }
                        } else {
                            successHandler(response);
                        }
                    } else {
                        $location.path('/login');
                    }
                    $rootScope.progressing = false;
                }).error(function (data, status, headers, config) {
                    $rootScope.progressing = false;
                    console.log('error', status);
                });
            },
            //upload file
            upload: function (url, data, successHandler, errorHandler) {
                $rootScope.progressing = true;
                return $http.post(url, data, {
                    withCredentials: true,
                    headers: {'Content-Type': undefined},
                    transformRequest: angular.identity
                }).success(function (response, status, headers, config) {
                    //chi xu ly khi status bằng 200
                    if (status == 200) {
                        if (response.error) {
                            alertify.error(response.message);
                            if (typeof errorHandler == "function") {
                                errorHandler(response);
                            }
                        } else {
                            successHandler(response);
                        }
                    } else {
                        $location.path('/login');
                    }
                    $rootScope.progressing = false;
                }).error(function (data, status, headers, config) {
                    $rootScope.progressing = false;
                    console.log('error', status);
                });
            },
        };
    }]);appRoot.factory('departmentService', ['apiService', function (apiService) {

        return {
            allDepartment : function (data,success,error){
                return apiService.get('department/all',data,success,error);
            }
        };
    }]);
appRoot.factory('dialogMessage', ['$rootScope', "$modal", function ($rootScope, $modal) {

        return {
            open: function (type, message, handle) {
                var modalInstance = $modal.open({
                    templateUrl: 'app/views/widgets/dialogMessage.html',
                    controller: 'dialogMessage',
                    size: 'sm',
                    resolve: {
                        data: function () {
                            return {
                                type: type,
                                message: message
                            };
                        }
                    }
                });
                modalInstance.result.then(function (data) {
                    handle(data);
                }, function () {
                });
            },
        };
    }]);


appRoot.factory('employeeService', ['apiService', function (apiService) {

        return {
            searchEmployee : function (data,success,error){
                return apiService.post('employee/search',data,success,error);
            }
        };
    }]);
appRoot.factory('projectService', ['apiService','$rootScope','alertify', function (apiService,$rootScope,alertify) {

        return {
            listProject : function (data,success,error){
                apiService.post('project/index',data,success,error);
            },
            addProject : function (data,success,error){
                apiService.upload('project/add',data,success,error);
            },
            listStatus : function (data,success,error){
                apiService.get('project/status',data,success,error);
            },
            listPriority : function (data,success,error){
                apiService.get('project/priority',data,success,error);
            },
            validate_step1 : function(object){
                var message = "";
                var now = new Date();
                if(object.name.length == 0){
                    message += $rootScope.$lang.project_name_error_empty + "<br/>";
                }
                if(object.description.length == 0){
                    message += $rootScope.$lang.project_description_error_empty + "<br/>";
                }
                if(!isNaN(parseFloat(object.estimate_hour)) && isFinite(object.estimate_hour)){
                    if(object.estimate_hour < 0){
                        message += $rootScope.$lang.project_estimate_error_0 + "<br/>";
                    }
                    
                }else{
                    message += $rootScope.$lang.project_estimate_error + "<br/>";
                }
                
                //check start date
                if((typeof object.start_datetime) === 'undefined' ){
                    message += $rootScope.$lang.project_start_date_error_empty + "<br/>";
                }
                //check enddate
                if((typeof object.duedatetime) === 'undefined'){
                    message += $rootScope.$lang.project_end_date_error_empty + "<br/>";
                }else{
                    if(Object.prototype.toString.call(object.duedatetime) === '[object Date]' && object.duedatetime.getTime() < now.getTime()){
                        message += $rootScope.$lang.project_end_date_error_past + "<br/>";
                    }
                }
                if(Object.prototype.toString.call(object.start_datetime) === '[object Date]' && Object.prototype.toString.call(object.duedatetime) === '[object Date]'){
                    if(object.start_datetime.getTime() > object.duedatetime.getTime()){
                        message += $rootScope.$lang.project_time_error + "<br/>";
                    }
                }
                
                if(message.length > 0){
                    alertify.error(message);
                    return false;
                }
                return true;
                
            },
            validate_step2 : function(object){
                var message = "";
                /*var now = new Date();
                if(object.manager_project_id == 0){
                    message += $rootScope.$lang.project_manager_error_empty + "<br/>";
                }
                if(object.members.length == 0 && object.departments.length == 0){
                    message += $rootScope.$lang.project_members_error_empty + "<br/>";
                }*/
                
                if(message.length > 0){
                    alertify.error(message);
                    return false;
                }
                return true;
                
            }
            
        };
    }]);
