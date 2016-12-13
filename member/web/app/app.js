appRoot = angular.module('iofficez',
        ['ui.tinymce', 'ngRoute', 'ui.bootstrap', "ngAlertify", 'ui.slider', 'ui.select', 'ngTagsInput',
            'ui.calendar', 'ui.bootstrap.datetimepicker', 'btford.socket-io', 'infinite-scroll', 'autocomplete', 'chart.js']);

//constant for paging
appRoot.constant('PER_PAGE_VIEW_MORE', 10);
appRoot.constant('PER_PAGE', 20);
appRoot.constant('MAX_PAGE_SIZE', 10);

//constant for maximun file storage.
appRoot.constant('MAX_SIZE_UPLOAD', 10485760);
appRoot.constant('MAX_FILE_UPLOAD', 20);

//main controller
appRoot.controller('iofficezCtrl', ['$scope', function ($scope) {

    }]);

// run project
appRoot.run(function ($rootScope, socketService, notifyService, taskService, commonService, $sce, authorityService) {
    //Get auth array to check.
    authorityService.getEmployeeAuth({}, function (respone) {
        $rootScope.auth = respone.objects;
    });
    //init for notification number.
    notifyService.countNotification({}, function (respone) {
        $rootScope.sum_notify = respone.objects;
    });
    //Get notification when broadcast.
    socketService.on('broadcast', function (data) {
        notifyService.countNotification({}, function (respone) {
            $rootScope.sum_notify = respone.objects;
        });
    });
    //Get notification items to show 
    $rootScope.getNotifications = function () {
        notifyService.getNotifications({}, function (respone) {
            $rootScope.notifications = respone.objects.collection;
        });
    }
    //
    $rootScope.getHtml = function (html) {
        return $sce.trustAsHtml(html);
    };
    //Get my task and show items on dropdown.
    $rootScope.myTasks = {
        task: null,
        total: 0,
        end: false
    };
    var currentPage = 1;
    //Get task for dropdown when loading page.
    taskService.getMyTaskForDropdown({currentPage: currentPage}, function (respone) {
        $rootScope.myTasks.task = respone.objects.collection;
        $rootScope.myTasks.total = respone.objects.totalCount;
        if (respone.objects.collection.length < 10) {
            $rootScope.myTasks.end = true;
            return true;
        }
        currentPage++;
    });
    //Get my task again when clicking on icon.
    $rootScope.getMyTaskDropdownClick = function () {
        currentPage = 0;
        $rootScope.myTasks = {
            task: null,
            total: 0,
            end: false
        };

        $rootScope.getMyTaskDropdownScroll();
    }
    //Get more task when scrolling down the scrollbar at the end.
    $rootScope.getMyTaskDropdownScroll = function () {
        if ($rootScope.myTasks.end) {
            return true;
        }
        
        taskService.getMyTaskForDropdown({currentPage: currentPage}, function (respone) {
            if ($rootScope.myTasks.task) {
                $rootScope.myTasks.task = $rootScope.myTasks.task.concat(respone.objects.collection);
                $rootScope.myTasks.total = respone.objects.totalCount;
            } else {
                $rootScope.myTasks.task = respone.objects.collection;
                $rootScope.myTasks.total = respone.objects.totalCount;
            }

            if (respone.objects.collection.length < 10) {
                $rootScope.myTasks.end = true;
                return true;
            }
            
            currentPage++;
        });
    }
    //Seach global dropdown
    $rootScope.searchGlobalItems = [];
    $rootScope.searchGlobalType = '';
    $rootScope.searchGlobalTypeCode = 'task';
    $rootScope.searchVal = '';
    $rootScope.selectSearchGlobalType = function (type, typeCode) {
        $rootScope.searchGlobalType = type;
        $rootScope.searchGlobalTypeCode = typeCode;
    }

    $rootScope.getSuggestSearchGlobal = function (val) {
        if (!val.trim()) {
            $rootScope.searchGlobalItems = null;
            return true;
        }

        $rootScope.searchVal = val;
        commonService.getSearchGlobalSuggest({val: val, typeSearch: $rootScope.searchGlobalTypeCode}, function (res) {
            $rootScope.searchGlobalItems = res.objects.collection;
        });
    }

    $rootScope.showItemSearchGlobal = function (suggestion) {

    }
});
