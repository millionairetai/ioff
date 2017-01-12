appRoot.controller('activityCtrl', ['$scope', '$uibModal', '$rootScope', 'alertify', 'PER_PAGE', 'MAX_PAGE_SIZE', 'activityService',
    function ($scope, $uibModal, $rootScope, alertify, PER_PAGE, MAX_PAGE_SIZE, activityService) {
        $scope.activity = {
            data: null,
            total: 0,
            end: false,
            page: 1
        };

        $scope.getActivity = function () {
            if ($scope.activity.end) {
                return true;
            }

            activityService.getActivity({currentPage: $scope.activity.page}, function (response) {
                if ($scope.activity.data) {
                    $scope.activity.data = $scope.activity.data.concat(response.objects.activities);
                } else {
                    $scope.activity.data = response.objects.activities;
                }

                $scope.activity.total = response.objects.totalCount;
                if (response.objects.activities.length < 10) {
                    $scope.activity.end = true;
                    return true;
                }
            });

            $scope.activity.page++;
        }

        $scope.getActivity();
    }]);