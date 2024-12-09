<?php
// Iniciar la sesión
session_start();

include 'querys/qcampaign.php';
include 'componentes/header.php';
include 'componentes/sidebar.php';
?>

    <!-- Incluir librerías necesarias -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>ListCampaign.php">Campañas</a></li>
                        </ol>
                    </nav>
                    <div class="card">
                        <div class="card-header">
                            <div class="titulox">
                                <h4>Listado de Campañas</h4>
                            </div>
                            <div class="ml-auto">
                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarCampania">
                                    <i class="fas fa-plus-circle"></i> Agregar Campañas
                                </a>
                            </div>
                        </div>
                   
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            <input type="text" class="form-control" id="searchInput" placeholder="Buscar...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            <input type="date" class="form-control" id="dateFrom" placeholder="Fecha desde">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            <input type="date" class="form-control" id="dateTo" placeholder="Fecha hasta">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button id="resetFilters" class="btn btn-secondary">
                                            <i class="fas fa-redo"></i> 
                                        </button>
                                        <button id="exportarExcel" class="btn btn-success" disabled>
                                        <i class="fas fa-file-excel"></i> 
                                    </button>
                                    </div>
                                </div>
                                <table class="table table-striped" id="tableExportadora">
                                  
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente</th>
                                            <th>Nombre de campaña</th>
                                            <th>Producto</th>
                                            <th>Año</th>
                                            <th>Fecha de Creación</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($campaign as $campania): ?>
                                            <tr data-fecha-creacion="<?php echo $campania['fechaCreacion']; ?>">
                                                <td data-key="id_campania"><?php echo $campania['id_campania']; ?></td>
                                                <td data-key="nombreCliente"><?php echo $clientesMap[$campania['id_Cliente']]['nombreCliente'] ?? ''; ?></td>
                                                <td data-key="NombreCampania"><?php echo $campania['NombreCampania']; ?></td>
                                                <td data-key="NombreDelProducto"><?php echo $productosMap[$campania['id_Producto']]['NombreDelProducto'] ?? ''; ?></td>
                                                <td data-key="Anio"><?php echo $aniosMap[$campania['Anio']]['years'] ?? ''; ?></td>
                                                <td data-key="fecha_creacion"><?php echo date('d/m/Y', strtotime($campania['fechaCreacion'])); ?></td>
                                                <td>
                                                    <div class="alineado">
                                                        <label class="custom-switch sino" data-toggle="tooltip"
                                                            title="<?php echo $campania['estado'] ? 'Desactivar Campaña' : 'Activar Campaña'; ?>">
                                                            <input type="checkbox"
                                                                class="custom-switch-input estado-switch-campania"
                                                                data-id="<?php echo $campania['id_campania']; ?>" data-tipo="campania" <?php echo $campania['estado'] ? 'checked' : ''; ?>>
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary micono" href="views/viewcampania.php?id_campania=<?php echo $campania['id_campania']; ?>" data-toggle="tooltip" title="Ver Campaña">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#modalUpdateCampania"
                                                        onclick="cargarDatosFormulario(<?php echo $campania['id_campania']; ?>);">
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
function filterTable() {
    const searchText = document.getElementById('searchInput').value.toLowerCase();
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    const rows = document.querySelectorAll('#tableExportadora tbody tr');
    
    let visibleRowCount = 0;

    rows.forEach(row => {
        let showRow = true;
        const textContent = row.textContent.toLowerCase();
        const dateCell = row.querySelector('td:nth-child(6)')?.textContent?.trim();
        const rowDate = dateCell ? convertDateFormat(dateCell) : null;

        // Text filter
        if (searchText && !textContent.includes(searchText)) {
            showRow = false;
        }

        // Date range filter
        if (rowDate) {
            if (dateFrom && dateTo) {
                if (rowDate < dateFrom || rowDate > dateTo) {
                    showRow = false;
                }
            } else if (dateFrom && rowDate < dateFrom) {
                showRow = false;
            } else if (dateTo && rowDate > dateTo) {
                showRow = false;
            }
        } else if ((dateFrom || dateTo) && (dateFrom !== '' || dateTo !== '')) {
            showRow = false;
        }

        row.style.display = showRow ? '' : 'none';
        
        if (showRow) {
            visibleRowCount++;
        }
    });

    // Update export button state
    const exportButton = document.getElementById('exportarExcel');
    exportButton.disabled = visibleRowCount === 0;
}

function convertDateFormat(dateStr) {
    try {
        const parts = dateStr.split('/');
        if (parts.length === 3) {
            return `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
        }
    } catch (error) {
        console.error('Error converting date:', error);
    }
    return null;
}

function exportarExcel() {
    const visibleRows = document.querySelectorAll('#tableExportadora tbody tr:not([style*="display: none"])');
    
    if (visibleRows.length === 0) {
        Swal2.fire({
            icon: 'warning',
            title: 'No hay datos para exportar',
            text: 'Aplique filtros para ver datos antes de exportar'
        });
        return;
    }

    const datosExportar = Array.from(visibleRows).map(fila => ({
        'ID': fila.querySelector('[data-key="id_campania"]').textContent,
        'Cliente': fila.querySelector('[data-key="nombreCliente"]').textContent,
        'Nombre de Campaña': fila.querySelector('[data-key="NombreCampania"]').textContent,
        'Producto': fila.querySelector('[data-key="NombreDelProducto"]').textContent,
        'Año': fila.querySelector('[data-key="Anio"]').textContent,
        'Fecha de Creación': fila.querySelector('[data-key="fecha_creacion"]').textContent
    }));

    const hoja = XLSX.utils.json_to_sheet(datosExportar);
    const libro = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(libro, hoja, "Campañas");

    XLSX.writeFile(libro, 'Campañas_Exportadas.xlsx');
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    filterTable();
}

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const exportButton = document.getElementById('exportarExcel');
    const resetButton = document.getElementById('resetFilters');

    searchInput.addEventListener('input', filterTable);
    dateFrom.addEventListener('change', filterTable);
    dateTo.addEventListener('change', filterTable);
    exportButton.addEventListener('click', exportarExcel);
    
    if (resetButton) {
        resetButton.addEventListener('click', resetFilters);
    }

    // Initially disable export if no rows
    exportButton.disabled = document.querySelectorAll('#tableExportadora tbody tr').length === 0;
});
</script>

<?php 
include 'views/modalAgregarCampania.php';
include 'views/modalUpdateCampania.php';
include 'componentes/settings.php';
include 'componentes/footer.php';
?>