$(document).ready(function() {
    const usuarioAcciones = document.getElementById('usuarioAcciones');
    const userData = sessionStorage.cedula; 



if (userData) {
    // Si hay datos, mostrar el dropdown
    usuarioAcciones.innerHTML = `
        <div class="profile-dropdown">
            <button class="profile-drop" id="profileMenu">
                <img src="../assets/${sessionStorage.foto}.png" id="profPic" alt="ProfPic" class="profile-img">
                <span class="profile-name">${sessionStorage.nombre} ${sessionStorage.apellido}</span>
            </button>
            <div class="profile-dropdown-content">
                <a href="../Vistas/manejos/manejoUsuario.html">Mi Perfil</a>
                <a href="#">Mis Likes</a>
                <a id="btnLogout" style="cursor: pointer; color: white;">Desloguearse</a>
            </div>
        </div>
    `;

    // Agregar evento para alternar el menú desplegable
    $('#profileMenu').on('click', function(event) {
        event.stopPropagation(); // Evita que el clic se propague
        $('.profile-dropdown-content').toggle(); // Muestra u oculta el dropdown
    });

    // Ocultar el menú cuando se hace clic fuera
    $(document).on('click', function() {
        $('.profile-dropdown-content').hide();
    });

    // Evento para el botón de Desloguearse
    $('#btnLogout').on('click', function() {
        // Limpiar datos de sesión
        sessionStorage.clear();
        // Redirigir a la página de inicio o a donde desees
        window.location.href = '../index.php'; // Cambia esta ruta según tus necesidades
    });

} else {
    // Si no hay datos, mostrar botones de registro y logueo
    usuarioAcciones.innerHTML = `
        <a href="../../Vistas/registros/division.html" class="mr-2 btn btn-custom">Crea tu cuenta</a>
        <a href="../../Vistas/inicios/divisionIni.html" id="btnInicio" class="btn btn-custom mr-2">Ingresa</a>
        <button class="btn btn-custom mr-2">Mis compras</button>
    `;
}
});