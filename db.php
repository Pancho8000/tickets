<?php
$host = 'localhost';
$db_name = 'tickets_db';
$username = 'root';
$password = ''; // Por defecto en XAMPP es vacío

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    // Habilitar errores de PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
