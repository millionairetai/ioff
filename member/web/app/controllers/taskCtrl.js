appRoot.controller('taskCtrl', ['$scope', 'taskService', '$uibModal', '$rootScope', 'PER_PAGE', 'MAX_PAGE_SIZE', 'flash',
    function ($scope, taskService, $uibModal, $rootScope, PER_PAGE, MAX_PAGE_SIZE, flash) {
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
        
        //alert authority
        flash.trigger();
    }]);

/*add Task Popup Controller*/
appRoot.controller('addTaskCtrl', ['socketService', '$scope', 'taskService', '$location', '$uibModalInstance', '$rootScope', 'departmentService', 'alertify', '$timeout', 'employeeService', 'projectService', '$cacheFactory', 'commonService', 'taskGroupService', 'priorityService', 'statusService',
    function (socketService, $scope, taskService, $location, $uibModalInstance, $rootScope, departmentService, alertify, $timeout, employeeService, projectService, $cacheFactory, commonService, taskGroupService, priorityService, statusService) {
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
                    preProcStr = $scope.employees[i].fullname.toLowerCase();
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
                    preProcStr = $scope.employees[i].fullname.toLowerCase();
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
        priorityService.getTaskPriority({}, function (data) {
            $scope.priorities = data.objects;
            if ($scope.priorities.length > 0) {
                $scope.task.priority_id = $scope.priorities[0].id;
            }
        });

        //status
        statusService.getTaskStatus({}, function (data) {
            $scope.statuses = data.objects;

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


/*View Task Controller*/
var static_postnew = false;
appRoot.controller('viewTaskCtrl', ['socketService','$sce', 'fileService', '$scope', 'taskService', 'TaskPostService', '$location', '$rootScope', 'departmentService', 'alertify', '$timeout', 'employeeService', 'projectService', '$cacheFactory', '$routeParams', 'dialogMessage', '$uibModal', 'PER_PAGE_VIEW_MORE', 'flash',
    function (socketService, $sce, fileService, $scope, taskService, TaskPostService, $location,  $rootScope, departmentService, alertify, $timeout, employeeService, projectService, $cacheFactory, $routeParams, dialogMessage, $uibModal, PER_PAGE_VIEW_MORE, flash) {
  
    //get info Task
    var taskId = $routeParams.taskId;
    $scope.collection = [];
    $scope.files = [];
    $scope.isOpenCommentForm = true;
    
    $scope.ToggleCommentForm = function() {
        $scope.isOpenCommentForm = $scope.isOpenCommentForm == true ? false : true;
    }
    $scope.getInfoTask = function () {
        taskService.getTaskView({taskId: taskId}, function (response) {
                if (response.objects.no_data == true) {
                    flash.setNoDataMessage();
                    $location.path('/task');
                }
                
                if (response.objects.no_authority == true) {
                    flash.setNoAuthItemMessage();
                    $location.path('/task');
                }
                
                $scope.collection = response.objects;
                //initialize value for completed percent of input task post
                $scope.taskPostData.completed_percent = response.objects.task.completed_percent;
            }, function (response) {
                if (response.objects.no_data == true) {
                    $location.path('/task');
                }
        });
    };
    $scope.getInfoTask();

    //load move - close file
    $scope.limitFile = 5;
    $scope.loadMoreFile = function () {
        $scope.limitFile = $scope.collection.file_info.length;
    };
    $scope.closeMoreFile = function () {
        $scope.limitFile = 5;
    };

    //load move - close childe task
    $scope.limitChildren = 5;
    $scope.loadMoreChildren = function () {
        $scope.limitChildren = $scope.collection.childrenList.length;
    };
    $scope.closeMoreChildren = function () {
        $scope.limitChildren = 5;
    };

    //load move - close followers collection.followers
    $scope.limitFollowers = 5;
    $scope.loadMoreFollowers = function () {
        $scope.limitFollowers = $scope.collection.followers.length;
    };
    $scope.closeMoreFollowers = function () {
        $scope.limitFollowers = 5;
    };
    //load move - close followers collection.assignees
    $scope.limitAssignee = 5;
    $scope.loadMoreAssignee = function () {
        $scope.limitAssignee = $scope.collection.assignees.length;
    };
    $scope.closeMoreAssignee = function () {
        $scope.limitAssignee = 5;
    };
    
  //removeFile
    $scope.deleteFile = function (index, id) {
        dialogMessage.open('confirm', $rootScope.$lang.confirm_delete_file, function () {
            fileService.removeFile({fileId: id}, function (reponse) {
                //Remove file in file list in description.
                $scope.collection.file_info.splice(index, 1);
                
                //Remove file in event post.
                angular.forEach($scope.taskPostFile[reponse.objects.onwer_id], function(val, key){
                    //Traverse array of file in task post, and check the file we want to delete by name.
                    if (val.name == reponse.objects.name) {
                        $scope.taskPostFile[reponse.objects.onwer_id].splice(key, 1);
                    }
                });
                
                //Get the last event post, to prepend to the first event post list.
                $scope.getLastTaskPost();
                alertify.success($rootScope.$lang.remove_file_success);
            })
        });
    };

    $scope.edit = function () {
        var modalInstance = $uibModal.open({
            templateUrl: 'app/views/task/edit.html',
            controller: 'editTaskCtrl',
            size: 'lg',
            keyboard: true,
            backdrop: 'static',
            resolve: {
                data: $scope.collection,
            }
        });
        modalInstance.result.then(function (data) {
            if (static_postnew) {
                $scope.getInfoTask();
                $scope.getLastTaskPost();
            }
        }, function () {
        });
    };
   //function add task post
    $scope.taskPostData = {
        worked_hour: '',
        completed_percent: 0,
        description: '',
        taskId: taskId,
    };
    
    //Check if show hide show for form of log hour.
    $scope.isCanLogTime = function(assignees, auth) {
        if (angular.isUndefined(assignees)) {
            return false;
        }
        var i = 0;
        for (i = 0; i < assignees.length; i++) {
           if (assignees[i].id == auth.user_id){
                return true;
            }
        }
        return false;
    };
    
    $scope.addTaskPost = function () {
        if (($scope.collection.employeeList != null)) {
            $scope.taskPostData.employeeList = $scope.collection.employeeList;
        };

        if (TaskPostService.validateTaskPost($scope.taskPostData)) {
            var fd = new FormData();
            for (var i in $scope.files) {
                fd.append("file_" + i, $scope.files[i]);
            }

            fd.append("task", angular.toJson($scope.taskPostData));
            TaskPostService.addTaskPost(fd, function (response) {
                //In case of user isn't fill up anything into form, we don't anything...Here, we return true.
                if (response.objects.length == 0) {
                    return true;
                }
                
                alertify.success($rootScope.$lang.task_post_add_success);
                //update again total worked hour and completed percent
                if ($scope.taskPostData.worked_hour) {
                    $scope.collection.task.worked_hour = parseInt($scope.collection.task.worked_hour) + parseInt($scope.taskPostData.worked_hour);   
                }
                //Empty current form.
                $scope.collection.task.complete_percent = $scope.taskPostData.completed_percent;
                $scope.taskPostData.worked_hour = '';
                $scope.taskPostData.description = '';
                
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
                $scope.taskPost = temp.concat($scope.taskPost);
                $scope.taskPostFile = angular.merge($scope.taskPostFile, response.objects.files);
            });
        }
    }
    
    //get event post
    $scope.getHtml = function (html) {
        return $sce.trustAsHtml(html);
    };

    $scope.filter = {
        itemPerPage: PER_PAGE_VIEW_MORE,
        totalItems: 0,
        offset: 0,
        taskId: taskId,
        currentPage : 1
    };
    
    $scope.taskPost = [];
    $scope.taskPostFile = [];
    $scope.getTaskPosts = function () {
        TaskPostService.getTaskPosts($scope.filter, function (response) {
            if ($scope.taskPost.length > 0 && response.objects.collection) {
                $scope.taskPost = $scope.taskPost.concat(response.objects.collection);
            } else {
                $scope.taskPost = response.objects.collection;
            }
            if (_.size($scope.taskPostFile) > 0 && response.objects.files) {
                $scope.taskPostFile = angular.merge($scope.taskPostFile, response.objects.files);
            } else {
                $scope.taskPostFile = response.objects.files;
            }

            $scope.filter.totalItems = response.objects.totalItems;
        });
    };

    $scope.getTaskPosts();
    //view more
    $scope.viewMore = function () {
        $scope.filter.offset = $scope.taskPost.length;
        $scope.filter.currentPage ++;
        $scope.getTaskPosts();
    }

    $scope.getLastTaskPost = function () {
        TaskPostService.getLastTaskPost({taskId: taskId}, function (response) {
            if ($scope.taskPost.length > 0 && response.objects.collection) {
                $scope.taskPost = response.objects.collection.concat($scope.taskPost);
            } else {
                $scope.taskPost = response.objects.collection;
            }

            if (_.size($scope.taskPostFile) > 0 && response.objects.files) {
                $scope.taskPostFile = angular.merge($scope.taskPostFile, response.objects.files);
            } else {
                $scope.taskPostFile = response.objects.files;
            }

            $scope.filter.totalItems = response.objects.totalItems;
        });
    }

    //Delete task post
    $scope.deleteTaskPost = function (index, id) {
        dialogMessage.open('confirm', $rootScope.$lang.confirm_delete_file, function () {
            TaskPostService.removeTaskPost({taskPostId: id}, function (data) {
                $scope.taskPost.splice(index, 1);
                alertify.success($rootScope.$lang.remove_task_post_success);
            });
        });
    };

    //edit task post
    $scope.editTaskPost = function (taskPost, $index) {
        var modalInstance = $uibModal.open({
            templateUrl: 'app/views/taskPost/edit.html',
            controller: 'editTaskPostCtrl',
            size: 'lg',
            keyboard: true,
            backdrop: 'static',
            resolve: {
                taskPost: function () {
                    return taskPost;
                }
            }
        });
    };
    
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
    
    //Get detail of work hour each employee.
    $scope.getDetailWorkedHourEmployee = function (taskId) {
        var modalInstance = $uibModal.open({
            templateUrl: 'app/views/task/detailWorkedHourEmployee.html',
            controller: 'detailWorkedHourEmployeeCtrl',
            size: 'sm',
            keyboard: true,
            backdrop: 'static',
            resolve: {
                taskId: function (){
                    return taskId;
                }
            }
        });
    };
}]);

/*edit Task Popup Controller*/
appRoot.controller('editTaskCtrl', ['socketService', 'data', '$scope', 'taskService', '$location', '$uibModalInstance', '$rootScope', 'commonService', 'alertify', '$timeout', 'employeeService', 'projectService', '$cacheFactory', 'priorityService', 'statusService',
    function (socketService, data, $scope, taskService, $location, $uibModalInstance, $rootScope, commonService, alertify, $timeout, employeeService, projectService, $cacheFactory, priorityService, statusService) {
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
            id: data.task.id,
            name: data.task.name,
            project_id: parseInt(data.task.project_id),
            duedatetime: new Date(data.task.duedatetime),
            priority_id: parseInt(data.task.priority_id),
            completed_percent: data.task.completed_percent,
            description: data.task.description,
            estimate_hour: parseInt(data.task.estimate_hour),
            worked_hour: 0,
            parent_id: parseInt(data.task.parent_id),
            status_id: parseInt(data.task.status_id),
            assigningEmployees: data.assignees,
            followingEmployees: data.followers,
            is_public: data.task.is_public,
            taskGroupIds: data.taskGroup,
            redmind: parseInt(data.task.remind),
            sms: 0,
            data_old: data,
        };
//        created_by

        //status
        $scope.beforpopup = function () {
            taskService.getParentTaskList({project_id: $scope.task.project_id}, function (data) {
                $scope.parentTasks = data.objects.collection;
            });
            taskService.getTaskGroupList({project_id: $scope.task.project_id}, function (data) {
                $scope.taskGroups = data.objects.collection;
            });
            employeeService.searchEmployeeByProjectIdAndKeyword({keyword: '', project_id: $scope.task.project_id}, function (response) {
                $scope.employees = response.objects.collection;
            });
        }
        $scope.beforpopup();
        
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
                var searchedIdx = [];
                var preProcStr = '';
                var preProcKeyword = '';
                preProcKeyword = keyword.toLowerCase();

                if ($rootScope.$lang.language == 'vi') {
                    preProcKeyword = $scope.vietnammesePreProc(preProcKeyword);
                }

                //begin with keyword                
                for (i = 0; i < $scope.employees.length; i++) {
                    preProcStr = $scope.employees[i].fullname.toLowerCase();
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
                    preProcStr = $scope.employees[i].fullname.toLowerCase();
                    if ($rootScope.$lang.language == 'vi') {
                        preProcStr = $scope.vietnammesePreProc(preProcStr);
                    }

                    if (searchedIdx.indexOf(i) === -1 && preProcStr.indexOf(preProcKeyword) > 0) {
                        $scope.searchedEmployees.push($scope.employees[i]);
                    }
                }
        };

        $scope.filterFollowingEmployees = function (person) {
            for (i = 0; i < $scope.task.followingEmployees.length; i++) {
                if (person.id == $scope.task.followingEmployees[i].id) {
                    return false;
                }
            }
            for (i = 0; i < $scope.task.assigningEmployees.length; i++) {
                if (person.id == $scope.task.assigningEmployees[i].id) {
                    return false;
                }
            }
            return true;
        };

        $scope.filterAssigningEmployees = function (person) {
            for (i = 0; i < $scope.task.assigningEmployees.length; i++) {
                if (person.id == $scope.task.assigningEmployees[i].id) {
                    return false;
                }
            }
            for (i = 0; i < $scope.task.followingEmployees.length; i++) {
                if (person.id == $scope.task.followingEmployees[i].id) {
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
        
        $projectIdOld = $scope.task.project_id;
        $parent_idOld = $scope.task.parent_id;
        $taskGroupIdOld = $scope.task.taskGroupIds;
        $assigningEmployeeOld = $scope.task.assigningEmployees;
        $followingEmployeeOld = $scope.task.followingEmployees;
        $scope.updateAfterProjectChanged = function () {
            if ($scope.task.project_id == $projectIdOld) {
                $scope.task.parent_id = 19;
                $scope.task.taskGroupIds = $taskGroupIdOld;
                $scope.task.assigningEmployees = $assigningEmployeeOld;
                $scope.task.followingEmployees = $followingEmployeeOld;
                $scope.beforpopup();
            } else {
                var $httpDefaultCache = $cacheFactory.get('$http');
                $httpDefaultCache.removeAll();
                $scope.task.parent_id = 0;
                $scope.task.taskGroupIds = 0;
                $scope.task.assigningEmployees = [];
                $scope.task.followingEmployees = [];
                //status
                taskService.getParentTaskList({project_id: $scope.task.project_id}, function (data) {
                    $scope.parentTasks = data.objects.collection;
                });

                taskService.getTaskGroupList({project_id: $scope.task.project_id}, function (data) {
                    $scope.taskGroups = data.objects.collection;
                });

                employeeService.searchEmployeeByProjectIdAndKeyword({keyword: '', project_id: $scope.task.project_id}, function (response) {
                    $scope.employees = response.objects.collection;
                });
            }
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
        priorityService.getTaskPriority({}, function (data) {
            $scope.priorities = data.objects;
        });

        //status
        statusService.getTaskStatus({}, function (data) {
            $scope.statuses = data.objects;
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
//                        if (taskService.validate_step2($scope.task)) {
                            var fd = new FormData();
                            for (var i in $scope.files) {
                                fd.append("file_" + i, $scope.files[i]);
                            }
                            fd.append("task", angular.toJson($scope.task));
                            taskService.editTask(fd, function (response) {
                                if (response.objects.postnew) {
                                    static_postnew = true;
                                }
                                alertify.success($rootScope.$lang.task_notify_success);
                                $uibModalInstance.close($scope.task);
                                socketService.emit('notify', 'ok');
                                $scope.step++;
                            });
//                        }
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

//edit task post
appRoot.controller('editTaskPostCtrl', ['$scope', 'TaskPostService', '$uibModalInstance', 'controllerService', 'actionService', '$rootScope', 'taskPost', 'alertify', 'dialogMessage', 'socketService',
    function ($scope, TaskPostService, $uibModalInstance, controllerService, actionService, $rootScope, taskPost, alertify, dialogMessage, socketService) {
        $scope.taskpost = {
            id: taskPost.id,
            description: taskPost.content,
        };
        $scope.update = function () {
            if (TaskPostService.validateTaskPost($scope.taskpost)) {
                var params = {'id': taskPost.id, 'content': $scope.taskpost.description};
                TaskPostService.updateTaskPost(params, function (data) {
                    taskPost.content = $scope.taskpost.description;
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

//edit task post
appRoot.controller('detailWorkedHourEmployeeCtrl', ['$scope', '$uibModalInstance', 'taskId', 'taskService',
    function ($scope, $uibModalInstance, taskId, taskService) {
       $scope.employees = [];
       taskService.getDetaiWorkedHourEmployee({taskId: taskId}, function(response) {
           $scope.employees = response.objects;
       });
        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
    };
}]);