
appRoot.directive('searchEmployee', ['employeeService', '$modal', function (employeeService, $modal) {
        return {
            restrict: 'E',
            scope: {
                handle: '=handle',
                departments : "=?departments",
                members : "=?members"
            },
            templateUrl: 'app/views/widgets/searchEmployee.html',
            controller: ['$scope', '$element', '$attrs', function ($scope, $element, $attrs) {
                    var departments = [];
                    if(typeof $scope.departments !== 'undefined'){
                        departments = $scope.departments;
                    }
                    
                    
                    //find product
                    $scope.keyword = "";
                    $scope.searchEmployee = function (keyword) {
                        return  employeeService.searchEmployee({keyword: keyword,departments:$scope.departments,members:$scope.members}, function (response) {
                        }).then(function (response) {
                                    return response.data.objects;
                            });
                    };

                    //handle selected
                    $scope.handleSelected = function ($item, $model, $label) {
                        $scope.handle($item, $model, $label);
                        $scope.keyword = "";
                    }

                }]
        };
    }]);