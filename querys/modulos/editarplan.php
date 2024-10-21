
<?php
session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
$user_name = $_SESSION['user_name'];

include '../qplanes.php';


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_planes_publicidad'])) {
    // Obtener el ID del plan de la URL y convertirlo a entero
    $id_planes_publicidad = (int) $_GET['id_planes_publicidad'];

    // Obtener todos los planes desde Supabase
  
    // Verificar que $planes es un array y tiene datos
    if (!is_array($planes) || empty($planes)) {
        echo "No se obtuvieron datos de los planes.";
        exit;
    }

    // Buscar el plan que coincida con el ID
    $plan = null;
    foreach ($planes as $item) {
        if ((int) $item['id_planes_publicidad'] === (int) $id_planes_publicidad) {
            $plan = $item;
            break;
        }
    }

    // Verifica si se encontró el plan
    if ($plan === null) {
        echo "No se encontró el plan publicitario.";
        exit;
    }

   
} else {
    echo "ID del plan no proporcionado.";
}
// Verifica si la respuesta contiene datos
if (is_array($ordenepublicidad) && !empty($ordenepublicidad)) {
    $id_ordenes_de_comprar = $ordenepublicidad[0]['id_ordenes_de_comprar'];
    $id_ordenes_de_comprar2 = $ordenepublicidad[0]['id_agencia'];
    $id_ordenes_de_comprar3 = $ordenepublicidad[0]['num_contrato'];
    $id_ordenes_de_comprar4 = $ordenepublicidad[0]['id_proveedor'];
    $id_ordenes_de_comprar5 = $ordenepublicidad[0]['Megatime'];
    $id_ordenes_de_comprar6 = $ordenepublicidad[0]['id_clasificacion'];
    $id_ordenes_de_comprar7 = $ordenepublicidad[0]['numero_orden'];

    

 
    $nombreOrdenx = isset($ordenMap[$id_ordenes_de_comprar7]) ? $ordenMap[$id_ordenes_de_comprar7]['NombreOrden'] : 'Nombre no disponible';

} else {
    $id_ordenes_de_comprar = null; // O algún valor por defecto si no se encuentra el dato
    $id_ordenes_de_comprar2 = null;
    $id_ordenes_de_comprar3 = null;
    $id_ordenes_de_comprar4 = null;
}

// Verificar si $mesesMap y $aniosMap están disponibles
if (!isset($mesesMap) || !isset($aniosMap)) {
    die("Error: No se pudieron obtener los datos de meses y años.");
}
$id_producto = $plan['id_producto'];
$nombreProducto = isset($productosMap2[$id_producto]) ? $productosMap2[$id_producto] : "Nombre no disponible";
$id_cliente = $plan['id_cliente'];

// Obtener el nombre del cliente basado en el ID
$nombreCliente = isset($clientesMap2[$id_cliente]) ? $clientesMap2[$id_cliente] : "Nombre no disponible";
$id_contrato = $plan['id_contrato'];

// Obtener el nombre del contrato basado en el ID
$nombreContrato = isset($contratosMap2[$id_contrato]) ? $contratosMap2[$id_contrato] : "Nombre no disponible";
$id_soporte = $plan['id_soporte'];

// Obtener el nombre del soporte basado en el ID
$nombreSoporte = isset($soportesMap2[$id_soporte]) ? $soportesMap2[$id_soporte] : "Nombre no disponible";
$id_campania = $plan['id_campania'];

// Obtener el nombre de la campaña basado en el ID
$nombreCampania = isset($campaignsMap2[$id_campania]) ? $campaignsMap2[$id_campania] : "Nombre no disponible";
$id_tema = $plan['id_temas'];

// Obtener el nombre del tema basado en el ID
$nombreTema = isset($temasMap2[$id_tema]['NombreTema']) ? $temasMap2[$id_tema]['NombreTema'] : "Nombre no disponible";
$idMedio = isset($temasMap2[$id_tema]['id_medio']) ? $temasMap2[$id_tema]['id_medio'] : "ID Medio no disponible";
$selectedFrFactura = $plan['fr_factura'];
$id_calendar = $plan['id_calendar'];
$matrizCalendario = isset($calendarMap2[$id_calendar]) ? $calendarMap2[$id_calendar] : [];

// Determinar el mes y año iniciales a partir de la matrizCalendario
$mesInicial = isset($matrizCalendario[0]) ? $matrizCalendario[0]['mes'] : date('n');
$anioInicial = isset($matrizCalendario[0]) ? $matrizCalendario[0]['anio'] : date('Y');
$anioID = null; // Variable para almacenar el ID

foreach ($anios2 as $anio) {
    if ($anio['years'] == $anioInicial) {
        $anioID = $anio['id'];
        break; // Salir del bucle una vez encontrado
    }
}
include '../../componentes/header.php';

include '../../componentes/sidebar.php';
?>
<style>
 .calendario {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        padding: 20px;
        max-width: 100%;
        width: 100%;
    }
    .selectores {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    ::marker {
    color: red;
}
    .product-item{text-align:left !important;}
    #mesSelector, #anioSelector {
        flex: 1;
        padding: 10px;
        font-size: 16px;
        background-color: white;
        border: 1px solid #d2d2d2;
    }
    .dias {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 10px;
    }
    .dia {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }
    .dia input {
        width: 100%;
        padding: 5px;
        margin-top: 5px;
        box-sizing: border-box;
    }
    .dia-numero {
        font-size: 14px;
        color: #888;
        margin-bottom: 5px;
    }
    #submitButton {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    #submitButton:hover {
        background-color: #0056b3;
    }
.custom-select-container {
    position: relative;
    width: 100%;
}

.client-dropdown {
    border:1px solid #ff0000;
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
      <li class="breadcrumb-item active" aria-current="page"><?php echo $plan['NombrePlan']; ?></li>
    </ol>
  </nav>
    <section class="section">
        <div style="background: white;
    width: 80% !important;
    margin: 0 auto;
    padding: 50px;">
    <form id="formularioEditPlan">
                    <!-- Campos del formulario -->
                    <div>
                        <h3 class="titulo-registro mb-3">Editar Plan</h3>
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
                                            <input class="form-control" type="text" value="<?php echo htmlspecialchars($nombreCliente); ?>" id="search-client" placeholder="Buscar cliente...">
                                            <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
                                            <input  type="hidden"  id="selected-client-id" value="<?php echo $id_cliente; ?>" name="selected-client-id" >
                                            <input type="hidden"  id="selected-calendar-id" value="<?php echo $plan['id_calendar']; ?>" name="selected-calendar-id" >
                                            <input type="hidden" id="selected-plan-id" value="<?php echo $id_planes_publicidad; ?>" name="selected-plan-id" >
                                            <input   type="hidden" id="ordenpublicidad-id" value="<?php echo htmlspecialchars($id_ordenes_de_comprar); ?>" name="ordenpublicidad-id" >
                                        </div>
                                        <ul id="client-list" class="client-dropdown">
                                            <!-- Aquí se mostrarán las opciones filtradas -->
                                        </ul>
                                    </div>

                                    <label class="labelforms" for="codigo">Nombre de Plan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre de Plan" name="nombrePlan" value="<?php echo $plan['NombrePlan']; ?>">
                                    </div>
                                    
                                <div class="row">
                                    <div class="col">
                                        <label class="labelforms" for="id_producto">Producto</label>
                                        <div class="custom-select-container">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                </div>
                                                <input class="form-control" type="text" id="search-product" value="<?php echo htmlspecialchars($nombreProducto); ?>" placeholder="Buscar producto...">
                                                <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
                                                <input type="hidden"  id="selected-product-id" name="selected-product-id" value="<?php echo $plan['id_producto']; ?>" >
                                            </div>
                                            <ul id="product-list" class="client-dropdown">
                                                <!-- Aquí se mostrarán las opciones filtradas -->
                                            </ul>
                                        </div>
                            
                                        <label class="labelforms" for="id_contrato">Contrato</label>
                                                        <div class="custom-select-container">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                                                                </div>
                                                                <input class="form-control" type="text" id="search-contrato" value="<?php echo htmlspecialchars($nombreContrato); ?>" placeholder="Buscar contrato...">
                                                                <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
                                                                <input  type="hidden"  id="selected-contrato-id" name="selected-contrato-id" value="<?php echo $plan['id_contrato']; ?>">
                                                                <input  type="hidden"  id="selected-proveedor-id" name="selected-proveedor-id" value="<?php echo htmlspecialchars($id_ordenes_de_comprar4); ?>">
                                                                <input type="hidden"   id="selected-num-contrato" name="selected-num-contrato" value="<?php echo htmlspecialchars($id_ordenes_de_comprar3); ?>">
                                                            </div>
                                                            <ul id="contrato-list" class="client-dropdown">
                                                                <!-- Aquí se mostrarán las opciones filtradas -->
                                                            </ul>
                                                        </div>


                                        <label class="labelforms" for="id_contrato">Soportes</label>
                                        <div class="custom-select-container">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                </div>
                                                <input class="form-control" type="text" id="search-soporte" value="<?php echo htmlspecialchars($nombreSoporte); ?>" placeholder="Buscar soporte...">
                                                <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
                                                <input  type="hidden"  id="selected-soporte-id" name="selected-soporte-id" value="<?php echo $plan['id_soporte']; ?>">
                                            </div>
                                            <ul id="soporte-list" class="client-dropdown">
                                                <!-- Aquí se mostrarán las opciones filtradas -->
                                            </ul>
                                        </div>
                                        <label for="descripcion" class="labelforms">Detalle</label>
                                    <div class="custom-textarea-container">
                                    <textarea id="descripcion" name="descripcion" class="form-control" rows="4" placeholder="Introduce el detalle aquí..."><?php echo htmlspecialchars($plan['detalle']); ?></textarea>                                    </div>
                                        </div>
                                        <div class="col">
                                        <label class="labelforms" for="id_campania">Campaña</label>
                                        <div class="custom-select-container">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                </div>
                                                <input class="form-control" type="text" value="<?php echo htmlspecialchars($nombreCampania); ?>" id="search-campania" placeholder="Buscar campaña...">
                                                <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
                                                <input  type="hidden"  id="selected-campania-id" name="selected-campania-id" value="<?php echo $plan['id_campania']; ?>">
                                                <input type="hidden"  id="selected-campania-agencia" name="selected-campania-agencia" value="<?php echo htmlspecialchars($id_ordenes_de_comprar2); ?>">
                                            </div>
                                            <ul id="campania-list" class="client-dropdown">
                                                <!-- Aquí se mostrarán las opciones filtradas -->
                                            </ul>
                                        </div>
                                        <label class="labelforms" for="id_orden_compra">Orden de compra</label>
<div class="custom-select-container">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
        </div>
        <input class="form-control" type="text" id="search-orden" value="<?php echo htmlspecialchars($nombreOrdenx); ?>" placeholder="Buscar Orden...">
        <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
        <input  type="hidden"  id="selected-orden-id" name="selected-orden-id" value="<?php echo htmlspecialchars($id_ordenes_de_comprar7); ?>">
    </div>
    <ul id="orden-list" class="client-dropdown">
        <!-- Aquí se mostrarán las opciones filtradas -->
    </ul>
</div> 
                                        <label class="labelforms" for="id_campania">Temas</label>
                                        <div class="custom-select-container">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                </div>
                                                <input class="form-control" type="text" id="search-temas" value="<?php echo htmlspecialchars($nombreTema); ?>" placeholder="Buscar temas...">
                                                <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
                                                <input  type="hidden"  id="selected-temas-id" name="selected-temas-id" value="<?php echo $plan['id_temas']; ?>">
                                                <input  type="hidden" id="selected-temas-codigo" name="selected-temas-codigo" value="<?php echo htmlspecialchars($id_ordenes_de_comprar5); ?>">
                                                <input  type="hidden" id="selected-id-medio" name="selected-id-medio" value="<?php echo htmlspecialchars($idMedio); ?>">
                                                <input  type="hidden" id="selected-id-clasificacion" name="selected-id-clasificacion" value="<?php echo htmlspecialchars($id_ordenes_de_comprar6); ?>">
                                            </div>
                                            <ul id="temas-list" class="client-dropdown">
                                                <!-- Aquí se mostrarán las opciones filtradas -->
                                            </ul>
                                        </div>  
                                        <label for="forma-facturacion" class="labelforms">Forma de facturación</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                </div>
                                                <select id="forma-facturacion" name="forma-facturacion" class="form-control">
    <option value="" disabled <?php echo ($selectedFrFactura === '') ? 'selected' : ''; ?>>Selecciona una opción</option>
    <option value="afecta" <?php echo ($selectedFrFactura === 'afecta') ? 'selected' : ''; ?>>Afecta</option>
    <option value="exenta" <?php echo ($selectedFrFactura === 'exenta') ? 'selected' : ''; ?>>Exenta</option>
    <option value="exportacion" <?php echo ($selectedFrFactura === 'exportacion') ? 'selected' : ''; ?>>Exportación</option>
</select>
                                        </div>
                                            </div>
                                        </div>
                                    
                          


                                  
                                 </div>
                                </div>
                       
                        </div>
                    </div>
                    <div >
    <div class="calendario">
        <div class="selectores">
            <select id="mesSelector">
                <?php foreach ($mesesMap as $id => $mes): ?>
                    <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($mes['Nombre']); ?></option>
                <?php endforeach; ?>
            </select>
            <select id="anioSelector">
                <?php foreach ($aniosMap as $id => $anio): ?>
                    <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($anio['years']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="diasContainer" class="dias"></div>
        
    </div>
</div>
                    <div class="d-flex justify-content-end mt-3">
                        <button id="submitButton" class="btn btn-primary btn-lg rounded-pill" type="submit" >
                            <span class="btn-txt">Guardar Plan</span>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                        </button>
                    </div>
                </form>
                </div>
    </section>
</div>


<script>
// Asignar clientes desde PHP al script
const clientes = <?php echo json_encode($clientesMap); ?>;

// Función para mostrar todas las opciones cuando se hace clic en el input
function showAllClients() {
    const clientList = document.getElementById("client-list");
    
    // Limpiar la lista antes de mostrar todos los resultados
    clientList.innerHTML = '';
    
    clientes.forEach(cliente => {
        const li = document.createElement("li");
        li.textContent = cliente.nombreCliente;
        li.setAttribute("data-id", cliente.id);
        li.classList.add("client-item");
        li.onclick = function() {
            selectClient(cliente.id, cliente.nombreCliente);
        };
        clientList.appendChild(li);
    });
    
    clientList.style.display = "block"; // Mostrar lista
}

// Función para mostrar las opciones filtradas
function filterClients() {
    const searchInput = document.getElementById("search-client").value.toLowerCase();
    const clientList = document.getElementById("client-list");

    // Limpiar la lista antes de mostrar resultados
    clientList.innerHTML = '';

    // Filtrar clientes según el valor del input
    const filteredClients = clientes.filter(cliente => cliente.nombreCliente.toLowerCase().includes(searchInput));

    if (filteredClients.length === 0) {
        clientList.style.display = "none";
    } else {
        clientList.style.display = "block";
        filteredClients.forEach(cliente => {
            const li = document.createElement("li");
            li.textContent = cliente.nombreCliente;
            li.setAttribute("data-id", cliente.id);
            li.classList.add("client-item");
            li.onclick = function() {
                selectClient(cliente.id, cliente.nombreCliente);
            };
            clientList.appendChild(li);
        });
    }

    // Mostrar el botón de limpiar si hay algo en el input
    document.querySelector(".clear-btn").style.display = searchInput ? 'inline' : 'none';
}

// Función para seleccionar un cliente de la lista
function selectClient(id, nombreCliente) {
    document.getElementById("search-client").value = nombreCliente;
    document.getElementById("selected-client-id").value = id;

    // Limpiar la lista de opciones una vez seleccionado
    document.getElementById("client-list").style.display = "none";
}

// Función para limpiar la búsqueda
function clearSearch() {
    document.getElementById("search-client").value = '';
    document.getElementById("selected-client-id").value = '';
    document.getElementById("client-list").style.display = "none";
    document.querySelector(".clear-btn").style.display = 'none';
}

// Función para cerrar el dropdown si se hace clic fuera
document.addEventListener('click', function(event) {
    const searchInput = document.getElementById('search-client');
    const clientList = document.getElementById('client-list');
    
    // Si el clic está fuera del campo de búsqueda y de la lista de opciones
    if (!searchInput.contains(event.target) && !clientList.contains(event.target)) {
        clientList.style.display = 'none';
    }
});

// Mostrar todos los clientes cuando el input es clickeado
document.getElementById("search-client").addEventListener('click', function() {
    const searchInput = document.getElementById("search-client").value;
    
    // Si el campo de búsqueda está vacío, mostrar todos los clientes
    if (searchInput === '') {
        showAllClients();
    }
});

// Asignar productos desde PHP al script
const productos = <?php echo json_encode($productosMap); ?>;

// Función para mostrar productos asociados al cliente seleccionado
function showProductsForClient() {
    const clientId = document.getElementById("selected-client-id").value;
    const productList = document.getElementById("product-list");

    // Limpiar la lista antes de mostrar los productos
    productList.innerHTML = '';

    // Filtrar productos según el cliente seleccionado
    const filteredProducts = productos.filter(producto => producto.idCliente === parseInt(clientId));

    if (filteredProducts.length === 0) {
        productList.style.display = "none";
    } else {
        productList.style.display = "block";
        filteredProducts.forEach(producto => {
            const li = document.createElement("li");
            li.textContent = producto.nombreProducto;
            li.setAttribute("data-id", producto.id);
            li.classList.add("product-item");
            li.onclick = function() {
                selectProduct(producto.id, producto.nombreProducto);
            };
            productList.appendChild(li);
        });
    }
}

// Función para mostrar todos los productos filtrados por búsqueda
function filterProducts() {
    const searchInput = document.getElementById("search-product").value.toLowerCase();
    const clientId = document.getElementById("selected-client-id").value;
    const productList = document.getElementById("product-list");

    // Limpiar la lista antes de mostrar resultados
    productList.innerHTML = '';

    // Filtrar productos según el valor del input y el cliente seleccionado
    const filteredProducts = productos.filter(producto =>
        producto.idCliente === parseInt(clientId) &&
        producto.nombreProducto.toLowerCase().includes(searchInput)
    );

    if (filteredProducts.length === 0) {
        productList.style.display = "none";
    } else {
        productList.style.display = "block";
        filteredProducts.forEach(producto => {
            const li = document.createElement("li");
            li.textContent = producto.nombreProducto;
            li.setAttribute("data-id", producto.id);
            li.classList.add("product-item");
            li.onclick = function() {
                selectProduct(producto.id, producto.nombreProducto);
            };
            productList.appendChild(li);
        });
    }

    // Mostrar el botón de limpiar si hay algo en el input
    document.querySelector(".clear-btn").style.display = searchInput ? 'inline' : 'none';
}

// Función para seleccionar un producto de la lista
function selectProduct(id, nombreProducto) {
    document.getElementById("search-product").value = nombreProducto;
    document.getElementById("selected-product-id").value = id;

    // Limpiar la lista de opciones una vez seleccionado
    document.getElementById("product-list").style.display = "none";
}

// Función para cerrar el dropdown si se hace clic fuera (aplicable para productos también)
document.addEventListener('click', function(event) {
    const searchInputProduct = document.getElementById('search-product');
    const productList = document.getElementById('product-list');
    
    // Si el clic está fuera del campo de búsqueda y de la lista de opciones de productos
    if (!searchInputProduct.contains(event.target) && !productList.contains(event.target)) {
        productList.style.display = 'none';
    }
});

// Mostrar productos del cliente cuando el input es clickeado
document.getElementById("search-product").addEventListener('click', function() {
    const clientId = document.getElementById("selected-client-id").value;

    // Si hay un cliente seleccionado, mostrar sus productos
    if (clientId) {
        showProductsForClient();
    }
});
function clearSearchProduct() {
    document.getElementById("search-product").value = '';
    document.getElementById("selected-product-id").value = '';
    document.getElementById("product-list").style.display = "none";
    document.querySelector(".clear-btn").style.display = 'none';
}

// Asignar contratos desde PHP al script
const contratos = <?php echo json_encode($contratosMap); ?>;

// Función para mostrar contratos asociados al cliente seleccionado
function showContractsForClient() {
    const clientId = document.getElementById("selected-client-id").value;
    const contratoList = document.getElementById("contrato-list");

    // Limpiar la lista antes de mostrar los contratos
    contratoList.innerHTML = '';

    // Filtrar contratos según el cliente seleccionado
    const filteredContracts = contratos.filter(contrato => contrato.idCliente === parseInt(clientId));

    if (filteredContracts.length === 0) {
        contratoList.style.display = "none";
    } else {
        contratoList.style.display = "block";
        filteredContracts.forEach(contrato => {
            const li = document.createElement("li");
            li.textContent = contrato.nombreContrato;
            li.setAttribute("data-id", contrato.id);
            li.setAttribute("data-proveedor-id", contrato.idProveedor);
            li.setAttribute("data-num-contrato", contrato.num_contrato);
            li.setAttribute("data-agencia-id", contrato.IdAgencias);
            li.classList.add("contract-item");
            li.onclick = function() {
                selectContract(contrato);
            };
            contratoList.appendChild(li);
        });
    }
}

// Función para mostrar todos los contratos filtrados por búsqueda
function filterContracts() {
    const searchInput = document.getElementById("search-contrato").value.toLowerCase();
    const clientId = document.getElementById("selected-client-id").value;
    const contratoList = document.getElementById("contrato-list");

    // Limpiar la lista antes de mostrar resultados
    contratoList.innerHTML = '';

    // Filtrar contratos según el valor del input y el cliente seleccionado
    const filteredContracts = contratos.filter(contrato =>
        contrato.idCliente === parseInt(clientId) &&
        contrato.nombreContrato.toLowerCase().includes(searchInput)
    );

    if (filteredContracts.length === 0) {
        contratoList.style.display = "none";
    } else {
        contratoList.style.display = "block";
        filteredContracts.forEach(contrato => {
            const li = document.createElement("li");
            li.textContent = contrato.nombreContrato;
            li.setAttribute("data-id", contrato.id);
            li.setAttribute("data-proveedor-id", contrato.idProveedor);
            li.setAttribute("data-num-contrato", contrato.num_contrato);
            li.setAttribute("data-agencia-id", contrato.IdAgencias);
            li.classList.add("contract-item");
            li.onclick = function() {
                selectContract(contrato);
            };
            contratoList.appendChild(li);
        });
    }

    // Mostrar el botón de limpiar si hay algo en el input
    document.querySelector(".clear-btn").style.display = searchInput ? 'inline' : 'none';
}

// Función para seleccionar un contrato de la lista
function selectContract(contrato) {
    document.getElementById("search-contrato").value = contrato.nombreContrato;
    document.getElementById("selected-contrato-id").value = contrato.id;
    document.getElementById("selected-proveedor-id").value = contrato.idProveedor;
    document.getElementById("selected-num-contrato").value = contrato.num_contrato;


    // Limpiar la lista de opciones una vez seleccionado
    document.getElementById("contrato-list").style.display = "none";
}

// Función para cerrar el dropdown si se hace clic fuera (aplicable para contratos también)
document.addEventListener('click', function(event) {
    const searchInputContrato = document.getElementById('search-contrato');
    const contratoList = document.getElementById('contrato-list');
    
    // Si el clic está fuera del campo de búsqueda y de la lista de opciones de contratos
    if (!searchInputContrato.contains(event.target) && !contratoList.contains(event.target)) {
        contratoList.style.display = 'none';
    }
});

// Mostrar contratos del cliente cuando el input es clickeado
document.getElementById("search-contrato").addEventListener('click', function() {
    const clientId = document.getElementById("selected-client-id").value;

    // Si hay un cliente seleccionado, mostrar sus contratos
    if (clientId) {
        showContractsForClient();
    }
});
function clearSearchContrato() {
    document.getElementById("search-contrato").value = '';
    document.getElementById("selected-contrato-id").value = '';
    document.getElementById("selected-proveedor-id").value = '';
    document.getElementById("selected-num-contrato").value = '';
    document.getElementById("contrato-list").style.display = "none";
    document.querySelector(".clear-btn").style.display = 'none';
}
// Map de soportes
const soportesMap = <?php echo json_encode($soportesMap); ?>;

const searchSoporteInput = document.getElementById('search-soporte');
const soporteList = document.getElementById('soporte-list');
const selectedSoporteIdInput = document.getElementById('selected-soporte-id');

// Evento de búsqueda de soportes
searchSoporteInput.addEventListener('input', function () {
    const searchTerm = searchSoporteInput.value.toLowerCase();
    const selectedProveedorId = document.getElementById('selected-proveedor-id').value;

    // Filtrar los soportes que coinciden con el término de búsqueda y el idProveedor
    const filteredSoportes = soportesMap.filter(soporte =>
        soporte.nombreSoporte.toLowerCase().includes(searchTerm) &&
        soporte.idProveedor == selectedProveedorId
    );

    // Mostrar los soportes en el dropdown
    renderSoporteDropdown(filteredSoportes);
});

// Mostrar lista al hacer clic en el input
searchSoporteInput.addEventListener('focus', function () {
    const selectedProveedorId = document.getElementById('selected-proveedor-id').value;

    if (selectedProveedorId) {
        const filteredSoportes = soportesMap.filter(soporte => soporte.idProveedor == selectedProveedorId);
        renderSoporteDropdown(filteredSoportes);
    }
});

// Función para renderizar el dropdown de soportes
function renderSoporteDropdown(soportes) {
    soporteList.innerHTML = '';

    if (soportes.length === 0) {
        soporteList.innerHTML = '<li>No se encontraron soportes.</li>';
        return;
    }

    soportes.forEach(soporte => {
        const li = document.createElement('li');
        li.textContent = soporte.nombreSoporte;
        li.dataset.id = soporte.id;
        li.classList.add('client-dropdown-item');
        
        li.addEventListener('click', function () {
            selectedSoporteIdInput.value = soporte.id;
            searchSoporteInput.value = soporte.nombreSoporte;
            soporteList.style.display = 'none'; // Cerrar el dropdown
        });

        soporteList.appendChild(li);
    });

    soporteList.style.display = 'block';
}

// Cerrar el dropdown al hacer clic fuera del mismo
document.addEventListener('click', function (event) {
    if (!event.target.closest('.custom-select-container')) {
        soporteList.style.display = 'none';
    }
});

// Función para limpiar la búsqueda
function clearSearch() {
    searchSoporteInput.value = '';
    selectedSoporteIdInput.value = '';
    soporteList.style.display = 'none';
}

const campaigns = <?php echo json_encode($campaignsMap); ?>;
// Función para mostrar campañas asociadas al cliente seleccionado
function showCampaignsForClient() {
    const clientId = document.getElementById("selected-client-id").value;
    const campaniaList = document.getElementById("campania-list");

    // Limpiar la lista antes de mostrar las campañas
    campaniaList.innerHTML = '';

    // Filtrar campañas según el cliente seleccionado
    const filteredCampaigns = campaigns.filter(campaign => campaign.idCliente === parseInt(clientId));

    if (filteredCampaigns.length === 0) {
        campaniaList.style.display = "none";
    } else {
        campaniaList.style.display = "block";
        filteredCampaigns.forEach(campaign => {
            const li = document.createElement("li");
            li.textContent = campaign.nombreCampania;
            li.setAttribute("data-id", campaign.id);
            li.classList.add("campaign-item");
            li.onclick = function() {
                selectCampaign(campaign);
            };
            campaniaList.appendChild(li);
        });
    }
}

// Función para mostrar todas las campañas filtradas por búsqueda
function filterCampaigns() {
    const searchInput = document.getElementById("search-campania").value.toLowerCase();
    const clientId = document.getElementById("selected-client-id").value;
    const campaniaList = document.getElementById("campania-list");

    // Limpiar la lista antes de mostrar resultados
    campaniaList.innerHTML = '';

    // Filtrar campañas según el valor del input y el cliente seleccionado
    const filteredCampaigns = campaigns.filter(campaign =>
        campaign.idCliente === parseInt(clientId) &&
        campaign.nombreCampania.toLowerCase().includes(searchInput)
    );

    if (filteredCampaigns.length === 0) {
        campaniaList.style.display = "none";
    } else {
        campaniaList.style.display = "block";
        filteredCampaigns.forEach(campaign => {
            const li = document.createElement("li");
            li.textContent = campaign.nombreCampania;
            li.setAttribute("data-id", campaign.id);
            li.classList.add("campaign-item");
            li.onclick = function() {
                selectCampaign(campaign);
            };
            campaniaList.appendChild(li);
        });
    }

    // Mostrar el botón de limpiar si hay algo en el input
    document.querySelector(".clear-btn").style.display = searchInput ? 'inline' : 'none';
}

// Función para seleccionar una campaña de la lista
function selectCampaign(campaign) {
    document.getElementById("search-campania").value = campaign.nombreCampania;
    document.getElementById("selected-campania-id").value = campaign.id;
    document.getElementById("selected-campania-agencia").value = campaign.IdAgencias; 
    // Limpiar la lista de opciones una vez seleccionado
    document.getElementById("campania-list").style.display = "none";
}

// Mostrar campañas del cliente cuando el input es clickeado
document.getElementById("search-campania").addEventListener('click', function() {
    const clientId = document.getElementById("selected-client-id").value;

    // Si hay un cliente seleccionado, mostrar sus campañas
    if (clientId) {
        showCampaignsForClient();
    }
});

// Función para cerrar el dropdown si se hace clic fuera
document.addEventListener('click', function(event) {
    const searchInputCampania = document.getElementById('search-campania');
    const campaniaList = document.getElementById('campania-list');
    
    // Si el clic está fuera del campo de búsqueda y de la lista de opciones de campañas
    if (!searchInputCampania.contains(event.target) && !campaniaList.contains(event.target)) {
        campaniaList.style.display = 'none';
    }
});

// Función para limpiar la búsqueda de campañas
function clearSearchCampania() {
    document.getElementById("search-campania").value = '';
    document.getElementById("selected-campania-id").value = '';
    document.getElementById("campania-list").style.display = "none";
    document.querySelector(".clear-btn").style.display = 'none';
}

const ordenes = <?php echo json_encode($ordenMap); ?>;
// Función para mostrar las órdenes asociadas a la campaña seleccionada
function showOrdenesForCampania() {
    const campaniaId = document.getElementById("selected-campania-id").value;
    const ordenList = document.getElementById("orden-list");

    // Limpiar la lista antes de mostrar las órdenes
    ordenList.innerHTML = '';

    // Filtrar órdenes según la campaña seleccionada
    const filteredOrdenes = ordenes.filter(orden => orden.id_campania === parseInt(campaniaId));

    if (filteredOrdenes.length === 0) {
        ordenList.style.display = "none";
    } else {
        ordenList.style.display = "block";
        filteredOrdenes.forEach(orden => {
            const li = document.createElement("li");
            li.textContent = orden.NombreOrden;
            li.setAttribute("data-id", orden.id_orden_compra);
            li.classList.add("orden-item");
            li.onclick = function() {
                selectOrden(orden);
            };
            ordenList.appendChild(li);
        });
    }
}

// Función para filtrar órdenes por búsqueda y campaña seleccionada
function filterOrdenes() {
    const searchInput = document.getElementById("search-orden").value.toLowerCase();
    const campaniaId = document.getElementById("selected-campania-id").value;
    const ordenList = document.getElementById("orden-list");

    // Limpiar la lista antes de mostrar resultados
    ordenList.innerHTML = '';

    // Filtrar órdenes según el valor del input y la campaña seleccionada
    const filteredOrdenes = ordenes.filter(orden =>
        orden.id_campania === parseInt(campaniaId) &&
        orden.NombreOrden.toLowerCase().includes(searchInput)
    );

    if (filteredOrdenes.length === 0) {
        ordenList.style.display = "none";
    } else {
        ordenList.style.display = "block";
        filteredOrdenes.forEach(orden => {
            const li = document.createElement("li");
            li.textContent = orden.NombreOrden;
            li.setAttribute("data-id", orden.id_orden_compra);
            li.classList.add("orden-item");
            li.onclick = function() {
                selectOrden(orden);
            };
            ordenList.appendChild(li);
        });
    }

    // Mostrar el botón de limpiar si hay algo en el input
    document.querySelector(".clear-btn").style.display = searchInput ? 'inline' : 'none';
}

// Función para seleccionar una orden de la lista
function selectOrden(orden) {
    document.getElementById("search-orden").value = orden.NombreOrden;
    document.getElementById("selected-orden-id").value = orden.id_orden_compra;

    // Limpiar la lista de opciones una vez seleccionada
    document.getElementById("orden-list").style.display = "none";
}

// Mostrar órdenes de la campaña cuando el input es clickeado
document.getElementById("search-orden").addEventListener('click', function() {
    const campaniaId = document.getElementById("selected-campania-id").value;

    // Si hay una campaña seleccionada, mostrar sus órdenes
    if (campaniaId) {
        showOrdenesForCampania();
    }
});

// Función para cerrar el dropdown si se hace clic fuera
document.addEventListener('click', function(event) {
    const searchInputOrden = document.getElementById('search-orden');
    const ordenList = document.getElementById('orden-list');
    
    // Si el clic está fuera del campo de búsqueda y de la lista de órdenes
    if (!searchInputOrden.contains(event.target) && !ordenList.contains(event.target)) {
        ordenList.style.display = 'none';
    }
});

// Función para limpiar la búsqueda de órdenes
function clearSearch() {
    document.getElementById("search-orden").value = '';
    document.getElementById("selected-orden-id").value = '';
    document.getElementById("orden-list").style.display = "none";
    document.querySelector(".clear-btn").style.display = 'none';
}

const campaniaTemasMap = <?php echo json_encode($campaniaTemasMap); ?>;
const temasMap = <?php echo json_encode($temasMap); ?>;

// Función para mostrar temas asociados a la campaña seleccionada
function showTemasForCampaign() {
    const campaignId = document.getElementById("selected-campania-id").value;
    const temasList = document.getElementById("temas-list");

    // Limpiar la lista antes de mostrar los temas
    temasList.innerHTML = '';

    // Obtener los temas relacionados a la campaña seleccionada usando campaniaTemasMap
    const temasRelacionados = campaniaTemasMap[campaignId] || [];

    // Filtrar los temas del temasMap que coincidan con los id_temas de campaniaTemasMap
    const filteredTemas = temasMap.filter(tema => temasRelacionados.includes(tema.id));

    if (filteredTemas.length === 0) {
        temasList.style.display = "none";
    } else {
        temasList.style.display = "block";
        filteredTemas.forEach(tema => {
            const li = document.createElement("li");
            li.textContent = tema.nombreTema;
            li.setAttribute("data-id", tema.id);
            li.setAttribute("data-codigo", tema.CodigoMegatime);
            li.setAttribute("data-medio", tema.id_medio);
            li.classList.add("tema-item");
            li.onclick = function() {
                selectTema(tema);
            };
            temasList.appendChild(li);
        });
    }
}

// Función para filtrar los temas por búsqueda
function filterTemas() {
    const searchInput = document.getElementById("search-temas").value.toLowerCase();
    const campaignId = document.getElementById("selected-campania-id").value;
    const temasList = document.getElementById("temas-list");

    // Limpiar la lista antes de mostrar resultados
    temasList.innerHTML = '';

    // Obtener los temas relacionados a la campaña seleccionada usando campaniaTemasMap
    const temasRelacionados = campaniaTemasMap[campaignId] || [];

    // Filtrar los temas del temasMap que coincidan con los id_temas de campaniaTemasMap y el valor del input
    const filteredTemas = temasMap.filter(tema =>
        temasRelacionados.includes(tema.id) &&
        tema.nombreTema.toLowerCase().includes(searchInput)
    );

    if (filteredTemas.length === 0) {
        temasList.style.display = "none";
    } else {
        temasList.style.display = "block";
        filteredTemas.forEach(tema => {
            const li = document.createElement("li");
            li.textContent = tema.nombreTema;
            li.setAttribute("data-id", tema.id);
            li.setAttribute("data-codigo", tema.CodigoMegatime);
            li.setAttribute("data-medio", tema.id_medio);
            li.classList.add("tema-item");
            li.onclick = function() {
                selectTema(tema);
            };
            temasList.appendChild(li);
        });
    }

    // Mostrar el botón de limpiar si hay algo en el input
    document.querySelector(".clear-btn").style.display = searchInput ? 'inline' : 'none';
}

// Función para seleccionar un tema de la lista
function selectTema(tema) {
    document.getElementById("search-temas").value = tema.nombreTema;
    document.getElementById("selected-temas-id").value = tema.id;
    document.getElementById("selected-temas-codigo").value = tema.CodigoMegatime;
    document.getElementById("selected-id-medio").value = tema.id_medio;

    // Llamada a la función fetchIdClasificacion para obtener la clasificación
    fetchIdClasificacion(tema.id_medio).then(idClasificacion => {
        if (idClasificacion) {
            document.getElementById("selected-id-clasificacion").value = idClasificacion;
        } else {
            document.getElementById("selected-id-clasificacion").value = '';
            console.error('No se encontró la clasificación para este id_medio.');
        }
    });

    // Limpiar la lista de opciones una vez seleccionado
    document.getElementById("temas-list").style.display = "none";
}
async function fetchIdClasificacion(id_medio) {
    const url = `https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Medios?id=eq.${id_medio}&select=Id_Clasificacion`;

    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        if (data.length > 0) {
            return data[0].Id_Clasificacion;
        } else {
            console.error('No se encontró el id_medio.');
            return null;
        }
    } catch (error) {
        console.error('Error:', error);
        return null;
    }
}

// Mostrar temas de la campaña cuando el input es clickeado
document.getElementById("search-temas").addEventListener('click', function() {
    const campaignId = document.getElementById("selected-campania-id").value;

    // Si hay una campaña seleccionada, mostrar sus temas
    if (campaignId) {
        showTemasForCampaign();
    }
});

// Función para cerrar el dropdown si se hace clic fuera
document.addEventListener('click', function(event) {
    const searchInputTemas = document.getElementById('search-temas');
    const temasList = document.getElementById('temas-list');
    
    // Si el clic está fuera del campo de búsqueda y de la lista de opciones de temas
    if (!searchInputTemas.contains(event.target) && !temasList.contains(event.target)) {
        temasList.style.display = 'none';
    }
});

// Función para limpiar la búsqueda de temas
function clearSearch() {
    document.getElementById("search-temas").value = '';
    document.getElementById("selected-temas-id").value = '';
    document.getElementById("selected-temas-codigo").value = '';
    document.getElementById("temas-list").style.display = "none";
    document.querySelector(".clear-btn").style.display = 'none';
}

</script>
<script>
    const mesesMap = <?php echo json_encode($mesesMap); ?>;
    const aniosMap = <?php echo json_encode($aniosMap); ?>;
    const calendarMap2 = <?php echo json_encode($calendarMap2); ?>;
    const idCalendar = <?php echo json_encode($plan['id_calendar']); ?>;
    const iniciall = <?php echo json_encode($anioInicial); ?>
    console.log('Meses Map:', mesesMap);
    console.log('Años Map:', aniosMap);
    console.log('Calendar Map2:', calendarMap2);
    console.log('ID del Calendario:', idCalendar);
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var anioID = <?php echo json_encode($anioID); ?>;
    console.log('El ID para el año es:', anioID);
    mesSelector.value = <?php echo $mesInicial; ?>;
anioSelector.value = <?php echo json_encode($anioID); ?>;

const diasContainer = document.getElementById('diasContainer');
const submitButton = document.getElementById('submitButton');

if (!mesSelector || !anioSelector || !diasContainer || !submitButton) {
    console.error('No se pudieron encontrar todos los elementos necesarios');
    return;
}

const mesesMap = <?php echo json_encode($mesesMap); ?>;
const aniosMap = <?php echo json_encode($aniosMap); ?>;
const calendarMap2 = <?php echo json_encode($calendarMap2); ?>;
const idCalendar = <?php echo json_encode($plan['id_calendar']); ?>;

console.log('ID del Calendario:', idCalendar);
console.log('Contenido de aniosMap:', aniosMap);

function actualizarCalendario() {
    const mesId = parseInt(mesSelector.value);
    const anioId = parseInt(anioSelector.value);

    console.log('Valor de anioSelector:', anioSelector.value, 'anioId:', anioId);
    console.log('Mes seleccionado:', mesId, mesesMap[mesId]);
    console.log('Año seleccionado:', anioId, aniosMap[anioId]);

    if (isNaN(anioId)) {
        console.error('El valor de anioId no es un número válido:', anioSelector.value);
        return;
    }

    if (!aniosMap[anioId] || typeof aniosMap[anioId].years === 'undefined') {
        console.error('No se encontró el año en aniosMap:', anioId);
        return;
    }

    const mes = parseInt(mesesMap[mesId]['Id']);
    const anio = parseInt(aniosMap[anioId]['years']);
    const diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    console.log('Mes y año para cálculos:', mes, anio);

    const diasEnMes = new Date(anio, mes, 0).getDate();
    console.log('Días en el mes:', diasEnMes);

    diasContainer.innerHTML = '';

    const matrizCalendario = calendarMap2[idCalendar] || [];

    for (let dia = 1; dia <= diasEnMes; dia++) {

        const fecha = new Date(anio, mes - 1, dia);
        const nombreDia = diasSemana[fecha.getDay()];

        const diaElement = document.createElement('div');
        diaElement.className = 'dia';

        // Busca si hay datos guardados para este día
        const datosDia = matrizCalendario.find(item => item.dia === dia && item.mes === mes && item.anio === anio);
        const cantidad = datosDia ? datosDia.cantidad : '';

        diaElement.innerHTML = `
         <div class="dia-nombre">${nombreDia}</div>
            <div class="dia-numero">${dia}</div>
            <input type="number" id="input-${anio}-${mes}-${dia}" value="${cantidad}" />
        `;
        diasContainer.appendChild(diaElement);
    }

    console.log('Calendario actualizado con los datos existentes.');
}

function recopilarDatos() {
    const mesId = parseInt(mesSelector.value);
    const anioId = parseInt(anioSelector.value);
    const mes = parseInt(mesesMap[mesId]['Id']);
    const anio = parseInt(aniosMap[anioId]['years']);
    const diasEnMes = new Date(anio, mes, 0).getDate();

    // Obtén el ID del cliente seleccionado
    const clienteId = parseInt(document.getElementById('selected-client-id').value);
    const id_calendar = parseInt(document.getElementById('selected-calendar-id').value); 

    const matrizCalendario = [];

    for (let dia = 1; dia <= diasEnMes; dia++) {
        const input = document.getElementById(`input-${anio}-${mes}-${dia}`);
        if (input && input.value) {
            matrizCalendario.push({
                mes: mes,
                anio: anio,
                dia: dia,
                cantidad: parseInt(input.value)
            });
        }
    }

    return {
        id_calendar: id_calendar,  // Incluye el id_calendar en los datos
        id_cliente: clienteId || 23, // Usa el ID del cliente seleccionado, o 23 como valor por defecto
        matrizCalendario: matrizCalendario,
   
    };
}

mesSelector.addEventListener('change', actualizarCalendario);
anioSelector.addEventListener('change', actualizarCalendario);
submitButton.addEventListener('click', enviarDatos);

console.log('Inicializando calendario');
actualizarCalendario();

const id_calendar = <?php echo json_encode($id_calendar); ?>;
const id_planes_publicidad = <?php echo json_encode($id_planes_publicidad); ?>;
console.log(id_planes_publicidad,"asdad" );
console.log(id_calendar,"asdad2" );
function enviarDatos() {
    const datos = recopilarDatos();  // Asegúrate de que recopilarDatos() devuelva los datos correctos para la tabla "json"

    // Usa el id_planes_publicidad ya existente
    const id_planes_publicidad = document.getElementById('selected-plan-id').value;
    const id_ordenes_de_comprar = document.getElementById('ordenpublicidad-id').value; // Obtén el valor del campo oculto
    console.log(id_ordenes_de_comprar,"ordenesctm");
    // Actualización del registro en la tabla "json"
    fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/json?id_calendar=eq.${id_calendar}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
                'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Prefer': 'return=representation'
        },
        body: JSON.stringify(datos)
    })
    .then(response => {
        console.log('Respuesta completa de la actualización del calendario:', response);
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`HTTP error! status: ${response.status}, message: ${text}`);
            });
        }
        return response.json();  // Asumimos que la respuesta es un JSON
    })
    .then(data => {
        console.log('Respuesta del servidor al actualizar calendario:', data);

        // Preparar los datos para la segunda actualización
        const datosPlan = {
            NombrePlan: document.querySelector('input[name="nombrePlan"]').value,
            id_cliente: document.getElementById('selected-client-id').value,
            id_producto: document.getElementById('selected-product-id').value,
            id_contrato: document.getElementById('selected-contrato-id').value,
            id_soporte: document.getElementById('selected-soporte-id').value,
            detalle: document.getElementById('descripcion').value,
            id_campania: document.getElementById('selected-campania-id').value,
            id_temas: document.getElementById('selected-temas-id').value,
            fr_factura: document.getElementById('forma-facturacion').value,
            id_calendar: id_calendar, // Usa el id_calendar existente
            id_planes_publicidad: id_planes_publicidad
        };
        console.log(datosPlan,"datosplan");
        // Actualización del registro en la tabla "PlanesPublicidad"
        return fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/PlanesPublicidad?id_planes_publicidad=eq.${id_planes_publicidad}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            },
            body: JSON.stringify(datosPlan)
        });
    })
    .then(response => {
        console.log('Respuesta completa de la actualización del plan:', response);
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`HTTP error! status: ${response.status}, message: ${text}`);
            });
        }
        return response.text();
    })
    .then(data => {
        console.log('Actualización del plan exitosa:', data);

        // Preparar los datos para la tercera actualización
        const datosOrdenpublicidad = {
            // Agrega los campos necesarios aquí
            // Ejemplo:
            id_cliente: document.getElementById('selected-client-id').value,
            num_contrato: document.getElementById('selected-contrato-id').value,
            id_proveedor: document.getElementById('selected-proveedor-id').value,
            id_soporte: document.getElementById('selected-soporte-id').value,
            id_tema: document.getElementById('selected-temas-id').value,
            id_plan: id_planes_publicidad,
            id_calendar: id_calendar,
            id_ordenes_de_comprar: id_ordenes_de_comprar,
            Megatime: document.getElementById('selected-temas-codigo').value,
            id_agencia: document.getElementById('selected-campania-agencia').value,
            id_clasificacion: document.getElementById('selected-id-clasificacion').value === "" ? null : document.getElementById('selected-id-clasificacion').value,
            numero_orden: document.getElementById('selected-orden-id').value
        };

        // Actualización del registro en la tabla "OrdenesDePublicidad"
        return fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenesDePublicidad?id_ordenes_de_comprar=eq.${id_ordenes_de_comprar}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Prefer': 'return=representation'
            },
            body: JSON.stringify(datosOrdenpublicidad)
        });
    })
    .then(response => {
        console.log('Respuesta completa de la actualización de OrdenesDePublicidad:', response);
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`HTTP error! status: ${response.status}, message: ${text}`);
            });
        }
        return response.text();
    })
    .then(data => {
        console.log('Actualización de OrdenesDePublicidad exitosa:', data);
        Swal.fire({
            title: '¡Éxito!',
            text: 'Los datos se han actualizado correctamente.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/ListPlanes.php';
            }
        });
    })
    .catch(error => {
        console.error('Error al actualizar los datos:', error);
        Swal.fire({
            title: 'Error',
            text: 'Error al actualizar los datos: ' + error.message,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
}

   
});
</script>


<?php include '../../componentes/settings.php'; ?>


<?php include '../../componentes/footer.php'; ?>