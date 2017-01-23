appRoot.factory('annoucementService', ['apiService', function (apiService) {

        return {
            validate: function() {
               return true; 
            }, 
            add: function (data, success, error) {
                return apiService.post('annoucement/add', data, success, error);
            }
        };
    }]);
