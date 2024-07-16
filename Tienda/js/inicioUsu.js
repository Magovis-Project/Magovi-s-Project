$(document).ready();
    const usuarios = [
        { correo: "usuario1@ejemplo.com", contraseña: "password123" },
        { correo: "usuario2@ejemplo.com", contraseña: "password456" }
    ];

   
    function Usuario(correo, contraseña) {
        this.correo = correo;
        this.contraseña = contraseña;
    }

    $("#btnsubmit").click(function(event) {
        event.preventDefault();
        tomarDatos();
    });

    function tomarDatos() {
        
        const correo = $("#correo").val();
        const contraseña = $("#contra").val();

        
        const resultado = validarUsuario(correo, contraseña);
        $("#msj").html(resultado);
    }

    

   
    function validarUsuario(unCorreo, unaContraseña) {
        
        const usuario = usuarios.find(user => user.correo === unCorreo && user.contraseña === unaContraseña);

        if (usuario) {
            window.location.href = "../manejos/manejoUsuario.html";
        } else {
            return "Correo o contraseña incorrectos";
        }
    }

