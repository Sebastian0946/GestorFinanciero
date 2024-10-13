<?php

require_once("../../Assets/Librerias/Cabecera.php");

?>

<link rel="stylesheet" href="../../Assets/Css/Ingresos/Ingresos.css">

<div class="container">
    <!-- Pestañas de navegación para Ingresos -->
    <ul class="nav nav-tabs justify-content-center" id="ingresosTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="dailyIngresos-tab" data-bs-toggle="tab" data-bs-target="#dailyIngresos" type="button" role="tab" aria-controls="dailyIngresos" aria-selected="true">Ingresos Diarios</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="monthlyIngresos-tab" data-bs-toggle="tab" data-bs-target="#monthlyIngresos" type="button" role="tab" aria-controls="monthlyIngresos" aria-selected="false">Ingresos Mensuales</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="totalIngresos-tab" data-bs-toggle="tab" data-bs-target="#totalIngresos" type="button" role="tab" aria-controls="totalIngresos" aria-selected="false">Ingresos Acumulados</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="predictionIngresos-tab" data-bs-toggle="tab" data-bs-target="#predictionIngresos" type="button" role="tab" aria-controls="predictionIngresos" aria-selected="false">Predicción de Ingresos</button>
        </li>
    </ul>

    <div class="tab-content mt-4" id="ingresosTabContent">
        <div class="tab-pane fade show active" id="dailyIngresos" role="tabpanel" aria-labelledby="dailyIngresos-tab">
            <h2>Ingresos Diarios</h2>
            <p>Este gráfico muestra el flujo de ingresos diario, permitiendo identificar patrones y tendencias en los ingresos a lo largo de la semana.</p>
            <div id="dailyIngresosChart" class="chart-canvas"></div>
        </div>
        <div class="tab-pane fade" id="monthlyIngresos" role="tabpanel" aria-labelledby="monthlyIngresos-tab">
            <h2>Ingresos Mensuales</h2>
            <p>Aquí se presenta un resumen de los ingresos acumulados mes a mes. Este gráfico ayuda a observar la evolución de los ingresos a lo largo del tiempo y facilita la planificación financiera.</p>
            <div id="monthlyIngresosChart" class="chart-canvas"></div>
        </div>
        <div class="tab-pane fade" id="totalIngresos" role="tabpanel" aria-labelledby="totalIngresos-tab">
            <h2>Ingresos Acumulados</h2>
            <p>Este gráfico ilustra el total de ingresos acumulados desde el inicio del seguimiento. Proporciona una visión general de la salud financiera actual.</p>
            <canvas id="totalIngresosLineChart" class="chart-canvas"></canvas>
        </div>
        <div class="tab-pane fade" id="predictionIngresos" role="tabpanel" aria-labelledby="predictionIngresos-tab">
            <h2>Predicción de Ingresos</h2>
            <p>Este gráfico utiliza datos históricos para proyectar ingresos futuros. Es una herramienta útil para la planificación financiera y la toma de decisiones estratégicas.</p>
            <div id="ingresosPredictionChart" class="chart-canvas"></div>
        </div>
    </div>
</div>

<script src="../../Assets/Js/Ingresos/Ingresos.js"></script>


<?php
    require_once "../../Assets/Librerias/PieDePagina.php";
?>