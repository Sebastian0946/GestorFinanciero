<?php

require_once('C:\xampp\htdocs\ProyectoGestorFinanzas\Modelos\ModeloCategorias\ModeloCategorias.php');
require_once('C:\xampp\htdocs\ProyectoGestorFinanzas\Conexion\Conexion.php'); // Conexión
require '../../Assets/Librerias/vendor/autoload.php'; // Autoload de Composer para Whoops

// Iniciar y registrar Whoops para manejo de errores y excepciones
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

class CategoriasController {
    private static $CategoriasModel;

    // Inicializamos el modelo
    private static function initModel() {
        if (self::$CategoriasModel === null) {
            $database = new Database();
            $db = $database->getConnection();
            self::$CategoriasModel = new Categorias($db);
        }
    }

    // Función para obtener todas las categorías
    public static function obtenerCategorias() {
        self::initModel(); // Inicializamos el modelo

        try {
            // Obtener todas las categorías
            $categorias = self::$CategoriasModel->getAll();
    
            $resultados = [];
    
            foreach ($categorias as $categoria) {
                // Añadimos los datos al arreglo de resultados
                $resultados[] = [
                    'id_categoria' => $categoria['id_categoria'],
                    'nombre_categoria' => $categoria['nombre_categoria'],
                    'tipo_categoria'=>$categoria['tipo']
                ];
            }
    
            // Devolvemos las categorías en formato JSON
            echo json_encode($resultados);

        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error de base de datos: ' . $e->getMessage()]);
        }
    }
}
?>