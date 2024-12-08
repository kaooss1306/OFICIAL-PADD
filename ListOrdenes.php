<?php
// Iniciar la sesión
session_start();

// Incluir archivos necesarios
require_once 'querys/qordenes.php';
require_once 'componentes/header.php';
require_once 'componentes/sidebar.php';

// Asegúrate de que las variables $ordenes, $contratos, $planesMap, $proveedoresMap, $temasMap, $soportesMap, y $clasificacionesMap estén definidas en qordenes.php
?>
<!-- Incluir librerías necesarias -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Listado de Ordenes de Publicidad</h4>
                        </div>
                        <div class="filtros-container">
                            <div class="row">
                                <div class="col-md-5">
                                <div class="input-container">
                                <label for="fechaInicio" class="placeholder">Fecha de inicio</label>
                                    <input type="date" id="fechaInicio" class="form-control" />
                                  
                                </div>
                                </div>
                                <div class="col-md-5">
                                <div class="input-container">

                                <label for="fechaFin" class="placeholder">Fecha de Fin:</label>
                                    <input type="date" id="fechaFin" class="form-control" />
                                </div>
                                
                                </div>

                                <div class="col-md-2 d-flex align-items-end justify-content-start">
                              <div class="acciones-contenedor">
                              <label for="acciones" class="placeholder"> </label>
                              <div class="btn-group">
                                        <button id="filtrarFechas" class="btn btn-primary mr-2">
                                            <i class="fas fa-filter"></i> 
                                        </button>
                                        <button id="limpiarFiltros" class="btn btn-secondary mr-2">
                                            <i class="fas fa-times"></i> 
                                        </button>
                                        <button id="exportarExcel" class="btn btn-success">
                                            <i class="fas fa-file-excel"></i> 
                                        </button>
                                    </div>
                              </div>
                                  
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tableExportadora-simplificada">
                                    <thead>
                                        <tr>
                                            <th>N° Orden</th>
                                            <th>Copia</th>
                                            <th>N° Contrato</th>
                                            <th>Proveedor</th>
                                            <th>Cod Megatime</th>
                                            <th>Tema</th>
                                            <th>Soporte</th>
                                            <th>Clasificación</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ordenesPublicidad as $orden): ?>
                                        <tr data-fecha-creacion="<?php echo $orden['fechaCreacion']; ?>">
                                            <td data-key="idOrden"><?php echo htmlspecialchars($orden['id_ordenes_de_comprar']); ?></td>
                                            <td>0</td>
                                            <td data-key="numeroContrato">
                                            <?php echo htmlspecialchars($contratosMap[$orden['num_contrato']]['num_contrato'] ?? ''); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($proveedoresMap[$orden['id_proveedor']]['nombreProveedor'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($orden['Megatime']); ?></td>
                                            <td><?php echo htmlspecialchars($temasMap[$orden['id_tema']]['NombreTema'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($soportesMap[$orden['id_soporte']]['nombreIdentficiador'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($clasificacionesMap[$orden['id_clasificacion']]['NombreClasificacion'] ?? ''); ?></td>
                                            <td>
                                            <div class="alineado">
                                            <label class="custom-switch sino" data-toggle="tooltip" 
                                            title="<?php echo $orden['estado'] ? 'Desactivar Orden de publicidad' : 'Activar Orden depublicidad'; ?>">
                                            <input type="checkbox" 
                                                class="custom-switch-input estado-switch2"
                                                data-id="<?php echo $orden['id_ordenes_de_comprar']; ?>" data-tipo="orden" <?php echo $orden['estado'] ? 'checked' : ''; ?>>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                            </div>
                                            </td>
                                            <td>
                                                    <a class="btn btn-primary micono" href="querys/modulos/orden.php?id_orden=<?php echo $orden['id_ordenes_de_comprar']; ?>" data-toggle="tooltip" title="Ver Orden">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                             <!--    <a class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#modalEditPlanPublicidad"
                                                        onclick="cargarDatosFormulario(<?php echo $orden['id_ordenes_de_comprar']; ?>);">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>Main Content -->
                                                    <a class="btn btn-success micono" href="querys/modulos/editarOrden.php?id_orden=<?php echo $orden['id_ordenes_de_comprar']; ?>">
    <i class="fas fa-pencil-alt"></i>
</a>
                                                </td>
                                          
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>


// Variables globales
let allRows = [];
let originalRows = [];

// Función para inicializar filas
function inicializarFilas() {
    const rows = document.querySelectorAll('#tableExportadora-simplificada tbody tr');
    allRows = Array.from(rows);
    originalRows = Array.from(rows);
}

// Función para filtrar por rango de fechas
function filtrarPorRangoFechas() {
    const fechaInicio = document.getElementById('fechaInicio').value;
    const fechaFin = document.getElementById('fechaFin').value;

    // Validaciones
    if (!fechaInicio || !fechaFin) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor, seleccione tanto la fecha de inicio como la fecha de fin.'
        });
        return;
    }

    // Validar orden de fechas
    if (new Date(fechaInicio) > new Date(fechaFin)) {
        Swal.fire({
            icon: 'error',
            title: 'Rango de fechas inválido',
            text: 'La fecha de inicio debe ser anterior a la fecha de fin.'
        });
        return;
    }

    // Filtrar filas
    const filasFiltradas = originalRows.filter(fila => {
        const fechaCampania = new Date(fila.getAttribute('data-fecha-creacion'));
        const inicio = new Date(fechaInicio);
        const fin = new Date(fechaFin);
        // Ajustar horas para comparación precisa
        inicio.setHours(0, 0, 0, 0);
        fin.setHours(23, 59, 59, 999);

        return fechaCampania >= inicio && fechaCampania <= fin;
    });



    // Actualizar tabla
    actualizarTabla(filasFiltradas);

    // Manejar paginación
    manejarPaginacion();

    // Información de resultados
    Swal.fire({
        icon: 'info',
        title: 'Filtrado Completado',
        text: `Se encontraron ${filasFiltradas.length} Ordenes en el rango seleccionado.`
    });
}

// Función para manejar la visibilidad de la paginación
function manejarPaginacion() {
    const filasVisibles = document.querySelectorAll('#tableExportadora-simplificada tbody tr').length;
    const paginacion = document.querySelector('.pagination');

    if (paginacion) {
        // Ocultar la paginación si hay menos de 10 o 50 registros
        if (filasVisibles < 10 || filasVisibles < 50) {
            paginacion.style.display = 'none';
        } else {
            paginacion.style.display = '';
        }
    }
}
function manejarPaginacionLimpiar() {
    const filasVisibles = document.querySelectorAll('#tableExportadora-simplificada tbody tr').length;
    const paginacion = document.querySelector('.pagination');

    if (paginacion) {
        // Ocultar la paginación si hay menos de 10 o 50 registros
        if (filasVisibles < 10 || filasVisibles < 50) {
            paginacion.style.display = 'flex';
        } else {
            paginacion.style.display = '';
        }
    }
}


// Función para actualizar tabla
function actualizarTabla(filas) {
    const tbody = document.querySelector('#tableExportadora-simplificada tbody');
    tbody.innerHTML = '';
    filas.forEach(fila => tbody.appendChild(fila));
    // manejarPaginacion();
}

// Función para exportar a Excel
function exportarExcel() {
    const filasAExportar = document.querySelectorAll('#tableExportadora-simplificada tbody tr');

    // Validar que haya filas
    if (filasAExportar.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Sin datos',
            text: 'No hay campañas para exportar.'
        });
        return;
    }

    // Preparar datos para exportación
    const datosExportar = Array.from(filasAExportar).map(fila => ({
        'Id Orden': fila.querySelector('[data-key="idOrden"]').textContent,
        'Numero Contrato': fila.querySelector('[data-key="numeroContrato"]').textContent,
        'nombre Proveedor': fila.querySelector('[data-key="nombreProveedor"]').textContent,
        'Codigo mega': fila.querySelector('[data-key="mega"]').textContent,
        'Codigo tema': fila.querySelector('[data-key="tema"]').textContent,
        'Codigo clasificacion': fila.querySelector('[data-key="clasificacion"]').textContent,

    }));

    // Crear libro de Excel
    const hoja = XLSX.utils.json_to_sheet(datosExportar);
    const libro = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(libro, hoja, "Ordenes");

    // Descargar archivo
    XLSX.writeFile(libro, 'Ordenes_Exportadas.xlsx');
}

// Función para limpiar filtros
function limpiarFiltros() {
    document.getElementById('fechaInicio').value = '';
    document.getElementById('fechaFin').value = '';
    actualizarTabla(originalRows);
    manejarPaginacionLimpiar();
}

// Event Listeners
document.addEventListener('DOMContentLoaded', () => {
    inicializarFilas();
    // manejarPaginacion();
    manejarPaginacionLimpiar()
    document.getElementById('filtrarFechas').addEventListener('click', filtrarPorRangoFechas);
    document.getElementById('exportarExcel').addEventListener('click', exportarExcel);
    document.getElementById('limpiarFiltros').addEventListener('click', limpiarFiltros);

    const inputs = document.querySelectorAll('input[type="date"]');
    inputs.forEach(input => {
        input.addEventListener('change', function () {
            if (this.value) {
                this.classList.add('not-empty');
            } else {
                this.classList.remove('not-empty');
            }
        });
    });
});






</script>

<style>
.filtros-container {
    padding: 20px;

}
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}
.btn-group button {
    height: 42px;
    width: 50px;
}

.card-header {
    justify-content: space-between;
}
.acciones-contenedor {
    display: flex;
    flex-direction: column;
}
</style>
<?php 
require_once 'componentes/settings.php';
require_once 'componentes/footer.php';
?>