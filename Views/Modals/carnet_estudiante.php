<?php
// Modals/carnet_estudiante.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../../Models/estudianteModel.php';
    require_once __DIR__ . '/../../Models/asistenciaModel.php';

    $modelTurno = new AsistenciaModel();
    $turnoActual = $modelTurno->obtenerTurnoActual();

    $busqueda = trim($_POST['busqueda']);
    $modelo = new EstudianteModel();
    $result = $modelo->buscarPorDniOCodigo($busqueda);

    if ($result && count($result) > 0) {
        $e = $result[0];

        $condicion = strtolower($e['condicion'] ?? '');
        $esBecario = $condicion === 'becario';
        $esLibre = $turnoActual && strpos($turnoActual, '(libre)') !== false;
        $puedeRegistrar = $esBecario || (!$esBecario && $esLibre);
        ?>
        <style>
            .carnet {
                display: flex;
                align-items: center;
                border: 1px solid #ccc;
                border-radius: 8px;
                padding: 20px;
                max-width: 900px;
                margin: 20px auto;
                background-color: #f8f9fa;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                font-family: Arial, sans-serif;
            }
            .foto img {
                width: 180px;
                height: 200px;
                object-fit: cover;
                border-radius: 6px;
                border: 2px solid black;
            }
            .foto {
                margin-right: 20px;
            }
            .info p {
                margin: 8px 0;
                font-size: 20px;
                color: #333;
            }
            .info strong {
                color: #000;
            }
            .info form {
                margin-top: 15px;
            }
            .info button {
                background-color: #007bff;
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 14px;
            }
            .info button:hover {
                background-color: #0056b3;
            }
            .info .success {
                color: green;
                font-weight: bold;
            }
        </style>

        <div class="carnet">
            <div class="foto">
                <img src="<?php echo htmlspecialchars($e['url_foto']); ?>" alt="Foto">
            </div>
            <div class="info">
                <p><strong>DNI:</strong> <?php echo htmlspecialchars($e['dni']); ?></p>
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($e['nombre']); ?> <?php echo htmlspecialchars($e['apellido']); ?></p>
                <p><strong>Carrera:</strong> <?php echo htmlspecialchars($e['carrera'] ?? 'No asignada'); ?></p>
                <p><strong>Becario:</strong> <?php echo htmlspecialchars($e['condicion'] ?? 'No asignado'); ?></p>

                <?php if ($puedeRegistrar): ?>
                    <p class="success">✔ Puede ingresar</p>
                    <form method="POST" action="../../Models/register_est.php">
                        <input type="hidden" name="id_estudiante" value="<?php echo htmlspecialchars($e['id']); ?>">
                        <button type="submit">Registrar Asistencia</button>
                    </form>
                <?php else: ?>
                    <p style="color:red; font-weight:bold;">✖ No puede registrar asistencia en este momento</p>
                <?php endif; ?>
            </div>
        </div>
        <?php
    } else {
        echo '<p style="color:red; text-align:center;">Estudiante no encontrado.</p>';
    }
}
?>
