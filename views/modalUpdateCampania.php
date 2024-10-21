<div class="modal fade bd-example-modal-lg" id="modalUpdateCampania" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actualizarSoporteLabel">Actualizar Campaña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para actualizar la campaña -->
                <form id="formularioUpdateCampania">
                    <!-- Campo oculto para almacenar el ID de la campaña -->
                    <input type="hidden" id="campaniaId" name="campaniaId">

                    <!-- Nombre Campania -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="NombreCampania">Nombre Campaña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                <input type="text" class="form-control" id="NombreCampaniaUpdate" name="NombreCampaniaUpdate" placeholder="Nombre Campaña" required>
                            </div>
                        </div>
                        <!-- Año -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Anio">Año</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                <select class="form-control" id="AnioUpdate" name="AnioUpdate" required>
                                    <?php foreach ($anioMap as $id => $anio) : ?>
                                        <option value="<?php echo $id; ?>"><?php echo $anio['years']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- Cliente -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="id_Cliente">Cliente</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <select class="form-control" name="id_ClienteUpdate" id="id_ClienteUpdate" required>
                                    <?php foreach ($clientesMap as $idCliente => $cliente) : ?>
                                        <option value="<?php echo $idCliente; ?>"><?php echo $cliente['nombreCliente']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- Agencia -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Id_Agencia">Agencia</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                <select class="form-control" name="Id_AgenciaUpdate" id="Id_AgenciaUpdate" required>
                                    <?php foreach ($agenciasMap as $id => $agencia) : ?>
                                        <option value="<?php echo $id; ?>"><?php echo $agencia['NombreDeFantasia']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- Producto -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="id_Producto">Producto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-box"></i></span>
                                <select class="form-control" name="id_ProductoUpdate" id="id_ProductoUpdate" required>
                                    <?php foreach ($productosMap as $id => $producto) : ?>
                                        <option value="<?php echo $id; ?>"><?php echo $producto['NombreDelProducto']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- Presupuesto -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Presupuesto">Presupuesto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-cash"></i></span>
                                <input type="number" class="form-control" id="PresupuestoUpdate" name="PresupuestoUpdate" placeholder="Presupuesto" required>
                            </div>
                        </div>
                 
                        <!-- Planes Publicidad -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Planes_Publicidad">Planes Publicidad</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-bullseye"></i></span>
                                <select class="form-control" id="Planes_PublicidadUpdate" name="Planes_PublicidadUpdate" required>
                                    <?php foreach ($planesMap as $id => $plan) : ?>
                                        <option value="<?php echo $id; ?>"><?php echo $plan['NombrePlan']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" onclick="actualizarCompania()">
                    Actualizar Compañía
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/compania/update_campania.js"></script>