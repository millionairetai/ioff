//list project
appRoot.controller('projectCtrl', ['$scope', 'projectService', '$uibModal','$rootScope','socketService', 'PER_PAGE_VIEW_MORE',
    function ($scope, projectService, $uibModal, $rootScope, socketService, PER_PAGE_VIEW_MORE) {
         
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
            $scope.getProjectPosts();
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
                    $scope.getProjectPosts();
                })
            });
        };

        //handle create project post successful
        $rootScope.$on('add_project_post_success', function (event, data) {
            $scope.getProjectPosts();
        });
        
        //handle create project successful
        $rootScope.$on('edit_project_success', function (event, data) {
        	$scope.getInfoProject();
        	$scope.getProjectPosts();
        	$scope.limit = 5;
        	$scope.limitFile = 5;
        });
    }]);

//edit project
appRoot.controller('editProjectCtrl', ['$scope', 'projectService', '$location', '$uibModalInstance', '$rootScope', 'departmentService', 'alertify', '$timeout', 'employeeService', '$filter', 'statusService', 'priorityService', 
    function ($scope, projectService, $location, $uibModalInstance, $rootScope, departmentService, alertify, $timeout, employeeService, $filter, statusService, priorityService) {
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
            start_datetime: $dataEditProject.project_info.start_datetime,
            duedatetime: $dataEditProject.project_info.duedatetime,
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
