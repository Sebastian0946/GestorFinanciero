<?php

require_once('C:\xampp\htdocs\ProyectoGestorFinanzas\Modelos\BaseModel.php');

class Ingresos extends BaseModel {

    protected $table_name = 'ingresos'; // Nombre de la tabla de ingresos

    // Constructor de la clase
    public function __construct($db) {
        parent::__construct($db, $this->table_name); // Llamamos al constructor de la clase base para inicializar la conexión
    }

    // Método para crear un ingreso
    public function create($IdCategoria, $IdUsuario, $monto, $descripcion, $motivo) {
        // Actualizamos la consulta para incluir las columnas de id_usuario y motivo
        $query = "INSERT INTO " . $this->table_name . " (id_categoria, id_usuario, monto, descripcion, motivo, fecha) 
                  VALUES (:IdCategoria, :IdUsuario, :monto, :descripcion, :motivo, :fecha)";
        
        $stmt = $this->conn->prepare($query);
        
        // Enlazamos los parámetros
        $stmt->bindParam(':IdCategoria', $IdCategoria);
        $stmt->bindParam(':monto', $monto);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':motivo', $motivo);
        $stmt->bindParam(':IdUsuario', $IdUsuario);
        
        // Generar la fecha actual
        $fechaActual = date('Y-m-d'); 
        $stmt->bindParam(':fecha', $fechaActual);
        
        return $stmt->execute(); // Ejecutamos la consulta
    }

    public function getAllIngresos($id_usuario) {
        // Lógica para conectarse a la base de datos y obtener los ingresos
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_usuario = :id_usuario"; // Filtrar por id_usuario
        
        $stmt = $this->conn->prepare($query); // Usamos la conexión del modelo
        
        // Vincular el parámetro id_usuario
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        
        $stmt->execute();
        
        // Manejo de resultados
        if ($stmt) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve todos los ingresos como un array asociativo
        } else {
            return false; // No se encontraron ingresos
        }
    }

    // Obtener un ingreso por ID
    public function getById($id_ingreso) {
        $query = "SELECT g.*, c.nombre_categoria 
                  FROM " . $this->table_name . " g
                  JOIN categorias c ON g.id_categoria = c.id_categoria
                  WHERE g.id_ingreso = :id_ingreso"; // Asegúrate de que la columna id_ingreso existe en tu tabla
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ingreso', $id_ingreso, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); // Cambia a fetch para obtener un solo ingreso
    }

    // Eliminar un ingreso por ID
    public function deleteById($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_ingreso = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}