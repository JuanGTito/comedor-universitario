<?php
// Views/Admin/reportes.php

require_once __DIR__ . '/../../models/asistenciaModel.php';
date_default_timezone_set('America/Lima');

$fecha_reporte = $_GET['fecha'] ?? date('Y-m-d');
$lista_asistencias = AsistenciaModel::obtenerReporteBecarios($fecha_reporte);

if (is_null($lista_asistencias)) {
    die("Error al obtener los datos del reporte.");
}

// Función para generar CSV y enviarlo al navegador (si se pide descarga)
if (isset($_GET['descargar']) && $_GET['descargar'] == 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=reporte_asistencias_' . $fecha_reporte . '.csv');

    $output = fopen('php://output', 'w');
    // Encabezados CSV
    fputcsv($output, ['DNI', 'Nombre', 'Apellido', 'Carrera', 'Desayuno', 'Almuerzo', 'Refrigerio']);

    foreach ($lista_asistencias as $fila) {
        fputcsv($output, [
            $fila['dni'],
            $fila['nombre'],
            $fila['apellido'],
            $fila['carrera'],
            $fila['desayuno'],
            $fila['almuerzo'],
            $fila['refrigerio']
        ]);
    }

    fclose($output);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Reporte de Asistencias - <?= htmlspecialchars($fecha_reporte) ?></title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #052795; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .controls {
    margin-bottom: 20px;
    display: flex;
    justify-content: flex-start; /* alinea a la izquierda */
    align-items: center;
    gap: 10px; /* espacio entre elementos */
    max-width: 500px;
    flex-wrap: wrap;
}

.controls form {
    display: flex;
    align-items: center;
    gap: 10px;
}

.controls label {
    font-weight: 600;
}

.controls input[type="date"] {
    padding: 6px 10px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    transition: border-color 0.3s ease;
}

.controls input[type="date"]:focus {
    outline: none;
    border-color: #052795;
}

.controls button[type="submit"] {
    background-color: #052795;
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.controls button[type="submit"]:hover {
    background-color: #052795;
}

.btn-download {
    background-color: #28a745;
    color: white;
    padding: 8px 15px;
    text-decoration: none;
    border-radius: 4px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
    border: none;
}

.btn-download:hover {
    background-color: #218838;
}
    </style>
</head>
<body>
    <h1>Reporte de Asistencias - Becarios</h1>

    <div class="controls">
        <!-- Selector de fecha -->
        <form method="GET" action="">
            <label for="fecha">Seleccionar fecha: </label>
            <input type="date" id="fecha" name="fecha" value="<?= htmlspecialchars($fecha_reporte) ?>" max="<?= date('Y-m-d') ?>">
            <button type="submit">Cargar</button>
        </form>

        <!-- Botón para descargar CSV -->
        <a 
            href="?fecha=<?= urlencode($fecha_reporte) ?>&descargar=csv" 
            class="btn-download"
            title="Descargar reporte CSV"
        >
            Descargar CSV
        </a>
    </div>

    <table id="tabla-asistencias">
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
            <?php if (count($lista_asistencias) === 0): ?>
                <tr><td colspan="7">No se encontraron registros para esta fecha.</td></tr>
            <?php else: ?>
                <?php include __DIR__ . '/../Layout/table-asistencias.php'; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#tabla-asistencias').DataTable({
            searching: false,
            language: {
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                paginate: {
                    next: "Siguiente",
                    previous: "Anterior"
                },
                zeroRecords: "No se encontraron registros",
            },
            pageLength: 10,
            order: [[3, "asc"]]
        });
    });
    </script>
</body>
</html>
