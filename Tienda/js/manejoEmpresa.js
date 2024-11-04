$(document).ready(function() {

// Manejar la selección de archivo y mostrar vista previa
$("#productImage").on("change", function (event) {
    const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $("#imagePreview").attr("src", e.target.result); // Cambia la fuente de la imagen a la seleccionada
            };
            reader.readAsDataURL(file); // Lee la imagen como una URL de datos
        }
     });
$("#btnCargar").click(function() {
    

$.ajax({
    url: "../../Controlador/ArticuloControlador.php",
    method: "POST",
    data: JSON.stringify({ action: "getAllByEmpresa", id_empresa: sessionStorage.id}), 
    contentType: "application/json",
    success: function (response) {
        console.log("Respuesta del servidor:", response);
        let productos = response || [];
        let listaProductos = $("#productos tbody"); // Selector del tbody de la tabla de productos
        listaProductos.empty();

        if (productos.length === 0) {
            listaProductos.append('<tr><td colspan="6">No hay productos disponibles</td></tr>');
        } else {
            productos.forEach(producto => {
                listaProductos.append(`
                    <tr>
                        <td>${producto.ID_Empresa}</td>
                        <td>${producto.Nombre}</td>
                        <td>${producto.Precio}</td>
                        <td>${producto.Cantidad}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editProductModal" onclick="fillEditForm(${producto.ID_Empresa}, "${producto.Nombre}", "${producto.Categoria}", ${producto.Precio}, ${producto.Cantidad})">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteProduct(${producto.Id_Articulos})">Eliminar</button>
                        </td>
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

$("#btnSalir").click(function() {
sessionStorage.clear();
window.location.href = "../../index.php";
})


    // Acción al hacer clic en el botón "Guardar Producto"
    $("#btnGuardar").on("click", function () {
        // Captura los valores de los campos del formulario
        let nombrePro = $("#productName").val();
        let precioPro = $("#productPrice").val();
        let cantidadPro = $("#productQuantity").val();
        let descripcionPro = $("#productDescription").val();
        let imagen = $("#productImage")[0].files[0];

        // Validación de campos básicos
        if (!nombrePro || !precioPro || !cantidadPro || !descripcionPro) {
            $("#msj").text("Por favor, completa todos los campos obligatorios.").css("color", "red");
            return;
        }
        console.log("Descripción del producto:", descripcionPro); // Verifica que tenga el valor esperado

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
            success: function (response) {
                console.log(response);
                let res = JSON.parse(response);
                if (res.success) {
                    alert("Producto añadido correctamente");
                    
                    // Opcional: Actualiza la lista de productos
                } else {
                    alert("Error al añadir producto: " + res.message);
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log("Error en la solicitud AJAX:", error);
                $("#addProductModal").modal("hide"); // Cerrar el modal
               // alert("Hubo un error al añadir el producto.");
            }
        });
            });
});
