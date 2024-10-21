<div class="modal fade bd-example-modal-lg" id="modalActualizarUsuario" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actualizarUsuario">Actualizar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Alerta para mostrar el resultado de la actualización -->
                <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>

                <form id="formularioActualizarUsuario">
                    <div class="row">
                        <!-- Campo oculto para el ID del usuario -->
                        <input type="hidden" id="UsuarioID" name="UsuarioID">

                        <!-- Nombres -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Nombres">Nombres</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="NombresUpdate" name="NombresUpdate" placeholder="NombresUpdate" required>
                            </div>
                        </div>

                        <!-- Apellidos -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Apellidos">Apellidos</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                <input type="text" class="form-control" id="ApellidosUpdate" name="ApellidosUpdate" placeholder="ApellidosUpdate" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Email">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="EmailUpdate" name="EmailUpdate" placeholder="Email" required>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Password">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                <input type="password" class="form-control" id="PasswordUpdate" name="PasswordUpdate" placeholder="Password">
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Estado">Estado</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-toggle-on"></i></span>
                                <select class="form-control" id="EstadoUpdate" name="EstadoUpdate" required>
                                    <option value="true">Activo</option>
                                    <option value="false">Inactivo</option>
                                </select>
                            </div>
                        </div>

                  
                      
                        <!-- perfil -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Perfil">Perfil</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-people"></i></span>
                                <select class="form-control" id="PerfilUpdate" name="PerfilUpdate" required>
                                    <?php foreach ($perfilesMap as $id => $perfil) : ?>
                                        <option value="<?php echo $id; ?>"><?php echo $perfil['NombrePerfil']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="actualizarUsuario" onclick="actualizarUsuario(event)">
                    Actualizar Usuario
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>


    async function actualizarUsuario(event) {
        event.preventDefault();

        const form = document.getElementById('formularioActualizarUsuario');
        const formData = new FormData(form);

        const usuarioID = formData.get('UsuarioID');

        // Crear el objeto usuario para actualizar
        const usuario = {
            Nombres: formData.get('NombresUpdate'),
            Apellidos: formData.get('ApellidosUpdate'),
            Email: formData.get('EmailUpdate'),
            Password: formData.get('PasswordUpdate'),
            Estado: formData.get('EstadoUpdate') === 'true',
            id_perfil: formData.get('PerfilUpdate') || null
        };

        try {
            const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Usuarios?id_usuario=eq.${usuarioID}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                    'Authorization': `Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc`,
                    'Prefer': 'return=minimal'
                },
                body: JSON.stringify(usuario)
            });

            if (response.ok) {
                console.log('Usuario actualizado con éxito');
                window.location.reload(); // Recargar la página después de la actualización
            } else {
                const error = await response.json();
                console.error('Error al actualizar el usuario:', error);
            }
        } catch (error) {
            console.error('Error en la solicitud:', error);
        }
    }
</script>
