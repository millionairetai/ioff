//list project
appRoot.controller('projectCtrl', ['$scope', 'projectService', function ($scope, projectService) {
        //get all project
        $scope.collection = [];
        projectService.listProject({}, function (response) {
            $scope.collection = response.objects;
        });
    }]);

//add project
appRoot.controller('addProjectCtrl', ['$scope', 'projectService','$location','alertify','$rootScope', function ($scope, projectService,$location,alertify,$rootScope) {
        $scope.object = {
            title: '',
            description: '',
        };

        $scope.save = function () {
            projectService.addProject($scope.object, function (response) {
                alertify.success($rootScope.$lang.success_add_project);
                $location.path('/project');
            });
        }
    }]);


