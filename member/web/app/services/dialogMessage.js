appRoot.factory('dialogMessage', ['$rootScope', "$uibModal", function ($rootScope, $uibModal) {

        return {
            open: function (type, message, handle) {
                var modalInstance = $uibModal.open({
                    templateUrl: 'app/views/widgets/dialogMessage.html',
                    controller: 'dialogMessage',
                    size: 'sm',
                    resolve: {
                        data: function () {
                            return {
                                type: type,
                                message: message
                            };
                        }
                    }
                });
                modalInstance.result.then(function (data) {
                    handle(data);
                }, function () {
                });
            },
        };
    }]);


