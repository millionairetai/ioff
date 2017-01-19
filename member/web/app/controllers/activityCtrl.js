appRoot.controller('activityCtrl', ['$scope', '$rootScope', 'alertify', 'activityService', 'commonService', 'commentService', 'validateService',
    function ($scope, $rootScope, alertify, activityService, commonService, commentService, validateService) {
        $scope.profile = null;
        $scope.comment = '';
        $scope.activity = {
            data: null,
            total: 0,
            end: false,
            page: 1,
            busy:false
        };
        var temp = [];
        $scope.getActivity = function () {
            if ($scope.activity.end || $scope.activity.busy) {
                return true;
            }

            $scope.activity.busy = true;
            activityService.getActivity({currentPage: $scope.activity.page}, function (response) {
                //Must transform object to array because object automatically arrange item by numeric key.
                temp = Object.keys(response.objects.activities).map(function(k) { return response.objects.activities[k] });                
                //Reverse max key to top head, beause they have just created.
                temp.reverse();
                if ($scope.activity.data === null) {
                    $scope.activity.data = temp;
                } else {
                    $scope.activity.data = $scope.activity.data.concat(temp);
                }
                
                $scope.profile = response.objects.profile;
                $scope.activity.total = response.objects.totalCount;
                if (temp.length < 10) {
                    $scope.activity.end = true;
                    return true;
                }
                 $scope.activity.busy = false;
            });

            $scope.activity.page++;
        }

        $scope.saveComment = function (index, activityId, content) {
            if (!validateService.required(content)) {
                return false;
            }
            commonService.add('comment', {activity_id: activityId, content: content}, function (response) {
                //Append to current comment.
                if (!angular.isDefined($scope.activity.data[index]['comments'])) {
                    $scope.activity.data[index]['comments'] = response.objects.comments;
                } else {
                    $scope.activity.data[index]['comments'] = angular.extend($scope.activity.data[index]['comments'], response.objects.comments);
                }

                alertify.success($rootScope.$lang.add_success);
            });
        }
        
        $scope.likeComment = function(indexActivity, commentId) {
            commentService.like({commentId: commentId}, function (response) {
                $scope.activity.data[indexActivity]['comments'][commentId].total_like = parseInt($scope.activity.data[indexActivity]['comments'][commentId].total_like) + 1;
                $scope.activity.data[indexActivity]['comments'][commentId].is_liked = true;
                alertify.success($rootScope.$lang.like_success);
            });
        }
        
        $scope.getActivity();
    }]);