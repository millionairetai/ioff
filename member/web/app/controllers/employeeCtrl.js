appRoot.controller('EmployeeCtrl', ['$scope', '$uibModal', 'employeeService', '$rootScope', 'alertify', 'PER_PAGE', 'MAX_PAGE_SIZE',
    function ($scope, $uibModal, employeeService, $rootScope, alertify, PER_PAGE, MAX_PAGE_SIZE) {

        $scope.params = {
            page: 1,
            limit: PER_PAGE,
            employeeName: '',
            orderBy: '',
            orderType: ''
        };

        $scope.totalItems = 0;
        $scope.employees = [];
        $scope.maxPageSize = MAX_PAGE_SIZE;
        $scope.getEmployees = function () {
            employeeService.getEmployeesByStatus($scope.params, function (res) {
                $scope.employees = res.objects.employees;
            });
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

        $scope.getEmployees();

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