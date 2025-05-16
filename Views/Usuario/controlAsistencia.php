<?php
// Usuario/controlAsistencia.php

// Este archivo solo devuelve el contenido para insertar dinámicamente
// No debe tener <html> ni <body>, solo fragmento HTML

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['busqueda'])) {
    // Aquí puedes requerir el modelo si quieres manejar la búsqueda aquí (opcional)
    // Pero para evitar problemas con rutas, lo manejamos solo en carnet_estudiante.php

    // Si quieres validar el valor:
    $busqueda = trim($_POST['busqueda']);
    if ($busqueda === '') {
        echo "<p style='color:red;'>Debe ingresar un DNI o código válido.</p>";
        exit;
    }
    // Si quieres, podrías enviar aquí algo, pero en esta estructura
    // la búsqueda real la hacemos desde JS hacia carnet_estudiante.php
    exit;
}
?>

<!-- FORMULARIO DE BÚSQUEDA -->
<h2>Registro de Asistencia</h2>
<form id="formBusquedaCarnet" style="margin-bottom:20px;">
    <input type="text" id="busquedaCarnet" placeholder="DNI o Código" required />
    <button type="submit">Buscar</button>
</form>

<!-- MODAL OCULTO PARA MOSTRAR DATOS DEL ESTUDIANTE -->
<div id="modalCarnet" class="modal" style="
    display:none; 
    position:fixed; 
    top:0; left:0; width:100%; height:100%; 
    background: rgba(0,0,0,0.5); 
    z-index: 2000;
">
    <div style="
        background:#fff; 
        margin:10% auto; 
        padding:20px; 
        width:400px; 
        border-radius:5px; 
        position:relative;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    ">
        <span onclick="cerrarModalCarnet()" style="
            position:absolute; 
            top:10px; right:15px; 
            cursor:pointer; 
            font-size:20px;
            font-weight:bold;
        ">&times;</span>
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

// Cerrar modal si se hace click fuera del contenido
window.addEventListener('click', function(event) {
    const modal = document.getElementById('modalCarnet');
    if (event.target === modal) {
        cerrarModalCarnet();
    }
});
</script>
