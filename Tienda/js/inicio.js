$(document).ready(function() {
    
    $('#btnBuscar').on('click', function(event) {
        // Evitar el comportamiento por defecto del botón
        event.preventDefault(); 

        const buscarCoin = $("#barraBusqueda").val(); // Obtén el valor de la barra de búsqueda
        localStorage.setItem('buscarCoin', buscarCoin); // Almacena el valor en localStorage
        console.log(buscarCoin);
    });

    
    // Comprobamos si hay datos en el storage
    const usuarioAcciones = document.getElementById('usuarioAcciones');
    const userData = sessionStorage.cedula; 
    
    if (userData) {
        // Si hay datos, mostrar el dropdown
        usuarioAcciones.innerHTML = `
            <div class="profile-dropdown">
                <button class="profile-drop" id="profileMenu">
                    <img src="../Tienda/assets/${sessionStorage.foto}.png" id="profPic" alt="ProfPic" class="profile-img">
                    <span class="profile-name">${sessionStorage.nombre} ${sessionStorage.apellido}</span>
                </button>
                <div class="profile-dropdown-content">
                    <a href="../Tienda/Vistas/manejos/manejoUsuario.html">Mi Perfil</a>
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
            window.location.href = '../Tienda/index.php'; // Cambia esta ruta según tus necesidades
        });

    } else {
        // Si no hay datos, mostrar botones de registro y logueo
        usuarioAcciones.innerHTML = `
            <a href="../Tienda/Vistas/registros/division.html" class="mr-2 btn btn-custom">Crea tu cuenta</a>
            <a href="../Tienda/Vistas/inicios/divisionIni.html" id="btnInicio" class="btn btn-custom mr-2">Ingresa</a>
            <button class="btn btn-custom mr-2">Mis compras</button>
        `;
    }

    $('#btnHistorial').on('click', function() {
        if (userData) {
            // Si hay datos, redirigir a historial
            window.location.href = '../Tienda/Vistas/inicios/historial.html';
        } else {
            // Si no hay datos, redirigir a inicioUsu
            window.location.href = '../Tienda/Vistas/inicios/inicioUsu.html';
        }
    });
});

$("#btnCategorias").on("click", function() {  
    $.ajax({
        url: "Controlador/CategoriaControlador.php",
        method: "POST",
        data: JSON.stringify({
            action: "getAll"
        }),
        contentType: "application/json",
        success: function(response) {
            if (Array.isArray(response)) {
                mostrarCategorias(response);
            } else {
                alert("Error al obtener categorías: " + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
            alert("Hubo un error al obtener las categorías.");
        }
    });
});

function mostrarCategorias(categorias) {
    let contenedorCategorias = $("#listaCategorias"); // Asegúrate de que este ID coincida con el del elemento en tu HTML
    contenedorCategorias.empty(); // Limpia las categorías existentes

    categorias.forEach(categoria => {
        // Crear un ID único para cada checkbox usando Id_Categoria
        contenedorCategorias.append(`
            <a>${categoria.Nombre}</a>
        `);
    });
}