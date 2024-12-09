<?php
// Iniciar sesión
session_start();

include "querys/qcontratos.php";
include "componentes/header.php";
include "componentes/sidebar.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<!-- Main Content -->
      <div class="main-content">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lista de Contratos</li>
        </ol>
    </nav><br>
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                <div class="card-header milinea">
                            <div class="titulox"><h4>Listado de Contratos</h4></div>
                            <div class="agregar">
                            <a href="#"
       class="btn btn-primary open-modal"
       data-bs-toggle="modal"
       data-bs-target="#modalAddContrato">
        <i class="fas fa-plus-circle"></i> Agregar Contrato
    </a>
                            </div>
                        </div>
                  <div class="card-body">
                    <div class="table-responsive">
                    <div class="row mb-3">
                                    <div class="col-md-4">
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
                            <th>
                              ID
                            </th>
                            <th>Fecha Creación</th>
                            <th>Nombre Contrato</th>
                            <th>Nombre Cliente</th>
                            <th>Inicio Contrato</th>
                            <th>Término Contrato </th>
                            <th>Producto</th>
                            <th>Proveedor</th>
                            <th>Medio</th>
                            <th>Forma de Pago</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($contratos as $contrato):

                            $nombreCliente = isset(
                                $clientesMap[$contrato["IdCliente"]]
                            )
                                ? $clientesMap[$contrato["IdCliente"]][
                                    "nombreCliente"
                                ]
                                : "N/A";
                            $nombreProducto = "N/A";
                            if (
                                isset($productosMap[$contrato["IdCliente"]]) &&
                                !empty($productosMap[$contrato["IdCliente"]])
                            ) {
                                $nombreProducto =
                                    $productosMap[$contrato["IdCliente"]][0][
                                        "NombreDelProducto"
                                    ];
                            }
                            $nombreProvee = isset(
                                $proveedorMap[$contrato["IdProveedor"]]
                            )
                                ? $proveedorMap[$contrato["IdProveedor"]][
                                    "nombreProveedor"
                                ]
                                : "N/A";
                            $nombreMedio = isset(
                                $mediosMap[$contrato["IdMedios"]]
                            )
                                ? $mediosMap[$contrato["IdMedios"]][
                                    "NombredelMedio"
                                ]
                                : "N/A";
                            $pagoForma = isset(
                                $pagosMap[$contrato["id_FormadePago"]]
                            )
                                ? $pagosMap[$contrato["id_FormadePago"]][
                                    "NombreFormadePago"
                                ]
                                : "N/A";
                            ?>
                        <tr>
    <td data-key="id_contrato"><?php echo $contrato["id"]; ?></td>
    <td data-key="fechaCreacion"><?php echo date('d/m/Y', strtotime($contrato['created_at'])); ?></td>
    <td data-key="nombre_contrato"><?php echo $contrato["NombreContrato"]; ?></td>
    <td data-key="nombre_cliente"><?php echo $nombreCliente; ?></td>
    <td data-key="fechaInicio"><?php echo date('d/m/Y', strtotime($contrato['FechaInicio'])); ?></td>
    <td data-key="fechaTermino"><?php echo date('d/m/Y', strtotime($contrato['FechaTermino'])); ?></td>
    <td data-key="nombre_producto"><?php echo $nombreProducto; ?></td>
    <td data-key="proveedor"><?php echo $nombreProvee; ?></td>
    <td data-key="medio"><?php echo $nombreMedio; ?></td>
    <td data-key="forma_pago"><?php echo $pagoForma; ?></td>
    <td><div class="alineado">
       <label class="custom-switch sino" data-toggle="tooltip"
       title="<?php echo $contrato["Estado"]
           ? "Desactivar Contrato"
           : "Activar Contrato"; ?>">
    <input type="checkbox"
           class="custom-switch-input estado-switchC"
           data-id="<?php echo $contrato[
               "id"
           ]; ?>" data-tipo="contrato" <?php echo $contrato["Estado"]
    ? "checked"
    : ""; ?>> <span class="custom-switch-indicator"></span>
</label>
    </div></td>
    <td>
      <a class="btn btn-primary micono" href="views/viewContrato.php?id=<?php echo $contrato[
          "id"
      ]; ?>" data-toggle="tooltip" title="Ver Contrato"><i class="fas fa-eye "></i></a>
      <button type="button" class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#modalEditContrato" data-contrato-id="<?php echo $contrato[
          "id"
      ]; ?>"><i class="fas fa-pencil-alt"></i></button>





    </td>
</tr>
<?php
                        endforeach; ?>
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

<script src="assets/js/toggleContratos.js"></script>




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
        const dateCell = row.querySelector('td:nth-child(2)')?.textContent?.trim();
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
        'ID Contrato': fila.querySelector('[data-key="id_contrato"]').textContent,
        'Fecha': fila.querySelector('[data-key="fechaCreacion"]').textContent,
        'Nombre Contrato': fila.querySelector('[data-key="nombre_contrato"]').textContent,
        'Nombre de Cliente': fila.querySelector('[data-key="nombre_cliente"]').textContent,
        'Inicio Contrato': fila.querySelector('[data-key="fechaInicio"]').textContent,
        'Término Contrato': fila.querySelector('[data-key="fechaTermino"]').textContent,
        'Nombre Producto': fila.querySelector('[data-key="nombre_producto"]').textContent,
        'Proveedor': fila.querySelector('[data-key="proveedor"]').textContent,
        'Medio': fila.querySelector('[data-key="medio"]').textContent,
        'Forma de Pago': fila.querySelector('[data-key="forma_pago"]').textContent
    }));

    const hoja = XLSX.utils.json_to_sheet(datosExportar);
    const libro = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(libro, hoja, "Contratos");

    XLSX.writeFile(libro, 'Contratos_Exportados.xlsx');
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






      <?php include "componentes/settings.php"; ?>
      <?php include "querys/modulos/modalAddContrato.php"; ?>
      <?php include "querys/modulos/modalEditContrato.php"; ?>
      <?php include "componentes/footer.php"; ?>
