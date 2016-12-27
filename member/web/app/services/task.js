appRoot.factory('taskService', ['apiService','$rootScope','alertify', function (apiService,$rootScope,alertify) {

        return {
            getPriorityList : function (data,success,error) {
                apiService.get('priority/get-priority-list',data,success,error);
            },                      
            getTaskGroupList : function (data,success,error) {
                apiService.get('task/get-task-group',data,success,error);
            },
            getRemindBeforeList : function (data,success,error) {
                apiService.get('task/get-task-remind-before-list',data,success,error);
            },
            getParentTaskList : function (data,success,error) {
                apiService.get('task/get-tasks-by-project',data,success,error);
            },
            getTaskView : function (data,success,error) {
                apiService.get('task/view',data,success,error);
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
                
                if(object.name.length > 255){
                    message += $rootScope.$lang.name_less_than_255_character + "<br/>";
                }
                
                if(object.project_id == 0 || object.project_id == null){
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
            validate_step2 : function(object) {
                var message = "";
                if(Object.prototype.toString.call(object.duedatetime) !== '[object Date]' && object.redmind > 0) {
                    message += $rootScope.$lang.task_duedatetime_error_empty + "<br/>";
                } else {
                    if(object.redmind > 0){
                        var sub = moment(object.duedatetime).subtract({ minutes: object.redmind});
                        var now = moment();
//                        console.log(sub.diff(now, 'minutes'));
//                        console.log(sub.diff(now));
                        if(sub.diff(now) < 0){
                            message += $rootScope.$lang.task_check_valid_redmind + "<br/>";
                        }
                    }
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
            editTask : function (data,success,error){
                apiService.upload('task/edit',data,success,error);
            },
            getMyTasks : function (data,success,error) {
                apiService.get('task/get-my-tasks',data,success,error);
            },
            getAssingedTasks : function (data,success,error) {
                apiService.get('task/get-assigned-tasks',data,success,error);
            },
            getFollowTasks : function (data,success,error) {
                apiService.get('task/get-follow-tasks',data,success,error);
            },
            getTasks: function(data,success,error) {
                apiService.get('task/get-tasks',data,success,error);
            },
            getMyTaskForDropdown: function(data,success,error) {
                apiService.post('task/get-task-for-dropdown',data,success,error, false);
            },
            getSearchGlobalTasks:  function(data,success,error) {
                apiService.post('task/get-search-global-tasks',data,success,error);
            },
            getMyTaskForCalendar:  function(data,success,error) {
                apiService.post('task/get-my-task-for-calendar',data,success,error);
            },
            getMyFollowTaskForCalendar:  function(data,success,error) {
                apiService.post('task/get-my-follow-task-for-calendar',data,success,error);
            },
            getTaskReport: function(data,success,error) {
                apiService.get('task/get-task-report',data,success,error);
            },
            getEmpTaskReport: function(data,success,error) {
                apiService.get('task/get-employee-task-report',data,success,error);
            },
            getDetaiWorkedHourEmployee: function(data,success,error) {
                apiService.get('task/get-detail-worked-hour-employee',data,success,error);
            }
        };
    }]);
