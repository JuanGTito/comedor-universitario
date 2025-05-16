<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../../Models/estudianteModel.php';

    $busqueda = trim($_POST['busqueda']);
    $modelo = new EstudianteModel();
    $result = $modelo->buscarPorDniOCodigo($busqueda);

    if ($result && count($result) > 0) {
        $e = $result[0];
        ?>
        <div class='carnet'>
            <div class='foto'><img src="<?= htmlspecialchars($e['url_foto']) ?>" alt='Foto'></div>
            <div class='info'>
                <p><strong>DNI:</strong> <?= htmlspecialchars($e['dni']) ?></p>
                <p><strong>Nombre:</strong> <?= htmlspecialchars($e['nombre']) ?> <?= htmlspecialchars($e['apellido']) ?></p>
                <p><strong>Carrera:</strong> <?= htmlspecialchars($e['escuela_profesional']['carrera']) ?></p>
                <p><strong>Becario:</strong> <?= htmlspecialchars($e['condicion_asignacion']['estado']) ?></p>
                <p style='color: green;'><strong>✔ Puede ingresar</strong></p>

                <form method='POST' action='registrar.php'>
                    <input type='hidden' name='id_estudiante' value='<?= htmlspecialchars($e['id']) ?>'>
                    <button type='submit'>Registrar Asistencia</button>
                </form>
            </div>
        </div>
        <?php
    } else {
        echo "<p style='color:red;'>Estudiante no encontrado.</p>";
    }
}
?>
