$(document).ready(function () {
    // sidebarToggle
    $("#sidebarToggle").on("click", function (event) {
        event.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
        localStorage.setItem('sb|sidebar-toggle',
            $("body").hasClass("sb-sidenav-toggled"));
    });

    // Datatable Peserta / Menu Peserta
    const links = document.querySelectorAll('.nav-link');
    if (links.length) {
        links.forEach((link) => {
            link.addEventListener('click', (e) => {
                links.forEach((link) => {
                    link.classList.remove('active');
                });
                e.preventDefault();
                link.classList.add('active');
            });
        });
    }
});