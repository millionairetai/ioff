appRoot.controller('EmployeeCtrl', ['$scope', '$uibModal', 'employeeService', '$rootScope', 'alertify', 'PER_PAGE', 'MAX_PAGE_SIZE', 'commonService',
    function ($scope, $uibModal, employeeService, alertify, PER_PAGE, MAX_PAGE_SIZE, commonService) {

        $scope.params = {
            page: 1,
            limit: 12,
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

appRoot.controller('profileCtrl', ['$scope', '$rootScope', 'alertify', '$timeout', '$filter', 'commonService', '$routeParams', 'employeeService', '$uibModal', '$location', '$window','activityService', 'commonService', 'commentService', 'validateService', 'departmentService', 'activityPostService', 'annoucementService', 'requestmentService', 'socketService',
    function ($scope, $rootScope, alertify, $timeout, $filter, commonService, $routeParams, employeeService, $uibModal, $location, $window, activityService, commonService, commentService, validateService, departmentService, activityPostService, annoucementService, requestmentService, socketService) {
        var employeeId = $routeParams.employeeId;
        employeeService.getProfile({employeeId: employeeId}, function (respone) {
            $scope.employee = respone.objects;
        }, function (respone) {
            $location.path('/');
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

        $scope.changePassword = function () {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/employee/changePassword.html',
                controller: 'changePasswordCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
                resolve: {
                    employee: {
                        id: $scope.employee.id,
                    }
                }
            });
        };

        $scope.changeProfile = function () {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/employee/changeProfile.html',
                controller: 'changeProfileCtrl',
                size: 'lg',
                keyboard: true,
                backdrop: 'static',
                resolve: {
                    employee: {
                        id: $scope.employee.id,
                    }
                }
            });

            modalInstance.result.then(function (data) {
                $scope.employee.image = data;
                $window.location.reload();
            });
        };

        //------------------------ Profile activity -------------------------------------//
        //employee profile wall
        $scope.annoucements = {
            data: [],
            totalPage: 0,
            currentPage: 1
        };
        $scope.profile = null;
        $scope.comment = '';
        $scope.activity = {
            data: null,
            total: 0,
            end: false,
            page: 1,
            busy: false,
            activityId: $routeParams.activityId
        };

        //Message tab.
        $scope.message = {
            all: true,
            content: '',
            option: false,
            departments: [],
            employees: []
        };

        //My number request.
//        $scope.myNumberRequest = {
//            sent: 0,
//            received: 0
//        }

        //get all department
        departmentService.allDepartment({}, function (data) {
            $scope.departments = data.objects;
        });

        //add employee
        $scope.getEmployees = function (keyword) {
            employeeService.searchEmployee({keyword: keyword}, function (response) {
                $scope.employees = response.objects;
            });
        };

        var temp = [];
        $scope.getActivity = function () {
            if ($scope.activity.end || $scope.activity.busy) {
                return true;
            }

            $scope.activity.busy = true;
            activityService.getProfileActivity({currentPage: $scope.activity.page, activityId: $scope.activity.activityId, employeeId: employeeId}, function (response) {
                //Must transform object to array because object automatically arrange item by numeric key.
                temp = Object.keys(response.objects.activities).map(function (k) {
                    return response.objects.activities[k]
                });
                //Reverse max key to top head, beause they have just created.
                temp.reverse();
                if ($scope.activity.data === null) {
                    $scope.activity.data = temp;
                } else {
                    $scope.activity.data = $scope.activity.data.concat(temp);
                }

                $scope.profile = response.objects.profile;
                $scope.activity.total = response.objects.totalCount;
                if ($scope.activity.data.length >= $scope.activity.total) {
                    $scope.activity.end = true;
                    return true;
                }
                $scope.activity.busy = false;
            });

            $scope.activity.page++;
        }

        $scope.saveComment = function (index, activityId, content) {
            if (!validateService.required(content)) {
                return false;
            }
            commonService.add('comment', {activity_id: activityId, content: content}, function (response) {
                //Append to current comment.
                if (!angular.isDefined($scope.activity.data[index]['comments'])) {
                    $scope.activity.data[index]['comments'] = response.objects.comments;
                } else {
                    $scope.activity.data[index]['comments'] = angular.extend($scope.activity.data[index]['comments'], response.objects.comments);
                }
                $scope.activity.data[index].total_comment = parseInt($scope.activity.data[index].total_comment) + 1;
                alertify.success($rootScope.$lang.add_success);
            });
        }

        $scope.likeComment = function (indexActivity, commentId) {
            commentService.like({commentId: commentId}, function (response) {
                $scope.activity.data[indexActivity]['comments'][commentId].total_like = parseInt($scope.activity.data[indexActivity]['comments'][commentId].total_like) + 1;
                $scope.activity.data[indexActivity]['comments'][commentId].is_liked = true;
                alertify.success($rootScope.$lang.like_success);
            });
        }

        $scope.likeActivity = function (indexActivity, activityId) {
            activityService.like({activityId: activityId}, function (response) {
                $scope.activity.data[indexActivity].total_like = parseInt($scope.activity.data[indexActivity].total_like) + 1;
                $scope.activity.data[indexActivity].is_liked = true;
                alertify.success($rootScope.$lang.like_success);
            });
        }

        $scope.addMessage = function () {
            activityPostService.addMessage($scope.message, function (response) {
                $scope.message.content = '';
                $scope.activity.data.unshift(response.objects.activity);
                $scope.message.employees = [];
                $scope.message.departments = [];
                $scope.message.option = false;
                $scope.message.all = true;
                alertify.success($rootScope.$lang.add_success);
            });
        }

        $scope.initializeTab = function ($event) {
            if ($event != '') {
                $event.preventDefault();
            }
        }

        //-------------annoucment -------//
        $scope.annoucemnt = {
            title: '',
            description: '',
            is_importance: false,
            date_new_to: '',
            sms: false
//            departments: [],
//            employees: []
        };

        $scope.addAnnoucement = function () {
            if (!annoucementService.validate($scope.annoucemnt)) {
                return false;
            }

            annoucementService.add($scope.annoucemnt, function (response) {
                $scope.activity.data.unshift(response.objects.activity);
                $scope.annoucemnt = {
                    title: '',
                    description: '',
                    is_importance: false,
                    date_new_to: '',
                    sms: false
                };
                alertify.success($rootScope.$lang.add_success);
            });
        }

        //requestment member
        $scope.requestment = {
            title: '',
            description: '',
            from_datetime: '',
            to_datetime: '',
            requestment_category_id: null,
            review_employee: null,
            review_employee_id: 0,
            sms: false,
            is_public: true
//            departments: [],
//            employees: []
        };

        // time picker
        $scope.timepickerOptions = {
            readonlyInput: false,
            showMeridian: false
        }

        commonService.gets('requestment-category', function (response) {
            $scope.requestmentCategory = response.objects;
        });

        $scope.selectReviewer = function ($item, $model) {
            $scope.getEmployees('');
        };

        //clear manager
        $scope.clearReviewer = function () {
            $scope.requestment.review_employee = null;
        }

        $scope.addRequestment = function () {
            if (!requestmentService.validate($scope.requestment)) {
                return false;
            }

            $scope.requestment.review_employee_id = $scope.requestment.review_employee.id;
            requestmentService.add($scope.requestment, function (response) {
                response.objects.requestment = angular.merge({
                    requestment: {avatar_to: $scope.requestment.review_employee.image},
                }, response.objects.requestment);
                $scope.activity.data.unshift(response.objects.requestment);
                $scope.requestment = {
                    title: '',
                    description: '',
                    from_datetime: '',
                    to_datetime: '',
                    requestment_category_id: null,
                    review_employee: null,
                    review_employee_id: 0,
                    sms: false,
                    is_public: true
                };
                socketService.emit('notify', 'ok');
                alertify.success($rootScope.$lang.add_success);
            });
        }

        //Accept or refuse requestment
        $scope.processRequestment = function (type, indexActivity, requestmentId) {
            requestmentService.process({requestmentId: requestmentId, type: type}, function (response) {
                $scope.activity.data[indexActivity].requestment.status = 'requestment.completed';
                if (type == 'accept') {
                    $scope.activity.data[indexActivity].requestment.is_accept = true;
                }
                socketService.emit('notify', 'ok');
                alertify.success($rootScope.$lang.update_success);
            });
        }

        //Get data when just loading.
        $scope.getActivity();
    }]);

appRoot.controller('updateProfileCtrl', ['$scope', '$rootScope', 'alertify', '$timeout', '$filter', 'commonService', '$routeParams', 'employeeService', '$uibModalInstance', 'employee',
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

appRoot.controller('changePasswordCtrl', ['$scope', '$rootScope', 'alertify', 'commonService', 'employeeService', '$uibModalInstance', 'employee',
    function ($scope, $rootScope, alertify, commonService, employeeService, $uibModalInstance, employee) {
        $scope.employee = {
            oldPassword: '',
            newPassword: '',
            rePassword: ''
        };

        angular.merge($scope.employee, employee);
        $scope.changePassword = function () {
            employeeService.changePassword($scope.employee, function (response) {
                alertify.success($rootScope.$lang.update_success);
                $uibModalInstance.close(response.objects);
            })
        }

        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    }]);

appRoot.controller('changeProfileCtrl', ['$scope', '$rootScope', 'alertify', 'employeeService', '$uibModalInstance', 'validateService',
    function ($scope, $rootScope, alertify, employeeService, $uibModalInstance, validateService) {
        $scope.file = [];
        //add file
        $scope.addFile = function (files) {
            $scope.$apply(function () {
                try {
                    if (!validateService.maxSizeUpload(files[0])) {
                        throw $rootScope.$lang.max_size;
                    }

                    if (!validateService.avatar(files[0])) {
                        throw $rootScope.$lang.please_choose_png_gif_jpg_file;
                    }

                    $scope.file = files[0];
                }
                catch (error) {
                    $scope.file = [];
                    alertify.error(error);
                }
            });
        };

        $scope.previewFile = function () {
            var preview = document.querySelector('#previewAvatar');
            var file = document.querySelector('input[type=file]').files[0];
            var reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        $scope.changeProfile = function () {
            if ($scope.file.length <= 0) {
                alertify.error($rootScope.$lang.please_choose_png_gif_jpg_file);
                return;
            }

            var fd = new FormData();
            fd.append("file", $scope.file);
            employeeService.changeAvatar(fd, function (response) {
                alertify.success($rootScope.$lang.update_success);
                $uibModalInstance.close(response.objects.image);
            })
        }

        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    }]);