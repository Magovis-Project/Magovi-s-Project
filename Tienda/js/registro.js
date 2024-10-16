(function ($) {
    $.fn.validate_ci = function () {
        function validation_digit(ci) {
            let a = 0;
            if (ci.length <= 6) ci = ci.padStart(7, '0');
            for (let i = 0; i < 7; i++) {
                a += (parseInt("2987634"[i]) * parseInt(ci[i])) % 10;
            }
            return a % 10 === 0 ? 0 : 10 - (a % 10);
        }

        const ci = this.val().replace(/\D/g, '');
        const dig = ci[ci.length - 1];
        return dig == validation_digit(ci.slice(0, -1));
    };
})(jQuery);

$("#btnGuardar").click(function (event) {
    event.preventDefault();
    tomarDatos();
});

function tomarDatos() {
    const nombre = $("#nombre").val().trim();
    const apellido = $("#apellido").val().trim();
    const ci = $("#ci").val().trim();
    const direccion = $("#direccion").val().trim();
    const numero = $("#numero").val().trim();
    const correo = $("#correo").val().trim();
    const contra = $("#contra").val().trim();
    const contraVerify = $("#contra2").val().trim();
    const foto = "";

    if (comprobar(ci, numero, contra, contraVerify)) {
        // Enviar datos al controlador
        const formData = {
            password: contra,
            direccion: direccion,
            apellido: apellido,
            nombre: nombre,
            email: correo,
            telefono: numero,
            cedula: ci,
            foto: foto 
        };

        $.ajax({
            type: "POST",
            url: "../../Controlador/UsuarioControlador.php",
            data: JSON.stringify({
                action: "create",
                password: contra,
                direccion: direccion,
                apellido: apellido,
                nombre: nombre,
                email: correo,
                telefono: numero,
                cedula: ci,
                foto: foto
            }),
            contentType: "application/json; charset=utf-8", // Asegura que se envíe como JSON
            dataType: "json", // Esperamos respuesta en JSON
            success: function (response) {
                console.log(response); 
                if (response.success) {
                    alert(response.message); // Éxito
                } else {
                    alert("Error: " + response.message); // Error desde el servidor
                }
            },
            error: function (xhr, error) {
                console.log("Error en la solicitud:", xhr.responseText);
                alert("Error: " + error);
            }
        });
        
    }
}

function comprobar(ci, numero, contra, contraVerify) {
    let mensaje = "";

    // Validación de Nombre
    if (!$("#nombre").val().trim()) {
        mensaje += "error";
        $("#mensajeErrorNombre").html("El nombre no puede estar vacío");
        setInputState($("#nombre"), false);
    } else {
        $("#mensajeErrorNombre").html("");
        setInputState($("#nombre"), true);
    }

    // Validación de Apellido
    if (!$("#apellido").val().trim()) {
        mensaje += "error";
        $("#mensajeErrorApellido").html("El apellido no puede estar vacío");
        setInputState($("#apellido"), false);
    } else {
        $("#mensajeErrorApellido").html("");
        setInputState($("#apellido"), true);
    }

    // Validación de Dirección
    if (!$("#direccion").val().trim()) {
        mensaje += "error";
        $("#mensajeErrorDireccion").html("La dirección no puede estar vacía");
        setInputState($("#direccion"), false);
    } else {
        $("#mensajeErrorDireccion").html("");
        setInputState($("#direccion"), true);
    }

    // Validación de Ciudad
    if (!$("#ciudad").val().trim()) {
        mensaje += "error";
        $("#mensajeErrorCiudad").html("La ciudad no puede estar vacía");
        setInputState($("#ciudad"), false);
    } else {
        $("#mensajeErrorCiudad").html("");
        setInputState($("#ciudad"), true);
    }

    // Validación de Correo
    if (!$("#correo").val().trim()) {
        mensaje += "error";
        $("#mensajeErrorCorreo").html("El correo no puede estar vacío.");
        setInputState($("#correo"), false);
    } else if (!validarCorreo($("#correo").val())) {
        mensaje += "error";
        $("#mensajeErrorCorreo").html("El correo debe tener un formato válido.");
        setInputState($("#correo"), false);
    } else {
        $("#mensajeErrorCorreo").html("");
        setInputState($("#correo"), true);
    }

    // Validación de CI
    if (!$("#ci").validate_ci()) {
        mensaje += "error";
        $("#mensajeErrorCi").html("La cédula no es válida.");
        setInputState($("#ci"), false);
    } else {
        $("#mensajeErrorCi").html("");
        setInputState($("#ci"), true);
    }

    // Validación de Número de Teléfono
    if (!/^\d{9}$/.test(numero)) {
        mensaje += "error";
        $("#mensajeErrorTele").html("El número de teléfono debe tener 9 dígitos.");
        setInputState($("#numero"), false);
    } else {
        $("#mensajeErrorTele").html("");
        setInputState($("#numero"), true);
    }

    // Validación de Contraseña
    if (!$("#contra").val().trim()) {
        mensaje += "error";
        $("#mensajeErrorContra").html("La contraseña no puede estar vacía.");
        setInputState($("#contra"), false);
    } else if (!validarContrasena(contra)) {
        mensaje += "error";
        $("#mensajeErrorContra").html("La contraseña debe tener al menos 8 caracteres, incluyendo al menos una mayúscula, una minúscula y un número.");
        setInputState($("#contra"), false);
    } else {
        $("#mensajeErrorContra").html("");
        setInputState($("#contra"), true);
    }

    // Validación de Coincidencia de Contraseñas
    if (contra !== contraVerify) {
        mensaje += "error";
        $("#mensajeErrorContraVerify").html("Las contraseñas no coinciden.");
        setInputState($("#contra2"), false);
    } else {
        $("#mensajeErrorContraVerify").html("");
        setInputState($("#contra2"), true);
    }

    // Retornar true si no hay errores
    return mensaje === "";
}

function validarContrasena(contra) {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&.,]{8,}$/;
    return regex.test(contra);
}

function setInputState(input, isValid) {
    if (isValid) {
        input.removeClass("input-error").addClass("input-valid");
    } else {
        input.removeClass("input-valid").addClass("input-error");
    }
}

function validarCorreo(correo) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(correo);
}
