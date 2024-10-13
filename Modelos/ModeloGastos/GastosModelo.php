<?php

require_once('C:\xampp\htdocs\ProyectoGestorFinanzas\Modelos\BaseModel.php');

class Gastos extends BaseModel {

    protected $table_name = 'gastos'; // Nombre de la tabla de gastos

    // Constructor de la clase
    public function __construct($db) {
        parent::__construct($db, 'Gastos'); // Llamamos al constructor de la clase base para inicializar la conexión
    }

    // Método para crear un gasto
    public function create($IdCategoria, $IdUsuario, $monto, $descripcion, $motivo) {
        // Consulta SQL para insertar el nuevo gasto
        $query = "INSERT INTO " . $this->table_name . " 
                  (id_categoria, id_usuario, monto, descripcion, motivo, fecha) 
                  VALUES (:IdCategoria, :IdUsuario, :monto, :descripcion, :motivo, :fecha)";
    
        // Preparar la consulta SQL
        $stmt = $this->conn->prepare($query);
    
        // Vincular los parámetros
        $stmt->bindParam(':IdCategoria', $IdCategoria);
        $stmt->bindParam(':IdUsuario', $IdUsuario);
        $stmt->bindParam(':monto', $monto);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':motivo', $motivo);
    
        // Obtener la fecha actual
        $fechaActual = date('Y-m-d');
        $stmt->bindParam(':fecha', $fechaActual);
    
        // Ejecutar la consulta y devolver el resultado
        return $stmt->execute();
    }

    // Obtener los gastos del usuario logueado
    public function getAllGastos($id_usuario) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_usuario = :id_usuario"; // Filtrar por id_usuario
        
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . implode(", ", $this->conn->errorInfo())); // Debugging
        }
        
        // Vincular el parámetro id_usuario
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        
        $stmt->execute();
        
        if ($stmt) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false; // No se encontraron gastos
        }
    }

    // Obtener los gastos del usuario logueado
    public function getById($id_gasto) {
        $query = "SELECT g.*, c.nombre_categoria 
                  FROM " . $this->table_name . " g
                  JOIN categorias c ON g.id_categoria = c.id_categoria
                  WHERE g.id_gasto = :id_gasto"; // Asegúrate de que la columna id_ingreso existe en tu tabla
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_gasto', $id_gasto, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); // Cambia a fetch para obtener un solo ingreso
    }

    // Eliminar un gasto por ID
    public function deleteById($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_gasto = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}