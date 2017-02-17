appRoot.factory('orderService', ['apiService', function (apiService) {
        return {
            getOrderHistory: function (data, success, error) {
                return apiService.get('order/get-history', data, success, error);
            },
            getOrderDetail: function (data, success, error) {
                return apiService.get('order/get-order-detail', data, success, error);
            }
        };
    }]);
