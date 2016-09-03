appRoot = angular.module('iofficez',
        ['ui.tinymce', 'ngRoute', 'ui.bootstrap', "ngAlertify", 'ui.slider', 'ui.select', 'ngTagsInput',
            'ui.calendar', 'ui.bootstrap.datetimepicker', 'btford.socket-io', 'infinite-scroll', 'autocomplete']);

//constant for paging
appRoot.constant('PER_PAGE_VIEW_MORE', 10);
appRoot.constant('PER_PAGE', 20);
appRoot.constant('MAX_PAGE_SIZE', 10);

//constant for maximun file storage.
appRoot.constant('MAX_SIZE_UPLOAD', 10485760);
appRoot.constant('MAX_FILE_UPLOAD', 20);

//main controller
appRoot.controller('iofficezCtrl', ['$scope', function ($scope) {
        ///////////////////////////////////
        $scope.clearCache = function () {
//            $templateCache.removeAll();
        }

        $scope.clearCache();
        ///////////////////////////
    }]);

// run project
appRoot.run(function ($rootScope, socketService, notifyService, taskService, $sce) {
    //init
    notifyService.countNotification({}, function (respone) {
        $rootScope.sum_notify = respone.objects;
    });

    //Get notification
    socketService.on('broadcast', function (data) {
        notifyService.countNotification({}, function (respone) {
            $rootScope.sum_notify = respone.objects;
        });
    });

    $rootScope.getNotifications = function () {
        notifyService.getNotifications({}, function (respone) {
            $rootScope.notifications = respone.objects.collection;
        });
    }

    $rootScope.getHtml = function (html) {
        return $sce.trustAsHtml(html);
    };

    $rootScope.getTaskForDropdown = function () {
        taskService.getTaskForDropdown({}, function (respone) {
            $rootScope.taskDropdown = respone.objects.collection;
        });
    }

    $rootScope.doSomething = function (typedthings) {
        console.log("Do something like reload data with this: " + typedthings);
        
    }
    
    $rootScope.movies = ["The Wolverine lsdf asd flasdf adslfjasd flsjafjsalfjlas flsad d fjksadj dfskajfls flsf iewosdfkas fkasj flkads iasiew lksaddf asdlkfj kasafk adsdfjiowisl fkasjdfklj wioei sfklfj lasj fkladsjfiew iosdf ladskfj wioe asdfasjklfjasdkd fkasdjoif we aslfska fkl jadsfiwji ffasjo", "The Smurfs 2", "The Mortal Instruments: City of Bones", "Drinking Buddies", "All the Boys Love Mandy Lane", "The Act Of Killing", "Red 2", "Jobs", "Getaway", "Red Obsession", "2 Guns", "The World's End", "Planes", "Paranoia", "The To Do List", "Man of Steel", "The Way Way Back", "Before Midnight", "Only God Forgives", "I Give It a Year", "The Heat", "Pacific Rim", "Pacific Rim", "Kevin Hart: Let Me Explain", "A Hijacking", "Maniac", "After Earth", "The Purge", "Much Ado About Nothing", "Europa Report", "Stuck in Love", "We Steal Secrets: The Story Of Wikileaks", "The Croods", "This Is the End", "The Frozen Ground", "Turbo", "Blackfish", "Frances Ha", "Prince Avalanche", "The Attack", "Grown Ups 2", "White House Down", "Lovelace", "Girl Most Likely", "Parkland", "Passion", "Monsters University", "R.I.P.D.", "Byzantium", "The Conjuring", "The Internship"];


    $rootScope.doSomethingElse = function (suggestion) {
        console.log("Suggestion selected: " + suggestion);
    }
});
