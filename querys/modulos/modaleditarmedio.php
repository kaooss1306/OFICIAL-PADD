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
                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <label for="NombredelMedio">Nombre del Medio</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-caret-square-right"></i></span>
                            </div>
                            <input type="text" class="form-control" id="NombredelMedio" name="NombredelMedio">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="codigo">Código</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                            </div>
                            <input type="text" class="form-control" id="codigo" name="codigo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Id_Clasificacion">Clasificación</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-indent"></i></span>
                            </div>
                            <select class="form-control" id="Id_Clasificacion" name="Id_Clasificacion">
                                <?php foreach ($clasifiacionmedios as $clasificacion): ?>
                                    <option value="<?php echo $clasificacion['id_clasificacion_medios']; ?>">
                                        <?php echo htmlspecialchars($clasificacion['NombreClasificacion']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Checkboxes -->
                    <div class="row">
                        <div class="col">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="duracion" name="duracion">
                                <label class="form-check-label" for="duracion">Duración</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="codigo_megatime" name="codigo_megatime">
                                <label class="form-check-label" for="codigo_megatime">Código Megatime</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="color" name="color">
                                <label class="form-check-label" for="color">Color</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="calidad" name="calidad">
                                <label class="form-check-label" for="calidad">Calidad</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="cooperado" name="cooperado">
                                <label class="form-check-label" for="cooperado">Cooperado</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="rubro" name="rubro">
                                <label class="form-check-label" for="rubro">Rubro</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>