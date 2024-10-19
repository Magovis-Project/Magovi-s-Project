$(document).ready(function() {
    $('#loginForm').submit(function(event) {
        event.preventDefault(); 

        const email = $('#correoEmp').val();
        const password = $('#contraEmp').val();
        const mensaje = $('#msj');

        // Realiza la solicitud AJAX al controlador de PHP
        $.ajax({
            url: '../../Controlador/EmpresaControlador.php', 
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'login',
                email: email,
                password: password,
            }),
            success: function(data) {
                if (data.error) {
                    mensaje.text(data.message).css('color', 'red');
                } else {
                    mensaje.text(data.message).css('color', 'green');
                    window.location.href = '../../Vistas/manejos/manejoEmpresa.html';
                }
            },
            error: function(xhr, status, error) {
                mensaje.text('Error en la solicitud: ' + error).css('color', 'red'); // Muestra el mensaje de error
            }
        });
    });
});
