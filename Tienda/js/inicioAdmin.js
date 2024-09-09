$(document).ready(function() {
    $("#btnsubmit").click(function(event) {
        event.preventDefault(); // Prevenir el comportamiento por defecto del botón de formulario
        tomarDatos();
    });

    function tomarDatos() {
        // Obtener los valores ingresados
        let contra1 = $("#contra1").val();
        let contra2 = $("#contra2").val();

        if (contra1==="boquitaElMasGrande" && contra2==="TumbaLaCasaMami789"){
            window.location.href = "../manejos/backOffice.html";
        }
    }
});

$.ajax({
    url: '/Tienda/Controlador/UsuarioControlador.php',  // Solo la ruta del archivo PHP
    method: 'GET',
    data: { action: 'getUsuariosJSON' },  // Enviar acción o parámetros
    dataType: 'json',
    success: function(data) {
        console.log(data);
        let listaUsuarios = $('#lista-usuarios');
        listaUsuarios.empty();  // Vaciar la lista antes de llenarla
        data.forEach(function(usuario) {
            let fila = `<tr><td>${usuario.nombre}</td><td>${usuario.apellido}</td></tr>`;
            listaUsuarios.append(fila);  // Agregar cada fila a la tabla
        });
    },
    error: function(xhr, status, error) {
        console.error('Error al obtener los datos:', error);
    }
});
