<?php
    header('Content-Type: application/json; charset=utf-8');

    // Incluimos el controlador de usuario
    require_once '../../Controladores/ControladorUsuario/UsuarioControlador.php';

    // Determinamos el método HTTP
    $method = $_SERVER['REQUEST_METHOD'];

    // Manejamos la solicitud en función del método HTTP
    switch ($method) {
        case 'GET':
            // Obtener usuarios
            UsuarioController::obtenerUsuarios();
            break;
        case 'POST':
            // Se espera que el login y el registro usen métodos POST
            $data = json_decode(file_get_contents("php://input"), true);
            if (!empty($data)) {
                if (isset($data['nombre'], $data['email'], $data['password'])) {
                    // Crear nuevo usuario
                    UsuarioController::crearUsuario($data['nombre'], $data['email'], $data['password']);
                } elseif (isset($data['email'], $data['password'])) {
                    // Iniciar sesión
                    UsuarioController::iniciarSesion($data['email'], $data['password']);
                } else {
                    http_response_code(400); // Código de error 400 para solicitudes incorrectas
                    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
                }
            } else {
                http_response_code(400); // Código de error 400 para solicitudes incorrectas
                echo json_encode(['success' => false, 'message' => 'No se recibieron datos']);
            }
            break;
        case 'PUT':
        case 'DELETE':
            http_response_code(405); // Código de error 405 para métodos no permitidos
            echo json_encode(['success' => false, 'message' => 'Método no soportado']);
            break;
        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no soportado']);
            break;
    }
?>