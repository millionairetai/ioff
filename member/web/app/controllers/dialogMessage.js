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

