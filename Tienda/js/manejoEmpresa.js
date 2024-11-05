$(document).ready(function() {
    // Manejar la selección de archivo y mostrar vista previa
    $("#productImage").on("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#imagePreview").attr("src", e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    $("#btnCargar").click(function() {
        $.ajax({
            url: "../../Controlador/ArticuloControlador.php",
            method: "POST",
            data: JSON.stringify({ action: "getAllByEmpresa", id_empresa: sessionStorage.id }), 
            contentType: "application/json",
            success: function(response) {
                let productos = response || [];
                let listaProductos = $("#productos tbody");
                listaProductos.empty();
    
                if (productos.length === 0) {
                    listaProductos.append('<tr><td colspan="6">No hay productos disponibles</td></tr>');
                } else {
                    productos.forEach(producto => {
                        console.log(producto.Categorias);

                        // Convierte el array de categorías en una cadena de texto separada por comas
                        const categorias = Array.isArray(producto.Categorias) ? producto.Categorias : producto.Categorias.split(",");
listaProductos.append(`
    <tr>
        <td>${producto.Id_Articulos}</td>
        <td>${producto.Nombre}</td>
        <td>${producto.Precio}</td>
        <td>${producto.Cantidad}</td>
        <td>${categorias.join(", ")}</td>
        <td>
            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editProductModal" onclick="fillEditForm(${producto.ID_Empresa}, '${producto.Nombre}', '${producto.Categorias}', ${producto.Precio}, ${producto.Cantidad})">Editar</button>
            <button class="btn btn-danger btn-sm" onclick="deleteProduct(${producto.Id_Articulos})">Eliminar</button>
        </td>
    </tr>
`);

                    });
                }
            },
            error: function(error) {
                console.log("Error al obtener productos:", error);
            }
        });
    });

    // Obtener todas las categorías cuando se abre el modal de añadir producto
$("#btnAgregar").on("click", function() {  
    $.ajax({
        url: "../../Controlador/CategoriaControlador.php",
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
        const checkboxId = `categoria_${categoria.Id_Categoria}`;
        contenedorCategorias.append(`
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="${categoria.Id_Categoria}" id="${checkboxId}">
                <label class="form-check-label" for="${checkboxId}">
                    ${categoria.Nombre}
                </label>
            </div>
        `);
    });
}




    // Acción al hacer clic en el botón "Guardar Producto"
    $("#btnGuardar").on("click", function() {
    let nombrePro = $("#productName").val();
    let precioPro = $("#productPrice").val();
    let cantidadPro = $("#productQuantity").val();
    let descripcionPro = $("#productDescription").val();

    // Obtener categorías seleccionadas
    let categoriasSeleccionadas = [];
    $("input[type=checkbox]:checked").each(function() {
        categoriasSeleccionadas.push($(this).val()); // Almacena el ID de la categoría
    });

    // Validar campos
    if (!nombrePro || !precioPro || !cantidadPro || !descripcionPro || categoriasSeleccionadas.length === 0) {
        $("#msj").text("Por favor, completa todos los campos obligatorios.").css("color", "red");
        return;
    }

    $("#btnGuardar").on("click", function() {
        let nombrePro = $("#productName").val();
        let precioPro = $("#productPrice").val();
        let cantidadPro = $("#productQuantity").val();
        let descripcionPro = $("#productDescription").val();
    
        // Obtener categorías seleccionadas
        let categoriasSeleccionadas = [];
        $("input[type=checkbox]:checked").each(function() {
            categoriasSeleccionadas.push($(this).val()); // Almacena el ID de la categoría
        });
    
        // Validar campos
        if (!nombrePro || !precioPro || !cantidadPro || !descripcionPro || categoriasSeleccionadas.length === 0) {
            $("#msj").text("Por favor, completa todos los campos obligatorios.").css("color", "red");
            return;
        }
    
        // Primero, guardar el producto
        $.ajax({
            url: "../../Controlador/ArticuloControlador.php",
            method: "POST",
            data: JSON.stringify({
                action: "create",
                id_empresa: sessionStorage.id,
                nombre: nombrePro,
                precio: precioPro,
                cantidad: cantidadPro,
                descripcion: descripcionPro,
                valoracion: 0,
                actividad: "Activo"
            }),
            contentType: "application/json",
            success: function(response) {
                console.log(response);
                if (response.success) {
                    // Suponiendo que la respuesta contiene el ID del nuevo producto
                    let idProducto = response.id; // Asegúrate de que esto coincida con lo que envía tu controlador
    
                    // Ahora, guardar la relación en Caracterizan para cada categoría
                    guardarCategorias(idProducto, categoriasSeleccionadas);
                } else {
                    alert("Error al añadir producto: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log("Error en la solicitud AJAX:", error);
            }
        });
    });
    
    // Función para guardar la relación entre el artículo y cada categoría
    function guardarCategorias(idProducto, categoriasSeleccionadas) {
        // Iterar sobre cada categoría seleccionada
        categoriasSeleccionadas.forEach(function(categoriaId) {
            $.ajax({
                url: "../../Controlador/CategorizanControlador.php",
                method: "POST",
                data: JSON.stringify({
                    action: "add",
                    id_articulo: idProducto,
                    id_categoria: categoriaId,
                }),
                contentType: "application/json",
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        alert("Categoría asociada al producto correctamente: " + categoriaId);
                    } else {
                        alert("Error al asociar categoría: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error en la solicitud AJAX:", error);
                }
            });
        });
    }
    
}); 
// Botón para salir
$("#btnSalir").click(function() {
    console.log("Botón clickeado");
    sessionStorage.clear();
    window.location.href = "../../index.php";
});

$("#btnVentas").click(function() {
    $.ajax({
        url: "../../Controlador/VentaControlador.php",
        method: "POST",
        data: JSON.stringify({ action: "getAllByEmpresa", id_empresa: sessionStorage.id }), 
        contentType: "application/json",
        success: function(response) {
            let ventas = response || [];
            let listaVentas = $("#ventas tbody");
            listaVentas.empty();

            if (ventas.length === 0) {
                listaVentas.append('<tr><td colspan="5">No hay ventas disponibles</td></tr>');
            } else {
                ventas.forEach(venta => {
                    listaVentas.append(`
                        <tr>
                            <td>${venta.Id_Venta}</td>
                            <td>${venta.Fecha}</td>
                            <td>${venta.Total}</td>
                            <td>${venta.Cliente}</td>
                            <td>${venta.NombreArticulo}</td>
                        </tr>
                    `);
                });
            }
        },
        error: function(error) {
            console.log("Error al obtener ventas:", error);
        }
    });
});


});  