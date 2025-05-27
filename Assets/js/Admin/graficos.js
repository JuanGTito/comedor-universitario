window.onload = function () {
    // Gráfico de barras
    const ctxBarras = document.getElementById('grafico-barras');
    if (ctxBarras && Array.isArray(labelsBarras) && Array.isArray(datosBarras)) {
        new Chart(ctxBarras.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labelsBarras,
                datasets: [{
                    label: 'Asistencias por Turno',
                    data: datosBarras,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        title: {
                            display: true,
                            text: 'Cantidad'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Turnos'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    title: {
                        display: false
                    }
                }
            }
        });
    }

    // Gráfico de torta
    const ctxTorta = document.getElementById('grafico-torta');
    if (ctxTorta && Array.isArray(labelsTorta) && Array.isArray(datosTorta)) {
        new Chart(ctxTorta.getContext('2d'), {
            type: 'pie',
            data: {
                labels: labelsTorta,
                datasets: [{
                    data: datosTorta,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    title: {
                        display: false
                    }
                }
            }
        });
    }
};
