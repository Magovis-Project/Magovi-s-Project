$(document).ready(function() {
    // Acción al enviar el formulario
    $('#btnsubmit').click(function(event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        // Obtener valores de correo y contraseña
        let email = $('#correoEmp').val();
        let passwordEmp = $('#contraEmp').val();

        // Verificar que los campos no estén vacíos
        if (email === '' || passwordEmp === '') {
            $('#msj').text('Por favor, complete ambos campos').css('color', 'red');
            return;
        }

        // Enviar datos al servidor usando AJAX
        $.ajax({
            url: '../../Controlador/EmpresaControlador.php', // Ruta al script PHP que maneja la verificación de empresa
            type: 'POST',
            data: JSON.stringify({ action: "login", email: email, password: passwordEmp }),
            contentType: "application/json",
            success: function(response) {
                console.log(response);
               
                if (response.success) {
                    // Guardar los datos de la empresa en sessionStorage
                    sessionStorage.setItem('id', response.empresa.ID_Empresa);
                    sessionStorage.setItem('nombre', response.empresa.Nombre);
                    sessionStorage.setItem('direccion', response.empresa.Direccion);
                    sessionStorage.setItem('email', response.empresa.Email);
                    sessionStorage.setItem('telefono', response.empresa.Telefono);
                    sessionStorage.setItem('rut', response.empresa.RUT);
                    sessionStorage.setItem('valoracion', response.empresa.Valoracion);
                    window.location.href = '../../Vistas/manejos/manejoEmpresa.html';
                } else {
                    // Mostrar mensaje de error si el email o la contraseña no coinciden
                    $('#msj').text(response.message).css('color', 'red');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Error en el servidor:");
                console.log("Status:", textStatus);
                console.log("Error:", errorThrown);
                console.log("Response text:", jqXHR.responseText);
                $('#msj').text('Hubo un error en el servidor, intente nuevamente.').css('color', 'red');
            }
        });
    });
});

