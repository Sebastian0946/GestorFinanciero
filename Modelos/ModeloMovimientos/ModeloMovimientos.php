<?php

class Movimientos
{
    private $conn; // Conexión a la base de datos

    // Constructor
    public function __construct($db)
    {
        $this->conn = $db; // Asignar la conexión a la propiedad
    }

    // Obtener todos los movimientos
    public function obtenerMovimientos($usuarioId, $fechaInicio = null, $fechaFin = null) {
        // Consulta SQL base para gastos e ingresos
        $query = "
            SELECT 
                g.id_gasto AS id,  -- Suponiendo que la columna de ID en gastos es id_gasto
                'gastos' AS tipo, 
                g.descripcion, 
                g.monto, 
                g.fecha,
                g.motivo 
            FROM 
                gastos g 
            WHERE 
                g.id_usuario = :usuarioId
        ";
        
        // Añadir filtros de fecha si están presentes para gastos
        if ($fechaInicio && $fechaFin) {
            $query .= " AND g.fecha BETWEEN :fechaInicio AND :fechaFin ";
        } elseif ($fechaInicio) {
            $query .= " AND g.fecha >= :fechaInicio ";
        }
        
        $query .= " 
            UNION ALL 
            SELECT 
                i.id_ingreso AS id,  -- Suponiendo que la columna de ID en ingresos es id_ingreso
                'ingresos' AS tipo, 
                i.descripcion, 
                i.monto, 
                i.fecha,
                i.motivo
            FROM 
                ingresos i 
            WHERE 
                i.id_usuario = :usuarioId
        ";
    
        // Añadir filtros de fecha si están presentes para ingresos
        if ($fechaInicio && $fechaFin) {
            $query .= " AND i.fecha BETWEEN :fechaInicio AND :fechaFin ";
        } elseif ($fechaInicio) {
            $query .= " AND i.fecha >= :fechaInicio ";
        }
    
        $query .= " ORDER BY fecha DESC"; // Ordenar por fecha
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuarioId', $usuarioId);
    
        // Vincular los parámetros de fecha si están presentes
        if ($fechaInicio) {
            $stmt->bindParam(':fechaInicio', $fechaInicio);
        }
        if ($fechaFin) {
            $stmt->bindParam(':fechaFin', $fechaFin);
        }
    
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retornar todos los movimientos
    }
}