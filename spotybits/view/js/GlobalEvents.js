// Eventos globales compartidos por toda la app

document.addEventListener('DOMContentLoaded', function () {

    // Cerrar menú hamburguesa al hacer click en un enlace
    const navbarCollapse = document.querySelector('.navbar-collapse');
    if (navbarCollapse) {
        const toggler = document.querySelector('.navbar-toggler');
        navbarCollapse.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (toggler && !toggler.classList.contains('collapsed')) {
                    toggler.click();
                }
            });
        });
    }

});
