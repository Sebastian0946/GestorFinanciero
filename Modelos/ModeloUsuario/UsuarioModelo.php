<?php

    require_once('C:\xampp\htdocs\ProyectoGestorFinanzas\Modelos\BaseModel.php');

    class Usuario extends BaseModel {

        // Constructor que utiliza el de BaseModel
        public function __construct($db) {
            parent::__construct($db, 'usuarios'); // Usar 'usuarios' como nombre de la tabla
        }

        // Crear usuario
        public function create($nombre, $email, $password) {
            // Encriptar la contraseña usando password_hash
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
            $query = "INSERT INTO " . $this->table . " (nombre, email, password) VALUES (:nombre, :email, :password)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword); // Usar la contraseña encriptada
            
            return $stmt->execute();
        }

        // Buscar usuario por email
        public function buscarPorEmail($email) {
            $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }

            return false; // No se encontró el usuario
        }
    }