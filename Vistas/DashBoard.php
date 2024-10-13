<?php
require_once "../Assets/Librerias/Cabecera.php";
?>
<link rel="stylesheet" href="../Assets/Css/DashBoard.css">

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <!-- Botón colapsable (versión móvil) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Centrando el contenido de navegación -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="Movimientos/Movimiento.php" onclick="loadPage('Movimientos/Movimiento.php'); return false;">Movimientos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Gastos/Gastos.php" onclick="loadPage('Gastos/Gastos.php'); return false;">Análisis Gastos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Ingresos/Ingresos.php" onclick="loadPage('Ingresos/Ingresos.php'); return false;">Análisis Ingresos</a>
                </li>
            </ul>
        </div>

        <!-- Dropdown con ícono de perfil a la derecha y nombre de usuario -->
        <div class="dropdown ms-auto">
            <a href="#" class="d-flex align-items-center text-decoration-none" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle" style="font-size: 1.5rem; color: #ffffff; margin-right: 8px;"></i> <!-- Ícono de perfil -->
                <!-- <span class="d-none d-md-inline text-white">Nombre del Usuario</span> Nombre del usuario -->
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#">Configuración Perfil</a></li>
                <li><a class="dropdown-item" href="../Index.php">Salir</a></li>
            </ul>
        </div>

    </div>
</nav>

<!-- Contenido de la página -->
<div id="content">
    <iframe id="content-frame" title="Contenido principal"></iframe>
</div>

<script src="../Assets/Js/DashBoard.js"></script>

<?php
require_once "../Assets/Librerias/PieDePagina.php";
?>