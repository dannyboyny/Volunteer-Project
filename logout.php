<?php
session_start();
if (isset($_SESSION['id_usuario'])) {
    // Asignarle al arreglo $_SESSION un arreglo vacio para eliminar las variables de la sesión.
    $_SESSION = array();

    // Borrar el cookie de la sesión asignandole el tiempo de expiración una hora(3600seg) en el pasado.
    if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time() - 3600);
    }

    // Borrar la sesión.
    session_destroy();
}

// Borrar los cookies del id_usuario, email y tipo_usuario asignandole el tiempo de expiración una hora(3600seg) en el pasado.
setcookie('id_usuario', '', time() - 3600);
setcookie('email', '', time() - 3600);
setcookie('id_tipo_usuario', '', time() - 3600);


//Redireccionar a la página de inicio.
$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
header('Location: ' . $home_url);
//header('Location:http://proyectovoluntariado.azurewebsites.net/index.php ' );