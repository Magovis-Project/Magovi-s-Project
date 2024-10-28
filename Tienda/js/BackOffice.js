//Usuarios
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
                listaUsuarios.append('<tr><td colspan="8">No hay usuarios disponibles</td></tr>');
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
                            <td>${usuario.Actividad}</td>
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

// Mostrar usuario por ID
$("#botonIdUsu").click(function () {
    let usuarioID = $("#idUsuarios").val().trim();
    if (usuarioID === "") {
        $("#mensajeError").html("Por favor, ingrese un ID de usuario.");
        return;
    }
    $("#mensajeError").html("");

    $.ajax({
        url: "../../Controlador/UsuarioControlador.php",
        method: "POST",
        data: JSON.stringify({ action: "getById", id_usuario: usuarioID }),
        contentType: "application/json",
        success: function (response) {
            let usuarios = Array.isArray(response) ? response : [response];
            let listaUsuarios = $("#lista-usuarios");
            listaUsuarios.empty();

            if (usuarios.length === 0 || !usuarios[0]) {
                listaUsuarios.append('<tr><td colspan="8">No se encontró el usuario con ese ID</td></tr>');
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
                            <td>${usuario.Actividad }</td>
                        </tr>
                    `);
                });
            }
        },
        error: function (error) {
            console.log("Error al obtener el usuario:", error);
        }
    });
});

$("#btnLimpiarUsuarios").click(OcultarUsuarios);
function OcultarUsuarios() {
    $("#lista-usuarios").html("");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Empresas
// Mostrar todas las empresas
$("#btnMostrarEmpresas").click(function () {
    $.ajax({
        url: "../../Controlador/EmpresaControlador.php",
        method: "POST",
        data: JSON.stringify({ action: "getAllEmpresas" }),
        contentType: "application/json",
        success: function (response) {
            let empresas = response || [];
            let listaEmpresas = $("#lista-empresas-tablon");
            listaEmpresas.empty();

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
                            <td>${empresa.Valoracion}</td>
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

// Mostrar empresa por ID
$("#botonIdEmpre").click(function () {
    let empresaID = $("#BuscarEmpresas").val().trim();
    if (empresaID === "") {
        $("#mensajeErrorEmpresa").html("Por favor, ingrese un ID de empresa.");
        return;
    }
    $("#mensajeError").html("");

    $.ajax({
        url: "../../Controlador/EmpresaControlador.php",
        method: "POST",
        data: JSON.stringify({ action: "getById", id_empresa: empresaID }), 
        contentType: "application/json",
        success: function (response) {
            let empresas = Array.isArray(response) ? response : [response];
            let listaEmpresas = $("#lista-empresas-tablon");
            listaEmpresas.empty();

            if (empresas.length === 0 || !empresas[0]) {
                listaEmpresas.append('<tr><td colspan="6">No se encontró la empresa con ese ID</td></tr>');
            } else {
                empresas.forEach(empresa => {
                    listaEmpresas.append(`
                        <tr>
                            <td>${empresa.Nombre}</td>
                            <td>${empresa.Direccion}</td>
                            <td>${empresa.RUT}</td>
                            <td>${empresa.Email}</td>
                            <td>${empresa.Telefono}</td>
                            <td>${empresa.Valoracion}</td>
                        </tr>
                    `);
                });
            }
        },
        error: function (error) {
            console.log("Error al obtener la empresa:", error);
        }
    });
});




$("#btnLimpiarEmpresas").click(OcultarEmpresas);
function OcultarEmpresas() {
    $("#lista-empresas-tablon").html("");
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Productos
// Mostrar empresa por ID
$("#botonIdProducto").click(function () {
    let productoID = $("#buscarProductos").val().trim();
    if (productoID === "") {
        $("#mensajeErrorProductos").html("Por favor, ingrese un ID de Producto.");
        return;
    }
    $("#mensajeErrorProductos").html("");

    $.ajax({
        url: "../../Controlador/ArticuloControlador.php", 
        method: "POST",
        data: JSON.stringify({ action: "getById", id_articulo: productoID }), 
        contentType: "application/json",
        success: function (response) {
            console.log(response);
            let productos = Array.isArray(response) ? response : [response];
            let listaProductos = $("#lista-productos-tablon");
            listaProductos.empty();

            if (productos.length === 0 || !productos[0]) {
                listaProductos.append('<tr><td colspan="7">No se encontró el artículo con ese ID</td></tr>');
            } else {
                productos.forEach(producto => {
                    listaProductos.append(`
                        <tr>
                            <td>${producto.ID_Empresa}</td>
                            <td>${producto.Nombre}</td>
                            <td>${producto.Precio}</td>
                            <td>${producto.Cantidad}</td>
                            <td>${producto.Tipo}</td>
                            <td>${producto.Actividad}</td>
                            <td>${producto.Valoracion}</td>
                        </tr>
                    `);
                });
            }
        },
        error: function (error) {
            console.log("Error al obtener el artículo:", error);
        }
    });
});

// Mostrar todos los productos
$("#btnMostrarProductos").click(function () {
    $.ajax({
        url: "../../Controlador/ArticuloControlador.php",
        method: "POST",
        data: JSON.stringify({ action: "getAll" }),
        contentType: "application/json",
        success: function (response) {
            let productos = response || [];
            let listaProductos = $("#lista-productos-tablon");
            listaProductos.empty();

            if (productos.length === 0) {
                listaProductos.append('<tr><td colspan="7">No hay productos disponibles</td></tr>');
            } else {
                productos.forEach(producto => {
                    listaProductos.append(`
                        <tr>
                            <td>${producto.ID_Empresa}</td>
                            <td>${producto.Nombre}</td>
                            <td>${producto.Precio}</td>
                            <td>${producto.Cantidad}</td>
                            <td>${producto.Tipo}</td>
                            <td>${producto.Actividad}</td>
                            <td>${producto.Valoracion}</td>
                        </tr>
                    `);
                });
            }
        },
        error: function (error) {
            console.log("Error al obtener productos:", error);
        }
    });
});
$("#btnLimpiarProductos").click(OcultarProductos);
function OcultarProductos() {
    $("#lista-productos-tablon").html("");
}
