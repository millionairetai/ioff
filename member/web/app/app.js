appRoot = angular.module('centeroffice', ['ui.tinymce', 'ngRoute', 'ui.bootstrap', "ngAlertify", 'ui.slider', 'ui.select', 'ngTagsInput', 'ui.calendar', 'ui.bootstrap.datetimepicker', 'btford.socket-io']);

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
