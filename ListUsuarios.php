<?php
// Iniciar la sesión
session_start();

include 'querys/qusuarios.php';
include 'componentes/header.php';
include 'componentes/sidebar.php';


?>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard">Home</a></li>
                            <li class="breadcrumb-item">Listado de Usuarios</li>
                        </ol>
                    </nav>
                    <div class="card">
                        <div class="card-header milinea">
                            <div class="titulox">
                                <h4>Listado de usuarios</h4>
                            </div>
                            <div class="agregar"><a class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalAgregarUsuario"><i class="fas fa-plus-circle"></i> Agregar usuarios</a></div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-center" id="tableExportadora">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombres </th>
                                            <th>Apellidos</th>
                                            <th>Email</th>
                                            <th>Perfil</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($usuario as $usuarios): ?>
                                            <tr>
                                                <td><?php echo $usuarios['id_usuario']; ?></td>
                                                <td><?php echo $usuarios['Nombres']; ?></td>
                                                <td><?php echo $usuarios['Apellidos']; ?></td>
                                                <td><?php echo $usuarios['Email']; ?></td>
                                                <td><?php echo $perfilesMap[$usuarios['id_perfil']]['NombrePerfil'] ?? ''; ?></td>

                                                <td>
                                                    <div class="alineado">
                                                        <label class="custom-switch sino" data-toggle="tooltip"
                                                            title="<?php echo $usuarios['Estado'] ? 'Desactivar Usuario' : 'Activar Usuario'; ?>">
                                                            <input type="checkbox"
                                                                class="custom-switch-input estado-switch-usuario"
                                                                data-id="<?php echo $usuarios['id_usuario']; ?>" data-tipo="usuario" <?php echo $usuarios['Estado'] ? 'checked' : ''; ?>>
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                <a class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#modalActualizarUsuario"
                                                        onclick="cargarUsuario(<?php echo $usuarios['id_usuario']; ?>);">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
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

<script>
 // Validación en tiempo real para Email


async function cargarUsuario(id) {

// Hacemos una solicitud al backend para obtener los datos del usuario por su ID
const response =  await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Usuarios?id_usuario=eq.${id}&select=*`, {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
        'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
        'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
        'Prefer': 'return=minimal'
    }
});

if (!response.ok) {
    throw new Error(`Error al obtener el usuario: ${response.status}`);
}

// Parsear los datos de la respuesta a formato JSON
const usuario = await response.json();

// Verificar si se ha recibido algún usuario
if (usuario.length === 0) {
    console.error('No se encontró el usuario');
    return;
}

console.log(usuario);

if (usuario.length > 0) {

    // Llenar los campos del formulario con los datos del usuario
    document.getElementById('UsuarioID').value = usuario[0].id_usuario;
    document.getElementById('NombresUpdate').value = usuario[0].Nombres;
    document.getElementById('ApellidosUpdate').value = usuario[0].Apellidos;
    document.getElementById('EmailUpdate').value = usuario[0].Email;
    document.getElementById('EstadoUpdate').value = usuario[0].Estado ? 'true' : 'false';
    document.getElementById('PerfilUpdate').value = usuario[0].id_perfil;
    document.getElementById('PasswordUpdate').value = usuario[0].Password;

    // Limpiar o restablecer la vista previa del avatar antes de cargar un nuevo avatar
    const avatarPreview = document.getElementById('avatarPreview');
    const noImageMessage = document.getElementById('noImageMessage'); // Elemento para el mensaje de "No hay imagen disponible"
    
    if (avatarPreview && noImageMessage) {
        avatarPreview.src = '';  // Limpiar la imagen anterior
        avatarPreview.style.display = 'none';  // Ocultar la imagen

        // Si hay avatar, mostrar la imagen; si no, mostrar el mensaje
        if (usuario[0].Avatar) {
            avatarPreview.src = usuario[0].Avatar;  // Establecer la URL de la imagen
            avatarPreview.style.display = 'block';  // Asegurarse de que la imagen sea visible
            noImageMessage.style.display = 'none';  // Ocultar el mensaje de "No hay imagen disponible"
            console.log('Avatar URL:', usuario[0].Avatar);  // Mostrar la URL en la consola
        } else {
            noImageMessage.style.display = 'block';  // Mostrar el mensaje de "No hay imagen disponible"
        }
    } else {
        console.error('El elemento avatarPreview o noImageMessage no se encontró en el DOM.');
    }
}
}

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="assets/js/toggleUsuarios.js"></script>
<?php include 'views/modalUpdateUsuarios.php' ?>
<?php include 'views/modalAgregarUsuarios.php' ?>
<?php include 'componentes/settings.php'; ?>
<?php include 'componentes/footer.php'; ?>