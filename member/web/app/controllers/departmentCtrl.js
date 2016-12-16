appRoot.controller('departmentCtrl', ['$scope', '$uibModal', '$rootScope', 'alertify', 'PER_PAGE', 'MAX_PAGE_SIZE', 'commonService', 'departmentService', 'dialogMessage',
    function ($scope, $uibModal, $rootScope, alertify, PER_PAGE, MAX_PAGE_SIZE, commonService, departmentService, dialogMessage) {
        $scope.params = {
            page: 1,
            limit: PER_PAGE,
            orderBy: '',
            orderType: ''
        };

        $scope.totalItems = 0;
        $scope.departments = [];
        $scope.maxPageSize = MAX_PAGE_SIZE;
        $scope.getDepartments = function () {
            departmentService.gets($scope.params, function (res) {
                $scope.departments = res.objects.collection;
                $scope.totalItems = res.objects.totalItems;
            });
        };

        $scope.update = function (id) {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/department/edit.html',
                controller: 'editDepartmentCtrl',
                size: 'sm',
                keyboard: true,
                backdrop: 'static',
                resolve: {
                    department: function ($q, commonService) {
                        var deferred = $q.defer();
                        commonService.get('department', id, function (respone) {
                            deferred.resolve(respone.objects);
                        });

                        return deferred.promise;
                    }
                }
            });

            modalInstance.result.then(function () {
                $scope.getDepartments();
            });
        };

        $scope.add = function () {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/department/add.html',
                controller: 'addDepartmentCtrl',
                size: 'sm',
                keyboard: true,
                backdrop: 'static',
            });

            modalInstance.result.then(function (data) {
                $scope.getDepartments();
            });
        };

        $scope.delete = function (id) {
            dialogMessage.open('confirm', $rootScope.$lang.is_delete, function (reponse) {
                departmentService.delete({id: id}, function () {
                    $scope.getDepartments();
                    alertify.success($rootScope.$lang.delete_success);
                }, function (data) {
                    if (data.message == 'is used') {
                        alertify.error($rootScope.$lang.have_at_least_one_employee_belong_this_department_please_remove_employee_with_this_department_first);
                    }
                });
            });
        };

        $scope.getDepartments();
    }]);

appRoot.controller('editDepartmentCtrl', ['$scope', '$uibModalInstance', '$rootScope', 'alertify', 'departmentService', 'department', 'commonService',
    function ($scope, $uibModalInstance, $rootScope, alertify, departmentService, department, commonService) {
        $scope.department = department;
        $scope.update = function () {
            if (departmentService.validate($scope.department)) {
                commonService.update('department', $scope.department, function (response) {
                    $scope.department = response.objects;
                    alertify.success($rootScope.$lang.update_success);
                    $uibModalInstance.close($scope.employee);
                })
            }
        }

        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    }]);

appRoot.controller('addDepartmentCtrl', ['$scope', '$uibModalInstance', '$rootScope', 'alertify', 'departmentService', 'commonService',
    function ($scope, $uibModalInstance, $rootScope, alertify, departmentService, commonService) {
        $scope.department = {
            name: '',
            description: '',
        };

        $scope.add = function () {
            if (departmentService.validate($scope.department)) {
                commonService.add('department', $scope.department, function (response) {
                    alertify.success($rootScope.$lang.add_success);
                    $uibModalInstance.close($scope.department);
                })
            }
        }

        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    }]);
