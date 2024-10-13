<?php
    header('Content-Type: application/json; charset=utf-8');

    // Incluimos el controlador de gastos
    require_once '../../Controladores/ControladorCategorias/CategoriasControlador.php';

    // Determinamos el método HTTP
    $method = $_SERVER['REQUEST_METHOD'];

    // Manejamos la solicitud en función del método HTTP
    switch ($method) {
        case 'GET':
            // Obtener gastos
            CategoriasController::obtenerCategorias();
            break;
        case 'POST':
            // Crear categoria
            
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