// Definición global de la función mostrarReseñas
function mostrarReseñas(resenas) {
    console.log(resenas); // Log para depuración
    $("#opiCant").html(resenas.length); // Actualiza el contador de opiniones
    const reseñasContainer = $("#resenasContainer"); // Contenedor de las reseñas
    reseñasContainer.empty(); // Limpia antes de añadir nuevas reseñas

    resenas.forEach(function (resena) {
        reseñasContainer.append(`
            <div class="resena">
                <p><strong>${resena.Nombre || "Usuario"} ${resena.Apellido || ""}</strong></p>
                <p>${resena.Comentario || "Sin comentario disponible."}</p>
                <p>Valoración: ${"★".repeat(Math.round(parseFloat(resena.Rating || 0)))}</p>
                <p><small>${new Date(resena.Fecha).toLocaleDateString()}</small></p>
            </div>
        `);
    });
}

// Código dentro de $(document).ready()
$(document).ready(function () {
    const usuarioAcciones = document.getElementById('usuarioAcciones');
    const userData = sessionStorage.cedula;

    if (userData) {
        // Si hay datos, mostrar el dropdown
        usuarioAcciones.innerHTML = `
            <div class="profile-dropdown">
                <button class="profile-drop" id="profileMenu">
                    <img src="../assets/${sessionStorage.foto}.png" id="profPic" alt="ProfPic" class="profile-img">
                    <span class="profile-name">${sessionStorage.nombre} ${sessionStorage.apellido}</span>
                </button>
                <div class="profile-dropdown-content">
                    <a href="../Vistas/manejos/manejoUsuario.html">Mi Perfil</a>
                    <a href="#">Mis Likes</a>
                    <a id="btnLogout" style="cursor: pointer; color: white;">Desloguearse</a>
                </div>
            </div>
        `;

        // Agregar evento para alternar el menú desplegable
        $('#profileMenu').on('click', function (event) {
            event.stopPropagation(); // Evita que el clic se propague
            $('.profile-dropdown-content').toggle(); // Muestra u oculta el dropdown
        });

        // Ocultar el menú cuando se hace clic fuera
        $(document).on('click', function () {
            $('.profile-dropdown-content').hide();
        });

        // Evento para el botón de Desloguearse
        $('#btnLogout').on('click', function () {
            // Limpiar datos de sesión
            sessionStorage.clear();
            // Redirigir a la página de inicio o a donde desees
            window.location.href = '../index.php'; // Cambia esta ruta según tus necesidades
        });

    } else {
        // Si no hay datos, mostrar botones de registro y logueo
        usuarioAcciones.innerHTML = `
            <a href="../Vistas/registros/division.html" class="mr-2 btn btn-custom">Crea tu cuenta</a>
            <a href="../Vistas/inicios/divisionIni.html" id="btnInicio" class="btn btn-custom mr-2">Ingresa</a>
            <button class="btn btn-custom mr-2">Mis compras</button>
        `;
    }

    // Extraer el parámetro `id` del producto desde la URL
    const urlParams = new URLSearchParams(window.location.search);
    const idProducto = urlParams.get('id');
    console.log("ID del producto extraído de la URL:", idProducto);

    if (idProducto) {
        // Llama a la función para obtener los datos del producto
        cargarDetalleProducto(idProducto);
    } else {
        alert("No se encontró el producto.");
    }
});

function cargarDetalleProducto(idProducto) {
    $.ajax({
        url: "../Controlador/ArticuloControlador.php", // Ruta al controlador
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify({
            action: "getById", // Acción definida en el backend para obtener un artículo por su ID
            id_articulo: idProducto
        }),
        success: function (response) {
            if (response) {
                console.log("Respuesta del servidor:", response);
                actualizarVistaProducto(response);
                cargarReseñas(idProducto); // Cargar las reseñas para el artículo
            } else {
                alert("No se encontró información del producto.");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
            alert("Hubo un error al cargar el producto.");
        }
    });
}

function actualizarVistaProducto(producto) {
    // Actualizar imagen
    $("img[alt='Producto']").attr("src", producto.foto_url || 'https://via.placeholder.com/500');

    // Actualizar título
    $(".card-title").html(`
        ${producto.Nombre}
        <a href="#" class="text-danger" title="Guardar como Favorito">
            <i class="bi bi-heart"></i>
        </a>
    `);

    // Actualizar valoración y opiniones
    const estrellas = Math.round(producto.Valoracion || 0);
    $(".text-warning").html("&#9733;".repeat(estrellas) + "&#9734;".repeat(5 - estrellas));
    $(".text-warning").next("small").text(`(${producto.NumeroOpiniones || 0} opiniones)`);

    // Actualizar precio
    $(".text-primary").text(`$${producto.Precio}`);

    // Actualizar descripción (envío, disponibilidad, etc.)
    $(".card-text").text(producto.Descripcion || "Sin descripción disponible.");
}

// Función para cargar las reseñas de un artículo
function cargarReseñas(idArticulo) {
    $.ajax({
        url: "../Controlador/ResenaControlador.php", // Ruta al controlador de reseñas
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify({
            action: "getReseñasByArticulo", // Acción para obtener las reseñas de un artículo
            id_articulo: idArticulo
        }),
        success: function (response) {
            console.log(response); // Log para depuración
            if (response && !response.error) {
                mostrarReseñas(response); // Si hay reseñas, mostrarlas
            } else {
                $("#resenasContainer").html("<b>No se encontraron reseñas sobre este producto.</b>");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
            alert("Hubo un error al cargar las reseñas.");
        }
    });
}
