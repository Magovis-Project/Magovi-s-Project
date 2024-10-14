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
    
    $("#btnGuardar").click(tomarDatos);
    
    function tomarDatos() {
        const nombre = $("#nombre").val();
        const apellido = $("#apellido").val();
        const ci = $("#ci").val();
        const direccion = $("#direccion").val();
        const ciudad = $("#ciudad").val();
        const numero = $("#numero").val();
        const correo = $("#correo").val();
        const contra = $("#contra").val();
        const contraVerify = $("#contra2").val();
    
        if (comprobar(ci, numero, contra, contraVerify)) {
        guardarDatos(nombre, apellido, ci, direccion, ciudad, numero, correo, contra);
        alert("Datos guardados correctamente.");
        $("#mensajeError").html("");
        }
    }
    
    function comprobar(ci, numero, contra, contraVerify) {
        let mensaje = "";
    
        // Validación de campos vacíos: nombre, apellido, dirección, ciudad y correo
        const camposObligatorios = ["#nombre", "#apellido", "#direccion", "#ciudad", "#correo"];
        const camposVacios = camposObligatorios.some((selector) => !$(selector).val().trim());
    
        if (camposVacios) {
            mensaje += "No puede haber campos vacíos.<br>";
        }
    
        // Validación de cédula de identidad
        if (!$("#ci").validate_ci()) {
            mensaje += "La cédula no es válida.<br>";
        }
    
        // Validación de número de teléfono
        if (numero.length !== 9) {
            mensaje += "El número de teléfono debe tener 9 dígitos.<br>";
        }
    
        // Validación de contraseña
        if (!contra) {
            mensaje += "La contraseña no puede estar vacía.<br>";
        } else if (!validarContrasena(contra)) {
            mensaje += "La contraseña debe tener al menos 8 caracteres, incluyendo al menos una mayúscula, una minúscula y un número.<br>";
        }
    
        // Validación de coincidencia de contraseñas
        if (contra !== contraVerify) {
            mensaje += "Las contraseñas no coinciden.<br>";
        }
    
        // Mostrar los errores si hay alguno
        if (mensaje) {
            $("#mensajeError").html(mensaje);
            return false;
        }
    
        return true;
    }
    
    // Función para validar la contraseña
    function validarContrasena(contra) {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
        return regex.test(contra);
    }
    
    
    
    
    let usuarios = [];
    function guardarDatos(nombre, apellido, ci, direccion, ciudad, numero, correo, contra) {
        const usuario = {
        nombreIn: nombre,
        apellidoIn: apellido,
        ciIn: ci,
        direccionIn: direccion,
        ciudadIn: ciudad,
        numeroIn: numero,
        correoIn: correo,
        contraseñaIn: contra,
        };
        usuarios.push(usuario);
        console.log(usuarios); // Para verificar en consola los datos guardados.
    }
    