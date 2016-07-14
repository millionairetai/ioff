//list auhthorities
appRoot.controller('AuthorityCtrl', ['$scope', '$uibModal', 'authorityService', '$rootScope', 'alertify',
    function ($scope, $uibModal, authorityService, $rootScope, alertify) {
        $scope.params = {
            page : 1,
            limit: 20,
            authorityName: '',
            orderBy: '',
            orderType: ''
        };

        $scope.totalItems = 0;
        $scope.authorities = [];
        $scope.maxPageSize = 15;
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
                        limit: 20,
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
                editable: false,
                selectable: true,
                eventLimit: 4,
                timezone: "local",
                lang: settingSystem.language,
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
                        
                        /*var newEvent = {
                            title: data.name,
                            start: data.start_datetime,
                            end: data.end_datetime,
                            color: "#" + data.color
                        };

                        $scope.events.push(newEvent);
                        for (i = 0; i < $scope.calendars.length; i++) {
                            if ($scope.calendars[i].id == data.calendar_id) {
                                $scope.calendars[i].count += 1;
                            }
                        }*/
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
                    left: 'month  agendaWeek agendaDay',
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
                        color: respone.objects[$i].color
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
appRoot.controller('projectCtrl', ['$scope', 'projectService', '$uibModal','$rootScope','socketService', function ($scope, projectService, $uibModal,$rootScope,socketService) {
         
        //get all project
        $scope.filter = {
            itemPerPage : 10,
            totalItems : 0,
            currentPage : 1
        };
        $scope.collection = [];
        $scope.getList = function(){
            projectService.listProject($scope.filter, function (response) {
                $scope.collection = response.objects.collection;
                $scope.filter.totalItems = response.objects.totalItems;
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
appRoot.controller('addProjectCtrl', ['socketService','$scope', 'projectService', '$location', '$uibModalInstance', '$rootScope', 'departmentService','alertify','$timeout','employeeService', function (socketService,$scope, projectService, $location, $uibModalInstance, $rootScope, departmentService,alertify,$timeout,employeeService) {
        
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
        $scope.findEmployee = function(keyword){
            employeeService.searchEmployee({keyword:keyword,members:$scope.project.members},function(response){
                $scope.people = response.objects;
            });
        };
        
        //add employee
        $scope.findEmployeeForProject = function(keyword){
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
        projectService.listStatus({}, function (data) {
            $scope.status = data.objects;
            if($scope.status.length > 0){
                $scope.project.status_id = $scope.status[0].id;
            }
        });   
        
        //listPriority
        projectService.listPriority({}, function (data) {
            $scope.priorities = data.objects;
            if($scope.priorities.length > 0){
                $scope.project.priority_id = $scope.priorities[0].id;
            }
        });
        
        //get all department
        departmentService.allDepartment({}, function (data) {
            $scope.departments = data.objects;
        });
        
        //check all
        $scope.checkAll = function () {
            if($scope.allDepartment){
                $scope.project.departments = $scope.departments.map(function (item) {
                    return item.id;
                });
            }else{
                $scope.project.departments = [];
            }
            $scope.findEmployeeForProject('');
        };
        
        //clickCheckAll
        $scope.clickCheckAll = function(){
            $timeout(function(){
                if($scope.project.departments.length != $scope.departments.length){
                    $scope.allDepartment = false;
                }else{
                    $scope.allDepartment = true;
                }
                $scope.findEmployeeForProject('');
            });
            
        };

        //clear manager
        $scope.clearManager = function(){
            $scope.project.manager = null;
        }

        //add file
        $scope.addFile = function (files) {
            $scope.$apply(function () {
                for (var i = 0; i < files.length; i++) {
                    if(files[i].size > 10485760){
                        alertify.error($rootScope.$lang.max_size);
                    }else{
                        if($scope.files.length >=20){
                            alertify.error($rootScope.$lang.max_length);
                            return true;
                        }else{
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

    }]);


