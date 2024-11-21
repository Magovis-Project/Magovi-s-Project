$(document).ready(function() {

    $('#btnLupa').on('click', function(event) {
        event.preventDefault(); // Evitar el comportamiento por defecto del botón
    
        const buscarCoin = $("#barraBusqueda").val(); // Obtén el valor de la barra de búsqueda
        console.log(buscarCoin);
    
        if (buscarCoin.trim() === "") {
            alert("Por favor, ingresa un término de búsqueda."); // Avisar si la búsqueda está vacía
        } else {
            localStorage.setItem('buscarCoin', buscarCoin); // Almacena el valor en localStorage
            location.reload();
            // Vaciar el campo de búsqueda después de almacenar el valor
            $("#barraBusqueda").val(""); // Limpia el input de búsqueda
        }
    });
    

    const usuarioAcciones = document.getElementById('usuarioAcciones');
    const userData = sessionStorage.cedula; 
    
    
    $("#tituloBusqueda").html(localStorage.buscarCoin);

        $.ajax({
            url: "../Controlador/CategoriaControlador.php",
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
        function mostrarCategorias(categorias) {
            let contenedorCategorias = $("#listaCategorias"); // Asegúrate de que este ID coincida con el del elemento en tu HTML
            contenedorCategorias.empty(); // Limpia las categorías existentes
        
            categorias.forEach(categoria => {
                contenedorCategorias.append(`
                    <a>${categoria.Nombre}</a><br>
                `);
            });
        }

        $.ajax({
            url: "../Controlador/ArticuloControlador.php",
            method: "POST",
            data: JSON.stringify({
                action: "buscarPorNombre",
                texto: localStorage.buscarCoin // Envía el texto para buscar
            }),
            contentType: "application/json",
            success: function(response) {
                // Manejar la respuesta de la búsqueda
                if (Array.isArray(response) && response.length > 0) {
                    $("#resultados").html(response.length+" resultados");
                    // Mostrar artículos encontrados
                    mostrarArticulos(response);
                    console.log(response);
                } else {
                    
                    mostrarVacio();
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", error);
                alert("Hubo un error al buscar los artículos.");
            }
        });

        function mostrarArticulos(articulos) {
            let contenedorArticulos = $("#listaArticulos"); // Contenedor de los artículos
            contenedorArticulos.empty(); // Limpia los artículos existentes
        
            articulos.forEach(articulo => {
                contenedorArticulos.append(`
                    <div class="border p-4 rounded-lg bg-card producto" data-id="${articulo.Id_Articulos}">
                        <div class="d-flex align-items-center" style="gap: 15px;">
                            <div>
                                <img src="${articulo.foto_url || 'https://placehold.co/100x100'}" alt="${articulo.Nombre}" class="me-4 rounded">
                            </div>
                            <div>
                                <h3 class="fw-bold mb-1">${articulo.Nombre}</h3>
                                <p class="text-green-500">$ ${articulo.Precio || '0.00'}</p>
                                <p class="text-muted-foreground mb-0">${articulo.Descripcion || ''}</p>
                                <span class="text-yellow-400">⭐ ${articulo.Valoracion || '0.0'}</span>
                                <p class="text-muted">Cantidad disponible: ${articulo.Cantidad || '0'}</p>
                            </div>
                        </div>
                    </div>
                `);
            });
        }
        
        $(document).on('click', '.producto', function() {
            const idProducto = $(this).data('id'); // Obtén el ID del producto
            console.log("ID del producto clickeado:", idProducto); // Verifica en la consola
            if (idProducto) {
                window.location.href = `../Vistas/Producto.html?id=${idProducto}`;
            } else {
                console.error("ID no válido o no encontrado.");
            }
        });
        

        
        
        function mostrarVacio() {
            let contenedorArticulos = $("#listaArticulos"); // Asegúrate de que este ID coincida con el del elemento en tu HTML
            contenedorArticulos.empty(); // Limpia los artículos existentes
        
            // Agrega un bloque que indique que no se encontraron artículos
            contenedorArticulos.append(`
                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                    <h2 class="text-muted">No se encontraron artículos.</h2>
                </div>
            `);
        }


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
        window.location.href = '../index.php'; // Cambia esta ruta según tus necesidades
    });

} else {
    // Si no hay datos, mostrar botones de registro y logueo
    usuarioAcciones.innerHTML = `
        <a href="../../Vistas/registros/division.html" class="mr-2 btn btn-custom">Crea tu cuenta</a>
        <a href="../../Vistas/inicios/divisionIni.html" id="btnInicio" class="btn btn-custom mr-2">Ingresa</a>
        <button class="btn btn-custom mr-2">Mis compras</button>
    `;
}
});