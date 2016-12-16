appRoot.controller('CompanyCtrl', ['$scope', 'companyService', '$rootScope', 'alertify', 
    function ($scope, companyService, $rootScope, alertify) {
        $scope.company = null;
        $scope.getCompany = function () {
            companyService.getOne({}, function (response) {
                $scope.company = response.objects.company;
            });
        };

        $scope.getCompany();
    }]);