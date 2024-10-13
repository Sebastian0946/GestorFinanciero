const icons = ['fa-dollar-sign', 'fa-euro-sign', 'fa-pound-sign', 'fa-yen-sign', 'fa-chart-line', 'fa-piggy-bank', 'fa-coins', 'fa-percentage', 'fa-chart-pie', 'fa-money-bill-wave', 'fa-credit-card', 'fa-balance-scale'];
const iconContainer = document.getElementById('financeIcons');

// Limita el número de íconos iniciales (por ejemplo, 10 en lugar de 50)
for (let i = 0; i < 10; i++) {
    createIcon();
}

// Aumenta el intervalo para agregar nuevos íconos (por ejemplo, cada 5 segundos)
setInterval(createIcon, 5000);

function createIcon() {
    const icon = document.createElement('i');
    icon.className = `fas ${icons[Math.floor(Math.random() * icons.length)]} finance-icon`;
    icon.style.left = `${Math.random() * 100}%`;
    icon.style.animationDuration = `${20 + Math.random() * 15}s`; // Aumenta el tiempo de la animación
    icon.style.animationDelay = `${Math.random() * 5}s`;
    iconContainer.appendChild(icon);

    // Elimina el ícono una vez que la animación termina
    icon.addEventListener('animationend', () => {
        icon.remove();
    });
}

function IniciarSesion() {
    // Obtener los valores del formulario
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    // Validar que los campos no estén vacíos
    if (email === '' || password === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor, completa todos los campos.',
            timer: 2000, // Mostrar durante 2 segundos
            showConfirmButton: false
        });
        return;
    }

    // Crear un objeto con los datos de inicio de sesión
    var data = {
        action: 'login',
        email: email,
        password: password
    };

    // Realizar la solicitud AJAX
    $.ajax({
        url: 'http://localhost/ProyectoGestorFinanzas/rutas/RutaUsuario/RutaUsuario.php', // URL de la API
        type: 'POST',
        data: JSON.stringify(data), // Enviar los datos en formato JSON
        contentType: 'application/json', // Tipo de contenido
        dataType: 'json',
        success: function (response) {
            // Verificar si el inicio de sesión fue exitoso
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Inicio de sesión exitoso',
                    text: response.message, // Mostrar el mensaje de la API
                    timer: 2000, // Mostrar durante 2 segundos
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'Vistas/DashBoard.php';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message, // Mostrar el mensaje de la API
                    timer: 2000, // Mostrar durante 2 segundos
                    showConfirmButton: false
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: 'error',
                title: 'Error en la solicitud',
                text: 'Ocurrió un error al procesar la solicitud.',
                timer: 2000, // Mostrar durante 2 segundos
                showConfirmButton: false
            });
            console.error("Error en la solicitud: " + textStatus, errorThrown);
        }
    });
}