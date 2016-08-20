//show calendar
appRoot.controller('calendarCtrl', ['$scope', '$uibModal', 'calendarService', '$timeout', 'settingSystem', 'uiCalendarConfig', 'listCalendar', '$rootScope', function ($scope, $uibModal, calendarService, $timeout, settingSystem, uiCalendarConfig, listCalendar, $rootScope) {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $scope.start = false;
        $scope.end = false;
        $scope.events = [];
        $scope.eventSources = [$scope.events];
        $scope.calendars = [];
        $scope.chooseCalendar = [];
        $scope.calendars = listCalendar;

        for (i = 0; i < $scope.calendars.length; i++) {
            $scope.chooseCalendar.push($scope.calendars[i].id);
        }

        /* config object */
        $scope.uiConfig = {
            calendar: {
                editable: true,
                selectable: true,
                eventLimit: 4,
                timezone: "local",
                lang: settingSystem.language,
                height: 'auto',
                select: function (start, end, allDay) {
                    var modalInstance = $uibModal.open({
                        templateUrl: 'app/views/calendar/add.html',
                        controller: 'addEventCtrl',
                        size: 'md',
                        keyboard: true,
                        backdrop: 'static',
                        resolve: {
                            data: function () {
                                return {
                                    start: start,
                                    end: end,
                                    calendars: $scope.calendars,
                                };
                            }
                        }
                    });
                    modalInstance.result.then(function (data) {
                        $timeout(function () {
                            $scope.resetEvents($scope.start, $scope.end);
                        });
                    }, function () {});
                },
                events: function (start, end, callback) {
                    $scope.start = start;
                    $scope.end = end;
                    $scope.resetEvents(start, end);
                },
                header: {
                    left: 'month agendaWeek agendaDay',
                    center: 'title prev,next',
                    right: 'today'
                },
            }
        };

        $scope.checkCalendar = function () {
            $timeout(function () {
                $scope.resetEvents($scope.start, $scope.end);
            });
        }

        $scope.resetEvents = function (start, end) {
            calendarService.listEvents({start: start.format('YYYY-MM-DD'), end: end.format('YYYY-MM-DD'), calendars: $scope.chooseCalendar}, function (respone) {
                $scope.events.length = 0;
                for ($i = 0; $i < respone.objects.length; $i++) {
                    var newEvent = {
                        title: respone.objects[$i].title,
                        start: moment(respone.objects[$i].start).toDate(),
                        end: moment(respone.objects[$i].end).toDate(),
                        color: respone.objects[$i].color,
                        url: '#/viewCalendar/' + respone.objects[$i].id
                    };
                    $scope.events.push(newEvent);
                }

            });
        }
    }]);

//add event to calendar

appRoot.controller('addEventCtrl', ['$rootScope', 'data', '$scope', 'calendarService', 'alertify', '$uibModalInstance', 'departmentService', 'employeeService', '$timeout', 'socketService',function ($rootScope, data, $scope, calendarService, alertify, $uibModalInstance, departmentService, employeeService, $timeout, socketService) {
        //step
        $scope.step = 1;
        $scope.more = 0;
        $scope.open_start_datetime = false;
        $scope.open_end_datetime = false;
        $scope.files = [];
        $scope.colors = calendarService.colors();
        $scope.redminds = calendarService.redmind();
        $scope.people = [];
        $scope.departments = [];
        $scope.allDepartment = 0;
        
        if (data.end.toDate().getHours() == data.start.toDate().getHours() && data.start.toDate().getHours() == 7 && data.start.toDate().getMinutes() == data.end.toDate().getMinutes()) {
            data.start.add(-7, 'hours');
            data.end.add(-7, 'hours');
        }
        
        $start_datetime = data.start.toDate();
        $end_datetime = data.end.toDate();
        
        $scope.event = {
            var_start_datetime: $start_datetime,
            var_start_time: $start_datetime,
            var_end_datetime: $end_datetime,
            var_end_time: $end_datetime,
            start_datetime: '',
            end_datetime: '',
            name: '',
            address: '',
            calendar_id: 0,
            is_public: 0,
            description: '',
            color: "",
            redmind: 0,
            sms: 0,
            departments: [],
            members: [],
        }

        //add calendar
        $scope.calendars = [];
        $scope.calendars.push({id: 0, name: '--', count: 0});
        for (i = 0; i < data.calendars.length; i++) {
            $scope.calendars.push(data.calendars[i]);
        }

        //init
        if ($scope.colors.length > 0) {
            $scope.event.color = $scope.colors[0];
        }

        //refresh member
        $scope.selectMember = function ($item, $model) {

        };

        //add employee
        $scope.findEmployeeForCalendar = function (keyword) {
            employeeService.searchEmployee({keyword: keyword, departments: $scope.event.departments, members: $scope.event.members}, function (response) {
                $scope.employees = response.objects;
            });
        };

        //get all department
        departmentService.allDepartment({}, function (data) {
            $scope.departments = data.objects;
        });

        //check all
        $scope.checkAll = function () {
            if ($scope.allDepartment) {
                $scope.event.departments = $scope.departments.map(function (item) {
                    return item.id;
                });
            } else {
                $scope.event.departments = [];
            }
            $scope.findEmployeeForCalendar('');
        };

        //clickCheckAll
        $scope.clickCheckAll = function () {
            $timeout(function () {
                if ($scope.event.departments.length != $scope.departments.length) {
                    $scope.allDepartment = false;
                } else {
                    $scope.allDepartment = true;
                }
                $scope.findEmployeeForCalendar('');
            });

        };

        //add file
        $scope.addFile = function (files) {
            $scope.$apply(function () {
                for (var i = 0; i < files.length; i++) {
                    if (files[i].size > 10485760) {
                        alertify.error($rootScope.$lang.max_size);
                    } else {
                        if ($scope.files.length >= 20) {
                            alertify.error($rootScope.$lang.max_length);
                            return true;
                        } else {
                            $scope.files.push(files[i]);
                        }

                    }
                }
            });
        };

        //remove file
        $scope.removeFile = function ($index) {
            if (typeof $scope.files[$index] !== 'undefined') {
                $scope.files.splice($index, 1);
            }
        };

        //next
        $scope.next = function () {
            if ($scope.step < 3) {
                //check validate when go to step 2
                if ($scope.step == 1) {
                    if (calendarService.validate_step1($scope.event)) {
                        $scope.step++;
                    }
                } else {
                    if ($scope.step == 2) {
                        //check validate when go to step 3
                        if (calendarService.validate_step2($scope.event)) {
                            $scope.event.start_datetime = moment($scope.event.var_start_datetime).format('YYYY-MM-DD HH:mm:ss');
                            $scope.event.end_datetime = moment($scope.event.var_end_datetime).format('YYYY-MM-DD HH:mm:ss');
                            var fd = new FormData();
                            
                            for (var i in $scope.files) {
                                fd.append("file_" + i, $scope.files[i]);
                            }
                            
                            fd.append("event", angular.toJson($scope.event));
                            calendarService.addEvent(fd, function (response) {
                                alertify.success($rootScope.$lang.calendar_notify_event_created_success);
                                $uibModalInstance.close($scope.event);
                                socketService.emit('notify', 'ok');
                                $scope.step++;
                            });

                        }
                    } else {
                        $scope.step++;
                    }
                }
            }
        };
        //back
        $scope.back = function () {
            if ($scope.step == 2) {
                $scope.step--;
            }
        };

        //cancel
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };

        //show more
        $scope.showMore = function (value) {
            $scope.more = value;
        }

        $scope.tinymceOptions = {
            inline: false,
            toolbar: 'formatselect | bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | undo redo ',
            menubar: false,
            skin: 'lightgray',
            theme: 'modern'
        };

        $scope.buttonBar = {
            show: true,
            now: {
                show: false,
                text: 'Now!'
            },
            today: {
                show: true,
                text: $rootScope.$lang.datepicker_today
            },
            clear: {
                show: true,
                text: $rootScope.$lang.datepicker_clear
            },
            date: {
                show: true,
                text: 'Date'
            },
            time: {
                show: true,
                text: 'Time'
            },
            close: {
                show: true,
                text: $rootScope.$lang.datepicker_close
            }

        };
        // time picker
        $scope.timepickerOptions =  {
                readonlyInput: false,
                showMeridian: false
            }

    }]);


//Display info detail of calendar
var $dataEditEvent = [];
appRoot.controller('viewCalendarCtrl', ['$scope', 'calendarService', 'projectService', 'fileService', 'projectPostService', '$uibModal', '$rootScope', 'dialogMessage', '$routeParams', 'alertify', '$sce', 'PER_PAGE_VIEW_MORE', 
  function ($scope, calendarService, projectService, fileService, projectPostService, $uibModal, $rootScope, dialogMessage, $routeParams, alertify, $sce, PER_PAGE_VIEW_MORE) {
	var calendarId = $routeParams.calendarId;
	//set paramter for layout
	$scope.collection = [];
	$scope.getInfoEvent = function () {
		calendarService.viewEvent({calendarId: calendarId}, function (response) {
			if (response.error) $location.path('/project');
          $scope.collection = response.objects;
		});
  };
  $scope.getInfoEvent();
  
  $scope.files = [];
  //add file post
  $scope.addFile = function (files) {
      $scope.$apply(function () {
          for (var i = 0; i < files.length; i++) {
              if (files[i].size > 10485760) {
                  alertify.error($rootScope.$lang.max_size);
              } else {
                  if ($scope.files.length >= 20) {
                      alertify.error($rootScope.$lang.max_length);
                      return true;
                  } else {
                      $scope.files.push(files[i]);
                  }
              }
          }
      });
  };
  //remove file post
  $scope.removeFile = function ($index) {
      if (typeof $scope.files[$index] !== 'undefined') {
          $scope.files.splice($index, 1);
      }
  };
  
  //load move - close employee
  $scope.limit = 5;
  $scope.loadMore = function () {
      $scope.limit = $scope.collection.invitations.departmentAndEmployee.employeeList.length;
  };
  $scope.closeMore = function () {
      $scope.limit = 5;
  };
  
  //edit project
  $scope.editEvent = function () {
      var modalInstance = $uibModal.open({
          templateUrl: 'app/views/calendar/edit.html',
          controller: 'editEventCtrl',
          size: 'lg',
          keyboard: true,
          backdrop: 'static',
          resolve: {
              data: function () {
                  return {
                      calendars: $scope.collection,
                  };
              },
      		listCalendar : function($q, calendarService){
      			var deferred = $q.defer();
      			calendarService.listCalendars({},function(respone){
      				deferred.resolve(respone.objects);
      			});
      			
      			return deferred.promise;
      		}
          }
      });
  };
}]);
//edit event to calendar
appRoot.controller('editEventCtrl', ['$rootScope', 'data', 'listCalendar', '$scope', 'calendarService', 'alertify', '$uibModalInstance', 'departmentService', 'employeeService', '$timeout', 'socketService',function ($rootScope, data, listCalendar,$scope, calendarService, alertify, $uibModalInstance, departmentService, employeeService, $timeout, socketService) {
      //step
      $scope.step = 1;
      $scope.more = 0;
      $scope.open_start_datetime = false;
      $scope.open_end_datetime = false;
      $scope.files = [];
      $scope.colors = calendarService.colors();
      $scope.redminds = calendarService.redmind();
      $scope.people = [];
      $scope.departments = [];
      $scope.allDepartment = 0;
      $scope.calendars = listCalendar;
      
      $scope.event = {
          var_start_datetime: data.calendars.event.start_datetime,
          var_start_time: data.calendars.event.start_time,
          var_end_datetime: data.calendars.event.end_datetime,
          var_end_time: data.calendars.event.end_time,
          start_datetime: '',
          end_datetime: '',
          name: data.calendars.event.name,
          address: data.calendars.event.address,
          calendar_id: data.calendars.event.calendar_id,
          is_public: data.calendars.event.is_public,
          description: data.calendars.event.description,
          color: data.calendars.event.color,
          redmind: parseInt(data.calendars.remind),
          sms: 0,
          departments: Object.keys(data.calendars.invitations.department),
          members: data.calendars.invitations.departmentAndEmployee.employeeEditList,
      }
      console.log(data.calendars.invitations.departmentAndEmployee.employeeEditList);
      //add calendar 
      $scope.calendars = [];
      $scope.calendars.push({id: 0, name: '--', count: 0});
      for (i = 0; i < listCalendar.length; i++) {
          $scope.calendars.push(listCalendar[i]);
      }

      //refresh member
      $scope.selectMember = function ($item, $model) {

      };

      //add employee
      $scope.findEmployeeForCalendar = function (keyword) {
          employeeService.searchEmployee({keyword: keyword, departments: $scope.event.departments, members: $scope.event.members}, function (response) {
              $scope.employees = response.objects;
          });
      };

      //get all department
      departmentService.allDepartment({}, function (data) {
          $scope.departments = data.objects;
      });

      //check all
      $scope.checkAll = function () {
          if ($scope.allDepartment) {
              $scope.event.departments = $scope.departments.map(function (item) {
                  return item.id;
              });
          } else {
              $scope.event.departments = [];
          }
          $scope.findEmployeeForCalendar('');
      };

      //clickCheckAll
      $scope.clickCheckAll = function () {
          $timeout(function () {
              if ($scope.event.departments.length != $scope.departments.length) {
                  $scope.allDepartment = false;
              } else {
                  $scope.allDepartment = true;
              }
              $scope.findEmployeeForCalendar('');
          });

      };

//      //add file
//      $scope.addFile = function (files) {
//          $scope.$apply(function () {
//              for (var i = 0; i < files.length; i++) {
//                  if (files[i].size > 10485760) {
//                      alertify.error($rootScope.$lang.max_size);
//                  } else {
//                      if ($scope.files.length >= 20) {
//                          alertify.error($rootScope.$lang.max_length);
//                          return true;
//                      } else {
//                          $scope.files.push(files[i]);
//                      }
//
//                  }
//              }
//          });
//      };
//
//      //remove file
//      $scope.removeFile = function ($index) {
//          if (typeof $scope.files[$index] !== 'undefined') {
//              $scope.files.splice($index, 1);
//          }
//      };

      //next
      $scope.next = function () {
          if ($scope.step < 3) {
              //check validate when go to step 2
              if ($scope.step == 1) {
                  if (calendarService.validate_step1($scope.event)) {
                      $scope.step++;
                  }
              } else {
                  if ($scope.step == 2) {
                      //check validate when go to step 3
                      if (calendarService.validate_step2($scope.event)) {
                          $scope.event.start_datetime = moment($scope.event.var_start_datetime).format('YYYY-MM-DD HH:mm:ss');
                          $scope.event.end_datetime = moment($scope.event.var_end_datetime).format('YYYY-MM-DD HH:mm:ss');
                          var fd = new FormData();
                          
                          for (var i in $scope.files) {
                              fd.append("file_" + i, $scope.files[i]);
                          }
                          
                          fd.append("event", angular.toJson($scope.event));
                          calendarService.editEvent(fd, function (response) {
                              alertify.success($rootScope.$lang.calendar_notify_event_created_success);
                              $uibModalInstance.close($scope.event);
                              socketService.emit('notify', 'ok');
                              $scope.step++;
                          });

                      }
                  } else {
                      $scope.step++;
                  }
              }
          }
      };
      //back
      $scope.back = function () {
          if ($scope.step == 2) {
              $scope.step--;
          }
      };

      //cancel
      $scope.cancel = function () {
          $uibModalInstance.dismiss('cancel');
      };

      //show more
      $scope.showMore = function (value) {
          $scope.more = value;
      }

      $scope.buttonBar = {
          show: true,
          now: {
              show: false,
              text: 'Now!'
          },
          today: {
              show: true,
              text: $rootScope.$lang.datepicker_today
          },
          clear: {
              show: true,
              text: $rootScope.$lang.datepicker_clear
          },
          date: {
              show: true,
              text: 'Date'
          },
          time: {
              show: true,
              text: 'Time'
          },
          close: {
              show: true,
              text: $rootScope.$lang.datepicker_close
          }

      };
      // time picker
      $scope.timepickerOptions =  {
              readonlyInput: false,
              showMeridian: false
          }
  }]);
