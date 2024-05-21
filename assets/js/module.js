$(document).ready(function () {
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    // default
    $("#content").load("menu/mod_dashboard.html", function () {
        sleep(1000);
        const datatablesSimple = document.getElementById('datatablesSimple');
        if (datatablesSimple) {
            new DataTable(datatablesSimple);
        }
    });

    // Per modules
    // -----------
    $("#nav_dashboard").on("click", function () {
        $("#content").load("menu/mod_dashboard.html", function () {
            sleep(1000);
            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                new DataTable(datatablesSimple);
            }
        });
    });

    $("#nav_data_pasien").on("click", function () {
        sleep(2000);
        $("#content").load("menu/mod_data_pasien.html", function () {

        });
    });
});