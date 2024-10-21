<?php
// Iniciar la sesión
session_start();

include 'querys/qcampaign.php';
include 'componentes/header.php';
include 'componentes/sidebar.php';

?>


<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>ListCampaign.php">Campañas</a></li>
                        </ol>
                    </nav>
                    <div class="card">
                        <div class="card-header milinea">
                            <div class="titulox">
                                <h4>Listado de Campañas</h4>
                            </div>
                            <div class="agregar"><a class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalAgregarCampania"><i class="fas fa-plus-circle"></i> Agregar Campañas</a></div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-center" id="tableExportadora">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente </th>
                                            <th>Nombre de camapaña</th>
                                            <th>Producto</th>
                                            <th>Año</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($campaign as $campania): ?>
                                            <tr>
                                                <td><?php echo $campania['id_campania']; ?></td>
                                                <td><?php echo $clientesMap[$campania['id_Cliente']]['nombreCliente'] ?? ''; ?></td>
                                                <td><?php echo $campania['NombreCampania']; ?></td>
                                                <td><?php echo $productosMap[$campania['id_Producto']]['NombreDelProducto'] ?? ''; ?></td>
                                                <td><?php echo $aniosMap[$campania['Anio']]['years'] ?? ''; ?></td>
                                                <td>
                                                    <div class="alineado">
                                                        <label class="custom-switch sino" data-toggle="tooltip"
                                                            title="<?php echo $campania['estado'] ? 'Desactivar Campaña' : 'Activar Campaña'; ?>">
                                                            <input type="checkbox"
                                                                class="custom-switch-input estado-switch-campania"
                                                                data-id="<?php echo $campania['id_campania']; ?>" data-tipo="campania" <?php echo $campania['estado'] ? 'checked' : ''; ?>>
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary micono" href="views/viewcampania.php?id_campania=<?php echo $campania['id_campania']; ?>" data-toggle="tooltip" title="Ver Campaña">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#modalUpdateCampania"
                                                        onclick="cargarDatosFormulario(<?php echo $campania['id_campania']; ?>);">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/toggleCampania.js"></script>
<script src="assets/js/compania/update_campania.js"></script>

<?php include 'views/modalAgregarCampania.php' ?>
<?php include 'views/modalUpdateCampania.php' ?>
<?php include 'componentes/settings.php'; ?>
<?php include 'componentes/footer.php'; ?>
