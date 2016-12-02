appRoot.controller('EmployeeCtrl', ['$scope', '$uibModal', 'employeeService', '$rootScope', 'alertify', 'PER_PAGE', 'MAX_PAGE_SIZE', 'commonService',
    function ($scope, $uibModal, employeeService, alertify, PER_PAGE, MAX_PAGE_SIZE, commonService) {

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

        $scope.type = '';
        $scope.commonTemplate = '';
        $scope.employees = [];
        $scope.maxPageSize = MAX_PAGE_SIZE;
        $scope.getEmployees = function (type, $event) {
            $scope.type = type;
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
                $scope.reset();
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

        $scope.reset = function () {
            $scope.totalItems.active = 0;
            $scope.totalItems.invited = 0;
            $scope.totalItems.inactive = 0;
            $scope.totalItems.all = 0;
        }

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
            });
        };

        $scope.edit = function (employeeId, index) {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/employee/edit.html',
                controller: 'editEmployeeCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
                resolve: {
                    employee: function ($q, commonService) {
                        var deferred = $q.defer();
                        commonService.get('employee', employeeId, function (respone) {
                            deferred.resolve(respone.objects);
                        });

                        return deferred.promise;
                    }
                }
            });

            modalInstance.result.then(function (data) {
                $scope.getEmployees($scope.type, '');
            });
        };

        $scope.add = function () {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/employee/add.html',
                controller: 'addEmployeeCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
            });

            modalInstance.result.then(function (data) {
                $scope.getEmployees($scope.type, '');
            });
        };

        $scope.getEmployees('active', '');
    }]);

appRoot.controller('InvitationCtrl', ['$scope', '$uibModalInstance', 'employeeService', '$rootScope', 'alertify', 'dialogMessage', '$rootScope',
    function ($scope, $uibModalInstance, employeeService, $rootScope, alertify, dialogMessage, $rootScope) {
        $scope.invitation = {
            message: $rootScope.$lang.message_invitation,
            emails: ''
        };

        $scope.invite = function () {
            //Remove null or empty email.
            var emails = $scope.invitation.emails;
            emails = _.compact(emails.split(','));
            //Check validation email & Check validation message.
            if (employeeService.validateInvitation(emails, $scope.invitation.message)) {
                employeeService.invite({emails: emails, message: $scope.invitation.message}, function (response) {
                    alertify.success($rootScope.$lang.invite_successfully);
                    $uibModalInstance.close(response.objects);
                });
            }
        }

        $scope.cancel = function () {
            $uibModalInstance.dismiss();
        };
    }]);

appRoot.controller('editEmployeeCtrl', ['$scope', '$uibModalInstance', '$rootScope', 'alertify', '$timeout', 'employeeService', '$filter', 'departmentService', 'employee', 'commonService', 'statusService',
    function ($scope, $uibModalInstance, $rootScope, alertify, $timeout, employeeService, $filter, departmentService, employee, commonService, statusService) {
        $scope.employee = employee;
        //change timestamp birthdate to object datetime.
        if ($scope.employee.birthdate != '' && $scope.employee.birthdate != 0) {
            $scope.employee.birthdate = new Date($scope.employee.birthdate);
        }

        $scope.statuses = [];
        $scope.departments = [];
        //get list of department
        commonService.gets('department', function (response) {
            $scope.departments = response.objects;
            if ($scope.departments.length > 0) {
                angular.forEach($scope.departments, function (val, key) {
                    if (val.id == $scope.employee.department_id) {
                        $scope.employee.department_id = val;
                    }
                });
            }
        });

        //get list of authority
        commonService.gets('authority', function (response) {
            $scope.authorities = response.objects;
            if ($scope.authorities.length > 0) {
                angular.forEach($scope.authorities, function (val, key) {
                    if (val.id == $scope.employee.authority_id) {
                        $scope.employee.authority_id = val;
                    }
                });
            }
        });

        //status
        statusService.getEmployeesStatus($scope.employee.status_id, function (data) {
            $scope.statuses = data.objects;
        });

        $scope.update = function () {
            if (employeeService.validate($scope.employee)) {
                $scope.employee.department_id = angular.isObject($scope.employee.department_id) ? $scope.employee.department_id.id : 0;
                $scope.employee.authority_id = angular.isObject($scope.employee.authority_id) ? $scope.employee.authority_id.id : 0;
                if ($scope.employee.birthdate == '' || angular.isUndefined($scope.employee.birthdate)) {
                    $scope.employee.birthdate = 0;
                }

                commonService.update('employee', $scope.employee, function (response) {
                    $scope.employee = response.objects;
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

appRoot.controller('addEmployeeCtrl', ['$scope', '$uibModalInstance', '$rootScope', 'alertify', '$timeout', 'employeeService', '$filter', 'departmentService', 'commonService', 'statusService',
    function ($scope, $uibModalInstance, $rootScope, alertify, $timeout, employeeService, $filter, departmentService, commonService, statusService) {
        $scope.employee = {
            email: null,
            firstname: '',
            lastname: '',
            authority_id: 0,
            department_id: 0,
            status_id: 0,
            is_admin: 0,
            mobile_phone: '',
            work_phone: '',
            is_make_password_auto: true
        };
        
        $scope.statuses = [];
        $scope.departments = [];
        //get list of department
        commonService.gets('department', function (response) {
            $scope.departments = response.objects;
        });

        //get list of authority
        commonService.gets('authority', function (response) {
            $scope.authorities = response.objects;
        });

        //status
        statusService.getEmployeesStatus(null, function (data) {
            $scope.statuses = data.objects;
            if ($scope.statuses.length > 0) {
                $scope.employee.status_id = $scope.statuses[0].id;
            }
        });

        $scope.add = function () {
            if (employeeService.validateAdd($scope.employee)) {
                if ($scope.employee.birthdate == '' || angular.isUndefined($scope.employee.birthdate)) {
                    $scope.employee.birthdate = 0;
                }
                
                commonService.add('employee', $scope.employee, function (response) {
                    alertify.success($rootScope.$lang.add_success);
                    $uibModalInstance.close($scope.employee);
                })
            }
        }

        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    }]);

appRoot.controller('profileCtrl', ['$scope','$rootScope', 'alertify', '$timeout', '$filter', 'commonService', '$routeParams', 'employeeService', '$uibModal', 
    function ($scope, $rootScope, alertify, $timeout, $filter, commonService, $routeParams, employeeService, $uibModal) {
        var employeeId = $routeParams.employeeId;
        employeeService.getProfile({employeeId : employeeId}, function (respone) {
            $scope.employee = respone.objects;
        });
        
        
        $scope.update = function (employeeId) {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/employee/editProfile.html',
                controller: 'updateProfileCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
                resolve: {
                    employee: {
                        id: $scope.employee.id,
                        firstname: $scope.employee.firstname,
                        lastname: $scope.employee.lastname,
                        birthdate: $scope.employee.birthdate,
                        department_id: $scope.employee.department_id,
                        mobile_phone: $scope.employee.mobile_phone,
                        work_phone: $scope.employee.work_phone,
                        street_address_1: $scope.employee.street_address_1
                    }
                }
            });

            modalInstance.result.then(function (data) {
                $scope.employee = angular.extend($scope.employee, data);
            });
        };
        
    }]);

appRoot.controller('updateProfileCtrl', ['$scope','$rootScope', 'alertify', '$timeout', '$filter', 'commonService', '$routeParams', 'employeeService', '$uibModalInstance', 'employee', 
    function ($scope, $rootScope, alertify, $timeout, $filter, commonService, $routeParams, employeeService, $uibModalInstance, employee) {
        $scope.employee = employee;
        //change timestamp birthdate to object datetime.
        if ($scope.employee.birthdate != '' && $scope.employee.birthdate != 0) {
            $scope.employee.birthdate = new Date($scope.employee.birthdate);
        }
        
        //get list of department
        $scope.departments = [];
        commonService.gets('department', function (response) {
            $scope.departments = response.objects;
            if ($scope.departments.length > 0) {
                angular.forEach($scope.departments, function (val, key) {
                    if (val.id == $scope.employee.department_id) {
                        $scope.employee.department_id = val;
                    }
                });
            }
        });
        
        $scope.update = function () {
            if (employeeService.validate($scope.employee)) {
                $scope.employee.department_id = angular.isObject($scope.employee.department_id) ? $scope.employee.department_id.id : 0;
                if ($scope.employee.birthdate == '' || angular.isUndefined($scope.employee.birthdate)) {
                    $scope.employee.birthdate = 0;
                }

                employeeService.updateProfile($scope.employee, function (response) {
                    alertify.success($rootScope.$lang.update_success);
                    $uibModalInstance.close(response.objects);
                })
            }
        }
        
        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
}]);