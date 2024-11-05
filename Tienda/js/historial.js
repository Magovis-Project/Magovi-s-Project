$(document).ready(function() {
// Comprobamos si hay datos en el storage
const usuarioAcciones = document.getElementById('usuarioAcciones');
const userData = sessionStorage.cedula; 

if (userData) {
    // Si hay datos, mostrar el dropdown
    usuarioAcciones.innerHTML = `
        <div class="profile-dropdown">
            <button class="profile-drop" id="profileMenu">
                <img src="../../../Tienda/assets/${sessionStorage.foto}.png" id="profPic" alt="ProfPic" class="profile-img">
                <span class="profile-name">${sessionStorage.nombre} ${sessionStorage.apellido}</span>
            </button>
            <div class="profile-dropdown-content">
                <a href="../../../Tienda/Vistas/manejos/manejoUsuario.html">Mi Perfil</a>
                <a href="#">Mis Likes</a>
                <a id="btnLogout" style="cursor: pointer">Desloguearse</a>
            </div>
        </div>
    `;

    // Agregar evento para alternar el menú desplegable
    $('#profileMenu').on('click', function(event) {
        event.stopPropagation(); // Evita que el clic se propague
        $('.profile-dropdown-content').toggle(); // Muestra u oculta el dropdown
    });

    // Ocultar el menú cuando se hace clic fuera
    $(document).on('click', function() {
        $('.profile-dropdown-content').hide();
    });

    // Evento para el botón de Desloguearse
    $('#btnLogout').on('click', function() {
        // Limpiar datos de sesión
        sessionStorage.clear();
        // Redirigir a la página de inicio o a donde desees
        window.location.href = '../../../Tienda/index.php'; // Cambia esta ruta según tus necesidades
    });

} else {
    // Si no hay datos, mostrar botones de registro y logueo
    usuarioAcciones.innerHTML = `
        <a href="../../../Tienda/Vistas/registros/division.html" class="mr-2 btn btn-custom">Crea tu cuenta</a>
        <a href="../../../Tienda/Vistas/inicios/divisionIni.html" id="btnInicio" class="btn btn-custom mr-2">Ingresa</a>
        <button class="btn btn-custom mr-2">Mis compras</button>
    `;
}

$.ajax({
    url: "../../Controlador/VioControlador.php",
    method: "POST",
    data: JSON.stringify({
        action: "getAllByUsuario",
        id_usuario: sessionStorage.id // O el ID del usuario que corresponda
    }),
    contentType: "application/json",
    success: function(response) {
        if (Array.isArray(response)) {
            if (response.length === 0) {
                // Si el arreglo está vacío, mostrar un mensaje
                $("#listaVios").html("<p>No se han visto productos todavía.</p>");
            } else {
                mostrarVios(response);
            }
        } else {
            alert("Error al obtener productos vistos: " + response.message);
        }
    },
    error: function(xhr, status, error) {
        console.error("Error en la solicitud AJAX:", error);
        console.log("Respuesta del servidor:", xhr.responseText); // Imprimir la respuesta del servidor
        alert("Hubo un error al obtener los productos vistos.");
    }
});

function mostrarVios(vios) {
    let contenedorVios = $("#listaVios"); // Asegúrate de que este ID coincida con el del elemento en tu HTML
    contenedorVios.empty(); // Limpia los productos vistos existentes

    vios.forEach(vio => {
        contenedorVios.append(`
            <div class="border p-4 rounded-lg bg-card producto">
                <div class="d-flex align-items-center" style="gap: 15px;">
                    <div>
                        <img src="${vio.foto_url || 'https://placehold.co/100x100'}" alt="${vio.Nombre}" class="me-4 rounded">
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1">${vio.Nombre}</h3>
                        <p class="text-muted-foreground line-through mb-0 precioOriginal">$ ${vio.PrecioOriginal || '0.00'}</p>
                        <p class="text-green-500">$ ${vio.PrecioDescuento || '0.00'} <span class="small text-muted-foreground oferta">${vio.Oferta || '0% OFF'}</span></p>
                        <p class="text-muted-foreground mb-0">Envío gratis</p>
                        <span class="text-yellow-400">⭐ ${vio.Valoracion || '0'} (${vio.Reviews || '0'})</span>
                    </div>
                </div>
            </div>
        `);
    });
}




});