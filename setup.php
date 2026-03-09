<?php
// setup.php
// Script para instalar la base de datos automáticamente
$host = 'localhost';
$username = 'root';
$password = ''; // Por defecto en XAMPP es vacío

try {
    // 1. Conectar a MySQL (sin seleccionar base de datos)
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión a MySQL exitosa.<br>";

    // 2. Crear la base de datos si no existe
    $conn->exec("CREATE DATABASE IF NOT EXISTS tickets_db DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
    echo "Base de datos 'tickets_db' verificada.<br>";

    // 3. Seleccionar la base de datos
    $conn->exec("USE tickets_db");

    // 4. Crear la tabla de tickets
    $sql = "CREATE TABLE IF NOT EXISTS tickets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        requester_name VARCHAR(100) NOT NULL,
        department VARCHAR(50) NOT NULL,
        issue_type VARCHAR(50) NOT NULL, -- Hardware, Software, Network, Other
        priority ENUM('Baja', 'Media', 'Alta', 'Crítica') DEFAULT 'Media',
        description TEXT NOT NULL,
        status ENUM('Abierto', 'En Progreso', 'Resuelto', 'Cerrado') DEFAULT 'Abierto',
        solution_notes TEXT DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $conn->exec($sql);
    echo "Tabla 'tickets' verificada.<br>";
    
    // Verificar si la columna solution_notes existe (para actualizaciones)
    try {
        $conn->query("SELECT solution_notes FROM tickets LIMIT 1");
    } catch (Exception $e) {
        $conn->exec("ALTER TABLE tickets ADD COLUMN solution_notes TEXT DEFAULT NULL AFTER status");
        echo "Columna 'solution_notes' agregada.<br>";
    }

    // 5. Insertar datos de ejemplo si la tabla está vacía
    $stmt = $conn->query("SELECT COUNT(*) FROM tickets");
    if ($stmt->fetchColumn() == 0) {
        $sql = "INSERT INTO tickets (requester_name, department, issue_type, priority, description, status) VALUES
        ('Juan Pérez', 'Ventas', 'Software', 'Alta', 'El CRM no carga los clientes nuevos', 'Abierto'),
        ('Ana García', 'Recursos Humanos', 'Hardware', 'Media', 'La impresora del segundo piso no funciona', 'En Progreso'),
        ('Carlos López', 'Finanzas', 'Red', 'Crítica', 'Sin acceso a internet en toda el área', 'Abierto')";
        $conn->exec($sql);
        echo "Datos de ejemplo insertados.<br>";
    } else {
        echo "La tabla ya tiene datos.<br>";
    }

    echo "<hr><h3>¡Instalación completada con éxito!</h3>";
    echo "<p>Ahora puedes ir a:</p>";
    echo "<ul>";
    echo "<li><a href='index.php'>Registrar un Ticket (Usuario)</a></li>";
    echo "<li><a href='admin.php'>Panel de Administración (TI)</a></li>";
    echo "</ul>";

} catch(PDOException $e) {
    echo "Error en la instalación: " . $e->getMessage();
}
?>
