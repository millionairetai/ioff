appRoot.controller('reportCtrl', ['$scope', '$uibModal', '$rootScope', 'alertify', 'PER_PAGE', 'MAX_PAGE_SIZE',
    function ($scope, $uibModal, $rootScope, alertify, PER_PAGE, MAX_PAGE_SIZE) {
        $scope.colors=["#f56954","#00a65a","#f39c12","#00c0ef","#3c8dbc","#d2d6de"];
        //Chart donut
        $scope.labels01 = ["Hoàn thành (11)", "Đang làm(13)", "Chưa làm(8)", "Bỏ dự án (20)", "Quá hạn(40)"];
        $scope.data01 = [11, 13, 8, 20,40];
        $scope.options = {
            legend: {
                display: true,
                position:'left'
            }
        };
        //Chart pie
        $scope.labels02 = ["Hoàn thành (200%)", "Đang làm(1300%)", "Chưa làm(800%)"];
        $scope.data02 = [400, 600, 800];
    }]);