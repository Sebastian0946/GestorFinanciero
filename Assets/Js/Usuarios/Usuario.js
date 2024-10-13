function RegistrarUsuario() {
    // Captura los valores de los inputs
    var nombre = $('#newUsername').val();
    var email = $('#emailRegistro').val();
    var password = $('#newPassword').val();
    var confirmPassword = $('#confirmPassword').val();

    // Validación de contraseñas
    if (password !== confirmPassword) {
        Swal.fire({
            icon: 'error',
            title: 'Error en las contraseñas',
            text: 'Las contraseñas no coinciden.',
            confirmButtonText: 'Aceptar'
        });
        return;
    }

    // Crea el objeto de datos a enviar en formato JSON
    var data = JSON.stringify({
        nombre: nombre,
        email: email,
        password: password
    });

    // Realiza la petición AJAX
    $.ajax({
        url: 'http://localhost/ProyectoGestorFinanzas/rutas/RutaUsuario/RutaUsuario.php', // URL de la API
        type: 'POST',
        data: data, // Enviar los datos en formato JSON
        contentType: 'application/json', // Establecer el tipo de contenido como JSON
        dataType: 'json',
        success: function (response) {
            // Verificar si hay un mensaje de éxito
            if (response.message === "Usuario creado exitosamente") {
                Swal.fire({
                    icon: 'success',
                    title: '¡Registro exitoso!',
                    text: response.message,
                    confirmButtonText: 'Aceptar'
                });
                // Limpiar el formulario después del registro
                $('#registerForm')[0].reset();
            } 
            // Si hay un error enviado desde el servidor
            else if (response.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error en el registro',
                    text: response.error, // Mostrar el mensaje de error enviado desde el servidor
                    confirmButtonText: 'Aceptar'
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud: " + textStatus, errorThrown);
            Swal.fire({
                icon: 'error',
                title: 'Error en la solicitud',
                text: 'Ocurrió un error al procesar la solicitud. Por favor intenta de nuevo.',
                confirmButtonText: 'Aceptar'
            });
        }
    });
}