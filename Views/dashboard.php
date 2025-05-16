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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

<?php include 'Layout/sidebar.php'; ?>

<div class="main-content">
    <div class="header" style="position:relative;">
        <div class="user-menu" style="position:relative; cursor:pointer;">
            <i class="fas fa-user" id="userIcon"></i>
            <div class="dropdown" id="userDropdown">
                <ul>
                    <li onclick="abrirModal('modalPerfil')">Perfil</li>
                    <li onclick="abrirModal('modalUsuarios')">Usuario</li>
                    <li onclick="logout()">Cerrar sesión</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="main-content" class="content">
        <iframe id="iframeContent" src="" style="width:100%; height:600px; border:none;"></iframe>
    </div>
</div>

<script>
    const userRole = '<?php echo $rol; ?>';

    // Función para cargar páginas completas en iframe
    function loadPageComplete(url) {
        document.getElementById('iframeContent').src = url;
    }

    // Abrir modal
    function abrirModal(id) {
        const modal = document.getElementById(id);
        if (!modal) {
            console.error('Modal no encontrado:', id);
            return;
        }
        modal.style.display = 'block';
    }

    // Cerrar modal
    function cerrarModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Cerrar modal si se hace click fuera del contenido
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });

    // Logout
    function logout() {
        fetch('../Models/logout.php')
            .then(() => {
                window.location.href = '../Views/Login/login.php';
            })
            .catch(() => {
                alert('Error al cerrar sesión.');
            });
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Carga contenido inicial según rol usando iframe
        if (userRole === 'admin') {
            loadPageComplete('admin_graficos.php');
        } else {
            loadPageComplete('Usuario/controlAsistencia.php');
        }

        // Dropdown menú usuario
        const userIcon = document.getElementById('userIcon');
        const dropdown = document.getElementById('userDropdown');

        userIcon.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function () {
            dropdown.style.display = 'none';
        });
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
