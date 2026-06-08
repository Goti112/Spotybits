// Filtrado de productos en la carta por tipo de plato

class CartaFiltros {
    constructor() {
        this.filtros = document.querySelectorAll('.filtros li');
        this.productos = document.querySelectorAll('.producto-col');
        if (this.filtros.length === 0) return;
        this.init();
    }

    // Click en cada filtro del sidebar
    init() {
        this.filtros.forEach(li => {
            li.addEventListener('click', () => this.filtrar(li));
        });
    }

    // Muestra/oculta productos según el tipo seleccionado
    filtrar(li) {
        this.filtros.forEach(x => x.classList.remove('activo'));
        li.classList.add('activo');

        const texto = li.textContent.trim().toLowerCase();
        const map = {
            'primer plato': 'primer',
            'segundo plato': 'segundo',
            'postres': 'postre',
            'postre': 'postre',
            'bebidas': 'bebida',
            'bebida': 'bebida'
        };

        const tipo = map[texto] || null;

        this.productos.forEach(col => {
            const t = (col.dataset.tipo || '').toLowerCase();
            if (!tipo) {
                col.style.display = '';
                return;
            }
            col.style.display = (t === tipo) ? '' : 'none';
        });
    }
}

document.addEventListener('DOMContentLoaded', () => new CartaFiltros());
