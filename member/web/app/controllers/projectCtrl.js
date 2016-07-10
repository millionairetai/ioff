//list project
appRoot.controller('projectCtrl', ['$scope', 'projectService', '$modal','$rootScope', function ($scope, projectService, $modal,$rootScope) {
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
            var modalInstance = $modal.open({
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
appRoot.controller('addProjectCtrl', ['$scope', 'projectService', '$location', '$modalInstance', '$rootScope', 'departmentService','alertify','$timeout','employeeService', function ($scope, projectService, $location, $modalInstance, $rootScope, departmentService,alertify,$timeout,employeeService) {
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
            $modalInstance.dismiss('cancel');
        };

        //show more
        $scope.showMore = function (value) {
            $scope.more = value;
        }

    }]);


