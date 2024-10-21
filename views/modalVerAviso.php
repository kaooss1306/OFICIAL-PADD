<div class="modal fade bd-example-modal-lg" id="modalVerAviso" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="VerAviso">MENSAJE</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formularioVerAviso">
                    <div class="row">
                        <!-- Columna única -->
                        <div class="col-md-12 mb-3">
                         <!-- Mensaje -->
                            <label class="form-label" for="MensajeVer">Contenido</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-chat-dots"></i></span>
                                <!-- Reemplazo del textarea por un div -->
                                <div class="form-control" id="MensajeVer" name="MensajeVer" style="background-color: #f8f9fa; border: 1px solid #ced4da; min-height: 100px;"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>

async function cargarMensaje(id) {
    // Hacemos una solicitud al backend para obtener los datos del aviso por su ID
    const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/aviso?id=eq.${id}&select=*`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            'Prefer': 'return=minimal'
        }
    });

    if (!response.ok) {
        throw new Error(`Error al obtener el aviso: ${response.status}`);
    }

    const aviso = await response.json();

    if (aviso.length === 0) {
        console.error('No se encontró el aviso');
        return;
    }

    // Mostrar el mensaje en el div
    document.getElementById('MensajeVer').innerText = aviso[0].mensaje;

    // Mostrar la imagen si existe
    const imagenUrl = aviso[0].imagen;
    const imgPreview = document.getElementById('ImagenVerPreview');
    const sinImagenTexto = document.getElementById('sinImagenTexto');

    if (imagenUrl && imagenUrl.trim() !== "") {
        imgPreview.src = imagenUrl; // Asignar la URL de la imagen
        imgPreview.style.display = 'block'; // Mostrar la imagen
        sinImagenTexto.style.display = 'none'; // Ocultar el mensaje de "sin imagen"
    } else {
        imgPreview.style.display = 'none'; // Ocultar la imagen si no existe
        sinImagenTexto.style.display = 'block'; // Mostrar el mensaje de "sin imagen"
    }
}


</script>
