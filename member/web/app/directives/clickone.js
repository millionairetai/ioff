angular.module('iofficez').directive('clickOnce', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var replacementText = attrs.clickOnce;

            element.bind('click', function () {
                $timeout(function () {
                    if (replacementText) {
                        element.html(replacementText);
                    }
                    element.attr('disabled', true);
                }, 0);
            });
        }
    };
});