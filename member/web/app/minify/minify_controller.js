//list auhthorities
appRoot.controller('AuthorityCtrl', ['$scope', '$uibModal', 'authorityService', '$rootScope', 'alertify', 'PER_PAGE', 'MAX_PAGE_SIZE', 
    function ($scope, $uibModal, authorityService, $rootScope, alertify, PER_PAGE, MAX_PAGE_SIZE) {
        $scope.params = {
            page : 1,
            limit: PER_PAGE,
            authorityName: '',
            orderBy: '',
            orderType: ''
        };

        $scope.totalItems = 0;
        $scope.authorities = [];
        $scope.maxPageSize = MAX_PAGE_SIZE;
        $scope.add = function (authority, $index) {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/authority/add.html',
                controller: 'AddAuthorityCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
                resolve: {
                    authority: function () {
                        return authority;
                    }
                }
            });
            
            modalInstance.result.then(function (data) {
                if (authority && data != 'delete') {//if editing
                    $scope.authorities[$index] = data;
                } else {//if creating or deleting
                    $scope.params = {
                        page :  1,
                        limit: PER_PAGE,
                        authorityName: '',
                        orderBy: 'lastup_datetime',
                        orderType: 'DESC'
                    };
                    
                    $scope.params.page = 1;
                    $scope.params.authorityName = '';
                    $scope.findAll();
                }
            });
        };

        $scope.findAll = function () {
            authorityService.findAll($scope.params, function (res) {
                $scope.authorities = res.objects.authorities;
                $scope.totalItems  = res.objects.totalItems;
                
                if (!$scope.$$phase) {
                    $scope.$apply();
                }
            });
        };

        $scope.search = function () {
            $scope.params.page = 1;
            $scope.findAll();
        };

        $scope.sortBy = function (orderBy, orderType) {
            $scope.params.orderBy   = orderBy;
            $scope.params.orderType = orderType;
            $scope.findAll();
        };

        $scope.findAll();
    }]);

/*************************************** ADD AUTHORITY CONTROLLER ********************************************/
appRoot.controller('AddAuthorityCtrl', ['$scope', '$uibModalInstance', 'controllerService', 'actionService', 'authorityService', '$rootScope', 'authority', 'alertify', 'dialogMessage',
    function ($scope, $uibModalInstance, controllerService, actionService, authorityService, $rootScope, authority, alertify, dialogMessage) {
        $scope.cancel = function () {
            $uibModalInstance.dismiss();
        };
        
        $scope.controllers = [];
        $scope.actions = [];
        var controllerNames = {};
        var actions = {};
        $scope.authorityName = '';
        $scope.authority = '';
        
        if (authority) {
            $scope.authorityName = authority.name;
            $scope.authority = authority;
        }

        controllerService.findAll(function (res) {
            for (var i in res.objects) {
                controllerNames[res.objects[i]['id']] = res.objects[i]['name'];
            }
            
            $scope.controllers = controllerNames;
        });
        
        actionService.findAll(function (res) {
            if (authority) {//edit
                authorityService.findAllAssignments({authorityId: authority.id}, function (data) {
                    var selectedAssignment = [];
                    for (var i in data.objects) {
                        selectedAssignment.push(data.objects[i]['action_id']);
                    }
                    
                    for (var i in res.objects) {
                        if (!actions[res.objects[i]['controller_id']]) {
                            actions[res.objects[i]['controller_id']] = {
                                isChecked: true,
                                actions: []
                            };
                        }

                        res.objects[i]['isChecked'] = true;
                        //check if user selected this authority
                        if (selectedAssignment.indexOf(res.objects[i].id) === -1) {
                            actions[res.objects[i]['controller_id']].isChecked = false;
                            res.objects[i]['isChecked'] = false;
                        }
                        
                        actions[res.objects[i]['controller_id']].actions.push(res.objects[i]);
                    }
                    
                    $scope.actions = actions;
                });
            } else {
                for (var i in res.objects) {
                    if (!actions[res.objects[i]['controller_id']]) {
                        actions[res.objects[i]['controller_id']] = {
                            isChecked: false,
                            actions: []
                        };
                    }
                    
                    res.objects[i]['isChecked'] = false;
                    actions[res.objects[i]['controller_id']].actions.push(res.objects[i]);
                }
                
                $scope.actions = actions;
            }
        });

        $scope.selectController = function (controllerId) {
            var isChecked = $scope.actions[controllerId].isChecked;
            if ($scope.actions[controllerId].actions.length) {
                for (var i in $scope.actions[controllerId].actions) {
                    $scope.actions[controllerId].actions[i].isChecked = isChecked;
                }
            }
        };

        $scope.selectAction = function (controllerId, actionIndex) {
            var isChecked = $scope.actions[controllerId].actions[actionIndex].isChecked;
            if (!isChecked) {
                $scope.actions[controllerId].isChecked = false;
            } else {
                $scope.actions[controllerId].isChecked = true;
                if ($scope.actions[controllerId].actions.length) {
                    for (var i in $scope.actions[controllerId].actions) {
                        if (!$scope.actions[controllerId].actions[i].isChecked) {
                            $scope.actions[controllerId].isChecked = false;
                            break;
                        }
                    }
                }
            }
        };
        
        $scope.errors = {};
        $scope.saveAuthority = function () {
            $scope.errors = {};
            //user need to select at least one functionality
            var hasError = true;
            for (var i in $scope.actions) {
                for (var j in $scope.actions[i].actions) {
                    if ($scope.actions[i].actions[j].isChecked) {
                        hasError = false;
                        break;
                    }
                }
                
                if (!hasError) {
                    break;
                }
            }
            
            if (hasError) {
                $scope.errors['action'] = $rootScope.$lang.please_select_action;
            }

            if (!$scope.authorityName) {
                $scope.errors['authorityName'] = $rootScope.$lang.please_enter_authority_name;
                hasError = true;
            } else {
                if ($scope.authorityName.length > 255) {
                    $scope.errors['authorityName'] = $rootScope.$lang.authority_name_max_length;
                    hasError = true;
                }
            }

            if (!hasError) {
                var params = {authorityName: $scope.authorityName, actions: $scope.actions};
                if (authority) {
                    params['authorityId'] = authority.id;
                    authorityService.edit(params, function (data) {
                        $scope.errors = {};
                        alertify.success($rootScope.$lang.authority_edited_success);
                        $uibModalInstance.close(data.objects);
                    }, function (data) {
                    });
                } else {
                    authorityService.add(params, function (data) {
                        $scope.errors = {};
                        alertify.success($rootScope.$lang.authority_added_success);
                        $uibModalInstance.close(data.objects);
                    }, function (data) {
                        alertify.error(data.objects);
                    });
                }
            } else {
                var errorMes = '';
                for (var i in $scope.errors) {
                    errorMes += $scope.errors[i] + '<br>';
                }
                alertify.error(errorMes);
            }
        };

        $scope.deleteAuthority = function () {
            dialogMessage.open('confirm', $rootScope.$lang.is_delete, function (data) {
                authorityService.delete({id: authority.id}, function () {
                    alertify.success($rootScope.$lang.authority_deleted_success);
                    $uibModalInstance.close('delete');
                }, function (data) {
                    if (data.message == 'is used') {
                        alertify.error($rootScope.$lang.authority_is_used);
                    }
                });
            });
        };
    }]);//show calendar
appRoot.controller('calendarCtrl', ['$scope', '$uibModal', 'calendarService', '$timeout', 'settingSystem', 'uiCalendarConfig', 'listCalendar', '$rootScope',
    function ($scope, $uibModal, calendarService, $timeout, settingSystem, uiCalendarConfig, listCalendar, $rootScope) {
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
                height: 'auto',
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

        $scope.resetEvents = function (start, end) {
            calendarService.listEvents({start: start.format('YYYY-MM-DD'), end: end.format('YYYY-MM-DD'), calendars: $scope.chooseCalendar}, function (respone) {
                $scope.events.length = 0;
                for ($i = 0; $i < respone.objects.length; $i++) {
                    allDay = respone.objects[$i].is_all_day == 1 ? true : false;
                    var newEvent = {
                        title: respone.objects[$i].title,
                        start: moment(respone.objects[$i].start).toDate(),
                        end: moment(respone.objects[$i].end).toDate(),
                        color: respone.objects[$i].color,
                        url: '#/viewEvent/' + respone.objects[$i].id,
                        allDay : allDay
                    };
                    $scope.events.push(newEvent);
                }

            });
        }
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
//        var calendarId = $routeParams.eventId;
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
        
        //download file post
        $scope.downloadFile = function (fileId) {
            window.open('calendar/download-file?fileId='+ fileId +'&eventId='+eventId);
//            calendarService.downloadFile({fileId:fileId,eventId: eventId}, function (response) {
//            });
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
        
        console.log(data.calendars.event.start_time);
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
// show dialog
appRoot.controller('dialogMessage', [ '$rootScope','$scope', '$uibModalInstance','data','$sce', function ( $rootScope,$scope, $uibModalInstance,data,$sce) {
        $scope.class_header = "dialog-header-error";
        $scope.show_save = false;
        $scope.title = $rootScope.$lang.title_error_dialog;
        if(data.type == 'confirm'){
            $scope.title = $rootScope.$lang.title_confirm_dialog;
            $scope.class_header = "dialog-header-wait";
            $scope.show_save = true;
        }
        //
        
        $scope.message = $sce.trustAsHtml(data.message);
        //
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
        //
        $scope.save = function () {
            $uibModalInstance.close('save');
        };
        
    }]);

//
appRoot.controller('homeCtrl', ['$scope','dialogMessage','alertify',function($scope,dialogMessage,alertify) {
    
    $scope.errorDialog = function(){
        alertify.success("Welcome to alertify!");
    };
    
    $scope.confirmDialog = function(){
        dialogMessage.open('confirm','message error',function(data){
            alert('12');
        });
    };
    
    
}]);


//list project
appRoot.controller('projectCtrl', ['$scope', 'projectService', '$uibModal','$rootScope','socketService', 'PER_PAGE_VIEW_MORE', 'alertify', 
    function ($scope, projectService, $uibModal, $rootScope, socketService, PER_PAGE_VIEW_MORE, alertify) {
         
        //get all project
        $scope.filter = {
            itemPerPage : PER_PAGE_VIEW_MORE,
            totalItems : 0,
            currentPage : 1
        };
        $scope.collection = [];
        $scope.getList = function(){
            projectService.listProject($scope.filter, function (response) {
                $scope.collection = response.objects.collection;
                $scope.filter.totalItems = response.objects.totalItems;
                if (response.objects.error) {
                	alertify.error(response.objects.error);
                }
            });
        };
        $scope.getList();
        
        //add project
        $scope.add = function () {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/project/add.html',
                controller: 'addProjectCtrl',
                size: 'lg',
                keyboard : true,
                backdrop: 'static',
            });
        };
        
        //view more
        $scope.viewMore = function(){
            $scope.filter.currentPage ++;
            $scope.getList();
        }
        
        
        //handle create project successful
        $rootScope.$on('create_project_success', function(event, data) { 
            $scope.getList();
        });
        
    }]);

//add project
appRoot.controller('addProjectCtrl', ['socketService','$scope', 'projectService', '$location', '$uibModalInstance', '$rootScope', 'departmentService','alertify','$timeout','employeeService', 'statusService', 'priorityService', 
    function (socketService, $scope, projectService, $location, $uibModalInstance, $rootScope, departmentService, alertify, $timeout, employeeService, statusService, priorityService) {      
        //step
        $scope.step = 1;
        $scope.more = 0;
        $scope.departments = [];
        $scope.allDepartment = 0;
        $scope.status = [];
        $scope.priorities = [];
        $scope.files = [];
        $scope.people = [];
        $scope.employees = [];
        $scope.open_start_datetime = false;
        $scope.open_end_datetime = false;
        
        $scope.project = {
            parent_id: 0,
            manager: null,
            name: '',
            start_datetime: '',
            duedatetime : '',
            priority_id: 3,
            completed_percent: 0,
            is_public: 0,
            status_id: 1,
            description: '',
            estimate_hour: 0,
            worked_hour: 0,
            sms : 0,
            departments: [],
            members : [],
            
        };

        //project manager
        $scope.findEmployee = function (keyword) {
            employeeService.searchEmployee({keyword: keyword, members: $scope.project.members}, function (response) {
                $scope.people = response.objects;
            });
        };
        
        //add employee
        $scope.findEmployeeForProject = function(keyword) {
            employeeService.searchEmployee({keyword:keyword,departments:$scope.project.departments,members:$scope.project.members,manager:$scope.project.manager},function(response){
                $scope.employees = response.objects;
            });
        };
        
        
        //refresh member
        $scope.selectManager = function($item, $model){
            $scope.findEmployeeForProject('');
        };
        
        //refresh manager
        $scope.selectMember = function($item, $model){
            $scope.findEmployee('');
        };
        
        
        //get list status
        statusService.getProjectStatus({}, function (data) {
            $scope.status = data.objects;
            if ($scope.status.length > 0) {
                $scope.project.status_id = $scope.status[0].id;
            }
        });   
        
        //listPriority
        priorityService.getProjectPriority({}, function (data) {
            $scope.priorities = data.objects;
            if ($scope.priorities.length > 0) {
                $scope.project.priority_id = $scope.priorities[0].id;
            }
        });
        
        //get all department
        departmentService.allDepartment({}, function (data) {
            $scope.departments = data.objects;
        });
        
        //check all
        $scope.checkAll = function () {
            if ($scope.allDepartment) {
                $scope.project.departments = $scope.departments.map(function (item) {
                    return item.id;
                });
            } else {
                $scope.project.departments = [];
            }
            $scope.findEmployeeForProject('');
        };
        
        //clickCheckAll
        $scope.clickCheckAll = function () {
            $timeout(function () {
                if ($scope.project.departments.length != $scope.departments.length) {
                    $scope.allDepartment = false;
                } else {
                    $scope.allDepartment = true;
                }
                $scope.findEmployeeForProject('');
            });
        };

        //clear manager
        $scope.clearManager = function () {
            $scope.project.manager = null;
        }

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
                if($scope.step == 1){
                    if(projectService.validate_step1($scope.project)){
                        $scope.step++;
                    }
                }else{
                    if($scope.step == 2){
                        //check validate when go to step 3
                        if(projectService.validate_step2($scope.project)){
                            var fd = new FormData();
                            for (var i in $scope.files) {
                                fd.append("file_"+i, $scope.files[i]);
                            }
                            fd.append("project", angular.toJson($scope.project));
                            projectService.addProject(fd,function(response){
                                alertify.success($rootScope.$lang.project_notify_success);
                                $rootScope.$emit('create_project_success', {message: 'hung'});
                                socketService.emit('notify', 'ok');
        
                                $scope.step++;
                            });
                            
                        }
                    }else{
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

    }]);

//Display info project
var $dataEditProject = [];
appRoot.controller('viewProjectCtrl', ['$scope', 'projectService', 'fileService', 'projectPostService', '$uibModal', '$rootScope', 'dialogMessage', '$routeParams', 'alertify', '$sce', 'PER_PAGE_VIEW_MORE', 
    function ($scope, projectService, fileService, projectPostService, $uibModal, $rootScope, dialogMessage, $routeParams, alertify, $sce, PER_PAGE_VIEW_MORE) {
        //get info project
        var projectId = $routeParams.projectId;
        $scope.collection = [];
        $scope.files = [];

        $scope.getInfoProject = function () {
            projectService.viewProject({projectId: projectId}, function (response) {
                $scope.collection = response.objects.collection;
                $dataEditProject = response.objects.collection;
                if (response.objects.collection.error) {
            		$location.path('/project');
            	}
            });
        };

        $scope.getInfoProject();

        //get all activity recode
        $scope.filter = {
            itemPerPage: PER_PAGE_VIEW_MORE,
            totalItems: 0,
            currentPage: 1,
            projectId: projectId
        };

        $scope.projectPost = [];
        $scope.projectPostFile = [];

        $scope.getProjectPosts = function () {
            projectPostService.getProjectPosts($scope.filter, function (response) {
                $scope.projectPost = response.objects.collection;
                $scope.projectPostFile = response.objects.files;
                $scope.filter.totalItems = response.objects.totalItems;
            });
        };

        $scope.getProjectPosts();

        $scope.project = {
            description: '',
            project_id: projectId,
        };
        $scope.files = [];

        //show code html
        $scope.getHtml = function (html) {
            return $sce.trustAsHtml(html);
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
        $scope.remove = function ($index) {
            if (typeof $scope.files[$index] !== 'undefined') {
                $scope.files.splice($index, 1);
            }
        };

        $scope.addProjectPost = function () {
            if (projectPostService.validateProjectPost($scope.project)) {
                var fd = new FormData();
                for (var i in $scope.files) {
                    fd.append("file_" + i, $scope.files[i]);
                }

                fd.append("project", angular.toJson($scope.project));

                projectPostService.addProjectPost(fd, function (response) {
                    alertify.success($rootScope.$lang.project_update_success);
                    $rootScope.$emit('add_project_post_success', {});
                    $scope.project = {
                        description: '',
                        project_id: projectId,
                    };
                    $scope.files = [];
                    $scope.release  = $scope.collection.file_info;
                    $scope.releases = response.objects.files;
                    $scope.releases = $scope.releases.concat($scope.release);
                    $scope.collection.file_info = $scope.releases;
                });
            }
        }

        //remove file project post
        $scope.removeFile = function ($index) {
            if (typeof $scope.files[$index] !== 'undefined') {
                $scope.files.splice($index, 1);
            }
        };

        //view more
        $scope.viewMore = function () {
            $scope.filter.currentPage++;
            projectPostService.getProjectPosts($scope.filter, function (response) {
                $scope.release  = response.objects.collection;
                $scope.releases = $scope.projectPost;
                $scope.projectPost = $scope.releases.concat($scope.release);
                $scope.projectPostFile = response.objects.files;
                $scope.filter.totalItems = response.objects.totalItems;
            });
        }

        //edit project
        $scope.edit = function () {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/project/edit.html',
                controller: 'editProjectCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
            });
        };

        //load move - close employee
        $scope.limit = 5;
        $scope.loadMore = function () {
            $scope.limit = $scope.collection.employee_info.length;
        };

        $scope.closeMore = function () {
            $scope.limit = 5;
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
        $scope.removeFileProject = function (index, id) {
            dialogMessage.open('confirm', $rootScope.$lang.confirm_delete_file, function () {
                fileService.removeFile({fileId: id}, function (data) {
                    $scope.collection.file_info.splice(index, 1);
                    alertify.success($rootScope.$lang.remove_file_success);
                })
            });
        };
       
        //Delete project post
        $scope.deleteProjectPost = function (index, id) {
             dialogMessage.open('confirm', $rootScope.$lang.confirm_delete_file, function () {
                projectPostService.removeProjectPost({ProjectPostId: id}, function (data) {
                    $scope.projectPost.splice(index, 1);
                    alertify.success($rootScope.$lang.remove_project_post_success);
                });
            });
        };
        
        //edit project
        $scope.editProjectPost = function (projectPost, $index) {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/projectPost/edit.html',
                controller: 'editProjectPostCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
                resolve: {
                	projectPost: function () {
                        return projectPost;
                    }
                }
            });
        };
        
       //handle create project post successful
        $rootScope.$on('add_project_post_success', function (event, data) {
        	$scope.filter = {
                    itemPerPage: PER_PAGE_VIEW_MORE,
                    totalItems: 0,
                    currentPage: 1,
                    projectId: projectId
                };
            $scope.getProjectPosts();
        });
        
        //handle create project successful
        $rootScope.$on('edit_project_success', function (event, data) {
        	$scope.getInfoProject();
        	$scope.getProjectPosts();
        	$scope.limit = 5;
        	$scope.limitFile = 5;
        });
        
        $scope.tinymceOptions = {
                inline: false,
                toolbar: 'formatselect | bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | undo redo ',
                menubar: false,
                skin: 'lightgray',
                theme: 'modern'
            };
    }]);

//edit project post
appRoot.controller('editProjectPostCtrl', ['$scope', 'projectPostService', '$uibModalInstance', 'controllerService', 'actionService', '$rootScope', 'projectPost', 'alertify', 'dialogMessage', 'socketService',
	function ($scope, projectPostService, $uibModalInstance, controllerService, actionService, $rootScope, projectPost, alertify, dialogMessage, socketService) {
            $scope.project = {
                id: projectPost.id,
            	description: projectPost.content,
            };
                                       		
            $scope.update = function () {
                if (projectPostService.validateProjectPost($scope.project)) {
                    var params = {'id': projectPost.id, 'content': $scope.project.description};
                    projectPostService.updateProjectPost(params, function (data) {
                    projectPost.content = $scope.project.description;
                    alertify.success($rootScope.$lang.project_post_update_success);
                	$uibModalInstance.dismiss('save');
            	});
        	}
        };
        //cancel
        $scope.cancel = function () {
        	$uibModalInstance.dismiss('cancel');
        };
                                       				
        //show more
        $scope.showMore = function (value) {
    	$scope.more = value;
    	
    	$scope.tinymceOptions = {
                inline: false,
                toolbar: 'formatselect | bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | undo redo ',
                menubar: false,
                skin: 'lightgray',
                theme: 'modern'
            };
	}
}]);

//edit project
appRoot.controller('editProjectCtrl', ['$scope', 'projectService', '$location', '$uibModalInstance', '$rootScope', 'departmentService', 'alertify', '$timeout', 'employeeService', '$filter', 'statusService', 'priorityService', 'socketService',  
                                       function ($scope, projectService, $location, $uibModalInstance, $rootScope, departmentService, alertify, $timeout, employeeService, $filter, statusService, priorityService, socketService) {
        //step
        $scope.step = 1;
        $scope.more = 0;
        $scope.departments = [];
        $scope.allDepartment = 0;
        $scope.status = [];
        $scope.priorities = [];
        $scope.files = [];
        $scope.people = [];
        $scope.employees = [];
        $scope.open_start_datetime = false;
        $scope.open_end_datetime = false;
        
        $scope.project = {
            project_id: $dataEditProject.project_info.project_id,
            parent_id: 0,
            manager: {id: $dataEditProject.project_info.manager_project_id, firstname: $dataEditProject.project_info.project_manager, image: $dataEditProject.project_info.image},
            name: $dataEditProject.project_info.project_name,
            start_datetime: new Date($dataEditProject.project_info.start_datetime),
            duedatetime: new Date($dataEditProject.project_info.duedatetime),
            priority_id: parseInt($dataEditProject.project_info.priority_id),
            completed_percent: $dataEditProject.project_info.completed_percent,
            is_public: $dataEditProject.project_info.is_public,
            status_id: parseInt($dataEditProject.project_info.status_id),
            description: $dataEditProject.project_info.description,
            estimate_hour: $dataEditProject.project_info.estimate_hour,
            worked_hour: 0,
            sms: 0,
            departments: [],
            members: $dataEditProject.participant_employee,
            employess_old: $dataEditProject.participant_employee,
            departments_old: $dataEditProject.department_info,
            projectInfo_old: $dataEditProject.project_info,
            default_department: Object.keys($dataEditProject.department_info)
        };

        $scope.removeChoice = function (index) {
        	$scope.project.members.splice(index, 1);
      	  	$scope.findEmployeeForProject('');
                $scope.findEmployee('');
        }
        
        //project manager
        $scope.findEmployee = function (keyword) {
            employeeService.searchEmployee({keyword: keyword, members: $scope.project.members}, function (response) {
                $scope.people = response.objects;
            });
        };

        //add employee
        $scope.findEmployeeForProject = function (keyword) {
            employeeService.searchEmployee({keyword: keyword, departments: $scope.project.default_department, members: $scope.project.members, manager: $scope.project.manager}, function (response) {
                $scope.employees = response.objects;
            });
        };

        //refresh member
        $scope.selectManager = function ($item, $model) {
            $scope.findEmployeeForProject('');
            $scope.findEmployee('');
        };

        //refresh manager
        $scope.selectMember = function ($item, $model) {
            $scope.findEmployeeForProject('');
            $scope.findEmployee('');
        };

        //get list status
        statusService.getProjectStatus({}, function (data) {
            $scope.status = data.objects;
        });

        //listPriority
        priorityService.getProjectPriority({}, function (data) {
            $scope.priorities = data.objects;
        });

        departmentService.allDepartment({}, function (data) {
            //get all department
            $scope.departments = data.objects;
        });

        //check all
        $scope.checkAll = function () {
            if ($scope.allDepartment) {
            	$scope.project.default_department = $scope.departments.map(function (item) {
                    return item.id;
                });
            } else {
                $scope.project.departments = [];
            }
            $scope.findEmployeeForProject('');
        };

        //clickCheckAll
        $scope.clickCheckAll = function () {
            $timeout(function () {
            	if ($scope.project.default_department.length != $scope.departments.length) {
                    $scope.allDepartment = false;
                } else {
                    $scope.allDepartment = true;
                }
                $scope.findEmployeeForProject('');
            });
        };

        //clear manager
        $scope.clearManager = function () {
            $scope.project.manager = null;
        }

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
                    if (projectService.validate_step1($scope.project)) {
                        $scope.step++;
                    }
                } else {
                    if ($scope.step == 2) {
                        //check validate when go to step 3
                        if (projectService.validate_step2($scope.project)) {
                            var fd = new FormData();
                            for (var i in $scope.files) {
                                fd.append("file_" + i, $scope.files[i]);
                            }
                            fd.append("project", angular.toJson($scope.project));
                            projectService.editProject(fd, function (response) {
                                alertify.success($rootScope.$lang.project_update_success);
                                $rootScope.$emit('edit_project_success', {message: 'hung'});
                                $scope.step++;
                                socketService.emit('notify', 'ok');
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

    }]);
