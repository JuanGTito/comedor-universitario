<?php
// Modals/info-est.php
require_once __DIR__ . '/../../Models/estudianteModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id'] ?? '');
    if (!$id) {
        echo "<p style='color:red; text-align:center;'>ID inválido.</p>";
        exit;
    }

    $modelo = new EstudianteModel();
    $todos = $modelo->obtenerEstudiantes();

    // Buscar estudiante por ID
    $e = null;
    foreach ($todos as $est) {
        if ($est['id'] == $id) {
            $e = $est;
            break;
        }
    }

    if ($e) {
?>
<style>
    .carnet {
        display: flex;
        align-items: center;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 20px;
        max-width: 900px;
        background-color: #f8f9fa;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
        margin: 0 auto;
    }
    .foto img {
        width: 180px;
        height: 200px;
        object-fit: cover;
        border-radius: 6px;
        border: 2px solid black;
    }
    .foto {
        margin-right: 30px;
    }
    .info p {
        margin: 6px 0;
        font-size: 18px;
        color: #333;
    }
    .info strong {
        color: #000;
    }
    .info .success {
        color: green;
        font-weight: bold;
    }
</style>

<div class='carnet'>
    <div class='foto'>
        <img src="<?= htmlspecialchars($e['url_foto']) ?>" alt='Foto del estudiante'>
    </div>
    <div class='info'>
        <p><strong>DNI:</strong> <?= htmlspecialchars($e['dni']) ?></p>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($e['nombre']) ?> <?= htmlspecialchars($e['apellido']) ?></p>
        <p><strong>Carrera:</strong> <?= htmlspecialchars($e['carrera'] ?? 'No asignada') ?></p>
        <p><strong>Becario:</strong> <?= htmlspecialchars($e['condicion'] ?? 'No asignado') ?></p>
        <p><strong>Total Asistencias:</strong> <?= (int)($e['total_asistencias'] ?? 0) ?></p>
        <p><strong>Total Tardanzas:</strong> <?= (int)($e['total_tardanzas'] ?? 0) ?></p>
        <p><strong>Total Faltas:</strong> <?= (int)($e['total_faltas'] ?? 0) ?></p>
    </div>
</div>
<?php
    } else {
        echo "<p style='color:red; text-align:center;'>Estudiante no encontrado.</p>";
    }
}
?>
