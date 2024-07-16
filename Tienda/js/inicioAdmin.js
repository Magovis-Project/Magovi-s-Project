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