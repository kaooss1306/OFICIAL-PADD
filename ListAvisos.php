<?php
// Iniciar la sesión
session_start();

include 'querys/qaviso.php';
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
                            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>ListAvisos.php">Avisos</a></li>
                        </ol>
                    </nav>
                    <div class="card">
                        <div class="card-header milinea">
                            <div class="titulox">
                                <h4>Listado de Mensajes</h4>
                            </div>
                            <div class="agregar"><a class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalAgregarAviso"><i class="fas fa-plus-circle"></i> Agregar Mensaje</a></div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-center" id="tableExportadora">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha de Creación</th>
                                            <th>Mensaje</th>
                                            <th>Usuario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($aviso as $avisos): ?>
                                            <tr>
                                                <td><?php echo $avisos['id']; ?></td>
                                               <td>
    <?php
    $fecha = new DateTime($avisos['created_at']);
    $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
    $formatoFecha = $fecha->format('d') . ' de ' . $meses[$fecha->format('n') - 1] . ' de ' . $fecha->format('Y') . ' a las ' . $fecha->format('H:i');
    echo $formatoFecha;
    ?>
</td>
                                                <td><?php echo $avisos['mensaje']; ?></td>
                                                <td><?php echo $usuarioMap[$avisos['id_usuario']]['Nombres'] ?? ''; ?></td>
                                                <td> <a class="btn btn-primary micono" data-bs-toggle="modal" data-bs-target="#modalVerAviso"
                                                        onclick="cargarMensaje(<?php echo $avisos['id']; ?>);">
                                                        <i class="fas fa-eye"></i> Ver Mensaje
                                                    </a></td>
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


<?php include 'views/modalAgregarAviso.php'; ?>
<?php include 'views/modalVerAviso.php'; ?>
<?php include 'componentes/settings.php'; ?>
<?php include 'componentes/footer.php'; ?>
