const API_KEY = 'fca_live_T9ZBfrq8iA7HTWnxLj2ZQ1aP95jfDejqi1ANb2zc';

class CurrencyService {
    constructor(apiKey = API_KEY, base = 'EUR') {
        this.apiKey = apiKey;
        this.base = base;
        this.endpoint = 'https://api.freecurrencyapi.com/v1/latest';
    }

    // obtiene tipos de cambio relativos a EUR.
    async getRates(symbols = []) {
        const symbolsParam = symbols.filter(s => s && s !== this.base).join(',');

        const url = new URL(this.endpoint);
        url.searchParams.set('apikey', this.apiKey);
        url.searchParams.set('base_currency', this.base);
        if (symbolsParam) url.searchParams.set('symbols', symbolsParam);

        const res = await fetch(url.toString());
        if (!res.ok) {
            throw new Error('Network response was not ok');
        }

        const json = await res.json();

        const rates = json.data || json.rates || json;

        if (!rates) throw new Error('Invalid response from currency API');

        const normalized = Object.assign({}, rates);
        normalized[this.base] = 1;

        return normalized;
    }
}

//inicializador global llamado desde admin.js después de renderizar la tabla de pedidos
window.initCurrencyWidget = function initCurrencyWidget() {
    const select = document.getElementById('currency-select-admin');
    const errorDiv = document.getElementById('currency-error');
    const thTotal = document.getElementById('th-total');

    if (!select) return; 

    const supported = ['EUR','USD','GBP','MXN'];

    //restaurar moneda de localStorage o por defecto EUR
    const stored = localStorage.getItem('admin_currency') || 'EUR';
    if (supported.includes(stored)) select.value = stored;

    const service = new CurrencyService(API_KEY, 'EUR');

    async function updateCurrency(to) {
        errorDiv.style.display = 'none';
        thTotal.textContent = `Total (${to})`;

        //si la moneda es EUR no necesitamos llamar a la API
        let rates = { EUR: 1 };
        try {
            if (to !== 'EUR') {
                const r = await service.getRates([to]);
                rates = r;
            }

            // convierte todos los importes que tengan el atributo data-eur
            const nodes = Array.from(document.querySelectorAll('.importe'));

            // obtiene los importes convertidos y actualizar cada celda
            const converted = nodes.map(node => {
                const eur = parseFloat(node.dataset.eur || '0') || 0;
                const factor = rates[to] || 1;
                const value = eur * factor;

                //formateo de moneda usando Intl
                try {
                    node.textContent = new Intl.NumberFormat(undefined, { style: 'currency', currency: to }).format(value);
                } catch (e) {
                    node.textContent = value.toFixed(2) + ' ' + to;
                }

                return value;
            });

            const totalSum = converted.reduce((acc, cur) => acc + cur, 0);

            console.debug('Total pedidos en', to, totalSum);

        } catch (err) {
            console.error('Currency error', err);
            errorDiv.style.display = '';
            errorDiv.textContent = 'No se ha podido obtener el tipo de cambio. Mostrando EUR.';
            localStorage.setItem('admin_currency', 'EUR');
            select.value = 'EUR';
            document.querySelectorAll('.importe').forEach(node => {
                const eur = parseFloat(node.dataset.eur || '0') || 0;
                node.textContent = eur.toFixed(2) + ' EUR';
            });
            thTotal.textContent = 'Total (EUR)';
        }
    }

    // evento al cambiar
    select.addEventListener('change', (e) => {
        const moneda = e.target.value;
        localStorage.setItem('admin_currency', moneda);
        updateCurrency(moneda);
    });

    // inicializar con la moneda guardada
    updateCurrency(select.value);
};

if (typeof module !== 'undefined') module.exports = { CurrencyService };
