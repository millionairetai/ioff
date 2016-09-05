appRoot.factory('commonService', ['apiService', 'taskService', 'projectService', 'calendarService',
    function (apiService, taskService, projectService, calendarService) {

        return {
            getSearchGlobalSuggest: function (params, success, error) {
                return apiService.post('task/get-search-global-suggestion', params, success, error, 0);
            }
        };
    }]);
