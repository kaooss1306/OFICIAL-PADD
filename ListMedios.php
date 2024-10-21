<?php
// Iniciar la sesión
session_start();

// Función para hacer peticiones cURL
include 'querys/qmedios.php';
// Obtener el ID del cliente de la URL
$idMedio = isset($_GET['id']) ? $_GET['id'] : null;
include 'componentes/header.php';
include 'componentes/sidebar.php';
?>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header milinea">
                            <div class="titulox"><h4>Listado de Medios</h4></div>
                            <div class="agregar">
                              <a href="#" 
       class="btn btn-primary open-modal" 
       data-bs-toggle="modal" 
       data-bs-target="#modalAdd">
        <i class="fas fa-plus-circle"></i> Agregar Medio
    </a></div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tableExportadora">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre del Medio</th>
                                            <th>Código</th>
                                            <th>Clasificación</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($medios as $medio): ?>
                                        <tr>
                                            <td><?php echo $medio['id']; ?></td>
                                            <td><?php echo $medio['NombredelMedio']; ?></td>
                                            <td><?php echo $medio['codigo']; ?></td>
                                            <td><?php echo $clasifiacionmediosMap[$medio['Id_Clasificacion']]['NombreClasificacion'] ?? ''; ?></td>
                                            <td>
                                            <div class="alineado">
       <label class="custom-switch sino" data-toggle="tooltip" 
       title="<?php echo $medio['Estado'] ? 'Desactivar Medio' : 'Activar Medio'; ?>">
    <input type="checkbox" 
           class="custom-switch-input estado-switchM"
           data-id="<?php echo $medio['id']; ?>" data-tipo="medio" <?php echo $medio['Estado'] ? 'checked' : ''; ?>> <span class="custom-switch-indicator"></span>
</label>
    </div>
                                            </td>
                                            <td><a href="views/viewMedio.php?id=<?php echo $medio['id']; ?>" data-toggle="tooltip" title="Ver Medio"><i class="fas fa-eye btn btn-primary miconoz"></i></a> 
                                            <a href="#" onclick="loadMedio(this)" data-idmedio="<?php echo $medio['id']; ?>"
   class="btn6 open-modal" 
   data-bs-toggle="modal" 
   data-bs-target="#exampleModal" 
   data-toggle="tooltip" 
   title="Editar Medio">
    <i class="fas fa-pencil-alt btn btn-success miconoz"></i></a>
                                            
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

<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">AGREGAR MEDIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Alerta para mostrar el resultado de la actualización -->
                <div id="updateAlert2" class="alert" style="display:none;" role="alert"></div>
                
                <form id="addMedioForm">
                    <!-- Campos existentes -->
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
                    
                    <!-- Nuevos campos booleanos como checkboxes -->
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
                  
                   
                    
                    <button type="submit" class="btn btn-primary">Agregar Medio</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal HTML -->
<!-- Modal HTML -->
<!-- Modal HTML -->
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
                            <input type="text" class="form-control" id="NombredelMedio2" name="NombredelMedio2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="codigo2">Código</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                            </div>
                            <input type="text" class="form-control" id="codigo2" name="codigo2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Id_Clasificacion2">Clasificación</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-indent"></i></span>
                            </div>
                            <select class="form-control" id="Id_Clasificacion2" name="Id_Clasificacion2">
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
                                <input type="checkbox" class="form-check-input" id="duracion2" name="duracion2">
                                <label class="form-check-label" for="duracion2">Duración</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="codigo_megatime2" name="codigo_megatime2">
                                <label class="form-check-label" for="codigo_megatime2">Código Megatime</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="color2" name="color2">
                                <label class="form-check-label" for="color2">Color</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="calidad2" name="calidad2">
                                <label class="form-check-label" for="calidad2">Calidad</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="cooperado2" name="cooperado2">
                                <label class="form-check-label" for="cooperado2">Cooperado</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="rubro2" name="rubro2">
                                <label class="form-check-label" for="rubro2">Rubro</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>


//modal de add Medio






//fin modal

<script>
function loadMedio(button) {
    // Obtener el ID del medio desde el atributo data-id del botón
    var idMedio = button.getAttribute('data-idmedio');
    
    // Obtener los datos del medio desde el endpoint
    fetch('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Medios?id=eq.' + idMedio, {
        headers: {
            'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.length > 0) {
            var medio = data[0];

            // Llenar los campos del formulario del modal
            document.querySelector('#updateMedioForm input[name="id"]').value = medio.id;
            document.querySelector('#updateMedioForm input[name="NombredelMedio2"]').value = medio.NombredelMedio;
            document.querySelector('#updateMedioForm input[name="codigo2"]').value = medio.codigo;
            document.querySelector('#updateMedioForm select[name="Id_Clasificacion2"]').value = medio.Id_Clasificacion;

            // Configurar checkboxes
            document.querySelector('#updateMedioForm input[name="duracion2"]').checked = medio.duracion;
            document.querySelector('#updateMedioForm input[name="codigo_megatime2"]').checked = medio.codigo_megatime;
            document.querySelector('#updateMedioForm input[name="color2"]').checked = medio.color;
            document.querySelector('#updateMedioForm input[name="calidad2"]').checked = medio.calidad;
            document.querySelector('#updateMedioForm input[name="cooperado2"]').checked = medio.cooperado;
            document.querySelector('#updateMedioForm input[name="rubro2"]').checked = medio.rubro;

            // Mostrar el modal
            $('#exampleModal').modal('show');
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>


<?php include 'componentes/settings.php'; ?>
<script src="assets/js/toggleMedios.js"></script>
<script src="../../../assets/js/updateMedio.js"></script>
<script src="../../../assets/js/addMedio.js"></script>





<?php include 'componentes/footer.php'; ?>