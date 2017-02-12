appRoot.controller('changePackageCtrl', ['$scope', '$uibModal', '$rootScope', 'alertify', 'PER_PAGE', 'MAX_PAGE_SIZE', 'companyService', 'planTypeService', 'commonService',
    function ($scope, $uibModal, $rootScope, alertify, PER_PAGE, MAX_PAGE_SIZE, companyService, planTypeService, commonService) {
        $scope.company = null;
        $scope.planTypes = [];
        $scope.plan_type_id = null;

        $scope.usingStoragePercentValue = 0;
        $scope.maxStorageOptions = {
            skin: {
                type: 'tron',
                width: 2,
                color: 'rgb(135, 206, 235)',
                spaceWidth: 3
            },
            barColor: 'rgb(135, 206, 235)',
            trackWidth: 30,
            barWidth: 30,
            textColor: 'rgb(135, 206, 235)',
            step: 0.1,
            unit: '%',
            size: 150
        };

        $scope.usingUserPercentValue = 0;
        $scope.maxUserOptions = {
            skin: {
                type: 'tron',
                width: 2,
                color: 'red',
                spaceWidth: 3
            },
            barColor: 'red',
            trackWidth: 30,
            barWidth: 30,
            textColor: 'red',
            step: 0.1,
            unit: '%',
            size: 150
        };

        $scope.getCompany = function () {
            return companyService.getOne({}, function (response) {
                $scope.company = response.objects.company;
                $scope.usingUserPercentValue = $scope.company.using_user_percent;
                $scope.usingStoragePercentValue = $scope.company.using_storage_percent;
                $scope.plan_type_id = $scope.company.plan_type_id;
            });
        };


        //Slider
        $scope.package = {
            planType: '',
            numberMonth: 0,
            maxUser: {
                value: 40,
            },
            maxStorage: {
                value: 20,
            }
        };
        $scope.getCompany().then(function (data) {
            commonService.gets('plan-type', function (response) {
                $scope.planTypes = response.objects;
                if ($scope.planTypes.length > 0) {
                    angular.forEach($scope.planTypes, function (val, key) {
                        if (val.id == $scope.company.plan_type_id) {
                            $scope.company.plan_type_id = val;
                            $scope.package.planType = $scope.company.plan_type_id.name
                            console.log($scope.company.plan_type_id);
                        }
                    });
                }
            });
        });

        //Invoice info.
        $scope.infoInvoice = null;
        $scope.periodTimes = [];

        commonService.gets('period-time', function (response) {
            $scope.periodTimes = response.objects;
        });

        $scope.changePackage = function () {
            $scope.package.planType = $scope.company.plan_type_id.name
            var packageInfo = {
                maxUser: $scope.package.maxUser.value, 
                maxStorage: $scope.package.maxStorage.value,
                numberMonth: $scope.package.numberMonth.month_value,
                planType: $scope.company.plan_type_id.name
            };
            
            if ($scope.infoInvoice) {
                angular.extend(packageInfo, {saveOrder: true});
            }
            
            if (packageInfo.planType != 'Free' && !companyService.validate(packageInfo)) {
                return ;
            }
            
            companyService.changePackage(packageInfo, function (response) {
                $scope.infoInvoice = response.objects.infoInvoice;
            });
        }

    }]);