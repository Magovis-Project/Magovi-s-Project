$(document).ready(function() {
    // Al hacer clic en el botón del engranaje, mostrar el modal
    $('#lapiz').click(function() {
        $('#edicionModal').modal('show');
    });
    $("#btnGuardar").click(tomarDatos);

    function tomarDatos() {
        const email = $("#correoCam").val();
        const nombre = $("#nombreCam").val();
        const apellido = $("#apellidoCam").val();
        const usuario = $("#usuarioCam").val(); // Corregir esta línea para obtener el valor
        const telefono = Number($("#numeroCam").val());
        remplazar(email, nombre, apellido, usuario, telefono);
    }

    function remplazar(email, nombre, apellido, usuario, telefono) {
        $(".usuario").text(usuario);
        $(".nombre").text(nombre);
        $(".apellido").text(apellido);
        $(".correo").text(email);
        $(".telefono").text(telefono);
    };

    $("#btnAggPaypal").click(tomarDireccion);

    function tomarDireccion(){
        const paypal = $("#paypalIng").val();
        actualizarPaypal(paypal);
    }
    function actualizarPaypal(paypal){
        $("#paypal").text (paypal);
    }

    $("#btnBorarPagos").click(borrarDatos);

    function borrarDatos(){
        $("#tarjeta").text ("Sin registro");
    }
 

});


