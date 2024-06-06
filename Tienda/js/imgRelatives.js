$(document).ready(function() {
    moveImage(); // Llama a la función moveImage
    adjustHeaderHeight(); // Llama a la función adjustHeaderHeight
});

$(window).on("resize", function() {
    moveImage(); // Llama a la función moveImage
    adjustHeaderHeight(); // Llama a la función adjustHeaderHeight
});

function moveImage() {
    const $element = $(".responsiveElement");
    const windowWidth = $(window).width();
    const windowHeight = $(window).height();

    $element.each(function() {
        const position = $(this).data("position");
        const elementWidth = $(this).width();
        const elementHeight = $(this).height();
        let top, right, bottom, left;

        switch (position) {
            case "carrito":
                top = 25;
                right = 25;
                $(this).css({ top: top, right: right, bottom: "", left: "" });
                break;

            case "logo":
                top = 25;
                left = 25;
                $(this).css({ top: "", right: right, bottom: bottom, left: "" });
                break;

            case "registro":
                top = (windowHeight - elementHeight) / 2;
                left = (windowWidth - elementWidth) / 2;
                $(this).css({ top: top, right: "", bottom: "", left: left });
                break;

            case "textoIniRegi":
                top = 40;
                left = 600;
                $(this).css({ top: top, right: "", bottom: "", left: left });
                break;

            // Añadir más posiciones según sea necesario
            default:
                break;
        }
    });
}

function adjustHeaderHeight() {
    const windowWidth = $(window).width();
    const windowHeight = $(window).height();
    const header = $("header");

    // Verificar si la ventana está maximizada
    if (windowWidth === screen.width && windowHeight === screen.height) {
        // Ventana maximizada, establecer una altura fija para el encabezado
        header.css("height", "100px");
    } else {
        // Ventana no maximizada, ajustar la altura del encabezado según el tamaño de la ventana
        const minHeight = 20; // Altura mínima deseada para el encabezado
        const newHeight = Math.max(minHeight, windowHeight * 0.2); // Por ejemplo, el 5% de la altura de la ventana
        header.css("height", newHeight + "px");
    }
}
