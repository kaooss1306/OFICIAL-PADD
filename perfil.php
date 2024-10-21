<?php
// Iniciar la sesión
session_start();
include 'componentes/header.php';
include 'componentes/sidebar.php';
?>

<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    <div class="row mt-sm-4">
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="card author-box">
                                <div class="card-body">
                                    <div class="author-box-center">
                                        <img id="imagen-perfil" class="rounded-circle author-box-picture">
                                        <div class="clearfix"></div>
                                        <div class="author-box-name">
                                            <a href="#" id="nombre_completo"></a>
                                        </div>
                                      
                                        <p class="text-muted" id="correo"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-8">
                            <div class="card">
                                <div class="padding-20">
                                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab2" data-bs-toggle="tab" href="#clave" role="tab" aria-selected="true">Cambiar Contraseña</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="home-tab2" data-bs-toggle="tab" href="#foto" role="tab" aria-selected="false">Actualizar foto de Perfil</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content tab-bordered" id="myTab3Content">
                                        <div class="tab-pane fade show active" id="clave" role="tabpanel" aria-labelledby="home-tab2">
                                            <form id="change-password-form">
                                                <div class="form-group">
                                                    <label for="current-password">Contraseña Actual</label>
                                                    <div class="input-group">
                                                        <input type="password" id="current-password" class="form-control" readonly required>
                                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('current-password')">👁️</button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="new-password">Nueva Contraseña</label>
                                                    <div class="input-group">
                                                        <input type="password" id="new-password" class="form-control" required>
                                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('new-password')">👁️</button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirm-password">Confirmar Nueva Contraseña</label>
                                                    <div class="input-group">
                                                        <input type="password" id="confirm-password" class="form-control" required>
                                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirm-password')">👁️</button>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="foto" role="tabpanel" aria-labelledby="home-tab2">
                                            <form id="upload-avatar-form" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <input type="file" id="imagen-input" accept="image/*" class="form-control" required>
                                                </div>
                                                <!-- Avatar actual -->
                                                <div class="text-center mb-3">
                                                    <img id="avatar-actual" src="" alt="Avatar actual" class="img-fluid " style="height: auto; width:auto;" />
                                                
                                                </div>
                                                <!-- Imagen mostrada -->
                                                <div class="text-center mb-3" id="preview-container" style="display: none;">
                                                    <img id="ImagenVerPreview" src="" alt="Nueva imagen del avatar" class="img-fluid" style="height: 30%; width:30%;" />
                                                
                                                </div>
                                                <button type="submit" class="btn btn-primary">Actualizar Foto</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    input.type = (input.type === 'password') ? 'text' : 'password';
}

// Función para cargar datos del usuario
function cargarDatosUsuario() {
    const id = "<?php echo $iduser; ?>";

    fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Usuarios?id_usuario=eq.${id}`, {
        method: 'GET',
        headers: {
            "apikey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
            "Authorization": "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
            "Content-Type": "application/json"
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data && data.length > 0) {
            const nombreCompleto = data[0].Nombres +" "+data[0].Apellidos;
            document.getElementById('nombre_completo').innerText = nombreCompleto;
            document.getElementById('correo').innerText = data[0].Email;
            document.getElementById('current-password').value = data[0].Password;
            if (data[0].Avatar) {
                document.getElementById('imagen-perfil').src = data[0].Avatar;
                document.getElementById('avatar-actual').src = data[0].Avatar;
            } else {
                document.getElementById('imagen-perfil').src = "https://coral-app-6fvkz.ondigitalocean.app/assets/img/avatar.png";
                document.getElementById('avatar-actual').src =  "https://coral-app-6fvkz.ondigitalocean.app/assets/img/avatar.png";
            }
        } else {
            console.error('No se encontraron datos del usuario');
        }
    })
    .catch(error => console.error('Error al cargar datos del usuario:', error));
}

// Función para manejar el envío del formulario de cambio de contraseña
function manejarCambioContrasena(event) {
    event.preventDefault();
    const id = "<?php echo $iduser; ?>";
    const currentPassword = document.getElementById('current-password').value;
    const newPassword = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (newPassword !== confirmPassword) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Las contraseñas no coinciden',
        });
        return;
    }

    fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Usuarios?id_usuario=eq.${id}`, {
        method: 'PATCH',
        headers: {
            "apikey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
            "Authorization": "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ Password: newPassword })
    })
    .then(response => {
        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Contraseña actualizada con éxito',
            });
            window.location.reload();
        } else {
            throw new Error('Error en la respuesta del servidor');
        }
    })
    .catch(error => {
        console.error('Error al actualizar la contraseña:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema al actualizar la contraseña',
        });
    });
}

// Función para subir imagen a store
async function subirImagen(imagen) {
    const nombreArchivo = `${Date.now()}_${imagen.name}`;
    const formData = new FormData();
    formData.append("file", imagen);
    try {
        const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/storage/v1/object/imagenes/${nombreArchivo}`, {
            method: 'POST',
            headers: {
                "apikey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
                "Authorization": "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
            },
            body: formData
        });

        if (!response.ok) {
            throw new Error("Error al subir la imagen");
        }

        return `https://ekyjxzjwhxotpdfzcpfq.supabase.co/storage/v1/object/public/imagenes/${nombreArchivo}`;
    } catch (error) {
        console.error('Error al subir la imagen:', error);
        throw error;
    }
}

// Función para actualizar el avatar
async function actualizarAvatar(urlImagen, userId) {
    try {
        const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Usuarios?id_usuario=eq.${userId}`, {
            method: 'PATCH',
            headers: {
                "apikey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
                "Authorization": "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
                'Content-Type': 'application/json',
                'Prefer': 'return=representation'
            },
            body: JSON.stringify({ Avatar: urlImagen })
        });

        if (!response.ok) {
            throw new Error("Error al actualizar el avatar");
        }
    } catch (error) {
        console.error('Error al actualizar el avatar:', error);
        throw error;
    }
}

// Función para cambiar la imagen del avatar
async function cambiarImagen(event) {
    event.preventDefault();
    const imagenInput = document.getElementById('imagen-input');
    const imagen = imagenInput.files[0];

    const userId = "<?php echo $iduser; ?>";

    if (imagen) {
        try {
            const urlImagen = await subirImagen(imagen);
            await actualizarAvatar(urlImagen, userId);
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Imagen de perfil actualizada con éxito',
            });
            cargarDatosUsuario(); // Recargar datos de usuario para mostrar la nueva imagen
            showLoading();
            window.location.reload();
        } catch (error) {
            console.error('Error al cambiar la imagen:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al actualizar la imagen de perfil',
            });
        }
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor selecciona una imagen',
        });
    }
}

// Función para mostrar la vista previa de la imagen seleccionada
function mostrarVistaPrevia(event) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const imgPreview = document.getElementById('ImagenVerPreview');
        imgPreview.src = e.target.result;
        document.getElementById('preview-container').style.display = 'block';
        document.getElementById('avatar-actual').style.display = 'none';
       
    }
    reader.readAsDataURL(event.target.files[0]);
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
// Inicializar eventos después de cargar el DOM
document.addEventListener('DOMContentLoaded', function() {
    cargarDatosUsuario();
    document.getElementById('change-password-form').addEventListener('submit', manejarCambioContrasena);
    document.getElementById('upload-avatar-form').addEventListener('submit', cambiarImagen);
    document.getElementById('imagen-input').addEventListener('change', mostrarVistaPrevia);
});
</script>

<?php include 'componentes/settings.php'; ?>
<?php include 'componentes/footer.php'; ?>
