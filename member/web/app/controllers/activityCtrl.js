appRoot.controller('activityCtrl', ['$scope', '$rootScope', 'alertify', 'activityService', 'commonService', 'commentService',
    function ($scope, $rootScope, alertify, activityService, commonService, commentService) {
        $scope.profile = null;
        $scope.comment = '';
        $scope.activity = {
            data: null,
            total: 0,
            end: false,
            page: 1,
            busy:false
        };
        
        $scope.getActivity = function () {
            if ($scope.activity.end || $scope.activity.busy) {
                return true;
            }

            $scope.activity.busy = true;
            activityService.getActivity({currentPage: $scope.activity.page}, function (response) {
                if ($scope.activity.data) {
                     console.log($scope.activity.data);
//                    var temp = [];
//                    temp = temp.concat($scope.activity.data);
//                    $scope.activity.data = temp.concat(response.objects.activities);              
//                    $scope.activity.data = $scope.activity.data.concat(response.objects.activities);
                    $scope.activity.data = angular.extend($scope.activity.data, response.objects.activities);

                    
                } else {
                    $scope.activity.data = response.objects.activities;
                }
                                
                $scope.profile = response.objects.profile;
                $scope.activity.total = response.objects.totalCount;
                if (response.objects.activities.length < 10) {
                    $scope.activity.end = true;
                    return true;
                }
                 $scope.activity.busy = false;
            });

            $scope.activity.page++;
        }

        $scope.saveComment = function (activityId, content) {
            commonService.add('comment', {activity_id: activityId, content: content}, function (response) {
                //Append to current comment.
                if (!angular.isDefined($scope.activity.data[activityId]['comments'])) {
                    $scope.activity.data[activityId]['comments'] = response.objects.comments;
                } else {
                    $scope.activity.data[activityId]['comments'] = angular.extend($scope.activity.data[activityId]['comments'], response.objects.comments);
                }

                alertify.success($rootScope.$lang.add_success);
            });
        }
        
        $scope.like = function(activityId, commentId) {
            commentService.like({commentId: commentId}, function (response) {
                $scope.activity.data[activityId]['comments'][commentId].total_like = parseInt($scope.activity.data[activityId]['comments'][commentId].total_like) + 1;
                $scope.activity.data[activityId]['comments'][commentId].is_liked = true;
                alertify.success($rootScope.$lang.like_success);
            });
        }
        
        $scope.getActivity();
    }]);