<?php
// admin.php
require_once 'db.php';

// Obtener tickets de la base de datos
$query = "SELECT * FROM tickets ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Tickets TI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .badge-status-Abierto { background-color: #dc3545; } /* Rojo */
        .badge-status-En-Progreso { background-color: #ffc107; color: #000; } /* Amarillo */
        .badge-status-Resuelto { background-color: #28a745; } /* Verde */
        .badge-status-Cerrado { background-color: #6c757d; } /* Gris */
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Panel de Control TI</a>
        <span class="navbar-text text-white">
            Bienvenido, Admin
        </span>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Gestión de Tickets</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Solicitante</th>
                                    <th>Depto</th>
                                    <th>Problema</th>
                                    <th>Prioridad</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->rowCount() > 0): ?>
                                    <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                                        <tr>
                                            <td>#<?php echo $row['id']; ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                                            <td><?php echo htmlspecialchars($row['requester_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['department']); ?></td>
                                            <td><?php echo htmlspecialchars($row['issue_type']); ?></td>
                                            <td>
                                                <?php 
                                                $priorityClass = '';
                                                switch($row['priority']) {
                                                    case 'Crítica': $priorityClass = 'bg-danger text-white'; break;
                                                    case 'Alta': $priorityClass = 'bg-warning text-dark'; break;
                                                    case 'Media': $priorityClass = 'bg-info text-dark'; break;
                                                    case 'Baja': $priorityClass = 'bg-success text-white'; break;
                                                }
                                                ?>
                                                <span class="badge <?php echo $priorityClass; ?>"><?php echo $row['priority']; ?></span>
                                            </td>
                                            <td><?php echo htmlspecialchars(substr($row['description'], 0, 50)) . '...'; ?></td>
                                            <td>
                                                <?php 
                                                $statusClass = 'badge-status-' . str_replace(' ', '-', $row['status']);
                                                ?>
                                                <span class="badge <?php echo $statusClass; ?>"><?php echo $row['status']; ?></span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">
                                                    Gestionar
                                                </button>

                                                <!-- Modal para editar estado -->
                                                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Gestionar Ticket #<?php echo $row['id']; ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="update_ticket.php" method="POST">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                    <p><strong>Descripción Completa:</strong></p>
                                                                    <p class="bg-light p-2 border rounded"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                                                                    
                                                                    <?php if (!empty($row['solution_notes'])): ?>
                                                                    <p><strong>Notas de Resolución:</strong></p>
                                                                    <p class="bg-info bg-opacity-10 p-2 border rounded"><?php echo nl2br(htmlspecialchars($row['solution_notes'])); ?></p>
                                                                    <?php endif; ?>
                                                                    
                                                                    <div class="mb-3">
                                                                        <label for="solution_notes" class="form-label">Notas de Resolución / Acciones Tomadas:</label>
                                                                        <textarea class="form-control" name="solution_notes" rows="3" placeholder="Detalla qué se hizo para solucionar el problema..."><?php echo htmlspecialchars($row['solution_notes'] ?? ''); ?></textarea>
                                                                    </div>
                                                                    
                                                                    <div class="mb-3">
                                                                        <label for="status" class="form-label">Cambiar Estado:</label>
                                                                        <select class="form-select" name="status">
                                                                            <option value="Abierto" <?php echo ($row['status'] == 'Abierto') ? 'selected' : ''; ?>>Abierto</option>
                                                                            <option value="En Progreso" <?php echo ($row['status'] == 'En Progreso') ? 'selected' : ''; ?>>En Progreso</option>
                                                                            <option value="Resuelto" <?php echo ($row['status'] == 'Resuelto') ? 'selected' : ''; ?>>Resuelto</option>
                                                                            <option value="Cerrado" <?php echo ($row['status'] == 'Cerrado') ? 'selected' : ''; ?>>Cerrado</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No hay tickets registrados.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Sistema de Notificaciones en Tiempo Real
    let lastKnownTicketId = 0;
    
    // Obtener el ID inicial al cargar la página
    fetch('check_latest_ticket.php')
        .then(response => response.json())
        .then(data => {
            lastKnownTicketId = parseInt(data.last_id);
            console.log("ID Inicial: " + lastKnownTicketId);
        });

    // Solicitar permiso para notificaciones
    if (Notification.permission !== "granted") {
        Notification.requestPermission();
    }

    // Función para revisar nuevos tickets cada 10 segundos
    setInterval(checkForNewTickets, 10000);

    function checkForNewTickets() {
        fetch('check_latest_ticket.php')
            .then(response => response.json())
            .then(data => {
                const currentId = parseInt(data.last_id);
                
                if (currentId > lastKnownTicketId) {
                    // ¡Hay un nuevo ticket!
                    showNotification(currentId);
                    lastKnownTicketId = currentId;
                    
                    // Opcional: Recargar la página automáticamente
                    // location.reload(); 
                }
            })
            .catch(error => console.error('Error verificando tickets:', error));
    }

    function showNotification(ticketId) {
        if (Notification.permission === "granted") {
            const notification = new Notification("¡Nuevo Ticket Recibido!", {
                body: "Se ha registrado el ticket #" + ticketId + ". Revisa el panel.",
                icon: "https://cdn-icons-png.flaticon.com/512/1067/1067566.png" // Icono genérico de ticket
            });
            
            notification.onclick = function() {
                window.focus();
                location.reload(); // Recargar para ver el nuevo ticket
            };
            
            // Reproducir sonido de notificación (opcional)
            const audio = new Audio('https://actions.google.com/sounds/v1/alarms/beep_short.ogg');
            audio.play().catch(e => console.log("Audio bloqueado por el navegador"));
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
