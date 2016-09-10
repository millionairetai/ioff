appRoot.factory('actionService', ['apiService', function (apiService) {

        return {
            findAll: function (success, error) {
                return apiService.get('action/index', {}, success, error);
            }
        };
    }]);
appRoot.factory('apiService', ['$rootScope', '$http', '$location', 'alertify', function ($rootScope, $http, $location, alertify) {

        return {
            //post
            post: function (url, data, successHandler, errorHandler,over) {
                over = typeof over !== 'undefined' ? over : 1;
                if(over) {
                    $rootScope.progressing = true;
                }
                
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
                    errorHandler(data);
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
                    errorHandler(data);
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
    }]);
appRoot.factory('authorityService', ['apiService', '$http', function (apiService, $http) {

        return {
            add: function (data, success, error) {
                apiService.post('authority/add', data, success, error);
            },
            edit: function (data, success, error) {
                apiService.post('authority/edit', data, success, error);
            },
            findAll: function (params, success, error) {
                apiService.get('authority', params, success, error);
            },
            findAllAssignments: function (params, success, error) {
                apiService.get('authority/get-assignments', params, success, error);
            },
            delete: function (data, success, error) {
                apiService.post('authority/delete', data, success, error);
            }
        };
    }]);
appRoot.factory('calendarService', ['apiService','$rootScope','alertify', function (apiService,$rootScope,alertify) {

        return {
            listCalendars : function (data,success,error){
                apiService.post('calendar/index',data,success,error);
            },
            listEvents : function (data,success,error){
                apiService.post('calendar/events',data,success,error);
            },
            addEvent : function (data,success,error){
                apiService.upload('calendar/add-event',data,success,error);
            },
            getLanguage : function (data,success,error){
                apiService.upload('calendar/language',data,success,error);
            },
            editEvent : function (data,success,error){
            	apiService.upload('calendar/edit-event',data,success,error);
            },
            viewEvent: function (data,success,error){
                apiService.get('calendar/view-event',data, success, error);
            },
            attend: function (data,success,error){
                apiService.post('calendar/attend',data, success, error);
            },
            viewAttend: function (data,success,error){
                apiService.post('calendar/view-attend',data, success, error);
            },
            //validate
            validate_step1 : function(object){
                var message = "";
                var now = new Date();

                //check name
                if(object.name.length == 0){
                    message += $rootScope.$lang.calendar_event_name_error_empty + "<br/>";
                }
                
                //check calendar
                if(object.calendar_id == 0){
                    message += $rootScope.$lang.calendar_event_calendar_id_error_empty + "<br/>";
                }
                
                //check start date
                if(Object.prototype.toString.call(object.var_start_datetime) !== '[object Date]'){
                    message += $rootScope.$lang.calendar_event_start_date_error_empty + "<br/>";
                }else{
                    if(object.redmind > 0){
                        var sub = moment(object.var_start_datetime).subtract({ minutes: object.redmind});
                        var now = moment();
                        if(sub.diff(now) < 0){
                            message += $rootScope.$lang.calendar_event_check_redmind + "<br/>";
                        }
                    }
                }
                //check enddate
                if(Object.prototype.toString.call(object.var_end_datetime) !== '[object Date]'){
                    message += $rootScope.$lang.calendar_event_end_date_error_empty + "<br/>";
                }
                
                if(Object.prototype.toString.call(object.var_start_datetime) === '[object Date]' && Object.prototype.toString.call(object.var_end_datetime) === '[object Date]'){
                    if(object.var_start_datetime.getTime() > object.var_end_datetime.getTime()){
                        message += $rootScope.$lang.calendar_event_time_error + "<br/>";
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
                if(Object.prototype.toString.call(object.var_start_datetime) !== '[object Date]'){
                    message += $rootScope.$lang.calendar_event_start_date_error_empty + "<br/>";
                }else{
                    if(object.redmind > 0){
                        var sub = moment(object.var_start_datetime).subtract({ minutes: object.redmind});
                        var now = moment();
                        if(sub.diff(now) < 0){
                            message += $rootScope.$lang.calendar_event_check_redmind + "<br/>";
                        }
                    }
                }
                
                if(message.length > 0){
                    alertify.error(message);
                    return false;
                }
                return true;
                
            },
            colors : function(){
                return ['3b91ad','5484ed','a4bdfc','46d6db','7ae7bf','51b749','fbd75b','ffb878','ff887c','dc2127','dbadff','e1e1e1']
            },
            redmind : function(){
                return [
                    {id:0,name:$rootScope.$lang.calendar_event_redmine_0},
                    {id:30,name:$rootScope.$lang.calendar_event_redmine_30},
                    {id:60,name:$rootScope.$lang.calendar_event_redmine_60},
                    {id:120,name:$rootScope.$lang.calendar_event_redmine_120},
                    {id:240,name:$rootScope.$lang.calendar_event_redmine_240},
                    {id:1440,name:$rootScope.$lang.calendar_event_redmine_1440},
                    {id:2880,name:$rootScope.$lang.calendar_event_redmine_2880},
                ];
            }
        };
    }]);
appRoot.factory('controllerService', ['apiService', function (apiService) {

        return {
            findAll: function (success, error) {
                return apiService.get('controller/index', {}, success, error);
            }
        };
    }]);
appRoot.factory('departmentService', ['apiService', function (apiService) {

        return {
            allDepartment : function (data,success,error){
                return apiService.get('department/all',data,success,error);
            }
        };
    }]);
appRoot.factory('dialogMessage', ['$rootScope', "$uibModal", function ($rootScope, $uibModal) {

        return {
            open: function (type, message, handle) {
                var modalInstance = $uibModal.open({
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
appRoot.factory('EventPostService', ['apiService', '$rootScope', 'alertify', function (apiService, $rootScope, alertify) {
    return {
        addEventPost: function (data, success, error) {
            apiService.upload('event-post/add-event-post', data, success, error);
        },
        getEventPosts: function (data, success, error) {
            apiService.get('event-post/get-event-post', data, success, error);
        },
        getLastEventPost: function (data, success, error) {
            apiService.get('event-post/get-last-event-post', data, success, error);
        },
        removeEventPost : function (data,success,error){
            apiService.get('event-post/remove-event-post', data, success, error);
        },
        updateEventPost : function (data,success,error){
            apiService.post('event-post/update-event-post', data, success, error);
        },
        validateEventPost: function (object) {
            var message = "";
            if (object.description.length == 0) {
                message += $rootScope.$lang.event_description_error_empty + "<br/>";
            }
            if (message.length > 0) {
                alertify.error(message);
                return false;
            }
            return true;
        }
    };
}]);appRoot.factory('fileService', ['apiService', function (apiService) {
    return {
    	removeFile : function (data,success,error){
            apiService.get('file/remove-file', data, success, error);
        }
    };
}]);
appRoot.factory('notifyService', ['apiService', '$rootScope', 'alertify', function (apiService, $rootScope, alertify) {

        return {
            countNotification: function (data, success, error) {
                apiService.post('notification/count', data, success, error, 0);
            },
        };
    }]);
appRoot.factory('priorityService', ['apiService', function (apiService) {
    return {
    	getProjectPriority : function (data,success,error){
            apiService.get('priority/get-project-priority', data, success, error);
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
            viewProject: function (data,success,error){
                apiService.post('project/view',data, success, error);
            },
            editProject : function (data,success,error){
                apiService.upload('project/edit', data, success,error);
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
                
            },
        };
    }]);
appRoot.factory('projectPostService', ['apiService', '$rootScope', 'alertify', 
    function (apiService, $rootScope, alertify) {
        return {
            addProjectPost: function (data, success, error) {
                apiService.upload('project-post/add-project-post', data, success, error);
            },
            getProjectPosts: function (data, success, error) {
                apiService.post('project-post/get-project-post', data, success, error);
            },
            removeProjectPost : function (data,success,error){
                apiService.get('project-post/remove-project-post', data, success, error);
            },
            updateProjectPost : function (data,success,error){
            	apiService.post('project-post/update-project-post', data, success, error);
            },
            validateProjectPost: function (object) {
                var message = "";
                if (object.description.length == 0) {
                    message += $rootScope.$lang.project_description_error_empty + "<br/>";
                }

                if (message.length > 0) {
                    alertify.error(message);
                    return false;
                }

                return true;
            }
        };
    }]);
appRoot.factory('socketService', ['socketFactory', function (socketFactory) {

        var myIoSocket = io.connect('http://localhost:3000');
        mySocket = socketFactory({
            ioSocket: myIoSocket
        });
        return mySocket;
    }]);

appRoot.factory('statusService', ['apiService', function (apiService) {
    return {
    	getProjectStatus : function (data,success,error){
            apiService.get('status/get-project-status', data, success, error);
        }
    };
}]);
appRoot.factory( "ValidationServices", function() {
    return {
        failIfWrongThreshouldConfig: function( firstThreshould, secondThreshould ) {
            if( (! firstThreshould && ! secondThreshould) || (firstThreshould && secondThreshould) ) {
                throw "You must specify one, and only one, type of threshould (chars or words)";
            }
        }
    };
});

appRoot.factory( "CharBasedTruncation", [ "$compile", '$rootScope' , function( $compile, $rootScope) {
    return {
        truncationApplies: function( $scope, threshould ) {
            return $scope.text.length > threshould;
        },

        applyTruncation: function( threshould, $scope, $element) {
            if( $scope.useToggling ) {
                var el = angular.element(    "<span>" + 
                                                $scope.text.substr( 0, threshould ) + 
                                                "<span ng-show='!open'>...</span>" +
                                                "<span class='btn-link ngTruncateToggleText' " +
                                                    "ng-click='toggleShow()'" +
                                                    "ng-show='!open'>" +
                                                    "  <div class='text-right'>" +  ($scope.customMoreLabel ? $scope.customMoreLabel : $rootScope.$lang.more) + "</div>" +
                                                "</span>" +
                                                "<span ng-show='open'>" + 
                                                    $scope.text.substring( threshould ) + 
                                                    "<span class='btn-link ngTruncateToggleText'" +
                                                          "ng-click='toggleShow()'>" +
                                                          "  <div class='text-right'>" +  ($scope.customLessLabel ? $scope.customLessLabel : $rootScope.$lang.less) + "</div>" +
                                                    "</span>" +
                                                "</span>" +
                                            "</span>" );
                $compile( el )( $scope );
                $element.append( el );

            } else {
                $element.append( $scope.text.substr( 0, threshould ) + "..." );

            }
        }
    };
}]);

appRoot.factory( "WordBasedTruncation", [ "$compile", function( $compile ) {
    return {
        truncationApplies: function( $scope, threshould ) {
            return $scope.text.split( " " ).length > threshould;
        },

        applyTruncation: function( threshould, $scope, $element ) {
            var splitText = $scope.text.split( " " );
            if( $scope.useToggling ) {
                var el = angular.element(    "<span>" + 
                                                splitText.slice( 0, threshould ).join( " " ) + " " + 
                                                "<span ng-show='!open'>...</span>" +
                                                "<span class='btn-link ngTruncateToggleText' " +
                                                    "ng-click='toggleShow()'" +
                                                    "ng-show='!open'>" +
                                                    "  <div class='text-right'>" + ($scope.customMoreLabel ? $scope.customMoreLabel : $rootScope.$lang.more) + "</div>" +
                                                "</span>" +
                                                "<span ng-show='open'>" + 
                                                    splitText.slice( threshould, splitText.length ).join( " " ) + 
                                                    "<span class='btn-link ngTruncateToggleText'" +
                                                          "ng-click='toggleShow()'>" +
                                                          "  <div class='text-right'>" +  ($scope.customLessLabel ? $scope.customLessLabel : $rootScope.$lang.less) + "</div>" +
                                                    "</span>" +
                                                "</span>" +
                                            "</span>" );
                $compile( el )( $scope );
                $element.append( el );

            } else {
                $element.append( splitText.slice( 0, threshould ).join( " " ) + "..." );
            }
        }
    };
}]);
