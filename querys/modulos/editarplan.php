
<?php
session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
$user_name = $_SESSION['user_name'];
$nombre_usuario = $_SESSION["user"]["Nombres"] ?? "Usuario";

// Capturar correo de usuario
$correoUsuario = $_SESSION['user_email'] ?? 'Correo No Disponible';

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
$id_orden_de_compra = null;
$copia = null;
$numerodeorden = null;
foreach ($ordenespuMap as $ordenpu) {
    if ($ordenpu['idplanorden'] == $id_planes_publicidad && 
        (empty($ordenpu['estadoorden']) || is_null($ordenpu['estadoorden']))) {
        $id_orden_de_compra = $ordenpu['id_ordenespu'];
        $numerodeorden = $ordenpu['numerodeorden'];
        $copia = $ordenpu['numerodeordenremplaza'];
        
        break;
    }
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

$contratoSeleccionado = null;
foreach ($contratosMap as $contrato) {
    if ($contrato['id'] == $id_contrato) {
        $contratoSeleccionado = $contrato;
        break;
    }
}

// Si se encontró el contrato, puedes extraer sus variables
if ($contratoSeleccionado) {
    $nombreContrato = $contratoSeleccionado['nombreContrato'];
    $idProveedor = $contratoSeleccionado['idProveedor'];
    $numContrato = $contratoSeleccionado['num_contrato'];
    $idCliente = $contratoSeleccionado['idCliente'];
    $idAnio = $contratoSeleccionado['id_Anio'];
    $idMes = $contratoSeleccionado['id_Mes'];
}




$id_soporte = $plan['id_soporte'];

// Obtener el nombre del soporte basado en el ID
$nombreSoporte = isset($soportesMap2[$id_soporte]) ? $soportesMap2[$id_soporte] : "Nombre no disponible";
$id_campania = $plan['id_campania'];

// Obtener el nombre de la campaña basado en el ID
$nombreCampania = isset($campaignsMap2[$id_campania]) ? $campaignsMap2[$id_campania] : "Nombre no disponible";
$id_tema = $plan['id_temas'];
$nombreTema = isset($temasMap2[$id_tema]['NombreTema']) ? $temasMap2[$id_tema]['NombreTema'] : "Nombre no disponible";
$programas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Programas?select=*');
// Obtener el nombre del tema basado en el ID

$idMedio = isset($temasMap2[$id_tema]['id_medio']) ? $temasMap2[$id_tema]['id_medio'] : "ID Medio no disponible";
$selectedFrFactura = $plan['fr_factura'];
// Ejemplo de datos obtenidos de la base de datos (asumiendo JSON decode)
$datosRecopilados = $plan['datosRecopilados']['datos'];
$tipoitem = $plan['tipo_item'];
// Mapear los datos recopilados a un formato utilizable en el formulario
$programasTemasData = [];
foreach ($datosRecopilados as $dato) {
    $programasTemasData[] = [
        'programa_id' => $dato['programa_id'],
        'tema_id' => $dato['tema_id'],
        'calendario' => $dato['calendario'],
        'descuento' => $dato['descuento'],
        'valor_neto' => $dato['valor_neto'],
        'valor_bruto' => $dato['valor_bruto'],
        'segundos' => $dato['segundos'],
        'clasificacion' => $dato['clasificacion'],
        'valor_total' => $dato['valor_total']
    ];
}

include '../../componentes/header.php';

include '../../componentes/sidebar.php';
?>
<style>

/* Para navegadores Webkit (Chrome, Safari, etc.) */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Para Firefox */
input[type="number"] {
    -moz-appearance: textfield;
}


td.text-end.fw-bold {
    border-color: transparent !important;
    padding: 14px 10px;
}
.table.table-bordered td, .table.table-bordered th {
    border-color: transparent;
}
.nameusu{color: #6878f2; font-weight: 700; font-size: 20px;}
.correusu{font-size:16px; color:black;}
.totalestotales{padding-top:30px;}
.finishtab{font-family:"Nunito","Segoe UI",arial !important;}
 .calendario {
    margin-top: 20px;
    margin-bottom: 10px;
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
        display: flex;
    }
    .dia {
        border: 1px solid #ddd;
        padding: 0px 0px 5px 0px;
        text-align: center;
    }
    ::marker {
    color: red;
}
.remove-group-btn{margin-left:10px; padding: 0px;
    border-radius: 100px;
    height: 25px;
    width: 25px;}
.add-group-btn{padding: 0px;
    border-radius: 100px;
    height: 25px;
    width: 25px;}
    .product-item{text-align:left !important;}
    .dia input {
        font-size:10px;
        width: 60%;
        padding: 0px;
        margin-top: 5px;
        box-sizing: border-box;
    }
    .dia-numero {
        font-size: 10px;
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
.programas-temas-group{
    border: 1px solid #f04d37;
    border-radius: 10px;
    padding: 10px;
    margin-top: 20px;
}
.contenedor-nuo{margin-top:10px; display:flex;}
.titfun{margin-left:20px;}

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
    <form id="formularioPlan">
        <input type="hidden" value="<?php echo $id_orden_de_compra;?>">
                    <!-- Campos del formulario -->
                    <div><div class="fountun"><div><h3 class="titulo-registro mb-3">Editar Plan</h3> </div><div class="sau titulot2"><span>AÑO /</span><span id="selected-year-span"></span></div></div>
                        
                        <div class="row">
                            <div class="col">
                        
                                <div class="form-group">
                  
                                    <!-- Selección de clientes -->
                                   
                                   
                                <div class="row"> 

                                    <div class="col">
                                    <label class="labelforms" for="codigo">Numero de Orden</label>
<div class="input-group">
    <div class="input-group-prepend">
        <span class="input-group-text"><i class="bi bi-123"></i></span>
    </div>
    <input type="number" class="form-control" id="numerodeOrden" value="<?php echo $plan['numerodeorden']; ?>" placeholder="Numero de Orden" name="numerodeOrden" readonly required>
 
</div>
                                                                                    <label class="labelforms" for="id_cliente">Clientes</label>
                                                <div class="custom-select-container">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                        </div>
                                                        <input class="form-control" type="text"  value="<?php echo htmlspecialchars($nombreCliente); ?>" id="search-client" placeholder="Buscar cliente..." oninput="filterClients()" required>
                                                        <button type="button" class="clear-btnCliente" style="display:none;" onclick="clearSearchCliente()">x</button>
                                                        <div class="invalid-feedback">
                                                    Por favor, seleccione un cliente.
                                                </div>
                                                        <input  type="hidden"  id="selected-client-id" value="<?php echo $id_cliente; ?>" name="selected-client-id" >
                                                                                            <input type="hidden" id="selected-plan-id" value="<?php echo $id_planes_publicidad; ?>" name="selected-plan-id" >
                                                                                            <input   type="hidden" id="ordenpublicidad-id" value="<?php echo htmlspecialchars($id_ordenes_de_comprar); ?>" name="ordenpublicidad-id" >
                                                    </div>
                                                    <ul id="client-list" class="client-dropdown">
                                                        <!-- Aquí se mostrarán las opciones filtradas -->
                                                    </ul>
                                                </div>

                                        <label class="labelforms" for="id_producto">Producto</label>
                                        <div class="custom-select-container">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bi bi-box"></i></span>
                                                </div>
                                                <input class="form-control" type="text" value="<?php echo htmlspecialchars($nombreProducto); ?>" id="search-product" placeholder="Buscar producto..." required>
                                                <button type="button" class="clear-btnProducto" style="display:none;" onclick="clearSearchProducto()">x</button>
                                                <div class="invalid-feedback">
                                                    Por favor, seleccione un Producto.
                                                </div>
                                                <input type="hidden" id="selected-product-id" value="<?php echo $plan['id_producto']; ?>" name="selected-product-id">
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
                                                                <input class="form-control" type="text" value="<?php echo htmlspecialchars($nombreContrato); ?>" id="search-contrato" placeholder="Buscar contrato..." required>
                                                                <button type="button" class="clear-btnContrato" style="display:none;" onclick="clearSearchContrato()">x</button>
                                                                <div class="invalid-feedback">
                                                    Por favor, seleccione un Contrato y recuerda actualizar tu calendario.
                                                </div>
                                                                <input type="hidden"  id="selected-contrato-id" value="<?php echo htmlspecialchars($id_contrato); ?>" name="selected-contrato-id">
                                                                <input type="hidden"  id="selected-proveedor-id" value="<?php echo htmlspecialchars($idProveedor); ?>" name="selected-proveedor-id">
                                                                <input type="hidden"  id="selected-num-contrato" value="<?php echo htmlspecialchars($numContrato); ?>" name="selected-num-contrato">
                                                                <input type="hidden" class="selected-anio" value="<?php echo htmlspecialchars($idAnio); ?>" id="selected-anio" name="selected-anio">
                                                                <input type="hidden" class="selected-mes" value="<?php echo htmlspecialchars($idMes); ?>" id="selected-mes" name="selected-mes">
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
                                                <input class="form-control" type="text" value="<?php echo htmlspecialchars($nombreSoporte); ?>" id="search-soporte" placeholder="Buscar soporte..." required>
                                                <button type="button" class="clear-btnSoporte" style="display:none;" onclick="clearSearchSoporte()">x</button>
                                                <input type="hidden" id="selected-soporte-id" value="<?php echo $plan['id_soporte']; ?>" name="selected-soporte-id" value="">
                                            </div>
                                            <ul id="soporte-list" class="client-dropdown">
                                                <!-- Aquí se mostrarán las opciones filtradas -->
                                            </ul>
                                        </div>

                                       


                                       
                                        </div>

                                        <div class="col">
                                        <label class="labelforms" for="codigo">Nombre de Plan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre de Plan" value="<?php echo $plan['NombrePlan']; ?>" name="nombrePlan" required>
                                    </div>

                                                    <label class="labelforms" for="id_campania">Campaña</label>
                                                        <div class="custom-select-container">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="bi bi-bullseye"></i></span>
                                                                </div>
                                                                <input class="form-control" type="text" value="<?php echo htmlspecialchars($nombreCampania); ?>" id="search-campania" placeholder="Buscar campaña..." required>
                                                                <button type="button" class="clear-btnCampaña" style="display:none;" onclick="clearSearchCampania()">x</button>
                                                                <input  type="hidden"  id="selected-campania-id" name="selected-campania-id" value="<?php echo $plan['id_campania']; ?>">
                                                                <input type="hidden"  id="selected-campania-agencia" name="selected-campania-agencia" value="<?php echo htmlspecialchars($id_ordenes_de_comprar2); ?>">
                                                            </div>
                                                            <ul id="campania-list" class="client-dropdown">
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
                                              <!-- Final ROw -->
                                    </div>
                                    <div id="programasTemasContainer">
                                        
                                        <div class="programas-temas-group">
                                            <div class="contenedor-nuo">
                                        <button type="button" class="add-group-btn" onclick="addProgramasTemasGroup()">+</button>
                                        <button type="button" class="remove-group-btn" onclick="removeProgramasTemasGroup(this)" style="display:none;">-</button>
                                        <p class="titfun">Agregar / Eliminar nuevo bloque.</p></div>
                                                <div class="row">
                                                    <div class="col-6"> <!-- Columna para el primer conjunto de label + input -->
                                                                    <label class="labelforms" for="id_campania">Temas</label>
                                                                    <div class="custom-select-container">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="bi bi-stars"></i></span>
                                                                            </div>
                                                                            <input class="form-control search-temas" type="text" id="search-temas" placeholder="Buscar temas..." required>
                                                                            
                                                                            <input type="hidden" class="selected-temas-id" id="selected-temas-id" name="selected-temas-id" required>
                                                                            <input type="hidden" id="selected-temas-codigo" name="selected-temas-codigo">
                                                                            <input type="hidden" id="selected-id-medio" name="selected-id-medio">
                                                                            <input type="hidden" id="selected-id-clasificacion" name="selected-id-clasificacion">
                                                                        </div>
                                                                        <ul id="temas-list" class="client-dropdown temas-list">
                                                                            <!-- Aquí se mostrarán las opciones filtradas -->
                                                                        </ul>
                                                                    </div>
                                                                </div>
    
                                                                <div class="col-3"> <!-- Columna para el segundo conjunto de label + input -->
                                                                    <label class="labelforms" for="codigo">Segundos</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="bi bi-clock"></i></span> <!-- Cambio de ícono a reloj -->
                                                                        </div>
                                                                        <input id="selected-segundos" class="form-control selected-segundos" name="selected-segundos" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3"> <!-- Columna para el segundo conjunto de label + input -->

                                                                <label class="labelforms" for="id_producto">Clasificación</label>
                                        <div class="custom-select-container">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="bi bi-box"></i></span>
                                                </div>
                                                <input class="form-control" type="text" id="search-clasificacion" placeholder="Buscar Clasificación..." required>
                                                <button type="button" class="clear-btn" style="display:none;" onclick="clearSearch()">x</button>
                                                <input type="hidden" class="selected-clasi" id="selected-clasi" name="selected-clasi">
                                            </div>
                                            <ul id="clasificacion-list" class="client-dropdown">
                                                <!-- Aquí se mostrarán las opciones filtradas -->
                                            </ul>
                                        </div>
                                                                </div>
                                                                                                                       
                                                    </div>
                                                    <div class="row"> <!-- Usamos row para hacer un contenedor de las columnas -->
                                                                <div class="col-6"> <!-- Columna para el primer conjunto de label + input -->
                                                                <label class="labelforms" for="id_programa">Programas</label>
                                                                                                                    <div class="custom-select-container">
                                                                                                                    <div class="input-group">
                                                                                                                    <div class="input-group-prepend">
                                                                                                                        <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                                                                                                    </div>
                                                                                                                    <input class="form-control search-programa" type="text" id="search-programa" placeholder="Buscar programa..." required>
                                                                                                                    
                                                                                                                    <input type="hidden" class="selected-programa-id" id="selected-programa-id" name="selected-programa-id" value="">
                                                                                                                    </div>
                                                                                                                    <ul id="programa-list" class="programa-list client-dropdown">
                                                                                                                        <!-- Aquí se mostrarán las opciones filtradas -->
                                                                                                                    </ul>
                                                                                                                    </div>
                                                                </div>

                                                                                                                <div class="col-3">
                                                                                                                    <label class="labelforms" for="hora-inicio">Hora inicio</label>
                                                                                                                    <div class="input-group">
                                                                                                                        <div class="input-group-prepend">
                                                                                                                            <span class="input-group-text"><i class="bi bi-hourglass"></i></span> <!-- Ícono de reloj de arena -->
                                                                                                                        </div>
                                                                                                                        <input id="hora-inicio" class="form-control hora-inicio" name="hora-inicio" readonly>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <!-- Columna para la Hora de Fin -->
                                                                                                                <div class="col-3">
                                                                                                                    <label class="labelforms" for="hora-fin">Hora Fin</label>
                                                                                                                    <div class="input-group">
                                                                                                                        <div class="input-group-prepend">
                                                                                                                            <span class="input-group-text"><i class="bi bi-stopwatch"></i></span> <!-- Ícono de cronómetro -->
                                                                                                                        </div>
                                                                                                                        <input id="hora-fin" class="form-control hora-fin" name="hora-fin" readonly>
                                                                                                                    </div>
                                                                                                                </div>
                                               
                                                    </div>

                            <div >
                            <div class="calendario">
    <div class="selectores">
        <select class="mesSelector" id="mesSelector">
            <option value="" disabled selected>Selecciona un mes</option>
            <?php foreach ($mesesMap as $id => $mes): ?>
                <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($mes['Nombre']); ?></option>
            <?php endforeach; ?>
        </select>
        <div><label>
            <input type="checkbox" class="fillAllCheckbox" /> Rellenar todas las casillas
        </label>
        <input type="number" class="fillAllInput" placeholder="Valor para rellenar" disabled /></div>
    </div>
    <div class="diasContainer dias"></div>
</div>
                                                    </div>
                                                    <div class="row">
            <div class="col-md-3 mb-3">
              <label for="estado" class="form-label">Valor Neto</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                <input type="number" class="selected-valorneto form-control" id="ValorNeto" name="ValorNeto" required>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="estado" class="form-label">Valor Bruto</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                <input type="number" class="selected-valorbruto form-control" id="ValorBruto" name="ValorBruto" required>
              </div>
            </div>
            <div class="col-md-3 mb-3">
                      <label for="estado" class="form-label">Descuento</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                        <input type="number" class="selected-descuentov form-control" id="Descuento1" name="Descuento1" value="0" required>
                      </div>
                    </div>
            
            <div class="col-md-3 mb-3">
              <label for="estado" class="form-label">Valor Total</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                <input type="number" class="selected-valortotal form-control" id="ValorTotal" name="ValorTotal" required>
              </div>
            </div>
        </div>                                                                                          
    </div>
</div>

                                    <!-- Final ROw --> 
                                    <div class="row">
    <div class="col-6">
        <label class="labelforms" for="codigo">Tipo de item</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="bi bi-chevron-down"></i></span> <!-- Ícono de lista desplegable -->
            </div>
            <!-- Aquí se reemplaza el input por un select -->
            <select id="selected-tipo" class="form-control selected-tipo" name="selected-tipo">
                <option value="<?php echo $plan['tipo_item']; ?>" disabled selected><?php echo $plan['tipo_item']; ?></option>
                <option value="AUSPICIO">AUSPICIO</option>
                <option value="PAUTA LIBRE">PAUTA LIBRE</option>
                <option value="VPS">VPS</option>
                <option value="CPR">CPR</option>
                <option value="CPM">CPM</option>
                <option value="CPC">CPC</option>
                <option value="BONIF.">BONIF.</option>
                <option value="CANJE">CANJE</option>
            </select>
        </div>
    </div>
</div>


                                     <div class="row">
                                     <div class="col">
                                            <label for="descripcion" class="labelforms">Detalle</label>
                                            <div class="custom-textarea-container">
                                                <textarea id="descripcion" name="descripcion" class="form-control" rows="4" placeholder="Introduce la detalle aquí..."><?php echo $plan['detalle']; ?></textarea>
                                            </div>
                                            
                                     </div>
                                     </div> 
                                     <div class="totalestotales"></div>
                                     <div style="margin-top:30px; display: flex; justify-content: flex-end; text-align: center; width: 100%;">
    <div>
        <input class="nombreuser" hidden value="<?php echo $nombre_usuario ?>">
        <input class="correouser" hidden value="<?php echo $correoUsuario ?>">
        <span class="nameusu"><?php echo $nombre_usuario ?></span><br>
        <span class="correusu"><?php echo $correoUsuario ?></span>
    </div>
</div>                 
                                                            


                                                                    
                                                                    </div>
                                                                    </div>
                                                        
                                                            </div>
                                                        </div>
                <!-- PRUEBASS -->
                                                   
                <div class="d-flex justify-content-end mt-3">
        <button id="submitButton" class="btn btn-primary btn-lg rounded-pill" type="submit">
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



    return valid; // Asegúrate de devolver el valor booleano
}


// Validar el formulario cuando se intente enviar
document.getElementById('formularioPlan').addEventListener('submit', function(event) {
    if (!validateForm()) {
        event.preventDefault();  // Evita el envío si el formulario no es válido
    }
});


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

   
});
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formularioPlan');
    const submitButton = document.getElementById('submitButton');

    // Prevenir el envío tradicional del formulario
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Esto es crucial para evitar el refresh
        
        if (!validateForm()) {
            Swal.fire({
                title: 'Error',
                text: 'Por favor, completa todos los campos requeridos.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        enviarDatos();
    });
});
// Función para recopilar datos
function recopilarUsuario() {
    const nombreusers = document.querySelector('.nombreuser')?.value || null;
    const correousers = document.querySelector('.correouser')?.value || null;

    return {
        nombreusuario: nombreusers,
        correousuario: correousers
    };
}

// Función para recopilar datos
function recopilarDatos() {
    
    const grupos = document.querySelectorAll('.programas-temas-group');
    const datosRecopilados = [];
    const anioId = parseInt(document.getElementById('selected-anio').value);
    // Obtener los valores del contrato
        // Variables para calcular totales
    let valorBrutoTotal = 0;
    let valorNetoTotal = 0;
    let descuentoTotal = 0;
    let valorTotalTotal = 0;
    
    grupos.forEach(grupo => {

        const mesId = grupo.querySelector('.mesSelector')?.value || null;
        const segund = grupo.querySelector('.selected-segundos')?.value || null;
        const idclasi = grupo.querySelector('.selected-clasi')?.value || null;
        const programaId = grupo.querySelector('.selected-programa-id')?.value || null;
        const temaId = grupo.querySelector('.selected-temas-id')?.value || null;
        const valorN = parseFloat(grupo.querySelector('.selected-valorneto')?.value || 0);
        const valorB = parseFloat(grupo.querySelector('.selected-valorbruto')?.value || 0);
        const valorT = parseFloat(grupo.querySelector('.selected-valortotal')?.value || 0);
        const descuentoV = parseFloat(grupo.querySelector('.selected-descuentov')?.value || 0);
        const diasContainer = grupo.querySelector('.diasContainer');
        
        if (isNaN(mesId) || isNaN(anioId)) {
            console.warn("Mes o año no disponibles en el contrato.");
            return;
        }
        
        const calendario = [];
        const inputs = diasContainer.querySelectorAll('.dia-input');
        
        inputs.forEach(input => {
            if (input.value && input.value.trim() !== '') {
                calendario.push({
                    mes: mesId,
                    anio: anioId,
                    dia: parseInt(input.dataset.dia),
                    cantidad: parseInt(input.value)
                });
            }
        });
        
        // Acumular los totales
        valorBrutoTotal += valorB;
        valorNetoTotal += valorN;
        descuentoTotal += descuentoV;
        valorTotalTotal += valorT;
        
        datosRecopilados.push({
            programa_id: programaId,
            tema_id: temaId,
            clasificacion: idclasi,
            segundos:segund,
            calendario: calendario,
            valor_neto: valorN,
            valor_bruto: valorB,
            valor_total: valorT,
            descuento: descuentoV
        });
    });
    
    // Crear objeto con los totales
    const totales = {
        valor_bruto_total: valorBrutoTotal,
        valor_neto_total: valorNetoTotal,
        descuento_total: descuentoTotal,
        valor_total_total: valorTotalTotal
    };
    
    // Retornar un objeto que contiene los datos y los totales
    return {
        datos: datosRecopilados,
        totales: totales
    };
}




async function enviarDatos() {
    try {
        const datos = recopilarDatos();  // Asegúrate de que recopilarDatos() devuelva los datos correctos para la tabla "json"
        const usuariodato = recopilarUsuario();
        // Usa el id_planes_publicidad ya existente
        const id_planes_publicidad = <?php echo json_encode($id_planes_publicidad); ?>;
        const id_ordenes_de_comprar = <?php echo json_encode($id_orden_de_compra); ?>;
        const numerodeorden = <?php echo json_encode($numerodeorden); ?>;
        const copia = <?php echo json_encode($copia !== null && is_numeric($copia) ? (int)$copia : 0); ?>;
       
        
  
        // Preparar los datos para la actualización de PlanesPublicidad
        const datosPlan = {
            id_planes_publicidad: id_planes_publicidad,
            NombrePlan: document.querySelector('input[name="nombrePlan"]').value,
            usuarioregistro: usuariodato,
                id_cliente: document.getElementById('selected-client-id').value,
                id_producto: document.getElementById('selected-product-id').value,
                id_contrato: document.getElementById('selected-contrato-id').value,
                id_soporte: document.getElementById('selected-soporte-id').value,
                detalle: document.getElementById('descripcion').value,
                id_campania: document.getElementById('selected-campania-id').value,
                id_temas: document.getElementById('selected-temas-id').value,
                tipo_item: document.getElementById('selected-tipo').value,                
                fr_factura: document.getElementById('forma-facturacion').value,
                estado: '1',
                datosRecopilados: datos
        };
        
        console.log(datosPlan, "datosplan");

        // Configuración de headers para Supabase
        const headers = {
            'Content-Type': 'application/json',
            'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc'
        };

        // Primera solicitud: Actualizar PlanesPublicidad
        const responsePlan = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/PlanesPublicidad?id_planes_publicidad=eq.${id_planes_publicidad}`, {
            method: 'PUT',
            headers: headers,
            body: JSON.stringify(datosPlan)
        });

        if (!responsePlan.ok) {
            const errorText = await responsePlan.text();
            throw new Error(`HTTP error! status: ${responsePlan.status}, message: ${errorText}`);
        }

        console.log('Actualización del plan exitosa');
        // Preparar los datos para la actualización de OrdenesDePublicidad (primera parte)
        const datosOrdenpublicidad = {
            estado: '0',
            id_ordenes_de_comprar: id_ordenes_de_comprar,
            estadoorden: 'Anulada',
            usuarioregistro: usuariodato
        };

        // Segunda solicitud: Actualizar OrdenesDePublicidad (primera parte)
        const responseOrdenPub1 = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenesDePublicidad?id_ordenes_de_comprar=eq.${id_ordenes_de_comprar}`, {
            method: 'PUT',
            headers: {
                ...headers,
                'Prefer': 'return=representation'
            },
            body: JSON.stringify(datosOrdenpublicidad)
        });

        if (!responseOrdenPub1.ok) {
            const errorText = await responseOrdenPub1.text();
            throw new Error(`HTTP error! status: ${responseOrdenPub1.status}, message: ${errorText}`);
        }

        console.log('Actualización de OrdenesDePublicidad exitosa');
        const copiaIncrementada = copia + 1;
        // Preparar los datos para la nueva orden de publicidad
        const datosOrdenpublicidad2 = {

                id_cliente: document.getElementById('selected-client-id').value ?? null,
                num_contrato: document.getElementById('selected-contrato-id').value ?? null,
                id_proveedor: document.getElementById('selected-proveedor-id').value ?? null,
                id_soporte: document.getElementById('selected-soporte-id').value ?? null,
                id_tema: document.getElementById('selected-temas-id').value ?? null,
                id_plan: id_planes_publicidad,
                id_contrato: document.getElementById('selected-contrato-id').value,
                detalle: document.getElementById('descripcion').value ?? null,
                datosRecopiladosb: datos,
                id_campania: document.getElementById('selected-campania-id').value,
                usuarioregistro: usuariodato,
                tipo_item: document.getElementById('selected-tipo').value ?? null,
                Megatime: document.getElementById('selected-temas-codigo').value ?? null,
                id_agencia: document.getElementById('selected-campania-agencia').value ?? null,
                id_clasificacion: document.getElementById('selected-id-clasificacion').value || null,
                estado: '1',
                copia: copia,
                numerodeorden: numerodeorden,
                numerodeordenremplaza: copiaIncrementada,
                remplaza: id_ordenes_de_comprar
        };
        console.log(datosOrdenpublicidad2, "error");

        // Tercera solicitud: Crear nueva orden de publicidad
        const responseNuevaOrden = await fetch('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenesDePublicidad', {
            method: 'POST',
            headers: {
                ...headers,
                'Prefer': 'return=representation'
            },
            body: JSON.stringify(datosOrdenpublicidad2)
        });

        if (!responseNuevaOrden.ok) {
            const errorText = await responseNuevaOrden.text();
            throw new Error(`HTTP error! status: ${responseNuevaOrden.status}, message: ${errorText}`);
        }

        console.log('Creación de nueva OrdenesDePublicidad exitosa');

        Swal.fire({
            title: '¡Éxito!',
            text: 'Los datos se han actualizado correctamente.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/ListOrdenes.php';
            }
        });
    } catch (error) {
        console.error('Error al actualizar los datos:', error);
        Swal.fire({
            title: 'Error',
            text: 'Error al actualizar los datos: ' + error.message,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}


</script>
<script>
// ACA EMPIEZA LA LOGICA DE LOS BUSCADORES INCLUIDO EL INITIALIZE CALENDAR
 // Pasar datos PHP a JavaScript
const programasTemasData = <?php echo json_encode($programasTemasData); ?>;
const clasificacionesMap = <?php echo json_encode($clasificaciones); ?>;
const programasMap = <?php echo json_encode($programas); ?>;
const mesesMap = <?php echo json_encode($mesesMap); ?>;
const aniosMap = <?php echo json_encode($aniosMap); ?>;
// Función para cargar los datos iniciales
// Función mejorada para cargar los datos iniciales

// Función para cargar los spans con los valores de año y mes
function cargarAñoMesSpans() {
    const yearSpan = document.getElementById("selected-year-span");
    const monthSpan = document.getElementById("selected-month-span");
    
    // Obtener los valores de los campos ocultos
    const selectedAnio = document.getElementById("selected-anio").value;
    const selectedMes = document.getElementById("selected-mes").value;

    // Verificar si aniosMap y mesesMap están definidos (asegúrate de que estén disponibles)
    if (yearSpan && aniosMap && aniosMap[selectedAnio]) {
        yearSpan.textContent = aniosMap[selectedAnio].years || 'N/A';
    }

    if (monthSpan && mesesMap && mesesMap[selectedMes]) {
        monthSpan.textContent = mesesMap[selectedMes].Nombre + ' / ' || 'N/A';
    }
}

// Llamar a la función cuando la página se cargue
document.addEventListener('DOMContentLoaded', function() {
    cargarAñoMesSpans();
});

function loadCalendarData(group, calendarioData) {
    if (!calendarioData || calendarioData.length === 0) {
        console.log('No hay datos de calendario para cargar');
        return;
    }

    const anioSelector = document.getElementById('selected-anio');
    const mesSelector = group.querySelector('.mesSelector');
    const diasContainer = group.querySelector('.diasContainer');

    function updateCalendar() {
        const diasSemana = ['D', 'L', 'M', 'Mi', 'J', 'V', 'S'];
        
        // Obtener el año del contrato
        const anioId = parseInt(document.getElementById('selected-anio').value);
        
        // Obtener el mes seleccionado
        const mesId = parseInt(mesSelector.value);

        if (!mesId || !anioId) {
            console.warn("No hay valores de mes o año disponibles");
            return;
        }

        // Obtener el mes y año directamente de los mapas
        const mes = parseInt(mesesMap[mesId]['Id']);
        const anio = parseInt(aniosMap[anioId]['years']);

        // Calcular días en el mes
        const diasEnMes = new Date(anio, mes, 0).getDate();
        diasContainer.innerHTML = '';

        // Generar el calendario
        for (let dia = 1; dia <= diasEnMes; dia++) {
            const fecha = new Date(anio, mes - 1, dia);
            const nombreDia = diasSemana[fecha.getDay()];

            const diaElement = document.createElement('div');
            diaElement.className = 'dia';
            diaElement.innerHTML = `
                <div class="dia-nombre">${nombreDia}</div>
                <div class="dia-numero">${dia}</div>
                <input type="number" class="dia-input" data-dia="${dia}" data-mes="${mesId}" data-anio="${anioId}" />
            `;
            diasContainer.appendChild(diaElement);
        }
    }
    // Verificar y establecer el año si es necesario
    if (calendarioData[0].anio && anioSelector) {
        anioSelector.value = calendarioData[0].anio;
    }

    // Verificar y establecer el mes si es necesario
    if (calendarioData[0].mes && mesSelector) {
        mesSelector.value = calendarioData[0].mes;
        
        // Llamar a updateCalendar para regenerar los días del mes
        updateCalendar();
    }

    // Cargar los valores en los inputs correspondientes
    calendarioData.forEach(item => {
        const diaInput = diasContainer.querySelector(
            `.dia-input[data-dia="${item.dia}"][data-mes="${item.mes}"][data-anio="${item.anio}"]`
        );

        if (diaInput) {
            diaInput.value = item.cantidad;
        }
    });
}

function initializeValoresCalculator(group) {
    const inputValorNeto = group.querySelector('.selected-valorneto');
    const inputValorBruto = group.querySelector('.selected-valorbruto');
    const inputDescuento = group.querySelector('.selected-descuentov');
    const inputValorTotal = group.querySelector('.selected-valortotal');

    if (!inputValorNeto || !inputValorBruto || !inputDescuento || !inputValorTotal) {
        console.error("Error: No se pudieron encontrar todos los inputs necesarios en el grupo");
        return;
    }

    const calcularValores = () => {
        const valorNeto = parseFloat(inputValorNeto.value) || 0;
        const valorBruto = Math.round(valorNeto * 1.19);
        const descuento = parseFloat(inputDescuento.value) || 0;
        const valorTotal = Math.max(0, valorBruto - descuento);

        inputValorBruto.value = valorBruto;
        inputValorTotal.value = valorTotal;

        // Actualizar totales globales
        updateTotalesGlobales();
    };

    // Agregar event listeners
    inputValorNeto.addEventListener('input', calcularValores);
    inputDescuento.addEventListener('input', calcularValores);
}
function updateTotalesGlobales() {
    const grupos = document.querySelectorAll('.programas-temas-group');
    const divTotales = document.querySelector('.totalestotales');
    
    if (!divTotales) {
        console.error("No se encontró el div con clase 'totalestotales'");
        return;
    }

    let totalValorNeto = 0;
    let totalValorBruto = 0;
    let totalDescuento = 0;
    let totalValorTotal = 0;

    // Calcular totales 
    grupos.forEach((grupo, index) => {
        const valorNeto = parseFloat(grupo.querySelector('.selected-valorneto').value) || 0;
        const valorBruto = parseFloat(grupo.querySelector('.selected-valorbruto').value) || 0;
        const descuento = parseFloat(grupo.querySelector('.selected-descuentov').value) || 0;
        const valorTotal = parseFloat(grupo.querySelector('.selected-valortotal').value) || 0;

        totalValorNeto += valorNeto;
        totalValorBruto += valorBruto;
        totalDescuento += descuento;
        totalValorTotal += valorTotal;
    });

    // Mostrar totales globales en tabla
    divTotales.innerHTML = `
        <table class="finishtab table table-bordered" style="width: auto; margin-left: auto;">
            <tbody>
                <tr>
                    <td class="fw-bold">Valor Neto Total:</td>
                    <td class="text-end">$${totalValorNeto.toLocaleString()}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Valor Bruto Total:</td>
                    <td class="text-end">$${totalValorBruto.toLocaleString()}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Descuento Total:</td>
                    <td class="text-end">$${totalDescuento.toLocaleString()}</td>
                </tr>
                <tr class="table-active">
                    <td class="fw-bold">Valor Total General:</td>
                    <td class="text-end fw-bold">$${totalValorTotal.toLocaleString()}</td>
                </tr>
            </tbody>
        </table>
    `;
}

function loadInitialData(programasTemasData) {
    const container = document.getElementById('programasTemasContainer');
    
    // Eliminar todos los grupos existentes excepto el primero
    const groups = container.querySelectorAll('.programas-temas-group');
    for (let i = 1; i < groups.length; i++) {
        groups[i].remove();
    }
    
    // Cargar cada conjunto de datos
    programasTemasData.forEach((data, index) => {
        // Si no es el primer conjunto, crear un nuevo grupo
        if (index > 0) {
            addProgramasTemasGroup();
        }
        
        // Obtener el grupo actual
        const groups = container.querySelectorAll('.programas-temas-group');
        const currentGroup = groups[index];
        
        // Cargar datos del programa
        const searchProgramaInput = currentGroup.querySelector('.search-programa');
        const selectedProgramaIdInput = currentGroup.querySelector('.selected-programa-id');
        const programa = programasMap.find(p => p.id.toString() === data.programa_id);
        if (programa) {
            searchProgramaInput.value = programa.descripcion;
            selectedProgramaIdInput.value = programa.id;
            currentGroup.querySelector('#hora-inicio').value = programa['hora_inicio'];
            currentGroup.querySelector('#hora-fin').value = programa['hora_fin'];
            const searchProgramaElement = currentGroup.querySelector("#search-programa");
            searchProgramaElement.setAttribute('readonly', true);
            
        }

          // Cargar datos de clasificación
          const searchClasificacionInput = currentGroup.querySelector('#search-clasificacion');
        const selectedClasificacionInput = currentGroup.querySelector('.selected-clasi');
        const clasificacion = clasificacionesMap.find(c => c.id.toString() === data.clasificacion);
        if (clasificacion) {
            searchClasificacionInput.value = clasificacion.NombreClasificacion;
            selectedClasificacionInput.value = clasificacion.id;
        }
        
        // Cargar datos del tema
        const searchTemasInput = currentGroup.querySelector('.search-temas');
        const selectedTemasIdInput = currentGroup.querySelector('.selected-temas-id');
        const tema = temasMap.find(t => t.id.toString() === data.tema_id);
        if (tema) {
            searchTemasInput.value = tema.nombreTema;
            selectedTemasIdInput.value = tema.id;
            currentGroup.querySelector('#selected-temas-codigo').value = tema.CodigoMegatime;
            currentGroup.querySelector('#selected-id-medio').value = tema.id_medio;
            currentGroup.querySelector('#selected-segundos').value = tema.Duracion;
            const searchTema = currentGroup.querySelector("#search-temas");
            searchTema.setAttribute('readonly', true);

        }

       
        
        // Cargar valores monetarios
        currentGroup.querySelector('.selected-valorneto').value = data.valor_neto || '';
        currentGroup.querySelector('.selected-valorbruto').value = data.valor_bruto || '';
        currentGroup.querySelector('.selected-descuentov').value = data.descuento || '0';
        currentGroup.querySelector('.selected-valortotal').value = data.valor_total || '';
        console.log(data.calendario, "acaviejita");
        // Cargar datos del calendario de manera asíncrona
        setTimeout(() => {
            loadCalendarData(currentGroup, data.calendario);
        }, index * 200); // Agregamos un delay incremental para cada grupo
    });
     // Llamar a updateTotalesGlobales después de cargar todos los grupos
     updateTotalesGlobales();
}

// Inicialización de los datos
function initializeFormData(programasTemasData) {
    if (document.readyState === 'loading') {
   
        document.addEventListener('DOMContentLoaded', () => {
            loadInitialData(programasTemasData);
            document.querySelector(".clear-btnCliente").style.display = 'block';
    document.getElementById("search-client").setAttribute('readonly', true);
    document.querySelector(".clear-btnProducto").style.display = 'block';
    document.getElementById("search-product").setAttribute('readonly', true);
    document.querySelector(".clear-btnContrato").style.display = 'block';
    document.getElementById("search-contrato").setAttribute('readonly', true);
    document.querySelector(".clear-btnSoporte").style.display = 'block';
    document.getElementById("search-soporte").setAttribute('readonly', true);
    document.querySelector(".clear-btnCampaña").style.display = 'block';
    document.getElementById("search-campania").setAttribute('readonly', true);
            
        });
    } else {
        loadInitialData(programasTemasData);
    }
}

// Llamar a la inicialización
initializeFormData(programasTemasData);

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
    document.querySelector(".clear-btnCliente").style.display = searchInput ? 'inline' : 'none';
}


function selectClient(id, nombreCliente) {
    // Obtener los elementos
    const searchClientInput = document.getElementById("search-client");
    const selectedClientIdInput = document.getElementById("selected-client-id");

    // Establecer el nombre del cliente en el input
    searchClientInput.value = nombreCliente;

    // Establecer el ID del cliente seleccionado
    selectedClientIdInput.value = id;

    // Ocultar la lista de clientes
    document.getElementById("client-list").style.display = "none";

    // Mostrar botón de limpiar
    document.querySelector(".clear-btnCliente").style.display = 'block';

    // Establecer como solo lectura
    searchClientInput.setAttribute('readonly', true);

    // Disparar eventos para forzar la validación
    searchClientInput.dispatchEvent(new Event('input', { bubbles: true }));
    searchClientInput.dispatchEvent(new Event('change', { bubbles: true }));
    
    // Remover clase de error si existe
    searchClientInput.classList.remove('is-invalid');
    selectedClientIdInput.classList.remove('is-invalid');
}

// Función para limpiar la búsqueda
function clearSearchCliente() {
    // Limpiar el input de búsqueda
    document.getElementById("search-client").value = "";
    // Limpiar el ID de cliente seleccionado
    document.getElementById("selected-client-id").value = "";
    
    // Ocultar la lista de clientes
    document.getElementById("client-list").style.display = "none";
    
    // Ocultar el botón de limpiar
    document.querySelector(".clear-btnCliente").style.display = 'none';
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
    // Obtener los elementos
    const searchProductInput = document.getElementById("search-product");
    const selectedProductIdInput = document.getElementById("selected-product-id");

    // Establecer el nombre del producto en el input
    searchProductInput.value = nombreProducto;

    // Establecer el ID del producto seleccionado
    selectedProductIdInput.value = id;

    // Limpiar la lista de opciones una vez seleccionado
    document.querySelector(".clear-btnProducto").style.display = 'block';
    document.getElementById("product-list").style.display = "none";

    // Disparar eventos para forzar la validación
    searchProductInput.dispatchEvent(new Event('input', { bubbles: true }));
    searchProductInput.dispatchEvent(new Event('change', { bubbles: true }));
    
    // Remover clase de error si existe
    searchProductInput.classList.remove('is-invalid');
    selectedProductIdInput.classList.remove('is-invalid');
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
function clearSearchProducto() {
    document.getElementById("search-product").value = '';
    document.getElementById("search-product").setAttribute('readonly', false);
    document.getElementById("selected-product-id").value = '';
    document.getElementById("product-list").style.display = "none";
    document.querySelector(".clear-btnProducto").style.display = 'none';
}

// Asignar contratos desde PHP al script
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
            li.setAttribute("data-anio", contrato.id_Anio);
            li.setAttribute("data-mes", contrato.id_Mes);
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
            li.setAttribute("data-anio", contrato.id_Anio);
            li.setAttribute("data-mes", contrato.id_Mes);
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

// Modificamos la función selectContract para mostrar año y mes
function selectContract(contrato) {
    // Código existente de selección de contrato
    document.getElementById("search-contrato").value = contrato.nombreContrato;
    document.getElementById("selected-contrato-id").value = contrato.id;
    document.getElementById("selected-proveedor-id").value = contrato.idProveedor;
    document.getElementById("selected-num-contrato").value = contrato.num_contrato;
    document.getElementById("selected-anio").value = contrato.id_Anio;
    document.getElementById("selected-mes").value = contrato.id_Mes;

    // Nuevas líneas para mostrar año y mes
    const yearSpan = document.getElementById("selected-year-span");
    const monthSpan = document.getElementById("selected-month-span");

    if (yearSpan) {
        yearSpan.textContent = aniosMap[contrato.id_Anio] ? aniosMap[contrato.id_Anio].years : 'N/A';
    }

    if (monthSpan) {
        monthSpan.textContent = mesesMap[contrato.id_Mes] ? mesesMap[contrato.id_Mes].Nombre + ' / ' : 'N/A';
    }

    // Limpiar la lista de opciones una vez seleccionado
    document.getElementById("contrato-list").style.display = "none";
    document.querySelector(".clear-btnContrato").style.display = 'block';
    document.getElementById("search-contrato").setAttribute('readonly', true);
    actualizarCalendarioDesdeContrato();
}

// Función para cerrar el dropdown si se hace clic fuera
document.addEventListener('click', function(event) {
    const searchInputContrato = document.getElementById('search-contrato');
    const contratoList = document.getElementById('contrato-list');
    
    if (!searchInputContrato.contains(event.target) && !contratoList.contains(event.target)) {
        contratoList.style.display = 'none';
    }
});

// Mostrar contratos del cliente cuando el input es clickeado
document.getElementById("search-contrato").addEventListener('click', function() {
    const clientId = document.getElementById("selected-client-id").value;
    if (clientId) {
        showContractsForClient();
    }
});

// Función para limpiar la búsqueda
function clearSearchContrato() {
    document.getElementById("search-contrato").value = '';
    document.getElementById("selected-contrato-id").value = '';
    document.getElementById("selected-proveedor-id").value = '';
    document.getElementById("selected-num-contrato").value = '';
    document.getElementById("selected-anio").value = '';
    document.getElementById("selected-mes").value = '';
    document.getElementById("contrato-list").style.display = "none";
    document.querySelector(".clear-btnContrato").style.display = 'none';
    

    // Limpiar los spans de año y mes
    const yearSpan = document.getElementById("selected-year-span");
    const monthSpan = document.getElementById("selected-month-span");
    if (yearSpan) yearSpan.textContent = '';
    if (monthSpan) monthSpan.textContent = '';
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
    document.querySelector(".clear-btnSoporte").style.display = 'block';
    soporteList.style.display = 'block';
}

// Cerrar el dropdown al hacer clic fuera del mismo
document.addEventListener('click', function (event) {
    if (!event.target.closest('.custom-select-container')) {
        soporteList.style.display = 'none';
    }
});

// Función para limpiar la búsqueda
function clearSearchSoporte() {
    searchSoporteInput.value = '';
    selectedSoporteIdInput.value = '';
    soporteList.style.display = 'none';
    document.querySelector(".clear-btnSoporte").style.display = 'none';
}


// Buscador programas



// Función para obtener los IDs de programas seleccionados en todos los grupos
function getSelectedProgramIds() {
    const selectedIds = [];
    document.querySelectorAll('.selected-programa-id').forEach(input => {
        if (input.value) {
            selectedIds.push(input.value);
        }
    });
    return selectedIds;
}

// Esta función configura los event listeners para búsqueda y selección en un grupo específico
function initializeSearch(group) {
    const programasMap = <?php echo json_encode($programasMap); ?>;

    const searchProgramaInput = group.querySelector('.search-programa');
    const programaList = group.querySelector('.programa-list');
    const selectedProgramaIdInput = group.querySelector('.selected-programa-id');
    const selectedhoraini = group.querySelector('.hora-inicio');
    const selectedhorafin = group.querySelector('.hora-fin');
    // Función de búsqueda de programas
    searchProgramaInput.addEventListener('input', function () {
        const searchTerm = searchProgramaInput.value.toLowerCase();
        const selectedSoporteId = document.querySelector('#selected-soporte-id').value;

        // Obtener IDs de programas ya seleccionados en otros grupos
        const selectedProgramIds = getSelectedProgramIds();

        // Filtrar los programas que coinciden con el término de búsqueda, el id del soporte, y no están seleccionados ya
        const filteredProgramas = programasMap.filter(programa =>
            programa.descripcion.toLowerCase().includes(searchTerm) &&
            programa.soporteId == selectedSoporteId &&
            !selectedProgramIds.includes(programa.id.toString())
        );

        // Mostrar los programas en el dropdown
        renderProgramaDropdown(filteredProgramas, programaList, searchProgramaInput, selectedProgramaIdInput);
    });

    // Mostrar lista al hacer clic en el input de programas
    searchProgramaInput.addEventListener('focus', function () {
        const selectedSoporteId = document.querySelector('#selected-soporte-id').value;

        if (selectedSoporteId) {
            const selectedProgramIds = getSelectedProgramIds();
            const filteredProgramas = programasMap.filter(programa =>
                programa.soporteId == selectedSoporteId &&
                !selectedProgramIds.includes(programa.id.toString())
            );
            renderProgramaDropdown(filteredProgramas, programaList, searchProgramaInput, selectedProgramaIdInput);
        }
    });
}
function initializeClasificacionSearch(groupElement) {
    const clasificacionesMap = <?php echo json_encode($clasificacionesMap); ?>;
    
    // Elementos existentes
    const searchInput = groupElement.querySelector('#search-clasificacion');
    const selectedClasiInput = groupElement.querySelector('#selected-clasi');
    const clasificacionList = groupElement.querySelector('#clasificacion-list');


    function addNuevaClasificacionInline() {
    const inlineAddHtml = `
<div style="display:flex;">
            <input type="text" placeholder="Nueva Clasificación" id="nuevaClasificacionInput">
            <button id="guardarNuevaClasificacion">+</button>
     </div>  
    `;
    const newItem = document.createElement('li');
    newItem.innerHTML = inlineAddHtml;
    clasificacionList.appendChild(newItem);

    const nuevaClasificacionInput = newItem.querySelector('#nuevaClasificacionInput');
    const guardarBtn = newItem.querySelector('#guardarNuevaClasificacion');

    guardarBtn.onclick = function() {
        const nombreClasificacion = nuevaClasificacionInput.value.trim();

        if (nombreClasificacion) {
            // Deshabilitar botón durante la solicitud
            guardarBtn.disabled = true;
            guardarBtn.textContent = 'Guardando...';

            // Configuración de la solicitud
            const requestOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                    'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                    'Prefer': 'return=representation'  // Esta línea es crucial
                },
                body: JSON.stringify({
                    NombreClasificacion: nombreClasificacion
                })
            };

            fetch('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clasificacion', requestOptions)
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(errorText => {
                            throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Datos recibidos:', data);
                    
                    // Obtener el ID de la primera entrada (si existe)
                    const nuevoId = data[0]?.id;
                    
                    if (nuevoId) {
                        // Actualizar mapa de clasificaciones local
                        clasificacionesMap.push({
                            id: nuevoId,
                            NombreClasificacion: nombreClasificacion
                        });

                        // Seleccionar nueva clasificación
                        searchInput.value = nombreClasificacion;
                        selectedClasiInput.value = nuevoId;
                        
                        // Actualizar lista de clasificaciones
                        filterClasificaciones();
                        
                        // Eliminar input inline
                        newItem.remove();
                    } else {
                        throw new Error('No se recibió un ID válido');
                    }
                })
                .catch(error => {
                    console.error('Error completo:', error);
                    alert('Error al guardar la clasificación: ' + error.message);
                    
                    // Restaurar botón
                    guardarBtn.disabled = false;
                    guardarBtn.textContent = '+';
                });
        }
    };
}

    // Función para filtrar clasificaciones
    function filterClasificaciones() {
        const searchTerm = searchInput.value.toLowerCase();
        clasificacionList.innerHTML = ''; // Limpiar lista anterior

        const filteredClasificaciones = clasificacionesMap.filter(clasi => 
            clasi.NombreClasificacion.toLowerCase().includes(searchTerm)
        );

        if (filteredClasificaciones.length === 0) {
            clasificacionList.style.display = 'none';
        } else {
            clasificacionList.style.display = 'block';
            filteredClasificaciones.forEach(clasi => {
                const li = document.createElement('li');
                li.textContent = clasi.NombreClasificacion;
                li.setAttribute('data-id', clasi.id);
                li.classList.add('clasificacion-item');
                li.onclick = function() {
                    selectClasificacion(clasi.id, clasi.NombreClasificacion);
                };
                clasificacionList.appendChild(li);
            });
        }

        // Agregar botón para nueva clasificación
        const addButton = document.createElement('li');
        addButton.textContent = '+ Agregar Nueva Clasificación';
        addButton.classList.add('nueva-clasificacion-btn');
        addButton.onclick = addNuevaClasificacionInline;
        clasificacionList.appendChild(addButton);

   
    }

    // Resto del código de inicialización (sin cambios)
    function selectClasificacion(id, nombreClasificacion) {
        searchInput.value = nombreClasificacion;
        selectedClasiInput.value = id;
        clasificacionList.style.display = 'none';
      
    }

    function clearClasificacionSearch() {
        searchInput.value = '';
        selectedClasiInput.value = '';
        clasificacionList.style.display = 'none';
      
    }

    // Evento de entrada para filtrar
    searchInput.addEventListener('input', filterClasificaciones);

    // Evento de clic para mostrar todas las clasificaciones
    searchInput.addEventListener('click', function() {
        if (clasificacionesMap.length > 0) {
            clasificacionList.innerHTML = '';
            clasificacionesMap.forEach(clasi => {
                const li = document.createElement('li');
                li.textContent = clasi.NombreClasificacion;
                li.setAttribute('data-id', clasi.id);
                li.classList.add('clasificacion-item');
                li.onclick = function() {
                    selectClasificacion(clasi.id, clasi.NombreClasificacion);
                };
                clasificacionList.appendChild(li);
            });
            
            // Agregar botón para nueva clasificación
            const addButton = document.createElement('li');
            addButton.textContent = '+ Agregar Nueva Clasificación';
            addButton.classList.add('nueva-clasificacion-btn');
            addButton.onclick = addNuevaClasificacionInline;
            clasificacionList.appendChild(addButton);
            
            clasificacionList.style.display = 'block';
        }
    });



    // Cerrar dropdown si se hace clic fuera
    document.addEventListener('click', function(event) {
        if (!searchInput.contains(event.target) && !clasificacionList.contains(event.target)) {
            clasificacionList.style.display = 'none';
        }
    });
}
// Función para renderizar el dropdown de programas (mejorada)
function renderProgramaDropdown(programas, programaList, searchInput, selectedProgramaIdInput) {
    programaList.innerHTML = '';

    if (programas.length === 0) {
        const li = document.createElement('li');
        li.textContent = 'No existen más programas.';
        li.classList.add('no-programs-item');
        programaList.appendChild(li);

        programaList.style.display = 'block';
        return;
    }

    programas.forEach(programa => {
        const li = document.createElement('li');
        li.textContent = programa.descripcion;
        li.dataset.id = programa.id;
        li.classList.add('client-dropdown-item');

        li.addEventListener('click', function () {
            // Set the program ID
            selectedProgramaIdInput.value = programa.id;
            
            // Set the search input value
            searchInput.value = programa.descripcion;
            
            // Find and set the hora inicio and hora fin inputs
            const container = searchInput.closest('.programas-temas-group');
            const horaInicioInput = container.querySelector('.hora-inicio');
            const horaFinInput = container.querySelector('.hora-fin');
            
            // Set hora inicio and hora fin if the inputs exist
            if (horaInicioInput) horaInicioInput.value = programa.horaini || '';
            if (horaFinInput) horaFinInput.value = programa.horafn || '';
            
            // Close the dropdown
            programaList.style.display = 'none';
        });

        programaList.appendChild(li);
    });

    programaList.style.display = 'block';
}


// Llamar a initializeSearch en el grupo original al cargar la página
document.querySelectorAll('.programas-temas-group').forEach(group => {
    initializeSearch(group);
});

// Cerrar el dropdown de programas al hacer clic fuera del mismo
document.addEventListener('click', function (event) {
    document.querySelectorAll('.programa-list').forEach(programaList => {
        if (!event.target.closest('.custom-select-container')) {
            programaList.style.display = 'none';
        }
    });
});



// Función para limpiar la búsqueda de programas
function clearSearchProgramas() {
    document.getElementById("selected-programa-id").value = '';
    document.getElementById("search-programa").value = '';
    document.getElementById("hora-inicio").value = ''; 
    document.getElementById("hora-fin").value = '';
    document.getElementById("programa-list").style.display = "none";            
    document.querySelector(".clear-btn").style.display = 'none';
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
    document.querySelector(".clear-btnCampaña").style.display = 'block';
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
    document.getElementById("selected-campania-agencia").value = '';
    document.getElementById("campania-list").style.display = "none";
    document.querySelector(".clear-btnCampaña").style.display = 'none';
}



            const campaniaTemasMap = <?php echo json_encode($campaniaTemasMap); ?>;
            const temasMap = <?php echo json_encode($temasMap); ?>;

            // Función para inicializar la búsqueda de temas en un grupo específico
            // Función para inicializar la búsqueda de temas en un grupo específico
            function initializeTemasSearch(group) {
    const searchTemasInput = group.querySelector('.search-temas');
    const temasList = group.querySelector('.temas-list');
    const selectedTemasIdInput = group.querySelector('.selected-temas-id');
    const selectedTemasCodigoInput = group.querySelector('#selected-temas-codigo');
    const selectedIdMedioInput = group.querySelector('#selected-id-medio');
    const selectedIdClasificacionInput = group.querySelector('#selected-id-clasificacion');
    const selectedSegundos = group.querySelector('#selected-segundos');
    const clearButton = group.querySelector('.clear-btn');

    // Mostrar temas cuando se hace click en el input
    searchTemasInput.addEventListener('click', function() {
        const campaignId = document.getElementById("selected-campania-id").value;
        if (campaignId) {
            showTemasForCampaignInGroup(group, campaignId);
        }
    });

    // Filtrar temas mientras se escribe
    searchTemasInput.addEventListener('input', function() {
        const campaignId = document.getElementById("selected-campania-id").value;
        if (campaignId) {
            filterTemasInGroup(group, campaignId);
        }
        clearButton.style.display = this.value ? 'inline' : 'none';
    });

    // Función para mostrar temas en un grupo específico
    function showTemasForCampaignInGroup(group, campaignId) {
        const temasList = group.querySelector('.temas-list');
        temasList.innerHTML = '';

        const temasRelacionados = campaniaTemasMap[campaignId] || [];
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
                li.setAttribute("data-duracion", tema.Duracion);
                li.classList.add("tema-item");
                li.onclick = function() {
                    selectTemaInGroup(group, tema);
                };
                temasList.appendChild(li);
            });
        }
    }

    // Función para filtrar temas en un grupo específico
    function filterTemasInGroup(group, campaignId) {
        const searchInput = group.querySelector('.search-temas').value.toLowerCase();
        const temasList = group.querySelector('.temas-list');
        temasList.innerHTML = '';

        const temasRelacionados = campaniaTemasMap[campaignId] || [];
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
                li.setAttribute("data-duracion", tema.Duracion);
                li.classList.add("tema-item");
                li.onclick = function() {
                    selectTemaInGroup(group, tema);
                };
                temasList.appendChild(li);
            });
        }
    }

    // Función para seleccionar un tema en un grupo específico
    async function selectTemaInGroup(group, tema) {
        const searchInput = group.querySelector('.search-temas');
        const selectedTemasIdInput = group.querySelector('.selected-temas-id');
        const selectedTemasCodigoInput = group.querySelector('#selected-temas-codigo');
        const selectedIdMedioInput = group.querySelector('#selected-id-medio');
        const selectedIdClasificacionInput = group.querySelector('#selected-id-clasificacion');
        const selectedSegundos = group.querySelector('#selected-segundos');
        const temasList = group.querySelector('.temas-list');

        searchInput.value = tema.nombreTema;
        selectedTemasIdInput.value = tema.id;
        selectedTemasCodigoInput.value = tema.CodigoMegatime;
        selectedIdMedioInput.value = tema.id_medio;
        selectedSegundos.value = tema.Duracion;
        // Obtener y establecer la clasificación
        const idClasificacion = await fetchIdClasificacion(tema.id_medio);
        if (idClasificacion) {
            selectedIdClasificacionInput.value = idClasificacion;
        } else {
            selectedIdClasificacionInput.value = '';
            console.error('No se encontró la clasificación para este id_medio.');
        }

        temasList.style.display = "none";
    }

    // Cerrar la lista de temas al hacer clic fuera
    document.addEventListener('click', function(event) {
        if (!group.contains(event.target)) {
            temasList.style.display = 'none';
        }
    });
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
            function clearSearchTemas() {
                document.getElementById("search-temas").value = '';
                document.getElementById("selected-temas-id").value = ''; 
                document.getElementById("selected-temas-codigo").value = '';
                document.getElementById("selected-segundos").value = '';
                document.getElementById("selected-id-medio").value = '';
                document.getElementById("selected-id-clasificacion").style.display = '';
                document.getElementById("temas-list").style.display = "none";            
                document.querySelector(".clear-btn").style.display = 'none';
            }

            function initializeCalendar(group) {
    const mesSelector = group.querySelector('.mesSelector');
    const diasContainer = group.querySelector('.diasContainer');
    const fillAllCheckbox = group.querySelector('.fillAllCheckbox');
    const fillAllInput = group.querySelector('.fillAllInput');

    // Función para actualizar todas las casillas
    function fillAllDays() {
        const value = fillAllInput.value;
        if (value !== '') {
            diasContainer.querySelectorAll('.dia-input').forEach(input => {
                input.value = value;
            });
        }
    }

    // Habilitar/deshabilitar la casilla de valor global
    fillAllCheckbox.addEventListener('change', (e) => {
        fillAllInput.disabled = !e.target.checked;
        if (!e.target.checked) {
            fillAllInput.value = '';
        }
    });

    // Escuchar cambios en la casilla global y rellenar todas las casillas
    fillAllInput.addEventListener('input', fillAllDays);

    // Función para inicializar el calendario
    function updateCalendar() {
        const diasSemana = ['D', 'L', 'M', 'Mi', 'J', 'V', 'S'];

        // Obtener el año y mes seleccionados
        const anioId = parseInt(document.getElementById('selected-anio').value);
        const mesId = parseInt(mesSelector.value);

        if (!mesId || !anioId) {
            console.warn("No hay valores de mes o año disponibles");
            return;
        }

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
                <input type="number" class="dia-input" data-dia="${dia}" data-mes="${mesId}" data-anio="${anioId}" />
            `;
            diasContainer.appendChild(diaElement);
        }

        // Si el checkbox está activo, rellenar todas las casillas con el valor actual
        if (fillAllCheckbox.checked && fillAllInput.value !== '') {
            fillAllDays();
        }
    }

    mesSelector.addEventListener('change', () => {
        fillAllInput.value = '';
        updateCalendar();
    });

    updateCalendar();
}

// Función para actualizar todos los calendarios cuando se selecciona un contrato
function actualizarCalendarioDesdeContrato() {
    const calendarios = document.querySelectorAll('.calendario');
    calendarios.forEach(calendario => {
        // Añadir event listener al mesSelector de cada calendario
        const mesSelector = calendario.querySelector('.mesSelector');
        mesSelector.addEventListener('change', () => {
            initializeCalendar(calendario);
        });
        
        // Inicializar el calendario con el año del contrato
        initializeCalendar(calendario);
    });
}

// Modificar la función addProgramasTemasGroup para inicializar la búsqueda de temas
function addProgramasTemasGroup() {
    const container = document.getElementById('programasTemasContainer');
    const newGroup = container.querySelector('.programas-temas-group').cloneNode(true);
    const groupCount = container.querySelectorAll('.programas-temas-group').length;

    // Asignar un ID único al grupo
    newGroup.dataset.groupId = `group-${groupCount + 1}`;

    // Limpiar los valores en los inputs del nuevo grupo
    newGroup.querySelectorAll('input').forEach(input => {
        input.value = '';
    });

    // Mostrar el botón de eliminar solo en el nuevo grupo
    const removeButton = newGroup.querySelector('.remove-group-btn');
    if (removeButton) {
        removeButton.style.display = 'inline-block';
    }

    // Ocultar el botón de eliminar en el primer grupo
    const firstGroup = container.querySelector('.programas-temas-group');
    const firstGroupRemoveButton = firstGroup.querySelector('.remove-group-btn');
    if (firstGroupRemoveButton) {
        firstGroupRemoveButton.style.display = 'none';
    }

       // Initialize classification search for the new group
       initializeClasificacionSearch(newGroup);
// Inicializar todas las funcionalidades en el nuevo grupo
    initializeSearch(newGroup);
    initializeTemasSearch(newGroup);
    initializeCalendar(newGroup);
    // Inicializar todas las funcionalidades en el nuevo grupo
    initializeValoresCalculator(newGroup);

    // Insertar el nuevo grupo en el contenedor
    container.appendChild(newGroup);

    // Actualizar totales globales
    updateTotalesGlobales();
}

// Inicializar el calculador en el grupo inicial cuando se carga la página
document.addEventListener('DOMContentLoaded', () => {
    
});

function removeProgramasTemasGroup(button) {
    const container = document.getElementById('programasTemasContainer');
    const groups = container.querySelectorAll('.programas-temas-group');

    if (groups.length > 1) {
        // Eliminar el grupo asociado al botón
        button.closest('.programas-temas-group').remove();

        // Si solo queda un grupo, ocultar su botón de eliminar
        if (groups.length - 1 === 1) {
            const remainingGroup = container.querySelector('.programas-temas-group');
            const removeButton = remainingGroup.querySelector('.remove-group-btn');
            if (removeButton) removeButton.style.display = 'none';
        }
    } else {
        alert("Debe existir al menos un bloque de Programas y Temas.");
    }
}


// Inicializar la búsqueda de temas en todos los grupos existentes
document.querySelectorAll('.programas-temas-group').forEach(group => {
    initializeTemasSearch(group);
});


document.addEventListener('DOMContentLoaded', function () {
    const firstGroup = document.querySelector('.programas-temas-group');
    initializeCalendar(firstGroup);

    // Asegúrate de ocultar el botón de eliminar en el primer grupo
    const removeButton = firstGroup.querySelector('.remove-group-btn');
    if (removeButton) removeButton.style.display = 'none';
});

</script>




<?php include '../../componentes/settings.php'; ?>


<?php include '../../componentes/footer.php'; ?>