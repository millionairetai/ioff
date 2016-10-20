appRoot.controller('taskCtrl', ['$scope', 'taskService', '$uibModal', '$rootScope', 'PER_PAGE', 'MAX_PAGE_SIZE',
    function ($scope, taskService, $uibModal, $rootScope, PER_PAGE, MAX_PAGE_SIZE) {
        $scope.params = {
            page: 1,
            limit: 5,
            searchText: '',
            orderBy: '',
            orderType: ''
        };

        $scope.task = {
            search: {
                follow: '',
                assigned: '',
                all: ''
            },
            page: {
                follow: 1,
                assigned: 1,
                all: 1
            }
        };

        //array store task collection response from server
        $scope.collection = {
            assigned: [],
            follow: [],
            all: []
        };

        $scope.totalItems = {
            assigned: 0,
            follow: 0,
            all: 0
        };
        $scope.maxPageSize = MAX_PAGE_SIZE;

        //get list with pagination
        $scope.getList = function (type, $event) {
            if ($event != '') {
                $event.preventDefault();
            }

            //check if this tab is checked, we don't get ajax again.
            if ($($event.target).parent().hasClass('active')) {
                return true;
            }

            switch (type) {
                case 'my_task':
                    {
                        $scope.params.searchText = $scope.task.search.assigned;
                        $scope.params.page = $scope.task.page.assigned;
                        taskService.getMyTasks($scope.params, function (response) {
                            $scope.collection.assigned = response.objects.collection;
                            $scope.totalItems.assigned = response.objects.totalItems;
                        });
                    }
                    break;
                case 'follow_task':
                    {
                        $scope.params.searchText = $scope.task.search.follow;
                        $scope.params.page = $scope.task.page.follow;
                        taskService.getFollowTasks($scope.params, function (response) {
                            $scope.collection.follow = response.objects.collection;
                            $scope.totalItems.follow = response.objects.totalItems;
                        });
                    }
                    break;
                case 'all_task':
                    {
                        $scope.params.searchText = $scope.task.search.all;
                        $scope.params.page = $scope.task.page.all;
                        taskService.getTasks($scope.params, function (response) {
                            $scope.collection.all = response.objects.collection;
                            $scope.totalItems.all = response.objects.totalItems;
                        });
                    }
                    break;
            }
        };

        $scope._resetParams = function () {
            $scope.params = {
                page: 1,
                limit: 5,
                searchText: '',
                orderBy: '',
                orderType: ''
            };
        };

        //initial task list
        $scope.getList('my_task', '');

        //search by task name
        $scope.searchByName = function (type) {
            $scope.getList(type, '');
        };

        //call popup add task
        $scope.add = function () {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/task/add.html',
                controller: 'addTaskCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
            });
        };

        //when add task successfully
        $rootScope.$on('create_task_success', function (event, data) {
            $scope.getList('my_task', '');
        });
    }]);

/*add Task Popup Controller*/
appRoot.controller('addTaskCtrl', ['socketService', '$scope', 'taskService', '$location', '$uibModalInstance', '$rootScope', 'departmentService', 'alertify', '$timeout', 'employeeService', 'projectService', '$cacheFactory', 'commonService', 'taskGroupService',
    function (socketService, $scope, taskService, $location, $uibModalInstance, $rootScope, departmentService, alertify, $timeout, employeeService, projectService, $cacheFactory, commonService, taskGroupService) {
        //init
        $scope.step = 1;
        $scope.more = 0;
        $scope.projects = [];
        $scope.projectId = [];
        $scope.priorities = [];
        $scope.statuses = [];
        $scope.employees = [];
        $scope.searchedEmployees = [];
        $scope.files = [];
        $scope.taskGroups = [];
        $scope.parentTasks = [];
        $scope.redminds = commonService.redmind();

        //task object init
        $scope.task = {
            name: '',
            project_id: 0,
            duedatetime: '',
            priority_id: 3,
            completed_percent: 0,
            description: '',
            estimate_hour: 0,
            worked_hour: 0,
            parent_id: 0,
            status_id: 1,
            assigningEmployees: [],
            followingEmployees: [],
            is_public: 0,
            taskGroupIds: [],
            sms: 0
        };

        /*Helpers*/
        $scope.vietnammesePreProc = function (str) {
            str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
            str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
            str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
            str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
            str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
            str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
            str = str.replace(/đ/g, "d");

            return str;
        }

        //employees
        $scope.findEmployeeForTask = function (keyword) {
            $scope.searchedEmployees = [];

            if (keyword == '') {
                $scope.searchedEmployees = $scope.employees;
            } else {
                var searchedIdx = [];
                var preProcStr = '';
                var preProcKeyword = '';
                preProcKeyword = keyword.toLowerCase();

                if ($rootScope.$lang.language == 'vi') {
                    preProcKeyword = $scope.vietnammesePreProc(preProcKeyword);
                }

                //begin with keyword                
                for (i = 0; i < $scope.employees.length; i++) {
                    preProcStr = $scope.employees[i].firstname.toLowerCase();
                    if ($rootScope.$lang.language == 'vi') {
                        preProcStr = $scope.vietnammesePreProc(preProcStr);
                    }

                    if (preProcStr.indexOf(preProcKeyword) === 0) {
                        $scope.searchedEmployees.push($scope.employees[i]);
                        searchedIdx.push(i);
                    }
                }

                //contains keyword
                for (i = 0; i < $scope.employees.length; i++) {
                    preProcStr = $scope.employees[i].firstname.toLowerCase();
                    if ($rootScope.$lang.language == 'vi') {
                        preProcStr = $scope.vietnammesePreProc(preProcStr);
                    }

                    if (searchedIdx.indexOf(i) === -1 && preProcStr.indexOf(preProcKeyword) > 0) {
                        $scope.searchedEmployees.push($scope.employees[i]);
                    }
                }
            }
        };

        $scope.filterFollowingEmployees = function (person) {
            for (i = 0; i < $scope.task.followingEmployees.length; i++) {
                if (person.email == $scope.task.followingEmployees[i].email) {
                    return false;
                }
            }

            return true;
        };

        $scope.filterAssigningEmployees = function (person) {
            for (i = 0; i < $scope.task.assigningEmployees.length; i++) {
                if (person.email == $scope.task.assigningEmployees[i].email) {
                    return false;
                }
            }

            return true;
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

        $scope.taskGroupTagTransform = function (newTag) {
            var item = {
                name: $rootScope.$lang.task_group + newTag,
            };

            return item;
        };

        $scope.updateAfterProjectChanged = function () {
            var $httpDefaultCache = $cacheFactory.get('$http');
            $httpDefaultCache.removeAll();
            $scope.task.parent_id = 0;
            $scope.task.taskGroupIds = 0;
            $scope.task.assigningEmployees = [];
            $scope.task.followingEmployees = [];

            //status
            taskService.getParentTasks({project_id: $scope.task.project_id}, function (data) {
                $scope.parentTasks = data.objects.collection;
            });

            taskGroupService.getTaskGroups({project_id: $scope.task.project_id}, function (data) {
                $scope.taskGroups = data.objects.collection;
            });

            employeeService.searchEmployeeByProjectIdAndKeyword({keyword: '', project_id: $scope.task.project_id}, function (response) {
                $scope.employees = response.objects.collection;
            });

        };

        $scope.checkProject = function () {
            if ($scope.task.project_id === 0 || $scope.task.project_id === undefined) {
                alertify.error($rootScope.$lang.task_project_empty);
            }
        }
        /*Call services*/
        //project 
        projectService.getProjects({}, function (data) {
            $scope.projects = data.objects.collection;
        });

        //priority
        taskService.getPriorityList({}, function (data) {
            $scope.priorities = data.objects.collection;
            if ($scope.priorities.length > 0) {
                $scope.task.priority_id = $scope.priorities[0].id;
            }
        });

        //status
        taskService.getStatusList({}, function (data) {
            $scope.statuses = data.objects.collection;

            if ($scope.statuses.length > 0) {
                $scope.task.status_id = $scope.statuses[0].id;
            }
        });

        //next
        $scope.next = function () {
            if ($scope.step < 3) {
                //check validate when go to step 2
                if ($scope.step == 1) {
                    if (taskService.validate_step1($scope.task)) {
                        $scope.step++;
                    }
                } else {
                    if ($scope.step == 2) {
                        //check validate when go to step 3
                        if (taskService.validate_step2($scope.task)) {
                            var fd = new FormData();
                            for (var i in $scope.files) {
                                fd.append("file_" + i, $scope.files[i]);
                            }
                            fd.append("task", angular.toJson($scope.task));
                            taskService.addTask(fd, function (response) {
                                alertify.success($rootScope.$lang.task_notify_success);
                                $rootScope.$emit('create_task_success', {message: 'danh'});
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
    }]);