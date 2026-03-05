<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Tickets TI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Nuevo Ticket de Soporte</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success">Ticket registrado exitosamente.</div>
                    <?php endif; ?>
                    
                    <form action="save_ticket.php" method="POST">
                        <div class="mb-3">
                            <label for="requester_name" class="form-label">Nombre del Solicitante</label>
                            <input type="text" class="form-control" id="requester_name" name="requester_name" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="department" class="form-label">Departamento</label>
                                <select class="form-select" id="department" name="department" required>
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="Ventas">Ventas</option>
                                    <option value="Recursos Humanos">Recursos Humanos</option>
                                    <option value="Finanzas">Finanzas</option>
                                    <option value="Operaciones">Operaciones</option>
                                    <option value="Dirección">Dirección</option>
                                    <option value="Marketing">Marketing</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="issue_type" class="form-label">Tipo de Problema</label>
                                <select class="form-select" id="issue_type" name="issue_type" required>
                                    <option value="" selected disabled>Seleccione...</option>
                                    <option value="Hardware">Hardware (Equipo físico)</option>
                                    <option value="Software">Software (Programas)</option>
                                    <option value="Red">Red / Internet</option>
                                    <option value="Acceso">Cuentas / Contraseñas</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="priority" class="form-label">Nivel de Urgencia</label>
                            <select class="form-select" id="priority" name="priority" required>
                                <option value="Baja">Baja (Puede esperar)</option>
                                <option value="Media" selected>Media (Afecta trabajo parcial)</option>
                                <option value="Alta">Alta (Afecta trabajo crítico)</option>
                                <option value="Crítica">Crítica (Sistema caído / Bloqueo total)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción del Problema</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Describa el problema con el mayor detalle posible..."></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Enviar Ticket</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-muted text-center">
                    <a href="admin.php">Acceso Administrativo (TI)</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
