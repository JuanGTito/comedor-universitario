<?php
require_once __DIR__ . '/../../Models/EstudianteModel.php';

$model = new EstudianteModel();
$estudiantes = $model->obtenerEstudiantes();
?>

<link rel="stylesheet" href="/comedor-universitario/Assets/css/admin/estudiante.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

<div class="content">
    <div class="options">
        <button class="btn-importar">Importar</button>
        <button class="btn-exportar">Exportar</button>
        <button class="btn-agregar">Agregar Estudiante</button>
    </div>
    <br>

    <table class="student-table display" style="width:100%">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nombre Completo</th>
                <th>Carrera</th>
                <th>Condición</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($estudiantes)): ?>
                <?php foreach ($estudiantes as $est): ?>
                    <tr>
                        <td><?= htmlspecialchars($est['dni']) ?></td>
                        <td><?= htmlspecialchars($est['nombre'] . ' ' . $est['apellido']) ?></td>
                        <td><?= htmlspecialchars($est['escuela_profesional']['carrera'] ?? 'No asignada') ?></td>
                        <td><?= htmlspecialchars($est['condicion_asignacion']['estado'] ?? 'No asignada') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">No hay estudiantes registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('.student-table').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            language: {
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros por página",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                paginate: {
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }
        });
    });
</script>
