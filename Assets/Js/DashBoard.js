setInterval(verificarSesion, 600000); // Verificar cada 60,000 ms (1 minuto)

function verificarSesion() {
    $.ajax({
        url: "http://localhost/ProyectoGestorFinanzas/rutas/VerificarSesion.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (!response.session_active) {
                // Si la sesión ha expirado, redirigir al login
                Swal.fire({
                    title: "Sesión expirada",
                    text: response.message,
                    icon: "warning",
                    timer: 2000,
                    showConfirmButton: false,
                }).then(() => {
                    window.location.href = "../index.php"; // Redirigir al login
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error al verificar la sesión: " + textStatus, errorThrown);
        },
    });
}

// Función para cargar la página en el iframe
function loadPage(page) {
    const iframe = document.getElementById("content-frame");
    iframe.src = page; // Carga la página seleccionada en el iframe
}

// Cargar la página predeterminada al iniciar
document.addEventListener("DOMContentLoaded", function () {
    loadPage("Movimientos/Movimiento.php"); // Cambia la página predeterminada si es necesario
});