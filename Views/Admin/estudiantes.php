<?php
require_once __DIR__ . '/../../Models/EstudianteModel.php';
date_default_timezone_set('America/Lima');

$model = new EstudianteModel();
$estudiantes = $model->obtenerEstudiantes();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="../../Assets/css/Admin/estudiante.css">
<div class="dashboard-estudiantes">
    <div class="dashboard-content active" id="usuarios">
        <div class="section-header">
            <h2><i class="fas fa-users"></i> Gestión de Usuarios</h2>
            <div class="action-buttons">
                <button class="btn btn-primary" id="openModalBtn"><i class="fas fa-user-plus"></i> Agregar Usuario</button>
                <button class="btn btn-secondary"><i class="fas fa-file-import"></i> Importar</button>
                <button class="btn btn-secondary"><i class="fas fa-file-export"></i> Exportar</button>
            </div>
        </div>
    
        <div class="table-responsive">
            <table id="usersTable" class="display users-table" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>DNI</th>
                        <th>Nombre Completo</th>
                        <th>Carrera</th>
                        <th>Condición</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($estudiantes)): ?>
                        <?php include __DIR__ . '/../Layout/table-estudiantes.php'; ?>
                    <?php else: ?>
                        <tr><td colspan="6">No hay usuarios registrados.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="modalCarnet" class="modal" style="display:none;">
        <div class="modal-content" style="
            background:#fff;
            padding:20px;
            border-radius:8px;
            max-width: 900px;
            margin: 50px auto;
            position: relative;
        ">
            <span id="closeModal" style="
                position:absolute;
                top:10px;
                right:15px;
                font-size: 28px;
                font-weight:bold;
                cursor:pointer;
            ">&times;</span>
            <div id="contenidoCarnet">
                <!-- Aquí se carga el carnet -->
            </div>
        </div>
    </div>
</div>
<style>
.modal {
    position: fixed;
    z-index: 1000;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.5);
    overflow: auto;
}
</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="../../Assets/js/Admin/estudiantes.js"></script>
