// CRUD de productos del panel de administración

class AdminProductos {
    constructor(apiUrl) {
        this.api = apiUrl;
        this.contenedor = null;
    }

    // Punto de entrada: pinta el formulario y carga los productos
    async cargar(contenedor) {
        this.contenedor = contenedor;
        this.pintarFormulario();
        this.registrarEventos();
        await this.listar();
    }

    // Formulario para añadir/editar producto
    pintarFormulario() {
        this.contenedor.innerHTML = `
            <form id="form-producto" class="mb-4">
                <h5>Añadir producto</h5>
                <div class="mb-2">
                    <input type="text" class="form-control" id="nombre" placeholder="Nombre" required>
                </div>
                <div class="mb-2">
                    <textarea class="form-control" id="descripcion" placeholder="Descripción" required></textarea>
                </div>
                <div class="mb-2">
                    <input type="number" step="0.01" class="form-control" id="precio" placeholder="Precio" required>
                </div>
                <div class="mb-2">
                    <input type="number" class="form-control" id="stock" placeholder="Stock" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Tipo</label>
                    <select id="tipo" class="form-select">
                        <option value="primer">Primer plato</option>
                        <option value="segundo">Segundo plato</option>
                        <option value="postre">Postre</option>
                        <option value="bebida">Bebida</option>
                    </select>
                </div>
                <button class="btn btn-success">Guardar producto</button>
            </form>
            <div id="lista-productos"></div>
        `;
    }

    // Eventos: submit del formulario + clicks en editar/eliminar (delegación)
    registrarEventos() {
        const form = document.getElementById('form-producto');
        if (form) {
            form.addEventListener('submit', (e) => this.guardar(e));
        }

        const lista = document.getElementById('lista-productos');
        if (lista) {
            lista.addEventListener('click', (e) => {
                const btn = e.target.closest('button[data-accion]');
                if (!btn) return;

                const id = parseInt(btn.dataset.id);
                const accion = btn.dataset.accion;

                if (accion === 'editar') this.editar(id);
                if (accion === 'eliminar') this.eliminar(id);
            });
        }
    }

    // Obtiene productos de la API y los pinta
    async listar() {
        try {
            const res = await fetch(this.api);
            const productos = await res.json();
            this.pintar(productos);
        } catch {
            this.contenedor.innerHTML += "<p class='text-muted'>No se pudieron cargar los productos</p>";
        }
    }

    // Renderiza las tarjetas de productos
    pintar(productos) {
        const lista = document.getElementById('lista-productos');
        if (!lista) return;

        lista.innerHTML = productos.map(p => `
            <div class="card bg-dark text-white mb-3">
                <div class="card-body">
                    <h5>${escapeHTML(p.nombre)}</h5>
                    <p>${escapeHTML(p.descripcion)}</p>
                    <p class="text-success fw-bold">${escapeHTML(p.precio)} €</p>
                    <p class="text-muted">Stock: ${escapeHTML(p.stock)}</p>
                    <button class="btn btn-warning btn-sm me-2" data-accion="editar" data-id="${escapeHTML(p.id)}">✏️ Editar</button>
                    <button class="btn btn-danger btn-sm" data-accion="eliminar" data-id="${escapeHTML(p.id)}">🗑️ Eliminar</button>
                </div>
            </div>
        `).join('');
    }

    // Crea un producto nuevo o actualiza uno existente
    async guardar(e) {
        e.preventDefault();

        const form = document.getElementById('form-producto');
        const editandoId = form?.dataset.editando;

        const producto = {
            nombre: document.getElementById('nombre').value,
            descripcion: document.getElementById('descripcion').value,
            precio: document.getElementById('precio').value,
            stock: document.getElementById('stock').value,
            tipo: document.getElementById('tipo')?.value || null
        };

        let method = 'POST';
        if (editandoId) {
            producto.id = editandoId;
            method = 'PUT';
        }

        try {
            await fetch(this.api, {
                method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(producto)
            });
            form.reset();
            delete form.dataset.editando;
            await this.listar();
        } catch {
            alert('Error al guardar producto');
        }
    }

    // Carga los datos de un producto en el formulario para editarlo
    async editar(id) {
        try {
            const res = await fetch(this.api);
            const productos = await res.json();
            const p = productos.find(x => x.id == id);
            if (!p) return;

            document.getElementById('nombre').value = p.nombre;
            document.getElementById('descripcion').value = p.descripcion;
            document.getElementById('precio').value = p.precio;
            document.getElementById('stock').value = p.stock;
            if (p.tipo) document.getElementById('tipo').value = p.tipo;

            document.getElementById('form-producto').dataset.editando = id;
        } catch {
            console.error('Error al cargar producto para editar');
        }
    }

    // Elimina un producto tras confirmar
    async eliminar(id) {
        if (!confirm('¿Seguro que quieres eliminar este producto?')) return;

        try {
            const res = await fetch(this.api, {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            });

            if (!res.ok) {
                const data = await res.json().catch(() => null);
                throw new Error(data?.error || 'Error al eliminar');
            }

            await this.listar();
        } catch (err) {
            alert('No se pudo eliminar: ' + err.message);
        }
    }
}
