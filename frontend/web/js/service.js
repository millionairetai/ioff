angular.module('centeroffice')
        .factory('authenticateService', function ($http, $cookieStore, $q, $rootScope) {
            var curUser = {};

            return {
                login: function (user) {
                    var deferred = $q.defer();
                    return deferred.promise;
                },
                logout: function () {

                },
                changeNewPassword: function (userId, newPassword, callback) {

                },
                changePassword: function (oldPassword, newPassword, callback) {

                }
            }
        });