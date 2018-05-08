appRoot.factory('taskGroupService', ['apiService', '$rootScope', 'alertify', function (apiService, $rootScope, alertify) {

        return {
            getTaskGroups: function (data, success, error) {
                apiService.get('task-group/get-task-groups', data, success, error);
            }
        };
    }]);
