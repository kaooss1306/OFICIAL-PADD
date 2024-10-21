<div class=" modal fade bd-example-modal-lg " id="modalAgregarCampania" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="actualizarSoporteLabel">Agregar Campaña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Alerta para mostrar el resultado de la actualización -->
        <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>

        <form id="formularioAgregarCampania">
          <div class="row">
            <!-- NombreCampania -->
            <div class="col-md-6 mb-3">
              <label class="form-label" for="NombreCampania">Nombre Campaña</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                <input type="text" class="form-control" id="NombreCampania" name="NombreCampania" placeholder="Nombre Campaña" required>
              </div>
            </div>
            <!-- Anio -->
            <div class="col-md-6 mb-3">
              <label class="form-label" for="Anio">Año</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                <select class="form-control"  id="Anio" name="Anio" placeholder="Año"  placeholder="Año" required>>
                  <?php foreach ($anioMap as $id => $anio) : ?>
                    <option value="<?php echo $id; ?>"><?php echo $anio['years']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <!-- id_Cliente -->
            <div class="col-md-6 mb-3">
              <label class="form-label" for="id_Cliente">Cliente</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <select class="form-control" name="cliente" id="id_Cliente" placeholder="Cliente" required>>
                  <?php foreach ($clientesMap as $idCliente => $cliente) : ?>
                    <option value="<?php echo $idCliente; ?>"><?php echo $cliente['nombreCliente']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
    
            </div>
            <!-- Id_Agencia -->
            <div class="col-md-6 mb-3">
              <label class="form-label" for="Id_Agencia">Agencia</label>
              <div class="input-group">
              <span class="input-group-text"><i class="bi bi-building"></i></span>
              <select class="form-control" name="Id_Agencia" id="Id_Agencia"  placeholder="Agencia" required>>
                  <?php foreach ($agenciasMap as $id => $agencia) : ?>
                    <option value="<?php echo $id; ?>"><?php echo $agencia['NombreDeFantasia']; ?></option>
                  <?php endforeach; ?>
                </select>
             
              </div>
            </div>
            <!-- id_Producto -->
            <div class="col-md-6 mb-3">
              <label class="form-label" for="id_Producto">Producto</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-box"></i></span>
                <select class="form-control" name="id_Producto" id="id_Producto"  placeholder="Producto" required>>
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
                <input type="number" class="form-control" id="Presupuesto" name="Presupuesto" placeholder="Presupuesto" required>
              </div>
            </div>
     
            <!-- Id_Planes_Publicidad -->
            <div class="col-md-6 mb-3">
              <label class="form-label" for="Id_Planes_Publicidad">ID Planes Publicidad</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-bullseye"></i></span>
                <select class="form-control" id="Planes_Publicidad" name="Planes_Publicidad" placeholder="Planes Publicidad" required>>
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
        <button type="submit" class="btn btn-primary" id="agregarCompania" onclick="guardarCompania(event)">
          Guardar Compañia
          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
        </button>
      </div>
    </div>
  </div>
</div>


<?php include_once 'querys/qcampaign.php' ?>

<script src="/assets/js/compania/agregar_compania.js"></script>

