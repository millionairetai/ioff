appRoot.controller('requestmentCtrl', ['$scope', '$uibModal', '$rootScope', 'alertify', 'PER_PAGE', 'MAX_PAGE_SIZE', 'commonService', 'requestmentService', 'dialogMessage',
    function ($scope, $uibModal, $rootScope, alertify, PER_PAGE, MAX_PAGE_SIZE, commonService, requestmentService, dialogMessage) {
        $scope.params = {
            page: 1,
            limit: PER_PAGE,
            orderBy: '',
            orderType: ''
        };

        $scope.totalItems = 0;
        $scope.requestment = [];
        $scope.maxPageSize = MAX_PAGE_SIZE;
        $scope.getRequest = function () {
//            requestmentService.gets($scope.params, function (res) {
//                $scope.requestment = res.objects.collection;
//                $scope.totalItems = res.objects.totalItems;
//            });
        };

        $scope.initializeTab = function ($event) {
            if ($event != '') {
                $event.preventDefault();
            }
        }
        
        $scope.update = function (id) {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/requestmentCategory/edit.html',
                controller: 'editRequestmentCategoryCtrl',
                size: 'sm',
                keyboard: true,
                backdrop: 'static',
                resolve: {
                    requestmentCategory: function ($q, commonService) {
                        var deferred = $q.defer();
                        commonService.get('requestment-category', id, function (respone) {
                            deferred.resolve(respone.objects);
                        });

                        return deferred.promise;
                    }
                }
            });

            modalInstance.result.then(function () {
                $scope.getRequestmentCategories();
            });
        };

        $scope.add = function () {
            var modalInstance = $uibModal.open({
                templateUrl: 'app/views/requestmentCategory/add.html',
                controller: 'addRequestmentCategoryCtrl',
                size: 'sm',
                keyboard: true,
                backdrop: 'static'
            });

            modalInstance.result.then(function (data) {
                $scope.getRequestmentCategories();
            });
        };

        $scope.delete = function (id) {
            dialogMessage.open('confirm', $rootScope.$lang.is_delete, function (reponse) {
                requestmentCategoryService.delete({id: id}, function () {
                    $scope.getRequestmentCategories();
                    alertify.success($rootScope.$lang.delete_success);
                }, function (data) {
//                    if (data.message == 'is used') {
//                        alertify.error($rootScope.$lang.have_at_least_one_employee_belong_this_department_please_remove_employee_with_this_department_first);
//                    }
                });
            });
        };

        $scope.getRequest();
    }]);

appRoot.controller('editRequestmentCategoryCtrl', ['$scope', '$uibModalInstance', '$rootScope', 'alertify', 'requestmentCategoryService', 'requestmentCategory', 'commonService',
    function ($scope, $uibModalInstance, $rootScope, alertify, requestmentCategoryService, requestmentCategory, commonService) {
        $scope.requestmentCategory = requestmentCategory;
        $scope.update = function () {
            if (requestmentCategoryService.validate($scope.requestmentCategory)) {
                commonService.update('requestment-category', $scope.requestmentCategory, function (response) {
                    $scope.requestmentCategory = response.objects;
                    alertify.success($rootScope.$lang.update_success);
                    $uibModalInstance.close($scope.requestmentCategory);
                })
            }
        }

        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    }]);

appRoot.controller('addRequestmentCategoryCtrl', ['$scope', '$uibModalInstance', '$rootScope', 'alertify', 'requestmentCategoryService', 'commonService',
    function ($scope, $uibModalInstance, $rootScope, alertify, requestmentCategoryService, commonService) {
        $scope.requestmentCategory = {
            name: '',
            description: '',
        };

        $scope.add = function () {
            if (requestmentCategoryService.validate($scope.requestmentCategory)) {
                commonService.add('requestment-category', $scope.requestmentCategory, function (response) {
                    alertify.success($rootScope.$lang.add_success);
                    $uibModalInstance.close($scope.requestmentCategory);
                })
            }
        }

        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    }]);
