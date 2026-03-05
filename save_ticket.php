<?php
// save_ticket.php

// Conexión a la base de datos
require_once 'db.php';

// Verificar si se enviaron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar datos básicos
    $requester_name = trim($_POST['requester_name']);
    $department = trim($_POST['department']);
    $issue_type = trim($_POST['issue_type']);
    $priority = trim($_POST['priority']);
    $description = trim($_POST['description']);

    // Validar que los campos no estén vacíos
    if (empty($requester_name) || empty($department) || empty($issue_type) || empty($priority) || empty($description)) {
        header("Location: index.php?error=empty_fields");
        exit();
    }

    try {
        // Preparar la consulta SQL
        $stmt = $conn->prepare("INSERT INTO tickets (requester_name, department, issue_type, priority, description, status) VALUES (?, ?, ?, ?, ?, 'Abierto')");
        
        // Ejecutar la consulta
        $stmt->execute([$requester_name, $department, $issue_type, $priority, $description]);

        // Redirigir al usuario con mensaje de éxito
        header("Location: index.php?success=1");
        exit();

    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error al guardar el ticket: " . $e->getMessage();
    }
} else {
    // Si no es POST, redirigir al formulario
    header("Location: index.php");
    exit();
}
?>
