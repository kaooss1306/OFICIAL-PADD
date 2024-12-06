<?php
// Iniciar la sesión
session_start();

// Función para hacer peticiones cURL
include 'querys/qtema.php';

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
                            <div class="titulox"><h4>Listado de Temas</h4></div>
                            <div class="agregar"><button type="button" class="btn btn-primary micono" data-bs-toggle="modal" data-bs-target="#agregartema"  ><i class="fas fa-plus-circle"></i> Agregar Tema</button>
                            </div>
                        
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tableExportadora">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre Tema</th>
                                            <th>Medio</th>
                                            <th>Duración</th>
                                            <th>Codigo Mega Time</th>
                                            <th>Calidad</th>
                                            <th>Cooperado</th>
                                            <th>Rubro</th>
                                            <th>Campaña</th>
                                            <th>Color</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($temas as $tema): ?>
                                        <tr>
                                            <td><?php echo $tema['id_tema']; ?></td>
                                            <td><?php echo $tema['NombreTema']; ?></td>
                                            <td><?php echo $mediosMap[$tema['id_medio']]['NombredelMedio'] ?? ''; ?></td>
                                            <td><?php echo $tema['Duracion']; ?></td>
                                            <td><?php echo $tema['CodigoMegatime']; ?></td>
                                            
                                            <td><?php echo $calidadsMap[$tema['id_Calidad']]['NombreCalidad'] ?? ''; ?></td>
                                            <td><?php echo $tema['cooperado']; ?></td>
                                            <td><?php echo $tema['rubro']; ?></td>
                                            <td>
                                                
                                            <?php 
                                                // Solicitud para obtener la relación entre temas y campañas
 

                                    // Variable con el id_tema actual
                                    $id_tema_actual = $tema['id_tema'];

                                    // Inicializamos la variable donde guardaremos el id_campania correspondiente
                                    $id_campania = null;

                                    // Buscamos el id_campania correspondiente al id_tema_actual
                                    foreach ($calidadsMap as $calidad) {
                                        if ($calidad['id_temas'] == $id_tema_actual) {
                                            $id_campania = $calidad['id_campania'];
                                            break; // Salimos del bucle una vez encontrado
                                        }
                                    }

                                    // Verificamos que hemos encontrado un id_campania
                                    if ($id_campania !== null) {
                                        // Hacemos la solicitud para obtener las campañas
                                        $campaigns = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Campania?select=*');
                                        
                                        // Creamos un array para mapear las campañas por id_campania
                                        $campaignsMap = [];
                                        foreach ($campaigns as $campaign) {
                                            $campaignsMap[$campaign['id_campania']] = $campaign;
                                        }

                                        // Ahora podemos obtener el NombreCampania para el id_campania encontrado
                                        if (isset($campaignsMap[$id_campania])) {
                                            $nombre_campania = $campaignsMap[$id_campania]['NombreCampania'];
                                            echo "Nombre de la campaña: " . $nombre_campania;
                                        } else {
                                            echo "No se encontró una campaña con el id_campania: " . $id_campania;
                                        }
                                    } else {
                                        echo "No existe campaña asociada.";
                                       
                                    }

                                            ?>
                                            
        </td>
                                            <td><?php echo $tema['color']; ?></td>
                                            <td>
                                            <div class="alineado">
                                            <label class="custom-switch sino" data-toggle="tooltip" 
                                            title="<?php echo $tema['estado'] ? 'Desactivar Tema' : 'Activar Tema'; ?>">
                                            <input type="checkbox" 
                                                class="custom-switch-input estado-switch2"
                                                data-id="<?php echo $tema['id_tema']; ?>" data-tipo="tema" <?php echo $tema['estado'] ? 'checked' : ''; ?>>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                            </div>
                                            </td>
                                            <td><a class="btn btn-success micono"  data-bs-toggle="modal" data-bs-target="#actualizatema" data-nombretema="<?php echo $tema['NombreTema']; ?>"  data-idtema="<?php echo $tema['id_tema']; ?>" onclick="loadTema(this)" ><i class="fas fa-pencil-alt"></i></a></td>
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


<div class="modal fade" id="actualizatema" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Alerta para mostrar el resultado de la actualización -->
                <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>

                <form id="formularioactualizarTema">
                    <!-- Campos del formulario -->
                    <div>
                        <h3 class="titulo-registro mb-3">Editar Tema</h3>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                <input type="hidden" class="form-control"  name="id_tema">
                              
                                    <label class="labelforms" for="codigo">Nombre de Tema</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre de Tema" name="NombreTema">
                                    </div>

                                   
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-primary btn-lg rounded-pill" type="submit" id="actualizarTemax">
                            <span class="btn-txt">Guardar Tema</span>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="agregartema" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Alerta para mostrar el resultado de la actualización -->
                <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>

                <form id="formularioTema">
                    <!-- Campos del formulario -->
                    <div>
                        <h3 class="titulo-registro mb-3">Agregar Tema</h3>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                <label class="labelforms" for="codigo">Nombre de Tema</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre de Tema" id="NombreTema" name="NombreTema">
                                    </div>
                                    <!-- Select de Medios -->
                                    <label class="labelforms" for="id_medio">Medios</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-bullseye"></i></span>
                                            </div>
                                            <select class="form-control" id="id_medio" name="id_medio">
                                                <?php if (!empty($mediosMap)): ?>
                                                    <?php foreach ($mediosMap as $id => $medio): ?>
                                                        <option value="<?php echo htmlspecialchars($id); ?>">
                                                            <?php echo htmlspecialchars($medio['NombredelMedio']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <option value="">No hay medios disponibles</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                              

                                    <!-- Campos Dinámicos Ocultos -->

                                    <div class="input-group" id="group-duracion" style="display:none;">
                                    <label class="labelforms" for="codigo">Duración</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Duración" id="Duracion" name="Duracion">
                                    </div>            
                                    </div>  
                                    <div class="input-group" id="group-color" style="display:none;">
                                    <label class="labelforms" for="codigo">Color</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                        </div>
                                        <input class="form-control" id="color" placeholder="Color" name="color">
                                    </div>            
                                    </div> 
                                    <div class="input-group" id="group-codigo_megatime" style="display:none;">
                                    <label class="labelforms" for="codigo">Codigo Megatime</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-broadcast"></i></span>
                                        </div>
                                        <input class="form-control" id="CodigoMegatime" placeholder="Codigo Megatime" name="CodigoMegatime">
                                    </div>            
                                    </div>   
                                    
                                    <div class="input-group " id="group-calidad" style="display:none;">
                                    <label class="labelforms" for="calidad">Calidad</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-stars"></i></span>
                                        </div>
                                        <select class="form-control" id="id_Calidad" name="id_Calidad">
                                            <?php if (!empty($calidadsMap)): ?>
                                                <?php foreach ($calidadsMap as $id => $calidad): ?>
                                                    <option value="<?php echo htmlspecialchars($id); ?>">
                                                        <?php echo htmlspecialchars($calidad['NombreCalidad']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="">No hay opciones disponibles</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>      
                                    </div>       

                                    <div class="input-group" id="group-cooperado" style="display:none;">
                                     
                                    <label class="labelforms" for="codigo">Cooperado</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                        </div>
                                        <select class="form-control" id="cooperado" name="cooperado">
                                            <option value="Sí">Sí</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>        
                                    </div>   

                                    <div class="input-group" id="group-rubro" style="display:none;">
                                    <label class="labelforms" for="codigo">Rubro</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-bullseye"></i></span>
                                        </div>
                                        <input class="form-control" id="rubro" placeholder="Rubro" name="rubro">
                                    </div>             
                                    </div>               
                        <!-- FIN Dinámicos Ocultos -->
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="d-flex justify-content-end mt-3">
                        <button id="submitButton" class="btn btn-primary btn-lg rounded-pill" type="submit">
                            <span class="btn-txt">Guardar Tema</span>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Script para Mostrar/Ocultar Campos según el Medio Seleccionado -->
<script>
        function loadTema(button) {
    // Obtener el ID del tema desde el atributo data-idproveedor del botón
    var idTema = button.getAttribute('data-idtema');
    
    // Obtener los demás datos del botón (si los tienes)
    var nombreTema = button.getAttribute('data-nombretema');
    
    // Cargar los datos en los campos del formulario del modal
    document.querySelector('#formularioactualizarTema input[name="id_tema"]').value = idTema;
    document.querySelector('#formularioactualizarTema input[name="NombreTema"]').value = nombreTema;

    // Mostrar el modal (opcional, ya que el data-bs-toggle lo maneja)
   
}
document.addEventListener('DOMContentLoaded', function() {
    // Datos de medios proporcionados por PHP
    const mediosData = <?php echo json_encode($mediosMap); ?>;
    
    // Seleccionar el elemento del formulario
    const mediosSelect = document.querySelector('select[name="id_medio"]');
    const duracionField = document.getElementById('group-duracion');
    const codigoMegatimeField = document.getElementById('group-codigo_megatime');
    const colorField = document.getElementById('group-color');
    const calidadField = document.getElementById('group-calidad');
    const cooperadoField = document.getElementById('group-cooperado');
    const rubroField = document.getElementById('group-rubro');
    // Añadir otros campos si es necesario...

    function updateFields() {
        const selectedMedioId = mediosSelect.value;
        const selectedMedio = mediosData[selectedMedioId];

        // Ocultar todos los campos primero
        duracionField.style.display = 'none';
        codigoMegatimeField.style.display = 'none';
        colorField.style.display = 'none';
        calidadField.style.display = 'none';
        cooperadoField.style.display = 'none';
        rubroField.style.display = 'none';
        // Ocultar otros campos si es necesario...

        // Mostrar solo los campos correspondientes al medio seleccionado
        if (selectedMedio) {
            if (selectedMedio.duracion) {
                duracionField.style.display = 'block';
            }
            if (selectedMedio.codigo_megatime) {
                codigoMegatimeField.style.display = 'block';
            }
            if (selectedMedio.color) {
                colorField.style.display = 'block';
            }
            if (selectedMedio.id_Calidad) {
                calidadField.style.display = 'block';
            }
            if (selectedMedio.cooperado) {
                cooperadoField.style.display = 'block';
            }
            if (selectedMedio.rubro) {
                rubroField.style.display = 'block';
            }
            // Mostrar otros campos según los valores booleanos...
        }
    }

    // Ejecutar la lógica al cargar la página
    updateFields();

    // Manejar el evento de cambio en el campo de selección
    mediosSelect.addEventListener('change', updateFields);
});
</script>
<script src="assets/js/toggleTema.js"></script>
<script src="assets/js/agregartema2.js"></script>
<?php include 'componentes/settings.php'; ?>
<?php include 'componentes/footer.php'; ?>