// Visualización de logs del panel de administración

class AdminLogs {
    constructor(apiUrl) {
        this.api = apiUrl;
        this.contenedor = null;
    }

    // Punto de entrada: carga y muestra logs
    async cargar(contenedor) {
        this.contenedor = contenedor;
        await this.listar();
    }

    // Obtiene logs de la API
    async listar() {
        try {
            const res = await fetch(this.api);
            const logs = await res.json();
            this.pintar(logs);
        } catch {
            this.contenedor.innerHTML = "<p class='text-muted'>No se pudieron cargar los logs</p>";
        }
    }

    // Renderiza la tabla de logs
    pintar(logs) {
        if (!logs?.length) {
            this.contenedor.innerHTML = "<p class='text-muted'>No hay logs</p>";
            return;
        }

        let html = `
            <h5 class="mb-3">Histórico de Logs</h5>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
        `;

        logs.forEach(l => {
            html += `
                <tr>
                    <td>${escapeHTML(l.id_log)}</td>
                    <td>${escapeHTML(l.fecha)}</td>
                    <td>${escapeHTML(l.accion)}</td>
                    <td>${escapeHTML(l.nombre ?? '—')}</td>
                </tr>
            `;
        });

        html += `</tbody></table>`;
        this.contenedor.innerHTML = html;
    }
}
