appRoot.controller('searchCtrl', ['$scope', 'taskService', 'eventService', 'projectService', '$uibModal', '$rootScope', 'PER_PAGE', 'MAX_PAGE_SIZE',
    function ($scope, taskService, eventService, projectService,$uibModal, $rootScope, PER_PAGE, MAX_PAGE_SIZE) {
        $scope.params = {
            page: 1,
            limit: 10,
            searchText: '',
            orderBy: '',
            orderType: ''
        };

        $scope.search = {
            pageTask: 1,
            pageEvent: 1,
            pageProject: 1
        };

        //array store item collection response from server
        $scope.collection = [];
        $scope.totalItems = 0;
        $scope.maxPageSize = MAX_PAGE_SIZE;
        //get list with pagination
        $scope.searchGlobal = function (type, $event) {
            if ($event != '') {
                $event.preventDefault();
            }

            //check if this tab is checked, we don't get ajax again.
            if ($($event.target).parent().hasClass('active') && $scope.collection != []) {
                return true;
            }

            $scope.params.searchText = $rootScope.searchVal;
            $('li').removeClass('active');
            $('#task').removeClass('active');
            $('#event').removeClass('active');
            $('#project').removeClass('active');
            switch (type) {
                case 'task': {
                        $('.task').addClass('active');
                        $('#task').addClass('active');
                        $scope.params.page = $scope.search.pageTask;
                        taskService.getSearchGlobalTasks($scope.params, function (response) {
                            $scope.collection = response.objects.collection;
                            $scope.totalItems = response.objects.totalItems;
                        });
                    }
                    break;
                case 'event': {
                        $('.event').addClass('active');
                        $('#event').addClass('active');
                        $scope.params.page = $scope.search.pageEvent;
                        eventService.getSearchGlobalEvents($scope.params, function (response) {
                            $scope.collection = response.objects.events;
                            $scope.totalItems = response.objects.totalCount;
                        });
                    }
                    break;
                case 'project': {
                         $('.project').addClass('active');
                         $('#project').addClass('active');
                        $scope.params.page = $scope.search.pageProject;
                        projectService.getSearchGlobalProjects($scope.params, function (response) {
                            $scope.collection = response.objects.projects;
                            $scope.totalItems = response.objects.totalCount;
                        });
                    }
                    break;
            }
        };

        //initial task list
        $scope.searchGlobal($rootScope.searchGlobalTypeCode, '');
    }]);