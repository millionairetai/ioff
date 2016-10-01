appRoot.controller('EmployeeCtrl', ['$scope', '$uibModal', 'employeeService', '$rootScope', 'alertify', 'PER_PAGE', 'MAX_PAGE_SIZE',
    function ($scope, $uibModal, employeeService, $rootScope, alertify, PER_PAGE, MAX_PAGE_SIZE) {

        $scope.params = {
            page: 1,
            limit: 2,
            statusName: '',
            employeeName: '',
            orderBy: '',
            orderType: ''
        };

        $scope.employee = {
            pageEmployee: 1,
            pageInvited: 1,
            pageInactive: 1
        };

        $scope.commonTemplate = '';
        $scope.totalItems = 0;
        $scope.employees = [];
        $scope.maxPageSize = MAX_PAGE_SIZE;
        $scope.getEmployees = function (type, $event) {
            switch (type) {
                case 'employee':
                    {
                        $scope.params.statusName = 'active';
                        $scope.params.page = $scope.employee.pageEmployee;
                        employeeService.getEmployeesByStatus($scope.params, function (response) {
                            $scope.employees = response.objects.employees;
                            $scope.totalItems = response.objects.totalItems;
                        });
                    }
                    break;
                case 'invited':
                    {
                        $scope.params.statusName = 'invited';
                        $scope.params.page = $scope.employee.pageInvited;
                        employeeService.getEmployeesByStatus($scope.params, function (response) {
                            $scope.employees = response.objects.employees;
                            $scope.totalItems = response.objects.totalItems;
                        });
                    }
                    break;
                case 'inactive':
                    {
                        $scope.params.statusName = 'inactive';
                        $scope.params.page = $scope.employee.pageInactive;
                        employeeService.getEmployeesByStatus($scope.params, function (response) {
                            $scope.employees = response.objects.employees;
                            $scope.totalItems = response.objects.totalItems;
                        });
                    }
                    break;
            }
        };

        $scope.invite = function (authority, $index) {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/employee/invitation.html',
                controller: 'InvitationCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
//                resolve: {
//                    authority: function () {
//                        return authority;
//                    }
//                }
            });
        };

        $scope.edit = function (authority, $index) {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/employee/edit.html',
                controller: 'editEmployeeCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
            });
        };

        $scope.getEmployees('employee', '');

    }]);

appRoot.controller('InvitationCtrl', ['$scope', '$uibModalInstance', '$rootScope', 'alertify', 'dialogMessage',
    function ($scope, $uibModalInstance, $rootScope, alertify, dialogMessage) {
        $scope.cancel = function () {
            $uibModalInstance.dismiss();
        };
    }]);

appRoot.controller('editEmployeeCtrl', ['$scope', '$uibModalInstance', '$rootScope', 'alertify', '$timeout', 'employeeService', '$filter', 'statusService', 'priorityService',
    function ($scope, $location, $uibModalInstance, $rootScope, alertify, $timeout, employeeService, $filter, statusService, priorityService) {
        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    }]);