<div class="modal fade bd-example-modal-lg" id="modalAgregarOC" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Agregar oc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario OC-->
                <form id="formularioOC">
                    <div class="row">
                    <input type="hidden" name="idcampania" value="<?php echo $idCampania ?>">
                        <!-- Campo NombreOrden -->
                        <div class="col-md-6 mb-3">
                            <label for="NombreOrden" class="form-label">Nombre Orden</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-file-text"></i></span>
                                <input type="text" class="form-control" id="NombreOrden" name="NombreOrden">
                            </div>
                        </div>
                        <!-- Campo Codigo -->
                        <div class="col-md-6 mb-3">
                            <label for="Codigo" class="form-label">Código</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-code-square"></i></span>
                                <input type="text" class="form-control" id="numero_orden" name="codigo">
                            </div>
                        </div>
                        <!-- Campo fechaOrden -->
                        <div class="col-md-6 mb-3">
                            <label for="fechaOrden" class="form-label">Fecha de Orden</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                <input type="date" class="form-control" id="fechaOrden" name="fechaOrden">
                            </div>
                        </div>
                        <!-- Campo monto -->
                        <div class="col-md-6 mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                <input type="text" class="form-control" id="monto" name="monto">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" onclick="agregarOC()">
                    Agregar OC
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function() {
        // Obtener el ID de la campaña (asumiendo que está disponible en PHP)
        const idCampania = <?php echo json_encode($idCampania); ?>;

        // Cargar los temas de la campaña al cargar la página
        obtenerOrdenCompra(idCampania);
    });
   function agregarOC() {
    const formulario = document.getElementById('formularioOC');

    let NombreOrden = formulario.querySelector('input[name="NombreOrden"]').value;
    let Codigo = formulario.querySelector('input[name="codigo"]').value;
    let FechaOrden = formulario.querySelector('input[name="fechaOrden"]').value;
    let Monto = formulario.querySelector('input[name="monto"]').value;
    let idCampania = parseInt(formulario.querySelector('input[name="idcampania"]').value, 10);

    let fechaConvertida = new Date(FechaOrden).toISOString().split('T')[0];
    const mapping = {
        "NombreOrden": NombreOrden,
        "Codigo": Codigo,
        "fechaOrden": fechaConvertida,
        "monto": Monto,
        "id_campania": idCampania
    };


    fetch('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenDeCompra', {
        method: 'POST',
        headers: {
            'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            'Content-Type': 'application/json',
            'Prefer': 'return=minimal'
        },
        body: JSON.stringify(mapping)
    })
    .then(response => {
        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: 'Agregado exitosamente',
                text: 'Orden de Compra agregada con éxito',
                showConfirmButton: false,
                timer: 1500
            });
            obtenerOrdenCompra(idCampania);
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregarOC'));
            modal.hide();
            // Aquí puedes agregar código para actualizar la UI o realizar alguna acción adicional
        } else {
            return response.json().then(errorData => {
                console.error('Error al agregar la Orden de Compra:', errorData);
            });
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
    });
}

function obtenerOrdenCompra(idCampania) {
    fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenDeCompra?id_campania=eq.${idCampania}`, {
        method: 'GET',
        headers: {
            'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Seleccionar el cuerpo de la tabla
        const tableBody = document.querySelector('#tableOC tbody');
const tableHead = document.querySelector('#tableOC thead');

// Limpiar contenido previo
tableBody.innerHTML = '';
tableHead.innerHTML = '';

// Crear encabezados de tabla
const headers = ['Nombre Orden', 'Fecha Orden', 'Monto', 'Estado'];
const headRow = document.createElement('tr');
headers.forEach(header => {
    const th = document.createElement('th');
    th.textContent = header;
    headRow.appendChild(th);
});
tableHead.appendChild(headRow);

// Rellenar la tabla con los datos obtenidos
data.forEach(orden => {
    const row = document.createElement('tr');

    // Crear celdas con la información de cada orden
    const nombreCell = document.createElement('td');
    nombreCell.textContent = orden.NombreOrden || '';
    row.appendChild(nombreCell);

    const fechaCell = document.createElement('td');
    fechaCell.textContent = orden.fechaOrden || '';
    row.appendChild(fechaCell);

    const montoCell = document.createElement('td');
    montoCell.textContent = orden.monto || '';
    row.appendChild(montoCell);

    // Crear la celda de estado con el switch
    const estadoCell = document.createElement('td');
    const estadoSwitch = document.createElement('div');
    estadoSwitch.classList.add('alineado');

    const label = document.createElement('label');
    label.classList.add('custom-switch', 'sino');
    label.setAttribute('data-toggle', 'tooltip');
    label.setAttribute('title', orden.estado ? 'Desactivar Orden' : 'Activar Orden');

    const input = document.createElement('input');
    input.type = 'checkbox';
    input.classList.add('custom-switch-input', 'estado-switch3');
    input.setAttribute('data-id', orden.id_orden_compra);
    input.setAttribute('data-tipo', 'orden');
    if (orden.estado) {
        input.setAttribute('checked', 'checked');
    }

    const span = document.createElement('span');
    span.classList.add('custom-switch-indicator');

    label.appendChild(input);
    label.appendChild(span);
    estadoSwitch.appendChild(label);
    estadoCell.appendChild(estadoSwitch);
    row.appendChild(estadoCell);

    // Añadir la fila a la tabla
    tableBody.appendChild(row);
});
    })
    .catch(error => {
        console.error('Error al obtener la Orden de Compra:', error);
    });
}



</script>
