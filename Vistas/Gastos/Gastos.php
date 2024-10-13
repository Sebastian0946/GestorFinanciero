<?php

require_once("../../Assets/Librerias/Cabecera.php");

?>

<link rel="stylesheet" href="../../Assets/Css/Gastos/Gastos.css">


<div class="container">
    <!-- Pestañas de navegación -->
    <ul class="nav nav-tabs justify-content-center" id="gastosTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="daily-tab" data-bs-toggle="tab" data-bs-target="#daily" type="button" role="tab" aria-controls="daily" aria-selected="true">Gastos Diarios</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly" type="button" role="tab" aria-controls="monthly" aria-selected="false">Gastos Mensuales</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="total-tab" data-bs-toggle="tab" data-bs-target="#total" type="button" role="tab" aria-controls="total" aria-selected="false">Gastos Acumulados</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="prediction-tab" data-bs-toggle="tab" data-bs-target="#prediction" type="button" role="tab" aria-controls="prediction" aria-selected="false">Predicción de Gastos</button>
        </li>
    </ul>

    <!-- Contenido de cada tab -->
    <div class="tab-content" id="gastosTabContent">
        <div class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="daily-tab">
            <div class="chart-container animate__animated animate__fadeInUp">
                <h2>Gastos Diarios</h2>
                <p>Este gráfico muestra el desglose de los gastos diarios, permitiendo visualizar patrones de gasto a lo largo de la semana. Es útil para identificar días con mayor consumo y ajustar el presupuesto diario.</p>
                <div id="dailyGastosChart" class="chart-canvas"></div>
            </div>
        </div>
        <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
            <div class="chart-container animate__animated animate__fadeInUp">
                <h2>Gastos Mensuales</h2>
                <p>Aquí se presenta un resumen de los gastos acumulados mes a mes. Este gráfico ayuda a observar tendencias a largo plazo y evaluar el impacto de decisiones financieras en el tiempo.</p>
                <div id="monthlyGastosChart" class="chart-canvas"></div>
            </div>
        </div>
        <div class="tab-pane fade" id="total" role="tabpanel" aria-labelledby="total-tab">
            <div class="chart-container animate__animated animate__fadeInUp">
                <h2>Gastos Acumulados</h2>
                <p>Este gráfico ilustra el total de gastos acumulados desde el inicio del seguimiento. Proporciona una visión clara de la situación financiera actual y permite planificar mejor para el futuro.</p>
                <canvas id="totalGastosLineChart" class="chart-canvas"></canvas>
            </div>
        </div>
        <div class="tab-pane fade" id="prediction" role="tabpanel" aria-labelledby="prediction-tab">
            <div class="chart-container animate__animated animate__fadeInUp">
                <h2>Predicción de Gastos</h2>
                <p>Este gráfico utiliza datos históricos para proyectar gastos futuros. Es una herramienta valiosa para la planificación financiera, ayudando a anticipar y gestionar posibles gastos.</p>
                <div id="gastosPredictionChart" class="chart-canvas"></div>
            </div>
        </div>
    </div>

</div>

<script src="../../Assets/Js/Gastos/Gastos.js"></script>


<?php

    require_once "../../Assets/Librerias/PieDePagina.php";

?>