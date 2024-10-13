<?php

require_once('C:\xampp\htdocs\ProyectoGestorFinanzas\Modelos\ModeloIngresos\ModeloIngresos.php');
require_once('C:\xampp\htdocs\ProyectoGestorFinanzas\Conexion\Conexion.php');
require '../../Assets/Librerias/vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

class IngresosController
{
    private static $IngresosModel;

    // Inicializamos el modelo
    private static function initModel()
    {
        if (self::$IngresosModel === null) {
            $database = new Database();
            $db = $database->getConnection();
            self::$IngresosModel = new Ingresos($db); 
        }
    }

    // Función para crear un ingreso
    public static function crearIngreso($IdCategoria, $monto, $descripcion, $motivo){

        session_start(); // Asegúrate de que la sesión esté iniciada
        $IdUsuario = $_SESSION['id_usuario']; // Obtener el ID del usuario desde la sesión
    
        self::initModel(); // Inicializamos el modelo
        try {
            // Pasar id_usuario al modelo
            if (self::$IngresosModel->create($IdCategoria, $IdUsuario, $monto, $descripcion, $motivo)) {
                // Devuelve una respuesta con `success` en true
                echo json_encode([
                    'success' => true,
                    'message' => 'Ingreso creado exitosamente'
                ]);
            } else {
                // En caso de error, lanzamos una excepción
                throw new Exception('Error al crear el ingreso');
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
    public static function obtenerTodosLosIngresos() {
        self::initModel(); // Inicializamos el modelo
        
        // Obtener el id_usuario de la sesión
        session_start(); // Asegúrate de iniciar la sesión
        if (!isset($_SESSION['id_usuario'])) {
            echo json_encode(['success' => false, 'message' => 'Usuario no autenticado.']);
            exit(); // Salir si no hay usuario logueado
        }
    
        $id_usuario = $_SESSION['id_usuario']; // Obtener el id del usuario logueado
        
        // Obtener los ingresos desde la base de datos
        $ingresos = self::$IngresosModel->getAllIngresos($id_usuario); // Llama al método de instancia en lugar de estático
        
        // Comprobar si se encontraron ingresos
        if ($ingresos) {
            echo json_encode(['success' => true, 'data' => $ingresos]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontraron ingresos.']);
        }
    }
    // Función para obtener un ingreso por ID
    public static function obtenerIngreso() {
        session_start(); // Asegúrate de que la sesión esté iniciada
    
        // Verificar si se recibe el id_ingreso como parámetro
        if (!isset($_GET['id_ingreso'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Falta el parámetro id_ingreso']);
            return;
        }
    
        $id_ingreso = $_GET['id_ingreso'];
    
        // Inicializa el modelo
        self::initModel(); // Asegúrate de que el modelo está inicializado
    
        // Llama al método getById para obtener el ingreso
        $ingreso = self::$IngresosModel->getById($id_ingreso);
    
        if ($ingreso) {
            // Añadir tipo_movimiento al arreglo de datos
            $ingreso['tipoMovimiento'] = 'ingresos'; // Asignar el tipo de movimiento
            echo json_encode(['success' => true, 'data' => $ingreso]);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['success' => false, 'message' => 'Ingreso no encontrado']);
        }
    }

    // Función para eliminar un ingreso
    public static function EliminarIngreso() {
        // Verificamos que se reciba el ID
        if (isset($_GET['id_ingreso'])) {
            $id_ingreso = $_GET['id_ingreso'];
            
            self::initModel();
            // Aquí llamamos al modelo para eliminar el ingreso
            $resultado = self::$IngresosModel->deleteById($id_ingreso);
            // Verificamos si la eliminación fue exitosa
            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Ingreso eliminado exitosamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el ingreso.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Falta el ID del ingreso.']);
        }
    }
}

?>