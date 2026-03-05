-- Crear base de datos si no existe
CREATE DATABASE IF NOT EXISTS tickets_db;
USE tickets_db;

-- Tabla de Tickets
CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    requester_name VARCHAR(100) NOT NULL,
    department VARCHAR(50) NOT NULL,
    issue_type VARCHAR(50) NOT NULL, -- Hardware, Software, Network, Other
    priority ENUM('Baja', 'Media', 'Alta', 'Crítica') DEFAULT 'Media',
    description TEXT NOT NULL,
    status ENUM('Abierto', 'En Progreso', 'Resuelto', 'Cerrado') DEFAULT 'Abierto',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertar algunos datos de ejemplo
INSERT INTO tickets (requester_name, department, issue_type, priority, description, status) VALUES
('Juan Pérez', 'Ventas', 'Software', 'Alta', 'El CRM no carga los clientes nuevos', 'Abierto'),
('Ana García', 'Recursos Humanos', 'Hardware', 'Media', 'La impresora del segundo piso no funciona', 'En Progreso'),
('Carlos López', 'Finanzas', 'Red', 'Crítica', 'Sin acceso a internet en toda el área', 'Abierto');
