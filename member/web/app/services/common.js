appRoot.factory('commonService', ['$rootScope', 'apiService', 'taskService', 'projectService', 'calendarService',
    function ($rootScope, apiService, taskService, projectService, calendarService) {

        return {
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
