<?php
$title = '404';
/*
$pagenotfound = 'class="active"';
$dropdown = 'active';
*/

require_once('header.php');
?>

    <section id="error" class="container text-center">
        <h1>Error 404, Página no encontrada!</h1>
        <p>La página que estas buscando no se pudo encontrar.</p>
        <a class="btn btn-primary" href="index.php">Regresar a la página de Inicio</a>
    </section><!--/#error-->
    
<?php
require_once('footer.php');
?>