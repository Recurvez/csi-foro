$(document).ready(function () {
    $(".start").click(function () {
        let user = $(this).data("user");
        $.post("times/start_time.php", { user: user }, function (data) {
            location.reload();
        });
    });

    $(".pause").click(function () {
        let user = $(this).data("user");
        $.post("times/pause_time.php", { user: user }, function (data) {
            location.reload();
        });
    });

    $(".resume").click(function () {
        let user = $(this).data("user");
        $.post("times/resume_time.php", { user: user }, function (data) {
            location.reload();
        });
    });

    $(".stop").click(function () {
        let user = $(this).data("user");
        $.post("times/stop_time.php", { user: user }, function (data) {
            location.reload();
        });
    });
});
