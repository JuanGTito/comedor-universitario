<?php
// Usuario/controlAsistencia.php
require_once __DIR__ . '/../../Models/asistenciaModel.php';
$horarioModel = new AsistenciaModel();
$turnoActual = $horarioModel->obtenerTurnoActual();
?>

<link rel="stylesheet" href="../../Assets/css/controlAsistencia.css"/>

<div class="asistencia-container">
    <h2>Registro de Asistencia</h2>
    <p style="font-size:18px; color:#444;">
    Turno actual: <strong><?= $turnoActual ?? 'Fuera del horario registrado' ?></strong>
    </p>
    <form id="formBusquedaCarnet" class="form-busqueda">
        <input type="text" id="busquedaCarnet" name="busqueda" placeholder="DNI o Código" required />
        <button type="submit" id="btnBuscar">Buscar</button>
    </form>
</div>

<div id="modalCarnet" class="modal-carnet" style="display:none;">
    <div class="modal-carnet-content">
        <span class="modal-close" onclick="cerrarModalCarnet()">&times;</span>
        <div id="contenidoCarnet">
            <!-- Aquí se cargan los datos del estudiante -->
        </div>
    </div>
</div>

<script src="../../Assets/js/Usuario/control_asistencia.js"></script>
