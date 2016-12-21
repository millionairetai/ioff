appRoot.controller('reportCtrl', ['$scope', '$uibModal', '$rootScope', 'alertify', 'taskService', 'commonService',
    function ($scope, $uibModal, $rootScope, alertify, taskService, commonService) {
        $scope.reports = [];
        $scope.projects = [];
        $scope.projectId = 0;
        $scope.totalTask = 0;
        $scope.colors = ["#00a65a", "#f56954", "#f39c12", "#00c0ef"];
        //Employee tab
        $scope.empTabProjectId = 0;
        $scope.chart = {
            colors: [],
            taskReportLabels: [],
            taskdataReport: [],
            options: {
                legend: {
                    display: true,
                    position: 'left'
                }
            }
        };

        commonService.gets('project', function (response) {
            $scope.projects = response.objects;
        });

        $scope.getTaskReport = function () {
            var id = 0;
            if ($scope.projectId) {
                id = $scope.projectId.id;
            } else {
                id = 0;
            }

            taskService.getTaskReport({projectId: id}, function (response) {
                $scope.reports = response.objects;
                $scope.chart.colors = [];
                $scope.chart.taskReportLabels = [];
                $scope.chart.taskdataReport = [];
                $scope.totalTask = 0;
                //Sum
                if ($scope.reports.length > 0) {
                    angular.forEach($scope.reports, function (value, key) {
                        $scope.totalTask += parseInt(value.number_task);
                    })
                }

                if ($scope.reports.length > 0) {
                    angular.forEach($scope.reports, function (value, key) {
                        $scope.chart.taskReportLabels[key] = value.status_name + '(' + value.number_task + ' '+ $rootScope.$lang.task +'- ' 
                                + $rootScope.$lang.about + ':' + Math.floor((value.number_task / $scope.totalTask) * 100) + '%)';
                        $scope.chart.taskdataReport[key] = value.number_task;
                        $scope.chart.colors[key] = $scope.colors[key];
                    })
                }
            });
        };

        $scope.getTaskReport();

        //Employee tab
        $scope.empTaskReports = [];
        $scope.empTaskTotalHour = 0;
        $scope.getEmployeeTaskReport = function () {
            var id = 0;
            $scope.empTaskTotalHour = 0;
            if ($scope.empTabProjectId) {
                id = $scope.empTabProjectId.id;
            } else {
                id = 0;
            }

            taskService.getEmpTaskReport({projectId: id}, function (response) {
                $scope.empTaskReports = response.objects;
                if ($scope.empTaskReports.length > 0) {
                    angular.forEach($scope.empTaskReports, function (value, key) {
                        value.total_hour = (value.total_hour != null && value.total_hour != '') ? value.total_hour : 0;
                        $scope.empTaskTotalHour += parseInt(value.total_hour);
                    })
                    
                    angular.forEach($scope.empTaskReports, function (value, key) {
                        value['hour_percent'] = (($scope.empTaskTotalHour != null && $scope.empTaskTotalHour != 0)
                                ? Math.floor((value.total_hour / $scope.empTaskTotalHour) * 100) : 0);
                    })
                }
            });
        };

        $scope.getEmployeeTaskReport();
    }]);