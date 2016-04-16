appRoot.factory('apiService', ['$rootScope', '$http', '$location', 'alertify', function ($rootScope, $http, $location, alertify) {

        return {
            //post
            post: function (url, data, successHandler, errorHandler) {
                $rootScope.progressing = true;
                return $http.post(url, data).success(function (response, status, headers, config) {
                    //chi xu ly khi status bằng 200
                    if (status == 200) {
                        if (response.error) {
                            alertify.error(response.message);
                            if (typeof errorHandler == "function") {
                                errorHandler(response);
                            }
                        } else {
                            successHandler(response);
                        }
                    } else {
                        $location.path('/login');
                    }
                    
                    $rootScope.progressing = false;
                }).error(function (data, status, headers, config) {
                    $rootScope.progressing = false;
                    console.log('error', status);
                });
            },
            //get
            get: function (url, data, successHandler, errorHandler) {
                $rootScope.progressing = true;
                return $http.get(url, {params: data}).success(function (response, status, headers, config) {
                    //chi xu ly khi status bằng 200
                    if (status == 200) {
                        if (response.error) {
                            alertify.error(response.message);
                            if (typeof errorHandler == "function") {
                                errorHandler(response);
                            }
                        } else {
                            successHandler(response);
                        }
                    } else {
                        $location.path('/login');
                    }
                    $rootScope.progressing = false;
                }).error(function (response, status, headers, config) {
                    $rootScope.progressing = false;
                    console.log(response);
                });
            },
            //put
            put: function (url, data, successHandler, errorHandler) {
                $rootScope.progressing = true;
                return $http.put(url, data).success(function (response, status, headers, config) {
                    //chi xu ly khi status bằng 200
                    if (status == 200) {
                        if (response.error) {
                            alertify.error(response.message);
                            if (typeof errorHandler == "function") {
                                errorHandler(response);
                            }
                        } else {
                            successHandler(response);
                        }
                    } else {
                        $location.path('/login');
                    }
                    $rootScope.progressing = false;
                }).error(function (data, status, headers, config) {
                    $rootScope.progressing = false;
                    console.log('error', status);
                });
            },
            //delete
            delete: function (url, data, successHandler, errorHandler) {
                $rootScope.progressing = true;
                return $http.delete(url, {params: data}).success(function (response, status, headers, config) {
                    //chi xu ly khi status bằng 200
                    if (status == 200) {
                        if (response.error) {
                            alertify.error(response.message);
                            if (typeof errorHandler == "function") {
                                errorHandler(response);
                            }
                        } else {
                            successHandler(response);
                        }
                    } else {
                        $location.path('/login');
                    }
                    $rootScope.progressing = false;
                }).error(function (data, status, headers, config) {
                    $rootScope.progressing = false;
                    console.log('error', status);
                });
            },
            //upload file
            upload: function (url, data, successHandler, errorHandler) {
                $rootScope.progressing = true;
                return $http.post(url, data, {
                    withCredentials: true,
                    headers: {'Content-Type': undefined},
                    transformRequest: angular.identity
                }).success(function (response, status, headers, config) {
                    //chi xu ly khi status bằng 200
                    if (status == 200) {
                        if (response.error) {
                            alertify.error(response.message);
                            if (typeof errorHandler == "function") {
                                errorHandler(response);
                            }
                        } else {
                            successHandler(response);
                        }
                    } else {
                        $location.path('/login');
                    }
                    $rootScope.progressing = false;
                }).error(function (data, status, headers, config) {
                    $rootScope.progressing = false;
                    console.log('error', status);
                });
            },
        };
    }]);