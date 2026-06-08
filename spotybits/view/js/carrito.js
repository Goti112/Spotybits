// Preparación del formulario de carrito antes de confirmar pedido

class CarritoApp {
    constructor() {
        this.init();
    }

    // Escucha el submit del formulario de confirmar pedido
    init() {
        const confirmForm = document.getElementById('confirmar-pedido-form');
        if (!confirmForm) return;
        confirmForm.addEventListener('submit', (e) => this.prepararPedido(e, confirmForm));
    }

    // Inyecta campos ocultos de dirección antes de enviar
    prepararPedido(e, form) {
        if (!confirm('¿Deseas confirmar el pedido?')) {
            e.preventDefault();
            return;
        }

        const campos = [
            ['calle',         'direccion_calle'],
            ['localidad',     'direccion_localidad'],
            ['estado',        'direccion_estado'],
            ['codigo_postal', 'direccion_cp']
        ];

        campos.forEach(([name, id]) => {
            const input = document.getElementById(id);
            const existing = form.querySelector(`input[name="${name}"]`);
            if (existing) existing.remove();

            const hidden = document.createElement('input');
            hidden.type  = 'hidden';
            hidden.name  = name;
            hidden.value = input ? input.value : '';
            form.appendChild(hidden);
        });
    }
}

document.addEventListener('DOMContentLoaded', () => new CarritoApp());
