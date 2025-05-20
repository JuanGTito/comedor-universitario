<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$rol = $_SESSION['usuario']['rol'] ?? 'usuario';
?>

<div class="sidebar">
    <h2 style="text-align: center; margin-bottom: 20px;">Comedor Universitario pe</h2>
    <ul class="sidebar-menu">
        <?php if ($rol === 'admin'): ?>
            <li><a href="#" class="nav-btn" data-page="Admin/graficos.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="#" class="nav-btn" data-page="Admin/estudiantes.php"><i class="fas fa-user-graduate"></i> Estudiantes</a></li>
            <li><a href="#" class="nav-btn" data-page="Admin/reportes.php"><i class="fas fa-chart-bar"></i> Reportes</a></li>
        <?php else: ?>
            <li><a href="#" class="nav-btn" data-page="Usuario/controlAsistencia.php"><i class="fas fa-clipboard-check"></i> Control Asistencia</a></li>
            <li><a href="#" class="nav-btn" data-page="Admin/reportes.php"><i class="fas fa-chart-bar"></i> Reportes</a></li>
        <?php endif; ?>
        <li><a href="../Models/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
    </ul>
</div>
