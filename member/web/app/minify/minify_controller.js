//show calendar
appRoot.controller('calendarCtrl', ['$scope',function($scope) {
    
}]);

//add event to calendar
appRoot.controller('addEventCtrl', ['$scope',function($scope) {
    
}]);


// show dialog
appRoot.controller('dialogMessage', [ '$rootScope','$scope', '$modalInstance','data','$sce', function ( $rootScope,$scope, $modalInstance,data,$sce) {
        $scope.class_header = "dialog-header-error";
        $scope.show_save = false;
        $scope.title = $rootScope.$lang.title_error_dialog;
        if(data.type == 'confirm'){
            $scope.title = $rootScope.$lang.title_confirm_dialog;
            $scope.class_header = "dialog-header-wait";
            $scope.show_save = true;
        }
        //
        
        $scope.message = $sce.trustAsHtml(data.message);
        //
        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        };
        //
        $scope.save = function () {
            $modalInstance.close('save');
        };
        
    }]);

//
appRoot.controller('homeCtrl', ['$scope','dialogMessage','alertify',function($scope,dialogMessage,alertify) {
    
    $scope.errorDialog = function(){
        alertify.success("Welcome to alertify!");
    };
    
    $scope.confirmDialog = function(){
        dialogMessage.open('confirm','message error',function(data){
            alert('12');
        });
    };
    
    
}]);


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


