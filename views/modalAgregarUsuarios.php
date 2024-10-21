<div class="modal fade bd-example-modal-lg" id="modalAgregarUsuario" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarUsuario">Agregar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Alerta para mostrar el resultado de la actualización -->
                <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>

                <form id="formularioAgregarUsuario">
                    <div class="row">
                        <!-- Nombres -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Nombres">Nombres</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="Nombres" name="Nombres" placeholder="Nombres" required>
                            </div>
                        </div>

                        <!-- Apellidos -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Apellidos">Apellidos</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                <input type="text" class="form-control" id="Apellidos" name="Apellidos" placeholder="Apellidos" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Email">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control email-input" id="Email" name="Email" placeholder="Email" required>
                                <div class="custom-tooltip" id="Email-tooltip"></div>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Password">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                <input type="password" class="form-control" id="Password" name="Password" placeholder="Password" required>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Estado">Estado</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-toggle-on"></i></span>
                                <select class="form-control" id="Estado" name="Estado" required>
                                    <option value="true" selected>Activo</option>
                                    <option value="false">Inactivo</option>
                                </select>
                            </div>
                        </div>


                        <!-- id_perfil -->

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Perfil">Perfil</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-people"></i></span>
                                <select class="form-control" id="Perfil" name="Perfil" placeholder="Perfil" placeholder="Perfil" required>>
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
                <button type="submit" class="btn btn-primary" id="agregarUsuario" onclick="guardarUsuario(event)">
                    Guardar Usuario
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                </button>
            </div>
        </div>
    </div>
</div>




<script>


document.addEventListener('DOMContentLoaded', function() { 
    function showError(input, message) {
        input.classList.add('is-invalid');
        var tooltip = document.getElementById(input.id + '-tooltip');
        tooltip.textContent = message;
        tooltip.style.opacity = '1';
        positionTooltip(input, tooltip);
    }

    function hideError(input) {
        input.classList.remove('is-invalid');
        var tooltip = document.getElementById(input.id + '-tooltip');
        tooltip.style.opacity = '0';
    }
    function positionTooltip(input, tooltip) {
        var rect = input.getBoundingClientRect();
        tooltip.style.left = '10px';
        tooltip.style.top = -(tooltip.offsetHeight + 5) + 'px';
    }
    var emailInputs = document.querySelectorAll('.email-input');
var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

emailInputs.forEach(function(emailInput) {
    emailInput.addEventListener('input', function() {
        if (this.value === "") {
            hideError(this);
        } else if (!emailPattern.test(this.value)) {
            showError(this, "EMAIL INCORRECTO");
        } else {
            hideError(this);
        }
    });
});
});


   async function guardarUsuario(event) {
    event.preventDefault();

    // Crear un objeto FormData para capturar los valores del formulario
    const form = document.getElementById('formularioAgregarUsuario');
    const formData = new FormData(form);

    const usuario = {
        Nombres: formData.get('Nombres'),
        Apellidos: formData.get('Apellidos'),
        Email: formData.get('Email'),
        Password: formData.get('Password'),
        Estado: formData.get('Estado') === 'true', // Convertir el valor de estado a booleano
        id_perfil: formData.get('Perfil') || null // Si el perfil es nulo, asignar null
    };

    try {
        // Realizar el POST a la URL de Supabase para guardar los datos del usuario
        const response = await fetch('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Usuarios', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Authorization': `Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc`,
                'Prefer': 'return=minimal'
            },
            body: JSON.stringify(usuario)
        });

        if (response.ok) {
            await mostrarExito('Usuario guardado con éxitoe');
            showLoading();
            window.location.reload();
   
        } else {
            const error = await response.json();
            console.error('Error al guardar el usuario:', error);
        }
    } catch (error) {
        console.error('Error en la solicitud:', error);
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
