$(document).ready(function() {
    $("#btnsubmit").click(function(event) {
        event.preventDefault(); // Prevenir el comportamiento por defecto del botón de formulario
        tomarDatos();
    });

    function tomarDatos() {
        // Obtener los valores ingresados
        let mail = $("#mail").val();
        let contra = $("#contra").val();

        if (mail==="MagovisContact@gmail.com" && contra==="ContraseñaApropiada123"){
            window.location.href = "../manejos/backOffice.html";
        }
    }
});


