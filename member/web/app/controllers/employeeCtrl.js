appRoot.controller('EmployeeCtrl', ['$scope', '$uibModal', 'employeeService', '$rootScope', 'alertify', 'PER_PAGE', 'MAX_PAGE_SIZE',
    function ($scope, $uibModal, employeeService, alertify, PER_PAGE, MAX_PAGE_SIZE) {

        $scope.params = {
            page: 1,
            limit: 5,
            searchName: '',
            orderBy: '',
            orderType: '',
            statusName: ''
        };

        $scope.employee = {
            search: {
                active: '',
                invited: '',
                inactive: '',
                all: ''
            },
            page: {
                active: 1,
                invited: 1,
                inactive: 1,
                all: 1
            }
        };

        $scope.totalItems = {
            active: 0,
            invited: 0,
            inactive: 0,
            all: 0
        };

        $scope.commonTemplate = '';
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
                case 'active':
                    $scope.params.statusName = 'active';
                    $scope.params.page = $scope.employee.page.active;
                    break;
                case 'invited':
                    $scope.params.statusName = 'invited';
                    $scope.params.page = $scope.employee.page.invited;
                    break;
                case 'inactive':
                    $scope.params.statusName = 'inactive';
                    $scope.params.page = $scope.employee.page.inactive;
                    break;
                case 'all':
                    $scope.params.statusName = '';
                    $scope.params.page = $scope.employee.page.all;
                    break;
            }

            employeeService.getEmployeesByStatus($scope.params, function (response) {
                $scope.employees = response.objects.employees;
                switch (type) {
                    case 'active':
                        $scope.totalItems.active = response.objects.totalItems;
                        break;
                    case 'invited':
                        $scope.totalItems.invited = response.objects.totalItems;
                        break;
                    case 'inactive':
                        $scope.totalItems.inactive = response.objects.totalItems;
                        break;
                    case 'all':
                        $scope.totalItems.all = response.objects.totalItems;
                        break;
                }
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

        $scope.getEmployees('active', '');

    }]);

appRoot.controller('InvitationCtrl', ['$scope', '$uibModalInstance', 'employeeService', '$rootScope', 'alertify', 'dialogMessage',
    function ($scope, $uibModalInstance, employeeService, $rootScope, alertify, dialogMessage) {
        $scope.invitation = {
            message: '     Please join me in our new intranet. This is a place where everyone can collaborate on projects, coordinate tasks and schedules, and build our knowledge base, ',
            emails: ''
        };

        $scope.invite = function () {
            //Remove null or empty email.
            var emails = $scope.invitation.emails;
            emails = _.compact(emails.split(','));
            //Check validation email & Check validation message.
            if (employeeService.validateInvitation(emails, $scope.invitation.message)) {
                employeeService.invite({emails: emails, message: $scope.invitation.message}, function (response) {
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

appRoot.controller('profileCtrl', ['$scope', '$rootScope', 'alertify', '$timeout', '$filter',
    function ($scope, $location, $rootScope, alertify, $timeout, $filter) {

    }]);