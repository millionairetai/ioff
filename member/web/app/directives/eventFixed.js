
appRoot.directive('eventFixed', function ($window) {
    var $win = angular.element($window); // wrap window object as jQuery object

    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var topClass = 'sidebarfixed', // get CSS class
                    offsetTop = element.offset().top; // get element's top relative to the document
            $win.on('scroll', function (e) {
                if ($win.scrollTop() >= offsetTop) {
                    element.addClass(topClass);
                    element.css('top', $win.scrollTop() - 50);
                } else {
                    element.removeClass(topClass);
                    element.css('top', '0');
                }
            });
        }
    };
});