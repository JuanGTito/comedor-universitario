<?php
session_start();

// Validar sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: ../Views/Login/login.php');
    exit();
}

// Obtener rol (por defecto 'usuario' si no existe)
$rol = $_SESSION['user_rol'] ?? 'usuario';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard General</title>
    <link rel="stylesheet" href="../Assets/css/dashboard.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<?php include 'Layout/sidebar.php'; ?>

<div class="main-content">
    <div class="content">
        <iframe id="iframeContent" src=""></iframe>
    </div>
</div>


<script>
    const userRole = '<?php echo $rol; ?>';

    // Función para cargar páginas completas en iframe
    function loadPageComplete(url) {
        document.getElementById('iframeContent').src = url;
    }
    // Cerrar modal si se hace click fuera del contenido
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Carga contenido inicial según rol usando iframe
        if (userRole === 'admin') {
            loadPageComplete('Admin/graficos.php');
        } else {
            loadPageComplete('Usuario/controlAsistencia.php');
        }
    });

    document.querySelectorAll('.nav-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const page = btn.getAttribute('data-page');
        if (page) {
            loadPageComplete(page);
            // Opcional: estilos para botón activo
            document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            }
        });
    });
    
</script>

</body>
</html>
