<?php
// Datos de ejemplo para los gráficos
$datos_barras = [10, 20, 30, 40, 50];
$labels_barras = ["Enero", "Febrero", "Marzo", "Abril", "Mayo"];

$datos_torta = [30, 40, 20, 10];
$labels_torta = ["Ventas", "Costos", "Beneficios", "Otros"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficos con PHP y Chart.js</title>
    <!-- Incluir Chart.js desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    <style>
        .chart-container {
            width: 50%;
            margin: 0 auto;
            padding-top: 50px;
        }

        canvas {
            width: 100%;
            height: auto;
        }

        @media (max-width: 768px) {
            .chart-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <div class="chart-container">
        <h2>Gráfico de Barras</h2>
        <canvas id="grafico-barras"></canvas>
    </div>

    <div class="chart-container">
        <h2>Gráfico de Torta</h2>
        <canvas id="grafico-torta"></canvas>
    </div>

    <script>
        window.onload = function() {

            var ctx_barras = document.getElementById('grafico-barras').getContext('2d');
            var graficoBarras = new Chart(ctx_barras, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels_barras); ?>,
                    datasets: [{
                        label: 'Ventas Mensuales',
                        data: <?php echo json_encode($datos_barras); ?>,
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
                    labels: <?php echo json_encode($labels_torta); ?>,
                    datasets: [{
                        label: 'Distribución de Costos',
                        data: <?php echo json_encode($datos_torta); ?>,
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
        };
    </script>

</body>
</html>
