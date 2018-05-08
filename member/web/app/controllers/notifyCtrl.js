appRoot.controller('notifyCtrl', ['$scope', 'notifyService', 'socketService',
    function ($scope, notifyService, socketService) {

        $scope.myNotifi = {
            notifi: null,
            total: 0,
            end: false,
            page: 1,
            busy: false
        };

        //Get notification items to show 
        $scope.getNotificationList = function () {
            if ($scope.myNotifi.end || $scope.myNotifi.busy) {
                return true;
            }

            $scope.myNotifi.busy = true;
            notifyService.getNotifications({currentPage: $scope.myNotifi.page}, function (respone) {
                if ($scope.myNotifi.notifi) {
                    $scope.myNotifi.notifi = $scope.myNotifi.notifi.concat(respone.objects.notifications);
                } else {
                    $scope.myNotifi.notifi = respone.objects.notifications;
                }

                $scope.myNotifi.total = respone.objects.totalCount;
                if (respone.objects.notifications.length < 10) {
                    $scope.myNotifi.end = true;
                    return true;
                }
                $scope.myNotifi.busy = false;
            });

            $scope.myNotifi.page++;
            socketService.emit('notify', 'ok');
        }
    }]);
