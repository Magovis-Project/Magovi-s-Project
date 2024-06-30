$("#btnGuardar").click (tomarDatos);
function tomarDatos(){
    let nombreEmp = $("#nombreEmp").val();
    let ubicacionEmp = $("#ubicacionEmp").val();
    let numeroEmp = Number($("#numeroEmp").val());
    let correoEmp = $("#correoEmp").val();
    let contraEmp = Number($("#contraEmp").val());
    let contraVerify = Number($("#contra2").val());
    let id;
    let check;
    
    comprobar(numeroEmp,correoEmp,contraEmp,contraVerify,check);
    
    if(check==true){
        guardarDatos(nombreEmp,ubicacionEmp,numeroEmp,correoEmp,contraEmp); 
    }else if(check==false){

    }

    
}

function comprobar(numeroEmp,correoEmp,contraEmp,contraVerify,check){
    let numbn;
    let contrabn;
    let correobn;
    if (numeroEmp.length=9){
        numbn==true;
    }else{
        numbn==false;
    }
    for(let i;i<correoEmp.length;i++){
    if (correoEmp.charAt(i)== "@" && correoEmp.charAt(!i)=="@"){
        correobn==false;
    }else{
        correobn==true;
    }
    }
    if (contraEmp == contraVerify){
        contrabn==true;
    }else{
        contrabn==false; 
    }
    if (contrabn==true && numbn==true && correobn==true){
        return check==true;
    }else if(contrabn==true && numbn==false && correobn==true){
        return check==false;
        $("#mensajeError").html("El numero de telefono no es valido");
    } else if(contrabn==false && numbn==true && correobn==true){
        return check==false;
        $("#mensajeError").html("Las contraseñas deben coincidir");
    } else if(contrabn==true && numbn==true && correobn==false){
        return check==false;
        $("#mensajeError").html("El correo no es valido");
    } else if(contrabn==true && numbn==false && correobn==false){
        return check==false;
        $("#mensajeError").html("El correo no es valido"+"<br>"+"El numero de telefono no es valido");
   } else if(contrabn==false && numbn==true && correobn==false){
    return check==false;
    $("#mensajeError").html("El correo no es valido"+"<br>"+"Las contraseñas deben coincidir");
    }else if(contrabn==false && numbn==false && correobn==true){
        return check==false;
        $("#mensajeError").html("El numero de telefono no es valido"+"<br>"+"Las contraseñas deben coincidir");
    }else if(contrabn==false && numbn==false && correobn==false){
        return check==false;
        $("#mensajeError").html("El numero de telefono no es valido"+"<br>"+"Las contraseñas deben coincidir"+"<br>"+"El correo electronico no es valido");
    }
    }
let empresas = [];
function guardarDatos(nombreEmp,ubicacionEmp,numeroEmp,correoEmp,contraEmp){
    
    let empresa = {
        nombreEmpIn: nombreEmp,
        ubicacionEmpIn: ubicacionEmp,
        numeroEmpIn: numeroEmp,
        correoEmpIn: correoEmp,
        contraEmpIn: contraEmp,
        idEmpIn: idEmp
    };
    empresas.push(empresa);

}