appRoot.controller('EmployeeCtrl', ['$scope', '$uibModal', 'employeeService', '$rootScope', 'alertify', 'PER_PAGE', 'MAX_PAGE_SIZE',
    function ($scope, $uibModal, employeeService, alertify, PER_PAGE, MAX_PAGE_SIZE) {

        $scope.params = {
            page: 1,
            limit: 2,
            statusName: '',
            orderBy: '',
            orderType: '',
            searchName: ''
        };

        $scope.employee = {
            pageEmployee: 1,
            pageInvited: 1,
            pageInactive: 1,
            pageAll: 1
        };

        $scope.commonTemplate = '';
        $scope.totalItems = 0;
        $scope.employees = [];
        $scope.maxPageSize = MAX_PAGE_SIZE;
        $scope.getEmployees = function (type, $event) {
            if ($event != '') {
                $event.preventDefault();
            }
            
            //check if this tab is checked, we don't get ajax again.
            if ($($event.target).parent().hasClass('active')) {
                return true;
            }
            
            if ($scope.params.searchName) {
                angular.element('.nav-item').removeClass('active');
                angular.element('#all_search').addClass('active');
            }
            
            switch (type) {
                case 'employee':
                    {
                        $scope.params.statusName = 'active';
                        $scope.params.page = $scope.employee.pageEmployee;
                    }
                    break;
                case 'invited':
                    {
                        $scope.params.statusName = 'invited';
                        $scope.params.page = $scope.employee.pageInvited;
                    }
                    break;
                case 'inactive':
                    {
                        $scope.params.statusName = 'inactive';
                        $scope.params.page = $scope.employee.pageInactive;
                    }
                    break;
                case 'all':
                    {
                        $scope.params.statusName = '';
                        $scope.params.page = $scope.employee.pageAll;
                    }
                    break;
            }

            employeeService.getEmployeesByStatus($scope.params, function (response) {
                $scope.employees = response.objects.employees;
                $scope.totalItems = response.objects.totalItems;
            });
        };
        
        //search by task name
        $scope.search = function (type) {
            $scope.getEmployees(type, '');
        }

        $scope.invite = function (authority, $index) {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/employee/invitation.html',
                controller: 'InvitationCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static'
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
                backdrop: 'static'
            });
        };

        $scope.getEmployees('employee', '');

    }]);

appRoot.controller('InvitationCtrl', ['$scope', '$uibModalInstance', 'employeeService', '$rootScope', 'alertify', 'dialogMessage',
    function ($scope, $uibModalInstance, employeeService, $rootScope, alertify, dialogMessage) {
        $scope.invitation = {
            message: '     Please join me in our new intranet. This is a place where everyone can collaborate on projects, coordinate tasks and schedules, and build our knowledge base, ',
            emails: ''
        };
        
        $scope.invite = function () {
            //Remove null or empty email.
            $scope.invitation.emails = _.compact($scope.invitation.emails.split(','));
            //Check validation email & Check validation message.
            if (employeeService.validateInvitation($scope.invitation)) {
                employeeService.invite($scope.invitation, function (response) {
                    alertify.success('Invite employees successfully');
                    $uibModalInstance.close(response.objects);
                });
            }
        }
        
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