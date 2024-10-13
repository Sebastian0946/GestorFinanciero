document.addEventListener('DOMContentLoaded', function () {
    // Función para obtener los datos de ingresos desde la ruta especificada
    function getIngresosData(callback) {
        $.ajax({
            url: 'http://localhost/ProyectoGestorFinanzas/Rutas/RutaIngresos/RutaIngresos.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    callback(response.data); // Llamar a la función callback con los datos recibidos
                } else {
                    console.error('No se encontraron ingresos:', response.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error fetching data:', textStatus, errorThrown);
            }
        });
    }

    // Función para formatear los datos para los gráficos
    function procesarDatosIngresos(ingresosData) {
        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        const ingresosPorMes = Array(12).fill(0);
        const ingresosPorDia = Array(31).fill(0);
        const descripcionesPorDia = Array(31).fill('');
        const ingresosAcumulados = [];
        let acumulado = 0;

        // Procesar los datos de la API
        ingresosData.forEach(item => {
            const fecha = new Date(item.fecha);
            const mesIndex = fecha.getMonth();
            const dia = fecha.getDate() - 1;

            ingresosPorMes[mesIndex] += parseFloat(item.monto);
            ingresosPorDia[dia] += parseFloat(item.monto);
            descripcionesPorDia[dia] += `${item.descripcion}, `;
        });

        // Calcular ingresos acumulados
        ingresosPorMes.forEach(ingreso => {
            acumulado += ingreso;
            ingresosAcumulados.push(acumulado);
        });

        return { meses, ingresosPorMes, ingresosPorDia, ingresosAcumulados, descripcionesPorDia };
    }

    // Llamar a la función para obtener los datos y generar los gráficos
    getIngresosData(function (ingresosData) {
        const { meses, ingresosPorMes, ingresosPorDia, ingresosAcumulados, descripcionesPorDia } = procesarDatosIngresos(ingresosData);

        // Gráfico de Barras: Ingresos Diarios
        const dailyIngresosChartOptions = {
            series: [{
                name: 'Ingresos',
                data: ingresosPorDia
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: Array.from({ length: 31 }, (_, i) => (i + 1).toString()),
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val, { dataPointIndex }) {
                        const descripcion = descripcionesPorDia[dataPointIndex].slice(0, -2); // Eliminar la última coma
                        return `$ ${val.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} COP<br>Descripción: ${descripcion || 'Sin descripción'}`;
                    }
                }
            }
        };

        const dailyIngresosChart = new ApexCharts(document.querySelector("#dailyIngresosChart"), dailyIngresosChartOptions);
        dailyIngresosChart.render();

        // Gráfico de Barras: Ingresos Mensuales
        const monthlyIngresosChartOptions = {
            series: [{
                name: 'Ingresos',
                data: ingresosPorMes
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: meses,
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "$ " + val.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + " COP";
                    }
                }
            }
        };

        const monthlyIngresosChart = new ApexCharts(document.querySelector("#monthlyIngresosChart"), monthlyIngresosChartOptions);
        monthlyIngresosChart.render();

        // Gráfico de Líneas: Ingresos Acumulados
        const totalIngresosLineChartData = {
            labels: meses,
            datasets: [{
                label: 'Ingresos Acumulados',
                data: ingresosAcumulados,
                fill: false,
                borderColor: '#33cc33',
                tension: 0.1
            }]
        };

        const totalIngresosLineChart = new Chart(document.getElementById('totalIngresosLineChart').getContext('2d'), {
            type: 'line',
            data: totalIngresosLineChartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Predicción de Ingresos para el próximo mes
        const prediccionProximoMesIngresos = ingresosAcumulados[ingresosAcumulados.length - 1] + (ingresosPorMes[ingresosPorMes.length - 1] * 0.05);

        const prediccionIngresosOptions = {
            series: [{
                name: 'Predicción de Ingresos',
                data: [...ingresosAcumulados.slice(-3), prediccionProximoMesIngresos]
            }],
            chart: {
                type: 'line',
                height: 350
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: ['Agosto', 'Septiembre', 'Octubre', 'Próximo Mes'],
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "$ " + val.toFixed(2) + " COP";
                    }
                }
            }
        };

        const ingresosPredictionChart = new ApexCharts(document.querySelector("#ingresosPredictionChart"), prediccionIngresosOptions);
        ingresosPredictionChart.render();
    });
});