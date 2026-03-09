# 🎫 Sistema de Tickets de Soporte TI

Un sistema de gestión de tickets simple y eficiente para departamentos de TI, desarrollado en PHP y MySQL. Permite a los empleados reportar problemas y al equipo de TI gestionarlos en tiempo real.

## ✨ Características

*   **Reporte de Problemas**: Formulario intuitivo para que cualquier empleado reporte incidentes.
*   **Clasificación**: Categorización por Departamento, Tipo de Problema y Nivel de Urgencia.
*   **Panel de Administración**: Vista centralizada para el equipo de TI.
*   **Gestión de Estados**: Actualización de tickets (Abierto, En Progreso, Resuelto, Cerrado).
*   **🔔 Notificaciones en Tiempo Real**: Alerta visual y sonora en el panel de admin cuando llega un nuevo ticket.
*   **Diseño Responsivo**: Interfaz limpia basada en Bootstrap 5.

## 🚀 Instalación Rápida

### Requisitos Previos
*   Un servidor web (como XAMPP, WAMP, o MAMP).
*   PHP 7.4 o superior.
*   MySQL.

### Pasos
1.  **Clonar el repositorio** en tu carpeta del servidor (ej. `htdocs`):
    ```bash
    git clone https://github.com/Pancho8000/tickets.git
    ```

2.  **Instalación Automática**:
    Abre tu navegador y ve a:
    `http://localhost/tickets/setup.php`
    *(Esto creará la base de datos y las tablas automáticamente)*.

3.  **¡Listo!**
    *   Para usuarios: `http://localhost/tickets/`
    *   Para administradores: `http://localhost/tickets/admin.php`

## 🛠️ Configuración Manual (Opcional)
Si prefieres hacerlo manualmente o cambiar credenciales:
1.  Importa el archivo `database_setup.sql` en tu gestor de base de datos.
2.  Edita el archivo `db.php` con tus credenciales de MySQL:
    ```php
    $username = 'tu_usuario';
    $password = 'tu_contraseña';
    ```

## 📱 Uso en Red Local
Para usarlo en múltiples computadoras dentro de la misma oficina:
1.  Asegúrate de que el equipo servidor tenga una IP fija.
2.  Desde otros equipos, accede usando la IP del servidor:
    `http://192.168.x.x/tickets/`

## 🤝 Contribuir
¡Las contribuciones son bienvenidas! Si tienes ideas para mejorar el sistema, no dudes en hacer un fork y enviar un pull request.
