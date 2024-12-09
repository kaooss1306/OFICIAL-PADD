<?php
// Iniciar la sesión
session_start();

include './querys/qplanes.php';
// Función para hacer peticiones cURL


// Obtener datos
$campaigns = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Campania?select=*');
$clientes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes?select=*');
$contratos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Contratos?select=*');
$ordenepublicidad = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenesDePublicidad?select=*');
$planes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/PlanesPublicidad?select=*');
$meses = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Meses?select=*');
$anos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Anios?select=*');
$productos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Productos?select=*');
$jsonData = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/json?select=*');
$calendarMap = [];

$ordenesporplan = [];
foreach ($ordenepublicidad as $orden) {
    $id_plan = $orden['id_plan']; // Asume que este es el nombre correcto de la columna
    if (!isset($ordenesporplan[$id_plan])) {
        $ordenesporplan[$id_plan] = [];
    }
    $ordenesporplan[$id_plan][] = $orden;
}

foreach ($jsonData as $calendar) {
    // Aquí asumimos que `id_calendar` es único y usamos su valor como clave en nuestro mapa
    $calendarMap[$calendar['id_calendar']] = $calendar['matrizCalendario'];
}
$mesesNombres = [
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Septiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Diciembre'
];

$clientesMap = [];
foreach ($clientes as $cliente) {
    $clientesMap[$cliente['id_cliente']] = $cliente['nombreCliente'];
}
$productosMap = [];
foreach ($productos as $producto) {
    $productosMap[] = [
        'id' => $producto['id'],
        'nombreProducto' => $producto['NombreDelProducto'],
        'idCliente' => $producto['Id_Cliente']
    ];
}

$campaignsMap = [];
foreach ($campaigns as $campaign) {
    $campaignsMap[] = [
        'id' => $campaign['id_campania'],
        'nombreCampania' => $campaign['NombreCampania'],
        'idCliente' => $campaign['id_Cliente']
    ];
}

$contratosMap = [];
foreach ($contratos as $contrato) {
    $contratosMap[$contrato['id']] = [
        'nombreContrato' => $contrato['NombreContrato'],
        'idCliente' => $contrato['IdCliente']
    ];
}

include 'componentes/header.php';
include 'componentes/sidebar.php';
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<style>

.custom-select-container {
    position: relative;
    width: 100%;
}

.client-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background-color: white;
  
   
    overflow-y: auto;
    z-index: 1000;
    display: none; /* Oculto por defecto */
}

.client-dropdown li {
    padding: 10px;
    cursor: pointer;
}

.client-dropdown li:hover {
    background-color: #f1f1f1;
}

.clear-btn {
    background: none;
    border: none;
    color: #d9534f;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
}

</style>
  <!-- Incluir librerías necesarias -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="main-content">
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard">Home</a></li>
      <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>ListPlanes.php">Ver Planes</a></li>
    </ol>
  </nav>
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            
                            <div style="    padding: 10px 5px;" class="card-header milinea">
                            <div class="titulox"><h4>Listado de Planes</h4></div>
                            <div class="agregar"><a  href="querys/modulos/addPlan.php" class="btn btn-primary micono"  ><i class="fas fa-plus-circle"></i> Agregar Plan</a>
                            </div>
                        </div>
                        </div>
                       
                        <div class="card-body">
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
                            <div class="table-responsive">
                            <table class="table table-striped" id="tableExportadora">
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha Ingreso</th>
            <th>Nombre plan</th>
            <th>Nombre Contrato</th>
            <th>Cliente</th>
            <th>Mes</th>
            <th>Año</th>
            <th>Estado</th>
            <th>Órdenes</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($planes as $plan): 
        // Buscar órdenes relacionadas con este plan
        $ordenesDelPlan = array_filter($ordenespuMap, function($ordenpu) use ($plan) {
            return $ordenpu['idplanorden'] == $plan['id_planes_publicidad'];
        });

    ?>
        <tr>
            <td data-key="id_plan"><?php echo $plan['id_planes_publicidad']; ?></td>
            <td data-key="fechaCreacion"><?php echo date('d/m/Y', strtotime($plan['created_at'])); ?></td>
            <td data-key="nombreplan"><?php echo $plan['NombrePlan']; ?></td>
            <td data-key="nombre_contrato"><?php echo isset($contratosMap[$plan['id_contrato']]) ? $contratosMap[$plan['id_contrato']]['nombreContrato'] : 'N/A'; ?></td>
            <td data-key="cliente">
                <?php 
                $idCliente = $contratosMap[$plan['id_contrato']]['idCliente'];
                echo isset($clientesMap[$idCliente]) ? $clientesMap[$idCliente] : 'N/A';
                ?>
            </td>
            
            <?php 
            $datosRecopilados = $plan['datosRecopilados'];
            $nombreMes = 'Mes no especificado'; 
            $nombreAnio = 'Año no especificado';

            if (!empty($datosRecopilados['datos'])) {
                $primerGrupo = $datosRecopilados['datos'][0];
                $mesId = $primerGrupo['calendario'][0]['mes'];
                $anioId = $primerGrupo['calendario'][0]['anio'];

                $nombreMes = $mesesMap[$mesId]['Nombre'] ?? 'Mes no encontrado';
                $nombreAnio = $aniosMap[$anioId]['years'] ?? 'Año no encontrado';
            } 
            ?>

            <td data-key="mes"><?php echo $nombreMes; ?></td>
            <td data-key="anio"><?php echo $nombreAnio; ?></td>
            <td>
                <div class="alineado">
                    <label class="custom-switch mt-2" data-toggle="tooltip"
                        title="<?php echo $plan['estado'] == 1 ? 'Desactivar plan' : 'Activar plan'; ?>">
                        <input type="checkbox" name="custom-switch-checkbox-<?php echo $plan['id_planes_publicidad']; ?>"
                            class="custom-switch-input estado-switch"
                            data-id="<?php echo $plan['id_planes_publicidad']; ?>"
                            data-tipo="plan"
                            <?php echo $plan['estado'] == 1 ? 'checked' : ''; ?>>
                        <span class="custom-switch-indicator"></span>
                    </label>
                </div>
            </td>
            
            <td data-key="ordenes">
    <?php 
    // Buscar la orden activa (sin estado)
    $ordenActiva = null;
    foreach ($ordenesDelPlan as $orden) {
        if (empty($orden['estadoorden'])) {
            $ordenActiva = $orden;
            break;
        }
    }

    if ($ordenActiva): ?>
        ID <?php echo $ordenActiva['id_ordenespu']; ?> - Estado Activa 
 
    <?php else: ?>
        <span class="badge badge-secondary">Sin órdenes</span>
    <?php endif; ?>
</td>


            <td>
                <?php 
                    $id_orden_de_compra = null;
                    $planes = $plan['id_planes_publicidad'];
                    foreach ($ordenespuMap as $ordenpu) {
                        if ($ordenpu['idplanorden'] == $planes && 
                            (empty($ordenpu['estadoorden']) || is_null($ordenpu['estadoorden']))) {
                            $id_orden_de_compra = $ordenpu['id_ordenespu'];
                            break;
                        }
                    }
                ?>
                <a class="btn btn-primary micono" href="querys/modulos/orden.php?id_orden=<?php echo $id_orden_de_compra; ?>" data-toggle="tooltip" title="Ver Plan">
                    <i class="fas fa-eye"></i>
                </a>





                <a class="btn btn-success micono" href="querys/modulos/editarplan.php?id_planes_publicidad=<?php echo $plan['id_planes_publicidad']; ?>">
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


<div class="modal fade" id="agregarplan" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Alerta para mostrar el resultado de la actualización -->
                <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>

                <form id="formularioTema">
                    <!-- Campos del formulario -->
                    <div>
                        <h3 class="titulo-registro mb-3">Agregar Tema</h3>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                  
                                    <!-- Selección de clientes -->
                                    <label class="labelforms" for="id_cliente">Clientes</label>
<div class="custom-select-container">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
        </div>
        <input class="form-control" type="text" id="search-client" placeholder="Buscar cliente...">
        <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
        <input type="hidden" id="selected-client-id" name="selected-client-id" >
    </div>
    <ul id="client-list" class="client-dropdown">
        <!-- Aquí se mostrarán las opciones filtradas -->
    </ul>
</div>
<label class="labelforms" for="id_producto">Producto</label>
<div class="custom-select-container">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
        </div>
        <input class="form-control" type="text" id="search-product" placeholder="Buscar producto...">
        <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
        <input type="hidden"  id="selected-product-id" name="selected-product-id">
    </div>
    <ul id="product-list" class="client-dropdown">
        <!-- Aquí se mostrarán las opciones filtradas -->
    </ul>
</div>


                                    <!-- Demás Campos  -->
                                <div class="encuentro">
                             

                                        <label class="labelforms" for="id_campania">Campaña</label>
                                        <div class="custom-select-container">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                </div>
                                                <input class="form-control" type="text" id="search-campania" placeholder="Buscar campaña...">
                                                <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
                                                <input type="hidden"  id="selected-campania-id" name="selected-campania-id">
                                            </div>
                                            <ul id="campania-list" class="client-dropdown">
                                                <!-- Aquí se mostrarán las opciones filtradas -->
                                            </ul>
                                        </div>

                                        <label class="labelforms" for="id_contrato">Contrato</label>
                                        <div class="custom-select-container">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                </div>
                                                <input class="form-control" type="text" id="search-contrato" placeholder="Buscar contrato...">
                                                <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
                                                <input type="hidden" id="selected-contrato-id" name="selected-contrato-id">
                                            </div>
                                            <ul id="contrato-list" class="client-dropdown">
                                                <!-- Aquí se mostrarán las opciones filtradas -->
                                            </ul>
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-primary btn-lg rounded-pill" type="submit" id="agregarTemax">
                            <span class="btn-txt">Guardar Tema</span>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
    $('[data-toggle="tooltip"]').tooltip();
});
const clientesMap = <?php echo json_encode($clientesMap); ?>;
const productosMap = <?php echo json_encode($productosMap); ?>;
const campaignsMap = <?php echo json_encode($campaignsMap); ?>;
const contratosMap = <?php echo json_encode($contratosMap); ?>;

function setupSearch(searchId, listId, dataMap, textProperty, filterProperty) {
    const searchInput = document.getElementById(searchId);
    const list = document.getElementById(listId);

    // Mostrar todos los elementos al principio según el cliente seleccionado
    searchInput.addEventListener('focus', function() {
        const clientId = document.getElementById('selected-client-id').value;
        const filteredItems = dataMap.filter(item =>
            (!filterProperty || item[filterProperty] === (clientId ? parseInt(clientId, 10) : null))
        );

        if (filteredItems.length > 0) {
            list.innerHTML = filteredItems.map(item =>
                `<li data-id="${item.id}">${item[textProperty]}</li>`
            ).join('');
            list.style.display = 'block';
        } else {
            list.style.display = 'none';
        }
    });

    // Filtrar a medida que el usuario escribe
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const clientId = document.getElementById('selected-client-id').value;

        if (query.length > 0) {
            document.querySelector('.clear-btn').style.display = 'block';

            // Filtrar elementos por nombre y idCliente
            const filteredItems = dataMap.filter(item =>
                item[textProperty].toLowerCase().includes(query) &&
                (!filterProperty || item[filterProperty] === (clientId ? parseInt(clientId, 10) : null))
            );

            if (filteredItems.length > 0) {
                list.innerHTML = filteredItems.map(item =>
                    `<li data-id="${item.id}">${item[textProperty]}</li>`
                ).join('');
                list.style.display = 'block';
            } else {
                list.style.display = 'none';
            }
        } else {
            // Mostrar todos los productos cuando no hay query
            const filteredItems = dataMap.filter(item =>
                (!filterProperty || item[filterProperty] === (clientId ? parseInt(clientId, 10) : null))
            );

            if (filteredItems.length > 0) {
                list.innerHTML = filteredItems.map(item =>
                    `<li data-id="${item.id}">${item[textProperty]}</li>`
                ).join('');
                list.style.display = 'block';
            } else {
                list.style.display = 'none';
            }

            document.querySelector('.clear-btn').style.display = 'none';
        }
    });

    // Seleccionar un elemento de la lista
    list.addEventListener('click', function(event) {
        if (event.target.tagName === 'LI') {
            searchInput.value = event.target.textContent;
            document.getElementById(`selected-${searchId.replace('search-', '')}-id`).value = event.target.getAttribute('data-id');
            list.style.display = 'none';
            document.querySelector('.clear-btn').style.display = 'none';
        }
    });
}

// Inicializa la búsqueda de clientes, productos, campañas y contratos
setupSearch('search-client', 'client-list', clientesMap, 'nombreCliente');
setupSearch('search-product', 'product-list', productosMap, 'nombreProducto', 'idCliente');
setupSearch('search-campania', 'campania-list', campaignsMap, 'nombreCampania', 'idCliente');
setupSearch('search-contrato', 'contrato-list', contratosMap, 'nombreContrato', 'idCliente');

// Función para limpiar todos los campos de búsqueda
function clearSearch() {
    document.getElementById('search-client').value = '';
    document.getElementById('selected-client-id').value = '';
    document.getElementById('client-list').style.display = 'none';
    document.getElementById('search-product').value = '';
    document.getElementById('selected-product-id').value = '';
    document.getElementById('product-list').style.display = 'none';
    document.getElementById('search-campania').value = '';
    document.getElementById('selected-campania-id').value = '';
    document.getElementById('campania-list').style.display = 'none';
    document.getElementById('search-contrato').value = '';
    document.getElementById('selected-contrato-id').value = '';
    document.getElementById('contrato-list').style.display = 'none';

    document.querySelectorAll('.clear-btn').forEach(btn => btn.style.display = 'none');
}

// Ocultar las listas cuando se hace clic fuera de ellas
document.addEventListener('click', function(event) {
    const searchFields = [
        document.getElementById('search-client'),
        document.getElementById('search-product'),
        document.getElementById('search-campania'),
        document.getElementById('search-contrato')
    ];

    const lists = [
        document.getElementById('client-list'),
        document.getElementById('product-list'),
        document.getElementById('campania-list'),
        document.getElementById('contrato-list')
    ];

    if (!searchFields.some(field => field.contains(event.target)) &&
        !lists.some(list => list.contains(event.target))) {
        lists.forEach(list => list.style.display = 'none');
    }
});

</script>
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
        text: `Se encontraron ${filasFiltradas.length} Planes en el rango seleccionado.`
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
            text: 'No hay Planes para exportar.'
        });
        return;
    }

    // Preparar datos para exportación
    const datosExportar = Array.from(filasAExportar).map(fila => ({
        'Id Planes': fila.querySelector('[data-key="idplan"]').textContent,
        'Nombre Cliente': fila.querySelector('[data-key="nombrecliente"]').textContent,
        'Nombre Plan': fila.querySelector('[data-key="nombrePlan"]').textContent,
        'Fecha de Creación': fila.querySelector('[data-key="fecha_creacion"]').textContent
    }));

    // Crear libro de Excel
    const hoja = XLSX.utils.json_to_sheet(datosExportar);
    const libro = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(libro, hoja, "Planes");

    // Descargar archivo
    XLSX.writeFile(libro, 'Planes_Exportadas.xlsx');
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
        'ID': fila.querySelector('[data-key="id_plan"]').textContent,
        'Fecha': fila.querySelector('[data-key="fechaCreacion"]').textContent,
        'Nombre Plan': fila.querySelector('[data-key="nombreplan"]').textContent,
        'Nombre de Contrato': fila.querySelector('[data-key="nombre_contrato"]').textContent,
        'Cliente': fila.querySelector('[data-key="cliente"]').textContent,
        'Mes': fila.querySelector('[data-key="mes"]').textContent,
        'Año': fila.querySelector('[data-key="anio"]').textContent,
        'Orden': fila.querySelector('[data-key="ordenes"]').textContent
    }));

    const hoja = XLSX.utils.json_to_sheet(datosExportar);
    const libro = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(libro, hoja, "Planes");

    XLSX.writeFile(libro, 'Planes_Exportados.xlsx');
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
<script src="assets/js/togglePlanes.js"></script>
<?php include 'componentes/settings.php'; ?>


<?php include 'componentes/footer.php'; ?>