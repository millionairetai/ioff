angular.module('centeroffice').controller('LogoutCtrl', function(authService, $state){
  if (authService.logout()) {
    $state.go('employee');
  }
});