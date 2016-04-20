appRoot.factory('projectService', ['apiService','$rootScope','alertify', function (apiService,$rootScope,alertify) {

        return {
            listProject : function (data,success,error){
                apiService.post('project/index',data,success,error);
            },
            addProject : function (data,success,error){
                apiService.upload('project/add',data,success,error);
            },
            listStatus : function (data,success,error){
                apiService.get('status/project',data,success,error);
            },
            listPriority : function (data,success,error){
                apiService.get('priority/index',data,success,error);
            },
            validate_step1 : function(object){
                var message = "";
                var now = new Date();
                if(object.name.length == 0){
                    message += $rootScope.$lang.project_name_error_empty + "<br/>";
                }
                if(object.description.length == 0){
                    message += $rootScope.$lang.project_description_error_empty + "<br/>";
                }
                if(!isNaN(parseFloat(object.estimate_hour)) && isFinite(object.estimate_hour)){
                    if(object.estimate_hour < 0){
                        message += $rootScope.$lang.project_estimate_error_0 + "<br/>";
                    }
                    
                }else{
                    message += $rootScope.$lang.project_estimate_error + "<br/>";
                }
                
                //check start date
                if((typeof object.start_datetime) === 'undefined' ){
                    message += $rootScope.$lang.project_start_date_error_empty + "<br/>";
                }
                //check enddate
                if((typeof object.duedatetime) === 'undefined'){
                    message += $rootScope.$lang.project_end_date_error_empty + "<br/>";
                }else{
                    if(Object.prototype.toString.call(object.duedatetime) === '[object Date]' && object.duedatetime.getTime() < now.getTime()){
                        message += $rootScope.$lang.project_end_date_error_past + "<br/>";
                    }
                }
                if(Object.prototype.toString.call(object.start_datetime) === '[object Date]' && Object.prototype.toString.call(object.duedatetime) === '[object Date]'){
                    if(object.start_datetime.getTime() > object.duedatetime.getTime()){
                        message += $rootScope.$lang.project_time_error + "<br/>";
                    }
                }
                
                if(message.length > 0){
                    alertify.error(message);
                    return false;
                }
                return true;
                
            },
            validate_step2 : function(object){
                var message = "";
                /*var now = new Date();
                if(object.manager_project_id == 0){
                    message += $rootScope.$lang.project_manager_error_empty + "<br/>";
                }
                if(object.members.length == 0 && object.departments.length == 0){
                    message += $rootScope.$lang.project_members_error_empty + "<br/>";
                }*/
                
                if(message.length > 0){
                    alertify.error(message);
                    return false;
                }
                return true;
                
            }
            
        };
    }]);
