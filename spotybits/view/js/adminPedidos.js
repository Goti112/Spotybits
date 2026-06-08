// Gestión de pedidos del panel de administración

class AdminPedidos {
    constructor(apiUrl) {
        this.api = apiUrl;
        this.contenedor = null;
    }

    // Punto de entrada: carga y muestra pedidos
    async cargar(contenedor) {
        this.contenedor = contenedor;
        await this.listar();
    }

    // Obtiene pedidos de la API
    async listar() {
        try {
            const res = await fetch(this.api);
            const pedidos = await res.json();
            this.pintar(pedidos);
        } catch {
            this.contenedor.innerHTML = "<p class='text-muted'>No se pudieron cargar los pedidos</p>";
        }
    }

    // Renderiza la tabla de pedidos con selector de moneda y estado
    pintar(pedidos) {
        if (!pedidos?.length) {
            this.contenedor.innerHTML = "<p class='text-muted'>No hay pedidos</p>";
            return;
        }

        let html = `
            <h5 class="mb-3">Pedidos</h5>
            ${currencyWidgetHTML()}
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th id="th-total">Total (EUR)</th>
                        <th>Estado</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
        `;

        pedidos.forEach(p => {
            const estado = p.estado ?? 'pendiente';
            html += `
                <tr>
                    <td>${escapeHTML(p.id)}</td>
                    <td>${escapeHTML(p.fecha)}</td>
                    <td class="importe" data-eur="${escapeHTML(p.importe_total)}">${escapeHTML(p.importe_total)}</td>
                    <td>
                        <select class="form-select form-select-sm bg-dark text-white cambiar-estado" data-id="${escapeHTML(p.id)}">
                            <option value="pendiente" ${estado === 'pendiente' ? 'selected' : ''}>pendiente</option>
                            <option value="completado" ${estado === 'completado' ? 'selected' : ''}>completado</option>
                            <option value="cancelado" ${estado === 'cancelado' ? 'selected' : ''}>cancelado</option>
                        </select>
                    </td>
                    <td>${escapeHTML(p.id_usuario ?? '—')}</td>
                </tr>
            `;
        });

        html += `</tbody></table>`;
        this.contenedor.innerHTML = html;

        // Eventos de cambio de estado (delegación en el contenedor)
        this.contenedor.querySelectorAll('.cambiar-estado').forEach(select => {
            select.addEventListener('change', (e) => {
                this.cambiarEstado(parseInt(e.target.dataset.id), e.target.value);
            });
        });

        // Activar widget de conversión de moneda
        if (window.initCurrencyWidget) window.initCurrencyWidget();
    }

    // Actualiza el estado de un pedido en la API
    async cambiarEstado(id, estado) {
        try {
            await fetch(this.api, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, estado })
            });
            await this.listar();
        } catch {
            alert('Error al cambiar estado');
        }
    }
}
