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
});
