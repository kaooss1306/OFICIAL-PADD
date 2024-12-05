<?php
// Iniciar la sesión
session_start();
include '../querys/qcampaign.php';
// Obtener el ID del cliente de la URL
$idCampania = isset($_GET['id_campania']) ? $_GET['id_campania'] : null;



$url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Campania?id_campania=eq.$idCampania&select=*";
$campania = makeRequest($url);




$datosCampania = $campania[0];



//obtener solo id segun tema

$temasAgregados = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/campania_temas?id_campania=eq.$idCampania&select=id_temas");

$temasAgregadosIds = array_column($temasAgregados, 'id_temas');

// Filtrar los temas que ya están agregados
$temasDisponibles = array_filter($temasMap, function ($tema) use ($temasAgregadosIds) {
    return !in_array($tema['id_tema'], $temasAgregadosIds);
});



include '../componentes/header.php';
include '../componentes/sidebar.php';
?>
<!-- Main Content -->
<div class="main-content">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>ListCampaign.php">Ver Campañas</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $datosCampania['NombreCampania']; ?></li>
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
                                    Nombre campaña
                                </div>
                                <div class="nombrex author-box-name">

                                    <?php echo $datosCampania['NombreCampania']; ?>
                                </div>
                                <div class="author-box-job">
                                    Fecha Creación
                                </div>
                                <div class="nombrex author-box-name">

                                    <?php echo $datosCampania['fechaCreacion']; ?>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card">
                    <div class="card-header">
                            <div class="cabeza">
                            <h4>Detalles de la Campaña</h4> 
                            <a class="btn btn-danger micono"  data-bs-toggle="modal" data-bs-target="#modalUpdateCampania"
                                                        onclick="cargarDatosFormulario(<?php echo $datosCampania['id_campania']; ?>);">
                                                        <i class="fas fa-pencil-alt"></i> Editar datos
                                                    </a>
                                                    
                            </div>
                        </div>
                     
                        <div class="card-body">
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-start">
                                        Nombre Cliente
                                    </span>
                                    <span class="float-right text-muted">

                                        <?php
                                        $cliente = $clientesMap[$datosCampania['id_Cliente'] ?? '']['nombreCliente'];
                                        echo $cliente
                                        ?>

                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-start">
                                        Producto
                                    </span>
                                    <span class="float-right text-muted">

                                        <?php
                                        $producto = $productosMap[$datosCampania['id_Producto'] ?? '']['NombreDelProducto'];
                                        echo $producto;
                                        ?>

                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-start">
                                        Estado
                                    </span>
                                    <span class="float-right text-muted">
                                        <?php $estado = $datosCampania['estado'];

                                        if ($estado == 0) {
                                            echo 'Inactivo';
                                        } else {
                                            echo 'Activo';
                                        }
                                        ?>
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-start">
                                        Presupuesto
                                    </span>
                                    <span class="float-right text-muted">
                                        <?php echo $datosCampania['Presupuesto']; ?>
                                    </span>
                                </p>
                             
                         

                                <p class="clearfix">
                                    <span class="float-start">
                                        Año
                                    </span>
                                    <span class="float-right text-muted">

                                        <?php
                                        $years = $anioMap[$datosCampania['Anio'] ?? '']['years'];
                                        echo $years
                                        ?>

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
                                    <a class="nav-link active" id="temastab" data-bs-toggle="tab" href="#temas" role="tab" aria-selected="true">Temas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="odctab" data-bs-toggle="tab" href="#odc" role="tab" aria-selected="true">Orden de compra</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="facturatab" data-bs-toggle="tab" href="#factura" role="tab" aria-selected="true">Factura</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="temas" role="tabpanel" aria-labelledby="temastab">
                                    <div class="row">
                                        <div class="col-md-12 col-12">

                                            <div class="card">
                                                <div class="card-header milinea">
                                                    <div class="titulox">
                                                        <h4>Listado de temas</h4>
                                                    </div>
                                                    <div class="agregar">
                                                    <a type="button" class="btn btn-primary micono" data-bs-toggle="modal" data-bs-target="#modalAgregarTema" data-id-campania="<?php echo $datosCampania['id_campania']; ?>">
                                                        <i class="fas fa-plus-circle"></i> Agregar Temas
                                                    </a>

                                                    </div>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-striped text-center" id="table1">
                                                        <thead>

                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="odc" role="tabpanel" aria-labelledby="odctab">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="row">
                                                <div class="col-md-12 col-12">

                                                    <div class="card">
                                                        <div class="card-header milinea">
                                                            <div class="titulox">
                                                                <h4>Listado de OC</h4>
                                                            </div>
                                                            <div class="agregar">
                                                                <a type="button" class="btn btn-primary micono" data-bs-toggle="modal" data-bs-target="#modalAgregarOC"><i class="fas fa-plus-circle"></i> Agregar OC</a>
                                                            </div>
                                                        </div>

                                                        <div class="table-responsive">
                                                            <table class="table table-striped text-center" id="tableOC">
                                                                <thead>

                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="factura" role="tabpanel" aria-labelledby="facturatab">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                        <div class="row">
                                                <div class="col-md-12 col-12">

                                                    <div class="card">
                                                        <div class="card-header milinea">
                                                            <div class="titulox">
                                                                <h4>Listado de factura</h4>
                                                            </div>
                                                            <div class="agregar">
                                                                <a type="button" class="btn btn-primary micono" data-bs-toggle="modal" data-bs-target="#modalAgregarFactura"><i class="fas fa-plus-circle"></i> Agregar factura</a>
                                                            </div>
                                                        </div>

                                                        <div class="table-responsive">
                                                            <table class="table table-striped text-center" id="tableFactura">
                                                                <thead>

                                                                </thead>
                                                                <tbody>

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
                            <span class="selectgroup-button selectgroup-button-icon" data-bs-toggle="tooltip" data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                            <span class="selectgroup-button selectgroup-button-icon" data-bs-toggle="tooltip" data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
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
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="mini_sidebar_setting">
                            <span class="custom-switch-indicator"></span>
                            <span class="control-label p-l-10">Mini Sidebar</span>
                        </label>
                    </div>
                </div>
                <div class="p-15 border-bottom">
                    <div class="theme-setting-options">
                        <label class="m-b-0">
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="sticky_header_setting">
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
<script src="../assets/js/toggleTema.js"></script>

<?php include './modalUpdateCampania.php' ?>
<?php include './modalUpdateFactura.php'; ?>
<?php include './modalAgregarFacturaCampania.php'; ?>
<?php include './modalAgregarOC.php'; ?>
<?php include './modalAgregarTemasCampania.php'; ?>
<script src="../assets/js/compania/update_campania.js"></script>
<?php include '../componentes/settings.php'; ?>
<?php include '../componentes/footer.php'; ?>
