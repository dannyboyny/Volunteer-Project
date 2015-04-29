<?php
$title = 'Mis Eventos';
$miseventos = 'class="active"';

require_once('header.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    or die('Error al intentar conexion con el servidor MySQL!');
?>

    <section id="error" class="container text-center">
        <h1>Página de Mis Eventos</h1>
        <p>Esta es la página de mis eventos.</p>
        <a class="btn btn-primary" href="creareventos.php">Crear Evento</a>
        
<?php            
        
    // Lista de Mis Eventos.    
    $query2 = "SELECT ev.*, org.nombre_organizacion FROM Evento ev, Organizacion org "
            . "WHERE ev.id_organizacion = org.id_organizacion AND org.id_organizacion = $_SESSION[id_organizacion]";    
    $result2 = mysqli_query($dbc, $query2)
    or die('Error al hacer query2 en la base de datos!');

    echo "<table border='1' class='container text-center'>
    <tr>
        <th>Nombre Evento</th>
        <th>Organizacion</th>
        <th>Nombre Lugar</th>
        <th>Editar Evento</th>
    </tr>";
    while ($row = mysqli_fetch_array($result2)) {
    echo "<tr>";
        $id_evento = $row['id_evento'];
        $nombre_evento = $row['nombre_evento'];
        echo "<td>" . $row['nombre_evento'] . "</td>";
        $nombre_organizacion = $row['nombre_organizacion'];
        echo "<td>" . $row['nombre_organizacion'] . "</td>";
        $nombre_lugar = $row['nombre_lugar'];
        echo "<td>" . $row['nombre_lugar'] . "</td>";
        echo "<td>";
        ?>
        <form id="formularioevento" name="editarevento" method="get" action="editareventos.php">
            <input  type="hidden" name="id_evento" value="<?php echo $row['id_evento']?>"/>
            <input type="image" src="images/edit.png" name='editar' alt="ver" width="36" height="36">
        </form>
         <?php             
        echo "</td>";

    echo "</tr>";
    }
    echo "</table>";

    
?>       
        
    </section><!--/#error-->
    
<?php
mysqli_close($dbc);
require_once('footer.php');
