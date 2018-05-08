appRoot.factory('commentService', ['apiService', function (apiService) {

        return {
            like: function (data, success, error) {
                return apiService.post('comment/like', data, success, error);
            }
        };
    }]);
