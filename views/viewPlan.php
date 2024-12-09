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
// Filtrar el plan específico basado en el ID
$plan_seleccionado = null;
foreach ($planes as $plan) {
    if ($plan['id_planes_publicidad'] == $id_planes_publicidad) {
        $plan_seleccionado = $plan;
        break;
    }
}



$nombre_plan = $plan_seleccionado['NombrePlan'];
$idproducto = $plan_seleccionado['id_producto'];
$idcampaña = $plan_seleccionado['id_campania'];
$idSoporte = $plan_seleccionado['id_soporte'];
$fac = $plan_seleccionado['fr_factura'];
$idcontrato = $plan_seleccionado['id_contrato'];
$idCliente = $plan_seleccionado['id_cliente'];

$nombreCliente = '';
$razonSocial = '';
foreach ($clientesMap as $cliente) {
    if ($cliente['id'] == $idCliente) {
        $nombreCliente = $cliente['nombreCliente'];
        $razonSocial = $cliente['razonSocial'];
        break; // Terminar el bucle una vez encontrado
    }
}

$nombreProducto = '';
$razonSocialProducto = '';
foreach ($productosMap as $producto) {
    if ($producto['id'] == $idproducto) {
        $nombreProducto = $producto['nombreProducto'];
        $razonSocialProducto = $producto['razonSocial'];
        break; // Terminar el bucle una vez encontrado
    }
}
$nombreSoporte = '';
foreach ($soportesMap as $soporte) {
    if ($soporte['id'] == $idSoporte) {
        $nombreSoporte = $soporte['nombreSoporte'];
        break; // Terminar el bucle una vez encontrado
    }
}
$nombreCampania = '';
foreach ($campaignsMap as $campaign) {
    if ($campaign['id'] == $idcampaña) {
        $nombreCampania = $campaign['nombreCampania'];
        break; // Terminar el bucle una vez encontrado
    }
}

$contratoSeleccionado = null;
foreach ($contratosMap as $contrato) {
    if ($contrato['id'] == $idcontrato) {
        $contratoSeleccionado = $contrato;
        break; // Salimos del loop cuando encontramos el contrato
    }
}
$nombreContrato = $contratoSeleccionado['nombreContrato'];
$idAnio = $contratoSeleccionado['id_Anio'];
$idMes = $contratoSeleccionado['id_Mes'];

// 3. Obtener el 'years' usando el id_Anio
$year = isset($aniosMap[$idAnio]) ? $aniosMap[$idAnio]['years'] : null;

// 4. Obtener el 'Nombre' del mes usando el id_Mes
$mes = isset($mesesMap[$idMes]) ? $mesesMap[$idMes]['Nombre'] : null;



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

                                    <?php echo $id_orden_de_compra ?>
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
                                <span class="float-start">Cliente</span>
                                <span class="float-right text-muted "><?php echo $nombreCliente ; ?></span>
                            </p>
                            <p class="clearfix">
                                <span class="float-start">Razón Social</span>
                                <span class="float-right text-muted "><?php echo $razonSocial; ?></span>
                            </p>
                            <p class="clearfix">
                                <span class="float-start">Producto</span>
                                <span class="float-right text-muted "><?php echo $nombreProducto; ?></span>
                            </p>
                            <p class="clearfix">
                                <span class="float-start">Soporte</span>
                                <span class="float-right text-muted "><?php echo $nombreSoporte; ?></span>
                            </p> 
                            <p class="clearfix">
                                <span class="float-start">Campaña</span>
                                <span class="float-right text-muted "><?php echo $nombreCampania; ?></span>
                            </p>
                            <p class="clearfix">
                                <span class="float-start">Contrato</span>
                                <span class="float-right text-muted "><?php echo $nombreContrato; ?></span>
                            </p> 
                            <p class="clearfix">
                                <span class="float-start">Año</span>
                                <span class="float-right text-muted "><?php echo $year; ?></span>
                            </p> 
                            <p class="clearfix">
                                <span class="float-start">Mes</span>
                                <span class="float-right text-muted "><?php echo $mes ; ?></span>
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
