appRoot.controller('EmployeeCtrl', ['$scope', '$uibModal', 'employeeService', '$rootScope', 'alertify', 'PER_PAGE', 'MAX_PAGE_SIZE',
    function ($scope, $uibModal, employeeService, $rootScope, alertify, PER_PAGE, MAX_PAGE_SIZE) {

        $scope.params = {
            page : 1,
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
        
        $scope.getEmployees();

    }]);