$(document).ready(function() {

    const empresas = [
        { correoEmp: "empresa1@ejemplo.com", contraseñaEmp: "password123" },
        { correoEmp: "empresa2@ejemplo.com", contraseñaEmp: "password456" }
    ];


    function Empresa(correoEmp, contraseñaEmp) {
        this.correoEmp = correoEmp;
        this.contraseñaEmp = contraseñaEmp;
    }

    $("#btnsubmit").click(function(event) {
        event.preventDefault(); 
        tomarDatos();
    });

    function tomarDatos() {
 
        const correoEmp = $("#correoEmp").val();
        const contraseñaEmp = $("#contraEmp").val();


        const resultado = validarEmpresa(correoEmp, contraseñaEmp);
        $("#msj").html(resultado);
    }

  
    function validarEmpresa(unCorreoEmp, unaContraseñaEmp) {
        const empresa = empresas.find(empresa => empresa.correoEmp === unCorreoEmp && empresa.contraseñaEmp === unaContraseñaEmp);

        if (empresa) {
    
            window.location.href = "../manejos/manejoEmpresa.html";
        } else {
            return "Correo o contraseña incorrectos";
        }
    }
});