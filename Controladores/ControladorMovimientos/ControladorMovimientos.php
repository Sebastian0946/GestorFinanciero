<?php

require_once('C:\xampp\htdocs\ProyectoGestorFinanzas\Modelos\ModeloMovimientos\ModeloMovimientos.php');
require_once('C:\xampp\htdocs\ProyectoGestorFinanzas\Conexion\Conexion.php'); // Conexión
require '../../Assets/Librerias/vendor/autoload.php'; // Autoload de Composer para Whoops

// Iniciar y registrar Whoops para manejo de errores y excepciones
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

class MovimientosController {
    private static $MovimientosModel;

    // Inicializamos el modelo
    private static function initModel()
    {
        if (self::$MovimientosModel === null) {
            $database = new Database();
            $db = $database->getConnection();
            self::$MovimientosModel = new Movimientos($db);
        }
    }

    // Función para obtener todos los movimientos (gastos e ingresos)
    public static function obtenerMovimientos() {
        self::initModel(); // Inicializamos el modelo
        session_start(); // Asegúrate de iniciar la sesión aquí
    
        try {
            // Verificar que el usuario esté logueado
            if (isset($_SESSION['id_usuario'])) {
                $id_usuario = $_SESSION['id_usuario']; // Obtener el id del usuario de la sesión
    
                // Verificar si se han pasado fechas de filtrado
                $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
                $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : date('Y-m-d'); // Por defecto, hasta hoy
    
                // Obtener los movimientos del usuario logueado con los filtros de fecha
                $movimientos = self::$MovimientosModel->obtenerMovimientos($id_usuario, $fechaInicio, $fechaFin);
    
                // Inicializamos un arreglo para almacenar los resultados
                $resultados = [];
    
               // Recorremos los movimientos y añadimos los datos al arreglo de resultados
                foreach ($movimientos as $movimiento) {
                    $resultados[] = [
                        'id' => $movimiento['id'], 
                        'tipo' => $movimiento['tipo'], // 'gasto' o 'ingreso'
                        'descripcion' => $movimiento['descripcion'],
                        'motivo' => $movimiento['motivo'],
                        'monto' => $movimiento['monto'],
                        'fecha' => $movimiento['fecha']
                    ];
                }
    
                // Estructura del JSON con data y message
                $response = [
                    'data' => $resultados,
                    'message' => 'Movimientos obtenidos'
                ];
    
                // Devolvemos los movimientos en formato JSON
                echo json_encode($response);
            } else {
                echo json_encode(['error' => 'Usuario no autenticado']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error de base de datos: ' . $e->getMessage()]);
        }
    }
}