<div class="modal fade bd-example-modal-lg" id="modalAgregarFactura" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Agregar Factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para agregar la factura -->
                <form id="formularioFactura">
                    <div class="row">
                        <!-- Campo id_factura (oculto) -->
                        <input type="hidden" name="idcampania" value="<?php echo $idCampania ?>">

                        <!-- Campo fecha_factura -->
                        <div class="col-md-6 mb-3">
                            <label for="fecha_factura" class="form-label">Fecha de Factura</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                <input type="date" class="form-control" id="fecha_factura" name="fecha_factura">
                            </div>
                        </div>

                        <!-- Campo RazonSocial -->
                        <div class="col-md-6 mb-3">
                            <label for="RazonSocial" class="form-label">Razón Social</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                <input type="text" class="form-control" id="RazonSocial" name="RazonSocial">
                            </div>
                        </div>

                        <!-- Campo monto -->
                        <div class="col-md-6 mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                <input type="number" class="form-control" id="monto" name="monto">
                            </div>
                        </div>

                        <!-- Campo idOrdenCompra -->
                        <div class="col-md-6 mb-3">
                            <label for="idOrdenCompra" class="form-label">ID Orden de Compra</label>
                            <select class="form-control" name="idOrdenCompra" id="idOrdenCompra" placeholder="Orden de compra" required>>
                                <?php foreach ($ordenesCompraMap as $id_ordenes_de_comprar => $oc) : ?>
                                    <option value="<?php echo $id_ordenes_de_comprar; ?>"><?php echo $oc['NombreOrden']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Campo estado -->
                        <div class="col-md-6 mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                                <select class="form-control" id="estado" name="estado">
                                    <option value="true">Activo</option>
                                    <option value="false">Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <!-- Campo TipodeFactura -->
                        <div class="col-md-6 mb-3">
                            <label for="TipodeFactura" class="form-label">Tipo de Factura</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                                <select class="form-control" id="TipodeFactura" name="TipodeFactura">
                                    <option value="Venta">Venta</option>
                                    <option value="Compra">Compra</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" onclick="agregarFactura()">
                    Agregar Factura
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
        obtenerFacturaYOrden(idCampania);
    });

    function agregarFactura() {
        const formulario = document.getElementById('formularioFactura');

        let fechaFactura = formulario.querySelector('input[name="fecha_factura"]').value;
        let RazonSocial = formulario.querySelector('input[name="RazonSocial"]').value;
        let monto = formulario.querySelector('input[name="monto"]').value;
        let idOrdenCompra = formulario.querySelector('select[name="idOrdenCompra"]').value;
        let estado = formulario.querySelector('select[name="estado"]').value;
        let TipodeFactura = formulario.querySelector('select[name="TipodeFactura"]').value;
        let IdCampania = formulario.querySelector('input[name="idcampania"]').value;

        let fechaConvertida = new Date(fechaFactura).toISOString().split('T')[0];
        const factura = {
            "fecha_factura": fechaConvertida,
            "RazonSocial": RazonSocial,
            "monto": parseInt(monto, 10),
            "idOrdenCompra": parseInt(idOrdenCompra, 10),
            "estado": estado === "true",
            "TipodeFactura": TipodeFactura,
            "IdCampania": parseInt(IdCampania, 10)
        };

        fetch('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Facturas', {
                method: 'POST',
                headers: {
                    'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                    'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                    'Content-Type': 'application/json',
                    'Prefer': 'return=minimal'
                },
                body: JSON.stringify(factura)
            })
            .then(response => {
                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Factura agregada',
                        text: 'La factura ha sido agregada con éxito',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    obtenerFacturaYOrden(IdCampania);
                    // Aquí puedes agregar código para actualizar la UI o realizar alguna acción adicional
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregarFactura'));
                    $('#formularioFactura')[0].reset();
                    $('.modal-backdrop').css('display', 'none');
                    modal.hide();
                    
                } else {
                    return response.json().then(errorData => {
                        console.error('Error al agregar la factura:', errorData);
                    });
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
            });
    }

    async function obtenerOrdenCompra(idOrdenCompra) {
        try {
            const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenDeCompra?id_orden_comprar=eq.${idOrdenCompra}&select=*`, {
                method: 'GET',
                headers: {
                    'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                    'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();
            console.log(data[0].NombreOrden)
            return data.length > 0 ? data[0].NombreOrden : 'No aplica'; // Cambia 'detalleOrden' por el campo correcto del JSON
        } catch (error) {
            console.error('Error al obtener la Orden de Compra:', error);
            return 'Error';
        }
    }

    async function obtenerFacturaYOrden(idCampania) {
        try {
            const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Facturas?IdCampania=eq.${idCampania}`, {
                method: 'GET',
                headers: {
                    'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                    'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                    'Content-Type': 'application/json'
                }
            });

            const facturas = await response.json();

            // Seleccionar el cuerpo de la tabla
            const tableBody = document.querySelector('#tableFactura tbody');
            const tableHead = document.querySelector('#tableFactura thead');

            // Limpiar contenido previo
            tableBody.innerHTML = '';
            tableHead.innerHTML = '';

            // Crear encabezados de tabla
            const headers = ['ID Orden', 'Razón Social', 'Fecha Factura', 'Detalle Orden de Compra', 'Estado', 'Tipo de Factura', 'Acciones'];
            const headRow = document.createElement('tr');
            headers.forEach(header => {
                const th = document.createElement('th');
                th.textContent = header;
                headRow.appendChild(th);
            });
            tableHead.appendChild(headRow);

            // Rellenar la tabla con los datos obtenidos
            for (const factura of facturas) {
                const row = document.createElement('tr');

                // Crear celdas con la información de cada factura
                const idFacturaCell = document.createElement('td');
                idFacturaCell.textContent = factura.id_factura || '';
                row.appendChild(idFacturaCell);

                const razonSocialCell = document.createElement('td');
                razonSocialCell.textContent = factura.RazonSocial || '';
                row.appendChild(razonSocialCell);

                const fechaFacturaCell = document.createElement('td');
                fechaFacturaCell.textContent = factura.fecha_factura || '';
                row.appendChild(fechaFacturaCell);

                // Obtener y agregar el detalle de la orden de compra
                const ordenResponse = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenDeCompra?id_orden_compra=eq.${factura.idOrdenCompra}&select=*`, {
                    method: 'GET',
                    headers: {
                        'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                        'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                        'Content-Type': 'application/json'
                    }
                });

                const ordenes = await ordenResponse.json();

                const detalleOrdenCompraCell = document.createElement('td');
                detalleOrdenCompraCell.textContent = ordenes.length > 0 ? ordenes[0].NombreOrden : 'No aplica'; // Ajusta el campo según tu JSON
                row.appendChild(detalleOrdenCompraCell);

                // Agregar el estado de la factura
                const idEstadoCell = document.createElement('td');
                idEstadoCell.textContent = factura.estado ? 'Activo' : 'Inactivo';
                row.appendChild(idEstadoCell);

                // Agregar el tipo de factura
                const TipodeFacturaCell = document.createElement('td');
                TipodeFacturaCell.textContent = factura.TipodeFactura || '';
                row.appendChild(TipodeFacturaCell);

                // Create the cell for the update button
                const updateButtonCell = document.createElement('td');
                const updateButton = document.createElement('a');
                updateButton.className = 'btn btn-success micono';
                updateButton.setAttribute('data-bs-toggle', 'modal');
                updateButton.setAttribute('data-bs-target', '#modalActualizarFactura');
                updateButton.setAttribute('onclick', `cargarDatosFormulario(${factura.id_factura});`);

                // Add the icon inside the button
                const icon = document.createElement('i');
                icon.className = 'fas fa-pencil-alt';
                updateButton.appendChild(icon);

                // Append the button to the cell
                updateButtonCell.appendChild(updateButton);

                // Append the button cell to the row
                row.appendChild(updateButtonCell);

                tableBody.appendChild(row);
            }
        } catch (error) {
            console.error('Error al obtener las facturas y órdenes de compra:', error);
        }
    }
</script>