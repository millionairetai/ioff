appRoot.factory('actionService', ['apiService', function (apiService) {

        return {
            findAll: function (success, error) {
                return apiService.get('action/index', {}, success, error);
            }
        };
    }]);
appRoot.factory('activityService', ['apiService', function (apiService) {

        return {
            getActivity: function (data, success, error) {
                return apiService.get('activity/get-activity', data, success, error);
            },
            like: function (data, success, error) {
                return apiService.post('activity/like', data, success, error);
            },
            addMessage: function (data, success, error) {
                return apiService.post('activity/add-message', data, success, error);
            },
            getProfileActivity: function (data, success, error) {
                return apiService.get('activity/get-activity', data, success, error);
            }
        };
    }]);
appRoot.factory('activityPostService', ['apiService', function (apiService) {

        return {
            addMessage: function (data, success, error) {
                return apiService.post('activity-post/add', data, success, error);
            }
        };
    }]);
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
            },
            getEmployeeAuth: function (data, success, error) {
                apiService.post('authority/get-employee-auth', data, success, error);
            },
            getOne:  function (data, success, error) {
                apiService.get('authority/view', data, success, error);
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
            validate: function (object) {
                var message = "";
                if (object.name.length == 0) {
                    message += $rootScope.$lang.calendar_name_error_empty + "<br/>";
                }
                if (object.name.length > 255) {
                    message += $rootScope.$lang.name_must_less_than_255_characters + "<br/>";
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
appRoot.factory('commentService', ['apiService', function (apiService) {

        return {
            like: function (data, success, error) {
                return apiService.post('comment/like', data, success, error);
            }
        };
    }]);
appRoot.factory('commonService', ['apiService', '$rootScope',
    function (apiService, $rootScope) {

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
appRoot.factory('companyService', ['apiService', '$rootScope', 'alertify', 
    function (apiService, $rootScope, alertify) {
        return {
            getOne: function (data, success, error) {
                apiService.get('company/view', data, success, error);
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
appRoot.factory('departmentService', ['apiService', '$rootScope', 'alertify', 'validateService', function (apiService, $rootScope, alertify, validateService) {
        return {
            validate: function (department) {
                var message = "";
                if (!validateService.required(department.name)) {
                    message += $rootScope.$lang.error_name_empty;
                }
                
                if (message.length > 0) {
                    alertify.error(message);
                    return false;
                }
                
                return true;
            },
            allDepartment: function (data, success, error) {
                return apiService.get('department/all', data, success, error);
            },
            gets: function (data, success, error) {
                return apiService.get('department/index', data, success, error);
            },
            delete: function (data, success, error) {
                return apiService.post('department/delete', data, success, error);
            },
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
            changeAvatar: function (data, success, error) {
                return apiService.upload('employee/change-avatar', data, success, error);
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
appRoot.factory('eventService', ['apiService', '$rootScope', 'alertify', function (apiService, $rootScope, alertify) {

        return {
            getUpcomingEvent: function (data, success, error) {
                apiService.get('event/get-upcoming-event', data, success, error);
            },
            listCalendars: function (data, success, error) {
                apiService.post('calendar/index', data, success, error);
            },
            addCalendar: function (data, success, error) {
                apiService.post('calendar/add-calendar', data, success, error);
            },
            editCalendar: function (data, success, error) {
                apiService.post('calendar/edit-calendar', data, success, error);
            },
            deleteCalendar: function (data, success, error) {
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
            },
            getNumberRequest:  function (data, success, error) {
                return apiService.get('requestment/get-my-number-request', data, success, error);
            }
        };
    }]);
appRoot.factory('requestmentCategoryService', ['apiService', '$rootScope', 'alertify', 'validateService',
    function (apiService, $rootScope, alertify, validateService) {
        return {
            validate: function (requestmentCategory) {
                var message = "";
                if (!validateService.required(requestmentCategory.name)) {
                    message += $rootScope.$lang.error_name_empty;
                }

                if (message.length > 0) {
                    alertify.error(message);
                    return false;
                }

                return true;
            },
            allDepartment: function (data, success, error) {
                return apiService.get('requestment-category/all', data, success, error);
            },
            gets: function (data, success, error) {
                return apiService.get('requestment-category/index', data, success, error);
            },
            delete: function (data, success, error) {
                return apiService.post('requestment-category/delete', data, success, error);
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
        getTaskStatus : function (data,success,error){
            apiService.get('status/get-status?type=task', data, success, error);
        },
        getEmployeesStatus : function (employeeStatus, success, error){
            apiService.get('status/get-employee-statuses', {currentStatus: employeeStatus},success, error);
        }
    };
}]);
appRoot.factory('taskService', ['apiService','$rootScope','alertify', function (apiService,$rootScope,alertify) {

        return {
            getPriorityList : function (data,success,error) {
                apiService.get('priority/get-priority-list',data,success,error);
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
                
                if(object.project_id == 0 || object.project_id == null){
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
            getMyTaskForDropdown: function(data,success,error) {
                apiService.post('task/get-task-for-dropdown',data,success,error, false);
            },
            getSearchGlobalTasks:  function(data,success,error) {
                apiService.post('task/get-search-global-tasks',data,success,error);
            },
            getMyTaskForCalendar:  function(data,success,error) {
                apiService.post('task/get-my-task-for-calendar',data,success,error);
            },
            getMyFollowTaskForCalendar:  function(data,success,error) {
                apiService.post('task/get-my-follow-task-for-calendar',data,success,error);
            },
            getTaskReport: function(data,success,error) {
                apiService.get('report/get-task-report',data,success,error);
            },
            getEmpTaskReport: function(data,success,error) {
                apiService.get('report/get-employee-task-report',data,success,error);
            },
            getDetaiWorkedHourEmployee: function(data,success,error) {
                apiService.get('task/get-detail-worked-hour-employee',data,success,error);
            },
            getOverviewMytask: function(data,success,error) {
                apiService.get('task/get-overview-my-task',data,success,error);
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
appRoot.factory('TaskPostService', ['apiService', '$rootScope', 'alertify', 'validateService',
    function (apiService, $rootScope, alertify, validateService) {

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
            removeTaskPost: function (data, success, error) {
                apiService.get('task-post/remove-task-post', data, success, error);
            },
            updateTaskPost: function (data, success, error) {
                apiService.post('task-post/update-task-post', data, success, error);
            },
            validateTaskPost: function (object) {
                var message = "";
                if (validateService.required(object.worked_hour) && !validateService.integer(object.worked_hour)) {
                    message += $rootScope.$lang.worked_hour_must_be_number + "<br/>";
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
appRoot.factory('validateService', ['apiService', function (apiService) {
        return {
            run: function(val, regExp) {
                if (val == '' || angular.isUndefined(val) || val == null) {
                    return false;
                }
                
                if (val.search(regExp) === -1) {
                    return false;
                }

                return true;
            },
            integer: function (number) {
                return this.run(number, /^\s*[+-]?\d+\s*$/);
            },
            email: function (email) {
                return this.run(email, /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/);
            },
            date: function (date) {
                return this.run(date, /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/);
            },
            maxSizeUpload: function(file) {
                return file.size < 10485760;
            },
            imageFile: function(file) {
                return file.type.match('image.*');
            },
            avatar: function(file) {
                return this.run(file.type, /^(image\/gif)|(image\/jpg)|(image\/jpeg)|(image\/pjpeg)|(image\/png)$/);
            },
            required: function(text) {
                if (text == '' || angular.isUndefined(text) || text == null) {
                    return false;
                }
                
                if (angular.isString(text)) {
                    text = text.trim();
                    return text.length > 0;
                }
                
                return true;
            }
        };
    }]);
