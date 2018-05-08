appRoot.directive('eventFixed', function ($window) {
    var $win = angular.element($window); // wrap window object as jQuery object

    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var firstTime = "first-time";
            var topClass, offsetTop, offsetparentTop;
            $win.on('scroll', function (e) {
                if (firstTime === "first-time") {
                    topClass = 'sidebarfixed'; // get CSS class
                    offsetTop = element.offset().top; // get element's top relative to the document
                    offsetparentTop = element.parent().offset().top;
                    firstTime = "";
                }
                if ($win.scrollTop() >= offsetTop) {
                    element.addClass(topClass);
                    element.css('top', $win.scrollTop() - offsetparentTop + 70);
                } else {
                    element.removeClass(topClass);
                    element.css('top', '0');
                }
            });
        }
    };
});