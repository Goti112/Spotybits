// Servicio de conversión de moneda y sección Monedas del admin

const CURRENCY_API_KEY = 'fca_live_T9ZBfrq8iA7HTWnxLj2ZQ1aP95jfDejqi1ANb2zc';

// Clase para obtener tipos de cambio desde la API
class CurrencyService {
    constructor(apiKey, base = 'EUR') {
        this.apiKey = apiKey;
        this.base = base;
        this.endpoint = 'https://api.freecurrencyapi.com/v1/latest';
    }

    // Obtiene tipos de cambio relativos a la moneda base
    async getRates(symbols = []) {
        const url = new URL(this.endpoint);
        url.searchParams.set('apikey', this.apiKey);
        url.searchParams.set('base_currency', this.base);

        const filtered = symbols.filter(s => s && s !== this.base).join(',');
        if (filtered) url.searchParams.set('symbols', filtered);

        const res = await fetch(url.toString());
        if (!res.ok) throw new Error('Error de red');

        const json = await res.json();
        const rates = json.data || json.rates || json;
        if (!rates) throw new Error('Respuesta inválida');

        rates[this.base] = 1;
        return rates;
    }
}

// HTML compartido del selector de moneda (reutilizado en Pedidos y Monedas)
function currencyWidgetHTML() {
    return `
        <div class="mb-3 d-flex align-items-center">
            <label for="currency-select-admin" class="me-2 mb-0">Moneda:</label>
            <select id="currency-select-admin" class="form-select form-select-sm w-auto">
                <option value="EUR">EUR</option>
                <option value="USD">USD</option>
                <option value="GBP">GBP</option>
                <option value="MXN">MXN</option>
            </select>
            <div id="currency-error" class="text-danger ms-3" style="display:none"></div>
        </div>
    `;
}

// Sección "Monedas": muestra pedidos con conversión de moneda
class AdminMonedas {
    constructor(apiPedidos) {
        this.api = apiPedidos;
        this.contenedor = null;
    }

    // Punto de entrada
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

    // Renderiza tabla de pedidos con selector de moneda
    pintar(pedidos) {
        if (!pedidos?.length) {
            this.contenedor.innerHTML = "<p class='text-muted'>No hay pedidos</p>";
            return;
        }

        let html = `
            <h5 class="mb-3">Pedidos (conversión de moneda)</h5>
            ${currencyWidgetHTML()}
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th id="th-total">Total (EUR)</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
        `;

        pedidos.forEach(p => {
            html += `
                <tr>
                    <td>${escapeHTML(p.id)}</td>
                    <td>${escapeHTML(p.fecha)}</td>
                    <td class="importe" data-eur="${escapeHTML(p.importe_total)}">${escapeHTML(p.importe_total)}</td>
                    <td>${escapeHTML(p.id_usuario ?? '—')}</td>
                </tr>
            `;
        });

        html += `</tbody></table>`;
        this.contenedor.innerHTML = html;

        // Activar widget de conversión
        if (window.initCurrencyWidget) window.initCurrencyWidget();
    }
}

// Widget global de conversión de moneda
// Lo usan tanto Pedidos como Monedas tras renderizar sus tablas
window.initCurrencyWidget = function () {
    const select = document.getElementById('currency-select-admin');
    const errorDiv = document.getElementById('currency-error');
    const thTotal = document.getElementById('th-total');
    if (!select) return;

    // Restaurar moneda guardada
    const stored = localStorage.getItem('admin_currency') || 'EUR';
    if (['EUR', 'USD', 'GBP', 'MXN'].includes(stored)) select.value = stored;

    const service = new CurrencyService(CURRENCY_API_KEY);

    // Convierte todos los importes a la moneda seleccionada
    async function convertir(to) {
        errorDiv.style.display = 'none';
        thTotal.textContent = `Total (${to})`;

        try {
            const rates = to === 'EUR' ? { EUR: 1 } : await service.getRates([to]);

            document.querySelectorAll('.importe').forEach(node => {
                const eur = parseFloat(node.dataset.eur) || 0;
                const valor = eur * (rates[to] || 1);
                try {
                    node.textContent = new Intl.NumberFormat(undefined, { style: 'currency', currency: to }).format(valor);
                } catch {
                    node.textContent = valor.toFixed(2) + ' ' + to;
                }
            });
        } catch {
            errorDiv.style.display = '';
            errorDiv.textContent = 'No se pudo obtener el tipo de cambio.';
            localStorage.setItem('admin_currency', 'EUR');
            select.value = 'EUR';
            thTotal.textContent = 'Total (EUR)';
            document.querySelectorAll('.importe').forEach(n => {
                n.textContent = (parseFloat(n.dataset.eur) || 0).toFixed(2) + ' EUR';
            });
        }
    }

    // Evento: cambio de moneda
    select.addEventListener('change', (e) => {
        localStorage.setItem('admin_currency', e.target.value);
        convertir(e.target.value);
    });

    // Convertir al cargar
    convertir(select.value);
};
