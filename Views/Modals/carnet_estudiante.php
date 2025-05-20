<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../../Models/estudianteModel.php';

    $busqueda = trim($_POST['busqueda']);
    $modelo = new EstudianteModel();
    $result = $modelo->buscarPorDniOCodigo($busqueda);

    if ($result && count($result) > 0) {
        $e = $result[0];
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

        <div class='carnet'>
            <div class='foto'>
                <img src="<?= htmlspecialchars($e['url_foto']) ?>" alt='Foto'>
            </div>
            <div class='info'>
                <p><strong>DNI:</strong> <?= htmlspecialchars($e['dni']) ?></p>
                <p><strong>Nombre:</strong> <?= htmlspecialchars($e['nombre']) ?> <?= htmlspecialchars($e['apellido']) ?></p>
                <p><strong>Carrera:</strong> <?= htmlspecialchars($e['escuela_profesional']['carrera'] ?? 'No asignada') ?></p>
                <p><strong>Becario:</strong> <?= htmlspecialchars($e['condicion_asignacion']['estado'] ?? 'No asignado') ?></p>
                <p class='success'>✔ Puede ingresar</p>

                <form method='POST' action='../../Models/register_est.php'>
                    <input type='hidden' name='id_estudiante' value='<?= htmlspecialchars($e['id']) ?>'>
                    <button type='submit'>Registrar Asistencia</button>
                </form>
            </div>
        </div>
        <?php
    } else {
        echo "<p style='color:red; text-align:center;'>Estudiante no encontrado.</p>";
    }
}
?>
