angular.module('centeroffice').config(function ($stateProvider) {
    $stateProvider.state('project', {
        url: '/project',
        templateUrl: '/frontend/app/modules/work/project/project.html',
        controller: 'ProjectCtrl'
    }).state('project.home', {
        url: '/home',
        templateUrl: '/frontend/app/modules/work/project/home/home.html',
        controller: 'HomeCtrl'
    })
});