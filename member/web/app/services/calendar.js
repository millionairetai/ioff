appRoot.factory('calendarService', ['apiService','$rootScope','alertify', function (apiService,$rootScope,alertify) {

        return {
            listCalendars : function (data,success,error){
                apiService.post('calendar/index',data,success,error);
            },
            listEvents : function (data,success,error){
                apiService.post('calendar/events',data,success,error);
            },
            addEvent : function (data,success,error){
                apiService.upload('calendar/add-event',data,success,error);
            },
            getLanguage : function (data,success,error){
                apiService.upload('calendar/language',data,success,error);
            },
            editEvent : function (data,success,error){
            	apiService.upload('calendar/edit-event',data,success,error);
            },
            viewEvent: function (data,success,error){
                apiService.post('calendar/view-event',data, success, error);
            },
            attend: function (data,success,error){
                apiService.post('calendar/attend',data, success, error);
            },
            //validate
            validate_step1 : function(object){
                var message = "";
                var now = new Date();

                //check name
                if(object.name.length == 0){
                    message += $rootScope.$lang.calendar_event_name_error_empty + "<br/>";
                }
                
                //check calendar
                if(object.calendar_id == 0){
                    message += $rootScope.$lang.calendar_event_calendar_id_error_empty + "<br/>";
                }
                
                //check start date
                if(Object.prototype.toString.call(object.var_start_datetime) !== '[object Date]'){
                    message += $rootScope.$lang.calendar_event_start_date_error_empty + "<br/>";
                }else{
                    if(object.redmind > 0){
                        var sub = moment(object.var_start_datetime).subtract({ minutes: object.redmind});
                        var now = moment();
                        if(sub.diff(now) < 0){
                            message += $rootScope.$lang.calendar_event_check_redmind + "<br/>";
                        }
                    }
                }
                //check enddate
                if(Object.prototype.toString.call(object.var_end_datetime) !== '[object Date]'){
                    message += $rootScope.$lang.calendar_event_end_date_error_empty + "<br/>";
                }
                
                if(Object.prototype.toString.call(object.var_start_datetime) === '[object Date]' && Object.prototype.toString.call(object.var_end_datetime) === '[object Date]'){
                    if(object.var_start_datetime.getTime() > object.var_end_datetime.getTime()){
                        message += $rootScope.$lang.calendar_event_time_error + "<br/>";
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
                if(Object.prototype.toString.call(object.var_start_datetime) !== '[object Date]'){
                    message += $rootScope.$lang.calendar_event_start_date_error_empty + "<br/>";
                }else{
                    if(object.redmind > 0){
                        var sub = moment(object.var_start_datetime).subtract({ minutes: object.redmind});
                        var now = moment();
                        if(sub.diff(now) < 0){
                            message += $rootScope.$lang.calendar_event_check_redmind + "<br/>";
                        }
                    }
                }
                
                if(message.length > 0){
                    alertify.error(message);
                    return false;
                }
                return true;
                
            },
            colors : function(){
                return ['3b91ad','5484ed','a4bdfc','46d6db','7ae7bf','51b749','fbd75b','ffb878','ff887c','dc2127','dbadff','e1e1e1']
            },
            redmind : function(){
                return [
                    {id:0,name:$rootScope.$lang.calendar_event_redmine_0},
                    {id:30,name:$rootScope.$lang.calendar_event_redmine_30},
                    {id:60,name:$rootScope.$lang.calendar_event_redmine_60},
                    {id:120,name:$rootScope.$lang.calendar_event_redmine_120},
                    {id:240,name:$rootScope.$lang.calendar_event_redmine_240},
                    {id:1440,name:$rootScope.$lang.calendar_event_redmine_1440},
                    {id:2880,name:$rootScope.$lang.calendar_event_redmine_2880},
                ];
            }
        };
    }]);
