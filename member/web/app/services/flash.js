appRoot.factory("flash", ['$rootScope','alertify', function ($rootScope,alertify) {
    var queue = [];
    var currentMessage = "";

    $rootScope.$on("$routeChangeSuccess", function () {
        currentMessage = queue.shift() || "";
    });

    return {
        setMessage: function (message) {
            queue.push(message);
        },
        setNoAuthFunctionMessage: function () {
            queue.push($rootScope.$lang.no_authoirty_function);
        },
        setNoAuthItemMessage: function () {
            queue.push($rootScope.$lang.no_authoirty_item);
        },
        setNoDataMessage: function () {
            queue.push($rootScope.$lang.no_data);
        },
        getMessage: function () {
            return currentMessage;
        }, 
        trigger: function () {
            var message = this.getMessage();
            if (message) {
                alertify.error(message);
            }

            return true;
        }
    };
}]);