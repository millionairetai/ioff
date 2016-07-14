
appRoot.directive('radioColor', function($timeout, $parse) {
    return {
        require: 'ngModel',
        restrict: 'AE',
        link: function($scope, element, $attrs, ngModel) {
            var background = "#"+$attrs['color'];
            element.css({'background-color':background});
            //check default
            $scope.$watch(function(){
                    return ngModel.$modelValue;
                }, function(modelValue){
                    if($attrs['color'] == modelValue){
                        $('.radio-color').removeClass('fa-check');
                        element.addClass('fa-check');
                    }
                });
            /*if($attrs['color'] == ngModel.$modelValue){
                $('.radio-color').removeClass('fa-check');
                element.addClass('fa-check');
            }*/
            //handle event click
            element.bind('click',function(){
                $scope.$apply(function() {
                    ngModel.$setViewValue($attrs['color']);
                });
            });
            
        }
    };
});