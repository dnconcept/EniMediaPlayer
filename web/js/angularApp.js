var urlMediaList = "/EniMediaPlayer/web/app_dev.php/media/list-ajax";
var urlGenreList = "/EniMediaPlayer/web/app_dev.php/genre/list-ajax";
var audioPlayer;

var mediaApp = angular.module("mediaApp", []);

mediaApp.controller("HomeCtrl", function ($scope, $http) {
    $scope.activeMedia = null;
    $scope.mediaList = [];
    $scope.avancement = 0;
    $scope.p = {
        timeNow: 0,
        timeTot: 0,
        volume: .05,
    };
    $scope.f = {search: ''};
    $scope.test = function () {
        console.log("test");
    }
    $scope.afterLoadPartial = function () {
        audioPlayer = document.getElementById("mediaPlayer");
    };
    $scope.pause = function () {
        $scope.activeMedia = null;
    };
    $scope.setVolume = function (v) {
        if (!audioPlayer)
            return;
        $scope.p.volume = v;
        audioPlayer.volume = v;
    };
    $scope.applyVolume = function () {
        audioPlayer.volume = $scope.p.volume;
    }
    var step = 0.05;
    $scope.decrease = function () {
        var v = $scope.p.volume || 0;
        v = parseFloat(v);
        $scope.setVolume(v - step < 0 ? 0 : v - step);
    }
    $scope.increase = function () {
        var v = $scope.p.volume || 0;
        v = parseFloat(v);
        $scope.setVolume((v + step > 1) ? 1 : v + step);
    }
    $scope.$watch("activeMedia", function (newValue, oldValue) {
        if (!audioPlayer)
            return;
        if (newValue == null) {
            audioPlayer.pause();
            audioPlayer.src = '';
            $scope.p.timeNow = 0;
            $scope.p.timeTot = 0;
        } else {
            audioPlayer.src = newValue.media_path;
            audioPlayer.volume = $scope.p.volume;
            audioPlayer.play();
            $scope.p.timeNow = 0;
            $scope.p.timeTot = audioPlayer.duration;
        }
    });
    $scope.next = function () {
        if ($scope.mediaList.length === 0)
            return;
        var newIndex = $scope.mediaList.indexOf($scope.activeMedia) + 1;
        if (!$scope.activeMedia || newIndex > $scope.mediaList.length - 1) {
            $scope.activeMedia = $scope.mediaList[0];
        } else {
            $scope.activeMedia = $scope.mediaList[newIndex];
        }
    };
    $scope.prev = function () {
        if ($scope.mediaList.length === 0)
            return;
        var newIndex = $scope.mediaList.indexOf($scope.activeMedia) - 1;
        if (!$scope.activeMedia || newIndex < 0) {
            $scope.activeMedia = $scope.mediaList[$scope.mediaList.length - 1];
        } else {
            $scope.activeMedia = $scope.mediaList[newIndex];
        }
    };
    $scope.random = function () {
        if ($scope.mediaList.length === 0)
            return;
        var index = Math.floor(Math.random() * $scope.mediaList.length);
        $scope.activeMedia = $scope.mediaList[index];
    };
    $scope.playOrStopMedia = function (media) {
        if ($scope.activeMedia == media) {
            $scope.activeMedia = null;
        } else {
            $scope.activeMedia = media;
            audioPlayer.src = media.media_path;
            audioPlayer.volume = $scope.p.volume;
            audioPlayer.play();
            console.log("playing audioplayer", audioPlayer.src);
        }
    };
    //Chargement asynchrone de la liste des médias
    $http.get(urlMediaList)
        .then(function (response) {
            $scope.mediaList = response.data;
        });
    $http.get(urlGenreList)
        .then(function (response) {
            $scope.genreList = response.data;
            angular.forEach($scope.genreList, function(genre){
                genre.checked = true;
            })
        });
});

mediaApp.directive("playPauseButton", function () {
    return {
        restrict: 'E',
        scope: {
            "isActive": "="
        },
        template: '<span ng-if="isActive"><i class="fa fa-stop"></i> Stop</span>' +
        '<span ng-if="!isActive"><i class="fa fa-play"></i> Play</span>'
        ,
    };
});

mediaApp.filter("myTime", function () {
    return function (timer) {
        if (!timer)
            return "0:00";
        var temp, heures, secondes, minutes;
        temp = timer % 3600;
        heures = (timer - temp) / 3600;
        secondes = Math.ceil(temp % 60);
        minutes = Math.ceil((temp - secondes) / 60);
        return minutes + ":" + (secondes < 10 ? "0" + secondes : secondes);
    }
})


