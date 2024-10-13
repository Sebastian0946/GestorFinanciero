$('#filtrarPorFecha').on('click', filtrarPorFecha);

// Evento para el formulario al enviar
$('#formCrearMovimiento').on('submit', function (e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto de enviar el formulario
    CrearGastoOIngreso(); // Llamar a la función para crear el gasto/ingreso
});

cargarTablaMovimientos();

$(document).ready(function () {
    CargarCategorias(); // Cargar categorías al cargar la página
});

function cargarTablaMovimientos(fechaInicio = null, fechaFin = null) {
    $.ajax({
        url: 'http://localhost/ProyectoGestorFinanzas/rutas/RutaMovimientos/RutaMovimientos.php',
        method: 'GET',
        data: { fechaInicio: fechaInicio, fechaFin: fechaFin },  // Pasamos ambas fechas si existen
        dataType: 'json',
        success: function (response) {
            if (!response.data || response.data.length === 0) {
                Swal.fire({
                    icon: 'info',
                    text: 'No se encontraron movimientos.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                return;
            }

            // Reiniciar la tabla si ya existe
            if ($.fn.DataTable.isDataTable('#TablaMovimientos')) {
                $('#TablaMovimientos').DataTable().clear().destroy();
            }

            // Inicializar DataTable con los nuevos datos
            $('#TablaMovimientos').DataTable({
                data: response.data,
                autoWidth: false,
                columns: [
                    {
                        data: 'tipo',
                        title: 'Tipo',
                        render: function (data) {
                            if (data === 'ingresos') {
                                return `<span class="badge badge-pill text-bg-success">${data}</span>`;
                            } else if (data === 'gastos') {
                                return `<span class="badge badge-pill text-bg-danger">${data}</span>`;
                            }
                            return data;
                        }
                    },
                    { data: 'descripcion', title: 'Descripción' },
                    { data: 'motivo', title: 'Motivo' },
                    { data: 'monto', title: 'Monto' },
                    { data: 'fecha', title: 'Fecha' },
                    {
                        title: 'Acciones',
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-warning btn-sm" data-id="${row.id}" data-tipo="${row.tipo}" onclick="CargarValores(this)">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn btn-danger btn-sm" data-id="${row.id}" data-tipo="${row.tipo}" onclick="EliminarMovimientos(this)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            `;
                        }
                    }
                ],
                // Ordenar por la columna de fecha en orden descendente
                order: [[4, 'desc']],  // La columna 4 es la de fecha
                pageLength: 8,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                }
            });

            // Actualizar totales y transacciones
            const totalIngresos = calcularIngresos(response.data);
            const totalEgresos = calcularEgresos(response.data);
            actualizarTotales(totalIngresos, totalEgresos);
            mostrarNumeroTransacciones(response.data);

        },
        error: function (jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: 'error',
                text: 'Error en la solicitud AJAX: ' + textStatus,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }
    });
}

function filtrarPorFecha() {
    const fechaInicio = $('#fechaFiltroInicio').val();
    let fechaFin = $('#fechaFiltroFin').val();

    // Si no se selecciona fecha de fin, usar la fecha actual
    if (!fechaFin) {
        const hoy = new Date();
        const dia = hoy.getDate().toString().padStart(2, '0');
        const mes = (hoy.getMonth() + 1).toString().padStart(2, '0');
        const año = hoy.getFullYear();

        fechaFin = `${año}-${mes}-${dia}`;  // Formato yyyy-mm-dd
    }

    // Validar que la fecha de inicio sea válida y no sea mayor que la fecha de fin
    if (fechaInicio) {
        if (new Date(fechaInicio) > new Date(fechaFin)) {
            Swal.fire({
                icon: 'error',
                text: 'La fecha de inicio no puede ser mayor que la fecha de fin.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            return;
        }
        cargarTablaMovimientos(fechaInicio, fechaFin);  // Pasamos ambas fechas
    } else {
        Swal.fire({
            icon: 'error',
            text: 'Por favor selecciona una fecha de inicio válida.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    }
}

function calcularIngresos(data) {
    let totalIngresos = 0;
    data.forEach(item => {
        if (item.tipo === 'ingresos') {
            totalIngresos += parseFloat(item.monto); // Asegúrate de que `monto` sea un número
        }
    });
    return totalIngresos;
}

function calcularEgresos(data) {
    let totalEgresos = 0;
    data.forEach(item => {
        if (item.tipo === 'gastos') {
            totalEgresos += parseFloat(item.monto); // Asegúrate de que `monto` sea un número
        }
    });
    return totalEgresos;
}

function actualizarTotales(totalIngresos, totalEgresos) {
    // Obtener la configuración regional del navegador
    const locale = navigator.language || 'es-CO'; // Por defecto, usar español de Colombia

    // Actualizar los totales en el HTML con formato de moneda
    $('#totalIngresos').text(totalIngresos.toLocaleString(locale, { style: 'currency', currency: 'COP' })); // Mostrar total de ingresos
    $('#totalEgresos').text(totalEgresos.toLocaleString(locale, { style: 'currency', currency: 'COP' })); // Mostrar total de egresos
}

// Función para mostrar el número de transacciones
function mostrarNumeroTransacciones(data) {
    $('#numeroTransacciones').text(data.length); // Actualiza el texto con el número de transacciones
}

let todasLasCategorias = []; // Variable para almacenar todas las categorías

// Cargar todas las categorías y almacenarlas
function CargarCategorias() {
    $.ajax({
        url: 'http://localhost/ProyectoGestorFinanzas/rutas/RutaCategorias/RutaCategorias.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            todasLasCategorias = data; // Guardamos todas las categorías
        },
        error: function (xhr, status, error) {
            console.error('Error al cargar categorías:', error);
        }
    });
}

// Filtrar y mostrar las categorías según el tipo de movimiento seleccionado
function filtrarCategorias(tipoMovimiento) {
    const select = $('#categoria');
    select.empty(); // Limpiamos el select antes de llenarlo

    // Filtrar las categorías según el tipo de movimiento
    const categoriasFiltradas = todasLasCategorias.filter(categoria => categoria.tipo_categoria === tipoMovimiento);

    // Agregar las categorías filtradas al select
    categoriasFiltradas.forEach(categoria => {
        select.append('<option value="' + categoria.id_categoria + '">' + categoria.nombre_categoria + '</option>');
    });

    // Habilitar el select de categoría y refrescar visualmente si usas selectpicker
    select.prop('disabled', false);
    select.selectpicker('refresh');
}

// Evento para el select de Tipo de Movimiento
$('#tipoMovimiento').on('change', function () {
    const tipoMovimiento = $(this).val(); // Obtener el valor seleccionado

    if (tipoMovimiento) {
        filtrarCategorias(tipoMovimiento); // Filtrar las categorías en base al valor seleccionado
    } else {
        $('#categoria').prop('disabled', true).empty(); // Deshabilitamos y limpiamos el select si no hay selección
        $('#categoria').append('<option value="" selected disabled>Seleccione una categoría...</option>');
        $('#categoria').selectpicker('refresh');
    }
});


function CrearGastoOIngreso() {
    // Capturamos los valores del formulario
    var tipoMovimiento = $('#tipoMovimiento').val();
    var descripcion = $('#descripcion').val();
    var monto = $('#monto').val();
    var fecha = $('#fecha').val();
    var categoria = $('#categoria').val();
    var motivo = $('#motivo').val();

    // Validamos que se haya seleccionado un tipo de movimiento
    if (!tipoMovimiento) {
        alert('Seleccione el tipo de movimiento.');
        return;
    }

    // Validamos que los campos obligatorios no estén vacíos
    if (!descripcion || !monto || !fecha || !motivo || !categoria) {
        alert('Por favor, complete todos los campos obligatorios.');
        return;
    }

    // Creamos un objeto con los datos a enviar
    var data = {
        tipo: tipoMovimiento,
        descripcion: descripcion,
        monto: monto,
        fecha: fecha,
        id_categoria: categoria,
        motivo: motivo
    };

    // Definimos la URL dependiendo del tipo de movimiento
    var url = '';
    if (tipoMovimiento === 'ingresos') {
        url = 'http://localhost/ProyectoGestorFinanzas/rutas/RutaIngresos/RutaIngresos.php';
    } else if (tipoMovimiento === 'gastos') {
        url = 'http://localhost/ProyectoGestorFinanzas/rutas/RutaGastos/RutaGastos.php';
    }

    $.ajax({
        url: url,
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function (response) {
            console.log('Respuesta del servidor:', response); // Verifica la respuesta aquí
            if (response.success) {
                // Usar SweetAlert para el éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Movimiento creado',
                    text: 'El movimiento ha sido creado exitosamente.',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#miModal').modal('hide'); // Asegúrate de que "miModal" es el ID correcto de tu modal
                    }
                });
                $('#formCrearMovimiento')[0].reset(); // Limpiamos el formulario
                cargarTablaMovimientos();
            } else {
                // Usar SweetAlert para errores específicos del backend
                Swal.fire({
                    icon: 'error',
                    title: 'Error al crear el movimiento',
                    text: response.error || response.message,
                    confirmButtonText: 'Aceptar'
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Error al crear el movimiento:', error);
            // Usar SweetAlert para errores generales de AJAX
            Swal.fire({
                icon: 'error',
                title: 'Error al crear el movimiento',
                text: 'Ocurrió un error durante el envío del movimiento. Por favor, inténtelo nuevamente.',
                confirmButtonText: 'Aceptar'
            });
        }
    });
}

function CargarValores(button) {
    var Id = $(button).data('id');
    var tipo_movimiento = $(button).data('tipo');

    var url = '';
    if (tipo_movimiento === 'ingresos') {
        url = 'http://localhost/ProyectoGestorFinanzas/rutas/RutaIngresos/RutaIngresos.php';
    } else if (tipo_movimiento === 'gastos') {
        url = 'http://localhost/ProyectoGestorFinanzas/rutas/RutaGastos/RutaGastos.php';
    }

    // Realizamos la solicitud AJAX
    $.ajax({
        url: url,
        type: 'GET', // Cambiamos a GET ya que queremos obtener información
        data: tipo_movimiento === 'ingresos' ? { id_ingreso: Id } : { id_gasto: Id }, // Usamos un operador ternario para decidir el parámetro
        success: function (response) {
            console.log('Respuesta del servidor:', response); // Verifica la respuesta aquí
        
            // Verificar si la respuesta es exitosa
            if (response.success) {
                // Cargar los datos en el formulario
                const formulario = document.getElementById('formCrearMovimiento'); // Asegúrate de que este ID sea correcto
                formulario.reset(); // Limpia el formulario
        
                // Asignar valores a los campos del formulario
                document.getElementById('idMovimiento').value = Id; // Asigna el ID del movimiento
                document.getElementById('tipoMovimiento').value = response.data.tipoMovimiento; // Asigna el tipo de movimiento
                document.getElementById('descripcion').value = response.data.descripcion;
                document.getElementById('monto').value = response.data.monto;
                document.getElementById('fecha').value = response.data.fecha; // Asegúrate de que la respuesta incluya la fecha
                document.getElementById('motivo').value = response.data.Motivo; // Cambié a minúsculas para que coincida con el campo

                // Cargar la categoría en el select
                const categoriaSelect = $('#categoria');
                categoriaSelect.empty(); // Limpiar el select antes de llenarlo
                categoriaSelect.append('<option value="" selected disabled>Seleccione una categoría...</option>'); // Opción por defecto
                
                // Agregar la categoría seleccionada
                categoriaSelect.append('<option value="' + response.data.id_categoria + '" selected>' + response.data.nombre_categoria + '</option>');
                
                // Habilitar el select de categoría y refrescar visualmente si usas selectpicker
                categoriaSelect.prop('disabled', false);
                categoriaSelect.selectpicker('refresh'); // Refrescar el selectpicker
                
                // Cambiar el texto del botón a "Actualizar" usando jQuery
                $('#formCrearMovimiento button[type="submit"]').text('Actualizar');

                // Aquí puedes mostrar el modal de edición si es necesario
                $('#crearMovimientoModal').modal('show'); // Mostrar el modal
            } else {
                // Usar SweetAlert para errores específicos del backend
                Swal.fire({
                    icon: 'error',
                    title: 'Error al cargar los datos',
                    text: response.error || response.message,
                    confirmButtonText: 'Aceptar'
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Error al cargar los datos:', error);
            // Usar SweetAlert para errores generales de AJAX
            Swal.fire({
                icon: 'error',
                title: 'Error al cargar los datos',
                text: 'Ocurrió un error durante la carga de datos. Por favor, inténtelo nuevamente.',
                confirmButtonText: 'Aceptar'
            });
        }
    });
}

function EliminarMovimientos(button) {
    // Obtener el ID del movimiento desde el botón
    var Id = $(button).data('id');
    var tipo_movimiento = $(button).data('tipo');

    console.log('ID obtenido:', Id); // Agregar esta línea para depurar
    console.log('ID obtenido:', tipo_movimiento); // Agregar esta línea para depurar

    var url = '';
    if (tipo_movimiento === 'ingresos') {
        url = 'http://localhost/ProyectoGestorFinanzas/rutas/RutaIngresos/RutaIngresos.php?id_ingreso='+Id;
    } else if (tipo_movimiento === 'gastos') {
        url = 'http://localhost/ProyectoGestorFinanzas/rutas/RutaGastos/RutaGastos.php?id_gasto='+Id;
    }
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Este movimiento será eliminado permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminarlo!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Realizar la solicitud AJAX para eliminar el movimiento
            $.ajax({
                url: url,
                type: 'DELETE',
                success: function(response) {
                    console.log('Respuesta del servidor:', response);
                    
                    // Verificar si la respuesta es exitosa
                    if (response.success) {
                        Swal.fire(
                            'Eliminado!',
                            'El movimiento ha sido eliminado.',
                            'success'
                        );
                        // Aquí puedes recargar la lista de movimientos o eliminar el elemento de la tabla
                        cargarTablaMovimientos();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al eliminar',
                            text: response.message || 'Ocurrió un error inesperado.',
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al eliminar el movimiento:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error durante la eliminación del movimiento. Por favor, inténtelo nuevamente.',
                    });
                }
            });
        }
    });
}

function ActualizarMovimientos(){

}

function limpiarCampos() {
    // Restablecer el campo oculto del ID
    document.getElementById('idMovimiento').value = '';

    // Limpiar los campos de texto
    document.getElementById('descripcion').value = '';
    document.getElementById('monto').value = '';
    document.getElementById('motivo').value = '';

    // Restablecer el campo de fecha
    document.getElementById('fecha').value = '';

    // Restablecer el select de tipo de movimiento
    document.getElementById('tipoMovimiento').selectedIndex = 0;

    // Limpiar y deshabilitar el select de categoría
    const categoriaSelect = document.getElementById('categoria');
    categoriaSelect.selectedIndex = 0; // Opción por defecto
    categoriaSelect.disabled = true; // Deshabilitar el select de categoría

    // Si usas selectpicker de Bootstrap, refrescarlo
    if ($.fn.selectpicker) {
        $(categoriaSelect).selectpicker('refresh');
    }
}
