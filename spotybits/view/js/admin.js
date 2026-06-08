// Coordinador del panel de administración
// Solo gestiona la navegación entre secciones y delega a cada módulo

class AdminApp {
    constructor() {
        this.contenedor = document.getElementById('admin-contenido');
        this.modulos = {};
        this.initNav();
    }

    // Registra un módulo para una sección
    registrar(nombre, modulo) {
        this.modulos[nombre] = modulo;
    }

    // Configura los clicks del menú lateral
    initNav() {
        const aside = document.querySelector('aside');
        if (!aside) return;

        aside.addEventListener('click', (e) => {
            const boton = e.target.closest('[data-seccion]');
            if (!boton) return;

            // Marcar botón activo
            document.querySelectorAll('[data-seccion]').forEach(b => b.classList.remove('active'));
            boton.classList.add('active');

            this.cargarSeccion(boton.dataset.seccion);
        });
    }

    // Carga la sección seleccionada
    cargarSeccion(seccion) {
        if (!this.contenedor) return;
        this.contenedor.innerHTML = '';

        // Ocultar ofertas por defecto
        const ofertaWrapper = document.getElementById('oferta-form-wrapper');
        if (ofertaWrapper) ofertaWrapper.style.display = 'none';

        // Ofertas se gestiona desde PHP, solo mostrar/ocultar
        if (seccion === 'ofertas') {
            if (ofertaWrapper) ofertaWrapper.style.display = '';
            else this.contenedor.innerHTML = "<p class='text-muted'>Ofertas (en construcción)</p>";
            return;
        }

        // Delegar al módulo correspondiente
        const modulo = this.modulos[seccion];
        if (modulo) modulo.cargar(this.contenedor);
    }
}

// --- Inicialización ---
// Registra cada módulo y carga la sección por defecto

// Escapa caracteres HTML para prevenir XSS al inyectar datos de la API
function escapeHTML(str) {
    return String(str ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

const BASE_API = '/Web_Spotify/SPOTYBITS/spotybits/controller/api';
const app = new AdminApp();

app.registrar('productos', new AdminProductos(`${BASE_API}/productosAPI.php`));
app.registrar('pedidos',   new AdminPedidos(`${BASE_API}/pedidosAPI.php`));
app.registrar('logs',      new AdminLogs(`${BASE_API}/logsAPI.php`));
app.registrar('monedas',   new AdminMonedas(`${BASE_API}/pedidosAPI.php`));

app.cargarSeccion('productos');
