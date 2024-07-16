window.addEventListener("scroll", function(){
    var header = document.querySelector("header");
    var logo = document.querySelector("header .logo");
    if (window.scrollY > 0) {
        header.classList.add("abajo");
        logo.style.top = "-2000px"; // Ajusta esto para que el logo desaparezca
    } else {
        header.classList.remove("abajo");
        logo.style.top = "-50px"; // Ajusta esto para que el logo vuelva a su posición original
    }
});

$("#boton").click(TomarDatos);
function TomarDatos() {
        var name = $("#name").val();
        var email = $("#email").val();
        var message = $("#message").val();
        var mensaje = validarFormulario(name, email, message);
        mostrarMensaje(mensaje);
    }

    function validarFormulario(name, email, message) {
        if (!name) {
            return 'Por favor, ingresa tu nombre.';
        }

        if (!email) {
            return 'Por favor, ingresa tu email.';
        }

        // Expresión regular para validar el email
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            return 'Por favor, ingresa un email válido.';
        }

        if (!message) {
            return 'Por favor, ingresa tu mensaje.';
        }

        return '¡Formulario enviado exitosamente! Te contestaremos a la brevedad';
    }

    function mostrarMensaje(mensaje) {
        alert(mensaje);
    }