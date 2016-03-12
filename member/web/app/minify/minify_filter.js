appRoot.filter('avatar', function (SITE_URL) {
            return function (input) {
                if (input) {
                    if (/^(f|ht)tps?:\/\//i.test(input)) {
                        return input;
                    } else {
                        return SITE_URL + 'uploads/avatars/' + input;
                    }
                } else {
                    return SITE_URL + 'frontend/web/images/img.jpg';
                }
            };
        })
        .filter('logo', function (SITE_URL) {
            return function (input) {
                if (input) {
                    if (/^(f|ht)tps?:\/\//i.test(input)) {
                        return input;
                    } else {
                        return SITE_URL + 'uploads/logos/' + input;
                    }
                } else {
                    return SITE_URL + 'frontend/web/images/icon-about.png';
                }
            };
        })
        .filter('format_time', function () {
            return function (hour, minute) {
                if (hour > 12) {
                    return (hour - 12) + ':' + minute + ' pm';
                } else {
                    return hour + ':' + minute + ' am';
                }
            }
        });