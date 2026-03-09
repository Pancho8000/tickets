<?php
// add_solution_column.php
// Script para agregar la columna 'solution_notes' a la tabla 'tickets'
require_once 'db.php';

try {
    // Verificar si la columna ya existe
    $stmt = $conn->query("SHOW COLUMNS FROM tickets LIKE 'solution_notes'");
    if ($stmt->rowCount() == 0) {
        // La columna no existe, agregarla
        $conn->exec("ALTER TABLE tickets ADD COLUMN solution_notes TEXT DEFAULT NULL AFTER status");
        echo "Columna 'solution_notes' agregada exitosamente.<br>";
    } else {
        echo "La columna 'solution_notes' ya existe.<br>";
    }

} catch (PDOException $e) {
    echo "Error al actualizar la tabla: " . $e->getMessage();
}
?>
