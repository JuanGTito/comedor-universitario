<?php
require_once __DIR__ . '/../../Models/EstudianteModel.php';
$model = new EstudianteModel();
$estudiantes = $model->obtenerEstudiantes();

require_once __DIR__ . '/../../Config/config.php';

date_default_timezone_set('America/Lima');

function supabaseSelect($endpoint) {
    $url = SUPABASE_URL . $endpoint;
    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => getHeaders(),
    ]);

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode != 200) {
        die("Error HTTP $httpcode al obtener datos: $response");
    }

    return json_decode($response, true);
}

function obtenerEstadoId($nombre) {
    $nombreEncoded = rawurlencode($nombre);
    $estados = supabaseSelect("estado?est_asistencia=eq.$nombreEncoded");

    if (!isset($estados[0]['id'])) {
        die("Estado no encontrado para '$nombre'.");
    }

    return $estados[0]['id'];
}

// Obtener ID del estado "no asistio"
$noAsistioId = obtenerEstadoId('no asistio');

?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../../Assets/css/Admin/estudiante.css">

<div class="dashboard-content active" id="usuarios">
    <div class="section-header">
        <h2 class="section-title">
            <i class="fas fa-users"></i> Gestión de Usuarios
        </h2>
        <div class="action-buttons">
            <button class="btn btn-primary" id="openModalBtn">
                <i class="fas fa-user-plus"></i> Agregar Usuario
            </button>
            <button class="btn btn-secondary">
                <i class="fas fa-file-import"></i> Importar Listado
            </button>
            <button class="btn btn-secondary">
                <i class="fas fa-file-export"></i> Exportar Listado
            </button>
        </div>
    </div>

    
<div class="table-responsive">
    <table id="usersTable" class="display users-table" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>DNI</th>
                <th>Nombre Completo</th>
                <th>Carrera</th>
                <th>Condición</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($estudiantes)): ?>
                <?php foreach ($estudiantes as $est): ?>
                    <?php
                        // Contar faltas (asistencia con estado "no asistio") para el estudiante actual
                        $faltasData = supabaseSelect("asistencia?estudiante_id=eq.{$est['id']}&estado_id=eq.$noAsistioId");
                        $faltas = count($faltasData);

                        // Definir color del botón según número de faltas
                        if ($faltas >= 5) {
                            $btnClass = 'btn-danger';   // rojo
                        } elseif ($faltas >= 2) {
                            $btnClass = 'btn-warning';  // amarillo
                        } else {
                            $btnClass = 'btn-success';  // verde
                        }
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($est['id']) ?></td>
                        <td><?= htmlspecialchars($est['dni']) ?></td>
                        <td><?= htmlspecialchars($est['nombre'] . ' ' . $est['apellido']) ?></td>
                        <td><?= htmlspecialchars($est['escuela_profesional']['carrera'] ?? 'No asignada') ?></td>
                        <td><?= htmlspecialchars($est['condicion_asignacion']['estado'] ?? 'No asignada') ?></td>
                        <td class="user-actions">
                            <button class="btn <?= $btnClass ?> btn-sm" title="Agregar nuevo">
                                <i class="fas fa-plus"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No hay usuarios registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
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
