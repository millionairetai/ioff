//show calendar
appRoot.controller('calendarCtrl', ['$scope', '$uibModal', 'calendarService', 'taskService', '$timeout', 'settingSystem', 'uiCalendarConfig', 'listCalendar', '$rootScope', 'dialogMessage',
    function ($scope, $uibModal, calendarService, taskService, $timeout, settingSystem, uiCalendarConfig, listCalendar, $rootScope, dialogMessage) {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $scope.start = false;
        $scope.end = false;
        $scope.events = [];
        $scope.eventSources = [$scope.events];
        $scope.calendars = [];
        $scope.chooseCalendar = [];
        $scope.calendars = listCalendar;

        for (i = 0; i < $scope.calendars.length; i++) {
            $scope.chooseCalendar.push($scope.calendars[i].id);
        }

        /* config object */
        $scope.uiConfig = {
            calendar: {
                editable: true,
                selectable: true,
                eventLimit: 4,
                timezone: "local",
                lang: settingSystem.language,
//                height: 'auto',
                select: function (start, end, allDay) {
                    var modalInstance = $uibModal.open({
                        templateUrl: 'app/views/calendar/add.html',
                        controller: 'addEventCtrl',
                        size: 'md',
                        keyboard: true,
                        backdrop: 'static',
                        resolve: {
                            data: function () {
                                return {
                                    start: start,
                                    end: end,
                                    calendars: $scope.calendars,
                                };
                            }
                        }
                    });
                    modalInstance.result.then(function (data) {
                        $timeout(function () {
                            $scope.resetEvents($scope.start, $scope.end);
                        });

                        calendarService.listCalendars({}, function (respone) {
                            calendarService.listCalendars({}, function (calendars) {
                                $scope.calendars = calendars.objects;
                                for (i = 0; i < $scope.calendars.length; i++) {
                                    $scope.chooseCalendar.push($scope.calendars[i].id);
                                }
                            });
                        });
                    }, function () {
                    });
                },
                events: function (start, end, callback) {
                    $scope.start = start;
                    $scope.end = end;
                    $scope.resetEvents(start, end);
                },
                header: {
                    left: 'month agendaWeek agendaDay',
                    center: 'title prev,next',
                    right: 'today'
                },
            }
        };

        $scope.checkCalendar = function () {
            $timeout(function () {
                $scope.resetEvents($scope.start, $scope.end);
            });
        }

        //Add my task in calendar
        $scope.myTask = [];
        $scope.chooseMyTask = [];
        taskService.getMyTaskForCalendar({}, function (respone) {
            $scope.myTask = respone.objects;
            $scope.chooseMyTask.push(true);
        });

        //Add my follow task in calendar
        $scope.myFollowTask = [];
        $scope.chooseMyFollowTask = [];
        taskService.getMyFollowTaskForCalendar({}, function (respone) {
            $scope.myFollowTask = respone.objects;
        });

        $scope.resetEvents = function (start, end) {
            calendarService.listEvents({start: start.format('YYYY-MM-DD'), end: end.format('YYYY-MM-DD'), calendars: $scope.chooseCalendar}, function (respone) {
                $scope.events.length = 0;
                $scope.canlendars = respone.objects;
                $scope.tasks = $scope.myTask;
                if ($scope.chooseMyTask != 'true') {
                    $scope.tasks = [];
                }

                if ($scope.chooseMyFollowTask == 'true') {
                    $scope.tasks = $scope.tasks.concat($scope.myFollowTask);
                }

                $scope.results = $scope.canlendars.concat($scope.tasks);
                angular.forEach($scope.results, function(value, key) {
                    allDay = value.is_all_day == 1 ? true : false;
                    var newEvent = {
                            title: value.title,
                            start: moment(value.start).toDate(),
                            end: moment(value.end).toDate(),
                            color: value.color,
                            url: '#/viewEvent/' + value.id,
                            allDay : allDay
                        };
                        $scope.events.push(newEvent);
                });
            });
        }
        
        $scope.addCalendar = function () {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/calendar/addCalendar.html',
                controller: 'addCalendarCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
            });

            modalInstance.result.then(function (data) {
                calendarService.listCalendars({}, function (calendars) {
                    $scope.calendars = calendars.objects;
                    for (i = 0; i < $scope.calendars.length; i++) {
                        $scope.chooseCalendar.push($scope.calendars[i].id);
                    }
                });
            });
        };

        $scope.editCalendar = function (calendar, $index) {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/calendar/editCalendar.html',
                controller: 'editCalendarCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
                resolve: {
                    calendar: function () {
                        return calendar;
                    }
                }
            });

            modalInstance.result.then(function (data) {
                for (i = 0; i < $scope.calendars.length; i++) {
                    if ($scope.calendars[i].id == data.id) {
                        $scope.calendars[i].name = data.name;
                    }
                    $scope.chooseCalendar.push($scope.calendars[i].id);
                }
            });
        };

        //Delete calendar title
        $scope.deleteCalendar = function (index, id) {
            dialogMessage.open('confirm', $rootScope.$lang.confirm_delete_file, function () {
                calendarService.deleteCalendar({calendarId: id}, function (data) {
                    $scope.calendars.splice(index, 1);
                    $scope.checkCalendar();
                    alertify.success($rootScope.$lang.remove_calendar_success);
                });
            });
        };
    }]);

//add Calendar Title 
appRoot.controller('addCalendarCtrl', ['$scope', '$rootScope', '$uibModalInstance', 'calendarService', 'alertify', 'socketService',
    function ($scope, $rootScope, $uibModalInstance, calendarService, alertify, socketService) {

        $scope.calendar = {
            name: '',
            description: '',
        };

        $scope.add = function () {
            if (calendarService.validateCalendarAdd($scope.calendar)) {
                calendarService.addCalendar($scope.calendar, function (data) {
                    alertify.success($rootScope.$lang.add_calendar_success);
                    $uibModalInstance.close($scope.calendar);
                });
            }
        };
        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    }]);

//edit Calendar Title
appRoot.controller('editCalendarCtrl', ['$scope', '$rootScope', '$uibModalInstance', 'calendarService', 'alertify', 'socketService', 'calendar',
    function ($scope, $rootScope, $uibModalInstance, calendarService, alertify, socketService, calendar) {
        $scope.calendar = {
            id: calendar.id,
            name: calendar.name,
            description: calendar.description
        };

        $scope.update = function () {
            if (calendarService.validateCalendarAdd($scope.calendar)) {
                calendarService.editCalendar($scope.calendar, function (data) {
                    calendar.description = $scope.calendar.description;
                    alertify.success($rootScope.$lang.update_calendar_success);
                    $uibModalInstance.close($scope.calendar);
                });
            }
        };

        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    }]);


//add event to calendar

appRoot.controller('addEventCtrl', ['$rootScope', 'data', '$scope', 'calendarService', 'alertify', '$uibModalInstance', 'departmentService', 'employeeService', '$timeout', 'socketService',
    function ($rootScope, data, $scope, calendarService, alertify, $uibModalInstance, departmentService, employeeService, $timeout, socketService) {
        //step
        $scope.step = 1;
        $scope.more = 0;
        $scope.open_start_datetime = false;
        $scope.open_end_datetime = false;
        $scope.files = [];
        $scope.colors = calendarService.colors();
        $scope.redminds = calendarService.redmind();
        $scope.people = [];
        $scope.departments = [];
        $scope.allDepartment = 0;

        if (data.end.toDate().getHours() == data.start.toDate().getHours() && data.start.toDate().getHours() == 7 && data.start.toDate().getMinutes() == data.end.toDate().getMinutes()) {
            data.start.add(-7, 'hours');
            data.end.add(-7, 'hours');
        }

        $start_datetime = data.start.toDate();
        $end_datetime = data.end.toDate();

        $scope.event = {
            var_start_datetime: $start_datetime,
            var_start_time: $start_datetime,
            var_end_datetime: $end_datetime,
            var_end_time: $end_datetime,
            start_datetime: '',
            end_datetime: '',
            name: '',
            address: '',
            calendar_id: 0,
            is_public: 0,
            description: '',
            color: "",
            redmind: 0,
            sms: 0,
            departments: [],
            members: [],
        }

        //add calendar
        $scope.calendars = [];
        $scope.calendars.push({id: 0, name: '--', count: 0});
        for (i = 0; i < data.calendars.length; i++) {
            $scope.calendars.push(data.calendars[i]);
        }

        //init
        if ($scope.colors.length > 0) {
            $scope.event.color = $scope.colors[0];
        }

        //refresh member
        $scope.selectMember = function ($item, $model) {

        };

        //add employee
        $scope.findEmployeeForCalendar = function (keyword) {
            employeeService.searchEmployee({keyword: keyword, departments: $scope.event.departments, members: $scope.event.members}, function (response) {
                $scope.employees = response.objects;
            });
        };

        //get all department
        departmentService.allDepartment({}, function (data) {
            $scope.departments = data.objects;
        });

        //check all
        $scope.checkAll = function () {
            if ($scope.allDepartment) {
                $scope.event.departments = $scope.departments.map(function (item) {
                    return item.id;
                });
            } else {
                $scope.event.departments = [];
            }
            $scope.findEmployeeForCalendar('');
        };

        //clickCheckAll
        $scope.clickCheckAll = function () {
            $timeout(function () {
                if ($scope.event.departments.length != $scope.departments.length) {
                    $scope.allDepartment = false;
                } else {
                    $scope.allDepartment = true;
                }
                $scope.findEmployeeForCalendar('');
            });

        };

        //add file
        $scope.addFile = function (files) {
            $scope.$apply(function () {
                for (var i = 0; i < files.length; i++) {
                    if (files[i].size > 10485760) {
                        alertify.error($rootScope.$lang.max_size);
                    } else {
                        if ($scope.files.length >= 20) {
                            alertify.error($rootScope.$lang.max_length);
                            return true;
                        } else {
                            $scope.files.push(files[i]);
                        }

                    }
                }
            });
        };

        //remove file
        $scope.removeFile = function ($index) {
            if (typeof $scope.files[$index] !== 'undefined') {
                $scope.files.splice($index, 1);
            }
        };

        //next
        $scope.next = function () {
            if ($scope.step < 3) {
                //check validate when go to step 2
                if ($scope.step == 1) {
                    if (calendarService.validate_step1($scope.event)) {
                        $scope.step++;
                    }
                } else {
                    if ($scope.step == 2) {
                        //check validate when go to step 3
                        if (calendarService.validate_step2($scope.event)) {
                            $scope.event.start_datetime = moment($scope.event.var_start_datetime).format('YYYY-MM-DD HH:mm:ss');
                            $scope.event.end_datetime = moment($scope.event.var_end_datetime).format('YYYY-MM-DD HH:mm:ss');
                            var fd = new FormData();

                            for (var i in $scope.files) {
                                fd.append("file_" + i, $scope.files[i]);
                            }

                            fd.append("event", angular.toJson($scope.event));
                            calendarService.addEvent(fd, function (response) {
                                alertify.success($rootScope.$lang.calendar_notify_event_created_success);
                                $uibModalInstance.close($scope.event);
                                socketService.emit('notify', 'ok');
                                $scope.step++;
                            });

                        }
                    } else {
                        $scope.step++;
                    }
                }
            }
        };
        //back
        $scope.back = function () {
            if ($scope.step == 2) {
                $scope.step--;
            }
        };

        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };

        //show more
        $scope.showMore = function (value) {
            $scope.more = value;
        }

        $scope.tinymceOptions = {
            inline: false,
            toolbar: 'formatselect | bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | undo redo ',
            menubar: false,
            skin: 'lightgray',
            theme: 'modern'
        };

        $scope.buttonBar = {
            show: true,
            now: {
                show: false,
                text: 'Now!'
            },
            today: {
                show: true,
                text: $rootScope.$lang.datepicker_today
            },
            clear: {
                show: true,
                text: $rootScope.$lang.datepicker_clear
            },
            date: {
                show: true,
                text: 'Date'
            },
            time: {
                show: true,
                text: 'Time'
            },
            close: {
                show: true,
                text: $rootScope.$lang.datepicker_close
            }

        };
        // time picker
        $scope.timepickerOptions = {
            readonlyInput: false,
            showMeridian: false
        }

    }]);

//Display info detail of calendar
var $dataEditEvent = [];
appRoot.controller('viewEventCtrl', ['$scope', 'calendarService', 'fileService', 'EventPostService', '$uibModal', '$rootScope', 'dialogMessage', '$routeParams', 'alertify', '$sce', 'PER_PAGE_VIEW_MORE','$location',
    function ($scope, calendarService, fileService, EventPostService, $uibModal, $rootScope, dialogMessage, $routeParams, alertify, $sce, PER_PAGE_VIEW_MORE, $location) {
        var eventId = $routeParams.eventId;
        //set paramter for layout
        $scope.collection = [];
        var employee_id =null;
        $scope.getInfoEvent = function () {
            calendarService.viewEvent({eventId: eventId}, function (response) {
                if (response.objects.error) {
                    $location.path('/calendar');
                }
                
                $scope.collection = response.objects;
                employee_id = $scope.collection.event.employee_id;
            });
        };
        $scope.getInfoEvent();

        //function add event post
        $scope.eventPostData = {
            description: '',
            eventId: eventId,
        };
        $scope.addEventPost = function () {
            if (($scope.collection.invitations != null)
                    && ($scope.collection.invitations.departmentAndEmployee != null)
                    && ($scope.collection.invitations.departmentAndEmployee.employeeList != null)) {
                $scope.eventPostData.employeeList = $scope.collection.invitations.departmentAndEmployee.employeeList;
            }

            if (EventPostService.validateEventPost($scope.eventPostData)) {
                var fd = new FormData();
                for (var i in $scope.files) {
                    fd.append("file_" + i, $scope.files[i]);
                }

                fd.append("event", angular.toJson($scope.eventPostData));
                EventPostService.addEventPost(fd, function (response) {
                    alertify.success($rootScope.$lang.event_post_add_success);
                    $scope.eventPostData = {
                        description: '',
                        eventId: eventId,
                    };

                    $scope.files = [];
                    $scope.releases = response.objects.collection;
                    //check if file is null, we will have errror with unshift function.
                    if (!_.isNull($scope.collection.file_info)) {
                        var newFiles = response.objects.files[Object.keys(response.objects.files)[0]];
                        //Revert files because json files returned which is inverted with the order uploaded.
                        newFiles.reverse();
                        angular.forEach(newFiles, function(val, key) {
                            $scope.collection.file_info.unshift(val);
                        });
                    } else {
                        $scope.collection.file_info = response.objects.files[Object.keys(response.objects.files)[0]];
                    }
                    

                    var temp = [];
                    temp = temp.concat($scope.releases);
                    $scope.eventPost = temp.concat($scope.eventPost);
                    $scope.eventPostFile = angular.merge($scope.eventPostFile, response.objects.files);
                });
            }
        }

        $scope.files = [];
        //add file post
        $scope.addFile = function (files) {
            $scope.$apply(function () {
                for (var i = 0; i < files.length; i++) {
                    if (files[i].size > 10485760) {
                        alertify.error($rootScope.$lang.max_size);
                    } else {
                        if ($scope.files.length >= 20) {
                            alertify.error($rootScope.$lang.max_length);
                            return true;
                        } else {
                            $scope.files.push(files[i]);
                        }
                    }
                }
            });
        };
        //remove file post
        $scope.removeFile = function ($index) {
            if (typeof $scope.files[$index] !== 'undefined') {
                $scope.files.splice($index, 1);
            }
        };
                
        //load move - close employee
        $scope.limit = 5;
        $scope.loadMore = function () {
            $scope.limit = $scope.collection.invitations.departmentAndEmployee.employeeList.length;
        };
        $scope.closeMore = function () {
            $scope.limit = 5;
        };

        //edit project
        $scope.editEvent = function () {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/calendar/edit.html',
                controller: 'editEventCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
                resolve: {
                    data: function () {
                        return {
                            calendars: $scope.collection,
                        };
                    },
                    listCalendar: function ($q, calendarService) {
                        var deferred = $q.defer();
                        calendarService.listCalendars({}, function (respone) {
                            deferred.resolve(respone.objects);
                        });

                        return deferred.promise;
                    }
                }
            });
            modalInstance.result.then(function (data) {
                $scope.getInfoEvent();
                $scope.getLastEventPost();
            }, function () {
            });
        };

        //get event post
        $scope.getHtml = function (html) {
            return $sce.trustAsHtml(html);
        };

        $scope.filter = {
            itemPerPage: PER_PAGE_VIEW_MORE,
            totalItems: 0,
            offset: 0,
            eventId: eventId
        };

        $scope.eventPost = [];
        $scope.eventPostFile = [];
        $scope.getEventPosts = function () {
            EventPostService.getEventPosts($scope.filter, function (response) {
                if ($scope.eventPost.length > 0 && response.objects.collection) {
                    $scope.eventPost = $scope.eventPost.concat(response.objects.collection);
                } else {
                    $scope.eventPost = response.objects.collection;
                }

                if (_.size($scope.eventPostFile) > 0 && response.objects.files) {
                    $scope.eventPostFile = angular.merge($scope.eventPostFile, response.objects.files);
                } else {
                    $scope.eventPostFile = response.objects.files;
                }

                $scope.filter.totalItems = response.objects.totalItems;
            });
        };

        $scope.getEventPosts();
        //view more
        $scope.viewMore = function () {
            $scope.filter.offset = $scope.eventPost.length;
            $scope.getEventPosts();
        }

        $scope.getLastEventPost = function () {
            EventPostService.getLastEventPost({eventId: eventId}, function (response) {
                if ($scope.eventPost.length > 0 && response.objects.collection) {
                    $scope.eventPost = response.objects.collection.concat($scope.eventPost);
                } else {
                    $scope.eventPost = response.objects.collection;
                }

                if (_.size($scope.eventPostFile) > 0 && response.objects.files) {
                    $scope.eventPostFile = angular.merge($scope.eventPostFile, response.objects.files);
                } else {
                    $scope.eventPostFile = response.objects.files;
                }

                $scope.filter.totalItems = response.objects.totalItems;
            });
        }

        //Delete event post
        $scope.deleteEventPost = function (index, id) {
            dialogMessage.open('confirm', $rootScope.$lang.confirm_delete_file, function () {
                EventPostService.removeEventPost({eventId: id}, function (data) {
                    $scope.eventPost.splice(index, 1);
                    alertify.success($rootScope.$lang.remove_event_post_success);
                });
            });
        };

        //edit event post
        $scope.editEventPost = function (eventPost, $index) {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/eventPost/edit.html',
                controller: 'editEventPostCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
                resolve: {
                    eventPost: function () {
                        return eventPost;
                    }
                }
            });
        };

        //action click attend
        $scope.objectEmployee = {};
        $scope.attend = function (attend) {
            calendarService.attend({attend_type: attend, eventId: eventId}, function (response) {
                $scope.message = '';
                switch ($scope.collection.event.active_attend) {
                    case 'attend':
                        $scope.collection.attent.attend--;
                        break;
                    case 'maybe':
                        $scope.collection.attent.maybe--;
                        break;
                    case 'no_attend':
                        $scope.collection.attent.no_attend--;
                        break;
                }
                switch (attend) {
                    case 'attend':
                        $scope.collection.attent.attend++;
                        $scope.message = $rootScope.$lang.confirm_success;
                        break;
                    case 'maybe':
                        $scope.collection.attent.maybe++;
                        $scope.message = $rootScope.$lang.confirm_success;
                        break;
                    case 'no_attend':
                        $scope.collection.attent.no_attend++;
                        $scope.message = $rootScope.$lang.confirm_success;
                        break;
                }
                if ($scope.collection.event.active_attend == '') {
                    if ($scope.collection.checkAttentCountDown != true) {
                        $scope.collection.attent.no_confirm--;
                    }
                }
                alertify.success($scope.message);
                $scope.collection.event.active_attend = attend;
                $scope.employessnew = {};
                $scope.employessnew[employee_id] = employee_id;
                $scope.collection.attent.eventConfirmList = angular.merge($scope.collection.attent.eventConfirmList, $scope.employessnew);
            });
        }

        $scope.showAttend = function (eventPost, $index) {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/calendar/modalAttend.html',
                controller: 'showAttendCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
                resolve: {
                    eventPost: function () {
                        return eventPost;
                    },
                    eventId: function () {
                        return eventId;
                    }
                }
            });
        };

        //load move - close file
        $scope.limitFile = 5;
        $scope.loadMoreFile = function () {
            $scope.limitFile = $scope.collection.file_info.length;
        };

        $scope.closeMoreFile = function () {
            $scope.limitFile = 5;
        };

        //removeFile
        $scope.deleteFile = function (index, id) {
            dialogMessage.open('confirm', $rootScope.$lang.confirm_delete_file, function () {
                fileService.removeFile({fileId: id}, function (reponse) {
                    //Remove file in file list in description.
                    $scope.collection.file_info.splice(index, 1);
                    //Remove file in event post.
                    angular.forEach($scope.eventPostFile[reponse.objects.onwer_id], function(val, key){
                        //Traverse array of file in event post, and check the file we want to delete by name.
                        if (val.name == reponse.objects.name) {
                            $scope.eventPostFile[reponse.objects.onwer_id].splice(key, 1);
                        }
                    });
                    
                    //Get the last event post, to prepend to the first event post list.
                    $scope.getLastEventPost();
                    alertify.success($rootScope.$lang.remove_file_success);
                })
            });
        };
    }]);


//show attend 
appRoot.controller('showAttendCtrl', ['$scope', 'eventPost', 'eventId', 'calendarService', '$uibModalInstance',
    function ($scope, eventPost, eventId, calendarService, $uibModalInstance) {
        $scope.tabsName = eventPost;
        calendarService.viewAttend({eventId: eventId}, function (response) {
            $scope.attendList = response.objects;
        });

        $scope.tabs = function ($index) {
            $scope.tabsName = $index;
        }

        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    }]);

//edit event post
appRoot.controller('editEventPostCtrl', ['$scope', 'EventPostService', '$uibModalInstance', 'controllerService', 'actionService', '$rootScope', 'eventPost', 'alertify', 'dialogMessage', 'socketService',
    function ($scope, EventPostService, $uibModalInstance, controllerService, actionService, $rootScope, eventPost, alertify, dialogMessage, socketService) {
        $scope.eventpost = {
            id: eventPost.id,
            description: eventPost.content,
        };
        $scope.update = function () {
            if (EventPostService.validateEventPost($scope.eventpost)) {
                var params = {'id': eventPost.id, 'content': $scope.eventpost.description};
                EventPostService.updateEventPost(params, function (data) {
                    eventPost.content = $scope.eventpost.description;
                    alertify.success($rootScope.$lang.update_post_success);
                    $uibModalInstance.dismiss('save');
                });
            }
        };
        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    }]);

//edit event to calendar
appRoot.controller('editEventCtrl', ['$rootScope', 'data', 'listCalendar', '$scope', 'calendarService', 'alertify', '$uibModalInstance', 'departmentService', 'employeeService', '$timeout', 'socketService',
    function ($rootScope, data, listCalendar, $scope, calendarService, alertify, $uibModalInstance, departmentService, employeeService, $timeout, socketService) {
        //step
        $scope.step = 1;
        $scope.more = 0;
        $scope.open_start_datetime = false;
        $scope.open_end_datetime = false;
        $scope.files = [];
        $scope.colors = calendarService.colors();
        $scope.redminds = calendarService.redmind();
        $scope.people = [];
        $scope.departments = [];
        $scope.allDepartment = 0;
        $scope.calendars = listCalendar;
        departmentsData = [];
        membersData = [];
        if (data.calendars.invitations.department != null) {
            departmentsData = Object.keys(data.calendars.invitations.department);
        }
        if ((data.calendars.invitations.departmentAndEmployee != null) && (data.calendars.invitations.departmentAndEmployee.employeeEditList != null)) {
            membersData = data.calendars.invitations.departmentAndEmployee.employeeEditList;
        }
        
        $scope.event = {
            id: data.calendars.event.id,
            var_start_datetime: new Date(data.calendars.event.start_datetime + ' ' + data.calendars.event.start_time),
            var_start_time: data.calendars.event.start_time,
            var_end_datetime: new Date(data.calendars.event.end_datetime + ' ' + data.calendars.event.end_time),
            var_end_time: data.calendars.event.end_time,
            start_datetime: '',
            end_datetime: '',
            name: data.calendars.event.name,
            is_all_day: data.calendars.event.is_all_day,
            address: data.calendars.event.address,
            calendar_id: data.calendars.event.calendar_id,
            is_public: data.calendars.event.is_public,
            description: data.calendars.event.description,
            color: data.calendars.event.color,
            redmind: parseInt(data.calendars.remind),
            sms: 0,
            departments: departmentsData,
            members: membersData,
            data_old: data.calendars,
        }
        //add calendar 
        $scope.calendars = [];
        $scope.calendars.push({id: 0, name: '--', count: 0});
        for (i = 0; i < listCalendar.length; i++) {
            $scope.calendars.push(listCalendar[i]);
        }

        //refresh member
        $scope.selectMember = function ($item, $model) {

        };

        //add employee
        $scope.findEmployeeForCalendar = function (keyword) {
            employeeService.searchEmployee({keyword: keyword, departments: $scope.event.departments, members: $scope.event.members}, function (response) {
                $scope.employees = response.objects;
            });
        };

        //get all department
        departmentService.allDepartment({}, function (data) {
            $scope.departments = data.objects;
            $scope.event.departmentlist = data.objects;
        });

        //check all
        $scope.checkAll = function () {
            if ($scope.allDepartment) {
                $scope.event.departments = $scope.departments.map(function (item) {
                    return item.id;
                });
            } else {
                $scope.event.departments = [];
            }
            $scope.findEmployeeForCalendar('');
        };

      //check all
        $scope.redmindsDay = calendarService.redmindDay();
        $scope.checkAllDay = function () {
            $scope.event.redmind = 30;
        };
        
        //clickCheckAll
        $scope.clickCheckAll = function () {
            $timeout(function () {
                if ($scope.event.departments.length != $scope.departments.length) {
                    $scope.allDepartment = false;
                } else {
                    $scope.allDepartment = true;
                }
                $scope.findEmployeeForCalendar('');
            });

        };

        //add file
        $scope.addFile = function (files) {
            $scope.$apply(function () {
                for (var i = 0; i < files.length; i++) {
                    if (files[i].size > 10485760) {
                        alertify.error($rootScope.$lang.max_size);
                    } else {
                        if ($scope.files.length >= 20) {
                            alertify.error($rootScope.$lang.max_length);
                            return true;
                        } else {
                            $scope.files.push(files[i]);
                        }

                    }
                }
            });
        };

        //remove file
        $scope.removeFile = function ($index) {
            if (typeof $scope.files[$index] !== 'undefined') {
                $scope.files.splice($index, 1);
            }
        };

        //next
        $scope.next = function () {
            if ($scope.step < 3) {
                //check validate when go to step 2
                if ($scope.step == 1) {
                    if (calendarService.validate_step1($scope.event)) {
                        $scope.step++;
                    }
                } else {
                    if ($scope.step == 2) {
                      //check validate when go to step 3
                        var flg = false;
                        if ($scope.event.is_all_day) {
                            $scope.event.start_datetime = moment($scope.event.var_start_datetime).format('YYYY-MM-DD');
                            $scope.event.end_datetime = moment($scope.event.var_end_datetime).format('YYYY-MM-DD');
                            flg = true;
                        } else if (calendarService.validate_step2($scope.event)) {
                            $scope.event.start_datetime = moment($scope.event.var_start_datetime).format('YYYY-MM-DD HH:mm');
                            $scope.event.end_datetime = moment($scope.event.var_end_datetime).format('YYYY-MM-DD HH:mm');
                            flg = true;
                        }
                        if (flg) {
                            var fd = new FormData();
                            for (var i in $scope.files) {
                                fd.append("file_" + i, $scope.files[i]);
                            }
                            fd.append("event", angular.toJson($scope.event));
                            calendarService.editEvent(fd, function (response) {
                                alertify.success($rootScope.$lang.calendar_notify_event_created_success);
                                $uibModalInstance.close($scope.event);
                                socketService.emit('notify', 'ok');
                                $scope.step++;
                            });
                        }
                    } else {
                        $scope.step++;
                    }
                }
            }
        };
        //back
        $scope.back = function () {
            if ($scope.step == 2) {
                $scope.step--;
            }
        };

        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };

        //show more
        $scope.showMore = function (value) {
            $scope.more = value;
        }

        $scope.tinymceOptions = {
            inline: false,
            toolbar: 'formatselect | bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | undo redo ',
            menubar: false,
            skin: 'lightgray',
            theme: 'modern'
        };

        $scope.buttonBar = {
            show: true,
            now: {
                show: false,
                text: 'Now!'
            },
            today: {
                show: true,
                text: $rootScope.$lang.datepicker_today
            },
            clear: {
                show: true,
                text: $rootScope.$lang.datepicker_clear
            },
            date: {
                show: true,
                text: 'Date'
            },
            time: {
                show: true,
                text: 'Time'
            },
            close: {
                show: true,
                text: $rootScope.$lang.datepicker_close
            }

        };
        // time picker
        $scope.timepickerOptions = {
            readonlyInput: false,
            showMeridian: false
        }
    }]);
