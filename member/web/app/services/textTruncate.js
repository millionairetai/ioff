appRoot.factory( "ValidationServices", function() {
    return {
        failIfWrongThreshouldConfig: function( firstThreshould, secondThreshould ) {
            if( (! firstThreshould && ! secondThreshould) || (firstThreshould && secondThreshould) ) {
                throw "You must specify one, and only one, type of threshould (chars or words)";
            }
        }
    };
});

appRoot.factory( "CharBasedTruncation", [ "$compile", '$rootScope' , function( $compile, $rootScope) {
    return {
        truncationApplies: function( $scope, threshould ) {
            return $scope.text.length > threshould;
        },

        applyTruncation: function( threshould, $scope, $element) {
            if( $scope.useToggling ) {
                var el = angular.element(    "<span>" + 
                                                $scope.text.substr( 0, threshould ) + 
                                                "<span ng-show='!open'>...</span>" +
                                                "<span class='btn-link ngTruncateToggleText' " +
                                                    "ng-click='toggleShow()'" +
                                                    "ng-show='!open'>" +
                                                    "  <div class='text-right'>" +  ($scope.customMoreLabel ? $scope.customMoreLabel : $rootScope.$lang.more) + "</div>" +
                                                "</span>" +
                                                "<span ng-show='open'>" + 
                                                    $scope.text.substring( threshould ) + 
                                                    "<span class='btn-link ngTruncateToggleText'" +
                                                          "ng-click='toggleShow()'>" +
                                                          "  <div class='text-right'>" +  ($scope.customLessLabel ? $scope.customLessLabel : $rootScope.$lang.less) + "</div>" +
                                                    "</span>" +
                                                "</span>" +
                                            "</span>" );
                $compile( el )( $scope );
                $element.append( el );

            } else {
                $element.append( $scope.text.substr( 0, threshould ) + "..." );

            }
        }
    };
}]);

appRoot.factory( "WordBasedTruncation", [ "$compile", function( $compile ) {
    return {
        truncationApplies: function( $scope, threshould ) {
            return $scope.text.split( " " ).length > threshould;
        },

        applyTruncation: function( threshould, $scope, $element ) {
            var splitText = $scope.text.split( " " );
            if( $scope.useToggling ) {
                var el = angular.element(    "<span>" + 
                                                splitText.slice( 0, threshould ).join( " " ) + " " + 
                                                "<span ng-show='!open'>...</span>" +
                                                "<span class='btn-link ngTruncateToggleText' " +
                                                    "ng-click='toggleShow()'" +
                                                    "ng-show='!open'>" +
                                                    "  <div class='text-right'>" + ($scope.customMoreLabel ? $scope.customMoreLabel : $rootScope.$lang.more) + "</div>" +
                                                "</span>" +
                                                "<span ng-show='open'>" + 
                                                    splitText.slice( threshould, splitText.length ).join( " " ) + 
                                                    "<span class='btn-link ngTruncateToggleText'" +
                                                          "ng-click='toggleShow()'>" +
                                                          "  <div class='text-right'>" +  ($scope.customLessLabel ? $scope.customLessLabel : $rootScope.$lang.less) + "</div>" +
                                                    "</span>" +
                                                "</span>" +
                                            "</span>" );
                $compile( el )( $scope );
                $element.append( el );

            } else {
                $element.append( splitText.slice( 0, threshould ).join( " " ) + "..." );
            }
        }
    };
}]);
