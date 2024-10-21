<div class="modal fade" id="modalAgregarTema" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
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
                                <input type="hidden"  id="inputIdCampania" name="id_campania" value="">
                                    <!-- Select de Medios -->
                                    <label class="labelforms" for="id_medio">Medios</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-bullseye"></i></span>
                                            </div>
                                            <select class="form-control" name="id_medio">
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
                                    <label class="labelforms" for="codigo">Nombre de Tema</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre de Tema" name="NombreTema">
                                    </div>

                                    <!-- Campos Dinámicos Ocultos -->

                                    <div class="input-group" id="group-duracion" style="display:none;">
                                    <label class="labelforms" for="codigo">Duración</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Duración" name="Duracion">
                                    </div>            
                                    </div>  
                                    <div class="input-group" id="group-color" style="display:none;">
                                    <label class="labelforms" for="codigo">Color</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Color" name="color">
                                    </div>            
                                    </div> 
                                    <div class="input-group" id="group-codigo_megatime" style="display:none;">
                                    <label class="labelforms" for="codigo">Codigo Megatime</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-broadcast"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Codigo Megatime" name="CodigoMegatime">
                                    </div>            
                                    </div>   
                                    
                                    <div class="input-group" id="group-calidad" style="display:none;">
                                    <label class="labelforms" for="calidad">Calidad</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-stars"></i></span>
                                        </div>
                                        <select class="form-control" name="id_Calidad">
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
                                        <select class="form-control" name="cooperado">
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
                                        <input class="form-control" placeholder="Rubro" name="rubro">
                                    </div>             
                                    </div>               
                        <!-- FIN Dinámicos Ocultos -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-primary btn-lg rounded-pill" type="submit" id="agregarTemax">
                            <span class="btn-txt">Guardar Tema</span>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
   
    // Definir variables globales
    const API_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc";
    const BASE_URL = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1";

    document.addEventListener('DOMContentLoaded', function() {
        // Obtener el ID de la campaña (asumiendo que está disponible en PHP)
        const idCampania = <?php echo json_encode($idCampania); ?>;
        document.getElementById('inputIdCampania').value = idCampania;
        // Cargar los temas de la campaña al cargar la página
        cargarTemasPorCampania(idCampania);
    });

    

    function cargarTemasPorCampania(idCampania) {
        const authHeader = {
            "apikey": API_KEY,
            "Authorization": `Bearer ${API_KEY}`,
            "Content-Type": "application/json"
        };

        // 1. Obtener los IDs de los temas desde la tabla intermedia filtrados por id_campania
        fetch(`${BASE_URL}/campania_temas?id_campania=eq.${idCampania}&select=*`, {
            method: 'GET',
            headers: authHeader
        })
        .then(response => response.json())
        .then(campaniaTemas => {
            // Extraer los IDs de los temas
            const temaIds = campaniaTemas.map(item => item.id_temas);

            // 2. Obtener la información de los temas usando los IDs obtenidos
            const temasPromises = temaIds.map(id => {
                return fetch(`${BASE_URL}/Temas?id_tema=eq.${id}&select=*`, {
                    method: 'GET',
                    headers: authHeader
                })
                .then(response => response.json());
            });

            // Esperar a que se resuelvan todas las promesas
            return Promise.all(temasPromises);
        })
        .then(temas => {
            // 3. Llamar a la función para rellenar la tabla con la información de los temas
            rellenarTabla(temas);
        })
        .catch(error => {
            console.error('Error al obtener los temas:', error);
        });
    }

    async function obtenerNombreMedio(idMedio) {
    try {
        const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Medios?id=eq.${idMedio}&select=*`, {
            headers: {
                'apikey': API_KEY,
                'Authorization': `Bearer ${API_KEY}`,
                'Range': '0-9'
            }
        });

        const data = await response.json();
        return data.length > 0 ? data[0].NombredelMedio : 'No aplica'; // Cambia 'nombre_medio' por el campo correcto del JSON
    } catch (error) {
        console.error('Error al obtener el nombre del medio:', error);
        return 'Error';
    }
}

async function rellenarTabla(temas) {
    const tableHead = document.querySelector('#table1 thead');
    const tableBody = document.querySelector('#table1 tbody');

    // Limpiar el contenido previo de la tabla
    tableHead.innerHTML = '';
    tableBody.innerHTML = '';

    // Crear el encabezado de la tabla
    const headerRow = document.createElement('tr');
    const headers = ['ID', 'Nombre Tema', 'Código Megatime', 'Duración', 'Cooperado', 'Rubro', 'Nombre Medio', 'Estado'];
    headers.forEach(headerText => {
        const th = document.createElement('th');
        th.textContent = headerText;
        headerRow.appendChild(th);
    });
    tableHead.appendChild(headerRow);

    // Crear las filas de la tabla con los datos de los temas
    for (const temaArray of temas) {
        const tema = temaArray[0]; // temaArray contiene un array con un solo objeto
        const row = document.createElement('tr');

        const idCell = document.createElement('td');
        idCell.textContent = tema.id_tema;
        row.appendChild(idCell);

        const nombreCell = document.createElement('td');
        nombreCell.textContent = tema.NombreTema;
        row.appendChild(nombreCell);

        const CodigoMegatimeCell = document.createElement('td');
        CodigoMegatimeCell.textContent = tema.CodigoMegatime || 'No aplica';
        row.appendChild(CodigoMegatimeCell);

        const duracionCell = document.createElement('td');
        duracionCell.textContent = tema.Duracion || 'No aplica';
        row.appendChild(duracionCell);

        const cooperadoCell = document.createElement('td');
        cooperadoCell.textContent = tema.cooperado || 'No aplica';
        row.appendChild(cooperadoCell);

        const rubroCell = document.createElement('td');
        rubroCell.textContent = tema.rubro || 'No aplica';
        row.appendChild(rubroCell);

        const medioCell = document.createElement('td');
        const nombreMedio = await obtenerNombreMedio(tema.id_medio);
        medioCell.textContent = nombreMedio;
        row.appendChild(medioCell);

        // Crear la celda de estado con el switch
        const estadoCell = document.createElement('td');
        const estadoSwitch = document.createElement('div');
        estadoSwitch.classList.add('alineado');

        const label = document.createElement('label');
        label.classList.add('custom-switch', 'sino');
        label.setAttribute('data-toggle', 'tooltip');
        label.setAttribute('title', tema.estado ? 'Desactivar Tema' : 'Activar Tema');

        const input = document.createElement('input');
        input.type = 'checkbox';
        input.classList.add('custom-switch-input', 'estado-switch2');
        input.setAttribute('data-id', tema.id_tema);
        input.setAttribute('data-tipo', 'tema');
        if (tema.estado) {
            input.setAttribute('checked', 'checked');
        }

        const span = document.createElement('span');
        span.classList.add('custom-switch-indicator');

        label.appendChild(input);
        label.appendChild(span);
        estadoSwitch.appendChild(label);
        estadoCell.appendChild(estadoSwitch);
        row.appendChild(estadoCell);

        tableBody.appendChild(row);
    }
}

</script>
<script src="../assets/js/toggleOrden.js"></script>
<script src="../assets/js/toggleTema2.js"></script>
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
<script src="../assets/js/agregarTema.js"></script>