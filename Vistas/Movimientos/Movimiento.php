<?php

require_once("../../Assets/Librerias/Cabecera.php");

?>

<link rel="stylesheet" href="../../Assets/Css/Movimientos/Movimientos.css">

<!-- Video de fondo -->
<video autoplay muted loop id="backgroundVideo">
    <source src="../../Assets/img/FondoAnimado2.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<div class="container container-custom mt-1">
    <div class="row row-custom">
        <!-- Carta de Presupuesto -->
        <div class="col-custom">
            <div class="card card-custom">
                <i class="fas fa-wallet"></i> <!-- Icono de presupuesto -->
                <div class="card-header card-header-custom">
                    PRESUPUESTO
                </div>
                <div class="card-body card-body-custom">
                    <h5>Total Presupuesto Disponible</h5>
                    <p>$10,000</p>
                </div>
            </div>
        </div>

        <!-- Carta de Movimientos Recientes -->
        <div class="col-custom">
            <div class="card card-custom">
                <i class="fas fa-history"></i> <!-- Icono de movimientos -->
                <div class="card-header card-header-custom">
                    MOVIMIENTOS
                </div>
                <div class="card-body card-body-custom">
                    <h5>Número de Transacciones</h5>
                    <p id="numeroTransacciones"></p> <!-- Agregado ID para actualizar el contenido -->
                </div>
            </div>
        </div>

        <!-- Carta de Ingresos -->
        <div class="col-custom">
            <div class="card card-custom">
                <i class="fas fa-plus-circle"></i> <!-- Icono de ingresos -->
                <div class="card-header card-header-custom">
                    INGRESOS
                </div>
                <div class="card-body card-body-custom">
                    <h5>Total de Ingresos</h5>
                    <p id="totalIngresos"></p> <!-- Agregado ID para actualizar el contenido -->
                </div>
            </div>
        </div>

        <!-- Carta de Egresos -->
        <div class="col-custom">
            <div class="card card-custom">
                <i class="fas fa-minus-circle"></i> <!-- Icono de egresos -->
                <div class="card-header card-header-custom">
                    EGRESOS
                </div>
                <div class="card-body card-body-custom">
                    <h5>Total de Egresos</h5>
                    <p id="totalEgresos"></p> <!-- Agregado ID para actualizar el contenido -->
                </div>
            </div>
        </div>

    </div>
</div>

<div class="table-responsive mt-4">
    <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" onclick="limpiarCampos();" data-bs-target="#crearMovimientoModal">
            Crear Ingreso/Gasto
        </button>

        <!-- Campo para seleccionar la fecha -->
        <input type="date" id="fechaFiltroInicio" class="form-control" placeholder="Selecciona una fecha" style="max-width: 200px;">

        <!-- Botón para filtrar por fecha -->
        <button type="button" class="btn btn-info" id="filtrarPorFecha">
            Mostrar desde la fecha seleccionada
        </button>

        <button type="button" class="btn btn-info" onclick="cargarTablaMovimientos();">
            Devolver Tabla
        </button>
    </div>

    <table id="TablaMovimientos" class="table table-hover table-bordered table-custom">
        <!-- La tabla se genera dinámicamente -->
    </table>
</div>

<!-- Modal para crear Ingreso o Gasto -->
<div class="modal fade" id="crearMovimientoModal" tabindex="-1" aria-labelledby="crearMovimientoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Modal tamaño grande -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearMovimientoLabel">Crear Ingreso o Gasto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: #fff !important;"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para crear ingreso o gasto -->
                <form id="formCrearMovimiento">
                    <input type="hidden" id="idMovimiento" /> <!-- Campo oculto para el ID -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tipoMovimiento" class="form-label">Tipo de Movimiento</label>
                            <select id="tipoMovimiento" class="form-control" required>
                                <option value="" selected disabled>Seleccione...</option>
                                <option value="ingresos">Ingreso</option>
                                <option value="gastos">Gasto</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion"
                                placeholder="Ingrese una descripción" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="number" class="form-control" id="monto" placeholder="Ingrese el monto"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select id="categoria" class="form-control selectpicker" disabled>
                                <option value="" selected disabled>Seleccione una categoría...</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo</label>
                        <textarea id="motivo" class="form-control" rows="4"
                            placeholder="Ingrese el motivo del movimiento"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" form="formCrearMovimiento" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script src="../../Assets/Js/Movimientos/Movimientos.js"></script>

<?php

require_once "../../Assets/Librerias/PieDePagina.php";

?>