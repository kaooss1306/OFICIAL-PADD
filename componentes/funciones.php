<?php
function verificarAcceso() {
    // Lista de páginas restringidas
    $paginasRestringidas = [
        'ListClientes.php',
        'ListProductos.php',
        'ListMedios.php',
        'ListAgencia.php',
        'ListProveedores.php',
        'ListSoportes.php',
        'ListUsuarios.php'  // Añadimos ListUsuarios.php a las páginas restringidas
    ];

    // Verificar si el usuario está logueado
    if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) {
        header("Location: /index.php");
        exit();
    }

    $idPerfil = $_SESSION["user"]["id_perfil"] ?? null;
    
    if ($idPerfil === null || $idPerfil === "Usuario") {
        header("Location: /index.php");
        exit();
    }

    // Verificar si la página actual está en la lista de restringidas
    $paginaActual = basename($_SERVER['PHP_SELF']);
    if (in_array($paginaActual, $paginasRestringidas)) {
        // Si el perfil no es 1 o 2, redirigir a dashboard.php
        if ($idPerfil != 1 && $idPerfil != 2) {
            header("Location: /dashboard.php");
            exit();
        }
    }

    // Retornar un array con booleanos para indicar qué menús mostrar
    return [
        'mostrarMenuComercial' => ($idPerfil == 1 || $idPerfil == 2),
        'mostrarMenuUsuarios' => ($idPerfil == 1 || $idPerfil == 2)
    ];
}

// Uso de la función
$permisos = verificarAcceso();
$mostrarMenuComercial = $permisos['mostrarMenuComercial'];
$mostrarMenuUsuarios = $permisos['mostrarMenuUsuarios'];

?>