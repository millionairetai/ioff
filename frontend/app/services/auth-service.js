angular.module('centeroffice').factory('authService', function ($http, userService, $cookieStore, $q, $rootScope) {
    var currentUser = {};

    return {
        /**
         * Authenticate user and save token
         *
         * @param  {Object}   user     - login info
         * @param  {Function} callback - optional
         * @return {Promise}
         */
        login: function (employee) {
            var deferred = $q.defer();

            return $http.post('api/auth/login', employee).success(function (data) {
                if (data) {
                    $cookieStore.put('token', data.token);
                }
                deferred.resolve(data);
            }).error(function (data) {
                deferred.reject(data);
            });

            return deferred.promise;
        },
        /**
         * Delete access token and user info
         *
         * @param  {Function}
         */
        logout: function () {
            var deferred = $q.defer();

            return $http.post('api/auth/logout').success(function (data) {
                if (data) {
                    $cookieStore.remove('token');
                    $rootScope.token = null;
                    $rootScope.currUser = {};
                    currentUser = {};
                }

                deferred.resolve(data);
            }).error(function (data) {
                deferred.reject(data);
            });

            return deferred.promise;
        },
        /**
         * Change password
         *
         * @param  {String}   oldPassword
         * @param  {String}   newPassword
         * @param  {Function} callback    - optional
         * @return {Promise}
         */
        changeNewPassword: function (userId, newPassword, callback) {
            var cb = callback || angular.noop;
            return userService.changeNewPassword({id: userId}, {
                newPassword: newPassword
            }, function (user) {
                return  user;
            }).$promise.then(function (result) {
                return result;
            });
        },
        changePassword: function (oldPassword, newPassword, callback) {
            var cb = callback || angular.noop;

            return userService.changePassword({id: currentUser._id}, {
                oldPassword: oldPassword,
                newPassword: newPassword
            }, function (user) {
                return cb(user);
            }).$promise.then(function (result) {
                return result;
            });
        },
        /**
         * Gets all available info on authenticated user
         *
         * @return {Object} user
         */
        getCurrentUser: function () {
            var defer = $q.defer();
            if (typeof currentUser.id !== 'undefined') {
                defer.resolve(currentUser);
            } else {
                userService.findMe().then(function (data) {
                    currentUser = data.data;
                    defer.resolve(currentUser);
                });
            }
            return defer.promise;
        },
        setCurrentUser: function () {
            userService.findMe().then(function (data) {
                currentUser = data.data;
                $rootScope.currUser = currentUser;
            });
        },
//        hasRole: function (roles) {
//            if (roles.indexOf(currentUser.role) !== -1) {
//                return true;
//            }
//            return false;
//        },
        /**
         * Check if a user is logged in
         *
         * @return {Boolean}
         */
        isLoggedIn: function () {
//            return currentUser.hasOwnProperty('role');
        },
        /**
         * Waits for currentUser to resolve before checking if user is logged in
         */
        isLoggedInAsync: function (cb) {
            if (currentUser.hasOwnProperty('$promise')) {
                currentUser.$promise.then(function () {
                    cb(true);
                }).catch(function () {
                    cb(false);
                });
            } else if (currentUser.hasOwnProperty('role')) {
                cb(true);
            } else {
                cb(false);
            }
        },
        findByEmail: function (email, callback) {
            var cb = callback || angular.noop;
            userService.findByEmail({email: email}, function (data) {
                //$cookieStore.put('token', data.token);
                //currentUser = userService.get();
                cb(data);
            }, function (err) {
                cb(err);
            }.bind(this)).$promise;
        },
        /**
         * Waits for currentUser to resolve before checking if user is logged in
         */
        getCurrentUserInAsync: function (cb) {
            if (!$cookieStore.get('token')) {
                return cb(null);
            }
            if (currentUser.hasOwnProperty('$promise')) {
                currentUser.$promise.then(function () {
                    cb(currentUser);
                }).catch(function () {
                    cb(null);
                });
            } else if (currentUser.hasOwnProperty('role')) {
                cb(currentUser);
            } else {
                cb(null);
            }
        },
        /**
         * Check if a user is an admin
         *
         * @return {Boolean}
         */
        isAdmin: function () {
            return currentUser.role === 'admin';
        },
        /**
         * Get auth token
         */
        getToken: function () {
            return $cookieStore.get('token');
        },
        /**
         * update profile
         * @param {Object} data
         * @returns {$promise}
         */
        update: function (data) {
            return userService.update(data).$promise.then(function () {
                //refresh
                currentUser = userService.get();
            });
        },
        forgotPassword: function (email) {
            return $http.post('api/auth/forgot-password', {email: email});
        },
        confirmResetPasswordToken: function (token, callback) {
            var cb = callback || angular.noop;
            var deferred = $q.defer();

            $http.get('/auth/local/confirmPasswordResetToken/' + token)
                    .success(function (data) {
                        //do login


                        deferred.resolve(data);
                        return cb();
                    })
                    .error(function (err) {
                        deferred.reject(err);
                        return cb(err);
                    }.bind(this));

            return deferred.promise;
        },
        confirmEmail: function (token, callback) {
            var cb = callback || angular.noop;
            var deferred = $q.defer();

            $http.get('/auth/local/confirm-email/' + token)
                    .success(function (data) {
                        //do login
                        deferred.resolve(data);
                    })
                    .error(function (err) {
                        deferred.reject(err);
                        return cb(err);
                    }.bind(this));

            return deferred.promise;
        }
    };
});