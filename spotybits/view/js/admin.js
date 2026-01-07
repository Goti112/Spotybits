document.addEventListener("DOMContentLoaded", () => {
    //por defecto se carga la seccion de productos
    cargarSeccion("productos");

    const aside = document.querySelector('aside');
    if (aside) {
        aside.addEventListener('click', (e) => {
            const boton = e.target.closest('[data-seccion]');
            if (!boton) return;

            const seccion = boton.dataset.seccion;

            document.querySelectorAll('[data-seccion]').forEach(b => b.classList.remove('active'));
            boton.classList.add('active');

            cargarSeccion(seccion);
        });
    }
});

//control de las secciones
function cargarSeccion(seccion) {
    const contenedor = document.getElementById("admin-contenido");
    contenedor.innerHTML = "";

    // ocultar por defecto el wrapper de ofertas si existe
    const ofertaWrapper = document.getElementById('oferta-form-wrapper');
    if (ofertaWrapper) ofertaWrapper.style.display = 'none';

    if (seccion === "productos") {
        pintarFormularioProducto();
        cargarProductos();
    }

    if (seccion === "pedidos") {
        cargarPedidos();
    }

    if (seccion === "logs") {
        contenedor.innerHTML = "<p class='text-muted'>Logs (en construcción)</p>";
    }

    if (seccion === "monedas") {
        contenedor.innerHTML = "<p class='text-muted'>Monedas (en construcción)</p>";
    }

    if (seccion === "ofertas") {
        const wrapper = document.getElementById('oferta-form-wrapper');
        if (wrapper) {
            // mostrar el wrapper original (está fuera del contenedor principal)
            wrapper.style.display = '';
            // asegurar que el contenedor principal quede vacío
            contenedor.innerHTML = '';
        } else {
            contenedor.innerHTML = "<p class='text-muted'>Ofertas (en construcción)</p>";
        }
    }
}

//formulario para añadir productos
function pintarFormularioProducto() {
    const contenedor = document.getElementById("admin-contenido");

    contenedor.innerHTML = `
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

            <button class="btn btn-success">Guardar producto</button>
        </form>

        <div id="lista-productos"></div>
    `;

    document.getElementById("form-producto")
        .addEventListener("submit", crearProducto);
}

//functiones para cargar y mostrar productos
function cargarProductos() {
    fetch("/Web_Spotify/SPOTYBITS/spotybits/controller/api/productosAPI.php")
        .then(res => res.json())
        .then(productos => mostrarProductos(productos))
        .catch(() => mostrarError("No se han podido cargar los productos"));
}

function mostrarProductos(productos) {
    const contenedor = document.getElementById("lista-productos");
    contenedor.innerHTML = "";

    productos.forEach(producto => {
        contenedor.innerHTML += `
            <div class="card bg-dark text-white mb-3">
                <div class="card-body">
                    <h5>${producto.nombre}</h5>
                    <p>${producto.descripcion}</p>
                    <p class="text-success fw-bold">${producto.precio} €</p>
                    <p class="text-muted">Stock: ${producto.stock}</p>

                    <button class="btn btn-warning btn-sm me-2"
                        onclick="editarProducto(${producto.id})">✏️ Editar</button>

                    <button class="btn btn-danger btn-sm"
                        onclick="eliminarProducto(${producto.id})">🗑️ Eliminar</button>
                </div>
            </div>
        `;
    });
}


//funciones para crear y editar productos
function crearProducto(e) {
    e.preventDefault();

    const form = document.getElementById("form-producto");
    const editandoId = form.dataset.editando;

    const producto = {
        nombre: nombre.value,
        descripcion: descripcion.value,
        precio: precio.value,
        stock: stock.value
    };

    let method = "POST";

    if (editandoId) {
        producto.id = editandoId;
        method = "PUT";
    }

    fetch("/Web_Spotify/SPOTYBITS/spotybits/controller/api/productosAPI.php", {
        method,
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(producto)
    })
    .then(() => {
        form.reset();
        delete form.dataset.editando;
        cargarSeccion("productos");
    });
}

function editarProducto(id) {
    fetch("/Web_Spotify/SPOTYBITS/spotybits/controller/api/productosAPI.php")
        .then(res => res.json())
        .then(productos => {
            const producto = productos.find(p => p.id === id);
            if (!producto) return;

            nombre.value = producto.nombre;
            descripcion.value = producto.descripcion;
            precio.value = producto.precio;
            stock.value = producto.stock;

            document.getElementById("form-producto").dataset.editando = id;
        });
}

//funciones para cargar y mostrar pedidos
function cargarPedidos() {
    fetch("/Web_Spotify/SPOTYBITS/spotybits/controller/api/pedidosAPI.php")
        .then(res => res.json())
        .then(pedidos => mostrarPedidos(pedidos))
        .catch(() => mostrarError("No se han podido cargar los pedidos"));
}

function mostrarPedidos(pedidos) {
    const contenedor = document.getElementById("admin-contenido");

    if (pedidos.length === 0) {
        contenedor.innerHTML = "<p class='text-muted'>No hay pedidos</p>";
        return;
    }

    let html = `
        <h5 class="mb-3">Pedidos</h5>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Total (€)</th>
                    <th>Estado</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
    `;

    pedidos.forEach(pedido => {
        const estadoActual = pedido.estado ?? "pendiente";

        html += `
            <tr>
                <td>${pedido.id}</td>
                <td>${pedido.fecha}</td>
                <td>${pedido.importe_total}</td>
                <td>
                    <select class="form-select form-select-sm bg-dark text-white"
                        onchange="cambiarEstado(${pedido.id}, this.value)">
                        <option value="pendiente" ${estadoActual === "pendiente" ? "selected" : ""}>pendiente</option>
                        <option value="completado" ${estadoActual === "completado" ? "selected" : ""}>completado</option>
                        <option value="cancelado" ${estadoActual === "cancelado" ? "selected" : ""}>cancelado</option>
                    </select>
                </td>
                <td>${pedido.id_usuario ?? "—"}</td>
            </tr>
        `;
    });

    html += `</tbody></table>`;
    contenedor.innerHTML = html;
}

//funcion para cambiar el estado de los pedidos
function cambiarEstado(idPedido, estado) {
    console.log("PUT pedido:", idPedido, estado);

    fetch("/Web_Spotify/SPOTYBITS/spotybits/controller/api/pedidosAPI.php", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: idPedido, estado })
    })
    .then(() => cargarPedidos())
    .catch(() => alert("Error al cambiar estado"));
}
