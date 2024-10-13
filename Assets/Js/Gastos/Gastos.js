// Esperar a que el contenido del DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    // Función para obtener los datos de gastos desde la API
    function getGastosData(callback) {
        $.ajax({
            url: 'http://localhost/ProyectoGestorFinanzas/rutas/RutaGastos/RutaGastos.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('Datos recibidos:', data);
                if (data.success) {
                    callback(data.data); // Cambiado para usar data.data
                } else {
                    console.error(data.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching data:', textStatus, errorThrown);
            }
        });
    }

    // Función para procesar los datos de gastos
    function procesarDatosGastos(gastosData) {
        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        const gastosPorMes = Array(12).fill(0);
        const gastosPorDia = Array(31).fill(0);
        const gastosAcumulados = [];
        let acumulado = 0;

        // Sumar los gastos por mes y por día
        gastosData.forEach(item => {
            const fecha = new Date(item.fecha);
            const mesIndex = fecha.getMonth();
            const dia = fecha.getDate() - 1;

            gastosPorMes[mesIndex] += parseFloat(item.monto);
            gastosPorDia[dia] += parseFloat(item.monto);
        });

        // Calcular los gastos acumulados
        gastosPorMes.forEach(gasto => {
            acumulado += gasto;
            gastosAcumulados.push(acumulado);
        });

        return { meses, gastosPorMes, gastosPorDia, gastosAcumulados };
    }

    // Obtener los datos y generar los gráficos
    getGastosData(function(gastosData) {
        const { meses, gastosPorMes, gastosPorDia, gastosAcumulados } = procesarDatosGastos(gastosData);

        // Gráfico de Gastos Diarios
        const dailyGastosChartOptions = {
            series: [{ name: 'Gastos', data: gastosPorDia }],
            chart: { type: 'bar', height: 350 },
            plotOptions: {
                bar: { horizontal: false, columnWidth: '55%', endingShape: 'rounded' }
            },
            xaxis: { categories: Array.from({ length: 31 }, (_, i) => (i + 1).toString()) },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "$ " + val.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + " COP";
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#dailyGastosChart"), dailyGastosChartOptions).render();

        // Gráfico de Gastos Mensuales
        const monthlyGastosChartOptions = {
            series: [{ name: 'Gastos', data: gastosPorMes }],
            chart: { type: 'bar', height: 350 },
            xaxis: { categories: meses },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "$ " + val.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + " COP";
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#monthlyGastosChart"), monthlyGastosChartOptions).render();

        // Gráfico de Gastos Acumulados
        const totalGastosLineChart = new Chart(document.getElementById('totalGastosLineChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Gastos Acumulados',
                    data: gastosAcumulados,
                    fill: false,
                    borderColor: '#ff5733',
                    tension: 0.1
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } }
            }
        });

        // Predicción de Gastos para el próximo mes
        const prediccionProximoMes = gastosAcumulados[gastosAcumulados.length - 1] + (gastosPorMes[gastosPorMes.length - 1] * 0.05);
        const prediccionGastosOptions = {
            series: [{ name: 'Predicción de Gastos', data: [...gastosAcumulados.slice(-3), prediccionProximoMes] }],
            chart: { type: 'line', height: 350 },
            xaxis: { categories: ['Agosto', 'Septiembre', 'Octubre', 'Próximo Mes'] },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "$ " + val.toFixed(2) + " COP";
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#gastosPredictionChart"), prediccionGastosOptions).render();
    });
});