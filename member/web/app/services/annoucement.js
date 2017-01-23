appRoot.factory('annoucementService', ['apiService', function (apiService) {

        return {
            validate: function() {
               return true; 
            }, 
            add: function (data, success, error) {
                return apiService.post('annoucement/add', data, success, error);
            },
            getAnnoucements: function (data, success, error) {
                return apiService.get('annoucement/get-annoucements', data, success, error);
            }
        };
    }]);
