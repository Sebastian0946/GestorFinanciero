<?php

require_once('C:\xampp\htdocs\ProyectoGestorFinanzas\Modelos\BaseModel.php');

class Categorias extends BaseModel {

    protected $table_name = 'Categorias'; // Nombre de la tabla de categorías

    // Constructor de la clase
    public function __construct($db) {
        parent::__construct($db, 'Categorias'); // Llamamos al constructor de la clase base para inicializar la conexión
    }

    // Método para obtener todas las categorías
    public function getAll() {
        $query = "SELECT id_categoria, nombre_categoria, tipo FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}