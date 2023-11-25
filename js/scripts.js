document.onreadystatechange = function () {
  if (document.readyState === "complete") {
    // La página está completamente cargada, oculta el loader
    hideLoader();
  }
};

function hideLoader() {
  // Oculta el loader después de un tiempo de espera (puedes ajustar el tiempo según tus necesidades)
  setTimeout(function () {
    document.querySelector('.loader-wrapper').style.display = 'none';
  }, 1000); // 1000 milisegundos = 1 segundo
}
(function($) {
    "use strict";

    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
        $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
            if (this.href === path) {
                $(this).addClass("active");
            }
        });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });
})(jQuery);

  