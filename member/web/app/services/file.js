appRoot.factory('fileService', ['apiService', function (apiService) {
    return {
    	removeFile : function (data,success,error){
            apiService.get('file/remove-file', data, success, error);
        }
    };
}]);
