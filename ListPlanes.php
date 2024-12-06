<?php
// Iniciar la sesión
session_start();

include './querys/qplanes.php';
// Función para hacer peticiones cURL


// Obtener datos
$campaigns = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Campania?select=*');
$clientes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes?select=*');
$contratos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Contratos?select=*');
$planes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/PlanesPublicidad?select=*');
$meses = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Meses?select=*');
$anos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Anios?select=*');
$productos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Productos?select=*');
$jsonData = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/json?select=*');
$calendarMap = [];

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
                            <div class="table-responsive">
                                <table class="table table-striped" id="tableExportadora">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre Contrato</th>
                                            <th>Cliente</th>
                                            <th>Nombre plan</th>
                                            <th>Mes</th>
                                            <th>Año</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php foreach ($planes as $plan): ?>
<tr>
    <td><?php echo $plan['id_planes_publicidad']; ?></td>
    <td><?php echo isset($contratosMap[$plan['id_contrato']]) ? $contratosMap[$plan['id_contrato']]['nombreContrato'] : 'N/A'; ?></td>

    <td>
    <?php 
    $idCliente = $contratosMap[$plan['id_contrato']]['idCliente'];
    echo isset($clientesMap[$idCliente]) ? $clientesMap[$idCliente] : 'N/A'; 
    ?>
</td>
    <td><?php echo $plan['NombrePlan']; ?></td>
    <?php 
// Si ya es un array, simplemente usa el array directamente
$datosRecopilados = $plan['datosRecopilados'];

// Inicializa las variables antes del bloque condicional
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
    
    <td><?php echo $nombreMes; ?></td>
    <td><?php echo $nombreAnio; ?></td>
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
<td>
                                            <a class="btn btn-primary micono"href="views/viewPlan.php?id=<?php echo $plan['id_planes_publicidad']; ?>" data-toggle="tooltip" title="Ver Proveedor"><i class="fas fa-eye "></i></a> 

                                                <a class="btn btn-success micono" href="querys/modulos/editarplan.php?id_planes_publicidad=<?php echo $plan['id_planes_publicidad']; ?>"><i class="fas fa-pencil-alt"></i></a>
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

<script src="assets/js/togglePlanes.js"></script>
<?php include 'componentes/settings.php'; ?>


<?php include 'componentes/footer.php'; ?>