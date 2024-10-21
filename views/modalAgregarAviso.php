<div class="modal fade bd-example-modal-lg" id="modalAgregarAviso" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actualizarUsuario">Agregar Aviso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formularioAgregarAviso">
                    <div class="row">
                        <!-- Columna única -->
                        <div class="col-md-12 mb-3">
                        <input type="hidden" id="Usuario" name="Usuario" value="<?php echo $iduser; ?>">


                            <!-- Mensaje -->
                            <label class="form-label" for="Mensaje">Mensaje</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-chat-dots"></i></span>
                                <textarea class="form-control" id="Mensaje" name="Mensaje" cols="40" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
                            </div>

                        
                            <!-- Botón de envío -->
                            <div class="text-right-btn">
                                <button type="button" class="btn btn-primary" onclick="AgregarAviso()">Enviar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>

async function AgregarAviso() {
    try {
        // Obtener datos del formulario
        const usuario = document.getElementById("Usuario").value;
        const mensaje = document.getElementById("Mensaje").value;

        // Validar si los campos obligatorios están vacíos
        if (!usuario || !mensaje) {
            console.error("El campo usuario o mensaje está vacío");
            return; // Termina la ejecución si hay campos vacíos
        }

        let data;


            // Si no hay imagen, crear el objeto sin la URL
            data = {
                "mensaje": mensaje,
                "estado": true,
                "id_usuario": parseInt(usuario)
            };
      

        // Realizar la petición POST
        const response = await fetch('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/aviso', {
            method: 'POST',
            headers: {
                'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        // Verificar si hay contenido en la respuesta antes de analizarla como JSON
        if (response.ok) {
            await mostrarExito('Aviso agregada correctamente');
            showLoading();
            window.location.reload();
        } else {
            const errorText = await response.text();
            console.error("Error al agregar el aviso:", errorText);
        }
    } catch (error) {
        console.error("Error en la petición:", error);
    }
}

async function subirImagen(imagen) {
    const nombreArchivo = `${Date.now()}_${imagen.name}`; // Generar un nombre único
    const formData = new FormData();
    formData.append("file", imagen);

    const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/storage/v1/object/imagenes/${nombreArchivo}`, {
        method: 'POST',
        headers: {
            'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc'
        },
        body: formData
    });

    if (response.ok) {
        const urlImagen = `https://ekyjxzjwhxotpdfzcpfq.supabase.co/storage/v1/object/public/imagenes/${nombreArchivo}`;
        return urlImagen;
    } else {
        throw new Error("Error al subir la imagen");
    }
}

async function mostrarExito(mensaje) {
    return new Promise((resolve) => {
        // Asumiendo que esta función muestra un mensaje y luego resuelve la promesa
        Swal.fire({
                  title: 'Éxito!',
                text: mensaje,
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
        }).then(() => {
            resolve(); // Resuelve la promesa cuando se cierra el Swal
        });
    });
}
function showLoading() {
    let loadingElement = document.getElementById('custom-loading');
    if (!loadingElement) {
        loadingElement = document.createElement('div');
        loadingElement.id = 'custom-loading';
        loadingElement.innerHTML = `
            <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.8); display: flex; justify-content: center; align-items: center; z-index: 9999;">
                <img src="/assets/img/loading.gif" alt="Cargando..." style="width: 220px; height: 135px;">
            </div>
        `;
        document.body.appendChild(loadingElement);
    }
    loadingElement.style.display = 'block';
}


</script>

<style>
    textarea#Mensaje {
    height: 300px !important;
}
.text-right-btn {
    text-align: right;
}
</style>