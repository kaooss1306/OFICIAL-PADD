
<?php
session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
$user_name = $_SESSION['user_name'];

include 'componentes/header.php';
include '../qplanes.php';
include 'componentes/sidebar.php';

// Verificar si $mesesMap y $aniosMap están disponibles
if (!isset($mesesMap) || !isset($aniosMap)) {
    die("Error: No se pudieron obtener los datos de meses y años.");
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
    ::marker {
    color: red;
}
    .product-item{text-align:left !important;}
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
.is-invalid {
    border-color: #dc3545;
}

.is-invalid ~ .invalid-feedback {
    display: block;
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
    </ol>
  </nav>
    <section class="section">
        <div style="background: white;
    width: 80% !important;
    margin: 0 auto;
    padding: 50px;">
    <form id="formularioPlan">
                    <!-- Campos del formulario -->
                    <div>
                        <h3 class="titulo-registro mb-3">Agregar Plan</h3>
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
        <input class="form-control" type="text" id="search-client" placeholder="Buscar cliente..." oninput="filterClients()" required>
        <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
        <div class="invalid-feedback">
    Por favor, seleccione un cliente.
</div>
        <input type="hidden" id="selected-client-id" name="selected-client-id">
    </div>
    <ul id="client-list" class="client-dropdown">
        <!-- Aquí se mostrarán las opciones filtradas -->
    </ul>
</div>

                                    <label class="labelforms" for="codigo">Nombre de Plan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre de Plan" name="nombrePlan" required>
                                    </div>

                                <div class="row">
                                    <div class="col">
                                        <label class="labelforms" for="id_producto">Producto</label>
                                        <div class="custom-select-container">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bi bi-box"></i></span>
                                                </div>
                                                <input class="form-control" type="text" id="search-product" placeholder="Buscar producto..." required>
                                                <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
                                                <input type="hidden" id="selected-product-id" name="selected-product-id">
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
                                                                <input class="form-control" type="text" id="search-contrato" placeholder="Buscar contrato..." required>
                                                                <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
                                                                <input type="hidden"  id="selected-contrato-id" name="selected-contrato-id">
                                                                <input type="hidden"  id="selected-proveedor-id" name="selected-proveedor-id">
                                                                <input type="hidden"  id="selected-num-contrato" name="selected-num-contrato">
                                                                                                            </div>
                                                            <ul id="contrato-list" class="client-dropdown">
                                                                <!-- Aquí se mostrarán las opciones filtradas -->
                                                            </ul>
                                                        </div>


                                        <label class="labelforms" for="id_contrato">Soportes</label>
                                        <div class="custom-select-container">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                                </div>
                                                <input class="form-control" type="text" id="search-soporte" placeholder="Buscar soporte..." required>
                                                <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
                                                <input type="hidden" id="selected-soporte-id" name="selected-soporte-id" value="">
                                            </div>
                                            <ul id="soporte-list" class="client-dropdown">
                                                <!-- Aquí se mostrarán las opciones filtradas -->
                                            </ul>
                                        </div>
                                        <label for="descripcion" class="labelforms">Detalle</label>
                                    <div class="custom-textarea-container">
                                        <textarea id="descripcion" name="descripcion" class="form-control" rows="4" placeholder="Introduce la detalle aquí..."></textarea>
                                    </div>
                                        </div>
                                        <div class="col">
                                        <label class="labelforms" for="id_campania">Campaña</label>
<div class="custom-select-container">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="bi bi-bullseye"></i></span>
        </div>
        <input class="form-control" type="text" id="search-campania" placeholder="Buscar campaña..." required>
        <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
        <input type="hidden" id="selected-campania-id" name="selected-campania-id">
        <input type="hidden" id="selected-campania-agencia" name="selected-campania-agencia">
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
        <input class="form-control" type="text" id="search-orden" placeholder="Buscar Orden..." required>
        <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
        <input  type="hidden"  id="selected-orden-id" name="selected-orden-id">
    </div>
    <ul id="orden-list" class="client-dropdown">
        <!-- Aquí se mostrarán las opciones filtradas -->
    </ul>
</div> 
                                        <label class="labelforms" for="id_campania">Temas</label>
                                        <div class="custom-select-container">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bi bi-stars"></i></span>
                                                </div>
                                                <input class="form-control" type="text" id="search-temas" placeholder="Buscar temas..." required>
                                                <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
                                                <input type="hidden" id="selected-temas-id" name="selected-temas-id" requerid>
                                                <input  type="hidden" id="selected-temas-codigo" name="selected-temas-codigo">
                                                <input type="hidden" id="selected-id-medio" name="selected-id-medio">
                                                <input type="hidden"  id="selected-id-clasificacion" name="selected-id-clasificacion">
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
                                            <select id="forma-facturacion" name="forma-facturacion" class="form-control" required>
                                                <option value="" disabled selected>Selecciona una opción</option>
                                                <option value="afecta">Afecta</option>
                                                <option value="exenta">Exenta</option>
                                                <option value="exportacion">Exportación</option>
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
        <select id="mesSelector" required>
    <option value="" disabled selected>Selecciona un mes</option>
    <?php foreach ($mesesMap as $id => $mes): ?>
        <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($mes['Nombre']); ?></option>
    <?php endforeach; ?>
</select>

<select id="anioSelector" required>
    <option value="" disabled selected>Selecciona un año</option>
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
function validateForm() {
    var form = document.getElementById('formularioPlan');
    var valid = true;

    // Validar campos requeridos
    var requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach(function(field) {
        if (!field.value.trim()) {
            valid = false;
            field.classList.add('is-invalid');
        } else {
            field.classList.remove('is-invalid');
        }
    });

    // Habilitar o deshabilitar el botón de envío
    var submitButton = document.getElementById('submitButton');
    submitButton.disabled = !valid;

    return valid; // Asegúrate de devolver el valor booleano
}

// Escuchar eventos de entrada y cambio para validar el formulario
document.getElementById('formularioPlan').addEventListener('input', validateForm);
document.getElementById('formularioPlan').addEventListener('change', validateForm);

// Validar el formulario cuando se intente enviar
document.getElementById('formularioPlan').addEventListener('submit', function(event) {
    if (!validateForm()) {
        event.preventDefault();  // Evita el envío si el formulario no es válido
    }
});
</script>

<script>

function validateDynamicField(fieldId) {
    var field = document.getElementById(fieldId);
    if (!field.value.trim()) {
        field.classList.add('is-invalid');
        return false;
    } else {
        field.classList.remove('is-invalid');
        return true;
    }
}

document.getElementById('formularioPlan').addEventListener('submit', function(event) {
    var valid = true;

    // Validar campos estáticos con required
    var requiredFields = document.querySelectorAll('[required]');
    requiredFields.forEach(function(field) {
        if (!field.value.trim()) {
            valid = false;
            field.classList.add('is-invalid');
        } else {
            field.classList.remove('is-invalid');
        }
    });

    // Validar campos dinámicos (ejemplo de validación adicional)
    valid = valid && validateDynamicField('selected-client-id');
    valid = valid && validateDynamicField('selected-product-id');

    if (!valid) {
        event.preventDefault();
        alert('Por favor, complete todos los campos obligatorios.');
    }
});



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
document.addEventListener('DOMContentLoaded', function() {
    const mesSelector = document.getElementById('mesSelector');
    const anioSelector = document.getElementById('anioSelector');
    const diasContainer = document.getElementById('diasContainer');
    const submitButton = document.getElementById('submitButton');

    console.log('Selectores:', mesSelector, anioSelector);
    console.log('Contenedor de días:', diasContainer);

    if (!mesSelector || !anioSelector || !diasContainer || !submitButton) {
        console.error('No se pudieron encontrar todos los elementos necesarios');
        return;
    }

    const mesesMap = <?php echo json_encode($mesesMap); ?>;
    const aniosMap = <?php echo json_encode($aniosMap); ?>;
    const diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

 function actualizarCalendario() {
    const mesId = parseInt(mesSelector.value);
    const anioId = parseInt(anioSelector.value);

    const mes = parseInt(mesesMap[mesId]['Id']);
    const anio = parseInt(aniosMap[anioId]['years']);

    const diasEnMes = new Date(anio, mes, 0).getDate();
    
    diasContainer.innerHTML = '';

    for (let dia = 1; dia <= diasEnMes; dia++) {
        const fecha = new Date(anio, mes - 1, dia);
        const nombreDia = diasSemana[fecha.getDay()];
        
        const diaElement = document.createElement('div');
        diaElement.className = 'dia';
        diaElement.innerHTML = `
            <div class="dia-nombre">${nombreDia}</div>
            <div class="dia-numero">${dia}</div>
            <input type="number" id="input-${anio}-${mes}-${dia}" />
        `;
        diasContainer.appendChild(diaElement);
    }

    console.log('Calendario actualizado');
}

    function recopilarDatos() {
    const mesId = parseInt(mesSelector.value);
    const anioId = parseInt(anioSelector.value);
    const mes = parseInt(mesesMap[mesId]['Id']);
    const anio = parseInt(aniosMap[anioId]['years']);
    const diasEnMes = new Date(anio, mes, 0).getDate();

    // Obtén el ID del cliente seleccionado
    const clienteId = parseInt(document.getElementById('selected-client-id').value);
 console.log(clienteId,"Holaaa");
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
        id_cliente: clienteId || 23, // Usa el ID del cliente seleccionado, o 23 como valor por defecto
        matrizCalendario: matrizCalendario
    };
}
    mesSelector.addEventListener('change', actualizarCalendario);
    anioSelector.addEventListener('change', actualizarCalendario);
    submitButton.addEventListener('click', enviarDatos);

    console.log('Inicializando calendario');
    actualizarCalendario();


    function enviarDatos() {

           // Primero, valida el formulario
    if (!validateForm()) {
        Swal.fire({
            title: 'Error',
            text: 'Por favor, completa todos los campos requeridos.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        event.preventDefault(); // Evita el envío si `matrizCalendario` está vacío
        return; // Salir de la función si el formulario no es válido
    }
 
    const datos = recopilarDatos();  // Asegúrate de que recopilarDatos() devuelva los datos correctos para la tabla "json"

// Verifica si `matrizCalendario` está vacío
if (!datos || !datos.matrizCalendario || (Array.isArray(datos.matrizCalendario) && datos.matrizCalendario.length === 0)) {
    Swal.fire({
        title: 'Advertencia',
        text: 'La matriz de calendario está vacía. Por favor, asegúrate de agregar datos a la matriz.',
        icon: 'warning',
        confirmButtonText: 'OK'
    });
    event.preventDefault(); // Evita el envío si `matrizCalendario` está vacío
    return; // Salir de la función si `matrizCalendario` está vacío
}

    console.log('Datos a enviar:', JSON.stringify(datos));

    fetch('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/json', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            'Prefer': 'return=representation' // Importante para obtener el id_calendar devuelto
        },
        body: JSON.stringify(datos)
    })
    .then(response => {
        console.log('Respuesta completa:', response);
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`HTTP error! status: ${response.status}, message: ${text}`);
            });
        }
        return response.json(); // Asumimos que la respuesta es un JSON que contiene el id_calendar
    })
    .then(data => {
        console.log('Respuesta del servidor:', data);

        // Captura el id_calendar de la respuesta
        const id_calendar = data[0].id_calendar;
        console.log('ID Calendar obtenido:', id_calendar);

        // Ahora que tienes el id_calendar, haz la segunda inserción
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
            id_calendar: id_calendar, // Usa el id_calendar obtenido
            estado: '1'
        };

        return fetch('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/PlanesPublicidad', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Prefer': 'return=representation'
            },
            body: JSON.stringify(datosPlan)
        });
    })
    .then(response => {
        console.log('Respuesta completa de la segunda inserción:', response);
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`HTTP error! status: ${response.status}, message: ${text}`);
            });
        }
        return response.json();
    })
    .then(data => {

        
        console.log('Respuesta del servidor2:', data);
        const id_planes_publicidad = data[0].id_planes_publicidad;
        const id_calendar = data[0].id_calendar;
        // Ahora, realiza la tercera inserción en la tabla "OrdenesDePublicidad"
        const datosOrden = { 
            
            id_cliente: document.getElementById('selected-client-id').value ?? null,
    num_contrato: document.getElementById('selected-contrato-id').value ?? null,
    id_proveedor: document.getElementById('selected-proveedor-id').value ?? null,
    id_soporte: document.getElementById('selected-soporte-id').value ?? null,
    id_tema: document.getElementById('selected-temas-id').value ?? null,
    id_plan: id_planes_publicidad,
    id_calendar: id_calendar,
    Megatime: document.getElementById('selected-temas-codigo').value ?? null,
    id_agencia: document.getElementById('selected-campania-agencia').value ?? null,
    id_clasificacion: document.getElementById('selected-id-clasificacion').value || null,
    numero_orden: document.getElementById('selected-orden-id').value ?? null,
            estado: '1'
            
           
             // Usa el id_calendar obtenido
         }; // Copia los datos de datosPlan, puedes modificar lo necesario después
         console.log(datosOrden,"holaaa");
        return fetch('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenesDePublicidad', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            },
            body: JSON.stringify(datosOrden)
        });
    })
    .then(response => {
        console.log('Respuesta completa de la tercera inserción:', response);
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`HTTP error! status: ${response.status}, message: ${text}`);
            });
        }
        return response.text();
    })
    .then(data => {
        
        console.log('Tercera inserción exitosa:', data);
        Swal.fire({
            title: '¡Éxito!',
            text: 'Los datos se han guardado correctamente.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading()
                window.location.href = '/ListPlanes.php';
            }
        });
    })
    .catch(error => {
        console.error('Error al guardar los datos:', error);
        Swal.fire({
            title: 'Error',
            text: 'Error al guardar los datos: ' + error.message,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
}

   
});

async function obtenerUltimoIdPlanesPublicidad() {
    try {
        let response = await fetch("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/PlanesPublicidad?select=id_planes_publicidad&order=id_planes_publicidad.desc&limit=1", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "apikey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9zZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
                "Authorization": "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9zZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc"
            }
        });

        if (response.ok) {
            const planesPublicidad = await response.json();
            const ultimoRegistro = planesPublicidad[0];
            const ultimoId = ultimoRegistro ? ultimoRegistro.id_planes_publicidad : null;
            return ultimoId;
        } else {
            console.error("Error al obtener el último ID de PlanesPublicidad:", await response.text());
            throw new Error("Error al obtener el último ID de PlanesPublicidad");
        }
    } catch (error) {
        console.error("Error en la solicitud:", error);
        throw error;
    }
}

function showLoading() {
    let loadingElement = document.getElementById('custom-loading');
    if (!loadingElement) {
        loadingElement = document.createElement('div');
        loadingElement.id = 'custom-loading';
        loadingElement.innerHTML = `
            <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.8); display: flex; justify-content: center; align-items: center; z-index: 9999;">
                <img src="/assets/img/loading.gif" alt="Cargando..." style="width: 220px; height: 135px;">
            </div>
        `;
        document.body.appendChild(loadingElement);
    }
    loadingElement.style.display = 'block';
}
</script>


<?php include '../../componentes/settings.php'; ?>


<?php include '../../componentes/footer.php'; ?>