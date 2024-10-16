$(document).ready(function () {
    $("#btnGuardar").click(function (event) {
        event.preventDefault();
        tomarDatos();
    });

    function tomarDatos() {
        const nombreEmp = $("#nombreEmp").val().trim();
        const ubicacionEmp = $("#ubicacionEmp").val().trim();
        const numeroEmp = $("#numeroEmp").val().trim();
        const correoEmp = $("#correoEmp").val().trim();
        const contraEmp = $("#contraEmp").val().trim();
        const contraVerify = $("#contra2").val().trim();
        const rut = $("#rut").val().trim().replace(/\D/g, "");

        let isValid = true;

        // Validación de nombre de empresa
        if (!nombreEmp) {
            $("#mensajeErrorNombreEmp").html("El nombre de la empresa no puede estar vacío.");
            $("#nombreEmp").removeClass("input-valid").addClass("input-error");
            isValid = false;
        } else {
            $("#mensajeErrorNombreEmp").html("");
            $("#nombreEmp").removeClass("input-error").addClass("input-valid");
        }

        // Validación de ubicación
        if (!ubicacionEmp) {
            $("#mensajeErrorUbicacionEmp").html("La ubicación no puede estar vacía.");
            $("#ubicacionEmp").removeClass("input-valid").addClass("input-error");
            isValid = false;
        } else {
            $("#mensajeErrorUbicacionEmp").html("");
            $("#ubicacionEmp").removeClass("input-error").addClass("input-valid");
        }

        // Validación de número de teléfono
        if (!/^\d{9}$/.test(numeroEmp)) {
            $("#mensajeErrorNumeroEmp").html("El número de teléfono debe tener 9 dígitos.");
            $("#numeroEmp").removeClass("input-valid").addClass("input-error");
            isValid = false;
        } else {
            $("#mensajeErrorNumeroEmp").html("");
            $("#numeroEmp").removeClass("input-error").addClass("input-valid");
        }

        // Validación de correo
        if (!correoEmp) {
            $("#mensajeErrorCorreoEmp").html("El correo no puede estar vacío.");
            $("#correoEmp").removeClass("input-valid").addClass("input-error");
            isValid = false;
        } else if (!validarCorreo(correoEmp)) {
            $("#mensajeErrorCorreoEmp").html("El correo debe tener un formato válido.");
            $("#correoEmp").removeClass("input-valid").addClass("input-error");
            isValid = false;
        } else {
            $("#mensajeErrorCorreoEmp").html("");
            $("#correoEmp").removeClass("input-error").addClass("input-valid");
        }

        // Validación de contraseña
        if (!contraEmp) {
            $("#mensajeErrorContraEmp").html("La contraseña no puede estar vacía.");
            $("#contraEmp").removeClass("input-valid").addClass("input-error");
            isValid = false;
        } else if (!validarContrasena(contraEmp)) {
            $("#mensajeErrorContraEmp").html("La contraseña debe tener al menos 8 caracteres, incluyendo al menos una mayúscula, una minúscula y un número.");
            $("#contraEmp").removeClass("input-valid").addClass("input-error");
            isValid = false;
        } else {
            $("#mensajeErrorContraEmp").html("");
            $("#contraEmp").removeClass("input-error").addClass("input-valid");
        }

        // Validación de coincidencia de contraseñas
        if (contraEmp !== contraVerify) {
            $("#mensajeErrorContraVerify").html("Las contraseñas no coinciden.");
            $("#contra2").removeClass("input-valid").addClass("input-error");
            isValid = false;
        } else {
            $("#mensajeErrorContraVerify").html("");
            $("#contra2").removeClass("input-error").addClass("input-valid");
        }

        // Validación de RUT
        if (!validarRUT(rut)) {
            $("#mensajeErrorRut").html("El RUT no es válido.");
            $("#rut").removeClass("input-valid").addClass("input-error");
            isValid = false;
        } else {
            $("#mensajeErrorRut").html("");
            $("#rut").removeClass("input-error").addClass("input-valid");
        }

        if (isValid) {
            // Obtener datos del formulario
            var formData = {
                nombreEmp: nombreEmp,
                ubicacionEmp: ubicacionEmp,
                numeroEmp: numeroEmp,
                correoEmp: correoEmp,
                contraEmp: contraEmp,
                rut: rut
            };

            // Enviar datos al controlador
            $.ajax({
                type: "POST", // Método de envío
                url: "../Controlador/EmpresaControlador.php", // Cambia esto a la ruta de tu controlador
                data: formData,
                success: function (response) {
                    // Manejar la respuesta del servidor
                    alert("Registro exitoso: " + response);
                },
                error: function (xhr, status, error) {
                    // Manejar errores
                    alert("Error: " + error);
                }
            });
        }
    }

    function validarCorreo(correo) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(correo);
    }

    function validarContrasena(contra) {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&.,]{8,}$/;
        return regex.test(contra);
    }

    function validarRUT(rut) {
        if (rut.length < 8 || rut.length > 10) return false;

        const digitoVerificador = rut.charAt(rut.length - 1).toUpperCase();
        const numeros = rut.slice(0, -1).split("").reverse();
        const pesos = [2, 9, 8, 7, 6, 5, 4, 3];
        let suma = 0;

        for (let i = 0; i < numeros.length; i++) {
            suma += parseInt(numeros[i]) * pesos[i % pesos.length];
        }

        const residuo = suma % 11;
        let dvCalculado;

        if (residuo === 0) {
            dvCalculado = "0";
        } else if (residuo === 1) {
            dvCalculado = "K";
        } else {
            dvCalculado = (11 - residuo).toString();
        }

        return dvCalculado === digitoVerificador;
    }
});
