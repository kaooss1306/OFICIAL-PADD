<?php
//session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);


// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}
$nombre_usuario = $_SESSION["user"]["Nombres"] ?? "Usuario";
$avatar_usuario = $_SESSION["user"]["Avatar"] ?? "Usuario";
$iduser = $_SESSION["user"]["id_usuario"] ?? "Usuario";
$idPerfil = $_SESSION["user"]["id_perfil"] ?? "Usuario";

$ruta = "https://probable-spork-95rwg54xr9737r4g-3000.app.github.dev/";



include 'funciones.php';

?>

<script>
async function obtenerUsuario() {
    const id = "<?php echo $iduser; ?>";  // Cargar el id del usuario desde PHP
    const url = `https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Usuarios?id_usuario=eq.${id}`;
    
    const headers = {
        "apikey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
        "Authorization": "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
        "Content-Type": "application/json"
    };

    const usuarios = await fetch(url, { headers })
        .then(response => response.json())
        .catch(error => {
            console.error('Error:', error);
            return [];
        });

    let url_imagen_p = usuarios.length > 0 ? usuarios[0].Avatar : null;
    const avatar_defecto = $ruta + "assets/img/default-avatar.png";  // Ruta al avatar por defecto

    // Asignar el avatar o el avatar por defecto si no está disponible
    const avatar_completo = url_imagen_p ? url_imagen_p : avatar_defecto;

    // Actualizar la imagen en el campo <img> en el DOM
    document.getElementById('avatarImagen').src = avatar_completo;

    return avatar_completo;
}

// Ejemplo de uso
obtenerUsuario().then(avatar => {
    console.log('Avatar completo:', avatar);
});

</script>
 
<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>PADD - Origen Medios</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/css/misestilos.css">
  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/css/app.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/css/formulario.css">
  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/bundles/bootstrap/css/bootstrap.min.css">


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/fontawesome.min.css">

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/css/components.css">
  <!-- Custom style CSS -->



  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/css/custom.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/bundles/datatables/datatables.min.css">
  <link rel="stylesheet" href="<?php echo $ruta; ?>assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel='shortcut icon' type='image/x-icon' href='https://www.origenmedios.cl/wp-content/uploads/2023/09/favicon-32.png' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline me-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-bs-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
            <li>
              <div class="crmtitulo">PADD DE ADMINISTRACIÓN</div>
            </li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right duo">
   Bienvenid@ - <?php echo htmlspecialchars($nombre_usuario); ?>
          <li class="dropdown"><a href="#" data-bs-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img id="avatarImagen" src="<?php echo $ruta; ?>assets/img/default-avatar.png" alt="Avatar" /></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">

              <a href="<?php echo $ruta; ?>perfil.php" class="dropdown-item has-icon"> <i class="fa-solid fa-user-tag"></i> Mi Perfíl
              </a><a href="" class="dropdown-item has-icon"> <i class="fas fa-copy"></i>
                Publicar Mensajes
              </a>
              <a href="" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Muro de Mensajes
              </a>
              <div class="dropdown-divider"></div>
              <a href="logout.php" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Salir de Padd
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <script src="<?php echo $ruta; ?>assets/js/app.min.js" defer></script>
    <script>
        window.addEventListener('load', function() {
            document.documentElement.className = 'fouc';
            document.getElementById('app').style.display = 'block';
        });
    </script>
