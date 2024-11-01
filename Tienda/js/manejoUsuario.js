$(document).ready(function() {
    const usuarioAcciones = document.getElementById('usuarioAcciones');
    const userData = sessionStorage.cedula; 
    $(".usuario").html(sessionStorage.nombre+" "+sessionStorage.apellido);
    $(".nombre").html(sessionStorage.nombre);
    $('#nombreCam').val(sessionStorage.nombre);
    $(".apellido").html(sessionStorage.apellido);
    $("#apellidoCam").val(sessionStorage.apellido);
    $(".correo").html(sessionStorage.email);
    $("#correoCam").val(sessionStorage.email);
    $(".telefono").html("0"+sessionStorage.telefono);
    $("#numeroCam").val(sessionStorage.telefono);
    $(".direccion").html(sessionStorage.direccion);
    $("#direccionCam").val(sessionStorage.direccion);
    $(".cedula").html(sessionStorage.cedula);
    // Extraer solo la parte de la fecha de la cadena almacenada en sessionStorage
    const fechaCompleta = sessionStorage.getItem('fecha_creacion');
    const soloFecha = fechaCompleta ? fechaCompleta.split(' ')[0] : ''; 
    // Insertar solo la fecha en el elemento con el id "creacion"
    $("#creacion").html(soloFecha);

    if (userData) {
        // Si hay datos, mostrar el dropdown
        usuarioAcciones.innerHTML = `
            <div class="profile-dropdown">
                <button class="profile-drop" id="profileMenu">
                    <img src="../../assets/${sessionStorage.foto}.png" id="profPic" alt="ProfPic" class="profile-img">
                    <span class="profile-name">${sessionStorage.nombre} ${sessionStorage.apellido}</span>
                </button>
                <div class="profile-dropdown-content">
                    <a href="../../Vistas/manejos/manejoUsuario.html">Mi Perfil</a>
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
            window.location.href = '../../index.php'; // Cambia esta ruta según tus necesidades
        });

    } else {
        // Si no hay datos, mostrar botones de registro y logueo
        usuarioAcciones.innerHTML = `
            <a href="../../Vistas/registros/division.html" class="mr-2 btn btn-custom">Crea tu cuenta</a>
            <a href="../../Vistas/inicios/divisionIni.html" id="btnInicio" class="btn btn-custom mr-2">Ingresa</a>
            <button class="btn btn-custom mr-2">Mis compras</button>
        `;
    }

    // Al hacer clic en el botón del engranaje, mostrar el modal
    $('#lapiz').click(function() {
        $('#edicionModal').modal('show');
    });
 

    $("#btnGuardar").click(function () {
        let nuevoNombre = $("#nombreCam").val()?.trim() || "";  
        let nuevoApellido = $("#apellidoCam").val()?.trim() || "";
        let nuevaDireccion = $("#direccionCam").val()?.trim() || "";
        let nuevoEmail = $("#correoCam").val()?.trim() || "";
        let nuevoTelefono = $("#numeroCam").val()?.trim() || "";
    
        // Comprobación de que todos los campos están completos
        if (!nuevoNombre || !nuevoApellido || !nuevaDireccion || !nuevoEmail || !nuevoTelefono) {
            console.log("Todos los campos deben estar completos para actualizar el usuario.");
            return; // Salir de la función si hay campos vacíos
        }
    
        // Llamada AJAX para actualizar el usuario
        $.ajax({
            url: "../../Controlador/UsuarioControlador.php",
            method: "POST",
            data: JSON.stringify({
                action: "update",
                id_usuario: sessionStorage.id,
                password: null,
                direccion: nuevaDireccion,
                apellido: nuevoApellido,
                nombre: nuevoNombre,
                email: nuevoEmail,
                telefono: nuevoTelefono,
                cedula: sessionStorage.cedula,
                foto: null,
                actividad: null
            }),
            contentType: "application/json",
            success: function (response) {
                console.log("Usuario actualizado correctamente:", response);
    
                // Actualizar sessionStorage con los nuevos valores
                sessionStorage.setItem("nombre", nuevoNombre);
                sessionStorage.setItem("apellido", nuevoApellido);
                sessionStorage.setItem("direccion", nuevaDireccion);
                sessionStorage.setItem("email", nuevoEmail);
                sessionStorage.setItem("telefono", nuevoTelefono);
    
                // Actualizar los elementos HTML si es necesario
                $(".nombre").html(nuevoNombre);
                $(".apellido").html(nuevoApellido);
                $(".correo").html(nuevoEmail);
                $(".telefono").html(nuevoTelefono);
                $(".direccion").html(nuevaDireccion);
    
                $('#edicionModal').modal('hide'); // Cerrar el modal solo si hay éxito
            },
            error: function (xhr,status,error) {
                console.log("Error:", error);
                console.log("Detalles:", xhr.responseText);
                console.log("Error al actualizar el usuario:", error);
                alert("Ocurrió un error al actualizar el usuario. Intenta nuevamente.");
            }
        });
    });
});     