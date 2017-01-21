appRoot.controller('activityCtrl', ['$scope', '$rootScope', 'alertify', 'activityService', 'commonService', 'commentService', 'validateService', 'departmentService', 'employeeService',
    function ($scope, $rootScope, alertify, activityService, commonService, commentService, validateService, departmentService, employeeService) {
        $scope.profile = null;
        $scope.comment = '';
        $scope.activity = {
            data: null,
            total: 0,
            end: false,
            page: 1,
            busy: false
        };

        //Message tab.
        $scope.message = {
            all: true,
            content: '',
            option: false,
            departments: [],
            employees: []
        };
        
                //get all department
        departmentService.allDepartment({}, function (data) {
            $scope.departments = data.objects;
        });

        //add employee
        $scope.getEmployees = function (keyword) {
            employeeService.searchEmployee({keyword: keyword}, function (response) {
                $scope.employees = response.objects;
            });
        };
        
        var temp = [];
        $scope.getActivity = function () {
            if ($scope.activity.end || $scope.activity.busy) {
                return true;
            }

            $scope.activity.busy = true;
            activityService.getActivity({currentPage: $scope.activity.page}, function (response) {
                //Must transform object to array because object automatically arrange item by numeric key.
                temp = Object.keys(response.objects.activities).map(function (k) {
                    return response.objects.activities[k]
                });
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
                $scope.activity.data[index].total_comment = parseInt($scope.activity.data[index].total_comment) + 1;
                alertify.success($rootScope.$lang.add_success);
            });
        }

        $scope.likeComment = function (indexActivity, commentId) {
            commentService.like({commentId: commentId}, function (response) {
                $scope.activity.data[indexActivity]['comments'][commentId].total_like = parseInt($scope.activity.data[indexActivity]['comments'][commentId].total_like) + 1;
                $scope.activity.data[indexActivity]['comments'][commentId].is_liked = true;
                alertify.success($rootScope.$lang.like_success);
            });
        }

        $scope.likeActivity = function (indexActivity, activityId) {
            activityService.like({activityId: activityId}, function (response) {
                $scope.activity.data[indexActivity].total_like = parseInt($scope.activity.data[indexActivity].total_like) + 1;
                $scope.activity.data[indexActivity].is_liked = true;
                alertify.success($rootScope.$lang.like_success);
            });
        }

        $scope.addMessage = function () {
            activityService.addMessage($scope.message, function (response) {
                $scope.message.content = '';
                $scope.activity.data.unshift(response.objects.activity);
                $scope.message.employees = [];
                $scope.message.departments = [];
                $scope.message.option = false;
                $scope.message.all = true;
                alertify.success($rootScope.$lang.add_success);
            });
        }
        
        $scope.a = function () {
            $scope.message.option = true;
            $scope.message.all = false;
        }
        
        $scope.getActivity();
    }]);