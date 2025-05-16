<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicia sesión si aún no está iniciada
}

// Obtener rol del usuario de la sesión
$rol = $_SESSION['usuario']['rol'] ?? 'usuario';
?>

<div class="sidebar">
    <h2>Comedor Universitario</h2>
    <ul>
        <?php if ($rol === 'admin'): ?>
            <li class="nav-btn" data-page="Admin/admin_graficos.php">Dashboard</li>
            <li class="nav-btn" data-page="Admin/estudiantes.php">Estudiantes</li>
            <li class="nav-btn" data-page="Admin/reportes.php">Reportes</li>
        <?php else: ?>
            <li class="nav-btn" data-page="Usuario/controlAsistencia.php">Dashboard</li>
            <li class="nav-btn" data-page="Admin/reportes.php">Reportes</li>
        <?php endif; ?>
    </ul>
</div>
