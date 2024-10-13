<?php

require_once('C:\xampp\htdocs\ProyectoGestorFinanzas\Modelos\ModeloUsuario\UsuarioModelo.php');
require_once('C:\xampp\htdocs\ProyectoGestorFinanzas\Conexion\Conexion.php'); // Conexión
require_once ('C:\xampp\htdocs\ProyectoGestorFinanzas\Assets\Librerias\vendor\autoload.php'); // Autoload de Composer para Whoops

// Iniciar y registrar Whoops para manejo de errores y excepciones
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

class UsuarioController
{
    private static $usuarioModel;

    // Inicializamos el modelo
    private static function initModel()
    {
        if (self::$usuarioModel === null) {
            $database = new Database();
            $db = $database->getConnection();
            self::$usuarioModel = new Usuario($db);
        }
    }

    // Función para crear un usuario
    public static function crearUsuario($nombre, $email, $password)
    {
        self::initModel(); // Inicializamos el modelo
        try {
            if (self::$usuarioModel->create($nombre, $email, $password)) {
                echo json_encode(['message' => 'Usuario creado exitosamente']);
            } else {
                echo json_encode(['error' => 'Error al crear el usuario']);
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Código de error SQL para duplicados
                echo json_encode(['error' => 'El email ya está registrado']);
            } else {
                echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
            }
        }
    }

    // Función para obtener todos los usuarios
    public static function obtenerUsuarios()
    {
        self::initModel(); // Inicializamos el modelo
        try {
            $usuarios = self::$usuarioModel->getAll();
            $resultados = [];

            foreach ($usuarios as $usuario) {
                // Añadimos los datos al arreglo de resultados
                $resultados[] = [
                    'nombre' => $usuario['nombre'],
                    'email' => $usuario['email'],
                    'password' => $usuario['password'] // Evita devolver el password en texto plano en un proyecto real
                ];
            }

            // Devolvemos los usuarios en formato JSON
            echo json_encode($resultados);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error de base de datos: ' . $e->getMessage()]);
        }
    }

    // Función para iniciar sesión
    public static function iniciarSesion($email, $password)
    {
        try {
            self::initModel(); // Inicializamos el modelo
            session_start();

            // Intentamos buscar el usuario por email
            $usuarios = self::$usuarioModel->buscarPorEmail($email);

            if ($usuarios) {
                // Verificar la contraseña usando password_verify
                if (password_verify($password, $usuarios['password'])) {

                    // Almacenar datos en la sesión
                    $_SESSION['id_usuario'] = $usuarios['id_usuario'];
                    $_SESSION['nombre'] = $usuarios['nombre'];
                    $_SESSION['email'] = $usuarios['email'];
                    $_SESSION['last_activity'] = time();
                    $_SESSION['session_timeout'] = 600; // 10 minutos

                    echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error inesperado: ' . $e->getMessage()]);
        }
    }

    // Verificar sesión
    public static function verificarSesion()
    {
        session_start();
        $response = [];

        if (isset($_SESSION['last_activity'])) {
            $timeElapsed = time() - $_SESSION['last_activity'];
            $timeRemaining = $_SESSION['session_timeout'] - $timeElapsed;

            if ($timeRemaining <= 0) {
                session_unset();
                session_destroy();
                $response['session_active'] = false;
                $response['message'] = 'Sesión expirada, por favor inicie sesión nuevamente.';
            } else {
                $_SESSION['last_activity'] = time();
                $response['session_active'] = true;
                $response['time_remaining'] = $timeRemaining;
            }
        } else {
            $response['session_active'] = false;
            $response['message'] = 'No hay sesión activa, por favor inicie sesión.';
        }

        echo json_encode($response);
    }
}
?>