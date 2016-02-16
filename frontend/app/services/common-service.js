angular.module('centeroffice').factory('commonService', function ($http, $q, $rootScope) {
    return {
        prepareState: function (stateName) {
            var deferred = $q.defer();

            return $http.post('api/' + stateName.replace('.', '/')).success(function (data) {
                if (data) {
                    $rootScope.stateData = data;
                }
                deferred.resolve(data);
            }).error(function (data) {
                deferred.reject(data);
            });

            return deferred.promise;
        }
    };
});