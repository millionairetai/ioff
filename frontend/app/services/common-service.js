angular.module('centeroffice').factory('commonService', function ($http, $q, $rootScope) {
    return {
        prepareState: function (url) {
            var deferred = $q.defer();

            return $http.post('api/' + url).success(function (data) {
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