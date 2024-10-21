<?php
// Iniciar la sesión
session_start();
// Definir variables de configuración
//$ruta = 'localhost/paddv4/';
// Función para hacer peticiones cURL
include '../querys/qplanes.php';
// Obtener el ID del cliente de la URL
$idPlan = isset($_GET['id']) ? $_GET['id'] : null;
$id_planes_publicidad = (int) $_GET['id'];

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
if (!$idPlan) {
    die("No se proporcionó un ID de cliente válido.");
}

// Obtener datos del cliente específico
$url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/PlanesPublicidad?id_planes_publicidad=eq.$idPlan&select=*";
$planmed = makeRequest($url);
$datosPlan = $planmed[0];
// Verificar si se obtuvo el medio

// Obtener datos
$temas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Temas?select=*');
$soportes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Soportes?select=*');
$proveedores = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Proveedores?select=*');
$clientes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes?select=*');
$contratos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Contratos?select=*');
 
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
    $clientesMap[$cliente['id_cliente']] = [
        'nombreCliente' => $cliente['nombreCliente'],
        'razonSocial' => $cliente['razonSocial']
    ];
}
$campaignsMap2 = [];
foreach ($campaigns as $campaign) {
    $campaignsMap2[$campaign['id_campania']] = [
        'id' => $campaign['id_campania'],
        'nombreCampania' => $campaign['NombreCampania'],
        'idCliente' => $campaign['id_Cliente']
    ];
}

$soportesMap = [];
foreach ($soportes as $soporte) {
    $soportesMap[] = [
        'id' => $soporte['id_soporte'],
        'nombreIdentficiador' => $soporte['nombreIdentficiador'],
        'idProveedor' => $soporte['id_proveedor']
    ];
}
$temasMap2 = [];
foreach ($temas as $tema) {
    $temasMap2[] = [
        'id' => $tema['id_tema'],
        'NombreTema' => $tema['NombreTema'],
        'CodigoMegatime' => $tema['CodigoMegatime'],
        'id_medio' => $tema['id_medio']
    ];
}


$contratosMap = [];
foreach ($contratos as $contrato) {
    $contratosMap[$contrato['id']] = [
        'nombreContrato' => $contrato['NombreContrato'],
        'idCliente' => $contrato['IdCliente'],
        'idProveedor' => $contrato['IdProveedor']
    ];
}
$proveedoresMap = [];
foreach ($proveedores as $proveedor) {
    $proveedoresMap[$proveedor['id']] = [
        'nombreProveedor' => $proveedor['NombreProveedor']
    ];
}
$calendarMap2 = [];
foreach ($jsonData as $calendar) {
    // Aquí asumimos que `id_calendar` es único y usamos su valor como clave en nuestro mapa
    $calendarMap2[$calendar['id_calendar']] = $calendar['matrizCalendario'];
}

// Luego, para acceder a 'razonSocial' del cliente correspondiente al 'id_cliente' del plan seleccionado:
$idCliente = $datosPlan['id_cliente']; // Aquí obtienes el 'id_cliente' del plan seleccionado
$idPlan = $datosPlan['id_soporte'];
$idTem = $datosPlan['id_temas'];
$idCam = $datosPlan['id_campania'];
$idContrato = $datosPlan['id_contrato'];
$nombreProveedor = isset($proveedoresMap[$idProveedor]) ? $proveedoresMap[$idProveedor]['nombreProveedor'] : null;
$contra = isset($contratosMap[$idContrato]) ? $contratosMap[$idContrato]['nombreContrato'] : null;
$cammoe = isset($campaignsMap2[$idCam]) ? $campaignsMap2[$idCam]['nombreCampania'] : null;
$razonSocial = isset($clientesMap[$idCliente]) ? $clientesMap[$idCliente]['razonSocial'] : null;
$nombreCliente = isset($clientesMap[$idCliente]) ? $clientesMap[$idCliente]['nombreCliente'] : null;
$soportename = isset($soportesMap[$idPlan]) ? $soportesMap[$idPlan]['nombreIdentficiador'] : null;
$temm = isset($temasMap2[$idTem]) ? $temasMap2[$idTem]['NombreTema'] : null;

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
include '../componentes/header.php';
include '../componentes/sidebar.php';

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
    }</style>
<div class="main-content">
      
      <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>ListMedios.php">Ver Plan</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $razonSocial; ?></li>
                      </ol>
                    </nav>
        <section class="section">
          <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-4">
              <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                <div class="clearfix"></div>
                                <div class="author-box-job">
                                    Nombre Plan
                                </div>
                                <div class="nombrex author-box-name">

                                    <?php echo $datosPlan['NombrePlan']; ?>
                                </div>
                                
                              

                            </div>
                        </div>
                    </div>
              <div class="card">
                  <div style="display: flex;
    justify-content: space-between;" class="card-header">
                   
                    <h4>Detalles del Plan</h4>
                    <a class="btn btn-danger micono"  href="../querys/modulos/editarplan.php?id_planes_publicidad=<?php echo $id_planes_publicidad; ?>" ><i class="fas fa-pencil-alt"></i> Editar datos</a>

                  </div>
                  <div class="card-body">
    <div class="py-4">
                      
                            <p class="clearfix">
                                <span class="float-start">Razón Social</span>
                                <span class="float-right text-muted "><?php echo $razonSocial; ?></span>
                            </p>
                             
                            <p class="clearfix">
                                <span class="float-start">Soporte</span>
                                <span class="float-right text-muted "><?php echo $soportename; ?></span>
                            </p> 
                            <p class="clearfix">
                                <span class="float-start">Tema</span>
                                <span class="float-right text-muted "><?php echo $temm; ?></span>
                            </p> 
                            <p class="clearfix">
                                <span class="float-start">Campaña</span>
                                <span class="float-right text-muted "><?php echo $cammoe; ?><?php echo $idCam; ?></span>
                            </p>
                            <p class="clearfix">
                                <span class="float-start">Contrato</span>
                                <span class="float-right text-muted "><?php echo $contra; ?><?php echo $idContrato; ?></span>
                            </p>
                            <p class="clearfix">
                                <span class="float-start">Proveedor</span>
                                <span class="float-right text-muted "><?php echo $contra; ?><?php echo $nombreProveedor; ?></span>
                            </p>
                            <?php
    // Verificar si existe un id_calendar en el plan actual
    if (isset($calendarMap[$datosPlan['id_calendar']])) {
        // Extraer la matriz de calendario
        $matrizCalendario = $calendarMap[$datosPlan['id_calendar']];

        // Obtener el primer mes y año
        $mesNumero = $matrizCalendario[0]['mes'];
        $anio = $matrizCalendario[0]['anio'];

        // Convertir el número de mes a nombre
        $mes = isset($mesesNombres[$mesNumero]) ? $mesesNombres[$mesNumero] : 'N/A';
    } else {
        $mes = 'N/A';
        $anio = 'N/A';
    }
    ?>
    <p class="clearfix">
                                <span class="float-start">Año</span>
                                <span class="float-right text-muted "><?php echo $anio; ?></span>
                            </p>
                            <p class="clearfix">
                                <span class="float-start">Mes</span>
                                <span class="float-right text-muted "><?php echo $mes; ?></span>
                            </p>
    </div>
</div>
                </div>
                 
              
               
              </div>
              <div class="col-12 col-md-12 col-lg-8">
                <div class="card">
                  <div class="padding-20">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab2" data-bs-toggle="tab" href="#medio" role="tab"
                          aria-selected="true">Información Calendario</a>
                      </li>
                       <li class="removido">
                       <button type="button" class="btn6" data-bs-toggle="modal" data-bs-target="#exampleModal">
                       <i class="fas fa-edit duo"></i></button><li>
                    </ul>
                    <div class="calendario">
        <div class="selectores">
            <select style="display:none;" id="mesSelector">
                <?php foreach ($mesesMap as $id => $mes): ?>
                    <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($mes['Nombre']); ?></option>
                <?php endforeach; ?>
            </select>
            <select style="display:none;" id="anioSelector">
                <?php foreach ($aniosMap as $id => $anio): ?>
                    <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($anio['years']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="diasContainer" class="dias"></div>
        
    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <div class="settingSidebar">
          <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
          </a>
          <div class="settingSidebar-body ps-container ps-theme-default">
            <div class=" fade show active">
              <div class="setting-panel-header">Setting Panel
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Select Layout</h6>
                <div class="selectgroup layout-color w-50">
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                    <span class="selectgroup-button">Light</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                    <span class="selectgroup-button">Dark</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                <div class="selectgroup selectgroup-pills sidebar-color">
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                    <span class="selectgroup-button selectgroup-button-icon" data-bs-toggle="tooltip"
                      data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                    <span class="selectgroup-button selectgroup-button-icon" data-bs-toggle="tooltip"
                      data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Color Theme</h6>
                <div class="theme-setting-options">
                  <ul class="choose-theme list-unstyled mb-0">
                    <li title="white" class="active">
                      <div class="white"></div>
                    </li>
                    <li title="cyan">
                      <div class="cyan"></div>
                    </li>
                    <li title="black">
                      <div class="black"></div>
                    </li>
                    <li title="purple">
                      <div class="purple"></div>
                    </li>
                    <li title="orange">
                      <div class="orange"></div>
                    </li>
                    <li title="green">
                      <div class="green"></div>
                    </li>
                    <li title="red">
                      <div class="red"></div>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="mini_sidebar_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Mini Sidebar</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="sticky_header_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Sticky Header</span>
                  </label>
                </div>
              </div>
              <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                  <i class="fas fa-undo"></i> Restore Default
                </a>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      <?php include '../componentes/settings.php'; ?>
<script src="../../../assets/js/updateMedio.js"></script>
<?php include '../componentes/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var anioID = <?php echo json_encode($anioID); ?>;
    console.log('El ID para el año es:', anioID);
    mesSelector.value = <?php echo $mesInicial; ?>;
anioSelector.value = <?php echo json_encode($anioID); ?>;

const diasContainer = document.getElementById('diasContainer');
const submitButton = document.getElementById('submitButton');

if (!mesSelector || !anioSelector || !diasContainer ) {
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
            <input type="number" id="input-${anio}-${mes}-${dia}" value="${cantidad}" readonly />
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
            id_agencia: document.getElementById('selected-agencia-id').value,
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
                window.location.reload(); // Recarga la página
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