appRoot.factory('authorityService', ['apiService', '$http', function (apiService, $http) {

        return {
            add: function (data, success, error) {
                apiService.post('authority/add', data, success, error);
            },
            edit: function (data, success, error) {
                apiService.post('authority/edit', data, success, error);
            },
            findAll: function (params, success, error) {
                apiService.get('authority', params, success, error);
            },
            findAllAssignments: function (params, success, error) {
                apiService.get('authority/get-assignments', params, success, error);
            },
            delete: function (data, success, error) {
                apiService.post('authority/delete', data, success, error);
            }
        };
    }]);
