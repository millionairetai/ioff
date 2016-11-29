appRoot.factory('validationService', ['apiService', function (apiService) {
        return {
            run: function(val, regExp) {
                if (val.search(regExp) === -1) {
                    return false;
                }

                return true;
            },
            email: function (email) {
                return this.run(email, /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/);
            },
            date: function (date) {
                return this.run(date, /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/);
            }
        };
    }]);
