<?php
// Iniciar la sesión
session_start();

// Incluir archivos necesarios
require_once 'querys/qordenes.php';
require_once 'componentes/header.php';
require_once 'componentes/sidebar.php';

// Asegúrate de que las variables $ordenes, $contratos, $planesMap, $proveedoresMap, $temasMap, $soportesMap, y $clasificacionesMap estén definidas en qordenes.php
?>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Listado de Ordenes de Publicidad</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tableExportadora">
                                    <thead>
                                        <tr>
                                            <th>N° Orden</th>
                                            <th>Copia</th>
                                            <th>N° Contrato</th>
                                            <th>Proveedor</th>
                                            <th>Cod Megatime</th>
                                            <th>Tema</th>
                                            <th>Soporte</th>
                                            <th>Clasificación</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ordenesPublicidad as $orden): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($orden['id_ordenes_de_comprar']); ?></td>
                                            <td>0</td>
                                            <td>
                                            <?php echo htmlspecialchars($contratosMap[$orden['num_contrato']]['num_contrato'] ?? ''); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($proveedoresMap[$orden['id_proveedor']]['nombreProveedor'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($orden['Megatime']); ?></td>
                                            <td><?php echo htmlspecialchars($temasMap[$orden['id_tema']]['NombreTema'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($soportesMap[$orden['id_soporte']]['nombreIdentficiador'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($clasificacionesMap[$orden['id_clasificacion']]['NombreClasificacion'] ?? ''); ?></td>
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
                                                    <a class="btn btn-primary micono" href="querys/modulos/orden.php?id_orden=<?php echo $orden['id_ordenes_de_comprar']; ?>" data-toggle="tooltip" title="Ver Orden">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                             <!--    <a class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#modalEditPlanPublicidad"
                                                        onclick="cargarDatosFormulario(<?php echo $orden['id_ordenes_de_comprar']; ?>);">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>Main Content -->
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

<?php 
require_once 'componentes/settings.php';
require_once 'componentes/footer.php';
?>