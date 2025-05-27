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
        <iframe id="iframeContent" src="" style="width: 100%; height: 100vh; border: none;"></iframe>
    </div>
</div>

<!-- Precarga oculta de Estudiantes -->
<iframe id="preloadEstudiantes" src="Admin/estudiantes.php" style="display:none;"></iframe>

<script>
    const userRole = '<?php echo $rol; ?>';

    function loadPageComplete(url) {
        document.getElementById('iframeContent').src = url;
    }

    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Precargar vista de estudiantes para que esté lista cuando se necesite
        const preloadIframe = document.getElementById('preloadEstudiantes');

        // Cargar página inicial en el iframe principal
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

                // Estilo activo
                document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            }
        });
    });
</script>

</body>
</html>
