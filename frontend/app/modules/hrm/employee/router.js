angular.module('centeroffice').config(function ($stateProvider) {
    $stateProvider.state('employee', {
        url: '/?token',
        templateUrl: '/frontend/app/modules/hrm/employee/login/login.html',
        controller: 'LoginCtrl'
    }).state('logout', {
        url: '/logout',
        controller: 'LogoutCtrl'
    }).state('employee.list', {
        url: '/list',
        templateUrl: '/frontend/app/modules/hrm/employee/employee.html',
        controller: 'EmployeeCtrl'
    });
});