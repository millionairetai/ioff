appRoot.directive('autoNumeric', [function () {
        'use strict';
        // Declare a empty options object
        var options = {};
        return {
            // Require ng-model in the element attribute for watching changes.
            require: '?ngModel',
            // This directive only works when used in element's attribute (e.g: cr-numeric)
            restrict: 'A',
            compile: function (tElm, tAttrs) {

                var isTextInput = tElm.is('input:text');

                return function (scope, elm, attrs, controller) {
                    // Get instance-specific options.
                    var opts = angular.extend({}, options, scope.$eval(attrs.autoNumeric));

                    // Helper method to update autoNumeric with new value.
                    var updateElement = function (element, newVal) {
                        // Only set value if value is numeric
                        if ($.isNumeric(newVal))
                            element.autoNumeric('set', newVal);
                    };

                    // Initialize element as autoNumeric with options.
                    elm.autoNumeric(opts);

                    // if element has controller, wire it (only for <input type="text" />)
                    if (controller && isTextInput) {
                        // watch for external changes to model and re-render element
                        scope.$watch(tAttrs.ngModel, function (current, old) {
                            controller.$render();
                        });
                        // render element as autoNumeric
                        controller.$render = function () {
                            updateElement(elm, controller.$viewValue);
                        }
                        // Detect changes on element and update model.
                        elm.bind('change', function (e) {
                            scope.$apply(function () {
                                controller.$setViewValue(elm.autoNumeric('get'));
                            });
                        });
                    }
                    else {
                        // Listen for changes to value changes and re-render element.
                        // Useful when binding to a readonly input field.
                        if (isTextInput) {
                            attrs.$observe('value', function (val) {
                                updateElement(elm, val);
                            });
                        }
                    }
                }
            } // compile
        } // return
    }]);/**
 * Checklist-model
 * AngularJS directive for list of checkboxes
 * https://github.com/vitalets/checklist-model
 * License: MIT http://opensource.org/licenses/MIT
 */

appRoot.directive('checklistModel', ['$parse', '$compile', function($parse, $compile) {
  // contains
  function contains(arr, item, comparator) {
    if (angular.isArray(arr)) {
      for (var i = arr.length; i--;) {
        if (comparator(arr[i], item)) {
          return true;
        }
      }
    }
    return false;
  }

  // add
  function add(arr, item, comparator) {
    arr = angular.isArray(arr) ? arr : [];
      if(!contains(arr, item, comparator)) {
          arr.push(item);
      }
    return arr;
  }  

  // remove
  function remove(arr, item, comparator) {
    if (angular.isArray(arr)) {
      for (var i = arr.length; i--;) {
        if (comparator(arr[i], item)) {
          arr.splice(i, 1);
          break;
        }
      }
    }
    return arr;
  }

  // http://stackoverflow.com/a/19228302/1458162
  function postLinkFn(scope, elem, attrs) {
     // exclude recursion, but still keep the model
    var checklistModel = attrs.checklistModel;
    attrs.$set("checklistModel", null);
    // compile with `ng-model` pointing to `checked`
    $compile(elem)(scope);
    attrs.$set("checklistModel", checklistModel);

    // getter / setter for original model
    var getter = $parse(checklistModel);
    var setter = getter.assign;
    var checklistChange = $parse(attrs.checklistChange);
    var checklistBeforeChange = $parse(attrs.checklistBeforeChange);

    // value added to list
    var value = attrs.checklistValue ? $parse(attrs.checklistValue)(scope.$parent) : attrs.value;


    var comparator = angular.equals;

    if (attrs.hasOwnProperty('checklistComparator')){
      if (attrs.checklistComparator[0] == '.') {
        var comparatorExpression = attrs.checklistComparator.substring(1);
        comparator = function (a, b) {
          return a[comparatorExpression] === b[comparatorExpression];
        };
        
      } else {
        comparator = $parse(attrs.checklistComparator)(scope.$parent);
      }
    }

    // watch UI checked change
    scope.$watch(attrs.ngModel, function(newValue, oldValue) {
      if (newValue === oldValue) { 
        return;
      } 

      if (checklistBeforeChange && (checklistBeforeChange(scope) === false)) {
        scope[attrs.ngModel] = contains(getter(scope.$parent), value, comparator);
        return;
      }

      setValueInChecklistModel(value, newValue);

      if (checklistChange) {
        checklistChange(scope);
      }
    });

    function setValueInChecklistModel(value, checked) {
      var current = getter(scope.$parent);
      if (angular.isFunction(setter)) {
        if (checked === true) {
          setter(scope.$parent, add(current, value, comparator));
        } else {
          setter(scope.$parent, remove(current, value, comparator));
        }
      }
      
    }

    // declare one function to be used for both $watch functions
    function setChecked(newArr, oldArr) {
      if (checklistBeforeChange && (checklistBeforeChange(scope) === false)) {
        setValueInChecklistModel(value, scope[attrs.ngModel]);
        return;
      }
      scope[attrs.ngModel] = contains(newArr, value, comparator);
    }

    // watch original model change
    // use the faster $watchCollection method if it's available
    if (angular.isFunction(scope.$parent.$watchCollection)) {
        scope.$parent.$watchCollection(checklistModel, setChecked);
    } else {
        scope.$parent.$watch(checklistModel, setChecked, true);
    }
  }

  return {
    restrict: 'A',
    priority: 1000,
    terminal: true,
    scope: true,
    compile: function(tElement, tAttrs) {
      if ((tElement[0].tagName !== 'INPUT' || tAttrs.type !== 'checkbox') && (tElement[0].tagName !== 'MD-CHECKBOX') && (!tAttrs.btnCheckbox)) {
        throw 'checklist-model should be applied to `input[type="checkbox"]` or `md-checkbox`.';
      }

      if (!tAttrs.checklistValue && !tAttrs.value) {
        throw 'You should provide `value` or `checklist-value`.';
      }

      // by default ngModel is 'checked', so we set it if not specified
      if (!tAttrs.ngModel) {
        // local scope var storing individual checkbox model
        tAttrs.$set("ngModel", "checked");
      }

      return postLinkFn;
    }
  };
}]);
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
appRoot.directive('icheck', function($timeout, $parse) {
    return {
        require: 'ngModel',
        link: function($scope, element, $attrs, ngModel) {
            return $timeout(function() {
                var value;
                value = $attrs['value'];

                $scope.$watch($attrs['ngModel'], function(newValue){
                    $(element).iCheck('update');
                });

                 $(element).iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'

                }).on('ifChanged', function(event) {
                    if ($(element).attr('type') === 'checkbox' && $attrs['ngModel']) {
                        $scope.$apply(function() {
                             ngModel.$setViewValue(event.target.checked);
                        });
                    }
                    if ($(element).attr('type') === 'radio' && $attrs['ngModel']) {
                         $scope.$apply(function() {
                             ngModel.$setViewValue(value);
                        });
                    }
                });
            });
        }
    };
});
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
appRoot.directive('searchEmployee', ['employeeService', '$modal', function (employeeService, $modal) {
        return {
            restrict: 'E',
            scope: {
                handle: '=handle',
                departments : "=?departments",
                members : "=?members"
            },
            templateUrl: 'app/views/widgets/searchEmployee.html',
            controller: ['$scope', '$element', '$attrs', function ($scope, $element, $attrs) {
                    var departments = [];
                    if(typeof $scope.departments !== 'undefined'){
                        departments = $scope.departments;
                    }
                    
                    
                    //find product
                    $scope.keyword = "";
                    $scope.searchEmployee = function (keyword) {
                        return  employeeService.searchEmployee({keyword: keyword,departments:$scope.departments,members:$scope.members}, function (response) {
                        }).then(function (response) {
                                    return response.data.objects;
                            });
                    };

                    //handle selected
                    $scope.handleSelected = function ($item, $model, $label) {
                        $scope.handle($item, $model, $label);
                        $scope.keyword = "";
                    }

                }]
        };
    }]);appRoot.directive("ngTextTruncate", [ "$compile", "ValidationServices", "CharBasedTruncation", "WordBasedTruncation",
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