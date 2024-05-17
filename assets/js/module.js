$(document).ready(function () {
    $("#content").load("menu/mod_dashboard.html", function () {
    });

    $("#nav_dashboard").on("click", function () {
        $("#content").load("menu/mod_dashboard.html", function () {
        });
    });

    $("#nav_data_pasien").on("click", function () {
        $("#content").load("menu/mod_data_pasien.html", function () {
        });
    });
});