appRoot.factory('eventService', ['apiService','$rootScope','alertify', function (apiService,$rootScope,alertify) {

        return {
            listCalendars : function (data,success,error){
                apiService.post('calendar/index',data,success,error);
            },
            addCalendar : function (data,success,error){
                apiService.post('calendar/add-calendar', data, success, error);
            },
            editCalendar : function (data,success,error){
                apiService.post('calendar/edit-calendar', data, success, error);
            },
            deleteCalendar : function (data,success,error){
                apiService.get('calendar/delete-calendar', data, success, error);
            },
            validateCalendarAdd: function (object) {
                var message = "";
                if (object.name.length == 0) {
                    message += $rootScope.$lang.calendar_name_error_empty + "<br/>";
                }
                if (object.description.length == 0) {
                    message += $rootScope.$lang.calendar_description_error_empty + "<br/>";
                }
                if (message.length > 0) {
                    alertify.error(message);
                    return false;
                }
                return true;
            }
        };
    }]);
