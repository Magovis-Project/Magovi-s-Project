$("#btnGuardar").click (tomarDatos);
function tomarDatos(){
    let nombre = $("#nombre").val();
    let apellido = $("#apellido").val();
    let ci = Number($("#ci").val());
    let departamento = $("#departamento").val();
    let ciudad = $("#ciudad").val();
    let numero = Number($("#numero").val());
    let correo = $("#correo").val();
    let contra = Number($("#contra").val());
    let contraVerify = Number($("#contra2").val());
    let id;
    let check;
    
    comprobar(ci,numero,correo,contra,contraVerify,check);
    
    if(check==true){
        guardarDatos(nombre,apellido,ci,departamento,ciudad,numero,correo,contra); 
    }else if(check==false){

    }

    
}

function comprobar(ci,numero,correo,contra,contraVerify,check){
    let cibn;
    let numbn;
    let contrabn;
    if (ci.length==8 || ci.length==7){
        cibn==true;
    }else{ 
    cibn=false;
    }
    if (numero.length=9){
        numbn==true;
    }else{
        numbn==false;
    }
    if (contra == contraVerify){
        contrabn==true;
    }else{
        contrabn==false; 
    }
    if (contrabn==true && numbn==true && cibn==true){
        return check==true;
    }else if(contrabn==true && numbn==true && cibn==false){
        return check==false;
        $("#mensajeError").html("La cedula no es valida");
    } else if(contrabn==true && numbn==false && cibn==true){
        return check==false;
        $("#mensajeError").html("El numero de telefono no es valido");
    } else if(contrabn==false && numbn==true && cibn==true){
        return check==false;
        $("#mensajeError").html("Las contraseñas deben coincidir");
    } else if(contrabn==true && numbn==false && cibn==false){
        return check==false;
        $("#mensajeError").html("El numero de telefono no es valido"<br>"La cedula no es valida");
    } else if(contrabn==false && numbn==false && cibn==true){
        return check==false;
        $("#mensajeError").html("El numero de telefono no es valido"<br>"Ambas contraseñas deben coincidir");
    } else if(contrabn==false && numbn==true && cibn==false){
        return check==false;
        $("#mensajeError").html("La cedula no es valida"<br>"Ambas contraseñas deben coincidir");
    } else if(contrabn==false && numbn==false && cibn==false){
        return check==false;
        $("#mensajeError").html("El numero de telefono no es valido"<br>"Ambas contraseñas deben coincidir"<br>"La cedula no es valida");
    }
}
let usuarios = [];
function guardarDatos(nombre,apellido,ci,departamento,ciudad,numero,correo,contra){
    
    let usuario = {
        nombreIn: nombre,
        apellidoIn: apellido,
        ciIn: ci,
        departamentoIn: departamento,
        ciudadIn: ciudad,
        numeroIn: numero,
        correoIn: correo,
        contraseñaIn: contra,
        idIn: id
    };
    usuarios.push(usuario);

}