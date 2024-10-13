<?php
    header('Content-Type: application/json; charset=utf-8');

    // Incluimos el controlador de ingresos
    require_once '../../Controladores/ControladorIngresos/IngresosControlador.php';

    // Determinamos el método HTTP
    $method = $_SERVER['REQUEST_METHOD'];

    // Manejamos la solicitud en función del método HTTP
    switch ($method) {
        case 'GET':
            // Verificar si se solicita un ingreso específico
            if (isset($_GET['id_ingreso'])) {
                IngresosController::obtenerIngreso(); // Llamar a un método específico para obtener por ID
            } else {
                // Retornar todos los ingresos
                IngresosController::obtenerTodosLosIngresos(); // Asegúrate de que este método esté definido
            }
            break;
        case 'POST':
            // Crear nuevo ingreso
            $data = json_decode(file_get_contents("php://input"), true);

            // Verificar si los datos existen
            if (!empty($data)) {
                // Validar que todos los campos necesarios estén presentes
                if (isset($data['id_categoria'], $data['monto'], $data['descripcion'], $data['motivo'])) {
                    // Llamar al controlador para crear el ingreso
                    IngresosController::crearIngreso(
                        $data['id_categoria'], 
                        $data['monto'], 
                        $data['descripcion'], 
                        $data['motivo']
                    );
                } else {
                    // Si faltan datos, responder con error 400
                    http_response_code(400); 
                    echo json_encode(['success' => false, 'message' => 'Datos incompletos. Se requiere id_categoria, monto, descripción y motivo.']);
                }
            } else {
                http_response_code(400); // Código 400 para solicitudes incorrectas
                echo json_encode(['success' => false, 'message' => 'No se recibieron datos']);
            }
            break;
        
        case 'PUT':
        case 'DELETE':
            if (isset($_GET['id_ingreso'])) {
                IngresosController::EliminarIngreso();
            } else {
                http_response_code(400); // Código de error 400 para solicitudes incorrectas
                echo json_encode(['success' => false, 'message' => 'Falta el ID del gasto.']);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no soportado']);
            break;
    }
?>