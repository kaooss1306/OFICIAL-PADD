<?php
// Iniciar la sesión
session_start();

// Incluir funciones necesarias
include '../querys/qclientes.php';

// Obtener el ID del cliente de la URL
$idCliente = isset($_GET['id_cliente']) ? $_GET['id_cliente'] : null;

if (!$idCliente) {
    die("No se proporcionó un ID de cliente válido.");
}

// Obtener datos del cliente específico
$url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes?id_cliente=eq.$idCliente&select=*";
$cliente = makeRequest($url);

// Verificar si se obtuvo el cliente
if (empty($cliente) || !isset($cliente[0])) {
    die("No se encontró el cliente con el ID proporcionado.");
}

$datosCliente = $cliente[0];

// Obtener productos asociados al cliente
$productos = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Productos?Id_Cliente=eq.$idCliente&select=*");

// Crear un mapa de productos para fácil acceso si es necesario
$productosMap = array_column($productos, null, 'id');

// Obtener comisión del cliente
$comisionCliente = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comisiones?id_cliente=eq.$idCliente&select=*");

// Verificar si se obtuvo la comisión del cliente
// Verificar si se obtuvo la comisión del cliente
if (!empty($comisionCliente) && is_array($comisionCliente) && isset($comisionCliente[0])) {
    $primerComision = $comisionCliente[0];
    
    $valorComision = $primerComision['valorComision'] ?? "No disponible";
    $fechaInicio = $primerComision['inicioComision'] ?? "No disponible";
    $fechaTermino = $primerComision['finComision'] ?? "No disponible";
} else {
    $valorComision = "No disponible";
    $fechaInicio = "No disponible";
    $fechaTermino = "No disponible";
}

// Obtener tipos de moneda
$monedas = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/TipoMoneda?select=*");

// Crear un mapa de monedas para fácil acceso
$monedasMap = array_column($monedas, 'nombreMoneda', 'id_moneda');

// Obtener tipos de formato

$formatos = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/formatoComision?select=*");
// Crear un mapa de formatos para fácil acceso
$formatosMap = array_column($formatos, 'nombreFormato', 'id_formatoComision');

include '../componentes/header.php';
include '../componentes/sidebar.php';
?>

<style>
       .is-invalid {
        border-color: #dc3545 !important;
    }
    .custom-tooltip {
        position: absolute;
        background-color: #dc3545;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
    }
    .custom-tooltip::before {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #dc3545 transparent transparent transparent;
    }
    .input-wrapper {
        position: relative;
    }
</style>
<!-- Main Content -->
<div class="main-content">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard.php">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>ListClientes.php">Ver Clientes</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $datosCliente['nombreCliente'] ; ?></li>
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
                                    <?php echo $datosCliente['nombreCliente'] ; ?>
                                </div>
                                <div class="author-box-job">
                                    <?php
    // Convertir la cadena de fecha y hora a un objeto DateTime
    $fecha = new DateTime($datosCliente['created_at']);
    
    // Formatear la fecha como deseas (en este caso, solo la fecha)
    echo 'Registrado el: '.$fecha->format('d-m-Y'); // Esto mostrará la fecha en formato AAAA-MM-DD
    ?>

                                </div>
                            </div>
                            <div class="text-center">
                                <div class="author-box-job">

                                    <?php echo 'Representante Legal: ' .$datosCliente['nombreRepresentanteLegal'] ; ?>

                                </div>
                                <div class="w-100 d-sm-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="cabeza">
                             <h4>Detalles del Cliente</h4> 
                             <button type="button" class="btn btn-danger micono" data-bs-toggle="modal" data-bs-target="#actualizarclienteView" data-id-cliente="<?php echo $datosCliente['id_cliente']; ?>" onclick="loadClienteDataView(this)" ><i class="fas fa-pencil-alt"></i> Editar datos</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-start">
                                        Nombre Cliente
                                    </span>
                                    <span class="float-right text-muted">
                                        <?php echo $datosCliente['nombreCliente'] ; ?>
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-start">
                                        Nombre de Fantasía
                                    </span>
                                    <span class="float-right text-muted">
                                        <?php echo $datosCliente['nombreFantasia'] ; ?>
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-start">
                                        Razón Social
                                    </span>
                                    <span class="float-right text-muted">
                                        <?php echo $datosCliente['razonSocial'] ; ?>
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-start">
                                        Tipo de Cliente
                                    </span>
                                    <span class="float-right text-muted">
                                        <?php echo $tiposClienteMap[$datosCliente['id_tipoCliente']] ?? ''; ?>
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-start">
                                        RUT
                                    </span>
                                    <span class="float-right text-muted">
                                        <?php echo $datosCliente['RUT'] ; ?>
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-start">
                                        Representante Legal
                                    </span>
                                    <span class="float-right text-muted">
                                        <?php echo $datosCliente['nombreRepresentanteLegal'] ; ?>
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-start">
                                        RUT Representante Legal
                                    </span>
                                    <span class="float-right text-muted">
                                        <?php echo $datosCliente['RUT_representante'] ; ?>
                                    </span>
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
                                    <a class="nav-link active" id="home-tab2" data-bs-toggle="tab" href="#facturacion"
                                        role="tab" aria-selected="true">Datos Facturación</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab2" data-bs-toggle="tab" href="#contacto"
                                        role="tab" aria-selected="false">Datos de Contacto</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab3" data-bs-toggle="tab" href="#otros" role="tab"
                                        aria-selected="false">Otros Datos</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab4" data-bs-toggle="tab" href="#productos"
                                        role="tab" aria-selected="false">Productos</a>
                                </li>

                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="facturacion" role="tabpanel"
                                    aria-labelledby="home-tab2">
                                    <div class="row">
                                        <div class="col-md-3 col-6 b-r">
                                            <strong>Razon Social</strong>
                                            <br>
                                            <p class="text-muted"><?php echo $datosCliente['razonSocial'] ; ?></p>
                                        </div>
                                        <div class="col-md-3 col-6 b-r">
                                            <strong>RUT Empresa</strong>
                                            <br>
                                            <p class="text-muted"><?php echo $datosCliente['RUT'] ; ?></p>
                                        </div>
                                        <div class="col-md-3 col-6 b-r">
                                            <strong>Región</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php echo $regionesMap[$datosCliente['id_region']] ?? ''; ?></p>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <strong>Comuna</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php echo $comunasMap[$datosCliente['id_comuna']] ?? ''; ?></p>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <strong>Dirección</strong>
                                            <br>
                                            <p class="text-muted"><?php echo $datosCliente['direccionEmpresa'] ; ?></p>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <strong>Facturación</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php echo $tiposClienteMap[$datosCliente['id_tipoCliente']] ?? ''; ?>
                                            </p>
                                        </div>
                                    </div>

                                </div>



                                <div class="tab-pane fade" id="contacto" role="tabpanel" aria-labelledby="profile-tab2">
                                    <div class="row">
                                        <div class="col-md-4 col-6 b-r">
                                            <strong>Nombre Representante Legal</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php echo $datosCliente['nombreRepresentanteLegal'] ; ?></p>
                                        </div>
                                        
                                        <div class="col-md-3 col-6 b-r">
                                            <strong>Teléfono Celular</strong>
                                            <br>
                                            <p class="text-muted"><?php echo $datosCliente['telCelular'] ; ?></p>
                                        </div>
                                        <div class="col-md-3 col-6 b-r">
                                            <strong>Teléfono Fijo</strong>
                                            <br>
                                            <p class="text-muted"><?php echo $datosCliente['telFijo'] ; ?></p>
                                        </div>
                                        <div class="col-md-2 col-6 b-r">
                                            <strong>Email</strong>
                                            <br>
                                            <p class="text-muted"><?php echo $datosCliente['email'] ; ?></p>
                                        </div>
                                       
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="otros" role="tabpanel" aria-labelledby="profile-tab3">
                                    <div class="card-header milinea">
                                        <div class="titulox am">Listado de Comisiones</div>
                                        <div class="agregar">
                                            <a href="#" class="btn btn-primary open-modal" data-bs-toggle="modal"
                                                data-bs-target="#comisionModal">
                                                <i class="fas fa-plus-circle"></i> Agregar Comisión
                                            </a>
                                        </div>
                                    </div>
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>

                                                <th>Comision</th>
                                                <th>Valor</th>
                                                <th>Formato</th>
                                                <th>Fecha Inicio</th>
                                                <th>Fecha de Término</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($comisionCliente) && isset($comisionCliente[0])): ?>
                                            <?php foreach ($comisionCliente as $comision): ?>

                                            <tr>
                                                <td><?php echo htmlspecialchars($monedasMap[$comision['id_tipoMoneda']] ?? 'No disponible'); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($comision['valorComision'] ?? 'No disponible'); ?>
                                                </td>

                                                <td><?php echo htmlspecialchars($formatosMap[$comision['id_formatoComision']] ?? 'No disponible'); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($fechaInicio); ?></td>
                                                <td><?php echo htmlspecialchars($fechaTermino); ?></td>
                                                <td><input type="hidden" class="id_comision"
                                                        value="<?php echo htmlspecialchars($comision['id_comision'] ?? 'No disponible'); ?>">
                                                       
                                                    <button type="button"
                                                        class="btn btn-danger micono eliminar-comision"
                                                        data-idcomision="<?php echo htmlspecialchars($comision['id_comision'] ?? ''); ?>"
                                                        data-toggle="tooltip" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>

                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <tr>
                                                <td colspan="6">No hay datos disponibles</td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>




                                </div>

                                <div class="tab-pane fade" id="productos" role="tabpanel"
                                    aria-labelledby="profile-tab4">

                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>Nombre Producto</th>
                                                <th>N° Campañas</th>
                                            
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($productos as $producto): ?>

                                            <tr>
                                                <td><?php echo htmlspecialchars($producto['NombreDelProducto']); ?></td>
                                                <td>
                                                    <?php
    // Obtener el ID del producto actual
    $nombreDelProducto = urlencode($producto['id']); // O usa el ID directamente si es un número

    // Construir la URL de solicitud
    $url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Campania?id_Producto=eq.$nombreDelProducto&select=*";

    // Realizar la solicitud y obtener la respuesta
    $campaign = makeRequest($url);

    // Contar ocurrencias de 'id_Producto'
    $campaniaCounts = [];

    foreach ($campaign as $entry) {
        $idProducto = $entry['id_Producto'];
        if (isset($campaniaCounts[$idProducto])) {
            $campaniaCounts[$idProducto]++;
        } else {
            $campaniaCounts[$idProducto] = 1;
        }
    }

    // Obtener el contador para el producto actual
    $conteo = isset($campaniaCounts[$nombreDelProducto]) ? $campaniaCounts[$nombreDelProducto] : 0;

    // Mostrar el contador de campañas en un elemento <p>
    ?>
                                                    <p><?php echo htmlspecialchars($conteo); ?></p>
                                                </td>
                                              
                                                <td>

                                                    <button type="button"
                                                        class="btn btn-danger eliminar-producto micono"
                                                        data-idproducto="<?php echo htmlspecialchars($producto['id']); ?>"
                                                        data-toggle="tooltip">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
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
                            <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout"
                                checked>
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
                            <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar"
                                checked>
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





<div class="modal fade" id="comisionModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">AGREGAR COMISIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Alerta para mostrar el resultado de la actualización -->
                <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>


                <form id="updateMedioForm3">
                    <input type="hidden" name="id_cliente" value="<?php echo $idCliente; ?>">
                    <div class="form-group">
                        <label for="NombreMoneda">Comisión</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                            </div>
                            <select class="form-control" id="nombreMoneda" name="nombreMoneda">
                                <?php foreach ($monedas as $moneda): ?>
                                <option value="<?php echo htmlspecialchars($moneda['id_moneda']); ?>">
                                    <?php echo htmlspecialchars($moneda['nombreMoneda']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="codigo">Valor</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                            <input type="text" class="form-control" id="valorComision" name="valorComision">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="NombreFormato">Formato</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-percent"></i></span>
                            </div>
                            <select class="form-control" id="nombreFormato" name="nombreFormato">
                                <?php foreach ($formatos as $formato): ?>
                                <option value="<?php echo htmlspecialchars($formato['id_formatoComision']); ?>">
                                    <?php echo htmlspecialchars($formato['nombreFormato']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inicioComision">Fecha Inicio</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" class="form-control" id="inicioComision" name="inicioComision">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="finComision">Fecha Término</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" class="form-control" id="finComision" name="finComision">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Comisión</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="actualizarcomisionModal" tabindex="-1" role="dialog" aria-labelledby="actualizarComisionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actualizarComisionModalLabel">ACTUALIZAR COMISIÓN</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="actualizarComisionForm">

                    <input type="hidden" id="actualizar_id_comision" name="id_comision">
                    <input type="hidden" name="id_cliente" value="<?php echo $idCliente; ?>">
                    <div class="form-group">
                        <label for="actualizar_nombreMoneda">Comisión</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                            </div>
                            <select class="form-control" id="actualizar_nombreMoneda" name="nombreMoneda">
                                <?php foreach ($monedas as $moneda): ?>
                                <option value="<?php echo htmlspecialchars($moneda['id_moneda']); ?>">
                                    <?php echo htmlspecialchars($moneda['nombreMoneda']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="actualizar_valorComision">Valor</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                            <input type="text" class="form-control" id="actualizar_valorComision" name="valorComision">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="actualizar_nombreFormato">Formato</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-percent"></i></span>
                            </div>
                            <select class="form-control" id="actualizar_nombreFormato" name="nombreFormato">
                                <?php foreach ($formatos as $formato): ?>
                                <option value="<?php echo htmlspecialchars($formato['id_formatoComision']); ?>">
                                    <?php echo htmlspecialchars($formato['nombreFormato']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="actualizar_inicioComision">Fecha Inicio</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" class="form-control" id="actualizar_inicioComision" name="inicioComision">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="actualizar_finComision">Fecha Término</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" class="form-control" id="actualizar_finComision" name="finComision">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar Comisión</button>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('ID del cliente:', <?php echo json_encode($idCliente); ?>);

    const form = document.getElementById('updateMedioForm3');
    const submitButton = form.querySelector('button[type="submit"]');
    let isSubmitting = false;

    // Asegúrate de reemplazar esto con tu clave API real de Supabase
    const SUPABASE_API_KEY =
        'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc';

    form.addEventListener('submit', async function(event) {
        event.preventDefault();

        if (isSubmitting) {
            console.log('Envío ya en progreso, ignorando este envío.');
            return;
        }

        isSubmitting = true;
        submitButton.disabled = true;

        const formData = new FormData(this);
        const data = {
            id_cliente: parseInt(formData.get('id_cliente')),
            id_tipoMoneda: parseInt(formData.get('nombreMoneda')),
            id_formatoComision: parseInt(formData.get('nombreFormato')),
            valorComision: parseFloat(formData.get('valorComision')),
            inicioComision: formData.get('inicioComision'),
            finComision: formData.get('finComision')
        };

        console.log('Datos del formulario:', data);

        try {
            document.body.classList.add('loaded');

            const response = await fetch(
                'https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comisiones', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'apikey': SUPABASE_API_KEY,
                        'Authorization': `Bearer ${SUPABASE_API_KEY}`,
                        'Prefer': 'return=minimal'
                    },
                    body: JSON.stringify(data)
                });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
            }

            $('#comisionModal').modal('hide');
$('.modal-backdrop').css('display', 'none');

await Swal.fire({
    icon: 'success',
    title: 'Éxito',
    text: 'Comisión guardada exitosamente',
    showConfirmButton: false,
    timer: 1500
});
await cargarComisiones();
            const otrosTab = document.querySelector('a[href="#otros"]');
            if (otrosTab) {
                const tab = new bootstrap.Tab(otrosTab);
                tab.show();
            }
        } catch (error) {
            console.error('Error en la solicitud:', error);
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al guardar la comisión: ' + error.message
            });
        } finally {
            document.body.classList.remove('loaded');
            isSubmitting = false;
            submitButton.disabled = false;
        }
    });

    async function cargarComisiones() {
        const idCliente = <?php echo json_encode($idCliente); ?>;
        console.log('Cargando comisiones para el cliente:', idCliente);

        try {
            const response = await fetch(
                `https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comisiones?id_cliente=eq.${idCliente}&select=*`, {
                    headers: {
                        'apikey': SUPABASE_API_KEY,
                        'Authorization': `Bearer ${SUPABASE_API_KEY}`
                    }
                });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const comisiones = await response.json();
            console.log('Comisiones cargadas:', comisiones);

            actualizarTablaComisiones(comisiones);
        } catch (error) {
            console.error('Error al cargar comisiones:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al cargar las comisiones: ' + error.message
            });
        }
    }

    function actualizarTablaComisiones(comisiones) {
        const tbody = document.querySelector('#otros table tbody');
        tbody.innerHTML = '';

        if (!Array.isArray(comisiones) || comisiones.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6">No hay datos disponibles</td></tr>';
            return;
        }

        comisiones.forEach(comision => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${obtenerNombreMoneda(comision.id_tipoMoneda)}</td>
                <td>${comision.valorComision}</td>
                <td>${obtenerNombreFormato(comision.id_formatoComision)}</td>
                <td>${comision.inicioComision}</td>
                <td>${comision.finComision}</td>
                <td>
                    <input type="hidden" class="id_comision" value="${comision.id_comision}">
               
                    <button type="button" class="btn btn-danger micono eliminar-comision" data-idcomision="${comision.id_comision}" data-toggle="tooltip" title="Eliminar">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function obtenerNombreMoneda(idMoneda) {
        const monedas = <?php echo json_encode($monedasMap); ?>;
        return monedas[idMoneda] || 'Desconocido';
    }

    function obtenerNombreFormato(idFormato) {
        const formatos = <?php echo json_encode($formatosMap); ?>;
        return formatos[idFormato] || 'Desconocido';
    }

    // Cargar comisiones al iniciar la página
    cargarComisiones();

    // Activar el tab correcto al cargar la página
    const urlParams = new URLSearchParams(window.location.search);
    const tabToActivate = urlParams.get('tab');
    if (tabToActivate === 'otros') {
        const otrosTab = document.querySelector('a[href="#otros"]');
        if (otrosTab) {
            const tab = new bootstrap.Tab(otrosTab);
            tab.show();
        }
    }
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const SUPABASE_API_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc';
    const idCliente = document.querySelector('input[name="id_cliente"]').value;

    async function cargarYMostrarComisiones() {
        try {
            const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comisiones?id_cliente=eq.${idCliente}&select=*`, {
                headers: {
                    'apikey': SUPABASE_API_KEY,
                    'Authorization': `Bearer ${SUPABASE_API_KEY}`
                }
            });
            
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const comisiones = await response.json();
            actualizarTablaComisiones(comisiones);
        } catch (error) {
            console.error('Error al cargar comisiones:', error);
            mostrarError('Error al cargar las comisiones: ' + error.message);
        }
    }

    function actualizarTablaComisiones(comisiones) {
        const tbody = document.querySelector('#otros table tbody');
        if (!tbody) {
            console.error('No se encontró el tbody de la tabla');
            return;
        }

        tbody.innerHTML = '';

        if (comisiones.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6">No hay comisiones disponibles</td></tr>';
            return;
        }

        comisiones.forEach(comision => {
            const row = tbody.insertRow();
            row.innerHTML = `
                <td>${obtenerNombreMoneda(comision.id_tipoMoneda)}</td>
                <td>${comision.valorComision}</td>
                <td>${obtenerNombreFormato(comision.id_formatoComision)}</td>
                <td>${comision.inicioComision}</td>
                <td>${comision.finComision}</td>
                <td>
                    <button class="btn btn-success micono editar-comision" data-id="${comision.id_comision}">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button class="btn btn-danger micono eliminar-comision" data-id="${comision.id_comision}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
        });

        agregarEventListeners();
    }

    function agregarEventListeners() {
        document.querySelectorAll('.editar-comision').forEach(btn => {
            btn.onclick = (e) => cargarDatosComision(e.currentTarget.dataset.id);
        });
        document.querySelectorAll('.eliminar-comision').forEach(btn => {
            btn.onclick = (e) => eliminarComision(e.currentTarget.dataset.id);
        });
    }

    async function cargarDatosComision(id) {
        try {
            const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comisiones?id_comision=eq.${id}`, {
                headers: {
                    'apikey': SUPABASE_API_KEY,
                    'Authorization': `Bearer ${SUPABASE_API_KEY}`
                }
            });
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const [comision] = await response.json();
            
            if (comision) {
                document.getElementById('actualizar_id_comision').value = comision.id_comision;
                document.getElementById('actualizar_nombreMoneda').value = comision.id_tipoMoneda;
                document.getElementById('actualizar_valorComision').value = comision.valorComision;
                document.getElementById('actualizar_nombreFormato').value = comision.id_formatoComision;
                document.getElementById('actualizar_inicioComision').value = comision.inicioComision;
                document.getElementById('actualizar_finComision').value = comision.finComision;

                new bootstrap.Modal(document.getElementById('actualizarcomisionModal')).show();
            }
        } catch (error) {
            console.error('Error al cargar los datos de la comisión:', error);
            mostrarError('No se pudieron cargar los datos de la comisión');
        }
    }

    async function actualizarComision(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        const id = formData.get('id_comision');
        const data = {
            id_cliente: parseInt(idCliente),
            id_tipoMoneda: parseInt(formData.get('nombreMoneda')),
            id_formatoComision: parseInt(formData.get('nombreFormato')),
            valorComision: parseFloat(formData.get('valorComision')),
            inicioComision: formData.get('inicioComision'),
            finComision: formData.get('finComision')
        };

        try {
            const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comisiones?id_comision=eq.${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'apikey': SUPABASE_API_KEY,
                    'Authorization': `Bearer ${SUPABASE_API_KEY}`,
                    'Prefer': 'return=minimal'
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            mostrarExito('Comisión actualizada correctamente');
            bootstrap.Modal.getInstance(document.getElementById('actualizarcomisionModal')).hide();
            await cargarYMostrarComisiones();
        } catch (error) {
            console.error('Error al actualizar la comisión:', error);
            mostrarError('No se pudo actualizar la comisión: ' + error.message);
        }
    }

    async function eliminarComision(id) {
        if (!await confirmarEliminar()) return;

        try {
            const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comisiones?id_comision=eq.${id}`, {
                method: 'DELETE',
                headers: {
                    'apikey': SUPABASE_API_KEY,
                    'Authorization': `Bearer ${SUPABASE_API_KEY}`
                }
            });

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            mostrarExito('La comisión ha sido eliminada.');
            await cargarYMostrarComisiones();
        } catch (error) {
            console.error('Error al eliminar la comisión:', error);
            mostrarError('No se pudo eliminar la comisión: ' + error.message);
        }
    }


    function obtenerNombreMoneda(id) {
        const monedas = <?php echo json_encode($monedasMap); ?>;
        return monedas[id] || 'Desconocido';
    }

    function obtenerNombreFormato(id) {
        const formatos = <?php echo json_encode($formatosMap); ?>;
        return formatos[id] || 'Desconocido';
    }

    function mostrarExito(mensaje) {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: mensaje,
            showConfirmButton: false,
            timer: 1500
        });
    }

    function mostrarError(mensaje) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: mensaje
        });
    }

    async function confirmarEliminar() {
        const result = await Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!',
            cancelButtonText: 'Cancelar'
        });
        return result.isConfirmed;
    }

    // Event Listeners
    document.getElementById('actualizarComisionForm').addEventListener('submit', actualizarComision);
    document.getElementById('updateMedioForm3').addEventListener('submit', agregarComision);

    // Inicialización
    cargarYMostrarComisiones();
});
</script>




<!-- Modal para Actualizar Cliente -->
<div class="modal fade" id="actualizarclienteView" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actualizarclienteLabel">Actualizar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateClienteForm3">
                    <input type="hidden" id="id_cliente" name="id_cliente">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="update_nombreCliente" class="form-label">Nombre del Cliente</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="update_nombreCliente" name="nombreCliente" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="update_nombreFantasia" class="form-label">Nombre de Fantasía</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-stars"></i></span>
                                    <input type="text" class="form-control" id="update_nombreFantasia" name="nombreFantasia">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="update_id_tipoCliente" class="form-label">Tipo de Cliente</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-tags"></i></span>
                                    <select class="form-select" id="update_id_tipoCliente" name="id_tipoCliente" required>
                                        <?php foreach ($tiposCliente as $tipo): ?>
                                            <option value="<?php echo $tipo['id_tyipoCliente']; ?>"><?php echo htmlspecialchars($tipo['nombreTipoCliente']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="update_razonSocial" class="form-label">Razón Social</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <input type="text" class="form-control" id="update_razonSocial" name="razonSocial" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="update_grupo" class="form-label">Grupo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-people"></i></span>
                                    <input type="text" class="form-control" id="update_grupo" name="grupo">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 input-wrapper">
                                <label for="update_RUT" class="form-label">RUT Empresa</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" class="form-control" id="update_RUT" name="RUT" required>
                                </div>
                                <div class="custom-tooltip" id="update_RUT-tooltip"></div>
                            </div>
                            <div class="mb-3">
                                <label for="update_giro" class="form-label">Giro</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                    <input type="text" class="form-control" id="update_giro" name="giro" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="update_nombreRepresentanteLegal" class="form-label">Nombre Representante Legal</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" class="form-control" id="update_nombreRepresentanteLegal" name="nombreRepresentanteLegal" required>
                                </div>
                            </div>
                            <div class="mb-3 input-wrapper">
                                <label for="update_RUT_representante" class="form-label">RUT Representante</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" class="form-control" id="update_RUT_representante" name="RUT_representante" required>
                                </div>
                                <div class="custom-tooltip" id="update_RUT_representante-tooltip"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="update_direccionEmpresa" class="form-label">Dirección Empresa</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" class="form-control" id="update_direccionEmpresa" name="direccionEmpresa" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="update_id_region" class="form-label">Región</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-map"></i></span>
                                    <select class="form-select" id="update_id_region" name="id_region" required>
                                        <?php foreach ($regiones as $region): ?>
                                            <option value="<?php echo $region['id']; ?>"><?php echo $region['nombreRegion']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="update_id_comuna" class="form-label">Comuna</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pin-map"></i></span>
                                    <select class="form-select" id="update_id_comuna" name="id_comuna" required>
                                        <?php foreach ($comunas as $comuna): ?>
                                            <option value="<?php echo $comuna['id_comuna']; ?>" data-region="<?php echo $comuna['id_region']; ?>"><?php echo $comuna['nombreComuna']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 input-wrapper">
                                <label for="update_telCelular" class="form-label">Teléfono Celular</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="tel" class="form-control" id="update_telCelular" name="telCelular" required>
                                </div>
                                <div class="custom-tooltip" id="update_telCelular-tooltip"></div>
                            </div>
                            <div class="mb-3 input-wrapper">
                                <label for="update_telFijo" class="form-label">Teléfono Fijo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="tel" class="form-control" id="update_telFijo" name="telFijo">
                                </div>
                                <div class="custom-tooltip" id="update_telFijo-tooltip"></div>
                            </div>
                            <div class="mb-3 input-wrapper">
                                <label for="update_email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="update_email" name="email" required>
                                </div>
                                <div class="custom-tooltip" id="update_email-tooltip"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="update_formato" class="form-label">Formato</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                                    <select class="form-select" id="update_formato" name="formato">
                                    <?php foreach ($formatoComisionMap as $id => $comision): ?>
        <option value="<?php echo htmlspecialchars($id); ?>">
            <?php echo htmlspecialchars($comision['nombreFormato']); ?>
        </option>
    <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="update_nombreMoneda" class="form-label">Moneda</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-currency-exchange"></i></span>
                                    <select class="form-select" id="update_nombreMoneda" name="nombreMoneda">
                                    <?php foreach ($tipoMonedaMap as $id => $tipozMoneda): ?>
        <option value="<?php echo htmlspecialchars($id); ?>">
            <?php echo htmlspecialchars($tipozMoneda['nombreMoneda']); ?>
        </option>
    <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="update_valor" class="form-label">Valor</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-cash"></i></span>
                                    <input type="number" class="form-control" id="update_valor" name="valor">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="updateClienteBtn">Actualizar Cliente</button>
            </div>
        </div>
    </div>
</div>







<script>
document.addEventListener('DOMContentLoaded', function() {
  
    function showError(input, message) {
        input.classList.add('is-invalid');
        var tooltip = document.getElementById(input.id + '-tooltip');
        tooltip.textContent = message;
        tooltip.style.opacity = '1';
        positionTooltip(input, tooltip);
    }

    function hideError(input) {
        input.classList.remove('is-invalid');
        var tooltip = document.getElementById(input.id + '-tooltip');
        tooltip.style.opacity = '0';
    }

    function positionTooltip(input, tooltip) {
        var rect = input.getBoundingClientRect();
        tooltip.style.left = '10px';
        tooltip.style.top = -(tooltip.offsetHeight + 5) + 'px';
    }
    
    var Fn = {
        validaRut: function(rutCompleto) {
            if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test(rutCompleto)) return false;
            var tmp = rutCompleto.split('-');
            var digv = tmp[1];
            var rut = tmp[0];
            if (digv == 'K') digv = 'k';
            return (Fn.dv(rut) == digv);
        },
        dv: function(T) {
            var M = 0, S = 1;
            for (; T; T = Math.floor(T / 10)) S = (S + T % 10 * (9 - M++ % 6)) % 11;
            return S ? S - 1 : 'k';
        }
    };
    function validaPhoneChileno(phone) {
        // Patrón para teléfonos chilenos
        // Acepta formatos: +56912345678, 912345678, 221234567
        var phonePattern = /^(\+?56|0)?([2-9]\d{8}|[2-9]\d{7})$/;
        return phonePattern.test(phone);
    }

    // Validación en tiempo real para RUTs
    var rutInputs = document.querySelectorAll('#RUT, #Rut_representante, #update_RUT, #update_RUT_representante');
    rutInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            if (this.value === "") {
                hideError(this);
            } else if (!Fn.validaRut(this.value)) {
                showError(this, "RUT INVALIDO - DEBES INGRESAR SIN PUNTOS Y CON GUIÓN");
            } else {
                hideError(this);
            }
        });
    });

   // Función de validación de email
function validateEmail(input) {
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (input.value === "") {
        hideError(input);
    } else if (!emailPattern.test(input.value)) {
        showError(input, "EMAIL INCORRECTO");
    } else {
        hideError(input);
    }
}

// Aplicar validación a ambos campos de email
var emailInputs = document.querySelectorAll('.email-input, #update_email');
emailInputs.forEach(function(input) {
    input.addEventListener('input', function() {
        validateEmail(this);
    });
});

      // Validación en tiempo real para teléfonos
      var phoneInputs = document.querySelectorAll('#telCelular, #telFijo, #update_telCelular, #update_telFijo');
    phoneInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            if (this.value === "") {
                hideError(this);
            } else if (!validaPhoneChileno(this.value)) {
                showError(this, "NÚMERO DE TELÉFONO NO VÁLIDO");
            } else {
                hideError(this);
            }
        });
    });

    document.getElementById('saveClienteBtn').addEventListener('click', function() {
        if (validateForm()) {
            submitForm();
        } else {
            alert("Por favor, complete todos los campos correctamente antes de enviar.");
        }
    });

    function validateForm() {
        var inputs = document.querySelectorAll('#addClienteForm input, #addClienteForm select');
        var valid = true;
        
        inputs.forEach(function(input) {
            if (input.value === "") {
                input.classList.add("invalid");
                valid = false;
            } else {
                input.classList.remove("invalid");
            }
        });

        if (!Fn.validaRut(document.getElementById('RUT').value) ||
            !Fn.validaRut(document.getElementById('Rut_representante').value)) {
            valid = false;
        }

        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(document.getElementById('email').value)) {
            valid = false;
        }

        return valid;
    }
});

// Function to fetch and populate commission details
function cargarDetallesComision(idComision) {
    // Make an AJAX request to fetch the commission details
    fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comisiones?id_comision=eq.${idComision}&select=*`, {
        method: 'GET',
        headers: {
                    'Content-Type': 'application/json',
                    'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                    'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                    'Prefer': 'return=representation'
                }
    })
    .then(response => response.json())
    .then(data => {
        if (data && data.length > 0) {
            const comision = data[0];
            
            // Populate the hidden input for commission ID
            document.getElementById('actualizar_id_comision').value = comision.id_comision;
            
            // Populate the currency (moneda) dropdown
            document.getElementById('actualizar_nombreMoneda').value = comision.id_tipoMoneda;
            
            // Populate the format (formato) dropdown
            document.getElementById('actualizar_nombreFormato').value = comision.id_formatoComision;
            
            // Populate the commission value input
            document.getElementById('actualizar_valorComision').value = comision.valorComision;
            
            // Populate the start and end dates
            document.getElementById('actualizar_inicioComision').value = comision.inicioComision;
            document.getElementById('actualizar_finComision').value = comision.finComision;
        }
    })
    .catch(error => {
        console.error('Error fetching commission details:', error);
    });
}

// Add event listeners to edit buttons
document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('.micono');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const idComision = this.getAttribute('data-idcomision');
            cargarDetallesComision(idComision);
        });
    });
});
</script>


<script>
    // Esta función se ejecutará cuando se haga clic en un botón de editar
    function loadComision(idComision) {
        // Usamos la función `makeRequest` en PHP para obtener la comisión
        fetch('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comisiones?id=eq.' + idComision + '&select=*', {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer <your_api_key>', // Si es necesario, agrega tu clave de API
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())  // Convertir la respuesta en JSON
        .then(data => {
            if (data && data.length > 0) {
                const comision = data[0];  // Obtener la primera comisión (en caso de que sea un array)
                
                // Llenar los campos del formulario con los datos de la comisión
                document.getElementById('actualizar_id_comision').value = comision.id_comision;
                document.getElementById('actualizar_nombreMoneda').value = comision.nombreMoneda;
                document.getElementById('actualizar_valorComision').value = comision.valorComision;
                document.getElementById('actualizar_nombreFormato').value = comision.nombreFormato;
                document.getElementById('actualizar_inicioComision').value = comision.inicioComision;
                document.getElementById('actualizar_finComision').value = comision.finComision;
            } else {
                console.log("No se encontró la comisión con ese ID.");
            }
        })
        .catch(error => {
            console.error('Error al obtener los datos de la comisión:', error);
        });
    }

    // Función que se ejecuta cuando se hace clic en el botón de editar
    document.addEventListener("DOMContentLoaded", function() {
        const botonesEditar = document.querySelectorAll('.btn.btn-success.micono');

        botonesEditar.forEach(button => {
            button.addEventListener('click', function() {
                const idComision = this.getAttribute('data-idcomision');
                loadComision(idComision);  // Llamamos a la función para cargar los datos de la comisión
            });
        });
    });
</script>

<script src="<?php echo $ruta; ?>assets/js/updateClienteView.js"></script>
<script src="../assets/js/deleteComision.js"></script>
<script src="../assets/js/deleteProducto.js"></script>
<?php include '../componentes/settings.php'; ?>
<?php include '../componentes/footer.php'; ?>