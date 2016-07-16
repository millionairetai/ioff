angular.module('centeroffice').directive('clickOnce', function ($timeout) {
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
//http://plnkr.co/edit/2aZWQSLS8s6EhO5rKnRh?p=preview
//http://blog.codebrag.com/post/57412530001/preventing-duplicated-requests-in-angularjs