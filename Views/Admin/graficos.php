<?php
// Views/Admin/graficos.php

require_once __DIR__ . '/../../Models/EstadisticaModel.php';
require_once __DIR__ . '/../../Models/AsistenciaModel.php';
date_default_timezone_set('America/Lima');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$rol = $_SESSION['usuario']['rol'] ?? 'usuario';

// Resumen de estadísticas
$resumen = EstadisticaModel::resumenHoy();
$total_estudiantes = $resumen['total_becarios'] ?? 0;
$total_asistencias = $resumen['total_asistencias'] ?? 0;
$total_inasistencias = $resumen['total_inasistencias'] ?? 0;
$puntualidad_general = EstadisticaModel::puntualidadGeneral() ?? 0;

// Datos para gráficos
$turno_data = EstadisticaModel::asistenciaPorTurno();
$labels_barras = $turno_data['labels'] ?? [];
$datos_barras = $turno_data['datos'] ?? [];

$carrera_data = EstadisticaModel::asistenciaPorCarrera();
$labels_torta = $carrera_data['labels'] ?? [];
$datos_torta = $carrera_data['datos'] ?? [];

// Reporte por fecha
$fecha_reporte = $_GET['fecha'] ?? date('Y-m-d');
$lista_asistencias = AsistenciaModel::obtenerReporteBecarios($fecha_reporte);

if (!is_array($lista_asistencias)) {
    die("Error al obtener los datos del reporte.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Panel Estadístico</title>

    <link rel="stylesheet" href="../../Assets/css/Admin/graficos.css" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="dashboard-container">

    <!-- Cuadros informativos -->
    <div class="cards-container">
        <div class="card">
            <h3><?= htmlspecialchars($total_asistencias) ?></h3>
            <p>Asistencias (Hoy)</p>
        </div>
        <div class="card">
            <h3><?= htmlspecialchars($total_inasistencias) ?></h3>
            <p>Inasistencias (Hoy)</p>
        </div>
        <div class="card">
            <h3><?= htmlspecialchars($puntualidad_general) ?>%</h3>
            <p>Puntualidad General</p>
        </div>
        <div class="card">
            <h3><?= htmlspecialchars($total_estudiantes) ?></h3>
            <p>Total Becarios</p>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="charts-grid">
        <div class="chart-card">
            <h2>Asistencia por Turno</h2>
            <canvas id="grafico-barras"></canvas>
        </div>
        <div class="chart-card">
            <h2>Asistencias por Carrera</h2>
            <canvas id="grafico-torta"></canvas>
        </div>
    </div>

    <!-- Tabla solo para usuarios -->
    <?php if ($rol === 'usuario'): ?>
        <h2>Lista de Asistencias - <?= htmlspecialchars($fecha_reporte) ?></h2>
        <table id="tabla-asistencias" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Carrera</th>
                    <th>Desayuno</th>
                    <th>Almuerzo</th>
                    <th>Refrigerio</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($lista_asistencias)): ?>
                    <tr><td colspan="7">No se encontraron registros para esta fecha.</td></tr>
                <?php else: ?>
                    <?php include __DIR__ . '/../Layout/table-asistencias.php'; ?>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

<!-- Variables JS con datos PHP para gráficos -->
<script>
    const datosBarras = <?= json_encode($datos_barras); ?>;
    const labelsBarras = <?= json_encode($labels_barras); ?>;
    const datosTorta = <?= json_encode($datos_torta); ?>;
    const labelsTorta = <?= json_encode($labels_torta); ?>;
</script>

<!-- Librerías JS DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Scripts personalizados -->
<script src="../../Assets/js/Admin/graficos.js"></script>

<script>
    $(document).ready(function () {
        const tabla = $('#tabla-asistencias');
        if (tabla.length) {
            if (! $.fn.DataTable.isDataTable('#tabla-asistencias')) {
                tabla.DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: 'Exportar a Excel',
                            titleAttr: 'Exportar tabla a Excel',
                            title: 'Reporte_Asistencias',
                            className: 'btn-excel'
                        }
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                        search: "Buscar:",
                        lengthMenu: "Mostrar _MENU_ registros",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        paginate: {
                            next: "Siguiente",
                            previous: "Anterior"
                        },
                        zeroRecords: "No se encontraron registros"
                    },
                    pageLength: 10,
                    order: [[3, "desc"]]
                });
            }
        }
    });
</script>

</body>
</html>
