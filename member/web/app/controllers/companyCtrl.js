appRoot.controller('CompanyCtrl', ['$scope', 'companyService', '$rootScope', 'alertify',
    function ($scope, companyService, $rootScope, alertify) {
        $scope.company = null;
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
            size:150
        };
        
        $scope.usingUserPercentValue=0;
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
            size:150
        };

        $scope.getCompany = function () {
            companyService.getOne({}, function (response) {
                $scope.company = response.objects.company;
                $scope.usingUserPercentValue = $scope.company.using_user_percent;
                $scope.usingStoragePercentValue = $scope.company.using_storage_percent;
            });
        };

        $scope.getCompany();
    }]);