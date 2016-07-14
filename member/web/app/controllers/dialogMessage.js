// show dialog
appRoot.controller('dialogMessage', [ '$rootScope','$scope', '$uibModalInstance','data','$sce', function ( $rootScope,$scope, $uibModalInstance,data,$sce) {
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
            $uibModalInstance.dismiss('cancel');
        };
        //
        $scope.save = function () {
            $uibModalInstance.close('save');
        };
        
    }]);

