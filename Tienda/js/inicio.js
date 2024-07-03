$(document).ready(function() {
    // Asegúrate de que el botón y el modal existan antes de agregar el evento
    $('#btnInicio').on('click', function() {
        $('#modalInicio').modal('show');
    });

    // Enfoca el botón al mostrar el modal
    $('#modalInicio').on('shown.bs.modal', function () {
        $('#btnInicio').trigger('focus');
    });
});