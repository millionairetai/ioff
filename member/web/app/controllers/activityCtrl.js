appRoot.controller('activityCtrl', ['$scope', '$rootScope', 'alertify', 'activityService', 'commonService', 'commentService', 'validateService', 'departmentService', 'employeeService', 'activityPostService', 'annoucementService', '$routeParams', 'requestmentService',
    function ($scope, $rootScope, alertify, activityService, commonService, commentService, validateService, departmentService, employeeService, activityPostService, annoucementService, $routeParams, requestmentService) {
        $scope.annoucements = {
            data: [],
            totalPage: 0,
            currentPage: 1
        };
        $scope.profile = null;
        $scope.comment = '';
        $scope.activity = {
            data: null,
            total: 0,
            end: false,
            page: 1,
            busy: false,
            activityId: $routeParams.activityId
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
            activityService.getActivity({currentPage: $scope.activity.page, activityId: $scope.activity.activityId}, function (response) {
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
                if ($scope.activity.data.length >= $scope.activity.total) {
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
            activityPostService.addMessage($scope.message, function (response) {
                $scope.message.content = '';
                $scope.activity.data.unshift(response.objects.activity);
                $scope.message.employees = [];
                $scope.message.departments = [];
                $scope.message.option = false;
                $scope.message.all = true;
                alertify.success($rootScope.$lang.add_success);
            });
        }

        $scope.initializeTab = function ($event) {
            if ($event != '') {
                $event.preventDefault();
            }
        }

        //-------------annoucment -------//
        $scope.annoucemnt = {
            title: '',
            description: '',
            is_importance: false,
            date_new_to: '',
            sms: false
//            departments: [],
//            employees: []
        };

        $scope.addAnnoucement = function () {
            if (!annoucementService.validate($scope.annoucemnt)) {
                return false;
            }

            annoucementService.add($scope.annoucemnt, function (response) {
                $scope.activity.data.unshift(response.objects.activity);
                $scope.annoucemnt = {
                    title: '',
                    description: '',
                    is_importance: false,
                    date_new_to: '',
                    sms: false
                };
                $scope.getAnnoucements('');
                alertify.success($rootScope.$lang.add_success);
            });
        }

        $scope.getAnnoucements = function (typePage) {
            if (typePage == 'next') {
                if ($scope.annoucements.currentPage >= $scope.annoucements.totalPage) {
                    return false;
                }
                $scope.annoucements.currentPage = $scope.annoucements.currentPage + 1;
            }

            if (typePage == 'previous') {
                if ($scope.annoucements.currentPage == 1) {
                    return false;
                }
                $scope.annoucements.currentPage = $scope.annoucements.currentPage - 1;
            }

            annoucementService.getAnnoucements({currentPage: $scope.annoucements.currentPage}, function (response) {
                temp = Object.keys(response.objects.annoucements).map(function (k) {
                    return response.objects.annoucements[k]
                });
                //Reverse max key to top head, beause they have just created.
                temp.reverse()
                $scope.annoucements.data = temp;
                $scope.annoucements.totalPage = response.objects.totalPage;
            });
        }

        //requestment member
        $scope.requestment = {
            title: '',
            description: '',
            from_datetime: '',
            to_datetime: '',
            requestment_category_id: 0,
            review_employee: [],
            review_employee_id: 0,
            sms: false
//            departments: [],
//            employees: []
        };

        commonService.gets('requestment-category', function (response) {
            $scope.requestmentCategory = response.objects;
        });

        $scope.selectReviewer = function ($item, $model) {
            $scope.getEmployees('');
        };

        //clear manager
        $scope.clearReviewer = function () {
            $scope.requestment.review_employee = null;
        }

        $scope.addRequestment = function () {
            if (!requestmentService.validate($scope.requestment)) {
                return false;
            }

            $scope.requestment.review_employee_id = $scope.requestment.review_employee.id;
            requestmentService.add($scope.requestment, function (response) {
                response.objects.requestment = angular.merge({
                    requestment:{avatar_to:$scope.requestment.review_employee.image},
                }, response.objects.requestment)
                $scope.activity.data.unshift(response.objects.requestment);
                $scope.requestment = {
                    title: '',
                    description: '',
                    from_datetime: '',
                    to_datetime: '',
                    requestment_category_id: 0,
                    review_employee: [],
                    review_employee_id: 0,
                    sms: false
                };
                alertify.success($rootScope.$lang.add_success);
            });
        }



        $scope.getActivity();
        $scope.getAnnoucements('all');
    }]);