appRoot.factory('commonService', ['apiService', 'taskService', 'projectService', 'calendarService', '$rootScope',
    function (apiService, taskService, projectService, calendarService, $rootScope) {

        return {
            get: function (controller, id, success, error) {
                return apiService.get(controller + '/get?id=' + id, {}, success, error);
            },
            gets: function (controller, success, error) {
                return apiService.get(controller + '/gets', {}, success, error);
            },
            update: function (controller, data, success, error) {
                return apiService.post(controller + '/update', data, success, error);
            },
            updateUpload: function (controller, data, success, error) {
                return apiService.upload(controller + '/update-upload', data, success, error);
            },
            add: function (controller, data, success, error) {
                apiService.post(controller + '/add', data, success, error);
            },
            addUpload: function (controller, data, success, error) {
                apiService.upload(controller + '/add-upload', data, success, error);
            },
            getLast: function (controller, data, success, error) {
                apiService.get(controller + '/get-last', data, success, error);
            },
            delete: function (controller, data, success, error) {
                apiService.get(controller + '/delete', data, success, error);
            },
            getSearchGlobalSuggest: function (params, success, error) {
                return apiService.post('task/get-search-global-suggestion', params, success, error, 0);
            },
            redmind: function () {
                return [
                    {id: 0, name: $rootScope.$lang.calendar_event_redmine_0},
                    {id: 30, name: $rootScope.$lang.calendar_event_redmine_30},
                    {id: 60, name: $rootScope.$lang.calendar_event_redmine_60},
                    {id: 120, name: $rootScope.$lang.calendar_event_redmine_120},
                    {id: 240, name: $rootScope.$lang.calendar_event_redmine_240},
                    {id: 1440, name: $rootScope.$lang.calendar_event_redmine_1440},
                    {id: 2880, name: $rootScope.$lang.calendar_event_redmine_2880},
                ];
            }
        };
    }]);
