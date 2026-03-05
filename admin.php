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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
