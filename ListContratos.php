<?php
// Iniciar sesión
session_start();

include "querys/qcontratos.php";
include "componentes/header.php";
include "componentes/sidebar.php";
?>
<!-- Main Content -->
<div class="main-content">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lista de Clientes y Contratos</li>
        </ol>
    </nav><br>
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header milinea">
                            <div class="titulox">
                                <h4>Listado de Clientes y Contratos</h4>
                            </div>
                            <div class="agregar">
                                <a href="#" class="btn btn-primary open-modal" data-bs-toggle="modal" data-bs-target="#modalAddContrato">
                                    <i class="fas fa-plus-circle"></i> Agregar Contrato
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php
                                // Procesar los datos para agrupar por cliente
                                $clientesUnicos = [];
                                foreach ($contratos as $contrato) {
                                    $idCliente = $contrato["IdCliente"];
                                    $nombreCliente = isset(
                                        $clientesMap[$idCliente]
                                    )
                                        ? $clientesMap[$idCliente][
                                            "nombreCliente"
                                        ]
                                        : "N/A";

                                    if (!isset($clientesUnicos[$idCliente])) {
                                        $clientesUnicos[$idCliente] = [
                                            "id" => $idCliente,
                                            "nombreCliente" => $nombreCliente,
                                            "cantidadContratos" => 1,
                                            "estado" => $contrato["Estado"],
                                        ];
                                    } else {
                                        $clientesUnicos[$idCliente][
                                            "cantidadContratos"
                                        ]++;
                                    }
                                }
                                ?>

                                <table class="table table-striped" id="tableExportadora">
                                    <thead>
                                        <tr>
                                            <th>ID Cliente</th>
                                            <th>Nombre Cliente</th>
                                            <th>Cantidad de Contratos</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (
                                            $clientesUnicos
                                            as $cliente
                                        ): ?>
                                            <tr>
                                                <td><?php echo $cliente[
                                                    "id"
                                                ]; ?></td>
                                                <td><?php echo $cliente[
                                                    "nombreCliente"
                                                ]; ?></td>
                                                <td><?php echo $cliente[
                                                    "cantidadContratos"
                                                ]; ?></td>
                                                <td>
                                                    <div class="alineado">
                                                        <label class="custom-switch sino" data-toggle="tooltip" title="<?php echo $cliente[
                                                            "estado"
                                                        ]
                                                            ? "Desactivar Cliente"
                                                            : "Activar Cliente"; ?>">
                                                            <input type="checkbox" class="custom-switch-input estado-switchC" data-id="<?php echo $cliente[
                                                                "id"
                                                            ]; ?>" data-tipo="cliente" <?php echo $cliente[
    "estado"
]
    ? "checked"
    : ""; ?>>
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary micono" href="views/viewCliente.php?id=<?php echo $cliente[
                                                        "id"
                                                    ]; ?>" data-toggle="tooltip" title="Ver Cliente">
                                                        <i class="fas fa-file-contract"></i>
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

<script src="assets/js/toggleContratos.js"></script>

<?php include "componentes/settings.php"; ?>
<?php include "querys/modulos/modalAddContrato.php"; ?>

<?php include "componentes/footer.php"; ?>
