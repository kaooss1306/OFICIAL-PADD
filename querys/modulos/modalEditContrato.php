<!-- Modal para editar un contrato existente -->
<div class="modal fade" id="modalEditContrato" tabindex="-1" aria-labelledby="modalEditContratoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditContratoLabel">Editar Contrato</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form-edit-contrato">
          <input type="hidden" id="editIdContrato" name="id">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="editNombreContrato" class="form-label">Nombre del Contrato</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                <input type="text" class="form-control" id="editNombreContrato" name="NombreContrato" required>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="editIdCliente" class="form-label">Seleccione un Cliente</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <select class="form-select" id="editIdCliente" name="IdCliente" required>
                  <?php foreach ($clientesMap as $cliente): ?>
                    <option value="<?php echo $cliente['id_cliente']; ?>"><?php echo $cliente['nombreCliente']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="editIdProducto" class="form-label">Seleccione un Producto</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-box"></i></span>
                <select class="form-select" id="editIdProducto" name="idProducto" required>
                  <option value="">Seleccione un producto</option>
                </select>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="editIdProveedor" class="form-label">Seleccione un Proveedor</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-truck"></i></span>
                <select class="form-select" id="editIdProveedor" name="IdProveedor" required>
                  <?php foreach ($proveedorMap as $proveedor): ?>
                    <option value="<?php echo $proveedor['id_proveedor']; ?>"><?php echo $proveedor['nombreProveedor']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="editIdMedios" class="form-label">Seleccione un Medio</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-broadcast"></i></span>
                <select class="form-select" id="editIdMedios" name="IdMedios" required>
                  <?php foreach ($mediosMap as $medio): ?>
                    <option value="<?php echo $medio['id']; ?>"><?php echo $medio['NombredelMedio']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="editIdFormaDePago" class="form-label">Seleccione una Forma de Pago</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                <select class="form-select" id="editIdFormaDePago" name="id_FormadePago" required>
                  <?php foreach ($pagosMap as $pago): ?>
                    <option value="<?php echo $pago['id']; ?>"><?php echo $pago['NombreFormadePago']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="editFechaInicio" class="form-label">Fecha de Inicio</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-week"></i></span>
                <input type="date" class="form-control" id="editFechaInicio" name="FechaInicio" required>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="editFechaTermino" class="form-label">Fecha de Término</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-week"></i></span>
                <input type="date" class="form-control" id="editFechaTermino" name="FechaTermino" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="editIdMes" class="form-label">Mes</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-week"></i></span>
                <select class="form-select" id="editIdMes" name="id_Mes" required>
                  <?php foreach ($mesesMap as $id => $mes): ?>
                    <option value="<?php echo $id; ?>"><?php echo $mes['Nombre']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="editIdAnio" class="form-label">Año</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-week"></i></span>
                <select class="form-select" id="editIdAnio" name="id_Anio" required>
                  <?php foreach ($aniosMap as $id => $anio): ?>
                    <option value="<?php echo $id; ?>"><?php echo $anio['years']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row otros">
            <div class="col-md-4 mb-3">
              <label for="editIdTipoDePublicidad" class="form-label">Tipo de Publicidad</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                <select class="form-select" id="editIdTipoDePublicidad" name="IdTipoDePublicidad" required>
                  <?php foreach ($tipoPMap as $tipo): ?>
                    <option value="<?php echo $tipo['id_Tipo_Publicidad']; ?>"><?php echo $tipo['NombreTipoPublicidad']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="editIdFormaDePago" class="form-label">Forma de Pago</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                <select class="form-select" id="editIdFormaDePago" name="id_FormadePago" required>
                  <?php foreach ($pagosMap as $pago): ?>
                    <option value="<?php echo $pago['id']; ?>"><?php echo $pago['NombreFormadePago']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="editIdGeneracionOrdenTipo" class="form-label">Tipo de Orden</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-aspect-ratio"></i></span>
                <select class="form-select" id="editIdGeneracionOrdenTipo" name="id_GeneraracionOrdenTipo" required>
                  <?php foreach ($ordenMap as $orden): ?>
                    <option value="<?php echo $orden['id']; ?>"><?php echo $orden['NombreTipoOrden']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 mb-3">
              <label for="editObservaciones" class="form-label">Observaciones</label>
              <div class="input-group">
                <textarea class="form-control" id="editObservaciones" name="Observaciones" rows="4" cols="50" placeholder="Escribe las Observaciones..."></textarea>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="editEstado" class="form-label">Estado del Contrato</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-toggle-on"></i></span>
                <select class="form-select" id="editEstado" name="Estado" required>
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="editNumContrato" class="form-label">Número del Contrato</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-journal"></i></span>
                <input type="number" class="form-control" id="editNumContrato" name="num_contrato" >
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btn-edit-contrato">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>

<script src="assets/js/editContrato.js"></script>