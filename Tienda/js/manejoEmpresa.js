function fillEditForm(id, name, category, price, quantity) {
    $("#editProductName").val(name);
    $("#editProductCategory").val(category);
    $("#editProductPrice").val(price);
    $("#editProductQuantity").val(quantity);
}

$("#saveProductChanges").click(function() {
    const id = 1; // Aquí se debe usar el ID del producto que se está editando
    const updatedProduct = {
        name: $("#editProductName").val(),
        category: $("#editProductCategory").val(),
        price: $("#editProductPrice").val(),
        quantity: $("#editProductQuantity").val()
    };

    // Aquí iría la lógica para guardar los cambios, probablemente una llamada AJAX al servidor
    console.log("Producto actualizado:", updatedProduct);

    // Cierra el modal
    $("#editProductModal").modal("hide");
});