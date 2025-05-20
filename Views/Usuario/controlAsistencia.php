<?php
// Usuario/controlAsistencia.php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['busqueda'])) {
    $busqueda = trim($_POST['busqueda']);
    if ($busqueda === '') {
        echo "<p class='error'>Debe ingresar un DNI o código válido.</p>";
        exit;
    }
    exit;
}
?>

<link rel="stylesheet" href="../../Assets/css/controlAsistencia.css"/>
<!-- FORMULARIO DE BÚSQUEDA -->
<div class="asistencia-container">
    <h2>Registro de Asistencia</h2>
    <form id="formBusquedaCarnet" class="form-busqueda">
        <input type="text" id="busquedaCarnet" placeholder="DNI o Código" required />
        <button type="submit">Buscar</button>
    </form>
</div>

<!-- MODAL DE RESULTADOS -->
<div id="modalCarnet" class="modal-carnet">
    <div class="modal-carnet-content">
        <span class="modal-close" onclick="cerrarModalCarnet()">&times;</span>
        <div id="contenidoCarnet">
            <!-- Aquí se cargan los datos del estudiante -->
        </div>
    </div>
</div>

<script>
document.getElementById('formBusquedaCarnet').addEventListener('submit', function(e) {
    e.preventDefault();

    let busqueda = document.getElementById('busquedaCarnet').value.trim();
    if (busqueda === '') {
        alert('Ingrese DNI o Código');
        return;
    }

    fetch('../Modals/carnet_estudiante.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'busqueda=' + encodeURIComponent(busqueda)
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById('contenidoCarnet').innerHTML = data;
        document.getElementById('modalCarnet').style.display = 'block';
    })
    .catch(err => {
        alert('Error al buscar estudiante');
        console.error(err);
    });
});

function cerrarModalCarnet() {
    document.getElementById('modalCarnet').style.display = 'none';
    document.getElementById('contenidoCarnet').innerHTML = '';
}

window.addEventListener('click', function(event) {
    const modal = document.getElementById('modalCarnet');
    if (event.target === modal) {
        cerrarModalCarnet();
    }
});
</script>
