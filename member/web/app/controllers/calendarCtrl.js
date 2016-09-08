//show calendar
appRoot.controller('calendarCtrl', ['$scope', '$uibModal', 'calendarService', '$timeout', 'settingSystem', 'uiCalendarConfig', 'listCalendar', '$rootScope', function ($scope, $uibModal, calendarService, $timeout, settingSystem, uiCalendarConfig, listCalendar, $rootScope) {
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
                    }, function () {});
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
                    var newEvent = {
                        title: respone.objects[$i].title,
                        start: moment(respone.objects[$i].start).toDate(),
                        end: moment(respone.objects[$i].end).toDate(),
                        color: respone.objects[$i].color,
                        url: '#/viewCalendar/' + respone.objects[$i].id
                    };
                    $scope.events.push(newEvent);
                }

            });
        }
    }]);

//add event to calendar

appRoot.controller('addEventCtrl', ['$rootScope', 'data', '$scope', 'calendarService', 'alertify', '$uibModalInstance', 'departmentService', 'employeeService', '$timeout', 'socketService',function ($rootScope, data, $scope, calendarService, alertify, $uibModalInstance, departmentService, employeeService, $timeout, socketService) {
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
        $scope.timepickerOptions =  {
                readonlyInput: false,
                showMeridian: false
            }

    }]);


//Display info detail of calendar
var $dataEditEvent = [];
appRoot.controller('viewCalendarCtrl', ['$scope', 'calendarService', 'fileService', 'EventPostService', '$uibModal', '$rootScope', 'dialogMessage', '$routeParams', 'alertify', '$sce', 'PER_PAGE_VIEW_MORE', 
    function ($scope, calendarService, fileService, EventPostService, $uibModal, $rootScope, dialogMessage, $routeParams, alertify, $sce, PER_PAGE_VIEW_MORE) {
    var calendarId = $routeParams.calendarId;
    //set paramter for layout
    $scope.collection = [];
    $scope.getInfoEvent = function () {
        calendarService.viewEvent({calendarId: calendarId}, function (response) {
            if (response.error) $location.path('/calendar');
            $scope.collection = response.objects;
        });
    };
    $scope.getInfoEvent();
    
    //function add event post
    $scope.project = {
            description: '',
            calendarId : calendarId,
        };
    $scope.addEventPost = function () {
        if(($scope.collection.invitations != null) && ($scope.collection.invitations.departmentAndEmployee != null) && ($scope.collection.invitations.departmentAndEmployee.employeeList != null) ){
            $scope.project.employeeList = $scope.collection.invitations.departmentAndEmployee.employeeList;
        }
        if (EventPostService.validateEventPost($scope.project)) {
            var fd = new FormData();
            for (var i in $scope.files) {
                fd.append("file_" + i, $scope.files[i]);
            }
            fd.append("event", angular.toJson($scope.project));
            EventPostService.addEventPost(fd, function (response) {
                alertify.success($rootScope.$lang.event_post_add_success);
                $scope.project = {
                    description: '',
                    calendarId: calendarId,
                };
                $scope.files = [];
                $scope.getEventPosts();
                $scope.release  = response.objects.files;
                $scope.releases = $scope.collection.file_info;
                $scope.collection.file_info = $scope.release.concat($scope.releases);
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
                listCalendar : function($q, calendarService){
                    var deferred = $q.defer();
                    calendarService.listCalendars({},function(respone){
                        deferred.resolve(respone.objects);
                    });
                    
                    return deferred.promise;
                }
            }
        });
        modalInstance.result.then(function (data) {
            $scope.getInfoEvent();
            $scope.getEventPosts();
        }, function () {});
    };
    
    //get event post
    $scope.getHtml = function (html) {
        return $sce.trustAsHtml(html);
    };
    $scope.filter = {
        itemPerPage: PER_PAGE_VIEW_MORE,
        totalItems: 0,
        currentPage: 1,
        eventId: calendarId
    };
    
    $scope.eventPost = [];
    $scope.eventPostFile = [];
    $scope.getEventPosts = function () {
        EventPostService.getEventPosts($scope.filter, function (response) {
            $scope.release  = response.objects.collection;
            $scope.releases = $scope.eventPost;
            $scope.eventPost = $scope.releases.concat($scope.release);
            $scope.eventPostFile = response.objects.files;
            $scope.filter.totalItems = response.objects.totalItems;
        });
    };
    
    $scope.getEventPosts();
  //Delete event post
    $scope.deleteEventPost = function (index, id) {
         dialogMessage.open('confirm', $rootScope.$lang.confirm_delete_file, function () {
             EventPostService.removeEventPost({calendarId: id}, function (data) {
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
    
    //view more
    $scope.viewMore = function () {
        $scope.filter.currentPage++;
        $scope.getEventPosts();
    }
    
    //action click attend
    $scope.objectEmployee = {};
    $scope.attend = function (attend) {
        calendarService.attend({attend_type: attend, calendarId: calendarId}, function (response) {
            $scope.message = '';
            switch($scope.collection.event.active_attend) {
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
            switch(attend) {
                case 'attend':
                    $scope.collection.attent.attend++;
                    $scope.message = $rootScope.$lang.update_attend_success;
                    break;
                case 'maybe':
                    $scope.collection.attent.maybe++;
                    $scope.message = $rootScope.$lang.update_maybe_success;
                    break;
                case 'no_attend':
                    $scope.collection.attent.no_attend++;
                    $scope.message = $rootScope.$lang.update_no_attend_success;
                    break;
                }
            if ($scope.collection.event.active_attend == '') {
                $scope.collection.attent.no_confirm--;
            }
            alertify.success($scope.message);
            $scope.collection.event.active_attend = attend;
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
                calendarId : function(){
                    return calendarId;
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
    $scope.removeFileProject = function (index, id) {
        dialogMessage.open('confirm', $rootScope.$lang.confirm_delete_file, function () {
            fileService.removeFile({fileId: id}, function (data) {
                $scope.collection.file_info.splice(index, 1);
                alertify.success($rootScope.$lang.remove_file_success);
            })
        });
    };
}]);


//show attend 
appRoot.controller('showAttendCtrl', ['$scope', 'eventPost', 'calendarId', 'calendarService', '$uibModalInstance',
    function ($scope, eventPost, calendarId, calendarService, $uibModalInstance) {
    $scope.tabsName = eventPost;
    calendarService.viewAttend({calendarId: calendarId}, function (response) {
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
              alertify.success($rootScope.$lang.project_post_update_success);
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
appRoot.controller('editEventCtrl', ['$rootScope', 'data', 'listCalendar', '$scope', 'calendarService', 'alertify', '$uibModalInstance', 'departmentService', 'employeeService', '$timeout', 'socketService',function ($rootScope, data, listCalendar,$scope, calendarService, alertify, $uibModalInstance, departmentService, employeeService, $timeout, socketService) {
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
        var departmentsData = membersData = [];
        if(data.calendars.invitations.department != null) {
            departmentsData = Object.keys(data.calendars.invitations.department);
        }
        if((data.calendars.invitations.departmentAndEmployee != null) && (data.calendars.invitations.departmentAndEmployee.employeeEditList != null)) {
            membersData = data.calendars.invitations.departmentAndEmployee.employeeEditList;
        }
        $scope.event = {
            id: data.calendars.event.id,
            var_start_datetime: data.calendars.event.start_datetime,
            var_start_time: data.calendars.event.start_time,
            var_end_datetime: data.calendars.event.end_datetime,
            var_end_time: data.calendars.event.end_time,
            start_datetime: '',
            end_datetime: '',
            name: data.calendars.event.name,
            address: data.calendars.event.address,
            calendar_id: data.calendars.event.calendar_id,
            is_public: data.calendars.event.is_public,
            description: data.calendars.event.description,
            color: data.calendars.event.color,
            redmind: parseInt(data.calendars.remind),
            sms: 0,
            departments: departmentsData,
            members:  membersData,
            data_old : data.calendars,
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
            $scope.event.departmentlist =  data.objects;
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
        $scope.timepickerOptions =  {
                readonlyInput: false,
                showMeridian: false
            }
    }]);
