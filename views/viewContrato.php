<?php
// Iniciar la sesión
session_start();

include '../querys/qcontratos.php';
// Obtener el ID del cliente de la URL
$idContrato = isset($_GET['id']) ? $_GET['id'] : null;

if (!$idContrato) {
    die("No se proporcionó un ID de cliente válido.");
}

$contrato = isset($contratosMap[$idContrato]) ? $contratosMap[$idContrato] : null;

if (!$contrato) {
    die("No se encontró el contrato especificado.");
}

// Obtener datos del contrato específico
$url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Contratos?id=eq.$idContrato&select=*";

$nombreCliente = isset($clientesMap[$contrato['IdCliente']]) ? $clientesMap[$contrato['IdCliente']]['nombreCliente'] : 'N/A';
$nombreProvee = isset($proveedorMap[$contrato['IdProveedor']]) ? $proveedorMap[$contrato['IdProveedor']]['nombreProveedor'] : 'N/A';
$nombreProducto = 'N/A';
if (isset($productosMap[$contrato['IdCliente']]) && !empty($productosMap[$contrato['IdCliente']])) {
    $nombreProducto = $productosMap[$contrato['IdCliente']][0]['NombreDelProducto'];
}
$nombreMedio = isset($mediosMap[$contrato['IdMedios']]) ? $mediosMap[$contrato['IdMedios']]['NombredelMedio'] : 'N/A';
$tipoPublicidad = isset($tipoPMap[$contrato['IdTipoDePublicidad']]) ? $tipoPMap[$contrato['IdTipoDePublicidad']]['NombreTipoPublicidad'] : 'N/A';
$anioz = isset($aniosMap[$contrato['id_Anio']]) ? $aniosMap[$contrato['id_Anio']]['years'] : 'N/A';
$mez = isset($mesesMap[$contrato['id']]) ? $mesesMap[$contrato['id_Mes']]['Nombre'] : 'N/A';
$formaPago = isset($pagosMap[$contrato['id_FormadePago']]) ? $pagosMap[$contrato['id_FormadePago']]['NombreFormadePago'] : 'N/A';
$ordenGeracionTipo = isset($ordenMap[$contrato['id_GeneraracionOrdenTipo']]) ? $ordenMap[$contrato['id_GeneraracionOrdenTipo']]['NombreTipoOrden'] : 'N/A';
$ordenesPublicidad = array_filter($ordenesPublicidad, function($orden) use ($contrato) {
  return $orden['num_contrato'] == $contrato['id'];
});
include '../componentes/header.php';
include '../componentes/sidebar.php';

?>

      <!-- Main Content -->
      <div class="main-content">
      
      <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>ListContratos.php">Ver Contratos</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $contrato['NombreContrato']; ?></li>
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
                      <div class="nombrex author-box-name">
                      <?php echo $contrato['NombreContrato']; ?>
                       
                      </div>
                      <div class="author-box-job">
                      <?php
    // Convertir la cadena de fecha y hora a un objeto DateTime
    $fecha = new DateTime($contrato['FechaInicio']);
    
    // Formatear la fecha como deseas (en este caso, solo la fecha)
    echo 'Fecha Inicio: '.$fecha->format('d-m-Y'); // Esto mostrará la fecha en formato AAAA-MM-DD
    ?>
                    </div>
                    </div>
                    <div class="author-box-job text-center">
                    N° de Contrato: <?php echo $contrato['num_contrato']; ?>
                    </div>
                    <div class="text-center">
                      <div class="author-box-job">
                      <?php 
    // Suponiendo que $contrato['Estado'] contiene el valor del estado
    $estado = $contrato['Estado'];

    // Verifica el valor del estado y muestra el mensaje correspondiente
    if ($estado == 1) {
        echo "El Contrato se encuentra activo";
    } elseif ($estado == 0) {
        echo "El Contrato se encuentra desactivado";
    } else {
        echo "Estado desconocido"; // Mensaje opcional para valores inesperados
    }
?>
<div>
  <button style="margin-top:15px; border-radius: 30px;" type="button" class="btn btn-danger micono" data-bs-toggle="modal" data-bs-target="#modalEditContrato" data-contrato-id="<?php echo $contrato['id']; ?>"><i class="fas fa-pencil-alt"></i> Editar datos</button></div>
                           
                   
                      </div>
                      
                      <div class="w-100 d-sm-none"></div>

                      
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
                          aria-selected="true">Información del Contrato</a>
                      </li>
                      <li class="nav-item"> 
                        <a class="nav-link" id="home-tab3" data-bs-toggle="tab" href="#ordenc" role="tab"
                          aria-selected="true">Ordenes de Contrato</a>
                      </li>
                       <li class="removido">
                       <button type="button" class="btn6" data-bs-toggle="modal" data-bs-target="#exampleModal">
                       <i class="fas fa-edit duo"></i></button><li>
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                      <div class="tab-pane fade show active" id="medio" role="tabpanel" aria-labelledby="home-tab2">
                        <div class="row">
                          <div class="col-md-3 col-12 b-r">
                            <strong>Nombre del Contrato</strong>
                            <br>
                            <p class="text-muted"><?php echo $contrato['NombreContrato']; ?></p>
                          </div>
                          <div class="col-md-3 col-12 b-r">
                            <strong>Cliente</strong>
                            <br>                      
                            <p class="text-muted"><?php echo $nombreCliente; ?></p>
                          </div>
                          <div class="col-md-3 col-12 b-r">
                            <strong>Proveedor</strong>
                            <br>
                            <p class="text-muted"><?php echo $nombreProvee; ?></p>
                          </div>
                          <div class="col-md-3 col-12 b-r">
                            <strong>Producto</strong>
                            <br>
                            <p class="text-muted"><?php echo $contrato['nombreProducto']; ?></p>
                          </div>
                          <div class="col-md-3 col-12 b-r">
                            <strong>Medio</strong>
                            <br>
                            <p class="text-muted"><?php echo $nombreMedio; ?></p>
                          </div>
                          <div class="col-md-3 col-12 b-r">
                            <strong>Tipo de Publicidad</strong>
                            <br>
                            <p class="text-muted"><?php echo $tipoPublicidad; ?></p>
                          </div>
                          <div class="col-md-3 col-12 b-r">
                            <strong>Año</strong>
                            <br>
                            <p class="text-muted"><?php echo $anioz; ?></p>
                          </div>
                          <div class="col-md-3 col-12 b-r">
                            <strong>Mes</strong>
                            <br>
                            <p class="text-muted"><?php echo $mez; ?></p>
                          </div>
                          
                          <div class="col-md-3 col-12 b-r">
                            <strong>Tipo generación de Orden</strong>
                            <br>
                            <p class="text-muted"><?php echo $ordenGeracionTipo; ?></p>
                          </div>
                          <div class="col-md-3 col-12 b-r">
                            <strong>Forma de Pago</strong>
                            <br>
                            <p class="text-muted"><?php echo $formaPago; ?></p>
                          </div>
                          <div class="col-md-3 col-12 b-r">
                                                        <strong>Fecha Inicio</strong>
                                                        <br>
                                                        <p class="text-muted"><?php
                                // Convertir la cadena de fecha y hora a un objeto DateTime
                                $fecha = new DateTime($contrato['FechaInicio']);
                                
                                // Formatear la fecha como deseas (en este caso, solo la fecha)
                                echo $fecha->format('d-m-Y'); // Esto mostrará la fecha en formato AAAA-MM-DD
                                ?></p>
                                                      </div>
                                                      <div class="col-md-3 col-12 b-r">
                                                        <strong>Fecha de Término</strong>
                                                        <br>
                                                        <p class="text-muted"><?php
                                // Convertir la cadena de fecha y hora a un objeto DateTime
                                $fecha = new DateTime($contrato['FechaTermino']);
                                
                                // Formatear la fecha como deseas (en este caso, solo la fecha)
                                echo $fecha->format('d-m-Y'); // Esto mostrará la fecha en formato AAAA-MM-DD
                                ?></p>
                          </div>
                        </div>
                        <div class="col-md-12 col-12 b-r">
                            <strong>Observaciones</strong>
                            <br>
                            <p class="text-muted"><?php echo $contrato['Observaciones']; ?></p>
                          </div>
                      </div>


                      <div class="tab-pane fade " id="ordenc" role="tabpanel" aria-labelledby="home-tab3">
                      <div style="padding:0px;" class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tableExportadora">
                                    <thead>
                                        <tr>
                                            <th>N° Orden</th>
                                            <th>Proveedor</th>
                                            <th>Cod Megatime</th>
                                            <th>Tema</th>
                                            <th>Soporte</th>
                      
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ordenesPublicidad as $orden): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($orden['id_ordenes_de_comprar']); ?></td>
                                            <td><?php echo htmlspecialchars($proveedoresMap[$orden['id_proveedor']]['nombreProveedor'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($orden['Megatime']); ?></td>
                                            <td><?php echo htmlspecialchars($temasMap[$orden['id_tema']]['NombreTema'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($soportesMap[$orden['id_soporte']]['nombreIdentficiador'] ?? ''); ?></td>
                  
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
                                                    <a class="btn btn-primary micono" href="../querys/modulos/orden.php?id_orden=<?php echo $orden['id_ordenes_de_comprar']; ?>" data-toggle="tooltip" title="Ver Orden">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
           
                                                    <a class="btn btn-success micono" href="../querys/modulos/editarOrden.php?id_orden=<?php echo $orden['id_ordenes_de_comprar']; ?>">
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


      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="formModal">EDITAR MEDIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                 <!-- Alerta para mostrar el resultado de la actualización -->
                 <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>
                            
                 
                <form id="updateMedioForm">
    <input type="hidden" name="id" value="<?php echo $idMedio; ?>">
    <div class="form-group">
        <label for="NombredelMedio">Nombre del Medio</label>
         <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="
fas fa-caret-square-right"></i></span>
            </div>
        <input type="text" class="form-control" id="NombredelMedio" name="NombredelMedio" value="<?php echo htmlspecialchars($datosMedio['NombredelMedio']); ?>">
    </div>
    </div>
    <div class="form-group">
        <label for="codigo">Código</label>
        <div class="input-group">
        <div class="input-group-prepend">
                <span class="input-group-text"><i class="
fas fa-barcode"></i></span>
            </div>
        <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo htmlspecialchars($datosMedio['codigo']); ?>">
    </div>
    </div>
    <div class="form-group">
        <label for="Id_Clasificacion">Clasificación</label>
         <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-indent"></i></span>
            </div>
        <select class="form-control" id="Id_Clasificacion" name="Id_Clasificacion">
            <?php foreach ($themedio as $clasificacion): ?>
                <option value="<?php echo $clasificacion['id_clasificacion_medios']; ?>" 
                        <?php echo ($clasificacion['id_clasificacion_medios'] == $datosMedio['Id_Clasificacion']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($clasificacion['NombreClasificacion']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    </div>
    <button type="submit" class="btn btn-primary">Guardar cambios</button>
</form>
              </div>
            </div>
          </div>
        </div>

        
<?php include '../componentes/settings.php'; ?>
<?php include '../querys/modulos/modalEditContrato.php';?>
<?php include '../componentes/footer.php'; ?>

<script>
// Asegurarse de que este código se ejecute solo una vez
(function() {
    if (window.hasRun) return;
    window.hasRun = true;

    const SUPABASE_URL = 'https://ekyjxzjwhxotpdfzcpfq.supabase.co';
    const SUPABASE_API_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc';

    // Función para mostrar la pantalla de carga
    function showLoading() {
        const loadingOverlay = document.createElement('div');
        loadingOverlay.id = 'loadingOverlay';
        loadingOverlay.style.position = 'fixed';
        loadingOverlay.style.top = '0';
        loadingOverlay.style.left = '0';
        loadingOverlay.style.width = '100%';
        loadingOverlay.style.height = '100%';
        loadingOverlay.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
        loadingOverlay.style.display = 'flex';
        loadingOverlay.style.justifyContent = 'center';
        loadingOverlay.style.alignItems = 'center';
        loadingOverlay.style.zIndex = '9999';

        const loadingImage = document.createElement('img');
        loadingImage.src = "/assets/img/loading.gif";
        loadingImage.alt = "Cargando...";
        loadingImage.style.width = '220px';
        loadingImage.style.height = '135px';

        loadingOverlay.appendChild(loadingImage);
        document.body.appendChild(loadingOverlay);
    }

    // Función para ocultar la pantalla de carga
    function hideLoading() {
        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) {
            loadingOverlay.remove();
        }
    }

    // Función para obtener los datos del formulario
    function getFormData() {
        const form = document.getElementById('form-edit-contrato');
        const formData = new FormData(form);
        const dataObject = {};
        formData.forEach((value, key) => {
            if (key === 'Estado') {
                dataObject[key] = value === "1";
            } else if (['id', 'IdCliente', 'IdProveedor', 'id_FormadePago', 'IdMedios', 'id_Mes', 'id_Anio', 'IdTipoDePublicidad', 'id_GeneraracionOrdenTipo', 'num_contrato'].includes(key)) {
                dataObject[key] = value !== "" ? parseInt(value, 10) : null;
            } else if (['ValorNeto', 'ValorBruto', 'Descuento1', 'ValorTotal'].includes(key)) {
                dataObject[key] = value !== "" ? parseFloat(value) : null;
            } else if (key === 'idProducto') {
                dataObject['nombreProducto'] = value;
            } else {
                dataObject[key] = value;
            }
        });
        console.log('Datos del formulario:', dataObject);
        return dataObject;
    }

    // Función para validar el formulario
    function validateForm() {
        const fechaInicio = new Date(document.getElementById('editFechaInicio').value);
        const fechaTermino = new Date(document.getElementById('editFechaTermino').value);
        
        if (fechaTermino < fechaInicio) {
            Swal.fire({
                title: 'Error',
                text: 'La fecha de término no puede ser anterior a la fecha de inicio',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return false;
        }

        

        return true;
    }

    // Función para enviar el formulario con PATCH
    async function submitForm(event) {
        event.preventDefault();
        if (!validateForm()) return;

        const formData = getFormData();
        const contratoId = formData.id;
        if (!contratoId) {
            await Swal.fire({
                title: 'Error',
                text: 'No se pudo identificar el ID del contrato. Por favor, inténtelo nuevamente.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        delete formData.id;

        // Eliminar propiedades con valor null o undefined
        Object.keys(formData).forEach(key => 
            (formData[key] === null || formData[key] === undefined) && delete formData[key]
        );

        try {
            const response = await fetch(`${SUPABASE_URL}/rest/v1/Contratos?id=eq.${contratoId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'apikey': SUPABASE_API_KEY,
                    'Authorization': `Bearer ${SUPABASE_API_KEY}`
                },
                body: JSON.stringify(formData)
            });

            if (response.ok) {
                let modal = bootstrap.Modal.getInstance(document.getElementById('modalEditContrato'));
                modal.hide();
                await Swal.fire({
                    title: '¡Éxito!',
                    text: 'El contrato se ha actualizado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                showLoading(); // Mostrar la pantalla de carga después del Sweet Alert
                window.location.reload();
            } else {
                const errorData = await response.json();
                console.error("Error:", errorData);
                await Swal.fire({
                    title: 'Error',
                    text: 'Ha ocurrido un error al actualizar el contrato. Por favor, inténtelo nuevamente.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        } catch (error) {
            console.error("Error:", error);
            await Swal.fire({
                title: 'Error',
                text: 'Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    }

    // Función para cargar los datos del contrato en el formulario
    async function loadContratoData(contratoId) {
        console.log('Cargando contrato con ID:', contratoId);
        try {
            const response = await fetch(`${SUPABASE_URL}/rest/v1/Contratos?id=eq.${contratoId}&select=*`, {
                headers: {
                    'apikey': SUPABASE_API_KEY,
                    'Authorization': `Bearer ${SUPABASE_API_KEY}`
                }
            });
            if (!response.ok) throw new Error('Error al obtener los datos del contrato');
            const data = await response.json();
            if (data.length === 0) throw new Error('No se encontró el contrato');
            
            const contrato = data[0];
            console.log('Datos del contrato:', contrato);

            // Llenar el formulario con los datos del contrato
            document.getElementById('editIdContrato').value = contrato.id;
            document.getElementById('editNombreContrato').value = contrato.NombreContrato || '';
            document.getElementById('editIdCliente').value = contrato.IdCliente || '';
            document.getElementById('editIdProveedor').value = contrato.IdProveedor || '';
            document.getElementById('editIdMedios').value = contrato.IdMedios || '';
            document.getElementById('editIdFormaDePago').value = contrato.id_FormadePago || '';
            document.getElementById('editFechaInicio').value = contrato.FechaInicio || '';
            document.getElementById('editFechaTermino').value = contrato.FechaTermino || '';
            document.getElementById('editIdMes').value = contrato.id_Mes || '';
            document.getElementById('editIdAnio').value = contrato.id_Anio || '';
            document.getElementById('editIdTipoDePublicidad').value = contrato.IdTipoDePublicidad || '';
            document.getElementById('editIdGeneracionOrdenTipo').value = contrato.id_GeneraracionOrdenTipo || '';
            document.getElementById('editObservaciones').value = contrato.Observaciones || '';
            document.getElementById('editEstado').value = contrato.Estado ? '1' : '0';
            document.getElementById('editNumContrato').value = contrato.num_contrato || '';

            // Cargar productos del cliente
            await cargarProductoCliente(contrato.IdCliente);
            document.getElementById('editIdProducto').value = contrato.nombreProducto || '';

            // Cargar medios del proveedor
            await filtrarMediosProveedor(contrato.IdProveedor);
        } catch (error) {
            console.error('Error al cargar los datos del contrato:', error);
            await Swal.fire({
                title: 'Error',
                text: 'No se pudieron cargar los datos del contrato. Por favor, inténtelo nuevamente.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    }

    // Función para cargar productos de un cliente
    async function cargarProductoCliente(idCliente) {
        const selectProducto = document.getElementById('editIdProducto');
        selectProducto.innerHTML = '<option value="">Cargando productos del cliente...</option>';

        if (!idCliente) {
            selectProducto.innerHTML = '<option value="">Seleccione un cliente primero</option>';
            return;
        }

        try {
            const response = await fetch(`${SUPABASE_URL}/rest/v1/Productos?Id_Cliente=eq.${idCliente}&select=*`, {
                headers: {
                    'apikey': SUPABASE_API_KEY,
                    'Authorization': `Bearer ${SUPABASE_API_KEY}`
                }
            });
            if (!response.ok) throw new Error('Error al obtener los productos');
            const productos = await response.json();
            
            selectProducto.innerHTML = '';
            if (productos.length > 0) {
                productos.forEach(producto => {
                    const option = document.createElement('option');
                    option.value = producto.NombreDelProducto;
                    option.textContent = producto.NombreDelProducto;
                    selectProducto.appendChild(option);
                });
            } else {
                selectProducto.innerHTML = '<option value="">No hay productos para este cliente</option>';
            }
        } catch (error) {
            console.error('Error al cargar productos:', error);
            selectProducto.innerHTML = '<option value="">Error al cargar productos</option>';
        }
    }

    // Función para filtrar medios de un proveedor
    async function filtrarMediosProveedor(idProveedor) {
        const selectMedio = document.getElementById('editIdMedios');
        selectMedio.innerHTML = '<option value="">Cargando medios del proveedor...</option>';
        selectMedio.disabled = true;

        if (!idProveedor) {
            selectMedio.innerHTML = '<option value="">Seleccione un proveedor primero</option>';
            selectMedio.disabled = false;
            return;
        }

        try {
            const responseRelaciones = await fetch(`${SUPABASE_URL}/rest/v1/proveedor_medios?id_proveedor=eq.${idProveedor}&select=id_medio`, {
                headers: {
                    'apikey': SUPABASE_API_KEY,
                    'Authorization': `Bearer ${SUPABASE_API_KEY}`
                }
            });
            if (!responseRelaciones.ok) throw new Error('Error al obtener las relaciones proveedor-medio');
            const relaciones = await responseRelaciones.json();

            if (relaciones.length > 0) {
                const idMedios = relaciones.map(rel => rel.id_medio);
                const responseMedios = await fetch(`${SUPABASE_URL}/rest/v1/Medios?id=in.(${idMedios.join(',')})&select=*`, {
                    headers: {
                        'apikey': SUPABASE_API_KEY,
                        'Authorization': `Bearer ${SUPABASE_API_KEY}`
                    }
                });
                if (!responseMedios.ok) throw new Error('Error al obtener los medios');
                const medios = await responseMedios.json();

                selectMedio.innerHTML = '';
                medios.forEach(medio => {
                    const option = document.createElement('option');
                    option.value = medio.id;
                    option.textContent = medio.NombredelMedio;
                    selectMedio.appendChild(option);
                });
            } else {
                selectMedio.innerHTML = '<option value="">No hay medios disponibles para este proveedor</option>';
            }
        } catch (error) {
            console.error('Error al cargar medios:', error);
            selectMedio.innerHTML = '<option value="">Error al cargar medios</option>';
        } finally {
            selectMedio.disabled = false;
        }
    }

    // Función para calcular el Valor Bruto y Total
    function calcularValores() {
      const valorNeto = parseFloat(document.getElementById('editValorNeto').value) || 0;
        const valorBruto = Math.round(valorNeto * 1.19);
        const descuento = parseFloat(document.getElementById('editDescuento1').value) || 0;
        const valorTotal = Math.max(0, valorBruto - descuento);

        document.getElementById('editValorBruto').value = valorBruto;
        document.getElementById('editValorTotal').value = valorTotal;
    }

    // Función para obtener el siguiente número de contrato
    function getNextContractNumber() {
        fetch(`${SUPABASE_URL}/rest/v1/Contratos?select=num_contrato&order=num_contrato.desc&limit=1`, {
            headers: {
                "apikey": SUPABASE_API_KEY,
                "Authorization": `Bearer ${SUPABASE_API_KEY}`
            }
        })
        .then(response => response.json())
        .then(data => {
            let nextNumber = 1;
            if (data.length > 0 && data[0].num_contrato) {
                nextNumber = parseInt(data[0].num_contrato) + 1;
            }
            document.getElementById('editNumContrato').value = nextNumber;
        })
        .catch(error => {
            console.error("Error al obtener el siguiente número de contrato:", error);
            document.getElementById('editNumContrato').value = 1; // Valor por defecto en caso de error
        });
    }

    // Inicializar los manejadores de eventos cuando se abre el modal
    const modal = document.getElementById('modalEditContrato');
    if (modal) {
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const contratoId = button.getAttribute('data-contrato-id');
            console.log('ID del contrato a editar:', contratoId);
            loadContratoData(contratoId);
        });
    }

    // Agregar el event listener al botón de editar contrato
    const btnEditContrato = document.getElementById('btn-edit-contrato');
    if (btnEditContrato) {
        btnEditContrato.addEventListener('click', submitForm);
    }

    // Agregar event listeners para el cálculo automático
    document.getElementById('editValorNeto').addEventListener('input', calcularValores);
    document.getElementById('editDescuento1').addEventListener('input', calcularValores);

    // Event listener para cargar productos cuando cambia el cliente
    const selectCliente = document.getElementById('editIdCliente');
    if (selectCliente) {
        selectCliente.addEventListener('change', function() {
            cargarProductoCliente(this.value);
        });
    }

    // Event listener para filtrar medios cuando cambia el proveedor
    const selectProveedor = document.getElementById('editIdProveedor');
    if (selectProveedor) {
        selectProveedor.addEventListener('change', function() {
            filtrarMediosProveedor(this.value);
        });
    }

    // Llamar a getNextContractNumber cuando se abre el modal de edición
    // (solo si el campo está vacío, para no sobrescribir contratos existentes)
    modal.addEventListener('show.bs.modal', function () {
        const numContratoField = document.getElementById('editNumContrato');
        if (!numContratoField.value) {
            getNextContractNumber();
        }
    });

    // Agregar un event listener para cuando la página haya terminado de cargar
    window.addEventListener('load', function() {
        hideLoading();
    });

})();
</script>