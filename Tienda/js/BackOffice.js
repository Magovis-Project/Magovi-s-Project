// Mostrar todos los usuarios
$("#btnMostrarUsuarios").click(function () {
    $.ajax({
        url: "../../Controlador/UsuarioControlador.php",
        method: "POST",
        data: JSON.stringify({ action: "get" }),
        contentType: "application/json",
        success: function (response) {
            let usuarios = response || [];
            let listaUsuarios = $("#lista-usuarios");
            listaUsuarios.empty(); // Limpiar tabla

            if (usuarios.length === 0) {
                listaUsuarios.append('<tr><td colspan="7">No hay usuarios disponibles</td></tr>');
            } else {
                usuarios.forEach(usuario => {
                    listaUsuarios.append(`
                        <tr>
                            <td>${usuario.Nombre}</td>
                            <td>${usuario.Apellido}</td>
                            <td>${usuario.Direccion}</td>
                            <td>${usuario.Email}</td>
                            <td>${usuario.Telefono}</td>
                            <td>${usuario.Cedula}</td>
                            <td>${usuario.Fecha_Creacion}</td>
                        </tr>
                    `);
                });
            }
        },
        error: function (error) {
            console.log("Error al obtener usuarios:", error);
        }
    });
});
$("#btnLimpiarUsuarios").click(OcultarUsuarios);
function OcultarUsuarios(){
    
    $("#lista-usuarios").html("");
}

    // Mostrar todas las empresas
$("#btnMostrarEmpresas").click(function () {
    $.ajax({
        url: "../../Controlador/EmpresaControlador.php",
        method: "POST",
        data: JSON.stringify({ action: "getAllEmpresas" }),
        contentType: "application/json",
        success: function (response) {
            let empresas = response || []; // Cambiado a una asignación más simple
        
            let listaEmpresas = $("#lista-empresas-tabla tbody"); // Seleccionar tbody
            listaEmpresas.empty(); // Limpiar tabla
        
            if (empresas.length === 0) {
                listaEmpresas.append('<tr><td colspan="6">No hay empresas disponibles</td></tr>');
            } else {
                empresas.forEach(empresa => {
                    listaEmpresas.append(`
                        <tr>
                            <td>${empresa.Nombre}</td>
                            <td>${empresa.Direccion}</td>
                            <td>${empresa.RUT}</td>
                            <td>${empresa.Email}</td>
                            <td>${empresa.Telefono}</td>
                            <td>${empresa.Valoracion !== null ? empresa.Valoracion : 'No disponible'}</td>
                        </tr>
                    `);
                });
            }
        },        
        error: function (error) {
            console.log("Error al obtener empresas:", error);
        }
    });
});

$("#btnLimpiarEmpresas").click(OcultarEmpresas);
function OcultarEmpresas(){
    
    $("#lista-empresas-tablon").html("");
}