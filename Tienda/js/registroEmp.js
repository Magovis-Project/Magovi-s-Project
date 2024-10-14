$("#btnGuardar").click(tomarDatos);

function tomarDatos() {
    let nombreEmp = $("#nombreEmp").val().trim(); // Eliminar espacios en blanco
    let ubicacionEmp = $("#ubicacionEmp").val().trim(); // Eliminar espacios en blanco
    let numeroEmp = $("#numeroEmp").val().trim(); // Eliminar espacios en blanco
    let correoEmp = $("#correoEmp").val().trim(); // Eliminar espacios en blanco
    let contraEmp = $("#contraEmp").val().trim(); // Eliminar espacios en blanco
    let contraVerify = $("#contra2").val().trim(); // Eliminar espacios en blanco
    let rut = $("#rut").val().trim().replace(/\D/g, ''); // Asegúrate de eliminar caracteres no numéricos
    let check;

    check = comprobar(numeroEmp, correoEmp, contraEmp, contraVerify, rut, nombreEmp, ubicacionEmp);
    
    if (check) {
        guardarDatos(nombreEmp, ubicacionEmp, numeroEmp, correoEmp, contraEmp, rut); 
        alert("Datos guardados correctamente.");
        $("#mensajeError").html("");
    }
}

function comprobar(numeroEmp, correoEmp, contraEmp, contraVerify, rut, nombreEmp, ubicacionEmp) {
    let mensaje = "";
    let camposVacios = [];

    // Validación de campos vacíos
    if (!nombreEmp) camposVacios.push("nombre de la empresa");
    if (!ubicacionEmp) camposVacios.push("ubicación");
    if (!numeroEmp) camposVacios.push("número de teléfono");
    if (!correoEmp) camposVacios.push("correo");
    if (!contraEmp) camposVacios.push("contraseña");
    if (!contraVerify) camposVacios.push("verificación de contraseña");
    if (!rut) camposVacios.push("RUT");

    // Si hay campos vacíos, crea un mensaje único
    if (camposVacios.length > 0) {
        mensaje += "Los siguientes campos no pueden estar vacíos: " + camposVacios.join(", ") + ".<br>";
    }

    // Validación de número de teléfono
    if (numeroEmp.length !== 9) {
        mensaje += "El número de teléfono debe tener 9 dígitos.<br>";
    }

    // Validación de correo electrónico
    if (!validarCorreo(correoEmp)) {
        mensaje += "El correo no es válido.<br>";
    }

    // Validación de contraseña
    if (contraEmp !== contraVerify) {
        mensaje += "Las contraseñas deben coincidir.<br>";
    }

    // Validación de contraseña
    if (!validarContrasena(contraEmp)) {
        mensaje += "La contraseña debe tener al menos 8 caracteres, incluyendo al menos una mayúscula, una minúscula y un número.<br>";
    }

    // Validación de RUT
    if (!validarRUT(rut)) {
        mensaje += "El RUT no es válido.<br>";
    }

    // Mostrar los errores si hay alguno
    if (mensaje) {
        $("#mensajeError").html(mensaje);
        return false;
    }

    return true;
}

// Función para validar el correo electrónico
function validarCorreo(correo) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(correo);
}

function validarContrasena(contraEmp) {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
    return regex.test(contraEmp);
}

// Función para validar el RUT
function validarRUT(rut) {
    // Verificar longitud
    if (rut.length < 8 || rut.length > 10) {
        return false;
    }

    const digitoVerificador = rut.charAt(rut.length - 1).toUpperCase();
    const numeros = rut.slice(0, -1).split('').reverse();
    const pesos = [2, 9, 8, 7, 6, 5, 4, 3]; // Pesos de derecha a izquierda
    let suma = 0;

    // Calcular la suma
    for (let i = 0; i < numeros.length; i++) {
        suma += parseInt(numeros[i]) * pesos[i % pesos.length];
    }

    // Calcular el residuo
    const residuo = suma % 11;
    let dvCalculado;

    if (residuo === 0) {
        dvCalculado = '0';
    } else if (residuo === 1) {
        dvCalculado = 'K';
    } else {
        dvCalculado = (11 - residuo).toString();
    }

    // Comparar el dígito verificador calculado con el ingresado
    return dvCalculado === digitoVerificador;
}

let empresas = [];
function guardarDatos(nombreEmp, ubicacionEmp, numeroEmp, correoEmp, contraEmp, rut) {
    let empresa = {
        nombreEmpIn: nombreEmp,
        ubicacionEmpIn: ubicacionEmp,
        numeroEmpIn: numeroEmp,
        correoEmpIn: correoEmp,
        contraEmpIn: contraEmp,
        rutIn: rut
    };
    empresas.push(empresa);
    console.log(empresas); // Para verificar en consola los datos guardados.
}
