appRoot.factory('validateService', ['apiService', function (apiService) {
        return {
            run: function(val, regExp) {
                if (val == '' || angular.isUndefined(val) || val == null) {
                    return false;
                }
                
                if (val.search(regExp) === -1) {
                    return false;
                }

                return true;
            },
            integer: function (number) {
                return this.run(number, /^\s*[+-]?\d+\s*$/);
            },
            email: function (email) {
                return this.run(email, /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/);
            },
            date: function (date) {
                return this.run(date, /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/);
            },
            maxSizeUpload: function(file) {
                return file.size < 10485760;
            },
            imageFile: function(file) {
                return file.type.match('image.*');
            },
            avatar: function(file) {
                return this.run(file.type, /^(image\/gif)|(image\/jpg)|(image\/jpeg)|(image\/pjpeg)|(image\/png)$/);
            },
            required: function(text) {
                if (text == '' || angular.isUndefined(text) || text == null) {
                    return false;
                }
                text = text.trim();
                return text.length > 0;
            }
        };
    }]);
