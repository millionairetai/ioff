appRoot.controller('searchCtrl', ['$scope', 'taskService', '$uibModal', '$rootScope', 'PER_PAGE', 'MAX_PAGE_SIZE',
    function ($scope, taskService, $uibModal, $rootScope, PER_PAGE, MAX_PAGE_SIZE) {
        $scope.params = {
            page: 1,
            limit: 5,
            searchText: '',
            orderBy: '',
            orderType: ''
        };
        
        $scope.search = {
            pageTask: 1,
        };

        //array store task collection response from server
        $scope.collection = [];
        $scope.totalItems = 0;
        $scope.maxPageSize = MAX_PAGE_SIZE;

        //get list with pagination
        $scope.searchGlobal = function (type, $event) {
            if ($event != '') {
                $event.preventDefault();
            }

            //check if this tab is checked, we don't get ajax again.
//            if ($($event.target).parent().hasClass('active') && $scope.collection != []) {
//                return true;
//            }

            $scope.params.searchText = $rootScope.searchVal;
            switch (type) {
                case 'task':
                    {
                        $scope.params.page = $scope.search.pageTask;
                        taskService.getSearchGlobalTasks($scope.params, function (response) {
                            $scope.collection = response.objects.collection;
                            $scope.totalItems = response.objects.totalItems;
                        });
                    }
                    break;
                case 'event':
                    {
//                        $scope.params.page = $scope.task.pageFollow;
                    }
                    break;
                case 'project':
                    {
//                        $scope.params.page = $scope.task.pageTasks;
                    }
                    break;
            }
        };

        //initial task list
        $scope.searchGlobal('task', '');
    }]);