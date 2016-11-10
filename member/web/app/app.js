appRoot = angular.module('iofficez',
        ['ui.tinymce', 'ngRoute', 'ui.bootstrap', "ngAlertify", 'ui.slider', 'ui.select', 'ngTagsInput',
            'ui.calendar', 'ui.bootstrap.datetimepicker', 'btford.socket-io', 'infinite-scroll', 'autocomplete']);

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
appRoot.run(function ($rootScope, socketService, notifyService, taskService, commonService, $sce) {
    //init
    notifyService.countNotification({}, function (respone) {
        $rootScope.sum_notify = respone.objects;
    });

    //Get notification
    socketService.on('broadcast', function (data) {
        notifyService.countNotification({}, function (respone) {
            $rootScope.sum_notify = respone.objects;
        });
    });

    $rootScope.getNotifications = function () {
        notifyService.getNotifications({}, function (respone) {
            $rootScope.notifications = respone.objects.collection;
        });
    }

    $rootScope.getHtml = function (html) {
        return $sce.trustAsHtml(html);
    };

    $rootScope.myTasks = null;
    var currentPage = 1;
    $rootScope.getTaskForDropdown = function () {
        taskService.getTaskForDropdown({currentPage: currentPage}, function (respone) {
            if ($rootScope.myTasks) {
                $rootScope.myTasks = angular.merge($rootScope.myTasks.concat(respone.objects.collection), respone.objects.collection);
            }else {
                $rootScope.myTasks = respone.objects.collection;
            }
            currentPage++;
            $rootScope.taskDropdown =  $rootScope.myTasks;
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
