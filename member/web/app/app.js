appRoot = angular.module('centeroffice', ['ui.tinymce', 'ngRoute', 'ui.bootstrap', "ngAlertify", 'ui.slider', 'ui.select', 'ngTagsInput', 'ui.calendar', 'ui.bootstrap.datetimepicker', 'btford.socket-io']);

//constant for paging
appRoot.constant('PER_PAGE_VIEW_MORE', 10);
appRoot.constant('PER_PAGE', 20);
appRoot.constant('MAX_PAGE_SIZE', 10);

//constant for maximun file storage.
appRoot.constant('MAX_SIZE_UPLOAD', 10485760);
appRoot.constant('MAX_FILE_UPLOAD', 20);

//main controller
appRoot.controller('centerofficeCtrl', ['$scope', function ($scope) {
    ///////////////////////////////////
        $scope.clearCache = function() { 
        $templateCache.removeAll();
    }
    
    $scope.clearCache();
    ///////////////////////////
}]);

// run project
appRoot.run(function ($rootScope, socketService, notifyService) {
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
    
    /////////////////////
        /*pagination*/
    $rootScope.getPaginationPages = function(totalCount,paginationSize,countPerPage,currentPage){
        var totalPages = Math.ceil(totalCount / countPerPage);
        var pages = [];
        var start = currentPage - Math.floor(paginationSize/2);
        var finish = null;

        if((start + paginationSize - 1) > totalPages){
            start = totalPages - paginationSize;
        }
        if(start <= 0) {
            start = 1;
        }

       finish = start +  paginationSize - 1;
       if(finish > totalPages){
           finish = totalPages;
       }


        for (var i = start; i <= finish; i++) {
            pages.push(i);
        }

        return pages;
    }
    /////////////////////////
});
