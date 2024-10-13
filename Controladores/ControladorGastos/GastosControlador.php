<?php

require_once('C:\xampp\htdocs\ProyectoGestorFinanzas\Modelos\ModeloGastos\GastosModelo.php');
require_once('C:\xampp\htdocs\ProyectoGestorFinanzas\Conexion\Conexion.php'); // Conexión
require '../../Assets/Librerias/vendor/autoload.php'; // Autoload de Composer para Whoops

// Iniciar y registrar Whoops para manejo de errores y excepciones
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

class GastosController
{
    private static $GastosModel;

    // Inicializamos el modelo
    private static function initModel()
    {
        if (self::$GastosModel === null) {
            $database = new Database();
            $db = $database->getConnection();
            self::$GastosModel = new Gastos($db);
        }
    }

    // Función para crear un gasto
    public static function crearGasto($IdCategoria, $monto, $descripcion, $motivo)
    {
        session_start(); // Asegúrate de que la sesión esté iniciada
        $IdUsuario = $_SESSION['id_usuario']; // Obtener el ID del usuario desde la sesión
    
        self::initModel(); // Inicializamos el modelo
        try {
            // Pasar id_usuario al modelo
            if (self::$GastosModel->create($IdCategoria, $IdUsuario, $monto, $descripcion, $motivo)) {
                // Devuelve una respuesta con `success` en true
                echo json_encode([
                    'success' => true,
                    'message' => 'Gasto creado exitosamente'
                ]);
            } else {
                // En caso de error, lanzamos una excepción
                throw new Exception('Error al crear el gasto');
            }
        } catch (Exception $e) {
            // Respuesta en caso de un error general
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        } catch (PDOException $e) {
            // Respuesta en caso de un error con la base de datos
            echo json_encode([
                'success' => false,
                'error' => 'Error de base de datos: ' . $e->getMessage()
            ]);
        }
    }

    // Función para obtener todos los ingresos
    public static function obtenerTodosLosGastos() {
        self::initModel(); // Inicializamos el modelo
        
        // Obtener el id_usuario de la sesión
        session_start(); // Asegúrate de iniciar la sesión
        if (!isset($_SESSION['id_usuario'])) {
            echo json_encode(['success' => false, 'message' => 'Usuario no autenticado.']);
            exit(); // Salir si no hay usuario logueado
        }
    
        $id_usuario = $_SESSION['id_usuario']; // Obtener el id del usuario logueado
        
        // Obtener los gastos desde la base de datos
        $gastos = self::$GastosModel->getAllGastos($id_usuario);
        
        // Comprobar si se encontraron gastos
        if ($gastos) {
            echo json_encode(['success' => true, 'data' => $gastos]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontraron gastos.']);
        }
        exit(); // Asegúrate de terminar la ejecución después de enviar la respuesta
    }


    // Función para obtener todos los gastos
    public static function obtenerGasto() {
        session_start(); // Asegúrate de que la sesión esté iniciada
    
        // Verificar si se recibe el id_ingreso como parámetro
        if (!isset($_GET['id_gasto'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Falta el parámetro Id gasto']);
            return;
        }
    
        $id_gasto = $_GET['id_gasto'];
    
        // Inicializa el modelo
        self::initModel(); // Asegúrate de que el modelo está inicializado
    
        // Llama al método getById para obtener el ingreso
        $gasto = self::$GastosModel->getById($id_gasto);
    
        if ($gasto) {
            // Añadir tipo_movimiento al arreglo de datos
            $gasto['tipoMovimiento'] = 'gastos'; // Asignar el tipo de movimiento
            echo json_encode(['success' => true, 'data' => $gasto]);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['success' => false, 'message' => 'Ingreso no encontrado']);
        }
    }

    public static function EliminarGasto() {
        // Verificamos que se reciba el ID
        if (isset($_GET['id_gasto'])) {
            $id_gasto = $_GET['id_gasto'];
            
            self::initModel();
            // Aquí llamamos al modelo para eliminar el gasto
            $resultado = self::$GastosModel->deleteById($id_gasto);
            // Verificamos si la eliminación fue exitosa
            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Gasto eliminado exitosamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el gasto.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Falta el ID del gasto.']);
        }
    }
}
?>