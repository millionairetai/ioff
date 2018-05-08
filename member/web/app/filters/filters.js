appRoot.filter('arrayIntersect', function(){
    return function(arr1, arr2){
       
        return arr1.filter(function(n) {
                   return arr2.indexOf(n) != -1
               });
    };
});
//Array diff under score difference

appRoot.filter('num', function() {
    return function(input) {
      return parseInt(input, 10);
    }
});

