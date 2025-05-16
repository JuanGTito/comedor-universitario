<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo</title>
    <link rel="stylesheet" href="/comedor-universitario/Assets/css/admin/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
</head>
<body>

    <div class="sidebar">
        <h2>Comedor Universitario</h2>
        <ul>
            <li class="nav-btn active" data-page="graficos.php">Dashboard</li>
            <li class="nav-btn" data-page="estudiantes.php">Estudiantes</li>
            <li class="nav-btn" data-page="reportes.php">Reportes</li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <div></div>
            <div class="user-menu">
                <i class="fas fa-user"></i>
                <div class="dropdown">
                    <ul>
                        <li>Perfil</li>
                        <li>Cerrar sesión</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="main-content" class="content">
            <!-- Aquí se cargará el contenido dinámico -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userIcon = document.querySelector('.user-menu .fas');
            const dropdown = document.querySelector('.user-menu .dropdown');

            userIcon.addEventListener('click', function () {
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', function (e) {
                if (!userIcon.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });

            const navButtons = document.querySelectorAll('.nav-btn');
            navButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const page = btn.getAttribute('data-page');
                    loadContent(page);

                    navButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                });
            });

            loadContent('graficos.php');
        });

        function loadContent(page) {
            fetch(page)
                .then(res => res.text())
                .then(data => {
                    document.getElementById('main-content').innerHTML = data;

                    if (page === 'graficos.php') {
                        createCharts();
                    }
                })
                .catch(err => {
                    document.getElementById('main-content').innerHTML = `<p style="color:red;">Error al cargar la página: ${page}</p>`;
                });
        }

        function createCharts() {

            var ctx_barras = document.getElementById('grafico-barras').getContext('2d');
            var graficoBarras = new Chart(ctx_barras, {
                type: 'bar',
                data: {
                    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo"],
                    datasets: [{
                        label: 'Ventas Mensuales',
                        data: [10, 20, 30, 40, 50],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });


            var ctx_torta = document.getElementById('grafico-torta').getContext('2d');
            var graficoTorta = new Chart(ctx_torta, {
                type: 'pie',
                data: {
                    labels: ["Ventas", "Costos", "Beneficios", "Otros"],
                    datasets: [{
                        label: 'Distribución de Costos',
                        data: [30, 40, 20, 10],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });
        }
    </script>

</body>
</html>
