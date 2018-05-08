appRoot.directive("ngTextTruncate", [ "$compile", "ValidationServices", "CharBasedTruncation", "WordBasedTruncation",
                                    	function( $compile, ValidationServices, CharBasedTruncation, WordBasedTruncation ) {
    return {
        restrict: "A",
        scope: {
            text: "=ngTextTruncate",
            charsThreshould: "@ngTtCharsThreshold",
            wordsThreshould: "@ngTtWordsThreshold",
            customMoreLabel: "@ngTtMoreLabel",
            customLessLabel: "@ngTtLessLabel"
        },
        controller: function( $scope, $element, $attrs ) {
            $scope.toggleShow = function() {
                $scope.open = !$scope.open;
            };

            $scope.useToggling = $attrs.ngTtNoToggling === undefined;
        },
        link: function( $scope, $element, $attrs ) {
            $scope.open = false;

            ValidationServices.failIfWrongThreshouldConfig( $scope.charsThreshould, $scope.wordsThreshould );

            var CHARS_THRESHOLD = parseInt( $scope.charsThreshould );
            var WORDS_THRESHOLD = parseInt( $scope.wordsThreshould );

            $scope.$watch( "text", function() {
                $element.empty();
                
                if( CHARS_THRESHOLD ) {
                        if( $scope.text && CharBasedTruncation.truncationApplies( $scope, CHARS_THRESHOLD ) ) {
                            CharBasedTruncation.applyTruncation( CHARS_THRESHOLD, $scope, $element );

                        } else {
                            $element.append( $scope.text );
                        }

                } else {

                    if( $scope.text && WordBasedTruncation.truncationApplies( $scope, WORDS_THRESHOLD ) ) {
                        WordBasedTruncation.applyTruncation( WORDS_THRESHOLD, $scope, $element );

                    } else {
                        $element.append( $scope.text );
                    }

                }
            } );
        }
    };
}]);