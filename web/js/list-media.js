(function ($) {

    $(".media-music .btn-delete").click(function (e) {
        e.preventDefault();
        var $btn = $(this);
        var $media = $btn.parents(".media-music");
        $.ajax({
            url: $btn.data("delete-path"),
            method: "DELETE",
            success: function (data) {
                $media.fadeOut();
            },
            error: function (error) {
                console.log(error);
                alert(error);
            }
        });

    });

})(jQuery);