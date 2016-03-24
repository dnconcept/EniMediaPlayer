var selector = ".media-music";
var audioPlayer,
    isPlaying = false,
    timer;
var $avancement,
    $musicName,
    $musicTitle,
    $medias,
    $timeNow,
    $timeTot,
    $search,
    $btnPlay,
    $btnMinVolume,
    $btnMaxVolume,
    $rangeVolume,
    $volumeText,
    $btnRandom,
    $nextSong,
    $prevSong,
    $currentMedia;
// fonction executée au chargement de la page web :
$(document).ready(function () {
    //Affectation des boutons
    $avancement = $('#rangeAvancement');
    $musicName = $("#name");
    $musicTitle = $("#title");
    $medias = $(selector);
    $timeNow = $("#timeNow");
    $timeTot = $("#timeTot");
    $search = $("#recherche");
    $btnPlay = $("#btnPlay");
    $btnMinVolume = $("#minVolume");
    $btnMaxVolume = $("#maxVolume");
    $rangeVolume = $("#rangeVolume");
    $volumeText = $("#volumeText");
    $btnRandom = $("#btnRandom");
    $nextSong = $("#nextSong");
    $prevSong = $("#prevSong");

    audioPlayer = $('#mediaPlayer')[0];

    setVolume(.5);

    $btnPlay.click(function (e) {
        e.preventDefault();
        playOrPause();
    });
    $btnMinVolume.click(function (e) {
        e.preventDefault();
        decrease();
    });
    $btnMaxVolume.click(function (e) {
        e.preventDefault();
        increase();
    });
    $rangeVolume.change(function (e) {
        e.preventDefault();
        setVolume($rangeVolume.val() / 100);
    });
    $btnRandom.click(function () {
        var index = Math.floor(Math.random() * $medias.length);
        playMediaMusic($medias.eq(index));
    });
    $avancement.change(function () {
        setAvancement();
    });
    $avancement.mousedown(function () {
        stopTimer();
    });
    $avancement.mouseup(function () {
        setAvancement();
    });

    $prevSong.click(function (e) {
        e.preventDefault();
        if (!$currentMedia)
            $currentMedia = $medias.first();
        playMediaMusic($currentMedia.prev());
    });

    $nextSong.click(function (e) {
        e.preventDefault();
        if (!$currentMedia)
            $currentMedia = $medias.first();
        playMediaMusic($currentMedia.next());
    });

    $(".btn-play").bind("click", selector, function (e) {
        e.preventDefault();
        playMediaMusic($(this).parents(selector));
        playOrPause(true);
    });

    //Play first music
    playMediaMusic($medias.first());

});

function playMediaMusic($media) {
    if (!$media || $media.length == 0)
        $media = $medias.first();
    if (!$media)
        return;
    $currentMedia = $media;
    audioPlayer.src = $media.data("music-path");
    $musicName.html("<b>" + $media.data("name") + "</b>");
    $musicTitle.html("<b>" + $media.data("title") + "</b>");
    update(audioPlayer);
}

function playOrPause(force) {
    force = force || false;
    if (!isPlaying || force) {
        audioPlayer.play();
        isPlaying = true;
        majAvancement();
        $("#playIcon").removeClass('fa-play').addClass('fa-stop');

    } else {
        stopTimer();
        audioPlayer.pause();
        isPlaying = false;
        $("#playIcon").removeClass('fa-stop').addClass('fa-play');
    }

}

function stopTimer() {
    window.clearTimeout(timer);
}

function setAvancement() {
    // Arrêt du timer
    stopTimer();
    audioPlayer.currentTime = $avancement.val() * audioPlayer.duration / 100;
    majAvancement();
}

function majAvancement() {
    $avancement.val(audioPlayer.currentTime * 100 / audioPlayer.duration);
    timer = setTimeout("majAvancement()", 1000);
}

function setVolume(volume) {
    audioPlayer.volume = volume;
    $volumeText.html(parseFloat(volume * 100, 10).toFixed(0) + "%");
    if ($rangeVolume.val() != volume) {
        $rangeVolume.val(volume * 100);
    }
}

function increase() {
    var volume = audioPlayer.volume + 0.2;
    if (volume > 1)
        volume = 1;
    setVolume(volume);
}

function decrease() {
    var volume = audioPlayer.volume - 0.2;
    if (volume < 0)
        volume = 0;
    setVolume(volume);
}

function update(player) {
    var duration = player.duration;    // Durée totale
    if (duration)
        $timeTot.html(getTime(duration));
    var time = player.currentTime; // Temps écoulé
    if (time)
        $timeNow.html(getTime(time));
}

function getTime(timer) {
    var temp, heures, secondes, minutes;
    temp = timer % 3600;
    heures = (timer - temp) / 3600;
    secondes = Math.ceil(temp % 60);
    minutes = Math.ceil((temp - secondes) / 60);
    return minutes + ":" + (secondes < 10 ? "0" + secondes : secondes);
}

function filtre() {
    var search = $search.val().toLowerCase();
    $medias.each(function () {
        var $element = $(this);
        if ($element.data("title").toLowerCase().indexOf(search) != -1) {
            $element.removeClass("hide");
        } else {
            $element.addClass("hide");
        }
    });
}