angular.module('centeroffice').factory('commonService', function ($http, $q, $rootScope, $state) {
    return {
        prepareState: function (url, toState, fromState) {
            return $http.post('api/' + url).success(function (data) {
                if (data) {
                    $rootScope.stateData = data;
                }

                $state.go(toState.name);
            }).error(function (data) {
                alertify.error($rootScope.$lang.you_dont_have_permission_to_access_this_page);
                $state.go(fromState.name);
                console.log(data);
            });
        },
//        canAccess: function(controller, action) {
//            var deferred = $q.defer();
//            this.get('api/auth/can?controller=' + controller + '&action=' + action).success(function(response) {
//                if (response.isPermiss) {
//                    alert(323);
//                   deferred.resolve(false);
//                } else {
//                    deferred.reject(true);
//                }
//            });
//            
//            return deferred.promise;
//        },
        processError: function (errorFunc, data, noPopupError) {
            if (!noPopupError && data) {
                switch (data.statusCode) {
                    case 403:
                        alertify.error($rootScope.$lang.you_dont_have_permission_to_access_this_page);
                        break;
                    case 404:
                        alertify.error($rootScope.$lang.page_not_found);
                        break;
                }
            }

            if (errorFunc) {
                errorFunc(data);
            }
        },
        post: function (url, data, successFunc, errorFunc, noPopupError) {
            var $this = this;
            return $http.post(url, data).success(function (data) {
                if (successFunc) {
                    successFunc(data);
                }
            }).error(function (data) {
                $this.processError(errorFunc, data, noPopupError);
            });
        },
        get: function (url, successFunc, errorFunc, noPopupError) {
            var $this = this;
            return $http.get(url).success(function (data) {
                if (successFunc) {
                    successFunc(data);
                }
            }).error(function (data) {
                $this.processError(errorFunc, data, noPopupError);
            });
        },
        put: function (url, data, successFunc, errorFunc, noPopupError) {
            var $this = this;
            return $http.put(url, data).success(function (data) {
                if (successFunc) {
                    successFunc(data);
                }
            }).error(function (data) {
                $this.processError(errorFunc, data, noPopupError);
            });
        },
        delete: function (url, successFunc, errorFunc, noPopupError) {
            var $this = this;
            return $http.delete(url).success(function (data) {
                if (successFunc) {
                    successFunc(data);
                }
            }).error(function (data) {
                $this.processError(errorFunc, data, noPopupError);
            });
        },
        http: function (config, successFunc, errorFunc, noPopupError) {
            var $this = this;
            $http(config).then(function successCallback(data) {
                if (successFunc) {
                    successFunc(data);
                }
            }, function errorCallback(data) {
                $this.processError(errorFunc, data, noPopupError);
            });
        }
    };
});