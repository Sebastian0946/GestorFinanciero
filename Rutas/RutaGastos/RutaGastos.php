<?php
header('Content-Type: application/json; charset=utf-8');

// Incluimos el controlador de gastos
require_once '../../Controladores/ControladorGastos/GastosControlador.php';

// Determinamos el método HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Manejamos la solicitud en función del método HTTP
switch ($method) {
    case 'GET':
        if (isset($_GET['id_gasto'])) {
            GastosController::obtenerGasto();
        } else {
            GastosController::obtenerTodosLosGastos();
        }
        break;
    case 'POST':
        // Crear nuevo gasto
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data)) {
            // Validamos que se reciban todos los datos requeridos
            if (isset($data['id_categoria'], $data['monto'], $data['descripcion'], $data['motivo'])) {
                // Validamos que los valores no estén vacíos
                if (!empty($data['id_categoria']) && !empty($data['monto']) && !empty($data['descripcion']) && !empty($data['motivo'])) {
                    // Crear nuevo gasto
                    GastosController::crearGasto($data['id_categoria'], $data['monto'], $data['descripcion'], $data['motivo']);
                } else {
                    http_response_code(400); // Código de error 400 para solicitudes incorrectas
                    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
                }
            } else {
                http_response_code(400); // Código de error 400 para solicitudes incorrectas
                echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            }
        } else {
            http_response_code(400); // Código de error 400 para solicitudes incorrectas
            echo json_encode(['success' => false, 'message' => 'No se recibieron datos']);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id_gasto'])) {
            // Llama al método de eliminación del controlador de gastos
            GastosController::EliminarGasto();
        } else {
            http_response_code(400); // Código de error 400 para solicitudes incorrectas
            echo json_encode(['success' => false, 'message' => 'Falta el ID del gasto.']);
        }
        break; // Importante: Eliminar esta línea de aquí

    default:
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Método no soportado']);
        break;
}
?>