appRoot.factory('taskService', ['apiService','$rootScope','alertify', function (apiService,$rootScope,alertify) {

        return {
            getPriorityList : function (data,success,error) {
                apiService.get('priority/get-priority-list',data,success,error);
            },
            getStatusList : function (data,success,error) {
                apiService.get('status/get-task-status-list',data,success,error);
            },                        
            getRemindBeforeList : function (data,success,error) {
                apiService.get('task/get-task-remind-before-list',data,success,error);
            },
            getParentTasks : function (data,success,error) {
                apiService.get('task/get-parent-tasks',data,success,error);
            },
            validate_step1 : function(object) {
                var message = "";
                var now = new Date();
                
                if(object.name.length == 0){
                    message += $rootScope.$lang.task_name_error_empty + "<br/>";
                }
                
                if(object.project_id.length == 0){
                    message += $rootScope.$lang.task_project_name_error_empty + "<br/>";
                }
                
                if(object.description.length == 0){
                    message += $rootScope.$lang.task_description_error_empty + "<br/>";
                }
                
                if(!isNaN(parseFloat(object.estimate_hour)) && isFinite(object.estimate_hour)){
                    if(object.estimate_hour < 0){
                        message += $rootScope.$lang.task_estimate_error_0 + "<br/>";
                    }
                    
                }else{
                    message += $rootScope.$lang.task_estimate_error + "<br/>";
                }
                                
                //check enddate
                if((typeof object.duedatetime) === 'undefined'){
                    message += $rootScope.$lang.task_end_date_error_empty + "<br/>";
                }                               
                
                if(message.length > 0){
                    alertify.error(message);
                    return false;
                }
                return true;
                
            },
            validate_step2 : function(object){
                var message = "";
                                
                if(object.taskGroupIds.length == 0){
                    message += $rootScope.$lang.task_group_error_empty + "<br/>";
                }
                
                if(message.length > 0){
                    alertify.error(message);
                    return false;
                }
                return true;
                
            },
            addTask : function (data,success,error){
                apiService.upload('task/add',data,success,error);
            },
            getMyTasks : function (data,success,error) {
                apiService.get('task/get-my-tasks',data,success,error);
            },
            getFollowTasks : function (data,success,error) {
                apiService.get('task/get-follow-tasks',data,success,error);
            },
            getTasks: function(data,success,error) {
                apiService.get('task/get-tasks',data,success,error);
            },
            getTaskForDropdown: function(data,success,error) {
                apiService.post('task/get-task-for-dropdown',data,success,error, 0);
            },
            getSearchGlobalTasks:  function(data,success,error) {
                apiService.post('task/get-search-global-tasks',data,success,error);
            }         
        };
    }]);
