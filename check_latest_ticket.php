<?php
// check_latest_ticket.php
require_once 'db.php';

try {
    // Obtener el ID del último ticket creado
    $stmt = $conn->query("SELECT MAX(id) as last_id FROM tickets");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Devolver el ID en formato JSON
    header('Content-Type: application/json');
    echo json_encode(['last_id' => $row['last_id'] ? $row['last_id'] : 0]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
