$(document).ready(function() {
    // Acción al enviar el formulario
    $('#btnsubmit').click(function(event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        // Obtener valores de correo y contraseña
        let email = $('#correo').val();
        let password = $('#contra').val();

        // Verificar que los campos no estén vacíos
        if (email === '' || password === '') {
            $('#msj').text('Por favor, complete ambos campos').css('color', 'red');
            return;
        }

        // Enviar datos al servidor usando AJAX
        $.ajax({
            url: '../../Controlador/UsuarioControlador.php', // Ruta al script PHP que maneja la verificación de usuario
            type: 'POST',
            data: JSON.stringify({ action: "login", email: email, password:password }),
            contentType: "application/json",
            success: function(response) {
                console.log(response);
               
                if (response.success) {
                    sessionStorage.setItem('nombre', response.usuario.Nombre);
                    sessionStorage.setItem('apellido', response.usuario.Apellido);
                    sessionStorage.setItem('email', response.usuario.Email);
                    sessionStorage.setItem('telefono', response.usuario.Telefono);
                    sessionStorage.setItem('cedula', response.usuario.Cedula);
                    sessionStorage.setItem('direccion', response.usuario.Direccion);
                    sessionStorage.setItem('foto', response.usuario.Foto);
                    sessionStorage.setItem('actividad', response.usuario.Actividad);
                    sessionStorage.setItem('fecha_creacion', response.usuario.Fecha_Creacion);
                    window.location.href = '../../index.php';
                } else {
                    // Mostrar mensaje de error si el usuario o la contraseña no coinciden
                    $('#msj').text(response.message).css('color', 'red');
                }
            },
            error: function() {
                $('#msj').text('Hubo un error en el servidor, intente nuevamente.').css('color', 'red');
            }
        });
    });
});
