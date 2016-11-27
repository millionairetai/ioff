appRoot.factory('actionService', ['apiService', function (apiService) {

        return {
            findAll: function (success, error) {
                return apiService.get('action/index', {}, success, error);
            }
        };
    }]);
appRoot.factory('activityService', ['apiService', function (apiService) {

        return {
            searchEmployee : function (data,success,error){
                return apiService.post('employee/search',data,success,error);
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
                apiService.get('calendar/view-attend',data, success, error);
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
            },
            redmindDay : function(){
                return [
                        {id:30,name:$rootScope.$lang.calendar_event_redmine_30},
                        {id:60,name:$rootScope.$lang.calendar_event_redmine_60},
                        {id:120,name:$rootScope.$lang.calendar_event_redmine_120},
                        {id:240,name:$rootScope.$lang.calendar_event_redmine_240},
                        {id:1440,name:$rootScope.$lang.calendar_event_redmine_1440},
                        {id:2880,name:$rootScope.$lang.calendar_event_redmine_2880},
                        ];
            },
            addCalendar : function (data,success,error){
                apiService.post('calendar/add-calendar', data, success, error);
            },
            editCalendar : function (data,success,error){
                apiService.post('calendar/edit-calendar', data, success, error);
            },
            deleteCalendar : function (data,success,error){
                apiService.get('calendar/delete-calendar', data, success, error);
            },
            validateCalendarAdd: function (object) {
                var message = "";
                if (object.name.length == 0) {
                    message += $rootScope.$lang.calendar_name_error_empty + "<br/>";
                }
                if (object.description.length == 0) {
                    message += $rootScope.$lang.calendar_description_error_empty + "<br/>";
                }
                if (message.length > 0) {
                    alertify.error(message);
                    return false;
                }
                return true;
            }
        };
    }]);
appRoot.factory('commonService', ['apiService', 'taskService', 'projectService', 'calendarService', '$rootScope',
    function (apiService, taskService, projectService, calendarService, $rootScope) {

        return {
            get: function (controller, id, success, error) {
                return apiService.get(controller + '/get?id=' + id, {}, success, error);
            },
            gets: function (controller, success, error) {
                return apiService.get(controller + '/gets', {}, success, error);
            },
            update: function (controller, data, success, error) {
                return apiService.post(controller + '/update', data, success, error);
            },
            updateUpload: function (controller, data, success, error) {
                return apiService.upload(controller + '/update-upload', data, success, error);
            },
            add: function (controller, data, success, error) {
                apiService.post(controller + '/add', data, success, error);
            },
            addUpload: function (controller, data, success, error) {
                apiService.upload(controller + '/add-upload', data, success, error);
            },
            getLast: function (controller, data, success, error) {
                apiService.get(controller + '/get-last', data, success, error);
            },
            delete: function (controller, data, success, error) {
                apiService.get(controller + '/delete', data, success, error);
            },
            getSearchGlobalSuggest: function (params, success, error) {
                return apiService.post('task/get-search-global-suggestion', params, success, error, 0);
            },
            redmind: function () {
                return [
                    {id: 0, name: $rootScope.$lang.calendar_event_redmine_0},
                    {id: 30, name: $rootScope.$lang.calendar_event_redmine_30},
                    {id: 60, name: $rootScope.$lang.calendar_event_redmine_60},
                    {id: 120, name: $rootScope.$lang.calendar_event_redmine_120},
                    {id: 240, name: $rootScope.$lang.calendar_event_redmine_240},
                    {id: 1440, name: $rootScope.$lang.calendar_event_redmine_1440},
                    {id: 2880, name: $rootScope.$lang.calendar_event_redmine_2880},
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
            allDepartment: function (data, success, error) {
                return apiService.get('department/all', data, success, error);
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
                return apiService.post('employee/invite', data, success, error);
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
appRoot.factory("flash", ['$rootScope','alertify', function ($rootScope,alertify) {
    var queue = [];
    var currentMessage = "";

    $rootScope.$on("$routeChangeSuccess", function () {
        currentMessage = queue.shift() || "";
    });

    return {
        setMessage: function (message) {
            queue.push(message);
        },
        setNoAuthFunctionMessage: function () {
            queue.push($rootScope.$lang.no_authoirty_function);
        },
        setNoAuthItemMessage: function () {
            queue.push($rootScope.$lang.no_authoirty_item);
        },
        setNoDataMessage: function () {
            queue.push($rootScope.$lang.no_data);
        },
        getMessage: function () {
            return currentMessage;
        }, 
        trigger: function () {
            var message = this.getMessage();
            if (message) {
                alertify.error(message);
            }

            return true;
        }
    };
}]);appRoot.factory('notifyService', ['apiService', '$rootScope', 'alertify', function (apiService, $rootScope, alertify) {

        return {
            countNotification: function (data, success, error) {
                apiService.post('notification/count', data, success, error, 0);
            },
            getNotifications: function (data, success, error) {
                apiService.post('notification/get-notifications', data, success, error, 0);
            }
        };
    }]);
appRoot.factory('priorityService', ['apiService', function (apiService) {
    return {
    	getTaskPriority : function (data,success,error){
            apiService.get('priority/get-priority?type=task', data, success, error);
        },
        getProjectPriority : function (data,success,error){
            apiService.get('priority/get-priority?type=project', data, success, error);
        }
    };
}]);
appRoot.factory('projectService', ['apiService','$rootScope','alertify', function (apiService,$rootScope,alertify) {

        return {
            listProject : function (data,success,error){
                apiService.post('project/index',data,success,error);
            },
            getProjects : function (data,success,error) {
                apiService.post('project/get-projects',data,success,error);
            },
            addProject : function (data,success,error){
                apiService.upload('project/add',data,success,error);
            },
            getLastedProject : function (data,success,error){
                apiService.get('project/get-lasted-project',data,success,error);
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
            apiService.get('status/get-status?type=project', data, success, error);
        },
        getEmployeeStatus : function (data,success,error){
            apiService.get('status/get-status?type=employee', data, success, error);
        }
    };
}]);
appRoot.factory('taskService', ['apiService','$rootScope','alertify', function (apiService,$rootScope,alertify) {

        return {
            getPriorityList : function (data,success,error) {
                apiService.get('priority/get-priority-list',data,success,error);
            },
            getStatusList : function (data,success,error) {
                apiService.get('status/get-task-status-list',data,success,error);
            },                        
            getTaskGroupList : function (data,success,error) {
                apiService.get('task/get-task-group',data,success,error);
            },
            getRemindBeforeList : function (data,success,error) {
                apiService.get('task/get-task-remind-before-list',data,success,error);
            },
            getParentTaskList : function (data,success,error) {
                apiService.get('task/get-tasks-by-project',data,success,error);
            },
            getTaskView : function (data,success,error) {
                apiService.get('task/view',data,success,error);
            },
            getParentTasks : function (data,success,error) {
                apiService.get('task/get-parent-tasks',data,success,error);
            },
            validate_step1 : function(object) {
                var message = "";
                var now = new Date();
                
                if(object.name.length == 0){
                    message += $rootScope.$lang.task_name_error_empty + "<br/>";
                }
                
                if(object.name.length > 255){
                    message += $rootScope.$lang.name_less_than_255_character + "<br/>";
                }
                
                if(object.project_id.length == 0 || object.project_id.length == null){
                    message += $rootScope.$lang.task_project_name_error_empty + "<br/>";
                }
                
                if(object.description.length == 0){
                    message += $rootScope.$lang.task_description_error_empty + "<br/>";
                }
                
                if(!isNaN(parseFloat(object.estimate_hour)) && isFinite(object.estimate_hour)){
                    if(object.estimate_hour < 0){
                        message += $rootScope.$lang.task_estimate_error_0 + "<br/>";
                    }
                    
                }else{
                    message += $rootScope.$lang.task_estimate_error + "<br/>";
                }
                                
                //check enddate
                if((typeof object.duedatetime) === 'undefined'){
                    message += $rootScope.$lang.task_end_date_error_empty + "<br/>";
                }                               
                
                if(message.length > 0){
                    alertify.error(message);
                    return false;
                }
                return true;
                
            },
            validate_step2 : function(object) {
                var message = "";
                if(Object.prototype.toString.call(object.duedatetime) !== '[object Date]' && object.redmind > 0) {
                    message += $rootScope.$lang.task_duedatetime_error_empty + "<br/>";
                } else {
                    if(object.redmind > 0){
                        var sub = moment(object.duedatetime).subtract({ minutes: object.redmind});
                        var now = moment();
//                        console.log(sub.diff(now, 'minutes'));
//                        console.log(sub.diff(now));
                        if(sub.diff(now) < 0){
                            message += $rootScope.$lang.task_check_valid_redmind + "<br/>";
                        }
                    }
                }
                
                if(message.length > 0){
                    alertify.error(message);
                    return false;
                }
                return true;
                
            },
            addTask : function (data,success,error){
                apiService.upload('task/add',data,success,error);
            },
            editTask : function (data,success,error){
                apiService.upload('task/edit',data,success,error);
            },
            getMyTasks : function (data,success,error) {
                apiService.get('task/get-my-tasks',data,success,error);
            },
            getAssingedTasks : function (data,success,error) {
                apiService.get('task/get-assigned-tasks',data,success,error);
            },
            getFollowTasks : function (data,success,error) {
                apiService.get('task/get-follow-tasks',data,success,error);
            },
            getTasks: function(data,success,error) {
                apiService.get('task/get-tasks',data,success,error);
            },
            getTaskForDropdown: function(data,success,error) {
                apiService.post('task/get-task-for-dropdown',data,success,error, 0);
            },
            getSearchGlobalTasks:  function(data,success,error) {
                apiService.post('task/get-search-global-tasks',data,success,error);
            },
            getMyTaskForCalendar:  function(data,success,error) {
                apiService.post('task/get-my-task-for-calendar',data,success,error);
            },
            getMyFollowTaskForCalendar:  function(data,success,error) {
                apiService.post('task/get-my-follow-task-for-calendar',data,success,error);
            }
        };
    }]);
appRoot.factory('taskGroupService', ['apiService', '$rootScope', 'alertify', function (apiService, $rootScope, alertify) {

        return {
            getTaskGroups: function (data, success, error) {
                apiService.get('task-group/get-task-groups', data, success, error);
            }
        };
    }]);
appRoot.factory('TaskPostService', ['apiService', '$rootScope', 'alertify', function (apiService, $rootScope, alertify) {
    return {
        addTaskPost: function (data, success, error) {
            apiService.upload('task-post/add-task-post', data, success, error);
        },
        getTaskPosts: function (data, success, error) {
            apiService.get('task-post/get-task-post', data, success, error);
        },
        getLastTaskPost: function (data, success, error) {
            apiService.get('task-post/get-last-task-post', data, success, error);
        },
        removeTaskPost : function (data,success,error){
            apiService.get('task-post/remove-task-post', data, success, error);
        },
        updateTaskPost : function (data,success,error){
            apiService.post('task-post/update-task-post', data, success, error);
        },
        validateTaskPost: function (object) {
            var message = "";
            if (object.description.length == 0) {
                message += $rootScope.$lang.task_description_error_empty + "<br/>";
            }
            if (message.length > 0) {
                alertify.error(message);
                return false;
            }
            return true;
        }
    };
}]);appRoot.factory( "ValidationServices", function() {
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
